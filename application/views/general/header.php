<?php 
	$user_data = $this->pages_data_model->get_user_data();
	if(!empty($user_data['link1'])) $link1 = $user_data['link1'];
	if(!empty($user_data['link1address'])) $link1address = $user_data['link1address'];
	$link2 = $user_data['link2'];
	$link2address = $user_data['link2address'];
	if(empty($title)) $title = 'Welcome To Tell The Boss';
	if(empty($description)) $description = 'Tell the boss is a full service customer feedback company, we provide business owners the possibility to know what their customers think about their service in real time using revolutionary easy ways.';
	if(empty($current)) $current = 'home';
	header("Cache-Control: no-cache, must-revalidate");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title><?php echo $title; ?></title>
  <meta name="description" content="<?php echo $description; ?>" />
  <meta name="keywords" content="telltheboss,customer feedback,tell the boss,customers feedback,customer feedback service,restaurants customer feedback service,cell phone feedback,cell phone surveys,phone feedback,phone survey,shortcode feedback,qr code feedback" />
  <meta name="author" content="Tell The Boss" />
  <meta name="google-site-verification" content="jQFvbxm1mwol9XokTJbnoZLS0J9kku9F_n80GGSzg-M" />
  <meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
  <meta HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE" />
  <link rel="shortcut icon" href="<?php echo img_url('icon.ico'); ?>"/>
  <link rel="stylesheet" href="<?php echo css_url('main_design').'?v=2'; ?>"/>
  <script src="<?php echo js_url('jquery-1.7.2.min'); ?>"></script>
  <script src="<?php echo js_url('colorbox'); ?>"></script>
  <script src="<?php echo js_url('scripts').'?v=1.8'; ?>"></script>
  <link rel="stylesheet" href="<?php echo css_url('colorbox'); ?>"/>
	<?php if(isset($table_css)) echo $table_css;?>
	<?php if(isset($table_js)) echo $table_js;?>
  <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
	<?php if(!empty($_GET['dev']) && $_GET['dev'] == 1) echo '<span style="position:fixed;top:0;left:0">dev site</span>'; ?>
	<header>
		<div id="logo"><a href="<?php echo site_url(''); ?>"><img src="<?php echo img_url('logo.png'); ?>" alt="Tell The Boss home page" height="88" width="287" /></a></div>
		<?php 
			if($this->pages_data_model->is_logged_in())
			{
				if(strcmp($user_data['type'], 'CLIENT') == 0) 
				{ 
					echo '<p>Welcome <em><mark>'.$user_data['first_name'].' '.$user_data['last_name'].'</mark></em>, You\'re logged in as <a href="'.site_url('dashboard/feedback_stats').'">'.$user_data['username'].'</a>!</p>'; 
				}
				if(strcmp($user_data['type'], 'ADMIN') == 0) 
				{ 
					echo '<p>Welcome <em><mark>'.$user_data['first_name'].' '.$user_data['last_name'].'</mark></em>, You\'re logged in as <a href="'.site_url('admin_panel').'">'.$user_data['username'].' (Admin)</a>!</p>'; 
				}
			}
		?>
		<nav>
			<ul>
				<li><a <?php if(strcmp($current, $link2address) == 0) echo 'class="current"'; if(strcmp('login', $link2address) == 0) echo 'id="ajax" title="Client Login"'; ?> href="<?php echo site_url($link2address); ?>"><?php echo $link2;?></a></li>
				<?php 
				if(!empty($link1) && !empty($link1address))
				{
				?>
				<li><a <?php if(strcmp($current, $link1address) == 0) echo 'class="current"'; ?> href="<?php echo site_url($link1address); ?>"><?php echo $link1; ?></a></li>
				<?php
				}
				?>
				<li><a <?php if(strcmp($current, 'terms_privacy') == 0) echo 'class="current"'; ?> href="<?php echo site_url('mobile_terms_conditions'); ?>">Terms &amp; Privacy</a></li>
				<li><a <?php if(strcmp($current, 'contact') == 0) echo 'class="current"'; ?> href="<?php echo site_url('contact'); ?>">Contact Us</a></li>
				<li><a <?php if(strcmp($current, 'services') == 0) echo 'class="current"'; ?> href="<?php echo site_url('services'); ?>">Services</a></li>
				<li><a <?php if(strcmp($current, 'home') == 0) echo 'class="current"'; ?> href="<?php echo site_url(''); ?>">Home</a></li>
			</ul>
		</nav>
	</header>
	<div id="body">