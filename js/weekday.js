function Convert(str)
{
	if(str == "日曜日")
	{
		return "星期日";
	}
	if(str == "月曜日")
	{
		return "星期一";
	}
	if(str == "火曜日")
	{
		return "星期二";
	}
	if(str == "水曜日")
	{
		return "星期三";
	}
	if(str == "木曜日")
	{
		return "星期四";
	}
	if(str == "金曜日")
	{
		return "星期五";
	}
	if(str == "土曜日")
	{
		return "星期六";
	}
	if(str == "祝日")
	{
		return "节假日";
	}
	if(str == "振替休日")
	{
		return "补休假期";
	}
}

function getMonthSec(month)
{
	switch(month)
	{
	case 1:
		return 0;
		break;
	case 2:
		return 31;
		break;
	case 3:
		return 31 + 28;
		break;
	case 4:
		return 31 + 28 + 31;
		break;
	case 5:
		return 31 + 28 + 31 + 30;
		break;
	case 6:
		return 31 + 28 + 31 + 30 + 31;
		break;
	case 7:
		return 31 + 28 + 31 + 30 + 31 + 30;
		break;
	case 8:
		return 31 + 28 + 31 + 30 + 31 + 30 + 31;
		break;
	case 9:
		return 31 + 28 + 31 + 30 + 31 + 30 + 31 + 31;
		break;
	case 10:
		return 31 + 28 + 31 + 30 + 31 + 30 + 31 + 31 + 30;
		break;
	case 11:
		return 31 + 28 + 31 + 30 + 31 + 30 + 31 + 31 + 30 + 31;
		break;
	case 12:
		return 31 + 28 + 31 + 30 + 31 + 30 + 31 + 31 + 30 + 31 + 30;
		break;
	}
}
function returnUserAgent(action)
{
var x=navigator;
var ua=x.userAgent;
var isMobile=ua.indexOf("Android"||"iOS"||"iPad"||"iPhone"||"Windows Phone");
var isIE=ua.indexOf("Internet Explorer");
var isTrident=ua.indexOf("Trident");
if(action=="useragent")
{
if(isMobile!=-1)
{
	return "Mobile";	
}
if(isIE!=-1)
{
	return "IE";
}
if(isTrident!=-1)
{
	return "Trident";	
}
}
else if(action=="version")
{
	return parseFloat(x.appVersion);	
}
}
function mouseNotifier(e, str){
	var oThis = arguments.callee;
	if(!str) {
		oThis.sug.style.visibility = 'hidden';
		document.onmousemove = null;
		return;
	}		
	if(!oThis.sug){
		var div = document.createElement('div'), css = 'top:0; left:0; position:absolute; z-index:100; visibility:hidden';
			div.style.cssText = css;
			div.setAttribute('style',css);
		var sug = document.createElement('div'), css= 'font:normal 14px/18px 微软雅黑; white-space:nowrap; color:#000; padding:5px; position:absolute; left:0; top:0; z-index:10; background:#fdfdfd; border:1px solid #000';
			sug.style.cssText = css;
			sug.setAttribute('style',css);
		var dr = document.createElement('div'), css = 'position:absolute; top:3px; left:3px; background:#000; filter:alpha(opacity=50); opacity:0.5; z-index:9';
			dr.style.cssText = css;
			dr.setAttribute('style',css);
		var ifr = document.createElement('iframe'), css='position:absolute; left:0; top:0; z-index:8; filter:alpha(opacity=0); opacity:0';
			ifr.style.cssText = css;
			ifr.setAttribute('style',css);
		div.appendChild(ifr);
		div.appendChild(dr);
		div.appendChild(sug);
		div.sug = sug;
		document.body.appendChild(div);
		oThis.sug = div;
		oThis.dr = dr;
		oThis.ifr = ifr;
		div = dr = ifr = sug = null;
	}
	var e = e || window.event, obj = oThis.sug, dr = oThis.dr, ifr = oThis.ifr;
	obj.sug.innerHTML = str;
	var w = obj.sug.offsetWidth, h = obj.sug.offsetHeight, dw = document.documentElement.clientWidth||document.body.clientWidth; dh = document.documentElement.clientHeight || document.body.clientHeight;
	var st = document.documentElement.scrollTop || document.body.scrollTop, sl = document.documentElement.scrollLeft || document.body.scrollLeft;
	var left = e.clientX +sl +17 + w < dw + sl && e.clientX + sl + 15 || e.clientX +sl-8 - w, top = e.clientY + st + 17;
	obj.style.left = left+ 10 + 'px';
	obj.style.top = top + 10 + 'px';
	dr.style.width = w + 'px';
	dr.style.height = h + 'px';
	ifr.style.width = w + 3 + 'px';
	ifr.style.height = h + 3 + 'px';
	obj.style.visibility = 'visible';
	document.onmousemove = function(e){
		var e = e || window.event, st = document.documentElement.scrollTop || document.body.scrollTop, sl = document.documentElement.scrollLeft || document.body.scrollLeft;
		var left = e.clientX +sl +17 + w < dw + sl && e.clientX + sl + 15 || e.clientX +sl-8 - w, top = e.clientY + st +17 + h < dh + st && e.clientY + st + 17 || e.clientY + st - 5 - h;
		obj.style.left = left + 'px';
		obj.style.top = top + 'px';
	}
}
var isIE = function(ver){
    var b = document.createElement('b')
    b.innerHTML = '<!--[if IE ' + ver + ']><i></i><![endif]-->'
    return b.getElementsByTagName('i').length === 1
}
function getCookie(c_name)
{
	if (document.cookie.length>0)
	{ 
		c_start=document.cookie.indexOf(c_name + "=");
		if (c_start!=-1)
		{ 
			c_start=c_start + c_name.length+1; 
			c_end=document.cookie.indexOf(";",c_start);
			if (c_end==-1) 
			{
				c_end=document.cookie.length;
			}
			return unescape(document.cookie.substring(c_start,c_end));
		} 
	}
	return "";
}
function setCookie(name,value,expiredays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie=name+"="+escape(value)+((expiredays==null)?"":";expires="+exdate.toGMTString());
}
function nowtimesec(code)
{
	var now = new Date();
	var y = now.getFullYear();
	var m = (now.getMonth() + 1);
	var d = now.getDate();
	var h = now.getHours();
	var mi = now.getMinutes();
	var nowplus;
	if(code==""||code==null)
	{
	    nowplus = getMonthSec(m).toString() + (d * 24 * 60).toString() + (h * 60).toString() + mi.toString();
	}
	else if(code=="number")
	{
		nowplus = (getMonthSec(m)+d)*24*60+(h*60)+mi;	
	}
	return nowplus;
}
function timecompare(month, date, hour, minutes)
{
	var minuteplus = new Number();
	minuteplus = (getMonthSec(month) + date) * 24 * 60 + hour * 60 + minutes;
	return minuteplus;
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
function Timezone(hour)
{
	var a = new Date();
	var timezone = parseInt(a.getTimezoneOffset() / 60);
	var _hour = Math.round(hour + (-9 - timezone));
	return Math.round(_hour);
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
	if(x=="") 
	{
		return "【未知】";
	}
	else
	{ 
		return x;
	}
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
function maintenance(maintenance_m,maintenance_d,maintenance_start_hour,maintenance_start_minute,maintenance_end_hour,maintenance_end_minute)
{
	var a=document.getElementById("maintenance");
	var flag=mainten_count(maintenance_m,maintenance_d,maintenance_start_hour,maintenance_start_minute,maintenance_end_hour,maintenance_end_minute);
	if(flag==-1)
	{
		a.innerHTML="<h4>下一次维护的时间:<br><br>"+maintenance_m+"月"+maintenance_d+"日&nbsp;&nbsp;("+Convert(maintenance_w)+")<br><br>开始时间 "+seczero(Timezone(maintenance_start_hour))+":"+seczero(maintenance_start_minute)+"<br><br>结束时间 "+seczero(Timezone(maintenance_end_hour))+":"+seczero(maintenance_end_minute)+"</h4>";
	}
	else if(flag==0)
	{
		a.innerHTML="<h4>服务器正在维护<br><br>维护时间:<br><br>"+maintenance_m+"月"+maintenance_d+"日&nbsp;&nbsp;("+Convert(maintenance_w)+")<br><br>开始时间 "+seczero(Timezone(maintenance_start_hour))+":"+seczero(maintenance_start_minute)+"<br><br>结束时间 "+seczero(Timezone(maintenance_end_hour))+":"+seczero(maintenance_end_minute)+"</h4>";	
	}
	else if(flag==1)
	{
		a.innerHTML="<h4>上一次维护的时间:<br><br>"+maintenance_m+"月"+maintenance_d+"日&nbsp;&nbsp;("+Convert(maintenance_w)+")<br><br>开始时间 "+seczero(Timezone(maintenance_start_hour))+":"+seczero(maintenance_start_minute)+"<br><br>结束时间 "+seczero(Timezone(maintenance_end_hour))+":"+seczero(maintenance_end_minute)+"</h4>";	
	}
}
function returnTime()
{
	var time = new Date();
	var _year = time.getFullYear();
	var _month = time.getMonth() + 1;
	var _date = time.getDate();
	var _hour = time.getHours();
	var _minute = time.getMinutes();
	var _second = time.getSeconds();
	return "现在的时间:<br><br>" + _year + "年" + _month + "月" + _date + "日<br><br>" + _hour + "时" + seczero(_minute) + "分" + seczero(_second) + "秒";
}
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
function nowtime()
{
	var nowtimecontent = document.getElementById("nowtime");
	nowtimecontent.innerHTML = "<h4>" + returnTime() + "</h4>";
	setTimeout("nowtime()", 1000);
}
function forIE()
{
	if(isIE())
	{
		alert("您正在使用Internet Explorer或IE内核的浏览器浏览该网页\n由于IE内核Trident对JQuery Mobile的兼容性限制，在Internet Explorer 8平台上会出现页面元素排布不正确的情况。\n推荐您使用Webkit内核的浏览器浏览\n（如Chrome浏览器、搜狗浏览器高速模式、360极速浏览器、Safari等）\n或将浏览器更新到Internet Explorer 9 及以上\n(仍会有部分功能不能正常运作)");
	}
}
function aboutTxtOutput()
{
	var text = "<h2>本脚本已维护"+timeGo()+"天<br>";
	text += "目前本脚本已经实现的功能有：<br>";
	text += "抓取官方推特中的<br>";
	text += "&nbsp;抢号时间<br>&nbsp;维护时间<br>&nbsp;活动时间<br>";
	text += "转发官方推特内容并进行简单的关键词翻译<br>";
	text += "即将实现的功能有<br>";
	text +=	"外链插件(图片)<br>";
	text += "本项目的代码已经开源，请遵循开放源代码许可。<br>";
	text += "GitHub 地址:<a href=\"https://github.com/ryanlee2014/KanColle-Registration-Notification/\" target=\"_blank\">https://github.com/ryanlee2014/KanColle-Registration-Notification/</a><br>";
	text += "来自PRC的问候 --<a href=\"mailto:gxlhybh@gmail.com\">Ryan</a></h2>";	
	document.getElementById("about_text").innerHTML=text;
}
function timeGo()
{
var now=nowtimesec("number");
var that=timecompare(2,21,0,0);
var exsec=now-that;
var d = parseInt((exsec/(60*24)));
return d;
}
function mainten_count(mainten_m,mainten_d,mainten_start_hour,mainten_start_minute,mainten_end_hour,mainten_end_minute)
{
	var now=nowtimesec("number");
	var that=timecompare(mainten_m,mainten_d,mainten_end_hour,mainten_end_minute);
	var exsec=that-now;
	var time_part=(mainten_end_hour*60+mainten_end_minute)-(mainten_start_hour*60+mainten_start_minute);
	if(exsec>time_part)
	{
		return -1;	
	}
	else if(exsec>0)
	{
		return 0;	
	}
	else if(exsec<0)
	{
		return 1;	
	}
}