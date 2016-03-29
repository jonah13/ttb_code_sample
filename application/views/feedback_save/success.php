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
			<h2 style="font-size:24px;">
				<?php echo $company['qr_success_text']; ?>
			</h2>
			</section>
		</div>
		<footer>
			<p>Powered by TellTheBoss.com <br/> <a href="<?php echo site_url('mobile_terms_conditions'); ?>">Terms &amp; Conditions</a>  | <a href="<?php echo site_url('privacy_policy'); ?>"> Privacy Policy</a></p>
			<p class="copyright">Copyright &copy; 2013, All Rights Reserved</p>
		</footer>
	</div>
</body>
</html>
