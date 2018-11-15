<?php 
session_start();
if($_GET['relationship'] == "unknown")
{
	$to = $_GET['to'];
	$pal_uid = $_GET['puid'];
	setcookie("puid", "$pal_uid", time()+3600, "/", "",0);
	setcookie("to", "$to", time()+3600, "/", "",0);
	header('Location: about.php?url=People.php');
}

else
{
	$to = $_GET['to'];
	$pal_uid = $_GET['puid'];
	setcookie("puid", "$pal_uid", time()+3600, "/", "",0);
	setcookie("to", "$to", time()+3600, "/", "",0);
	header('Location: chat.php');
}
