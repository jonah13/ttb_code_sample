<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_options_class
{
	public $critical_words = array();
	public $feedback_limit; //feedback comments per customer limit --> n > 0 or 0 for unlimited 
	public $notify_for; //all, critical, none
	public $phones = array(); //array contains arrays of phone number + associated codes
	public $emails = array(); //array contains arrays of email + associated codes
	//the phone number can be: all_phones, user_phone, stores_phones, store_phone_'store_id', an actual phone number
	//the associated code can be: all_codes, an actual code
}