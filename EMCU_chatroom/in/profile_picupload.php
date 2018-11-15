<?php
session_start();
if(!isset($_COOKIE['user']))
{
	header('Location:../index.php');
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
		width: 100%;
		height: 120;
		top: 0px;
		color: white;
		left: 0px;
		background-color: #21284f;
		z-index: 1;
	}
	#form_profile_pic_upload
	{
		position: relative;
		top:50px;
		width: 80%;
		height: 150px;
		background-color: #21284f;
		border-radius: 10px;
		color: white;
	}
	</style>
	</head>
	<center><body bgcolor="gray">
	<div id="header">SkyChat<br>
	<a href="my_profile.php"><input type="button" value="Back"></input></a></div><br><br><br><br><br><br>
	
	<div id="form_profile_pic_upload">Upload Profile picture<br>Size limit is 1MB<br><br>
	<form action="upload.php" method="POST" enctype="multipart/form-data">
	<input type="file" name="upload" />
	<br>
	<br>
	<input type="submit" value="Upload"/>
	</form>
	</div>
	</body>
	</html>';
}