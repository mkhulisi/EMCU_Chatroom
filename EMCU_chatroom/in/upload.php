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

	// check for form request method
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{

		// check for uploaded file
		if(isset($_FILES['upload']))
		{
			

			// file name, type, size, temporary name
			$file_name = $_FILES['upload']['name'];
			$file_type = $_FILES['upload']['type'];
			$file_tmp_name = $_FILES['upload']['tmp_name'];
			$file_size = $_FILES['upload']['size'];
			//check file size

			if($file_size >= 1000024)
			{
				$picture_size = $file_size / 1000000;
				$limit = 1000024 / 1000000;
				echo '<script type="text/javascript">
				alert("picture above max size");
				document.location="profile_picupload.php";
				</script>';
				exit;
			}

	 		//check file extension
			$allowed_extensions = array('jpeg', 'jpg', 'png', 'gif','ico');
			$file_ext = strtolower(end(explode('.',$file_name)));

			if (in_array($file_ext, $allowed_extensions) == false) 
			{
				echo '<script type="text/javascript">
				alert("Ooops! file not an image/picture");
				document.location="profile_picupload.php";
				</script>';
			}
			else
			{

				$file_name = "$uid.$file_ext";
				// target directory
				$target_dir = "uploads/";
			
				// uploding file
				if(move_uploaded_file($file_tmp_name,$target_dir.$file_name))
				{
					// connect to database
					if(!$dbc)
					{
						die('cant connect to db '.mysqli_connect_error());
					}
					else
					{
						// query
						$sql = "UPDATE profile SET profile_picture = '$target_dir$file_name' WHERE uid = '$uid'";
						$query = mysqli_query($dbc,$sql);
						// run query
						if(!$query)
						{
							die('cant query to db'.mysqli_error($dbc));
						}
						else
						{
							echo '<script type="text/javascript">
							alert("profile picture updated");
							document.location="my_profile.php";
							</script>';			
							exit;
						}
					}
				}
			}
		}
	}
	else
	{
		echo '<script type="text/javascript">
		alert("An Error occured please try again");
		document.location="profile_picupload.php";
		</script>';
	}
}