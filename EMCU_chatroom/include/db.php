<?php
$dbc = mysqli_connect("localhost","database_user","database_password","dtabase");

function StatusUpdate($to,$dbc,$cm)
{
	$sql = "SELECT status_update FROM users WHERE username = '$to'";
	$query = mysqli_query($dbc,$sql);
	if(!$query)
	{
		die('cant query from db '.mysqli_error($dbc));
	}
	else
	{
		while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
		{
			if($cm > 0)
			{
				echo '<div id="altfstatus"><i>'.wordwrap($row['status_update'],20,'<br>',true).'</i></div>';
			}
			else
			{
				echo '<div id="fstatus"><i>'.wordwrap($row['status_update'],20,'<br>',true).'</i></div>';
			}
		}
	}
}

function StatusUpdateprofile($to,$dbc)
{
	$sql = "SELECT status_update FROM users WHERE username = '$to'";
	$query = mysqli_query($dbc,$sql);
	if(!$query)
	{
		die('cant query from db '.mysqli_error($dbc));
	}
	else
	{
		while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
		{
			echo '<i>'.wordwrap($row['status_update'],20,'<br>',true).'</i>';
		}
	}
}



function profilePicpath($dbc,$uid)
{
	if(!$dbc)
	{
		die('db connection failed'.mysqli_connect_error());
	}
	else
	{	
		$sql = "SELECT profile_picture FROM profile WHERE uid = '$uid'";
		$query = mysqli_query($dbc,$sql);
		if(!$query)
		{
			die('cant query from db '.mysqli_error($dbc));
		}
		else
		{
			while($row1 = mysqli_fetch_array($query,MYSQLI_ASSOC))
			{
				$path = $row1['profile_picture'];
			}
			return $path;
		}
	}
}

function EmptyProfile($pal_username)
{
	echo "<b>$pal_username</b>'s Profile is EMPTY";
				
}

function About_user($name,$surname,$home_town,$gender,$path)
{
			
	echo '<div id="about"><img src="'.$path.'" name="about"></img>
	<br><b>NAME: </b>'.$name.'<br>
	<b>SURNAME: </b>'.$surname.'<br>
	<b>TOWN: </b>'.$home_town.'<br>
	<b>GENDER: </b>'.$gender.'<br>';
}


function getSentMessageCount($dbc,$sender,$user)
{
	$sql1 = "SELECT * FROM cahats WHERE destination = '$user' AND sender = '$sender' AND message_read_status = '✅'";
	$query1 = mysqli_query($dbc,$sql1);
	if(!$query1)
	{
		die('cant query from db '.mysqli_error($dbc));
	}
	else
	{
		while($row1 = mysqli_fetch_array($query1,MYSQLI_ASSOC))
		{
			$messages_sent = mysqli_num_rows($query1);
			$no_message = "mk";
			if($messages_sent > 0)
			{
			
				return $messages_sent;
			}
			else
			{
				return $no_message;
			}
		}
	}
}
