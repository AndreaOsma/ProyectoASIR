<?php
include 'connect.php';
include 'header.php';
if($sesion_iniciada == false)
{
    echo 'Este foro es privado, tienes que haber <a href="login.php">iniciado sesión</a> para poder ver el contenido.';
}
else { 
    $sql = "SELECT
                temas.cod_tema,
                temas.descrip_tema,
                temas.fecha_tema,
                temas.cat_tema,
                categorias.cod_cat,
                categorias.nombre_cat,
                categorias.descr_cat
            FROM
                temas
            LEFT JOIN
                categorias
            ON
                temas.cat_tema = categorias.cod_cat";
    
    $result = $conn->query($sql);
    
    if(!$result)
    {
        echo 'No se han podido desplegar las categorías. Por favor, inténtalo de nuevo.';
    }
    else
    {
        if(mysqli_num_rows($result) == 0)
        {
            echo 'Todavía no hay categorías.';
        }
        else
        {
            echo '<table border="1">
                <tr>
                    <th>Categoría</th>
                    <th>Último tema</th>
                </tr>'; 
                
            while($row = mysqli_fetch_assoc($result))
            {          
                echo '<tr>';
                    echo '<td class="leftpart">';
                        echo '<h3><a href="categoria.php?cod_cat='.$row['cod_cat'].'">' . $row['nombre_cat'] . '</a></h3>' . $row['descr_cat'];
                    echo '</td>';
                    echo '<td class="rightpart">';
                                echo '<a href="tema.php?cod_tema='.$row['cod_tema'].'">'.$row['descrip_tema'].'</a> en la fecha '.$row['fecha_tema'].'';
                    echo '</td>';
                echo '</tr>';
            }
        }
    }
} 
include 'footer.php';
?>