<?php
/**
 * 決済API定義ファイル
 */
return array
(
    /**
     * GMOペイメント
     */
    // モジュールタイプ、PHPスクリプト配置パス
    'gmo_path_gpay_client' => '/var/www/bronline/fuel/vendor/gpay_client',
    // 決済選択呼び出し
//    'gmo_url_multi_entry' => 'https://p01.mul-pay.jp/link/9101984264355/Multi/Entry',

	//テスト開発
//    'gmo_url_multi_entry' => 'https://stbfep.sps-system.com/Extra/BuyRequestAction.do',
//    'gmo_shop_id' => '19788',
//    'hash_code' => '398a58952baf329cac5efbae97ea84ba17028d02',
//    'service_id' => '001',

	//共通試験
//    'gmo_url_multi_entry' => 'https://stbfep.sps-system.com/f01/FepBuyInfoReceive.do',
//    'gmo_shop_id' => '30132',
//    'hash_code' => '644da9995cac43695d6b3fcbc89787872fbc8b5c',
//    'service_id' => '101',

	//本番
    'gmo_url_multi_entry' => 'https://fep.sps-system.com/f01/FepBuyInfoReceive.do',
    'gmo_shop_id' => '88955',
    'hash_code' => '6be403b7e3b05c03e48f9ebd6499d1240233d625',
    'service_id' => '001',

    // カード編集呼び出し
    'gmo_url_member_edit' => 'https://p01.mul-pay.jp/link/9101984264355/Member/Edit',
    // ショップID
//    'gmo_shop_id' => '9101984264355',
    // ショップパスワード
    'gmo_shop_pwd' => 'wtnx4awm',
    // サイトID
//    'gmo_site_id' => 'tsite00029625',
    'gmo_site_id' => 'mst2000015088',
    // サイトパスワード
    'gmo_site_pwd' => '46m2fss6',
    // リンクタイプ決済方法（即時売上：CAPTURE、仮売上：AUTH）
    'gmo_job_cd' => 'CAPTURE',

    /**
     * AmazonPay
     */
    // ***** SANDBOX *****
    // Amazon MWSエンドポイント
//    'amazon_url_amazon_mws' => 'https://mws.amazonservices.jp/OffAmazonPayments_Sandbox/2013-01-01/',
    // widget.js URL
//    'amazon_url_widget_js' => 'https://static-fe.payments-amazon.com/OffAmazonPayments/jp/sandbox/lpa/js/Widgets.js',
    // Profile API エンドポイント
//    'amazon_url_profile_api' =>'https://api-sandbox.amazon.co.jp/user/profile',
    // ***** 本番環境 *****
    // Amazon MWSエンドポイント
    'amazon_url_amazon_mws' => 'https://mws.amazonservices.jp/OffAmazonPayments/2013-01-01/',
    // widget.js URL
    'amazon_url_widget_js' => 'https://static-fe.payments-amazon.com/OffAmazonPayments/jp/lpa/js/Widgets.js',
    // Profile API エンドポイント
    'amazon_url_profile_api' =>'https://api.amazon.co.jp/user/profile',


    'amazon_merchant_id' => 'A2BOFNYODUOJXW',
    'amazon_access_key' => 'AKIAIROQRUMSPW5L4XSA',
    'amazon_secret_key' => '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',
//    'amazon_client_id' => 'amzn1.application-oa2-client.78aa471445cb4bdbbbfc2589e4a7ebe7',
    'amazon_client_id' => 'amzn1.application-oa2-client.639c8ed425df405d8e8f2473e4b60b75',
    //'client_secret' => '78eb35f226cb8ab53e55e39ad09f5154b632cd4f5a5e1aa1ad7fe130197436e4',本番
    //'client_secret' => '75fb3287b3f541ac47891a19b68a01c5cb9916fa884531ac0c172a505795f9e6',
    'amazon_region' => 'jp',
    'amazon_currency_code' => 'JPY',
    'amazon_sandbox' => false,

	// for v2
    'public_key_id' => 'LIVE-AFX5QO6I6I5GVEPRBGQ7V33M',
    'private_key' => '/var/www/bronline/fuel/app/config/keys/AmazonPay_LIVE-AFX5QO6I6I5GVEPRBGQ7V33M.pem',
);
