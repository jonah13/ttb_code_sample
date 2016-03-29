<?php
	$experience = array('positive','negative','neutral'); 
	$rating = array(5=>'Excellent',4=>'Good',3=>'Average',2=>'Fair',1=>'Poor');
	$unitname = !empty($company['unitname']) ? $company['unitname'] : 'ID Field';
	
	$questions = array(
		'driver_polite'=>"Was the driver polite?",
		'driver_safe'=>"Did your driver drive safely?",
		'driver_taxi_clean'=>"Was your taxi clean and neat?",
		'driver_clean'=>"Was the driver clean and neat?",
		'driver_cc'=>"Did the driver accept a credit card?",
		'driver_exp'=>"Rate your overall experience?"
	);
	
	$codejson = '[';
	$codenext = '';
	foreach ($codes as $c) {
		$codejson .= $codenext.'{id:'.$c['ID'].',lid:'.$c['location_id'].',code:"'.$c['code'].'"}';
		$codenext = ',';
	}
	$codejson .= ']';
?>
<div class="fluid-container">
<?php if (file_exists(UPLOAD_DIR.'logo_'.$company['ID'].'.jpg')) { ?>
<?php $size = getimagesize(img_url('uploads/logo_'.$company['ID'].'.jpg')); if ($size[1] == 125) { ?>
<img class="pull-right" height="60px" src="<?php echo img_url('uploads/logo_'.$company['ID'].'.jpg?v='.time()); ?>" alt=""/>
<?php } else { ?>
<img class="pull-right" width="150px" src="<?php echo img_url('uploads/logo_'.$company['ID'].'.jpg?v='.time()); ?>" alt=""/>
<?php } ?>
<?php } ?>
<h1><?php echo empty($comment) ? "Create" : "Edit"; ?> Comment</h1>
<h4><?php echo $company['name']; ?></h4>
<form role="form" action="<?php echo site_url("dash/save_comment"); ?>" method="post">
	<div class="row">
        <div class="col-sm-6 col-md-5 col-lg-4">
<!--
            <h2>
                <i class="fa fa-building-o"></i>&nbsp;Location Information</h2>
-->
            <input name="ID" type="hidden" value="<?php echo !empty($comment['ID']) ? $comment['ID'] : '0'; ?>"/>

            <div class="form-group top30">
                <label for="CommentDate">Date</label>
                <input id="mydate" name="comment_time" <?php echo !empty($comment['comment_time']) ? 'value="'.$comment['comment_time'].'"' : ''; ?> type="text" class="form-control" id="CommentDate" placeholder="Enter comment date">
            </div>

<?php if (empty($comment)) { ?>
            <div class="form-group">
				<label>Time</label>
				<div class="checkbox">
					<label>
						<input type="radio" name="timetype" value="AM"/> AM&nbsp;&nbsp;
					</label>
					<label>
						<input type="radio" name="timetype" value="PM"/> PM&nbsp;&nbsp;
					</label>
					<label>
						<input type="radio" name="timetype" value="0" checked/> None
					</label>
				</div>
            </div>
<?php } ?>
            
<?php if (strpos($company['qr-order'],'idfield') !== false) { ?>
  <?php if (!empty($company['qr-idfield-answers'])) { 
	  		$ar = explode(',',$company['qr-idfield-answers']);
  ?>
            <div class="form-group">
                <label for="Unit"><?php echo $unitname; ?></label>
                <select name="unit" class="form-control" id="Unit">
					<?php foreach ($ar as $a) {
						echo "<option value=".trim($a).(!empty($comment['unit']) && $comment['unit'] == trim($a) ? " selected" : "").">".trim($a)."</option>";
					} ?>
                </select>
            </div>
            
  <?php } else { ?>
            <div class="form-group">
                <label for="Unit"><?php echo $unitname; ?></label>
                <input name="unit" <?php echo !empty($comment['unit']) ? 'value="'.$comment['unit'].'"' : ''; ?> type="text" class="form-control" id="Unit" placeholder="Enter <?php echo $unitname; ?>">
            </div>
  <?php } ?>
<?php } ?>

            <div class="form-group">
                <label for="Rating">Rating</label>
                <select name="rating" class="form-control" id="Rating">
					<?php foreach ($rating as $sk=>$ss) {
						echo "<option value=".$sk.(!empty($comment['rating']) && $comment['rating'] == $sk ? " selected" : "").">".$sk."=".$ss."</option>";
					} ?>
                </select>
            </div>
            
<?php if (empty($comment)) { foreach ($questions as $k=>$q) { ?>
            <div class="form-group">
				<label><?php echo $q; ?></label>
				<div class="checkbox">
  <?php if ($k == 'driver_cc') { ?>
					<label>
						<input type="radio" name="<?php echo $k; ?>" value="Yes"/> Yes&nbsp;&nbsp;
					</label>
					<label>
						<input type="radio" name="<?php echo $k; ?>" value="No"/> No&nbsp;&nbsp;
					</label>
					<label>
						<input type="radio" name="<?php echo $k; ?>" value="0" checked/> N/A&nbsp;&nbsp;
					</label>
  <?php } else { ?>
					<label>
						<input type="radio" name="<?php echo $k; ?>" value="0" checked/> None&nbsp;&nbsp;
					</label>
					<label>
						<input type="radio" name="<?php echo $k; ?>" value="1"/> 1&nbsp;&nbsp;
					</label>
					<label>
						<input type="radio" name="<?php echo $k; ?>" value="2"/> 2&nbsp;&nbsp;
					</label>
					<label>
						<input type="radio" name="<?php echo $k; ?>" value="3"/> 3&nbsp;&nbsp;
					</label>
					<label>
						<input type="radio" name="<?php echo $k; ?>" value="4"/> 4&nbsp;&nbsp;
					</label>
					<label>
						<input type="radio" name="<?php echo $k; ?>" value="5"/> 5&nbsp;&nbsp;
					</label>
  <?php } ?>
				</div>
			</div>
<?php } } ?>            
            
            <div class="form-group">
                <label for="Comment">Comment</label>
                <textarea class="form-control" id="Comment" name="comment" rows="3"><?php echo !empty($comment['comment_time']) ? $comment['comment'] : ''; ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="Contact">Contact Info</label>
                <input name="contact" <?php echo !empty($comment['contact']) ? 'value="'.$comment['contact'].'"' : ''; ?> type="text" class="form-control" id="Contact" placeholder="Enter contact info">
            </div>
            
        </div>
        <div class="col-sm-6 col-md-5 col-md-offset-1 col-lg-4 col-lg-offset-1">
<!--
            <h2>
                <i class="fa fa-user"></i>&nbsp;Organization Placement</h2>
-->
            <div class="form-group top30">
                <label for="Location">Location</label>
                <select name="location_id" class="form-control" id="Location">
					<?php foreach ($locations as $loc) {
						echo "<option value=".$loc['ID'].(!empty($comment['location_id']) && $comment['location_id'] == $loc['ID'] ? " selected" : "").">".$loc['name']."</option>";
					} ?>
                </select>
            </div>
            
            <input type="hidden" name="code"/>
            <div class="form-group">
                <label for="Code">Code</label>
                <select name="code_id" class="form-control" id="Code">
<!--
					<?php foreach ($codes as $code) {
						echo "<option value=".$code['ID'].(!empty($comment['code']) && $comment['code'] == $code['code'] ? " selected" : "").">".$code['code']."</option>";
					} ?>
-->
                </select>
            </div>
            
            <div class="form-group">
                <label for="Nature">Experience</label>
                <select name="analyzer_nature" class="form-control" id="Nature">
					<?php foreach ($experience as $sk=>$ss) {
						echo "<option value=".$ss.(!empty($comment['analyzer_nature']) && $comment['analyzer_nature'] == $sk ? " selected" : "").">".$ss."</option>";
					} ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="Contest">Contest Info</label>
                <input name="contest" <?php echo !empty($comment['contest']) ? 'value="'.$comment['contest'].'"' : ''; ?> type="text" class="form-control" id="Contest" placeholder="Enter contest info">
            </div>
            
        </div>
	</div>
	<div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <button type="submit" class="btn btn-ttb mr20">Save</button>
            <a href="<?php echo site_url('dash'); ?>"><button type="button" class="btn btn-default mr20">Cancel</button></a>
            <?php if (!empty($comment)) { ?>
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
      <h4 class="modal-title">Delete comment</h4>
    </div>
    <div class="modal-body">
      <p>Are you sure you want to delete this comment?</p>
    </div>
    <div class="modal-footer"> 
    	<a href="#" class="btn btn-ttb" data-dismiss="modal">Close</a> 
    	<a href="<?php echo site_url('dash/delete_comment').'?cid='.$comment['ID']; ?>" class="btn btn-default">Delete</a> 
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

<div class="clearfix"></div>
<script>
	$(function () { 
	
		var codes = eval('<?php echo $codejson; ?>');
		function setup_select(lid) {
			var optionsAsString = '';
			$.each(codes,function(i,val) {
				if (val.lid == lid) {
					optionsAsString += "<option value='" + val.id + "'>" + val.code + "</option>";
				}
			}); 			
			$("select[name=code_id]").find('option').remove().end().append($(optionsAsString));
		}

<?php if (!empty($comment)) { ?>
		setup_select(<?php echo $comment['location_id']; ?>);
		$("select[name=code_id]").val("<?php echo $comment['code_id']; ?>");
		$('input[name=code]').val("<?php echo $comment['code']; ?>");
<?php } else { ?>
		setup_select(<?php echo $locations[0]['ID']; ?>);
		$('input[name=code]').val($('select[name=code_id]').find("option:first").text());
<?php } ?>	

		$('select[name=code_id]').change(function() {
			$('input[name=code]').val($(this).find("option:selected").text());
		});
		
		$('select[name=location_id]').change(function() {
			setup_select($(this).find("option:selected").val());
		});

		$('select[name=rating]').change(function() {
			var rating = $(this).find("option:selected").val();
			if (rating < 3) {
				$('select[name=analyzer_nature]').val('negative');
			} else if (rating > 3) {
				$('select[name=analyzer_nature]').val('positive');
			} else {
				$('select[name=analyzer_nature]').val('neutral');
			}
		});
		$('#mydate').datepicker({format:'yyyy-mm-dd'});
	});
</script>



            
