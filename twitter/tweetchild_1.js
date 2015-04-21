var tweet=document.getElementsByTagName("p");
var timetext="";
var txt=new Array();
var _txt=new Array();
var timeout=new String();
var open_time="次回";
var pub="/";
var start="【";
var end="】";
var maintenance="メンテナンス";
var kaihou="開放";
var counter=new Number();
var strx=new String();
counter=0;
timeout="";
for(i=0;i<tweet.length;i++)
{
var strtweet=tweet[i].firstChild.nodeValue;
if(isString(strtweet)){
txt[i]=strtweet;
/*
document.getElementById("time").innerHTML+=txt[i];
*/
}
}
for(b=0;b<txt.length;b++){
	if(txt[b]!=undefined&&(txt[b].indexOf(open_time)!=-1||txt[b].indexOf(kaihou)!=-1)&&txt[b].indexOf(start)!=-1){
	_txt.push(txt[b]);
	}
}
for(j=0;j<txt.length;j++)
{
	intxt=_txt[j];
	var str_s=new Number();
	var str_e=new Number();
	var com=new String();
	if((intxt.indexOf(open_time)!=-1||intxt.indexOf(kaihou)!=-1)&&intxt.indexOf(maintenance)==-1){
		for(z=0;z<intxt.length;z++)
		{
			if(intxt.charAt(z)==start){
				str_s=z;
				}
			if(intxt.charAt(z)==end){
				str_e=z;
			}
			var strn=intxt.substring(str_s+1,str_e);
			if(strn!=com){
				com=strn;
			}
			else{
				continue;
			}
			if(strn.indexOf("曜日")!=-1){
				counter+=1;
			}
			if(strn.indexOf("名")!=-1){
				counter+=1;
			}
			if(counter!=0&&counter%2==0)
			{
				break;
			}
			if(isNaN(strn.charAt(0))==0){
			strx+="下次抢号时间&nbsp;<br>"+strn+"\n";
            strn=intxt.substring(intxt.lastIndexOf(start)+1,intxt.lastIndexOf(end));
			strx+="<br>"+strn;
			document.getElementById("remove").innerHTML="<div id=\"time\"></div>";
			var di=document.getElementById("time");
			di.innerHTML=strx;
		}}
		}		
}

function isString(str){ 
return (typeof str=='string')&&str.constructor==String; 
} 
function isNumber(obj){ 
return (typeof obj=='number')&&obj.constructor==Number; 
} 
