<?php
session_start();
if(!isset($_COOKIE['user']))
{
	header('location:../index.php');
}
else
{
	
	include("../include/db.php");
	$to  = $_COOKIE['to'];
	echo '<link rel="stylesheet" href="..include/style.css"></link>';
	$user = $_COOKIE['user'];
	if(empty($_POST['data']))
	{
		if(!$dbc)
		{
			die('cant connect to db'. mysqli_connect_error());
		}
		else
		{

			#indicate that message hass been read
			$sql = "UPDATE cahats SET message_read_status = '✅✅' WHERE sender = '$to' AND
			message_read_status = '✅' AND destination = '$user'";
			$query = mysqli_query($dbc,$sql);
			if(!$query)
			{
				die('cant query to update message r status '.mysqli_error($dbc));
			}
			else
			{

			#get my messages;
			$sql = "SELECT * FROM cahats WHERE destination = '$user' AND sender = '$to' OR destination = '$to' AND sender = '$user' ORDER BY id DESC";
			$query = mysqli_query($dbc,$sql);
			if(!$query)
			{
				die('cant query from db'.mysqli_error($dbc));
			}
			else
			{
				while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
				{
					if($row['sender'] == $user)
					{
						echo '<br><div id="messagebox"><b><font color="#21284f">'.$row['sender'].'</font></b><hr>'.wordwrap($row['message'],25,'<br>',true).$row['message_read_status'].'<hr><i><b>'.$row['message_date'].'</b><br></div><br>';
					}
					else
					{
						echo '<br><div id="messageboxother"><b><font color="#21284f">'.$row['sender'].'</font></b><hr>'.wordwrap($row['message'],25,'<br>',true).'<hr><i><b>'.$row['message_date'].'</b><br></div><br>';	
					}
				}
			}

		}
		}
	}
	else 
	{

		#send message
		$message = strip_tags($_POST['data']);
		$message = mysqli_real_escape_string($dbc,$message);
		$sql ="INSERT INTO cahats(message,message_date,sender,destination,message_read_status) VALUES('$message',NOW(),'$user','$to','✅')";
		
		$query = mysqli_query($dbc,$sql);
		if(!$query)
		{
			die('cant query to db because'.mysqli_error($dbc));
		}
		else
		{
			
			$sql = "SELECT * FROM cahats WHERE destination = '$user' AND sender = '$to' OR destination = '$to' AND sender = '$user' ORDER BY id DESC";
			$query = mysqli_query($dbc,$sql);
			if(!$query)
			{
				die('cant query from db'.mysqli_error($dbc));
			}
			else
			{
				
				while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
				{
					if($row['sender'] == $user)
					{
						echo '<br><div id="messagebox"><b><font color="green">'.$row['sender'].'</font></b><hr>'.wordwrap($row['message'],25,'<br>',true).$row['message_read_status'].'<hr><i><b>'.$row['message_date'].'</i></b><br></div><br>';	
					}
					else
					{
						echo '<br><div id="messageboxother"><b><font color="green">'.$row['sender'].'</font></b><hr>'.wordwrap($row['message'],25,'<br>',true).'<hr><b><i>'.$row['message_date'].'</i></b></div><br>';	
					}
				}
				mysqli_free_result($query);
			}
		}
	}
}