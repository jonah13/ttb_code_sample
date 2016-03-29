
<div id="menu-content">
	<div id="content_wrapper">
		<h1>Edit <span class="special">comment</span> :</h1>
		<?php if(!empty($reply)) echo '<p class="reply">'.$reply.'</p>'; ?>
		<div class="box">
			<h2>Editing Comment</h2>
			<section>
				<p>Make the changes you want, and click submit.</p><br />
				<p>P.S.: Fields marked with <span class="required">*</span> are required. To delete a field, just empty it before clicking submit.</p><br />
				<form class="standard" method="post" action="<?php echo site_url('admin_feedback/submit_edit/'.$comment_data['ID']); ?>" >
				<p>
						<label style="vertical-align:top;" for="comment">Comment:</label> 
						<textarea name="comment" id="comment" rows="8"><?php echo set_value('comment', $comment_data['comment']); ?></textarea>
						<?php echo form_error('comment'); ?>
						<br />
						<label for="code">Code:</label>
						<select name="code" id="code">
							<option value="" <?php echo set_select('code', ''); ?>>--Please Select--</option>
							<?php
							foreach($codes as $code)
							{
								$selected = "";
								if(strcasecmp($code, $comment_data['code']) == 0) $selected = 'selected="selected"';
								echo '<option value="'.$code.'" '.$selected.'>'.$code.'</option>';
							}
							?>
						</select>
						<?php echo form_error('code'); ?>
						<br />
						<label for="time">Date and Time:</label> 
						<input type="text" name="time" id="time" value="<?php echo set_value('time', $comment_data['comment_time']); ?>"/> (keep format)
						<?php echo form_error('time'); ?>
						<br />
						<label for="time_type">How Time is Displayerd:</label> 
						<select name="time_type" id="time_type">
							<option value="NO_TIME" <?php echo set_select('time_type', 'NO_TIME', (strcasecmp('NO_TIME', $comment_data['time_type']) == 0)?true:false); ?>>No Time displayed, only date</option>
							<option value="AM" <?php echo set_select('time_type', 'AM', (strcasecmp('AM', $comment_data['time_type']) == 0)?true:false); ?>>Date and AM, no time</option>
							<option value="PM" <?php echo set_select('time_type', 'PM', (strcasecmp('PM', $comment_data['time_type']) == 0)?true:false); ?>>Date and PM, no time</option>
							<option value="SPECIFIC" <?php echo set_select('time_type', 'SPECIFIC', (strcasecmp('SPECIFIC', $comment_data['time_type']) == 0)?true:false); ?>>Specific - Date and time</option>
						</select>
						<?php echo form_error('time_type'); ?>
						<br />
						<label for="nature">Nature:</label>
						<select name="nature" id="nature">
							<?php $def = false; ?>
							<option value="positive" <?php echo set_select('nature', 'positive', (strcasecmp('positive', $comment_data['nature']) == 0)?true:false); ?>>Positive</option>
							<option value="neutral" <?php echo set_select('nature', 'neutral', (strcasecmp('neutral', $comment_data['nature']) == 0)?true:false); ?>>Neutral</option>
							<option value="negative" <?php echo set_select('nature', 'negative', (strcasecmp('negative', $comment_data['nature']) == 0)?true:false); ?>>Negative</option>
						</select>
						<?php echo form_error('nature'); ?>
						<br />
						<label for="source">Source:</label>
						<select name="source" id="source">
							<option value="MAIL" <?php echo set_select('source', 'MAIL', (strcasecmp('MAIL', $comment_data['origin']) == 0)?true:false); ?>>Mail</option>
							<option value="URL" <?php echo set_select('source', 'URL', (strcasecmp('URL', $comment_data['origin']) == 0)?true:false); ?>>URL</option>
							<option value="QR" <?php echo set_select('source', 'QR', (strcasecmp('QR', $comment_data['origin']) == 0)?true:false); ?>>QR</option>
							<option value="SMS" <?php echo set_select('source', 'SMS', (strcasecmp('SMS', $comment_data['origin']) == 0)?true:false); ?>>SMS</option>
						</select>
						<br />
						<label for="is_postcard">IS Postcard?:</label>
						<input type="checkbox" name="is_postcard" id="is_postcard" style="width:auto; margin-left:6px;" value="yes" <?php if(strcasecmp('postcards', $comment_data['indirect_origin']) == 0) echo 'checked="checked"' ; ?>/>  
						<br/>
						<label for="extra_data">Extra Data:</label> 
						<input type="text" name="extra_data" id="extra_data" value="<?php echo set_value('extra_data', $comment_data['extra_data']); ?>"/>
						<?php echo form_error('extra_data'); ?>
						<br />
					<label for="sec_extra_data">Second Extra Data:</label> 
					<input type="text" name="sec_extra_data" id="sec_extra_data" value="<?php echo set_value('sec_extra_data', $comment_data['sec_extra_data']); ?>"/>
					<?php echo form_error('sec_extra_data'); ?>
					<br />
					<br />
					<input name="btn_submit" class="btn_submit" type="submit" value="Submit changes" />
					</p>
					<p>N.B.: Extra Data (Second Extra Data) will only appear with the comment in the comments table if the company that the code belongs to has extra data (sec extra data)s set.</p>
				</form>
			</section>
		</div>
		
		<div class="box">
			<h2>Comment's Extra Information</h2>
			<section>
				<p>
					<span class="infot">Comment's nautre  :</span> <?php echo $comment_data['nature']; ?> <br/>
					<span class="infot">Analyzer nature :</span> <?php echo $comment_data['analyzer_nature']; ?> <br/>
					<span class="infot">Comment's Origin :</span> 
					<?php 
						echo $comment_data['origin']; 
						if(strcasecmp($comment_data['origin'], 'MAIL') == 0 || !empty($comment_data['admin_id']))
						{
							if(!empty($comment_data['admin']))
								echo '<br/>Comment was added by the Admin '.$comment_data['admin'].' on '.$comment_data['time'].'.<br/>';
							else
								echo 'Comment was added by an Admin on '.$comment_data['time'].'.<br/>';
							if(!empty($comment_data['admin_comments_number']))
								echo 'This Admin has added a total of '.$comment_data['admin_comments_number'].' Feedback Comments.<br/>';
						
						}
						elseif(strcasecmp($comment_data['origin'], 'SMS') == 0)
						{
							if(empty($comment_data['phone_number']))
								echo 'No phone number is listed with this comment <br/>';
							else
							{
								echo 'Comment was sent from '.$comment_data['phone_number'].' on '.$comment_data['time'].'.<br/>';
								if($comment_data['total_comments_number'] == 1)
								{
									echo 'This phone number has only sent this feedback comment to Tell The Boss.';
								}
								else
								{
									echo 'This phone number has sent a total of '.$comment_data['total_comments_number'].' feedback comments';
									if($comment_data['total_codes_number'] == 1)
										echo ' All towards '.$comment_data['code'].'. <br/>';
									else
										echo ' Towards '.$comment_data['total_codes_number'].' different codes that belong to '.$comment_data['total_locations_number'].' location(s) and '.$comment_data['total_companies_number'].' company(companies).<br/>';
										
									if(!empty($comment_data['last_day_comments_number']))
										echo 'Last 24 Hours : '.$comment_data['last_day_comments_number'].' feedback comment(s) for '.$comment_data['last_day_codes_number'].' different code(s), '.$comment_data['last_day_locations_number'].' different location(s) and '.$comment_data['last_day_companies_number'].' different company(ies).<br/>';
									if(!empty($comment_data['last_week_comments_number']))
										echo 'Last 7 Days : '.$comment_data['last_week_comments_number'].' feedback comment(s) for '.$comment_data['last_week_codes_number'].' different code(s), '.$comment_data['last_week_locations_number'].' different location(s) and '.$comment_data['last_week_companies_number'].' different company(ies).<br/>';
									if(!empty($comment_data['last_month_comments_number']))
										echo 'Last 30 Days : '.$comment_data['last_month_comments_number'].' feedback comment(s) for '.$comment_data['last_month_codes_number'].' different code(s), '.$comment_data['last_month_locations_number'].' different location(s) and '.$comment_data['last_month_companies_number'].' different company(ies).<br/>';
									if(!empty($comment_data['last_year_comments_number']))
										echo 'Last 12 months : '.$comment_data['last_year_comments_number'].' feedback comment(s) for '.$comment_data['last_year_codes_number'].' different code(s), '.$comment_data['last_year_locations_number'].' different location(s) and '.$comment_data['last_year_companies_number'].' different company(ies).<br/>';
								}
							}
						}
						elseif(strcasecmp($comment_data['origin'], 'QR') == 0 || strcasecmp($comment_data['origin'], 'URL') == 0)
						{
							if(!empty($comment_data['cookie_id']))
								echo '<br/><span class="infot">Cookie ID :</span> '.$comment_data['cookie_id'];
							if(!empty($comment_data['session_id']))
								echo '<br/><span class="infot">Session ID :</span> '.$comment_data['session_id'];
							if(!empty($comment_data['user_agent']))
								echo '<br/><span class="infot">User Agent :</span> '.$comment_data['user_agent'];
							if(!empty($comment_data['ip_address']))
								echo '<br/><span class="infot">IP Address :</span> '.$comment_data['ip_address'];
							if(!empty($comment_data['geo_location']))
								echo '<br/><span class="infot">Comment was sent from :</span> '.$comment_data['geo_location'];
								
							if(empty($comment_data[$comment_data['indic']]))
								echo '<br/>No device identification information is listed with this comment <br/>';
							else
							{
								echo '<br/>Comment was sent from a device that is identified with '.$comment_data['indic'].', on '.$comment_data['time'].'.<br/>';
								if($comment_data['total_comments_number'] == 1)
								{
									echo 'Basing on the identification information, This device (phone/computer/tablet/...) has only sent this feedback comment to Tell The Boss.';
								}
								else
								{
									echo 'Basing on the identification information, This device (phone/computer/tablet/...) has sent a total of '.$comment_data['total_comments_number'].' feedback comments';
									if($comment_data['total_codes_number'] == 1)
										echo ' All towards '.$comment_data['code'].'. <br/>';
									else
										echo ' Towards '.$comment_data['total_codes_number'].' different codes that belong to '.$comment_data['total_locations_number'].' location(s) and '.$comment_data['total_companies_number'].' company(companies).<br/>';
										
									if(!empty($comment_data['last_day_comments_number']))
										echo '<span class="infot">Last 24 Hours :</span> '.$comment_data['last_day_comments_number'].' feedback comment(s) for '.$comment_data['last_day_codes_number'].' different code(s), '.$comment_data['last_day_locations_number'].' different location(s) and '.$comment_data['last_day_companies_number'].' different company(ies).<br/>';
									if(!empty($comment_data['last_week_comments_number']))
										echo '<span class="infot">Last 7 Days :</span> '.$comment_data['last_week_comments_number'].' feedback comment(s) for '.$comment_data['last_week_codes_number'].' different code(s), '.$comment_data['last_week_locations_number'].' different location(s) and '.$comment_data['last_week_companies_number'].' different company(ies).<br/>';
									if(!empty($comment_data['last_month_comments_number']))
										echo '<span class="infot">Last 30 Days :</span> '.$comment_data['last_month_comments_number'].' feedback comment(s) for '.$comment_data['last_month_codes_number'].' different code(s), '.$comment_data['last_month_locations_number'].' different location(s) and '.$comment_data['last_month_companies_number'].' different company(ies).<br/>';
									if(!empty($comment_data['last_year_comments_number']))
										echo '<span class="infot">Last 12 months :</span> '.$comment_data['last_year_comments_number'].' feedback comment(s) for '.$comment_data['last_year_codes_number'].' different code(s), '.$comment_data['last_year_locations_number'].' different location(s) and '.$comment_data['last_year_companies_number'].' different company(ies).<br/>';
								}
							}
						}
					?>
				
				</p>
			</section>
		</div>
		
		<div class="box">
			<h2>Deleting Comment</h2>
			<section>
				<p>You're about to delete this comment.</p>
				<p><strong style="color:red;">Please note that this action is irreversible!</strong></p><br />
					<p><a href="<?php echo site_url('admin_feedback/submit_delete/'.$comment_data['ID']); ?>" class="confirm">- Continue to deleting this comment!</p>
					<p><a href="<?php echo site_url('admin_feedback'); ?>">- I don't want to delete this comment, go back to "Feedback Stats" page.</p>
			</section>
		</div>
		
	</div>
	</div>
	<p class="content_end">&nbsp;</p>
	


				
				</div>
			</div>
		</div>
	</div><!-- #body -->
	
<script>
	$(document).ready(function()
	{
		//general confirm box when deleting
		$('a.confirm').click(function() {
			var r = confirm("Confirm deleting: Are you sure you want to delete this comment?");
			if (!r)  return false;
		});
	});
	</script>