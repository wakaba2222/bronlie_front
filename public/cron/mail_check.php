<?php
//require_once '../../data/config/config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../require.php';
require_once CLASS_EX_REALDIR . 'page_extends/LC_Page_Index_Ex.php';
//$fp = fopen("/home/sv11/www/html/smaregi/log.txt","w+");

define("CRON_PATH","/var/data/test/html/cron/");
define("LOG_FILE","email".date("Ymd").".log");
define("TO_ADDR1","wakabayashi@tag-i.net");
define("TO_ADDR2","tagawa@tagi.co.jp");
define("FROM_ADDR","info@bronline.jp");

//body = checkOrderList();

//sendMail(TO_ADDR2,"送信メール確認(".date("Ymd H:i:s").")",$body,FROM_ADDR);
//sendMail(TO_ADDR1,"送信メール確認(".date("Ymd H:i:s").")",$body,FROM_ADDR);

//if ($fp)
//	fclose($fp);

exit;

function checkOrderList()
{
   	$objQuery =& SC_Query_Ex::getSingletonInstance();

	// 当日   	
	$now = date('Y-m-d 00:00:00');
//print_r($now);
//$now = "2015-08-09 00:00:00";
   	// 受注番号を確認　基本的には当日分だけ
   	$objQuery->setOrder("order_id desc");
	$arrRet = $objQuery->select("*","dtb_order","(status = 1 or status = 6) and del_flg = 0 and create_date >= ?",array($now));

   	$col = '*';
   	$from = 'dtb_mail_history';
   	$where = 'order_id = ? and template_id = 1';
   	
   	$body = "";
   	
   	foreach($arrRet as $ret)
   	{
		$arrMail = $objQuery->select($col, $from, $where, array($ret['order_id']));
		if (count($arrMail) > 1)
		{
			$cnt = count($arrMail);
			$m = "order id {$ret['order_id']} mail count it's many. count({$cnt})";
			$body .= date("Ymd H:i:s")."   ".$m.PHP_EOL;
			outLog("mail many",$m);
//			print_r($m."<br>");
		}
		else if (count($arrMail) > 0)
		{
			$m = "order id {$ret['order_id']} mail count 1 send.";
			$body .= date("Ymd H:i:s")."   ".$m.PHP_EOL;
			outLog("mail normal",$m);
//			print_r($m."<br>");
		}
		else
		{
			$m = "order id {$ret['order_id']} mail none.";
			$body .= date("Ymd H:i:s")."   ".$m.PHP_EOL;
			outLog("mail none",$m);
//			print_r($m."<br>");
		}
   	}
   	
   	return $body;
}

function sendMail($to, $subject, $body, $from=TO_ADDR1)
{
	mb_language("japanese");
	mb_internal_encoding("utf-8");
	mb_send_mail($to, $subject, $body, "From:".$from.PHP_EOL);
}


function outLog($name,$data)
{
//	print_r($data);
//	$send_data .= date("Ymd H:i:s")."   ".$name.":".$data.PHP_EOL;
	$current = file_get_contents(LOG_FILE);
	$current = date("Ymd H:i:s")."   ".$name.":".$data.PHP_EOL;
	file_put_contents(LOG_FILE,$current, FILE_APPEND | LOCK_EX);
}
?>