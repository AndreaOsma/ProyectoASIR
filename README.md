# Red empresarial en AWS
Este proyecto se compone de varias partes.
<ul>
  <li>Implantación de servidor Apache y servidor mySQL.</li>
  <li>Foro programado en PHP y mySQL.</li>
  <li>Implantación de servidor de chat y de servidor mail.</li>
</ul>

# Pruebas en XAMPP

# Foro
El objetivo de esta sección es realizar una página web, un foro creado en PHP con una base de datos mySQL para que los empleados puedan compartir sus pensamientos.
<h3>Relación de tablas</h3>
En esta tabla

<h3>Paso 1. Creación de las tablas de usuarios.</h3>
En primer lugar, es necesario crear una tabla dentro de la base de datos que recoja los usuarios que habrá en el foro. Al ser una red empresarial, estos serán los miembros de la empresa.

<pre>CREATE TABLE usuarios (
user_code   INT(8) NOT NULL AUTO_INCREMENT,
user_name   VARCHAR(30) NOT NULL,
user_pass   VARCHAR(255) NOT NULL,
user_email  VARCHAR(255) NOT NULL,
user_date   DATETIME NOT NULL,
user_level  INT(8) NOT NULL,
UNIQUE INDEX user_name_unique (user_name),
PRIMARY KEY (user_id)
) TYPE=INNODB;</pre>

# Bibliografía
https://code.tutsplus.com/es/tutorials/how-to-create-a-phpmysql-powered-forum-from-scratch--net-10188
