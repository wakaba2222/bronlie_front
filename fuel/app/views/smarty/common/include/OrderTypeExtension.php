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

namespace Customize\Form\Extension\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Eccube\Common\EccubeConfig;
use Eccube\Entity\Product;
use Eccube\Form\Type\Admin\OrderType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints as Assert;
use Eccube\Entity\Order;
use Eccube\Entity\Payment;


/**
 * Class OrderTypeExtension.
 */
class OrderTypeExtension extends AbstractTypeExtension
{
    /**
     * @var EccubeConfig
     */
    private $eccubeConfig;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EccubeConfig $eccubeConfig, EntityManagerInterface $entityManager)
    {
        $this->eccubeConfig = $eccubeConfig;
        $this->entityManager = $entityManager;
    }

    /**
     * RelatedCollectionExtension.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Payment', EntityType::class, [
                'required' => false,
                'class' => Payment::class,
                'choice_label' => function (Payment $Payment) {
                	$ext = '円';
                	if ($Payment->getTypeFlg())
                		$ext = '部数';
                    return $Payment->isVisible()
                        ? $Payment->getId().'-'.$Payment->getSaleType().'-'.$Payment->getMethod().' ['.number_format($Payment->getRuleMin()).'〜'.number_format($Payment->getRuleMax()).$ext.']'
                        : $Payment->getMethod().trans('admin.common.hidden_label');
                },
                'placeholder' => false,
                'query_builder' => function ($er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.visible', 'DESC')  // 非表示は下に配置
                        ->addOrderBy('p.sort_no', 'ASC');
                },
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ]);
    }

    /**
     * product admin form name.
     *
     * @return string
     */
    public function getExtendedType()
    {
        return OrderType::class;
    }

    /**
     * product admin form name.
     *
     * @return string[]
     */
    public static function getExtendedTypes(): iterable
    {
        yield OrderType::class;
    }
}
