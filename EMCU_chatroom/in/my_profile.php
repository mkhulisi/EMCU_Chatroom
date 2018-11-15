<?php
session_start();
include("../include/db.php");
if(!isset($_COOKIE['user']))
{
	header('location:../index.php');
}
else
{
	
	$status = $_SESSION['status'];
	$uid = $_COOKIE['uid'];
	$username = $_COOKIE['user'];
	if($status == "complete")
	{
		if(!$dbc)
		{
			die('cant connect to db'.mysqli_connect_error());
		}
		else
		{
			$sql = "SELECT * FROM profile WHERE uid = '$uid'";
			$query = mysqli_query($dbc,$sql);
			if(!$query)
			{
				die('cant query from db '.mysqli_error($dbc));
			}
			else
			{	
				echo '<html>
				<head>
				<style>
				#header
				{
					position: fixed; 
					background-color: #21284F;
					top: 0px; 
					left: 0px;
					width: 100%; 
					height: 200px;
					z-index: 3;
				}
				#profile_form_container
				{
					position: relative;
					top: 247px;
					background-color: #21284F;
					border-radius: 40px;
					color: white;
					width: 320px;
					height: 489px;
					box-shadow: 0px 0px 5px white;
					z-index: 2;
				}
				input[type="text"],input[type="password"]
				{
					position: relative;
					margin: 5px;
					color: white;
					background-color: #086288;
					height: 50px;
					width: 250px;
					border: none;
					border-top-left-radius:21px;
				}
				</style>
				<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
				<link href="style.css" rel="stylesheet"></link>
				</head>

				<center><body bgcolor="gray">
				<div id="header"><font color="white">EMU Chatroom</font>
				<br>
				<a href="index.php"><input type="button" value="Back"></input></a>
				<br>
				<div id="status_update_form"><form action="update_status.php" method="POST">
				<textarea maxlength="30" cols="30" rows="5" name="status" placeholder="type your Status update here"></textarea>
				<br>
				<input type="submit" value="Update"></input>
				</form></div></div>

				<div id="profile_form_container">';
				$to = $_COOKIE['user'];
				while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
				{
					$path = profilePicpath($dbc,$uid);
					echo '<br><font size="10px"><a href="profile_picupload.php"><img src="'.$path.' " name="profile"</img></a></font><br><b>NAME: </b>'.$row['first_name'].'<br>
					<b>SURNAME: </b>'.$row['last_name'].'<br>
					<b>TOWN: </b>'.$row['home_town'].'<br>
					<b>GENDER: </b>'.$row['gender'].'<br>
					'.StatusUpdateprofile($to,$dbc).'';
				}
				echo '<hr>Change Password<br>
				<form action="pchangeprc.php" method="POST">
				<input type="text" name="old_password" placeholder="Enter old password"/>
				<br>
				<input type="password" name="new_password" placeholder="Enter new password"/>
				<br>
				<input type="password" name="passwordv" placeholder="Verify new password"/>
				<br>
				<input type="submit" value="Change"/>
				</form>
				<br><br><br><br><br><br>
				</form>
				</div>
				</body>
				</center>
				</html>';
			}
		}
	}
	else
	{
		echo '<html>
		<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="style.css" rel="stylesheet"></link>
		<style type="text/css">
		#header
		{
			position: fixed; 
			background-color: #21284F;
			top: 0px;
			left: 0px;
			width: 100%; 
			height: 200px;
			z-index: 3;
		}
		#profile_form_container
		{
			position: relative;
			top: 170px;
			background-color: #21284F;
			border-radius: 40px;
			color: white;
			width: 320px;
			height: 489px;
			box-shadow: 0px 0px 5px white;
			z-index: 2;
		}
		</style>
		</head>

		<center><body bgcolor="gray">

		<div id="header"><font color="white">EMU Chatroom</font>
		<br>
		<a href="index.php"><input type="button" value="Back"></input></a>
		<br>
		<div id="status_update_form"><form action="update_status.php" method="POST">
		<textarea maxlength="30" cols="30" rows="5" name="status" placeholder="type your Status update here"></textarea>
		<br>
		<input type="submit" value="Update"></input>
		</form></div></div>

		<div id="profile_form_container">
		<br>
		<font color="white">Welcome on EMCU Chatroom <b>'.$username.'</b>, your account has been created successfully. Please update your  profile to complete your registration</font><br>
		<font size="10px">👤</font>
		<form action="profileprc.php" method="POST">
		<input type="text" name="first_name" placeholder="Name"></input>
		<br>
		<input type="text" name="last_name" placeholder="Surname"></input>
		<br>
		<input type="text" name="home_town" placeholder="Home town"></input>
		<br>
		Select your Gender
		<br>
		Male<input type="radio" name="gender" value="male"></input>
		<br>
		Female<input type="radio" name="gender" value="female"></input>
		<br>
		<input type="submit" value="update profile"></input>
		</form>
		<br><br><br>
		<br><br><br>
		<br><br><br>
		<br><br><br>
		</div>
		</body>
		</center>
		</html>';
	}
}