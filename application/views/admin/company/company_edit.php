<?php 
	$states = array(
		"AL"=>"Alabama",
		"AK"=>"Alaska",
		"AZ"=>"Arizona",
		"AR"=>"Arkansas",
		"CA"=>"California",
		"CO"=>"Colorado",
		"CT"=>"Connecticut",
		"DE"=>"Delaware",
		"DC"=>"District Of Columbia",
		"FL"=>"Florida",
		"GA"=>"Georgia",
		"HI"=>"Hawaii",
		"ID"=>"Idaho",
		"IL"=>"Illinois",
		"IN"=>"Indiana",
		"IA"=>"Iowa",
		"KS"=>"Kansas",
		"KY"=>"Kentucky",
		"LA"=>"Louisiana",
		"ME"=>"Maine",
		"MD"=>"Maryland",
		"MA"=>"Massachusetts",
		"MI"=>"Michigan",
		"MN"=>"Minnesota",
		"MS"=>"Mississippi",
		"MO"=>"Missouri",
		"MT"=>"Montana",
		"NE"=>"Nebraska",
		"NV"=>"Nevada",
		"NH"=>"New Hampshire",
		"NJ"=>"New Jersey",
		"NM"=>"New Mexico",
		"NY"=>"New York",
		"NC"=>"North Carolina",
		"ND"=>"North Dakota",
		"OH"=>"Ohio",
		"OK"=>"Oklahoma",
		"OR"=>"Oregon",
		"PA"=>"Pennsylvania",
		"RI"=>"Rhode Island",
		"SC"=>"South Carolina",
		"SD"=>"South Dakota",
		"TN"=>"Tennessee",
		"TX"=>"Texas",
		"UT"=>"Utah",
		"VT"=>"Vermont",
		"VA"=>"Virginia",
		"WA"=>"Washington",
		"WV"=>"West Virginia",
		"WI"=>"Wisconsin",
		"WY"=>"Wyoming"
	);
?>
<div class="fluid-container">
<?php if (!empty($company) && file_exists(UPLOAD_DIR.'logo_'.$company['ID'].'.jpg')) { ?>
<?php $size = getimagesize(img_url('uploads/logo_'.$company['ID'].'.jpg')); if ($size[1] == 125) { ?>
<img class="pull-right" height="60px" src="<?php echo img_url('uploads/logo_'.$company['ID'].'.jpg?v='.time()); ?>" alt=""/>
<?php } else { ?>
<img class="pull-right" width="150px" src="<?php echo img_url('uploads/logo_'.$company['ID'].'.jpg?v='.time()); ?>" alt=""/>
<?php } ?>
<?php } ?>
<h1><?php echo empty($company) ? "Create" : "Edit"; ?> Profile</h1>
<?php if (!empty($company)) { ?>
<h4><?php echo $company['name']; ?></h4>
<?php } ?>
<form role="form" action="<?php echo site_url("admin/company/save_company"); ?>" method="post">
	<div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <h2>
                <i class="fa fa-building-o"></i>&nbsp;Company Information</h2>
            <input name="ID" type="hidden" value="<?php echo !empty($company['ID']) ? $company['ID'] : '0'; ?>"/>
            <div class="form-group top30">
                <label for="CompanyName">Company name</label>
                <input name="name" <?php echo !empty($company['name']) ? 'value="'.$company['name'].'"' : ''; ?> type="text" class="form-control" id="CompanyName" placeholder="Enter company name">
            </div>
            <div class="form-group">
                <label for="Address">Address</label>
                <input name="address" <?php echo !empty($company['address']) ? 'value="'.$company['address'].'"' : ''; ?> type="text" class="form-control" id="Address" placeholder="Enter address">
            </div>
            <div class="form-group">
                <label for="City">City</label>
                <input name="city" <?php echo !empty($company['city']) ? 'value="'.$company['city'].'"' : ''; ?> type="text" class="form-control" id="City" placeholder="Enter city">
            </div>
            <div class="form-group">
                <label for="State">State</label>
                <select name="state" class="form-control" id="State">
                    <option value="">Select state...</option>
					<?php foreach ($states as $sk=>$ss) {
						echo "<option value=".$sk.(!empty($company['state']) && $company['state'] == $sk ? " selected" : "").">".$ss."</option>";
					} ?>
                </select>
            </div>
            <div class="form-group">
                <label for="ZipCode">Zip Code</label>
                <input name="zipcode" <?php echo !empty($company['zipcode']) ? 'value="'.$company['zipcode'].'"' : ''; ?> type="text" class="form-control" id="CompanyName" placeholder="Enter zip code name">
            </div>
        </div>
        <div class="col-sm-6 col-md-4  col-md-offset-1 col-lg-3 col-lg-offset-1">
            <h2>
                <i class="fa fa-user"></i>&nbsp;Contact Information</h2>
            <div class="form-group top30">
                <label for="ContactName">Contact name</label>
                <input name="company_contact" <?php echo !empty($company['company_contact']) ? 'value="'.$company['company_contact'].'"' : ''; ?> type="text" class="form-control" id="ContactName" placeholder="Enter contact name">
            </div>
            <div class="form-group">
                <label for="ContactPhone">Contact phone</label>
                <input name="contact_phone" <?php echo !empty($company['contact_phone']) ? 'value="'.$company['contact_phone'].'"' : ''; ?> type="text" class="form-control" id="ContactPhone" placeholder="Enter phone number">
            </div>
            <div class="form-group">
                <label for="ContactEmail">Contact email</label>
                <input name="contact_email" <?php echo !empty($company['contact_email']) ? 'value="'.$company['contact_email'].'"' : ''; ?> type="email" class="form-control" id="ContactEmail" placeholder="Enter email address">
            </div>
        </div>
	</div>
	<div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <button type="submit" class="btn btn-ttb mr20">Save</button>
<?php if (!empty($company) && strcmp($this->session->userdata('type'), 'SUPER') == 0) { ?>
            <a href="<?php echo site_url("/admin/company/script"); ?>"><button type="button" class="btn btn-ttb">Edit Script</button></a>
<?php } ?>
        </div>
	</div>
</form>
<?php if (!empty($company)) { ?>
<h2><i class="fa fa-picture-o"></i> Company Logo</h2>
<?php if (!empty($error)) { ?>
<div class="alert alert-danger"> <?php echo trim($error); ?> </div>
<?php } ?>
<div class="pull-left">
<h4>Upload New Image</h4>
<form role="form" action="<?php echo site_url('admin/company/save_picture'); ?>" method="post" enctype="multipart/form-data">
	<input type="file" name="userfile">
	<input style="margin-top:10px;" type="submit" value="Upload" class="btn btn-ttb" />
</form>
</div>
<div class="pull-left">
<?php if (file_exists(UPLOAD_DIR.'logo_'.$company['ID'].'.jpg')) { ?>
<h4>Current Image</h4>
<?php $size = getimagesize(img_url('uploads/logo_'.$company['ID'].'.jpg')); if ($size[1] == 125) { ?>
<img class="pull-right" height="60px" src="<?php echo img_url('uploads/logo_'.$company['ID'].'.jpg?v='.time()); ?>" alt=""/>
<?php } else { ?>
<img class="pull-right" width="150px" src="<?php echo img_url('uploads/logo_'.$company['ID'].'.jpg?v='.time()); ?>" alt=""/>
<?php } ?>
<?php } ?>
<?php } ?>
</div>
</div>
<div class="clearfix"></div>
            
