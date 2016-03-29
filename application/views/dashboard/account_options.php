<?php $user_data = $this->pages_data_model->get_user_data();?>
<div id="main" class="dashboard">
	<div id="menu">
		<h1>Dashboard</h1>
		<ul>
			<li><a href="<?php echo site_url('dashboard/edit_user_info'); ?>">My Account</a></li>
			<li><a class="active" href="<?php echo site_url('dashboard/feedback_stats'); ?>">Customer Feedback</a></li>
			<li><a href="<?php echo site_url('dashboard/edit_stores'); ?>">Locations</a></li>
			<li><a href="<?php echo site_url('dashboard'); ?>">Codes</a></li>
		</ul>
	</div>
	<div id="menu-content">
	<h1>Account Options</h1>
		<p>Check and edit you account options here, if you have any questions regarding them, check our <a href="<?php echo site_url('help'); ?>">help</a> or <a href="<?php echo site_url('contact'); ?>">contact us</a>.</p>
		<h3>Limit feedback messages</h3>
		<p>To limit the number of feedback messages we receive from the same customer for your company within 24 hours, specify that number here or choose unlimited (customers can send as many feedback messages as they want).</p>
		<form class="dashboard" method="post" action="<?php echo site_url('dashboard/account_options/submit'); ?>">
			<p>
				<label class="feedback_limit" for="feedback_limit">Feedback messages per customer limit :</label> 
				<select name="feedback_limit" id="feedback_limit">
					<option value="0" <?php echo set_select('feedback_limit', '0'); ?>>Unlimited</option>
					<?php for($i = 1; $i < 20; $i++) {?>
						<option value="<?php echo $i; ?>" <?php echo set_select('feedback_limit', $i); ?>><?php echo $i; ?></option>
					<?php } ?>
				</select>
			</p>
		
			<h3>Set critical words</h3>
			<p>The critical words are words you want us to notify you right away if they happen to appear in a customer feedback message. Enter the words you choose for your location here (use commas to seperate them): <br />
			"Example: racist, cockroach" <br /></p>
			<p>
				<label for="critical">Critical words:</label> <br />
				<textarea name="critical" id="critical" rows="2" cols="77"></textarea>
			</p>
			<p>Or you can choose to be notified of all customer messages</p>
			<p>
				<input class="checkbox" type="checkbox" name="receive_all" value="receive_all" /> Notify me of all customers feedback messages.
			</p>
			<h3>Where to receive messages</h3>
			<p>Choose where you want to receive messages from our website. (Messages notifying you of customers feedback) </p>
			<p>
				<label for="client_contact">send me notifications on : </label> <br />
				<input class="checkbox" type="checkbox" name="receive_all" value="client_phone" /> My phone number.<br />
				<input class="checkbox" type="checkbox" name="receive_all" value="company_phone" /> My company phone number.<br />
				<input class="checkbox" type="checkbox" name="receive_all" value="eclient_mail" /> My email address.<br />
				<input class="checkbox" type="checkbox" name="receive_all" value="company_email" /> My company email address.
			</p>
			<br />
			<input name="btn_submit_changes" id="btn_submit_changes" src="<?php echo img_url('submit_changes.png'); ?>" type="image" alt="submit_changes" />
		</form>
	</div>
	<p class="content_end">&nbsp;</p>
</div>