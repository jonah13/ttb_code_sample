<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('send_sms'))
{
	function send_sms($obj, $to, $message, $Purpose = 'standard_content')
	{
		if(!empty($message))
		{
			$callback_date = create_function('$match', '
						if(empty($match[0]) || empty($match[1])) 
							return date("m/d/y"); 
						else 
							return date("m/d/y", time()+$match[1]*86400); ');
					
			$message = preg_replace_callback("#\#date\+([0-9]+)#", $callback_date, $message);
		}
	
		log_message('debug', 'called send_sms');
		
		// Sending an SMS
		$URL = "https://gateway.celltrust.net/TxTNotify/TxTNotify?";
		//your username generally
		$USERNAME = "Telltheboss";
		$PASSWORD = "ttb55";
		$NICKNAME = "Telltheboss";
		//Carrier ID of the Carrier is required. 
		//$CARRIER= "CARRIER ID";
		$XMLRESPONSE = "true"; 
		$DATA  = "PhoneDestination=".$to. "&Message=".urlencode($message). "&Username=".$USERNAME. "&Password=".$PASSWORD."&CustomerNickname=".$NICKNAME."&XMLResponse=".$XMLRESPONSE;
		$response = do_post_request($URL, $DATA);
/*
		$response = "<TxTNotifyResponse><MsgResponseList><MsgResponse type='SMS'><Status>ACCEPTED</Status><MessageId>BCXF1393460627998-501684</MessageId></MsgResponse></MsgResponseList></TxTNotifyResponse>";		
*/
		
		log_message('debug', $DATA);
		log_message('debug', $response);

		$xmldoc = new SimpleXMLElement($response);
		if($xmldoc->error)
		{
			echo $xmldoc->Error->ErrorCode . " : " . $xmldoc->Error->ErrorMessage;
			return false;
		}
		else
		{
			//storing the sent sms in the all_sms_record table
			$data = array();
			$data['from'] = '22121';
			$data['to'] = $to;
			$data['message'] = $message;
			$data['ticket_id'] = (string)$xmldoc->MsgResponseList->MsgResponse[0]->MessageId;
			$data['time'] = 'now';
			$data['type'] = 'NOTIFY';
			log_message('debug', print_r($data,true));
			$obj->sms_record->add_sms_record($data);
			return true;
		}	
	}
}

if (!function_exists('format_phone'))
{
	function format_phone($phone_number)//give the phone number the right format (11 digits, no +)
	{
		//removing all kind of separators 
		$phone_number = str_replace("+","",$phone_number);
		$phone_number = str_replace("-","",$phone_number);
		$phone_number = str_replace("(","",$phone_number);
		$phone_number = str_replace(")","",$phone_number);
		$phone_number = str_replace(" ","",$phone_number);
		
		if(strlen($phone_number) == 10)
		{
			$phone_number = '1'.$phone_number;
		}
		
		return $phone_number;
	}
}

//should work in PHP 4 and 5
function do_post_request($url, $data, $optional_headers = null) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
	return $response;
} 


if (!function_exists('send_notifications'))
{
	// Takes a code, and sends a notification message to users for that code
	function send_notifications($obj, $code, $message, $nature = 0, $comment_id)
	{
		$config['mailtype'] = 'html';
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$obj->email->initialize($config);
	
		// Gather phone and email data on users
		$phones = array();
		$emails = array();
		
		$code_row = $obj->codes->get_by_code($code);
		if(empty($code_row)) return $phones;
		
		$code_id = $code_row['ID'];
		$location_id = $code_row['location_id'];
		$company_id = $code_row['company_id'];
		
		// TODO: Get all user_ids with permissions on this code, and test all for phone notifications

		$users = $obj->users->get_users_for_location($location_id);
		foreach ($users as $u) {
			$phone = $obj->users->get_phones($u['ID']);

			if (!empty($phone)) {
				$phone = $phone[0];
				$notify = $phone['notify_for'];
				if ($notify == "all" || $notify == $nature) {
					try {
						send_sms($obj, format_phone($phone['contact']), $message);
					} catch (Exception $e) {
		    			log_message('error', 'Caught exception: '.$e->getMessage()." \r\n");
					}
				}
			}

			
			$email = $obj->users->get_emails($u['ID']);
			if (!empty($email)) {
				$email = $email[0];
				$notify = $email['notify_for'];
				if ($notify == "all" || $notify == $nature) {
				
					if(!empty($comment_id))
						$comment = $obj->comments->get_by_id($comment_id);
					if(!empty($comment))
					{
						$company = $obj->companies->get_by_id($comment['company_id']);
						$company = $company[0];
						$company_name = $company['name'];
						$location = $obj->locations->get_by_id($comment['location_id']);
						$location = $location[0];
						$location_name = $location['name'];
						
						$time = $comment['time'];
						
						$time_obj = new DateTime($time);
						if ($location['timezone'] == 'MST')
						{
							$time_obj->add(date_interval_create_from_date_string('1 hour'));
							$time = $time_obj->format('m/d/y g:iA').' MST';
						}
						else if ($location['timezone'] == 'CST')
						{
							$time_obj->add(date_interval_create_from_date_string('2 hours'));
							$time = $time_obj->format('m/d/y g:iA').' CST';
						}
						else if ($location['timezone'] == 'EST')
						{
							$time_obj->add(date_interval_create_from_date_string('3 hours'));
							$time = $time_obj->format('m/d/y g:iA').' EST';
						} 
						else 
						{
							$time = $time_obj->format('m/d/y g:iA').' PST';
						}
						
						$email_message = '<strong>Tell The Boss Feedback for: '.$company_name.'</strong><br/><br/>';
						$email_message .= '<span style="width:100px;">Date:    </span>'.$time.'<br/>';
						$email_message .= '<span style="width:100px;">Code:    </span>'.$comment['code'].'<br/>';
						$email_message .= '<span style="width:100px;">Location:    </span>'.$location_name.'<br/>';
						$email_message .= '<span style="width:100px;">Comment:    </span>'.$comment['comment'].'<br/>';
						$email_message .= '<span style="width:100px;">+/-:    </span>'.$comment['nature'].'<br/>';
						$email_message .= '<span style="width:100px;">Source:    </span>'.$comment['origin'].'<br/>';
						if (!empty($company['unitname']) && $company['unitname'] != '') {
							$email_message .= '<span style="width:100px;">'.$company['unitname'].':    </span>'.$comment['unit'].'<br/>';
						}
/*
						if ($company['contact'] != '') {
							$email_message .= '<span style="width:100px;">Contact:    </span>'.$comment['contact'].'<br/>';
						}
*/
					}
					
					$obj->email->clear();
					$obj->email->from('donotreply@telltheboss.com', 'Tell The Boss');
					$obj->email->to($email['contact']);
		
					$obj->email->subject('Tell The Boss Feedback for: '. $company_name);
					if(empty($email_message))
						$obj->email->message($message);
					else
						$obj->email->message($email_message);
						
					if(!$obj->email->send())
					{
		   				log_message('error', 'Email Failed. Debug: '.$obj->email->print_debugger()." \r\n");
					}
					
				}
			}
		}

	}
}
		