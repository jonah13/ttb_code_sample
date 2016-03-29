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
  <script src="<?php echo js_url('jquery-1.7.2.min'); ?>"></script>
  <script src="<?php echo js_url('colorbox'); ?>"></script>
  <script src="<?php echo js_url('jquery.miniColors.min'); ?>"></script>	
  <script src="<?php echo js_url('scripts').'?v=1.9'; ?>"></script>
  <script src="<?php echo js_url('datatable'); ?>"></script>
	<script type="text/javascript" src="<?php echo js_url('jquery.datepick.min'); ?>"></script>
  <link rel="stylesheet" href="<?php echo css_url('datatable'); ?>"/>
  <link rel="stylesheet" href="<?php echo css_url('colorbox').'?v=1.3'; ?>"/>
	<link rel="stylesheet" href="<?php echo css_url('jquery.miniColors'); ?>"/>
	<link rel="stylesheet" href="<?php echo css_url('jquery.datepick'); ?>" /> 
	<?php if(isset($table_css)) echo $table_css;?>
	<?php if(isset($table_js)) echo $table_js;?>
  <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  <script src="<?php echo js_url('chart.min'); ?>"></script>
  </head>
<body>
	<?php if(!empty($_GET['dev']) && $_GET['dev'] == 1) echo '<span style="position:fixed;top:0;left:0">dev site</span>'; ?>
	<header>
		<div id="logo"><a href="<?php echo site_url(''); ?>"><img src="<?php echo img_url('new_logo.png'); ?>" alt="Tell The Boss" height="88" width="287" /></a></div>
		
		<nav>
			<ul>
				<li><a <?php echo ( $sub_current == 'feedback_stats' ? 'class="active"' : ""); ?> href="<?php echo site_url('dashboard/feedback_stats'); ?>">Welcome <?php echo $userdata['username']; ?></a></li> | 
				<li><a <?php echo ( $sub_current == 'locations_codes' ? 'class="active"' : ""); ?> href="<?php echo site_url('dashboard/locations_codes'); ?>">My Account</a></li> | 
				<li><a <?php echo ( $sub_current == 'notifications_options' ? 'class="active"' : ""); ?> href="<?php echo site_url('dashboard/notifications_options'); ?>">Notification Settings</a></li> | 
				<li><a class="logout" href="<?php echo site_url('login/log_out'); ?>">Logout</a></li>
			</ul>
		</nav>
	</header>