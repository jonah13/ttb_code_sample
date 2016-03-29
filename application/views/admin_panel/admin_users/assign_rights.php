<?php 
//echo '<pre>'.print_r($_POST, true).'</pre>';
//echo '<pre>'.print_r($rights, true).'</pre>';

	function display_inputs_tree($tree, $indent = 0, $rights)
	{
		$id = '';
		if($indent == 0)
		{	
			$margin = 0;
			$id = 'class="company_tree form_elements" id="id_'.$tree['ID'].'" ';
			$access = ''; $t = '';
			if(in_array($tree['ID'], $rights['companies']))
			{
				$access = ' <span class="full">(Full Access)</span>';
				$t = 'checked="checked"';
			}
			echo '<ul '.$id.' style="margin-left:'.$margin.'px">';
			echo '	<li><input type="checkbox" class="checkbox company_checkbox" name="companies[]" id="company_'.$tree['ID'].'" value="'.$tree['ID'].'" '.$t.' '.set_checkbox('companies[]', $tree['ID'], in_array($tree['ID'], $rights['companies'])).' /><label for="company_'.$tree['ID'].'" style="font-size:14px; color:#000; font-weight:bold;">'.$tree['name'].$access.'</label>';
			$indent++;
			display_inputs_tree($tree['tree'], $indent, $rights);
			echo '</li></ul>';
		}
		else
		{
			$margin = 50;
			$id = '';
			echo '<ul '.$id.' style="margin-left:'.$margin.'px">';
			$indent++;
			foreach($tree as $elmt)
			{
				$t = '';
				if(!empty($elmt['children']))
				{
					if(in_array($elmt['ID'], $rights['groups']))
						$t = 'checked="checked"';
					echo '<li><input type="checkbox" class="checkbox subgroup_checkbox" name="subgroups[]" id="subgroup_'.$elmt['ID'].'" value="'.$elmt['ID'].'" '.$t.' '.set_checkbox('subgroups[]', $elmt['ID']).' /><label for="subgroup_'.$elmt['ID'].'">'.$elmt['name'].'</label>';
					display_inputs_tree($elmt['children'], $indent, $rights);
				}
				else
				{
					if(in_array($elmt['ID'], $rights['locations']))
						$t = 'checked="checked"';
					echo '<li><input type="checkbox" class="checkbox location_checkbox" name="locations[]" id="loc_'.$elmt['ID'].'" value="'.$elmt['ID'].'" '.$t.' '.set_checkbox('locations[]', $elmt['ID']).' /><label style="font-weight:bold; padding-left:0px; color:#1B0062;" for="loc_'.$elmt['ID'].'">'.$elmt['name'].'</label>';
					if(!empty($elmt['codes']))
					{
						$t = '';
						echo '<ul style="margin-left:'.$margin.'px">';
						foreach($elmt['codes'] as $code)
						{
							if(in_array($code['ID'], $rights['codes']))
								$t = 'checked="checked"';
							echo '<li><input type="checkbox" class="checkbox code_checkbox" name="codes[]" id="code_'.$code['ID'].'" value="'.$code['ID'].'" '.$t.' '.set_checkbox('codes[]', $code['ID']).' /><label style="color:#1B0062; font-weight:normal;" for="code_'.$code['ID'].'">'.$code['code'].'</label>';
						}
						echo '</ul>';
					}
				}
				echo '</li>';
				
			}
			echo '</ul>';
		}
	}
	
?>
	<div id="menu-content">
	<div id="content_wrapper">
		<h1>Assigning Companies, Groups, Locations and Codes to <span class="special"><?php echo $user_data['username']; ?></span> :</h1>
		<div class="box">
			<h2>Assign companies, groups, locatons and codes to <?php echo $user_data['username']; ?></span></h2>
			<section>
				<p>Tree List of Companies, Groups, Locations and Codes. Select what you want to assign to <mark><?php echo $user_data['username']; ?></mark> and press submit. (Unchecking a checked box and then clicking submit will result in unassigning that item from the user).</p>
				<?php if(!empty($reply)) echo '<p>'.$reply.'</p>'; ?>
				<form class="standard indent_0" id="assign_rights_form" method="post" action="<?php echo site_url('admin_users/assign_rights/'.$user_data['ID'].'/submit'); ?>" >
				<ul id="companies_tree">
				<?php 
					foreach($companies as $co)
					{
						display_inputs_tree($co, 0, $rights);
					}
				?>
				
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
	link_checkboxes($('#companies_tree'));
	partial_access_companies($('#companies_tree'));
	
	$('#assign_rights_form').submit(function(event){
		var codes = new Array();
		$.each($("input.code_checkbox:checked"), function() { codes.push($(this).val()); });	
		var locations = new Array();
		$.each($("input.location_checkbox:checked"), function() { locations.push($(this).val()); });	
		var subgroups = new Array();
		$.each($("input.subgroup_checkbox:checked"), function() { subgroups.push($(this).val()); });
		var companies = new Array();
		$.each($("input.company_checkbox:checked"), function() { companies.push($(this).val()); });
		//we remove their children from the subgroups and locations arrays
		for(var i = 0; i < companies.length; i++)
		{
			$('input#company_'+companies[i]).next().next().find('input.checkbox').each(function(){
				if($(this).hasClass('subgroup_checkbox'))
					remove_from_array(subgroups, $(this).val());
				if($(this).hasClass('location_checkbox'))
					remove_from_array(locations, $(this).val());
				if($(this).hasClass('code_checkbox'))
					remove_from_array(codes, $(this).val());
			});
		}
		for(var i = 0; i < subgroups.length; i++)
		{
			$('input#subgroup_'+subgroups[i]).next().next().find('input.checkbox').each(function(){
				if($(this).hasClass('subgroup_checkbox'))
				{
					if(remove_from_array(subgroups, $(this).val()))
						i = 0;
				}
				if($(this).hasClass('location_checkbox'))
					remove_from_array(locations, $(this).val());
				if($(this).hasClass('code_checkbox'))
					remove_from_array(codes, $(this).val());
			});
		}
		for(var i = 0; i < locations.length; i++)
		{
			$('input#loc_'+locations[i]).next().next().find('input.checkbox').each(function(){
				if($(this).hasClass('code_checkbox'))
					remove_from_array(codes, $(this).val());
			});
		}
		
		//alert('type:'+type+' name:'+name+' locs:'+locations+' sg:'+subgroups);
		$('#assign_rights_form').append("<input type='hidden' name='filtred_companies' value='"+companies+"' />");
		$('#assign_rights_form').append("<input type='hidden' name='filtred_subgroups' value='"+subgroups+"' />");
		$('#assign_rights_form').append("<input type='hidden' name='filtred_locations' value='"+locations+"' />");
		$('#assign_rights_form').append("<input type='hidden' name='filtred_codes' value='"+codes+"' />");
	});
});

function partial_access_companies(elmt)
{
	elmt.find('input.company_checkbox').each(function(){
		if($(this).prop('indeterminate'))
			$('<span class="partial"> (Partial Access)</span>').appendTo($(this).next());
	});
}

function remove_from_array(array, item)
{
  for(var i in array)
	{
		if(array[i]==item)
		{
			array.splice(i,1);
			return true;
		}
	}
	return false;
}

function create_tree(elmt)
{
	elmt.find('li').has('ul').each(function(){
		$('<a href="#" class="expand"><img src="<?php echo img_url('icon_expand.gif'); ?>" alt="expand/collapse" /></a>').prependTo($(this));
		$(this).children('ul').hide();
	});
	
	//expand/collapse
	elmt.find('a.collapse').live('click', function(){
		$(this).removeClass('collapse').addClass('expand');
		var src = $(this).children('img').attr('src');
		$(this).children('img').attr('src', src.replace('collapse', 'expand'));
		$(this).parent('li').children('ul').slideUp(300);
		return false;
	});
	elmt.find('a.expand').live('click', function(){
		$(this).removeClass('expand').addClass('collapse');
		var src = $(this).children('img').attr('src');
		$(this).children('img').attr('src', src.replace('expand', 'collapse'));
		$(this).parent('li').children('ul').slideDown(300);
		return false;
	});
}

function link_checkboxes(elmt)
{
	update_all_checkboxes(elmt);
	elmt.find('input.checkbox').live('change', function(){
		update_checkbox($(this));
		update_all_checkboxes(elmt);
	});
}

function update_checkbox(elmt)
{
	if(elmt.is(':checked')) //when a checkbox is checked, we check all the checkboxes under it
	{
		elmt.next().next().find('input.checkbox').prop('indeterminate', false);
		elmt.next().next().find('input.checkbox').prop('checked', true);
	}
	else //otherwise, we uncheck all the checkboxes under it
	{
		elmt.next().next().find('input.checkbox').prop('checked', false);
		elmt.parents('ul').prev().prev().prop('checked', false);
	}
}

function update_all_checkboxes(elmt)
{
	elmt.find('input:checked').each(function(i){
		$(this).next().next().find('input.checkbox').prop('checked', true);
	});
	
	elmt.find('input:not(:checked)').each(function(i){
		var children = $(this).next().next().find('input.checkbox');
		if(children.length > 0)
		{
			var unchecked_children = $(this).next().next().find('input.checkbox:not(:checked)');
			var checked_children = $(this).next().next().find('input.checkbox:checked');
			if(unchecked_children.length == 0)
			{
				if(!$(this).prop('checked'))
				{
					$(this).prop('checked', true);
					update_all_checkboxes(elmt);
				}
				$(this).prop('indeterminate', false);
			}
			else 
			{
				if(checked_children.length != 0)
					$(this).prop('indeterminate', true);
				else
					$(this).prop('indeterminate', false);
			}
		}
	});
}
	</script>
	<p class="content_end">&nbsp;</p>
	


				
				</div>
			</div>
		</div>
	</div><!-- #body -->