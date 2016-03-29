	
<div id="menu-content">
	<div id="content_wrapper">
		<h1>Edit <span class="special"><?php echo $target_data['username']; ?></span> :</h1>
		<div class="box">
			<h2>Editing <?php echo $target_data['type']; ?>'s Information</h2>
			<section>
				<p>Make the changes you want, and click submit.</p><br />
				<p>P.S.: Fields marked with <span class="required">*</span> are required. To delete a field, just empty it before clicking submit.</p><br />
				<form class="standard" method="post" action="<?php echo site_url('admin_users/submit_edit/'.$target_data['ID']); ?>" >
					<p>
						<label for="first_name">First Name:<span class="error">*</span></label>
						<input type="text" name="first_name" id="first_name" value="<?php $s = set_value('first_name'); if(strlen($s) > 1) echo $s; else echo $target_data['first_name']; ?>" />
						<?php echo form_error('first_name'); ?>
						<br />
						<label for="last_name">Last Name:<span class="error">*</span></label>
						<input type="text" name="last_name" id="last_name" value="<?php $s = set_value('last_name'); if(strlen($s) > 1) echo $s; else echo $target_data['last_name']; ?>" />
						<?php echo form_error('last_name'); ?>
						<br />
						<label for="username">User Name:<span class="error">*</span></label>
						<input type="text" name="username" id="username" value="<?php $s = set_value('username'); if(strlen($s) > 1) echo $s; else echo $target_data['username']; ?>" />
						<?php echo form_error('username'); ?>
						<br />
						<label for="password">Password:<span class="error">*</span></label>
						<input type="text" name="password" id="password" value="<?php $s = set_value('password'); if(strlen($s) > 1) echo $s; else echo $target_data['password']; ?>" />
						<?php echo form_error('password'); ?>
						<br />
						<label for="email">Email:<span class="error">*</span></label>
						<input type="text" name="email" id="email" value="<?php $s = set_value('email'); if(strlen($s) > 1) echo $s; else echo $target_data['email']; ?>" />
						<?php echo form_error('email'); ?>
						<br />
						<label for="phone">Phone:</label>
						<input type="text" name="phone" id="phone" value="<?php $s = set_value('phone'); if(strlen($s) > 1) echo $s; else echo $target_data['phone']; ?>" />
						<?php echo form_error('phone'); ?>
						<br />
						<input name="btn_submit_changes" class="btn_submit" type="submit" value="Submit Changes" />
					</p>
				</form>
			</section>
		</div>
	</div>
	</div>
	<p class="content_end">&nbsp;</p>
	


				
				</div>
			</div>
		</div>
	</div><!-- #body -->