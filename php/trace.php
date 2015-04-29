<?php 
$url = "http://www.haoyuan.info/twitter/index.php"; //获取内容
global $contents; 
$contents = file_get_contents($url); 
//如果出现中文乱码使用下面代码 
//$getcontent = iconv("gb2312", "utf-8",$contents);
//echo $contents;
?> 
<?php
$notimepart="/：【\d+\/\d+\(\S+\)\】/";//没有小时的正则表达式
$nexttime="/\d+\/\d+\(\S*曜日\)\s*\d+:\d+(?=】)/";//catch all
$li="/\d+\S\d+(?=名】)/";
$comma="/\d+(?=,)\d+/";
$ne=preg_match("/(?:日【)\d+\S+(?:】)\S*(?=に|以)/",$contents,$next);
$nemo=preg_match("/\d+/",$next[0],$nextmonth);
$neda=preg_match("/\d{1,2}(?=\()/",$next[0],$nextdate);
$newe=preg_match("/\S{3}曜日/",$next[0],$nextweekday);
$evti=preg_match("/<p>(?:\S+)(?=イベント)\S+(?:【)(\d+)\S\d+\S+(?:】)(?=\S+)/",$contents,$event_time);
$evti_=preg_match("/\d{1,2}(?=\/)/",$event_time[0],$event_month);
$evti_1=preg_match("/\d{1,2}(?=\()/",$event_time[0],$event_date);
$event_wee=preg_match("/\S{3}曜日/",$event_time[0],$event_weekday);
$count=preg_match($li,$contents,$pe);
$netim=preg_match($nexttime,$contents,$nval);
$ntp=preg_match($notimepart,$contents,$nowtimepart);
$_mon=preg_match("/\d{1,2}/",$nowtimepart[0],$_month);
$_da=preg_match("/\d{1,2}(?=\()/",$nowtimepart[0],$_date);
$_weekd=preg_match("/\S{3}曜日/",$nowtimepart[0],$_weekday);
$text=preg_match($part,$contents,$matches);
$mon=preg_match("/\d+(?=\/)/",$nval[0],$month);
$da=preg_match("/\d{1,2}(?=\()/",$nval[0],$day);
$week=preg_match("/\S{3}曜日/",$nval[0],$weekday);
$ho=preg_match("/\d+(?=:)/",$nval[0],$hour);
$min=preg_match("/\d+$/",$nval[0],$minute);
$people=$pe[0];
//活动设定
$eve=preg_match("/(春|夏|秋|冬)イベント\S+(?:】)/",$contents,$event);
$eventval=$event[0];
$ye=preg_match("/[0-9]{4}/",$eventval,$event_year);
if($event_year[0]=="")
{
	$event_yr="null";
}
else
{
	$event_yr=$event_year[0];
}
$evn=preg_match("/(春|夏|秋|冬)イベント\S+(?:】)(?=は|の|を|、)/",$eventval,$event_name);
if($event_month[0]==""&&$event_date[0]==""&&$event_weekday[0]=="")
{
	$event_m="null";
	$event_d="null";
	$event_w="null";
}
else
{
	$event_m=$event_month[0];
	$event_d=$event_date[0];
	$event_w=$event_weekday[0];
}
if((int)$_month[0]>(int)$month[0])
{
$m=$_month[0];	
$h="null";
$mi="null";
$dat=$_date[0];
$w=$_weekday[0];
}
else if((int)$month[0]==(int)$_month[0])
{
	if((int)$_date[0]>(int)$day[0])
		{
			$m=$_month[0];	
			$h="null";
			$mi="null";
			$dat=$_date[0];
			$w=$_weekday[0];
		}
	else if($_date[0]==$day[0])
		{
			$m=$month[0];
			$dat=$day[0];
			$mi=$minute[0];
			$h=$hour[0];
			$w=$weekday[0];
		}
	else
	{
		$m=$month[0];
		$dat=$day[0];
		$mi=$minute[0];
		$h=$hour[0];
		$w=$weekday[0];
	}
}
if($nextdate[0]=="")
{
	$nextdate[0]="null";
}
if($nextmonth[0]=="")
{
	$nextmonth[0]="null";
}
//如果使用JSON则启动此段
?>
<?php
/*
if($h!="null")
{
$h-=1;	
}
*/
?>
<?php
$client=$_GET["client"];
$help=$_GET["help"];
if($help=="1"&&$client==""||$client==null)
{
	header('Content-Type:text/html; charset=utf-8');
	echo "<html>";
	echo "<head><title>API Help Document</title></head><body>";
	echo "<header align=\"center\"><h1 style=\"align:middle;\">API Document Help file</h1></header><br>\n";
	echo "<p align=\"center\">====================================<br>==&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;==<br>==&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PHP&nbsp;API&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;==<br>==&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;==<br>==&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;==<br>====================================<br></p>";
	echo "<p align=\"center\"This is a help file about how to use the PHP API file <code>trace.php</code><br>\n";
	echo "The val <code>client</code> post the server what your client is.<br>\n";
	echo "if you want to get this page in <code>desktop</code>,the val <code>client=desktop</code><br>\n";
	echo "or if you want to get the JavaScript file in your browser,you can post the val<code>client=web</code>And you can get an complete JavaScript file<br>\n";
	echo "if you want to show this file,you can open this page:<code>trace.php?help=1</code><br></p>\n";
	echo "<footer align=\"center\"><h1>This PHP file is protected by GPLV2 LICENCE.</h1></footer>";
	echo "</body></html>";
}
if($client=="web")
{
header('Content-type: application/x-javascript;charset=utf-8');
echo "var month=new Number();\n";
echo "var date=new Number();\n";
echo "var weekday=new String();\n";
echo "var hour=new Number();\n";
echo "var minute=new Number();\n";
echo "var people=new String();\n";
echo "var event_year=new Number();\n";
echo "var event_name=new String();\n";
echo "var event_month=new Number();\n";
echo "var event_date=new Number();\n";
echo "var event_weekday=new String();\n";
echo "var nextmonth=new Number();\n";
echo "var nextdate=new Number();\n";
echo "var nextweekday=new String()\n";
echo "month=".$m.";\n";
echo "date=".$dat.";\n";
echo "weekday=\"".$w."\";\n";
echo "hour=".$h.";\n";
echo "minute=".$mi.";\n";
echo "people=\"".$people."\";\n";
echo "event_year=".$event_yr.";\n";
echo "event_name=\"".$event_name[0]."\";\n";
echo "event_month=".$event_m.";\n";
echo "event_date=".$event_d.";\n";
echo "event_weekday=\"".$event_w."\";\n";
echo "nextmonth=".$nextmonth[0].";\n";
echo "nextdate=".$nextdate[0].";\n";
echo "nextweekday=\"".$nextweekday[0]."\";";
}
else if($client=="desktop")
{
	header('Content-Type: application/xml; charset=utf-8');
	echo "<document>";   
   	echo "<month>".$m."</month>\n";
	echo "<date>".$dat."</date>\n";
	echo "<weekday>".$w."</weekday>\n";
	echo "<hour>".$h."</hour>\n";
	echo "<minute>".$mi."</minute>\n";
	echo "<people>".$people."</people>\n";
	echo "<event_year>".$event_yr."</event_year>\n";
	echo "<event_name>".$event_name[0]."</event_name>\n";
	echo "<event_month>".$event_m."</event_month>\n";
	echo "<event_date>".$event_d."</event_date>\n";
	echo "<event_weekday>".$event_w."</event_weekday>\n";
	echo "<nextmonth>".$nextmonth[0]."</nextmonth>\n";
	echo "<nextdate>".$nextdate[0]."</nextdate>\n";
	echo "<nextweekday>".$nextweekday[0]."</nextweekday>\n";	
	echo "</document>";
}
else if($client=="json")
{
$arr = array ('month'=>$m,'date'=>$dat,'weekday'=>$w,'hour'=>$h,'minute'=>$mi,'people'=>$people,'event_year'=>$event_yr,'event_name'=>$event_name[0],'event_month'=>$event_m,'event_date'=>$event_d,'event_weekday'=>$event_w,'nextmonth'=>$nextmonth[0],'nextdate'=>$nextdate[0],'nextweekday'=>$nextweekday[0]);
$jsonval=json_encode($arr);
$txt="kancolle={month:\"".$month[0]."\",date:\"".$day[0]."\",weekday:\"".$weekday[0]."\",hour:\"".$hour[0]."\",minute:\"".$minute[0]."\"}";
echo $jsonval;	
}
?>
<?php
/*
$file=fopen("datelog.js","a");
echo fwrite($file,);
fclose($file);
*/
?>
<?php
/*
$dom=new DOMDocument('1.0','UTF-8');
$filename="/xml/timetable.xml";
if(file_exists($filename))
{
$dom->load($filename);
}
else
{
}
*/
?>
