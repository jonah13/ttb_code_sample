	
	<div id="menu-content">
	<div id="content_wrapper">
		<h1>Deleting <span class="special"><?php echo $target_data['name']; ?></span> :</h1>
		<div class="box">
			<h2>Deleting Location</h2>
			<section>
				<p>You're about to delete the location <em><?php echo $target_data['name']; ?></em> from the company <strong><?php echo $company_name; ?></strong>.</p>
				<p>Deleting a location will also result in deleting all the codes and comments under it.</p>
				<p><strong style="color:red;">This action is irreversible!</strong></p><br />
				<p><a href="<?php echo site_url('admin_companies/submit_delete_location/'.$target_data['ID']); ?>" class="confirm">- Continue to deleting <?php echo $target_data['name']; ?>!</p>
				<p><a href="<?php echo site_url('admin_companies/manage_locations/'.$target_data['company_id']); ?>">- I don't want to delete this Location - go back to "Manage <?php echo $company_name; ?>'s Loactions" page.</p>
			</section>
		</div>
	</div>
	</div>
	<script>
	$(document).ready(function()
	{
		//general confirm box when deleting
		$('a.confirm').click(function() {
			var r = confirm("Confirm deleting: Are you sure you want to delete this Location?");
			if (!r)  return false;
		});
	});
	</script>
	<p class="content_end">&nbsp;</p>
	


				
				</div>
			</div>
		</div>
	</div><!-- #body -->