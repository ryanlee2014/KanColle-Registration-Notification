<?php
$html=new DOMDocument();
$html->load("test.xml");
$time=$html->getElementsByTagName('time');
$time_count=$time->length-1;
$times=$time->item($time_count);
$weekday=$times->getElementsByTagName('weekday');
$weekday_count=$weekday->length-1;
$weekdays=$weekday->item($weekday_count);
$tes=$weekdays->nodeValue="tefsafaes";
$html->save("test.xml");
header('Content-Type:application/xml;charset=utf-8');
echo $weekday->nodeValue;
echo $html->saveXML();
?>