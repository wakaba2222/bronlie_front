<?php
define('CACHE_TIME', '90');
define('TRANSACTION_ID_NAME', 'TRANSACTION_ID');
define('TPL_URLPATH', '/admin_common/');
define('CHECK_PRODUCTS', 'CHECK_PRODUCTS');
define('STEXT_LEN','100');
define('MTEXT_LEN','200');
define('LTEXT_LEN','1000');
define('LLTEXT_LEN','9999');
define('PRICE_LEN','10');
define('PERCENTAGE_LEN','3');
define('UPLOAD_IMAGE_PATH','/upload/images/');
define('UPLOAD_LOGOIMAGE_PATH','/common/images/mall/');
define('REAL_UPLOAD_IMAGE_PATH','/var/www/bronline/public/upload/images/');
define('REAL_UPLOAD_LOGOIMAGE_PATH','/var/www/bronline/public/common/images/mall/');
if (intval(date('Ymd') ) >= 20191001)
	define('TAX_RATE', '10');
else
	define('TAX_RATE', '8');
define('GIFT_FEE', 300);
define('HTTP_URL', 'https://www.bronline.jp/');
define('SMAREGI', 1);
define('USE_RAKUTEN', 1);

// パスワードハッシュ作成用
define('AUTH_MAGIC', 'nucrecrimaethoutecheahaethifroutiofrouch');
define('PASSWORD_HASH_ALGOS', 'sha256');

// メール設定：会員仮登録
define('CUSTOMER_TEMP_MAIL_FROM', 'info@bronline.jp');
define('CUSTOMER_TEMP_MAIL_TITLE', 'B.R.ONLINE 仮会員登録のお知らせ');

// メール設定：問い合わせ
define('CONTACT_MAIL_FROM', 'info@bronline.jp');
define('CONTACT_MAIL_TO_ADMIN', 'info@bronline.jp');
define('CONTACT_MAIL_TITLE_INQUIRER', 'B.R.ONLINE お問い合わせ');
define('CONTACT_MAIL_TITLE_ADMIN', 'B.R.ONLINE お問い合わせがありました');

// メール設定：パスワード再設定
define('PASSWORD_RESET_MAIL_FROM', 'info@bronline.jp');
define('PASSWORD_RESET_MAIL_TITLE', 'B.R.ONLINE パスワード再設定のお知らせ');

define('ORDER_MAIL_FROM', 'onlineshop@bronline.jp');
define('ORDER_MAIL_TO_ADMIN', 'onlineshop@bronline.jp');
define('ORDER_MAIL_TITLE_ADMIN', 'ご注文ありがとうございます');
define('ORDER_MAIL_TEMPLATE_ID', 1);

define('DOMAIN', 'www.bronline.jp');

define('CONTRACT_ID', 'skg804r6');
define('ACCESS_TOKEN', 'c22e2bd637a2c7bff062922e34c87082');
define('SMAREGI_URL', 'https://webapi.smaregi.jp/access/');

// PAYMENT画面
define('PAYMENT_BACK_URL', 'https://www.bronline.jp/cart');

// CONFIRM画面：GMOリンクタイプ
//define('GMO_RESPONSE_URL', 'https://www.bronline.jp/cart/complete');
//define('GMO_CANCEL_URL', 'https://www.bronline.jp/cart/confirm');
//define('GMO_COMPLETE_URL', 'https://www.bronline.jp/cart/complete');

define('GMO_RESPONSE_URL', 'https://www.bronline.jp/cart/response');
define('GMO_CANCEL_URL', 'https://www.bronline.jp/cart/cancel');
define('GMO_COMPLETE_URL', 'https://www.bronline.jp/cart/complete');
define('GMO_ERROR_URL', 'https://www.bronline.jp/cart/error');

// CONFIRM画面：AmazonPay
define('AMA_AMAZONPAY_URL', 'https://www.bronline.jp/cart/amazon');

// AMAZONPAY画面
define('AMAZONPAY_SIGNIN_CANCEL_URL', 'https://www.bronline.jp/cart/payment');

// ポイントログのステータス
define('POINT_LOG_ISSUE', '1');		// 仮発行
define('POINT_LOG_ENABLE', '2');	// 有効昇華
define('POINT_LOG_USE', '3');		// 利用
define('POINT_LOG_ADD', '4');		// 加算（管理画面から）
define('POINT_LOG_SUB', '5');		// 減算（管理画面から）
define('POINT_LOG_CANCEL', '6');	// キャンセル（仮発行時のみ減算）
define('POINT_LOG_LOST', '7');		// 失効（購入から1年365日）
define('POINT_LOG_TEMP_LOST', '8');	// 仮発行
define('POINT_LOG_ISSUE_SHOP', '9');	// 仮発行(SHOP用)

// スライダーがこれ以下の場合、繰り返さない
define('CAROUSEL_NO_LOOP', 4);

// meta情報
define('META_SITE_NAME', 'B.R.ONLINE - Style Web Magazine & Online Shop | ビー・アール・オンライン');
define('META_DESCRIPTION_LENGTH', 100);
