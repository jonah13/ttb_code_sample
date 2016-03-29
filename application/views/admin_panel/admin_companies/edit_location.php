<?php 
//echo '<pre>'.print_r($_POST, true).'</pre>';
//var_dump($location_data);
?>		
	<div id="menu-content">
	<div id="content_wrapper">
		<h1>Editing Location <span class="special"><?php echo $location_data['name']; ?></span> :</h1>
		<div class="box">
			<h2>Edit location</h2>
			<section>
			<p>Make the changes you want to the fields below and click submit. (You can delete a field by making it empty)</p><br />
			<?php if(!empty($other_errors)) echo '<p class="reply" style="color:red;">'.$other_errors.'</p>'; ?>
			<form class="standard indent_0" method="post" action="<?php echo site_url('admin_companies/submit_edit_location/'.$location_data['ID']); ?>" >
			<div id="locations_container">
			<?php 
				if(!empty($_POST['codes_number'])) $codes_number = $_POST['codes_number'];
				else $codes_number = count($location_data['codes']);
					echo '<div  class="primary_form" id="location" style="padding-bottom:46px;">
									<p>
										<label for="name">Location Name:<span class="required">*</span></label>
										<input type="text" name="name" id="name" value="'.set_value('name', $location_data['name']).'" />'.form_error('name').' <br />
										
										<label for="timezone">Timezone:</label>
										<select name="timezone" id="timezone">
											<option value="America/Los_Angeles" '.set_select('timezone', 'America/Los_Angeles', ($location_data['timezone'] == 'America/Los_Angeles')?TRUE:FALSE).'>PST/PDT (Pacific: Los Angeles, CA)</option>
											<option value="America/Phoenix" '.set_select('timezone', 'America/Phoenix', ($location_data['timezone'] == 'America/Phoenix')?TRUE:FALSE).'>MST (Mountain: Phoenix, AZ)</option>
											<option value="America/Boise" '.set_select('timezone', 'America/Boise', ($location_data['timezone'] == 'America/Boise')?TRUE:FALSE).'>MST/MDT (Mountain: Boise, ID)</option>
											<option value="America/Chicago" '.set_select('timezone', 'America/Chicago', ($location_data['timezone'] == 'America/Chicago')?TRUE:FALSE).'>CST/CDT (Central: Chicago, IL)</option>
											<option value="America/New_York" '.set_select('timezone', 'America/New_York', ($location_data['timezone'] == 'America/New_York')?TRUE:FALSE).'>EST/EDT (Eastern: New York City, NY)</option>
											<option value="America/Juneau" '.set_select('timezone', 'America/Juneau', ($location_data['timezone'] == 'America/Juneau')?TRUE:FALSE).'>AKST/AKDT (ALASKA: Juneau, AK)</option>
											<option value="Pacific/Honolulu" '.set_select('timezone', 'Pacific/Honolulu', ($location_data['timezone'] == 'Pacific/Honolulu')?TRUE:FALSE).'>HST (Hawaii: Honolulu, HI)</option>
										</select>'.form_error('timezone').'<br />
										
										<label for="address">Address:</label>
										<input type="text" name="address" id="address" value="'.set_value('address', $location_data['address']).'" />'.form_error('address').'<br />
										
										<label for="state">state:</label>
										<select name="state" id="state">';
										$state = $location_data['state'];
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
			<?php		echo	form_error('state').'<br />
			
										<label for="city">city:</label>
										<input type="text" name="city" id="city" value="'.set_value('city', $location_data['city']).'" />'.form_error('city').'<br />
										
										<label for="zipcode">zipcode:</label>
										<input type="text" name="zipcode" id="zipcode" value="'.set_value('zipcode', $location_data['zipcode']).'" />'.form_error('zipcode').'<br />
										
										<label for="website">Location WebSite:</label>
										<input type="text" name="website" id="website" value="'.set_value('website', $location_data['website']).'" />'.form_error('website').'<br />
										
										<label for="code_1">Location Codes:<span class="required">*</span></label> <span class="note">(each location should have at least one code)</span><br />	
										
										<div class="codes_container">
											<input class="codes_number" name="codes_number" type="hidden" value="'.$codes_number.'" />';

					for($j = 1; $j <= $codes_number; $j++)
					{
						$temp_code = (empty($_POST['code_'.$j]))?$location_data['codes'][$j-1]->code:$_POST['code_'.$j];
						$temp_desc = (empty($_POST['code_'.$j.'_desc']))?$location_data['codes'][$j-1]->description:$_POST['code_'.$j.'_desc'];
						echo '		<div class="secondary_form" id="code_section_'.$j.'">
												<span class="label">Code '.$j.': </span> <input type="text" name="code_'.$j.'" id="code_'.$j.'" class="secondary_input" value="'.set_value('code_'.$j, $temp_code).'" />'.form_error('code_'.$j).'<br />
												<span class="label">Description: </span> <input type="text" name="code_'.$j.'_desc" id="code_'.$j.'_desc" value="'.set_value('code_'.$j.'_desc', $temp_desc).'" />'.form_error('code_'.$j.'_desc').'<br />';
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
			?>
			</div>
			
			<p>
				<input id="add_box_img" name="add_box_img" type="hidden" value="<?php echo img_url('add_box.png'); ?>" />
				<input id="delete_box_img" name="delete_box_img" type="hidden" value="<?php echo img_url('delete_box.png'); ?>" />
				
				<input name="btn_submit" class="btn_submit" type="submit" value="Submit Changes" />
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

function add_code_box($obj)
{
	var $add_box_img = $('#add_box_img').val();
	var $delete_box_img = $('#delete_box_img').val();
	
	var $container = $obj.parent().parent();
	var $n_codes_input = $obj.parent().parent().children('input.codes_number');
	var $n_codes = parseInt($n_codes_input.val());
	
	$n_codes += 1;
	$n_codes_input.val($n_codes);
	
	var $new_elmt = $('<div class="secondary_form" id="code_section_'+$n_codes+'">'+	
		'  <span class="label">Code '+$n_codes+': </span> <input type="text" name="code_'+$n_codes+'" id="code_'+$n_codes+'" class="secondary_input" /><br/>'+
		'  <span class="label">Description: </span> <input type="text" name="code_'+$n_codes+'_desc" id="code_'+$n_codes+'_desc" /><br/>'+
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
	$('a.add_code').live('click', function(){
		add_code_box($(this));
		return false;
	});
	
	$('a.delete_code').live('click', function(){
		var r = confirm("Confirm deleting: Are you sure you want to delete this code? if you press OK then the code will be deleted upon submitting the changes.");
		if (r) 
		{
			remove_code_box($(this));
			return false;
		}
		else
			return false;
	});
	
});
</script>