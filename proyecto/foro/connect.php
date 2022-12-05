<?php
$conn = mysqli_connect("localhost", "root", "", "foro");

if (!$conn) {
    die("ERROR: no se ha podido establecer una conexión con la base de datos. " . mysqli_connect_errno());
  } 

?>