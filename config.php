<?php
if (!isset ($_SESSION)) {
	ob_start();
	session_start();
}
 $hostname="localhost"; 
 $basename="*****"; 
 $basepass="*****"; 
 $database="*****"; 

 $conn=mysql_connect($hostname,$basename,$basepass)or die("error!"); //連接mysql              
 mysql_select_db($database,$conn); //選擇mysql資料庫
 mysql_query("set names 'utf8'");//mysql編碼
?>