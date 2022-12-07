<?php
include 'connect.php';
include 'header.php';

$sql= "SELECT
    posts.tema_post,
    posts.texto_post,
    posts.fecha_post,
    posts.autor_post,
    usuarios.cod_usuario,
    usuarios.nombre_usu
FROM
    posts
LEFT JOIN
    usuarios
ON
    posts.autor_post = usuarios.cod_usuario
WHERE
    posts.tema_post = '".mysqli_real_escape_string($conn,$_GET["cod_tema"])."';";

$result = $conn->query($sql);

if(!$result)
{
    die('La categoría no ha podido ser desplegada. Por favor, inténtalo de nuevo más tarde.' . mysqli_connect_errno());
}
else
{
                echo '<table border="1">
                      <tr>
                        <th>Contenido</th><th>Fecha y autor</th>
                      </tr>'; 
                     
                while($row = mysqli_fetch_assoc($result))
                {              
                    echo '<tr>';
                        echo '<td class="leftpart">';
                            echo $row['texto_post'];
                        echo '</td>';
                        echo '<td class="rightpart">';
                            echo '<p>' . date('d-m-Y', strtotime($row['fecha_post'])) . '</p><p>' . $row['nombre_usu'] . '</p>';
                        echo '</td>';
                    echo '</tr>';
                }
            }

echo '<h3>Escribe aquí tu respuesta</h3>
    <form method="post" action="respuesta.php?cod_tema='.$_GET["cod_tema"].'">
    <textarea name="texto-post"></textarea>
    <input type="submit" value="Responder" />
</form>';
         
include 'footer.php';
?>