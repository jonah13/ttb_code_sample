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
        
		<p>Page Not Found</p>
		<p>The page you're requesting doesn't exist, check that you've entred the link correctly, or that the code you're using is the right one. If you believe you're seeing this by mistake, please <a href="<?php echo site_url('contact'); ?>" >contact us</a>.</p>
    </div>
    
    <div class="foot">
        <img class="ttb" src="<?php echo img_url('logo_ttb_footer.png') ?>" width="150" height="21" />
    </div>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="<?php echo js_url('jquery-1.10.1.min') ?>"><\/script>')
    </script>

</body>

</html>
