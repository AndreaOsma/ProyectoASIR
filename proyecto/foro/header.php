<?php
  session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Foro</title>
    <link rel="stylesheet" href="css/estilo.css" type="text/css">
</head>
<body>
<a href="index.php"><h1>Foro para el proyecto de 2º de ASIR</h1></a>
    <div id="wrapper">
    <div id="menu">
        <a class="item" href="index.php">Inicio</a> -
        <a class="item" href="crear_tema.php">Crear un tema</a> -
        <a class="item" href="crear_cat.php">Crear una categoría</a>
         
        <div id="userbar">
<div id="userbar">
    <?php
$sesion_iniciada=$_SESSION['sesion_iniciada']   ?? null;

    if($sesion_iniciada)
    {
        echo 'Hola, ' . $_SESSION['nombre_usu'] . '. ¿No eres tú? <a class="item" href="cierresesion.php">Cerrar sesión</a>';
    }
    else
    {
        echo '<a class="item" href="login.php">Iniciar sesión</a> <a class="item" href="registro.php">Crear una cuenta</a>';
    }
?>
</div>
    </div>
        <div id="contenido">