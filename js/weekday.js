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