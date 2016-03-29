<?php $user_data = $this->pages_data_model->get_user_data();?>
<div id="main" class="dashboard">
	<div id="menu-content">
		<h1>Customer Feedback</h1>
	<?php 
	if((!isset($comments_number)) || $comments_number == 0)
	{
		echo '<p>None of your stores has feedback from customers, inform your customers of the different ways they can use to leave comments on your stores.</p>';
	}
	else
	{
	?>
		
		<section class="summary">
			<form class="filer_feedback" method="post" action="<?php echo site_url('dashboard/feedback_stats'); ?>">
			<p>
				<label>Summary for:</label>
				<select name="period" id="period">
						<?php if(isset($period)) $b = $period; else $b = '';?>
						<option value="0" <?php if(strcmp($b, '') == 0) echo 'selected="selected"'; ?>>All Time</option>
						<option value="today" <?php if(strcmp($b, 'Last 24 Hours') == 0) echo 'selected="selected"'; ?>>Last 24 hours</option>
						<option value="weekly" <?php if(strcmp($b, 'Last 7 days') == 0) echo 'selected="selected"'; ?>>Last 7 days</option>
						<option value="monthly" <?php if(strcmp($b, 'Last 30 days') == 0) echo 'selected="selected"'; ?>>Last 30 days</option>
						<option value="yearly" <?php if(strcmp($b, 'Last 12 months') == 0) echo 'selected="selected"'; ?>>Last 12 months</option>
				</select>
				<br />
				<label>Select Store:</label>
				<select name="store" id="store">
					<option value="0" <?php echo set_select('store', '0'); ?>>All Stores</option>
					<?php
					if(isset($store)) $b = $store; else $b = '';
					for($i = 0; $i < $user_data['stores_number']; $i++)
					{
						$store_data = $this->pages_data_model->get_store_data($user_data['stores_ids'][$i]); 
						if(strcmp($b, $store_data['name']) == 0) $s = 'selected="selected"'; else $s = '';
						echo '<option value="'.$user_data['stores_ids'][$i].'" '.$s.'>'.$store_data['name'].'</option>';
					}?>
				</select><br />
				<label>Select Code:</label>
				<select name="code" id="code">
					<option value="0" <?php echo set_select('code', '0'); ?>>All Codes</option>
					<?php
					if(isset($code)) $b = $code; else $b = '';
					for($i = 0; $i < $user_data['stores_number']; $i++)
					{
						$store_data = $this->pages_data_model->get_store_data($user_data['stores_ids'][$i]);
						echo '<optgroup label="'.$store_data['name'].'">';
						for($j = 0; $j < $store_data['codes_number']; $j++)
						{
							$code_data = $this->pages_data_model->get_code_data($store_data['codes_ids'][$j]);
							if(strcmp($b, $code_data['code']) == 0) $s = 'selected="selected"'; else $s = '';
							echo '<option value="'.$store_data['codes_ids'][$j].'" '.$s.'>'.$code_data['code'].' - '.$code_data['description'].'</option>';
						}
						echo '</optgroup>';
					}?>
				</select><br />
				<input name="btn_submit" id="btn_submit" src="<?php echo img_url('submit.png'); ?>" type="image" alt="submit" />
			</p>
			</form>
		</section>
		<section>
			<h2>
		<?php 
			if(isset($period)) echo $period.' - '; else echo 'All Time - '; 
			if(isset($store)) echo $store.' - '; else echo 'All Stores - '; 
			if(isset($code)) echo $code; else echo 'All Codes'; 
			if(isset($comments_number)) echo ' : '.$comments_number.' results.'; 
		?></h2>
			<table id="feedback_list">
			<thead>
				<tr>
					<th class="first">When</th>
					<th class="second">Code</th>
					<th class="third">Where</th>
					<th class="fourth">What</th>
					<th class="last">Comment</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$j = 1; 
				foreach($comments as $comment)
				{
					$rowstyle = 'odd';
					if($j % 2)
					{
						$rowstyle = 'even';
					}
					
					$j++; 
				?>
					<tr>
						<td class="first<?php echo " $rowstyle";?>"><?php echo $comment->time; ?></td>
						<td class="second<?php echo " $rowstyle";?>"><?php echo  strtoupper($comment->code); ?></td>
						<td class="third<?php echo " $rowstyle";?>"><?php echo $this->pages_data_model->get_store_name_from_code($comment->code); ?></td>
						<td class="fourth<?php echo " $rowstyle";?>"><?php echo $this->pages_data_model->get_description_from_code($comment->code); ?></td>
						<td class="last<?php echo " $rowstyle";?>"><?php echo htmlentities($comment->comment); ?></td>
					</tr>
				<?php 
				} 
				?>
			</tbody>
		</table>
		<div class="pagination"><?php echo $pagination; ?></div>
	<?php
	}
	?>
	</div>
	<p class="content_end">&nbsp;</p>
</div>