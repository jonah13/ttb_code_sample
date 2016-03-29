			<div id="menu-content">
				<div id="content_wrapper">
					<h1>Welcome Back <span class="special"><?php echo $user_data['username']; ?></span>!</h1>

					<div class="box" style="">
						<h2>Your Account information</h2>
						<section>
							<div class="container" style="height:230px;">
								<p class="ReadZone">
									<span class="reply" style="display:block; text-align:center;"> <?php if(!empty($reply)) echo $reply; ?> <br/></span>
									<span style="display:block; text-align:center; color:red;"> <?php if(!empty($error)) echo $error; ?></span>
									<span class="infot">User Name:</span> <?php echo $user_data['username']; ?><br />
									<span class="infot">First Name:</span> <?php echo $user_data['first_name']; ?><br />
									<span class="infot">Last Name:</span> <?php echo $user_data['last_name']; ?><br />
									<span class="infot">Email:</span> <a href="mailto:<?php echo $user_data['email']; ?>"><?php echo $user_data['email']; ?></a><br />
									<span class="infot">Phone number:</span> <?php if(!empty($user_data['phone'])) echo $user_data['phone']; else echo 'Not set'; ?><br />
									<span class="infot">Your <a href="<?php echo site_url('home'); ?>">TellTheBoss.com</a> Account was created On:</span> <?php if(!empty($user_data['signup_date'])) echo $user_data['signup_date']; else echo 'Not set'; ?><br />
								</p>
								<?php 
										$hide_info = "hide";
										$hide_info_link = "reveal";
										$hide_info_text = "Edit My Information";
										$hide_pw = "hide";
										$hide_pw_link = "reveal";
										$hide_pw_text = "Change my password";
										$btn_submit_val = "";
										$btn_submit_val = $this->input->post('btn_submit');
										$errors = validation_errors();
										if(!empty($errors) && strcmp($btn_submit_val, 'Submit Changes') == 0)
										{
											$hide_info = "";
											$hide_info_link = "hide";
											$hide_info_text = "Hide this form";
										}
										if(!empty($errors) && strcmp($btn_submit_val, 'Submit Password Change') == 0)
										{
											$hide_pw = "";
											$hide_pw_link = "hide";
											$hide_px_text = "Hide this form";
										}
									?>
								
								<form class="EditZoneInfo standard <?php echo $hide_info; ?>" id="edit_info" method="post" action="<?php echo site_url('dashboard/submit_edit_my_info'); ?>" >
								<p>
									<span>Fields marked with "<span class="required">*</span>" are required.</span><br/>
									<label for="first_name">First Name:<span class="required">*</span></label>
									<input style="margin-bottom:0; height:22px;" type="text" name="first_name" id="first_name" value="<?php $s = set_value('first_name'); if(strlen($s) > 1) echo $s; else echo $user_data['first_name']; ?>" />
									<?php echo form_error('first_name'); ?>
									<br />
									<label for="last_name">Last Name:<span class="required">*</span></label>
									<input style="margin-bottom:0; height:22px;" type="text" name="last_name" id="last_name" value="<?php $s = set_value('last_name'); if(strlen($s) > 1) echo $s; else echo $user_data['last_name']; ?>" />
									<?php echo form_error('last_name'); ?>
									<br />
									<label for="username">User Name:<span class="required">*</span></label>
									<input style="margin-bottom:0; height:22px;" type="text" name="username" id="username" value="<?php $s = set_value('username'); if(strlen($s) > 1) echo $s; else echo $user_data['username']; ?>" />
									<?php echo form_error('username'); ?>
									<br />
									<label for="email">Email:</label>
									<input style="margin-bottom:0; height:22px;" type="text" name="email" id="email" value="<?php $s = set_value('email'); if(strlen($s) > 1) echo $s; else echo $user_data['email']; ?>" />
									<?php echo form_error('email'); ?>
									<br /><label for="phone">phone:</label>
									<input style="margin-bottom:0; height:22px;" type="text" name="phone" id="phone" value="<?php $s = set_value('phone'); if(strlen($s) > 1) echo $s; else echo $user_data['phone']; ?>" />
									<?php echo form_error('phone'); ?>
									<br />
									<input id="btn_submit_info" name="btn_submit" class="btn_submit" type="submit" value="Submit" style="width:180px; padding:4px 0;" />
								</p>
								</form>
						
							
								<form class="EditZonePassWord standard <?php echo $hide_pw; ?>" id="edit_password" method="post" action="<?php echo site_url('dashboard/submit_edit_password'); ?>" >
								<p>	
									<span>To change your password, enter the following:<br/>Fields marked with "<span class="required">*</span>" are required.</span><br />
									<label for="Opass">Old Password:<span class="required">*</span></label>
									<input type="password" name="old_password" id="Opass" />
									<?php echo form_error('old_password'); ?>
									<br />
									<label for="pass">New Password:<span class="required">*</span></label>
									<input type="password" name="password" id="pass" />
									<?php echo form_error('password'); ?>
									<br />
									<label for="confirm_password">Confirm Password:<span class="required">*</span></label>
									<input type="password" name="confirm" id="confirm_password" />
									<?php echo form_error('confirm'); ?>
									<br />
									<input id="btn_submit_pass" name="btn_submit" class="btn_submit" type="submit" value="Submit" style="width:180px; padding:4px 0;" />
								</p>
								</form>
								
							</div>
							
							<p>
								<a name="EditZoneInfo" class="<?php echo $hide_info_link; ?> semi_btn float_right" rel="Edit my information" onClick="" style="cursor:pointer;"><?php echo $hide_info_text; ?></a>
								<a name="EditZonePassWord" class="<?php echo $hide_pw_link; ?> semi_btn float_right" rel="Change my password" onClick="" style="cursor:pointer;"><?php echo $hide_pw_text; ?></a>
							</p>
							<br class="clear_float"/>
						</section>
					</div>
					
					<div class="box" style="">
						<h2>Your Statistics</h2>
						<section>
							<p>
								<?php if(!empty($stats['companies_number'])) echo '<span class="infot">Number of Companies you have full access to:</span> '.$stats['companies_number'].'<br />'; ?>
								<?php if(!empty($stats['groups_number'])) echo '<span class="infot">Number of Groups you have full access to:</span> '.$stats['groups_number'].'<br />'; ?>
								<?php if(!empty($stats['locations_number'])) echo '<span class="infot">Number of Locations you have full access to:</span> '.$stats['locations_number'].'<br />'; ?>
								<?php if(!empty($stats['codes_number'])) echo '<span class="infot">Number of Codes you have full access to:</span> '.$stats['codes_number'].'<br />'; ?>
								<span class="infot">Number of feedback comments you got:</span> <?php echo $stats['comments_number']; if(empty($stats['comments_number'])) $stats['comments_number'] = 1; ?> <br />
							</p>
							<div style="border:solid #aaaaaa 2px; width:800px; background-color:#eeeeee; overflow:visible; z-index:1000; padding:10px; margin-top:10px;">
								<img style="margin-bottom:0px; float:left; margin-right:30px;" src="<?php echo img_url('e-analyzer-logo3.png'); ?>" alt="Analyzer Results" width="180">
								<ul style="width:130px; float:left; margin-right:30px;">
									<li>
										<span style="display:inline-block;width:85px;line-height:28px;">
											<img src="<?php echo img_url('positive.png'); ?>" width="20" style="vertical-align:middle;margin-right:5px;">Positive:
										</span> <?php echo round(($stats['pos_comments_number']*100)/$stats['comments_number']); ?>%
									</li>
									<li>
										<span style="display:inline-block;width:85px;line-height:28px;">
											<img src="<?php echo img_url('negative.png'); ?>" width="20" style="vertical-align:middle;margin-right:5px;">Negative:
										</span> <?php echo round(($stats['neg_comments_number']*100)/$stats['comments_number']); ?>%
									</li>
									<li>
										<span style="display:inline-block;width:85px;line-height:28px;">
											<img src="<?php echo img_url('neutral.png'); ?>" width="20" style="vertical-align:middle;margin-right:5px;">Neutral:
										</span> <?php echo round(($stats['neut_comments_number']*100)/$stats['comments_number']) ?>%
									</li>
								</ul>
								<p style="float:left; width:80px; height:80px; margin-right:20px; color:#555; font-weight:bold; padding-top:10px;">Source :</p>
								<ul style="width:130px; float:left; margin-right:20px;">
									<li>
										<span style="display:inline-block;width:85px;line-height:23px;">
											<img src="<?php echo img_url('sms.png'); ?>" width="20" style="vertical-align:middle;margin-right:5px;">SMS:
										</span> <?php echo round(($stats['sms_comments_number']*100)/$stats['comments_number']); ?>%
									</li>
									<li>
										<span style="display:inline-block;width:85px;line-height:23px;">
											<img src="<?php echo img_url('qr.png'); ?>" width="20" style="vertical-align:middle;margin-right:5px;">QR:
										</span> <?php echo round(($stats['qr_comments_number']*100)/$stats['comments_number']); ?>%
									</li>
									<li>
										<span style="display:inline-block;width:85px;line-height:23px;">
											<img src="<?php echo img_url('url.png'); ?>" width="20" style="vertical-align:middle;margin-right:5px;">URL:
										</span> <?php echo round(($stats['url_comments_number']*100)/$stats['comments_number']) ?>%
									</li>
									<li>
										<span style="display:inline-block;width:85px;line-height:23px;">
											<img src="<?php echo img_url('mail.png'); ?>" width="20" style="vertical-align:middle;margin-right:5px;">MAIL:
										</span> <?php echo round(($stats['mail_comments_number']*100)/$stats['comments_number']) ?>%
									</li>
								</ul>
								<br class="clear_float"/>
							</div>
						</section>
					</div>

				
				</div>
			</div>
		</div>
	</div><!-- #body -->
	<script>
	var infoLabelActive = "Edit My Information";
	var infoLabelInActive = "Cancel";
	var passLabelActive = "Change my password";
	var passLabelInActive = "Cancel";
		
	function active_btn_submit(btn){
		var link = $("#" + btn );
		link.addClass('btn_is_active');
		}
	function inactive_btn_submit(btn){
		var link = $("#" + btn );
		link.addClass('btn_is_inactive');
		}
	function ActiveReadInfo(){
		var to_reveal = $(".ReadZone");
		to_reveal.show();
		}
	function InActiveReadInfo(){
		var to_hide = $(".ReadZone");
		to_hide.hide();
		}			
	function ActiveEditInfo(){
		var to_reveal = $(".EditZoneInfo");
		to_reveal.show();
		var link = $('a[name=EditZoneInfo]');
		link.text(infoLabelInActive);
		link.removeClass('reveal');
		link.addClass('hide');
		var hide_link = $('a[name=EditZonePassWord]');
		hide_link.hide();
		}
	function InActiveEditInfo(){
		var to_hide = $(".EditZoneInfo");
		to_hide.hide();
		var link = $('a[name=EditZoneInfo]');
		link.text(infoLabelActive);
		link.removeClass('hide');
		link.addClass('reveal');
		var hide_link = $('a[name=EditZonePassWord]');
		hide_link.show();
		}			
	function ActiveEditPassword(){
		var to_reveal = $(".EditZonePassWord");
		to_reveal.show();
		var link = $('a[name=EditZonePassWord]');
		link.text(infoLabelInActive);
		link.removeClass('reveal');
		link.addClass('hide');
		var hide_link = $('a[name=EditZoneInfo]');
		hide_link.hide();
		}
	function InActiveEditPassword(){
		var to_hide = $(".EditZonePassWord");
		to_hide.hide();
		var link = $('a[name=EditZonePassWord]');
		link.text(passLabelActive);
		link.removeClass('hide');
		link.addClass('reveal');
		var hide_link = $('a[name=EditZoneInfo]');
		hide_link.show();
		}
	$(document).ready(function()
	{
		$('form.hide').hide();
		$('a.reveal[name=EditZoneInfo]').live('click', function(){
			InActiveReadInfo();
			ActiveEditInfo();
			InActiveEditPassword();
			active_btn_submit("btn_submit_info");
			return false;
			});
		$('a.hide[name=EditZoneInfo]').live('click', function(){
			ActiveReadInfo();
			InActiveEditInfo();
			InActiveEditPassword();
			inactive_btn_submit("btn_submit_info");
			return false;
			});
		$('a.reveal[name=EditZonePassWord]').live('click', function(){
			InActiveReadInfo();
			InActiveEditInfo();
			ActiveEditPassword();
			active_btn_submit("btn_submit_pass");
			return false;
			});
		$('a.hide[name=EditZonePassWord]').live('click', function(){
			ActiveReadInfo();
			InActiveEditInfo();
			InActiveEditPassword();
			inactive_btn_submit("btn_submit_pass");
			return false;
			});	
	});

	</script>