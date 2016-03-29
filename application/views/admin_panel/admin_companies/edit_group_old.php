<?php   
//echo '<pre>'.print_r($_POST, true).'</pre>';   
?>		   
	<div id="menu-content">
	<div id="content_wrapper">
		<h1>Editing Group <span class="special"><?php echo $group_data['name']; ?></span> :</h1>
		<div class="box">
			<h2>Edit Group</h2>
			<section>
			<p>Make the changes you want to the fields below and click submit. </p><br />
			<?php if(!empty($other_errors)) echo '<p class="reply" style="color:red;">'.$other_errors.'</p>'; ?>
			<form class="standard indent_0" method="post" action="<?php echo site_url('admin_companies/submit_edit_group/'.$group_data['ID']); ?>" >
			<div  class="primary_form" style="padding-bottom:46px;">
				<h3>Group Information</h3>
				<p>
					<label for="type">Group Type:<span class="required">*</span>  (Region, District, Sector, ...)</label>
					<input type="text" name="type" id="type" value="<?php echo set_value('type', $group_data['type']); ?>" /> <?php echo form_error('type'); ?><br />
					
					<label for="name">Group Name:<span class="required">*</span></label>
					<input type="text" name="name" id="name" value="<?php echo set_value('name', $group_data['name']); ?>" /> <?php echo form_error('name'); ?> <br />
				</p>
			</div>
			
			<div  class="primary_form" style="padding-bottom:46px;">
				<h3>Add locations to this Group</h3> <?php echo form_error('locations[]'); ?>
				<p>
				<?php 
					foreach($locations as $loc)
					{
						echo '<input type="checkbox" class="checkbox" name="locations[]" value="'.$loc->ID.'"  '.set_checkbox('locations[]', $loc->ID, $loc->in_group).' />'.$loc->name.',  '.$loc->address.' '.$loc->city.' '.$loc->state.'<br/>';
					}
				?>
				</p>
			</div>
			<p>
			
				<input name="btn_submit" class="btn_submit" type="submit" value="Submit Changes" />
			</p>
			</form>
			</section>
		</div>
	</div>
	<p class="content_end">&nbsp;</p>
					
				</div>
			</div>
		</div>
	</div><!-- #body -->