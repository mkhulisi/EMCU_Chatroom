<?php
session_start();
include("../include/db.php");
if(!isset($_COOKIE['user']))
{
	header('Location:../index.php');
}
else
{
}
?>
<htm>
<head>
	<script type="text/javascript" src="../include/script.js" ></script>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="style.css" rel="stylesheet"></link>
	 <script type="text/javascript">
			var w = document.ineerWidth;
			var h = document.innerHeight;
		document.write('<style>#header{position: relative; background-color: #21284F; top: -5px; width:'+w,'px; height: 100px; z-index: 3;} #friends_requests{position: relative;top: 0px; background-color: #21284F; width:'+w,'px;color: white;height:'+h,';overflow:scroll;}</style>');
		</script>
</head>
	<center><body>
	<div id="header"><input  type="button" value="Back" onclick="Back()"></input></div>
	
<?php
	$requestername = $_GET['requestername'];
	$number_of_request = $_GET['requests'];
	echo '<div id="friends_requests">';
	for($x = 1;$x <= $number_of_request;$x++)
	{
		$requester_uid = $_COOKIE[''.$x.''];
		if(!$dbc)
		{
			die('cant connect to db '.mysqli_connect_error());
		}
		else
		{
			$sql = "SELECT * FROM profile WHERE uid = '$requester_uid'";
			$query = mysqli_query($dbc,$sql);
			if(!$query)
			{
				die('cant query from db '.mysqli_error($dbc));
			}
			else
			{
				while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
				{ 
					$uid = $requester_uid;
					$path = profilePicpath($dbc,$uid);
					echo '<br><img src="'.$path.'" name="profile" height="70"></img><br><b>NAME: </b>'.$row['first_name'].'<br>
					<b>SURNAME: </b>'.$row['last_name'].'<br>
					<b>HOME TOWN: </b>'.$row['home_town'].'<br>
					<b>GENDER: </b>'.$row['gender'].'
					<br><a href="prcrequest.php?requester_uid='.$requester_uid.'&choice=accept&friend_username='.$requestername.'"><input type="button" value="Accept"></input></a>

					<br><br><a href="prcrequest.php?requester_uid='.$requester_uid.'&choice=reject"><input type="button" value="Reject"></input></a><hr>';
				}
			}
		}
	}
