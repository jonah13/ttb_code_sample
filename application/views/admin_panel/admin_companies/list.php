
			<div id="menu-content">
				<div id="content_wrapper">
				<h1>Manage <span class="special">Companies</span> :</h1>
				<div class="box">
					<h2>Add Companies</h2>
					<section>
						<p>
							<a href="<?php echo site_url('admin_companies/add'); ?>" class="semi_btn float_right" class="btn" >Add A New Company</a>
							You can register a new Company from the following button: 
							<br class="clear_float"/>
						<p>
					</section>
				</div>
				
				<?php if(!empty($reply)) echo '<p class="reply">'.$reply.'</p>'; ?>
				<div class="box">
					<h2>List of Companies</h2>
					<section>
						<?php
						$object_number = count($objects);
						if($object_number == 0)
							echo '<p>There is no company registered to TellTheBoss.com, try registering a new company from <a href="'.site_url('admin_companies/add').'">here</a>.</p>';
						else 
						{
							if($object_number == 1)
								echo '<p>There is currently <mark>1</mark> company registered to TellTheBoss.com. Select the action you want to perform from the table below:</p>';
							else
								echo '<p>There are currently <mark>'.$object_number.'</mark> companies registered to TellTheBoss.com. Select the action you want to perform from the table below:</p>';
							echo '<div id="companies_table" class="section">
										<table class="manage">
										<thead>
											<tr>
												<th class="first">Company Name</th>
												<th>Date Added</th>
												<th>Edit Company Info</th>
												<th>Manage locations and codes</th>
												<th>Manage Groups</th>
												<th>Edit SMS and QR scripts</th>
												<th>Deactivate / activate</th>
												<th class="last">Delete</th>
											</tr>
										</thead>
										<tbody>';
							for($i = 0; $i < $object_number; $i++)
							{
								$class = ($i%2) ? 'odd' : 'even';
								if($objects[$i]->is_active == 0)
									$class .= ' stand_out';
								$is_test = '';
								if($objects[$i]->is_test == 1)
									$is_test = ' <strong>(Test company)</strong>';
								echo  '<tr class="'.$class.'">';
									echo '<td class="first">'.$objects[$i]->name.$is_test.'</td>';						
									echo '<td>'.$objects[$i]->date_added.'</td>';						
									echo '<td><a href="'.site_url('admin_companies/edit/'.$objects[$i]->ID).'"><img src="'.img_url('edit.png').'" alt="Edit"></a></td>';
									echo '<td><a href="'.site_url('admin_companies/manage_locations/'.$objects[$i]->ID).'"><img src="'.img_url('manage_locations.png').'" alt="Manage Locations"></a> ('.count($objects[$i]->locations).')</td>';
									echo '<td><a href="'.site_url('admin_companies/manage_groups/'.$objects[$i]->ID).'"><img src="'.img_url('groups.png').'" alt="Manage Groups" width="32"></a> ('.count($objects[$i]->groups).')</td>';
									echo '<td><a href="'.site_url('admin_companies/edit_sms_qr_scripts/'.$objects[$i]->ID).'"><img src="'.img_url('edit_style.png').'" alt="Edit Scripts and Style"></a></td>';
									if($objects[$i]->is_active == 1)
										echo '<td><a href="'.site_url('admin_companies/deactivate/'.$objects[$i]->ID).'" class="confirm_deactivate">deactivate</a></td>';
									else
										echo '<td><a href="'.site_url('admin_companies/activate/'.$objects[$i]->ID).'">activate</a></td>';
									echo '<td><a href="'.site_url('admin_companies/delete/'.$objects[$i]->ID).'"><img src="'.img_url('delete.png').'" alt="Delete"></a></td>';
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
	$('#companies_table table').dataTable({
	"sPaginationType": "full_numbers",
	"oLanguage": {"sSearch": "Companies Search : "},
	"aaSorting":[[0,'asc']],
	"aoColumns": [ null, null, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, null, {"bSortable": false} ],
	"iDisplayLength": 50, 
	"aLengthMenu": [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]] 
	}); 
	
	$('a.confirm_deactivate').click(function() {
			var r = confirm("Confirm Deactivating: Are you sure you want to deactivate this Company? All the codes under it won't be able to receive feedback until you activate it again!");
			if (!r)  return false;
		});
});
</script>