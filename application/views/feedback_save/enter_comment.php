<div id="main" >
	<div id="menu-content">
			<h2>Rating feedback</h2>
			<section>
			<p>Enter your comment (might contain an email so that it can be similar to what customers would submit):</p>
			<form class="feedback" method="post" action="<?php echo site_url('rate_feedback/submit'); ?>">
				<dl class="formFields">
					<dt>
						<?php echo form_error('feedback'); ?>
					</dt>
					<dd>
						<textarea rows="4" name="feedback" id="feedback"  aria-required="true" required="required" data-minlength="2"></textarea>
					</dd>
				</dl>
				<p class="formButtons">
					<input name="btn_submit" id="btn_submit" src="<?php echo img_url('submit.png'); ?>" type="image" alt="submit" />
				</p>
			</form>
			</section>
	</div>
</div>