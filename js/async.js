if(returnUserAgent("useragent") != "Mobile")
{
	var x=document.getElementById("countdown").style;
	var z=document.getElementById("nowtime").style;
	var a=document.getElementById("maintenance").style;
	z.cssFloat="right";
	z.marginTop="-20em";
	x.cssFloat="right";
	x.right="-36em";	
	x.marginTop="-9em";
	a.cssFloat="right";
	a.marginTop="-20em";
	a.marginRight="15em";
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