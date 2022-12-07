# Red empresarial en AWS
<p>Este proyecto se compone de varias partes.</p>
<ul>
  <li>Implantación de servidor Apache y servidor mySQL.</li>
  <li>Foro programado en PHP y mySQL.</li>
  <li>Implantación de servidor de chat y de servidor mail.</li>
</ul>

# Entorno de pruebas
<h3><img src="https://user-images.githubusercontent.com/76048388/199499904-ccf173ce-fb43-4ca6-95d0-b251fd15381c.png"></h3>
<p>XAMPP es un entorno de desarrollo enfocado a la programación en PHP. La distribución incluye el servidor web Apache, un servidor de bases de datos mySQL, un servidor FTP Filezilla, el servidor de correo Mercury y el contenedor Tomcat para utilizar el lenguaje de programación Java. Puesto que este proyecto estará programado en PHP, JavaScript y mySQL, solo necesitaremos los dos primeros (Apache y mySQL). XAMPP funciona de manera que crea estos servidores en la máquina donde se instalen, pudiendo luego acceder a ellos o bien desde la IP del dispositivo y el puerto del servidor (por ejemplo: http://192.168.1.60:80 para acceder al servidor Apache, es decir, a la web principal) o bien accediendo desde la propia máquina poniendo http://localhost en el navegador. Se suele acceder como localhost, ya que el propósito principal de XAMPP, si bien se pueden desplegar páginas web con él, es ser usado como entorno de pruebas a la hora de programar una página web. Por lo tanto, durante el proyecto usaré XAMPP para probar cada cambio que haga al programar la web.</p>
<p>Para que estos servidores funcionen, simplemente una vez instalado XAMPP, que se puede descargar desde <a href="https://www.apachefriends.org/es/index.html">aquí</a>, entraremos a su panel de control como administrador.</p>
<img src="https://user-images.githubusercontent.com/76048388/199494030-504ff5a0-0205-41ee-b8f0-bfc5e50b988e.png">
<p>Posteriormente, le daremos a "Start" a los servicios que queramos utilizar. Como se puede ver en la imagen que hay a continuación, aparecerán el PID (código de proceso) del servicio activado y el puerto o puertos que tiene asignados dicho servicio. Los que no utilizamos simplemente se quedarán desactivados, para no consumir recursos de manera innecesaria.</p>

<img src="https://user-images.githubusercontent.com/76048388/199494882-3bef7d3e-0c5e-400e-983b-c148b6b33413.png">

<p>También hay varios botones de acción en cada servicio. El botón "admin" es un enlace directo a la ubicación del servidor, el botón "config" permite seleccionar entre los diferentes archivos de configuración del servidor para poder editarlos en caso de que fuese necesario, y el botón "logs" lleva a los registros del servidor, como por ejemplo para ver los accesos o para ver los errores.</p>

<img src="https://user-images.githubusercontent.com/76048388/199495163-803e9d1c-8870-46e7-8de0-f3e72d60076f.png">

<br/>

<h3><img src="https://user-images.githubusercontent.com/76048388/199499673-c9b32c6c-d811-4aec-b8b8-a928749529b2.png"></h3>
<p>Una vez programada la página web habiendo utilizado XAMPP como entorno de pruebas, utilizaré <a href="https://www.terraform.io">Terraform</a> para el despliegue en AWS. Terraform permite definir la infraestructura como código, esto quiere decir que es posible escribir en un fichero de texto la definición de la infraestructura usando un lenguaje de programación declarativo y simple. Esto tiene varios beneficios:
<ul>
<li>En primer lugar, que toda la infraestructura utilizada se puede administrar desde una sola aplicación, lo cual a una empresa, donde a la larga existen un volumen de servicios elevados, le permite desplegar estos servicios y sus dependencias, y cuando se quiera dejar de usar el proveedor que se esté utilizando (como por ejemplo AWS), cerrar estos servicios y dependencias para poder llevarlos a otro proveedor. Si no se utilizase Terraform, podría quedar algún servicio abierto por error, suponiendo esto un coste extra a la empresa o usuario, ya que todos los servicios que se utilicen en la nube tienen un coste que cobran a final de mes. Con Terraform, todo quedaría cerrado evitando estas situaciones</li>
<li>En segundo lugar, relacionado con lo dicho en el punto anterior, que Terraform no se limita a un solo proveedor, por lo que por ejemplo una empresa que utilizase AWS, podría migrar toda la infraestructura a otros proveedores como Azure de una forma sencilla y evitando los posibles errores que comenté en el punto anterior.</li>
<li>Como extra, todas las configuraciones que se hacen en Terraform pueden ser compartidas y reutilizables, con lo que los diferentes trabajadores que gestionasen Terraform en la empresa tendrían acceso a los mismos archivos y configuraciones.</li>
</ul>


# Foro
<p>El objetivo de esta sección es realizar una página web, un foro creado en PHP con una base de datos mySQL para que los empleados puedan compartir sus pensamientos, ideas o quejas. Podríamos utilizar otros servicios como Slack o Discord, donde crear un foro con diferentes subforos con esta misma misión, pero haciendo nuestro propio foro nos aseguramos de tener una web propia, sin necesidad de depender de los servidores de terceros.</p>
<h3>Relación de tablas</h3>
Para crear el modelo de datos he utilizado Case Studio. Los datos se gestionarán así:

<img src="https://user-images.githubusercontent.com/76048388/199696419-f960024c-487e-4eb6-9308-a8779877d8d3.png">


<h3>Creación de la tabla de usuarios.</h3>
<p>En primer lugar, es necesario crear una tabla dentro de la base de datos que recoja los usuarios que habrá en el foro. La primera columna será cod_usuario, que será el id del usuario, de tipo integer, que no podrá estar vacía y que se irá incrementando cada vez que se meta una nueva fila. Llevará también las columnas nombre_usu (para el nombre de usuario), pass_usu (para la contraseña), email_usu (para el correo electrónico), fecha_registro (que contendrá la fecha en la que se hizo el registro), y nivel_usu, ya que el usuario podrá ser administrador o estándar, por lo que si tiene un 1 será administrador y si tiene un 0 será estándar. La primary key será cod_usuario y nombre_usu debe ser único.</p>

<pre>CREATE TABLE usuarios (
cod_usuario   INT(8) NOT NULL AUTO_INCREMENT,
nombre_usu   VARCHAR(30) NOT NULL,
pass_usu   VARCHAR(255) NOT NULL,
email_usu  VARCHAR(255) NOT NULL,
fecha_registro   DATETIME NOT NULL,
nivel_usu  INT(8) NOT NULL,
UNIQUE INDEX nombre_usuario_unico (nombre_usu),
PRIMARY KEY (cod_usuario)
);</pre>

<h3>Creación de la tabla de categorías.</h3>
<p>La segunda tabla será la de categorías, que será donde vayan englobados todos los temas. La primera columna es cod_cat, estructurada de la misma manera que en la tabla de usuarios, la segunda nombre_cat, donde irá el nombre de la categoría, y la tercera descr_cat, donde irá la descripción de la categoría. La columna nombre_cat será única y la primary key será cod_cat.</p>

<pre>CREATE TABLE categorias (
cod_cat          INT(8) NOT NULL AUTO_INCREMENT,
nombre_cat       VARCHAR(255) NOT NULL,
descr_cat     VARCHAR(255) NOT NULL,
UNIQUE INDEX nombre_cat_unico (nombre_cat),
PRIMARY KEY (cod_cat)
);</pre>


<h3>Creación de la tabla de temas.</h3>
<p>La tercera tabla será la de temas. La primera columna es cod_tema, estructurada de la misma manera que en el resto de las tablas, la segunda descrip_tema, donde irá la descripción o asunto del tema, la tercera fecha_tema, que indicará la fecha en la que fue insertado el tema, la cuarta cat_tema, que será una foreign key donde aparezca el código de la categoría a la que pertenece el tema, y la quinta será autor_tema, donde irá una foreign key hacia el código del usuario que ha creado el tema. La primary key será cod_tema.</p>

<pre>CREATE TABLE temas (
cod_tema        INT(8) NOT NULL AUTO_INCREMENT,
descrip_tema      VARCHAR(255) NOT NULL,
fecha_tema      DATETIME NOT NULL,
cat_tema       INT(8) NOT NULL,
autor_tema        INT(8) NOT NULL,
PRIMARY KEY (cod_tema)
);</pre>

<h3>Creación de la tabla de posts.</h3>
<p>La cuarta tabla será la de posts, es decir, la de las respuestas a los temas. La primera columna es cod_post, estructurada de la misma manera que en el resto de las tablas, la segunda texto_post, donde irá el texto que el usuario meta en él, la tercera fecha_post, que indicará la fecha en la que fue insertado el post, la cuarta tema_post, que será una foreign key donde aparezca el código del tema al que responde el post, y la quinta será autor_post, donde irá una foreign key hacia el código del usuario que ha creado el post. La primary key será cod_post.</p>

<pre>CREATE TABLE posts (
cod_post         INT(8) NOT NULL AUTO_INCREMENT,
texto_post        TEXT NOT NULL,
fecha_post       DATETIME NOT NULL,
tema_post      INT(8) NOT NULL,
autor_post     INT(8) NOT NULL,
PRIMARY KEY (cod_post)
);</pre>

<h3>Añadiendo las foreign keys</h3>
<p>Por último, ya que no lo hemos hecho en el código insertado anteriormente, insertaremos tres comandos alter table para crear las foreign keys en cada una de las tablas, con un "on delete on restrict update cascade", que no nos dejará borrar una categoría si hay un tema, un usuario si tiene temas o un tema si tiene posts. </p>

<pre>ALTER TABLE temas ADD FOREIGN KEY(cat_tema) REFERENCES categorias(cod_cat) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE temas ADD FOREIGN KEY(autor_tema) REFERENCES usuarios(cod_usuario) ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE posts ADD FOREIGN KEY(tema_post) REFERENCES temas(cod_tema) ON DELETE RESTRICT ON UPDATE CASCADE;
</pre>

# Métodos de autenticación
<h3>Contraseña</h3>
Como es normal en todas las páginas web, el usuario tendrá una contraseña con la que acceder a la página web. Esta contraseña estará definida en la base de datos de usuarios, codificada. Habrá definida una función, que será la que en la página del registro codifique la contraseña para después meterla en la base de datos, y que en la página del login la descodificará.

<h3>Autenticación en dos factores</h3>
Al ser una página empresarial, queremos que tenga seguridad y que no pueda acceder cualquier persona. Para ello, el usuario tendrá que tener activada la verificación en dos pasos o 2FA, un método que actúa como una segunda capa de seguridad al hacer que el usuario tenga que meter un código que recibirá por SMS, correo, o bien usando una aplicación que tenga este propósito como pueden ser Google Authenticator o Authy. En esta página web se dará mediante correo o aplicación. Una vez lo active, el usuario tendrá que descargar unos códigos que le servirán para poder recuperar su cuenta en el caso de que perdiese el acceso a su correo o aplicación.

<h3>Passkeys</h3>
A día 24 de octubre de 2022 salió iOS 16 para los iPhone de Apple. Una de las novedades de esta actualización fueron los passkeys, los cuales prometen ser el nuevo estándar para la identificación en páginas web, ya que Google, Microsoft y Apple han sido los colaboradores en ello, y por el momento solo es posible usarlas en macOS, iOS o iPadOS, pero se planea convertirlo en el estándar de manera que se pueda utilizar en cualquier dispositivo que tenga sensores biométricos. Consisten en que, mientras que una contraseña tradicional está almacenada en una base de datos, exponiéndola a posibles filtraciones y, además, siendo complicada de recordar cuanto más segura sea, el passkey lo que hace es generar dos claves, una privada y otra pública. La pública se almacena en el servidor y la privada en el llavero de iCloud, haciendo que gracias a esto el usuario pueda firmar de forma biométrica o bien con su huella o bien con su cara, un método más seguro que las contraseñas tradicionales. Por lo tanto, implementaré este método en esta página web mediante una herramienta llamada OwnID.

# Código del foro
<h3>Cabecera y pie de página</h3>
En primer lugar, crearemos un archivo <b>header.php</b>. Este archivo contendrá el menú, y estará incluido al principio del código PHP de cada archivo con el comando: <pre>include "header.php";</pre>
<img src="https://user-images.githubusercontent.com/76048388/206175615-25872325-57e4-4b85-a42d-8cddb0150a04.png">

Crearemos también un archivo <b>footer.php</b> que en este caso contendrá mi nombre, pero podría contener cualquier otra información como el copyright o enlaces de interés, e irá incluido al final del código PHP de cada archivo con el comando: <pre>include footer.php;</pre>


# Bibliografía
<ul>
<li>https://www.apachefriends.org/es/index.html</li>
<li>https://openwebinars.net/blog/por-que-usar-terraform/</li>
<li>https://code.tutsplus.com/es/tutorials/how-to-create-a-phpmysql-powered-forum-from-scratch--net-10188</li>
<li>https://www.applesfera.com/tutoriales/he-estado-probando-passkeys-ios-16-como-funciona-que-experiencia-simplemente-maravillosa</li>
</ul>

# Autoría
<p>Este proyecto ha sido creado por Andrea Osma Rafael, como proyecto de fin de grado del Grado Superior de Administración de Sistemas Informáticos en Red terminado en el año 2022.</p>

# Licencia
<p xmlns:cc="http://creativecommons.org/ns#" xmlns:dct="http://purl.org/dc/terms/"><a property="dct:title" rel="cc:attributionURL" href="https://github.com/Andify28/ProyectoASIR">Red empresarial en AWS - Proyecto de fin de grado de ASIR</a> by <a rel="cc:attributionURL dct:creator" property="cc:attributionName" href="https://github.com/Andify28">Andrea Osma Rafael</a> is licensed under <a href="http://creativecommons.org/licenses/by-nc-sa/4.0/?ref=chooser-v1" target="_blank" rel="license noopener noreferrer" style="display:inline-block;">CC BY-NC-SA 4.0<img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/cc.svg?ref=chooser-v1"><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/by.svg?ref=chooser-v1"><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/nc.svg?ref=chooser-v1"><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/sa.svg?ref=chooser-v1"></a></p>
