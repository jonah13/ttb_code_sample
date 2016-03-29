
			<div id="menu-content">
				<div id="content_wrapper">
				<h1>Manage <span class="special">Clients</span> &amp; <span class="special">Admins</span> :</h1>
				<div class="box">
					<h2>Add Users</h2>
					<section>
						<p>
							<a href="<?php echo site_url('admin_users/add'); ?>"  class="semi_btn float_right" >Add A New User</a>
							You can register a new Client or Admin from the following button:
							<br class="clear_float"/>
						<p>
					</ection>
				</div>
				
				<?php if(!empty($reply)) echo '<p class="reply">'.$reply.'</p>'; ?>
				
				<div class="box">
					<h2>List of Clients</h2>
					<section>
						<?php
						$clients_number = count($clients);
						if($clients_number == 0)
							echo '<p>There is no client registered to TellTheBoss.com, try registering a new client from <a href="'.site_url('admin_users/add').'">here</a>.</p>';
						else 
						{
							if($clients_number == 1)
								echo '<p>There is currently <strong>1</strong> <em>CLIENT</em> registered to TellTheBoss.com. Select the action you want to perform from the table below:</p>';
							else
								echo '<p>There are currently <strong>'.$clients_number.'</strong> <em>CLIENTS</em> registered to TellTheBoss.com. Select the action you want to perform from the table below:</p>';
							echo '<div class="section" id="users_table">
										<table class="manage">
										<thead>
											<tr>
												<th class="first">Full Name - Username - Email</th>
												<th>Date Added</th>
												<th>Edit</th>
												<th>Assign companies / locations</th>
												<th>Manage notifications</th>
												<th>Deactivate / Activate</th>
												<th class="last">Delete</th>
											</tr>
										</thead>
										<tbody>';
							for($i = 0; $i < $clients_number; $i++)
							{
								$class = ($i%2) ? 'odd' : 'even';
								if($clients[$i]->is_active == 0)
									$class .= ' stand_out';
								echo  '<tr class="'.$class.'">';
									echo '<td class="first">'.$clients[$i]->first_name.' '.$clients[$i]->last_name.' - '.$clients[$i]->username.' - '.$clients[$i]->email.'</td>';
									echo '<td>'.$clients[$i]->signup_date.'</td>';
									echo '<td><a href="'.site_url('admin_users/edit/'.$clients[$i]->ID).'"><img src="'.img_url('edit.png').'" alt="Edit"></a></td>';
									echo '<td><a href="'.site_url('admin_users/assign_rights/'.$clients[$i]->ID).'"><img src="'.img_url('assign_rights.png').'" alt="Assign companies and locations"></a></td>';
									echo '<td><a href="'.site_url('admin_users/manage_notifications/'.$clients[$i]->ID).'"><img src="'.img_url('manage_notifications.png').'" alt="Notifications options"></a></td>';
									if($clients[$i]->is_active == 1)
										echo '<td><a href="'.site_url('admin_users/deactivate/'.$clients[$i]->ID).'" class="confirm_deactivate">deactivate</a></td>';
									else
										echo '<td><a href="'.site_url('admin_users/activate/'.$clients[$i]->ID).'">activate</a></td>';
									echo '<td><a href="'.site_url('admin_users/delete/'.$clients[$i]->ID).'"><img src="'.img_url('delete.png').'" alt="Delete"></a></td>';
									echo '</tr>';
							}
							echo '</tbody>
										</div>
									</table>';
						}
						?>
					</section>
				</div>
				<div class="box">
					<h2>List of Admins</h2>
					<section>
						<?php 
						$admins_number = count($admins);
						if($admins_number == 0)
							echo '<p>There is no other admin registered to TellTheBoss.com, try registering a new admin from <a href="'.site_url('admin_users/add').'">here</a>.</p>';
						else 
						{
							if($admins_number == 1)
								echo '<p>In addition to you, there is currently <strong>1</strong> other <em>ADMIN</em> registered to TellTheBoss.com. Select the action you want to perform from the table below:</p>';
							else
								echo '<p>In addition to you, There are currently <strong>'.$admins_number.'</strong> other <em>ADMINS</em> registered to TellTheBoss.com. Select the action you want to perform from the table below:</p>';
							echo '<div class="section" id="admins_table">
										<table class="manage">
										<thead>
											<tr>
												<th class="first">Full Name - Username - Email</th>
												<th>Date Added</th>
												<th>Edit</th>
												<th>Deactivate/activate</th>
												<th class="last">Delete</th>
											</tr>
										</thead>
										<tbody>';
							for($i = 0; $i < $admins_number; $i++)
							{
								$class = ($i%2) ? 'odd' : 'even';
								if($admins[$i]->is_active == 0)
									$class .= ' stand_out';
								echo  '<tr class="'.$class.'">';
									echo '<td class="first">'.$admins[$i]->first_name.' '.$admins[$i]->last_name.' - '.$admins[$i]->username.' - '.$admins[$i]->email.'</td>';
									echo '<td>'.$admins[$i]->signup_date.'</td>';
									echo '<td><a href="'.site_url('admin_users/edit/'.$admins[$i]->ID).'"><img src="'.img_url('edit.png').'" alt="Edit"></a></td>';
									if($admins[$i]->is_active == 1)
										echo '<td><a href="'.site_url('admin_users/deactivate/'.$admins[$i]->ID).'" class="confirm_deactivate">deactivate</a></td>';
									else
										echo '<td><a href="'.site_url('admin_users/activate/'.$admins[$i]->ID).'">activate</a></td>';
									echo '<td><a href="'.site_url('admin_users/delete/'.$admins[$i]->ID).'"><img src="'.img_url('delete.png').'" alt="Delete"></a></td>';
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
	$('#users_table table').dataTable({
	"sPaginationType": "full_numbers",
	"oLanguage": {"sSearch": "Users Search : "},
	"aaSorting":[[0,'asc']],
	"aoColumns": [ null, null, {"bSortable": false}, {"bSortable": false}, {"bSortable": false}, null, {"bSortable": false} ],
	"iDisplayLength": 50, 
	"aLengthMenu": [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]] 
	}); 
	
	$('#admins_table table').dataTable({
	"sPaginationType": "full_numbers",
	"oLanguage": {"sSearch": "Users Search : "},
	"aaSorting":[[0,'asc']],
	"aoColumns": [ null, null, {"bSortable": false}, null, {"bSortable": false} ],
	"iDisplayLength": 50, 
	"aLengthMenu": [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]] 
	}); 
	
	$('a.confirm_deactivate').click(function() {
			var r = confirm("Confirm Deactivating: Are you sure you want to deactivate this User? They won't be able to log in again until you activate them!");
			if (!r)  return false;
		});
});
</script>
