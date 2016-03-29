<?php $user_data = $this->pages_data_model->get_user_data();?>
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
		<h1>Add a New Locaation</h1>
		<p>You currently have <?php echo $user_data['stores_number']; ?> locations registered to our service.</p>
		<p>Enter your information and submit the form to add a new location.</p>
		<section>
		<form class="add_store" method="post" action="<?php echo site_url('dashboard/add_stores/submit'); ?>" enctype="multipart/form-data" >
			<p>
				<label for="store_name">Location Name:<span class="required">*</span></label>
				<input type="text" name="store_name" id="store_name" value="<?php echo set_value('store_name'); ?>" />
				<?php echo form_error('store_name'); ?>
				<br />
				<label for="store_code1">Codes:<span class="required">*</span></label> <span class="note">(your store should have at least one code)</span><br />
					<span class="label">Code 1: </span><input type="text" name="store_code1" id="store_code1" class="secondary_input" value="<?php echo set_value('store_code1'); ?>" /> - Description: <input type="text" name="code1_desc" id="code1_desc" value="<?php echo set_value('code1_desc'); ?>" />
					<?php 
						echo form_error('store_code1');  
						if(strlen(form_error('code1_desc')) > 0 && strlen(form_error('store_code1')) > 0) echo ' - '; 
						echo form_error('code1_desc');
					?><br />
					<span class="label">Code 2: </span><input type="text" name="store_code2" id="store_code2" class="secondary_input" value="<?php echo set_value('store_code2'); ?>" /> - Description: <input type="text" name="code2_desc" id="code2_desc" value="<?php echo set_value('code2_desc'); ?>" />
					<?php 
						echo form_error('store_code2');  
						if(strlen(form_error('code2_desc')) > 0 && strlen(form_error('store_code2'))) echo ' - '; 
						echo form_error('code2_desc');
					?><br />
					<span class="label">Code 3: </span><input type="text" name="store_code3" id="store_code3" class="secondary_input" value="<?php echo set_value('store_code3'); ?>" /> - Description: <input type="text" name="code3_desc" id="code3_desc" value="<?php echo set_value('code3_desc'); ?>" />
					<?php 
						echo form_error('store_code3');  
						if(strlen(form_error('code3_desc')) > 0 && strlen(form_error('store_code3'))) echo ' - '; 
						echo form_error('code3_desc');
					?><br />
					<span class="label">Code 4: </span><input type="text" name="store_code4" id="store_code4" class="secondary_input" value="<?php echo set_value('store_code4'); ?>" /> - Description: <input type="text" name="code4_desc" id="code4_desc" value="<?php echo set_value('code4_desc'); ?>" />
					<?php 
						echo form_error('store_code4');  
						if(strlen(form_error('code4_desc')) > 0 && strlen(form_error('store_code4'))) echo ' - '; 
						echo form_error('code4_desc');
					?><br />
					<span class="label">Code 5: </span><input type="text" name="store_code5" id="store_code5" class="secondary_input" value="<?php echo set_value('store_code5'); ?>" /> - Description: <input type="text" name="code5_desc" id="code5_desc" value="<?php echo set_value('code5_desc'); ?>" />
					<?php 
						echo form_error('store_code5');  
						if(strlen(form_error('code5_desc')) > 0 && strlen(form_error('store_code5'))) echo ' - '; 
						echo form_error('code5_desc');
					?><br />
				<br />
				<label for="business_type">Business type:</label>
				<input type="text" name="business_type" id="business_type" value="<?php echo set_value('business_type'); ?>" />
				<?php echo form_error('business_type'); ?>
				<br />
				<label for="address">Address:</label>
				<input type="text" name="address" id="address" value="<?php echo set_value('address'); ?>" />
				<?php echo form_error('address'); ?>
				<br />
				<label for="city">City:</label>
				<input type="text" name="city" id="city" value="<?php echo set_value('city'); ?>" />
				<?php echo form_error('city'); ?>
				<br />
				<label for="state">State:</label>
				<select name="state" id="state">
					<option value="" <?php echo set_select('state', '', TRUE); ?>>--Please select--</option>
					<option value="AL" <?php echo set_select('state', 'AL'); ?>>Alabama</option>
					<option value="AK" <?php echo set_select('state', 'AK'); ?>>Alaska</option>
					<option value="AZ" <?php echo set_select('state', 'AZ'); ?>>Arizona</option>
					<option value="AR" <?php echo set_select('state', 'AR'); ?>>Arkansas</option>
					<option value="CA" <?php echo set_select('state', 'CA'); ?>>California</option>
					<option value="CO" <?php echo set_select('state', 'CO'); ?>>Colorado</option>
					<option value="CT" <?php echo set_select('state', 'CT'); ?>>Connecticut</option>
					<option value="DE" <?php echo set_select('state', 'DE'); ?>>Delaware</option>
					<option value="DC" <?php echo set_select('state', 'DC'); ?>>District Of Columbia</option>
					<option value="FL" <?php echo set_select('state', 'FL'); ?>>Florida</option>
					<option value="GA" <?php echo set_select('state', 'GA'); ?>>Georgia</option>
					<option value="HI" <?php echo set_select('state', 'HI'); ?>>Hawaii</option>
					<option value="ID" <?php echo set_select('state', 'ID'); ?>>Idaho</option>
					<option value="IL" <?php echo set_select('state', 'IL'); ?>>Illinois</option>
					<option value="IN" <?php echo set_select('state', 'IN'); ?>>Indiana</option>
					<option value="IA" <?php echo set_select('state', 'IA'); ?>>Iowa</option>
					<option value="KS" <?php echo set_select('state', 'KS'); ?>>Kansas</option>
					<option value="KY" <?php echo set_select('state', 'KY'); ?>>Kentucky</option>
					<option value="LA" <?php echo set_select('state', 'LA'); ?>>Louisiana</option>
					<option value="ME" <?php echo set_select('state', 'ME'); ?>>Maine</option>
					<option value="MD" <?php echo set_select('state', 'MD'); ?>>Maryland</option>
					<option value="MA" <?php echo set_select('state', 'MA'); ?>>Massachusetts</option>
					<option value="MI" <?php echo set_select('state', 'MI'); ?>>Michigan</option>
					<option value="MN" <?php echo set_select('state', 'MN'); ?>>Minnesota</option>
					<option value="MS" <?php echo set_select('state', 'MS'); ?>>Mississippi</option>
					<option value="MO" <?php echo set_select('state', 'MO'); ?>>Missouri</option>
					<option value="MT" <?php echo set_select('state', 'MT'); ?>>Montana</option>
					<option value="NE" <?php echo set_select('state', 'NE'); ?>>Nebraska</option>
					<option value="NV" <?php echo set_select('state', 'NV'); ?>>Nevada</option>
					<option value="NH" <?php echo set_select('state', 'NH'); ?>>New Hampshire</option>
					<option value="NJ" <?php echo set_select('state', 'NJ'); ?>>New Jersey</option>
					<option value="NM" <?php echo set_select('state', 'NM'); ?>>New Mexico</option>
					<option value="NY" <?php echo set_select('state', 'NY'); ?>>New York</option>
					<option value="NC" <?php echo set_select('state', 'NC'); ?>>North Carolina</option>
					<option value="ND" <?php echo set_select('state', 'ND'); ?>>North Dakota</option>
					<option value="OH" <?php echo set_select('state', 'OH'); ?>>Ohio</option>
					<option value="OK" <?php echo set_select('state', 'OK'); ?>>Oklahoma</option>
					<option value="OR" <?php echo set_select('state', 'OR'); ?>>Oregon</option>
					<option value="PA" <?php echo set_select('state', 'PA'); ?>>Pennsylvania</option>
					<option value="PR" <?php echo set_select('state', 'PR'); ?>>Puerto Rico</option>
					<option value="RI" <?php echo set_select('state', 'RI'); ?>>Rhode Island</option>
					<option value="SC" <?php echo set_select('state', 'SC'); ?>>South Carolina</option>
					<option value="SD" <?php echo set_select('state', 'SD'); ?>>South Dakota</option>
					<option value="TN" <?php echo set_select('state', 'TN'); ?>>Tennessee</option>
					<option value="TX" <?php echo set_select('state', 'TX'); ?>>Texas</option>
					<option value="UT" <?php echo set_select('state', 'UT'); ?>>Utah</option>
					<option value="VT" <?php echo set_select('state', 'VT'); ?>>Vermont</option>
					<option value="VA" <?php echo set_select('state', 'VA'); ?>>Virginia</option>
					<option value="WA" <?php echo set_select('state', 'WA'); ?>>Washington</option>
					<option value="WV" <?php echo set_select('state', 'WV'); ?>>West Virginia</option>
					<option value="WI" <?php echo set_select('state', 'WI'); ?>>Wisconsin</option>
					<option value="WY" <?php echo set_select('state', 'WY'); ?>>Wyoming</option>
        </select>
				<br />
				<label for="zipcode">Zipcode:</label>
				<input type="text" name="zipcode" id="zipcode" value="<?php echo set_value('zipcode'); ?>" />
				<?php echo form_error('zipcode'); ?>
				<br />
				<label for="store_phone">Phone:</label>
				<input type="text" name="store_phone" id="store_phone" value="<?php echo set_value('store_phone'); ?>" />
				<?php echo form_error('store_phone'); ?>
				<br />
				<label for="fax">Fax:</label>
				<input type="text" name="fax" id="fax" value="<?php echo set_value('fax'); ?>" />
				<?php echo form_error('fax'); ?>
				<br />
				<label for="website">Website:</label>
				<input type="text" name="website" id="website" value="<?php echo set_value('website'); ?>" />
				<?php echo form_error('website'); ?>
				<br />
				<label for="store_email">SEmail:</label>
				<input type="text" name="store_email" id="store_email" value="<?php echo set_value('store_email'); ?>" />
				<?php echo form_error('store_email'); ?>
				<br />
				<label for="store_logo">Logo:</label>
				<input type="file" name="logo" id="store_logo" />
				<?php if(isset($error) && $error != NULL) echo $error;?>
				<br />
				<label class="align-top" for="description">Description:</label> 
				<textarea name="description" id="description" rows="8" cols="68"><?php echo set_value('description'); ?></textarea>
				<?php echo form_error('description'); ?>
				<br />
				<input name="btn_submit" id="btn_submit" src="<?php echo img_url('submit.png'); ?>" type="image" alt="submit" />
			</p>
		</form>
		</section>
	</div>
	<p class="content_end">&nbsp;</p>
</div>