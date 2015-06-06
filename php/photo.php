<?php
//字体大小
	$url = "http://".$_SERVER['HTTP_HOST']."/php/trace2.php?p=month"; //获取内容
	global $contents; 
	$month = file_get_contents($url); 
	$url_2 = "http://".$_SERVER['HTTP_HOST']."/php/trace2.php?p=date";
	$url_3 = "http://".$_SERVER['HTTP_HOST']."/php/trace2.php?p=hour";
	$url_4 = "http://".$_SERVER['HTTP_HOST']."/php/trace2.php?p=minute";
	$date = file_get_contents($url_2);
	$hour = file_get_contents($url_3);
	$minute = file_get_contents($url_4);
	if($hour!="null"&&$minute!="null")
	{
	$contents = "下次抢号的时间是\n".$month."月".$date."日  (北京时间)".$hour.":".$minute."\n\nhttp://www.haoyuan.info/";
	}
	else 
	{
	$contents = "下次抢号的时间是\n".$month."月".$date."日\n\nhttp://www.haoyuan.info/";		
	}
	$h = $_GET['h'];
	$w = $_GET['w'];
	$s = $_GET['s'];
	$angle = $_GET['a'];
	$mode = $_GET['mode'];
	$margin_left=$_GET['margin_l'];
	$margin_right=$_GET['margin_r'];
	if($mode=="normal")
	{
		normal($contents);	
	}
	else if($mode=="large")
	{
		large($contents);	
	}
	else if($mode == "small")
	{
		small($contents);	
	}
	if($angle==""||$angle==null)
	{
		$angle = 0;
	}
	else
	{
	if($margin_left=="")
	{
		$margin_left=30;	
	}
	if($margin_right=="")
	{
		$margin_right=50;	
	}
$size = $s;
//字体类型，本例为宋体
$font ="c:/windows/fonts/simhei.ttf";
//显示的文字
global $text;
$text = $contents;
//创建一个长为500高为80的空白图片
$img = imagecreate($w, $h);
//给图片分配颜色
imagecolorallocate($img, 0xf9, 0xf9, 0xf9);
//设置字体颜色
$black = imagecolorallocate($img, 0, 0, 0);
//将ttf文字写到图片中
imagettftext($img, $size, $angle, $margin_left, $margin_right, $black, $font, $text);
//发送头信息
header('Content-Type: image/png');
//输出图片
imagepng($img);
	}
function small($contents)
{
	$angle = 0;
	$margin_left=15;	
	$margin_right=25;	
	$size = 10;
	$w = 190;
	$h = 85;
//字体类型，本例为宋体
$font ="c:/windows/fonts/simhei.ttf";
//显示的文字
$text = $contents;
//创建一个长为500高为80的空白图片
$img = imagecreate($w, $h);
//给图片分配颜色
imagecolorallocate($img, 0xf9, 0xf9, 0xf9);
//设置字体颜色
$black = imagecolorallocate($img, 0, 0, 0);
//将ttf文字写到图片中
imagettftext($img, $size, $angle, $margin_left, $margin_right, $black, $font, $text);
//发送头信息
header('Content-Type: image/png');
//输出图片
imagepng($img);
}
function normal($contents)
{
	$angle = 0;
	$margin_left=30;	
	$margin_right=50;	
	$size = 20;
	$w = 380;
	$h = 170;
//字体类型，本例为宋体
$font ="c:/windows/fonts/simhei.ttf";
//显示的文字
$text = $contents;
//创建一个长为500高为80的空白图片
$img = imagecreate($w, $h);
//给图片分配颜色
imagecolorallocate($img, 0xf9, 0xf9, 0xf9);
//设置字体颜色
$black = imagecolorallocate($img, 0, 0, 0);
//将ttf文字写到图片中
imagettftext($img, $size, $angle, $margin_left, $margin_right, $black, $font, $text);
//发送头信息
header('Content-Type: image/png');
//输出图片
imagepng($img);
}
function large($contents)
{
	$angle = 0;
	$margin_left=60;	
	$margin_right=100;	
	$size = 40;
	$w = 760;
	$h = 340;
//字体类型，本例为宋体
$font ="c:/windows/fonts/simhei.ttf";
//显示的文字
$text = $contents;
//创建一个长为500高为80的空白图片
$img = imagecreate($w, $h);
//给图片分配颜色
imagecolorallocate($img, 0xf9, 0xf9, 0xf9);
//设置字体颜色
$black = imagecolorallocate($img, 0, 0, 0);
//将ttf文字写到图片中
imagettftext($img, $size, $angle, $margin_left, $margin_right, $black, $font, $text);
//发送头信息
header('Content-Type: image/png');
//输出图片
imagepng($img);
}	
?>