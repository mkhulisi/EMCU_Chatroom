<?php 
session_start();
ob_start();
include("../include/db.php");
if(!isset($_COOKIE['user']))
{
	header('location:../index.php');
	exit;
}
else
{
	if($_SESSION['status'] == "incomplete")
	{
		header('Location:my_profile.php');
		exit;
	}
	else
	{
		if(isset($_COOKIE['destination']))
		{
			unset($_COOKIE['destination']);
			setcookie( "to", "", time()- 60, "/","", 0);
		}
		$user =$_COOKIE['user'];
		$uid = $_COOKIE['uid'];
	}
	echo '<html>
	<head>
	<script type="text/javascript" src="../include/script.js" ></script>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="style.css" rel="stylesheet"></link>
	</head>
	<center><body bgcolor="gray">
	<div id="header_index">
	<br>
	<input type="button" name="home_people" value="People" onclick="People()"</input>
	<input type="button" name="home_logout" value="Logout" onclick="Logout()"</input>
	<input type="button" name="home_public" value="Public" onclick="public()"</input>
	<br>
	<input type="button" name="home_profile" value="My profile" onclick="myProfile()"</input></div>';

	if(!$dbc)
	{
		die('cant connect to db '.mysqli_connect_error());
	}
	else
	{
		$sql = "SELECT * FROM friendship WHERE friend_username = '$user' AND status = 'pending'";
		$query = mysqli_query($dbc,$sql);
		if(!$query)
		{
			die('cant query from db '.mysqli_error($dbc));
		}
		else
		{	
			//get notifications count
			$x = 0;
			while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
			{	
				$x++;
				setcookie("$x", "{$row['uid']}", time()+3600, "/", "",0);
				$requester = $row['username'];
			}
			if(mysqli_num_rows($query) > 0)
			{
				echo '<br><div id="notification"><b><a href="friend_request.php?requests='.mysqli_num_rows($query).'&requestername='.$requester.'">'.mysqli_num_rows($query).'🔔</a></b></b></div>';
			}
			echo'</div>';
		}
		//get messages count
		$Sql = "SELECT * FROM cahats WHERE destination = '$user' AND message_read_status ='✅'";
		$Query = mysqli_query($dbc,$Sql);
		if(!$Query)
		{
			die('query failed because '.mysqli_error($dbc));
		}
		else
		{
			if(mysqli_num_rows($Query) > 0)
			{
				echo '<br><div id="messagenotification">'.mysqli_num_rows($Query).'📩</div>';
			}
			$control = 0;
			while($row = mysqli_fetch_array($Query,MYSQLI_ASSOC))
			{
				$senders = $row['sender'];
				$control ++;
			}	
		}
		//get friend list
		$sql = "SELECT uid,username FROM friendship WHERE friend_username = '$user' AND status = 'accepted'";
		$query = mysqli_query($dbc,$sql);
		if(!$query)
		{
			die('cant query from db '.mysqli_error($dbc));
		}
		else
		{		
			echo '<br><br><br><br><br><br><div id="friends">My Friends';
			//get friend list and messages sent to me
			while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
			{
				$uid = $row['uid'];
				$path = profilePicpath($dbc,$uid);
				$sender = $row['username'];
				$to = $row['username'];
				$cm = getSentMessageCount($dbc,$sender,$user);
				if($cm >= 1)
				{	
					echo '<div id="friendsbox">'.$row['username'].'<br><a href="tochat.php?to='.$row['username'].'&puid='.$row['uid'].'"><img src="'.$path.'"</img></a><br><br>'.StatusUpdate($to,$dbc,$cm).'<br></div>';
					$fuid = $row['uid'];
					echo '<div id="message_count"><font color="yellow"><br><br>'.$cm.'📩</font></div>';
				}
				else
				{
					
					echo '<div id="friendsbox"><br>'.$row['username'].'<br><a href="tochat.php?to='.$row['username'].'&puid='.$row['uid'].'"><img src="'.$path.'"</img></a><br>'.StatusUpdate($to,$dbc,$cm).'<br></div>';
					$fuid = $row['uid'];
				}

				//get friend requests notifications
			}
			if(empty($fuid))
			{
					
				echo '<div id="friendsbox"><br>you dont have any friends yet<br>
				<a href="People.php"><input type="button" value="Find friends"></input></a></div>';
			}
			mysqli_free_result($query);
		}	
	}
	echo '<br><br></div><br><br></center></body></html>';
	ob_flush();	
}	