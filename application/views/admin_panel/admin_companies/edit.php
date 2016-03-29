	
	<div id="menu-content">
	<div id="content_wrapper">
		<h1>Edit <span class="special"><?php echo $target_data['name']; ?></span> :</h1>
		<div class="box">
			<h2>Editing company's Information</h2>
			<section>
				<p>Make the changes you want, and click submit.</p><br />
				<p>P.S.: Fields marked with <span class="required">*</span> are required. To delete a field, just empty it before clicking submit.</p><br />
				<form class="standard" method="post" action="<?php echo site_url('admin_companies/submit_edit/'.$target_data['ID']); ?>" >
					<p>
						<label for="name">Company Name:<span class="error">*</span></label>
						<input type="text" name="name" id="name" value="<?php $s = set_value('name'); if(strlen($s) > 1) echo $s; else echo $target_data['name']; ?>" />
						<?php echo form_error('name'); ?>
						<br />
						<label for="address">Address:</label>
						<input type="text" name="address" id="address" value="<?php $s = set_value('address'); if(strlen($s) > 1) echo $s; else echo $target_data['address']; ?>" />
						<?php echo form_error('address'); ?>
						<br />
						<label for="city">city:</label>
						<input type="text" name="city" id="city" value="<?php $s = set_value('city'); if(strlen($s) > 1) echo $s; else echo $target_data['city']; ?>" />
						<?php echo form_error('city'); ?>
						<br />
						<label for="state">State:</label>
						<select name="state" id="state">
							<?php 
							$state = $target_data['state']; 
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
						<label for="zipcode">zipcode:</label>
						<input type="text" name="zipcode" id="zipcode" value="<?php $s = set_value('zipcode'); if(strlen($s) > 1) echo $s; else echo $target_data['zipcode']; ?>" />
						<?php echo form_error('zipcode'); ?>
						<br />
						<label for="company_contact">Company Contact:</label>
						<input type="text" name="company_contact" id="company_contact" value="<?php $s = set_value('company_contact'); if(strlen($s) > 1) echo $s; else echo $target_data['company_contact']; ?>" />
						<?php echo form_error('company_contact'); ?>
						<br />
						<label for="contact_phone">Company Phone:</label>
						<input type="text" name="contact_phone" id="contact_phone" value="<?php $s = set_value('contact_phone'); if(strlen($s) > 1) echo $s; else echo $target_data['contact_phone']; ?>" />
						<?php echo form_error('contact_phone'); ?>
						<br />
						<label for="contact_email">Company Email:</label>
						<input type="text" name="contact_email" id="contact_email" value="<?php $s = set_value('contact_email'); if(strlen($s) > 1) echo $s; else echo $target_data['contact_email']; ?>" />
						<?php echo form_error('contact_email'); ?>
						<br />
						<label for="website">Web site:</label>
						<input type="text" name="website" id="website" value="<?php $s = set_value('website'); if(strlen($s) > 1) echo $s; else echo $target_data['website']; ?>" />
						<?php echo form_error('website'); ?>
						<br />
						<label for="business_type">Business Type:</label>
						<select name="business_type" id="business_type">
							<?php
							if(empty($target_data['state']))
								$business_type = 'others';
							else
								$business_type = $target_data['state']; 
							if(!empty($_POST['business_type'])) $business_type = $_POST['business_type'];
							?>
							<option value="" <?php if(strcmp($business_type, '') == 0) echo 'selected="selected" ' ?>>--Please select--</option>
							<option value="food_services" <?php if(strcmp($business_type, 'food_services') == 0) echo 'selected="selected" ' ?>>Restaurants and food services, fast food, frozen yogurt</option>
							<option value="transportation" <?php if(strcmp($business_type, 'transportation') == 0) echo 'selected="selected" ' ?>>Transportation, buses, limousine, taxi services</option>
							<option value="grocery" <?php if(strcmp($business_type, 'grocery') == 0) echo 'selected="selected" ' ?>>Grocery stores</option>
							<option value="clothing" <?php if(strcmp($business_type, 'clothing') == 0) echo 'selected="selected" ' ?>>Clothing retailers</option>
							<option value="lodging" <?php if(strcmp($business_type, 'lodging') == 0) echo 'selected="selected" ' ?>>Hotels, lodging, hospitality, spas</option>
							<option value="medical" <?php if(strcmp($business_type, 'medical') == 0) echo 'selected="selected" ' ?>>Doctor's offices, medical services, hospitals</option>
							<option value="repairing" <?php if(strcmp($business_type, 'repairing') == 0) echo 'selected="selected" ' ?>>Home services/repair</option>
							<option value="cleaning" <?php if(strcmp($business_type, 'cleaning') == 0) echo 'selected="selected" ' ?>>Cleaning, housekeeping</option><option value="cleaning" <?php if(strcmp($business_type, 'others') == 0) echo 'selected="selected" ' ?>>Others</option>
						</select>
						<?php echo form_error('business_type'); ?>
						<br />
						<label for="is_test">Is this Company a testing company?</label>
						<select name="is_test" id="is_test">
							<?php
							if(empty($target_data['is_test']))
								$is_test = '0';
							else
								$is_test = $target_data['is_test']; 
							if($is_test == 1)
								$is_test = '1';
							if(!empty($_POST['is_test'])) $is_test = $_POST['is_test'];
							?>
							<option value="0" <?php if(strcmp($is_test, '0') == 0) echo 'selected="selected" ' ?>>No</option>
							<option value="1" <?php if(strcmp($is_test, '1') == 0) echo 'selected="selected" ' ?>>Yes</option>
						</select>
						<?php echo form_error('is_test'); ?>
						<br />
						
						<input name="btn_submit_changes" class="btn_submit" type="submit" value="Submit Changes" />
					</p>
				</form>
		</section>
	</div>
	</div>
	<p class="content_end">&nbsp;</p>
	


				
				</div>
			</div>
		</div>
	</div><!-- #body -->