function Back()
{
	window.location="index.php";
}

function Logout()
{
	window.location="../logout.php";
}

function profile()
{
	window.location="about.php?url=chat.php";
}

function People()
{
	window.location="People.php";
}

function Friends()
{
	window.location="index.php";
}

function myProfile()
{
	window.location="my_profile.php";
}

function public()
{
	window.location="public.php";
}


//Post/Send private chat
function getData(dataSource,chat,message)
{
	var XMLHttpRequestObject = false;
	if (window.XMLHttpRequest) 
	{
		XMLHttpRequestObject = new XMLHttpRequest();
	}
	else if (window.ActiveXObject) 
	{
		ActiveXObject("Microsoft.XMLHTTP");
	}
	if(XMLHttpRequestObject) 
	{
		var obj = document.getElementById("chat");
		var message = document.getElementById("message").value;
		
		XMLHttpRequestObject.open("POST", dataSource);
		XMLHttpRequestObject.setRequestHeader('Content-Type',
		'application/x-www-form-urlencoded');
		XMLHttpRequestObject.onreadystatechange = function()
		{
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) 
			{
				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
		XMLHttpRequestObject.send("data=" + message);
	}	
	document.getElementById("message").value = "";
}

//get private Chats
function getChats(dataSource,chat)
{
	var XMLHttpRequestObject = false;
	if (window.XMLHttpRequest) 
	{
		XMLHttpRequestObject = new XMLHttpRequest();
	}
	else if (window.ActiveXObject) 
	{
		ActiveXObject("Microsoft.XMLHTTP");
	}
	if(XMLHttpRequestObject) 
	{
		var obj = document.getElementById("chat");
		
		var message = "";
		XMLHttpRequestObject.open("POST", dataSource);
		XMLHttpRequestObject.setRequestHeader('Content-Type',
		'application/x-www-form-urlencoded');
		XMLHttpRequestObject.onreadystatechange = function()
		{
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) 
			{
				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
		XMLHttpRequestObject.send("data=" + message);
	}
	setTimeout("getChats('getchats.php','chat')",4000);	
}


//Post a publick post
function postPost(dataSource,chat,message)
{
	var XMLHttpRequestObject = false;
	if (window.XMLHttpRequest) 
	{
		XMLHttpRequestObject = new XMLHttpRequest();
	}
	else if (window.ActiveXObject) 
	{
		ActiveXObject("Microsoft.XMLHTTP");
	}
	if(XMLHttpRequestObject) 
	{
		var obj = document.getElementById("chat");
		var message = document.getElementById("message").value;
		
		XMLHttpRequestObject.open("POST", dataSource);
		XMLHttpRequestObject.setRequestHeader('Content-Type',
		'application/x-www-form-urlencoded');
		XMLHttpRequestObject.onreadystatechange = function()
		{
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) 
			{
				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
		XMLHttpRequestObject.send("data=" + message);
	}	
	document.getElementById("message").value = "";
}



//get public Posts
function getPosts(dataSource,chat)
{
	var XMLHttpRequestObject = false;
	if (window.XMLHttpRequest) 
	{
		XMLHttpRequestObject = new XMLHttpRequest();
	}
	else if (window.ActiveXObject) 
	{
		ActiveXObject("Microsoft.XMLHTTP");
	}
	if(XMLHttpRequestObject) 
	{
		var obj = document.getElementById("chat");
		
		var message = "";
		XMLHttpRequestObject.open("POST", dataSource);
		XMLHttpRequestObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		XMLHttpRequestObject.onreadystatechange = function()
		{
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) 
			{
				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
		XMLHttpRequestObject.send("data=" + message);
	}
	setTimeout("getPosts('getposts.php','chat')",4000);	
}