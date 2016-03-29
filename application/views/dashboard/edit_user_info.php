<?php 
$user_data = $this->pages_data_model->get_user_data();
$company_data = $this->pages_data_model->get_company_data();
$selected = "";
if(!empty($error_pane)) $selected = "$(\"#tabs\").tabs(\"select\", \"$error_pane\");";
?>
<script type="text/javascript">
	$(function() {
		$("#tabs").tabs().addClass('ui-tabs-vertical ui-helper-clearfix');
		<?php echo $selected; ?>
		$("#tabs").removeClass('ui-corner-all ui-corner-bottom');
		$("#tabs div").removeClass('ui-corner-all ui-corner-bottom');
		$("#tabs ul").removeClass('ui-corner-all ui-widget-header');
		$("#tabs li").removeClass('ui-corner-top');
	
		update_noti_controls();
		$('#phone_notifications, #email_notifications').live('change', function(){update_noti_controls();});
		
	});
	
	function update_noti_controls()
	{
		if($('#phone_notifications').is(':checked')) 
			$("#phone_noti_type input").prop('disabled', false);
		else
			$("#phone_noti_type input").prop('disabled', true);
			
		if($('#email_notifications').is(':checked')) 
			$("#email_noti_type input").prop('disabled', false);
		else
			$("#email_noti_type input").prop('disabled', true);
	}
</script>
<style type="text/css">
	
/* Vertical Tabs
----------------------------------*/
.ui-tabs-vertical { width: 54.5em; }
.ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 12em; margin-top: 5px; border:0 ;}
.ui-tabs-vertical .ui-tabs-nav li, .ui-tabs-vertical .ui-tabs-nav li.ui-state-default { clear: left; width: 100%; border:0; margin-right: 0px; padding-right: 0px}
.ui-tabs-vertical .ui-tabs-nav li a { display:block; }
.ui-tabs-vertical .ui-tabs-nav li.ui-tabs-selected, .ui-tabs-vertical .ui-tabs-nav li.ui-state-hover { padding-bottom: 0; border: 0;}
.ui-tabs-vertical .ui-tabs-panel { 
	padding: 1em; float: 
	right; width: 40em; 
	border: 1px solid #dddddd; 
	-moz-box-shadow: 0 0 5px 4px #dddddd;
	-webkit-box-shadow: 0 0 5px 4px #dddddd;
	box-shadow: 0 0 5px 4px #dddddd;}
#tabs { border:0; }
#tabs .ui-tabs-panel h2 { padding-top: 2px; padding-bottom: 2px; color: #333333;}
#tabs section { margin-left: 0px;}

.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { background: transparent; font-weight: normal; color: #555555; }
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited { color: #555555; text-decoration: none; }
.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus { background: #dadada; font-weight: normal; color: #212121; }
.ui-state-hover a, .ui-state-hover a:hover { color: #212121; text-decoration: none; }
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active { background: #dddddd; font-weight: bold; color: #212121; }
.ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited { color: #212121; text-decoration: none; }
.ui-widget :active { outline: none; }

</style>
	
	
<div id="main" class="dashboard">
	<div id="menu">
		<ul>
			<li><a class="active" href="<?php echo site_url('dashboard/edit_user_info'); ?>">My Account</a></li>
			<li><a href="<?php echo site_url('dashboard/feedback_stats'); ?>">Customer Feedback</a></li>
			<!--<li><a href="<?php echo site_url('dashboard/edit_stores'); ?>">Locations</a></li>-->
			<li><a href="<?php echo site_url('dashboard'); ?>">Locations & Codes</a></li>
			<!--<li><a href="<?php echo site_url('feedback/receive/ttb'); ?>">Feedback to TTB</a></li>-->
		</ul>
	</div>
	<div id="menu-content">
	<h1>My Account</h1>
	<article id="tabs">
	
		<ul>
			<?php if(!empty($company_data)) echo '<li><a href="#tabs-1">Company Info</a></li>'; ?>
			<li><a href="#tabs-2">User Info</a></li>
			<li><a href="#tabs-3">Change Password</a></li>
			<?php //if(!empty($company_data)) echo '<li><a href="#tabs-4">Billing Info</a></li>'; ?>
		</ul>
		
		<?php 
		if(!empty($company_data)) { 
			// Display the Company Information tab 
		?>
		
		<div id="tabs-1">
			<h2>COMPANY INFORMATION:</h2>
			<section>
			<?php if(isset($message) && $message != null && $message != '') echo '<br /><p class = "success">'.$message.'</p><br />'; ?>
			<form class="edit_form" method="post" id="company_info" name="company_info" action="<?php echo site_url('dashboard/edit_company_info'); ?>" >
				<p>
					<input type="hidden" name="company_id" value="<?php echo $company_data['id']; ?>" />
					<label for="company_name">Company Name:</label>
					<input type="text" name="company_name" id="company_name" value="<?php $s = set_value('company_name'); if(strlen($s) > 1) echo $s; else echo $company_data['name']; ?>" />
					<?php echo form_error('company_name'); ?>
					<br />
					<label for="address">Address:</label>
					<input type="text" name="address" id="address" value="<?php $s = set_value('address'); if(strlen($s) > 1) echo $s; else echo $company_data['address']; ?>" />
					<?php echo form_error('address'); ?>
					<br />
					<label for="city">City:</label>
					<input type="text" name="city" id="city" value="<?php $s = set_value('city'); if(strlen($s) > 1) echo $s; else echo $company_data['city']; ?>" />
					<?php echo form_error('city'); ?>
					<br />
					<label for="state">State:</label>
					<select name="state" id="state">
					<?php 
						$state = $company_data['state']; 
						if(strlen($state) < 2) $state = '';
						if(!empty($_POST['state'])) $state = $_POST['state'];
						?>
					<option value="" <?php if(strcmp($state, '') == 0) echo 'selected="selected" ' ?>>--Please select--</option>
					<option value="AL" <?php if(strcmp($state, 'AL') == 0) echo 'selected="selected" ' ?>>Alabama</option>
					<option value="AK" <?php if(strcmp($state, 'AK') == 0) echo 'selected="selected" ' ?>>Alaska</option>
					<option value="AZ" <?php if(strcmp($state, 'AZ') == 0) echo 'selected="selected" ' ?>>Arizona</option>
					<option value="AR" <?php if(strcmp($state, 'AR') == 0) echo 'selected="selected" ' ?>>Arkansas</option>
					<option value="CA" <?php if(strcmp($state, 'CA') == 0) echo 'selected="selected" ' ?>>California</option>
					<option value="CO" <?php if(strcmp($state, 'CO') == 0) echo 'selected="selected" ' ?>>Colorado</option>
					<option value="CT" <?php if(strcmp($state, 'CT') == 0) echo 'selected="selected" ' ?>>Connecticut</option>
					<option value="DE" <?php if(strcmp($state, 'DE') == 0) echo 'selected="selected" ' ?>>Delaware</option>
					<option value="DC" <?php if(strcmp($state, 'DC') == 0) echo 'selected="selected" ' ?>>District Of Columbia</option>
					<option value="FL" <?php if(strcmp($state, 'FL') == 0) echo 'selected="selected" ' ?>>Florida</option>
					<option value="GA" <?php if(strcmp($state, 'GA') == 0) echo 'selected="selected" ' ?>>Georgia</option>
					<option value="HI" <?php if(strcmp($state, 'HI') == 0) echo 'selected="selected" ' ?>>Hawaii</option>
					<option value="ID" <?php if(strcmp($state, 'ID') == 0) echo 'selected="selected" ' ?>>Idaho</option>
					<option value="IL" <?php if(strcmp($state, 'IL') == 0) echo 'selected="selected" ' ?>>Illinois</option>
					<option value="IN" <?php if(strcmp($state, 'IN') == 0) echo 'selected="selected" ' ?>>Indiana</option>
					<option value="IA" <?php if(strcmp($state, 'IA') == 0) echo 'selected="selected" ' ?>>Iowa</option>
					<option value="KS" <?php if(strcmp($state, 'KS') == 0) echo 'selected="selected" ' ?>>Kansas</option>
					<option value="KY" <?php if(strcmp($state, 'KY') == 0) echo 'selected="selected" ' ?>>Kentucky</option>
					<option value="LA" <?php if(strcmp($state, 'LA') == 0) echo 'selected="selected" ' ?>>Louisiana</option>
					<option value="ME" <?php if(strcmp($state, 'ME') == 0) echo 'selected="selected" ' ?>>Maine</option>
					<option value="MD" <?php if(strcmp($state, 'MD') == 0) echo 'selected="selected" ' ?>>Maryland</option>
					<option value="MA" <?php if(strcmp($state, 'MA') == 0) echo 'selected="selected" ' ?>>Massachusetts</option>
					<option value="MI" <?php if(strcmp($state, 'MI') == 0) echo 'selected="selected" ' ?>>Michigan</option>
					<option value="MN" <?php if(strcmp($state, 'MN') == 0) echo 'selected="selected" ' ?>>Minnesota</option>
					<option value="MS" <?php if(strcmp($state, 'MS') == 0) echo 'selected="selected" ' ?>>Mississippi</option>
					<option value="MO" <?php if(strcmp($state, 'MO') == 0) echo 'selected="selected" ' ?>>Missouri</option>
					<option value="MT" <?php if(strcmp($state, 'MT') == 0) echo 'selected="selected" ' ?>>Montana</option>
					<option value="NE" <?php if(strcmp($state, 'NE') == 0) echo 'selected="selected" ' ?>>Nebraska</option>
					<option value="NV" <?php if(strcmp($state, 'NV') == 0) echo 'selected="selected" ' ?>>Nevada</option>
					<option value="NH" <?php if(strcmp($state, 'NH') == 0) echo 'selected="selected" ' ?>>New Hampshire</option>
					<option value="NJ" <?php if(strcmp($state, 'NJ') == 0) echo 'selected="selected" ' ?>>New Jersey</option>
					<option value="NM" <?php if(strcmp($state, 'NM') == 0) echo 'selected="selected" ' ?>>New Mexico</option>
					<option value="NY" <?php if(strcmp($state, 'NY') == 0) echo 'selected="selected" ' ?>>New York</option>
					<option value="NC" <?php if(strcmp($state, 'NC') == 0) echo 'selected="selected" ' ?>>North Carolina</option>
					<option value="ND" <?php if(strcmp($state, 'ND') == 0) echo 'selected="selected" ' ?>>North Dakota</option>
					<option value="OH" <?php if(strcmp($state, 'OH') == 0) echo 'selected="selected" ' ?>>Ohio</option>
					<option value="OK" <?php if(strcmp($state, 'OK') == 0) echo 'selected="selected" ' ?>>Oklahoma</option>
					<option value="OR" <?php if(strcmp($state, 'OR') == 0) echo 'selected="selected" ' ?>>Oregon</option>
					<option value="PA" <?php if(strcmp($state, 'PA') == 0) echo 'selected="selected" ' ?>>Pennsylvania</option>
					<option value="PR" <?php if(strcmp($state, 'PR') == 0) echo 'selected="selected" ' ?>>Puerto Rico</option>
					<option value="RI" <?php if(strcmp($state, 'RI') == 0) echo 'selected="selected" ' ?>>Rhode Island</option>
					<option value="SC" <?php if(strcmp($state, 'SC') == 0) echo 'selected="selected" ' ?>>South Carolina</option>
					<option value="SD" <?php if(strcmp($state, 'SD') == 0) echo 'selected="selected" ' ?>>South Dakota</option>
					<option value="TN" <?php if(strcmp($state, 'TN') == 0) echo 'selected="selected" ' ?>>Tennessee</option>
					<option value="TX" <?php if(strcmp($state, 'TX') == 0) echo 'selected="selected" ' ?>>Texas</option>
					<option value="UT" <?php if(strcmp($state, 'UT') == 0) echo 'selected="selected" ' ?>>Utah</option>
					<option value="VT" <?php if(strcmp($state, 'VT') == 0) echo 'selected="selected" ' ?>>Vermont</option>
					<option value="VA" <?php if(strcmp($state, 'VA') == 0) echo 'selected="selected" ' ?>>Virginia</option>
					<option value="WA" <?php if(strcmp($state, 'WA') == 0) echo 'selected="selected" ' ?>>Washington</option>
					<option value="WV" <?php if(strcmp($state, 'WV') == 0) echo 'selected="selected" ' ?>>West Virginia</option>
					<option value="WI" <?php if(strcmp($state, 'WI') == 0) echo 'selected="selected" ' ?>>Wisconsin</option>
					<option value="WY" <?php if(strcmp($state, 'WY') == 0) echo 'selected="selected" ' ?>>Wyoming</option>
        			</select>
					<?php echo form_error('state'); ?>
					<br />
					<label for="zipcode">Zip Code:</label>
					<input type="text" name="zipcode" id="zipcode" value="<?php $s = set_value('zipcode'); if(strlen($s) > 1) echo $s; else echo $company_data['zipcode']; ?>" />
					<?php echo form_error('address'); ?>
					<br />
					<label for="company_contact">Contact Name:</label>
					<input type="text" name="company_contact" id="company_contact" value="<?php $s = set_value('company_contact'); if(strlen($s) > 1) echo $s; else echo $company_data['company_contact']; ?>" />
					<?php echo form_error('company_contact'); ?>
					<br />
					<label for="company_phone">Contact Phone:</label>
					<input type="text" name="company_phone" id="company_phone" value="<?php $s = set_value('company_phone'); if(strlen($s) > 1) echo $s; else echo $company_data['phone']; ?>" />
					<?php echo form_error('phone'); ?>
					<br />
					<label for="company_email">Contact Email:</label>
					<input type="text" name="company_email" id="company_email" value="<?php $s = set_value('company_email'); if(strlen($s) > 1) echo $s; else echo $company_data['email']; ?>" />
					<?php echo form_error('company_contact'); ?>
					<br />
					<input name="btn_submit_changes" id="btn_submit_changes2" src="<?php echo img_url('submit_changes.png'); ?>" type="image" alt="submit_changes" value="submit" /><br /><br />
					<br />
				</p>
			</form>
			</section>
		</div>
		<?php } ?>
		
		<div id="tabs-2">
			<h2>USER INFORMATION:</h2>
			<section>
			<?php if(isset($message) && $message != null && $message != '') echo '<br /><p class = "success">'.$message.'</p><br />'; ?>
			<form class="edit_form" method="post" id="pers_info" name="pers_info" action="<?php echo site_url('dashboard/edit_user_info'); ?>" >
				<input type="hidden" name="user_id" value="<?php echo $user_data['id']; ?>" />
				<p>
					<label for="first_name">First Name:<span class="error" style="padding:0px;">*</span></label>
					<input type="text" name="first_name" id="first_name" value="<?php $s = set_value('first_name'); if(strlen($s) > 1) echo $s; else echo $user_data['first_name']; ?>" />
					<?php echo form_error('first_name'); ?>
					<br />
					<label for="last_name">Last Name:<span class="error" style="padding:0px;">*</span></label>
					<input type="text" name="last_name" id="last_name" value="<?php $s = set_value('last_name'); if(strlen($s) > 1) echo $s; else echo $user_data['last_name']; ?>" />
					<?php echo form_error('last_name'); ?>
					<br />
					<label for="username">User Name:<span class="error" style="padding:0px;">*</span></label>
					<input type="text" name="username" id="username" value="<?php $s = set_value('username'); if(strlen($s) > 1) echo $s; else echo $user_data['username']; ?>" />
					<?php echo form_error('username'); ?>
					<br />
					<label for="phone">Cell Phone:</label>
					<input type="text" name="phone" id="phone" value="<?php $s = set_value('phone'); if(strlen($s) > 1) echo $s; else echo $user_data['phone']; ?>" /></br>
					<span style="float:left;font-size:11px;width:160px;display:inline-block;padding-left:5px;padding-right:5px;">(ex: 1234567890)</span>
					<input style="width:20px;margin-left:3px;" type="checkbox" id="phone_notifications" name="phone_notifications" value="1" <?php if(!empty($user_data['phone_notifications'])) echo 'checked="checked"'; ?> /> <span style="font-size:11px;">Send feedback to this cell phone number?</span>
					<?php echo form_error('phone', '<br /><span class="error" style="margin-left:153px;">', '</span>'); ?>
					<br />
					<div class="inline_radios" id="phone_noti_type">
						<?php if(empty($user_data['phone_noti_type'])) $user_data['phone_noti_type'] = 'all'; ?>
						<input type="radio" name="phone_noti_type" value="all" <?php if(!empty($user_data['phone_noti_type']) && $user_data['phone_noti_type'] == "all") echo 'checked="checked"'; ?> />All Comments
						<input type="radio" name="phone_noti_type" value="negative" <?php if(!empty($user_data['phone_noti_type']) && $user_data['phone_noti_type'] == "negative") echo 'checked="checked"'; ?> />Negative Only
						<input type="radio" name="phone_noti_type" value="positive" <?php if(!empty($user_data['phone_noti_type']) && $user_data['phone_noti_type'] == "positive") echo 'checked="checked"'; ?> />Positive Only
					</div>
					<br />
					<label for="email">Email:<span class="error" style="padding:0px;">*</span></label>
					<input type="text" name="email" id="email" value="<?php $s = set_value('email'); if(strlen($s) > 1) echo $s; else echo $user_data['email']; ?>" /></br>
					<input style="width:20px;margin-left:173px;" type="checkbox" id="email_notifications" name="email_notifications" value="1" <?php if(!empty($user_data['email_notifications'])) echo 'checked="checked"'; ?> /> <span style="font-size:11px;">Send feedback to this email?</span>
					<?php echo form_error('email', '<br /><span class="error" style="margin-left:153px;">', '</span>'); ?>
					<br />
					<div class="inline_radios" id="email_noti_type">
						<?php if(empty($user_data['email_noti_type'])) $user_data['email_noti_type'] = 'all'; ?>
						<input type="radio" name="email_noti_type" value="all" <?php if(!empty($user_data['email_noti_type']) && $user_data['email_noti_type'] == "all") echo 'checked="checked"'; ?> />All Comments
						<input type="radio" name="email_noti_type" value="negative" <?php if(!empty($user_data['email_noti_type']) && $user_data['email_noti_type'] == "negative") echo 'checked="checked"'; ?> />Negative Only
						<input type="radio" name="email_noti_type" value="positive" <?php if(!empty($user_data['email_noti_type']) && $user_data['email_noti_type'] == "positive") echo 'checked="checked"'; ?> />Positive Only
					</div>
					<br />
					<input name="btn_submit_changes" id="btn_submit_changes" src="<?php echo img_url('submit_changes.png'); ?>" type="image" alt="submit_changes" value="submit" /><br />
					<span class="error" style="margin-left:0px;padding-left:0px;">* required</span>
				</p>
			</form>
			</section>
		</div>
		
		<div id="tabs-3">
			<h2>CHANGE PASSWORD:</h2>
			<section>
			<form class="edit_form" id="change_pass" name="change_pass" method="post" action="<?php echo site_url('dashboard/change_password'); ?>" >
				<input type="hidden" name="user_id" value="<?php echo $user_data['id']; ?>" />
				<p>	
					<span>To change your password, enter the following:</span><br />
					<label for="Opass">Old Password:</label>
					<input type="password" name="old_password" id="Opass" />
					<?php echo form_error('old_password'); ?>
					<br />
					<label for="pass">New Password:</label>
					<input type="password" name="password" id="pass" />
					<?php echo form_error('password'); ?>
					<br />
					<label for="confirm_password">Confirm Password:</label>
					<input type="password" name="confirm" id="confirm_password" />
					<?php echo form_error('confirm'); ?>
					<br />
					<input name="btn_submit_changes" id="btn_submit_changes3" src="<?php echo img_url('submit_changes.png'); ?>" type="image" alt="submit_changes" value="submit" /><br /><br />
				</p>
			</form>
			</section>
		</div>
		
		
		<?php 
		if(!empty($company_data)) { 
			// Display the Billing and Payment Info tab 
		?>
		<?php
/*
		<div id="tabs-4">
			<h2>BILLING AND PAYMENT INFO:</h2>
			<section>
			<!-- This stuff doesn't show -->
			<script type="text/javascript" src="/assets/contentx/popup.js"></script>
			<script type="text/javascript">
				function beforePopup(e)
				{
					$("#tabs-4").hide();
					AuthorizeNetPopup.openManagePopup();
				}
				function closePanel()
				{
					$("#divAuthorizeNetPopup, #divAuthorizeNetPopupScreen").hide();
					$("#tabs-4").show();
				}
				AuthorizeNetPopup.options.onPopupClosed = function() {
  					$("#tabs-4").show();
  				};
  				
				// Uncomment this line to use test.authorize.net instead of secure.authorize.net.
  				//AuthorizeNetPopup.options.useTestEnvironment = true;
  			</script>
  			<form method="post" action="https://secure.authorize.net/hosted/profile/manage" id="formAuthorizeNetPopup" name="formAuthorizeNetPopup" target="iframeAuthorizeNet" style="display:none;">
  				<input type="hidden" name="Token" value="<?php echo $company_data['authnet_token']; ?>" />
			</form>
			<!-- End of invisible stuff -->
			<ul>
				<li>Start Date: <?php echo $company_data['plan_start']; ?></li>
				<li>Amount: <?php echo $company_data['plan_amount']; ?></li>
				<li>Billed every <?php echo $company_data['plan_months']; ?> month(s)</li>
				<?php 
					$last_billed = $company_data['plan_last_billed'];
					if($last_billed == "0000-00-00 00:00:00") $last_billed = "Never";
					else $last_billed = date("n-j-Y at g:i:s PST",strtotime($last_billed));
				?>
				<li>Last billed: <?php $last_billed; ?> month(s)</li>
			</ul>
			
			<!--<button onclick="beforePopup();">Manage my payment and information</button>-->
			</section>
		</div>
		*/
		?>
		
		
		<?php } ?>
	</article>
	<p class="content_end">&nbsp;</p>

</div>
<?php
/*
<script type="text/javascript">
var htmlBlock = '<!-- INSTRUCTIONS:';
	htmlBlock +='Put this divAuthorizeNetPopup section right before the closing </body> tag. The popup will be centered inside the whole browser window. ';
	htmlBlock +='If you want the popup to be centered inside some other element such as a div, put it inside that element.-->';
	htmlBlock +='<div id="divAuthorizeNetPopup" style="display:none;" class="AuthorizeNetPopupGrayFrameTheme">';
  	htmlBlock +='<div class="AuthorizeNetPopupOuter">';
    htmlBlock +='<div class="AuthorizeNetPopupTop">';
    htmlBlock +='<div class="AuthorizeNetPopupClose">';
    htmlBlock +='<a href="javascript:;" onclick="AuthorizeNetPopup.closePopup();" title="Close"> </a>';
    htmlBlock +='</div>';
    htmlBlock +='</div>';
    htmlBlock +='<div class="AuthorizeNetPopupInner">';
    htmlBlock +='<iframe name="iframeAuthorizeNet" id="iframeAuthorizeNet" src="/assets/contentx/empty.html" frameborder="0" scrolling="no"></iframe>';
    htmlBlock +='</div>';
    htmlBlock +='<div class="AuthorizeNetPopupBottom">';
    htmlBlock +='<button onclick="closePanel();">Close this Panel</button>';
   	htmlBlock +='</div>';
	htmlBlock +='</div>';
  	htmlBlock +='<div class="AuthorizeNetShadow AuthorizeNetShadowT"></div>';
  	htmlBlock +='<div class="AuthorizeNetShadow AuthorizeNetShadowR"></div>';
  	htmlBlock +='<div class="AuthorizeNetShadow AuthorizeNetShadowB"></div>';
  	htmlBlock +='<div class="AuthorizeNetShadow AuthorizeNetShadowL"></div>';
  	htmlBlock +='<div class="AuthorizeNetShadow AuthorizeNetShadowTR"></div>';
  	htmlBlock +='<div class="AuthorizeNetShadow AuthorizeNetShadowBR"></div>';
  	htmlBlock +='<div class="AuthorizeNetShadow AuthorizeNetShadowBL"></div>';
  	htmlBlock +='<div class="AuthorizeNetShadow AuthorizeNetShadowTL"></div>';
	htmlBlock +='</div>';

	htmlBlock +='<!-- INSTRUCTIONS:';
	htmlBlock +='Put this divAuthorizeNetPopupScreen section right before the closing </body> tag.-->';
	htmlBlock +='<div id="divAuthorizeNetPopupScreen" style="display:none;"></div>';
	htmlBlock +='</div>';
	
	$(document).ready(function(){
		$("#tabs").append(htmlBlock);
	});
</script>
*/
?>
