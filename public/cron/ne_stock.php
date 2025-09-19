<?php
	require_once '../require.php';

	define("SHOP_MODE","newsugawara");
	define("STOCK_FILE","/../ne_api_sdk_php/log/stock_just".date('Ymd').".log");
	$path1 = dirname(__FILE__);
	
	$fp = fopen($path1.STOCK_FILE, 'a+');
	// 失敗した場合はエラー表示
	if (!$fp) {
	    return;
	}

    $objQuery =& SC_Query_Ex::getSingletonInstance();
	$col = "product_class_id,product_code,stock";
	$from = "dtb_products join dtb_products_class on dtb_products.product_id = dtb_products_class.product_id";
	$where = "dtb_products.del_flg = 0";

	$objQuery->query("set search_path to ".SHOP_MODE.",public;");
	$arrRet = $objQuery->select($col,$from,$where);
//SC_Utils::sfPrintR($arrRet);
//exit;
	if (count($arrRet) > 0)
	{
//		$arrStockResult = array();
		$url = HTTP_URL."ne_api_sdk_php/api_brnext.php?product_code=1";
		$res = file_get_contents($url);
		if ($res != 'null')
		{
			$arrResult = json_decode($res,true);
		}
		else
		{
			outLog($fp,"NE","RESULT FAIL.");
			return;
		}

		foreach($arrRet as $ret)
		{
//			SC_Utils::sfPrintR($url.$ret['product_code']);
//			outLog($fp, $res, $url.$ret['product_code']);
//print_r($res);

			$f = false;
			foreach($arrResult as $ne)
			{
				if ($ret['product_code'] == $ne['stock_goods_id'])
				{
					$sqlval['stock'] = $ne['stock_free_quantity'];
					$sqlval['update_date'] = 'now()';
					$where = "product_class_id = ?";
	
					$objQuery->query("set search_path to ".SHOP_MODE.",public;");
					$objQuery->update('dtb_products_class',$sqlval,$where,array($ret['product_class_id']));
//						$arrStockResult[] = $ret['product_code'];
					SC_Helper_DB_Ex::checkSubStock2($ret['product_code'], $shop_mode);
	
					outLog($fp,'[NE]'.$ret['product_code'],$sqlval['stock']);
					outLog($fp,'[CUBE]'.$ret['product_code'],$ret['stock']);
					$f = true;
				}
				if ($f) break;
			}
		}
	}
//		$this->arrStockResult = $arrStockResult;

	fclose($fp);


function outLog($fp, $name, $data)
{
	print($name.":".$data."<br>");
	fwrite($fp,date("Ymd H:i:s")."   ".$name.":".$data.PHP_EOL);
}
?>