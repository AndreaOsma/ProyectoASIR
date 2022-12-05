<?php
include 'connect.php';
include 'header.php';
 
$sql = "SELECT
            cod_cat,
            nombre_cat,
            descr_cat
        FROM
            categorias";
 
$result = $conn->query($sql);
 
if(!$result)
{
    die('No se han podido desplegar las categorías. Por favor, inténtalo de nuevo.' . mysqli_connect_errno());
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
                    echo '<h3><a href="categoria.php?id">' . $row['nombre_cat'] . '</a></h3>' . $row['descr_cat'];
                echo '</td>';
                echo '<td class="rightpart">';
                            echo '<a href="tema.php?id=">Descripción del tema</a> at 10-10';
                echo '</td>';
            echo '</tr>';
        }
    }
}
 
include 'footer.php';
?>