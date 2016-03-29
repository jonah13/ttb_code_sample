<?php
ini_set('display_errors',1);
// Receiving a push SMS
//===================================================
//  Celltrust sms Response gateway Test script
//  Put this script in the web server directory
//===================================================
$url = "http://www.telltheboss.com/sms/";

$fields = $_POST; //for live testing using POST Method 
	
//open connection
$ch = curl_init();
	
//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
	
//execute post
$result = curl_exec($ch);
	
//close connection
curl_close($ch);
//==========END: using CURL================//
/*
$file = fopen('/var/www/ttb/application/logs/new_incoming_sms_log', 'a');
fwrite($file, print_r($fields, true));
fwrite($file, $result);
fclose($file);*/
//echo print_r($fields, true);
//echo $result;

?>