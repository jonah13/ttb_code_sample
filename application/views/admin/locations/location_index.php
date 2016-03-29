<?php
	function dohtml($map,$loc_names,$group_types,$group_names) {
		$nest = '';
		if (!empty($map['locations'])) {
			foreach ($map['locations'] as $k=>$m) {
				$nest .= '
<li class="dd-item dd3-item dd-location" data-id="'.$m.'">
	<div class="dd-handle dd3-handle"></div><div class="dd3-content"><i class="fa fa-building-o"></i> <a href="'.site_url('admin/locations/edit').'?lid='.$m.'" data_gid="'.$m.'">'.$loc_names[$m].'</a></div>
</li>
				';
			}
		}
		if (!empty($map['groups'])) {
			foreach ($map['groups'] as $k=>$m) {
				$nest .= '
<li class="dd-item dd3-item" data-id="-'.$k.'">
	<div class="dd-handle dd3-handle"></div>
	<div class="dd3-content"><i class="fa fa-sitemap"></i> 
		<a href="#" data-type="text" data-url="'.site_url('admin/locations/set_group').'" data-pk="'.$k.'" data-name="type">'.$group_types[$k].'</a>&nbsp;|&nbsp;<a href="#" data-type="text" data-url="'.site_url('admin/locations/set_group').'" data-pk="'.$k.'" data-name="name">'.$group_names[$k].'</a>
		<a href="'.site_url('admin/locations/edit').'?gid='.$k.'">
			<button type="button" class="btn btn-ttb btn-xs pull-right" data-gid="'.$k.'" style="line-height:1.3;">
				<i class="fa fa-plus-circle"></i>&nbsp;Add Location
			</button>
		</a>
		<button data-toggle="modal" data-target="#myModal" type="button" class="btn btn-default btn-xs pull-right mr10" data-gid="'.$k.'" style="line-height:1.3;">
			<i class="fa fa-minus-circle"></i>&nbsp;Delete Group
		</button>
	</div>
	<ol class="dd-list">
			    ';
			
				$nest .= dohtml($m,$loc_names,$group_types,$group_names);
				
				$nest .= '
	</ol>
</li>
				';
			}
		}
		
		return $nest;
	}

	
	$nest = dohtml($map,$loc_names,$group_types,$group_names);
?>
<div class="fluid-container">
<?php if (file_exists(UPLOAD_DIR.'logo_'.$company['ID'].'.jpg')) { ?>
<?php $size = getimagesize(img_url('uploads/logo_'.$company['ID'].'.jpg')); if ($size[1] == 125) { ?>
<img class="pull-right" height="60px" src="<?php echo img_url('uploads/logo_'.$company['ID'].'.jpg?v='.time()); ?>" alt=""/>
<?php } else { ?>
<img class="pull-right" width="150px" src="<?php echo img_url('uploads/logo_'.$company['ID'].'.jpg?v='.time()); ?>" alt=""/>
<?php } ?>
<?php } ?>
<h1>Organizational Structure</h1>
<h4><?php echo $company['name']; ?></h4>
</div>

<div class="fluid-container header mt30">
<?php if (!empty($error)) { ?>
<div class="alert alert-danger"> <?php echo trim($error); ?> </div>
<?php } ?>
	<h2><i class="fa fa-sitemap"></i>&nbsp;Add Group Level</h2>
	<div class="row top20">
		<form role="form" action="<?php echo site_url("admin/locations/add_group"); ?>" method="post">
	        <div class="col-sm-5">
	        	<input type="hidden" value="<?php echo $company['ID']; ?>" name="companyid"/>
	            <div class="form-group">
	                <label for="CompanyName">Group level type
	                    <span class="text-muted">(Zone, Territory, Region, State, County, etc.)</span>
	                </label>
	                <input type="text" name="grouptype" class="form-control" id="CompanyName" placeholder="Enter group level type">
	            </div>
	        </div>
	        <div class="col-sm-5">
	            <div class="form-group">
	                <label for="CompanyName">Group level description</label>
	                <input type="text" name="groupname" class="form-control" id="CompanyName" placeholder="Enter group level description">
	            </div>
	        </div>
	        <div class="col-sm-2">
	            <button id="addgroup" type="submit" class="btn btn-ttb"><i class="fa fa-plus-circle"></i>&nbsp;Add Group</button>
	        </div>
	    </form>
	</div>
</div>

<div class="fluid-container">          
	<div class="row top30">
        <div class="col-xs=12 col-sm-10 col-md-8 col-lg-6">
    	<a href="<?php echo site_url('admin/locations/edit'); ?>"><button type="button" class="btn btn-ttb" data-gid="0"><i class="fa fa-plus-circle"></i>&nbsp;Add Location</button></a>
		<div class="top30 clearfix"></div>
		<div class="dd" id="nestable3">
		    <ol class="dd-list">
		    	<?php echo $nest; ?>
		    </ol>
		</div>
        </div>
	</div>
	
	<!-- Modal -->
	<div class="modal fade" id="myModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Delete group</h4>
				</div>
				<div class="modal-body">
					<p>Any locations in this group will NOT be deleted and will end up not in any group.</p>
					<p>Are you sure you want to delete this group?</p>
				</div>
				<div class="modal-footer"> 
					<a href="#" class="btn btn-ttb" data-dismiss="modal">Close</a> 
					<a id="deletegroup" href="#" class="btn btn-default">Delete</a> 
				</div>
			</div>
		<!-- /.modal-content --> 
		</div>
	<!-- /.modal-dialog --> 
	</div>
	<!-- /.modal --> 

</div>
<div class="clearfix"></div>
<script>
	$(function () { 
		$('a[data-type=text]').editable();
		$('#nestable3').nestable();

		function find_parent(map,id,group) {
			for (var key in map) {
				if (map[key].id == id) { return group; }
				if (map[key].children != undefined && map[key].children.length > 0) {
					var g = find_parent(map[key].children,id,map[key].id);
					if (g !== false) { return g; }
				}
			}
			return false;
		}
		
/* 		var map = window.JSON.stringify($('#nestable3').nestable('serialize')); */
		$('#nestable3').on('change',function(e,id) {
			var map = $('#nestable3').nestable('serialize');
			var group = find_parent(map,id,0);
			$.post("<?php echo site_url('admin/locations/change_group'); ?>",{id: id, group: group});
		});
		
		$('button[data-toggle=modal]').on('click',function(e) {
			var gid = $(this).attr('data-gid');
			$('#deletegroup').attr('href','<?php echo site_url('admin/locations/delete_group').'?gid='; ?>'+gid);
		});
	});
</script>
