<!doctype HTML>
<html lang="en">
<head>
	<title>Twitter Timeline with API 1.1</title>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="robots" content="index,follow">
	<link rel="stylesheet" href="css/styles.css">
</head>

<body id="remove">
    <div id="tt"></div>
    <div id="time"></div>
	<?php include_once('_includes/twitter.php'); ?>
	
	<footer>
		<a href="https://github.com/kmaida/twitter-timeline-php">twitter-timeline-php</a> on <a href="http://github.com">GitHub</a><br>
		GNU Public License
	</footer>
	
	<!-- jQuery library -->
	<script type="text/javascript" src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
	<!-- Optional: include //code.jquery.com/jquery-migrate-1.2.1.js if IE6/7/8 support is needed -->
	
	<!-- Web Intents for Reply / Retweet / Favorite popup functionality (https://dev.twitter.com/docs/intents) -->
<!--	<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>-->
	<!-- Custom Twitter functions -->
	<script type="text/javascript" src="js/twitter.js"></script>
 <!--<script src="tweetchild.js"></script>-->
</body>
</html>