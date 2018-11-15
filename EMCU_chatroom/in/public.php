<?php 
session_start();
include("../include/db.php");
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

<center><body bgcolor="gray" onload="JavaScript:getPosts('getposts.php','chat');">
<div id="headerpublic_index">
<br>
<input  type="button" value="Back" onclick="Back()">
<a href="People.php?url=publick.php"><input type="button" name="public_people" value="People"></input></a>
<input type="button" name="logout" value="Logout" onclick="Logout()"></input>
<br><br><br><br><br>
<form action ="#" name="public" OnSubmit="postPost('getposts.php','chat','message')">
<textarea id="message" name="postmessage" placeholder="Type your post here"></textarea>
<br>
<font size="7"><input name="post" type="submit" value="Send"></input></font>
</form>
</div>

<div id="chat"></div>
</body>
</center>
</html>
