<?php 
$flag=false;
if($_GET['e']=="")
{
	$flag=true;	
}
if($_GET['test']==1)
{
	$flag=false;	
}
if($flag)
{
?>
<!doctype HTML>
<html lang="en">
<head>
	<title>Twitter Timeline with API 1.1</title>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="">
	<meta name="keywords" content="">
    <link rel="stylesheet" href="css/styles.css" />
   	<meta name="robots" content="index,follow">
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="js/twitter.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
    <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body id="remove">
<?php
}
?>
<?php include_once('_includes/twitter.php'); ?>
<?php
	if($flag)
	{
?>
	<footer>
		<a style="font-family:微软雅黑,黑体" href="https://github.com/kmaida/twitter-timeline-php">twitter-timeline-php</a> on <a href="http://github.com">GitHub</a><br>
		GNU Public License
	</footer>
	<!-- jQuery library -->
	<!-- Optional: include //code.jquery.com/jquery-migrate-1.2.1.js if IE6/7/8 support is needed -->
	
	<!-- Web Intents for Reply / Retweet / Favorite popup functionality (https://dev.twitter.com/docs/intents) -->
<!--	<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>-->
	<!-- Custom Twitter functions -->
 <!--<script src="tweetchild.js"></script>-->
</body>
</html>
<?php
	}
?>	