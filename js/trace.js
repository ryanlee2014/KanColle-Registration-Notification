var now = new Date();
var number = now.getYear().toString() + now.getMonth().toString() + now.getDate().toString() + now.getHours().toString() + now.getMinutes().toString() + now.getSeconds().toString();
document.write("\<script src=\"../trace.php?" + number + "\"><\/script\>");