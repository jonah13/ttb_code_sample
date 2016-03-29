<div class="fluid-container">
<?php if (file_exists(UPLOAD_DIR.'logo_'.$company['ID'].'.jpg')) { ?>
<?php $size = getimagesize(img_url('uploads/logo_'.$company['ID'].'.jpg')); if ($size[1] == 125) { ?>
<img class="pull-right" height="60px" src="<?php echo img_url('uploads/logo_'.$company['ID'].'.jpg?v='.time()); ?>" alt=""/>
<?php } else { ?>
<img class="pull-right" width="150px" src="<?php echo img_url('uploads/logo_'.$company['ID'].'.jpg?v='.time()); ?>" alt=""/>
<?php } ?>
<?php } ?>
<a href="<?php echo site_url('admin/users/edit?uid=0'); ?>">
    <button type="button" class="btn btn-ttb btn-lg pull-right mt0 mr20">
        <i class="fa fa-plus-circle"></i>&nbsp;Add User</button>
</a>
<?php if ($this->pages_data_model->is_logged_in() && strcmp($this->session->userdata('type'), 'SUPER') == 0) { ?>
<!--
<a href="<?php echo site_url('admin/users/edit?uid=0'); ?>">
    <button type="button" class="btn btn-ttb btn-lg pull-right mt0 mr20">
        <i class="fa fa-plus-circle"></i>&nbsp;Connect User</button>
</a>
-->
<?php } ?>
<h1>Users</h1>
<h4><?php echo $company['name']; ?></h4>
<div class="clearfix"></div>
<table cellpadding="0" cellspacing="0" border="0" class="table table-hover" id="userindex">
    <thead>
        <tr>
            <th>Username</th>
            <th>Name</th>
            <th>Email</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($users as $c) { ?>
        <tr>
            <td><a href="<?php echo site_url('admin/users/edit?uid='.$c['ID']); ?>"><?php echo $c['username']; ?></a></td>
            <td><?php echo $c['first_name'].' '.$c['last_name']; ?></td>
            <td><?php echo $c['email']; ?></td>
            <td><?php echo $c['type']; ?></td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<script>  
	$(function () { 
		$('table').dataTable({
			"sPaginationType": "bootstrap",
			"aoColumns": [
				{  },
				{  },
				{  },
				{  }
	       ]
		});
	});  
</script> 
