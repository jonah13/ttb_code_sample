<?php 
	function get_subgroups($elmt)
	{
		$subgroups = array();
		foreach($elmt['children'] as $e)
		{
			if(!empty($e['children'])) //is a subgroup means it has children
				$subgroups[] = $e;
		}
		return $subgroups;
	}
	
	function get_locations($elmt)
	{
		$locs = array();
		foreach($elmt['children'] as $e)
		{
			if(empty($e['children'])) //is a subgroup means it has children
				$locs[] = $e;
		}
		return $locs;
	}
	
	function display_table_rows($tree, $indent = 0)
	{
		$not_empty = false;
		foreach($tree as $elmt)
			if(!empty($elmt['children']))
				$not_empty = true;
		
		if($not_empty)
		{
			$to_indent = ' ';
			for($j = 0;  $j < $indent; $j++)
				$to_indent.= '&mdash;&mdash;';
			$indent++;
			
			foreach($tree as $elmt)
			{
				if(!empty($elmt['children']))
				{
					echo '<tr>';
						echo '<td class="first"> '.$to_indent.' '.$elmt['name'].'</td>';	
						echo '<td>'.$elmt['type'].'</td>';
						$subgroups = get_subgroups($elmt);
						if(!empty($subgroups))
						{
							echo '<td style="text-align:left;">';
							foreach($subgroups as $sg)
								echo '<span style="display:block;">'.$sg['name'].'</span>';
							echo '</td>';
						}
						else
							echo '<td>N/A</td>';
						$locs = get_locations($elmt);
						if(!empty($locs))
						{
							echo '<td style="text-align:left;">';
							foreach($locs as $loc)
								echo '<span style="display:block;">'.$loc['name'].'</span>';
							echo '</td>';
						}
						else
							echo '<td>N/A</td>';
						echo '<td><a href="'.site_url('admin_companies/edit_group/'.$elmt['ID']).'"><img src="'.img_url('edit.png').'" alt="Edit"></a></td>';
						echo '<td><a href="'.site_url('admin_companies/delete_group/'.$elmt['ID']).'"><img src="'.img_url('delete.png').'" alt="Delete"></a></td>';
					echo '</tr>';
					display_table_rows($elmt['children'], $indent);
				}
			}
		}
	}
					
?>
			<div id="menu-content">
				<div id="content_wrapper">
				<h1>Manage <span class="special"><?php echo $company_data['name']; ?></span>'s Groups :</h1>
				<div class="box">
					<h2>Add Groups</h2>
					<section>
						<p>
							Groups provide way to organize locations by a common factor like their region or their speciality. <br/>
							Make sure to give groups the approriate name and type and to place them in their right place in the hierarchy, the type and name will be used in feedback filters. <br/>
							<a href="<?php echo site_url('admin_companies/add_group/'.$company_data['ID']); ?>" class="semi_btn float_right" class="btn" >Add A New Group</a>
							You can add a new Group for <strong><?php echo $company_data['name']; ?></strong> from the following button: 
							<br class="clear_float"/>
						<p>
					</section>
				</div>
				<?php if(!empty($reply)) echo '<p class="reply">'.$reply.'</p>'; ?>
				<div class="box">
					<h2>List of <?php echo $company_data['name']; ?>'s Groups</h2>
					<section>
						<?php
						$gps_number = count($groups);
						if($gps_number == 0)
							echo '<p>There is no group registered for this company, you can add a new group for '. $company_data['name'].' from <a href="'.site_url('admin_companies/add_group/'.$company_data['ID']).'">here</a>.</p>';
						else 
						{
							if($gps_number == 1)
								echo '<p>There is currently <mark>1</mark> group registered for this company. Select the action you want to perform from the table below:</p>';
							else
								echo '<p>There are currently <mark>'.$gps_number.'</mark> groups registered for this company. Select the action you want to perform from the table below:</p>';
							echo '<div id="locations_table" class="section">
										<table class="manage">
										<thead>
											<tr>
												<th class="first">Group\'s Name</th>
												<th>Type</th>
												<th>Sub Groups</th>
												<th>locations</th>
												<th>Edit Group</th>
												<th class="last">Delete</th>
											</tr>
										</thead>
										<tbody>';
							$i = 0;
							display_table_rows($hierarchy);
							/*foreach($hierarchy as $elemnt)
							{
								if(!empty($element['children']))
								{
									$class = ($i%2) ? 'odd' : 'even';
									echo  '<tr class="'.$class.'">';
										echo '<td class="first">'.$elemnt[$i]->name.'</td>';						
										echo '<td>'.$elemnt[$i]->type.'</td>';										
										echo '<td style="text-align:left;">';
										foreach($elemnt[$i]->children as $sub_element)
											echo '<span style="display:block;">'.$loc['name'].'</span>';
										echo '</td>';	
										if(!empty($groups[$i]->subgroups))
										{
											echo '<td style="text-align:left;">';
											foreach($groups[$i]->subgroups as $sg)
												echo '<span style="display:block;">'.$sg['name'].'</span>';
											echo '</td>';
										}
										else
											echo '<td>N/A</td>';
										echo '<td><a href="'.site_url('admin_companies/edit_group/'.$groups[$i]->ID).'"><img src="'.img_url('edit.png').'" alt="Edit"></a></td>';
										echo '<td><a href="'.site_url('admin_companies/delete_group/'.$groups[$i]->ID).'"><img src="'.img_url('delete.png').'" alt="Delete"></a></td>';
									echo '</tr>';
								}
								
							}
							for($i = 0; $i < $gps_number; $i++)
							{
								$class = ($i%2) ? 'odd' : 'even';
								echo  '<tr class="'.$class.'">';
									echo '<td class="first">'.$groups[$i]->name.'</td>';						
									echo '<td>'.$groups[$i]->type.'</td>';	
									if(!empty($groups[$i]->subgroups))
									{
										echo '<td style="text-align:left;">';
										foreach($groups[$i]->subgroups as $sg)
											echo '<span style="display:block;">'.$sg['name'].'</span>';
										echo '</td>';
									}
									else
										echo '<td>N/A</td>';
									if(!empty($groups[$i]->locations))
									{
										echo '<td style="text-align:left;">';
										foreach($groups[$i]->locations as $loc)
											echo '<span style="display:block;">'.$loc['name'].'</span>';
										echo '</td>';
									}
									else
										echo '<td>N/A</td>';
									echo '<td><a href="'.site_url('admin_companies/edit_group/'.$groups[$i]->ID).'"><img src="'.img_url('edit.png').'" alt="Edit"></a></td>';
									echo '<td><a href="'.site_url('admin_companies/delete_group/'.$groups[$i]->ID).'"><img src="'.img_url('delete.png').'" alt="Delete"></a></td>';
								echo '</tr>';
							}*/
							echo '</tbody>
									</table>
								</div>';
						}
						?>
					</section>
				</div>
			


				
				</div>
			</div>
		</div>
	</div><!-- #body -->
	
<script type="text/javascript">
$(document).ready(function(){
	$('#locations_table table').dataTable({
	"sPaginationType": "full_numbers",
	"oLanguage": {"sSearch": "Groups/Locations Search : "},
	"aaSorting":[],
	"aoColumns": [ null, null, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false} ],
	"iDisplayLength": 20, 
	"aLengthMenu": [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]] 
	}); 
});
</script>