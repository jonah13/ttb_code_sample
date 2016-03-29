	
	<div id="menu-content">
	<div id="content_wrapper">
		<h1>Assigning Companies, Groups, Locations and Codes to <span class="special"><?php echo $user_data['username']; ?></span> :</h1>
		<div class="box">
			<h2>Assign companies, groups, locatons and codes to <?php echo $user_data['username']; ?></span></h2>
			<section>
				<p>Tree List of Companies, Groups, Locations and Codes. Select what you want to assign to <mark><?php echo $user_data['username']; ?></mark> and press submit. (Unchecking a checked box and then clicking submit will result in unassigning that item from the user).</p>
				<?php if(!empty($reply)) echo '<p>'.$reply.'</p>'; ?>
				<!--<div style="float:right; margin:30px 60px; -webkit-border-radius:8px; -moz-border-radius:8px; -o-border-radius:8px; -ms-border-radius:8px; border-radius:8px; border:1px solid #777; padding:5px 20px; ">
					<h3>Colors Legend</h3>
					<p style="font-size:14px; color:#000; font-weight:bold;">Company</p>
					<p style="font-weight:bold; padding-left:0px; color:#777;">Group</p>
					<p style="font-weight:bold; padding-left:0px; color:#1B0062;">Location</p>
					<p style="padding-left:0px;">CODE</p>
				</div>-->
				<form class="standard indent_0" method="post" action="<?php echo site_url('admin_users/assign_rights/'.$user_data['ID'].'/submit'); ?>" >
				<ul class="first_lvl" id="companies_tree">
				<?php
				
					if(empty($linked_comps)) $linked_comps = array();
					if(empty($linked_groups)) $linked_groups = array();
					if(empty($linked_locs)) $linked_locs = array();
					if(empty($linked_codes)) $linked_codes = array();
					foreach($companies as $co)
					{
						$attr = '';
						if(in_array($co->ID, $linked_comps))
							$attr = ' <span class="full">(Full Access)</span>';
						else
						{
							if(!empty($co->groups) && !empty($linked_groups))
							{
								foreach($co->groups as $group)
								{
									if(in_array($group->ID, $linked_groups))
									{
										$attr = ' <span>(Partial Access)</span>';
										break;
									}
									if(!empty($group->locations) && !empty($linked_comps))
									{
										foreach($group->locations as $loc)
										{
											if(in_array($loc->ID, $linked_locs))
											{
												$attr = ' <span>(Partial Access)</span>';
												break 2;
											}
											if(!empty($loc->codes) && !empty($linked_codes))
											{
												foreach($loc->codes as $code)
												{
													if(in_array($code->ID, $linked_codes))
													{
														$attr = ' <span>(Partial Access)</span>';
														break 3;
													}
												}
											}
										}
									}
								}
							}
							if(!empty($co->locations))
							{
								foreach($co->locations as $loc)
								{
									if(in_array($loc->ID, $linked_locs))
									{
										$attr = ' <span>(Partial Access)</span>';
										break 1;
									}
									if(!empty($loc->codes) && !empty($linked_codes))
									{
										foreach($loc->codes as $code)
										{
											if(in_array($code->ID, $linked_codes))
											{
												$attr = ' <span>(Partial Access)</span>';
												break 2;
											}
										}
									}
								}
							}
							
						}
						echo '<li>';
							echo '<div class="comp_container"><a href="#" class="expand" style="margin-left:20px;"><img src="'.img_url('icon_expand.gif').'" alt="expand/collapse" /></a><input type="checkbox" class="company checkbox" name="companies[]" id="company_'.$co->ID.'" value="'.$co->ID.'"  '.set_checkbox('companies[]', $co->ID, in_array($co->ID, $linked_comps)).' style="width:20px; margin:5px 0 5px 10px;" /><label for="company_'.$co->ID.'" style="text-align:left; width:auto; marign:0; font-size:14px; color:#000;">'.$co->name.'</label>'.$attr.'</div>';
							echo '<ul class="sec_lvl collapsed" style="margin:6px 0 6px 20px;">';
								if(!empty($co->groups))
								{
									foreach($co->groups as $group)
									{
									 echo '<li>';
										echo '<div><a href="#" class="expand" style="margin-left:20px;"><img src="'.img_url('icon_expand.gif').'" alt="expand/collapse" /></a><input type="checkbox" class="group checkbox" name="groups[]" id="group_'.$group->ID.'" value="'.$group->ID.'"  '.set_checkbox('groups[]', $group->ID, in_array($group->ID, $linked_groups)).' style="width:20px; margin:0; margin-left:10px;" /><label for="group_'.$group->ID.'" style="text-align:left; width:auto; font-size:13px; marign:0;">'.$group->name.'</label></div>';
										echo '<ul class="thrid_lvl collapsed" style="margin:5px 0 5px 40px;">';
											if(!empty($group->locations))
											{
												foreach($group->locations as $loc)
												{
												 echo '<li>';
													echo '<div><a href="#" class="expand" style="margin-left:20px;"><img src="'.img_url('icon_expand.gif').'" alt="expand/collapse" /></a><input type="checkbox" class="location checkbox" name="locations[]" id="location_'.$loc->ID.'" value="'.$loc->ID.'"  '.set_checkbox('locations[]', $loc->ID, in_array($loc->ID, $linked_locs)).' style="width:20px; margin:0; margin-left:10px;" /><label for="location_'.$loc->ID.'" style="text-align:left; width:auto; marign:0; color:#1B0062;">'.$loc->name.'</label></div>';
													echo '<ul class="fourth_lvl collapsed" style="margin:5px 0 5px 60px;">';
														if(!empty($loc->codes))
														{
															foreach($loc->codes as $code)
															{
															 echo '<li>';
																echo '<div><input type="checkbox" class="code checkbox" name="codes[]" id="code_'.$code->ID.'" value="'.$code->ID.'"  '.set_checkbox('codes[]', $code->ID, in_array($code->ID, $linked_codes)).' style="width:20px; margin:0; margin-left:10px;" /><label for="code_'.$code->ID.'" style="text-align:left; width:auto; marign:0; font-weight:normal; color:#000;">'.$code->code.'</label></div>';
															 echo '</li>';
															}
														}
													echo '</ul>';
												 echo '</li>';
												}
											}
										echo '</ul>';
									 echo '</li>';
									}
								}
								if(!empty($co->locations))
								{
									foreach($co->locations as $loc)
									{
									 echo '<li>';
										echo '<div><a href="#" class="expand" style="margin-left:20px;"><img src="'.img_url('icon_expand.gif').'" alt="expand/collapse" /></a><input type="checkbox" class="location checkbox" name="locations[]" id="location_'.$loc->ID.'" value="'.$loc->ID.'"  '.set_checkbox('locations[]', $loc->ID, in_array($loc->ID, $linked_locs)).' style="width:20px; margin:0; margin-left:10px;" /><label for="location_'.$loc->ID.'" style="text-align:left; width:auto; marign:0; color:#1B0062;">'.$loc->name.'</label></div>';
										echo '<ul class="third_lvl collapsed" style="margin:5px 0 5px 40px;">';
											if(!empty($loc->codes))
											{
												foreach($loc->codes as $code)
												{
												 echo '<li>';
													echo '<div><input type="checkbox" class="code checkbox" name="codes[]" id="code_'.$code->ID.'" value="'.$code->ID.'"  '.set_checkbox('codes[]', $code->ID, in_array($code->ID, $linked_codes)).' style="width:20px; margin:0; margin-left:10px;" /><label for="code_'.$code->ID.'" style="text-align:left; width:auto; marign:0; font-weight:normal; color:#000;">'.$code->code.'</label></div>';
												 echo '</li>';
												}
											}
										echo '</ul>';
									 echo '</li>';
									}
								}
							echo '</ul>';
						echo '</li>';
					}
				
				?>
				</ul>
				<input name="btn_submit" class="btn_submit" type="submit" value="Submit" style="margin-left:20px; width:300px; height:40px; padding:1px;" />
				</form>
			</section>
		</div>
	</div>
	</div>
	<script>
	$(document).ready(function()
	{
		create_tree($('#companies_tree'));
		update_all_checkboxes();
		$('#companies_tree input.checkbox').live('change', function() {update_checkbox($(this)); });
		
	});
	
	function update_checkbox(elmt)
	{
		if(elmt.is(':checked')) //when a checkbox is checked, we check all the checkboxes under it
		{
			elmt.parent().next().find('input.checkbox').prop('checked', true);
		}
		else //otherwise, we uncheck all the checkboxes under it
		{
			elmt.parent().next().find('input.checkbox').prop('checked', false);
			elmt.parents('ul').prev().find('input.checkbox').prop('checked', false);
		}
		update_all_checkboxes();
	}
	
	function update_all_checkboxes()
	{
		$('input.location:checked, input.group:checked, input.company:checked').each(function(i){
			$(this).parent().next().find('input.checkbox').prop('checked', true);
		});
		
		$('input.location:not(:checked)').each(function(i){
			var unchecked_children = $(this).parent().next().find('input.checkbox:not(:checked)');
			var checked_children = $(this).parent().next().find('input.checkbox:checked');
			if(unchecked_children.length == 0)
			{
				$(this).prop('checked', true);
				$(this).prop('indeterminate', false);
			}
			else 
			{
				if(checked_children.length != 0)
					$(this).prop('indeterminate', true);
				else
					$(this).prop('indeterminate', false);
			}
		});
		
		$('input.group:not(:checked)').each(function(i){
			var unchecked_children = $(this).parent().next().find('input.checkbox:not(:checked)');
			var checked_children = $(this).parent().next().find('input.checkbox:checked');
			if(unchecked_children.length == 0)
			{
				$(this).prop('checked', true);
				$(this).prop('indeterminate', false);
			}
			else 
			{
				if(checked_children.length != 0)
					$(this).prop('indeterminate', true);
				else
					$(this).prop('indeterminate', false);
			}
		});
		
		$('input.company:not(:checked)').each(function(i){
			var unchecked_children = $(this).parent().next().find('input.checkbox:not(:checked)');
			var checked_children = $(this).parent().next().find('input.checkbox:checked');
			if(unchecked_children.length == 0)
			{
				$(this).prop('checked', true);
				$(this).prop('indeterminate', false);
			}
			else 
			{
				if(checked_children.length != 0)
					$(this).prop('indeterminate', true);
				else
					$(this).prop('indeterminate', false);
			}
		});
		
	}
	
	
	function create_tree(list)
	{
		$('a.expand').live('click', function(){ expand($(this), list); return false; });
		$('a.collapse').live('click', function(){ collapse($(this), list); return false; });
		update(list);
	}
	
	function update(list)
	{
		list.find('ul.expanded').show();
		list.find('ul.collapsed').hide();
	}
	
	function expand(elmt, list)
	{
		to_expand = elmt.parent().next();
		if(to_expand.hasClass('collapsed'))
		{
			to_expand.removeClass('collapsed').addClass('expanded');
			elmt.removeClass('expand').addClass('collapse');
			elmt.children('img').attr('src', "<?php echo img_url('icon_collapse.gif'); ?>"); 
			update(list);
		}
	}
	
	function collapse(elmt, list)
	{
		to_collapse = elmt.parent().next();
		if(to_collapse.hasClass('expanded'))
		{
			to_collapse.removeClass('expanded').addClass('collapsed');
			elmt.removeClass('collapse').addClass('expand');
			elmt.children('img').attr('src', "<?php echo img_url('icon_expand.gif'); ?>"); 
			update(list);
		}
	}
	</script>
	<p class="content_end">&nbsp;</p>
	


				
				</div>
			</div>
		</div>
	</div><!-- #body -->