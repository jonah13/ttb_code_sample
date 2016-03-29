			<div id="menu-content">
				<div id="content_wrapper">
					<h1><span class="special"><?php echo $username; ?></span>'s Companies, Groups and Locations!</h1>

					<?php 
						$class = "";
						if(count($companies) > 1)
							$class = ' collapsible';
						foreach($companies as $comp)
						{
							$access = '';
							if(strcasecmp($comp['access_type'], 'Partial Access') == 0)
								$access = ': Partial Access';
							echo '<div class="box'.$class.'">';
							echo '	<h2>'.$comp['name'].$access.'</h2>';
							echo '	<section>';
							if(!empty($comp['groups']))
							{
								foreach($comp['groups'] as $grp)
								{
									if(!empty($grp['locations']))
									{
										echo '	<h3 style="margin-top:12px">'.strtoupper($grp['type'].': '.$grp['name']).'</h3>';
										echo '	<div class="round_box">';
										foreach($grp['locations'] as $loc)
										{	
											$access = '';
											if(strcasecmp($loc['access_type'], 'Partial Access') == 0)
												$access = ': Partial Access';
											echo '	<h4>'.$loc['name'].$access.'</h4>';
											echo '	<div class="round_box">';
											if(!empty($loc['address']))
												echo '		<span class="infot">Address</span>: '.$loc['address'].'<br/>';
											if(!empty($loc['city']))
												echo '		<span class="infot">City</span>: '.$loc['city'].'<br/>';
											if(!empty($loc['state']))
												echo '		<span class="infot">State</span>: '.$loc['state'].'<br/>';
											if(!empty($loc['zipcode']))
												echo '		<span class="infot">Zipcode</span>: '.$loc['zipcode'].'<br/>';
											if(!empty($loc['timezone']))
												echo '		<span class="infot">Time Zone</span>: '.$loc['timezone'].'<br/>';
											if(!empty($loc['business_type']))
												echo '		<span class="infot">Business</span>: '.$loc['business_type'].'<br/>';
											if(!empty($loc['website']))
												echo '		<span class="infot">Website</span>: '.$loc['website'].'<br/>';
											echo '<strong style="font-size:15px"><a href="'.site_url('dashboard/codes/'.$loc['ID']).'">Go to '.$loc['name'].'\'s codes ('.count($loc['codes']).')</a></strong><br/>';
											echo '	</div>';
										}
										echo '	</div>';
									}
								}
							}
							if(!empty($comp['locations']))
							{
								foreach($comp['locations'] as $loc)
								{
									$access = '';
									if(strcasecmp($loc['access_type'], 'Partial Access') == 0)
										$access = ': Partial Access';
									echo '	<h4>'.$loc['name'].$access.'</h4>';
									echo '	<div class="round_box">';
									if(!empty($loc['address']))
										echo '		<span class="infot">Address</span>: '.$loc['address'].'<br/>';
									if(!empty($loc['city']))
										echo '		<span class="infot">City</span>: '.$loc['city'].'<br/>';
									if(!empty($loc['state']))
										echo '		<span class="infot">State</span>: '.$loc['state'].'<br/>';
									if(!empty($loc['zipcode']))
										echo '		<span class="infot">Zipcode</span>: '.$loc['zipcode'].'<br/>';
									if(!empty($loc['timezone']))
										echo '		<span class="infot">Time Zone</span>: '.$loc['timezone'].'<br/>';
									if(!empty($loc['business_type']))
										echo '		<span class="infot">Business</span>: '.$loc['business_type'].'<br/>';
									if(!empty($loc['website']))
										echo '		<span class="infot">Website</span>: '.$loc['website'].'<br/>';
									echo '<strong style="font-size:15px"><a href="'.site_url('dashboard/codes/'.$loc['ID']).'">Go to '.$loc['name'].'\'s codes ('.count($loc['codes']).')</a></strong><br/>';
									echo '	</div>';
								}
							}
							echo '	</section>';
							echo '</div>';
						}
					?>
				
				</div>
			</div>
		</div>
	</div><!-- #body -->
	
<script>
$(document).ready(function(){

	$('.collapsible section').show();
	$('.collapsible h2').each(function(){
		$(this).html('<span>'+$(this).text()+'</span> &#9653;')
	});
		
		
	$('.collapsible h2').css('cursor', 'pointer').click(function(){
		$(this).next().slideToggle(function(){
			if($(this).css('display') == 'none')
				$(this).prev().html('<span>'+$(this).prev().children('span').text()+'</span> &#9663;');
			else
				$(this).prev().html('<span>'+$(this).prev().children('span').text()+'</span> &#9653;');
		});
	});
		
});
</script>