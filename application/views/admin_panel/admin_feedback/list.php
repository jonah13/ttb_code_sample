
			<div id="menu-content">
				<div id="content_wrapper">
				<h1>Feedback Stats :</h1>
				
				<div class="box" style="margin-bottom:8px;">
					<h2>Add Comments</h2>
					<section>
						<p>
							<a href="<?php echo site_url('admin_feedback/add'); ?>" class="semi_btn float_right" class="btn" >Add A New Comment</a>
							You can add a new Comment from the following button: 
							<br class="clear_float"/>
						<p>
					</section>
				</div>
				
				<div class="box collapsable" style="margin-bottom:8px;">
					<h2>Filters</h2>
					<section>
					<form  id="filter" name="filter" class="filter_feedback" method="get" action="<?php echo site_url('admin_feedback/index'); ?>">
						<div class="tier_box">
							<h3 style="margin-bottom:4px;">Hierarchy Filters</h3>
							<label for="filter_by">Filter By:</label>
							<select name="filter_by" id="filter_by" style="display:block;">
								<?php if(empty($cur_filter)) $cur_filter = '0'; ?>
								<option value="0" <?php echo set_select('filter_by', '0', ($cur_filter == '0')?TRUE:FALSE); ?>>Select A Filter</option>
								<option value="client" <?php echo set_select('filter_by', 'client', ($cur_filter == 'client')?TRUE:FALSE); ?>>By User Name</option>
								<option value="company" <?php echo set_select('filter_by', 'company', ($cur_filter == 'company')?TRUE:FALSE); ?>>By Company</option>
								<option value="group" <?php echo set_select('filter_by', 'group', ($cur_filter == 'group')?TRUE:FALSE); ?>>By Group</option>
								<option value="location" <?php echo set_select('filter_by', 'location', ($cur_filter == 'location')?TRUE:FALSE); ?>>By Location</option>
								<option value="code" <?php echo set_select('filter_by', 'code', ($cur_filter == 'code')?TRUE:FALSE); ?>>By Code</option>
							</select>
							<br/>
							
							<div id="filter_client" class="toggle_filter">
								<label for="client">Select User Name:</label>
								<select name="client" id="client" class="dropdowns" style="display:block;">
									<option value="0" <?php echo set_select('client', '0'); ?>>All Users</option>
									<?php
									if(!empty($cur_client)) $b = $cur_client; else $b = '';
									foreach($clients as $c)
									{
										if(strcmp($b, $c['ID']) == 0) $s = 'selected="selected"'; else $s = '';
										echo '<option value="'.$c['ID'].'" '.$s.'>'.$c['username'].' ('.$c['first_name'].' '.$c['last_name'].')</option>';
									}
									?>
								</select>
							</div>
							
							<div id="filter_company" class="toggle_filter">
								<label for="company">Select Company:</label>
								<select name="company" id="company" class="dropdowns" style="display:block;">
									<option value="0" <?php echo set_select('company', '0'); ?>>All Companies</option>
									<?php	
									if(!empty($cur_company)) $b = $cur_company; else $b = '';
									foreach($companies as $c)
									{
										if(strcmp($b, $c['ID']) == 0) $s = 'selected="selected"'; else $s = '';
										echo '<option value="'.$c['ID'].'" '.$s.'>'.$c['name'].'</option>';
									}
									?>
								</select>
							</div>
							
							<div id="filter_group" class="toggle_filter">
								<label for="group">Select Group:</label>
								<select name="group" id="group" class="dropdowns" style="display:block;">
									<option value="0" <?php echo set_select('group', '0'); ?>>All Groups</option>
									<?php	
									if(!empty($cur_group)) $b = $cur_group; else $b = '';
									$opt_groups = array();
									foreach($groups as $g)
									{
										if(empty($opt_groups[$companies[$g['company_id']]['name']]))
											$opt_groups[$companies[$g['company_id']]['name']] = '<optgroup label="'.$companies[$g['company_id']]['name'].'">';
										if(strcmp($b, $g['ID']) == 0) $s = 'selected="selected"'; else $s = '';
										$opt_groups[$companies[$g['company_id']]['name']] = $opt_groups[$companies[$g['company_id']]['name']].'<option value="'.$g['ID'].'" '.$s.'>'.$g['name'].'</option>';
									}
									ksort($opt_groups);
									foreach($opt_groups as $og)
										echo $og;
									?>
								</select>
							</div>
							
							<div id="filter_location" class="toggle_filter">
								<label for="location">Select Location:</label>
								<select name="location" id="location" class="dropdowns" style="display:block;">
									<option value="0" <?php echo set_select('location', '0'); ?>>All Locations</option>
									<?php	
									if(!empty($cur_location)) $b = $cur_location; else $b = '';
									$opt_groups = array();
									foreach($locations as $l)
									{
										if(empty($opt_groups[$companies[$l['company_id']]['name']]))
											$opt_groups[$companies[$l['company_id']]['name']] = '<optgroup label="'.$companies[$l['company_id']]['name'].'">';
										if(strcmp($b, $l['ID']) == 0) $s = 'selected="selected"'; else $s = '';
										$opt_groups[$companies[$l['company_id']]['name']] = $opt_groups[$companies[$l['company_id']]['name']].'<option value="'.$l['ID'].'" '.$s.'>'.$l['name'].'</option>';
									}
									ksort($opt_groups);
									foreach($opt_groups as $og)
										echo $og;
									?>
								</select>
							</div>
							
							<div id="filter_code" class="toggle_filter">
								<label for="code">Select Code:</label>
								<select name="code" id="code" class="dropdowns" style="display:block;">
									<option value="0" <?php echo set_select('code', '0'); ?>>All Codes</option>
									<?php	
									if(!empty($cur_code)) $b = $cur_code; else $b = '';
									$opt_groups = array();
									foreach($codes as $c)
									{
										if(empty($opt_groups[$c['location_id']]))
											$opt_groups[$c['location_id']] = '<optgroup label=" ->'.$locations[$c['location_id']]['name'].'">';
										if(strcmp($b, $c['ID']) == 0) $s = 'selected="selected"'; else $s = '';
										$opt_groups[$c['location_id']] = $opt_groups[$c['location_id']].'<option value="'.$c['ID'].'" '.$s.'>'.$c['code'].'</option>';
									}
									$comp_opt_groups = array();
									foreach($opt_groups as $loc_id => $og)
									{
										if(empty($comp_opt_groups[$companies[$locations[$loc_id]['company_id']]['name']]))
											$comp_opt_groups[$companies[$locations[$loc_id]['company_id']]['name']] = '<optgroup label="'.$companies[$locations[$loc_id]['company_id']]['name'].'">';
										$comp_opt_groups[$companies[$locations[$loc_id]['company_id']]['name']] .= $og;
									}
									ksort($comp_opt_groups);
									foreach($comp_opt_groups as $og)
										echo $og;
									?>
								</select>
							</div>
						</div>
						
						<div class="tier_box">
							<h3 style="margin-bottom:4px;">Time Filter</h3>
							<label for="period">Summary for:</label>
							<select name="period" id="period" class="date_dropdown" style="display:block; margin-bottom:15px;">
								<?php if(!empty($cur_period)) $b = $cur_period; else $b = '';?>
								<option value="0" <?php if(strcmp($b, '') == 0) echo 'selected="selected"'; ?>>All Time</option>
								<option value="today" <?php if(strcmp($b, 'today') == 0) echo 'selected="selected"'; ?>>Last 24 hours</option>
								<option value="weekly" <?php if(strcmp($b, 'weekly') == 0) echo 'selected="selected"'; ?>>Last 7 days</option>
								<option value="monthly" <?php if(strcmp($b, 'monthly') == 0) echo 'selected="selected"'; ?>>Last 30 days</option>
								<option value="yearly" <?php if(strcmp($b, 'yearly') == 0) echo 'selected="selected"'; ?>>Last 12 months</option>
								<option value="custom" <?php if(strcmp($b, 'custom') == 0) echo 'selected="selected"'; ?>>Custom</option>
							</select>
							<div id="custom_date" class="round_box" style="padding-bottom:38px;">
								<label for="from" style="display:inline-block; width:60px;">From:</label>
								<input type="text" name="from" id="from" class="date_pick" value="<?php if(empty($cur_from)) $cur_from = ''; echo set_value('from', $cur_from); ?>" style="display:inline-block; width:120px;" />
								<br/>
								<label for="to" style="display:inline-block; width:60px;">To:</label>
								<input type="text" name="to" id="to" class="date_pick" value="<?php if(empty($cur_to)) $cur_to = ''; echo set_value('to', $cur_to); ?>" style="display:inline-block; width:120px;" />
								<br/>
								<input id="btn_submit_info" name="btn_submit" class="btn float_right" type="submit" value="Submit" style="width:140px; padding:1px 0;" />
							</div>
						</div>
						
						<div class="tier_box">
							<h3 style="margin-bottom:4px;">Other Filters</h3>
							<label for="nature">Select Experience:</label>
							<select name="nature" id="nature" class="dropdowns" style="display:block;">
								<?php if(empty($cur_nature)) $cur_nature = '0'; ?>
								<option value="0" <?php echo set_select('nature', '0', ($cur_nature == '0')?TRUE:FALSE); ?>>Select An Experience</option>
								<option value="negative" <?php echo set_select('nature', 'negative', ($cur_nature == 'negative')?TRUE:FALSE); ?>>Negative</option>
								<option value="positive" <?php echo set_select('nature', 'positive', ($cur_nature == 'positive')?TRUE:FALSE); ?>>Positive</option>
								<option value="neutral" <?php echo set_select('nature', 'neutral', ($cur_nature == 'neutral')?TRUE:FALSE); ?>>Neutral</option>
<!--
								<option value="not_negative" <?php echo set_select('nature', 'not_negative', ($cur_nature == 'not_negative')?TRUE:FALSE); ?>>Not Negative</option>
								<option value="not_positive" <?php echo set_select('nature', 'not_positive', ($cur_nature == 'not_positive')?TRUE:FALSE); ?>>Not Positive</option>
								<option value="not_neutral" <?php echo set_select('nature', 'not_neutral', ($cur_nature == 'not_neutral')?TRUE:FALSE); ?>>Not Neutral</option>
-->
							</select>
							<br/>
							
							<label for="source">Select Source:</label>
							<select name="source" id="source" class="dropdowns" style="display:block;"> 
								<?php if(empty($cur_source)) $cur_source = '0'; ?>
								<option value="0" <?php echo set_select('source', '0', ($cur_source == '0')?TRUE:FALSE); ?>>Select A Source</option>
								<option value="QR" <?php echo set_select('source', 'QR', ($cur_source == 'QR')?TRUE:FALSE); ?>>QR</option>
								<option value="URL" <?php echo set_select('source', 'URL', ($cur_source == 'URL')?TRUE:FALSE); ?>>URL</option>
								<option value="SMS" <?php echo set_select('source', 'SMS', ($cur_source == 'SMS')?TRUE:FALSE); ?>>SMS</option>
								<option value="MAIL" <?php echo set_select('source', 'MAIL', ($cur_source == 'MAIL')?TRUE:FALSE); ?>>MAIL</option>
							</select>
							<br/>
							
							<label for="is_test">Test/Non Test?:</label>
							<select name="is_test" id="is_test" class="dropdowns" style="display:block;">
								<?php if(empty($cur_is_test)) $cur_is_test = '0'; ?>
								<option value="0" <?php echo set_select('is_test', '0', ($cur_is_test == '0')?TRUE:FALSE); ?>>Select</option>
								<option value="test" <?php echo set_select('is_test', 'test', ($cur_is_test == 'test')?TRUE:FALSE); ?>>Test Comments</option>
								<option value="not_test" <?php echo set_select('is_test', 'not_test', ($cur_is_test == 'not_test')?TRUE:FALSE); ?>>Non Test Comments</option>
							</select>
							<br/>
						</div>
						</form>
						<br class="clear_float" />
					</section>
				</div>
				
				<?php if(!empty($reply)) echo '<p class="reply">'.$reply.'</p>'; ?>
				<div class="box">
					<h2>List of Feedback Comments</h2>
					<section style="padding:1px 2px;">
						<?php
						if($total_comments_number == 0)
							echo '<p>There is no comments for any of the codes registered to TellTheBoss.com.</p>';
						else 
						{
							echo 
							 '<div id="comments_table" class="section">
									<table class="manage" style="">
										<thead>
											<tr>
												<th class="first time" style="width:50px;">Time</th>
												<th style="width:86px;">Company</th>
												<th style="width:80px;">Location</th>
												<th style="width:60px;">Code</th>
												<th style="">Comment</th>
												<th style="width:90px;">Experience</th>
												<th style="width:66px;">Source</th>
												<th style="width:40px;">Action</th>
												<th class="last" style="width:80px;">Verified</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td colspan="9" class="dataTables_empty">Loading data from server</td>
											</tr> 
										</tbody>
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
	
	var cur_filter = $('#filter_by').val();
	var cur_period = $('#period').val();
	var cur_nature = $('#nature').val();
	var cur_source = $('#source').val();
	var cur_is_test = $('#is_test').val();
	
	$('.collapsable section').hide();
	if(cur_filter != '0' || cur_period != '0' || cur_nature != '0' || cur_source != '0' || cur_is_test != '0')
		$('.collapsable section').show();
	if($('.collapsable section').css('display') == 'none')
		$('.collapsable h2').html('Filters &#9663;');
	else
		$('.collapsable h2').html('Filters &#9653;');
	
	$('.collapsable h2').css('cursor', 'pointer').click(function(){
		$('.collapsable section').slideToggle(function(){
			if($('.collapsable section').css('display') == 'none')
				$('.collapsable h2').html('Filters &#9663;');
			else
				$('.collapsable h2').html('Filters &#9653;');
		});
	});

	//filters
	$('.toggle_filter').hide();
	
	if(cur_filter != '0')
		$('#filter_'+cur_filter).show();
		
	$('#filter_by').change(function(){
		if($(this).val() == '0')
			$('.toggle_filter').hide();
		else
		{
			$('.toggle_filter').hide();
			$('#filter_'+$(this).val()).show();
		}
	});
	
	$('#custom_date').hide();
	if($('#period').val() == 'custom')
		$('#custom_date').show();
	$('#period').change(function(){
		if($(this).val() == 'custom')
			$('#custom_date').fadeIn();
		else
		{
			$('#filter').submit();
			$('#custom_date').fadeOut();
		}
	});
	$('.date_pick').datepick({dateFormat: 'yyyy-mm-dd'});
	
	$('.dropdowns').change(function(){
		$('#filter').submit();
	});
	
	//datatable of comments
	$('#comments_table table').dataTable({
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "<?php echo $cur_link; ?>",
		"sPaginationType": "full_numbers",
		"oLanguage": {"sSearch": "Search Comments, Companies, Locations, Codes And Source : "},
		"aaSorting":[[0,'desc']],
		"aoColumns": [ null, null, null, null, null, null, null, {"bSortable": false}, null ],
		"iDisplayLength": 50, 
		"aLengthMenu": [[20, 50, 100, 200, -1], [20, 50, 100, 200, "All"]],
		"fnServerData": function ( sSource, aoData, fnCallback ) 
		{
			$.ajax( {
					"dataType": 'json', 
					"type": "POST", 
					"url": sSource, 
					"data": aoData, 
					"success": fnCallback
			} );
    }
	}); 
	
	$('a.toggle_verified').live('click', function(){
		var link = $(this).attr('href');
		var container = $(this).parents('td');
		$.ajax({
			url: link,
			success: function(html)
			{
				if(html)
				{
					container.empty();
					container.append(html);
				}
			},error: function(jqXHR, textStatus, errorThrown)
			{
				$(this).html('Failed to contact Server. Try again!');
			}
		});
		return false;
	});
});
</script>