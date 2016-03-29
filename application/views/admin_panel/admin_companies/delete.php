	
	<div id="menu-content">
	<div id="content_wrapper">
		<h1>Deleting <span class="special"><?php echo $target_data['name']; ?></span> :</h1>
		<div class="box">
			<h2>Deleting Company</h2>
			<section>
				<p>You're about to delete the Company <?php echo $target_data['name']; ?>.</p>
				<p>Deleting a company will also result in deleting all the locations and codes under it.</p>
				<p><strong style="color:red;">This action is irreversible!</strong></p><br />
				<p><a href="<?php echo site_url('admin_companies/submit_delete/'.$target_data['ID']); ?>" class="confirm">- Continue to deleting <?php echo $target_data['name']; ?>!</p>
				<p><a href="<?php echo site_url('admin_companies'); ?>">- I don't want to delete this Company - go back to "Manage Companies" page.</p>
			</section>
		</div>
	</div>
	</div>
	<script>
	$(document).ready(function()
	{
		//general confirm box when deleting
		$('a.confirm').click(function() {
			var r = confirm("Confirm deleting: Are you sure you want to delete this Company?");
			if (!r)  return false;
		});
	});
	</script>
	<p class="content_end">&nbsp;</p>
	


				
				</div>
			</div>
		</div>
	</div><!-- #body -->