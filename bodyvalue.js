console.time("running bodyvalue use time");
var text;
useragent();
var x = navigator;
var browser = x.userAgent;
var version = parseFloat(x.appVersion);
if(browser.indexOf("Internet Explorer") != -1)
{
	if(version <= 7)
	{
		text = "<div data-role=\"page\" data-theme=\"a\" id=\"home\"><div data-role=\"header\"><h1>您的浏览器版本过低，为了您更好的体验，请更新至Chrome或Internet Explorer 8以上版本</h1></div><div data-role=\"header\"><h1>舰队collection放号时间</h1></div><div data-role=\"navbar\"><ul><li><a href=\"#home\"  data-icon=\"home\">首页</a></li><li><a href=\"#twitter\" data-transition=\"slide\" data-icon=\"arrow-r\">官推截图</a></li></ul></div>";
	}
}
else
{
	text = useragent();
	text += "<div data-role=\"page\" data-theme=\"a\" id=\"home\"><div data-role=\"header\"  style=\"position:fixed;top:0px;right:0px;width:100%;z-index:999\"><h4>";
	if(document.URL.indexOf("v2") == -1)
	{
		text += "舰队collection放号时间";
	}
	else
	{
		text += "Kantai Collection Notification(Ver1.0)";
	}
	text += "</h4></div><div data-role=\"navbar\" style=\"position:fixed;margin-top:2.7em;width:100%;\"><ul><li><a href=\"#home\"  data-icon=\"home\">首页</a></li><li><a href=\"#twitter\" data-transition=\"slide\" data-icon=\"arrow-r\">官推截图</a></li></ul></div>";
	if(document.URL.indexOf("v2") == -1)
	{
		text += "<div data-role=\"content\" style=\"margin-top:5em;\"><a href=\"kancollev2.html\" target=\"blank\"><button>此页面已经停止维护,点击此前往新版</button></a></div>";
	}
	text += "\n<div data-role=\"content\" style=\"position:relative;margin-top:5em;\" id=\"time\" data-theme=\"c\"></div>";
	text += "\n<div data-role=\"content\" id=\"countdown\" data-theme=\"c\" ></div>";
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
	var x = navigator;
	var ua = x.userAgent;
	var ieua = ua.indexOf("Trident");
	if(ieua != -1)
	{
		alert("您正在使用Internet Explorer或IE内核的浏览器浏览该网页\n由于IE内核Trident对HTML5和JQuery Mobile的兼容性限制，\n推荐您使用Webkit内核的浏览器浏览\n（如Chrome浏览器、搜狗浏览器高速模式、360极速浏览器等）");
	}
}
function useragent()
{
	var x=navigator;
	var ua=x.userAgent;
	var uaok=ua.indexOf("Android"||"iOS"||"iPad"||"iPhone"||"Windows Phone");
	if(uaok==-1)
	{
		return "<embed style=\"float:right;margin-right=20px;position:fixed;z-index:1;top:50%;right:0;\" src=\"http://www.xiami.com/widget/9768381_1769745040,1770729861,1774137590,1773750009,1773865494,1770869934,_235_346_5677fc_536dfe_1/multiPlayer.swf\" width=\"235\" type=\"application/x-shockwave-flash\" height=\"346\" align=\"ABSBOTTOM\"></embed>";
	}
	else
	{
		return "";
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