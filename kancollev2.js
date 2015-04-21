var localtimezone;
var d=new Date();
var nowmonth=d.getMonth();
var nowdate=d.getDate();
var nowhour=d.getHours();
var nowminutes=d.getMinutes();
var nowsecond=d.getSeconds();
var txt;
var timezoneminus;
if(hour!=null){
localtimezone=d.getTimezoneOffset()/60;
timezoneminus=-8-localtimezone;
time_hour=Number(time_hour)+timezoneminus;
}
if(localtimezone!=-9)
{
	alert("您的电脑时区不是日本时区，若需要抢号请将电脑时区更改为日本东京时区");
}
var timezone;


if(timezoneminus==0)
{
	timezone="北京时间";
}
else if(timezoneminus==1)
{
	timezone="东京时间";
}
else
{
	timezone="未知时区";
}
if(TimeGo(month,date,hour,minute)==-1)
{	
if(hour==null){
	txt="</br>下次抢号时间为:<h3>"+month+"月"+date+"日&nbsp;&nbsp;("+weekday+")";
	txt+="</br><h3>官方未公开具体的时间</h3>";
	}	
	else{				
	}
var a=document.getElementById("time");
a.innerHTML=txt;
}
else if(TimeGo(month,date,hour,minute)==0)
{
	txt+="</br>本次抢号时间为:<h3>"+month+"月"+date+"日&nbsp;&nbsp;("+weekday+")</br>"+timezone+"&nbsp;"+hour+":"+minute+"</h3></br>放号名额为:<h3>"+people+"名</h3>";
	var a=document.getElementById("time");
	a.innerHTML=txt;
}
else if(TimeGo(month,date,hour,minute)==1)
{
var aa=document.getElementById("time");
aa.innerHTML=txt;

}
a=document.getElementById("footer");
var copyright="<p align=\"center\">抢号时间脚本由<span class=\"bold\">本站</span>提供,判断逻辑由<span class=\"author\">Ryan</span>编写</p>";
a.innerHTML=copyright;
var b=document.getElementById("footer_1");
b.innerHTML="<p align=\"center\">官方推特转发由<span class=\"bold\">本站</span>提供,判断逻辑由<span class=\"author\">Ryan</span>编写</p>";
var t;
//计时器
function timecount()
{
	var g=new Date();
    var now_month=g.getMonth();
	var now_date=g.getDate();
	var now_hour=g.getHours();
	var now_minutes=g.getMinutes();
	var now_second=g.getSeconds();
	var timemonth=month-now_month-1;
	var timedate=date-now_date;
	var timehour;
	if(now_hour>hour)
	{
		timehour=24+hour-now_hour-1;
	}
	else
	{
		timehour=hour-now_hour-1;
	}
	var timemin;
	var timesecond=60-now_second;

	if(now_minutes>minute)
	{
		if(timesecond==0)
		{
			timemin=60+Number(minute)-now_minutes;
		}
		else
		{
		timemin=60+Number(minute)-now_minutes-1;
		}
	}
	else
	{
		if(timesecond==0)
		{
			timemin=minute-now_minutes;
		}
		else
		{
		timemin=Number(minute)-Number(now_minutes)-1;
		}
	}
	var cd=document.getElementById("countdown");
	if(nowhour<hour)
	{
	if(isNaN(timehour))
	{
		cd.innerHTML="<h4>距离抢号时间还有"+timemonth+"月"+timedate+"日</h4>";
	}
	else{
	cd.innerHTML="<h4>距离抢号时间还有"+timemonth+"月"+timedate+"日"+timehour+"小时"+timemin+"分"+timesecond+"秒</h4>";
	}
	t=setTimeout("timecount()",1000);
	}
	}
