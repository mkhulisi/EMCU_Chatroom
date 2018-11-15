<?php
include("include/db.php");
if(isset($_POST['username']) || isset($_POST['password']) || isset($_POST['passwordv']))
{
	if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['passwordv']))
	{
		echo '
		<script type="text/javascript">
		alert("all fields are mandatory and cant be empty");
		document.location="register.php";
		</script>';
	}
	else
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$passwordv = $_POST['passwordv'];
		if($passwordv != $password)
		{
			echo '
			<script type="text/javascript">
			alert("password verification failed, password does not match");
			document.location="register.php";

			</script>';
			exit;
		}
		else
		{
			$passwordv = md5($passwordv);


			if(!$dbc)
			{
				die('cant connect to db'.mysqli_connect_error());
			}
			else
			{
				$sql = "SELECT username FROM users WHERE username = '$username'";
				$query = mysqli_query($dbc,$sql);
				if(!$query)
				{
					die('query from db'.mysqli_error($dbc));
				}
				else
				{
					while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
					{
						$dbusername = $row['username'];
					}
					if($username == $dbusername)
					{
						echo '
						<script type="text/javascript">
						alert("Sory the the username you have entered has beeb already taken please chose a different one");
						document.location="register.php";
						</script>';
					}
					else
					{
						$sql = "INSERT INTO users(username,password,join_date) VALUES('$username','$passwordv',NOW())";
						$query = mysqli_query($dbc,$sql);
						if(!$query)
						{
							die('cant query to db'.mysqli_error($dbc));
						}
						else
						{
						
							$sqluid = "SELECT * FROM users WHERE username = '$username'";
							$queryuid = mysqli_query($dbc,$sqluid);
							if(!$queryuid)
							{
								die('query failed failed line 107 '.mysqli_error($dbc));
							}
							else
							{
								while($rowuid = mysqli_fetch_array($queryuid,MYSQLI_ASSOC))
								{
									$uid = $rowuid['id'];
								}
							}
							$_SESSION['status'] = "incomplete";
							setcookie("user", "$username", time() + (10 * 365 * 24 * 60 * 60), "/", "",0);
							setcookie("uid", "$uid", time() + (10 * 365 * 24 * 60 * 60), "/", "",0);
							header('Location:in/my_profile.php');
						}
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
	<div id="heade_reg"><br><b>EMCU Chatroom</b></div>
	<div id="reg_form">
	<br>
	dont have an account?, Register one by filling the form below
	<form action="register.php" method="POST">
	<input type="text" name="username" placeholder="UserName"</input>
	<br>
	<input type="password" name="password" placeholder="Password"</input>
	<br>
	<input type="password" name="passwordv" placeholder="Verify password"</input>
	<br>
	<input type="submit" value="Register"</input>
	</form>
	<i>already have an account<a href="index.php">Login</i></a>
	<br><br>
	</div>
	</body>
	</center>
	</html>';
}