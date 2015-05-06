console.time("running kancollev3.js use time");//V8 console控制台调用
_screenwidth("ifm");//窗口大小调用
remindTimezoneChange();//时区调用
maincore();//主要功能调用
//函数部分
function maincore()
{
	var txt = new String();
	if(timepast(month, date, hour, minute) == -1)
	{
		if(hour == null && minute == null)
		{
			txt = "<br>下次抢号时间为:<h3>" + month + "月" + date + "日&nbsp;&nbsp;&nbsp;&nbsp;(" + Convert(weekday) + ")&nbsp&nbsp&nbsp;" + "<br>放号名额为:" + comma(people, ",") + "名</h3>";
			txt += "<h2>官方尚未公开具体抢号时间</h2>";
		}
		else
		{
			txt = "<br>下次抢号时间为:<h3>" + month + "月" + date + "日&nbsp;&nbsp;&nbsp;&nbsp;(" + Convert(weekday) + ")&nbsp&nbsp&nbsp;<br>抢号时间:UTC" + reTimezone() + "&nbsp;&nbsp;" + Timezone(hour) + ":" + seczero(minute) + "<br>放号名额为:" + comma(people, ",") + "名</h3>";
		}
	}
	else if(timepast(month, date, hour, minute) == 0)
	{
		txt = "<br>开始抢号，请提督做好准备。抢号地址:<h1><a href=\"http:\/\/www.dmm.com\/netgame\/social\/-\/gadgets\/=\/app_id=854854\/\" target=\"blank\">艦隊これくしょん　艦これ</a>";
	}
	else if(timepast(month, date, hour, minute) == 1)
	{
		txt = "<br>本次抢号活动已经结束，若抢号未成功，请等待下一次的官方抢号时间.<br>";
		txt += "<span class=\"black\">上一次</span>的抢号时间为:<h3>" + month + "月" + date + "日&nbsp;&nbsp;&nbsp;&nbsp;(" + Convert(weekday) + ")&nbsp&nbsp&nbsp;<br>抢号时间:UTC" + reTimezone() + "&nbsp;&nbsp;" + Timezone(hour) + ":" + seczero(minute) + "<br>放号名额为:" + comma(people, ",") + "名<br><br>下一次抢号时间为<br>" + nextmonth + "月" + nextdate + "日&nbsp;&nbsp;(" + Convert(nextweekday) + ")</h3>";
		console.info("%cTimepast function output code:" + timepast(month, date, hour, minute), "font-size:18px");
		console.warn("Time up");
	}
	txt += "<h4>"+_time()+"</h4>";
	if(event_year != "" && event_year != null && event_name != "")
	{
		txt += "<h4>当前活动:" + event_year + "年【" + comma(event_name, "[【】]") + "】</h4>";
		console.info("Event showed completed!");
	}
	else if(event_year == null && event_name != "")
	{
		var g = new Date();
		txt += "<h4>当前活动:" + (Number(g.getYear()) + 1900) + "年【" + comma(event_name, "[【】]") + "】</h4>";
		console.info("Event showed completed but no year data posted!");
	}
	else
	{
		console.warn("No event was showed!");
		console.warn("活动时间" + event_year + "活动名" + event_name);
	}
	if(event_date!=event_end_date)
	{
	if(event_month != null && event_date != null)
	{
		txt += "<h4>活动开始时间:" + event_month + "月" + event_date + "日 (" + Convert(event_weekday) + ")</h4>";
	}
	}
	if(event_end_month!=null&&event_end_date!=null)
	{
		txt += "<h4>活动结束时间:" + event_end_month + "月" + event_end_date + "日 (" + Convert(event_end_weekday) + ")</h4>";	
	}
	console.info("%cTimepast code:" + timepast(month, date, hour, minute), "font-size:24px");
	var dom_time = document.getElementById("time");
	dom_time.innerHTML = txt;
	if(!mobile())
	{
	setTimeout("maincore()", 1000);
	}
}
//上部分需要进行函数化，代码过于冗长
console.timeEnd("running kancollev3.js use time");
//当前时间
function _time()
{
	var time=new Date();
	var _year=time.getYear()+1900;
	var _month=time.getMonth()+1;
	var _date=time.getDate();
	var _hour=time.getHours();
	var _minute=time.getMinutes();
	var _second=time.getSeconds();
	return "现在的时间:"+	_year+"年"+_month+"月"+_date+"日"+_hour+"时"+seczero(_minute)+"分"+seczero(_second)+"秒";
}
//时区
function remindTimezoneChange()
{
	var v = new Date();
	var _timezone = v.getTimezoneOffset() / 60;
	if(_timezone != -9)
	{
		alert("您的电脑时区不是日本时区，若需要抢号请将电脑时区更改为日本东京时区");
	}

}

function Timezone(hour)
{
	var a = new Date();
	var timezone = parseInt(a.getTimezoneOffset() / 60);
	var _hour = hour + (-9 - timezone);
	if(timezone != -9)
	{
		console.log("您的电脑时区不是日本时区，若需要抢号请将电脑时区更改为日本东京时区");
	}
	else
	{
		console.log("Timezone:%cJapan", "font-size:21px");
	}
	return _hour;
}
//时区--UTF
function reTimezone()
{
	var d = new Date();
	var date = d.getTimezoneOffset() / 60;
	date = -date;
	if(date > 0)
	{
		return "+" + date;
	}
	else
	{
		return date;
	}
}
//倒计时调用
timecount(month, date, hour, minute);
//Javascript工作核心
function timepast(month, date, hour, minute)
{
	var d = new Date();
	var nm = d.getMonth();
	var nd = d.getDate();
	var nh = d.getHours();
	var nmi = d.getMinutes();
	console.log("%cMonth:" + month + " Date:" + date + " Hour:" + Timezone(hour) + " Minute:" + minute, "font-size:21px;");
	if(maxnum(nm, month) && maxnum(nd, date))
	{
		console.info("Compare month and date complete!");
		console.log(nh * 60 + nmi - hour * 60 - minute)
		if(hour == null && minute == null)
		{
			return -1;
		}
		else
		{
			if(nh * 60 + nmi < hour * 60 + minute)
			{
				return -1;
				console.warn("hour>nowhour");
				console.log(nh * 60 + nmi - hour * 60 - minute)
			}
			else if(nh * 60 + nmi <= hour * 60 + minute + 60)
			{
				return 0;
				console.warn("hour plus one >nowhour");
			}
			else
			{
				console.info("hour is gone!");
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
	x.style.width = thiswidth * 0.8;
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
		var etime = (getMonthSec(month) + date) * 24 * 60 * 60 + hour * 60 * 60 + minute * 60;
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
				maincore();
				htmlo.innerHTML = "<h4>距离抢号时间还有" + seczero(ld) + "日" + seczero(lh) + "小时" + seczero(lmi) + "分" + seczero(ls) + "秒</h4>";
			}
			t = setTimeout("timecount(month,date,hour,minute)", 1000);
		}
		else
		{
			//console.log("Time has past");
		}
	}
	else
	{
		htmlo.innerHTML = "<h4>距离抢号时间还有" + (date - nd) + "日</h4>";
		//console.log("Time didn't get from 'trace.php',if it didn't work,please check");
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
	console.log("%cRegExp code:" + reg, "font-size:24px;");
	console.log("RegExp replace succeed");
	return x;
}
function mobile()
{
var x=navigator;
var ua=x.userAgent;
var isMobile=ua.indexOf("Android"||"iOS"||"iPad"||"iPhone"||"Windows Phone");
if(isMobile!=-1)
{
	return true;	
}
else
{
	return false;	
}
}