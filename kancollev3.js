if(window.console)
{
console.time("running kancollev3.js use time"); //V8 console控制台调用
}
if(!(isIE(5)||isIE(6)||isIE(7)))
{
_screenwidth("ifm"); //窗口大小调用
remindTimezoneChange(); //时区调用
nowtime();//现在时间
XMLRefresh();//异步GET
}
if(window.console)
{
console.timeEnd("running kancollev3.js use time");
console.timeEnd("all JavaScript use time");
}
//console output
//函数部分
function maincore(readycode)
{
	var txt = new String();
	var g = new Date();
	txt = "";
	if(timepast(month, date, hour, minute) == -1)
	{
		if(hour == null && minute == null)
		{
			txt += "<br>下次抢号时间为:<h3>" + month + "月" + date + "日&nbsp;&nbsp;&nbsp;&nbsp;(" + Convert(weekday) + ")&nbsp&nbsp&nbsp;" + "<br>放号名额为:" + comma(people, ",") + "名</h3>";
			txt += "<h2>官方尚未公开具体抢号时间</h2>";
		}
		else
		{
			txt += "<br>下次抢号时间为:<h3>" + month + "月" + date + "日&nbsp;&nbsp;&nbsp;&nbsp;(" + Convert(weekday) + ")&nbsp&nbsp&nbsp;<br>抢号时间:UTC" + reTimezone() + "&nbsp;&nbsp;" + Timezone(hour) + ":" + seczero(minute) + "<br>放号名额为:" + comma(people, ",") + "名</h3>";
		}
	}
	else if(timepast(month, date, hour, minute) == 0)
	{
		txt += "<br>开始抢号，请提督做好准备。抢号地址:<h1><a href=\"http:\/\/www.dmm.com\/netgame\/social\/-\/gadgets\/=\/app_id=854854\/\" target=\"blank\">艦隊これくしょん　艦これ</a>";
	}
	else if(timepast(month, date, hour, minute) == 1)
	{
		txt += "<br>本次抢号活动已经结束，若抢号未成功，请等待下一次的官方抢号时间.<br>";
		txt += "<span class=\"black\">上一次</span>的抢号时间为:<h3>" + month + "月" + date + "日&nbsp;&nbsp;&nbsp;&nbsp;(" + Convert(weekday) + ")&nbsp&nbsp&nbsp;<br>抢号时间:UTC" + reTimezone() + "&nbsp;&nbsp;" + Timezone(hour) + ":" + seczero(minute) + "<br>放号名额为:" + comma(people, ",") + "名<br><br>下一次抢号时间为<br>";
		if(readycode == 0 && nextmonth == "null")
		{
			txt += "Loading</h3>";
		}
		else if(readycode == 1 || nextmonth != "null")
		{
			txt += nextmonth + "月" + nextdate + "日&nbsp;&nbsp;(" + Convert(nextweekday) + ")</h3>";
		}
	}
	if(event_year != "" && event_year != null && event_name != "")
	{
		txt += "<h4>当前活动:" + event_year + "年【" + comma(event_name, "[【】]") + "】</h4>";
	}
	else if(event_year == null && event_name != "")
	{
		txt += "<h4>当前活动:" + (Number(g.getYear()) + 1900) + "年【" + comma(event_name, "[【】]") + "】</h4>";
	}
	txt += _event();
	txt += maintenance(maintenance_m,maintenance_d);
	var dom_time = document.getElementById("time");
	dom_time.innerHTML = txt;
}
function nowtime()
{
	var nowtimecontent = document.getElementById("nowtime");
	nowtimecontent.innerHTML = "<h4>" + _time() + "</h4>";
	setTimeout("nowtime()", 1000);
}
//上部分需要进行函数化，代码过于冗长
function console_activity()
{
	if(window.console)
	{
	console.info("%cTimepast function output code:" + timepast(month, date, hour, minute), "font-size:18px");
	console.info("Event showed completed!");
	console.warn("活动时间" + event_year + "活动名" + event_name);
	console.log("%cMonth:" + month + " Date:" + date + " Hour:" + Timezone(hour) + " Minute:" + minute, "font-size:21px;");
	}
}
//当前时间
function _event()
{
	var _eventtxt = new String();
	_eventtxt = "";
		if(event_date != event_end_date)
		{
			if(event_month != null && event_date != null)
			{
				_eventtxt += "<h4>活动开始时间:" + event_month + "月" + event_date + "日 (" + Convert(event_weekday) + ")</h4>";
			}
		}
		if(event_end_month != null && event_end_date != null)
		{
			_eventtxt += "<h4>活动结束时间:" + event_end_month + "月" + event_end_date + "日 (" + Convert(event_end_weekday) + ")</h4>";
		}
		if(nowtimesec() - timecompare(event_end_month, event_end_date, 0, 0))
		{
			_eventtxt += "<h4>活动已结束</h4>";
		}
	return _eventtxt;
}
function _time()
{
	var time = new Date();
	var _year = time.getYear() + 1900;
	var _month = time.getMonth() + 1;
	var _date = time.getDate();
	var _hour = time.getHours();
	var _minute = time.getMinutes();
	var _second = time.getSeconds();
	return "现在的时间:<br><br>" + _year + "年" + _month + "月" + _date + "日<br><br>" + _hour + "时" + seczero(_minute) + "分" + seczero(_second) + "秒";
}
//时区
function remindTimezoneChange()
{
	var v = new Date();
	var _timezone = v.getTimezoneOffset() / 60;
	if(_timezone != -9)
	{
		if(returnUserAgent("useragent") != "Mobile")
		{
		alert("您的电脑时区不是日本时区\n若需要抢号请将电脑时区更改为日本东京时区");
		}
	}

}
function Timezone(hour)
{
	var a = new Date();
	var timezone = parseInt(a.getTimezoneOffset() / 60);
	var _hour = Math.round(hour + (-9 - timezone));
	return Math.round(_hour);
}
//时区--UTF
function reTimezone()
{
	var d = new Date();
	var date = d.getTimezoneOffset() / 60;
	date = -date;
	if(date > 0)
	{
		return "+" + Math.round(date);
	}
	else
	{
		return Math.round(date);
	}
}
//Javascript工作核心
function timepast(month, date, hour, minute)
{
	var d = new Date();
	var nm = d.getMonth();
	var nd = d.getDate();
	var nh = d.getHours();
	var nmi = d.getMinutes();
	var time=nm*30+nd;
	var extime=month*30+date;
	if(maxnum(time,extime))
	{
		if(hour == null && minute == null)
		{
			return -1;
		}
		else
		{
			if(nh * 60 + nmi < Timezone(hour) * 60 + minute)
			{
				return -1;
			}
			else if(nh * 60 + nmi <= Timezone(hour) * 60 + minute + 60)
			{
				return 0;
			}
			else if(end==true)
			{
				return 1;	
			}
			else
			{
				return 1;
			}
		}
	}
	else
	{
		return 1;
	}
}
//本js大小对比
function maxnum(val1, val2)
{
	if(val1 <= val2)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function mmax(val1, val2)
{
	if(val1 + 1 <= val2)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function _screenwidth(id)
{
	var thiswidth = screen.availWidth;
	var x = document.getElementById(id);
	x.style.width = thiswidth * 0.95;
}
//倒计时模块
var t;
function timecount(month, date, hour, minute)
{
	var d = new Date();
	var nm = d.getMonth() + 1;
	var nd = d.getDate();
	var nh = d.getHours();
	var nmi = d.getMinutes();
	var ns = d.getSeconds();
	var htmlo = document.getElementById("countdown");
	if(hour != null && minute != null)
	{
		var etime = (getMonthSec(month) + date) * 24 * 60 * 60 + Timezone(hour) * 60 * 60 + minute * 60;
		var nowtime = (getMonthSec(nm) + nd) * 24 * 60 * 60 + nh * 60 * 60 + nmi * 60;
		var mtime = etime - nowtime;
		var ld, lh, lmi, ls = new Number();
		if(mtime > 0)
		{
			ld = Math.floor(mtime / (60 * 60 * 24));
			lh = Math.floor((mtime - ld * (60 * 60 * 24)) / (60 * 60));
			lmi = Math.floor((mtime - ld * (60 * 60 * 24) - lh * (60 * 60)) / 60);
			if(ns == 0)
			{
				ls = 0;
			}
			else
			{
				ls = 60 - ns;
				lmi = Math.floor((mtime - ld * (60 * 60 * 24) - lh * (60 * 60)) / 60) - 1;
			}
			if(mtime < 0)
			{
				window.location.reload();
			}
			else
			{
				//maincore();
				if(ld == 0)
				{
					htmlo.innerHTML = "<h4>距离抢号时间还有<br>" + seczero(lh) + "小时" + seczero(lmi) + "分" + seczero(ls) + "秒</h4>";
				}
				else
				{
					htmlo.innerHTML = "<h4>距离抢号时间还有<br>" + seczero(ld) + "日" + seczero(lh) + "小时" + seczero(lmi) + "分" + seczero(ls) + "秒</h4>";
				}
			}
			t = setTimeout("timecount(month,date,hour,minute)", 1000);
		}
	}
	else
	{
		htmlo.innerHTML = "<h4>距离抢号时间还有" + (getMonthSec(month)+date-(getMonthSec(nm)+nd)) + "日</h4>";
	}
}
//倒计时显示相关
function seczero(second)
{
	if(second < 10)
	{
		return "0" + second;
	}
	else
	{
		return second;
	}
}
//替换相关
function comma(str, regexp)
{
	var reg = new RegExp(regexp, "g");
	var x = str;
	x = x.replace(reg, "");
	return x;
}
function mobile()
{
	var x = navigator;
	var ua = x.userAgent;
	var isMobile = ua.indexOf("Android" || "iOS" || "iPad" || "iPhone" || "Windows Phone");
	if(isMobile != -1)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function timecompare(month, date, hour, minutes)
{
	var minuteplus = new Number();
	minuteplus = getMonthSec(month) + date * 24 * 60 + hour * 60 + minutes;
	return minuteplus;
}
function nowtimesec()
{
	var now = new Date();
	var m = (now.getMonth() + 1);
	var d = now.getDate();
	var h = now.getHours();
	var mi = now.getMinutes();
	var nowplus = getMonthSec(m).toString() + (d * 24 * 60).toString() + (h * 60).toString() + mi.toString();
	return nowplus;
}
function maintenance(maintenance_m,maintenance_d)
{
		return "<h4>下一次维护的时间是"+maintenance_m+"月"+maintenance_d+"日</h4>";
}
function XMLRefresh()
{
	$().ready(function (e)
	{
		var tracephp;
		var xmlhttp;
		var traceurl = new String();
		var urladdr = new String();
		traceurl = "http://"+location.hostname+"/php/trace2.php?client=web&random="+nowtimesec();
		urladdr = "http://" + location.hostname + "/php/trace2.php?ajax=1&r=refresh&client=web&t=100&random=" + nowtimesec();
		if(window.XMLHttpRequest)
		{
			xmlhttp = new XMLHttpRequest();
			endxml = new XMLHttpRequest();
			tracephp = new XMLHttpRequest();
		}
		else
		{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			endxml = new ActiveXObject("Microsoft.XMLHTTP");
			tracephp = new ActiveXObject("Microsoft.XMLHTTP");
		}
				tracephp.onreadystatechange = function ()
		{
			if(tracephp.readyState == 4 && tracephp.status == 200)
			{
				eval(tracephp.responseText);
				//倒计时调用
				maincore(0);
				asyncxml();
				timecount(month, date, hour, minute);
			}
		}
		tracephp.open("GET",traceurl,true);
		tracephp.send();
		xmlhttp.onreadystatechange = function ()
		{
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
			{
				eval(xmlhttp.responseText);
				maincore(1);
				loaded();
				if(window.console)
				{
				console.log("XHR_DATA="+xmlhttp.responseText);
				}
			}
		}
		xmlhttp.open("GET", urladdr, true);
		xmlhttp.send();
	/*	var twitter=new XMLHttpRequest();
		twitter.onreadystatechange=function()
		{
			if(twitter.readyState == 4 && twitter.status == 200)
			{
				document.getElementById("twitter1").innerHTML=twitter.responseText;
			}	
		}
		twitter.open("GET","http://www.haoyuan.info/twitter/index.php?test=1",true);
		twitter.send();*/
		setTimeout(function()
		{
				clearTimeout(timeout);
				document.getElementById("loading").innerHTML="<h3>加载失败！</h3>";
				setTimeout(function(){$("div#loading").hide("slow");},3000);},18000);
		});
}
function loaded()
{
	clearTimeout(timeout);
	document.getElementById("loading").innerHTML="<h3>加载完毕！</h3>";
	setTimeout(function(){$("div#loading").hide("slow");},1000);
}
function asyncxml()
{
	var endxml;
	var endurl = new String();
	endurl ="http://"+location.hostname+"/twitter/index.php?e=end&random="+nowtimesec();
	if(window.XMLHttpRequest)
	{
		endxml = new XMLHttpRequest();
	}
	else
	{
		endxml = new ActiveXObject("Microsoft.XMLHTTP");
	}
	endxml.onreadystatechange = function()
	{
		if(endxml.readyState == 4 && endxml.status == 200)
		{
			eval(endxml.responseText);
			maincore(1);
			if(window.console)
			{
				console.log("XHR ending mode="+end.toString());
			}
		}
	}
	endxml.open("GET",endurl,true);
	endxml.send();
}