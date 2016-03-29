<?php 
//echo '<pre>'.print_r($_POST, true).'</pre>';
	$locations_number = 0;
	if(!empty($_POST['locations_number'])) $locations_number = (int) $_POST['locations_number'];
	//var_dump($locations_number);
?>		
	<div id="menu-content">
	<div id="content_wrapper">
		<h1>Add a new <span class="special">Company</span> :</h1>
		<div class="box">
			<h2>New Company Registration</h2>
			<section>
			<p>To register a new Company to TellTheBoss.com, complete the fields below, and click submit.</p><br />
			<?php if(!empty($other_errors)) echo '<p class="reply" style="color:red;">'.$other_errors.'</p>'; ?>
			<form class="standard indent_0" method="post" action="<?php echo site_url('admin_companies/submit_add'); ?>" >
			<p>
				<label for="name">Company Name:<span class="required">*</span></label>
				<input type="text" name="name" id="name" value="<?php echo set_value('name'); ?>" />
				<?php echo form_error('name'); ?>
				<br />
				<label for="address">Address:</label>
				<input type="text" name="address" id="address" value="<?php echo set_value('address'); ?>" />
				<?php echo form_error('address'); ?>
				<br />
				
				<label for="state">state:</label>
				<select name="state" id="state">
					<?php
					$state = '';
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
				
				<label for="city">city:</label>
				<input type="text" name="city" id="city" value="<?php echo set_value('city'); ?>" />
				<?php echo form_error('city'); ?>
				<br />
				
				<label for="zipcode">zipcode:</label>
				<input type="text" name="zipcode" id="zipcode" value="<?php echo set_value('zipcode'); ?>" />
				<?php echo form_error('zipcode'); ?>
				<br />
				
				<label for="company_contact">Company Contact:</label>
				<input type="text" name="company_contact" id="company_contact" value="<?php echo set_value('company_contact'); ?>" />
				<?php echo form_error('company_contact'); ?>
				<br />
				
				<label for="contact_phone">Company Phone:</label>
				<input type="text" name="contact_phone" id="contact_phone" value="<?php echo set_value('contact_phone'); ?>" />
				<?php echo form_error('contact_phone'); ?>
				<br />
				
				<label for="contact_email">Company Email:</label>
				<input type="text" name="contact_email" id="contact_email" value="<?php echo set_value('contact_email'); ?>" />
				<?php echo form_error('contact_email'); ?>
				<br />
				
				<label for="website">Web Site:</label>
				<input type="text" name="website" id="website" value="<?php echo set_value('website'); ?>" />
				<?php echo form_error('website'); ?>
				<br />
				
				<label for="business_type">Business Type:</label>
				<select name="business_type" id="business_type">
					<?php
					$business_type = '';
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
					$is_test = '0';
					if(!empty($_POST['is_test'])) $is_test = $_POST['is_test'];
					?>
					<option value="0" <?php if(strcmp($is_test, '0') == 0) echo 'selected="selected" ' ?>>No</option>
					<option value="1" <?php if(strcmp($is_test, '1') == 0) echo 'selected="selected" ' ?>>Yes</option>
				</select>
				<?php echo form_error('is_test'); ?>
				<br />
			</p>
			
			<div id="locations_container">
			<?php 
				for($i = 1; $i <= $locations_number; $i++)
				{
					$codes_number = $_POST['codes_'.$i.'_number'];
					echo '<div class="secondary_form" id="location_'.$i.'" style="padding-bottom:46px;">
									<h3>Location '.$i.' : </h3>
									<p>
										<label for="name_'.$i.'">Location Name:<span class="required">*</span></label>
										<input type="text" name="name_'.$i.'" id="name_'.$i.'" value="'.set_value('name_'.$i).'" />'.form_error('name_'.$i).' <br />
										
										<label for="timezone_'.$i.'">Timezone:</label>
										<select name="timezone_'.$i.'" id="timezone_'.$i.'">
											<option value="America/Los_Angeles" '.set_select('timezone_'.$i, 'America/Los_Angeles').'>PST/PDT (Pacific: Los Angeles, CA)</option>
											<option value="America/Phoenix" '.set_select('timezone_'.$i, 'America/Phoenix').'>MST (Mountain: Phoenix, AZ)</option>
											<option value="America/Boise" '.set_select('timezone_'.$i, 'America/Boise').'>MST/MDT (Mountain: Boise, ID)</option>
											<option value="America/Chicago" '.set_select('timezone_'.$i, 'America/Chicago').'>CST/CDT (Central: Chicago, IL)</option>
											<option value="America/New_York" '.set_select('timezone_'.$i, 'America/New_York').'>EST/EDT (Eastern: New York City, NY)</option>
											<option value="America/Juneau" '.set_select('timezone_'.$i, 'America/Juneau').'>AKST/AKDT (ALASKA: Juneau, AK)</option>
											<option value="Pacific/Honolulu" '.set_select('timezone_'.$i, 'Pacific/Honolulu').'>HST (Hawaii: Honolulu, HI)</option>
										</select>'.form_error('timezone_'.$i).'<br />
										
										<label for="address_'.$i.'">Address:</label>
										<input type="text" name="address_'.$i.'" id="address_'.$i.'" value="'.set_value('address_'.$i).'" />'.form_error('address_'.$i).'<br />
										
										<label for="state_'.$i.'">state:</label>
										<select name="state_'.$i.'" id="state_'.$i.'">';
										$state = '';
										if(!empty($_POST['state_'.$i])) $state = $_POST['state_'.$i];
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
			<?php		echo	form_error('state_'.$i).'<br />
			
										<label for="city_'.$i.'">city:</label>
										<input type="text" name="city_'.$i.'" id="city_'.$i.'" value="'.set_value('city_'.$i).'" />'.form_error('city_'.$i).'<br />
										
										<label for="zipcode_'.$i.'">zipcode:</label>
										<input type="text" name="zipcode_'.$i.'" id="zipcode_'.$i.'" value="'.set_value('zipcode_'.$i).'" />'.form_error('zipcode_'.$i).'<br />
										
										<label for="website_'.$i.'">Location WebSite:</label>
										<input type="text" name="website_'.$i.'" id="website_'.$i.'" value="'.set_value('website_'.$i).'" />'.form_error('website_'.$i).'<br />
										
										<label for="code_'.$i.'_1">Location '.$i.' Codes:<span class="required">*</span></label> <span class="note">(each location should have at least one code)</span><br />	
										
										<div class="codes_container">
											<input class="codes_number" name="codes_'.$i.'_number" type="hidden" value="'.$codes_number.'" />';

					for($j = 1; $j <= $codes_number; $j++)
					{
						echo '		<div class="secondary_form" id="code_section_'.$j.'">
												<span class="label">Code '.$j.': </span> <input type="text" name="code_'.$i.'_'.$j.'" id="code_'.$i.'_'.$j.'" class="secondary_input" value="'.set_value('code_'.$i.'_'.$j).'" />'.form_error('code_'.$i.'_'.$j).'<br />
												<span class="label">Description: </span> <input type="text" name="code_'.$i.'_'.$j.'_desc" id="code_'.$i.'_'.$j.'_desc" value="'.set_value('code_'.$i.'_'.$j.'_desc').'" />'.form_error('code_'.$i.'_'.$j.'_desc').'<br />';
						if($codes_number == $j && $codes_number != 1)
							echo '		<a href="#" class="add_code" style="position:absolute; bottom:5px; right:5px;"> <img src="'.img_url('add_box.png').'" alt="Add a new code" title="Add a new code" width="32" /> </a>
												<a href="#" class="delete_code" style="position:absolute; bottom:5px; right:40px;"> <img src="'.img_url('delete_box.png').'" alt="elete this code" title="elete this code" width="32" /> </a>';
						elseif($codes_number == 1)
							echo '		<a href="#" class="add_code" style="position:absolute; bottom:5px; right:5px;"> <img src="'.img_url('add_box.png').'" alt="Add a new code" title="Add a new code" width="32" /> </a>';
						echo '		</div>';
											
					}
					echo '		</div>
									
										
									</p>
								</div>';
				}
			?>
			</div>
			
			<p>
				<a style="display:block; width:220px; height:20px; text-align:center; margin-left:22%;" class="btn" href="#" id="add_new_location">Click to Add a New Location</a> 
				<span style="display:block; margin-left:22%; font-weight:bold; font-size:15px; color:#777;">Or </span>
		
				<input id="add_box_img" name="add_box_img" type="hidden" value="<?php echo img_url('add_box.png'); ?>" />
				<input id="delete_box_img" name="delete_box_img" type="hidden" value="<?php echo img_url('delete_box.png'); ?>" />
				
				<input id="locations_number" name="locations_number" type="hidden" value="<?php echo $locations_number; ?>" />
				<input name="btn_submit" class="btn_submit" type="submit" value="Submit" />
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
	
						
	
<script type="text/javascript">

function add_location_box()
{
	var $n_locations = parseInt($('#locations_number').val());
	var $add_box_img = $('#add_box_img').val();
	var $delete_box_img = $('#delete_box_img').val();
	
	$n_locations += 1;
	$('#locations_number').val($n_locations);
	
	$('<div class="secondary_form" id="location_'+$n_locations+'" style="padding-bottom:46px;">'+
		'  <h3>Location '+$n_locations+' : </h3>'+	
		'	 <p>'+	
		'			<label for="name_'+$n_locations+'">Location Name:<span class="required">*</span></label>'+	
		'			<input type="text" name="name_'+$n_locations+'" id="name_'+$n_locations+'" />'+	
		'     <br />'+	
		
		'			<label for="timezone_'+$n_locations+'">Timezone:</label>'+	
		'			<select name="timezone_'+$n_locations+'" id="timezone_'+$n_locations+'">'+	
		'				<option value="America/Los_Angeles">PST/PDT (Pacific: Los Angeles, CA)</option>'+	
		'				<option value="America/Phoenix">MST (Mountain: Phoenix, AZ)</option>'+	
		'				<option value="America/Boise">MST/MDT (Mountain: Boise, ID)</option>'+	
		'				<option value="America/Chicago">CST/CDT (Central: Chicago, IL)</option>'+	
		'				<option value="America/New_York">EST/EDT (Eastern: New York City, NY)</option>'+	
		'				<option value="America/Juneau">AKST/AKDT (ALASKA: Juneau, AK)</option>'+	
		'				<option value="Pacific/Honolulu">HST (Hawaii: Honolulu, HI)</option>'+	
		'			</select>'+	
		'			<br />'+	
		
		'			<label for="address_'+$n_locations+'">Address:</label>'+	
		'			<input type="text" name="address_'+$n_locations+'" id="address_'+$n_locations+'" />'+	
		'			<br />'+		
		
		'			<label for="state_'+$n_locations+'">State:</label>'+	
		'			<select name="state_'+$n_locations+'" id="state_'+$n_locations+'">'+	
		'				<option value="" >--Please select--</option>'+
		'				<option value="AL" >Alabama</option>'+
		'				<option value="AK" >Alaska</option>'+
		'				<option value="AZ" >Arizona</option>'+
		'				<option value="AR" >Arkansas</option>'+
		'				<option value="CA" >California</option>'+
		'				<option value="CO" >Colorado</option>'+
		'				<option value="CT" >Connecticut</option>'+
		'				<option value="DE" >Delaware</option>'+
		'				<option value="DC" >District Of Columbia</option>'+
		'				<option value="FL" >Florida</option>'+
		'				<option value="GA" >Georgia</option>'+
		'				<option value="HI" >Hawaii</option>'+
		'				<option value="ID" >Idaho</option>'+
		'				<option value="IL" >Illinois</option>'+
		'				<option value="IN" >Indiana</option>'+
		'				<option value="IA" >Iowa</option>'+
		'				<option value="KS" >Kansas</option>'+
		'				<option value="KY" >Kentucky</option>'+
		'				<option value="LA" >Louisiana</option>'+
		'				<option value="ME" >Maine</option>'+
		'				<option value="MD" >Maryland</option>'+
		'				<option value="MA" >Massachusetts</option>'+
		'				<option value="MI" >Michigan</option>'+
		'				<option value="MN" >Minnesota</option>'+
		'				<option value="MS" >Mississippi</option>'+
		'				<option value="MO" >Missouri</option>'+
		'				<option value="MT" >Montana</option>'+
		'				<option value="NE" >Nebraska</option>'+
		'				<option value="NV" >Nevada</option>'+
		'				<option value="NH" >New Hampshire</option>'+
		'				<option value="NJ" >New Jersey</option>'+
		'				<option value="NM" >New Mexico</option>'+
		'				<option value="NY" >New York</option>'+
		'				<option value="NC" >North Carolina</option>'+
		'				<option value="ND" >North Dakota</option>'+
		'				<option value="OH" >Ohio</option>'+
		'				<option value="OK" >Oklahoma</option>'+
		'				<option value="OR" >Oregon</option>'+
		'				<option value="PA" >Pennsylvania</option>'+
		'				<option value="PR" >Puerto Rico</option>'+
		'				<option value="RI" >Rhode Island</option>'+
		'				<option value="SC" >South Carolina</option>'+
		'				<option value="SD" >South Dakota</option>'+
		'				<option value="TN" >Tennessee</option>'+
		'				<option value="TX" >Texas</option>'+
		'				<option value="UT" >Utah</option>'+
		'				<option value="VT" >Vermont</option>'+
		'				<option value="VA" >Virginia</option>'+
		'				<option value="WA" >Washington</option>'+
		'				<option value="WV" >West Virginia</option>'+
		'				<option value="WI" >Wisconsin</option>'+
		'				<option value="WY" >Wyoming</option>'+
		'			</select>'+	
		'			<br />'+	
		
		'			<label for="city_'+$n_locations+'">City:</label>'+	
		'			<input type="text" name="city_'+$n_locations+'" id="city_'+$n_locations+'" />'+	
		'			<br />'+		
		
		'			<label for="zipcode_'+$n_locations+'">Zipcode:</label>'+	
		'			<input type="text" name="zipcode_'+$n_locations+'" id="zipcode_'+$n_locations+'" />'+	
		'			<br />'+		
		
		'			<label for="website_'+$n_locations+'">Location WebSite:</label>'+	
		'			<input type="text" name="website_'+$n_locations+'" id="website_'+$n_locations+'" />'+	
		'			<br />'+	
		
		'			<label for="code_'+$n_locations+'_1">Location '+$n_locations+' Codes:<span class="required">*</span></label> <span class="note">(each location should have at least one code)</span><br />'+	
		
		'     <div class="codes_container">'+
		'				<input class="codes_number" name="codes_'+$n_locations+'_number" type="hidden" value="1" />'+	
		
		'				<div class="secondary_form" id="code_section_1">'+	
		'					<span class="label">Code 1: </span> <input type="text" name="code_'+$n_locations+'_1" id="code_'+$n_locations+'_1" class="secondary_input" /><br/>'+	
		'					<span class="label">Description: </span> <input type="text" name="code_'+$n_locations+'_1_desc" id="code_'+$n_locations+'_1_desc" /><br/>'+	
		'					<a href="#" class="add_code" style="position:absolute; bottom:5px; right:5px;"><img src="'+$add_box_img+'" alt="Add a new code" title="Add a new code" width="32" /></a>'+	
		'				</div>'+
		'			</div>'+
		
		'  </p>'+	
		'</div>').appendTo('#locations_container').hide().slideDown();
		
		$('#delete_location').remove();
		$('<a href="#" id="delete_location" class="btn" style="color:#F97575; border:1px solid #F97575; display:block; float:right; width:220px; height:20px; text-align:center;" >Delete Location</a>').click(function(){
			remove_location_box();
			return false;
		}).appendTo('#location_'+$n_locations);
}

function remove_location_box()
{
	var $n_locations = parseInt($('#locations_number').val());
	$n_locations -= 1;
	$('#locations_number').val($n_locations);
	if($n_locations == 0)
		$('#delete_location').parent().slideUp(function(){ $(this).remove(); });
	else
	{
		$('#delete_location').parent().slideUp(function(){
			$('#delete_location').appendTo('#location_'+$n_locations);
			$(this).remove();
		});
	}
}

function add_code_box($obj)
{
	var $add_box_img = $('#add_box_img').val();
	var $delete_box_img = $('#delete_box_img').val();
	
	var $container = $obj.parent().parent();
	var $n_codes_input = $obj.parent().parent().children('input.codes_number');
	var $n_codes = parseInt($n_codes_input.val());
	var $cur_loc =  $n_codes_input.attr('name');
	$cur_loc = $cur_loc.substring($cur_loc.indexOf('_')+1, $cur_loc.lastIndexOf('_'));
	
	$n_codes += 1;
	$n_codes_input.val($n_codes);
	
	var $new_elmt = $('<div class="secondary_form" id="code_section_'+$n_codes+'">'+	
		'  <span class="label">Code '+$n_codes+': </span> <input type="text" name="code_'+$cur_loc+'_'+$n_codes+'" id="code_'+$cur_loc+'_'+$n_codes+'" class="secondary_input" /><br/>'+
		'  <span class="label">Description: </span> <input type="text" name="code_'+$cur_loc+'_'+$n_codes+'_desc" id="code_'+$cur_loc+'_'+$n_codes+'_desc" /><br/>'+
		'</div>').appendTo($container).hide().slideDown();
	
	$obj.parent().children('a.delete_code').remove();
	$obj.appendTo($new_elmt);
	$('<a href="#" class="delete_code" style="position:absolute; bottom:5px; right:40px;"><img src="'+$delete_box_img+'" alt="delete this code" title="Delete this code" width="32" /></a>').appendTo($new_elmt);
}

function remove_code_box($obj)
{
	var $n_codes_input = $obj.parent().parent().children('input.codes_number');
	var $n_codes = parseInt($n_codes_input.val());
	$n_codes -= 1;
	$n_codes_input.val($n_codes);
	if($n_codes == 1)
		$obj.parent().slideUp(function(){ $obj.prev().appendTo($(this).prev()); $(this).remove(); });
	else
	{
		$obj.parent().slideUp(function(){
			$obj.prev().appendTo($(this).prev());
			$obj.appendTo($(this).prev());
			$(this).remove();
		});
	}
}

$(document).ready(function()
{
	$('#add_new_location').live('click', function(){
		add_location_box();
		return false;
	});
	
	$('a.add_code').live('click', function(){
		add_code_box($(this));
		return false;
	});
	
	$('a.delete_code').live('click', function(){
		remove_code_box($(this));
		return false;
	});
	
});
</script>