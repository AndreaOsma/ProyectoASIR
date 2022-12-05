<?php
include 'connect.php';
include 'header.php';

$sql = "SELECT
            cod_cat,
            nombre_cat,
            descr_cat
        FROM
            categorias
        WHERE
            cod_cat = '".mysqli_real_escape_string($conn,$_GET["cod_cat"])."';";

$result = $conn->query($sql);

if(!$result)
{
    die('ERROR: No se ha podido desplegar la categoría, por favor, inténtalo de nuevo más tarde.' . mysqli_connect_errno());
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'Esta categoría no existe.';
    }
    else
    {
        while($row = mysqli_fetch_assoc($result))
        {
            echo '<h2>Temas en la categoría ' . $row['nombre_cat'] . '.</h2>';
        }
     
       
        $sql = "SELECT  
                    cod_tema,
                    descrip_tema,
                    fecha_tema,
                    cat_tema
                FROM
                    temas
                WHERE
                    cat_tema = '".mysqli_real_escape_string($conn,$_GET["cod_cat"])."';";


    $result = $conn->query($sql);
         
        if(!$result)
        {
            die('ERROR: Los temas no han podido ser desplegados, por favor, inténtalo de nuevo más tarde.' . mysqli_connect_errno());
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                echo 'Todavía no hay temas en esta categoría.';
            }
            else
            {
                echo '<table border="1">
                      <tr>
                        <th>Tema</th>
                        <th>Fecha de creación</th>
                      </tr>'; 
                     
                while($row = mysqli_fetch_assoc($result))
                {               
                    echo '<tr>';
                        echo '<td class="leftpart">';
                            echo '<h3><a href="tema.php?cod_tema=' . $row['cod_tema'] . '">' . $row['descrip_tema'] . '</a><h3>';
                        echo '</td>';
                        echo '<td class="rightpart">';
                            echo date('d-m-Y', strtotime($row['fecha_tema']));
                        echo '</td>';
                    echo '</tr>';
                }
            }
        }
    }
}
 
include 'footer.php';
?>