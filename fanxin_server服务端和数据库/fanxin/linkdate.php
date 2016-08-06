<?php

$server="localhost";
$username=" ";
$password=" ";
 $link=mysql_connect($server,$username,$password) or die("连接数据库失败");
$ok=mysql_select_db(" ",$link);
/*if($ok){
    echo("链接数据库成功<br>");
}
else echo("链接数据库失败<br>")*/
?>
