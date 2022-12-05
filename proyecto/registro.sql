INSERT INTO
       usuarios(nombre_usu, pass_usu, email_usu ,fecha_registro, nivel_usu)
VALUES('" . $mysqli->real_escape_string($_POST['nombre_usu']) . "',
       '" . sha1($_POST['pass_usu']) . "',
       '" . $mysqli->real_escape_string($_POST['email_usu']) . "',
       NOW(),   
       0);