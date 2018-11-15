<?php
session_start();
include("../include/db.php");
#functions
$uid = $_COOKIE['puid'];
$path = profilePicpath($dbc,$uid);
if(empty($_SESSION['url']))
{
	$from = $_GET['url'];
}
else
{
$from = $_SESSION['url'];
}

if(!isset($_COOKIE['user']))
{
	header('location:../index.php');
}
else
{

	echo '<html>
	<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="style.css" rel="stylesheet"></link>
	<style type="text/css">
	#about
	{
		position: relative;
		width: 80%;
		background-color: #21284f;
		border-bottom-left-radius: 70px;
		color: white;
	}
	</style>
	</head>

	<center><body bgcolor="gray">
	<div id="header_index">EMCU Chatroom<br>About User</div>
	<br><br><br><br>
	<br><br><br><br>';
	$pal_uid = $_COOKIE['puid'];
	$pal_username = $_COOKIE['to'];
	$my_username = $_COOKIE['user'];
	$my_uid = $_COOKIE['uid'];
	if(!$dbc)
	{
		die('cant connect to db'.mysqli_connect_error());
	}
	else
	{	#get pal's profile infor
		$sql = "SELECT * FROM profile WHERE uid = '$pal_uid'";
		$query = mysqli_query($dbc,$sql);
		if(!$query)
		{
			die('cant query from db '.mysqli_error($dbc));
			}
			else
			{
				while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
			{
				$name = $row['first_name'];
				$surname = $row['last_name'];
				$home_town = $row['home_town'];
				$gender = $row['gender'];
			}#get user profile infor
			mysqli_free_result($query);
			#check if friend request was sent or not
			$sql = "SELECT * FROM friendship WHERE username = '$my_username' AND friend_username = '$pal_username' AND status='pending' OR username = '$pal_username' AND friend_username = '$my_username'";
			$query = mysqli_query($dbc,$sql);
			if(!$query)
			{
				die('cant query from db '.mysqli_error($dbc));
			}
			else
			{
				while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
				{
					$status = $row['status'];
					$fdate = $row['friendship_date'];
					$friend_username = $row['friend_username'];
				}
				if($status == "pending")#get if friend request was sent or not
				{
					About_user($name,$surname,$home_town,$gender,$path);
					echo "<hr><i>A friend request was sent to <b>$friend_username</b> on <b>$fdate</b> and its still pending</i><br>";
					echo '<br><a href="People.php"><input type="button" value="Back"></input></a>';
					exit;
				}
				else if($status =='accepted')#if already friends 
				{
					About_user($name,$surname,$home_town,$gender,$path);
					echo '<br>friends since '.$fdate.'
					<br><a href="'.$from.'"><input type="button" value="Back"></input></a>';
				}
				else
				{
					About_user($name,$surname,$home_town,$gender,$path);
					$path = profilePicpath($dbc,$uid);
					echo '<br><a href="add_friend.php?my_uid='.$my_uid.'&my_username='.$my_username.'&pal_username='.$pal_username.'"><input type="button" value="➕ add friend"></input></a><br><a href="'.$from.'"><br><input type="button" value="Back"></input></a>';
				}
				mysqli_free_result($query);
				mysqli_close($dbc);
			}
		}
	}
	unset($_GET['url']);
}