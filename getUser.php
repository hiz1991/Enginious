<?php
session_start();
$user=$_SESSION['user'];
$account=$_SESSION['userType'];
//echo "user=$user";
//$user='kura';
echo "user=$user&account=$account";
?>