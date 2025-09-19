<?php
//require_once '../../data/config/config.php';

require_once '../require.php';
//$fp = fopen("/home/sv11/www/html/smaregi/log.txt","w+");

define("SHOP_MODE","guji");
define("STOCK_PATH","/var/www/vhosts/"."www.bronline.jp"."/html/crossmall/guji/upload/csv/");
define("STOCK_FILE","stock.csv");

print_r($_SERVER);

$fp = fopen(STOCK_PATH.STOCK_FILE, 'r');
// 失敗した場合はエラー表示
if (!$fp) {
    return;
}

$arrCSV = array();
$line_count = 0;
$all_line_checked = false;

while (!feof($fp)) {
    $arrCSV = fgetcsv($fp, CSV_LINE_MAX);
//SC_Utils::sfPrintR($arrCSV);
    // 全行入力チェック後に、ファイルポインターを先頭に戻す
    if (feof($fp) && !$all_line_checked) {
        rewind($fp);
        $line_count = 0;
        $all_line_checked = true;
        break;
    }

    // 行カウント
    $line_count++;
    // ヘッダ行はスキップ
    if ($line_count == 1) {
        continue;
    }
    // 空行はスキップ
    if (empty($arrCSV)) {
        continue;
    }

    $arrVal = array();
    $arrVal['product_code'] = $arrCSV[0];
    $arrVal['stock'] = $arrCSV[1];
    
	updateStock($arrVal);
}
fclose($fp);

rename(STOCK_PATH.STOCK_FILE, STOCK_PATH.date("YmdHis")."_stock.csv");



function sendMail($to, $subject, $body, $from=TO_ADDR1)
{
	mb_language("japanese");
	mb_internal_encoding("utf-8");
	mb_send_mail($to, $subject, $body, "From:".$from.PHP_EOL);
}

function updateStock($arrVal)
{
   	$objQuery =& SC_Query_Ex::getSingletonInstance();
   	$id = $arrVal['product_code'];
   	unset($arrVal['product_code']);
	$objQuery->query("set search_path to ".SHOP_MODE.",public;");
   	$objQuery->update("dtb_products_class", $arrVal, "product_code=?",array($id));

	SC_Helper_DB_Ex::checkSubStock2($id,SHOP_MODE);
}

function outLog($name,$data,&$send_data)
{
//	print_r($data);
	$send_data .= date("Ymd H:i:s")."   ".$name.":".$data.PHP_EOL;
	
	$fp = fopen(SMA_DIR."stock".date("Ymd").".txt","a+");
	fwrite($fp,date("Ymd H:i:s"));
	fwrite($fp,"   ".$name.":".$data.PHP_EOL);
	fclose($fp);
}
?>
