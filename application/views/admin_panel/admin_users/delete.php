	
	<div id="menu-content">
	<div id="content_wrapper">
		<h1>Deleting <span class="special"><?php echo $target_data['username']; ?></span> :</h1>
		<div class="box">
			<h2>Deleting <?php echo $target_data['type']; ?></h2>
			<section>
				<p>You're about to delete the <?php echo strtolower($target_data['type']).' : '.$target_data['first_name'].' '.$target_data['last_name']; ?>.</p>
				<?php if($target_data['type'] == 'CLIENT')
					echo '<p>Deleting a client will also result in deleting all of their relationships with companies, locations and codes.</p>';
				?>
				<p><strong style="color:red;">This action is irreversible!</strong></p><br />
					<p><a href="<?php echo site_url('admin_users/submit_delete/'.$target_data['ID']); ?>" class="confirm">- Continue to deleting <?php echo strtolower($target_data['type']); ?>!</p>
					<p><a href="<?php echo site_url('admin_users'); ?>">- I don't want to delete this <?php echo strtolower($target_data['type']); ?> - go back to "manage users" page.</p>
			</section>
		</div>
	</div>
	</div>
	<script>
	$(document).ready(function()
	{
		//general confirm box when deleting
		$('a.confirm').click(function() {
			var r = confirm("Confirm deleting: Are you sure you want to delete this user?");
			if (!r)  return false;
		});
	});
	</script>
	<p class="content_end">&nbsp;</p>
	


				
				</div>
			</div>
		</div>
	</div><!-- #body -->