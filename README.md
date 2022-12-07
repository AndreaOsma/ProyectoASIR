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

# Código del foro
<h3>Cabecera y pie de página</h3>
En primer lugar, crearemos un archivo <b>header.php</b>. Este archivo contendrá el menú, y estará incluido al principio del código PHP de cada archivo con la línea: <pre>include "header.php";</pre>
<img src="https://user-images.githubusercontent.com/76048388/206175615-25872325-57e4-4b85-a42d-8cddb0150a04.png">
El código fuente lo podemos ver en este archivo del repositorio:
<a href="https://github.com/Andify28/ProyectoASIR/blob/main/proyecto/foro/header.php">header.php</a>
<br/>

Crearemos también un archivo <b>footer.php</b> que en este caso contendrá mi nombre, pero podría contener cualquier otra información como el copyright o enlaces de interés, e irá incluido al final del código PHP de cada archivo con la línea: <pre>include footer.php;</pre>
El código fuente lo podemos ver en este archivo del repositorio:
<a href="https://github.com/Andify28/ProyectoASIR/blob/main/proyecto/foro/footer.php">footer.php</a>

Como podemos ver en el código, el <b>header.php</b> parece incompleto, ya que no tiene una etiqueta &lt;/body&gt; que finalice el código, y tiene un &lt;div&gt; abierto que tampoco está finalizado. Este código se finaliza en el <b>footer.php</b>, ya que al dedicarnos a incluirlos en cada archivo, estos actuarán como si el código estuviese escrito en cada archivo.

<h3>Conexión con la base de datos</h3>
Para conectar con la base de datos y poder realizar cualquier acción dentro de ella, necesitaremos unas líneas de código dedicadas a ello. Para no escribirlas en cada archivo, crearemos un archivo con ellas que será el que después incluyamos en cada archivo. Este archivo contendrá una variable llamada $conn (aunque la podremos llamar como queramos) que dentro contendrá la función mysqli_connect, donde dentro irán en orden la ubicación de la base de datos (en nuestro caso localhost o 127.0.0.1), el usuario con el que queramos acceder a la base de datos, su contraseña y el nombre de la base de datos a la queramos acceder.
Después crearemos una condición if que declara que si no se puede lograr la conexión por un error en la base de datos, el archivo mostrará un texto de error y el código de error.
El código fuente lo podemos ver en este archivo del repositorio:
<a href="https://github.com/Andify28/ProyectoASIR/blob/main/proyecto/foro/connect.php">connect.php</a>

<h3>Página de registro</h3>
Este foro será privado, por lo que para ver o crear contenido será necesario registrarse mediante la página de registro, que contendrá un formulario. El formulario tendrá cuatro campos, que serán el nombre de usuario, la contraseña, una repetición de la contraseña y el email del usuario.
<img src="https://user-images.githubusercontent.com/76048388/206184530-a8011f57-cfc4-47a9-a967-d05f15d5686a.png">

El código funcionará de manera que, primero, tendrá incluidos los archivos <b>connect.php</b> y <b>header.php</b>, el primero para mostrar la base de datos y el segundo para mostrar el menú de navegación. Si no hay ya ningunos datos guardados con el método post, mostrará el formulario, que el usuario rellenará para poder iniciar sesión. Si ya hay datos, comprobará que estos estén bien rellenados:
<ul>
  <li>Si el usuario contiene algún símbolo, mostrará una alerta en JavaScript de que no puede añadirlo ya que el nombre de usuario solo puede contener letras o números, y añadirá el mismo texto de error al array $errors, que contendrá todos los errores para así mostrar todos los errores en una lista.</li>
  <img src="https://user-images.githubusercontent.com/76048388/206184907-98131fbd-5fe9-4d60-8e72-0d05ff8e92e8.png">
  <img src="https://user-images.githubusercontent.com/76048388/206184941-50514c03-fde9-4940-9f65-3623519ed7f4.png">
  <img src="https://user-images.githubusercontent.com/76048388/206184978-c2d289b3-0f35-48fa-a66b-54d3bb0da094.png">

  <li>Si el nombre de usuario contiene más de 30 caracteres, mostrará otra alerta y añadirá ese error al array.</li>
   <img src="https://user-images.githubusercontent.com/76048388/206185303-2ffd5c3e-544b-44b7-970c-e0925d98e020.png">
  
  <li>Otro error ocurrirá si el campo de contraseña y el de repetir contraseña no coinciden.</li>
  <img src="https://user-images.githubusercontent.com/76048388/206185635-3102055c-b228-47bd-bf6d-acfa72e1ce01.png">

  <li>El último error se dará si cualquiera de los campos de contraseña están vacíos.</li>
  <img src="https://user-images.githubusercontent.com/76048388/206185715-c4db57d2-b959-4792-8f0b-1531558a4b1d.png">

  <li>El correo electrónico es opcional, por lo que no se mostrará ningún error.</li>
  <img src="https://user-images.githubusercontent.com/76048388/206185798-c36e1c9e-8c8a-4e90-98f2-fcb03500ba8d.png">
  <img src="https://user-images.githubusercontent.com/76048388/206185832-6d713eac-476e-4a38-83ae-566812e4a478.png">

</ul>
Si todos los datos son correctos y el usuario no está duplicado, se procederá a insertar mediante mySQL los datos en la base de datos. Por defecto, al usuario se le asignará el nivel de usuario 0, que significa que este usuario no es administrador. Si se quisiera cambiar, lo haría una persona con acceso a la base de datos (el administrador) modificando el campo <b>nivel_usu</b> de 0 a 1. La contraseña se hasheará cuando se incluya en la base de datos mediante la función sha1, que le hace un encriptado sha1 para que ni siquiera una persona con acceso a la base de datos pueda saber la contraseña de cada usuario. Además, se utilizará la función <b>mysqli_real_escape_string</b> al introducir texto plano para dificultar los ataques por inyección SQL.
Si la inserción no se ha podido realizar con éxito, mostrará una alerta, y si se ha podido mostrará un mensaje de éxito y un enlace al inicio de sesión.
<br/>
El código fuente lo podemos ver en este archivo del repositorio:
<a href="https://github.com/Andify28/ProyectoASIR/blob/main/proyecto/foro/registro.php">registro.php</a>

<h3>Inicio de sesión</h3>
Una vez creado un usuario, querremos iniciar sesión para ver el contenido del foro. Para esto tenemos un archivo <b>login.php</b> que realiza una selección de la base de datos.
<img src="https://user-images.githubusercontent.com/76048388/206213298-78fa6e93-7cd8-49fe-8e04-51c3f3f7c47f.png">

Al igual que con la página de registro, primero incluiremos <b>connect.php</b> y <b>header.php</b>. Si se detecta que ya hay una sesión iniciada, se imprimirá un mensaje diciendo que ya se ha iniciado sesión y que puedes cerrar sesión si quieres (con un enlace al archivo de cierre de sesión). Si la sesión no está iniciada y no hay ya datos enviados mediante post, saldrá un formulario que pedirá el usuario y la contraseña. Si el campo de nombre de usuario está vacío, se añadirá un texto de error al array $errors como anteriormente, y lo mismo ocurrirá si no hay nada en la contraseña. Si ocurre cualquiera de estas situaciones, al enviar el formulario saldrá una lista con los errores. Si no ocurre ninguno de estos errores, se procederá a seleccionar el código de usuario, el nombre y el nivel, donde el nombre de usuario sea igual que el enviado y la contraseña sea igual que la contraseña que se ha enviado hasheada. Si no se ha podido realizar el select, saldrá un error, y si se ha podido, si el nombre de usuario y la contraseña dan resultados en la base de datos se iniciará sesión y se mostrará un mensaje de bienvenidad, y si no se ha podido se mostrará un error de que el nombre de usuario y la contraseña no coinciden con el contenido de la base de datos.
<h2>Error</h2>
<img src="https://user-images.githubusercontent.com/76048388/206213625-0e0bdf39-7396-4000-82d1-8e7b31d77a13.png">
<h2>Inicio de sesión con éxito</h2>
<img src="https://user-images.githubusercontent.com/76048388/206213753-e6bca350-a963-4e71-8f16-64cb6e826c3d.png">
<br/>
El código fuente lo podemos ver en este archivo del repositorio:
<a href="https://github.com/Andify28/ProyectoASIR/blob/main/proyecto/foro/login.php">login.php</a>

<h3>Cierre de sesión</h3>
Una vez iniciada la sesión, en el menú de navegación aparecerá nuestro nombre de usuario y al lado un enlace para cerrar sesión que irá al archivo <b>cierresesion.php</b>. Este archivo simplemente borrará la sesión y hará una redirección a la página de inicio de sesión.
<br/>
El código fuente lo podemos ver en este archivo del repositorio:
<a href="https://github.com/Andify28/ProyectoASIR/blob/main/proyecto/foro/cierresesion.php">cierresesion.php</a>

<h3>Crear una categoría</h3>
Como se explicó antes, el foro tiene tres niveles de contenidos. En primer lugar, están las categorías, donde se englobarán cada uno de los temas, y dentro de los temas habrá posts, que son respuestas a estos temas. Para crear categorías necesitaremos ser administradores, es decir, tener un 1 en la columna nivel_usu de nuestro usuario en la base de datos. Los usuarios estándar no podrán crear categorías, solamente temas y respuestas a esos temas.
Para empezar, la página comprobará que la sesión está iniciada. Si no está iniciada, nos dará un mensaje con un enlace a la página de inicio de sesión.
<img src="https://user-images.githubusercontent.com/76048388/206216764-78036d49-f982-4284-a0f7-4ea1750294a0.png">

Una vez iniciada, como dije antes, necesitaremos ser administradores. Para comprobarlo, la página cogerá el valor nivel_usu de la sesión, que declaramos al hacer el inicio de sesión junto al nombre de usuario y el código del usuario. Si este valor es 1, es decir, administrador, se imprimirá un formulario donde podrán rellenarse el nombre de la categoría y su descripción.
<img src="https://user-images.githubusercontent.com/76048388/206218200-d5da5f31-2785-4bb4-90e6-4087e17f7282.png">

De lo contrario, al ser un usuario estándar saldrá un mensaje de que no es posible crear categorías sin ser administrador.
<img src="https://user-images.githubusercontent.com/76048388/206218394-bf21f6eb-2d81-44f6-a32c-51f3543aef76.png">

Al enviar la categoría con éxito, saldrá un mensaje de éxito al crear la categoría, si no si se produjese un error en la base de datos saldría el código de error.
<img src="https://user-images.githubusercontent.com/76048388/206219285-2020c02d-8cd6-4fb6-81e6-09db1a390426.png">
<br/>
El código fuente lo podemos ver en este archivo del repositorio:
<a href="https://github.com/Andify28/ProyectoASIR/blob/main/proyecto/foro/crear_cat.php">crear_cat.php</a>

<h3>Crear un tema</h3>
Teniendo ya categorías, podremos ir a crear un tema, tanto siendo usuario administrador como siendo usuario estándar.
Primero comprobará que hemos iniciado sesión, si no lo hemos hecho saldrá un error indicando que debemos ir a la página de inicio de sesión.
<img src="https://user-images.githubusercontent.com/76048388/206216966-cd67671b-5635-454a-b5ec-6f4e6be37219.png">
Si tenemos la sesión iniciada, seleccionaremos todas las categorías que haya en la base de datos. Si diese un error en la conexión saldría un mensaje de error y su código de error, y si no hay un error pero no hubiese ninguna categoría habría dos casos.
El primer caso sería que le saliese a un usuario administrador, por lo que le saldría que todavía no ha creado ninguna categoría.
<img src="https://user-images.githubusercontent.com/76048388/206218866-c023ee34-c4ee-44d3-aa57-cf15f131d6a9.png">
El segundo caso sería el de un usuario estándar, al que le saldría que tiene que esperar a que un administrador crease una categoría.
<img src="https://user-images.githubusercontent.com/76048388/206221231-b7d30218-8538-4e98-8aab-254ef7e0e984.png">

Habiendo categorías, saldrá un formulario para crear un tema, donde habrá un campo para la descripción o asunto del tema, otro para el texto del tema, y uno tipo select que contendrá un bucle while que diga que despliegue todas las categorías cada una como un option.
<img src="https://user-images.githubusercontent.com/76048388/206221617-1fea80ad-55d6-4001-8097-8ade5f6f67fd.png">

Cuando ya haya datos enviados, haremos una consulta SQL con un left join, donde vamos a seleccionar las columnas cod_tema, descrip_tema, fecha_tema y cat_tema de la tabla temas y las columnas cod_cat, nombre_cat y descr_cat de la tabla categorías, pero solo donde coincidad la columna categorias.cod_cat con la columna temas.cat_tema, para así recoger todos los temas que tenga la categoría seleccionada.
Si no ha habido ningún error, se procederá a insertar el contenido del formulario en la tabla de temas, con el código de la categoría elegida en la columna cat_tema y con el código del usuario que hay en la sesión en la columna autor_tema. A la vez, la descripción del tema se insertará también en la tabla posts en la columna texto_post, junto a la fecha de inserción, el código del tema en tema_post y el código de usuario en autor_post.
Si no hay ningún error, se mostrará un mensaje de éxito.
<img src="https://user-images.githubusercontent.com/76048388/206224444-f0a9ba44-9aca-446b-bb97-c1cccf6b961b.png">
<br/>
El código fuente lo podemos ver en este archivo del repositorio:
<a href="https://github.com/Andify28/ProyectoASIR/blob/main/proyecto/foro/crear_tema.php">crear_tema.php</a>

<h3>Inicio</h3>
Una vez ya haya temas, querremos verlos. Para eso tenemos el archivo <b>index.php</b>, que es la página de inicio del foro. Como el foro es privado, si no tenemos iniciada la sesión, saldrá que primero tenemos que iniciar sesión.
<img src="https://user-images.githubusercontent.com/76048388/206216725-bc7d2fb8-cb20-493c-90ab-7d324773a5c6.png">
Una vez iniciada la sesión, si todavía no hay contenido saldrá este mensaje:
<img src="https://user-images.githubusercontent.com/76048388/206218798-bff652ee-a884-4331-bd84-c4afa7705f1a.png">
En cambio, si hay contenido saldrá listado, pero solamente saldrán las categorías que tengan un tema dentro. Como se puede ver, aparecerá una tabla donde a la izquierda saldrá el nombre de cada una de las categorías y a la derecha el último tema creado. Esto se ha hecho mediante un select con left join igual al de la página <b>crear_tema.php</b>.
<img src="https://user-images.githubusercontent.com/76048388/206226750-8881709f-4d41-4275-aa39-6c57caecccfd.png">
<br/>
El código fuente lo podemos ver en este archivo del repositorio:
<a href="https://github.com/Andify28/ProyectoASIR/blob/main/proyecto/foro/index.php">index.php</a>

<h3>Vista de categoría</h3>
Ahora queremos que al pinchar en el nombre de una categoría nos muestre todos los temas que hay dentro. Para ello vamos a crear un archivo <b>categoria.php</b>, pero no accederemos directamente a este archivo sino a la categoría en cuestión, que habremos mandado antes mediante el protocolo GET en el <b>index.php</b> al pulsar el enlace, por lo que en el enlace saldrá el código de la categoría.
<img src="https://user-images.githubusercontent.com/76048388/206233108-4d99cd86-dd10-4725-ab68-caf29669e049.png">
Si intentásemos acceder directamente poniendo el código de una categoría cualquiera, nos saldría que la categoría no existe.
<img src="https://user-images.githubusercontent.com/76048388/206233561-ab927253-5b7d-4e93-9bad-dd5db21aefee.png">
Al acceder a una categoría que sí que exista, saldrá una tabla con todos los temas que hay dentro y su fecha de creación.
<img src="https://user-images.githubusercontent.com/76048388/206233730-9c8e1b39-50c0-4d58-80c0-17dcda3b0f55.png">
<br/>
El código fuente lo podemos ver en este archivo del repositorio:
<a href="https://github.com/Andify28/ProyectoASIR/blob/main/proyecto/foro/categoria.php">categoria.php</a>

<h3>Vista de tema</h3>
A los temas accederemos de una forma similar a las categorías mediante el enlace el protocolo GET. Dentro de cada tema saldrá desplegado tanto el tema como todas sus respuestas o posts, estando a un lado de la tabla el contenido de ese post y al otro el usuario y la fecha de publicación. Habrá un formulario para enviar respuestas nuevas.
<img src="https://user-images.githubusercontent.com/76048388/206234130-adc86dfe-b600-4c52-9e7c-553731709a60.png">
<br/>
El código fuente lo podemos ver en este archivo del repositorio:
<a href="https://github.com/Andify28/ProyectoASIR/blob/main/proyecto/foro/tema.php">tema.php</a>

<h3>Responder a temas</h3>
Para procesar lo que se introduzca en el formulario mencionado anteriormente para responder, necesitaremos el fichero <b>respuesta.php</b>. No se podrá acceder a este archivo directamente, es decir, cuando no haya ningún dato guardado mediante el protocolo POST. Si lo intentamos saldrá un mensaje.
<img src="https://user-images.githubusercontent.com/76048388/206234860-5bf50ab3-0fd4-44e0-acf3-2652d6028567.png">
Si hay datos, estos se procesarán y se guardarán en la base de datos en la tabla de posts, y al realizarlo con éxito saldrá un mensaje de éxito con un enlace a la página del tema.
<img src="https://user-images.githubusercontent.com/76048388/206235257-97b7b7e4-220c-433b-9ae9-cb6fa7986166.png">
Finalmente, al acceder a la vista del tema veremos que la respuesta se ha guardado correctamente.
<img src="https://user-images.githubusercontent.com/76048388/206235458-8e412d8a-b4c4-4111-8f39-8b96795b7352.png">
<br/>
El código fuente lo podemos ver en este archivo del repositorio:
<a href="https://github.com/Andify28/ProyectoASIR/blob/main/proyecto/foro/respuesta.php">respuesta.php</a>

# Configurando Terraform
Para esta sección utilizaré Ubuntu 22.04 en modo Terminal.
En primer lugar utilizaremos estos comandos para guardar el repositorio en el que está Terraform y actualizar la lista de repositorios.
<pre><code>wget -O- https://apt.releases.hashicorp.com/gpg | gpg --dearmor | sudo tee /usr/share/keyrings/hashicorp-archive-keyring.gpg
echo "deb [signed-by=/usr/share/keyrings/hashicorp-archive-keyring.gpg] https://apt.releases.hashicorp.com $(lsb_release -cs) main" | sudo tee /etc/apt/sources.list.d/hashicorp.list
sudo apt update && sudo apt install terraform</code></pre>
Después instalaremos Terraform mediante el comando:
<pre><code>sudo apt-get install terraform</code></pre>

Verificaremos que está bien instalado:
<pre><code>terraform -help
Usage: terraform [global options] <subcommand> [args]

The available commands for execution are listed below.
The primary workflow commands are given first, followed by
less common or more advanced commands.

Main commands:
  init          Prepare your working directory for other commands
  validate      Check whether the configuration is valid
  plan          Show changes required by the current configuration
  apply         Create or update infrastructure
  destroy       Destroy previously-created infrastructure
  </pre></code>

A partir de este punto, podríamos configurarlo para usar la nube de nuestra elección, yo elegiré AWS, de la cual ya tengo una cuenta creada.

Instalamos la CLI de AWS:
<pre><code>
curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"
unzip awscliv2.zip
sudo ./aws/install
</code></pre>

Iniciaremos sesión en la web de AWS, donde tendremos que pulsar en nuestro nombre de usuario y posteriormente en credenciales de seguridad.
<br/>
<img src="https://user-images.githubusercontent.com/76048388/206243145-495e151b-17db-4b9e-a00b-749e64f1e661.png">

Dentro pulsaremos en "Claves de acceso" y le daremos a "Crear una clave de acceso".
<img src="https://user-images.githubusercontent.com/76048388/206243625-4ea0c9ce-a916-405c-a434-72661ecf132e.png">

Descargaremos el archivo de claves. Estas son las claves de acceso del usuario raíz, y no se deben compartir con nadie que no se quiera que tenga acceso a nuestra cuenta de AWS ya que puede tener objetivos maliciosos.
<img src="https://user-images.githubusercontent.com/76048388/206243742-043d7416-5caf-4b8a-abd4-91af80a18484.png">

Volveremos a la terminal de Ubuntu, donde definiremos dos variables de entorno.

<pre><code>
export AWS_ACCESS_KEY_ID=tuiddeacceso
export AWS_SECRET_ACCESS_KEY=tucontraseñadeacceso
</code></pre>

Crearemos una carpeta para la instancia de Terraform y nos moveremos a esa carpeta.
<pre><code>
mkdir terraform-aws-instance
cd terraform-aws-instance
</code></pre>

Crearemos un archivo para la configuración de AWS.
<pre><code>touch main.tf</code></pre>

Abriremos el archivo con un editor de texto, como por ejemplo nano, e introduciremos el siguiente código. El bloque "Terraform" tendrá la configuración de Terraform. El bloque "provider" define el proveedor que utilizaremos, en este caso Terraform. La región es la ubicación donde está el servidor que utilizaremos, ya que Amazon tiene servidores por todo el mundo. Esto determinará los precios y la latencia a la hora de acceder. El bloque "resource" definirá la infraestructura que usaremos, primero vendrá el tipo de instancia y después el nombre, que en mi caso es "server_proyecto". El AMI es el ID de la imagen de máquina que se utilizará, la que usaré será de Ubuntu 22.04. Por último, en instance_type viene el tipo de instancia, y en este caso usaremos t2.micro ya que este califica para el tier gratis de Amazon.
<pre><code>terraform {
  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "~> 4.16"
    }
  }

  required_version = ">= 1.2.0"
}

provider "aws" {
  region  = "eu-west-1"
}

resource "aws_instance" "server_proyecto" {
  ami           = "ami-05e786af422f8082a"
  instance_type = "t2.micro"

  tags = {
    Name = "InstanciaProyecto"
  }
}
</code></pre>

Una vez configurado el archivo, lo guardaremos y ejecutaremos el siguiente comando para inicializar Terraform.

<pre><code>terraform init</code></pre>

Para validar el archivo de configuración podremos utilizar el siguiente comando.
<pre><code>terraform validate</code></pre>

Aplicaremos la configuración con el siguiente comando:
<pre><code>terraform apply</code></pre>

Saldrá una lista con todos los archivos que se van a añadir, y al final nos preguntará si queremos que se lleven a cabo esas acciones. Cuando aceptemos se empezará a crear la instancia.
<img src="https://user-images.githubusercontent.com/76048388/206249354-c82a44c3-9c2b-41ac-a92f-56e32c406f44.png">

Para ver el estado de la instancia podemos ejecutar el siguiente comando.
<pre><code>terraform show</code></pre>

Si quisiéramos destruir la instancia una vez finalizado el uso, para evitar costes extra o posibles riesgos, usaríamos el siguiente comando:
<pre><code>terraform destroy</code></pre>

# Configurando Kubernetes
En esta parte es donde Terraform podrá de ser de mayor ayuda, ya que Kubernetes (EKS en AWS) cuesta unos $0.10 por hora, y la mayor ventaja que tiene Terraform es poder destruir la instancia en cualquier momento, y así no incurrir en gastos extra.
Para instalar la CLI de Kubernetes en Ubuntu, usaré estos comandos:
<pre><code>
curl -LO "https://dl.k8s.io/release/$(curl -L -s https://dl.k8s.io/release/stable.txt)/bin/linux/amd64/kubectl"
sudo install -o root -g root -m 0755 kubectl /usr/local/bin/kubectl
</code></pre>
También necesitaremos AWS IAM Authenticator:
<pre><code>
curl -Lo aws-iam-authenticator https://github.com/kubernetes-sigs/aws-iam-authenticator/releases/download/v0.5.9/aws-iam-authenticator_0.5.9_linux_amd64
chmod +x ./aws-iam-authenticator
mkdir -p $HOME/bin && cp ./aws-iam-authenticator $HOME/bin/aws-iam-authenticator && export PATH=$PATH:$HOME/bin
echo 'export PATH=$PATH:$HOME/bin' >> ~/.bashrc
</code></pre>

Comprobamos que funciona:
<pre><code>
aws-iam-authenticator help
</code></pre>

# Instalando Apache
Una vez realizada la configuración, habremos creado un servidor, que actuará como cualquier otra máquina en la que hubiéramos instalado Ubuntu Server 22.04.


# Bibliografía
<ul>
  <li>https://www.apachefriends.org/es/index.html</li>
  <li>https://openwebinars.net/blog/por-que-usar-terraform/</li>
  <li>https://code.tutsplus.com/es/tutorials/how-to-create-a-phpmysql-powered-forum-from-scratch--net-10188</li>
  <li>https://developer.hashicorp.com/terraform/tutorials/aws-get-started</li>
  <li>https://developer.hashicorp.com/terraform/tutorials/kubernetes/eks</li>
</ul>

# Autoría
<p>Este proyecto ha sido creado por Andrea Osma Rafael, como proyecto de fin de grado del Grado Superior de Administración de Sistemas Informáticos en Red terminado en el año 2022.</p>

# Licencia
<p xmlns:cc="http://creativecommons.org/ns#" xmlns:dct="http://purl.org/dc/terms/"><a property="dct:title" rel="cc:attributionURL" href="https://github.com/Andify28/ProyectoASIR">Red empresarial en AWS - Proyecto de fin de grado de ASIR</a> by <a rel="cc:attributionURL dct:creator" property="cc:attributionName" href="https://github.com/Andify28">Andrea Osma Rafael</a> is licensed under <a href="http://creativecommons.org/licenses/by-nc-sa/4.0/?ref=chooser-v1" target="_blank" rel="license noopener noreferrer" style="display:inline-block;">CC BY-NC-SA 4.0<img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/cc.svg?ref=chooser-v1"><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/by.svg?ref=chooser-v1"><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/nc.svg?ref=chooser-v1"><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/sa.svg?ref=chooser-v1"></a></p>
