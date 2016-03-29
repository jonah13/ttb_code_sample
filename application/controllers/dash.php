<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dash extends CI_Controller 
{
	protected $page_data;
	protected $admin_id;
	protected $company_id;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('comments_model', 'comments');
		$this->load->model('companies_model', 'companies');
		$this->load->model('locations_model', 'locations');
		$this->load->model('codes_model','codes');

		$this->load->model('pages_data_model');
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
		
		$this->page_data = array();
		$this->page_data['title'] = 'Tell The Boss - Feedback';

		$this->admin_id = $this->session->userdata('user_id');
		
		$this->company_id = $this->session->userdata('cid');
	}
	
	public function index()
	{
		if($this->pages_data_model->is_logged_in())
		{
			$values = $this->input->post(NULL, TRUE);
			
			$date_filter = array();
			if (!empty($values)) {
				if (!empty($values['startdate']) && !empty($values['enddate'])) {
					$date_filter['start'] = $values['startdate'];
					$date_filter['end'] = $values['enddate'];
				}
			}
			$this->page_data['date_filter'] = $date_filter;
			
			$location_filter = array();
			if (!empty($values)) {
				if (!empty($values['locations'])) {
					$location_filter = explode(',',$values['locations']);
				}
				$pos = array_search($values['location'],$location_filter);
				if ($pos !== false) {
					unset($location_filter[$pos]);
				} else if (!empty($values['location'])) {
					$location_filter[] = $values['location'];
				}
			}
			$this->page_data['location_filter'] = $location_filter;
			
			$code_filter = array();
			if (!empty($values)) {
				if (!empty($values['codes'])) {
					$code_filter = explode(',',$values['codes']);
				}
				$pos = array_search($values['code'],$code_filter);
				if ($pos !== false) {
					unset($code_filter[$pos]);
				} else if (!empty($values['code'])) {
					$code_filter[] = $values['code'];
				}
			}
			$this->page_data['code_filter'] = $code_filter;
			
			$unit_filter = array();
			if (!empty($values)) {
				if (!empty($values['units'])) {
					$unit_filter = explode(',',$values['units']);
				}
				$pos = array_search($values['unit'],$unit_filter);
				if ($pos !== false) {
					unset($unit_filter[$pos]);
				} else if (!empty($values['unit'])) {
					$unit_filter[] = $values['unit'];
				}
			}
			$this->page_data['unit_filter'] = $unit_filter;
			
			$exp_filter = array();
			if (!empty($values)) {
				if (!empty($values['exps'])) {
					$exp_filter = explode(',',$values['exps']);
				}
				$pos = array_search($values['exp'],$exp_filter);
				if ($pos !== false) {
					unset($exp_filter[$pos]);
				} else if (!empty($values['exp'])) {
					$exp_filter[] = $values['exp'];
				}
			}
			$this->page_data['exp_filter'] = $exp_filter;
			
			$source_filter = array();
			if (!empty($values)) {
				if (!empty($values['sources'])) {
					$source_filter = explode(',',$values['sources']);
				}
				$pos = array_search($values['source'],$source_filter);
				if ($pos !== false) {
					unset($source_filter[$pos]);
				} else if (!empty($values['source'])) {
					$source_filter[] = $values['source'];
				}
			}
			$this->page_data['source_filter'] = $source_filter;
			
			$this->page_data['adminpage'] = "Feedback";

			if ($this->company_id == 0) {
				$c = $this->companies->get_companies_for_user($this->admin_id);
				if (!empty($c)) {
					$this->company_id = $c[0]['ID'];
				} else {
					redirect('admin');
				}
			}
			if (!$this->companies->verify_company_for_user($this->admin_id,$this->company_id)) {
				$c = $this->companies->get_companies_for_user($this->admin_id);
				if (!empty($c)) {
					$this->company_id = $c[0]['ID'];
				} else {
					redirect('admin');
				}
			}

			$company = $this->companies->get_by_id($this->company_id);
			$this->page_data['company'] = $company[0];

			$comments = $this->comments->get_by_company_id($this->company_id,$location_filter,$code_filter,$unit_filter,$exp_filter,$source_filter,$date_filter);
			$this->page_data['comments'] = $comments;
			
			$stats = array(
				'positive' => 0,
				'negative' => 0,
				'neutral' => 0,
				'URL' => 0,
				'QR' => 0,
				'MAIL' => 0,
				'SMS' => 0
				);
			foreach ($comments as $c) {
				if (isset($stats[$c['nature']])) {
					$stats[$c['nature']]++;
				}
				if (isset($stats[$c['origin']])) {
					$stats[$c['origin']]++;
				}
			}
			$this->page_data['stats'] = $stats;
			
			$my_locations = $this->comments->get_locations_for_company_id($this->company_id);
			$this->page_data['my_locations'] = $my_locations;
			$my_codes = $this->comments->get_codes_for_company_id($this->company_id);
			$this->page_data['my_codes'] = $my_codes;
			$my_units = $this->comments->get_units_for_company_id($this->company_id);
			$this->page_data['my_units'] = $my_units;
			
			$this->load->view('admin/header', $this->page_data);
			$this->load->view('dash/feedback_index',$this->page_data);
			$this->load->view('admin/footer');

		}
		else
		{
			redirect('error/must_sign_up');
		}
	}

	public function delete_comment() {
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'SUPER') == 0) {
			$id = $this->input->get('cid');
			$this->comments->delete_by_id($id);
			redirect(site_url('/dash'));
		}
	}
	
	public function edit_comment() {
		if($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'SUPER') == 0) {
			$this->page_data['adminpage'] = "Feedback";

			$id = $this->input->get('cid');
			$company = $this->companies->get_by_id($this->company_id);
			$this->page_data['company'] = $company[0];
			
			if ($id != 0) {
				$comment = $this->comments->get_by_id($id);
				$this->page_data['comment'] = $comment[0];
			}
			
			$locations = $this->locations->get_by_company_id($this->company_id);
			$this->page_data['locations'] = $locations;
			
			$codes = $this->codes->get_by_company_id($this->company_id);
			$this->page_data['codes'] = $codes;
			
			$this->load->view('admin/header', $this->page_data);
			$this->load->view('feedback/edit_comment',$this->page_data);
			$this->load->view('admin/footer');
		}
		else
		{
			redirect('error/must_sign_up');
		}
	}	

	public function save_comment()
	{
		$questions = array(
			'driver_polite'=>"Was the driver polite?",
			'driver_safe'=>"Did your driver drive safely?",
			'driver_taxi_clean'=>"Was your taxi clean and neat?",
			'driver_clean'=>"Was the driver clean and neat?",
			'driver_cc'=>"Did the driver accept a credit card?",
			'driver_exp'=>"Rate your overall experience?"
		);
		
		$formValues = $this->input->post(NULL, TRUE);
		$cid = $formValues['ID'];
		if ($cid == 0) {
			$formValues['origin'] = 'MAIL';
			$formValues['company_id'] = $this->company_id;
			if (!empty($formValues['timetype'])) {
				if ($formValues['timetype'] == 'AM') {
					$formValues['comment_time'] .= ' 08:00:00';
				}
				if ($formValues['timetype'] == 'PM') {
					$formValues['comment_time'] .= ' 20:00:00';
				}
				unset($formValues['timetype']);
			}
			$formValues['time'] = $formValues['comment_time'];
			foreach ($questions as $k=>$q) {
				if (!empty($formValues[$k])) {
					$val = $formValues[$k];
					if ($val != '0') {
						$formValues['comment'] .= "\n".$q.'='.$val;
					}
					unset($formValues[$k]);
				}
			}
			$lid = $this->comments->add($formValues);

		} else {
			$this->comments->put_by_id($formValues);
		}
		redirect('dash');
	}
	
	public function pdf() {
		$displayed_data = $this->comments->get_by_company_id($this->company_id);

		$nb_filtred_results = array(); //$comments['nb_filtred_results'];
		$nb_total_results = array(); //$comments['nb_total_results'];
		
		$comments_number = count($displayed_data);
		if($comments_number == 0) $comments_number = 1;
		$posi = 0; $nega = 0; $neut = 0;
		$br = ' 
	';

		$this->load->library('cezpdf');
		foreach($displayed_data as $row_key => $row_val)
		{
			//time
			$time = new DateTime($row_val['comment_time'], new DateTimeZone('America/Los_Angeles')); //PDT is the timezone in the server.
			if(strcasecmp($row_val['timezone'], "America/Los_Angeles") != 0)
				$time->setTimezone(new DateTimeZone($row_val['timezone']));
			if(strcasecmp($row_val['time_type'], "NO_TIME") == 0)
				$time_str = $time->format('m/d/y');
			elseif(strcasecmp($row_val['time_type'], "AM") == 0 )
				$time_str = $time->format('m/d/y \A\M');		
			elseif(strcasecmp($row_val['time_type'], "PM") == 0)
				$time_str = $time->format('m/d/y \P\M');		
			else
				$time_str = $time->format('m/d/y g:iA T');	
				
			$time_str = preg_replace('/ /', $br, $time_str);
				
			//comment	
			$comment_text = strip_tags($row_val['comment']); 
			$extra_data = "";
/*
			if(!empty($row_val['extra_data']) || !empty($row_val['sec_extra_data']))
			{
				if(!empty($row_val['cf_name']) && !empty($row_val['extra_data']))
					$extra_data = '<c:bold><c:uline>'.$row_val['cf_name'].':</c:uline></c:bold> '.$row_val['extra_data'];
				
				if(!empty($row_val['sec_extra_data']))
				{
					if(!empty($row_val['cf2_name']))
					{
						if(empty($extra_data))
							$extra_data = '<c:bold><c:uline>'.$row_val['cf2_name'].':</c:uline></c:bold> '.$row_val['sec_extra_data'];
						else
							$extra_data = $extra_data.$br.'<c:bold><c:uline>'.$row_val['cf2_name'].':</c:uline></c:bold> '.$row_val['sec_extra_data'];
					}
					elseif($row_val['cf_name'])
					{
						if(empty($extra_data))
							$extra_data = '<c:bold><c:uline>'.$row_val['cf_name'].':</c:uline></c:bold> '.$row_val['sec_extra_data'];
						else
							$extra_data = $extra_data.$br.'<c:bold><c:uline>'.$row_val['cf_name'].':</c:uline></c:bold> '.$row_val['sec_extra_data'];
					}
				}
				if(!empty($extra_data))
					$comment_text = $comment_text.$br.$extra_data;
			}
*/
			
			//origin
			$source = $row_val['origin'];
			if(!empty($row_val['indirect_origin']))
						$source = $source.$br.'('.strtolower($row_val['indirect_origin']).')';
				
			//code
			$code = $row_val['code']; 
			if(!empty($row_val['code_desc']))
				$code .= $br.'('.$row_val['code_desc'].')';
				
			$data[] = array('Time'=>$time_str, 'Location'=>$row_val['locname'],'Code'=>$code,'Comment'=>$comment_text,'Nature'=>$row_val['nature'],'Source'=>$source);
				
			//nature
			if(strcasecmp($row_val['nature'], 'positive') == 0)
				$posi++;
			elseif(strcasecmp($row_val['nature'], 'negative') == 0)
				$nega++;
			elseif(strcasecmp($row_val['nature'], 'neutral') == 0)
				$neut++;
			
		}
		//var_dump($data);
		
		// Set Report Title
		$report_title = "Feedback report".$br;
		
		$h_filter = "";
		$p_filter = "";
		$o_filter = "";
		
		$cur_filter = $this->input->get('filter_by');
	
		$cur_company = $this->input->get('company');
		$cur_group = $this->input->get('group');
		$cur_location = $this->input->get('location');
		$cur_code = $this->input->get('code');
		
		$cur_period = $this->input->get('period');
		$cur_from = $this->input->get('from');
		$cur_to = $this->input->get('to');
		
		$cur_nature = $this->input->get('nature');
		$cur_source = $this->input->get('source');
		
		if(!empty($cur_filter))
		{
			if(strcasecmp($cur_filter, 'code') == 0 && !empty($cur_code))
				$h_filter = $this->pa_companies[$this->pa_codes[$cur_code]['company_id']]['name']." - ".$this->pa_locations[$this->pa_codes[$cur_code]['location_id']]['name']." - ".$this->pa_codes[$cur_code]['code'];
			elseif(strcasecmp($cur_filter, 'location') == 0 && !empty($cur_location))
				$h_filter = $this->pa_companies[$this->pa_locations[$cur_location]['company_id']]['name']." - ".$this->pa_locations[$cur_location]['name']." - All Codes";
			elseif(strcasecmp($cur_filter, 'group') == 0 && !empty($cur_group))
				$h_filter = $this->pa_companies[$this->site_groups[$cur_group]['company_id']]['name']." - ".$this->site_groups[$cur_group]['name']." - All Locations - All Codes";
			elseif(strcasecmp($cur_filter, 'company') == 0 && !empty($cur_company))
				$h_filter = $this->pa_companies[$cur_company]['name']." - All Locations - All Codes";
		}
		else
		{
			$h_filter = "All Companies - All Locations - All Codes";
		}
		
		if(!empty($cur_period))
		{
			if(strcasecmp($cur_period, 'today') == 0)
				$p_filter = "Period: Today";
			elseif(strcasecmp($cur_period, 'weekly') == 0)
				$p_filter = "Period: Last 7 Days";
			elseif(strcasecmp($cur_period, 'monthly') == 0)
				$p_filter = "Period: Last 30 Days";
			elseif(strcasecmp($cur_period, 'yearly') == 0)
				$p_filter = "Period: Last 12 Months";
			elseif(strcasecmp($cur_period, 'custom') == 0 && !empty($cur_from) && !empty($cur_to))
				$p_filter = "Period: Between ".$cur_from." and ".$cur_to;
		}
		else
			$p_filter = "Period: All Time";
		
		if(!empty($cur_nature))
			$o_filter = "Nature: ".str_replace('_', ' ', $cur_nature).". ";
		
		if(!empty($cur_source))
			$o_filter .= 'Source: '.$cur_source;
	
		/*foreach($this->pa_companies as $c)
				$report_title = $report_title . $c['name'].' - ';*/
		
		$this->cezpdf->ezSetMargins(115,80,20,20);
		
		$header = $this->cezpdf->openObject();
		$this->cezpdf->addJpegFromFile(UPLOAD_DIR.'../logo.jpg',25,750,120);
		$this->cezpdf->closeObject();
		$this->cezpdf->addObject($header, "all");
		
		
		$footer = $this->cezpdf->openObject();
	  $this->cezpdf->addText(25,45,8,"TELL THE BOSS, INC. 27762 Antonio Pkwy., Suite L-1504, Ladera Ranch, CA 92694 (800) 372-7960. www.TellTheBoss.com");
		$this->cezpdf->closeObject();
		$this->cezpdf->addObject($footer, "all");
		
		
		//letter = 612 x 792
		$this->cezpdf->addInfo('Title',$report_title);
		$this->cezpdf->addInfo('Author','TellTheBoss.com');
		$this->cezpdf->addInfo('Subject','Feedback Report');
		
		$this->cezpdf->ezStartPageNumbers(552,45,12,'','',1);
		$this->cezpdf->setLineStyle(1);
		
	  $this->cezpdf->addText(25,735,12,$report_title);
	  $this->cezpdf->addText(25,720,10,$h_filter);
	  $this->cezpdf->addText(25,705,10,$p_filter);
		if(!empty($o_filter))
		{
			$this->cezpdf->addText(25,690,10,$o_filter);
			$this->cezpdf->addText(25,675,10,"Comments Number: ".$comments_number);
		}
		else
			$this->cezpdf->addText(25,690,10,"Comments Number: ".$comments_number);
		
		//$this->cezpdf->addText(25,735,8,$report_title);
	
		$dataNature[] = array('Nature'=>'Positive', 'Count'=>round(($posi*100)/$comments_number)."%");
		$dataNature[] = array('Nature'=>'Negative', 'Count'=>round(($nega*100)/$comments_number)."%");
		$dataNature[] = array('Nature'=>'Neutral', 'Count'=>round(($neut*100)/$comments_number)."%");
		
		$this->cezpdf->ezTable($dataNature,'','eAnalyzer Results',array('showHeadings'=>0,'shadeCol'=>array(0.9,0.9,0.9),'shaded'=>1,'fontSize'=>7, 'width'=>120,'xPos'=>'right','xOrientation'=>'left','cols' => array('Nature'=>array('justification'=>'left','width'=>80),'Count'=>array('justification'=>'right','width'=>30) )));
		$this->cezpdf->ezSetDy(-20);
		$this->cezpdf->ezTable($data,'','',array('showHeadings'=>1,'shaded'=>1,'fontSize'=>7, 'width'=>545, 'xPos'=>'right','xOrientation'=>'left',  'shadeCol'=>array(0.9,0.9,0.9),  'shadeCol2'=>array(0.9,0.9,0.9),'cols' => array('time'=>array('justification'=>'left','width'=>50),'Location'=>array('justification'=>'center','width'=>50),'Code'=>array('justification'=>'center','width'=>50),'Comment'=>array('justification'=>'left'),'Nature'=>array('justification'=>'center','width'=>40),'Source'=>array('justification'=>'center','width'=>50) )  ));
	
		$this->cezpdf->ezStream();
	}
	
	public function csv() {
		$displayed_data = $this->comments->get_by_company_id($this->company_id);
		
		$this->page_data['headers'] = array();
		$this->page_data['headers'][] = 'Time';
		$this->page_data['headers'][] = 'Location';
		$this->page_data['headers'][] = 'Code';
		$this->page_data['headers'][] = 'Code Description';
		$this->page_data['headers'][] = 'Comment';
		
		$this->page_data['headers'][] = 'Nature';
		$this->page_data['headers'][] = 'Source';
			
		$this->page_data['filename'] = "feedback-stats-".date("Ymdhis");
		
		$this->page_data['data'] = array();
		foreach($displayed_data as $row_key => $row_val)
		{
			foreach($this->page_data['headers'] as $i => $index)
			{
				if(strcasecmp($index, 'time') == 0)
				{
					$time = new DateTime($row_val['comment_time'], new DateTimeZone('America/Los_Angeles')); //PDT is the timezone in the server.
					if(strcasecmp($row_val['timezone'], "America/Los_Angeles") != 0)
						$time->setTimezone(new DateTimeZone($row_val['timezone']));
					if(strcasecmp($row_val['time_type'], "NO_TIME") == 0)
						$this->page_data['data'][$row_key][$i] = $time->format('m/d/y');
					elseif(strcasecmp($row_val['time_type'], "AM") == 0 )
						$this->page_data['data'][$row_key][$i] = $time->format('m/d/y \A\M');		
					elseif(strcasecmp($row_val['time_type'], "PM") == 0)
						$this->page_data['data'][$row_key][$i] = $time->format('m/d/y \P\M');		
					else
						$this->page_data['data'][$row_key][$i] = $time->format('m/d/y g:iA T');
				}
				elseif(strcasecmp($index, 'location') == 0)
					$this->page_data['data'][$row_key][$i] = $row_val['locname']; 
				elseif(strcasecmp($index, 'code') == 0)
					$this->page_data['data'][$row_key][$i] = $row_val['code'];
				elseif(strcasecmp($index, 'code description') == 0)
					$this->page_data['data'][$row_key][$i] = $row_val['code_desc'];  
				elseif(strcasecmp($index, 'comment') == 0)
					$this->page_data['data'][$row_key][$i] = $row_val['comment'];   
				elseif(strcasecmp($index, 'nature') == 0)
					$this->page_data['data'][$row_key][$i] = $row_val['nature'];   
				elseif(strcasecmp($index, 'source') == 0)
				{
					$this->page_data['data'][$row_key][$i] = $row_val['origin'];
					if(!empty($row_val['indirect_origin']))
					$this->page_data['data'][$row_key][$i] .= ' ('.strtolower($row_val['indirect_origin']).')';
				}
				elseif(strcasecmp($index, 'comment') == 0)
					$this->page_data['data'][$row_key][$i] = $row_val['comment'];  
			}
			$n = count($this->page_data['headers']);
			for($i = 0; $i < $n; $i++)
				if(empty($this->page_data['data'][$row_key][$i]))
					$this->page_data['data'][$row_key][$i] = 'No Data Available';
			ksort($this->page_data['data'][$row_key]);
			
		}
			
		$this->load->view('dash/csv_output', $this->page_data);

	}
}