<?php
include 'connect.php';
include 'header.php';

$sesion_iniciada=$_SESSION['sesion_iniciada']   ?? null;

if($sesion_iniciada == false)
{
    echo 'Lo siento, tienes que haber <a href="login.php">iniciado sesión</a> para crear un tema.';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {   
        $sql = "SELECT
                    cod_cat,
                    nombre_cat,
                    descr_cat
                FROM
                    categorias";
         
        $result = $conn->query($sql);
         
        if(!$result)
        {
            die('Error seleccionando de la base de datos. Por favor, inténtalo de nuevo más tarde.' . mysqli_connect_errno());
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                if($_SESSION['nivel_usu'] == 1)
                {
                    echo 'Todavía no has creado ninguna categoría.';
                }
                else
                {
                    echo 'Antes de poder postear, tienes que esperar a que un administrador cree alguna categoría.';
                }
            }
            else
            {
                echo '<h2>Crear un tema</h2>';
                echo '<form method="post" action="">
                    Descripción: <input type="text" name="descrip_tema" />
                    Categoría:'; 
                 
                echo '<select name="nombre_cat">';
                    while($row = mysqli_fetch_assoc($result))
                    {
                        echo '<option value="' . $row['cod_cat'] . '">' . $row['nombre_cat'] . '</option>';
                    }
                echo '</select>'; 
                     
                echo 'Contenido: <textarea name="texto_post" /></textarea>
                    <input type="submit" value="Crear tema" />
                 </form>';
            }
        }
    }
    else
    {
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
                    
        $query  = "BEGIN WORK;";
        $result = $conn->query($sql);
         
        if(!$result)
        {
            die('Ha ocurrido un error creando tu tema. Por favor, inténtalo de nuevo más tarde.' . mysqli_connect_errno());
        }
        else
        {
            $sql = "INSERT INTO 
                        temas(descrip_tema,
                               fecha_tema,
                               cat_tema,
                               autor_tema)
                   VALUES('" . $conn->real_escape_string($_POST['descrip_tema']) . "',
                               NOW(),
                               " . $conn->real_escape_string($_POST['nombre_cat']) . ",
                               " . $_SESSION['cod_usuario'] . "
                               )";
                      
            $result = $conn->query($sql);
            if(!$result)
            {
                die('Ha ocurrido un error insertando tu tema. Por favor, inténtalo de nuevo más tarde.' . mysqli_connect_errno());
                mysqli_rollback($conn);
                $result = $conn->query($sql);
            }
            else
            {
                $cod_tema = mysqli_insert_id($conn);
                 
                $sql = "INSERT INTO
                            posts(texto_post,
                                  fecha_post,
                                  tema_post,
                                  autor_post)
                        VALUES
                            ('" . $conn->real_escape_string($_POST['descrip_tema']) . "',
                                  NOW(),
                                  " . $cod_tema . ",
                                  " . $_SESSION['cod_usuario'] . "
                            )";
                $result = $conn->query($sql);
                 
                if(!$result)
                {
                    die('Ha ocurrido un error insertando tu post. Por favor, inténtalo de nuevo más tarde.' . mysqli_connect_errno());
                    mysqli_rollback($conn);
                    $result = $conn->query($sql);
                }
                else
                {
                    $sql = "COMMIT;";
                    $result = $conn->query($sql);
                     
                    echo 'Has creado con éxito <a href="tema.php?cod_tema='. $cod_tema . '">un nuevo tema.</a>.';
                }
            }
        }
    }
}
 
include 'footer.php';
?>