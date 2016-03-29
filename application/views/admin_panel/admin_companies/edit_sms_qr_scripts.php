<?php 
	//echo '<pre>' . print_r($text, true) . '</pre>';
	$sms_first_reply = SMS_FIRST_REPLY; if(!empty($company['sms_first_reply'])) $sms_first_reply = $company['sms_first_reply'];
	$sms_last_reply = SMS_LAST_REPLY; if(!empty($company['sms_last_reply'])) $sms_last_reply = $company['sms_last_reply'];
	$qr_header = QR_HEADER; if(!empty($company['qr_header'])) $qr_header = $company['qr_header'];
	$qr_comment_label = QR_COMMENT_LABEL; if(!empty($company['qr_comment_label'])) $qr_comment_label = $company['qr_comment_label'];
	$qr_success_text = QR_SUCCESS_TEXT; if(!empty($company['qr_success_text'])) $qr_success_text = $company['qr_success_text'];
	
	$s_body_bg_type = 'gradient'; if(!empty($company['s_body_bg_type'])) $s_body_bg_type = $company['s_body_bg_type'];
	$s_body_bg1 = S_BODY_BG1; if(!empty($company['s_body_bg1'])) $s_body_bg1 = $company['s_body_bg1'];
	$s_body_bg2 = S_BODY_BG2; if(!empty($company['s_body_bg2'])) $s_body_bg2 = $company['s_body_bg2'];
	$s_header_bg_type = 'gradient'; if(!empty($company['s_header_bg_type'])) $s_header_bg_type = $company['s_header_bg_type'];
	$s_header_bg1 = S_HEADER_BG1; if(!empty($company['s_header_bg1'])) $s_header_bg1 = $company['s_header_bg1'];
	$s_header_bg2 = S_HEADER_BG2; if(!empty($company['s_header_bg2'])) $s_header_bg2 = $company['s_header_bg2'];
	$s_header_fcolor = S_HEADER_FCOLOR; if(!empty($company['s_header_fcolor'])) $s_header_fcolor = $company['s_header_fcolor'];
	$s_header_ffamily = S_HEADER_FFAMILY; if(!empty($company['s_header_ffamily'])) $s_header_ffamily = $company['s_header_ffamily'];
	$s_header_fsize = S_HEADER_FSIZE; if(!empty($company['s_header_fsize'])) $s_header_fsize = $company['s_header_fsize'];
	$s_labels_fcolor = S_LABELS_FCOLOR; if(!empty($company['s_labels_fcolor'])) $s_labels_fcolor = $company['s_labels_fcolor'];
	$s_labels_ffamily = S_LABELS_FFAMILY; if(!empty($company['s_labels_ffamily'])) $s_labels_ffamily = $company['s_labels_ffamily'];
	$s_labels_fsize = S_LABELS_FSIZE; if(!empty($company['s_labels_fsize'])) $s_labels_fsize = $company['s_labels_fsize'];
?>
			<div id="menu-content">
				<div id="content_wrapper">
				<h1>Edit SMS and QR scripts for <span class="special"><?php echo $company['name']; ?></span> :</h1>
				<p>Welcome to this customization tool, from here you can add a custom field to collect extra data for "<?php echo $company['name']; ?>". You can also edit the QR form style and text for QR form and the text for SMS messages. Make sure to submit your changes if you like what you see in the preview.</p>
				<p>P.S. : You can use the following keywords and they will be replaced by their respective value: <strong>#code</strong>, <strong>#company_name</strong>, <strong>#location_name</strong>, <strong>#description</strong>, <strong>#date+X</strong> (#date+X will be replaced with the date of X days from the current day).</p>
				<p>You can also use hyper links (for example: http://www.telltheboss.com) and they will be replaced by actual links</p>
		<br/>
		<?php if(!empty($reply)) echo '<p class="reply">'.$reply.'</p>'; ?>
		<form class="standard indent_0" method="post" action="<?php echo site_url('admin_companies/submit_edit_sms_qr_scripts/'.$company['ID']); ?>" enctype="multipart/form-data">
			<div style="width:400px; float:right;">
				<div class="box">
					<h2>SMS Preview</h2>
					<section>
						<p>
						<strong>Client: </strong><em>CODE</em><br/>
						<span id="custom_field_sms_msg"></span>
						<strong>22121:</strong><span id="sms_first_response_text"><?php echo $sms_first_reply; ?></span><br/>
						<strong>Client: </strong><em> Feedback comment</em><br/>
						<strong>22121:</strong><span id="sms_last_response_text"><?php echo $sms_last_reply; ?></span><br/>
					</p>
					</section>
				</div>
				<div class="box">
					<h2>QR Preview</h2>
					<section>
						<div id="smartphone">
							<div id="smartphone_screen_bg"></div>
							<div id="smartphone_screen">
								<div class="header_bar"><h4><?php echo $company['name']; ?> - CODE</h4></div>
								<p class="label_place label1">Your Feedback Comment:</p>
								<p class="label_place label2"></p>
								<p class="footer_p">Powered by TellTheBoss.com <br/> 
								<a href="<?php echo site_url('mobile_terms_conditions'); ?>">Terms &amp; Conditions</a> | <a href="<?php echo site_url('privacy_policy'); ?>"> Privacy Policy</a></p>
								<p class="copyright">Copyright &copy; 2012, All Rights Reserved</p>
							</div>
						</div>
						<br/>
						<h3>QR form Success Message</h3>
						<p id="qr_success_message_text"></p>
					</section>
				</div>
				<div class="box">
					<h2>Submit Changes</h2>
					<section>
						<p>When you're done editing SMS and QR forms text and style, Press the submit button:</p>
						<input name="btn_submit" class="btn_submit" type="submit" value="Submit Changes" style="display:block; margin:0 auto; margin-top:10px; cursor:pointer;" />
					</section>
				</div>
			</div>
			<div style="margin-right:406px;">
				<div class="box">
					<h2>Customize SMS and QR Forms' Text</h2>
					<section>
						<p>
							<label for="sms_first_reply">The First Response from TellTheBoss to the customer:</label><br/>
							<input type="text" name="sms_first_reply" id="sms_first_reply" class="sms_text text" value="<?php echo set_value('sms_first_reply', $sms_first_reply); ?>" />
							<?php echo form_error('sms_first_reply'); ?>
							<br />
							<label for="sms_last_reply">The Final Response from TellTheBoss to the customer:</label><br/>
							<input type="text" name="sms_last_reply" id="sms_last_reply" class="sms_text text" value="<?php echo set_value('sms_last_reply', $sms_last_reply); ?>" />
							<?php echo form_error('sms_last_reply'); ?>
							<br />
							<label for="qr_header">The Text for the header of the QR form:</label><br/>
							<input type="text" name="qr_header" id="qr_header" class="qr_text text" value="<?php echo set_value('qr_header', $qr_header); ?>" />
							<?php echo form_error('qr_header'); ?>
							<br />
							<label for="qr_comment_label">The Text label before the Comment field:</label><br/>
							<input type="text" name="qr_comment_label" id="qr_comment_label" class="qr_text text" value="<?php echo set_value('qr_comment_label', $qr_comment_label);  ?>" />
							<?php echo form_error('qr_comment_label'); ?>
							<br />
							<label for="qr_success_text">The QR form Success Reply After Submitting the form:</label><br/>
							<input type="text" name="qr_success_text" id="qr_success_text" class="qr_text text" value="<?php echo set_value('qr_success_text', $qr_success_text);  ?>" />
							<?php echo form_error('qr_success_text'); ?>
							<br />
							<a href="#" id="reset_default_text" class="btn">Reset Text to Default</a><br/><br/>
						</p>
					</section>
				</div>
				
				<div class="box customize_style">
					<h2>Customize QR form Style</h2>
					<section>
					<p>
						<label for="s_header_logo">Header Logo :</label>
						<input type="file" name="s_header_logo" id="s_header_logo" class="upload" />
						<?php if(!empty($img_error['logo'])) echo $img_error['logo'];?>
						<br />
						<?php if(!empty($company['s_header_logo'])) echo '<span class="note">This company already has a logo background picture uploaded<br/>upload a different one to overwrite it or <a href="#" id="toggle_delete">click here to remove it</a>!</span><br/>'; ?>
						<input type="hidden" name="s_delete_logo" id="s_delete_logo" value="false" />
							
						<label for="s_header_bg_type">Header Background Type:</label>
						<select name="s_header_bg_type" id="s_header_bg_type">
							<?php 
							$ff = $s_header_bg_type; 
							if(!empty($_POST['s_header_bg_type'])) $ff = $_POST['s_header_bg_type'];
							?>
							<option value="gradient" <?php if(strcmp($ff, 'gradient') == 0) echo 'selected="selected" ' ?>>Gradient of 2 Colors</option>
							<option value="picture" <?php if(strcmp($ff, 'picture') == 0) echo 'selected="selected" ' ?>>Background Picture</option>
						</select>
						<?php echo form_error('s_header_bg_type'); ?>
						<br/>
						<div id="header_bg_picture">
							<label for="s_header_bg_pic">Header Background Picture :</label>
							<input type="file" name="s_header_bg_pic" id="s_header_bg_pic" class="upload" />
							<?php if(!empty($img_error['header'])) echo $img_error['header'];?>
							<br />
							<?php if(!empty($company['s_header_bg_pic'])) echo '<span class="note">This company already has a header background picture uploaded, upload a different one to overwrite it!</span><br/>'; ?>
						</div>
						<div id="header_bg_gradient">
							<label for="s_header_bg1">Header Background Color 1:</label>
							<input type="text" name="s_header_bg1" id="s_header_bg1" class="color-picker" value="<?php echo set_value('s_header_bg1', $s_header_bg1); ?>" />
							<?php echo form_error('s_header_bg1'); ?>
							<br />
							<label for="s_header_bg2">Header Background Color 2:</label>
							<input type="text" name="s_header_bg2" id="s_header_bg2" class="color-picker" value="<?php echo set_value('s_header_bg2', $s_header_bg2); ?>" />
							<?php echo form_error('s_header_bg2'); ?>
							<br />
						</div>
						
						<label for="s_body_bg_type">Body Background Type:</label>
						<select name="s_body_bg_type" id="s_body_bg_type">
							<?php 
							$ff = $s_body_bg_type; 
							if(!empty($_POST['s_body_bg_type'])) $ff = $_POST['s_body_bg_type'];
							?>
							<option value="gradient" <?php if(strcmp($ff, 'gradient') == 0) echo 'selected="selected" ' ?>>Gradient of 2 Colors</option>
							<option value="picture" <?php if(strcmp($ff, 'picture') == 0) echo 'selected="selected" ' ?>>Background Picture</option>
						</select>
						<?php echo form_error('s_body_bg_type'); ?>
						<br/>
						<div id="body_bg_picture">
							<label for="s_body_bg_pic">Body Background Picture :</label>
							<input type="file" name="s_body_bg_pic" id="s_body_bg_pic" class="upload" />
							<?php if(!empty($img_error['body'])) echo $img_error['body'];?>
							<br />
							<?php if(!empty($company['s_body_bg_pic'])) echo '<span class="note">This company already has a body background picture uploaded, upload a different one to overwrite it!</span><br/>'; ?>
						</div>
						<div id="body_bg_gradient">
							<label for="s_body_bg1">Body Background Color 1:</label>
							<input type="text" name="s_body_bg1" id="s_body_bg1" class="color-picker" value="<?php echo set_value('s_body_bg1', $s_body_bg1); ?>" />
							<?php echo form_error('s_body_bg1'); ?>
							<br />
							<label for="s_body_bg2">Body Background Color 2:</label>
							<input type="text" name="s_body_bg2" id="s_body_bg2" class="color-picker" value="<?php echo set_value('s_body_bg2', $s_body_bg2); ?>" />
							<?php echo form_error('s_body_bg2'); ?>
							<br />
						</div>
						<label for="s_header_fcolor">Header Font Color:</label>
						<input type="text" name="s_header_fcolor" id="s_header_fcolor" class="color-picker" value="<?php echo set_value('s_header_fcolor', $s_header_fcolor); ?>" />
						<?php echo form_error('s_header_fcolor', S_HEADER_FCOLOR); ?>
						<br />
						<label for="s_header_ffamily">Header Font family:</label>
						<select name="s_header_ffamily" id="s_header_ffamily" class="font-picker">
							<?php 
							$ff = $s_header_ffamily; 
							if(!empty($_POST['s_header_ffamily'])) $ff = $_POST['s_header_ffamily'];
							?>
							<option value="Arial" <?php if(strcmp($ff, 'arial') == 0) echo 'selected="selected" ' ?>>Arial</option>
							<option value="arial black" <?php if(strcmp($ff, 'arial black') == 0) echo 'selected="selected" ' ?>>Arial Black</option>
							<option value="comic sans ms" <?php if(strcmp($ff, 'comic sans ms') == 0) echo 'selected="selected" ' ?>>Comic Sans MS</option>
							<option value="courier new" <?php if(strcmp($ff, 'courier new') == 0) echo 'selected="selected" ' ?>>Courier New</option>
							<option value="helvetica" <?php if(strcmp($ff, 'helvetica') == 0) echo 'selected="selected" ' ?>>Helvetica</option>
							<option value="geneva" <?php if(strcmp($ff, 'geneva') == 0) echo 'selected="selected" ' ?>>Geneva</option>
							<option value="georgia" <?php if(strcmp($ff, 'georgia') == 0) echo 'selected="selected" ' ?>>Georgia</option>
							<option value="impact" <?php if(strcmp($ff, 'impact') == 0) echo 'selected="selected" ' ?>>Impact</option>
							<option value="lucida console" <?php if(strcmp($ff, 'lucida console') == 0) echo 'selected="selected" ' ?>>Lucida Console</option>
							<option value="lucida grande" <?php if(strcmp($ff, 'lucida grande') == 0) echo 'selected="selected" ' ?>>Lucida Grande</option>
							<option value="lucida sans unicode" <?php if(strcmp($ff, 'lucida sans unicode') == 0) echo 'selected="selected" ' ?>>Lucida Sans Unicode</option>
							<option value="monaco" <?php if(strcmp($ff, 'monaco') == 0) echo 'selected="selected" ' ?>>Monaco</option>
							<option value="palatino" <?php if(strcmp($ff, 'palatino') == 0) echo 'selected="selected" ' ?>>Palatino</option>
							<option value="palatino linotype" <?php if(strcmp($ff, 'palatino linotype') == 0) echo 'selected="selected" ' ?>>Palatino Linotype</option>
							<option value="tahoma" <?php if(strcmp($ff, 'tahoma') == 0) echo 'selected="selected" ' ?>>Tahoma</option>
							<option value="times" <?php if(strcmp($ff, 'times') == 0) echo 'selected="selected" ' ?>>Times</option>
							<option value="times new roman" <?php if(strcmp($ff, 'times new roman') == 0) echo 'selected="selected" ' ?>>Times New Roman</option>
							<option value="trebuchet ms" <?php if(strcmp($ff, 'trebuchet ms') == 0) echo 'selected="selected" ' ?>>Trebuchet MS</option>
							<option value="verdana" <?php if(strcmp($ff, 'verdana') == 0) echo 'selected="selected" ' ?>>Verdana</option>
						</select>
						<?php echo form_error('s_header_ffamily'); ?>
						<br />
						<label for="s_header_fsize">Header Font Size in Pixels:</label>
						<input type="number" name="s_header_fsize" id="s_header_fsize" min="5" max="35" value="<?php echo set_value('s_header_fsize', $s_header_fsize); ?>" />
						<?php echo form_error('s_header_fsize'); ?>
						<br />
						<label for="s_labels_fcolor">Labels Font Color:</label>
						<input type="text" name="s_labels_fcolor" id="s_labels_fcolor" class="color-picker" value="<?php echo set_value('s_labels_fcolor', $s_labels_fcolor); ?>" />
						<?php echo form_error('s_labels_fcolor', S_LABELS_FCOLOR); ?>
						<br />
						<label for="s_labels_ffamily">Labels Font family:</label>
						<select name="s_labels_ffamily" id="s_labels_ffamily" class="font-picker">
							<?php 
							$ff = $s_labels_ffamily; 
							if(!empty($_POST['s_labels_ffamily'])) $ff = $_POST['s_labels_ffamily'];
							?>
							<option value="Arial" <?php if(strcmp($ff, 'arial') == 0) echo 'selected="selected" ' ?>>Arial</option>
							<option value="arial black" <?php if(strcmp($ff, 'arial black') == 0) echo 'selected="selected" ' ?>>Arial Black</option>
							<option value="comic sans ms" <?php if(strcmp($ff, 'comic sans ms') == 0) echo 'selected="selected" ' ?>>Comic Sans MS</option>
							<option value="courier new" <?php if(strcmp($ff, 'courier new') == 0) echo 'selected="selected" ' ?>>Courier New</option>
							<option value="helvetica" <?php if(strcmp($ff, 'helvetica') == 0) echo 'selected="selected" ' ?>>Helvetica</option>
							<option value="geneva" <?php if(strcmp($ff, 'geneva') == 0) echo 'selected="selected" ' ?>>Geneva</option>
							<option value="georgia" <?php if(strcmp($ff, 'georgia') == 0) echo 'selected="selected" ' ?>>Georgia</option>
							<option value="impact" <?php if(strcmp($ff, 'impact') == 0) echo 'selected="selected" ' ?>>Impact</option>
							<option value="lucida console" <?php if(strcmp($ff, 'lucida console') == 0) echo 'selected="selected" ' ?>>Lucida Console</option>
							<option value="lucida grande" <?php if(strcmp($ff, 'lucida grande') == 0) echo 'selected="selected" ' ?>>Lucida Grande</option>
							<option value="lucida sans unicode" <?php if(strcmp($ff, 'lucida sans unicode') == 0) echo 'selected="selected" ' ?>>Lucida Sans Unicode</option>
							<option value="monaco" <?php if(strcmp($ff, 'monaco') == 0) echo 'selected="selected" ' ?>>Monaco</option>
							<option value="palatino" <?php if(strcmp($ff, 'palatino') == 0) echo 'selected="selected" ' ?>>Palatino</option>
							<option value="palatino linotype" <?php if(strcmp($ff, 'palatino linotype') == 0) echo 'selected="selected" ' ?>>Palatino Linotype</option>
							<option value="tahoma" <?php if(strcmp($ff, 'tahoma') == 0) echo 'selected="selected" ' ?>>Tahoma</option>
							<option value="times" <?php if(strcmp($ff, 'times') == 0) echo 'selected="selected" ' ?>>Times</option>
							<option value="times new roman" <?php if(strcmp($ff, 'times new roman') == 0) echo 'selected="selected" ' ?>>Times New Roman</option>
							<option value="trebuchet ms" <?php if(strcmp($ff, 'trebuchet ms') == 0) echo 'selected="selected" ' ?>>Trebuchet MS</option>
							<option value="verdana" <?php if(strcmp($ff, 'verdana') == 0) echo 'selected="selected" ' ?>>Verdana</option>
						</select>
						<?php echo form_error('s_labels_ffamily'); ?>
						<br />
						<label for="s_labels_fsize">Labels Font Size in Pixels:</label>
						<input type="number" name="s_labels_fsize" id="s_labels_fsize" min="5" max="35" value="<?php echo set_value('s_labels_fsize', $s_labels_fsize); ?>" />
						<?php echo form_error('s_labels_fsize'); ?>
						<br />
				
						<a href="#" id="reset_default_style" class="btn">Reset Style to Default</a><br /><br />
					</p>
					</section>
				</div>
				
				<div class="box">
					<h2>Custom Field</h2>
					<section>
						<p>You can, edit or delete the first and second custom field for this company from here</p>
						<?php 
							if(empty($company['cf_asked_for']) || strcmp($company['cf_asked_for'], 'none') == 0) 
							{
								echo '<p>This company doesn\'t have any custom field data</p>';
								$cf = false;
								$cf2 = false;
							}
							else
							{
								$cf = true;
								if(empty($company['cf2_asked_for']) || strcmp($company['cf2_asked_for'], 'none') == 0) 
									$cf2 = false;
								else
									$cf2 = true;
							}
						?>
						<input name="cf_exists" id="cf_exists" type="hidden" value="<?php if($cf) echo 'true'; else echo 'false';?>" />
						<input name="cf2_exists" id="cf2_exists" type="hidden" value="<?php if($cf2) echo 'true'; else echo 'false';?>" />
						
						<div id="cf_box">
							<label for="cf_asked_for" style="display:inline-block; width:240px;">Custom Field will be Asked for:</label>
							<select name="cf_asked_for" id="cf_asked_for" style="width:155px; font-weight:normal; font-weight:bold; color:#666; font-size:11px; line-height:25px; height:25px; margin:5px; padding-left:4px; font-family:Arial;">
								<?php 
								$asked_for = $company['cf_asked_for']; 
								if(empty($qr_sms)) $qr_sms = "qr";
								if(!empty($_POST['cf_asked_for'])) $ff = $_POST['cf_asked_for'];
								?>
								<option value="both" <?php if(strcmp($asked_for, 'both') == 0) echo 'selected="selected" ' ?>>Both SMS and QR form</option>
								<option value="qr" <?php if(strcmp($asked_for, 'qr') == 0) echo 'selected="selected" ' ?>>Only QR form</option>
								<option value="sms" <?php if(strcmp($asked_for, 'sms') == 0) echo 'selected="selected" ' ?>>Only SMS</option>
							</select>
							<br />
							<label for="cf_type">What type of data can we expect in this field? (ex: Email, Suite, Phone, Text, ...)</label><br/>
							<input type="text" name="cf_type" id="cf_type" class="custom_text text" value="<?php $s = set_value('cf_type', $company['cf_type']); if(!empty($s)) echo $s; else echo 'Email'; ?>" />
							<br />
							<span id="cf_asked_for_qr">
								<label for="cf_qr_label">QR form Label Text for the Custom Field: (See QR form Preview)</label><br/>
								<input type="text" name="cf_qr_label" id="cf_qr_label" class="custom_text text" value="<?php $s = set_value('cf_qr_label', $company['cf_qr_label']); if(!empty($s)) echo $s; else echo 'Enter your email if you would like to be contacted:'; ?>" />
								<br />
								<?php if(!empty($company['cf_required'])) $required = 'true'; else $required = 'false'; ?>
								<input type="radio" class="inline" name="cf_required" value="true" <?php if(strcmp($required, 'true') == 0) echo 'checked="checked"';?>> Required  -  <input type="radio" class="inline" name="cf_required" value="false"  <?php if(strcmp($required, 'true') != 0) echo 'checked="checked"';?>>Optional<br/><br/>
								<label for="cf_pos_before">Custom Field Position: (See QR form Preview)</label><br/>
								<?php $position = 'before'; if(!empty($company['cf_pos'])) $position = $company['cf_pos']; ?>
								<input type="radio" class="inline cf_pos" name="cf_pos" id="cf_pos_before" value="before" <?php if(strcmp($position, 'before') == 0) echo 'checked="checked"';?>> Before Comment Field  -  <input type="radio" class="inline cf_pos" name="cf_pos" id="cf_pos_after" value="after"  <?php if(strcmp($position, 'after') == 0) echo 'checked="checked"';?>>After Comment Field<br/>
								<br/>
							</span>
							<span id="cf_asked_for_sms">
								<label for="cf_sms_text">SMS Inviting Message for the Custom Field: (See SMS messages preview)</label><br/>
								<input type="text" name="cf_sms_text" id="cf_sms_text" class="custom_text text" value="<?php $s = set_value('cf_sms_text', $company['cf_sms_text']); if(!empty($s)) echo $s; else echo 'Send us your email if you would like to be contacted:'; ?>" />
								<br />
							</span>
				
							<br class="clear_float"/>
							<br/>
							
							<div id="cf2_box" class="primary_form" style="padding-bottom:56px;">
								<label for="cf2_type">What type of data can we expect in this 2nd custom field? (ex: Email, Suite, Phone, or Text)</label><br/>
								<input type="text" name="cf2_type" id="cf2_type" class="custom_text text" value="<?php $s = set_value('cf2_type', $company['cf2_type']); if(!empty($s)) echo $s; else echo 'Phone'; ?>" />
								<br />
								<label for="cf2_qr_label">QR form Label Text for the Second Custom Field: </label><br/>
								<input type="text" name="cf2_qr_label" id="cf2_qr_label" class="custom_text text" value="<?php $s = set_value('cf2_qr_label', $company['cf2_qr_label']); if(!empty($s)) echo $s; else echo 'Enter your phone if you would like to be contacted:'; ?>" />
								<br />
								<?php if(!empty($company['cf2_required'])) $required = 'true'; else $required = 'false'; ?>
								<input type="radio" class="inline" name="cf2_required" value="true" <?php if(strcmp($required, 'true') == 0) echo 'checked="checked"';?>> Required  -  <input type="radio" class="inline" name="cf2_required" value="false"  <?php if(strcmp($required, 'true') != 0) echo 'checked="checked"';?>>Optional<br/><br/>
								<label for="cf2_pos_before">Second Custom Field Position: </label><br/>
								<?php $position = 'before'; if(!empty($company['cf2_pos'])) $position = $company['cf2_pos']; ?>
								<input type="radio" class="inline cf2_pos" name="cf2_pos" id="cf2_pos_before" value="before" <?php if(strcmp($position, 'before') == 0) echo 'checked="checked"';?>> Before Comment Field  -  <input type="radio" class="inline cf2_pos" name="cf2_pos" id="cf2_pos_after" value="after"  <?php if(strcmp($position, 'after') == 0) echo 'checked="checked"';?>>After Comment Field<br/>
								<br/>
							</div>
						</div>
						<br/>
						<br/>
						<input name="val_company_name" id="val_company_name" type="hidden" value="<?php echo $company['name'];?>" />
						<input name="val_header_bg_pic" id="val_header_bg_pic" type="hidden" value="<?php if(!empty($company['s_header_bg_pic'])) echo $company['s_header_bg_pic'];?>" />
						<input name="val_body_bg_pic" id="val_body_bg_pic" type="hidden" value="<?php if(!empty($company['s_body_bg_pic'])) echo $company['s_body_bg_pic'];?>" />
					</section>
				</div>
			</div>
			


				</div>
			</div>
		</div>
	</div><!-- #body -->
	
<script>
function update_cf_visibility()
{	
	$('#cf_box').hide();
	$('#add_cf').remove();
	$('#add_cf2').remove();
	$('#delete_cf').remove();
	$('#delete_cf2').remove();
	var cf_exists = $('input#cf_exists').val();
	var cf2_exists = $('input#cf2_exists').val();
	
	if(cf_exists == "true")
	{
		$('#cf_box').show();
		$('#cf2_box').hide();
		if(cf2_exists == "true")
		{
			$('#cf2_box').show();
			$('<a href="#" id="delete_cf2" class="btn" style="color:#F97575; border:1px solid #F97575; display:block; float:right; width:220px; height:20px; text-align:center;" >Delete 2nd Custom Field</a>').bind('click', function() { delete_cf2(); return false; }).appendTo('#cf2_box');
		}
		else
		{
			$('<a href="#" id="add_cf2" class="btn" style="display:block; float:right; height:20px;" >Add Second Custom Field</a>').bind('click', function(){ add_cf2(); return false;}).insertBefore('#cf2_box');
			$('<a href="#" id="delete_cf" class="btn delete_btn">Delete Custom Field</a>').bind('click', function() { delete_cf(); return false; }).appendTo('#cf_box');
		}
	}
	else
		$('<a href="#" id="add_cf" class="btn" style="display:block; float:right; height:20px;" >Add Customm Field</a>').bind('click', function(){ add_cf(); return false;}).insertBefore('#cf_box');
}

function add_cf()
{
	$('input#cf_exists').val('true');
	update_cf_visibility();
}

function add_cf2()
{
	$('input#cf2_exists').val('true');
	update_cf_visibility();
}

function delete_cf()
{
	var r = confirm("Confirm deleting: Are you sure you want to delete the custom fields for this company? the company will have no custom fields upon submission!");
	if (!r)  return false;
	else
	{
		$('input#cf_exists').val('false');
		$('input#cf2_exists').val('false');
		update_cf_visibility();
	}
}

function delete_cf2()
{
	var r = confirm("Confirm deleting: Are you sure you want to delete the second custom field for this company? the company will have no second custom field upon submission!");
	if (!r)  return false;
	else
	{
		$('input#cf2_exists').val('false');
		update_cf_visibility();
	}
}

function update_text()
{
	var qr_head_text = $('input#qr_header').val();
	var qr_comment_label = $('input#qr_comment_label').val();
	var qr_success_message = $('input#qr_success_text').val();
	
	qr_head_text = qr_head_text.replace(/#code/g, "<em>CODE</em>");
	qr_head_text = qr_head_text.replace(/#company_name/g, $('#val_company_name').val() );
	qr_head_text = qr_head_text.replace(/#location_name/g, "<em>LOCATION NAME</em>");
	qr_head_text = qr_head_text.replace(/#description/g, "<em>DESCRIPTION</em>");
	qr_comment_label = qr_comment_label.replace(/#code/g, "<em>CODE</em>");
	qr_comment_label = qr_comment_label.replace(/#company_name/g, $('#val_company_name').val() );
	qr_comment_label = qr_comment_label.replace(/#location_name/g, "<em>LOCATION NAME</em>");
	qr_comment_label = qr_comment_label.replace(/#description/g, "<em>DESCRIPTION</em>");
	qr_success_message = qr_success_message.replace(/#code/g, "<em>CODE</em>");
	qr_success_message = qr_success_message.replace(/#company_name/g, $('#val_company_name').val() );
	qr_success_message = qr_success_message.replace(/#location_name/g, "<em>LOCATION NAME</em>");
	qr_success_message = qr_success_message.replace(/#description/g, "<em>DESCRIPTION</em>");
	
	var sms_first_response_text = $('input#sms_first_reply').val();
	var sms_last_response_text = $('input#sms_last_reply').val();
	
	sms_first_response_text = sms_first_response_text.replace(/#code/g, "<em>CODE</em>");
	sms_first_response_text = sms_first_response_text.replace(/#company_name/g, $('#val_company_name').val() );
	sms_first_response_text = sms_first_response_text.replace(/#location_name/g, "<em>LOCATION NAME</em>");
	sms_first_response_text = sms_first_response_text.replace(/#description/g, "<em>DESCRIPTION</em>");
	sms_last_response_text = sms_last_response_text.replace(/#code/g, "<em>CODE</em>");
	sms_last_response_text = sms_last_response_text.replace(/#company_name/g, $('#val_company_name').val() );
	sms_last_response_text = sms_last_response_text.replace(/#location_name/g, "<em>LOCATION NAME</em>");
	sms_last_response_text = sms_last_response_text.replace(/#description/g, "<em>DESCRIPTION</em>");
	
	$('.header_bar h4').html(qr_head_text);
	$('#smartphone_screen .label1').html(qr_comment_label);
	$('#sms_first_response_text').html(sms_first_response_text);
	$('#sms_last_response_text').html(sms_last_response_text);
	$('#qr_success_message_text').html(qr_success_message);
}

function update_style()
{
	update_color();
	$('.header_bar h4').css('fontFamily', $('#s_header_ffamily').val());
	$('.label_place').css('fontFamily', $('#s_labels_ffamily').val());
	$('.header_bar h4').css('fontSize', $('#s_header_fsize').val()+'px');
	$('.label_place').css('fontSize', $('#s_labels_fsize').val()+'px');
}

function update_color(hex)
{
	var h_bg_type = $('select#s_header_bg_type').val();
	var b_bg_type = $('select#s_body_bg_type').val();
	var h_bg_pic = $('input#val_header_bg_pic').val();
	var b_bg_pic = $('input#val_body_bg_pic').val();
	
	if(h_bg_type == 'picture' && h_bg_pic)
	{
		$('.header_bar').css('background-image','url('+'<?php echo img_url('uploads/'.$company['s_header_bg_pic']); ?>'+')');
	}
	else
	{
		$('.header_bar').css('background','-moz-linear-gradient('+$('input#s_header_bg1').val()+', '+$('input#s_header_bg2').val()+')');
		$('.header_bar').css('background','-webkit-gradient(linear, left top, left bottom, from('+$('input#s_header_bg1').val()+'), to('+$('input#s_header_bg2').val()+'))');
		$('.header_bar').css('background','-webkit-linear-gradient('+$('input#s_header_bg1').val()+', '+$('input#s_header_bg2').val()+')');
		$('.header_bar').css('background','-ms-linear-gradient('+$('input#s_header_bg1').val()+', '+$('input#s_header_bg2').val()+')');
		$('.header_bar').css('background','-o-linear-gradient('+$('input#s_header_bg1').val()+', '+$('input#s_header_bg2').val()+')');
		$('.header_bar').css('background','linear-gradient('+$('input#s_header_bg1').val()+', '+$('input#s_header_bg2').val()+')');
		$('.header_bar').css('filter','progid:DXImageTransform.Microsoft.gradient(startColorstr=\''+$('input#s_header_bg1').val()+'\', endColorstr=\''+$('input#s_header_bg2').val()+'\' gradientType=1)');
	}
	if(b_bg_type == 'picture' && b_bg_pic)
		$('#smartphone_screen_bg').css('background-image','url('+'<?php echo img_url('uploads/'.$company['s_body_bg_pic']); ?>'+')');
	else
	{
		$('#smartphone_screen_bg').css('background','-moz-linear-gradient('+$('input#s_body_bg1').val()+', '+$('input#s_body_bg2').val()+')');
		$('#smartphone_screen_bg').css('background','-webkit-gradient(linear, left top, left bottom, from('+$('input#s_body_bg1').val()+'), to('+$('input#s_body_bg2').val()+'))');
		$('#smartphone_screen_bg').css('background','-webkit-linear-gradient('+$('input#s_body_bg1').val()+', '+$('input#s_body_bg2').val()+')');
		$('#smartphone_screen_bg').css('background','-ms-linear-gradient('+$('input#s_body_bg1').val()+', '+$('input#s_body_bg2').val()+')');
		$('#smartphone_screen_bg').css('background','-o-linear-gradient('+$('input#s_body_bg1').val()+', '+$('input#s_body_bg2').val()+')');
		$('#smartphone_screen_bg').css('background','linear-gradient('+$('input#s_body_bg1').val()+', '+$('input#s_body_bg2').val()+')');
		$('#smartphone_screen_bg').css('filter','progid:DXImageTransform.Microsoft.gradient(startColorstr=\''+$('input#s_body_bg1').val()+'\', endColorstr=\''+$('input#s_body_bg2').val()+'\' gradientType=1)');
	}
	
	$('.header_bar h4').css('color', $('input#s_header_fcolor').val());
	$('.label_place, #smartphone_screen p.copyright, #smartphone_screen .footer_p').css('color', $('input#s_labels_fcolor').val());
}

function update_bg_types()
{
	$('#header_bg_gradient, #header_bg_picture, #body_bg_gradient, #body_bg_picture').hide();
	var h_bg_type = $('select#s_header_bg_type').val();
	var b_bg_type = $('select#s_body_bg_type').val();
	$('#header_bg_'+h_bg_type).show();
	$('#body_bg_'+b_bg_type).show();
	update_style();
}

$(document).ready(function()
{
	//toggle delete logo
	$('a#toggle_delete').live('click', function(){
		var del = $('input#s_delete_logo').val();
		if(del == 'false')
		{
			$('input#s_delete_logo').val('true');
			$(this).text("logo will be removed, click here to undo.");
		}
		else
		{
			$('input#s_delete_logo').val('false');
			$(this).text("click here to remove it");
		}
	});
	
	//update the preview when the page loads
	update_bg_types();
	update_style();
	update_text();
	
	//custom field controls
	update_cf_visibility();
	
	$('select#s_header_bg_type, select#s_body_bg_type').live('change', function(){
		update_bg_types();
	});
	
	//bind event handlers
	$(".color-picker").miniColors({
		letterCase: 'uppercase',
		change: function(hex, rgb) {
			update_color(hex);
		}
	});
		
	$('input.text').live('keyup', function(){
		update_text();
	});
	$('input.text').live('change', function(){
		update_text();
	}); 
	
	$('select.font-picker option').each(function() {
		$(this).css('font-family', $(this).val());
	});
	
	$('select.font-picker').change(function(){
		$("select option:selected").each(function () {
			$(this).parent().css('font-family', $(this).val());
		 });
	});

	//Rest buttons for style and text
	$('#reset_default_style').click(function() {
		$('#s_body_bg1').val('<?php echo S_BODY_BG1; ?>');
		$('#s_body_bg2').val('<?php echo S_BODY_BG2; ?>');
		$('#s_header_bg1').val('<?php echo S_HEADER_BG1; ?>');
		$('#s_header_bg2').val('<?php echo S_HEADER_BG2; ?>');
		$('#s_header_fcolor').val('<?php echo S_HEADER_FCOLOR; ?>');
		$('#s_header_ffamily').val('<?php echo S_HEADER_FFAMILY; ?>');
		$('#s_header_fsize').val('<?php echo S_HEADER_FSIZE; ?>');
		$('#s_labels_fcolor').val('<?php echo S_LABELS_FCOLOR; ?>');
		$('#s_labels_ffamily').val('<?php echo S_LABELS_FFAMILY; ?>');
		$('#s_labels_fsize').val('<?php echo S_LABELS_FSIZE; ?>');
		update_style();
		$(".color-picker").each(function(){
			$(this).miniColors('value', $(this).val());
		});
		return false;
	});
	
	$('#reset_default_text').click(function() {
		$('input#qr_header').val('<?php echo QR_HEADER; ?>');
		$('input#qr_comment_label').val('<?php echo QR_COMMENT_LABEL; ?>');
		$('input#qr_success_text').val('<?php echo QR_SUCCESS_TEXT; ?>');
		$('input#sms_first_reply').val('<?php echo SMS_FIRST_REPLY; ?>');
		$('input#sms_last_reply').val('<?php echo SMS_LAST_REPLY; ?>');
		update_text();
		return false;
	});
	
		$('input#s_header_fsize').change(function(){
			$('.header_bar h4').css('fontSize', $(this).val()+'px');
			$('.header_bar h4').css('marginTop', ((36 - $(this).val())/2)+'px');
		});
		
		$('input#s_labels_fsize').change(function(){
			$('.label_place').css('fontSize', $(this).val()+'px');
		});
		
		$('select#s_header_ffamily').change(function(){
			$('.header_bar h4').css('fontFamily', $(this).val());
		});
		$('select#s_header_ffamily option').hover(function(){
			$('.header_bar h4').css('fontFamily', $(this).val());
		});
		$('select#s_header_ffamily option').focus(function(){
			$('.header_bar h4').css('fontFamily', $(this).val());
		});
		$('select#s_labels_ffamily').change(function(){
			$('.label_place').css('fontFamily', $(this).val());
		});
		$('select#s_labels_ffamily option').hover(function(){
			$('.label_place').css('fontFamily', $(this).val());
		});
		$('select#s_labels_ffamily option').focus(function(){
			$('.label_place').css('fontFamily', $(this).val());
		});
		
	/*
	//Scripts for the QR and SMS custumazion page
	if($('.customize_qr_sms').length > 0)
	{
		//updating the page style and text on load
		
		
		//Add a custom filed scripts
		if($('#custom_field_exists').val() == 'true')//if the custom field already exists
		{
			$('#add_custom_field').text('Edit Custom Field'); //edit the style of the form 
			update_custom_text_preview(); //update the text and preview related to the custom field
			update_custom_field();
			update_cf_pos();
		}
		else
		{
			$('.add_custom_field').hide(); //we start by hiding the form for adding a custom field
			//when the user clicks on Add a custom field
			$('#add_custom_field').css('cursor','pointer').click(function(){
				$('.add_custom_field').fadeIn(1000); //show the form
				$('#add_custom_field').css({'background':'none', 'cursor':'default'}).text('Edit Custom Field'); //edit the style of the form 
				$('#custom_field_exists').val('true');
				update_custom_text_preview(); //update the text and preview related to the custom field
				update_custom_field();
			});
		}
		
		//Add a second custom field scripts
		if($('#sec_custom_field_exists').val() == 'true')//if the custom field already exists
		{
			update_custom_text_preview(); //update the text and preview related to the custom field
			update_custom_field();
			update_cf_pos();
			$('#add_sec_custom_field').css({'color':'red'}).text('Delete Second Custom Field').addClass("confirm"); //edit the style of the form 
			update_custom_text_preview(); //update the text and preview related to the custom field
			update_custom_field();
		}
		else
		{
			$('#sec_custom_field').hide(); //we start by hiding the form for adding a second custom field
			//when the user clicks on Add a second custom field
			$('#add_sec_custom_field').css('cursor','pointer').click(function(){
				if($(this).hasClass('confirm'))
				{
					var r = confirm("Confirm deleting: Are you sure you want to delete the second custom field for this company? All custom data will be deleted upon submitting changes");
					if (!r) {return false;}
					else //when confirmed, preview should go back to normal and custom field form should disappear 
					{
						update_custom_field();
						$('#sec_custom_field').fadeOut(function(){$(this).hide();});
						$('#add_sec_custom_field').css({'color':''}).text('Add a Second Custom Field For QR forms').removeClass('confirm');
						$('#sec_custom_field_exists').val('false'); 
						update_custom_text_preview();
						return false;				
					}
				}
				else
				{
					$('#sec_custom_field').fadeIn(1000); //show the form
					$('#add_sec_custom_field').css({'color':'red'}).text('Delete Second Custom Field').addClass("confirm"); //edit the style of the form 
					$('#sec_custom_field_exists').val('true');
					update_custom_text_preview(); //update the text and preview related to the custom field
					update_custom_field();
					return false;
				}
			});
		}
		
		
		//confirm button for deleting the custom field
		$('.customize_qr_sms  a.confirm').click(function() {
			var r = confirm("Confirm deleting: Are you sure you want to delete the custom field for this company? All custom data will be deleted upon submitting changes");
			if (!r) {return false;}
			else //when confirmed, preview should go back to normal and custom field form should disappear 
			{
				update_custom_field();
				$('.add_custom_field').fadeOut(function(){$(this).hide();});
				$('#add_custom_field').css({'background':'', 'cursor':'pointer'}).text('Add Custom Field').click(function(){
					$('.add_custom_field').fadeIn(1000); //show the form
					$('#add_custom_field').css({'background':'none', 'cursor':'default'}).text('Edit Custom Field'); //edit the style of the form 
					$('#custom_field_exists').val('true');
					update_custom_text_preview(); //update the text and preview related to the custom field
					update_custom_field();
				});
				$('#custom_field_exists').val('false'); 
				$('#sec_custom_field_exists').val('false'); 
				return false;				
			}
		});
		
		//we update the text and preview related to the custom field on this element change
		$('#custom_field_qr_sms').live('change', function(){
			update_custom_text_preview();
			update_custom_field();
		});
		$('input.custom_text').live('keyup', function(){
			update_custom_text_preview();
		});
		$('input.custom_text').live('change', function(){
			update_custom_text_preview();
		}); 
		
		//updating preview for custom field position
		$('#custom_field_asked_for_qr input.custom_field_qr_pos:radio').live('change', function(){
			update_cf_pos();
		});
		
		
		
		
	}
	*/
});

function update_custom_field()
{
	if($('#custom_field_qr_sms').val() == 'both')
	{
		$('#custom_field_asked_for_qr').fadeIn();
		$('#custom_field_asked_for_sms').fadeIn();
		$('#smartphone_screen').addClass('extra_field');
		update_cf_pos();
	}
	else if($('#custom_field_qr_sms').val() == 'qr')
	{
		$('#custom_field_asked_for_qr').fadeIn();
		$('#custom_field_asked_for_sms').fadeOut(function(){$(this).hide();});
		$('#smartphone_screen').addClass('extra_field');
		update_cf_pos();
		$('#custom_field_sms_msg').html('');
	}
	else if($('#custom_field_qr_sms').val() == 'sms')
	{
		$('#custom_field_asked_for_qr').fadeOut(function(){$(this).hide();});
		$('#custom_field_asked_for_sms').fadeIn();
		$('#smartphone_screen').removeClass('extra_field');
		$('#smartphone_screen .label2').html('');
	}
	
}

function update_custom_text_preview()
{
	var custom_field_name = $('input#custom_field_name').val();
	var qr_text = $('input#qr_text').val();
	var sms_text = $('input#sms_text').val();
	custom_field_name = custom_field_name.replace(/#code/g, "<em>CODE</em>");
	custom_field_name = custom_field_name.replace(/#company_name/g, $('#val_company_name').val() );
	custom_field_name = custom_field_name.replace(/#location_name/g, "<em>LOCATION NAME</em>");
	qr_text = qr_text.replace(/#code/g, "<em>CODE</em>");
	qr_text = qr_text.replace(/#company_name/g, $('#val_company_name').val() );
	qr_text = qr_text.replace(/#location_name/g, "<em>LOCATION NAME</em>");
	sms_text = sms_text.replace(/#code/g, "<em>CODE</em>");
	sms_text = sms_text.replace(/#company_name/g, $('#val_company_name').val() );
	sms_text = sms_text.replace(/#location_name/g, "<em>LOCATION NAME</em>");
	
	$('#smartphone_screen .label2').html(qr_text);
	if($('#custom_field_qr_sms').val() == 'both')
	{
		$('#custom_field_sms_msg').html('<strong>22121: </strong>'+sms_text+'<br/><strong>Client: </strong><em>'+custom_field_name+'</em><br/>');
	}
	else if($('#custom_field_qr_sms').val() == 'sms')
	{
		$('#custom_field_sms_msg').html('<strong>22121: </strong>'+sms_text+'<br/><strong>Client: </strong><em>'+custom_field_name+'</em><br/>');
	}
	
	if($('#custom_field_exists').val() == 'false')
	{
		$('#smartphone_screen').removeClass('extra_field');
		$('#smartphone_screen .label2').html('');
		$('#custom_field_sms_msg').html('');
	}
}



function update_cf_pos()
{
	if($('#custom_field_exists').val() == 'true' && $('#custom_field_qr_sms').val() != 'sms')
	{
		if($('#custom_field_asked_for_qr input.custom_field_qr_pos:radio:checked').val() == "after")
			$('#smartphone_screen').addClass("after");
		else
			$('#smartphone_screen').removeClass("after");
	}
	else
		$('#smartphone_screen').removeClass("after");
}

</script>