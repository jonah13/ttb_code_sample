<div id="main">
	<section class="left_sec">
				<h1>Contact Us</h1>
				<p>Do you have questions regarding our service? Or, are you interested in scheduling a demo and want to request a date for a consult?<br />
				Leave your name and contact information, and we will get back with you shortly.</p>
				<form class="contact "method="post" action="<?php echo site_url('contact/submit'); ?>">
					<p>
						<label for="name">Name:</label>
						<input class="text" type="text" name="name" id="name" />
						<br />
						<label for="name">Company Name:</label>
						<input class="text" type="text" name="company_name" id="company_name" />
						<br />
						<label for="email">Email:</label>
						<input class="text" type="text" name="email" id="email" />
						<br />
						<label for="phone">Enter your phone number if you would like us to call you:</label>
						<input class="text" type="text" name="phone" id="phone" />
						<br />
						<label for="message">Message:</label> 
						<textarea name="message" id="message"></textarea>
						<br />
						<input name="btn_send" class="btn_send" src="<?php echo img_url('send.png'); ?>" type="image" />
					</p>
				</form>
	</section>
	<section class="right_sec">
				<h1>Contact Information</h1>
				<br />
				<img src="<?php echo img_url('con-img.jpg'); ?>" alt="contact information" height="134" width="238" />
				<br />
				<br />
				<p><strong>Address:</strong> <br />
					Tell the Boss, Inc. <br />
					27762 Antonio Parkway Suite L-1504 <br />
					Ladera Ranch, CA 92694 <br />
					Email contact at : <a href="mailto:info@telltheboss.com">Info@TellTheBoss.com</a> <br />
					Phone:     (949) 888-1000 <br />
					Toll free: (888) 744-2855 <br />
					<!--Fax:       (888) 551-1128 -->
				</p>
	</section>
	<p class="content_end">&nbsp;</p>
</div>