
			<div id="menu-content">
				<div id="content_wrapper">
				<h1>Feedback Stats :</h1>
				<?php if(!empty($reply)) echo '<p class="reply">'.$reply.'</p>'; ?>
				<div class="box">
					<h2>List of Feedback Comments</h2>
					<section>
						<?php
						if($total_comments_number == 0)
							echo '<p>There is no comments for any of the codes registered to TellTheBoss.com.</p>';
						else 
						{
							$comments_number = count($comments);
							echo '<div id="comments_table" class="section">
										<table class="manage">
										<thead>
											<tr>
												<th class="first">Time</th>
												<th>Company</th>
												<th>Location</th>
												<th>Code</th>
												<th>Comment</th>
												<th>Nature</th>
												<th>Source</th>
												<th>Action</th>
												<th class="last">New/Seen</th>
											</tr>
										</thead>
										<tbody>';
							for($i = 0; $i < $comments_number; $i++)
							{
								$class = ($i%2) ? 'odd' : 'even';
								
								$is_test = '';
								if($comments[$i]->is_test == 1)
									$is_test = '<strong>(Test Comment)</strong> ';
									
								$code_desc = '';
								if(!empty($comments[$i]->code_desc))
									$code_desc = '<br/>('.$comments[$i]->code_desc.')';
									
								
								echo  '<tr class="'.$class.'">';
									echo '<td class="first">'.$comments[$i]->comment_time.'</td>';						
									echo '<td>'.$comments[$i]->company_name.'</td>';						
									echo '<td>'.$comments[$i]->location_name.'</td>';
									echo '<td>'.$comments[$i]->code.$code_desc.'</td>';
									echo '<td>';
									{
										echo $is_test;
										echo htmlentities($comments[$i]->comment); 
										$extra_data = "";
										if(!empty($comments[$i]->extra_data) || !empty($comments[$i]->sec_extra_data))
										{
											if(!empty($comments[$i]->cf_name) && !empty($comments[$i]->extra_data))
												$extra_data = '<strong>'.$comments[$i]->cf_name.':</strong> '.$comments[$i]->extra_data;
											
											if(!empty($comments[$i]->sec_extra_data))
											{
												if(!empty($comments[$i]->cf2_name))
												{
													if(empty($extra_data))
														$extra_data = '<strong>'.$comments[$i]->cf2_name.':</strong> '.$comments[$i]->sec_extra_data;
													else
														$extra_data = $extra_data.'<br/><strong>'.$comments[$i]->cf2_name.':</strong> '.$comments[$i]->sec_extra_data;
												}
												elseif($comments[$i]->cf_name)
												{
													if(empty($extra_data))
														$extra_data = '<strong>'.$comments[$i]->cf_name.':</strong> '.$comments[$i]->sec_extra_data;
													else
														$extra_data = $extra_data.'<br/><strong>'.$comments[$i]->cf_name.':</strong> '.$comments[$i]->sec_extra_data;
												}
											}
											if(!empty($extra_data))
												echo '<div class="custom_field">'.$extra_data.'</div>';
										}
									}
									echo '</td>';
									echo '<td><span class="hidden">'.$comments[$i]->nature.'</span><img src="'.img_url($comments[$i]->nature.'.png').'" alt="'.$comments[$i]->nature.'" width="51"></td>';
									echo '<td>';
										echo strtoupper($comments[$i]->origin);
										if(!empty($comments[$i]->indirect_origin))
											echo '<br/>('.strtolower($comments[$i]->indirect_origin).')';
									echo '</td>';
									echo '<td><a href="'.site_url('admin_feedback/edit_comment/'.$comments[$i]->ID).'"><img src="'.img_url('edit_comment.png').'" alt="Edit" title="Edit"></a><br/>
														<a href="'.site_url('admin_feedback/delete_comment/'.$comments[$i]->ID).'"><img src="'.img_url('delete_comment.png').'" alt="Delete" title="Delete"></a><br/>
														<a href="'.site_url('admin_feedback/comment_info/'.$comments[$i]->ID).'"><img src="'.img_url('info.png').'" alt="Info" title="Info"></a></td>';
									echo '<td>';
										if($comments[$i]->seen)
										{
											echo 'Seen ';
											if(!empty($comments[$i]->seen_by))
												echo 'by <strong>'.$comments[$i]->seen_by.'</strong>';
											echo '<br/><a href="'.site_url('admin_feedback/mark_as_new/'.$comments[$i]->ID).'">Mark as New</a>';
										}
										else
											echo 'New<br/><input type="checkbox" name="to_mark_seen[]" class="checkbox" /> Mark as seen';
									echo '</td>';
								echo '</tr>';
							}
							echo '</tbody>
									</table>
								</div>';
						}
						?>
					</section>
				</div>
				<div class="box">
					<h2>Add Companies</h2>
					<section>
						<p>
							<a href="<?php echo site_url('admin_companies/add'); ?>" class="semi_btn float_right" class="btn" >Add A New Company</a>
							You can registre a new Company from the following button: 
							<br class="clear_float"/>
						<p>
					</section>
				</div>
			


				
				</div>
			</div>
		</div>
	</div><!-- #body -->
	
<script type="text/javascript">
$(document).ready(function(){
	$('#comments_table table').dataTable({
	"sPaginationType": "full_numbers",
	"oLanguage": {"sSearch": "Comments Search : "},
	"aaSorting":[[0,'desc']],
	"aoColumns": [ null, null, null, null, null, null, null, {"bSortable": false}, null} ],
	"iDisplayLength": <?php echo $comments_per_page; ?>, 
	"aLengthMenu": [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]] 
	}); 
});
</script>