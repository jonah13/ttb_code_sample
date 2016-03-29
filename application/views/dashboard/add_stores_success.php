<?php $user_data = $this->pages_data_model->get_user_data();?>
<div id="main" class="dashboard">
	<div id="menu">
		<ul>
			<li><a href="<?php echo site_url('dashboard/edit_user_info'); ?>">My Account</a></li>
			<li><a class="active" href="<?php echo site_url('dashboard/feedback_stats'); ?>">Customer Feedback</a></li>
			<li><a href="<?php echo site_url('dashboard/edit_stores'); ?>">Locations</a></li>
			<li><a href="<?php echo site_url('dashboard'); ?>">Codes</a></li>
		</ul>
	</div>
	<div id="menu-content">
		<h1>Location Added</h1>
		<p>Your information has successfully been submitted. <a href="'.site_url('dashboard/add_stores').'">Add another Location?</a><</p>
	</div>
	<p class="content_end">&nbsp;</p>
</div>