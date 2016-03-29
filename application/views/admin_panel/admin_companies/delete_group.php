	
	<div id="menu-content">
	<div id="content_wrapper">
		<h1>Deleting Group <span class="special"><?php echo $target_data['name']; ?></span> :</h1>
		<div class="box">
			<h2>Delete Group</h2>
			<section>
				<p>You're about to delete the Group <em><?php echo $target_data['name']; ?></em> from the company <strong><?php echo $company_name; ?></strong>.</p>
				<p>Deleting a Group will NOT result in deleting the locations and subgroups under it. Just the group will be deleted!</p>
				<p>All the locations and subgroups under this group will belong to its parent group in case it has a parent</p>
				<p><strong style="color:red;">This action is irreversible!</strong></p><br />
				<p><a href="<?php echo site_url('admin_companies/submit_delete_group/'.$target_data['ID']); ?>" class="confirm">- Continue to deleting the Group <?php echo $target_data['name']; ?>!</p>
				<p><a href="<?php echo site_url('admin_companies/manage_groups/'.$target_data['company_id']); ?>">- I don't want to delete this Group - go back to "Manage <?php echo $company_name; ?>'s Groups" page.</p>
			</section>
		</div>
	</div>
	</div>
	<script>
	$(document).ready(function()
	{
		//general confirm box when deleting
		$('a.confirm').click(function() {
			var r = confirm("Confirm deleting: Are you sure you want to delete this Group?");
			if (!r)  return false;
		});
	});
	</script>
	<p class="content_end">&nbsp;</p>
	


				
				</div>
			</div>
		</div>
	</div><!-- #body -->