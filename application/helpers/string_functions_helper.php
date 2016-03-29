<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('format_phone'))
{
	function format_phone($phone_number)//give the phone number the right format (11 digits, no +)
	{
		//removing all kind of separators 
		$phone_number = str_replace("/\D/","",$phone_number);
		
		if(strlen($phone_number) == 10)
		{
			$phone_number = '1'.$phone_number;
		}
		
		return $phone_number;
	}
}

if (!function_exists('remove_amp'))
{
	function remove_amp($str)//give the phone number the right format (11 digits, no +)
	{
		$str = str_replace("&amp;","&",$str);
		
		return $str;
	}
}
