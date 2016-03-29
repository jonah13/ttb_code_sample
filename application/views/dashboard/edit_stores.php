<?php $user_data = $this->pages_data_model->get_user_data();?>
<?php $store_data = $this->pages_data_model->get_store_data($store_id);?>
<div id="main" class="dashboard">
	<div id="menu">
		<ul>
			<li><a href="<?php echo site_url('dashboard/edit_user_info'); ?>">My Account</a></li>
			<li><a class="active" href="<?php echo site_url('dashboard/feedback_stats'); ?>">Customer Feedback</a></li>
			<li><a href="<?php echo site_url('dashboard/edit_stores'); ?>">Locations</a></li>
			<li><a href="<?php echo site_url('dashboard'); ?>">Codes</a></li>
		</ul>
	</div>
	<div id="menu-content">
		<h1>Edit your Location information</h1>
		<h3><?php echo $store_data['name']; ?></h3>
		<p>Please make the changes you want on your location information and click the "submit changes" button.</p>
		<?php if(isset($message) && $message != null && $message != '') echo '<p class = "success">'.$message.'</p>'; ?>
		<section>
			<form class="edit_form" method="post" action="<?php echo site_url('dashboard/edit_stores/submit/'.$store_id); ?>" enctype="multipart/form-data" >
			<p>
				<label for="store_name">Location Name:</label>
				<input type="text" name="store_name" id="store_name" value="<?php $s = set_value('store_name'); if(strlen($s) > 1) echo $s; else echo $store_data['name']; ?>" />
				<?php echo form_error('store_name'); ?>
				<br />
				
				<label>Codes:</label> <span class="note">(each location should have at least one code)</span><br />
				<?php
				for($j = 0; $j < $store_data['codes_number']; $j++)
				{
					$code_data = $this->pages_data_model->get_code_data($store_data['codes_ids'][$j]);
					$s_code = (strlen(set_value('store_code'.$j)) > 1)?set_value('store_code'.$j):$code_data['code'];
					$s_desc = (strlen(set_value('code'.$j.'_desc')) > 1)?set_value('code'.$j.'_desc'):$code_data['description'];
					
					echo '<span class="label">Code '.($j+1).': <strong>'.$s_code.'</strong></span><input type="hidden" name="store_code'.$j.'" id="store_code'.$j.'" class="secondary_input"  value="'.$s_code.'" /> - Description: <input type="text" name="code'.$j.'_desc" id="code'.$j.'_desc" value="'.$s_desc.'" />';
					echo form_error('store_code'.$j);  
					if(strlen(form_error('code'.$j.'_desc')) > 0 && strlen(form_error('store_code'.$j)) > 0) echo ' - '; 
					echo form_error('code'.$j.'_desc');
					echo '<br />';
				}
				for($j = $store_data['codes_number']; $j < 5; $j++)
				{
					$s_code = set_value('store_code'.$j);
					$s_desc = set_value('code'.$j.'_desc');
					
					echo '<span class="label">Code '.($j+1).': <strong>'.$s_code.'</strong></span><input name="store_code'.$j.'" id="store_code'.$j.'" class="secondary_input"  value="'.$s_code.'" /> - Description: <input type="text" name="code'.$j.'_desc" id="code'.$j.'_desc" value="'.$s_desc.'" />';
					echo form_error('store_code'.$j);  
					if(strlen(form_error('code'.$j.'_desc')) > 0 && strlen(form_error('store_code'.$j)) > 0) echo ' - '; 
					echo form_error('code'.$j.'_desc');
					echo '<br />';
				}
				?>
				<br />
				<label for="business_type">Business type:</label>
				<input type="text" name="business_type" id="business_type" value="<?php $s = set_value('business_type'); if(strlen($s) > 1) echo $s; else echo $store_data['business_type']; ?>" />
				<?php echo form_error('business_type'); ?>
				<br />
				<label for="address">Address:</label>
				<input type="text" name="address" id="address" value="<?php $s = set_value('address'); if(strlen($s) > 1) echo $s; else echo $store_data['address']; ?>" />
				<?php echo form_error('address'); ?>
				<br />
				<label for="city">City:</label>
				<input type="text" name="city" id="city" value="<?php $s = set_value('city'); if(strlen($s) > 1) echo $s; else echo $store_data['city']; ?>" />
				<?php echo form_error('city'); ?>
				<br />
				<label for="state">State:</label>
				<select name="state" id="stat">
					<?php $state = $store_data['state']; $def = false; if(strlen($state) < 2) $state = '';?>
					<option value="" <?php if(strcmp($state, '') == 0 && !$def) $def = true; else $def = false; echo set_select('state', '', $def); ?>>--Please select--</option>
					<option value="AL" <?php if(strcmp($state, 'AL') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'AL', $def); ?>>Alabama</option>
					<option value="AK" <?php if(strcmp($state, 'AK') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'AK', $def); ?>>Alaska</option>
					<option value="AZ" <?php if(strcmp($state, 'AZ') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'AZ', $def); ?>>Arizona</option>
					<option value="AR" <?php if(strcmp($state, 'AR') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'AR', $def); ?>>Arkansas</option>
					<option value="CA" <?php if(strcmp($state, 'CA') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'CA', $def); ?>>California</option>
					<option value="CO" <?php if(strcmp($state, 'CO') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'CO', $def); ?>>Colorado</option>
					<option value="CT" <?php if(strcmp($state, 'CT') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'CT', $def); ?>>Connecticut</option>
					<option value="DE" <?php if(strcmp($state, 'DE') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'DE', $def); ?>>Delaware</option>
					<option value="DC" <?php if(strcmp($state, 'DC') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'DC', $def); ?>>District Of Columbia</option>
					<option value="FL" <?php if(strcmp($state, 'FL') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'FL', $def); ?>>Florida</option>
					<option value="GA" <?php if(strcmp($state, 'GA') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'GA', $def); ?>>Georgia</option>
					<option value="HI" <?php if(strcmp($state, 'HI') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'HI', $def); ?>>Hawaii</option>
					<option value="ID" <?php if(strcmp($state, 'ID') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'ID', $def); ?>>Idaho</option>
					<option value="IL" <?php if(strcmp($state, 'IL') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'IL', $def); ?>>Illinois</option>
					<option value="IN" <?php if(strcmp($state, 'IN') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'IN', $def); ?>>Indiana</option>
					<option value="IA" <?php if(strcmp($state, 'IA') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'IA', $def); ?>>Iowa</option>
					<option value="KS" <?php if(strcmp($state, 'KS') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'KS', $def); ?>>Kansas</option>
					<option value="KY" <?php if(strcmp($state, 'KY') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'KY', $def); ?>>Kentucky</option>
					<option value="LA" <?php if(strcmp($state, 'LA') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'LA', $def); ?>>Louisiana</option>
					<option value="ME" <?php if(strcmp($state, 'ME') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'ME', $def); ?>>Maine</option>
					<option value="MD" <?php if(strcmp($state, 'MD') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'MD', $def); ?>>Maryland</option>
					<option value="MA" <?php if(strcmp($state, 'MA') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'MA', $def); ?>>Massachusetts</option>
					<option value="MI" <?php if(strcmp($state, 'MI') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'MI', $def); ?>>Michigan</option>
					<option value="MN" <?php if(strcmp($state, 'MN') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'MN', $def); ?>>Minnesota</option>
					<option value="MS" <?php if(strcmp($state, 'MS') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'MS', $def); ?>>Mississippi</option>
					<option value="MO" <?php if(strcmp($state, 'MO') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'MO', $def); ?>>Missouri</option>
					<option value="MT" <?php if(strcmp($state, 'MT') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'MT', $def); ?>>Montana</option>
					<option value="NE" <?php if(strcmp($state, 'NE') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'NE', $def); ?>>Nebraska</option>
					<option value="NV" <?php if(strcmp($state, 'NV') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'NV', $def); ?>>Nevada</option>
					<option value="NH" <?php if(strcmp($state, 'NH') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'NH', $def); ?>>New Hampshire</option>
					<option value="NJ" <?php if(strcmp($state, 'NJ') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'NJ', $def); ?>>New Jersey</option>
					<option value="NM" <?php if(strcmp($state, 'NM') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'NM', $def); ?>>New Mexico</option>
					<option value="NY" <?php if(strcmp($state, 'NY') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'NY', $def); ?>>New York</option>
					<option value="NC" <?php if(strcmp($state, 'NC') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'NC', $def); ?>>North Carolina</option>
					<option value="ND" <?php if(strcmp($state, 'ND') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'ND', $def); ?>>North Dakota</option>
					<option value="OH" <?php if(strcmp($state, 'OH') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'OH', $def); ?>>Ohio</option>
					<option value="OK" <?php if(strcmp($state, 'OK') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'OK', $def); ?>>Oklahoma</option>
					<option value="OR" <?php if(strcmp($state, 'OR') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'OR', $def); ?>>Oregon</option>
					<option value="PA" <?php if(strcmp($state, 'PA') == 0 && !$def) $def = true; else $def = false; echo set_select('state', 'PA', $def); ?>>Pennsylvania</option>
					<option value="PR" <?php if(strcmp($state, 'PR') == 0 && !$def) $def = true; else $def = false; echo  set_select('state', 'PR', $def); ?>>Puerto Rico</option>
					<option value="RI" <?php if(strcmp($state, 'RI') == 0 && !$def) $def = true; else $def = false; echo  set_select('state', 'RI', $def); ?>>Rhode Island</option>
					<option value="SC" <?php if(strcmp($state, 'SC') == 0 && !$def) $def = true; else $def = false; echo  set_select('state', 'SC', $def); ?>>South Carolina</option>
					<option value="SD" <?php if(strcmp($state, 'SD') == 0 && !$def) $def = true; else $def = false; echo  set_select('state', 'SD', $def); ?>>South Dakota</option>
					<option value="TN" <?php if(strcmp($state, 'TN') == 0 && !$def) $def = true; else $def = false; echo  set_select('state', 'TN', $def); ?>>Tennessee</option>
					<option value="TX" <?php if(strcmp($state, 'TX') == 0 && !$def) $def = true; else $def = false; echo  set_select('state', 'TX', $def); ?>>Texas</option>
					<option value="UT" <?php if(strcmp($state, 'UT') == 0 && !$def) $def = true; else $def = false; echo  set_select('state', 'UT', $def); ?>>Utah</option>
					<option value="VT" <?php if(strcmp($state, 'VT') == 0 && !$def) $def = true; else $def = false; echo  set_select('state', 'VT', $def); ?>>Vermont</option>
					<option value="VA" <?php if(strcmp($state, 'VA') == 0 && !$def) $def = true; else $def = false; echo  set_select('state', 'VA', $def); ?>>Virginia</option>
					<option value="WA" <?php if(strcmp($state, 'WA') == 0 && !$def) $def = true; else $def = false; echo  set_select('state', 'WA', $def); ?>>Washington</option>
					<option value="WV" <?php if(strcmp($state, 'WV') == 0 && !$def) $def = true; else $def = false; echo  set_select('state', 'WV', $def); ?>>West Virginia</option>
					<option value="WI" <?php if(strcmp($state, 'WI') == 0 && !$def) $def = true; else $def = false; echo  set_select('state', 'WI', $def); ?>>Wisconsin</option>
					<option value="WY" <?php if(strcmp($state, 'WY') == 0 && !$def) $def = true; else $def = false; echo  set_select('state', 'WY', $def); ?>>Wyoming</option>
        </select>
				<br />
				<label for="zipcode">Zip Code:</label>
				<input type="text" name="zipcode" id="zipcode" value="<?php $s = set_value('zipcode'); if(strlen($s) > 1) echo $s; else echo $store_data['zipcode']; ?>" />
				<?php echo form_error('zipcode'); ?>
				<br />
				<label for="store_phone">Phone:</label>
				<input type="text" name="store_phone" id="store_phone" value="<?php $s = set_value('store_phone'); if(strlen($s) > 1) echo $s; else echo $store_data['store_phone']; ?>" />
				<?php echo form_error('store_phone'); ?>
				<br />
				<label for="fax">Fax:</label>
				<input type="text" name="fax" id="fax" value="<?php $s = set_value('fax'); if(strlen($s) > 1) echo $s; else echo $store_data['fax']; ?>" />
				<?php echo form_error('fax'); ?>
				<br />
				<label for="website">Website:</label>
				<input type="text" name="website" id="website" value="<?php $s = set_value('website'); if(strlen($s) > 1) echo $s; else echo $store_data['website']; ?>" />
				<?php echo form_error('website'); ?>
				<br />
				<label for="store_email">Email:</label>
				<input type="text" name="store_email" id="store_email" value="<?php $s = set_value('store_email'); if(strlen($s) > 1) echo $s; else echo $store_data['store_email']; ?>" />
				<?php echo form_error('store_email'); ?>
				<!--<br />
				<label for="upload_logo">Upload a new logo:</label>
				<input type="file" name="logo" id="upload_logo" />
				<?php if(isset($error) && $error != NULL) echo $error;?>
				-->
				<br />
				<label class="align-top" for="description">Description:</label> 
				<textarea name="description" id="description" rows="8"><?php $s = set_value('description'); if(strlen($s) > 1) echo $s; else echo $store_data['description']; ?></textarea>
				<?php echo form_error('description'); ?>
				<br />
				<input name="btn_submit_changes" class="btn_submit_changes" src="<?php echo img_url('submit_changes.png'); ?>" type="image" alt="submit_changes" /> 
				<br />
				<br />
			</p>
			</form>
		</section>
	</div>
	<p class="content_end">&nbsp;</p>
</div>