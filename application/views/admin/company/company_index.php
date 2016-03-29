<div class="fluid-container">
<h1 class="pull-left">Companies</h1>
<a href="<?php echo site_url('admin/company/add'); ?>">
    <button type="button" class="btn btn-ttb btn-lg pull-right">
        <i class="fa fa-plus-circle"></i>&nbsp;Add Company</button>
</a>
<div class="clearfix"></div>
<table cellpadding="0" cellspacing="0" border="0" class="table table-hover" id="companyindex">
    <thead>
        <tr>
        	<th></th>
            <th>Company</th>
            <th>Contact Name</th>
            <th class="text-center">Active</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($companies as $c) { ?>
        <tr>
        	<td class="text-center"><a href="<?php echo site_url('admin/company?cid='.$c['ID']); ?>">
<?php if (file_exists(UPLOAD_DIR.'logo_'.$c['ID'].'.jpg')) { ?>
<?php $size = getimagesize(img_url('uploads/logo_'.$c['ID'].'.jpg')); if ($size[1] == 125) { ?>
<img height="25px" src="<?php echo img_url('uploads/logo_'.$c['ID'].'.jpg?v='.time()); ?>" alt=""/>
<?php } else { ?>
<img width="50px" src="<?php echo img_url('uploads/logo_'.$c['ID'].'.jpg?v='.time()); ?>" alt=""/>
<?php } ?>
<?php } ?>
        	</a></td>
            <td><a href="<?php echo site_url('admin/company?cid='.$c['ID']); ?>"><?php echo $c['name']; ?></a></td>
            <td><?php echo $c['company_contact']; ?></td>
            <td class="text-center">
                <a href="#" class="activebutton" data-id="<?php echo $c['ID']; ?>">
                    <i class="fa fa-power-off <?php echo $c['is_active'] ? 'on' : 'off'; ?>"></i>
                </a>
            </td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<script>  
	$(function () { 
		$('.activebutton').click(function(e) {
			var id = $(this).attr('data-id');
			var obj = $(this).children(0);
			$.post("<?php echo site_url('admin/home/change_active'); ?>",{id: id},function(data) {
				if (data == '1') {
					obj.removeClass('off');
					obj.addClass('on');
				} else {
					obj.removeClass('on');
					obj.addClass('off');
				}
			});
			e.preventDefault();
		});
		
		var oTable = $('table').dataTable({
			"iDisplayLength": 50,
			"sPaginationType": "bootstrap",
			"aoColumns": [
				{ 'bSortable': false },
				{  },
				{  },
				{ 'bSortable': false }
	       ]
		});
		oTable.fnSort( [ [1,'asc'] ] );

	});  
</script> 
