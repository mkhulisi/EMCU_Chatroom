<?php
session_start();
include("../include/db.php");
if(!isset($_COOKIE['user']))
{
	header('Location:../index.php');
}
else
{
}
?>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="style.css" rel="stylesheet"></link>
	 <script type="text/javascript">
			var w = document.ineerWidth;
			document.write('<style>#header{position: relative; background-color: #21284F; top: 0px; width:'+w,'px; height: 100px; z-index: 3; color: white;} #chat{position: relative;top: 0px; background-color: #21284F; width:'+w,'px;color: white;height: 650px;overflow:scroll;}</style>');
		</script>
	</head>
	<center><body>
	<div id="header">SkyChat</div><br><br><br>
	
<?php
	if(!$dbc)
	{
		die('cant connect tot db '.mysqli_connect_error());
	}
	else
	{	
		$my_uid = $_GET['my_uid'];
		$my_username = $_GET['my_username'];
		$friend_username = $_GET['pal_username'];

		$sql = "INSERT into friendship(uid,username,friend_username,friendship_date,status) VALUES('$my_uid','$my_username','$friend_username',NOW(),'pending')";
		$query = mysqli_query($dbc,$sql);
		if(!$query)
		{
			die('cant query into db'.mysqli_error($dbc));
		}
		else
		{
			echo 'A friend request has been sent to <b>'.$friend_username.'</b><br>
			<a href="People.php"><input type="button" value="Back"></input></a>';
		}
	}