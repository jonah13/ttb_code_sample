	<div id="body">
		<div id="main" class="admin_panel">
			<div id="current_page">
				<div style="width:1000%">
				<p class="current_link">
					<a class="first" href="<?php echo site_url('admin_panel'); ?>">Admin Panel</a><?php
						foreach($current_path as $label=>$url)
						{
							$class = '';
							if(end($current_path) == $url)
								$class = ' class="last" ';
							echo '<a '.$class.' href="'.site_url($url).'">'.$label.'</a>';
						}
					?>
				</p>
				</div>
			</div>
			<div id="menu">
				<ul>
					<li><a href="<?php echo site_url('admin_panel'); ?>" class="<?php echo ( $sub_current == "home" ? "active" : ""); ?>">My Account</a></li>
					<li><a href="<?php echo site_url('admin_users'); ?>" class="<?php echo ( $sub_current == "manage_users" ? "active" : ""); ?>">Manage Users</a></li>
					<li><a href="<?php echo site_url('admin_companies'); ?>" class="<?php echo ( $sub_current == "manage_companies" ? "active" : ""); ?>">Manage Companies</a></li>
					<li><a href="<?php echo site_url('admin_feedback'); ?>" class="<?php echo ( $sub_current == "feedback_stats" ? "active" : ""); ?>">Feedback</a></li>
				</ul>
			</div>