	
	<div id="menu-content">
	<div id="content_wrapper">
		<h1>Add a new <span class="special">User</span> :</h1>
		<div class="box">
			<h2>New user registration</h2>
			<section>
			<p>To registre a new User to TellTheBoss.com, complete the fields bellow, and click submit.</p><br />
			<p>P.S.: Fields marked with <span class="required">*</span> are required.</p><br />
			<form class="standard" method="post" action="<?php echo site_url('admin_users/submit_add'); ?>" >
			<p>
				<label for="first_name">First Name:<span class="required">*</span></label>
				<input type="text" name="first_name" id="first_name" value="<?php echo set_value('first_name'); ?>" />
				<?php echo form_error('first_name'); ?>
				<br />
				<label for="last_name">Last Name:<span class="required">*</span></label>
				<input type="text" name="last_name" id="last_name" value="<?php echo set_value('last_name'); ?>" />
				<?php echo form_error('last_name'); ?>
				<br />
				<label for="username">User Name:<span class="required">*</span></label>
				<input type="text" name="username" id="username" value="<?php echo set_value('username'); ?>" />
				<?php echo form_error('username'); ?>
				<br />
				<label for="pass">Password:<span class="required">*</span></label>
				<input type="password" name="password" id="pass" />
				<?php echo form_error('password'); ?>
				<br />
				<label for="pass">Confirm Password:<span class="required">*</span></label>
				<input type="password" name="confirm" id="confirm_password" />
				<?php echo form_error('confirm'); ?>
				<br />
				<label for="email">Email:</label>
				<input type="text" name="email" id="email" value="<?php echo set_value('email'); ?>" />
				<?php echo form_error('email'); ?>
				<br />
				<label for="phone">Phone Number:</label>
				<input type="text" name="phone" id="phone" value="<?php echo set_value('phone'); ?>" />
				<?php echo form_error('phone'); ?>
				<br />
				<label for="type">User Type:<span class="required">*</span></label>
				<select name="type" id="type">
					<option value="CLIENT" <?php echo set_select('type', 'CLIENT'); ?>>CLIENT</option>
					<option value="ADMIN" <?php echo set_select('type', 'ADMIN'); ?>>ADMIN</option>
				</select>
				<?php echo form_error('type'); ?>
				<br />
				<input name="btn_submit" class="btn_submit" type="submit" value="Submit" />
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