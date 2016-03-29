<?php 
//echo '<pre>'.print_r($_POST, true).'</pre>';
//echo '<pre>'.print_r($hierarchy, true).'</pre>';

	function display_inputs_tree($tree, $indent = 0)
	{
		$margin = $indent*30;
		$id = '';
		if($indent == 0)
			$id = 'id="company_tree"';
		echo '<ul '.$id.' style="margin-left:'.$margin.'px">';
		$indent++;
		foreach($tree as $elmt)
		{
			if(!empty($elmt['children']))
			{
				echo '<li>'.'<input type="checkbox" class="checkbox subgroup_checkbox" name="subgroups[]" id="subgroup_'.$elmt['ID'].'" value="'.$elmt['ID'].'"  '.set_checkbox('subgroups[]', $elmt['ID']).' /><label for="subgroup_'.$elmt['ID'].'">'.$elmt['name'].'</label>';
				display_inputs_tree($elmt['children'], $indent);
			}
			else
				echo '<li>'.'<input type="checkbox" class="checkbox location_checkbox" name="locations[]" id="loc_'.$elmt['ID'].'" value="'.$elmt['ID'].'"  '.set_checkbox('locations[]', $elmt['ID']).' /><label style="color:#1B0062; font-weight:normal;" for="loc_'.$elmt['ID'].'">'.$elmt['name'].'</label>';
			echo '</li>';
			
		}
		echo '</ul>';
	}
?>		
	<div id="menu-content">
	<div id="content_wrapper">
		<h1>Adding a new <span class="special">Group</span> for "<?php echo $company_data['name']; ?>" :</h1>
		<div class="box">
			<h2>Add Group</h2>
			<section>
			<p>To add a new Group for <strong><?php echo $company_data['name']; ?></strong>, complete fields below, and click submit.</p><br />
			<?php if(!empty($other_errors)) echo '<p class="reply" style="color:red;">'.$other_errors.'</p>'; ?>
			<form id="add_group_form" class="standard indent_0" method="post" action="<?php echo site_url('admin_companies/submit_add_group/'.$company_data['ID']); ?>" >
			<div  class="primary_form" style="padding-bottom:46px;">
				<h3>Group Information</h3>
				<p>
					<label for="type">Group Type:<span class="required">*</span>  (Region, District, Sector, ...)</label>
					<?php 
						if(empty($group_types))
							echo '<input type="text" name="type" id="type" value="'.set_value('type').'" /> '.form_error('type').'<br />';
						else
						{
							echo '<div>';
							echo '	<div id="choose_type"><label for="type_select">Choose Existing: </label>';
							echo '	<select name="type" id="type_select">';
							foreach($group_types as $type)
								echo '	<option value="'.$type.'" '.set_select('type', $type).'>'.$type.'</option>';
							echo '	</select>';
							echo '	Or <a href="#" id="add_new">Add New</a>.</div>';
							echo '	<div id="add_new_type"><label for="type_input">Add New: </label> <input type="text" name="not_type" id="type_input" value="'.set_value('type').'" /> '.form_error('type').' Or <a href="#" id="choose_existing">Choose Existing</a>.</div>';
							echo '</div>';
						}
					?>
					
					
					<label for="name">Group Name:<span class="required">*</span></label>
					<input type="text" name="name" id="name" value="<?php echo set_value('name'); ?>" /> <?php echo form_error('name'); ?> <br />
				</p>
			</div>
			
			<div  class="primary_form" style="padding-bottom:46px;">
				<h3>Add locations to this Group</h3> <?php echo form_error('locations[]'); ?> <?php echo form_error('subgroups[]'); ?>
				<p>
				<?php 
					display_inputs_tree($hierarchy);
				?>
				</p>
			</div>
			<p>
			
				<input name="btn_submit" class="btn_submit" id="submit" type="submit" value="Submit" />
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
$(document).ready(function()
{
	$('#add_new_type').hide();
	
	$('a#add_new').click(function(){
		$('#choose_type').fadeOut(function(){
			$('#add_new_type').fadeIn();
		});
		$('#type_select').attr('name', 'not_type');
		$('#type_input').attr('name', 'type');
		return false;
	});
	$('a#choose_existing').click(function(){
		$('#add_new_type').fadeOut(function(){
			$('#choose_type').fadeIn();
		});
		$('#type_select').attr('name', 'type');
		$('#type_input').attr('name', 'not_type');
		return false;
	});
	
	create_tree($('#company_tree'));
	link_checkboxes($('#company_tree'));
	
	$('#add_group_form').submit(function(event){
		var type = $('[name="type"]').val();
		var name = $('input#name').val();
		
		var attributes = {
			has_parent:0
		};
		
		var locations = new Array();
		$.each($("input.location_checkbox:checked"), function() { locations.push($(this).val()); });	
		var subgroups = new Array();
		//we add the selected subgroups
		$.each($("input.subgroup_checkbox:checked"), function() { subgroups.push($(this).val()); });
		//we remove their children from the subgroups and locations arrays
		for(var i = 0; i < subgroups.length; i++)
		{
			$('input#subgroup_'+subgroups[i]).next().next().find('input.checkbox').each(function(){
				if($(this).hasClass('location_checkbox'))
					remove_from_array(locations, $(this).val());
				if($(this).hasClass('subgroup_checkbox'))
					remove_from_array(subgroups, $(this).val());
			});
		}
		
		//alert('type:'+type+' name:'+name+' locs:'+locations+' sg:'+subgroups);
		var possible = possible_group(locations, subgroups, attributes);
		if(!type || !name || (!locations.length && !subgroups.length) || !possible)
		{
			var message  = '';
			if(!type)
				message += 'You should choose a type for the group\n';
			if(!name)
				message += 'You should choose a name for the group\n';
			if(!locations.length && !subgroups.length)
				message += 'You group should at least contain a location or a subgroup\n';
			if(!possible)
				message += 'The elements you\'ve chosen can\'t form a group. Make sure the elements have the same parent!\n';
			alert(message);
			event.preventDefault();
		}
		else
		{;
			$('#add_group_form').append("<input type='hidden' name='filtred_locations' value='"+locations+"' />");
			$('#add_group_form').append("<input type='hidden' name='filtred_subgroups' value='"+subgroups+"' />");
			$('#add_group_form').append("<input type='hidden' name='has_parent' value='"+attributes.has_parent+"' />");
		}
	});
});

function possible_group(locations, subgroups, attributes)
{
	var parent = 0;
	for(var i in locations)
	{
		var parent_elmt = $('input#loc_'+locations[i]).parent().parent().prev().prev();
		if(parent_elmt.hasClass('subgroup_checkbox'))
		{
			if(parent == 0)
				parent = parent_elmt.val();
			else
			{
				if(parent != parent_elmt.val())
					return false;
			}
		
		}
	}
	for(var i in subgroups)
	{
		var parent_elmt = $('input#subgroup_'+subgroups[i]).parent().parent().prev().prev();
		if(parent_elmt.hasClass('subgroup_checkbox'))
		{
			if(parent == 0)
				parent = parent_elmt.val();
			else
			{
				if(parent != parent_elmt.val())
					return false;
			}
		
		}
	}
	if(parent != 0)
		attributes.has_parent = 1;
	return true;
}

function remove_from_array(array, item)
{
  for(var i in array)
	{
		if(array[i]==item)
		{
			array.splice(i,1);
			break;
		}
	}
}

function create_tree(elmt)
{
	elmt.find('li').has('ul').each(function(){
		$('<a href="#" class="collapse"><img src="<?php echo img_url('icon_collapse.gif'); ?>" alt="expand/collapse" /></a>').prependTo($(this));
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