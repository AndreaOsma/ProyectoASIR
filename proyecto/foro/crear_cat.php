<?php
include 'header.php';
include 'connect.php';

$sesion_iniciada=$_SESSION['sesion_iniciada']   ?? null;

if($sesion_iniciada == false)
{
    echo 'Lo siento, tienes que haber <a href="login.php">iniciado sesión</a> para crear una categoría.';
}
else {
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        echo '<h2>Crear una categoría</h2>';
        echo '<form method="post" action="">
            Nombre de la categoría: <input type="text" name="nombre_cat" /> <br/>
            Descripción de la categoría: <textarea name="descr_cat" /></textarea>
            <input type="submit" value="Añadir categoría" />
        </form>';
    }
    else
    {
        $sql = "INSERT INTO categorias(nombre_cat, descr_cat)
        VALUES('" . $conn->real_escape_string($_POST['nombre_cat']) . "',
                '" . $conn->real_escape_string($_POST['descr_cat']) . "')";


        $result = $conn->query($sql);
        if(!$result)
        {
            die('ERROR: ' . mysqli_connect_errno());
        }
        else
        {
            echo 'Nueva categoría añadida con éxito';
        }
    }
}
include 'footer.php';
?>