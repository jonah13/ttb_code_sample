<?php 
//echo '<pre>'.print_r($_POST, true).'</pre>';
$sec_contacts_number = count($list_emails_phones) - 2;
if(!empty($_POST['sec_contacts_number'])) $sec_contacts_number = $_POST['sec_contacts_number'];
if($sec_contacts_number < 0) $sec_contacts_number = 0;
?>		
	<div id="menu-content">
	<div id="content_wrapper">
		<h1>Your Email, Phone and <span class="special">Notifications</span>' Options :</h1>
		<div class="box">
			<h2>Notifications' options</h2>
			<section>
				<p>Edit your phone and email, Make the changes you want to the options and press submit</p><br />
				<?php if(!empty($reply)) echo '<p class="reply">'.$reply.'</p>'; ?>
				<form class="standard indent_0" method="post" action="<?php echo site_url('dashboard/submit_notifications_options/'); ?>" >
					<div class="primary_form" id="primary_email">
						<h3>Primary Email</h3>
						<p>
							<label for="email">Primary Email:</label>
							<input type="text" name="email" id="email" value="<?php echo set_value('email', $user_data['email']); ?>" />
							<?php echo form_error('email'); ?>
							<br />
							<label for="pe_noti_for">Receive Notifications for:</label>
							<?php $notify_for = 'all'; if(!empty($list_emails_phones[$user_data['email']]['notify_for'])) $notify_for = $list_emails_phones[$user_data['email']]['notify_for']; ?>
						  None: <input type="radio" class="radio" name="pe_noti_for" value="none" <?php if(strcmp($notify_for, 'none') == 0) echo 'checked="checked"';?>> 
							All: <input type="radio" class="radio" name="pe_noti_for" value="all"  <?php if(strcmp($notify_for, 'all') == 0) echo 'checked="checked"';?>>  
							positive Only: <input type="radio" class="radio" name="pe_noti_for" value="positive"  <?php if(strcmp($notify_for, 'positive') == 0) echo 'checked="checked"';?>> 
							Negative Only: <input type="radio" class="radio" name="pe_noti_for" value="negative"  <?php if(strcmp($notify_for, 'negative') == 0) echo 'checked="checked"';?>> <br/><br/>
							<?php echo form_error('pe_noti_for'); ?>
							<br />
						</p>
					</div>
					<div class="primary_form" id="primary_phone">
						<h3>Primary Phone</h3>
						<p>
							<label for="email">Primary Phone:</label>
							<input type="text" name="phone" id="phone" value="<?php echo set_value('phone', $user_data['phone']); ?>" />
							<?php echo form_error('phone'); ?>
							<br />
							<label for="pf_noti_for">Receive Notifications for:</label>
							<?php $notify_for = 'all'; if(!empty($list_emails_phones[$user_data['phone']]['notify_for'])) $notify_for = $list_emails_phones[$user_data['phone']]['notify_for']; ?>
							None: <input type="radio" class="radio" name="pf_noti_for" value="none" <?php if(strcmp($notify_for, 'none') == 0) echo 'checked="checked"';?>>
							All: <input type="radio" class="radio" name="pf_noti_for" value="all"  <?php if(strcmp($notify_for, 'all') == 0) echo 'checked="checked"';?>>
							positive Only: <input type="radio" class="radio" name="pf_noti_for" value="positive"  <?php if(strcmp($notify_for, 'positive') == 0) echo 'checked="checked"';?>>
							Negative Only: <input type="radio" class="radio" name="pf_noti_for" value="negative"  <?php if(strcmp($notify_for, 'negative') == 0) echo 'checked="checked"';?>> <br/><br/>
							<?php echo form_error('pf_noti_for'); ?>
							<br />
						</p>
					</div>
					
					<p>
						<input name="btn_submit" class="btn_submit" type="submit" value="Submit" />
					</p>
				</form>
			</section>
		</div>
	</div>
	<p class="content_end">&nbsp;</p>
					
			</div>
		</div>
	</div><!-- #body -->
	