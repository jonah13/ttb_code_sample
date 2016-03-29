<?php
	$defaultorder = 'rating,comment,contact,reply';
	$defaultscript = array(
				'rating'=>'How was your experience today?',
				'idfield'=>'Please enter your cab #...',
				//Where did your experience occur? 
				'comment'=>'Tell us more...',
				'contact'=>'If you would like to be contacted...',
				'contest'=>'To be entered in the monthly drawing...',
				'reply'=>'Thank you for your feedback.'
				//Thank you for your feedback. If you entered your email or phone #, we will be contacting you.
				//Thank you for your feedback. If you win the drawing, we will contact you.
				);
				
	if (empty($company['qr-order'])) {
		$company['qr-order'] = $defaultorder;
	}
	
	$ar = explode(',',$company['qr-order']);

	foreach ($ar as $qr) {
		if (empty($company['qr-'.$qr.'-text'])) {
			$company['qr-'.$qr.'-text'] = $defaultscript[$qr];
		}
	}
	
	$variables = array(
		'company_name'=>$company['name'],
		'location_name'=>$location['name'],
		'code'=>$code,
		'date'=>''
		);
		
	$callback_date = create_function('$match', '
		if(empty($match[0]) || empty($match[1])) 
			return date("m/d/y"); 
		else 
			return date("m/d/y", time()+$match[1]*86400);
	');

	foreach ($variables as $k=>$v) {
		foreach ($ar as $qr) {
			if ($k == 'date') {
				$company['qr-'.$qr.'-text'] = preg_replace_callback("#\#date\+([0-9]+)#", $callback_date, $company['qr-'.$qr.'-text']);
			} else {
			    $company['qr-'.$qr.'-text'] = preg_replace('/(\#'.$k.')/s', $v, $company['qr-'.$qr.'-text']);
			}
		}
	}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Customer Feedback | Tell The Boss</title>

    <!-- Sets initial viewport load and disables zooming  -->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- Makes your prototype chrome-less once bookmarked to your phone's home screen -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Set a shorter title for iOS6 devices when saved to home screen -->
    <meta name="apple-mobile-web-app-title" content="Ratchet">

    <!-- Set Apple icons for when prototype is saved to home screen -->

    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo img_url('touch-icons/apple-touch-icon-114x114.png'); ?>">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo img_url('touch-icons/apple-touch-icon-72x72.png'); ?>">
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo img_url('touch-icons/apple-touch-icon-57x57.png'); ?>">


    <!-- Include the compiled Ratchet CSS -->
    <link rel="stylesheet" href="<?php echo css_url('ratchet'); ?>">

    <!-- Include the Font Awesome -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

    <!-- Include the compiled Ratchet JS -->
    <script src="<?php echo js_url('ratchet') ?>"></script>

</head>

<body>

    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
    <div class="content">
    <div class="padded_wrap">
        
<?php if (file_exists(UPLOAD_DIR.'logo_'.$company['ID'].'.jpg')) { ?>
<?php $size = getimagesize(img_url('uploads/logo_'.$company['ID'].'.jpg')); if ($size[1] == 125) { ?>
<img class="brand" height="60px" src="<?php echo img_url('uploads/logo_'.$company['ID'].'.jpg?v='.time()); ?>" alt=""/>
<?php } else { ?>
<img class="brand" width="150px" src="<?php echo img_url('uploads/logo_'.$company['ID'].'.jpg?v='.time()); ?>" alt=""/>
<?php } ?>
<?php } else { ?>
	<p><b><?php echo $company['name']; ?></b></p>
<?php } ?>
        
		<?php echo validation_errors('<a class="btn btn-negative btn-block btn-outlined">','</a>'); ?>

		<form class="feedback" method="post" action="<?php echo site_url('feedback/submit/'.$code); ?>">
            <input name="origin" type="hidden" value="<?php echo $origin; ?>"/>
		
<?php 
	foreach ($ar as $qr) { 
?>

<?php if ($qr == 'rating') { ?>		
            <p><?php echo $company['qr-'.$qr.'-text']; ?></p>
            <input name="rating" type="hidden" value="0"/>
            <div class="rating-container">
                <i class="fa fa-thumbs-down"></i>
                <div class="star">1</div>
                <div class="star">2</div>
                <div class="star">3</div>
                <div class="star">4</div>
                <div class="star">5</div>
                <i class="fa fa-thumbs-up"></i>
            </div>
<?php } else if ($qr == 'idfield') { ?>

  <?php if (!empty($idfieldset)) { // this forces the idfield to a value ?>
        <input name="unit" type="hidden" value="<?php echo $idfieldset; ?>"/>
  <?php } else { ?>
            <p><?php echo $company['qr-'.$qr.'-text']; ?></p>
    <?php if (!empty($company['qr-idfield-answers'])) {
  			$ans = explode(',',$company['qr-idfield-answers']);
  			echo '<select name="unit">';
  			foreach ($ans as $a) {
	  			echo '<option value="'.trim($a).'">'.trim($a).'</option>';
  			}
  			echo '</select>';
  		} else { ?>
            <input name="unit" type="text"/>
    <?php } ?>
  <?php } ?>

<?php } else if ($qr == 'comment') { ?>
            <p><?php echo $company['qr-'.$qr.'-text']; ?></p>
            <textarea name="feedback" rows="3" placeholder="Enter feedback here..."></textarea>
<?php } else if ($qr == 'contact' && !in_array('contest',$ar)) { ?>
            <p><?php echo $company['qr-'.$qr.'-text']; ?></p>
            <input name="contact_info" type="text" placeholder="Enter phone or email...">
<?php } else if ($qr == 'contest' && !in_array('contact',$ar)) { ?>
            <p><?php echo $company['qr-'.$qr.'-text']; ?></p>
            <input name="contest_info" type="text" placeholder="Enter phone or email...">
<?php } else if ($qr == 'contact' && in_array('contest',$ar)) { ?>

	    	<p>
				<input name="contact_cb" type="checkbox"> <?php echo $company['qr-contact-text']; ?>
			<br/>
				<input name="contest_cb" type="checkbox"> <?php echo $company['qr-contest-text']; ?>
	    	</p>
            <input name="contact_contest_info" type="text" placeholder="Enter phone or email...">
<?php } ?>

<?php } ?>
            <a href="#" class="btn btn-positive btn-block">Submit</a>
        </form>
    </div>
    
    <div class="foot">
        <img class="ttb" src="<?php echo img_url('logo_ttb_footer.png') ?>" width="150" height="21" />
    </div>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="<?php echo js_url('jquery-1.10.1.min') ?>"><\/script>')
    </script>

    <script>
        $('.rating-container .star').click(function() {
            $('.rating-container .star').removeClass('active');
            $(this).prevAll('.star').addBack().addClass('active');
            $('input[name=rating]').val($(this).text());
        });
        $('a').click(function(e) {
        	$('form').submit();
	        e.preventDefault();
        });
    </script>



</body>

</html>