			<div id="menu-content">
				<div id="content_wrapper">
					<h1>Welcome Back <span class="special"><?php echo $user_data['username']; ?></span>!</h1>
				
				<!--	<h2>Graph</h2>
					<section><p>
					
						<canvas  id="myChart" style="width: 500px; height: 350px;" height="350px" width="500px">

						</canvas >							
						</p>
					</section>-->

					<div class="box" style="width:50%; min-width:460px;">
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
									<span class="infot">You signed up to <a href="<?php echo site_url('home'); ?>">TellTheBoss.com</a> on:</span> <?php if(!empty($user_data['signup_date'])) echo $user_data['signup_date']; else echo 'Not set'; ?><br />
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
								
								<form class="EditZoneInfo standard <?php echo $hide_info; ?>" id="edit_info" method="post" action="<?php echo site_url('admin_panel/submit_edit_my_info'); ?>" >
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
									<label for="email">Email:<span class="required">*</span></label>
									<input style="margin-bottom:0; height:22px;" type="text" name="email" id="email" value="<?php $s = set_value('email'); if(strlen($s) > 1) echo $s; else echo $user_data['email']; ?>" />
									<?php echo form_error('email'); ?>
									<br /><label for="phone">phone:<span class="required">*</span></label>
									<input style="margin-bottom:0; height:22px;" type="text" name="phone" id="phone" value="<?php $s = set_value('phone'); if(strlen($s) > 1) echo $s; else echo $user_data['phone']; ?>" />
									<?php echo form_error('phone'); ?>
									<br />
									<input id="btn_submit_info" name="btn_submit" class="btn_submit" type="submit" value="Submit" style="width:180px; padding:4px 0;" />
								</p>
								</form>
						
							
								<form class="EditZonePassWord standard <?php echo $hide_pw; ?>" id="edit_password" method="post" action="<?php echo site_url('admin_panel/submit_edit_password'); ?>" >
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
					
					<div class="box" style="width:50%; min-width:460px;">
						<h2>Current Site Stats</h2>
						<section>
							<p>
								<span class="infot">Number of Client users:</span> <?php echo $stats['clients_number']; ?><br />
								<span class="infot">Number of Admin users:</span> <?php echo $stats['admins_number']; ?><br />
								<span class="infot">Number of Companies:</span> <?php echo $stats['companies_number']; ?><br />
								<span class="infot">Number of Groups:</span> <?php echo $stats['groups_number']; ?><br />
								<span class="infot">Number of locations:</span> <?php echo $stats['locations_number']; ?></a><br />
								<span class="infot">Number of codes:</span> <?php echo $stats['codes_number']; ?><br />
								<span class="infot">Number of feedback comments:</span> <?php echo $stats['comments_number']; ?> (URL: <?php echo number_format(100*$stats['url_comments_number']/$stats['comments_number'], 2); ?>% , QR: <?php echo number_format(100*$stats['qr_comments_number']/$stats['comments_number'], 2); ?>%, SMS: <?php echo number_format(100*$stats['sms_comments_number']/$stats['comments_number'], 2); ?>%, MAIL: <?php echo number_format(100*$stats['mail_comments_number']/$stats['comments_number'], 2); ?>%)<br />
								<span class="infot">Number of incoming SMS messages:</span> <?php echo $stats['incoming_SMS_number']; ?><br />
								<span class="infot">Number of outgoing SMS messages:</span> <?php echo $stats['outgoing_SMS_number']; ?><br />
							</p>
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

	/*	
		var data = {
			labels : ["January","February","March","April","May","June","July"],
			datasets : [
				{
					fillColor : "rgba(0, 0, 255, 0.5)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					data : [65,59,90,81,56,55,40]
				},
				{
					fillColor : "rgba(151,187,205,0.5)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					data : [28,48,40,19,96,27,100]
				}
			]
		}
		var options = {
				
	//Boolean - If we show the scale above the chart data			
	scaleOverlay : false,
	
	//Boolean - If we want to override with a hard coded scale
	scaleOverride : false,
	
	//** Required if scaleOverride is true **
	//Number - The number of steps in a hard coded scale
	scaleSteps : null,
	//Number - The value jump in the hard coded scale
	scaleStepWidth : null,
	//Number - The scale starting value
	scaleStartValue : null,

	//String - Colour of the scale line	
	scaleLineColor : "rgba(0,0,0,.1)",
	
	//Number - Pixel width of the scale line	
	scaleLineWidth : 2,

	//Boolean - Whether to show labels on the scale	
	scaleShowLabels : false,
	
	//Interpolated JS string - can access value
	scaleLabel : "<%=value%>",
	
	//String - Scale label font declaration for the scale label
	scaleFontFamily : "'Arial'",
	
	//Number - Scale label font size in pixels	
	scaleFontSize : 12,
	
	//String - Scale label font weight style	
	scaleFontStyle : "normal",
	
	//String - Scale label font colour	
	scaleFontColor : "#666",	
	
	///Boolean - Whether grid lines are shown across the chart
	scaleShowGridLines : true,
	
	//String - Colour of the grid lines
	scaleGridLineColor : "rgba(0,0,0,.05)",
	
	//Number - Width of the grid lines
	scaleGridLineWidth : 2,	

	//Boolean - If there is a stroke on each bar	
	barShowStroke : true,
	
	//Number - Pixel width of the bar stroke	
	barStrokeWidth : 2,
	
	//Number - Spacing between each of the X value sets
	barValueSpacing : 5,
	
	//Number - Spacing between data sets within X values
	barDatasetSpacing : 1,
	
	//Boolean - Whether to animate the chart
	animation : true,

	//Number - Number of animation steps
	animationSteps : 300,
	
	//String - Animation easing effect
	animationEasing : "easeOutQuart",

	//Function - Fires when the animation is complete
	onAnimationComplete : null
	
}
		
		var ctx = document.getElementById("myChart").getContext("2d");
		var myNewChart = new Chart(ctx).Line(data,options);*/
	});

	</script>