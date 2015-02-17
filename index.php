<?php
session_start();
if (!$_SESSION["user"]) {
    header('Location: loginSignUp/index.php');
    die;
}
else
{
    header('Location: player.php');
    die;
}
?>