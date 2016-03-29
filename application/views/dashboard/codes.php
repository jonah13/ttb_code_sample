	<div id="menu-content">
				<div id="content_wrapper">
				<h1><span class="special"><?php echo $location['name']; ?></span>'s codes:</h1>
				
				<?php if(!empty($reply)) echo '<p class="reply">'.$reply.'</p>'; ?>
				<div class="box">
					<h2>List of <?php echo $location['name']; ?>'s codes</h2>
					<section style="padding:1px 2px;">
						<?php
						if($total_codes_number == 0)
							echo '<br/><p style="padding:10px;">There is no codes for this location that you have access to. Contact a TellTheBoss.com Admin for support.</p><br/>';
						else 
						{
							echo 
							'<p style="padding:5px 10px 1px;">You have '.$total_codes_number.' codes listed under this location.</p>
							 <div id="codes_table" class="section">
									<table class="manage" style="">
										<thead>
											<tr>
												<th class="first">Code</th>
									    	<th>QR code</th>
												<th style="width:50%;">URL</th>
												<th class="last">Code Description</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td colspan="4" class="dataTables_empty">Loading data from server</td>
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
	
	//datatable of codes
	$('#codes_table table').dataTable({
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "<?php echo $cur_link; ?>",
		"sPaginationType": "full_numbers",
		"oLanguage": {"sSearch": "Search Codes : "},
		"aaSorting":[[0,'desc']],
		"aoColumns": [ null, {"bSortable": false}, null, null ],
		"iDisplayLength": 5, 
		"aLengthMenu": [[5, 10, 20, 50, -1], [5, 10, 20, 50, "All"]],
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
	
	//colorbox
	$('.colorbox').live('click', function() {
		var title =  $(this).attr('rel');
		$.colorbox({href:$(this).attr('href'), open:true, opacity:0.7, width:400, title: function(){
			return title;}
		});
		return false;
	});
	
});
</script>