<?php 
	$user_data = $this->pages_data_model->get_user_data();
	if(!empty($user_data['link1'])) $link1 = $user_data['link1'];
	if(!empty($user_data['link1address'])) $link1address = $user_data['link1address'];
	$link2 = $user_data['link2'];
	$link2address = $user_data['link2address'];
	if(!(isset($title) && $title != NULL)) $title = 'Welcome To TellTheBoss';
	if(!(isset($current) && $current != NULL)) $current = 'home';
	header("Cache-Control: no-cache, must-revalidate");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title><?php echo $title; ?></title>
  <meta name="description" content="Tell The Boss" />
  <meta name="author" content="Tell The Boss" />
  <meta name="keywords" content="Tell The Boss" />
  <meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
  <meta HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE" />
  <meta NAME="ROBOTS" CONTENT="INDEX,NOFOLLOW" /> 
  <link rel="shortcut icon" href="<?php echo img_url('icon.ico'); ?>"/>
  <link rel="stylesheet" href="<?php echo css_url('dashboard_design').'?v=1'; ?>"/>
  <script src="<?php echo js_url('jquery-1.10.2.min'); ?>"></script>
  <script src="<?php echo js_url('jquery.miniColors.min'); ?>"></script>	
  <script src="<?php echo js_url('scripts').'?v=1.9'; ?>"></script>
  <script src="<?php echo js_url('datatable'); ?>"></script>
	<script src="<?php echo js_url('jquery.datepick.min'); ?>"></script>
  <link rel="stylesheet" href="<?php echo css_url('datatable_new'); ?>"/>
  <link rel="stylesheet" href="<?php echo css_url('colorbox').'?v=1.3'; ?>"/>
	<link rel="stylesheet" href="<?php echo css_url('jquery.miniColors'); ?>"/>
	<link rel="stylesheet" href="<?php echo css_url('jquery.datepick'); ?>" />
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="<?php echo css_url('bootstrap.min'); ?>">

	<!-- Optional theme -->
	<link rel="stylesheet" href="<?php echo css_url('bootstrap-theme.min'); ?>">

	<!-- Latest compiled and minified JavaScript -->
	<script src="<?php echo js_url('bootstrap.min'); ?>"></script>
	
	<script src="<?php echo js_url('bootstrap-select'); ?>"></script> 
	<link rel="stylesheet" href="<?php echo css_url('bootstrap-select.min'); ?>" /> 
	
  <link rel="stylesheet" type="text/css" media="all" href="<?php echo css_url('daterangepicker-bs3'); ?>" />
	<script type="text/javascript" src="<?php echo js_url('moment.min'); ?>"></script>
  <script type="text/javascript" src="<?php echo js_url('daterangepicker'); ?>"></script>
	
	<?php if(isset($table_css)) echo $table_css;?>
	<?php if(isset($table_js)) echo $table_js;?>
  <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  <script src="<?php echo js_url('chart.min_new'); ?>"></script>
  </head>
<body>
	<?php if(!empty($_GET['dev']) && $_GET['dev'] == 1) echo '<span style="position:fixed;top:0;left:0">dev site</span>'; ?>
	<header style="height:70px;">
		<div id="logo"><a href="<?php echo site_url(''); ?>"><img src="<?php echo img_url('new_logo.png'); ?>" alt="Tell The Boss" width="282" /></a></div>
		
		<nav>
			<ul>
				<li><a <?php echo ( $sub_current == 'feedback_stats' ? 'class="active"' : ""); ?> href="<?php echo site_url('dashboard/feedback_stats'); ?>">Welcome <?php echo $user_data['username']; ?></a></li> <strong style="color:#666;">|</strong> 
				<li><a <?php echo ( $sub_current == 'locations_codes' ? 'class="active"' : ""); ?> href="<?php echo site_url('dashboard/locations_codes'); ?>">My Account</a></li> <strong style="color:#666;">|</strong> 
				<li><a <?php echo ( $sub_current == 'notifications_options' ? 'class="active"' : ""); ?> href="<?php echo site_url('dashboard/notifications_options'); ?>">Notification Settings</a></li>
				<li><a class="logout" href="<?php echo site_url('login/log_out'); ?>">Logout</a></li>
			</ul>
		</nav>
	</header>
	<div id="body">
		<div id="main" class="dashboard">
			<div id="top_section" class="row">
				<div class="col-md-7">
					<h1 style="margin-bottom:10px;">Feedback Summary for <span class="special"><?php echo $username; ?></span></h1>
					
					<h3>Filter comments by</h3>
					<form  id="filter" name="filter" class="filter_feedback" method="get" action="<?php echo site_url('dashboard/feedback_stats'); ?>">
						<input type="hidden" name="report_type" id="report_type" value="WEB"/>
						
						<input type="hidden" name="from" id="from" value="<?php if(!empty($_GET['from'])) echo $_GET['from']; else echo '0'; ?>"/>
						<input type="hidden" name="to" id="to" value="<?php if(!empty($_GET['to'])) echo $_GET['to']; else echo '0'; ?>"/>
					
						<select name="location" id="location" class="selectpicker" data-width="94px"  data-style="btn-primary">
							<option value="0" <?php echo set_select('location', '0'); ?>>Location</option>
							<?php	
							if(!empty($cur_location)) $b = $cur_location; else $b = '';
							$opt_groups = array();
							foreach($all_locations as $l)
							{
								if(empty($opt_groups[$all_companies[$l['company_id']]['name']]))
									$opt_groups[$all_companies[$l['company_id']]['name']] = '<optgroup label="'.$all_companies[$l['company_id']]['name'].'">';
								if(strcmp($b, $l['ID']) == 0) $s = 'selected="selected"'; else $s = '';
								$opt_groups[$all_companies[$l['company_id']]['name']] = $opt_groups[$all_companies[$l['company_id']]['name']].'<option value="'.$l['ID'].'" '.$s.'>'.$l['name'].'</option>';
							}
							ksort($opt_groups);
							foreach($opt_groups as $og)
								echo $og;
							?>
						</select>
						
						<select name="code" id="code" class="selectpicker"  data-width="74px"  data-style="btn-primary">
							<option value="0" <?php echo set_select('code', '0'); ?>>Code</option>
							<?php	
							if(!empty($cur_code)) $b = $cur_code; else $b = '';
							$opt_groups = array();
							foreach($codes as $c)
							{
								if(empty($opt_groups[$c['location_id']]))
									$opt_groups[$c['location_id']] = '<optgroup label="'.$all_locations[$c['location_id']]['name'].'">';
								if(strcmp($b, $c['ID']) == 0) $s = 'selected="selected"'; else $s = '';
								$opt_groups[$c['location_id']] = $opt_groups[$c['location_id']].'<option value="'.$c['ID'].'" '.$s.'>'.$c['code'].'</option>';
							}
							$comp_opt_groups = array();
							foreach($opt_groups as $loc_id => $og)
							{
								if(empty($comp_opt_groups[$all_companies[$all_locations[$loc_id]['company_id']]['name']]))
									$comp_opt_groups[$all_companies[$all_locations[$loc_id]['company_id']]['name']] = '<optgroup label="'.$all_companies[$all_locations[$loc_id]['company_id']]['name'].'">';
								$comp_opt_groups[$all_companies[$all_locations[$loc_id]['company_id']]['name']] .= $og;
							}
							ksort($comp_opt_groups);
							foreach($comp_opt_groups as $og)
								echo $og;
							?>
						</select>
						
						<button type="button" id="reportrange" data-width="106px" class="btn btn-primary" style="margin-top:-10px;">Date Range <b class="caret"></b></button>
						<input name="period" type="hidden"  data-style="btn-primary" />
							
						<select name="nature" id="nature" class="selectpicker" data-width="108px"  data-style="btn-primary">
							<?php if(empty($cur_nature)) $cur_nature = '0'; ?>
							<option value="0" <?php echo set_select('nature', '0', ($cur_nature == '0')?TRUE:FALSE); ?>>Experience</option>
							<option value="negative" <?php echo set_select('nature', 'negative', ($cur_nature == 'negative')?TRUE:FALSE); ?>>Negative</option>
							<option value="positive" <?php echo set_select('nature', 'positive', ($cur_nature == 'positive')?TRUE:FALSE); ?>>Positive</option>
							<option value="neutral" <?php echo set_select('nature', 'neutral', ($cur_nature == 'neutral')?TRUE:FALSE); ?>>Neutral</option>
							<option value="not_negative" <?php echo set_select('nature', 'not_negative', ($cur_nature == 'not_negative')?TRUE:FALSE); ?>>Not Negative</option>
							<option value="not_positive" <?php echo set_select('nature', 'not_positive', ($cur_nature == 'not_positive')?TRUE:FALSE); ?>>Not Positive</option>
							<option value="not_neutral" <?php echo set_select('nature', 'not_neutral', ($cur_nature == 'not_neutral')?TRUE:FALSE); ?>>Not Neutral</option>
						</select>
								
						<select name="source" id="source" class="selectpicker" data-width="84px"  data-style="btn-primary"> 
							<?php if(empty($cur_source)) $cur_source = '0'; ?>
							<option value="0" <?php echo set_select('source', '0', ($cur_source == '0')?TRUE:FALSE); ?>>Source</option>
							<option value="QR" <?php echo set_select('source', 'QR', ($cur_source == 'QR')?TRUE:FALSE); ?>>QR</option>
							<option value="URL" <?php echo set_select('source', 'URL', ($cur_source == 'URL')?TRUE:FALSE); ?>>URL</option>
							<option value="SMS" <?php echo set_select('source', 'SMS', ($cur_source == 'SMS')?TRUE:FALSE); ?>>SMS</option>
							<option value="MAIL" <?php echo set_select('source', 'MAIL', ($cur_source == 'MAIL')?TRUE:FALSE); ?>>MAIL</option>
						</select>
						
						<input id="search_temp" type="text" class="form-control" placeholder="Search ..." style="width:130px; display:inline-block; margin-top:-10px"; >
					</form>
				</div>			
				
				<div class="col-md-5">
					<div class="row">
						<div class="col-md-12"><img src="<?php echo img_url('eanalyzer_logo.png'); ?>" alt="eAnalyzer" height="40"/></div>
						<div class="col-md-6">
							<div class="row">
								<h3 class="col-md-12">Experience</h3>
								<div class="col-md-6"><canvas id="nature_chart" width="120" height="120"></canvas></div>
								<ul class="col-md-6">
									<?php if(empty($stats['comments_number'])) $stats['comments_number'] = 1; ?>
									<li><span class="glyphicon glyphicon-comment" style="color:#35A907;"></span> <span style="font-size:12px"> Positive <?php echo round(($stats['pos_comments_number']*100)/$stats['comments_number']); ?>%</span></li>
									<li><span class="glyphicon glyphicon-comment" style="color:#BF0115;"></span> <span style="font-size:12px"> Negative <?php echo round(($stats['neg_comments_number']*100)/$stats['comments_number']); ?>%</span></li>
									<li><span class="glyphicon glyphicon-comment" style="color:#B7B7B7;"></span> <span style="font-size:12px">Neutral <?php echo round(($stats['neut_comments_number']*100)/$stats['comments_number']) ?>%</span></li>
								</ul>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row">
								<h3 class="col-md-12">Source</h3>
								<div class="col-md-6"><canvas id="source_chart" width="120" height="120"></canvas></div>
								<ul class="col-md-6 col-md-offset-0">
									<li><span class="glyphicon glyphicon-phone" style="color:#1B7396;"></span>  <span style="font-size:12px">SMS <?php echo round(($stats['sms_comments_number']*100)/$stats['comments_number']); ?>%</span></li>
									<li><span class="glyphicon glyphicon-qrcode" style="color:#002A4A;"></span> <span style="font-size:12px"> QR Code <?php echo round(($stats['qr_comments_number']*100)/$stats['comments_number']); ?>%</span></li>
									<li><span class="glyphicon glyphicon-globe" style="color:#D64700;"></span>  <span style="font-size:12px">URL <?php echo round(($stats['url_comments_number']*100)/$stats['comments_number']); ?>%</span></li>
									<li><span class="glyphicon glyphicon-envelope" style="color:#FF9311;"></span> <span style="font-size:12px"> MAIL <?php echo round(($stats['mail_comments_number']*100)/$stats['comments_number']); ?>%</span></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div id="main_section" class="row">
				<h1 class="col-md-7"><span class="glyphicon glyphicon-comment" style="color:#078ABB;"></span> Customer Comments</h1>
				<div class="col-md-5">
					<p style="float:right; margin-top:20px;">
						<a href="#" id="csvSubmitButton" class="black_btn"><span class="glyphicon glyphicon-download" style="color:#fff;"></span> Download CSV</a>  
						<a href="#" id="pdfSubmitButton" class="black_btn"><span class="glyphicon glyphicon-print" style="color:#fff;"></span> Print PDF</a>
					</p>
				</div>
				<br style="clear:both;"/>
				<div class="col-md-12">
					<?php
					if($total_comments_number == 0)
						echo '<br/><p style="padding:10px;">There is no comments for you yet, or you don\'t have any codes assigned to you. Contact a TellTheBoss.com Admins for support.</p><br/>';
					else 
					{
						echo 
						'<div id="comments_table" class="section">
								<table class="manage" style="">
									<thead>
										<tr>
											<th class="first time" style="width:140px;">Date/Time</th>
											<th class="location" style="width:150px;">Location</th>
											<th class="type" style="width:150px;">Type</th>
											<th class="comment">Comment</th>
											<th class="experience" style="width:100px;">Experience</th>
											<th class="last source" style="width:100px;">Source</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="9" class="dataTables_empty">Loading data from server</td>
										</tr> 
									</tbody>
								</table>
							</div>';
					}
					?>
				</div>
			</div>
			
		</div><!-- #main -->
	</div><!-- #body -->

	<footer class="row">
		<p class="copyright col-md-7"><span class="glyphicon glyphicon-comment" style="color:#078ABB;"></span> Copyright &copy; 2013 Tell The Boss, Inc. All Rights Reserved.</p>
		<div class="col-md-5"><p class="rfloat"><a href="<?php echo site_url('mobile_terms_conditions'); ?>">Terms &amp; Conditions</a>  | <a href="<?php echo site_url('privacy_policy'); ?>"> Privacy Policy</a>  | <a href="<?php echo site_url('contact'); ?>"> Contact Us</a></p></div>
	</footer>
</body>

</html>
	
<script type="text/javascript">

$(document).ready(function(){
	
	//chart code
	var data = [
		{
			value: <?php echo $stats['pos_comments_number']; ?>,
			color:"#35A907"
		},
		{
			value : <?php echo $stats['neg_comments_number']; ?>,
			color : "#BF0115"
		},
		{
			value : <?php echo $stats['neut_comments_number']; ?>,
			color : "#B7B7B7"
		}			
	];
	
	var data_2 = [
		{
			value: <?php echo $stats['sms_comments_number']; ?>,
			color:"#1B7396"
		},
		{
			value : <?php echo $stats['qr_comments_number']; ?>,
			color : "#002A4A"
		},
		{
			value : <?php echo $stats['url_comments_number']; ?>,
			color : "#D64700"
		},
		{
			value : <?php echo $stats['mail_comments_number']; ?>,
			color : "#FF9311"
		}			
	];
	
	var options = { animationSteps: 100, segmentStrokeWidth :1 };

	var ctx = $("#nature_chart").get(0).getContext("2d");
	var nature_chart = new Chart(ctx).Pie(data, options);
	var ctx2 = $("#source_chart").get(0).getContext("2d");
	var source_chart = new Chart(ctx2).Pie(data_2, options);
	 
	 $('#reportrange').daterangepicker(
	 {
		
			ranges: {
				 'Today': [moment(), moment()],
				 'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
				 'Last 7 Days': [moment().subtract('days', 6), moment()],
				 'Last 30 Days': [moment().subtract('days', 29), moment()],
				 'This Month': [moment().startOf('month'), moment().endOf('month')],
				 'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
			},
			opens: 'right',
			buttonClasses: ['btn btn-default'],
			applyClass: 'btn-small btn-primary',
			startDate: get_from_date(),
      endDate: get_to_date(),
			buttonClasses: ['btn btn-default'],
			applyClass: 'btn-small btn-primary',
			cancelClass: 'btn-small',
			format: 'MM/DD/YYYY',
			separator: ' to ',
			locale: {
					applyLabel: 'Submit',
					fromLabel: 'From',
					toLabel: 'To',
					customRangeLabel: 'Custom Range',
					daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
					monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
					firstDay: 1
			}
	 },
	 function(start, end) {
		$('input#from').val(start.format('YYYY-MM-DD'));
		$('input#to').val(end.format('YYYY-MM-DD'));
		$('#filter').submit();
		
		if(start.format('YYYY-MM-DD') != '2010-01-01' && end.format('MM/DD/YYYY') != moment())
			$('button#reportrange').removeClass('btn-primary').addClass('btn-info');
		else
			$('button#reportrange').removeClass('btn-info').addClass('btn-primary');
	 });
		//Set the initial state of the picker 
		if($('input#from').val() != '2010-01-01' && $('input#from').val() != '0' && $('input#to').val() != '0')
			$('button#reportrange').removeClass('btn-primary').addClass('btn-info');
		else
			$('button#reportrange').removeClass('btn-info').addClass('btn-primary');
	
	$('.selectpicker').selectpicker();
	$('.selectpicker').each(function(){
		if($(this).val() != 0)
			$(this).selectpicker('setStyle', 'btn-info');
		else
			$(this).selectpicker('setStyle', 'btn-primary');
	});
	
	$('.selectpicker').change(function(){
		if($(this).attr("name") == "location")
			$("select#code").val(0);
		else if($(this).attr("name") == "code")
			$("select#location").val(0);
			
		if($(this).val() != 0)
			$(this).selectpicker('setStyle', 'btn-info');
		else
			$(this).selectpicker('setStyle', 'btn-primary');
			
		$('#report_type').val("WEB");
		$('#filter').attr("target", "_parent");
		$('#filter').submit();
	});
	
	
	
	$('input#search_temp').on('keyup', function(){
		$('#DataTables_Table_0_filter input').val($(this).val()).keyup();
	});

	
	//datatable of comments
	$('#comments_table table').dataTable({
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "<?php echo $cur_link; ?>",
		"sPaginationType": "full_numbers",
		"oLanguage": {"sSearch": "Search"},
		"aaSorting":[[0,'desc']],
		"aoColumns": [ null, null, null, null, null, null ],
		"iDisplayLength": 20, 
		"aLengthMenu": [[20, 50, 100, 200, -1], [20, 50, 100, 200, "All"]],
		"fnServerData": function ( sSource, aoData, fnCallback ) 
		{
			$.ajax( {
					"dataType": 'json', 
					"type": "POST", 
					"url": sSource, 
					"data": aoData, 
					"success": fnCallback
			} );
    }
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
	
	//reply button script
	$('a.reply_btn').on('click', function(){
		$('a.reply_btn').popover();
		return false;
	});
	
});

function my_popover(e)
{
	$(e).popover();
}

function get_from_date()
{
	var from = $('input#from').val();
	if(from == '0')
		return moment().subtract('days', 29);
	else
	{
		var d = new Date(from);
		return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear();
	}
}
function get_to_date()
{
	var to = $('input#to').val();
	if(to == '0')
		return moment();
	else
	{
		var d = new Date(to);
		return (d.getMonth()+1)+'/'+d.getDate()+'/'+d.getFullYear();
	}
}

</script>