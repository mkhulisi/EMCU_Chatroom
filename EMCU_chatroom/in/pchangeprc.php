<?php
session_start();
include("../include/db.php");
if(!isset($_COOKIE['user']))
{
	header('location:../index.php');
}
else
{

	if(empty($_POST['old_password']) || empty($_POST['new_password']) || empty($_POST['passwordv']))
	{
		echo '
		<script type="text/javascript">
		alert("All fields are mandatory and can be empty");
		document.location="my_profile.php";
		</script>';
		exit;
	}
	else
	{
		if($_POST['new_password'] != $_POST['passwordv'])
		{
			echo '
			<script type="text/javascript">
			alert("Password verification failed, passwords dont match");
			document.location="my_profile.php";
			</script>';
			exit;
		}
	
		else
		{
			$uid = $_COOKIE['uid'];
			$old_password = md5($_POST['old_password']);
			$new_password = md5($_POST['new_password']);
			$passwordv = md5($_POST['passwordv']);

			if(!$dbc)
			{
				die('cant conect to db '.mysqli_connect_error());
			}
			else
			{
				$sql = "SELECT password FROM users WHERE id = '$uid'";
				$query = mysqli_query($dbc,$sql);
				if(!$query)
				{
					die('cant query from db'.mysqli_error($dbc));
				}
				else
				{
					while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
					{
						$dbpassword = $row['password'];
					}
					if($old_password != $dbpassword)
					{
						echo '
						<script type="text/javascript">
						alert("Old password incorrect");
						document.location="my_profile.php";
						</script>';
				exit;
					}
					else
					{
						$sql = "UPDATE users SET password = '$passwordv' WHERE id = '$uid'";
						$query = mysqli_query($dbc,$sql);
						if(!$query)
						{
							die('cant query to db '.mysqli_error($dbc));
						}
						else
						{
							echo '
							<script type="text/javascript">
							alert("Password changed successfuly");
							document.location="my_profile.php";
							</script>';
						}
					}
				}
			}
		}
	}
}