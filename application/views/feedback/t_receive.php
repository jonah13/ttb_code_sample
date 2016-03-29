<?php 
$store_name = $this->pages_data_model->get_store_name_from_code($code); 
?> 
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title><?php echo $store_name; ?> - Leave feedback - Powered by Tell The Boss</title>
  <meta name="description" content="Tell The Boss" />
  <meta name="author" content="Tell The Boss" />
  <meta name="keywords" content="Tell The Boss lite" />
  <meta name="viewport" content="width=device-width, initial-scale=1"> 
	<meta http-equiv="cache-control" content="no-cache" />
  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.css" />
  <script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
 
  <link rel="shortcut icon" href="<?php echo img_url('icon.ico'); ?>"/>
  <link rel="stylesheet" href="<?php echo css_url('iPhoneUI'); ?>"/>
	<?php
	if(!empty($style) && !is_string($style))
	{
		echo '<style type="text/css">';
		if(empty($style['body_bg_1'])) $style['body_bg_1'] = '#F9F9F9';
		if(empty($style['body_bg_2'])) $style['body_bg_2'] = '#F1F1F1';
		if(empty($style['header_bg_1'])) $style['header_bg_1'] = '#3c3c3c';
		if(empty($style['header_bg_2'])) $style['header_bg_2'] = '#111';
		if(empty($style['header_font_color'])) $style['header_font_color'] = '#fff';
		if(empty($style['header_font_family'])) $style['header_font_family'] = 'Arial';
		if(empty($style['header_font_size'])) $style['header_font_size'] = '16';
		if(empty($style['label_font_color'])) $style['label_font_color'] = '#333';
		if(empty($style['label_font_family'])) $style['label_font_family'] = 'Arial';
		if(empty($style['label_font_size'])) $style['label_font_size'] = '16';
	
		echo '.ui-body-c, .ui-overlay-c{
			background-image:-webkit-gradient(linear,left top,left bottom,from('.$style['body_bg_1'].'),to('.$style['body_bg_2'].')); 
			background-image:-webkit-linear-gradient('.$style['body_bg_1'].', '.$style['body_bg_2'].'); 
			background-image:-moz-linear-gradient('.$style['body_bg_1'].', '.$style['body_bg_2'].'); 
			background-image:-ms-linear-gradient('.$style['body_bg_1'].', '.$style['body_bg_2'].'); 
			background-image:-o-linear-gradient('.$style['body_bg_1'].', '.$style['body_bg_2'].'); 
			background-image:linear-gradient('.$style['body_bg_1'].', '.$style['body_bg_2'].');}';
		echo '.ui-bar-a{
			background-image:-webkit-gradient(linear,left top,left bottom,from('.$style['header_bg_1'].'),to('.$style['header_bg_2'].')); 
			background-image:-webkit-linear-gradient('.$style['header_bg_1'].', '.$style['header_bg_2'].'); 
			background-image:-moz-linear-gradient('.$style['header_bg_1'].', '.$style['header_bg_2'].'); 
			background-image:-ms-linear-gradient('.$style['header_bg_1'].', '.$style['header_bg_2'].'); 
			background-image:-o-linear-gradient('.$style['header_bg_1'].', '.$style['header_bg_2'].'); 
			background-image:linear-gradient('.$style['header_bg_1'].', '.$style['header_bg_2'].'); 
			color:'.$style['header_font_color'].';}';
		echo '.ui-bar-a, .ui-bar-a input, .ui-bar-a select, .ui-bar-a textarea, .ui-bar-a button, .ui-header .ui-title, .ui-footer .ui-title  {font-family:"'.$style['header_font_family'].'";  font-size:'.$style['header_font_size'].'px;}';
		echo 'label.ui-input-text{color:'.$style['label_font_color'].'; font-family:"'.$style['label_font_family'].'"; font-size:'.$style['label_font_size'].'px;}';
		echo '</style>';
	}
	//CSS fix
	echo '<style type="text/css">';
		echo '.ui-header .ui-title, .ui-footer .ui-title {margin:0.7em 0px 0.8em 0px;}';
	echo '</style>';
	
	//text
	if(!empty($text['qr_head_text']) && is_array($text)) $head = $text['qr_head_text']; else $head = $store_name;
	if(!empty($text['qr_comment_label']) && is_array($text)) $label1 = $text['qr_comment_label']; else $label1 = 'Enter your comment:';
	?>
</head>
<body>
	<div id="body">
		<div id="main" data-role="page">
			<div data-role="header">
				<h2><?php if(!empty($_GET['dev']) && $_GET['dev'] == 1) echo 'dev - '; echo $head; ?></h2>
			</div>
			<section data-role="content">
				<p><?php echo form_error('feedback'); ?></p>
				<form class="feedback" method="post" action="<?php echo site_url('feedback/submit'); ?>">
					<label for="contact">Your email or phone number :</label>
					<input type="text" name="contact" id="contact" />
					<?php 
					if(!empty($custom_field) && (strcmp($custom_field['asked_for'], 'both') == 0 || strcmp($custom_field['asked_for'], 'qr') == 0 ))
					{
						if(!empty($custom_field['qr_text'])) $label2 = $custom_field['qr_text']; else $label2 = 'Extra information:';
						if(!empty($custom_field['custom_field_name']) && stripos($custom_field['custom_field_name'], 'email') !== false) $type = 'email'; else $type = 'text';
						if(!empty($custom_field['required']) && strcmp($custom_field['required'], 'true') == 0) $required = 'aria-required="true" required="required"'; else $required = '';
						
						if(empty($custom_field['position']) || $custom_field['position'] == 'before')
						{
							echo '<label for="custom_field">'.$label2.'</label>';
							echo '<input type="'.$type.'" '.$required.' name="custom_field" id="custom_field" />';
							echo '<br/>';
						}
					}
					?>
					
					<label for="feedback"><?php echo $label1; ?></label>
					<textarea rows="4" name="feedback" id="feedback"  aria-required="true" required="required" data-minlength="2"></textarea>
					
					<?php
						if(!empty($custom_field) && (strcmp($custom_field['asked_for'], 'both') == 0 || strcmp($custom_field['asked_for'], 'qr') == 0 ) && !empty($custom_field['position']) && $custom_field['position'] == 'after')
						{
							echo '<label for="custom_field">'.$label2.'</label>';
							echo '<input type="'.$type.'" '.$required.' name="custom_field" id="custom_field" />';
							echo '<br/>';
						}
					?>
					<input name="btn_send" id="btn_send" type="submit" value="Submit" />
					<input type="hidden" name="code" id="code" value="<?php echo $code; ?>" />
					<input type="hidden" name="origin" id="origin" value="<?php echo $origin; ?>" />
					
				</form>
			</section>
			<footer>
				<p>Powered by TellTheBoss.com <br/> <a href="<?php echo site_url('mobile_terms_conditions'); ?>">Terms &amp; Conditions</a>  | <a href="<?php echo site_url('privacy_policy'); ?>"> Privacy Policy</a></p>
				<p class="copyright">Copyright &copy; 2012, All Rights Reserved</p>
			</footer>
		</div>
	</div>
</body>

</html>