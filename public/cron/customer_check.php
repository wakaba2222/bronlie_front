<?php
//require_once '../../data/config/config.php';

require_once '../require.php';
require_once CLASS_EX_REALDIR . 'page_extends/LC_Page_Index_Ex.php';
//$fp = fopen("/home/sv11/www/html/smaregi/log.txt","w+");

define("CRON_PATH","/var/www/bronline/public/cron/");
define("LOG_FILE","customer".date("YmdHis").".log");
class CustomerMail extends LC_Page_Index_Ex {
	function send($ret, $template_id)
	{
		$this->customer = $ret;
//		$this->point_date = date('Y-m-d',date($ret['last_buy_date'].strtotime('+ day'));
		$m = new SC_Helper_Mail_Ex();
		$m->setPage($this);
		$m->sfSendTemplateMail($ret['email'],$ret['name01'], $template_id, $this);
	}
}

//$fp = fopen(CRON_PATH.LOG_FILE, 'w+');
// 失敗した場合はエラー表示

// 仮ポイントチェック
// １分毎にチェックして期間過ぎていたら有効ポイントにする
//if ($fp)
//{
//	fwrite($fp,date("Ymd H:i:s"));
//	fwrite($fp,"   check_temp_point:".PHP_EOL);
//}

check_temp_point();

fast_mail();
last_mail();

lost_point();

//if ($fp)
//	fclose($fp);

exit;


function fast_mail()
{
    $CONF = SC_Helper_DB_Ex::sfGetBasisData();
    
    $arrRet = check_customer($CONF['send_mail_fast']);
    
	$objPage = new CustomerMail();
	register_shutdown_function(array($objPage, 'destroy'));
	$objPage->init();

    foreach($arrRet as $ret)
    {
    	$ret['point_date'] = date('Y-m-d',strtotime($ret['last_buy_date']." +".$CONF['lost_point']."days"));
//    	print_r("fast mail:".$ret['email']."<br>");
		$objPage->send($ret, 50);
    }
}

function last_mail()
{
    $CONF = SC_Helper_DB_Ex::sfGetBasisData();
    
    $arrRet = check_customer($CONF['send_mail_last']);
    
	$objPage = new CustomerMail();
	register_shutdown_function(array($objPage, 'destroy'));
	$objPage->init();

    foreach($arrRet as $ret)
    {
    	$ret['point_date'] = date('Y-m-d',strtotime($ret['last_buy_date']." +".$CONF['lost_point']."days"));
//    	print_r("last mail:".$ret['email']."<br>");
		$objPage->send($ret, 51);
    }
}

function check_customer($day)
{    
   	$now = date('Y-m-d H:i:s', strtotime("-".$day." days"));
   	$now2 = date('Y-m-d H:i:s', strtotime("-".($day+1)." days"));
//   	$arrRet = getCustomerPoint("point_flg > 0 and point > 0 and (last_buy_date > '".$now2."' and last_buy_date < '".$now."')");
   	$arrRet = getCustomerPoint("point > 0 and (last_buy_date > '".$now2."' and last_buy_date < '".$now."')");
//print_r($now."<br>");
//print_r($now2."<br>");
   	return $arrRet;
}

function lost_point()
{
    $CONF = SC_Helper_DB_Ex::sfGetBasisData();
    
    $arrRet = check_customer($CONF['lost_point']);
    
   	$objQuery =& SC_Query_Ex::getSingletonInstance();

	$where = "customer_id = ?";

	$objPage = new CustomerMail();
	register_shutdown_function(array($objPage, 'destroy'));
	$objPage->init();

	$objQuery->begin();
    foreach($arrRet as $ret)
    {
    	$customer_id = $ret['customer_id'];
    	$sql = array();
    	$sql['point'] = '0';
		$sql['update_date'] = 'CURRENT_TIMESTAMP';
    	
		$objQuery->update('dtb_customer', $sql, $where, array($customer_id));
		SC_Helper_DB_Ex::pointLog($ret['customer_id'], $ret['point'], POINT_LOG_LOST);
//    	print_r($ret['email']."<br>");
//		$objPage->send($ret, 52);
    }
	$objQuery->commit();
}

function getCustomerPoint($where = "")
{
   	$objQuery =& SC_Query_Ex::getSingletonInstance();

	$col = "*";
	$from = "dtb_customer";

	$arrRet = $objQuery->select($col,$from,$where);
	
	return $arrRet;
}

function check_temp_point()
{
    $CONF = SC_Helper_DB_Ex::sfGetBasisData();

   	$now = date('Y-m-d H:i:s', strtotime("-".$CONF['pointtopoint']." days"));
   	$arrValid = SC_Helper_DB_Ex::getTempPoint2("create_date < '".$now."'");
//print_r($now);
   	if (count($arrValid) > 0)
	   	move_point($arrValid);
}

function move_point($arrValid)
{
   	$objQuery =& SC_Query_Ex::getSingletonInstance();

	$objQuery->begin();
	foreach($arrValid as $point)
	{
		$customer_id = $point['customer_id'];
		$order_id = $point['order_id'];
		$p = $point['point'];
		$d = $point['create_date'];
		
		$arrRet = $objQuery->select("point","dtb_customer","customer_id = ?",array($customer_id));
		
    	$sql = array();
		$sql['point'] = intVal($arrRet[0]['point']) + intVal($p);
		$sql['update_date'] = 'CURRENT_TIMESTAMP';
		$where = "customer_id = ?";
		
		$objQuery->update('dtb_customer', $sql, $where, array($customer_id));

		$where = "customer_id = ? and order_id = ?";
		$objQuery->delete('dtb_temp_point', $where, array($customer_id, $order_id));

		SC_Helper_DB_Ex::pointLog($customer_id, $p, POINT_LOG_ENABLE, $order_id);
	}
	$objQuery->commit();
}


function outLog($name,$data)
{
	$current = file_get_contents(LOG_FILE);
	$current = date("Ymd H:i:s")."   ".$name.":".$data.PHP_EOL;
	file_put_contents(LOG_FILE,$current, FILE_APPEND | LOCK_EX);
/*
//	print_r($data);
	$send_data .= date("Ymd H:i:s")."   ".$name.":".$data.PHP_EOL;
	
	$fp = fopen(CRON_PATH.LOG_FILE.date("Ymd").".log","a+");
	fwrite($fp,date("Ymd H:i:s"));
	fwrite($fp,"   ".$name.":".$data.PHP_EOL);
	fclose($fp);
*/
}
?>