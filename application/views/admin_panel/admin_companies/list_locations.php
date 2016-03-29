
			<div id="menu-content">
				<div id="content_wrapper">
				<h1>Manage <span class="special"><?php echo $company_data['name']; ?></span>'s locations :</h1>
				<div class="box">
					<h2>Add Locations</h2>
					<section>
						<p>
							<a href="<?php echo site_url('admin_companies/add_location/'.$company_data['ID']); ?>" class="semi_btn float_right" class="btn" >Add A New Location</a>
							You can register a new Location for <strong><?php echo $company_data['name']; ?></strong> from the following button: 
							<br class="clear_float"/>
						<p>
					</section>
				</div>
				
				<?php if(!empty($reply)) echo '<p class="reply">'.$reply.'</p>'; ?>
				<div class="box">
					<h2>List of <?php echo $company_data['name']; ?>'s Locations</h2>
					<section>
						<?php
						$loc_number = count($locations);
						if($loc_number == 0)
							echo '<p>There is no location registered for this company, you can register a new location for '. $company_data['name'].' from <a href="'.site_url('admin_companies/add_location/'.$company_data['ID']).'">here</a>.</p>';
						else 
						{
							if($loc_number == 1)
								echo '<p>There is currently <mark>1</mark> location registered for this company. Select the action you want to perform from the table below:</p>';
							else
								echo '<p>There are currently <mark>'.$loc_number.'</mark> locations registered for this company. Select the action you want to perform from the table below:</p>';
							echo '<div id="locations_table" class="section">
										<table class="manage">
										<thead>
											<tr>
												<th class="first">Location\'s Name</th>
												<th>codes\'s number</th>
												<th>codes</th>
												<th>Edit location</th>
												<th>Deactivate/activate</th>
												<th class="last">Delete</th>
											</tr>
										</thead>
										<tbody>';
							for($i = 0; $i < $loc_number; $i++)
							{
								$codes_number = count($locations[$i]->codes);
								$class = ($i%2) ? 'odd' : 'even';
								if($locations[$i]->is_active == 0)
									$class .= ' stand_out';
								echo  '<tr class="'.$class.'">';
									echo '<td class="first">'.$locations[$i]->name.'</td>';					
									echo '<td>'.$codes_number.'</td>';					
									echo '<td style="text-align:left;">';
									foreach($locations[$i]->codes as $code)
										echo '<span style="display:inline-block; min-width:100px;"><a href="'.site_url('feedback/receive/'.$code->code).'">'.$code->code.'</a></span>';
									echo '</td>';					
									echo '<td><a href="'.site_url('admin_companies/edit_location/'.$locations[$i]->ID).'"><img src="'.img_url('edit.png').'" alt="Edit"></a></td>';
									if($locations[$i]->is_active == 1)
										echo '<td><a href="'.site_url('admin_companies/deactivate_location/'.$locations[$i]->ID).'" class="confirm_deactivate">deactivate</a></td>';
									else
										echo '<td><a href="'.site_url('admin_companies/activate_location/'.$locations[$i]->ID).'">activate</a></td>';
									echo '<td><a href="'.site_url('admin_companies/delete_location/'.$locations[$i]->ID).'"><img src="'.img_url('delete.png').'" alt="Delete"></a></td>';
								echo '</tr>';
							}
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
	"oLanguage": {"sSearch": "Locations/Codes Search : "},
	"aaSorting":[[0,'asc']],
	"aoColumns": [ null, null, {"bSortable": false}, {"bSortable": false}, null, {"bSortable": false} ],
	"iDisplayLength": 20, 
	"aLengthMenu": [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]] 
	}); 
	
	$('a.confirm_deactivate').click(function() {
		var r = confirm("Confirm Deactivating: Are you sure you want to deactivate this Location? All the codes under it won't be able to receive feedback!");
		if (!r)  return false;
	});
});
</script>