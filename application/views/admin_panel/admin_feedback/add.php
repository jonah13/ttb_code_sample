	
	<div id="menu-content">
	<div id="content_wrapper">
		<h1>Add a new <span class="special">Comment</span> :</h1>
		<?php if(!empty($reply)) echo '<p class="reply">'.$reply.'</p>'; ?>
		<div class="box">
			<h2>Adding a new comment</h2>
			<section>
			<p>Fill in the comment information and press submit.</p><br />
			<form class="standard" method="post" action="<?php echo site_url('admin_feedback/submit_add'); ?>" >
			<p>
				<label style="vertical-align:top;" for="comment">Comment:</label> 
				<textarea name="comment" id="comment" rows="8"><?php echo set_value('comment'); ?></textarea>
				<?php echo form_error('comment'); ?>
				<br />
				<label for="overall_exp">Overall experience:</label> 
				<select name="overall_exp" id="overall_exp">
					<option value="5=Excellent" <?php echo set_select('overall_exp', '5=Excellent'); ?>>5=Excellent</option>
					<option value="4=Good" <?php echo set_select('overall_exp', '4=Good'); ?>>4=Good</option>
					<option value="3=Average" <?php echo set_select('overall_exp', '3=Average'); ?>>3=Average</option>
					<option value="2=Fair" <?php echo set_select('overall_exp', '2=Fair'); ?>>2=Fair</option>
					<option value="1=Poor" <?php echo set_select('overall_exp', '1=Poor'); ?>>1=Poor</option>
					<option value="" <?php echo set_select('overall_exp', ''); ?>>No Overall Experience</option>
				</select>
				<?php echo form_error('overall_exp'); ?>
				<br />
				<label for="code">Code:</label>
				<select name="code" id="code">
					<option value="" <?php echo set_select('code', ''); ?>>--Please Select--</option>
					<?php
					foreach($codes as $code)
					{
						echo '<option value="'.$code.'" '.set_select('code', $code).'>'.$code.'</option>';
					}
					?>
				</select>
				<?php echo form_error('code'); ?>
				<br />
				<label for="date">Date:</label> 
				<input type="text" name="date" id="date" value="<?php echo set_value('date'); ?>"/> MM/DD/YY
				<?php echo form_error('date'); ?>
				<br />
				<label for="time">Time:</label> 
				<select name="time" id="time">
					<option value="NO_TIME" <?php echo set_select('time', 'NO_TIME'); ?>>No Time</option>
					<option value="AM" <?php echo set_select('time', 'AM'); ?>>AM</option>
					<option value="PM" <?php echo set_select('time', 'PM'); ?>>PM</option>
					<option value="SPECIFIC" <?php echo set_select('time', 'SPECIFIC'); ?>>Specific</option>
				</select>
				<?php echo form_error('time'); ?>
				<br />
				<div id="spec_time">
					<label for="s_time">Specific Time:</label> 
					<input type="text" name="s_time" id="s_time" value="<?php echo set_value('s_time'); ?>"/> HH:MM AM/PM
					<?php echo form_error('s_time'); ?>
					<br />
				</div>
				<label for="nature">Nature:</label>
				<select name="nature" id="nature">
					<?php $def = false; ?>
					<option value="positive" <?php echo set_select('nature', 'positive', $def); ?>>Positive</option>
					<option value="neutral" <?php echo set_select('nature', 'neutral', $def); ?>>Neutral</option>
					<option value="negative" <?php echo set_select('nature', 'negative', $def); ?>>Negative</option>
				</select>
				<?php echo form_error('nature'); ?>
				<br />
				<label for="source">Source:</label>
				<select name="source" id="source">
					<option value="MAIL" <?php echo set_select('source', 'MAIL'); ?>>Mail</option>
					<option value="URL" <?php echo set_select('source', 'URL'); ?>>URL</option>
					<option value="QR" <?php echo set_select('source', 'QR'); ?>>QR</option>
					<option value="SMS" <?php echo set_select('source', 'SMS'); ?>>SMS</option>
				</select>
				<br />
				<label for="is_postcard">IS Postcard?:</label>
				<input type="checkbox" name="is_postcard" id="is_postcard" style="width:auto; margin-left:6px;" value="yes" <?php echo set_checkbox('is_postcard', 'yes', true); ?>/>  
				<br/>
				<label for="extra_data">Extra Data:</label> 
				<input type="text" name="extra_data" id="extra_data" value="<?php echo set_value('extra_data'); ?>"/>
				<?php echo form_error('extra_data'); ?>
				<br />
				<label for="sec_extra_data">Second Extra Data:</label> 
				<input type="text" name="sec_extra_data" id="sec_extra_data" value="<?php echo set_value('sec_extra_data'); ?>"/>
				<?php echo form_error('sec_extra_data'); ?>
				<br />
				<br />
				<input name="btn_submit" class="btn_submit" type="submit" value="Submit and Go back to Feedback Stats" style="padding-left:20px; padding-right:20px; display:inline;" />Or<input name="btn_submit" class="btn_submit" type="submit" value="Submit and Add a New Comment"  style="padding-left:20px; padding-right:20px; display:inline; margin-left:10px;" />
			</p>
			<p>N.B.: Extra Data (Second Extra Data) will only appear with the comment in the comments table if the company that the code belongs to has extra data (sec extra data)s set.</p>
			</form>
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
		$('#spec_time').hide();
		
		$("select#time").change(function() {
			if($("select#time option:selected").val() == 'SPECIFIC')
				$('#spec_time').slideDown();
			else
				$('#spec_time').slideUp();
		}).trigger('change');
	});
</script>