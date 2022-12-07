<?php
include 'connect.php';
include 'header.php';
 
echo '<h3>Inicio de sesión</h3>';
 
if(isset($_SESSION['sesion_iniciada']) && $_SESSION['sesion_iniciada'] == true)
{
    echo 'Ya has iniciado sesión, puedes <a href="cierresesion.php" onclick="return confirm(¿Seguro que quieres cerrar sesión?);">cerrar sesión</a> si quieres.';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        echo '<form method="post" action="">
            Username: <input type="text" name="nombre_usu" />
            Password: <input type="password" name="pass_usu">
            <input type="submit" value="Sign in" />
         </form>';
    }
    else
    {
        $errors = array(); 
         
        if(!isset($_POST['nombre_usu']))
        {
            $errors[] = 'El campo nombre de usuario no puede estar vacío.';
        }
         
        if(!isset($_POST['pass_usu']))
        {
            $errors[] = 'El campo contraseña no puede estar vacío.';
        }
         
        if(!empty($errors)) 
        {
            echo 'Un par de campos no han sido rellenados correctamente.';
            echo '<ul>';
            foreach($errors as $key => $value) 
            {
                echo '<li>' . $value . '</li>'; 
            }
            echo '</ul>';
        }
        else
        {
            $sql = "SELECT 
                        cod_usuario,
                        nombre_usu,
                        nivel_usu
                    FROM
                        usuarios
                    WHERE
                        nombre_usu = '" . $conn->real_escape_string($_POST['nombre_usu']) . "'
                    AND
                        pass_usu = '" . sha1($_POST['pass_usu']) . "'";
                         
            $result = $conn->query($sql);
            if(!$result)
            {
                die('Algo ha ido mal en el inicio de sesión. Por favor, inténtalo de nuevo más tarde.' . mysqli_connect_errno());
            }
            else
            {
                if(mysqli_num_rows($result) == 0)
                {
                    echo 'El nombre de usuario y/o la contraseña son incorrectos. Por favor, inténtalo de nuevo.<br/>';
                    echo '<a href="login.php">Volver al inicio de sesión</a>';
                }
                else
                {
                    $_SESSION['sesion_iniciada'] = true;
                     
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $_SESSION['cod_usuario']    = $row['cod_usuario'];
                        $_SESSION['nombre_usu']  = $row['nombre_usu'];
                        $_SESSION['nivel_usu'] = $row['nivel_usu'];
                    }
                     
                    echo 'Bienvenido/a, ' . $_SESSION['nombre_usu'] . '. <a href="index.php">Ir al inicio</a>.';
                }
            }
        }
    }
}
 
include 'footer.php';
?>