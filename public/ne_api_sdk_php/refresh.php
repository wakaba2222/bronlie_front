<?php
//$url = "https://demo:testtest@dev.bronline.jp/ne_api_sdk_php/api_brnext.php?receive_id=0";
$url = "https://www.bronline.jp/ne_api_sdk_php/api_brnext.php?receive_id=0";
$options['http']['header']='User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)';
$options['http']['ignore_errors']=true;
$options['ssl']['verify_peer']=false;
$options['ssl']['verify_peer_name']=false;
$response = file_get_contents($url, false, stream_context_create($options));

var_dump($response);
?>
