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
		<h1>Locations</h1>
		<?php 
		if($user_data['stores_number'] == 0)
			echo '<p>You have no registered locations. Try adding one <a href="'.site_url('dashboard/add_stores').'">here</a></p>';
		else 
		{
			echo '<p>You currently have <mark>'. $user_data['stores_number'].'</mark> locations registered. Select the location you want to edit</p>';
			echo '<section><ul class="stores_list">';
			for($i = 0; $i < $user_data['stores_number']; $i++)
			{
				$store_data = $this->pages_data_model->get_store_data($user_data['stores_ids'][$i]);
				echo '<li><a href="'.site_url('dashboard/edit_stores/'.$user_data['stores_ids'][$i]).'">'.$store_data['name'].'</a></li>';
			}
			echo '</ul></section>';
		}
		?>
	</div>
	<p class="content_end">&nbsp;</p>
</div>