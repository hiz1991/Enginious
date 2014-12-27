<?php
session_start();
if (!$_SESSION["user"]) {
    header('Location: loginSignUp/index.html');
    die;
}
else
{
    header('Location: player.html');
    die;
}
?>