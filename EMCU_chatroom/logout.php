<?php
session_start();
setcookie( "to", "", time()- 60, "/","", 0);
setcookie( "user", "", time()- 60, "/","", 0);
setcookie("puid", "", time()-60, "/", "",0);
unset($_SESSION['status']);
header('location:index.php');