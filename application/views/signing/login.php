<div id="main" class="login">
	<section>
		<h1>Client Login</h1>
		<?php if(!empty($message)) echo '<p><span class="error">'.$message.'</span></p>'; ?>
		<form class="login" method="post" action="<?php echo site_url('login/submit'); ?>">
			<p>
				<label for="username">USER NAME :</label><?php echo form_error('username', '<span class="error">', '</span>'); ?><br />
				<input type="text" name="username" id="username" value="<?php echo set_value('username'); ?>" />
				<br />
				<label for="password">PASSWORD :</label><?php echo form_error('password', '<span class="error">', '</span>'); ?><br />
				<input type="password" name="password" id="password" />
				<br />
				<input name="btn_login" id="btn_login" src="<?php echo img_url('login.png'); ?>" type="image" />
			</p>
		</form>
		<p class="form_links">
			<a href="<?php echo site_url('login/reset_password'); ?>">Reset Password</a> <br />
		</p>
		<p class="form_register">You don't have an account? <a href="<?php echo site_url('contact'); ?>">Contact us for a Demo!</a></p>
	</section>
</div>