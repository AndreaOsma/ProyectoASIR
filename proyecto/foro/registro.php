<?php
include 'connect.php';
include 'header.php';
 
echo '<h3>Registro</h3>';
 
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    echo '<form method="post" action="">
        Nombre de usuario: <input type="text" name="nombre_usu" /> <br/>
        Contraseña: <input type="password" name="pass_usu"> <br/>
        Repite la contraseña: <input type="password" name="pass_usu_check"> <br/>
        Correo electrónico: <input type="email" name="email_usu"> <br/>
        <input type="submit" value="Registro" />
     </form>';


$usuario=$_POST['nombre_usu']   ?? null;     
$nombre_usu = strip_tags($usuario);

}
else {
    $sql = "SELECT
                        nombre_usu,email_usu
                    FROM
                        usuarios
                    WHERE
                        nombre_usu = '" . $conn->real_escape_string($_POST['nombre_usu']) . "'";
                    
            $result = $conn->query($sql);
            if(!$result)
            {
            echo "<script>alert('Algo ha fallado. Por favor, prueba más tarde.')</script>";
            }
            else
            {
                $errors = array(); 

                if(isset($_POST['nombre_usu']))
                {
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($_POST['nombre_usu'] = $row['nombre_usu']) {
                            echo "<script>alert('El nombre de usuario ya existe. Por favor, prueba otro diferente.')</script>";
                            $errors[] = 'El nombre de usuario ya existe. Por favor, prueba otro diferente.';
                        }
                    }
                    if(!ctype_alnum($_POST['nombre_usu']))
                    {
                        echo "<script>alert('El nombre de usuario solo puede contener números y letras.')</script>";
                        $errors[] = 'El nombre de usuario solo puede contener números y letras.';
                    }
                    if(strlen($_POST['nombre_usu']) > 30)
                    {
                        echo "<script>alert('El nombre de usuario no puede tener más de 30 caracteres.')</script>";
                        $errors[] = 'El nombre de usuario no puede tener más de 30 caracteres.';
                    }
                }
                else
                {
                    echo "<script>alert('El campo nombre de usuario no puede estar vacío.')</script>";
                    $errors[] = 'El campo nombre de usuario no puede estar vacío.';
                }
                 
                 
                if(isset($_POST['pass_usu']))
                {
                    if($_POST['pass_usu'] != $_POST['pass_usu_check'])
                    {
                        echo "<script>alert('Las dos contraseñas no coinciden.')</script>";
                        $errors[] = 'Las dos contraseñas no coinciden.';
                    }
                }
                else
                {
                    echo "<script>alert('El campo contraseña no puede estar vacío.')</script>";
                    $errors[] = 'El campo contraseña no puede estar vacío.';
                }
                 
                if(!empty($errors)) 
                {
                    echo "Algunos campos son incorrectos o están vacíos.";
                    echo '<ul>';
                    foreach($errors as $key => $value) 
                    {
                        echo '<li>' . $value . '</li>'; 
                    }
                    echo '</ul>';
                    echo '<a href="registro.php">Volver al registro</a>';
                }
                else
                {
                    $sql = "INSERT INTO
                                usuarios(nombre_usu, pass_usu, email_usu ,fecha_registro, nivel_usu)
                                VALUES('" . $conn->real_escape_string($_POST['nombre_usu']) . "',
                                '" . sha1($_POST['pass_usu']) . "',
                                '" . $conn->real_escape_string($_POST['email_usu']) . "',
                            NOW(),   
                            0);";
                                     
                    $result = $conn->query($sql);
                    if(!$result)
                    {
                        echo "<script>alert('Algo ha fallado en el registro. Por favor, prueba más tarde.')</script>";
                        
                    }
                    else
                    {
                        echo 'Registro realizado con éxito. ¡Ahora puedes <a href="login.php">iniciar sesión</a> y empezar a postear!';
                    }
                }
            }
}
 
include 'footer.php';
?>