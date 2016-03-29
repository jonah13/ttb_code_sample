<?php
$this->load->helper('feedback');

echo '<div id="main" >
			<div id="menu-content">
			<h2>Rating feedback</h2>
			<section>';
			$result_n = rate_feedback($comment, true);
			if($result_n == 1) $result = 'Positive';
			elseif($result_n == 2) $result = 'Negative';
			else $result = 'Neutral';
			//echo '<br/> Comment index: <strong>'.$result_n.'</strong>';
			echo '<br/> Comment Nature: <strong>'.$result.'</strong>';
			echo '
			</section>
			</div>
			</div>';
?>