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
	
	$rxurl = 'telltheboss.com/ttb2/feedback/receive/';
	$timezones = array(
		"EST"=>"EST",
		"CST"=>"CST",
		"MST"=>"MST",
		"PST"=>"PST"
		);
?>
<div class="fluid-container">
<?php if (file_exists(UPLOAD_DIR.'logo_'.$company['ID'].'.jpg')) { ?>
<?php $size = getimagesize(img_url('uploads/logo_'.$company['ID'].'.jpg')); if ($size[1] == 125) { ?>
<img class="pull-right" height="60px" src="<?php echo img_url('uploads/logo_'.$company['ID'].'.jpg?v='.time()); ?>" alt=""/>
<?php } else { ?>
<img class="pull-right" width="150px" src="<?php echo img_url('uploads/logo_'.$company['ID'].'.jpg?v='.time()); ?>" alt=""/>
<?php } ?>
<?php } ?>
<h1><?php echo empty($location) ? "Create" : "Edit"; ?> Location</h1>
<h4><?php echo $company['name']; ?></h4>
<form role="form" action="<?php echo site_url("admin/locations/save"); ?>" method="post">
	<div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <h2>
                <i class="fa fa-building-o"></i>&nbsp;Location Information</h2>
            <input name="ID" type="hidden" value="<?php echo !empty($location['ID']) ? $location['ID'] : '0'; ?>"/>
            <div class="form-group top30">
                <label for="CompanyName">Location name</label>
                <input name="name" <?php echo !empty($location['name']) ? 'value="'.$location['name'].'"' : ''; ?> type="text" class="form-control" id="CompanyName" placeholder="Enter company name">
            </div>
            <div class="form-group">
                <label for="Address">Address</label>
                <input name="address" <?php echo !empty($location['address']) ? 'value="'.$location['address'].'"' : ''; ?> type="text" class="form-control" id="Address" placeholder="Enter address">
            </div>
            <div class="form-group">
                <label for="City">City</label>
                <input name="city" <?php echo !empty($location['city']) ? 'value="'.$location['city'].'"' : ''; ?> type="text" class="form-control" id="City" placeholder="Enter city">
            </div>
            <div class="form-group">
                <label for="State">State</label>
                <select name="state" class="form-control" id="State">
                    <option value="">Select state...</option>
					<?php foreach ($states as $sk=>$ss) {
						echo "<option value=".$sk.(!empty($location['state']) && $location['state'] == $sk ? " selected" : "").">".$ss."</option>";
					} ?>
                </select>
            </div>
            <div class="form-group">
                <label for="ZipCode">Zip Code</label>
                <input name="zipcode" <?php echo !empty($location['zipcode']) ? 'value="'.$location['zipcode'].'"' : ''; ?> type="text" class="form-control" id="CompanyName" placeholder="Enter zip code name">
            </div>
            <div class="form-group">
                <label for="Timezone">Timezone</label>
                <select name="timezone" class="form-control" id="Timezone">
                    <option value="">Select timezone...</option>
					<?php foreach ($timezones as $sk=>$ss) {
						echo "<option value=".$sk.(!empty($location['timezone']) && $location['timezone'] == $sk ? " selected" : "").">".$ss."</option>";
					} ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6 col-md-5 col-md-offset-1 col-lg-4 col-lg-offset-1">
            <h2>
                <i class="fa fa-user"></i>&nbsp;Organization Placement</h2>
            <div class="form-group top30">
                <label for="State">Organization level</label>
                <select name="orgposition" class="form-control" id="State">
                    <option value="" selected="selected">No Group</option>
                    <?php foreach ($groups as $k=>$g) { ?>
                    	<option value="<?php echo $k; ?>" <?php if ($k == $group_id) { echo "selected"; } ?>><?php echo $g; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
	</div>
	<div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <button type="submit" class="btn btn-ttb mr20">Save</button>
            <a href="<?php echo site_url('admin/locations'); ?>"><button type="button" class="btn btn-default mr20">Cancel</button></a>
            <?php if (!empty($location)) { ?>
	            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">
	                Delete</button>
	        <?php } ?>
        </div>
	</div>
</form>

<!-- Modal -->
<div class="modal fade" id="myModal">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">Delete location</h4>
    </div>
    <div class="modal-body">
      <p>All feedback, location codes and user permissions that are associated with this location will also be deleted.</p>
      <p>Are you sure you want to delete this location?</p>
    </div>
    <div class="modal-footer"> 
    	<a href="#" class="btn btn-ttb" data-dismiss="modal">Close</a> 
    	<a href="<?php echo site_url('admin/locations/delete_location').'?lid='.$location['ID']; ?>" class="btn btn-default">Delete</a> 
    </div>
  </div>
  <!-- /.modal-content --> 
</div>
<!-- /.modal-dialog --> 
</div>
<!-- /.modal --> 

<!-- Modal -->
<div class="modal fade" id="myModalCode">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">Delete code</h4>
    </div>
    <div class="modal-body">
      <p>All feedback associated with this code will also be deleted.</p>
      <p>Are you sure you want to delete this code?</p>
    </div>
    <div class="modal-footer"> 
    	<a href="#" class="btn btn-ttb" data-dismiss="modal">Close</a> 
    	<a id="deletecode" href="#" class="btn btn-default">Delete</a> 
<!-- <a href=""> -->
    </div>
  </div>
  <!-- /.modal-content --> 
</div>
<!-- /.modal-dialog --> 
</div>
<!-- /.modal --> 

<!-- /row -->
<?php if (!empty($location)) { ?>
<div class="row top30">
    <div class="col-md-12">
        <h2>
            <i class="fa fa-qrcode"></i>&nbsp;Location Codes</h2>
    </div>
</div>
<div class="ltgray">
<?php if (!empty($codes)) { ?>
<table class="table table-stripped qrcodes">
    <colgroup>
        <col class="col-xs-1">
            <col class="col-xs-2">
                <col class="col-xs-6">
                    <col class="col-xs-1">
                        <col class="col-xs-1">
<?php if($this->pages_data_model->is_logged_in() &&strcmp($this->session->userdata('type'), 'SUPER') == 0) { ?>
							<col class="col-xs-1">
<?php } ?>
    </colgroup>
    <thead>
        <tr>
            <th>QR</th>
            <th>Code</th>
            <th>Description</th>
            <th>Auto-Set<br/>Id Field</th>
            <th></th>
<?php if($this->pages_data_model->is_logged_in() &&strcmp($this->session->userdata('type'), 'SUPER') == 0) { ?>
            <th></th>
<?php } ?>
        </tr>
    </thead>
    <tbody>
    	<?php foreach ($codes as $c) { ?>
        <tr>
            <td>
            	<a href="<?php echo site_url('feedback/receive').'/'.$c['code']; ?>">
                <img src="<?php echo site_url('admin/locations/get_qr_code').'?code='.$rxurl.$c['code']; ?>" height="64" width="64" />
            	</a>
            </td>
            <td>
            	<a class="editablecode" href="#" data-type="text" data-url="<?php echo site_url('admin/locations/set_code'); ?>" data-pk="<?php echo $c['ID']; ?>" data-name="code">
            		<?php echo empty($c['code']) ? '' : $c['code']; ?>
            	</a>
<!--                 <input type="text" class="form-control" id="qrcode" placeholder="Enter code" <?php echo empty($c['code']) ? '' : 'value="'.$c['code'].'"'; ?>> -->
            </td>
            <td>
            	<a href="#" data-type="text" data-url="<?php echo site_url('admin/locations/set_code'); ?>" data-pk="<?php echo $c['ID']; ?>" data-name="description">
            		<?php echo empty($c['description']) ? '' : $c['description']; ?>
            	</a>
<!--                 <input type="text" class="form-control" id="qrcode_desc" placeholder="Enter code description" <?php echo empty($c['description']) ? '' : 'value="'.$c['description'].'"'; ?>> -->
            </td>
            <td>
            	<a href="#" data-type="text" data-url="<?php echo site_url('admin/locations/set_code'); ?>" data-pk="<?php echo $c['ID']; ?>" data-name="idfieldset">
            		<?php echo empty($c['idfieldset']) ? '' : $c['idfieldset']; ?>
            	</a>
            </td>
            <td>
            	<a href="<?php echo site_url('admin/locations/get_qr_code').'?code='.$rxurl.$c['code']; ?>" download="<?php echo $c['code'].'.png'; ?>">
                <button type="button" class="btn btn-ttb btn-sm pull-right">
                    Download</button>
            	</a>
            </td>
<?php if($this->pages_data_model->is_logged_in() &&strcmp($this->session->userdata('type'), 'SUPER') == 0) { ?>
            <td>
                <button type="button" class="btn btn-default btn-sm pull-right codedelete" data-toggle="modal" data-target="#myModalCode" data-code="<?php echo $c['ID']; ?>">
                    Delete</button>
            </td>
<?php } ?>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php } ?>
<?php if($this->pages_data_model->is_logged_in() &&strcmp($this->session->userdata('type'), 'SUPER') == 0) { ?>
<a href="<?php echo site_url('admin/locations/add_qr_code').'?lid='.$location['ID']; ?>">
    <button type="button" class="btn btn-ttb btn-xs">
        <i class="fa fa-plus-circle"></i>&nbsp;Add Code</button>
</a>
<?php } ?>
</div>
<?php } ?>
<div class="clearfix"></div>
<script>
	$(function () { 
		$('a[data-type=text]').editable({
			success: function(response,newValue) {
				if ($(this).hasClass('editablecode')) {
					$(this).parent().prev().html('<img src="<?php echo site_url('admin/locations/get_qr_code').'?code='.$rxurl; ?>'+newValue+'" height="64" width="64" />');
					$(this).parent().next().next().children('a').attr('href','<?php echo site_url('admin/locations/get_qr_code').'?code='.$rxurl; ?>'+newValue).attr('download',newValue+'.png');
				}
			}
		});

		$('.codedelete').on('click',function(e) {
			var code = $(this).attr('data-code');
			$('#deletecode').attr('href','<?php echo site_url('admin/locations/delete_qr_code').'?lid='.$location['ID']; ?>&cid='+code);
		});
	});
</script>



            
