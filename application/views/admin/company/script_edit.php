<?php
	$types = array('qr','sms');
	
	$parts = array(
				'rating'=>'Rating',
				'idfield'=>'ID Field',
				'comment'=>'Comment',
				'contact'=>'Contact',
				'contest'=>'Contest',
				'reply'=>'Reply'
				);
				
	$first_message_boiler = 'Text HELP for help, text STOP to stop. Msg&Data Rates May Apply';
	$last_message_boiler = 'Msg&Data Rates May Apply';
	$defaultorder = array('qr'=>'rating,comment,contact,reply','sms'=>'comment,rating,contact');
	$defaultscript = array('qr' => array(
				'rating'=>'How was your experience today?',
				'idfield'=>'Please enter your cab #...',
				//Where did your experience occur? 
				'comment'=>'Tell us more...',
				'contact'=>'If you would like to be contacted...',
				'contest'=>'To be entered in the monthly drawing...',
				'reply'=>'Thank you for your feedback.'
				//Thank you for your feedback. If you entered your email or phone #, we will be contacting you.
				//Thank you for your feedback. If you win the drawing, we will contact you.
				),
				'sms' => array(			
				'rating'=>'How would you rate your experience? On a scale of 1-5 (1=worst, 5=best)?',
				'idfield'=>'Please enter your cab #:',
				//Where did your experience occur? Enter 1 for drive-thru, 2 for Carry-out, 3 for Eat-In
				'comment'=>'Tell us what you think?',
				'contact'=>'Thank you for your feedback. If you would like to be contacted re this
issue, enter your email or phone # below:',
				'contest'=>'Thank you for your feedback. To be entered in our monthly drawing, enter
your email or phone # below:',
				'reply'=>'Thank you for your feedback.'
				));
				
	if (empty($company['unitname'])) {
		$company['unitname'] = 'Id Field';
	}
	foreach ($types as $t) {	
		$nest[$t] = '';
		if (empty($company[$t.'-order'])) {
			$company[$t.'-order'] = $defaultorder[$t];
		}
		if (!empty($company[$t.'-order'])) {
			$ar = explode(',',$company[$t.'-order']);
			foreach ($ar as $k) {
				$key = $t.'-'.$k;
				if (empty($company[$key.'-text'])) {
					$company[$key.'-text']	= $defaultscript[$t][$k];
				}
				$nest[$t] .= '
		<li class="dd-item dd3-item dd-location" data-id="'.$key.'" data-pk="'.$company['ID'].'">
			<div class="dd-handle dd3-handle dd-tall"></div>
			<div class="dd3-content dd-tall">
				<div class="row">
				<div class="col-xs-2">
					<b>'.($k != 'idfield' ? $parts[$k] : '<a href="#" data-type="text" data-url="'.site_url('admin/company/set_script').'" data-pk="'.$company['ID'].'" data-name="unitname">'.$company['unitname'].'</a>').'</b><br/>
					Enabled: <input type="checkbox" checked name="'.$key.'"/><br/>
					Count: <span class="'.$key.'-counter">'.strlen($company[$key.'-text']).'</span>
				</div>
				<div class="'.($k == 'idfield' ? 'col-xs-7' : 'col-xs-10').'">
					<a href="#" data-type="text" data-url="'.site_url('admin/company/set_script').'" data-pk="'.$company['ID'].'" data-name="'.$key.'-text">'.$company[$key.'-text'].'</a>
				</div>
				'.($t == 'qr' && $k == 'idfield' ? '
				<div class="col-xs-3">
					Ans: <a href="#" data-type="text" data-url="'.site_url('admin/company/set_script').'" data-pk="'.$company['ID'].'" data-name="'.$key.'-answers">'.$company[$key.'-answers'].'</a>
				</div>
				' : '').'
				</div>
		
			</div>
		</li>
				';
			}
		} else {
			$ar = array();
		}
		foreach ($parts as $k=>$p) {
			if (!in_array($k,$ar)) {
				$key = $t.'-'.$k;
				if (empty($company[$key.'-text'])) {
					$company[$key.'-text']	= $defaultscript[$t][$k];
				}
				$nest[$t] .= '
		<li class="dd-item dd3-item dd-location" data-id="'.$key.'" data-pk="'.$company['ID'].'">
			<div class="dd-handle dd3-handle dd-tall"></div>
			<div class="dd3-content dd-tall">
				<div class="row">
				<div class="col-xs-2">
					<b>'.($k != 'idfield' ? $parts[$k] : '<a href="#" data-type="text" data-url="'.site_url('admin/company/set_script').'" data-pk="'.$company['ID'].'" data-name="unitname">'.$company['unitname'].'</a>').'</b><br/>
					Enabled: <input type="checkbox" name="'.$key.'"/><br/>
					Count: <span class="'.$key.'-counter">'.strlen($company[$key.'-text']).'</span>
				</div>
				<div class="'.($k == 'idfield' ? 'col-xs-7' : 'col-xs-10').'">
					<a href="#" data-type="text" data-url="'.site_url('admin/company/set_script').'" data-pk="'.$company['ID'].'" data-name="'.$key.'-text">'.$company[$key.'-text'].'</a>
				</div>
				'.($t == 'qr' && $k == 'idfield' ? '
				<div class="col-xs-3">
					Ans: <a href="#" data-type="text" data-url="'.site_url('admin/company/set_script').'" data-pk="'.$company['ID'].'" data-name="'.$key.'-answers">'.$company[$key.'-answers'].'</a>
				</div>
				' : '').'
				</div>
		
			</div>
		</li>
				';
			}
		}
	}
	
?>

<div class="fluid-container">
	<?php if (file_exists(UPLOAD_DIR.'logo_'.$company['ID'].'.jpg')) { ?>
	<?php $size = getimagesize(img_url('uploads/logo_'.$company['ID'].'.jpg')); if ($size[1] == 125) { ?>
	<img class="pull-right" height="60px" src="<?php echo img_url('uploads/logo_'.$company['ID'].'.jpg?v='.time()); ?>" alt=""/>
	<?php } else { ?>
	<img class="pull-right" width="150px" src="<?php echo img_url('uploads/logo_'.$company['ID'].'.jpg?v='.time()); ?>" alt=""/>
	<?php } ?>
	<?php } ?>
	<h1><?php echo empty($company) ? "Create" : "Edit"; ?> Script</h1>
	<h4><?php echo $company['name']; ?></h4>

	<div class="row top30">
        <div class="col-xs-12 col-md-8">
		<div class="top30 clearfix"></div>
		<h4>QR Code</h4>
		<div class="dd" id="nestable3">
		    <ol class="dd-list">
		    	<?php echo $nest['qr']; ?>
		    </ol>
		</div>
        </div>
	</div>
	
	<div class="row top30">
        <div class="col-xs-12 col-md-8">
		<div class="top30 clearfix"></div>
		<h4>SMS</h4>
		<p>First message maximum length is 96 because it will have the following additional message: Text HELP for help, text STOP to stop. Msg&Data Rates May Apply.  The last message maximum length is 136 because it will have the following additional message: Msg&Data Rates May Apply.  All other messages have a maximum length of 160.</p>
		<p>If the QR answers for ID Field are not empty, the SMS question will require the user to respond with 1, 2, 3... to indicate the first, second, third... responses.  For example if QR answers are Drive Thru, Dine In, Carry Out.  Then the SMS question should read something like: Enter 1 for Drive Thru, 2 for Dine In, 3 for Carry Out.</p>
		<div class="dd" id="nestable4">
		    <ol class="dd-list">
		    	<?php echo $nest['sms']; ?>
		    </ol>
		</div>
        </div>
	</div>
</div>            
<div class="clearfix"></div>
<script>
	$(function () { 
		var last_edit;
		$('a[data-type=text]').editable({
			success: function(response,val) {
				if (last_edit == 'unitname') {
					$('a[data-name=unitname]').text(val);
				} else {
					$('.'+last_edit.substr(0,last_edit.length-5)+'-counter').text(val.length);
				}
			}
		}).on('click',function(e) {
			last_edit = $(this).attr('data-name');
		});
		
		$('#nestable3').nestable();
		$('#nestable4').nestable();

		$('#nestable3').on('change',function(e,id) {
			var map = $('#nestable3').nestable('serialize');
			var order = '';
			for (var key in map) {
				var id = map[key].id;
				var pk = map[key].pk;
				var qrsms = 'sms-order';
				if (id.substr(0,2) == 'qr') { qrsms = 'qr-order'; }
				if ($('input[name='+id+']:checked').length == 1) {
					if (order != '') { order += ','; }
					if (qrsms == 'qr-order') {
						order += id.substr(3);
					} else {
						order += id.substr(4);
					}
				}
			}
			$.post("<?php echo site_url('admin/company/set_script'); ?>",{pk: pk, name: qrsms, value: order});
		});

		$('#nestable4').on('change',function(e,id) {
			var map = $('#nestable4').nestable('serialize');
			console.log(map);
			var order = '';
			for (var key in map) {
				var id = map[key].id;
				var pk = map[key].pk;
				var qrsms = 'sms-order';
				if (id.substr(0,2) == 'qr') { qrsms = 'qr-order'; }
				if ($('input[name='+id+']:checked').length == 1) {
					if (order != '') { order += ','; }
					if (qrsms == 'qr-order') {
						order += id.substr(3);
					} else {
						order += id.substr(4);
					}
				}
			}
			$.post("<?php echo site_url('admin/company/set_script'); ?>",{pk: pk, name: qrsms, value: order});
		});
	});
</script>
