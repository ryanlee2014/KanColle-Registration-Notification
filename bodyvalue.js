if(window.console)
{
console.time("running bodyvalue use time");
console.time("all JavaScript use time");
}
var text;
var timeout;
var count=new Number();
var end=new Boolean();
var month=new Number();
var date=new Number();
var weekday=new String();
var hour=new Number();
var minute=new Number();
var people=new String();
var event_year=new Number();
var event_name=new String();
var event_month=new Number();
var event_date=new Number();
var event_weekday=new String();
var nextmonth=new Number();
var nextdate=new Number();
var nextweekday=new String();
var event_end_month=new Number();
var event_end_date=new Number();
var event_end_weekday=new String();
var maintenance_m=new Number();
var maintenance_d=new Number();
var maintenance_w=new Number();
count=0;
//HTML body elements
	if(isIE(5)||isIE(6)||isIE(7))
	{
		text = "<div data-role=\"page\" data-theme=\"a\" id=\"home\"><div data-role=\"header\"><h1>您的浏览器版本过低，页面元素无法正常显示。请使用Chorme访问或更新至Internet Explorer 9以上版本</h1></div>";
		document.write(text);
	}
else
{
	text = checkCookie();
	text += "<div data-role=\"page\" data-theme=\"a\" id=\"home\"><div data-role=\"header\"  style=\"position:fixed;top:0px;right:0px;width:100%;z-index:500\"><h4>";
	text += "Kantai Collection Notification(Ver1.5.2)";
	text += "<span id=\"cookie\" align=\"right\" class=\"header\" onClick=\"delCookie()\">";
	text += "</span></h4>";
	text +="</div><div data-role=\"navbar\" style=\"margin-top:2.7em;\">";
	text +="<ul><li>";
	text +="<a href=\"#home\"  data-icon=\"home\">首页</a></li><li><a href=\"#twitter\" data-transition=\"slide\" data-icon=\"arrow-r\">官推截图</a></li><li><a href=\"#about\" data-icon=\"info\" data-transition=\"slide\">关于</a></li></ul></div>";
	if(document.URL.indexOf("v2") == -1)
	{
		text += "<div data-role=\"content\" style=\"margin-top:5em;\"><a href=\"kancollev2.html\" target=\"blank\"><button>此页面已经停止维护,点击此前往新版</button></a></div>";
	}
	text += "\n<div data-role=\"content\" id=\"loading\" data-theme=\"c\" style=\"height:1em;overflow-x:visible;\"><h3></h3></div>";
	text += "\n<div data-role=\"content\" style=\"position:relative;width:80%;\" id=\"time\" data-theme=\"c\"></div>";
	text += "\n<div data-role=\"content\" id=\"countdown\" data-theme=\"c\" style=\"float:right;top:-18em;\"></div>";
	text += "\n<div data-role=\"content\" id=\"nowtime\" data-theme=\"c\"></div>";
	text += "<div data-role=\"dialog\" id=\"alert-dialog\" style=\"margin-top:2em;\"><div data-role=\"header\" data-theme=\"a\"><h1>来自网页的信息</h1></div><div role=\"main\" class=\"ui-content\" style=\"background-color:#ffffff;\"><h1>Delete cookie complete!</h1><p align=\"center\" style=\"opacity:1;\">该网页的Cookie已经从您的设备中删除。</p><a href=\"#home\" data-role=\"button\" data-theme=\"b\" id=\"test\">关闭</a></div></div>";
	text += btncookie(1);
	text += "<br><br><br><br><br>";
	text += "\n<div data-role=\"footer\" style=\"position:fixed;bottom:0px;right:0px;width:100%;\" id=\"footer\"><h1></h1></div></div>";
	text += "\n<div data-role=\"page\" data-theme=\"a\" id=\"twitter\">";
	text += "\n<div data-role=\"header\" style=\"position:fixed;top:0px;right:0px;width:100%;z-index:999\">";
	text += "\n<h1>Kantai Collection Notification(Ver1.5)</h1>";
	text += "\n</div><div data-role=\"navbar\" style=\"margin-top:1.52em;width:100%;\">;"
	text += "\n<ul><li><a href=\"#home\" data-transition=\"slide\" data-direction=\"reverse\" data-icon=\"home\">首页</a></li>";
	text += "\n<li><a href=\"#twitter\" data-icon=\"arrow-r\">官推截图</a></li>";
	text += "\n<li><a href=\"#about\" data-icon=\"info\" data-transition=\"slide\">关于</a></li>";
	text += "</ul></div>";
	text += "\n<div data-role=\"content\" id=\"twitter1\" data-theme=\"c\" style=\"position:relative;margin-top:5em;\">";
	text += btncookie(2);
	text += "\n<iframe id=\"ifm\" frameborder=\"0\" height=\"4800em\" scrolling=\"no\"  align=\"middle\" marginwidth=\"40px\"  marginheight=\"80px\"  width=\"100%\" style=\"margin-top:-2.3em;\" src=\"http://www.haoyuan.info/twitter/index.php?t=20&get=tweet\"></iframe>";
	text += "\n</div><br><div data-role=\"footer\" id=\"footer_1\" style=\"position:fixed;bottom:0px;right:0px;width:100%;\"><h1></h1></div></div>";
	text += "\n<div data-role=\"page\" data-theme=\"a\" id=\"about\">";
	text += "\n<div data-role=\"header\" style=\"position:fixed;top:0px;right:0px;width:100%;z-index:999\">";
	text += "\n<h1>Kantai Collection Notification(Ver1.5)</h1>";
	text += "\n</div><div data-role=\"navbar\" style=\"margin-top:1.52em;width:100%;\">;"
	text += "\n<ul><li><a href=\"#home\" data-transition=\"slide\" data-direction=\"reverse\" data-icon=\"home\">首页</a></li>";
	text += "\n<li><a href=\"#twitter\" data-icon=\"arrow-r\" data-transition=\"slide\" data-direction=\"reverse\">官推截图</a></li><li><a href=\"#about\" data-icon=\"info\" data-transition=\"slide\">关于</a></li></ul></div>";
	text += "\n<div data-role=\"content\" id=\"test\" data-theme=\"c\" style=\"position:relative;margin-top:5em;\">";
	text += "\n</div><br><div data-role=\"footer\" id=\"footer_2\" style=\"position:fixed;bottom:0px;right:0px;width:100%;\"><h1></h1></div></div>";
	if(getCookie("language")=="chinese")
	{
		$(document).ready(function(e) {
            $("a#changecn").hide();
        });
	}
	else if(getCookie("language")=="japanese")
	{
		$().ready(function(e) {
		   $("iframe").attr("src","http://www.haoyuan.info/twitter/index.php?t=20");	            
        });
			$(document).ready(function(e) {
               $("a#changejp").hide();
            });
	}
	$(document).on("pageinit","#home",function(){
  		$("div#home").on("swipeleft",function(){
    		$.mobile.changePage("#twitter",
			{
		    	   transition : "slide"
			}
			); 
  		});                       
	});
	$(document).on("pageinit","#twitter",function(){
		$("div#twitter").on("swipeleft",function(){
			$.mobile.changePage("#about",
			{
				transition : "slide"
			}
			);
		});
	});
	$(document).on("pageinit","#twitter",function(){
  		$("div#twitter").on("swiperight",function(){
   			$.mobile.changePage("#home", {  
                transition : "slide",  
            	    reverse : true  
            		}, true, true);  
  			});                       
		});
$(document).on("pageinit","#twitter",function(){
  $("iframe").on("swiperight",function(){
   $.mobile.changePage("#home", {  
                transition : "slide",  
                reverse : true  
            }, true, true);  
  });                       
});
$(document).on("pageinit","#about",function(){
	$("div#about").on("swiperight",function (){
		$.mobile.changePage("#twitter",{
			transition :　"slide",
			reverse : true
		},true,true);
	});
});
$(document).ready(function(e) {
    $("a#changecn").click(function()
	{
		$("iframe").attr("src","http://www.haoyuan.info/twitter/index.php?t=20&get=tweet");
		$("a#changecn").hide("fast");
		$("a#changejp").show("fast");
		setCookie("language","chinese",3650);
		})
});
$(document).ready(function(e) {
    $("a#changejp").click(function(){
	$("iframe").attr("src","http://www.haoyuan.info/twitter/index.php?t=20");
	$("a#changejp").hide("fast");
	$("a#changecn").show("fast");
	setCookie("language","japanese",3650);
	});
});
document.write(text);
var footer = new Object();
footer = document.getElementById("footer");
var yr=new Date();
var copyright = "<p align=\"center\"><span class=\"bold\" id=\"fcopy\">Copyright © 2014-"+(parseInt(yr.getFullYear()))+" All rights reserved</span></p>";
footer.innerHTML = copyright;
var footer_1 = document.getElementById("footer_1");
footer_1.innerHTML = "<p align=\"center\"><span class=\"bold\" id=\"fcopy1\">Copyright © 2014-"+(parseInt(yr.getFullYear()))+" All rights reserved</span></p>";
var footer_2 = document.getElementById("footer_2");
footer_2.innerHTML = "<p align=\"center\"><span class=\"bold\" id=\"fcopy2\">Copyright © 2014-"+(parseInt(yr.getFullYear()))+" All rights reserved</span></p>";
forIE();
if(returnUserAgent("useragent") != "Mobile")
{
	var x=document.getElementById("countdown").style;
	var z=document.getElementById("nowtime").style;
	z.cssFloat="right";
	z.marginTop="-20em";
	x.cssFloat="right";
	x.right="-36em";	
	x.marginTop="-9em";
}
else if(returnUserAgent("useragent") == "Mobile")
{
	var y=document.getElementById("countdown").style;
	y.cssFloat="left";
	y.marginTop="0em";
	var a=document.getElementById("fcopy").style;
	a.fontSize="20px";
	var b=document.getElementById("fcopy1").style;
	b.fontSize="20px";	
	var c=document.getElementById("fcopy2").style;
	c.fontSize="20px";
}
loadinganimation();
if(window.console)
{
console.timeEnd("running bodyvalue use time");
}
//函数部分
function forIE()
{
	if(isIE())
	{
		alert("您正在使用Internet Explorer或IE内核的浏览器浏览该网页\n由于IE内核Trident对JQuery Mobile的兼容性限制，在Internet Explorer 8平台上会出现页面元素排布不正确的情况。\n推荐您使用Webkit内核的浏览器浏览\n（如Chrome浏览器、搜狗浏览器高速模式、360极速浏览器、Safari等）\n或将浏览器更新到Internet Explorer 9 及以上\n(仍会有部分功能不能正常运作)");
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
function checkCookie()
{
	if(returnUserAgent("useragent") == "Mobile")
	{
		mobileplayer=getCookie("mobileplayer");
		if(mobileplayer=="true")
		{
			return "<audio src=\"http://www.haoyuan.info/music/wacci.mp3\" autoplay=\"autoplay\" controls></audio>";
		}	
		else if(mobileplayer=="false")
		{
		//continue;
		}
		else
		{
			var Okplayer=confirm("是否开启HTML5播放器?\n该功能10天内有效");
			if(Okplayer==true)
			{
				setCookie("mobileplayer","true",10);
				return "<audio src=\"http://www.haoyuan.info/music/wacci.mp3\" autoplay=\"autoplay\"></audio>";
			}
			else if(Okplayer==false)
			{
				setCookie("mobileplayer","false",10);
			}
		}
	}
	else
	{
		flashplayer=getCookie("flashplayer");
		if(flashplayer=="true")
		{
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
	var cval_m;
		cval=getCookie("flashplayer");
		if(cval!=null)
		{
			 document.cookie="flashplayer="+cval+";expires="+del.toGMTString();
		}
	  cval_m=getCookie("mobileplayer");
	  if(cval_m!=null) document.cookie= "mobileplayer="+cval+";expires="+del.toGMTString();	
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
function btncookie(code)
{
	var co=getCookie("mobileplayer")+getCookie("flashplayer");
	var lang=getCookie("language");
	if(code==1)
	{
	if(co!=""&&co!=null)
	{
	return "<a href=\"#alert-dialog\" data-role=\"button\" style=\"position:fixed;width:100px;float:right;right:1em;top:80%; z-index:999\" id=\"cookie_a\" data-rel=\"dialog\" data-transition=\"pop\">删除Cookie</a>";
	}
	}
	else if(code==2)
	{
		if(lang=="japanese")
		{
			return	"<a href=\"#\" data-role=\"button\" style=\"position:fixed;width:11em;float:right;right:1em;top:80%; z-index:999\" id=\"changecn\" >切换中文（自动翻译）</a><a href=\"#\" data-role=\"button\" style=\"position:fixed;width:7em;float:right;right:1em;top:80%; z-index:999\" id=\"changejp\">切换原文</a>";
		}
		else if(lang=="chinese")
		{
			return "<a href=\"#\" data-role=\"button\" style=\"position:fixed;width:11em;float:right;right:1em;top:80%; z-index:999\" id=\"changecn\" >切换中文（自动翻译）</a><a href=\"#\" data-role=\"button\" style=\"position:fixed;width:7em;float:right;right:1em;top:80%; z-index:998\" id=\"changejp\">切换原文</a>";	
		}
		else
		{
			var Thislanguage=confirm("是否需要翻译twitter原文?");
			if(Thislanguage==true)
			{
				setCookie("language","chinese",3650);
				return	"<a href=\"#\" data-role=\"button\" style=\"position:fixed;width:11em;float:right;right:1em;top:80%; z-index:999\" id=\"changecn\" >切换中文（自动翻译）</a><a href=\"#\" data-role=\"button\" style=\"position:fixed;width:7em;float:right;right:1em;top:80%; z-index:999\" id=\"changejp\">切换原文</a>";
			}
			else
			{
				setCookie("language","japanese",3650);	
				return	"<a href=\"#\" data-role=\"button\" style=\"position:fixed;width:11em;float:right;right:1em;top:80%; z-index:999\" id=\"changecn\" >切换中文（自动翻译）</a><a href=\"#\" data-role=\"button\" style=\"position:fixed;width:7em;float:right;right:1em;top:80%; z-index:999\" id=\"changejp\">切换原文</a>";
			}
		}
	}
}
function showbtn_cn()
{
	$("a#changecn").show();
}
function showbtn_jp()
{
	$("a#changjp").show();	
}
function loadinganimation()
{
	var str=new String();
	var ostr=new String();
	str="<h3>加载中";
	if(count==0)
	{
		ostr=str+"</h3>";
		count++;
	}
	else if(count==1)
	{
		ostr=str+".</h3>";
		count++;	
	}
	else if(count==2)
	{
		ostr=str+"..</h3>";
		count++;
	}
	else if(count==3)
	{
		ostr=str+"...</h3>";
		count=0;
	}
	document.getElementById("loading").innerHTML=ostr;
	timeout=setTimeout(function(){loadinganimation();},300);
}
}