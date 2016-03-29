<?php 
//echo '<pre>'.print_r($_POST, true).'</pre>';
$sec_contacts_number = count($list_emails_phones) - 2;
if(!empty($_POST['sec_contacts_number'])) $sec_contacts_number = $_POST['sec_contacts_number'];
if($sec_contacts_number < 0) $sec_contacts_number = 0;
?>		
	<div id="menu-content">
	<div id="content_wrapper">
		<h1>Manage <span class="special"><?php echo $user_data['username']; ?></span>'s emails, phones and notifications' options :</h1>
		<div class="box">
			<h2>Phones, Emails and Notifications' options</h2>
			<section>
				<p>Add, Edit or Delete phones and emails for <?php echo $user_data['username']?>, Make the changes you want to the options and press submit</p><br />
				<?php if(!empty($reply)) echo '<p class="reply">'.$reply.'</p>'; ?>
				<form class="standard indent_0" method="post" action="<?php echo site_url('admin_users/submit_manage_notifications/'.$user_data['ID'].'/'); ?>" >
					<?php echo validation_errors(); ?>
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
					<div id="sec_contacts_container">
					<?php 
					for($i = 1; $i <= $sec_contacts_number; $i++)
					{
						if(empty($phones_emails[$i]))
						{
							$phones_emails[$i+1]['primary'] = 0;
							$phones_emails[$i+1]['notify_for'] = $_POST['ef_noti_for_'.$i];
							$phones_emails[$i+1]['contact'] = $_POST['email_phone_'.$i];
						}
						if($phones_emails[$i+1]['primary'] != 1)
						{
							if(empty($phones_emails[$i+1]['notify_for']))
								$phones_emails[$i+1]['notify_for'] = 'none';
							$none = '';
							if(strcmp($phones_emails[$i+1]['notify_for'], 'none') == 0)
								$none = 'checked="checked"';
							$all = '';
							if(strcmp($phones_emails[$i+1]['notify_for'], 'all') == 0)
								$all = 'checked="checked"';
							$pos = '';
							if(strcmp($phones_emails[$i+1]['notify_for'], 'positive') == 0)
								$pos = 'checked="checked"';
							$neg = '';
							if(strcmp($phones_emails[$i+1]['notify_for'], 'negative') == 0)
								$neg = 'checked="checked"';
							echo '<div class="primary_form" id="sec_contact_'.$i.'" style="padding-bottom:46px;">
											<h3>Secondary Phone or email '.$i.' : </h3>
											<p>
												<label for="email_phone_'.$i.'">Email or Phone number:</label>
												<input type="text" name="email_phone_'.$i.'" id="email_phone_'.$i.'" value="'.$phones_emails[$i+1]['contact'].'" />'.form_error('email_phone_'.$i).'
												<br />
												<label for="ef_noti_for_'.$i.'">Receive Notifications for:</label>
												None: <input type="radio" class="radio" name="ef_noti_for_'.$i.'" value="none" '.$none.'>
												All: <input type="radio" class="radio" name="ef_noti_for_'.$i.'" value="all" '.$all.'>
												positive Only: <input type="radio" class="radio" name="ef_noti_for_'.$i.'" value="positive" '.$pos.'>
												Negative Only: <input type="radio" class="radio" name="ef_noti_for_'.$i.'" value="negative" '.$neg.'>
												<br />
										  </p>';
							if($i == $sec_contacts_number)
								echo '<a href="#" id="delete_sec_contact" class="btn" style="color:#F97575; border:1px solid #F97575; display:block; float:right; width:220px; height:20px; text-align:center;" >Delete this Phone/Email</a>';
								echo '</div>';
						}
					}
					?>
					</div>
					
					<p>
						<!--<a style="display:block; width:220px; height:20px; text-align:center; margin-left:22%;" class="btn" href="#" id="add_new_phone_email">Add a New Phone or Email</a> 
						<span style="display:block; margin-left:22%; font-weight:bold; font-size:15px; color:#777;">Or </span>
						
						<input id="sec_contacts_number" name="sec_contacts_number" type="hidden" value="<?php echo $sec_contacts_number; ?>" />-->
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
	
						
	
<script type="text/javascript">

function add_new_phone_email()
{
	var $n_contacts = parseInt($('#sec_contacts_number').val());
	
	$n_contacts += 1;
	$('#sec_contacts_number').val($n_contacts);
	
	$('<div class="primary_form" id="sec_contact_'+$n_contacts+'" style="padding-bottom:46px;">'+
		'  <h3>Secondary Phone or email '+$n_contacts+' : </h3>'+	
		'	 <p>'+	
		'			<label for="email_phone_'+$n_contacts+'">Email or Phone number:</label>'+	
		'			<input type="text" name="email_phone_'+$n_contacts+'" id="email_phone_'+$n_contacts+'" />'+	
		'     <br />'+	
		'			<label for="ef_noti_for_'+$n_contacts+'">Receive Notifications for:</label>'+
		'			None: <input type="radio" class="radio" name="ef_noti_for_'+$n_contacts+'" value="none">'+
		'			All: <input type="radio" class="radio" name="ef_noti_for_'+$n_contacts+'" value="all" checked="checked">'+
		'			positive Only: <input type="radio" class="radio" name="ef_noti_for_'+$n_contacts+'" value="positive">'+
		'			Negative Only: <input type="radio" class="radio" name="ef_noti_for_'+$n_contacts+'" value="negative">'+
		'			<br />'+
		'  </p>'+	
		'</div>').appendTo('#sec_contacts_container').hide().slideDown();
		
		$('#delete_sec_contact').remove();
		$('<a href="#" id="delete_sec_contact" class="btn" style="color:#F97575; border:1px solid #F97575; display:block; float:right; width:220px; height:20px; text-align:center;" >Delete this Phone/Email</a>').click(function(){
			remove_sec_contact_box();
			return false;
		}).appendTo('#sec_contact_'+$n_contacts);
}

function remove_sec_contact_box()
{
	var $n_contacts = parseInt($('#sec_contacts_number').val());
	$n_contacts -= 1;
	if($n_contacts == 0)
	{
		$('#delete_sec_contact').parent().slideUp(function(){ $(this).remove(); });
		$('#sec_contacts_number').val($n_contacts);
	}
	else if($n_contacts > 0)
	{
		$('#delete_sec_contact').parent().slideUp(function(){
			$('#delete_sec_contact').appendTo('#sec_contact_'+$n_contacts);
			$(this).remove();
		});
		$('#sec_contacts_number').val($n_contacts);
	}
}

$(document).ready(function()
{
	$('#add_new_phone_email').live('click', function(){
		add_new_phone_email();
		return false;
	});
	
	$('#delete_sec_contact').live('click', function(){
		remove_sec_contact_box();
		return false;
	});
	
});
</script>