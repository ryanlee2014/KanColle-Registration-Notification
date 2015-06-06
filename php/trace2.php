<?php
include_once("../php/function.php");
$ajax=$_GET['ajax'];
$nowtime=getdate();
$nowmonth=$nowtime[mon];
$nowdate=$nowtime[mday];
$nowhours=$nowtime[hours];
$nowminutes=$nowtime[minutes];
$nowyears=$nowtime[year];
$nowtimeplus=isNowtime();
$load_time_xml=new DOMDocument();
$load_time_xml->load("../xml/time_log.xml");
$load_time_root=$load_time_xml->getElementsByTagName('time');
$load_time_root_length=$load_time_root->length-1;
$load_time_root_lastChild=$load_time_root->item($load_time_root_length);
$load_time_month=$load_time_root_lastChild->getElementsByTagName('month')->item(0)->nodeValue;
$load_time_date=$load_time_root_lastChild->getElementsByTagName('date')->item(0)->nodeValue;
$load_time_weekday=$load_time_root_lastChild->getElementsByTagName('weekday')->item(0)->nodeValue;
$load_time_hour=$load_time_root_lastChild->getElementsByTagName('hour')->item(0)->nodeValue;
$load_time_minute=$load_time_root_lastChild->getElementsByTagName('minute')->item(0)->nodeValue;
$load_time_people=$load_time_root_lastChild->getElementsByTagName('people')->item(0)->nodeValue;
$load_time_xml_text=$load_time_xml->saveXML();	
$xml_load_timestamp=new DOMDocument();
$xml_load_timestamp->load("../xml/time_log_part.xml");
$xml_load_timestamp_add=$xml_load_timestamp->getElementsByTagName('times')->item(0);
$xml_load_timestamp_root=$xml_load_timestamp->getElementsByTagName('time');
$xml_load_timestamp_root_length=$xml_load_timestamp_root->length-1;
$xml_load_timestamp_root_lastChild=$xml_load_timestamp_root->item($xml_load_timestamp_root_length);
$xml_load_timestamp_month=$xml_load_timestamp_root_lastChild->getElementsByTagName('month')->item(0)->nodeValue;
$xml_load_timestamp_date=$xml_load_timestamp_root_lastChild->getElementsByTagName('date')->item(0)->nodeValue;
$xml_load_timestamp_weekday=$xml_load_timestamp_root_lastChild->getElementsByTagName('weekday')->item(0)->nodeValue;
$xml_load_timestamp_people=$xml_load_timestamp_root_lastChild->getElementsByTagName('people')->item(0)->nodeValue;
$xml_load_nextdate=new DOMDocument();
$xml_load_nextdate->load("../xml/nextdate.xml");
$xml_load_nextdate_add=$xml_load_nextdate->getElementsByTagName('times')->item(0);
$xml_load_nextdate_root=$xml_load_nextdate->getElementsByTagName('time');
$xml_load_nextdate_length=$xml_load_nextdate_root->length-1;
$xml_load_nextdate_root_lastChild=$xml_load_nextdate_root->item($xml_load_nextdate_length);
$xml_load_nextdate_month=$xml_load_nextdate_root_lastChild->getElementsByTagName('nextmonth')->item(0)->nodeValue;
$xml_load_nextdate_date=$xml_load_nextdate_root_lastChild->getElementsByTagName('nextdate')->item(0)->nodeValue;
$xml_load_nextdate_weekday=$xml_load_nextdate_root_lastChild->getElementsByTagName('nextweekday')->item(0)->nodeValue;
$xml_load_maintenance=new DOMDocument();
$xml_load_maintenance->load("../xml/maintenance.xml");
$xml_laod_maintenance_add=$xml_load_maintenance->getElementsByTagName('maintenances')->item(0);
$xml_load_maintenance_root=$xml_load_maintenance->getElementsByTagName('maintenance');
$xml_load_maintenance_length=$xml_load_maintenance_root->length-1;
$xml_load_maintenance_root_lastChild=$xml_load_maintenance_root->item($xml_load_maintenance_length);
$xml_load_maintenance_month=$xml_load_maintenance_root_lastChild->getElementsByTagName('month')->item(0)->nodeValue;
$xml_load_maintenance_date=$xml_load_maintenance_root_lastChild->getElementsByTagName('date')->item(0)->nodeValue;
$xml_load_maintenance_weekday=$xml_load_maintenance_root_lastChild->getElementsByTagName('weekday')->item(0)->nodeValue;
$valhour="null";
$valminute="null";
$valmonth="null";
$valdate="null";
$valpeople="null";
$valweekday="null";
$valmaintenance_m="null";
$valmaintenance_d="null";
$valmaintenance_w="null";
$valnextmonth=$xml_load_nextdate_month;
$valnextdate=$xml_load_nextdate_date;
$valnextweekday=$xml_load_nextdate_weekday;
if($load_time_month>=$xml_load_timestamp_month&&$load_time_date>=$xml_load_timestamp_date)
{
	$valmonth=$load_time_month;
	$valdate=$load_time_date;
	$valhour=$load_time_hour;
	$valpeople=$load_time_people;
	$valminute=$load_time_minute;
	$valweekday=$load_time_weekday;	
}
else
{
	$valmonth=$xml_load_timestamp_month;
	$valdate=$xml_load_timestamp_date;
	$valweekday=$xml_load_timestamp_weekday;
	$valpeople=$xml_load_timestamp_people;
}
$maintp=time_all($nowyears,$xml_load_maintenance_month,$xml_load_maintenance_date,0,0);
if($maintp>=$nowtimeplus)
{
$valmaintenance_m=$xml_load_maintenance_month;
$valmaintenance_d=$xml_load_maintenance_date;
$valmaintenance_w=$xml_load_maintenance_weekday;	
}
if($nowmonth>$valmonth||($nowmonth==$valmonth&&$nowdate>$valdate))
{
	$func=true;
}
$get=$_GET['get'];
$getCount=$_GET['t'];
if($getCount==""||$getCount==null)
{
$getCount=100;	
}
if($get=="1"||$func||$ajax=="1")
{
	$url = "http://".$_SERVER['HTTP_HOST']."/twitter/index.php?t=".$getCount; //获取内容
	global $contents; 
	$contents = file_get_contents($url); 
	$url_2 = "http://".$_SERVER['HTTP_HOST']."/twitter/index.php?e=next";
	global $next_contents; 
	$next_contents = file_get_contents($url_2);
	$url_3 = "http://".$_SERVER['HTTP_HOST']."/twitter/index.php?e=maintenance";
	global $maintenance;
	$maintenance = file_get_contents($url_3);
	//如果出现中文乱码使用下面代码 
	//$getcontent = iconv("gb2312", "utf-8",$contents);
	//echo $contents;
	//功能实现正则
	$notimepart="/：【\d+\/\d+\(\S+\)(\S*)\】/";//没有小时的正则表达式
	$nexttime="/\d+\/\d+\([\x80-\xff]*(曜)*日\)\s*\d+:\d+(\s*)(?=】)/";//catch all
	$li="/\d+\S\d+(?=名】)/";
	$comma="/\d+(?=,)\d+/";
	#$ne=preg_match("/(?:日)*(?:【)\d+\S+(?:】)\S*(?=に|以)/",$contents,$next);
	$nemo=preg_match("/\d+/",$next_contents,$nextmonth);
	$neda=preg_match("/\d{1,2}(?=\()/",$next_contents,$nextdate);
	$newe=preg_match("/[\x80-\xff]{1,9}(曜)*日/",$next_contents,$nextweekday);
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
	#维护时间
	$mainten_month_flag=preg_match("/\d{1,2}/",$maintenance,$mainten_m);
	$mainten_date_flag=preg_match("/\d{1,2}(?=\()/",$maintenance,$mainten_d);
	$mainten_weekday_flag=preg_match("/[\x80-\xff]{1,9}(曜)*日/",$maintenance,$mainten_w);
	$valmaintenance_m=$mainten_m[0];
	$valmaintenance_d=$mainten_d[0];
	$valmaintenance_w=$mainten_w[0];
	$people=$pe[0];
	//活动设定
	$eve=preg_match("/(春|夏|秋|冬)イベント\S+(?:】)/",$contents,$event);
	$eventval=$event[0];
	$ye=preg_match("/[0-9]{4}/",$eventval,$event_year);
	$evend=preg_match("/(?:期間は【)(\S|\s){1,30}(?=】)/",$contents,$event_end);
	$evn=preg_match("/(春|夏|秋|冬)イベント\S+(?:】)(?=は|の|を|、)/",$contents,$event_name);
	$evnm=preg_match("/\d{1,2}/",$event_end[0],$event_end_month);
	$evnd=preg_match("/\d{1,2}(?=\()/",$event_end[0],$event_end_date);
	$evew=preg_match("/[\x80-\xff]{1,3}?(曜)*日/",$event_end[0],$event_end_weekday);
	$evendf=preg_match("/【([\s\S](?!】))*AM[\S\s]*?】/",$contents,$event_full_end);
	$eventfm=preg_match("/\d{1,2}/",$event_full_end[0],$event_full_month);
	$eventfd=preg_match("/\d{1,2}(?=\()/",$event_full_end[0],$event_full_date);
	$eventfw=preg_match("/[\x80-\xff]{1,3}?(曜)*日/",$event_full_end[0],$event_full_weekday);
	$valnextdate=$nextdate[0];
	$valnextmonth=$nextmonth[0];
	$valnextweekday=$nextweekday[0];
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
}
else
{
	$m=$valmonth;
	$dat=$valdate;
	$w=$valweekday;
	$people=$valpeople;
	$h=$valhour;
	$mi=$valminute;	
}
	$load_event_xml=new DOMDocument();
	$load_event_xml->load("../xml/event_file.xml");
	$load_event_xml_length=$load_event_xml->getElementsByTagName('event')->length-1;
	$load_event_xml_lastChild=$load_event_xml->getElementsByTagName('event')->item($load_event_xml_length);
	$load_event_year=$load_event_xml_lastChild->getElementsByTagName('event_year');
	$load_event_month=$load_event_xml_lastChild->getElementsByTagName('event_month');
	$load_event_date=$load_event_xml_lastChild->getElementsByTagName('event_date');
	$load_event_name=$load_event_xml_lastChild->getElementsByTagName('event_name');
	$load_event_weekday=$load_event_xml_lastChild->getElementsByTagName('event_weekday');
	$load_event_end_month=$load_event_xml_lastChild->getElementsByTagName('event_end_month');
	$load_event_end_date=$load_event_xml_lastChild->getElementsByTagName('event_end_date');
	$load_event_end_weekday=$load_event_xml_lastChild->getElementsByTagName('event_end_weekday');
	$load_event_year_textnode=$load_event_year->item(0)->nodeValue;
	$load_event_month_textnode=$load_event_month->item(0)->nodeValue;
	$load_event_date_textnode=$load_event_date->item(0)->nodeValue;
	$load_event_name_textnode=$load_event_name->item(0)->nodeValue;
	$load_event_weekday_textnode=$load_event_weekday->item(0)->nodeValue;
	$load_event_end_month_textnode=$load_event_end_month->item(0)->nodeValue;
	$load_event_end_date_textnode=$load_event_end_date->item(0)->nodeValue;
	$load_event_end_weekday_textnode=$load_event_end_weekday->item(0)->nodeValue;
	$load_event_xml_text=$load_event_xml->saveXML();
	//判断机制
	if($event_name[0]=="")
	{
		$event_name[0]=$load_event_name_textnode;	
	}
	if($event_year[0]=="")
	{
		$event_yr=$load_event_year_textnode;
	}
	else
	{
		$event_yr=$event_year[0];
	}
	if($event_month[0]==""&&$event_date[0]==""&&$event_weekday[0]=="")
	{
		$event_m=$load_event_month_textnode;
		$event_d=$load_event_date_textnode;
		$event_w=$load_event_weekday_textnode;
	}
	else if($event_month[0]==$event_end_month[0])
	{
		$event_m=$load_event_month_textnode;
		$event_d=$load_event_date_textnode;
		$event_w=$load_event_weekday_textnode;	
	}
	else if($event_month[0]=="null"||$event_date[0]=="null")
	{
		$event_m=$load_event_month_textnode;
		$event_d=$load_event_date_textnode;
		$event_w=$load_event_weekday_textnode;	
	}
	else
	{
		$event_m=$event_month[0];
		$event_d=$event_date[0];
		$event_w=$event_weekday[0];
	}
	if($nextdate[0]==""||$nextdate[0]>31||$nextdate[0]<1)
	{
		$nextdate[0]="null";
	}
	if($nextmonth[0]==""||$nextmonth[0]>12||$nextmonth[0]<1)
	{
		$nextmonth[0]="null";
	}
	if($event_end_month[0]==""||$event_end_date[0]=="")
	{
		$event_end_month[0]=$load_event_end_month_textnode;
		$event_end_date[0]=$load_event_end_date_textnode;
		$event_end_weekday[0]=$load_event_end_weekday_textnode;	
	}
	if($nowdate<$xml_load_nextdate)
	{
	$nextdate[0]=$xml_load_nextdate_date;
	$nextmonth[0]=$xml_load_nextdate_month;
	$nextweekday[0]=$xml_load_nextdate_weekday;
	}
//活动文件写入
if(!is_file("../xml/event_file.xml"))
{
$event_xml=new DOMDocument();
$event_xml->formatOutput=true;
$root=$event_xml->createElement('event');
$root=$event_xml->appendChild($root);
$xml_event_year=$event_xml->createElement('event_year');
$xml_event_year=$root->appendChild($xml_event_year);
$xml_event_year_textnode=$event_xml->createTextNode($event_yr);
$xml_event_year_textnode=$xml_event_year->appendChild($xml_event_year_textnode);
$xml_event_month=$event_xml->createElement('event_month');
$xml_event_month=$root->appendChild($xml_event_month);
$xml_event_month_textnode=$event_xml->createTextNode($event_m);
$xml_event_month_textnode=$xml_event_month->appendChild($xml_event_month_textnode);
$xml_event_date=$event_xml->createElement('event_date');
$xml_event_date=$root->appendChild($xml_event_date);
$xml_event_date_textnode=$event_xml->createTextNode($event_d);
$xml_event_date_textnode=$xml_event_date->appendChild($xml_event_date_textnode);
$xml_event_name=$event_xml->createElement('event_name');
$xml_event_name=$root->appendChild($xml_event_name);
$xml_event_name_textnode=$event_xml->createTextNode($event_name[0]);
$xml_event_name_textnode=$xml_event_name->appendChild($xml_event_name_textnode);
$xml_event_weekday=$event_xml->createElement('event_weekday');
$xml_event_weekday=$root->appendChild($xml_event_weekday);
$xml_event_weekday_textnode=$event_xml->createTextNode($event_w);
$xml_event_weekday_textnode=$xml_event_weekday->appendChild($xml_event_weekday_textnode);
$xml_event_end_month=$event_xml->createElement('event_end_month');
$xml_event_end_month=$root->appendChild($xml_event_end_month);
$xml_event_end_month_textnode=$event_xml->createTextNode($event_end_month[0]);
$xml_event_end_month_textnode=$xml_event_end_month->appendChild($xml_event_end_month_textnode);
$xml_event_end_date=$event_xml->createElement('event_end_date');
$xml_event_end_date=$root->appendChild($xml_event_end_date);
$xml_event_end_date_textnode=$event_xml->createTextNode($event_end_date[0]);
$xml_event_end_date_textnode=$xml_event_end_date->appendChild($xml_event_end_date_textnode);
$xml_event_end_weekday=$event_xml->createElement('event_end_weekday');
$xml_event_end_weekday=$root->appendChild($xml_event_end_weekday);
$xml_event_end_weekday_textnode=$event_xml->createTextNode($event_end_weekday[0]);
$xml_event_end_weekday_textnode=$xml_event_end_weekday->appendChild($xml_event_end_weekday_textnode);
$xmlfile=$event_xml->saveXML();
if($event_name[0]!=""&&$event_month!=$event_end_month[0]&&$event_end_month[0]!="null")
{
$file=fopen("../xml/event_file.xml","w");
fwrite($file,$xmlfile);
fclose($file);
}
}
else
{
if($event_name[0]!=""&&$event_month!=$event_end_month[0]&&$event_end_month[0]!="null")
{
$xml_event_file=new DOMDocument();
$xml_event_file->load("../xml/event_file.xml");
$xml_event_file_root=$xml_event_file->getElementsByTagName('events')->item(0);
$xml_event_file_appendChild=$xml_event_file->createElement('event');
$xml_event_file_appendChild=$xml_event_file_root->appendChild($xml_event_file_appendChild);
$xml_event_file_appendChild_year=$xml_event_file->createElement('event_year');
$xml_event_file_appendChild_year=$xml_event_file_appendChild->appendChild($xml_event_file_appendChild_year);
$xml_event_file_appendChild_year_textnode=$xml_event_file->createTextNode($event_yr);
$xml_event_file_appendChild_year_textnode=$xml_event_file_appendChild_year->appendChild($xml_event_file_appendChild_year_textnode);
$xml_event_file_appendChild_month=$xml_event_file->createElement('event_month');
$xml_event_file_appendChild_month=$xml_event_file_appendChild->appendChild($xml_event_file_appendChild_month);
$xml_event_file_appendChild_month_textnode=$xml_event_file->createTextNode($event_m);
$xml_event_file_appendChild_month_textnode=$xml_event_file_appendChild_month->appendChild($xml_event_file_appendChild_month_textnode);
$xml_event_file_appendChild_date=$xml_event_file->createElement('event_date');
$xml_event_file_appendChild_date=$xml_event_file_appendChild->appendChild($xml_event_file_appendChild_date);
$xml_event_file_appendChild_date_textnode=$xml_event_file->createTextNode($event_d);
$xml_event_file_appendChild_date_textnode=$xml_event_file_appendChild_date->appendChild($xml_event_file_appendChild_date_textnode);
$xml_event_file_appendChild_name=$xml_event_file->createElement('event_name');
$xml_event_file_appendChild_name=$xml_event_file_appendChild->appendChild($xml_event_file_appendChild_name);
$xml_event_file_appendChild_name_textnode=$xml_event_file->createTextNode($event_name[0]);
$xml_event_file_appendChild_name_textnode=$xml_event_file_appendChild_name->appendChild($xml_event_file_appendChild_name_textnode);
$xml_event_file_appendChild_weekday=$xml_event_file->createElement('event_weekday');
$xml_event_file_appendChild_weekday=$xml_event_file_appendChild->appendChild($xml_event_file_appendChild_weekday);
$xml_event_file_appendChild_weekday_textnode=$xml_event_file->createTextNode($event_w);
$xml_event_file_appendChild_weekday_textnode=$xml_event_file_appendChild_weekday->appendChild($xml_event_file_appendChild_weekday_textnode);
$xml_event_file_appendChild_end_month=$xml_event_file->createElement('event_end_month');
$xml_event_file_appendChild_end_month=$xml_event_file_appendChild->appendChild($xml_event_file_appendChild_end_month);
$xml_event_file_appendChild_end_month_textnode=$xml_event_file->createTextNode($event_end_month[0]);
$xml_event_file_appendChild_end_month_textnode=$xml_event_file_appendChild_end_month->appendChild($xml_event_file_appendChild_end_month_textnode);
$xml_event_file_appendChild_end_date=$xml_event_file->createElement('event_end_date');
$xml_event_file_appendChild_end_date=$xml_event_file_appendChild->appendChild($xml_event_file_appendChild_end_date);
$xml_event_file_appendChild_end_date_textnode=$xml_event_file->createTextNode($event_end_date[0]);
$xml_event_file_appendChild_end_date_textnode=$xml_event_file_appendChild_end_date->appendChild($xml_event_file_appendChild_end_date_textnode);
$xml_event_file_appendChild_end_weekday=$xml_event_file->createElement('event_end_weekday');
$xml_event_file_appendChild_end_weekday=$xml_event_file_appendChild->appendChild($xml_event_file_appendChild_end_weekday);
$xml_event_file_appendChild_end_weekday_textnode=$xml_event_file->createTextNode($event_end_weekday[0]);
$xml_event_file_appendChild_end_weekday_textnode=$xml_event_file_appendChild_end_weekday->appendChild($xml_event_file_appendChild_end_weekday_textnode);
$xml_event_file->save("../xml/event_file.xml");
}
}
$xml_get=$_GET['xml'];
if($xml_get=="2")
{
	header('Content-Type:application/xml;charset=utf-8');
	echo $load_event_xml->saveXML();
}
if($xml_get=="3")
{
	header('Content-Type:application/x-javascript;charset=utf-8');
	echo $load_event_year_textnode."\n";
	echo $load_event_month_textnode."\n";
	echo $load_event_date_textnode."\n";
	echo $load_event_name_textnode;	
}
//$event_xml=new DOMDocument();
//$event_xml->load(
?>
<?php
//$_GET参数输出
$client=$_GET["client"];
$help=$_GET["help"];
$val=$_GET["val"];
$test=$_GET['test'];
if($help=="1"&&($client==""||$client==null))
{
	//API Help Document
	header('Access-Control-Allow-Origin:*');
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
header('Access-Control-Allow-Origin:*');
header('Content-type: application/x-javascript;charset=utf-8');
/*if($ajax!="1")
{
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
}*/
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
echo "nextmonth=".$valnextmonth.";\n";
echo "nextdate=".$valnextdate.";\n";
echo "nextweekday=\"".$valnextweekday."\";\n";
echo "event_end_month=".$event_end_month[0].";\n";
echo "event_end_date=".$event_end_date[0].";\n";
echo "event_end_weekday=\"".$event_end_weekday[0]."\";\n";
echo "maintenance_m=".$valmaintenance_m.";\n";
echo "maintenance_d=".$valmaintenance_d.";\n";
echo "maintenance_w=\"".$valmaintenance_w."\";";
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
	echo "<nextmonth>".$valnextmonth."</nextmonth>\n";
	echo "<nextdate>".$valnextdate."</nextdate>\n";
	echo "<nextweekday>".$valnextweekday."</nextweekday>\n";
	echo "<event_end_month>".$event_end_month[0]."</event_end_month>\n";
	echo "<event_end_date>".$event_end_date[0]."</event_end_date>\n";
	echo "<event_end_weekday>".$event_end_weekday[0]."</event_end_weekday>\n";
	echo "<maintenance_m>".$mainten_m[0]."</maintenance_m>";
	echo "<maintenance_d>=".$mainten_d[0]."</maintenance_d>";
	echo "<maintenance_w>".$mainten_w[0]."</maintenance_w>";	
	echo "</document>";
}
else if($client=="json")
{
	//json输出
header('Content-type: application/json;charset=utf-8;');
$arr = array ('month'=>$m,'date'=>$dat,'weekday'=>$w,'hour'=>$h,'minute'=>$mi,'people'=>$people,'event_year'=>$event_yr,'event_name'=>$event_name[0],'event_month'=>$event_m,'event_date'=>$event_d,'event_weekday'=>$event_w,'nextmonth'=>$nextmonth[0],'nextdate'=>$nextdate[0],'nextweekday'=>$nextweekday[0],'event_end_month'=>$event_end_month[0],'event_end_date'=>$event_end_date[0],'event_end_weekday'=>$event_end_weekday[0],'nextmonth'=>$valnextmonth,'nextdate'=>$valnextdate,'nextweekday'=>$valnextweekday);
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
	#if($val="maintenance")
	#{
	#	header('Content-Type:application/x-javascript;charset=utf-8');
	#	$twitter=new DOMDocument();
	#	$twitter->load("../twitter/index.php?t=100");
	#	echo $twitter->saveXML();
	#}
	if($val=="next")
	{
		echo "String next=".$next_contents;	
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
	if($val=="fullend")
	{
		echo "event_full_end=".$event_full_end[0];	
	}
}
else
{
	//错误区域
	if($help!="1"&&$test!="1"&&$get!="1"&&$ajax==""&&$_GET['p']=="")
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
//log every time
if(!is_file("../xml/time_log.xml"))
{
	$xml_file=new DOMDocument();
	$xml_root=$xml_file->createElement('times');
	$xml_root=$xml_file->appendChild($xml_root);
	$xml_time=$xml_file->createElement('time');
	$xml_time=$xml_root->appendChild($xml_time);
	$xml_month=$xml_file->createElement('month');
	$xml_month=$xml_time->appendChild($xml_month);
	$xml_date=$xml_file->createElement('date');
	$xml_date=$xml_time->appendChild($xml_date);
	$xml_weekday=$xml_file->createElement('weekday');
	$xml_weekday=$xml_time->appendChild($xml_weekday);
	$xml_people=$xml_file->createElement('people');
	$xml_people=$xml_time->appendChild($xml_people);
	$xml_hour=$xml_file->createElement('hour');
	$xml_hour=$xml_time->appendChild($xml_hour);
	$xml_minute=$xml_file->createElement('minute');
	$xml_minute=$xml_time->appendChild($xml_minute);	
	$xml_month_textnode=$xml_file->createTextNode($m);
	$xml_month_textnode=$xml_month->appendChild($xml_month_textnode);
	$xml_date_textnode=$xml_file->createTextNode($dat);
	$xml_date_textnode=$xml_date->appendChild($xml_date_textnode);
	$xml_weekday_textnode=$xml_file->createTextNode($w);
	$xml_weekday_textnode=$xml_weekday_textnode->appendChild($xml_weekday_textnode);
	$xml_people_textnode=$xml_file->createTextNode($people);
	$xml_people_textnode=$xml_people->appendChild($xml_people_textnode);
	$xml_hour_textnode=$xml_file->createTextNode($h);		
	$xml_hour_textnode=$xml_hour->appendChild($xml_hour_textnode);
	$xml_minute_textnode=$xml_file->createTextNode($mi);
	$xml_minute_textnode=$xml_minute->appendChild($xml_minute_textnode);
	$xml_file->save("../xml/time_log.xml");
	if($_GET['xml']=="4"&&$_GET['test']=="1")
	{
		header('Content-Type:application/xml;charset=utf-8');
		echo $xml_file->saveXML();
	}
}
else
{
	$xml_load_time=new DOMDocument();
	$xml_load_time->load("../xml/time_log.xml");
	$load_this_root=$xml_load_time->getElementsByTagName('times')->item(0);
	$load_root=$xml_load_time->getElementsByTagName('time');
	$load_root_item=$load_root->length-1;
	$load_root_lastChild=$load_root->item($load_root_item);
	$load_month=$load_root_lastChild->getElementsByTagName('month')->item(0)->nodeValue;
	$load_date=$load_root_lastChild->getElementsByTagName('date')->item(0)->nodeValue;
	$load_weekday=$load_root_lastChild->getElementsByTagName('weekday')->item(0)->nodeValue;
	$load_hour=$load_root_lastChild->getElementsByTagName('hour')->item(0)->nodeValue;
	$load_minute=$load_root_lastChild->getElementsByTagName('minute')->item(0)->nodeValue;
	$load_people=$load_root_lastChild->getElementsByTagName('people')->item(0)->nodeValue;
}	
if(!is_file("../xml/maintenance.xml"))
{
	$xml_maintenance = new DOMDocument();
	$xml_maintenance->formatOutput=true;
	$xml_maintenance_root = $xml_maintenance->createElement('maintenances');
	$xml_maintenance_root = $xml_maintenance->appendChild($xml_maintenance_root);
	$xml_maintenance_root_child = $xml_maintenance->createElement('maintenance');
	$xml_maintenance_root_child = $xml_maintenance_root->appendChild($xml_maintenance_root_child);	
	$xml_maintenance_month = $xml_maintenance->createElement('month');
	$xml_maintenance_date = $xml_maintenance->createElement('date');
	$xml_maintenance_weekday = $xml_maintenance->createElement('weekday');
	$xml_maintenance_month_textnode = $xml_maintenance->createTextNode($valmaintenance_m);
	$xml_maintenance_date_textnode = $xml_maintenance->createTextNode($valmaintenance_d);
	$xml_maintenance_weekday_textnode = $xml_maintenance->createTextNode($valmaintenance_w);
	$xml_maintenance_month_textnode = $xml_maintenance_month->appendChild($xml_maintenance_month_textnode);
	$xml_maintenance_date_textnode = $xml_maintenance_date->appendChild($xml_maintenance_date_textnode);
	$xml_maintenance_weekday_textnode = $xml_maintenance_weekday->appendChild($xml_maintenance_weekday_textnode);
	$xml_maintenance_month = $xml_maintenance_root_child->appendChild($xml_maintenance_month);
	$xml_maintenance_date = $xml_maintenance_root_child->appendChild($xml_maintenance_date);
	$xml_maintenance_weekday = $xml_maintenance_root_child->appendChild($xml_maintenance_weekday);
	$xml_maintenance->save("../xml/maintenance.xml");
}		
	if($mi!="null"&&$h!="null")
	{
		if($load_date!=$dat&&$m!=""&&$dat!="")
		{
			$load_appendChild_root=$xml_load_time->createElement('time');
			$load_appendChild_root=$load_this_root->appendChild($load_appendChild_root);
			$load_appendChild_month=$xml_load_time->createElement('month');
			$load_appendChild_month=$load_appendChild_root->appendChild($load_appendChild_month);
			$load_appendChild_month_textnode=$xml_load_time->createTextNode($m);
			$load_appendChild_month_textnode=$load_appendChild_month->appendChild($load_appendChild_month_textnode);
			$load_appendChild_date=$xml_load_time->createElement('date');
			$load_appendChild_date=$load_appendChild_root->appendChild($load_appendChild_date);
			$load_appendChild_date_textnode=$xml_load_time->createTextNode($dat);
			$load_appendChild_date_textnode=$load_appendChild_date->appendChild($load_appendChild_date_textnode);
			$load_appendChild_weekday=$xml_load_time->createElement('weekday');
			$load_appendChild_weekday=$load_appendChild_root->appendChild($load_appendChild_weekday);
			$load_appendChild_weekday_textnode=$xml_load_time->createTextNode($w);
			$load_appendChild_weekday_textnode=$load_appendChild_weekday->appendChild($load_appendChild_weekday_textnode);
			$load_appendChild_people=$xml_load_time->createElement('people');
			$load_appendChild_people=$load_appendChild_root->appendChild($load_appendChild_people);
			$load_appendChild_people_textnode=$xml_load_time->createTextNode($people);
			$load_appendChild_people_textnode=$load_appendChild_people->appendChild($load_appendChild_people_textnode);
			$load_appendChild_hour=$xml_load_time->createElement('hour');
			$load_appendChild_hour=$load_appendChild_root->appendChild($load_appendChild_hour);
			$load_appendChild_hour_textnode=$xml_load_time->createTextNode($h);
			$load_appendChild_hour_textnode=$load_appendChild_hour->appendChild($load_appendChild_hour_textnode);
			$load_appendChild_minute=$xml_load_time->createElement('minute');
			$load_appendChild_minute=$load_appendChild_root->appendChild($load_appendChild_minute);
			$load_appendChild_minute_textnode=$xml_load_time->createTextNode($mi);
			$load_appendChild_minute_textnode=$load_appendChild_minute->appendChild($load_appendChild_minute_textnode);		
			$xml_load_time->save('../xml/time_log.xml');			
		}
if($_GET['xml']=="5"&&$_GET['test']=="1")
{
	header('Content-Type:application/xml;charset=utf-8');
	echo $xml_load_time->saveXML();	
}
}
if($h=="null"&&$mi=="null")
{
	if($xml_load_timestamp_date!=$dat&&$_GET['r']=="refresh")
	{
		$xml_timestamp_appendChild_root=$xml_load_timestamp->createElement('time');
		$xml_timestamp_appendChild_root=$xml_load_timestamp_add->appendChild($xml_timestamp_appendChild_root);
		$xml_timestamp_appendChild_month=$xml_load_timestamp->createElement('month');
		$xml_timestamp_appendChild_date=$xml_load_timestamp->createElement('date');
		$xml_timestamp_appendChild_weekday=$xml_load_timestamp->createElement('weekday');
		$xml_timestamp_appendChild_people=$xml_load_timestamp->createElement('people');
		$xml_timestamp_appendChild_month=$xml_timestamp_appendChild_root->appendChild($xml_timestamp_appendChild_month);
		$xml_timestamp_appendChild_date=$xml_timestamp_appendChild_root->appendChild($xml_timestamp_appendChild_date);
		$xml_timestamp_appendChild_weekday=$xml_timestamp_appendChild_root->appendChild($xml_timestamp_appendChild_weekday);
		$xml_timestamp_appendChild_people=$xml_timestamp_appendChild_root->appendChild($xml_timestamp_appendChild_people);
		$xml_timestamp_appendChild_month_textnode=$xml_load_timestamp->createTextNode($m);
		$xml_timestamp_appendChild_month_textnode=$xml_timestamp_appendChild_month->appendChild($xml_timestamp_appendChild_month_textnode);
		$xml_timestamp_appendChild_date_textnode=$xml_load_timestamp->createTextNode($dat);
		$xml_timestamp_appendChild_date_textnode=$xml_timestamp_appendChild_date->appendChild($xml_timestamp_appendChild_date_textnode);
		$xml_timestamp_appendChild_weekday_textnode=$xml_load_timestamp->createTextNode($w);
		$xml_timestamp_appendChild_weekday_textnode=$xml_timestamp_appendChild_weekday->appendChild($xml_timestamp_appendChild_weekday_textnode);
		$xml_timestamp_appendChild_people_textnode=$xml_load_timestamp->createTextNode($people);
		$xml_timestamp_appendChild_people_textnode=$xml_timestamp_appendChild_people->appendChild($xml_timestamp_appendChild_people_textnode);
		$xml_load_timestamp->save("../xml/time_log_part.xml");
		} 
}
$mainp=time_all($nowyears,$valmaintenance_m,$valmaintenance_d,0,0);
if($mainp>$maintp)
{
	$xml_plus_maintenance=$xml_load_maintenance->createElement('maintenance');
	$xml_plus_maintenance=$xml_laod_maintenance_add->appendChild($xml_plus_maintenance);
	$xml_plus_maintenance_month=$xml_load_maintenance->createElement('month');
	$xml_plus_maintenance_date=$xml_load_maintenance->createElement('date');
	$xml_plus_maintenance_weekday=$xml_load_maintenance->createElement('weekday');
	$xml_plus_maintenance_month_textnode=$xml_load_maintenance->createTextNode($valmaintenance_m);
	$xml_plus_maintenance_date_textnode=$xml_load_maintenance->createTextNode($valmaintenance_d);
	$xml_plus_maintenance_weekday_textnode=$xml_load_maintenance->createTextNode($valmaintenance_w);
	$xml_plus_maintenance_date_textnode=$xml_plus_maintenance_date->appendChild($xml_plus_maintenance_date_textnode);
	$xml_plus_maintenance_month_textnode=$xml_plus_maintenance_month->appendChild($xml_plus_maintenance_month_textnode);
	$xml_plus_maintenance_weekday_textnode=$xml_plus_maintenance_weekday->appendChild($xml_plus_maintenance_weekday_textnode);
	$xml_plus_maintenance_month=$xml_plus_maintenance->appendChild($xml_plus_maintenance_month);
	$xml_plus_maintenance_date=$xml_plus_maintenance->appendChild($xml_plus_maintenance_date);
	$xml_plus_maintenance_weekday=$xml_plus_maintenance->appendChild($xml_plus_maintenance_weekday);
	$xml_load_maintenance->save("../xml/maintenance.xml");
}
if($_GET['r']=="refresh"&&$xml_load_nextdate_date!=$nextdate[0]&&$nextdate[0]!=""&&$nextdate[0]!=null)
{
$xml_load_nextdate_append=$xml_load_nextdate->createElement('time');
$xml_load_nextdate_append_month=$xml_load_nextdate->createElement('nextmonth');
$xml_load_nextdate_append_date=$xml_load_nextdate->createElement('nextdate');
$xml_load_nextdate_append_weekday=$xml_load_nextdate->createElement('nextweekday');
$xml_load_nextdate_append=$xml_load_nextdate_add->appendChild($xml_load_nextdate_append);
$xml_load_nextdate_append_month=$xml_load_nextdate_append->appendChild($xml_load_nextdate_append_month);
$xml_load_nextdate_append_month_textnode=$xml_load_nextdate->createTextNode($nextmonth[0]);
$xml_load_nextdate_append_month_textnode=$xml_load_nextdate_append_month->appendChild($xml_load_nextdate_append_month_textnode);
$xml_load_nextdate_append_date=$xml_load_nextdate_append->appendChild($xml_load_nextdate_append_date);
$xml_load_nextdate_append_date_textnode=$xml_load_nextdate->createTextNode($nextdate[0]);
$xml_load_nextdate_append_date_textnode=$xml_load_nextdate_append_date->appendChild($xml_load_nextdate_append_date_textnode);
$xml_load_nextdate_append_weekday=$xml_load_nextdate_append->appendChild($xml_load_nextdate_append_weekday);
$xml_load_nextdate_append_weekday_textnode=$xml_load_nextdate->createTextNode($nextweekday[0]);
$xml_load_nextdate_append_weekday_textnode=$xml_load_nextdate_append_weekday->appendChild($xml_load_nextdate_append_weekday_textnode);
$xml_load_nextdate->save("../xml/nextdate.xml");
}
?>
<?php
?>
<?php
if($_GET['p']=="month")
{
	echo $m;	
}
if($_GET['p']=="date")
{
	echo $dat;	
}
if($_GET['p']=="hour")
{
	echo $h;	
}
if($_GET['p']=="minute")
{
	echo $mi;	
}
if($_GET['p']=="weekday")
{
	echo Convert($w);	
}
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