<?php 
$url = "http://".$_SERVER['HTTP_HOST']."/twitter/index.php"; //获取内容
global $contents; 
$contents = file_get_contents($url); 
//如果出现中文乱码使用下面代码 
//$getcontent = iconv("gb2312", "utf-8",$contents);
//echo $contents;
?> 
<?php
//功能实现正则
$notimepart="/：【\d+\/\d+\(\S+\)(\S*)\】/";//没有小时的正则表达式
$nexttime="/\d+\/\d+\([\x80-\xff]*(曜)*日\)\s*\d+:\d+(\s*)(?=】)/";//catch all
$li="/\d+\S\d+(?=名】)/";
$comma="/\d+(?=,)\d+/";
$ne=preg_match("/(?:日)*(?:【)\d+\S+(?:】)\S*(?=に|以)/",$contents,$next);
$nemo=preg_match("/\d+/",$next[0],$nextmonth);
$neda=preg_match("/\d{1,2}(?=\()/",$next[0],$nextdate);
$newe=preg_match("/[\x80-\xff]{1,9}(曜)*日/",$next[0],$nextweekday);
$evti=preg_match("/<p>(?:\S+)?(?=イベント)\S+(?:【)(\d+)\S\d+\S+(?:】)(?=\S+)/",$contents,$event_time);
$evti_=preg_match("/\d{1,2}(?=\/)/",$event_time[0],$event_month);
$evti_1=preg_match("/\d{1,2}(?=\()/",$event_time[0],$event_date);
$event_wee=preg_match("/(?![\(\)])[\x80-\xff]{1,5}(曜)*日/",$event_time[0],$event_weekday);
$count=preg_match($li,$contents,$pe);
$netim=preg_match($nexttime,$contents,$nval);
$ntp=preg_match($notimepart,$contents,$nowtimepart);
$_mon=preg_match("/\d{1,2}/",$nowtimepart[0],$_month);
$_da=preg_match("/\d{1,2}(?=\()/",$nowtimepart[0],$_date);
$_weekd=preg_match("/[\x80-\xff]{1,9}?(曜)*日/",$nowtimepart[0],$_weekday);
$text=preg_match($part,$contents,$matches);
$mon=preg_match("/\d+(?=\/)/",$nval[0],$month);
$da=preg_match("/\d{1,2}(?=\()/",$nval[0],$day);
$week=preg_match("/(?![\(\)])[\x80-\xff]{1,9}(曜)*日/",$nval[0],$weekday);
$ho=preg_match("/\d+(?=:)/",$nval[0],$hour);
$min=preg_match("/\d+$/",$nval[0],$minute);
$people=$pe[0];
?>
<?php
//活动设定
$eve=preg_match("/(春|夏|秋|冬)イベント\S+(?:】)/",$contents,$event);
$eventval=$event[0];
$ye=preg_match("/[0-9]{4}/",$eventval,$event_year);
$evend=preg_match("/(?:期間は【)(\S|\s){1,30}(?=】)/",$contents,$event_end);
$evn=preg_match("/(春|夏|秋|冬)イベント\S+(?:】)(?=は|の|を|、)/",$contents,$event_name);
$evnm=preg_match("/\d{1,2}/",$event_end[0],$event_end_month);
$evnd=preg_match("/\d{1,2}(?=\()/",$event_end[0],$event_end_date);
$evew=preg_match("/[\x80-\xff]{1,3}?(曜)*日/",$event_end[0],$event_end_weekday);
if($event_year[0]=="")
{
	$event_yr="null";
}
else
{
	$event_yr=$event_year[0];
}
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
if($event_end_month[0]==""||$event_end_date[0]=="")
{
	$event_end_month[0]="null";
	$event_end_date[0]="null";	
}
?>
<?php
//$_GET参数输出
$client=$_GET["client"];
$help=$_GET["help"];
$val=$_GET["val"];
if($help=="1"&&($client==""||$client==null))
{
	//API Help Document
	header('Content-Type:text/html; charset=utf-8');
	echo "<!doctype html>\n<html>\n";
	echo "<head>\n<title>\nAPI Help Document</title>\n<style>\n";
	echo "code\n {";
	echo "\nbackground-color:#f1f1f1;\n";
	//echo "border:1px groove;";
	echo "border-radius:15px 15px 15px 15px;\n";
	echo "box-shadow: 2px 2px 1px #e1e1e1;\n";
	echo "}\n</style>\n";
	echo "</head>\n<body>\n";
	echo "<header>\n<h1>\nAPI Document Help file\n</h1>\n</header>\n<br>\n";
	echo "<p>====================================<br>\n==&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;==<br>\n==&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PHP&nbsp;API&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;==<br>\n==&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;==<br>\n==&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;==<br>\n====================================<br>\n</p>\n";
	echo "<p>This is a help file about how to use the PHP API file <code>trace.php</code>\n<br>\n";
	echo "The val <code>client</code> post the server what your client is.<br>\n";
	echo "if you want to get this page in <code>XML</code>,the val <code>client=xml</code>\n<br>\n";
	echo "and this is a xml demo:<br>\n";
	echo "
<code>\n<strong>\n&lt;document&gt;<br>
&lt;month&gt;5&lt;/month&gt;<br>
&lt;date&gt;2&lt;/date&gt;<br>
&lt;weekday&gt;土曜日&lt;/weekday&gt;<br>
&lt;hour&gt;18&lt;/hour&gt;<br>
&lt;minute&gt;30&lt;/minute&gt;<br>
&lt;people&gt;5,000&lt;/people&gt;<br>
&lt;event_year&gt;2015&lt;/event_year&gt;<br>
&lt;event_name&gt;春イベント2015：期間限定海域【発令！第十一号作戦】&lt;/event_name&gt;<br>
&lt;event_month&gt;4&lt;/event_month&gt;<br>
&lt;event_date&gt;28&lt;/event_date&gt;<br>
&lt;event_weekday&gt;火曜日&lt;/event_weekday&gt;<br>
&lt;nextmonth&gt;5&lt;/nextmonth&gt;<br>
&lt;nextdate&gt;4&lt;/nextdate&gt;<br>
&lt;nextweekday&gt;祝日&lt;/nextweekday&gt;<br>
&lt;event_end_month&gt;5&lt;/event_end_month&gt;<br>
&lt;event_end_date&gt;18&lt;/event_end_date&gt;<br>
&lt;event_end_weekday&gt;月曜日&lt;/event_end_weekday&gt;<br>
&lt;/document&gt;</strong>\n</code>\n<br>\n";
	echo "or if you want to get the JavaScript file in your browser,you can post the val<code>client=web</code>And you can get an complete JavaScript file<br>\n";
	echo "if you want to show this file,you can open this page:<code>trace.php?help=1</code><br></p>\n";
	echo "<footer>\n<h1>This PHP file is protected by ";
	echo "\n<a href=\"https://github.com/ryanlee2014/KanColle-Registration-Notification/blob/master/LICENCE\" target=\"_blank\">GPLV2 LICENCE</a>\n</h1>\n</footer>\n";
	echo "</body>\n</html>";
}
if($client=="web")
{
	//JavaScript输出
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
echo "var nextweekday=new String();\n";
echo "var event_end_month=new Number();\n";
echo "var event_end_date=new Number();\n";
echo "var event_end_weekday=new String();\n";
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
echo "nextweekday=\"".$nextweekday[0]."\";\n";
echo "event_end_month=".$event_end_month[0].";\n";
echo "event_end_date=".$event_end_date[0].";\n";
echo "event_end_weekday=\"".$event_end_weekday[0]."\";";
}
else if($client=="xml")
{
	//xml输出区域
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
	echo "<event_end_month>".$event_end_month[0]."</event_end_month>\n";
	echo "<event_end_date>".$event_end_date[0]."</event_end_date>\n";
	echo "<event_end_weekday>".$event_end_weekday[0]."</event_end_weekday>\n";	
	echo "</document>";
}
else if($client=="json")
{
	//json输出
header('Content-type: application/json;charset=utf-8;');
$arr = array ('month'=>$m,'date'=>$dat,'weekday'=>$w,'hour'=>$h,'minute'=>$mi,'people'=>$people,'event_year'=>$event_yr,'event_name'=>$event_name[0],'event_month'=>$event_m,'event_date'=>$event_d,'event_weekday'=>$event_w,'nextmonth'=>$nextmonth[0],'nextdate'=>$nextdate[0],'nextweekday'=>$nextweekday[0],'event_end_month'=>$event_end_month[0],'event_end_date'=>$event_end_date[0],'event_end_weekday'=>$event_end_weekday[0]);
$jsonval=json_encode($arr);
//$txt="kancolle={month:\"".$month[0]."\",date:\"".$day[0]."\",weekday:\"".$weekday[0]."\",hour:\"".$hour[0]."\",minute:\"".$minute[0]."\"}";
echo $jsonval;	
}
else if($client==""&&$help==""&&$val!="")
{
	//调试用区域
	header('Content-Type: application/x-javascript;charset=utf-8;');
	if($val=="nextmonth")
	{
		echo "nextmonth=".$nextmonth[0];	
	}	
	if($val=="next")
	{
		echo "String next=".$next[0];;	
	}
	if($val=="nval")
	{
		echo "nval=".$nval[0];;	
	}
	if($val=="root")
	{
		echo $_SERVER['HTTP_HOST'];
	}
	if($val=="eventend")
	{
		echo "event_end=".$event_end[0];	
	}
	if($val=="event_end_month")
	{
		echo "event_end_month=".$event_end_month[0];
	}
	if($val=="event_end_date")
	{
		echo "event_end_date=".$event_end_date[0];
	}
	if($val=="event_end_weekday")
	{
		echo "event_end_weekday=".$event_end_weekday[0];
	}
}
else
{
	//错误区域
	if($help!="1")
	{
	header('Content-Type:text/html; charset=utf-8');
	echo "<html><head><title>参数错误</title></head><body>";
	echo "<p align=\"center\"><h1>您没有返回正确的参数，请参阅<a href=\"trace.php?help=1\">API Document</a>查阅该PHP API使用参数</h1></p></body></html>";	
	}
}

?>
<?php
//数据库
$db=$_GET["db"];
if($db=="1")
{
$db_addr="103.27.176.9:3306";
$db_user="a0311230429";
$db_psw="23201016";
$con=mysql_connect($db_addr,$db_user,$db_psw);
if(!$con)
{
die('Could not connect:'.mysql_error());
}
else
{
	header('Content-Type:text/html;charset=utf-8');
echo "<script>alert(\"succeed\")</script>";	
}
mysql_select_db("a0311230429", $con);
$sql="UPDATE kancolle SET month ='11' where month = ''";
mysql_query($sql,$con);
$result= mysql_query("select * from kancolle where username='Jack' ",$con);
$userInfo = mysql_fetch_assoc($result);
$thismonth=$userInfo["month"];
mysql_close($con);
echo "month:".$thismonth;
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
