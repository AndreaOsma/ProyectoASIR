# Red empresarial en AWS
Este proyecto se compone de varias partes.
<ul>
  <li>Implantación de servidor Apache y servidor mySQL.</li>
  <li>Foro programado en PHP y mySQL.</li>
  <li>Implantación de servidor de chat y de servidor mail.</li>
</ul>

# Foro
<h3>Paso 1. Creación de las tablas de usuarios.</h3>
Para clasificar
<code>CREATE TABLE users (
user_id   INT(8) NOT NULL AUTO_INCREMENT,
user_name   VARCHAR(30) NOT NULL,
user_pass   VARCHAR(255) NOT NULL,
user_email  VARCHAR(255) NOT NULL,
user_date   DATETIME NOT NULL,
user_level  INT(8) NOT NULL,
UNIQUE INDEX user_name_unique (user_name),
PRIMARY KEY (user_id)
) TYPE=INNODB;</code>
