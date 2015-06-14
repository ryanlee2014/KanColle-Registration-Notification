<?php
ignore_user_abort();//关掉浏览器，PHP脚本也可以继续执行.
set_time_limit(0);// 通过set_time_limit(0)可以让程序无限制的执行下去
$interval=60*30;// 每隔半小时运行
do{
$run = include '../php/config.php';
$trace = include '../php/trace2.php?client=web&ajax=1&r=refresh';    
$url = "http://" . $_SERVER['HTTP_HOST'] . "/php/trace2.php?client=web&ajax=1&r=refresh"; //获取内容
    $ch  = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $contents = curl_exec($ch);
    curl_close($ch);

if(!$run) die('process abort');
 //ToDo 
 sleep($interval);// 等待5分钟
}while(true);
?>