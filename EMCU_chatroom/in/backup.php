<center><body id="onbody" onload="JavaScript:getData('getchats.php','chat','message');">

<div id="header"><?php echo $_SESSION['user'];?><input  type="button" value="Back" onclick="Back()"></input>
<input type="button" value="Profile" onclick="profile()"></input>
<input type="button" value="Logout" onclick="Logout()"></input>
</div>

<div id="adtop"><marquee behavior="scroll" direction="left" scrollamount="4" width="100%" ><font color="white" size="3"><b>to advertise here call +26876916108</i></b></marquee></font></div>
<br><br><br><br><br><br>



<div id="adbotom"><marquee behavior="scroll" direction="left" scrollamount="4" width="100%" ><font color="white" size="3"><b>to advertise here call +26876916108</i></b></marquee></font></div>

<form action ="#" name="ch" OnSubmit="getData('getchats.php','onbody','message')">
<textarea id="message" placeholder="Type your message here"></textarea>
<font size="7"><input type="submit" value="🕊"></input></font>
</form>
</body>
</center>
</html>