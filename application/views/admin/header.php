<?php 
	$user_data = $this->pages_data_model->get_user_data();
/*
	if(!empty($user_data['link1'])) $link1 = $user_data['link1'];
	if(!empty($user_data['link1address'])) $link1address = $user_data['link1address'];
	$link2 = $user_data['link2'];
	$link2address = $user_data['link2address'];
	if(!(isset($title) && $title != NULL)) $title = 'Welcome To TellTheBoss';
	if(!(isset($current) && $current != NULL)) $current = 'home';
	header("Cache-Control: no-cache, must-revalidate");
*/
?>
<!DOCTYPE html>
<html class="no-js">

<head>
  <meta charset="utf-8" />

  </head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo empty($title) ? 'Tell The Boss' : $title; ?></title>
	<meta name="description" content="Tell The Boss" />
	<meta name="author" content="Tell The Boss" />
	<meta name="keywords" content="Tell The Boss" />
	<meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
	<meta HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE" />
	<meta NAME="ROBOTS" CONTENT="INDEX,NOFOLLOW" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?php echo css_url('bootstrap.min'); ?>">
    <style>
        body {
                padding-top: 70px;
                padding-bottom: 20px;
            }
    </style>
    <link rel="stylesheet" href="<?php echo css_url('main'); ?>">
	<link rel="stylesheet" href="<?php echo css_url('jquery.dataTables'); ?>"/>
	<link rel="stylesheet" href="<?php echo css_url('bootstrap.dataTables'); ?>"/>
	<link rel="stylesheet" href="<?php echo css_url('jquery.nestable'); ?>"/>
	<link rel="stylesheet" href="<?php echo css_url('font-awesome.min'); ?>"/>
	<link rel="stylesheet" href="<?php echo css_url('bootstrap-editable'); ?>"/>
	<link rel="stylesheet" href="<?php echo css_url('daterangepicker-bs3'); ?>"/>
    <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <script>window.html5 || document.write('<script src="<?php echo js_url('html5shiv'); ?>"><\/script>')</script>
        <![endif]-->
    <script src="<?php echo js_url('jquery-1.10.2.min'); ?>"></script>
    <script src="<?php echo js_url('bootstrap.min'); ?>"></script>
    <script src="<?php echo js_url('main'); ?>"></script>
	<script src="<?php echo js_url('jquery.dataTables.min'); ?>"></script>
	<script src="<?php echo js_url('dataTables.bootstrap'); ?>"></script>
	<script src="<?php echo js_url('jquery.nestable'); ?>"></script>
	<script src="<?php echo js_url('chart.min_new'); ?>"></script>
	<script src="<?php echo js_url('bootstrap-editable.min'); ?>"></script>
	<script src="<?php echo js_url('moment.min'); ?>"></script>
	<script src="<?php echo js_url('daterangepicker'); ?>"></script>

</head>

<body>
    <div id="wrap">
<?php if (strcmp($this->session->userdata('type'), 'ADMIN') == 0 || strcmp($this->session->userdata('type'), 'SUPER') == 0) { ?>
        <div class="navbar navbar-inverse navbar-fixed-top">
<?php } else { ?>
        <div class="navbar navbar-default navbar-fixed-top">
<?php } ?>
            <div class="fluid-container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
<?php if (strcmp($this->session->userdata('type'), 'ADMIN') == 0 || strcmp($this->session->userdata('type'), 'SUPER') == 0) { ?>
                    <a class="navbar-brand" href="<?php echo site_url('admin'); ?>">
<?php } else { ?>
                    <a class="navbar-brand" href="<?php echo site_url('dash'); ?>">
<?php } ?>
<?php if (strcmp($this->session->userdata('type'), 'ADMIN') == 0 || strcmp($this->session->userdata('type'), 'SUPER') == 0) { ?>
                        <img src="<?php echo img_url('logo_admin.png'); ?>" width="285" height="29" />
<?php } else { ?>
                        <img src="<?php echo img_url('logo_user.png'); ?>" width="207" height="27" />
<?php } ?>
                    </a>
                </div>
                
                
                <div class="navbar-collapse collapse">
                
                
<?php if (!empty($adminpage) && $adminpage != "None") { ?>
                    <ul class="nav navbar-nav">
<?php if (strcmp($this->session->userdata('type'), 'ADMIN') == 0 || strcmp($this->session->userdata('type'), 'SUPER') == 0) { ?>
                        <li <?php if (!empty($adminpage) && $adminpage == "Company") { echo 'class="active"'; } ?>>
                            <a href="<?php echo site_url('admin/company'); ?>">Company</a>
                        </li>
                        <li <?php if (!empty($adminpage) && $adminpage == "Locations") { echo 'class="active"'; } ?>>
                            <a href="<?php echo site_url('admin/locations'); ?>">Locations</a>
                        </li>
                        <li <?php if (!empty($adminpage) && $adminpage == "Users") { echo 'class="active"'; } ?>>
                            <a href="<?php echo site_url('admin/users'); ?>">Users</a>
                        </li>
                        <li <?php if (!empty($adminpage) && $adminpage == "Feedback") { echo 'class="active"'; } ?>>
                            <a href="<?php echo site_url('dash'); ?>">Feedback</a>
                        </li>
<?php } else { ?>
                        <li <?php if (!empty($adminpage) && $adminpage == "Feedback") { echo 'class="active"'; } ?>>
                            <a href="<?php echo site_url('dash'); ?>">Feedback</a>
                        </li>
                        <li <?php if (!empty($adminpage) && $adminpage == "Users") { echo 'class="active"'; } ?>>
                            <a style="margin-right:20px;" class="user" href="<?php echo site_url('admin/users/edit?uid=').$this->session->userdata('user_id'); ?>">Account Settings</a>
                        </li>
<?php } ?>
                    </ul>
<?php } ?>



                    <div class="navbar-right">

                    <?php if (!empty($user_data['first_name'])) { ?>
                        <a style="margin-right:20px;" class="user" href="<?php echo site_url('admin/users/edit?uid=').$this->session->userdata('user_id'); ?>"><?php echo $user_data['first_name'].' '.$user_data['last_name']; ?>
                            <i class="fa fa-cog"></i>
                        </a>
                    <?php } ?>

<?php if (strcmp($this->session->userdata('type'), 'SUPER') == 0) { ?>
                        <a href="<?php echo site_url('admin'); ?>" class="tip company" data-toggle="tooltip" data-placement="bottom" title="Change Company">
                            <i class="fa fa-building-o"></i>
                        </a>
<?php } ?>

                        <a href="<?php echo site_url('login/log_out'); ?>">
                            <button type="button" class="btn btn-ttb btn-xs">Logout</button>
                        </a>
                    </div>
                </div>
                <!--/.navbar-collapse -->
            </div>
        </div>
        <!--/.navbar -->

        <div id="body">