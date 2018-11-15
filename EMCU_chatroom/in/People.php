<?php 
session_start();
include("../include/db.php");
if(!isset($_COOKIE['user']))
{
	header('location:../index.php');
}
else
{
	if(isset($_POST['search']))
	{
		if(empty($_POST['search']))
		{
			echo '<script type="text/javascript">
			alert("provide search key word");
			document.location="People.php";
			</script>';
			exit;
		}
		else
		{
			$user = $_COOKIE['user'];
			$find = $_POST['search'];
			if(!$dbc)
			{
				die('dbc connection failed because '.mysqli_connect_error());
			}
			else
			{
				$sql = "SELECT * FROM users WHERE username  !='$user' AND username LIKE'%$find%'";
				$query = mysqli_query($dbc,$sql);
				if(!$query)
				{
					die('query failed because '.mysqli_error($dbc));
				}
				else
				{
					if(mysqli_num_rows($query) == 0)
					{
						echo '<script type="text/javascript">
						alert("NO RESULTS MATCHING YOUR SEARCH");
						document.location="People.php";
						</script>';
						exit;
					}
					else
					{
						echo '<htm>
						<head>
						<script type="text/javascript" src="../include/script.js" ></script>
						<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
						<link href="style.css" rel="stylesheet"></link>
						</head>

						<center><body bgcolor="gray">
						<div id="headersearch_index"><a href="People.php"><input type="button" value="Back"/></a>
						<br>
						Search results matching <u><i>'.$find.'</i></u></div>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>';
						while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
						{
							$uid = $row['id'];
							$path = profilePicpath($dbc,$uid);
							echo '<a href="tochat.php?to='.$row['username'].'&puid='.$row['id'].'&relationship=unknown&url=People.php"><img src="'.$path.'"height="70"></img></a>
							<br>'.$row['username'].'
							<br><br>';
						}
						echo '</body>
						</center>
						</html>';
					}
				}
			}
		}
	}
	else
	{
		if(isset($_SESSION['destination']))
		{
			unset($_SESSION['destination']);
		}
		$user = $_COOKIE['user'];
		?>
		<htm>
		<head>
		<script type="text/javascript" src="../include/script.js" ></script>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="style.css" rel="stylesheet"></link>
		<style type="text/css">
			input[type="text"]
			{
				position: relative;
				border-top-left-radius:15px;
				top: 5px;
				height: 35px;
				background-color: #086266;
				border: none;
			}
			input[type='submit']
			{
				position: relative;
				top: 7px;
				height: 35px;
				background-color: #086266;
				border: none;
				border-radius: 5px;
			}

		</style>
		</head>

		<center><body bgcolor="gray">
		<div id="headerpeople_index">
		<br>
		<input type="button" name="people_friends" value="Friends" onclick="Friends()"</input>
		<input type="button" name="logout" value="Logout" onclick="Logout()"</input>
		<input type="button" name="people_public" value="Public" onclick="public()"</input>
		<br>
		<br>
		<input type="button" name="people_profile" value="My profile" onclick="myProfile()"</input>
		<form action="People.php" method="POST">
		<input type="text" name="search" placeholder="Find friend by username"/>
		<br>
		<input type="submit" value="Search"/>
		</form>
		</div>
		<br><br><br><br>
		<?php
		if(!$dbc)
		{
			die('cant connect to db '.mysqli_connect_error());
		}
		else
		{
			$sql = "SELECT * FROM users WHERE username != '$user'";
			$query = mysqli_query($dbc,$sql);
			if(!$query)
			{
				die('cant query from db '.mysqli_error($dbc));
			}
			else
			{		

				echo '<div id="people">Users<br><br>';
				while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
				{	
					$uid = $row['id'];
					$path = profilePicpath($dbc,$uid);
					echo '<a href="tochat.php?to='.$row['username'].'&puid='.$row['id'].'&relationship=unknown&url=People.php"><img src="'.$path.'"height="70"></img></a>
					<br>'.$row['username'].'
					<br><br>';
				}
				echo '</div>';
			}	
		}
	}
}