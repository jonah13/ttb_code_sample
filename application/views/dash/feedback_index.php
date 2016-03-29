<form id="filterform" role="form" action="<?php echo site_url('dash'); ?>" method="post">
	<input type="hidden" name="startdate" value="<?php echo !empty($date_filter) ? $date_filter['start'] : ''; ?>"/>
	<input type="hidden" name="enddate" value="<?php echo !empty($date_filter) ? $date_filter['end'] : ''; ?>"/>
	<input type="hidden" name="locations" value="<?php echo implode(',',$location_filter); ?>"/>
	<input type="hidden" name="location" value=""/>
	<input type="hidden" name="codes" value="<?php echo implode(',',$code_filter); ?>"/>
	<input type="hidden" name="code" value=""/>
	<input type="hidden" name="units" value="<?php echo implode(',',$unit_filter); ?>"/>
	<input type="hidden" name="unit" value=""/>
	<input type="hidden" name="exps" value="<?php echo implode(',',$exp_filter); ?>"/>
	<input type="hidden" name="exp" value=""/>
	<input type="hidden" name="sources" value="<?php echo implode(',',$source_filter); ?>"/>
	<input type="hidden" name="source" value=""/>
</form>

  <div class="row filters">
    <div class="fluid-container">
      <div> 
        <div class="btn-group">
          <button id="daterange" type="button" data="" class="btn btn-ttb btn-sm<?php echo !empty($date_filter) ? ' btn-ttb-dark' : ''; ?>"><?php echo !empty($date_filter) ? $date_filter['start'].' to '.$date_filter['end'] : 'Date Range'; ?> <span class="caret"></span></button>
        </div>

<?php if (!empty($my_locations) && count($my_locations) > 1) { ?>
        <div class="btn-group">
          <button type="button" class="btn btn-ttb btn-sm dropdown-toggle<?php echo !empty($location_filter) ? ' btn-ttb-dark' : ''; ?>" data-toggle="dropdown">Location <span class="caret"></span></button>
          <ul class="dropdown-menu" role="menu">
<?php foreach ($my_locations as $m) { ?>
            <li> <a class="location_filter" data="<?php echo $m['locname']; ?>" href="#"><?php echo $m['locname']; ?> <?php echo !empty($location_filter) && in_array($m['locname'],$location_filter) ? '<i class="fa fa-check"></i>' : ''; ?></a></li>
<?php } ?>
            <li class="divider"></li>
            <li> <a class="location_filter" data="" href="#">All Locations <?php echo empty($location_filter) ? '<i class="fa fa-check"></i>' : ''; ?></a> </li>
          </ul>
        </div>
<?php } ?>

<?php if (!empty($my_codes) && count($my_codes) > 1) { ?>
        <div class="btn-group">
          <button type="button" data="" class="btn btn-ttb btn-sm dropdown-toggle<?php echo !empty($code_filter) ? ' btn-ttb-dark' : ''; ?>" data-toggle="dropdown">Code <span class="caret"></span></button>
          <ul class="dropdown-menu" role="menu">
<?php foreach ($my_codes as $m) { ?>
            <li> <a class="code_filter" data="<?php echo $m['code']; ?>" href="#"><?php echo $m['code']; ?> <?php echo !empty($code_filter) && in_array($m['code'],$code_filter) ? '<i class="fa fa-check"></i>' : ''; ?></a></li>
<?php } ?>
            <li class="divider"></li>
            <li> <a class="code_filter" data="" href="#">All Codes <?php echo empty($code_filter) ? '<i class="fa fa-check"></i>' : ''; ?></a> </li>
          </ul>
        </div>
<?php } ?>

<?php if (!empty($my_units) && count($my_units) > 1) { ?>
<?php if (!empty($company['unitname'])) { ?>
        <div class="btn-group">
          <button type="button" data="" class="btn btn-ttb btn-sm dropdown-toggle<?php echo !empty($unit_filter) ? ' btn-ttb-dark' : ''; ?>" data-toggle="dropdown"><?php echo $company['unitname']; ?> <span class="caret"></span></button>
          <ul class="dropdown-menu" role="menu">
<?php foreach ($my_units as $m) { ?>
            <li> <a class="unit_filter" data="<?php echo $m['unit']; ?>" href="#"><?php echo $m['unit']; ?> <?php echo !empty($unit_filter) && in_array($m['unit'],$unit_filter) ? '<i class="fa fa-check"></i>' : ''; ?></a></li>
<?php } ?>
            <li class="divider"></li>
            <li> <a class="unit_filter" data="" href="#">All <?php echo empty($unit_filter) ? '<i class="fa fa-check"></i>' : ''; ?></a> </li>
          </ul>
        </div>
<?php } ?>
<?php } ?>

        <div class="btn-group">
          <button type="button" data="" class="btn btn-ttb btn-sm dropdown-toggle<?php echo !empty($exp_filter) ? ' btn-ttb-dark' : ''; ?>" data-toggle="dropdown"> Experience <span class="caret"></span></button>
          <ul class="dropdown-menu" role="menu">
            <li> <a class="exp_filter" data="positive" href="#">Positive <?php echo !empty($exp_filter) && in_array('positive',$exp_filter) ? '<i class="fa fa-check"></i>' : ''; ?></a></li>
            <li> <a class="exp_filter" data="neutral" href="#">Neutral <?php echo !empty($exp_filter) && in_array('neutral',$exp_filter) ? '<i class="fa fa-check"></i>' : ''; ?></a></li>
            <li> <a class="exp_filter" data="negative" href="#">Negative <?php echo !empty($exp_filter) && in_array('negative',$exp_filter) ? '<i class="fa fa-check"></i>' : ''; ?></a></li>
            <li class="divider"></li>
            <li> <a class="exp_filter" data="" href="#">All Experience <?php echo empty($exp_filter) ? '<i class="fa fa-check"></i>' : ''; ?></a> </li>
          </ul>
        </div>

        <div class="btn-group">
          <button type="button" data="" class="btn btn-ttb btn-sm dropdown-toggle<?php echo !empty($source_filter) ? ' btn-ttb-dark' : ''; ?>" data-toggle="dropdown">Source <span class="caret"></span></button>
          <ul class="dropdown-menu" role="menu">
            <li> <a class="source_filter" data="SMS" href="#">SMS <?php echo !empty($source_filter) && in_array('SMS',$source_filter) ? '<i class="fa fa-check"></i>' : ''; ?></a></li>
            <li> <a class="source_filter" data="QR" href="#">QR Code <?php echo !empty($source_filter) && in_array('QR',$source_filter) ? '<i class="fa fa-check"></i>' : ''; ?></a></li>
            <li> <a class="source_filter" data="URL" href="#">URL <?php echo !empty($source_filter) && in_array('URL',$source_filter) ? '<i class="fa fa-check"></i>' : ''; ?></a></li>
            <li> <a class="source_filter" data="MAIL" href="#">Mail <?php echo !empty($source_filter) && in_array('MAIL',$source_filter) ? '<i class="fa fa-check"></i>' : ''; ?></a></li>
            <li class="divider"></li>
            <li> <a class="source_filter" data="" href="#">All Sources <?php echo empty($source_filter) ? '<i class="fa fa-check"></i>' : ''; ?></a> </li>
          </ul>
        </div>
        <form class="feedback" role="search">
          <div class="form-group">
            <input id="search-box" type="text" class="form-control search" placeholder="Search">
          </div>
        </form>
        
<?php if($this->pages_data_model->is_logged_in() &&strcmp($this->session->userdata('type'), 'SUPER') == 0) { ?>
        <a href="<?php echo site_url('dash/edit_comment').'?cid=0'; ?>"><button type="button" class="btn btn-outline btn-sm pull-right"> <i class="fa fa-comment"></i> Add Comment</button></a>
<?php } ?>
      </div>
    </div>
    <!-- /container --> 
  </div>
  <!-- /filter row -->
  
	<div class="fluid-container">
		
<?php if (file_exists(UPLOAD_DIR.'logo_'.$company['ID'].'.jpg')) { ?>
		<div id="divlogo" class="logo pull-right" style="display:none;">
<?php $size = getimagesize(img_url('uploads/logo_'.$company['ID'].'.jpg')); if ($size[1] == 125) { ?>
			<img class="pull-right" height="60px" src="<?php echo img_url('uploads/logo_'.$company['ID'].'.jpg?v='.time()); ?>" alt=""/>
<?php } else { ?>
			<img class="pull-right" width="150px" src="<?php echo img_url('uploads/logo_'.$company['ID'].'.jpg?v='.time()); ?>" alt=""/>
<?php } ?>
			<a id="showanalytics" href="#">Show Analytics</a>
		</div>
<?php } ?>

		<div id="divanalytics" class="charts pull-right" style="display:;">
			<div class="chart experience">
				<canvas id="nature_chart" width="93" height="93"></canvas>
				<h3>Experience</h3>
				<ul class="fa-ul">
				<?php $total = $stats['positive']+$stats['negative']+$stats['neutral']; ?>
					<li> <i class="fa-li fa fa-comment positive"></i>Positive (<?php echo $total == 0 ? '0%' : number_format($stats['positive']*100/($total),0).'%'; ?>)</li>
					<li> <i class="fa-li fa fa-comment negative"></i>Negative (<?php echo $total == 0 ? '0%' : number_format($stats['negative']*100/($total),0).'%'; ?>)</li>
					<li> <i class="fa-li fa fa-comment neutral"></i>Neutral (<?php echo $total == 0 ? '0%' : number_format($stats['neutral']*100/($total),0).'%'; ?>)</li>
				</ul>
			</div>
			<div class="chart">
				<canvas id="source_chart" width="93" height="93"></canvas>
				<h3>Source</h3>
				<ul class="fa-ul">
				<?php $total = $stats['SMS']+$stats['QR']+$stats['URL']+$stats['MAIL']; ?>
					<li> <i style="color:#1b7396" class="fa-li fa fa-mobile"></i>SMS (<?php echo $total == 0 ? '0%' : number_format($stats['SMS']*100/($total),0).'%'; ?>)</li>
					<li> <i style="color:#002a4a" class="fa-li fa fa-qrcode"></i>QR Code (<?php echo $total == 0 ? '0%' : number_format($stats['QR']*100/($total),0).'%'; ?>)</li>
					<li> <i style="color:#d64700" class="fa-li fa fa-desktop"></i>URL (<?php echo $total == 0 ? '0%' : number_format($stats['URL']*100/($total),0).'%'; ?>)</li>
					<li> <i style="color:#ff9311" class="fa-li fa fa-envelope"></i>Mail (<?php echo $total == 0 ? '0%' : number_format($stats['MAIL']*100/($total),0).'%'; ?>)</li>
				</ul>
			</div>
<?php if (file_exists(UPLOAD_DIR.'logo_'.$company['ID'].'.jpg')) { ?>
			<a id="hideanalytics" href="#">Hide Analytics</a>
<?php } ?>
		</div>

	    <h1>Customer Feedback</h1>
	    <h4><?php echo $company['name']; ?></h4>

		<div class="clearfix"></div>
	
	</div>
	
  <!-- begin feedback table -->
  <div class="fluid-container top30">
    <table class="table table-hover feedback">
      <thead>
        <tr>
          <th>Date/Time</th>
          <th>Location</th>
          <th>Code</th>
<?php if (!empty($company['unitname'])) { ?>
          <th><?php echo $company['unitname']; ?></th>
<?php } ?>
          <th>Feedback</th>
          <th class="text-center">Experience</th>
          <th class="text-center">Source</th>
        </tr>
      </thead>
      <tbody>
<?php 
	$source = array('URL'=>'fa-desktop','MAIL'=>'fa-envelope','SMS'=>'fa-mobile','QR'=>'fa-qrcode'); 
	$sort0 = array('URL'=>'2','MAIL'=>'3','SMS'=>'0','QR'=>'1'); 
	$sort1 = array('positive'=>'0','neutral'=>'1','negative'=>'2'); 
	$sort2 = array('positive'=>'&#43;','neutral'=>'&#61;','negative'=>'&#8722;'); 
	foreach ($comments as $c) { ?>
        <tr>
<?php if ($c['origin'] == 'MAIL') { ?>
          <td nowrap><span data-var="<?php echo $c['utime']; ?>"><?php echo date("n/j/y A",$c['utime']); ?></span></td>
<?php } else { ?>
          <td nowrap><span data-var="<?php echo $c['utime']; ?>"><?php echo date("n/j/y g:i A",$c['utime']); ?></span></td>
<?php } ?>
          <td><?php echo $c['locname']; ?></td>
          <td><?php echo $c['code']; ?></td>
<?php if (!empty($company['unitname'])) { ?>
          <td><?php echo $c['unit']; ?></td>
<?php } ?>
<?php if($this->pages_data_model->is_logged_in() &&strcmp($this->session->userdata('type'), 'SUPER') == 0) { ?>
          <td><a href="<?php echo site_url('dash/edit_comment').'?cid='.$c['ID']; ?>"><?php echo empty($c['comment']) ? 'None' : $c['comment']; ?></a></td>
<?php } else { ?>
          <td><?php echo empty($c['comment']) ? 'None' : $c['comment']; ?></td>
<?php } ?>
          <td class="text-center"><span data-var="<?php echo $sort1[$c['nature']]; ?>"><i class="fa fa-comment fa-lg <?php echo $c['nature']; ?>"><span class="operator"><?php echo $sort2[$c['nature']]; ?></span></i></span></td>
          <td class="text-center"><span data-var="<?php echo $sort0[$c['origin']]; ?>"><i class="fa <?php echo $source[$c['origin']]; ?> fa-lg"></i></span></td>

        </tr>
<?php } ?>
      </tbody>
    </table>
  </div>
  <!-- /container --> 
  <div id="downloadbuttons">
	    <a href="<?php echo site_url('dash/pdf'); ?>"><button type="button" class="btn btn-default btn-xs pull-right print"> <i class="fa fa-print fa-inverse"></i>&nbsp;Print PDF</button></a>
	    <a href="<?php echo site_url('dash/csv'); ?>"><button type="button" class="btn btn-default btn-xs pull-right"> <i class="fa fa-arrow-circle-down fa-inverse"></i>&nbsp;Download CSV</button></a>
  </div>

<script>  
	$(function () { 
	
	//chart code
	var data = [
		{
			value: <?php echo $stats['positive']; ?>,
			color:"#35A907"
		},
		{
			value: <?php echo $stats['negative']; ?>,
			color : "#BF0115"
		},
		{
			value: <?php echo $stats['neutral']; ?>,
			color : "#B7B7B7"
		}			
	];
	
	var data_2 = [
		{
			value: <?php echo $stats['SMS']; ?>,
			color : "#1b7396"
		},
		{
			value: <?php echo $stats['QR']; ?>,
			color : "#002a4a"
		},
		{
			value: <?php echo $stats['URL']; ?>,
			color : "#d64700"
		},
		{
			value: <?php echo $stats['MAIL']; ?>,
			color:"#ff9311"
		}			
	];
	
	var options = { animationSteps: 100, segmentStrokeWidth :1 };

	var ctx = $("#nature_chart").get(0).getContext("2d");
	var nature_chart = new Chart(ctx).Doughnut(data, options);
	var ctx2 = $("#source_chart").get(0).getContext("2d");
	var source_chart = new Chart(ctx2).Doughnut(data_2, options);

	jQuery.fn.dataTableExt.oSort['data-var-asc'] = function(a,b) {
		regex = /data-var=\"([0-9]+)/;
		x = a.match(regex)[1];
		y = b.match(regex)[1];
		return ((x > y) ?  1 : ((x < y) ? -1 : 0));
	};
	jQuery.fn.dataTableExt.oSort['data-var-desc'] = function(a,b) {
		regex = /data-var=\"([0-9]+)/;
		x = a.match(regex)[1];
		y = b.match(regex)[1];
		return ((x < y) ?  1 : ((x > y) ? -1 : 0));
	};
	
		var oTable = $('table').dataTable({
			"sDom": "<'row'<'col-xs-6'l><'col-xs-6' <'#rightside'>>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
			"sPaginationType": "bootstrap",
			"bAutoWidth": false,
			"iDisplayLength": 100,
            "aoColumns": [
				{ sWidth : '20%', sType: "data-var" },
				{ sWidth : '20%' },
				{ sWidth : '10%' },
<?php if (!empty($company['unitname'])) { ?>
				{ sWidth : '10%' },
<?php } ?>
				{ sWidth : '30%' },
				{ sWidth : '5%', sType: "data-var" },
				{ sWidth : '5%', sType: "data-var" }
	       ]
		});
		oTable.fnSort( [ [0,'desc'] ] );

		$('[data-toggle="popover"]').popover({
		    trigger: 'clicks',
		        'placement': 'top'
		});
		$('#showanalytics').click(function(e) {
			$('#divlogo').fadeOut(function() {
				$('#divanalytics').fadeIn();
			});
			e.preventDefault();
		})
		$('#hideanalytics').click(function(e) {
			$('#divanalytics').fadeOut(function() {
				$('#divlogo').fadeIn();
			});
			e.preventDefault();
		})
		
		$("#search-box").keyup(function(){
			oTable = $('table').dataTable();
		    oTable.fnFilter( $(this).val() );
	
		});
		
		$("#downloadbuttons").appendTo('#rightside');
		
		$('.location_filter').click(function(e) {
			e.preventDefault();
			var location = $(this).attr('data');
			if (location == '') {
				$('input[name=locations]').val('');
			} else {
				$('input[name=location]').val(location);
			}
			$('#filterform').submit();
		});

		$('.code_filter').click(function(e) {
			e.preventDefault();
			var code = $(this).attr('data');
			if (code == '') {
				$('input[name=codes]').val('');
			} else {
				$('input[name=code]').val(code);
			}
			$('#filterform').submit();
		});

		$('.unit_filter').click(function(e) {
			e.preventDefault();
			var unit = $(this).attr('data');
			if (unit == '') {
				$('input[name=units]').val('');
			} else {
				$('input[name=unit]').val(unit);
			}
			$('#filterform').submit();
		});

		$('.exp_filter').click(function(e) {
			e.preventDefault();
			var exp = $(this).attr('data');
			if (exp == '') {
				$('input[name=exps]').val('');
			} else {
				$('input[name=exp]').val(exp);
			}
			$('#filterform').submit();
		});

		$('.source_filter').click(function(e) {
			e.preventDefault();
			var source = $(this).attr('data');
			if (source == '') {
				$('input[name=sources]').val('');
			} else {
				$('input[name=source]').val(source);
			}
			$('#filterform').submit();
		});
		
		$('.date_filter').click(function(e) {
			e.preventDefault();
			$('input[name=startdate]').val('');
			$('input[name=enddate]').val('');
			$('#filterform').submit();
		});
				
		$('#daterange').daterangepicker(
		  { 
            ranges: {
               'All Dates': [0, 0],
               'Today': [new Date(), new Date()],
               'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
               'Last 7 Days': [moment().subtract('days', 6), new Date()],
               'Last 30 Days': [moment().subtract('days', 29), new Date()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
            },
			opens: 'left',
            format: 'MM/DD/YYYY',
<?php if (!empty($date_filter)) { ?>
			startDate: '<?php echo $date_filter['start']; ?>',
			endDate: '<?php echo $date_filter['end']; ?>',
<?php } else { ?>
			startDate: '12/31/1969',
			endDate: '12/31/1969',
<?php } ?>
            buttonClasses: ['btn btn-ttb'],
            applyClass: 'btn-small btn-ttb',
            cancelClass: 'btn-small btn-ttb'
		  },
		  function(start, end, label) {
			$('input[name=startdate]').val(start.valueOf() <= 0 ? '' : start.format('MM/DD/YYYY'));
			$('input[name=enddate]').val(end.valueOf() <= 0 ? '' : end.format('MM/DD/YYYY'));
			$('#filterform').submit();
		  }
		);		
	});  
</script> 
