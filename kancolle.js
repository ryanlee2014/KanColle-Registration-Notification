var x=document.getElementsByTagName("p");
var start=x[0].firstChild.nodeValue;
var end=x[0].lastChild.nodeValue;
var line=start.indexOf("/");
var month;
var date;
var localtimezone;

for(i=0;i<line;i++)
{
	if(i==0)
	  {
		month=start.charAt(i);
	}
	else
	{
		month+=start.charAt(i);
		
	}
}
for(i=line+1;i<start.length;i++)
{
	if(start.charAt(i)=="(")
	{
		break;
	}
	if(i==line+1)
	{
		date=start.charAt(i);
	}
	else
	{
		date+=start.charAt(i);
	}
}
var weekday;
for(i=start.indexOf("星");i<start.length;i++)
{
	if(start.charAt(i)==")")
	{
		break;
	}
	if(i==start.indexOf("星"))
	{
		weekday=start.charAt(i);
	}
	else
	{
		weekday+=start.charAt(i);
	}
}
var time_hour;
if(Number(start.indexOf(")"))+1==start.length){
	time_hour="未公布小时";
}

else
{

for(i=start.indexOf(")")+1;i<start.length;i++)
{
	if(start.charAt(i)==":")
	{
		break;
	}
	if(i==start.indexOf(")")+1)
	{
		time_hour=start.charAt(i);
	}
	else
	{
		time_hour+=start.charAt(i);
	}
}
}
var time_min;

if(start.indexOf(":")!=-1)
{
for(i=start.indexOf(":")+1;i<start.length;i++)
{
	if(i==start.indexOf(":")+1)
	{
		time_min=start.charAt(i);
	}
	else
	{
		time_min+=start.charAt(i);
	}
}
}
else
{
time_min="未公布分钟";
}

var para=document.getElementsByTagName("p");
var child=para.childNodes;
for(i=0;i<para.length;i++)
{
	para[i].removeChild(para[i].firstChild);
	para[i].removeChild(para[i].lastChild);
}
var d=new Date();
var nowmonth=d.getMonth();
var nowdate=d.getDate();
var nowhour=d.getHours();
var nowminutes=d.getMinutes();
var nowsecond=d.getSeconds();
var txt;
var fm;
var fd;
var fh;
var fmi;
var timezoneminus;
if(time_hour!="未公布小时"){
localtimezone=d.getTimezoneOffset()/60;
timezoneminus=-8-localtimezone;
time_hour=Number(time_hour)+timezoneminus;
}
if(localtimezone!=-9)
{
	alert("您的电脑时区不是日本时区，若需要抢号请将电脑时区更改为日本东京时区");
}
var timezone;
if(nowmonth+1>month)
{
	fm=1;
}
else if(nowmonth+1==month)
{
fm=2;
}
else
{
	fm=0;
}
if(nowdate>date)
{
	fd=1;
}
else if(nowdate==date)
{
	fd=2;
}
else
{
	fd=0;
}
if(nowhour>time_hour)
{
	fh=1;
}
else if(nowhour==time_hour)
{
	fh=2;
}
else
{
	
	fh=0;
}
if(fh==2&nowminutes>time_min)
{
	fmi=1;
}
else if(fh==2&nowminutes==time_min)
{
	fmi=2;
}
else
{
	fmi=0;
}
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
if(fm==0||fm==2&&fd==0||fd==2&&fh==0)
{	
if(isNaN(time_hour)){
	txt="</br>下次抢号时间为:<h3>"+month+"月"+date+"日&nbsp;&nbsp;("+weekday+")";
	txt+="</br><h3>官方未公开具体的时间</h3>";
	}	
	else{				
txt="</br>下次抢号时间为:<h3>"+month+"月"+date+"日&nbsp;&nbsp;("+weekday+")&nbsp&nbsp</br></br>"+timezone+"&nbsp;"+time_hour+":"+time_min+"</br>放号名额为:"+end+"</h3>";
	}
var a=document.getElementById("time");
a.innerHTML=txt;
}
else if(fm==2&&fd==2&&(fh==2||fh==0)&&(fmi==1||fmi==2))
{
	txt="</br>开始抢号，请提督做好准备。抢号地址:<h1><a href=\"http:\/\/www.dmm.com\/netgame\/social\/-\/gadgets\/=\/app_id=854854\/\" target=\"blank\">艦隊これくしょん　艦これ</a>";
	txt+="</br>本次抢号时间为:<h3>"+month+"月"+date+"日&nbsp;&nbsp;("+weekday+")</br>"+timezone+"&nbsp;"+time_hour+":"+time_min+"</h3></br>放号名额为:<h3>"+end+"</h3>";
	txt+="</br></br>舰队collection官方微博(来源：<a href=\"http://www.crystalacg.com\" target=\"blank\">CrystalACG</a>)</br>"
	for(i=0;i<10;i++)
	{
	txt+="<img src=\"http://www.crystalacg.com/res/tt/ttl"+Number(i+1)+".png\"></br>"
	}

	var a=document.getElementById("time");
	a.innerHTML=txt;
}
else if(fm==1||fm==2&&fd==1||fd==2&&fh==1)
{
txt="</br>本次抢号活动已经结束，若抢号未成功，请等待下一次的官方抢号时间.";
var aa=document.getElementById("time");
aa.innerHTML=txt;

}
a=document.getElementById("footer");
var copyright="<p align=\"center\">抢号时间脚本由<span class=\"bold\"><a href=\"http://www.crystalacg.com\" target=\"blank\">CrystalACG</a></span>提供,判断逻辑由<span class=\"author\">Ryan</span>编写</p>";
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
	if(now_hour>time_hour)
	{
		timehour=24+time_hour-now_hour-1;
	}
	else
	{
		timehour=time_hour-now_hour-1;
	}
	var timemin;
	var timesecond=60-now_second;

	if(now_minutes>time_min)
	{
		if(timesecond==0)
		{
			timemin=60+Number(time_min)-now_minutes;
		}
		else
		{
		timemin=60+Number(time_min)-now_minutes-1;
		}
	}
	else
	{
		if(timesecond==0)
		{
			timemin=time_min-now_minutes;
		}
		else
		{
		timemin=Number(time_min)-Number(now_minutes)-1;
		}
	}
	var cd=document.getElementById("countdown");
	if(nowhour<time_hour)
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