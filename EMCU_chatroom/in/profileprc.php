<?php
ob_start();
session_start();
include("../include/db.php");
if(!isset($_COOKIE['user']))
{
	header('location:../index.php');
}
else
{
	echo '<html>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="../include/style.css" rel="stylesheet"></link>
	<center><body>
	<div id="header">SkyChat</div><br><br><br><br><br>';

	if(empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['gender']) || empty($_POST['home_town']))
	{
		echo 'all fields are mandatory and cant be empty<br><a href="my_profile.php"><input type="button" value="back"></input></a>';
		exit;
	}
	else
	{
		$name = $_POST['first_name'];
		$surname = $_POST['last_name'];
		$home_town = $_POST['home_town'];
		$gender = $_POST['gender'];
		$uid = $_COOKIE['uid'];
		if(!$dbc)
		{
			die('cant connect to db'.mysqli_connect_error());
		}
		else
		{
			$sql = "INSERT INTO profile(uid,first_name,last_name,home_town,gender) VALUES('$uid','$name','$surname','$home_town','$gender')";
			$query = mysqli_query($dbc,$sql);
			if(!$query)
			{
				die('cant query to db '.mysqli_error($dbc));
			}
			else
			{
				$_SESSION['status'] = "complete";
				header('location:my_profile.php');
			}
		}
	}
}
ob_flush();