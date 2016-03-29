<?php 
$user_data = $this->pages_data_model->get_user_data();
$user_store_data = $this->stores_model->get_user_stores_data($user_data['id']);
?>

<script type="text/javascript">
$(document).ready(function(){ $('.dashboard #feedback_list').dataTable({
"sPaginationType": "full_numbers",
"oLanguage": {"sSearch": "Keyword Search : "},
"aaSorting":[[7,'desc']],
"bAutoWidth": false,
"aoColumns": [{ "sType": "datetime-us", "asSorting": [ "desc", "asc" ]}, null, null, null,  {"bSortable": false}, null, {"bSortable": false}],
"iDisplayLength": -1, 
"aLengthMenu": [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]] 
}); });

$(document).ready(function(){ 
  $('#company').change(function(){
	  $('#store').attr('selectedIndex', 0);
		$('#store').val('0');
	});
	$('.dropdowns').change(function(){
	  $('#report_type').val("WEB");
		$('#filter').attr("target", "_parent");
	  if($('#period').val() == "custom"){
		  $('#customDateRange').css("display","block");
			$('#customMonthYear').css("display","none");
			return false;
		}
		if($('#period').val() == "bymonth"){
		  $('#customMonthYear').css("display","block");
			 $('#customDateRange').css("display","none");
			 return false;
		}
		  $('#filter').submit();
	});
	$('#customDateButton').click(function(){
	 $('#report_type').val("WEB");
	 $('#filter').submit();
	});
	$('#customMonthButton').click(function(){
	 $('#report_type').val("WEB");
	 $('#filter').submit();
	});
	
	$('#csvSubmitButton').click(function(){
	 $('#report_type').val("CSV");
	 $('#filter').attr("target", "_blank");
	 $('#filter').submit();
	 return false; 
	});
	$('#pdfSubmitButton').click(function(){
	 $('#report_type').val("PDF");
	 $('#filter').attr("target", "_blank");
	 $('#filter').submit();
	 return false;
	});
	
});
	
</script>

<div id="main" class="dashboard">
	<div id="menu">
		<ul>
			<li><a href="<?php echo site_url('dashboard/edit_user_info'); ?>">My Account</a></li>
			<li><a class="active" href="<?php echo site_url('dashboard/feedback_stats'); ?>">Customer Feedback</a></li>
			<!--
			<li><a href="<?php echo site_url('dashboard/edit_stores'); ?>">Locations</a></li>-->
			<li><a href="<?php echo site_url('dashboard'); ?>">Locations & Codes</a></li>
			<!--<li><a href="<?php echo site_url('feedback/receive/ttb'); ?>">Feedback to TTB</a></li>-->
		</ul>
	</div>
	<div id="menu-content">
		<h1>Customer Feedback</h1>
		<h2><?php echo $user_data['company_name']; ?></h2>
	<?php 
	/*if(empty($total_comments_number))
	{
		echo '<p>Your location(s) have no feedback from customers, inform your customers of the different ways they can use to leave comments.</p>';
	}
	else*/
	{
	?>
		<section class="summary">
			<form id="filter" name="filter" class="filter_feedback" method="post" action="<?php echo site_url('dashboard/feedback_stats'); ?>">
			<input type="hidden" id="report_type" name="report_type" value="WEB">
			<div style="position:relative;left:0px;top:0px;display:inline-block;border:none;width:400px;">
				<label>Summary for:</label>
				<select name="period" id="period" class="dropdowns">
						<?php if(isset($period)) $b = $period; else $b = '';?>
						<option value="0" <?php if(strcmp($b, '') == 0) echo 'selected="selected"'; ?>>All Dates</option>
						<option value="today" <?php if(strcmp($b, 'Last 24 Hours') == 0) echo 'selected="selected"'; ?>>Last 24 hours</option>
						<option value="weekly" <?php if(strcmp($b, 'Last 7 days') == 0) echo 'selected="selected"'; ?>>Last 7 days</option>
						<option value="monthly" <?php if(strcmp($b, 'Last 30 days') == 0) echo 'selected="selected"'; ?>>Last 30 days</option>
						<option value="yearly" <?php if(strcmp($b, 'Last 12 months') == 0) echo 'selected="selected"'; ?>>Last 12 months</option>
						<option value="bymonth" <?php if(strcmp($b, 'By Month') == 0) echo 'selected="selected"'; ?>>Select Month</option>
						<option value="custom" <?php if(strcmp($b, 'Custom Date Range') == 0) echo 'selected="selected"'; ?>>Custom Date</option>
				</select>
				<br>
				<?php
				if(strcmp($b, 'Custom Date Range') == 0){
				  $customDateRangeView = "block";
				} else {
				  $customDateRangeView = "none";
				}
				?>
				<div id="customDateRange" style="display:<?php echo $customDateRangeView;?>">
				<label>Date Range:</label>
				Start: <input type="text" name="start_date" style="width: 70px; font-size: 12px;" value="<?php echo $start_date; ?>" class="datepicker">
				End: <input type="text" name="end_date" style="width: 70px; font-size: 12px;" value="<?php echo $end_date; ?>" class="datepicker">
				<input type="button" name="customDateButton" id="customDateButton" value="GO" style="width: 40px; ">
				<script>
      	$(function() {
      		$( ".datepicker" ).datepicker();
      	});
      	</script>
      	<br />
				</div>
					<?php
				if(strcmp($b, 'By Month') == 0){
				  $customMonthYearView = "block";
				} else {
				  $customMonthYearView = "none";
				}
				?>
				<div id="customMonthYear" style="display:<?php echo $customMonthYearView;?>">
				<label>By Month:</label>
				<?php if(isset($by_month)) $b = $by_month; else $b = '';?>
				<select name="by_month" id="by_month" class="dropdowns" style="width: 100px;">
					<option value="01" <?php if(strcmp($b, '01') == 0) echo 'selected="selected"'; ?>>Jan</option>
					<option value="02" <?php if(strcmp($b, '02') == 0) echo 'selected="selected"'; ?>>Feb</option>
					<option value="03" <?php if(strcmp($b, '03') == 0) echo 'selected="selected"'; ?>>Mar</option>
					<option value="04" <?php if(strcmp($b, '04') == 0) echo 'selected="selected"'; ?>>Apr</option>
					<option value="05" <?php if(strcmp($b, '05') == 0) echo 'selected="selected"'; ?>>May</option>
					<option value="06" <?php if(strcmp($b, '06') == 0) echo 'selected="selected"'; ?>>Jun</option>
					<option value="07" <?php if(strcmp($b, '07') == 0) echo 'selected="selected"'; ?>>Jul</option>
					<option value="08" <?php if(strcmp($b, '08') == 0) echo 'selected="selected"'; ?>>Aug</option>
					<option value="09" <?php if(strcmp($b, '09') == 0) echo 'selected="selected"'; ?>>Sep</option>
					<option value="10" <?php if(strcmp($b, '10') == 0) echo 'selected="selected"'; ?>>Oct</option>
					<option value="11" <?php if(strcmp($b, '11') == 0) echo 'selected="selected"'; ?>>Nov</option>
					<option value="12" <?php if(strcmp($b, '12') == 0) echo 'selected="selected"'; ?>>Dec</option>
					
				</select>
				
					<?php 
							$currentYear = date("Y");
					?>		
				<?php if(!empty($by_year)) $b = $by_year; else $b = $currentYear;?>
				<select name="by_year" id="by_year" class="dropdowns" style="width: 100px;">
					<option value="<? echo $currentYear - 2;?>" <?php if(strcmp($b, $currentYear - 2) == 0) echo 'selected="selected"'; ?>><? echo $currentYear - 2;?></option>
					<option value="<? echo $currentYear - 1;?>" <?php if(strcmp($b, $currentYear - 1) == 0) echo 'selected="selected"'; ?>><? echo $currentYear - 1;?></option>
					<option value="<? echo $currentYear ;?>" <?php if(strcmp($b, $currentYear) == 0) echo 'selected="selected"'; ?>><? echo $currentYear ;?></option>
					<option value="<? echo $currentYear + 1;?>" <?php if(strcmp($b, $currentYear +1) == 0) echo 'selected="selected"'; ?>><? echo $currentYear + 1;?></option>
				</select>
				<input type="button" name="customMonthButton" id="customMonthButton" value="GO" style="width: 40px; ">
				<br />
				</div>
				
				<label>Select Company:</label>
				<select name="company" id="company" class="dropdowns">
					<option value="0" <?php echo set_select('store', '0'); ?>>All Companies</option>
					<?php
					$company_name = "";
					if(isset($company)) $company = $company; else $company = '';
					if(is_array($user_store_data)){
					   $current_company_id = 0;
  					 foreach ($user_store_data as $key=>$value)
  					 {
    						if($current_company_id <> $value['company_id']){ 
								 if($company == $value['company_id']){ $s = 'selected="selected"'; $company_name = $value['company_name']; } else { $s = ''; }
								 echo '<option value="'. $value['company_id'].'" '.$s.'>'.$value['company_name'].'</option>';
  							 $current_company_id = $value['company_id'];
  							}
  							
  					 }
					}
					?>
				</select>
				<br>
				<label>Select Location:</label>
				<select name="store" id="store" class="dropdowns">
					<option value="0" <?php echo set_select('store', '0'); ?>>All Locations</option>
					<?php
					if(isset($store)) $store = $store; else $store = '';
					if(is_array($user_store_data)){
					   $current_company_id = 0;
  					 foreach ($user_store_data as $key=>$value)
  					 {
						    $display_option = true;
						    if($company > 0){
								  $display_option = false;
									if($company == $value['company_id']){
									  $display_option = true;
								  }
								}	
								if($display_option == true){
      						if($current_company_id <> $value['company_id']){ 
      							 if($current_company_id > 0){ echo '</optgroup>'; }
      							 echo '<optgroup label="'.$value['company_name'].'">';
      							 $current_company_id = $value['company_id'];
    							}
    							if($store == $value['name']){ $s = 'selected="selected"';} else { $s = ''; }
    							echo '<option value="'. $value['ID'].'" '.$s.'>'.$value['name'].'</option>';
								}
  					 }
						  echo '</optgroup>'; 
					}
					?>
				</select><br />
				<label>Select Code:</label>
				<select name="code" id="code" class="dropdowns">
					<option value="0" <?php echo set_select('code', '0'); ?>>All Codes</option>
					<?php
				  if(isset($code)) $code = $code; else $code = '';
					if(is_array($user_store_data)){
					   $current_store_id = 0;
  					 $display_code = true;
						 foreach ($user_store_data as $key=>$value)
  					 {
						    if(trim($store) <> ""){ 
										$display_code = false;
										if ($value['name'] == $store){
										  $display_code = true;
										}
								}
								if ($display_code == true){		
      						if($current_store_id <> $value['ID']){ 
    							  if($current_store_id > 0){ echo '</optgroup>'; }
    							   echo '<optgroup label="'.$value['name'].'">';
    							   $current_store_id = $value['ID'];
      							 if(is_array($value['codes'])){
    								 				foreach ($value['codes'] as $key2=>$value2)
      											 {
    												 				if($code == $value2){ $s = 'selected="selected"';} else { $s = ''; }
      															echo '<option value="'. $key2.'" '.$s.'>'.$value2.'</option>';	
    												 }						 
    								 }
  								}
								}
  							
  					 }
						  echo '</optgroup>'; 
					}
					?>
				</select>
			</div>
			<table style="float:right;display:inline-block;border:solid #aaaaaa 2px;width:350px;margin-right:15px;background-color:#eeeeee;overflow:visible;z-index:1000;">
				<tr>
					<td style="overflow:visible;padding:5px;width:180px;">
						<img style="margin-bottom:0px;" src="<?php echo img_url('e-analyzer-logo3.png'); ?>" alt="Analyzer Results" width="180">
						<div style="margin-left:20px;">
							<label style="width:160px;padding-top:0px;">Select Results:</label><br />
							<select style="width:160px;" name="nature" id="nature" class="dropdowns">
								<?php if(isset($filter_nature)) $b = $filter_nature; else $b = '';?>
								<option value="0" <?php if(strcmp($b, '') == 0) echo 'selected="selected"'; ?>>All Results</option>
								<option value="1" <?php if(strcmp($b, 1) == 0) echo 'selected="selected"'; ?>>Positive</option>
								<option value="2" <?php if(strcmp($b, 2) == 0) echo 'selected="selected"'; ?>>Negative</option>
								<option value="3" <?php if(strcmp($b, 3) == 0) echo 'selected="selected"'; ?>>Neutral</option>
							</select>
						</div>
					</td>
					<td id="stats_box" style="overflow:visible;padding:10px;"></td>
				</tr>
			</table>
			</form>
		</section>
		<section>
		<div>
			<div style="float:left">
			<h2>
		  <?php 
			if(isset($period)){
				if ($period == "Custom Date Range"){
					echo $start_date . " thru ". $end_date . " - ";
				} else {
					echo $period.' - ';
				}
			}else{
			  echo 'All Time - ';
				$period=0; 
			}
			if(strlen($company_name) > 0) echo $company_name.' - '; else echo 'All Companies - '; 
			if(strlen($store) > 0) echo $store.' - '; else echo 'All Locations - '; 
			if(strlen($code) > 0) echo $code; else echo 'All Codes'; 
			if(isset($comments_number)) echo ' : '.$comments_number.'/'.$total_comments_number.' results.'; 
			echo '</h2>';
			echo '</div>';
			echo '<div style="float:right"><h2><a href="" id="csvSubmitButton" ><img src="'.img_url('print_csv.png').'"></a>  <a href="" id="pdfSubmitButton"><img src="'.img_url('print_PDF.png').'"></a></h2></div></div><div style="clear:both"></div>';
			
			
			
			
		if(empty($total_comments_number))	echo '<p>Your location(s) have no feedback yet.</p>';
		elseif(empty($comments_number)) echo '<p>No results found for the current criteria.</p>';
		else 
		{
		?>
			<table id="feedback_list">
			<thead>
				<tr>
					<th class="first" style="width:76px;">Time</th>
					<th class="second">Code</th>
					<!--<th class="third">Company</th>-->
					<th class="fourth">Location</th>
					<th class="fifth">Code<br/>Description</th>
					<th class="sixth">Comment</th>
					<th class="seventh">+/-</th>
					<th class="last">Source</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$j = 1;
				$posi = 0; $nega = 0; $neut = 0;
				foreach($comments as $comment)
				{
					$rowstyle = 'odd';
					if($j % 2) 
						$rowstyle = 'even';		
					$j++; 
					if($comment->nature == 1) 
					{
						$nature = "positive";
						$posi++;
					}
					elseif($comment->nature == 2) 
					{
						$nature = "negative";
						$nega++;
					}
					else 
					{
						$nature = "neutral";
						$neut++;
					}
					
					$source = "QR";
					if(!empty($comment->is_sms) && $comment->is_sms != 0)
					{
						$source = "SMS";
					}
					elseif(!empty($comment->origin) && strcmp(strtoupper($comment->origin), 'PC') == 0)
					{
						$source = "URL";
					}
					elseif(!empty($comment->origin) && strcmp(strtoupper($comment->origin), 'MAIL') == 0)
					{
						$source = "MAIL";
					}
					$time = preg_replace('/ /', '<br/>', $comment->time, 1);
					//$code_info = $this->pages_data_model->get_information_from_code($comment->code); 
				?>
					<tr class="<?php echo $rowstyle;?>">
						<td class="first" style="text-align:left;"><?php echo $time; ?></td>
						<td class="second"><?php echo  strtoupper($comment->code); ?></td>
						<!--<td class="third"><?php echo $comment->company_name; //echo $this->pages_data_model->get_store_name_from_code($comment->code); ?></td>-->
						<td class="fourth"><?php echo $comment->store_name; //echo $this->pages_data_model->get_store_name_from_code($comment->code); ?></td>
						<td class="fifth"><?php echo $comment->comment_type; ?></td>
						<td class="sixth comment">
							<?php 
								echo htmlentities($comment->comment); 
								$extra_data = "";
								
								if(!empty($comment->extra_data) || !empty($comment->sec_extra_data))
								{
									$company_data = $this->companies_model->get_company_by_user_id($comment->user_id);
									if(!empty($company_data['custom_field']) && strcmp(strtolower($company_data['custom_field']), 'default') != 0)
										$custom_field = unserialize($company_data['custom_field']);
									if(!empty($custom_field) && !empty($comment->extra_data))
										$extra_data = '<strong>'.$custom_field['custom_field_name'].':</strong> '.$comment->extra_data;
									if(!empty($custom_field['sec_custom_field']) && !empty($comment->sec_extra_data))
									{
										if(empty($extra_data))
										$extra_data = '<strong>'.$custom_field['sec_custom_field_name'].':</strong> '.$comment->sec_extra_data;
										else
											$extra_data = $extra_data.'<br/><strong>'.$custom_field['sec_custom_field_name'].':</strong> '.$comment->sec_extra_data;
									}
									if(!empty($extra_data))
										echo '<div class="custom_field">'.$extra_data.'</div>';
								}
							?>
						</td>
						<td class="seventh"><img src="<?php echo img_url('analyzer-bug-'.$nature.'.png').'" alt="'.$nature; ?>" width="40"><?php echo '<span class="hidden">'.$nature.'</span>'; ?></td>
						<td class="last"><?php 
							echo $source; 
							if($comment->code == 'JWA')
								$comment->indirect_source = 'postcards';
							if(!empty($comment->indirect_source))
								echo '<br/>('.strtolower($comment->indirect_source).')';
						?></td>
					</tr>
				<?php 
				} 
				?>
			</tbody>
		</table>
		<div class="pagination"><?php echo $pagination; ?></div>
		<?php
		$html_string = "<ul style='width:130px;'><li><span style='display:inline-block;width:85px;line-height:22px;'><img src='".img_url('analyzer-bug-positive.png')."' width='20' style='vertical-align:middle;margin-right:5px;'>Positive:</span> ".round(($posi*100)/$comments_number)."%</li><li><span style='display:inline-block;width:85px;line-height:22px;'><img src='".img_url('analyzer-bug-negative.png')."' width='20' style='vertical-align:middle;margin-right:5px;'>Negative:</span> ".round(($nega*100)/$comments_number)."%</li><li><span style='display:inline-block;width:85px;line-height:22px;'><img src='".img_url('analyzer-bug-neutral.png')."' width='20' style='vertical-align:middle;margin-right:5px;'>Neutral:</span> ".round(($neut*100)/$comments_number)."%</li></ul>";
		?>
		<script type="text/javascript">
		var htmlString = "<?php echo $html_string; ?>";
		$('#stats_box').html(htmlString);
		</script>
	<?php
		}
	}
	?>
		</section>
	</div>
	<p class="content_end">&nbsp;</p>
</div>