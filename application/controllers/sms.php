<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms extends CI_Controller 
{
	protected $first_message_boiler = 'Text HELP for help, text STOP to stop. Msg&Data Rates May Apply';
	protected $last_message_boiler = 'Msg&Data Rates May Apply';
	protected $defaultorder = 'comment,rating,contact';
	protected $defaultscript = array(
				'rating'=>'How would you rate your experience? On a scale of 1-5 (1=worst, 5=best)?',
				'idfield'=>'Please enter your cab #:',
				//Where did your experience occur? Enter 1 for drive-thru, 2 for Carry-out, 3 for Eat-In
				'comment'=>'Tell us what you think?',
				'contact'=>'Thank you for your feedback. If you would like to be contacted re this
issue, enter your email or phone # below:',
				'contest'=>'Thank you for your feedback. To be entered in our monthly drawing, enter
your email or phone # below:',
				'reply'=>'Thank you for your feedback.'
				);
				
				
	protected $customer_response_period = 30; //in minutes

	//default reply messages
	protected $help_message = "TTB Service: Text a location code to 22121 and follow instructions. Reply STOP to stop. Msg&Data Rates May Apply. To reach customer support for this program, call (888)744-2855";
	protected $stopped_message = "TTB Service: You've chosen to not receive further messages. To restart send START, For more info visit telltheboss.com. Msg&Data Rates May Apply. To reach customer support for this program, call (888)744-2855";
	protected $stop_message = "TelltheBoss feedback: You have opted out and will receive no further messages/charges. To restart send START, For more info visit www.telltheboss.com. To reach customer support for this program, call (888)744-2855";
	protected $start_message = "You have opted in. Reply HELP for help, STOP to Stop.  Msg&Data Rates May Apply. To reach customer support for this program, call (888)744-2855";
	protected $wrong_message = "We did not understand your message. Msg&Data Rates May Apply Reply HELP for Help, STOP to Stop. www.telltheboss.com. To reach customer support for this program, call (888)744-2855";
	

	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		$this->load->model('codes_model','codes');
		$this->load->model('locations_model','locations');
		$this->load->model('comments_model','comments');
		$this->load->model('sms_record_model','sms_record');
		$this->load->model('customers_model','customers');
		$this->load->model('companies_model','companies');
		$this->load->model('pages_data_model','pages_data');
		
		$this->load->helper('feedback');
		$this->load->helper('sms');
		
	}
	
	function setupvariables($str,$qr,$company,$location,$code) {
		$variables = array(
			'company_name'=>$company['name'],
			'location_name'=>$location['name'],
			'code'=>$code,
			'date'=>''
			);
			
		$callback_date = create_function('$match', '
			if(empty($match[0]) || empty($match[1])) 
				return date("m/d/y"); 
			else 
				return date("m/d/y", time()+$match[1]*86400);
		');
	
		foreach ($variables as $k=>$v) {
			if ($k == 'date') {
				$str = preg_replace_callback("#\#date\+([0-9]+)#", $callback_date, $str);
			} else {
			    $str = preg_replace('/(\#'.$k.')/s', $v, $str);
			}
		}
		
		return $str;
	}

	
	public function simulate()
	{
		$this->load->view('admin/header');
		$this->load->view('feedback/simulate_sms');
		$this->load->view('admin/footer');		
	}
	
	//called when telltheboss.com receives a text(sms) from a customer, the txt is sent via POST with all the other information on the sender
	public function index($is_test = 0)
	{
		if(!empty($_POST['Message']) && !empty($_POST['OriginatorAddress']))
		{
			//first we add the message to the database records
			$Message = trim($_POST['Message']);
			$source_phone = format_phone($_POST['OriginatorAddress']);
			
			$record_data = array();
			$record_data['from'] = $source_phone;
			$record_data['to'] = '22121';
			$record_data['message'] = $Message;
			$record_data['ticket_id'] = $_POST['Carrier'] . '=' . $source_phone . '-' . substr($Message, 0, 5);
			$record_data['time'] = 'now';
			
			
			$all_words = explode(" ",$Message);
			$words_number = count($all_words);
			$first_word = strtoupper($all_words[0]);
			
			/*DEBUGING*/
			if($is_test)
			{
				echo "******************* START SIMULATION ********************* <br/>\r\n";
				echo "<h2>Details about incoming SMS</h2>";
				echo "<label>Source Phone:</label> " . $source_phone . "<br>\n";
				echo "<label>Carrier:</label> " . $_POST['Carrier'] . "<br>\n";
				echo "<label>Network Type:</label> " . $_POST['NetworkType'] . "<br>\n";
				echo "<label>Delivered text:</label> " . $_POST['Message'] . "<br>\n";
			}
			/*END DEBUGGING*/
			
			if($this->customers->count(array('phone'=>$source_phone)) == 0) //if the phone number doesn't exist in database, we add a new customer
			{
				$data = array();
				$data['phone'] = $source_phone;
				$customer_id = $this->customers->add($data);
			}
			if(empty($customer_id))
				$customer_id = $this->customers->get_id_from_phone($source_phone);
		
			//DEBUGING
			if($is_test)
				echo "<label>Customer ID:</label> " . $customer_id . "<br>\n";
			
			if($words_number == 1 && $first_word == "HELP")
			{
				if(!$this->isStopped($customer_id))
				{
					if(empty($is_test))
						send_sms($this, $source_phone, $this->help_message);
					else
						$this->display_send_sms($this->help_message);
				}
				else
				{	
					if(empty($is_test))
						send_sms($this, $source_phone, $this->stopped_message);
					else
						$this->display_send_sms($this->stopped_message);
				}
				$record_data['type'] = 'HELP';
			}
			elseif(($words_number == 1) && ($first_word == "STOP" || $first_word == "END" || $first_word == "CANCEL" || $first_word == "UNSUBSCRIBE"))
			{
				if(empty($is_test))
					send_sms($this, $source_phone, $this->stop_message);
				else
					$this->display_send_sms($this->stop_message);
				$this->stop_number($customer_id);
				$record_data['type'] = 'STOP';
			}
			elseif($words_number == 1 && $first_word == "START")
			{
				if(empty($is_test))
					send_sms($this, $source_phone, $this->start_message);
				else
					$this->display_send_sms($this->start_message);
				$this->unstop_number($customer_id); 
				$record_data['type'] = 'START';   
			}
			elseif(!$this->isStopped($customer_id)) //the message received can either be the store code, extra data, the feedback message or an error 
			{
				$where = array('code'=>$first_word);
				
				//CODE case
				if(count($all_words) == 1 && $this->codes->count($where) == 1) //if we only have one word in the message and it is a store code that exists in the database 
				{
					$code_row = $this->codes->get_by_code($first_word);
					$location_data = $this->locations->get_by_id($code_row['location_id']);
					$location_data = $location_data[0];
					$company_id = $code_row['company_id'];
					$company_data = $this->companies->get_by_id($company_id);
					$company_data = $company_data[0];
					$code_id = $code_row['ID'];
					
					if (empty($company_data['sms-order'])) {
						$company_data['sms-order'] = $this->defaultorder;
					}
					$ar = explode(',',$company_data['sms-order']);
					$reply_message = $company_data['sms-'.$ar[0].'-text'];
					if (empty($reply_message)) {
						$reply_message = $this->defaultscript[$ar[0]];
					}
					$reply_message .= ' '.$this->first_message_boiler;
					$reply_message = $this->setupvariables($reply_message,$ar[0],$company_data,$location_data,$first_word);
					if(empty($is_test))
						send_sms($this, $source_phone, $reply_message);
					else
						$this->display_send_sms($reply_message);
					$record_data['type'] = 'CODE'; 
				}
				//Feedback comment, extra data or error
				else //if we have more than one word or one word that is not a store code then the message might be feedback, extra data or an error
				{
					$customer_response_period = $this->customer_response_period;
					if(empty($customer_response_period))
						$customer_response_period = 30;
					$where = "`from` = '$source_phone' AND `type` = 'CODE' AND `time` > DATE_SUB(NOW(), INTERVAL $customer_response_period MINUTE)";
					
					//Error case
					if($this->sms_record->count($where) < 1) //this sender  has not sent a valid code in the last 30 minutes
					{
						if(empty($is_test))
							send_sms($this, $source_phone, $this->wrong_message);
						else
							$this->display_send_sms($this->wrong_message);
						$record_data['type'] = 'MISTAKE'; 
					}
					else //we get the last store code sent from the same phone number, then store the feedback and reply to the customer. IT CAN BE MORE THAN ONE CODE, WE NEED THE LAST ONE
					{
						$sms_records = $this->sms_record->list_records($where);
						foreach($sms_records as $sms_record)
						{
							$where = array('code'=>strtoupper($sms_record->message));
							if($this->codes->count($where) == 1) //we make sure it's a code
							{
								$code_obj = $this->codes->get_by_code($where['code']);
								$location_data = $this->locations->get_by_id($code_obj['location_id']);
								$location_data = $location_data[0];
								$company_id = $code_obj['company_id'];
								$company_data = $this->companies->get_by_id($company_id); 
								$company_data = $company_data[0];
								
								if (empty($company_data['sms-order'])) {
									$company_data['sms-order'] = $this->defaultorder;
								}
								$ar = explode(',',$company_data['sms-order']);
								$ans = array();
								if (!empty($company_data['qr-idfield-answers'])) {
									$ans = explode(',',$company_data['qr-idfield-answers']);
								}

								//we check if the customer has left extra data in the last 30 minutes, it still could be for another feedback left before his current one, so it must be after a code
								$extra_data_sms = $this->sms_record->list_records("`from` = '$source_phone' AND `type` like 'M_%' AND `ID` > '".$sms_record->ID."' AND `time` > DATE_SUB(NOW(), INTERVAL $customer_response_period MINUTE)");
								$extra_data_left = false;
								if(count($extra_data_sms) > 0)
									$extra_data_left = true;
								
								$extra_data_position = -1;
								foreach ($extra_data_sms as $extra) {
									$pos = array_keys($ar,substr($extra->type,2));
									if ($pos[0] > $extra_data_position) {
										$extra_data_position = $pos[0];
									}
								}
								// $extra_data_position now holds the last data we have in the database (-1 means we didn't find anything so we already asked for 0)
								$extra_data_position++; // go to next data item to indicate what we just recevied
								
								if ($ar[$extra_data_position] == 'idfield' && !empty($ans) && ($Message < '1' || $Message > count($ans))) {
									$reply_message = $company_data['sms-'.$ar[$extra_data_position+1].'-text'];
									if (empty($reply_message)) {
										$reply_message = $this->defaultscript[$ar[$extra_data_position+1]];
									}
									$reply_message = $this->setupvariables($reply_message,$ar[$extra_data_position+1],$company_data,$location_data,$where['code']);
							
									if(empty($is_test))
										send_sms($this, $source_phone, $reply_message);
									else
										$this->display_send_sms($reply_message);

									$record_data['type'] = 'INVALID'; 
								} else if ($extra_data_position >= count($ar) || $ar[$extra_data_position] == 'reply') { // we have exceeded the questions available or user are responding to the reply message
									$reply_message = $this->wrong_message;
									if(empty($is_test))
										send_sms($this, $source_phone, $reply_message);
									else
										$this->display_send_sms($reply_message);
									$record_data['type'] = 'FORBIDDEN'; 
								} else if (isset($ar[$extra_data_position+1]) && $ar[$extra_data_position+1] != 'reply') { // we have another question to ask and the next question is not the final reply
									$reply_message = $company_data['sms-'.$ar[$extra_data_position+1].'-text'];
									if (empty($reply_message)) {
										$reply_message = $this->defaultscript[$ar[$extra_data_position+1]];
									}
									$reply_message = $this->setupvariables($reply_message,$ar[$extra_data_position+1],$company_data,$location_data,$where['code']);
							
									if(empty($is_test))
										send_sms($this, $source_phone, $reply_message);
									else
										$this->display_send_sms($reply_message);
									$record_data['type'] = 'M_'.$ar[$extra_data_position];
								} else {
									$comment_data = array();

									$comment_data['comment'] = 'Undefined';
									$comment_data['unit'] = 'Undefined';
									$comment_data['contact'] = 'Undefined';
									$comment_data['contest'] = 'Undefined';
									$comment_data['rating'] = 'Undefined';
									
									foreach ($extra_data_sms as $extra) {
										if ($extra->type == 'M_rating') {
											$comment_data['rating'] = $extra->message;
										} else if ($extra->type == 'M_idfield') {
											if (!empty($ans)) {
												$comment_data['unit'] = trim($ans[$extra->message-1]);
											} else {
												$comment_data['unit'] = $extra->message;
											}
										} else if ($extra->type == 'M_comment') {
											$comment_data['comment'] = $extra->message;
										} else if ($extra->type == 'M_contact') {
											$comment_data['contact'] = $extra->message;
										} else if ($extra->type == 'M_contest') {
											$comment_data['contest'] = $extra->message;
										}
									}

									// put in this data
									if ($ar[$extra_data_position] == 'rating') {
										$comment_data['rating'] = $Message;
									} else if ($ar[$extra_data_position] == 'idfield') {
										if (!empty($ans)) {
											$comment_data['unit'] = trim($ans[$Message-1]);
										} else {
											$comment_data['unit'] = $Message;
										}
									} else if ($ar[$extra_data_position] == 'comment') {
										$comment_data['comment'] = $Message;
									} else if ($ar[$extra_data_position] == 'contact') {
										$comment_data['contact'] = $Message;
									} else if ($ar[$extra_data_position]== 'contest') {
										$comment_data['contest'] = $Message;
									}
									
									$comment_data['time'] = 'now';
									$comment_data['comment_time'] = 'now';
									if (empty($comment_data['rating']) || $comment_data['rating'] == 'Undefined') {
										$comment_data['nature'] = rate_feedback($comment_data['comment']);
									} else {
										if ($comment_data['rating'] < 3) {
											$comment_data['nature'] = 'negative';
										} else if ($comment_data['rating'] == 3) {
											$comment_data['nature'] = 'neutral';
										} else if ($comment_data['rating'] > 3) {
											$comment_data['nature'] = 'positive';
										} else {
											$comment_data['nature'] = rate_feedback($comment_data['comment']);
										}
									}
									$comment_data['analyzer_nature'] = $comment_data['nature'];
									$comment_data['origin'] = 'SMS';
									$comment_data['phone_number'] = $source_phone;
									$comment_data['code_id'] = $code_obj['ID'];
									$comment_data['code'] = $where['code'];
									$comment_data['location_id'] = $code_obj['location_id'];
									$comment_data['company_id'] = $code_obj['company_id'];
									
									if(!empty($is_test))
										$comment_data['is_test'] = 1;
									
									$record_data['type'] = 'M_'.$ar[$extra_data_position];
									
									$comment_id = $this->comments->add($comment_data);

									if (in_array('reply',$ar)) {
										$reply_message = $company_data['sms-reply-text'];
										if (empty($reply_message)) {
											$reply_message = $this->defaultscript['reply'];
										}
										$reply_message .= ' '.$this->last_message_boiler;
										$reply_message = $this->setupvariables($reply_message,'reply',$company_data,$location_data,$where['code']);

										if(empty($is_test))
											send_sms($this, $source_phone, $reply_message);
										else
											$this->display_send_sms($reply_message);
									}
									//sending notification ==> to be done
									$msg = $where['code'].(empty($unit) ? '' : ' ('.$unit.')').": ".$Message;
									
									if(empty($is_test)) {
										$phone_list = send_notifications($this, $where['code'], $msg, $comment_data['nature'], $comment_id);
									}

									
								}
				                break;
							}
							else
								echo 'No earlier code was found from this sender<br/>\r\n';
						}
					}
				}
			}
			else
			{
				if(empty($is_test))
					send_sms($this, $source_phone, $this->stopped_message);
				else
					$this->display_send_sms($this->stopped_message);
				$record_data['type'] = 'FORBIDDEN'; 
			}
			
			//storing sms record
			$this->sms_record->add($record_data);
		}
		else //error receiving the SMS
			echo "Error receiving SMS \r\n";
		
		if($is_test)
			echo "******************* END SIMULATION ********************* <br/>\r\n";
	}
	
	function isStopped($customer_id)
	{
		return (int)$this->customers->get_data($customer_id, 'stopped');
	}
	
	function stop_number($customer_id)
	{
		$data['stopped'] = 1;
		$this->customers->edit($customer_id, $data);
	}
	
	function unstop_number($customer_id)
	{
		$data['stopped'] = 0;
		$this->customers->edit($customer_id, $data);
	}
	
	function display_send_sms($msg)
	{
		echo "<h2>Server's reply: (".strlen($msg).")</h2> <p><strong>".$msg."</strong></p><br/>\r\n";
	}
}
	
	