<?php $store_name = $this->pages_data_model->get_store_name_from_code($code); ?> 
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>TellTheBoss - Thank you for your feedback!</title>
  <meta name="description" content="Tell The Boss" />
  <meta name="author" content="Tell The Boss" />
  <meta name="keywords" content="Tell The Boss lite" />
  <meta name = "viewport" content = "width = device-width">
  <link rel="shortcut icon" href="<?php echo img_url('icon.ico'); ?>"/>
  <link rel="stylesheet" href="<?php echo css_url('iPhoneUI'); ?>"/>
</head>
<body>
	<div id="body">
		<div id="main">
			<h2><?php echo $reply; ?></h2>
		</div>
	</div>
	<footer>
		<p class="copyright">Powered by TellTheBoss.com</p>
		<a href="<?php echo site_url('mobile_terms_conditions'); ?>">Terms &amp; Conditions</a>  | <a href="<?php echo site_url('privacy_policy'); ?>"> Privacy Policy</a>
		<p class="copyright">Copyright &copy; 2012, All Rights Reserved</p>
	</footer>
</body>

</html>