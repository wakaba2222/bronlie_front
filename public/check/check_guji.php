<?php
//require_once '../../data/config/config.php';

require_once '../require.php';
//$fp = fopen("/home/sv11/www/html/smaregi/log.txt","w+");

define("SHOP_MODE","guji");
define("STOCK_PATH","./");
define("STOCK_FILE","stock_guji.csv");

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
    $arrVal['group_code'] = $arrCSV[0];
    $arrVal['product_code'] = $arrCSV[1];
    $arrVal['stock'] = $arrCSV[3];
    
	checkStock($arrVal);
}
fclose($fp);

print("<br>Stock Check Complete.<br>");
exit;


function checkStock($arrVal)
{
   	$objQuery =& SC_Query_Ex::getSingletonInstance();

	$col = "group_code,product_code,stock";
	$from = "dtb_products join dtb_products_class on dtb_products.product_id = dtb_products_class.product_id";
	$where = "group_code = ? and dtb_products.del_flg = 0";

	$objQuery->query("set search_path to ".SHOP_MODE.",public;");
	$arrRet = $objQuery->select($col,$from,$where,array($arrVal['group_code']));
	
	if (count($arrRet) > 0)
	{
		$f = false;
		foreach($arrRet as $ret)
		{
			if ($ret['product_code'] == $arrVal['product_code'])
			{
				if ($ret['stock'] != $arrVal['stock'])
				{
					outLog($arrVal['group_code']);
					outLog($arrVal['product_code']."<->".$ret['product_code']);
					outLog($arrVal['stock']."<->".$ret['stock']);
					outLog(PHP_EOL."Stock Mismatch.".PHP_EOL);
				}
				$f = true;
			}
		}
		if (!$f)
		{
//			outLog($arrVal['group_code']);
//			outLog($arrVal['product_code']."<->".$ret['product_code']);
//			outLog(PHP_EOL."Mismatch.".PHP_EOL);
		}
	}
	else
	{
//		outLog($arrVal['group_code']." products none.");
	}
}

function outLog($data)
{
//	print_r($data);
	$fp = fopen(STOCK_PATH.SHOP_MODE."stock".date("Ymd").".log","a+");
	fwrite($fp,$data.PHP_EOL);
	fclose($fp);
}
?>