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
	$user = $_COOKIE['user'];

	if(empty($_POST['status']))
	{
		echo '<script type="text/javascript">
		alert("cant Update with empty status update");
		document.location="my_profile.php";
		</script>';			
		exit;
	}
	else
	{
		$status_update = $_POST['status'];
		if(!$dbc)
		{
			die('cant connection to db failed '.mysqli_connect_error());
		}
		else
		{
			$sql = "UPDATE users SET status_update = '$status_update' WHERE username = '$user'";
			$query = mysqli_query($dbc,$sql);
			if(!$query)
			{
				die('cant query to db '.mysqli_error($dbc));
			}
			else
			{
				header('Location: my_profile.php');
			}
		}
	}
}
ob_flush();