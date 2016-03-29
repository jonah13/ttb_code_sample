<?php $user_data = $this->pages_data_model->get_user_data();?>
<div id="main" class="dashboard">
	<div id="menu-content">
		<h2>My Account</h2>
		<p>
			<span class="infot">User Name:</span> <?php echo $user_data['username']; ?><br />
			<span class="infot">Full Name:</span> <?php echo $user_data['first_name'].' '.$user_data['last_name']; ?><br />
			<span class="infot">Company Name:</span> <?php echo $user_data['company_name']; ?><br />
			<span class="infot">Email:</span> <a href="mailto:<?php echo $user_data['email']; ?>"><?php echo $user_data['email']; ?></a><br />
			<span class="infot">Phone number:</span> <?php echo $user_data['phone']; ?><br />
			<span class="infot">Your subsciption ends on:</span> <?php echo $user_data['plan_end']; ?><br />
			<span class="infot">You signed up to <a href="<?php echo site_url(''); ?>">TellTheBoss.com</a> on:</span> <?php echo $user_data['sign_up_date']; ?><br />
		</p>
		<h2>Store information</h2>
		<?php 
			if($user_data['stores_number'] < 1) echo '<p>You currently have no registred store to our service. To register your stores go to <a href="'.site_url('dashboard/add_stores').'">Add Stores</a></p>';
			else
			{
				echo '<p>You have '.$user_data['stores_number'].' stores registered with Tell the Boss. Each Store SMS Code and QR Code is listed below:</p>';
				for($i = 0; $i < $user_data['stores_number']; $i++)
				{
					$store_data = $this->pages_data_model->get_store_data($user_data['stores_ids'][$i]);
					echo '<section>';
					echo '<h3 class="no_top_margin">'.$store_data['name'].'</h3>';
					echo '<p>'; ?>
					<?php if(isset($store_data['logo']) && strlen($store_data['logo']) > 1 && strcmp($store_data['logo'], 'no_logo_uploaded') != 0) { ?>
						<img class="dashboard" alt="store logo" src="<?php echo uploads_url($store_data['logo']); ?>" /> <br />
					<?php } 
					
					if(isset($store_data['business_type']) && strlen($store_data['business_type']) > 1) 
						echo '<span class="infot">Business Type:</span> '.$store_data['business_type'].'<br />';
					if(isset($store_data['description']) && strlen($store_data['description']) > 1) 
						echo '<span class="infot">Description:</span> <br />'.$store_data['description'].'<br />';
					if((isset($store_data['address']) && strlen($store_data['address']) > 1)||(isset($store_data['city']) && strlen($store_data['city']) > 1)||(isset($store_data['state']) && strlen($store_data['state']) > 1)||(isset($store_data['zipcode']) && strlen($store_data['zipcode']) > 1)) {
						echo '<span class="infot">Address information:</span><br />';
						if(isset($store_data['address']) && strlen($store_data['address']) > 1) echo $store_data['address'].', ';
						if(isset($store_data['city']) && strlen($store_data['city']) > 1) echo $store_data['city'].', ';
						if(isset($store_data['state']) && strlen($store_data['state']) > 1) echo $store_data['state'].'.<br />';
						if(isset($store_data['zipcode']) && strlen($store_data['zipcode']) > 1) echo '<span class="infot">Zip Code:</span> '.$store_data['zipcode'].'<br />';
					} 
					if(isset($store_data['store_phone']) && strlen($store_data['store_phone']) > 1) 
						echo '<span class="infot">Store Phone:</span> '.$store_data['store_phone'].'<br />';
					if(isset($store_data['fax']) && strlen($store_data['fax']) > 1) 
						echo '<span class="infot">Store Fax:</span> '.$store_data['fax'].'<br />';
					if(isset($store_data['store_email']) && strlen($store_data['store_email']) > 1) 
						echo '<span class="infot">Store Email:</span> <a href="mailto:'.$store_data['store_email'].'">'.$store_data['store_email'].'</a><br />';
					if(isset($store_data['website']) && strlen($store_data['website']) > 1) 
						echo '<span class="infot">Store Website:</span> <a href="'.$store_data['website'].'">'.$store_data['website'].'</a><br />';
					echo '</p>'; ?>
			
					<br /><strong><span class="infot">Store Codes:</span></strong><br />
					<table id="codes_list">
						<thead>
							<tr>
								<th class="first">SMS Code</th>
								<th class="second">QR Code</th>
								<th class="third">URL</th>
								<th class="last">Code Description</th>
							</tr>
						</thead>
						<tbody>
							<?php
							for($j = 0; $j < $store_data['codes_number']; $j++)
							{
								$code_data = $this->pages_data_model->get_code_data($store_data['codes_ids'][$j]);
								$code = strtolower($code_data['code']);
								$url = site_url('feedback/receive/'.$code);
								$filename = "$code.png";
								$filepath = "/var/www/ttb/assets/images/$filename"; 
								$width = $height = 300; 
								if (!file_exists($filename)) 
								{ 
									$qr_url = urlencode($url); 
									$qr = file_get_contents("http://chart.googleapis.com/chart?chs={$width}x{$height}&cht=qr&chl={$qr_url}&choe=UTF-8&chld=L|1"); 
									file_put_contents($filepath, $qr); 
								}
								
								$desc = (isset($code_data['description']) && strlen($code_data['description']) > 1)?$code_data['description']:'No description given for this code';
								echo '<tr>';
									echo '<td class="first">'.$code_data['code'].'</td>';
									echo '<td class="second"><div class="qr_code"><img alt="QR code: Right click to download full size image" title="QR code: Right click to download full size image" style="height:100px;width:100px;" src="/assets/images/'.$filename.'"/></div></td>';
									echo '<td class="third"><a href="'.$url.'">'.$url.'</a></td>';
									echo '<td class="last">'.$desc.'</td>';
								echo '</tr>';
							}
							?>
						</tbody>
					</table>
				</section>
				<?php
				}
			}
		?>
	</div>
	<p class="content_end">&nbsp;</p>
</div>