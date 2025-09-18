<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Customize\Controller\Admin\Order;

use Eccube\Common\Constant;
use Eccube\Controller\AbstractController;
use Eccube\Entity\ExportCsvRow;
use Eccube\Entity\Master\CsvType;
use Eccube\Entity\Master\OrderStatus;
use Eccube\Entity\OrderPdf;
use Eccube\Entity\Shipping;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Eccube\Form\Type\Admin\OrderPdfType;
use Customize\Form\Type\Admin\SearchOrderType;
use Eccube\Repository\CustomerRepository;
use Eccube\Repository\Master\OrderStatusRepository;
use Eccube\Repository\Master\PageMaxRepository;
use Eccube\Repository\Master\ProductStatusRepository;
use Eccube\Repository\Master\SexRepository;
use Eccube\Repository\OrderPdfRepository;
use Eccube\Repository\ShippingRepository;
use Customize\Repository\OrderRepository;
use Eccube\Repository\PaymentRepository;
use Eccube\Repository\ProductStockRepository;
use Customize\Service\CsvExportService;
use Eccube\Service\MailService;
use Customize\Service\OrderPdfService;
use Eccube\Service\OrderStateMachine;
use Eccube\Service\PurchaseFlow\PurchaseFlow;
use Eccube\Util\FormUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderController extends AbstractController
{
    /**
     * @var PurchaseFlow
     */
    protected $purchaseFlow;

    /**
     * @var CsvExportService
     */
    protected $csvExportService;

    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    /**
     * @var PaymentRepository
     */
    protected $paymentRepository;

    /**
     * @var SexRepository
     */
    protected $sexRepository;

    /**
     * @var OrderStatusRepository
     */
    protected $orderStatusRepository;

    /**
     * @var PageMaxRepository
     */
    protected $pageMaxRepository;

    /**
     * @var ProductStatusRepository
     */
    protected $productStatusRepository;

    /**
     * @var OrderRepository
     */
    protected $orderRepository;

    /** @var OrderPdfRepository */
    protected $orderPdfRepository;

    /**
     * @var ProductStockRepository
     */
    protected $productStockRepository;

    /** @var OrderPdfService */
    protected $orderPdfService;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var OrderStateMachine
     */
    protected $orderStateMachine;
    protected $shippingRepository;

    /**
     * @var MailService
     */
    protected $mailService;

    /**
     * OrderController constructor.
     *
     * @param PurchaseFlow $orderPurchaseFlow
     * @param CsvExportService $csvExportService
     * @param CustomerRepository $customerRepository
     * @param PaymentRepository $paymentRepository
     * @param SexRepository $sexRepository
     * @param OrderStatusRepository $orderStatusRepository
     * @param PageMaxRepository $pageMaxRepository
     * @param ProductStatusRepository $productStatusRepository
     * @param ProductStockRepository $productStockRepository
     * @param OrderRepository $orderRepository
     * @param OrderPdfRepository $orderPdfRepository
     * @param ValidatorInterface $validator
     * @param OrderStateMachine $orderStateMachine ;
     */
    public function __construct(
        PurchaseFlow $orderPurchaseFlow,
        CsvExportService $csvExportService,
        CustomerRepository $customerRepository,
        PaymentRepository $paymentRepository,
        SexRepository $sexRepository,
        OrderStatusRepository $orderStatusRepository,
        PageMaxRepository $pageMaxRepository,
        ProductStatusRepository $productStatusRepository,
        ProductStockRepository $productStockRepository,
        OrderRepository $orderRepository,
        OrderPdfRepository $orderPdfRepository,
        ValidatorInterface $validator,
        OrderStateMachine $orderStateMachine,
        MailService $mailService,
        ShippingRepository $shippingRepository,
    ) {
        $this->purchaseFlow = $orderPurchaseFlow;
        $this->csvExportService = $csvExportService;
        $this->customerRepository = $customerRepository;
        $this->paymentRepository = $paymentRepository;
        $this->sexRepository = $sexRepository;
        $this->orderStatusRepository = $orderStatusRepository;
        $this->pageMaxRepository = $pageMaxRepository;
        $this->productStatusRepository = $productStatusRepository;
        $this->productStockRepository = $productStockRepository;
        $this->orderRepository = $orderRepository;
        $this->orderPdfRepository = $orderPdfRepository;
        $this->validator = $validator;
        $this->orderStateMachine = $orderStateMachine;
        $this->mailService = $mailService;
        $this->shippingRepository = $shippingRepository;
    }

    /**
     * 受注一覧画面.
     *
     * - 検索条件, ページ番号, 表示件数はセッションに保持されます.
     * - クエリパラメータでresume=1が指定された場合、検索条件, ページ番号, 表示件数をセッションから復旧します.
     * - 各データの, セッションに保持するアクションは以下の通りです.
     *   - 検索ボタン押下時
     *      - 検索条件をセッションに保存します
     *      - ページ番号は1で初期化し、セッションに保存します。
     *   - 表示件数変更時
     *      - クエリパラメータpage_countをセッションに保存します。
     *      - ただし, mtb_page_maxと一致しない場合, eccube_default_page_countが保存されます.
     *   - ページング時
     *      - URLパラメータpage_noをセッションに保存します.
     *   - 初期表示
     *      - 検索条件は空配列, ページ番号は1で初期化し, セッションに保存します.
     *
     * @Route("/%eccube_admin_route%/order", name="admin_order", methods={"GET", "POST"})
     * @Route("/%eccube_admin_route%/order/page/{page_no}", requirements={"page_no" = "\d+"}, name="admin_order_page", methods={"GET", "POST"})
     * @Template("@admin/Order/index.twig")
     */
    public function index(Request $request, PaginatorInterface $paginator, $page_no = null)
    {
        $builder = $this->formFactory
            ->createBuilder(SearchOrderType::class);

        $event = new EventArgs(
            [
                'builder' => $builder,
            ],
            $request
        );
        $this->eventDispatcher->dispatch($event, EccubeEvents::ADMIN_ORDER_INDEX_INITIALIZE);

        $searchForm = $builder->getForm();

        /**
         * ページの表示件数は, 以下の順に優先される.
         * - リクエストパラメータ
         * - セッション
         * - デフォルト値
         * また, セッションに保存する際は mtb_page_maxと照合し, 一致した場合のみ保存する.
         **/
        $page_count = $this->session->get('eccube.admin.order.search.page_count',
            $this->eccubeConfig->get('eccube_default_page_count'));

        $page_count_param = (int) $request->get('page_count');
        $pageMaxis = $this->pageMaxRepository->findAll();

        if ($page_count_param) {
            foreach ($pageMaxis as $pageMax) {
                if ($page_count_param == $pageMax->getName()) {
                    $page_count = $pageMax->getName();
                    $this->session->set('eccube.admin.order.search.page_count', $page_count);
                    break;
                }
            }
        }

        if ('POST' === $request->getMethod()) {
            $searchForm->handleRequest($request);

            if ($searchForm->isValid()) {
                /**
                 * 検索が実行された場合は, セッションに検索条件を保存する.
                 * ページ番号は最初のページ番号に初期化する.
                 */
                $page_no = 1;
                $searchData = $searchForm->getData();

                // 検索条件, ページ番号をセッションに保持.
                $this->session->set('eccube.admin.order.search', FormUtil::getViewData($searchForm));
                $this->session->set('eccube.admin.order.search.page_no', $page_no);
            } else {
                // 検索エラーの際は, 詳細検索枠を開いてエラー表示する.
                return [
                    'searchForm' => $searchForm->createView(),
                    'pagination' => [],
                    'pageMaxis' => $pageMaxis,
                    'page_no' => $page_no,
                    'page_count' => $page_count,
                    'has_errors' => true,
                ];
            }
        } else {
            if (null !== $page_no || $request->get('resume')) {
                /*
                 * ページ送りの場合または、他画面から戻ってきた場合は, セッションから検索条件を復旧する.
                 */
                if ($page_no) {
                    // ページ送りで遷移した場合.
                    $this->session->set('eccube.admin.order.search.page_no', (int) $page_no);
                } else {
                    // 他画面から遷移した場合.
                    $page_no = $this->session->get('eccube.admin.order.search.page_no', 1);
                }
                $viewData = $this->session->get('eccube.admin.order.search', []);
                $searchData = FormUtil::submitAndGetData($searchForm, $viewData);
            } else {
                /**
                 * 初期表示の場合.
                 */
                $page_no = 1;
                $viewData = [];

                if ($statusId = (int) $request->get('order_status_id')) {
                    $viewData = ['status' => [$statusId]];
                }

                $searchData = FormUtil::submitAndGetData($searchForm, $viewData);

                // セッション中の検索条件, ページ番号を初期化.
                $this->session->set('eccube.admin.order.search', $viewData);
                $this->session->set('eccube.admin.order.search.page_no', $page_no);
            }
        }
        $qb = $this->orderRepository->getQueryBuilderBySearchDataForAdmin($searchData);

        $event = new EventArgs(
            [
                'qb' => $qb,
                'searchData' => $searchData,
            ],
            $request
        );

        $this->eventDispatcher->dispatch($event, EccubeEvents::ADMIN_ORDER_INDEX_SEARCH);
        $sortKey = $searchData['sortkey'];

        if (empty($this->orderRepository::COLUMNS[$sortKey]) || $sortKey == 'order_status') {
            $pagination = $paginator->paginate(
                $qb,
                $page_no,
                $page_count
            );
        } else {
            $pagination = $paginator->paginate(
                $qb,
                $page_no,
                $page_count,
                ['wrap-queries' => true]
            );
        }

		$ship_info = array();
		$ship_info2 = array();
		foreach($pagination as $o)
		{
			$order_addr = $o->getName01().$o->getName02().$o->getAddr01().$o->getAddr02();
			
			if ($o->getShippings() != null)
			{
				foreach($o->getShippings() as $s)
				{
					$shipping_addr = $s->getName01().$s->getName02().$s->getAddr01().$s->getAddr02();
					if ($order_addr != $shipping_addr)
					{
						$ship_info[] = $o->getId();
						$ship_info2[$s->getId()] = $o->getId();
					}
				}
			}
		}

//dump(implode(',', $ship_info));
//exit;
        return [
            'searchForm' => $searchForm->createView(),
            'pagination' => $pagination,
            'pageMaxis' => $pageMaxis,
            'page_no' => $page_no,
            'page_count' => $page_count,
            'has_errors' => false,
            'OrderStatuses' => $this->orderStatusRepository->findBy([], ['sort_no' => 'ASC']),
            'ship_info' => implode(',', $ship_info),
            'ship_info2' => $ship_info2,
        ];
    }

    /**
     * @Route("/%eccube_admin_route%/order/bulk_delete", name="admin_order_bulk_delete", methods={"POST"})
     */
    public function bulkDelete(Request $request)
    {
        $this->isTokenValid();
        $ids = $request->get('ids');
        foreach ($ids as $order_id) {
            $Order = $this->orderRepository
                ->find($order_id);
            if ($Order) {
                $this->entityManager->remove($Order);
                log_info('受注削除', [$Order->getId()]);
            }
        }

        $this->entityManager->flush();

        $this->addSuccess('admin.common.delete_complete', 'admin');

        return $this->redirect($this->generateUrl('admin_order', ['resume' => Constant::ENABLED]));
    }

    /**
     * 受注CSVの出力.
     *
     * @Route("/%eccube_admin_route%/order/export/order", name="admin_order_export_order", methods={"GET"})
     *
     * @param Request $request
     *
     * @return StreamedResponse
     */
    public function exportOrder(Request $request)
    {
        $filename = 'order_'.(new \DateTime())->format('YmdHis').'.csv';
        $response = $this->exportCsv($request, CsvType::CSV_TYPE_ORDER, $filename);
        log_info('受注CSV出力ファイル名', [$filename]);

        return $response;
    }

    /**
     * 配送CSVの出力.
     *
     * @Route("/%eccube_admin_route%/order/export/shipping", name="admin_order_export_shipping", methods={"GET"})
     *
     * @param Request $request
     *
     * @return StreamedResponse
     */
    public function exportShipping(Request $request)
    {
        $filename = 'shipping_'.(new \DateTime())->format('YmdHis').'.csv';
        $response = $this->exportCsv($request, CsvType::CSV_TYPE_SHIPPING, $filename);
        log_info('配送CSV出力ファイル名', [$filename]);

        return $response;
    }

    /**
     * SimplexCSVの出力.
     *
     * @Route("/%eccube_admin_route%/order/export/simplex", name="admin_order_export_simplex", methods={"GET","POST"})
     *
     * @param Request $request
     *
     * @return StreamedResponse
     */
    public function exportSimplex(Request $request)
    {
        $filename = 'simplex_'.(new \DateTime())->format('YmdHis').'.csv';
        $response = $this->exportCsv($request, 7, $filename);
        log_info('SimplexCSV出力ファイル名', [$filename]);

        return $response;
    }
    /**
     * SimplexCSVの出力.
     *
     * @Route("/%eccube_admin_route%/order/export/simplex2", name="admin_order_export_simplex2", methods={"GET","POST"})
     *
     * @param Request $request
     *
     * @return StreamedResponse
     */
    public function exportSimplex2(Request $request)
    {
        $filename = 'simplex(宝暦)_'.(new \DateTime())->format('YmdHis').'.csv';
        $response = $this->exportCsv($request, 8, $filename);
        log_info('SimplexCSV(宝暦)出力ファイル名', [$filename]);

        return $response;
    }

    /**
     * @param Request $request
     * @param $csvTypeId
     * @param string $fileName
     *
     * @return StreamedResponse
     */
    protected function exportCsv(Request $request, $csvTypeId, $fileName)
    {
        // タイムアウトを無効にする.
        set_time_limit(0);

        // sql loggerを無効にする.
        $em = $this->entityManager;
        $em->getConfiguration()->setSQLLogger(null);
        
//        $qb = $this->csvExportService
//            ->getOrderQueryBuilder2($request, $csvTypeId);

//        $qb = $this->orderRepository->getQueryBuilderBySearchDataForAdmin2();
//        createQueryBuilder('o')
//            ->select('o, s')
//            ->addSelect('oi', 'pref')
//            ->innerJoin('o.OrderItems', 'oi')
//            ->leftJoin('o.Pref', 'pref')
//            ->innerJoin('o.Shippings', 's');

//		foreach($qb->getQuery()->getResult() as $Order)
//		{
//			dump($Order->getOrderItems());
//		}       
//dump($qb->getDql());
//exit;

//dump($request->get('ids', ''));
//exit;
			if ($request->get('ids', '') != '')
			{
				if ($request->get('ids', '')[0] != '')
				{
					$shipping_id = explode(',', $request->get('ids')[0]);
					$order_ids = array();
					
					foreach($shipping_id as $id)
					{
						$Shipping = $this->shippingRepository->find($id);
						$order_ids[] = $Shipping->getOrder()->getId();
					}
				}
			}
//dump($order_ids);
//exit;

        $response = new StreamedResponse();
        $response->setCallback(function () use ($request, $csvTypeId) {
            // CSV種別を元に初期化.
            $this->csvExportService->initCsvType($csvTypeId);

			$order_ids = array();
			if ($request->get('ids', '') != '')
			{
				if ($request->get('ids', '')[0] != '')
				{
					$shipping_id = explode(',', $request->get('ids')[0]);
					
					foreach($shipping_id as $id)
					{
						$Shipping = $this->shippingRepository->find($id);
						$order_ids[] = $Shipping->getOrder()->getId();
					}
				}
			}
//dump($order_ids);
//exit;
            // 受注データ検索用のクエリビルダを取得.
            $qb = $this->csvExportService
                ->getOrderQueryBuilder2($request, $csvTypeId, $order_ids);

            // ヘッダ行の出力.
            $this->csvExportService->exportHeader();

            // データ行の出力.
            $this->csvExportService->setExportQueryBuilder($qb);
            $this->csvExportService->exportData(function ($entity, $csvService) use ($request) {
                $Csvs = $csvService->getCsvs();

                $Order = $entity;
                $OrderItems = $Order->getOrderItems();

				$bunrui1 = '1';	//分類コード
				$uchiwake1 = '10';	//内訳コード
				$bunrui5 = '';	//分類コード
				$uchiwake5 = '';	//内訳コード
				$kubun = '1';	//区分
				$haisou = 'ヤマト運輸';
				$binshu = '宅配便';
				$sale_type = '1';
				$quantity = 0;
              	$target_name1 = $Order->getName01().$Order->getName02();
              	$target_addr1 = $Order->getAddr01().$Order->getAddr02();
              	$jiin_code = $Order->getCustomer()->getJiinCode();
//dump($Order->getCustomer());
//exit;
				$target_name2 = '';
				$target_kana2 = '';
				$target_addr2 = '';
				$target_pref2 = '';
				$target_tel2 = '';
				$target_ship_date2 = '';
				$ship_date2 = '';
				$ship_zip2 = '';
				$target_time2 = '';
                foreach ($OrderItems as $OrderItem)
                {
                	if ($OrderItem->getShipping() != null)
                	{
                		$Shipping = $OrderItem->getShipping();
	                   	$target_name2 = $Shipping->getName01().'　'.$Shipping->getName02();

						$jiin = '';
						if ($Order->getCustomer())
						{
							if ($Order->getCustomer()->getCustomerType() == 3)
							{
								$jiin = substr_replace($Order->getCustomer()->getJiinCode(), '**', 2, 2);
								$jiin .= ":";
							}
						}
	                   	$target_kana2 = $jiin.mb_convert_kana($Shipping->getKana01().' '.$Shipping->getKana02(), 'k');

	                   	$target_addr2 = $Shipping->getAddr01().$Shipping->getAddr02();
	                   	$target_pref2 = $Shipping->getPref()->getName();
	                   	$target_tel2 = $Shipping->getPhoneNumber();
	                   	$target_ship_date2 = $Shipping->getShippingDate2();
	                   	$ship_zip2 = $Shipping->getZipCode();
	                   	if ($Shipping->getShippingDeliveryDate() != null)
		                   	$ship_date2 = $Shipping->getShippingDeliveryDate()->format('Y/m/d');

                       	if ($Shipping->getShippingDeliveryTime() == '午前')
                       	{
                       		$target_time2 = '1';
                       	}
                       	else if ($Shipping->getShippingDeliveryTime() == '14〜16時')
                       	{
                       		$target_time2 = '2';
                       	}
                       	else if ($Shipping->getShippingDeliveryTime() == '16〜18時')
                       	{
                       		$target_time2 = '3';
                       	}
                       	else if ($Shipping->getShippingDeliveryTime() == '18〜20時')
                       	{
                       		$target_time2 = '4';
                       	}
                       	else if ($Shipping->getShippingDeliveryTime() == '19〜21時')
                       	{
                       		$target_time2 = '5';
                       	}
                	}
                }
//dump($target_name1);
//dump($target_name2);
//dump($target_addr1);
//dump($target_addr2);
//exit;
                $otodoke_code = '';
                if ($target_name1 != $target_name2 && $target_addr1 != $target_addr2)
                {
                	$otodoke_code = 'OD'.$Shipping->getId();
                }
                else
                {
                	$otodoke_code = $Order->getCustomer()->getId();
                }

                $neko_flg = false;
                foreach ($OrderItems as $OrderItem)
                {
                	if ($OrderItem->isProduct())
                	{
                	    if ($OrderItem->getProduct()->getNekoFlg())
                	    {
                	       $neko_flg = true;
                	    }
	                   	if ($OrderItem->getProductClass() != null && $OrderItem->getProductClass()->getSaleType()->getId() == 3)
	                   	{
							$uchiwake1 = '30';
	                   		$sale_type = '3';
	                   	}
	                   	else if ($OrderItem->getProductClass() != null && $OrderItem->getProductClass()->getSaleType()->getId() == 2)
	                   	{
	                   		$sale_type = '2';
	                   		$quantity += $OrderItem->getQuantity();
	                   		if ($quantity <= 20)
		                   		$haisou = 'その他';
	                   	}
	                   	else if ($OrderItem->getProductClass() != null && $OrderItem->getProductClass()->getSaleType()->getId() == 4)
	                   	{
	                   		$haisou = 'その他';
							$uchiwake5 = '10';
	                   		$sale_type = '4';
	                   	}
	                   	else if ($OrderItem->getProductClass() != null && $OrderItem->getProductClass()->getSaleType()->getId() == 5)
	                   	{
	                   		$sale_type = '5';
							$uchiwake1 = '30';
							$uchiwake5 = '20';
	                   	}
	                   	else if ($OrderItem->getProductClass() != null && $OrderItem->getProductClass()->getSaleType()->getId() == 7)
	                   	{
	                   		$sale_type = '7';
							$uchiwake1 = '30';
							if ($OrderItem->getQuantity() > 10)
							{
								$uchiwake1 = '31';
							}
							$uchiwake5 = '20';
	                   	}
	                   	else if ($OrderItem->getProductClass() != null && $OrderItem->getProductClass()->getSaleType()->getId() == 8)
	                   	{
	                   		$sale_type = '8';
							$uchiwake1 = '40';
							if ($OrderItem->getQuantity() > 25)
							{
								$uchiwake1 = '41';
							}
							$uchiwake5 = '21';
	                   	}
	                   	
	                   	if ($OrderItem->getProductClass() != null && ($OrderItem->getProductClass()->getSaleType()->getId() == 4 || $OrderItem->getProductClass()->getSaleType()->getId() == 5))
	                   	{
	                   		$bunrui5 = '2';
	                   		$bunrui1 = '2';
	                   	}
	                   	else if ($OrderItem->getProductClass() != null && $OrderItem->getProductClass()->getSaleType()->getId() > 5)
	                   	{
	                   		$bunrui1 = '2';
	                   		$bunrui5 = '1';
	                   	}
	
	                   	if ($OrderItem->getProductClass() != null && $OrderItem->getProductClass()->getSaleType()->getId() > 3)
	                   	{
							$kubun = '2';
	                   	}
                	}
                }

$seikyu = array();
$otodoke_date = '';//お届け予定日
foreach ($OrderItems as $OrderItem)
{
	if ($OrderItem->isProduct())
	{
		if ($OrderItem->getProduct()->getDueDate() != null)
		{
			$otodoke_date = $OrderItem->getProduct()->getDueDate()->format('Y/m/d');
		}
		if ($OrderItem->getProductClass()->getSaleType()->getId() < 4)
			$seikyu[$OrderItem->getOrder()->getId()] = 1;
		else
			$seikyu[$OrderItem->getOrder()->getId()] = 2;
	}

}

$fee = false;
if ($Order->getPaymentMethod() == '代金引換')
	$fee = true;


                foreach ($OrderItems as $OrderItem) {
                	if (count($seikyu) == 0)
                		continue;
                    $ExportCsvRow = new ExportCsvRow();
                    
                    if (!$fee)
                    {
                    	if ($OrderItem->isCharge())
                    		continue;
                    }
                   	if ($OrderItem->isDeliveryFee())
                   	{
                   		if ($OrderItem->getPrice() == 0)
	                  		continue;
                   	}


                    // CSV出力項目と合致するデータを取得.
                    foreach ($Csvs as $Csv) {
                        // 受注データを検索.
                        $ExportCsvRow->setData($csvService->getData($Csv, $Order));
                        if ($ExportCsvRow->isDataNull()) {
                            // 受注データにない場合は, 受注明細を検索.
                            $ExportCsvRow->setData($csvService->getData($Csv, $OrderItem));
                        }
                        if ($ExportCsvRow->isDataNull() && $Shipping = $OrderItem->getShipping()) {
                            // 受注明細データにない場合は, 出荷を検索.
                            $ExportCsvRow->setData($csvService->getData($Csv, $Shipping));
                        }
                        if ($Csv->getDispName() == '支払方法')
                        {
log_info('CHANGE DATA');
							if ($csvService->getData($Csv, $Order) == '代金引換' || $csvService->getData($Csv, $Order) == 'クレジットカード決済' || $csvService->getData($Csv, $Order) == '登録済みのクレジットカードで決済')
							{
							}
							else
							{
								$ExportCsvRow->setData('収納代行');
							}
log_info('CHANGE DATA');
                        }
                        else if ($Csv->getDispName() == '請求先住所No')
                        {
                        	if (isset($seikyu[$OrderItem->getOrder()->getId()]))
	                        	$ExportCsvRow->setData($seikyu[$OrderItem->getOrder()->getId()]);
//                        	if ($OrderItem->isProduct())
//                        	{
//	                        	if ($OrderItem->getProductClass()->getSaleType()->getId() < 4)
//	                        	{
//									$ExportCsvRow->setData(intVal(1));
//	                        	}
//	                        	else
//	                        	{
//									$ExportCsvRow->setData(intVal(2));
//	                        	}
//                        	}
                        	
                        }
                        else if ($Csv->getDispName() == '受注情報メモ')
                        {
							$ExportCsvRow->setData($jiin_code);
                        }
                        else if ($Csv->getDispName() == '前入金チェックフラグ')
                        {
                        	if ($Order->getPaymentMethod() == 'クレジットカード決済' || $Order->getPaymentMethod() == '登録済みのクレジットカードで決済')
								$ExportCsvRow->setData(0);
							else
								$ExportCsvRow->setData(0);
                        }
                        else if ($Csv->getDispName() == '時間帯指定')
                        {
							$ExportCsvRow->setData($target_time2);
//                        	if ($Shipping != null)
//                        	{
//	                        	if ($Shipping->getShippingDeliveryTime() == '午前')
//	                        	{
//									$ExportCsvRow->setData(1);
//	                        	}
//	                        	else if ($Shipping->getShippingDeliveryTime() == '14〜16時')
//	                        	{
//									$ExportCsvRow->setData(2);
//	                        	}
//	                        	else if ($Shipping->getShippingDeliveryTime() == '16〜18時')
//	                        	{
//									$ExportCsvRow->setData(3);
//	                        	}
//	                        	else if ($Shipping->getShippingDeliveryTime() == '18〜20時')
//	                        	{
//									$ExportCsvRow->setData(4);
//	                        	}
//	                        	else if ($Shipping->getShippingDeliveryTime() == '19〜21時')
//	                        	{
//									$ExportCsvRow->setData(5);
//	                        	}
//                        	}
                        }
                        else if ($Csv->getDispName() == 'お届け先郵便番号')
                        {
							$ExportCsvRow->setData($ship_zip2);
                        }
                        else if ($Csv->getDispName() == '出荷予定日')
                        {
                        	if ($otodoke_date != '')
                        	{
								$ExportCsvRow->setData($otodoke_date);
                        	}
                        	else
								$ExportCsvRow->setData($target_ship_date2);
                        }
                        else if ($Csv->getDispName() == 'お届け先TEL')
                        {
							$ExportCsvRow->setData($target_tel2);
                        }
                        else if ($Csv->getDispName() == 'お届け先 都道府県')
                        {
							$ExportCsvRow->setData($target_pref2);
                        }
                        else if ($Csv->getDispName() == '配送先_お名前(姓)')
                        {
							$ExportCsvRow->setData($target_name2);
                        }
                        else if ($Csv->getDispName() == '配送先_お名前(セイ)')
                        {
							$ExportCsvRow->setData($target_kana2);
                        }
                        else if ($Csv->getDispName() == 'お届け先 市区町村')
                        {
                        	if ($Shipping != null)
                        	{
	                        	$addr = $Shipping->getAddr01().$Shipping->getAddr02();
	                        	
								$ExportCsvRow->setData(mb_substr($addr, 0, 10));
                        	}
                        	else
                        	{
								$ExportCsvRow->setData(mb_substr($target_addr2, 0, 10));
                        	}
                        }
                        else if ($Csv->getDispName() == 'お届け先 その他')
                        {
                        	if ($Shipping != null)
                        	{
	                        	$addr = $Shipping->getAddr01().$Shipping->getAddr02();
	                        	
								$ExportCsvRow->setData(mb_substr($addr, 10, 20));
                        	}
                        	else
                        	{
								$ExportCsvRow->setData(mb_substr($target_addr2, 10, 20));
                        	}
                        }
                        else if ($Csv->getDispName() == 'お届け先 ビル等')
                        {
                        	if ($Shipping != null)
                        	{
	                        	$addr = $Shipping->getAddr01().$Shipping->getAddr02();
	                        	
								$ExportCsvRow->setData(mb_substr($addr, 30, 20));
                        	}
                        	else
                        	{
								$ExportCsvRow->setData(mb_substr($target_addr2, 30, 20));
                        	}
                        }
                        else if ($Csv->getDispName() == '請求先 市区町村')
                        {
                        	$addr = $Order->getAddr01().$Order->getAddr02();
                        	
							$ExportCsvRow->setData(mb_substr($addr, 0, 10));
                        }
                        else if ($Csv->getDispName() == '請求先 その他')
                        {
                        	$addr = $Order->getAddr01().$Order->getAddr02();
                        	
							$ExportCsvRow->setData(mb_substr($addr, 10, 20));
                        }
                        else if ($Csv->getDispName() == '請求先 ビル等')
                        {
                        	$addr = $Order->getAddr01().$Order->getAddr02();
                        	
							$ExportCsvRow->setData(mb_substr($addr, 30, 20));
                        }
                        else if ($Csv->getDispName() == '消費税等合計額')
                        {
							$ExportCsvRow->setData(intVal($Order->getTax()));
                        }
                        else if ($Csv->getDispName() == '分類コード1')
                        {
                       		$ExportCsvRow->setData($bunrui1);
                        }
                        else if ($Csv->getDispName() == '分類コード5')
                        {
                       		$ExportCsvRow->setData($bunrui5);
                        }
                        else if ($Csv->getDispName() == '内訳コード1')
                        {
                       		$ExportCsvRow->setData($uchiwake1);
                        }
                        else if ($Csv->getDispName() == '内訳コード5')
                        {
                       		$ExportCsvRow->setData($uchiwake5);
                        }
                        else if ($Csv->getDispName() == 'お届け先コード')
                        {	
                       		$ExportCsvRow->setData($otodoke_code);
                        }
                        else if ($Csv->getDispName() == 'お届け先住所No')
                        {	
                       		$ExportCsvRow->setData($kubun);
                        }
                        else if ($Csv->getDispName() == 'お届け予定日')
                        {
                        	if ($otodoke_date != '')
                        	{
	                       		$ExportCsvRow->setData($otodoke_date);
                        	}
                        	else
                        	{
	                        	if ($Shipping != null && $Shipping->getShippingDeliveryDate() != '')
		                       		$ExportCsvRow->setData($Shipping->getShippingDeliveryDate()->format('Y/m/d'));
		                       	else
		                       		$ExportCsvRow->setData($ship_date2);
                        	}
                        }
                        else if ($Csv->getDispName() == '配送会社')
                        {	
                       		$ExportCsvRow->setData($haisou);
                        }
                        else if ($Csv->getDispName() == '商品コード')
                        {
                        	if ($OrderItem->getProductName() == '送料' && $sale_type == '1')
                        	{
                        		if ($Order->getSubTotal() < 910)
		                       		$ExportCsvRow->setData('0401020100');
//		                       		$ExportCsvRow->setData('0401020200');
		                       	else if ($Order->getSubTotal() < 9100)
		                       		$ExportCsvRow->setData('0401010000');
		                       	else if ($Order->getSubTotal() < 27273)
		                       		$ExportCsvRow->setData('0401020000');
		                       	else if ($Order->getSubTotal() < 90910)
		                       		$ExportCsvRow->setData('0401030000');
		                       	else if ($Order->getSubTotal() < 263637)
		                       		$ExportCsvRow->setData('0401040000');
		                       	else
		                       		$ExportCsvRow->setData('0401050000');
                        	}
                        	else if ($OrderItem->getProductName() == '送料' && $sale_type == '2')
                        	{
                        		if ($quantity == 1)
		                       		$ExportCsvRow->setData('0401010200');
		                       	else if ($quantity < 11)
		                       		$ExportCsvRow->setData('0401070200');
		                       	else if ($quantity < 21)
		                       		$ExportCsvRow->setData('0401080200');
		                       	else if ($quantity < 51)
		                       		$ExportCsvRow->setData('0401090200');
		                       	else if ($quantity < 231)
		                       		$ExportCsvRow->setData('0401120200');
		                       	else if ($quantity < 301)
		                       		$ExportCsvRow->setData('0401130200');
		                       	else if ($quantity < 461)
		                       		$ExportCsvRow->setData('0401140200');
		                       	else if ($quantity < 601)
		                       		$ExportCsvRow->setData('0401150200');
		                       	else if ($quantity < 901)
		                       		$ExportCsvRow->setData('0401160200');
		                       	else if ($quantity < 1201)
		                       		$ExportCsvRow->setData('0401170200');
		                       	else if ($quantity < 1501)
		                       		$ExportCsvRow->setData('0401180200');
		                       	else if ($quantity < 1801)
		                       		$ExportCsvRow->setData('0401190200');
		                       	else if ($quantity < 2101)
		                       		$ExportCsvRow->setData('0401200200');
		                       	else
		                       		$ExportCsvRow->setData('0401200200');
                        	}
                        	else if ($OrderItem->getProductName() == '送料' && $sale_type == '7')
                        	{
                        		if ($Order->getSubTotal() < 112)
		                       		$ExportCsvRow->setData('TG-90000100');
		                       	else if ($Order->getSubTotal() < 1111)
		                       		$ExportCsvRow->setData('TG-90000110');
		                       	else if ($Order->getSubTotal() < 9091)
		                       		$ExportCsvRow->setData('TG-90000400');
		                       	else if ($Order->getSubTotal() < 27273)
		                       		$ExportCsvRow->setData('TG-90000410');
		                       	else if ($Order->getSubTotal() < 90909)
		                       		$ExportCsvRow->setData('TG-90000420');
		                       	else if ($Order->getSubTotal() < 263637)
		                       		$ExportCsvRow->setData('TG-90000430');
		                       	else
		                       		$ExportCsvRow->setData('TG-90000440');
                        	}
                        	else if ($OrderItem->getProductName() == '送料' && $sale_type == '8')
                        	{
                        		if ($Order->getTotal() < 41)
		                       		$ExportCsvRow->setData('TG-90000100');
		                       	else if ($Order->getSubTotal() < 1001)
		                       		$ExportCsvRow->setData('TG-90000110');
		                       	else if ($Order->getSubTotal() < 9081)
		                       		$ExportCsvRow->setData('TG-90000400');
		                       	else if ($Order->getSubTotal() < 27241)
		                       		$ExportCsvRow->setData('TG-90000410');
		                       	else if ($Order->getSubTotal() < 909881)
		                       		$ExportCsvRow->setData('TG-90000420');
		                       	else if ($Order->getSubTotal() < 272721)
		                       		$ExportCsvRow->setData('TG-90000430');
		                       	else
		                       		$ExportCsvRow->setData('TG-90000440');
                        	}
                        	else if ($OrderItem->getProductName() == '手数料' && ($sale_type == '1' || $sale_type == '3') && $Order->getPaymentMethod() == '代金引換')
                        	{
                        		if ($Order->getSubTotal() < 9091)
		                       		$ExportCsvRow->setData('0402010300');
		                       	else if ($Order->getSubTotal() < 27273)
		                       		$ExportCsvRow->setData('0402020300');
		                       	else if ($Order->getSubTotal() < 90909)
		                       		$ExportCsvRow->setData('0402030300');
		                       	else
		                       		$ExportCsvRow->setData('0402040300');
                        	}
                        	else if ($OrderItem->getProductName() == '手数料' && $sale_type == '7' && $Order->getPaymentMethod() == '代金引換')
                        	{
                        		if ($Order->getSubTotal() < 1111)
		                       		$ExportCsvRow->setData('');
		                       	else if ($Order->getSubTotal() < 9091)
		                       		$ExportCsvRow->setData('TG-90000900');
		                       	else if ($Order->getSubTotal() < 27273)
		                       		$ExportCsvRow->setData('TG-90000910');
		                       	else if ($Order->getSubTotal() < 90909)
		                       		$ExportCsvRow->setData('TG-90000920');
		                       	else if ($Order->getSubTotal() < 263637)
		                       		$ExportCsvRow->setData('TG-90000930');
                        	}
                        	else if ($OrderItem->getProductName() == '手数料' && $sale_type == '8' && $Order->getPaymentMethod() == '代金引換')
                        	{
                        		if ($Order->getTotal() < 1001)
		                       		$ExportCsvRow->setData('');
		                       	else if ($Order->getSubTotal() < 9081)
		                       		$ExportCsvRow->setData('TG-90000900');
		                       	else if ($Order->getSubTotal() < 27241)
		                       		$ExportCsvRow->setData('TG-90000910');
		                       	else if ($Order->getSubTotal() < 90881)
		                       		$ExportCsvRow->setData('TG-90000920');
		                       	else if ($Order->getSubTotal() < 272721)
		                       		$ExportCsvRow->setData('TG-90000930');
                        	}
                        	else if ($OrderItem->getProductName() == '手数料' && $sale_type == '2' && $Order->getPaymentMethod() == '代金引換')
                        	{
		                       		$ExportCsvRow->setData('0402010300');
                        	}
                        }
                        else if ($Csv->getDispName() == '商品名')
                        {
                        	/*
                        	if ($OrderItem->getProductName() == '送料' && $sale_type == '1')
                        	{
                        		if ($Order->getTotal() < 910)
		                       		$ExportCsvRow->setData('デイリーネコポス送料');
		                       	else if ($Order->getTotal() < 9100)
		                       		$ExportCsvRow->setData('送料A');
		                       	else if ($Order->getTotal() < 27273)
		                       		$ExportCsvRow->setData('送料B');
		                       	else if ($Order->getTotal() < 90910)
		                       		$ExportCsvRow->setData('送料C');
		                       	else if ($Order->getTotal() < 263637)
		                       		$ExportCsvRow->setData('送料D');
		                       	else
		                       		$ExportCsvRow->setData('送料E');
                        	}
                        	else if ($OrderItem->getProductName() == '送料' && $sale_type == '7')
                        	{
                        		if ($Order->getTotal() < 112)
		                       		$ExportCsvRow->setData('定期ネコポス送料A');
		                       	else if ($Order->getTotal() < 1111)
		                       		$ExportCsvRow->setData('定期ネコポス送料B');
		                       	else if ($Order->getTotal() < 9091)
		                       		$ExportCsvRow->setData('送料A');
		                       	else if ($Order->getTotal() < 27273)
		                       		$ExportCsvRow->setData('送料B');
		                       	else if ($Order->getTotal() < 90909)
		                       		$ExportCsvRow->setData('送料C');
		                       	else if ($Order->getTotal() < 263637)
		                       		$ExportCsvRow->setData('送料D');
		                       	else
		                       		$ExportCsvRow->setData('送料E');
                        	}
                        	else if ($OrderItem->getProductName() == '送料' && $sale_type == '8')
                        	{
                        		if ($Order->getTotal() < 41)
		                       		$ExportCsvRow->setData('定期ネコポス送料A');
		                       	else if ($Order->getTotal() < 1001)
		                       		$ExportCsvRow->setData('定期ネコポス送料B');
		                       	else if ($Order->getTotal() < 9081)
		                       		$ExportCsvRow->setData('送料A');
		                       	else if ($Order->getTotal() < 27241)
		                       		$ExportCsvRow->setData('送料B');
		                       	else if ($Order->getTotal() < 909881)
		                       		$ExportCsvRow->setData('送料C');
		                       	else if ($Order->getTotal() < 272721)
		                       		$ExportCsvRow->setData('送料D');
		                       	else
		                       		$ExportCsvRow->setData('送料E');
                        	}
                        }
                        else if ($Csv->getDispName() == '受注単価')
                        {	
                        	if ($OrderItem->getProductName() == '送料' && $sale_type == '1')
                        	{
                        		if ($Order->getTotal() < 910)
		                       		$ExportCsvRow->setData('354');
		                       	else if ($Order->getTotal() < 9100)
		                       		$ExportCsvRow->setData('700');
		                       	else if ($Order->getTotal() < 27273)
		                       		$ExportCsvRow->setData('900');
		                       	else if ($Order->getTotal() < 90910)
		                       		$ExportCsvRow->setData('1100');
		                       	else if ($Order->getTotal() < 263637)
		                       		$ExportCsvRow->setData('1100');
		                       	else
		                       		$ExportCsvRow->setData('1100');
                        	}
                        	else if ($OrderItem->getProductName() == '送料' && $sale_type == '7')
                        	{
                        		if ($Order->getTotal() < 112)
		                       		$ExportCsvRow->setData('300');
		                       	else if ($Order->getTotal() < 1111)
		                       		$ExportCsvRow->setData('354');
		                       	else if ($Order->getTotal() < 9091)
		                       		$ExportCsvRow->setData('700');
		                       	else if ($Order->getTotal() < 27273)
		                       		$ExportCsvRow->setData('900');
		                       	else if ($Order->getTotal() < 90909)
		                       		$ExportCsvRow->setData('1100');
		                       	else if ($Order->getTotal() < 263637)
		                       		$ExportCsvRow->setData('1100');
		                       	else
		                       		$ExportCsvRow->setData('1100');
                        	}
                        	else if ($OrderItem->getProductName() == '送料' && $sale_type == '8')
                        	{
                        		if ($Order->getTotal() < 41)
		                       		$ExportCsvRow->setData('300');
		                       	else if ($Order->getTotal() < 1001)
		                       		$ExportCsvRow->setData('354');
		                       	else if ($Order->getTotal() < 9081)
		                       		$ExportCsvRow->setData('700');
		                       	else if ($Order->getTotal() < 27241)
		                       		$ExportCsvRow->setData('900');
		                       	else if ($Order->getTotal() < 909881)
		                       		$ExportCsvRow->setData('1100');
		                       	else if ($Order->getTotal() < 272721)
		                       		$ExportCsvRow->setData('1100');
		                       	else
		                       		$ExportCsvRow->setData('1100');
                        	}
                        	else
								$ExportCsvRow->setData(intVal($csvService->getData($Csv, $OrderItem)));
							*/
                        }
                        else if ($Csv->getDispName() == '数量')
                        {
							$ExportCsvRow->setData($OrderItem->getQuantity());
                        }
                        else if ($Csv->getDispName() == '備考')
                        {
                        	$msg = str_replace(PHP_EOL, '', $Order->getMessage());
							$ExportCsvRow->setData($msg);
                        }
                        else if ($Csv->getDispName() == '受注単価')
                        {
							$ExportCsvRow->setData(intVal($OrderItem->getPrice()));
                        }
                        else if ($Csv->getDispName() == '便種')
                        {
							if ($OrderItem->getProductClass() != null)
							{
								if ($OrderItem->isProduct())
								{
									if ($OrderItem->getProductClass()->getSaleType()->getId() <= 3)
									{
										if ($OrderItem->getProductClass()->getSaleType()->getId() == 2)
										{
											if ($OrderItem->getQuantity() <= 20)
					                        	$binshu = 'ゆうメール';
					                        else
					                        	$binshu = '宅配便';
										}
										else if ($Order->getSubTotal() < 910 && !$neko_flg)
				                        	$binshu = 'ネコポス便';
				                        else
				                        	$binshu = '宅配便';
									}
									else if ($OrderItem->getProductClass()->getSaleType()->getId() == 4)
									{
			                        	$binshu = 'ゆうメール';
									}
									else if ($OrderItem->getProductClass()->getSaleType()->getId() == 5)
									{
										if ($Order->getPaymentMethod() != '代金引換')
				                        	$binshu = 'ネコポス便';
									}
									else if ($OrderItem->getProductClass()->getSaleType()->getId() == 7)
									{
										if ($OrderItem->getQuantity() <= 10)
				                        	$binshu = 'ネコポス便';
									}
									else if ($OrderItem->getProductClass()->getSaleType()->getId() == 8)
									{
										if ($OrderItem->getQuantity() <= 25)
				                        	$binshu = 'ネコポス便';
									}
								}
							}
                       		$ExportCsvRow->setData($binshu);
                        }
//                        else if ($Csv->getDispName() == '時間帯指定')
//                        {
////                       		$ExportCsvRow->setData($kubun);
//                        }

                        $event = new EventArgs(
                            [
                                'csvService' => $csvService,
                                'Csv' => $Csv,
                                'OrderItem' => $OrderItem,
                                'ExportCsvRow' => $ExportCsvRow,
                            ],
                            $request
                        );
                        $this->eventDispatcher->dispatch($event, EccubeEvents::ADMIN_ORDER_CSV_EXPORT_ORDER);

                        $ExportCsvRow->pushData();
                    }

                    // $row[] = number_format(memory_get_usage(true));
                    // 出力.
                    $csvService->fputcsv($ExportCsvRow->getRow());
                }
            });
        });

        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$fileName);

        return $response;
    }

    /**
     * Update to order status
     *
     * @Route("/%eccube_admin_route%/shipping/{id}/order_status", requirements={"id" = "\d+"}, name="admin_shipping_update_order_status", methods={"PUT"})
     *
     * @param Request $request
     * @param Shipping $Shipping
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateOrderStatus(Request $request, Shipping $Shipping)
    {
        if (!($request->isXmlHttpRequest() && $this->isTokenValid())) {
            return $this->json(['status' => 'NG'], 400);
        }

        $Order = $Shipping->getOrder();
        $OrderStatus = $this->entityManager->find(OrderStatus::class, $request->get('order_status'));

        if (!$OrderStatus) {
            return $this->json(['status' => 'NG'], 400);
        }

        $result = [];
        try {
            if ($Order->getOrderStatus()->getId() == $OrderStatus->getId()) {
                log_info('対応状況一括変更スキップ');
                $result = ['message' => trans('admin.order.skip_change_status', ['%name%' => $Shipping->getId()])];
            } else {
                if ($this->orderStateMachine->can($Order, $OrderStatus)) {
                    if ($OrderStatus->getId() == OrderStatus::DELIVERED) {
                        if (!$Shipping->isShipped()) {
                            $Shipping->setShippingDate(new \DateTime());
                        }
                        $allShipped = true;
                        foreach ($Order->getShippings() as $Ship) {
                            if (!$Ship->isShipped()) {
                                $allShipped = false;
                                break;
                            }
                        }
                        if ($allShipped) {
                            $this->orderStateMachine->apply($Order, $OrderStatus);
                        }
                    } else {
                        $this->orderStateMachine->apply($Order, $OrderStatus);
                    }

                    if ($request->get('notificationMail')) { // for SimpleStatusUpdate
                        $this->mailService->sendShippingNotifyMail($Shipping);
                        $Shipping->setMailSendDate(new \DateTime());
                        $result['mail'] = true;
                    } else {
                        $result['mail'] = false;
                    }
                    // 対応中・キャンセルの更新時は商品在庫を増減させているので商品情報を更新
                    if ($OrderStatus->getId() == OrderStatus::IN_PROGRESS || $OrderStatus->getId() == OrderStatus::CANCEL) {
                        foreach ($Order->getOrderItems() as $OrderItem) {
                            $ProductClass = $OrderItem->getProductClass();
                            if ($OrderItem->isProduct() && !$ProductClass->isStockUnlimited()) {
                                $this->entityManager->persist($ProductClass);
                                $this->entityManager->flush();
                                $ProductStock = $this->productStockRepository->findOneBy(['ProductClass' => $ProductClass]);
                                $this->entityManager->persist($ProductStock);
                                $this->entityManager->flush();
                            }
                        }
                    }
                    $this->entityManager->persist($Order);
                    $this->entityManager->persist($Shipping);
                    $this->entityManager->flush();

                    // 会員の場合、購入回数、購入金額などを更新
                    if ($Customer = $Order->getCustomer()) {
                        $this->orderRepository->updateOrderSummary($Customer);
                        $this->entityManager->persist($Customer);
                        $this->entityManager->flush();
                    }
                } else {
                    $from = $Order->getOrderStatus()->getName();
                    $to = $OrderStatus->getName();
                    $result = ['message' => trans('admin.order.failed_to_change_status', [
                        '%name%' => $Shipping->getId(),
                        '%from%' => $from,
                        '%to%' => $to,
                    ])];
                }

                log_info('対応状況一括変更処理完了', [$Order->getId()]);
            }
        } catch (\Exception $e) {
            log_error('予期しないエラーです', [$e->getMessage()]);

            return $this->json(['status' => 'NG'], 500);
        }

        return $this->json(array_merge(['status' => 'OK'], $result));
    }

    /**
     * Update to Tracking number.
     *
     * @Route("/%eccube_admin_route%/shipping/{id}/tracking_number", requirements={"id" = "\d+"}, name="admin_shipping_update_tracking_number", methods={"PUT"})
     *
     * @param Request $request
     * @param Shipping $shipping
     *
     * @return Response
     */
    public function updateTrackingNumber(Request $request, Shipping $shipping)
    {
        if (!($request->isXmlHttpRequest() && $this->isTokenValid())) {
            return $this->json(['status' => 'NG'], 400);
        }

        $trackingNumber = mb_convert_kana($request->get('tracking_number'), 'a', 'utf-8');
        /** @var \Symfony\Component\Validator\ConstraintViolationListInterface $errors */
        $errors = $this->validator->validate(
            $trackingNumber,
            [
                new Assert\Length(['max' => $this->eccubeConfig['eccube_stext_len']]),
                new Assert\Regex(
                    ['pattern' => '/^[0-9a-zA-Z-]+$/u', 'message' => trans('admin.order.tracking_number_error')]
                ),
            ]
        );

        if ($errors->count() != 0) {
            log_info('送り状番号入力チェックエラー');
            $messages = [];
            /** @var \Symfony\Component\Validator\ConstraintViolationInterface $error */
            foreach ($errors as $error) {
                $messages[] = $error->getMessage();
            }

            return $this->json(['status' => 'NG', 'messages' => $messages], 400);
        }

        try {
            $shipping->setTrackingNumber($trackingNumber);
            $this->entityManager->persist($shipping);
            $this->entityManager->flush();
            log_info('送り状番号変更処理完了', [$shipping->getId()]);
            $message = ['status' => 'OK', 'shipping_id' => $shipping->getId(), 'tracking_number' => $trackingNumber];

            return $this->json($message);
        } catch (\Exception $e) {
            log_error('予期しないエラー', [$e->getMessage()]);

            return $this->json(['status' => 'NG'], 500);
        }
    }

    /**
     * @Route("/%eccube_admin_route%/order/export/pdf", name="admin_order_export_pdf", methods={"GET", "POST"})
     * @Template("@admin/Order/order_pdf.twig")
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function exportPdf(Request $request)
    {
        // requestから出荷番号IDの一覧を取得する.
        $ids = $request->get('ids', []);

        if (count($ids) == 0) {
            $this->addError('admin.order.delivery_note_parameter_error', 'admin');
            log_info('The Order cannot found!');

            return $this->redirectToRoute('admin_order');
        }

        /** @var OrderPdf $OrderPdf */
        $OrderPdf = $this->orderPdfRepository->find($this->getUser());

        if (!$OrderPdf) {
            $OrderPdf = new OrderPdf();
            $OrderPdf
                ->setTitle(trans('admin.order.delivery_note_title__default'));
//                ->setMessage1(trans('admin.order.delivery_note_message__default1'))
//                ->setMessage2(trans('admin.order.delivery_note_message__default2'))
//                ->setMessage3(trans('admin.order.delivery_note_message__default3'));
        }

        /**
         * @var FormBuilder
         */
        $builder = $this->formFactory->createBuilder(OrderPdfType::class, $OrderPdf);

        /* @var \Symfony\Component\Form\Form $form */
        $form = $builder->getForm();

        // Formへの設定
        $form->get('ids')->setData(implode(',', $ids));

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/%eccube_admin_route%/order/export/pdf/download", name="admin_order_pdf_download", methods={"POST"})
     * @Template("@admin/Order/order_pdf.twig")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function exportPdfDownload(Request $request, OrderPdfService $orderPdfService)
    {
        /**
         * @var FormBuilder
         */
        $builder = $this->formFactory->createBuilder(OrderPdfType::class);

        /* @var \Symfony\Component\Form\Form $form */
        $form = $builder->getForm();
        $form->handleRequest($request);

        // Validation
        if (!$form->isValid()) {
            log_info('The parameter is invalid!');

            return $this->render('@admin/Order/order_pdf.twig', [
                'form' => $form->createView(),
            ]);
        }

        $arrData = $form->getData();

        // 購入情報からPDFを作成する
        $status = $orderPdfService->makePdf($arrData);

        // 異常終了した場合の処理
        if (!$status) {
            $this->addError('admin.order.export.pdf.download.failure', 'admin');
            log_info('Unable to create pdf files! Process have problems!');

            return $this->render('@admin/Order/order_pdf.twig', [
                'form' => $form->createView(),
            ]);
        }

        // TCPDF::Outputを実行するとプロパティが初期化されるため、ファイル名を事前に取得しておく
        $pdfFileName = $orderPdfService->getPdfFileName();

        // ダウンロードする
        $response = new Response(
            $orderPdfService->outputPdf(),
            200,
            ['content-type' => 'application/pdf']
        );

        $downloadKind = $form->get('download_kind')->getData();

        // レスポンスヘッダーにContent-Dispositionをセットし、ファイル名を指定
        if ($downloadKind == 1) {
            $response->headers->set('Content-Disposition', 'attachment; filename="'.$pdfFileName.'"');
        } else {
            $response->headers->set('Content-Disposition', 'inline; filename="'.$pdfFileName.'"');
        }

        log_info('OrderPdf download success!', ['Order ID' => implode(',', $request->get('ids', []))]);

        $isDefault = isset($arrData['default']) ? $arrData['default'] : false;
        if ($isDefault) {
            // Save input to DB
            $arrData['admin'] = $this->getUser();
            $this->orderPdfRepository->save($arrData);
        }

        return $response;
    }
}
