<?php
	function dohtml($map,$loc_names,$group_types,$group_names,$permissions) {
		$nest = '';
		if (!empty($map['locations'])) {
			foreach ($map['locations'] as $k=>$m) {
				$nest .= '
<li class="dd-item dd3-item" data-id="'.$m.'">
	<div class="dd-handle dd3-handle dd-location dd3-handle-fa fa'.(!empty($permissions['location']) && in_array($m,$permissions['location']) ? ' fa-check-square-o' : ' fa-square-o').'"></div>
	<div class="dd3-content"><i class="fa fa-building-o"></i>
	 '.$loc_names[$m].'</div>
</li>
				';
			}
		}
		if (!empty($map['groups'])) {
			foreach ($map['groups'] as $k=>$m) {
				$nest .= '
<li class="dd-item dd3-item" data-id="-'.$k.'"><button type="button" data-action="collapse" class="expandcollapse">Collapse</button>
	<div class="dd-handle dd3-handle dd-group dd3-handle-fa fa"></div>
	<div class="dd3-content"><i class="fa fa-sitemap"></i> 
		<b>'.$group_types[$k].'&nbsp;|&nbsp;'.$group_names[$k].'</b>
	</div>
	<ol class="dd-list">
			    ';
			
				$nest .= dohtml($m,$loc_names,$group_types,$group_names,$permissions);
				
				$nest .= '
	</ol>
</li>
				';
			}
		}
		
		return $nest;
	}

	
	$nest = dohtml($map,$loc_names,$group_types,$group_names,$permissions);
/* 	var_dump($permissions); */
	
	$oneLocation = (empty($map['locations']) || count($map['locations']) <= 1) && empty($map['groups']);
?>
<div class="fluid-container">
<?php if (file_exists(UPLOAD_DIR.'logo_'.$company['ID'].'.jpg')) { ?>
<?php $size = getimagesize(img_url('uploads/logo_'.$company['ID'].'.jpg')); if ($size[1] == 125) { ?>
<img class="pull-right" height="60px" src="<?php echo img_url('uploads/logo_'.$company['ID'].'.jpg?v='.time()); ?>" alt=""/>
<?php } else { ?>
<img class="pull-right" width="150px" src="<?php echo img_url('uploads/logo_'.$company['ID'].'.jpg?v='.time()); ?>" alt=""/>
<?php } ?>
<?php } ?>
<h1><?php echo empty($user) ? "Create" : "Edit"; ?> User</h1>
<?php if (strcmp($this->session->userdata('type'), 'SUPER') != 0) { ?>
<h4><?php echo $company['name']; ?></h4>
<?php } ?>
<form role="form" action="<?php echo site_url("admin/users/save"); ?>" method="post">
    <input name="ID" type="hidden" value="<?php echo !empty($user['ID']) ? $user['ID'] : '0'; ?>"/>
	<div class="row">
        <div class="col-sm-6 col-md-5 col-lg-5">
            <h2><i class="fa fa-user"></i>&nbsp;User Information</h2>
            <div class="form-group top30">
                <label for="FirstName">First name</label>
                <input name="first_name" value="<?php echo !empty($user['first_name']) ? $user['first_name'] : ''; ?>" type="text" class="form-control" id="FirstName" placeholder="Enter first name">
            </div>
            <div class="form-group">
                <label for="LastName">Last name</label>
                <input name="last_name" value="<?php echo !empty($user['last_name']) ? $user['last_name'] : ''; ?>"type="text" class="form-control" id="LastName" placeholder="Enter last name">
            </div>
<?php if (strcmp($this->session->userdata('type'), 'ADMIN') == 0 || strcmp($this->session->userdata('type'), 'SUPER') == 0) { ?>
            <div class="form-group">
                <label for="Type">Permission type</label>
                <select name="type" class="form-control" id="Type">
						<option value="CLIENT" <?php echo !empty($user['type']) && $user['type'] == 'CLIENT' ? 'selected' : ''; ?>>USER</option>";
						<option value="ADMIN" <?php echo !empty($user['type']) && $user['type'] == 'ADMIN' ? 'selected' : ''; ?>>ADMIN</option>";
<?php if (strcmp($this->session->userdata('type'), 'SUPER') == 0) { ?>
						<option value="SUPER" <?php echo !empty($user['type']) && $user['type'] == 'SUPER' ? 'selected' : ''; ?>>SUPER</option>";
<?php } ?>
                </select>
            </div>
<?php } ?>
        </div>
        <div class="col-sm-6 col-md-5  col-md-offset-1 col-lg-5 col-lg-offset-1">
            <h2>
                <i class="fa fa-lock"></i>&nbsp;Username and Password</h2>
            <div class="form-group top30">
                <label for="Username">Username</label>
                <input name="username" value="<?php echo !empty($user['username']) ? $user['username'] : ''; ?>"type="text" class="form-control" id="Username" placeholder="Enter username">
            </div>
            <div class="form-group">
                <label for="Password">Password</label>
                <input name="password" value="<?php echo !empty($user['password']) ? $user['password'] : ''; ?>"type="password" class="form-control" id="Password" placeholder="Enter new password">
            </div>
            <div class="form-group">
                <label for="RePassword">Confirm password</label>
                <input id="confirmpassword" value="<?php echo !empty($user['password']) ? $user['password'] : ''; ?>"type="password" class="form-control" id="RePassword" placeholder="Re-enter new password">
            </div>
        </div>
	</div>
	<div class="row top10">
	    <div class="col-sm-6 col-md-5 col-lg-5">
	        <h2><i class="fa fa-bullhorn"></i>&nbsp;Feedback Notification Settings</h2>
            <div class="form-group top20">
                <label for="MobilePhone">Mobile phone</label>
                <input name="phone" value="<?php echo !empty($user['phone']) ? $user['phone'] : ''; ?>"type="text" class="form-control" id="MobilePhone" placeholder="Enter mobile phone number">
            </div>
	        <div class="notify">
	            <div class="onoffswitch">
	                <input type="checkbox" name="smsonoff" class="onoffswitch-checkbox" id="smsonoff" <?php echo !empty($sms) ? 'checked' : ''; ?>>
	                <label class="onoffswitch-label" for="smsonoff">
	                    <div class="onoffswitch-inner"></div>
	                    <div class="onoffswitch-switch"></div>
	                </label>
	            </div>
	            <span class="notify_type">
	                Use Text</span>
	        </div>
	        <fieldset id="smsfield" <?php echo !empty($sms) ? '' : 'disabled'; ?>>
		        <div class="checkbox-inline">
		            <label class="checkbox-inline">
		                <input type="checkbox" name="smstype" value="3" <?php echo !empty($sms) && $sms[0]['notify_for'] == 'all' ? 'checked' : ''; ?>>All feedback
		            </label>
		            <label class="checkbox-inline">
		                <input type="checkbox" name="smstype" value="1" <?php echo !empty($sms) && $sms[0]['notify_for'] == 'negative' ? 'checked' : ''; ?>>Negative only
		            </label>
		            <label class="checkbox-inline">
		                <input type="checkbox" name="smstype" value="2" <?php echo !empty($sms) && $sms[0]['notify_for'] == 'positive' ? 'checked' : ''; ?>>Positive only
		            </label>
		        </div>
	        </fieldset>
            <div class="form-group top30">
                <label for="Email">Email address</label>
                <input name="email" value="<?php echo !empty($user['email']) ? $user['email'] : ''; ?>"type="text" class="form-control" id="Email" placeholder="Enter email address">
            </div>
	        <div class="notify">
	            <div class="onoffswitch">
	                <input type="checkbox" name="emailonoff" class="onoffswitch-checkbox" id="emailonoff" <?php echo !empty($email) ? 'checked' : ''; ?>>
	                <label class="onoffswitch-label" for="emailonoff">
	                    <div class="onoffswitch-inner"></div>
	                    <div class="onoffswitch-switch"></div>
	                </label>
	            </div>
	            <span class="notify_type">
	                Use Email</span>
	        </div>
	        <fieldset id="emailfield" <?php echo !empty($email) ? '' : 'disabled'; ?>>
	            <div class="checkbox-inline">
	                <label class="checkbox-inline">
	                    <input type="checkbox" name="emailtype" value="3" <?php echo !empty($email) && $email[0]['notify_for'] == 'all' ? 'checked' : ''; ?>>All feedback
	                </label>
	                <label class="checkbox-inline">
	                    <input type="checkbox" name="emailtype" value="1" <?php echo !empty($email) && $email[0]['notify_for'] == 'negative' ? 'checked' : ''; ?>>Negative only
	                </label>
	                <label class="checkbox-inline">
	                    <input type="checkbox" name="emailtype" value="2" <?php echo !empty($email) && $email[0]['notify_for'] == 'positive' ? 'checked' : ''; ?>>Positive only
	                </label>
	            </div>
	        </fieldset>
	        <p class="top20">Note: please make sure you add telltheboss.com to your spam filter white list</p>
	    </div>
<?php if (strcmp($this->session->userdata('type'), 'ADMIN') == 0 || strcmp($this->session->userdata('type'), 'SUPER') == 0) { ?>
	    <div class="col-sm-6 col-md-5  col-md-offset-1 col-lg-5 col-lg-offset-1">
	        <h2 class="">
	            <i class="fa fa-sitemap"></i>&nbsp;Location Permission</h2>
	        <input type="hidden" name="checks" value=""/>
			<div class="dd" id="nestable3">
			    <ol class="dd-list topElement">
<?php if (!$oneLocation) { ?>
					<li class="dd-item dd3-item" data-id="-'.$k.'"><button type="button" data-action="expand" class="expandcollapse">Collapse</button>
						<div class="dd-handle dd3-handle dd-group dd3-handle-fa fa"></div>
						<div class="dd3-content"><i class="fa fa-sitemap"></i> <b><?php echo $company['name']; ?></b>
						</div>
						<ol class="dd-list" style="display:none;">
<?php } ?>
					        <?php echo $nest; ?>
<?php if (!$oneLocation) { ?>
						</ol>
					</li>
<?php } ?>
			    </ol>
			</div>
	    </div>
<?php } ?>
	</div>
	<div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <button id="saveuser" type="submit" class="btn btn-ttb mr20">Save</button>
            <a href="<?php echo site_url('admin/users'); ?>"><button type="button" class="btn btn-default mr20">Cancel</button></a>
            <?php if (!empty($user['ID']) && $user['ID'] != $this->session->userdata('user_id')) { ?>
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
      <h4 class="modal-title">Delete user</h4>
    </div>
    <div class="modal-body">
      <p>Are you sure you want to delete this user?</p>
    </div>
    <div class="modal-footer"> 
    	<a href="#" class="btn btn-ttb" data-dismiss="modal">Close</a> 
    	<a href="<?php echo site_url('admin/users/delete_user').'?uid='.$user['ID']; ?>" class="btn btn-default">Delete</a> 
    </div>
  </div>
  <!-- /.modal-content --> 
</div>
<!-- /.modal-dialog --> 
</div>
<!-- /.modal --> 

<!-- /container -->
<script>
	$(function () { 
		function check_parent(rootobj) {
			var top = rootobj.parent().parent().hasClass('topElement');
			var obj = rootobj.parent().parent().prev().prev();
			var objs = obj.next().next().children('li').children('.dd3-handle-fa').length;
			var checked = obj.next().next().children('li').children('.fa-check-square-o').length;
			var mixed = obj.next().next().children('li').children('.fa-minus-square-o').length;
			if (mixed > 0) {
				obj.removeClass('fa-check-square-o').removeClass('fa-square-o').addClass('fa-minus-square-o');
			} else if (checked == 0) {
				obj.removeClass('fa-check-square-o').removeClass('fa-minus-square-o').addClass('fa-square-o');
			} else if (checked == objs) {
				obj.addClass('fa-check-square-o').removeClass('fa-minus-square-o').removeClass('fa-square-o');
			} else {
				obj.removeClass('fa-check-square-o').addClass('fa-minus-square-o').removeClass('fa-square-o');
			}
			if (!top) {
				check_parent(obj);
			}
		}
		$('.dd-location').on('click',function(e) {
			e.preventDefault();
			var obj = $(this);
			if (obj.hasClass('fa-check-square-o')) {
				obj.removeClass('fa-check-square-o');
				obj.addClass('fa-square-o');
			} else {
				obj.addClass('fa-check-square-o');
				obj.removeClass('fa-square-o');
			}
			check_parent(obj);
		});
		
		$('.dd-location').each(function() {
			check_parent($(this));
		});
		
		$('.dd-group').each(function() {
			var obj = $(this);
			if (obj.hasClass('fa-check-square-o') ||
			    obj.hasClass('fa-square-o') ||
			    obj.hasClass('fa-minus-square-o')) {
			} else {
				obj.addClass('fa-square-o');
			}
		});
		
		function check_children(obj,state) {
			if (state) {
				obj.next().next().children('li').children('.dd3-handle-fa').removeClass('fa-minus-square-o').removeClass('fa-square-o').addClass('fa-check-square-o');
				obj.next().next().children('li').children('.dd-group').each(function() {check_children($(this),state)});
			} else {
				obj.next().next().children('li').children('.dd3-handle-fa').removeClass('fa-minus-square-o').removeClass('fa-check-square-o').addClass('fa-square-o');
				obj.next().next().children('li').children('.dd-group').each(function() {check_children($(this),state)});
			}
		}
		
		$('.dd-group').on('click',function(e) {
			e.preventDefault();
			var obj = $(this);
			if (obj.hasClass('fa-check-square-o')) {
				obj.removeClass('fa-check-square-o');
				obj.removeClass('fa-minus-square-o');
				obj.addClass('fa-square-o');
				check_children(obj,false);
			} else {
				obj.addClass('fa-check-square-o');
				obj.removeClass('fa-minus-square-o');
				obj.removeClass('fa-square-o');
				check_children(obj,true);
			}
			check_parent(obj);
		});
		
		$('.expandcollapse').on('click',function(e) {
			if ($(this).attr('data-action') == 'collapse') {
				$(this).attr('data-action','expand');
				$(this).next().next().next().hide();
			} else {
				$(this).attr('data-action','collapse');
				$(this).next().next().next().show();
			}
		});
		
		$('#saveuser').click(function (e) {
			var pw = $('input[name=password]').val();
			var cp = $('#confirmpassword').val();
			if (pw != cp) {
				alert("Password and Confirm Password do not match.");
				e.preventDefault();	
			}
			var checks = '';
			$('.dd-location').each(function() {
				if ($(this).hasClass('fa-check-square-o')) {
					if (checks != '') { checks += ','; }
					checks += $(this).parent().attr('data-id');
				}
			});
			$('input[name=checks]').val(checks);
		});
		
		$('input[name=smsonoff]').change(function() {
			$('#smsfield').prop('disabled',!this.checked);
		});
		$('input[name=smstype]').change(function() {
			$('input[name=smstype]').prop('checked',false);
			this.checked = true;
		});

		$('input[name=emailonoff]').change(function() {
			$('#emailfield').prop('disabled',!this.checked);
		});
		$('input[name=emailtype]').change(function() {
			$('input[name=emailtype]').prop('checked',false);
			this.checked = true;
		});
	});
</script>
