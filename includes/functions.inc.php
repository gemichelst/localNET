<?php
# GENERAL INFOS
# STATE 1 = new | STATE 2 = read
$datetime=date('Y-m-d H:i:s');


# GENERATE RANDOM STRING 
function generateRandomString($length = 5) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
# /////////////////////////////////////////////////////////////////////////////////

/*
# LIST USERDATA
function listUserdata($uid,$pw,$sid,$datetime) {
$sql_listUserdata=mysql_query( "SELECT * FROM user WHERE uid='$uid' AND pw='$pw' AND sid='$sid' LIMIT 0,1 ") or die(mysql_error());
$sql_deleteDuplicates=mysql_query("DELETE FROM user WHERE sid='$sid' AND uid != '$uid' AND pw != '$pw' ") or die(mysql_error());
$listUserdata_count=mysql_num_rows($sql_listUserdata);
if($listUserdata_count >= 1) { 
$data_listUserdata=mysql_fetch_array($sql_listUserdata);
$uid=$data_listUserdata["uid"];
$_SESSION["uid"]=$uid;
$pw=$data_listUserdata["pw"]; 
$_SESSION["pw"]=$pw;
$sid=$data_listUserdata["sid"]; }
session_id($sid);
$sql_updateUserdata=mysql_query( "UPDATE user SET last_action='$datetime' WHERE uid='$uid' AND pw='$pw' AND sid='$sid'") or die(mysql_error());
}
# /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/ 

# SET UID PW
if(isset($_SESSION["uid"]) && isset($_SESSION["pw"])) { 
$_SESSION["uid"]=$_SESSION["uid"]; $_SESSION["pw"]=$_SESSION["pw"]; $sid=session_id();
$uid=$_SESSION["uid"]; $pw=$_SESSION["pw"];
$sql_checkUID=mysql_query( "SELECT * FROM user WHERE uid='$uid' AND pw='$pw' OR sid='$sid'") or die(mysql_error());
$checkUID_count=mysql_num_rows($sql_checkUID);
if($checkUID_count < 1) { $sql_insertUID=mysql_query( "INSERT INTO user (uid,pw,sid) VALUES ('$uid','$pw','$sid') ") or die(mysql_error()); } else { $do="nothing"; }
} 
else { $_SESSION["uid"]=rand(1000,999999); $_SESSION["pw"]=generateRandomString(); 
$uid=$_SESSION["uid"]; $pw=$_SESSION["pw"]; $sid=session_id();
$sql_insertUID=mysql_query( "INSERT INTO user (uid,pw,sid) VALUES ('$uid','$pw','$sid')") or die(mysql_error());
}
# /////////////////////////////////////////////////////////////////////////////////


# SEND CONTENT
function sendContent() {
$sql_checkUID=mysql_query( "SELECT * FROM user WHERE uid='$to_uid' AND pw='$to_pw'") or die(mysql_error());
$checkUID_count=mysql_num_rows($sql_checkUID);
if($checkUID_count < 1) { $statusMsg="WRONG UID AND/OR PW GIVEN"; } else {
$sql_sendContent=mysql_query( "INSERT INTO content (content,from_uid,from_pw,from_sid,to_uid,to_pw,state) VALUES ('$to_content','$uid','$pw','$sid','$to_uid','$to_pw','1') ") or die(mysql_error());
$statusMsg="CONTENT DELIVERED"; }
}
# ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

# RECEIVE CONTENT
function receiveContent() {
$sql_receiveContent=mysql_query( "SELECT * FROM content WHERE to_uid='$uid' AND to_pw='$pw' AND state='1' LIMIT 0,1 ") or die(mysql_error());
$receiveContent_count=mysql_num_rows($sql_receiveContent);
if($receiveContent_count >= 1) { 
$data_receiveContent=mysql_fetch_array($sql_receiveContent);
$content=$data_receiveContent["content"];
$from_uid=$data_receiveContent["from_uid"];
$datetime=$data_receiveContent["datetime"]; }
}
# /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

# CHECK FOR CONTENT
$sql_myContent=mysql_query( "SELECT * FROM content WHERE to_uid='$uid' AND to_pw='$pw' AND state='1'") or die(mysql_error());
$myContent_count=mysql_num_rows($sql_myContent);
if($myContent_count >= 1) { } else { }
# //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>