<?php
include 'connect.php';
include 'header.php';
 
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    echo 'No se puede acceder directamente a este archivo.';
}
else
{
    if(!$_SESSION['sesion_iniciada'])
    {
        echo 'Tienes que haber iniciado sesión para poder responder.';
    }
    else
    {
        $sql = "INSERT INTO 
                    posts(texto_post,
                          fecha_post,
                          tema_post,
                          autor_post) 
                VALUES ('".$_POST['texto-post']."',
                        NOW(),
                        '".mysqli_real_escape_string($conn,$_GET["cod_tema"])."',
                        ".$_SESSION['cod_usuario'].");";

        $result = $conn->query($sql);
                         
        if(!$result)
        {
            die('Tu respuesta no ha podido ser guardada. Por favor, inténtalo de nuevo más tarde. Error: ' . mysqli_connect_errno());
        }
        else
        {
            echo 'Tu respuesta ha sido guardada, puedes verlo en <a href="tema.php?cod_tema=' . htmlentities($_GET['cod_tema']) . '">el tema</a>.';
        }
    }
}
 
include 'footer.php';
?>