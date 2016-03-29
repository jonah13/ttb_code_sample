<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title><?php echo $company['name']; ?> - Leave feedback - Powered by Tell The Boss</title>
  <meta name="description" content="Tell The Boss" />
  <meta name="author" content="Tell The Boss" />
  <meta name="keywords" content="Tell The Boss" />
  <meta name="viewport" content="width=device-width, initial-scale=1"> 
	<meta http-equiv="cache-control" content="no-cache" />
  <link rel="shortcut icon" href="<?php echo img_url('icon.ico'); ?>"/>
  <link rel="stylesheet" href="<?php echo css_url('phone_design').'?v=1'; ?>"/>
  <script src="<?php echo js_url('jquery-1.7.2.min'); ?>"></script>
  <script src="<?php echo js_url('jquery.autosize-min'); ?>"></script>
  <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<script>
	$(document).ready(function()
	{
		$('textarea').autosize(); 
	});
	</script>
	<?php
	echo '<style type="text/css">';

	if(empty($company['s_body_bg1'])) $company['s_body_bg1'] = S_BODY_BG1;
	if(empty($company['s_body_bg2'])) $company['s_body_bg2'] = S_BODY_BG2;
	if(empty($company['s_header_bg1'])) $company['s_header_bg1'] = S_HEADER_BG1;
	if(empty($company['s_header_bg2'])) $company['s_header_bg2'] = S_HEADER_BG2;
	if(empty($company['s_header_fcolor'])) $company['s_header_fcolor'] = S_HEADER_FCOLOR;
	if(empty($company['s_header_ffamily'])) $company['s_header_ffamily'] = S_HEADER_FFAMILY;
	if(empty($company['s_header_fsize'])) $company['s_header_fsize'] = S_HEADER_FSIZE;
	if(empty($company['s_labels_fcolor'])) $company['s_labels_fcolor'] = S_LABELS_FCOLOR;
	if(empty($company['s_labels_ffamily'])) $company['s_labels_ffamily'] = S_LABELS_FFAMILY;
	if(empty($company['s_labels_fsize'])) $company['s_labels_fsize'] = S_LABELS_FSIZE;
	
	$padd = (44-$company['s_header_fsize'])/2;
	if(strcasecmp($company['s_body_bg_type'], 'picture') == 0 && !empty($company['s_body_bg_pic']))
		echo '#main{background:url('.img_url('uploads/'.$company['s_body_bg_pic']).') repeat;}';
	else
		echo '#main{
			background: '.$company['s_body_bg1'].';
			background: -moz-linear-gradient(top, '.$company['s_body_bg1'].' 0%, '.$company['s_body_bg2'].' 100%);
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,'.$company['s_body_bg1'].'), color-stop(100%,'.$company['s_body_bg2'].'));
			background: -webkit-linear-gradient(top, '.$company['s_body_bg1'].' 0%,'.$company['s_body_bg2'].' 100%);
			background: -o-linear-gradient(top, '.$company['s_body_bg1'].' 0%,'.$company['s_body_bg2'].' 100%);
			background: -ms-linear-gradient(top, '.$company['s_body_bg1'].' 0%,'.$company['s_body_bg2'].' 100%);
			background: linear-gradient(to bottom, '.$company['s_body_bg1'].' 0%,'.$company['s_body_bg2'].' 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\''.$company['s_body_bg1'].'\', endColorstr=\''.$company['s_body_bg2'].'\',GradientType=0 );}';
	if(strcasecmp($company['s_header_bg_type'], 'picture') == 0 && !empty($company['s_header_bg_pic']))
		echo '#header{background:url('.img_url('uploads/'.$company['s_header_bg_pic']).') repeat;}';
	else
		echo '#header{
			background-image:-webkit-gradient(linear,left top,left bottom,from('.$company['s_header_bg1'].'),to('.$company['s_header_bg2'].')); 
			background-image:-webkit-linear-gradient('.$company['s_header_bg1'].', '.$company['s_header_bg2'].'); 
			background-image:-moz-linear-gradient('.$company['s_header_bg1'].', '.$company['s_header_bg2'].'); 
			background-image:-ms-linear-gradient('.$company['s_header_bg1'].', '.$company['s_header_bg2'].'); 
			background-image:-o-linear-gradient('.$company['s_header_bg1'].', '.$company['s_header_bg2'].'); 
			background-image:linear-gradient('.$company['s_header_bg1'].', '.$company['s_header_bg2'].'); }';
	echo '#header h2{color:'.$company['s_header_fcolor'].'; font-family:"'.$company['s_header_ffamily'].'";  font-size:'.$company['s_header_fsize'].'px; padding:'.$padd.'px 5px;}';
	if(!empty($company['s_header_logo']))
		echo '#header h2{margin-left:70px;}';
	echo 'form label{color:'.$company['s_labels_fcolor'].'; font-family:"'.$company['s_labels_ffamily'].'"; font-size:'.$company['s_labels_fsize'].'px;}';
	echo 'footer p, footer p.copyright{color:'.$company['s_labels_fcolor'].';}';
	echo '</style>';

	?>
</head>
<body>
	<div id="main">
		<?php 
			if(!empty($company['s_header_logo']))
			{
				echo '<div id="company_logo"><img src="'.img_url('uploads/'.$company['s_header_logo']).'" alt="'.$company['name'].' Logo"/></div>';
			}
		?>
		<div id="header">
			<h2><?php if(!empty($_GET['dev']) && $_GET['dev'] == 1) echo 'dev - '; echo $company['qr_header']; ?></h2>
		</div>
		<div id="body">
			<section style="min-height:300px;">
			<p><?php echo validation_errors('<div class="error">', '</div>'); ?></p>
			<form class="feedback" method="post" action="<?php echo site_url('feedback/submit/'.$code); ?>">
		
				<?php 
				if(!empty($company['cf_asked_for']) && (strcmp($company['cf_asked_for'], 'both') == 0 || strcmp($company['cf_asked_for'], 'qr') == 0 ))
				{
					if(!empty($company['cf_qr_label'])) $cf_label = $company['cf_qr_label']; else $cf_label = 'Extra information:';
					if(!empty($company['cf_type']) && strcasecmp($company['cf_type'], 'email') === 0)  $cf_type = 'email'; else $cf_type = 'text';
					if(!empty($company['cf_required']) && $company['cf_required'] == 1) $cf_required = 'aria-required="true" required="required"'; else $cf_required = '';
					
					if(empty($company['cf_pos']) || strcmp($company['cf_pos'], 'before') == 0)
					{
						echo '<label for="custom_field">'.$cf_label.'</label>';
						echo '<input class="text" type="'.$cf_type.'" '.$cf_required.' name="custom_field" id="custom_field" />';
						echo '<br/>';
					}
				}
				
				if(!empty($company['cf2_asked_for']) && (strcmp($company['cf2_asked_for'], 'both') == 0 || strcmp($company['cf2_asked_for'], 'qr') == 0 ))
				{
					if(!empty($company['cf2_qr_label'])) $cf2_label = $company['cf2_qr_label']; else $cf2_label = 'Other extra information:';
					if(!empty($company['cf2_type']) && strcasecmp($company['cf2_type'], 'email') === 0) $cf2_type = 'email'; else $cf2_type = 'text';
					if(!empty($company['cf2_required']) && $company['cf2_required'] == 1) $cf2_required = 'aria-required="true" required="required"'; else $cf2_required = '';
					
					if(empty($company['cf2_pos']) || $company['cf2_pos'] == 'before')
					{
						echo '<label for="sec_custom_field">'.$cf2_label.'</label>';
						echo '<input class="text" type="'.$cf2_type.'" '.$cf2_required.' name="sec_custom_field" id="sec_custom_field" />';
						echo '<br/>';
					}
				}
				?>
				
				<label for="feedback"><?php echo $company['qr_comment_label']; ?></label>
				<textarea rows="4" name="feedback" id="feedback"  aria-required="true" required="required" data-minlength="2"></textarea>
				<br/>
				
				<?php
					if(!empty($company['cf_asked_for']) && (strcmp($company['cf_asked_for'], 'both') == 0 || strcmp($company['cf_asked_for'], 'qr') == 0 ) && !empty($company['cf_pos']) && $company['cf_pos'] == 'after')
					{
						echo '<label for="custom_field">'.$cf_label.'</label>';
						echo '<input class="text" type="'.$cf_type.'" '.$cf_required.' name="custom_field" id="custom_field" />';
						echo '<br/>';
					}
					if(!empty($company['cf2_asked_for']) && (strcmp($company['cf2_asked_for'], 'both') == 0 || strcmp($company['cf2_asked_for'], 'qr') == 0 ) && !empty($company['cf2_pos']) && $company['cf2_pos'] == 'after')
					{
						echo '<label for="sec_custom_field">'.$cf2_label.'</label>';
						echo '<input class="text" type="'.$cf2_type.'" '.$cf2_required.' name="sec_custom_field" id="sec_custom_field" />';
						echo '<br/>';
					}
				?>
				<input name="btn_send" id="btn_send" type="submit" value="Submit" />
				<input type="hidden" name="origin" id="origin" value="<?php echo $origin; ?>" />
				
			</form>
			</section>
		</div>
		<footer>
			<p>Powered by TellTheBoss.com <br/> <a href="<?php echo site_url('mobile_terms_conditions'); ?>">Terms &amp; Conditions</a>  | <a href="<?php echo site_url('privacy_policy'); ?>"> Privacy Policy</a></p>
			<p class="copyright">Copyright &copy; 2013, All Rights Reserved</p>
		</footer>
	</div>
</body>
</html>
