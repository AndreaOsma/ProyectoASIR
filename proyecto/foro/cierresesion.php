<?php
session_start(); 
session_unset(); 
session_destroy(); 
header ('location:login.php');

echo '<script>alert("Has cerrado sesión correctamente")</script>';
?>