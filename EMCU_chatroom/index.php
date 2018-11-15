<?php
session_start();
include("include/db.php");
if(isset($_POST['username']) || isset($_POST['password']))
{
	if(empty($_POST['username']) || empty($_POST['password']))
	{
		echo '
		<script type="text/javascript">
		alert("All fields are mandatory and cant be empty");
		document.location="index.php";
		</script>';
		exit;
	}

	else
	{
		$username = $_POST['username'];
		$password = md5($_POST['password']);

		$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
		$query = mysqli_query($dbc,$sql);
		if(!$query)
		{
			die('cant query from db'.mysqli_error($dbc));
		}
		else
		{
			
			if(mysqli_num_rows($query) == 0)
			{
				echo '
				<script type="text/javascript">
				alert("Username or password incorrect");
				document.location="index.php";
				</script>';
				exit;
			}
			else
			{
				while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
				{
					$uid = $row['id'];
				}

				$sql = "SELECT uid from profile WHERE uid ='$uid'";
				$query = mysqli_query($dbc,$sql);
				if(!$query)
				{
					die('cant query from db'.mysqli_error());
				}
				else
				{
					
					if(mysqli_num_rows($query) == 0)
					{
						$_SESSION['status'] = "incomplete";
						setcookie("user", "$username", time() + (10 * 365 * 24 * 60 * 60), "/", "",0);
						setcookie("uid", "$uid", time() + (10 * 365 * 24 * 60 * 60), "/", "",0);
						echo '<script>
						window.location="in/";
						</script>';
					}
					else
					{
						$_SESSION['status'] = "complete";	
						setcookie("user", "$username", time() + (10 * 365 * 24 * 60 * 60), "/", "",0);
						setcookie("uid", "$uid", time() + (10 * 365 * 24 * 60 * 60), "/", "",0);
						echo '<script>
						window.location="in/";
						</script>';
					}
				}
				
			}
		}
	}
}
else
{
	echo '<html>
	<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="include/style.css" rel="stylesheet"></link>
	</head>

	<center><body bgcolor="gray">
	<div id="header_login"><br><b>EMCU Chatroom</b></div>

	<div id="login_form"><br>Please Login
	<form action="index.php" method="POST">
	<input type="text" name="username" placeholder="UserName"</input>
	<br>
	<input type="password" name="password" placeholder="Password"</input>
	<br>
	<input type="submit" value="Login"</input>
	</form>
	<br>
	dont have an account?, <a href="register.php">Register</a>
	<br><br>
	</div>
	</body>
	</center>
	</html>';
}
