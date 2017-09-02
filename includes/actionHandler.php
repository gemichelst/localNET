<?php
session_start();
error_reporting(E_ALL);
require('includes/mysql_connection.inc.php');
require('includes/functions.inc.php');


if($_GET["a"]=="send") {

	if(!isset($_GET["sid"]) OR empty($_GET["sid"])) { $statusMsg = "INVALID SESSION!"; echo $statusMsg; } 
elseif(!isset($_GET["u"]) OR empty($_GET["u"])) { $statusMsg = "NO UID GIVEN!"; echo $statusMsg; }  
elseif(!isset($_GET["p"]) OR empty($_GET["p"])) { $statusMsg = "NO PW GIVEN!"; echo $statusMsg; }  
elseif(!isset($_GET["c"]) OR empty($_GET["c"])) { $statusMsg = "NO CONTENT GIVEN!"; echo $statusMsg; }  
else {
$to_uid=$_GET["u"];
$to_pw=$_GET["p"];
$to_content=$_GET["c"];

$sql_checkUID=mysql_query( "SELECT * FROM user WHERE uid='$to_uid' AND pw='$to_pw' ") or die(mysql_error());
$checkUID_count=mysql_num_rows($sql_checkUID);
if($checkUID_count < 1) { $statusMsg="UID AND/OR PW NOT FOUND"; } else {
$sql_sendContent=mysql_query( "INSERT INTO content (content,from_uid,from_pw,from_sid,to_uid,to_pw,state,datetime) VALUES ('$to_content','$uid','$pw','$sid','$to_uid','$to_pw','1','$datetime') ") or die(mysql_error());
$statusMsg="CONTENT DELIVERED"; }


echo $statusMsg;
}
} # SEND

elseif($_GET["a"]=="receive") {
$sql_receiveContent=mysql_query( "SELECT * FROM content WHERE to_uid='$uid' AND to_pw='$pw' AND state='1' ORDER BY datetime ASC LIMIT 0,1 ") or die(mysql_error());
$receiveContent_count=mysql_num_rows($sql_receiveContent);
if($receiveContent_count >= 1) { 
$data_receiveContent=mysql_fetch_array($sql_receiveContent);
$content=$data_receiveContent["content"];
$from_uid=$data_receiveContent["from_uid"];
$datetime=$data_receiveContent["datetime"]; }

echo $content;	
} # RECEIVE

elseif($_GET["a"]=="close") {
$sql_closeContent=mysql_query( "SELECT * FROM content WHERE to_uid='$uid' AND to_pw='$pw' AND state='1' ORDER BY datetime ASC LIMIT 0,1 ") or die(mysql_error());
$closeContent_count=mysql_num_rows($sql_closeContent);
if($closeContent_count >= 1) { 
$data_closeContent=mysql_fetch_array($sql_closeContent);
$cid=$data_closeContent["cid"];
$sql_closeContent2=mysql_query( "UPDATE content SET state='2' WHERE cid='$cid' AND to_uid='$uid' AND to_pw='$pw' AND state='1'") or die(mysql_error());
$statusMsg="CONTENT $cid CLOSED"; echo $statusMsg; } else { $statusMsg="NO CONTENT FOUND"; echo $statusMsg; }
} # CLOSE

else { $statusMsg="NO ACTION GIVEN"; echo $statusMsg; }

?>