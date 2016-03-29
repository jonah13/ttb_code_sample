<div id="main" class="reset">
	<section>
		<h1>Reset Password</h1>
		<p>Enter your user name or email and we will send you an email with the instructions to reset your password.</p>
		<form class="reset" method="post" action="<?php echo site_url('login/reset_password/submit'); ?>">
			<p>
				<label for="email_username">Username Or Email:</label><?php echo form_error('email_username', '<span class="error">', '</span>'); ?>
				<input type="text" name="email_username" id="email_username" value="<?php echo set_value('email_username'); ?>" /><br>
				<input name="btn_submit" id="btn_submit" src="<?php echo img_url('submit.png'); ?>" type="image" />
			</p>
		</form>
		<br />
		<p class="form_register">You don't have an account? <a href="<?php echo site_url('contact'); ?>">Contact us for a Demo!</a></p>
	</section>
</div>