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
  <link rel="stylesheet" href="<?php echo css_url('admin_panel_design').'?v=1'; ?>"/>
  <script src="<?php echo js_url('jquery-1.7.2.min'); ?>"></script>
  <script src="<?php echo js_url('jquery-ui-1.8.19.custom.min'); ?>"></script>
  <script src="<?php echo js_url('jquery.form.wizard-min'); ?>"></script>
  <script src="<?php echo js_url('colorbox'); ?>"></script>
  <script src="<?php echo js_url('jquery.miniColors.min'); ?>"></script>	
  <script src="<?php echo js_url('scripts').'?v=1.9'; ?>"></script>
  <link rel="stylesheet" href="<?php echo css_url('colorbox'); ?>"/>
	<link rel="stylesheet" href="<?php echo css_url('jquery.miniColors'); ?>"/>
  <link rel="stylesheet" href="<?php echo css_url('smoothness/jquery-ui-1.8.19.custom'); ?>"/>
	<?php if(isset($table_css)) echo $table_css;?>
	<?php if(isset($table_js)) echo $table_js;?>
  <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
	<?php if(!empty($_GET['dev']) && $_GET['dev'] == 1) echo '<span style="position:fixed;top:0;left:0">dev site</span>'; ?>
	<header>
		<div id="logo"><a href="<?php echo site_url(''); ?>"><img src="<?php echo img_url('logo.png'); ?>" alt="Tell The Boss" height="88" width="287" /></a></div>
		
		<nav>
			<ul>
				<li><a <?php if(strcmp($current, 'home') == 0) echo 'class="current"'; ?> href="<?php echo site_url(''); ?>">Home</a></li>
				<li><a <?php if(strcmp($current, 'services') == 0) echo 'class="current"'; ?> href="<?php echo site_url('services'); ?>">Services</a></li>
				<li><a <?php if(strcmp($current, 'contact') == 0) echo 'class="current"'; ?> href="<?php echo site_url('contact'); ?>">Contact Us</a></li>
				<li><a <?php if(strcmp($current, 'terms_privacy') == 0) echo 'class="current"'; ?> href="<?php echo site_url('mobile_terms_conditions'); ?>">Terms &amp; Privacy</a></li>
				<?php 
				if(!empty($link1) && !empty($link1address))
				{
				?>
				<li><a <?php if(strcmp($current, $link1address) == 0) echo 'class="current"'; ?> href="<?php echo site_url($link1address); ?>"><?php echo $link1; ?></a></li>
				<?php
				}
				?>
				<li><a <?php if(strcmp($current, $link2address) == 0) echo 'class="current"'; if(strcmp('login', $link2address) == 0) echo 'id="ajax" title="Client Login"'; ?> href="<?php echo site_url($link2address); ?>"><?php echo $link2;?></a></li>
				
			</ul>
		</nav>
	</header>
	<div id="body">
		<div id="main" class="admin_panel">
			<div id="current_page">
				<p class="current_link"><a class="first" href="">Admin Panel</a><a class="" href="">Manage Clients</a><a class="last" href="">Add a New Client</a> </p>
			</div>
			<?php 
			$current_page = 'admin_panel';
			$username = $user_data['username'];
			?>
			<div id="menu">
			<ul>
				<li><a href="<?php echo site_url('admin_panel'); ?>" class="<?php echo ( $current_page == "admin_panel" ? "active" : ""); ?>">Home</a></li>
				<li><a href="<?php echo site_url('admin_panel/edit_my_info'); ?>" class="<?php echo ( $current_page == "edit_my_account" ? "active" : ""); ?>">Manage Users</a></li>
				<li><a href="<?php echo site_url('admin_panel/add_users'); ?>" class="<?php echo ( $current_page == "add_users" ? "active" : ""); ?>">Manage Companies</a></li>
				<li><a href="<?php echo site_url('admin_panel/add_client_wizard'); ?>" class="<?php echo ( $current_page == "add_client" ? "active" : ""); ?>">Feedback Stats</a></li>
			</ul>
			</div>
			<div id="menu-content">
				<div id="content_wrapper">
					<h1>Welcome Back <span class="special"><?php echo $user_data['username']; ?></span>!</h1>
					<p>Welcome Administrator, Your Admin panel is where you can add, edit and delete clients and locations, review all the feedback the clients get and see site stats.</p>
					<h2>Your personal information</h2>
					<section><p>
						<span class="infot">User Name:</span> <?php echo $user_data['username']; ?><br />
						<span class="infot">Full Name:</span> <?php echo $user_data['first_name'].' '.$user_data['last_name']; ?><br />
						<span class="infot">Email:</span> <a href="mailto:<?php echo $user_data['email']; ?>"><?php echo $user_data['email']; ?></a><br />
						<span class="infot">Phone number:</span> <?php echo $user_data['phone']; ?><br />
						<span class="infot">You signed up to <a href="<?php echo site_url(''); ?>">TellTheBoss.com</a> on:</span> <?php echo $user_data['signup_date']; ?><br />
					</p></section>
					<h2>Current Site Stats</h2>
					<section><p>
						<span class="infot">Number of clients:</span> <br />
						<span class="infot">Number of Admins:</span><br />
						<span class="infot">Number of locations:</span> </a><br />
						<span class="infot">Number of codes:</span> <br />
						<span class="infot">Number of feedback comments:</span> <br />
						<span class="infot">Number of incoming SMS messages:</span> <br />
						<span class="infot">Number of outgoing SMS messages:</span> <br />
					</p></section>
				</div>
			</div>
		</div>
	</div><!-- #body -->
	<footer>
		<p class="footer_links"><a href="<?php echo site_url('mobile_terms_conditions'); ?>">Terms &amp; Conditions</a>  | <a href="<?php echo site_url('privacy_policy'); ?>"> Privacy Policy</a>  | <a href="http://www.telltheboss.com/sitemap.html"> Sitemap</a></p>
		<p class="copyright">Copyright &copy; 2013 by Tell The Boss, Inc. All Rights Reserved</p>
	</footer>
</body>

</html>