<?php
session_start();
include("../include/db.php");
if(!isset($_COOKIE['user']))
{
	header('Location:../index.php');
}
else
{
	$uid = $_COOKIE['uid'];
	$requester_uid = $_GET['requester_uid'];
	$friend_username = $_GET['friend_username'];
	$choice = $_GET['choice'];
	$user = $_COOKIE['user'];
	if(!$dbc)
	{
		die('cant connect to db'.mysqli_connect_error());
	}
	else
	{
		if($choice == "reject")
		{
			$sql = "DELETE FROM friendship WHERE uid = '$requester_uid' AND friend_username = '$user'";
			$query = mysqli_query($dbc,$sql);
			if(!$query)
			{
				die('cant query to db '.mysqli_error($dbc));
			}
			else
			{
				echo '
				<script type="text/javascript">
				alert("Friend request declined");
				document.location="index.php";
				</script>';
				exit;
			}
		}
		else
		{
			$sql = "INSERT INTO friendship(uid,username,friend_username,status,friendship_date) VALUES('$uid','$user','$friend_username','accepted',NOW())";
			$query = mysqli_query($dbc,$sql);
			$sql1 = "UPDATE friendship SET status = 'accepted',friendship_date = NOW() WHERE username = '$friend_username' AND friend_username = '$user'";
			$query1 = mysqli_query($dbc,$sql1);
			if(!$query || !$query1)
			{
				die('cant query to db'.mysqli_error($dbc));
			}
			else
			{
				echo '
				<script type="text/javascript">
				alert("Friend request accepted");
				document.location="index.php";
				</script>';
				exit;
			}
		}
	}
}