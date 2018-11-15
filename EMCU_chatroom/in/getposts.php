<?php
session_start();
include("../include/db.php");
echo '<link rel="stylesheet" href="..include/style.css"></link>';
if(!isset($_COOKIE['user']))
{
	header('location:../index.php');
}
else
{
	if(empty($_POST['data']))
	{
		if(!$dbc)
		{
			die('cant connect to db'.mysqli_connect_error());
		}
		else
		{
			//get posts
			$sql = "SELECT * FROM posts ORDER BY id DESC";
			$query = mysqli_query($dbc,$sql);
			if(!$query)
			{
				die('cant query from db '.mysqli_error($dbc));
			}
			else
			{
				while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
				{
					echo '<br><div id="post"><b><font color="green">'.$row['poster'].'</a></font></b><hr>'.wordwrap($row['post'],25,'<br>',true).'<hr>'.$row['post_date'].'<br></div><br></div>';
				}
			}
			mysqli_free_result($query);
		}
	}
	else
	{	//post post
		$post = $_POST['data'];
		$poster = $_COOKIE['user'];
		$sql = "INSERT INTO posts(post,poster,post_date) VALUES('$post','$poster',NOW())";
		$query = mysqli_query($dbc,$sql);
		if(!$query)
		{
			die('cant query to db '.mysqli_error($dbc));
		}
		
		//get posts
		$sql = "SELECT * FROM posts ORDER BY id DESC";
		$query = mysqli_query($dbc,$sql);
		if(!$query)
		{
			die('cant query from db '.mysqli_error($dbc));
		}
		else
		{
			while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
			{
				echo '<br><div id="post"><b><font color="green">'.$row['poster'].'</a></font></b><hr>'.wordwrap($row['post'],25,'<br>',true).'<hr>'.$row['post_date'].'<br></div><br></div>';
			}
		}
		mysqli_free_result($query);
	}
}