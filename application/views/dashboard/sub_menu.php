	<div id="body">
		<div id="main" class="dashboard">
			<div id="current_page">
				<div style="width:1000%">
				<p class="current_link">
					<a class="first" href="<?php echo site_url('dashboard'); ?>"><?php echo $username; ?>'s Dashboard</a><?php
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
					<li><a href="<?php echo site_url('dashboard'); ?>" class="<?php echo ( $sub_current == "home" ? "active" : ""); ?>">My Account</a></li>
					<li><a href="<?php echo site_url('dashboard/feedback_stats'); ?>" class="<?php echo ( $sub_current == "feedback_stats" ? "active" : ""); ?>">Feedback</a></li>
					<li><a href="<?php echo site_url('dashboard/notifications_options'); ?>" class="<?php echo ( $sub_current == "notifications_options" ? "active" : ""); ?>">Notifications Options</a></li>
					<li><a href="<?php echo site_url('dashboard/locations_codes'); ?>" class="<?php echo ( $sub_current == "locations_codes" ? "active" : ""); ?>">My Locations</a></li>
				</ul>
			</div>