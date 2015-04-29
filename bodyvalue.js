console.time("running bodyvalue use time");
var text;
if(returnUserAgent("useragent") == "IE")
{
	if(returnUserAgent("version") <= 7)
	{
		text = "<div data-role=\"page\" data-theme=\"a\" id=\"home\"><div data-role=\"header\"><h1>您的浏览器版本过低，为了您更好的体验，请更新至Chrome或Internet Explorer 8以上版本</h1></div><div data-role=\"header\"><h1>舰队collection放号时间</h1></div><div data-role=\"navbar\"><ul><li><a href=\"#home\"  data-icon=\"home\">首页</a></li><li><a href=\"#twitter\" data-transition=\"slide\" data-icon=\"arrow-r\">官推截图</a></li></ul></div>";
	}
}
else
{
	text = checkCookie();
	text += "<div data-role=\"page\" data-theme=\"a\" id=\"home\"><div data-role=\"header\"  style=\"position:fixed;top:0px;right:0px;width:100%;z-index:500\"><h4>";
	if(document.URL.indexOf("v2") == -1)
	{
		text += "舰队collection放号时间";
	}
	else
	{
		text += "Kantai Collection Notification(Ver1.0)";
	}
	text += "<span id=\"cookie\" align=\"right\" class=\"header\" onClick=\"delCookie()\">";
	text += "</span></h4>";
	text +="</div><div data-role=\"navbar\" style=\"position:fixed;margin-top:2.7em;width:100%;\"><ul><li><a href=\"#home\"  data-icon=\"home\">首页</a></li><li><a href=\"#twitter\" data-transition=\"slide\" data-icon=\"arrow-r\">官推截图</a></li></ul></div>";
	if(document.URL.indexOf("v2") == -1)
	{
		text += "<div data-role=\"content\" style=\"margin-top:5em;\"><a href=\"kancollev2.html\" target=\"blank\"><button>此页面已经停止维护,点击此前往新版</button></a></div>";
	}
	text += "\n<div data-role=\"content\" style=\"position:relative;margin-top:5em;\" id=\"time\" data-theme=\"c\"></div>";
	text += "\n<div data-role=\"content\" id=\"countdown\" data-theme=\"c\" ></div>";
	text += "<div data-role=\"dialog\" id=\"alert-dialog\"><div data-role=\"header\" data-theme=\"a\"><h1>来自网页的信息</h1></div><div role=\"main\" class=\"ui-content\"><h1>Delete cookie complete!</h1><p align=\"center\">该网页的Cookie已经从您的电脑中删除。</p><a href=\"#home\" data-role=\"button\" data-theme=\"b\" id=\"test\">关闭</a></div></div>";
	text += btncookie();
	text += "<br><br><br>";
	text += "\n<div data-role=\"footer\" style=\"position:fixed;bottom:0px;right:0px;width:100%;\" id=\"footer\"><h1></h1></div></div>";
	text += "\n<div data-role=\"page\" data-theme=\"a\" id=\"twitter\">";
	text += "\n<div data-role=\"header\" style=\"position:fixed;top:0px;right:0px;width:100%;z-index:999\">";
	text += "\n<h1>Kantai Collection Official Twitter</h1>";
	text += "\n</div><div data-role=\"navbar\" style=\"margin-top:1.52em;width:100%;\">;"
	text += "\n<ul><li><a href=\"#home\" data-transition=\"slide\" data-direction=\"reverse\" data-icon=\"home\">首页</a></li>";
	text += "\n<li><a style=\"width:100%;\" href=\"#twitter\" data-icon=\"arrow-r\">官推截图</a></li></ul></div>";
	text += "\n<div data-role=\"content\" id=\"twitter1\" data-theme=\"c\" style=\"position:relative;margin-top:5em;\">";
	text += "\n<iframe id=\"ifm\" frameborder=\"0\" height=\"5000px\" scrolling=\"no\"  align=\"middle\" marginwidth=\"40px\"  marginheight=\"80px\"  width=\"100%\" style=\"margin-top:-2.3em;\"   src=\"http://www.haoyuan.info/twitter/index.php\"></iframe>";
	text += "\n</div><br><div data-role=\"footer\" id=\"footer_1\" style=\"position:fixed;bottom:0px;right:0px;width:100%;\"><h1></h1></div></div>";
}
document.write(text);
footer = document.getElementById("footer");
var copyright = "<p align=\"center\">抢号时间脚本由<span class=\"bold\">本站</span>提供,判断逻辑由<span class=\"author\">Ryan</span>编写</p>";
footer.innerHTML = copyright;
console.log("footer is completed");
var footer_1 = document.getElementById("footer_1");
footer_1.innerHTML = "<p align=\"center\">官方推特转发由<span class=\"bold\">本站</span>提供,判断逻辑由<span class=\"author\">Ryan</span>编写</p>";
forIE();
console.timeEnd("running bodyvalue use time");
function forIE()
{
	if(returnUserAgent("useragent") == "Trident")
	{
		alert("您正在使用Internet Explorer或IE内核的浏览器浏览该网页\n由于IE内核Trident对HTML5和JQuery Mobile的兼容性限制，\n推荐您使用Webkit内核的浏览器浏览\n（如Chrome浏览器、搜狗浏览器高速模式、360极速浏览器等）");
	}
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
			console.info("%cgetCookie succeed!","font-size:21px;");
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
	console.log("setCookie succeed!");
}
function checkCookie()
{
	if(returnUserAgent("useragent") == "mobile")
	{
		mobileplayer=getCookie("mobileplayer");
		if(mobileplayer=="true")
		{
			return "<audio src=\"http://www.haoyuan.info/music/wacci.mp3\" autoplay=\"autoplay\" controls></audio>";
		}	
		else
		{
			var Okplayer=confirm("是否开启HTML5播放器?\n该功能10天内有效");
			if(Okplayer==true)
			{
				setCookie("mobileplayer","true",10);
				console.info(unescape(document.cookie));
				return "<audio src=\"http://www.haoyuan.info/music/wacci.mp3\" autoplay=\"autoplay\"></audio>";
			}
			else if(Okplayer==false)
			{
				setCookie("mobileplayer","false",10);
				console.info(unescape(document.cookie));
			}
		}
	}
	else
	{
		flashplayer=getCookie("flashplayer");
		if(flashplayer=="true")
		{
			console.info(unescape(document.cookie));
			return "<embed style=\"float:right;margin-right=20px;position:fixed;z-index:1;top:50%;right:0;\" src=\"http://www.xiami.com/widget/9768381_1769745040,1770729861,1774137590,1773750009,1773865494,1770869934,_235_346_5677fc_536dfe_1/multiPlayer.swf\" width=\"235\" type=\"application/x-shockwave-flash\" height=\"346\" align=\"ABSBOTTOM\"></embed>";
		}
		else if(flashplayer=="false")
		{
			return "";
		}
		else
		{
			var Okplayer=confirm("是否十天内开启Flash音乐播放器?");
			if(Okplayer==true)
			{
				setCookie("flashplayer","true",10);
			return "<embed style=\"float:right;margin-right=20px;position:fixed;z-index:1;top:50%;right:0;\" src=\"http://www.xiami.com/widget/9768381_1769745040,1770729861,1774137590,1773750009,1773865494,1770869934,_235_346_5677fc_536dfe_1/multiPlayer.swf\" width=\"235\" type=\"application/x-shockwave-flash\" height=\"346\" align=\"ABSBOTTOM\"></embed>";
			}
			else if(Okplayer==false)
			{
				setCookie("flashplayer","false",10);	
			}
		}
	}
}
function delCookie()
{
	var del=new Date();
	del.setTime(del.getTime()-1);
	var cval;
	if(returnUserAgent("useragent")!="mobile")
	{
		cval=getCookie("flashplayer");
		if(cval!=null)
		{
			 document.cookie="flashplayer="+cval+";expires="+del.toGMTString();
		}
	}
	else
	{
	  cval=getCookie("mobileplayer");
	  if(cval!=null) document.cookie= "mobileplayer="+cval+";expires="+del.toGMTString();	
	}
}
$("a#cookie_a").click(function(){
	delCookie();
	$("div#alert-dialog").show();
	$("a#cookie_a").animate({height:'20px',width:'30px',opacity:'0.4'},"slow");
$("a#cookie_a").remove();
})
$("a#test").click(function(){
	$("div#alert-dialog").hide();
})
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
	console.log(parseFloat(x.appVersion));
	return parseFloat(x.appVersion);	
}
}
function btncookie()
{
	var co=getCookie("mobileplayer")+getCookie("flashplayer");
	if(co!=""&&co!=null)
	{
	return "<a href=\"#alert-dialog\" data-role=\"button\" style=\"width:200px;float:right;top:-23.5em; z-index:999\" id=\"cookie_a\" data-rel=\"dialog\" data-transition=\"pop\">删除Cookie</a>";
	}
}
/*
function autoHeight(){
        var iframe = document.getElementById("ifm");
        if(iframe.Document)
		{//ie自有属性
            iframe.style.height = iframe.Document.documentElement.scrollHeight+13;
        }
		else if(iframe.contentDocument)
		{//ie,firefox,chrome,opera,safari
            iframe.height = iframe.contentDocument.body.offsetHeight+13;
        }
    }
	*/