<?php 
session_start();
include("../include/db.php");
$to = $_COOKIE['to'];
$uid = $_COOKIE['puid'];
$path = profilePicpath($dbc,$uid);
if(!isset($_COOKIE['user']))
{
	header('location:../index.php');
}
else
{

}
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>SkyChat</title>
<script type="text/javascript" src="../include/script.js" ></script>

<link rel="stylesheet" href="style.css"></link>
</head>

<center><body bgcolor="gray" onload="JavaScript:getChats('getchats.php','chat','message');">

<div id="headerpublic_index">
<?php echo '<img name="chat" src="'.$path.'"</img>';?>
<input  type="button" value="Back" onclick="Back()">
<a href="about.php?url=chat.php"><input type="button" value="About"></input></a>
<br><br><br><br><br>
<form action ="#" name="ch" OnSubmit="getData('getchats.php','chat','message')">
<textarea name="message" id="message" placeholder="Type your message here"></textarea>
<br>
<font size="7"><input name="message" type="submit" value="Send"></input></font>
</form>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div id="chat"></div>	


</body>
</center>
</html>