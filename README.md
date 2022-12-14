<a name="top"></a>
> Andrea Osma Rafael  
> CFP Juan XXIII - Ciclo 2020/2022
> CFGS Administración de Sistemas Informáticos en Red 

# Implantación de foro en AWS
# Índice
<p>Este proyecto se compone de varias partes.</p>
<ul>
  <li><a href="#introduccion">Introducción</a></li>
  <li><a href="#programas">Programas e infraestructura utilizados</a></li>
    <ul>
      <li><a href="#xampp">XAMPP</a></li>
      <li><a href="#visualstudio">Visual Studio Code</a></li>
      <li><a href="#github">GitHub</a></li>
      <li><a href="#awsinfra">Amazon Web Services</a></li>
    </ul>
  <li><a href="#foro">Foro</a></li>
     <ul>
       <li><a href="#basedatos">Base de datos</a></li>
       <li><a href="#codigo">Código</a></li>
     </ul>
  <li><a href="#aws">Creación del servidor web y la base de datos en AWS</a></li>
    <ul>
      <li><a href="#ec2">Despliegue de la instancia de EC2</a></li>
      <li><a href="#serv-basedatos">Despliegue del servidor de bases de datos</a></li>
      <li><a href="#apache">Instalación del servidor web Apache</a></li>
      <li><a href="#contenido">Añadiendo contenido a la base de datos</a></li>
      <li><a href="#funcionamiento">Prueba de funcionamiento</a></li>
      <li><a href="#https">Activación de HTTPS</a></li>
    </ul>
  <li><a href="#conclusion">Conclusión del proyecto</a></li>
  <li><a href="#glosario">Glosario</a></li>
  <li><a href="#bibliografia">Bibliografía</a></li>
</ul>

<a name="introduccion"></a>
# Introducción
En este proyecto he querido mostrar los beneficios que el almacenamiento en la nube puede tener, tanto para una persona individual como para una empresa, como espacio para desplegar nuestros proyectos. Lo he querido mostrar mediante un foro que he programado mediante PHP y mySQL, debido a mi interés en la programación de páginas web.

El proyecto consistirá en un foro en el que los miembros podrán compartir sus pensamientos con el resto de los usuarios, por lo tanto podrán:
<ul>
  <li>Crear su propia cuenta.</li>
  <li>Iniciar o cerrar sesión.</li>
  <li>Ver el contenido, pudiendo desplegar cada una de las categorías y temas para ver el contenido ya publicado.</li>
  <li>Crear sus propias categorías (solamente si son administradores).</li>
  <li>Crear sus propios temas.</li>
  <li>Responder a los temas que ya haya publicados.</li>
</ul>

A continuación, usaré AWS (Amazon Web Services) para desplegar esa página web, y que cualquier persona con su IP o DNS pueda acceder sin problemas. Le daré seguridad mediante el protocolo HTTPS y mostaré opciones como <b>Route 53</b> para darle un nombre de dominio a la página web.

<a name="programas"></a>
# Programas e infraestructura utilizados
<a name="xampp"></a>
<h3>XAMPP</h3>
XAMPP es un entorno de desarrollo web. La distribución incluye el servidor web Apache, un servidor de bases de datos mySQL, un servidor FTP Filezilla, el servidor de correo Mercury y el contenedor Tomcat para utilizar el lenguaje de programación Java. Puesto que este proyecto estará programado en PHP, JavaScript y mySQL, solo necesitaremos los dos primeros (Apache y mySQL). XAMPP funciona de manera que crea estos servidores en la máquina donde se instalen, pudiendo luego acceder a ellos o bien desde la IP del dispositivo y el puerto del servidor (por ejemplo: http://192.168.1.60:80 para acceder al servidor Apache, es decir, a la web principal) o bien accediendo desde la propia máquina poniendo http://localhost en el navegador.
Este programa solamente lo usaré como entorno de pruebas mientras programo el foro, ya que después en AWS instalaré tanto Apache como mySQL, pero no el resto de servidores.

Para que estos servidores funcionen, simplemente una vez instalado XAMPP, que se puede descargar desde <a href="https://www.apachefriends.org/es/index.html">aquí</a>, entraremos a su panel de control como administrador.
<img src="https://user-images.githubusercontent.com/76048388/199494030-504ff5a0-0205-41ee-b8f0-bfc5e50b988e.png">
<p>Posteriormente, le daremos a "Start" a los servicios que queramos utilizar. Como se puede ver en la imagen que hay a continuación, aparecerán el PID (código de proceso) del servicio activado y el puerto o puertos que tiene asignados dicho servicio. Los que no utilizamos simplemente se quedarán desactivados, para no consumir recursos de manera innecesaria.</p>

<img src="https://user-images.githubusercontent.com/76048388/199494882-3bef7d3e-0c5e-400e-983b-c148b6b33413.png">

<p>También hay varios botones de acción en cada servicio. El botón "admin" es un enlace directo a la ubicación del servidor, el botón "config" permite seleccionar entre los diferentes archivos de configuración del servidor para poder editarlos en caso de que fuese necesario, y el botón "logs" lleva a los registros del servidor, como por ejemplo para ver los accesos o para ver los errores.</p>

<img src="https://user-images.githubusercontent.com/76048388/199495163-803e9d1c-8870-46e7-8de0-f3e72d60076f.png">

<br/>

<a name="visualstudio"></a>
<h3>Visual Studio Code</h3>
Visual Studio Code es un editor de código fuente desarrollado por Microsoft, que tiene aplicaciones para Windows, Linux, macOS y web. Tiene control integrado de Git y permite la instalación de extensiones para depurar el código de cualquier lenguaje y encontrar errores. He decidido utilizar este programa ya que, primero, ayuda con la depuración de errores y la sintaxis, y segundo, permite iniciar sesión con la cuenta de Microsoft o la de Github para poder tener una copia de seguridad del código o en el caso de Github poder clonar repositorios con facilidad.
<br/>

<a name="github"></a>
<h3>GitHub</h3>
GitHub es una web para alojar proyectos utilizando el sistema de control de versiones Git, que es un software que diseñó Linus Torvalds, la misma persona que creó Linux, pensando en la eficiencia, la confiabilidad y compatibilidad del mantenimiento de versiones de aplicaciones cuando estas tienen un gran número de archivos de código fuente. Su propósito es llevar registro de los cambios en archivos de computadora incluyendo coordinar el trabajo que varias personas realizan sobre archivos compartidos en un repositorio de código. GitHub se utiliza principalmente para la creación de código fuente de programas de ordenador, y lo he elegido para poder alojar, además del contenido de mi memoria, que es este archivo <b>README.md</b>, el código fuente de mi foro, para luego poder por ejemplo clonarlo en la instancia donde alojaré el servidor web.

<a name="awsinfra"></a>
<h3>Amazon Web Services</h3>
Amazon Web Services, abreviado como AWS, es una colección de servicios web que en conjunto forman una plataforma de computación en la nube. La mayoría de estos servicios no están expuestos directamente a los usuarios finales, sino que ofrecen una funcionalidad que otros desarrolladores puedan utilizar en sus aplicaciones. Se accede a través de HTTP, pudiendo realizar todas las gestiones a través de una consola web, pero una vez ya realizado el registro también se puede acceder mediante línea de comandos instalando el paquete que lo permite.
AWS está situado en 18 regiones geográficas, y solamente en Europa hay servidores en cinco diferentes ciudades, cada una con tres zonas diferentes de disponibilidad. Las zonas de seguridad son los centros de datos que proporcionan sus servicios, y están aisladas unas de otras para evitar la propagación de cortes entre las zonas. Esto nos da la seguridad de que es prácticamente imposible que nuestros servicios dejen de estar disponibles en algún periodo de tiempo, ya que sería muy complicado que todas las zonas de disponibilidad cayesen a la vez, y si cayese solamente una no importaría ya que nuestros datos tienen una réplica en otra.
Hay otros servicios como Azure, de Microsoft, o Gcloud, de Google, siendo estos son competidores más directos, pero yo he elegido AWS debido a que es donde tengo cierta experiencia.

<a name="foro"></a>
# Foro
<a name="basedatos"></a>
<h2>Base de datos</h2>
<p>El objetivo de esta sección es realizar una página web, un foro creado en PHP con una base de datos mySQL para que los usuarios puedan compartir sus pensamientos, ideas o quejas. Está enfocado a una red de empresa, por lo que alguien que no sea usuario no podría ver el contenido, pero se podría adaptar a ser un foro normal quitando solamente un par de líneas de código. Podríamos utilizar otros servicios como Slack o Discord, donde crear un foro con diferentes subforos con esta misma misión, pero haciendo nuestro propio foro nos aseguramos de tener una web propia, sin necesidad de depender de los servidores de terceros.</p>
<h3>Relación de tablas</h3>
Para crear el modelo de datos he utilizado Case Studio. Los datos se gestionarán así:

<img src="https://user-images.githubusercontent.com/76048388/199696419-f960024c-487e-4eb6-9308-a8779877d8d3.png">

<h3>Tabla de usuarios</h3>
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

<h3>Tabla de categorías</h3>
<p>La segunda tabla será la de categorías, que será donde vayan englobados todos los temas. La primera columna es cod_cat, estructurada de la misma manera que en la tabla de usuarios, la segunda nombre_cat, donde irá el nombre de la categoría, y la tercera descr_cat, donde irá la descripción de la categoría. La columna nombre_cat será única y la primary key será cod_cat.</p>

<pre>CREATE TABLE categorias (
cod_cat          INT(8) NOT NULL AUTO_INCREMENT,
nombre_cat       VARCHAR(255) NOT NULL,
descr_cat     VARCHAR(255) NOT NULL,
UNIQUE INDEX nombre_cat_unico (nombre_cat),
PRIMARY KEY (cod_cat)
);</pre>


<h3>Tabla de temas</h3>
<p>La tercera tabla será la de temas. La primera columna es cod_tema, estructurada de la misma manera que en el resto de las tablas, la segunda descrip_tema, donde irá la descripción o asunto del tema, la tercera fecha_tema, que indicará la fecha en la que fue insertado el tema, la cuarta cat_tema, que será una foreign key donde aparezca el código de la categoría a la que pertenece el tema, y la quinta será autor_tema, donde irá una foreign key hacia el código del usuario que ha creado el tema. La primary key será cod_tema.</p>

<pre>CREATE TABLE temas (
cod_tema        INT(8) NOT NULL AUTO_INCREMENT,
descrip_tema      VARCHAR(255) NOT NULL,
fecha_tema      DATETIME NOT NULL,
cat_tema       INT(8) NOT NULL,
autor_tema        INT(8) NOT NULL,
PRIMARY KEY (cod_tema)
);</pre>

<h3>Tabla de posts</h3>
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
<a name="codigo"></a>
# Código PHP
<h3>Cabecera y pie de página</h3>
En primer lugar, crearemos un archivo <b>header.php</b>. Este archivo contendrá el menú, y estará incluido al principio del código PHP de cada archivo con la línea: <pre>include "header.php";</pre>
<img src="https://user-images.githubusercontent.com/76048388/206175615-25872325-57e4-4b85-a42d-8cddb0150a04.png">
El código fuente lo podemos ver en este archivo del repositorio:
<a href="https://github.com/AndreaOsma/ProyectoASIR/blob/main/proyecto/foro/header.php">header.php</a>
<br/>

Crearemos también un archivo <b>footer.php</b> que en este caso contendrá mi nombre, pero podría contener cualquier otra información como el copyright o enlaces de interés, e irá incluido al final del código PHP de cada archivo con la línea: <pre>include footer.php;</pre>
El código fuente lo podemos ver en este archivo del repositorio:
<a href="https://github.com/AndreaOsma/ProyectoASIR/blob/main/proyecto/foro/footer.php">footer.php</a>

Como podemos ver en el código, el <b>header.php</b> parece incompleto, ya que no tiene una etiqueta &lt;/body&gt; que finalice el código, y tiene un &lt;div&gt; abierto que tampoco está finalizado. Este código se finaliza en el <b>footer.php</b>, ya que al dedicarnos a incluirlos en cada archivo, estos actuarán como si el código estuviese escrito en cada archivo.

<h3>Conexión con la base de datos</h3>
Para conectar con la base de datos y poder realizar cualquier acción dentro de ella, necesitaremos unas líneas de código dedicadas a ello. Para no escribirlas en cada archivo, crearemos un archivo con ellas que será el que después incluyamos en cada archivo. Este archivo contendrá una variable llamada $conn (aunque la podremos llamar como queramos) que dentro contendrá la función mysqli_connect, donde dentro irán en orden la ubicación de la base de datos (en nuestro caso localhost o 127.0.0.1), el usuario con el que queramos acceder a la base de datos, su contraseña y el nombre de la base de datos a la queramos acceder.
Después crearemos una condición if que declara que si no se puede lograr la conexión por un error en la base de datos, el archivo mostrará un texto de error y el código de error.
El código fuente lo podemos ver en este archivo del repositorio:
<a href="https://github.com/AndreaOsma/ProyectoASIR/blob/main/proyecto/foro/connect.php">connect.php</a>

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
<a href="https://github.com/AndreaOsma/ProyectoASIR/blob/main/proyecto/foro/registro.php">registro.php</a>

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
<a href="https://github.com/AndreaOsma/ProyectoASIR/blob/main/proyecto/foro/login.php">login.php</a>

<h3>Cierre de sesión</h3>
Una vez iniciada la sesión, en el menú de navegación aparecerá nuestro nombre de usuario y al lado un enlace para cerrar sesión que irá al archivo <b>cierresesion.php</b>. Este archivo simplemente borrará la sesión y hará una redirección a la página de inicio de sesión.
<br/>
El código fuente lo podemos ver en este archivo del repositorio:
<a href="https://github.com/AndreaOsma/ProyectoASIR/blob/main/proyecto/foro/cierresesion.php">cierresesion.php</a>

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
<a href="https://github.com/AndreaOsma/ProyectoASIR/blob/main/proyecto/foro/crear_cat.php">crear_cat.php</a>

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
<a href="https://github.com/AndreaOsma/ProyectoASIR/blob/main/proyecto/foro/crear_tema.php">crear_tema.php</a>

<h3>Inicio</h3>
Una vez ya haya temas, querremos verlos. Para eso tenemos el archivo <b>index.php</b>, que es la página de inicio del foro. Como el foro es privado, si no tenemos iniciada la sesión, saldrá que primero tenemos que iniciar sesión.
<img src="https://user-images.githubusercontent.com/76048388/206216725-bc7d2fb8-cb20-493c-90ab-7d324773a5c6.png">
Una vez iniciada la sesión, si todavía no hay contenido saldrá este mensaje:
<img src="https://user-images.githubusercontent.com/76048388/206218798-bff652ee-a884-4331-bd84-c4afa7705f1a.png">
En cambio, si hay contenido saldrá listado, pero solamente saldrán las categorías que tengan un tema dentro. Como se puede ver, aparecerá una tabla donde a la izquierda saldrá el nombre de cada una de las categorías y a la derecha el último tema creado. Esto se ha hecho mediante un select con left join igual al de la página <b>crear_tema.php</b>.
<img src="https://user-images.githubusercontent.com/76048388/206226750-8881709f-4d41-4275-aa39-6c57caecccfd.png">
<br/>
El código fuente lo podemos ver en este archivo del repositorio:
<a href="https://github.com/AndreaOsma/ProyectoASIR/blob/main/proyecto/foro/index.php">index.php</a>

<h3>Vista de categoría</h3>
Ahora queremos que al pinchar en el nombre de una categoría nos muestre todos los temas que hay dentro. Para ello vamos a crear un archivo <b>categoria.php</b>, pero no accederemos directamente a este archivo sino a la categoría en cuestión, que habremos mandado antes mediante el protocolo GET en el <b>index.php</b> al pulsar el enlace, por lo que en el enlace saldrá el código de la categoría.
<img src="https://user-images.githubusercontent.com/76048388/206233108-4d99cd86-dd10-4725-ab68-caf29669e049.png">
Si intentásemos acceder directamente poniendo el código de una categoría cualquiera, nos saldría que la categoría no existe.
<img src="https://user-images.githubusercontent.com/76048388/206233561-ab927253-5b7d-4e93-9bad-dd5db21aefee.png">
Al acceder a una categoría que sí que exista, saldrá una tabla con todos los temas que hay dentro y su fecha de creación.
<img src="https://user-images.githubusercontent.com/76048388/206233730-9c8e1b39-50c0-4d58-80c0-17dcda3b0f55.png">
<br/>
El código fuente lo podemos ver en este archivo del repositorio:
<a href="https://github.com/AndreaOsma/ProyectoASIR/blob/main/proyecto/foro/categoria.php">categoria.php</a>

<h3>Vista de tema</h3>
A los temas accederemos de una forma similar a las categorías mediante el enlace el protocolo GET. Dentro de cada tema saldrá desplegado tanto el tema como todas sus respuestas o posts, estando a un lado de la tabla el contenido de ese post y al otro el usuario y la fecha de publicación. Habrá un formulario para enviar respuestas nuevas.
<img src="https://user-images.githubusercontent.com/76048388/206234130-adc86dfe-b600-4c52-9e7c-553731709a60.png">
<br/>
El código fuente lo podemos ver en este archivo del repositorio:
<a href="https://github.com/AndreaOsma/ProyectoASIR/blob/main/proyecto/foro/tema.php">tema.php</a>

<h3>Responder a temas</h3>
Para procesar lo que se introduzca en el formulario mencionado anteriormente para responder, necesitaremos el fichero <b>respuesta.php</b>. No se podrá acceder a este archivo directamente, es decir, cuando no haya ningún dato guardado mediante el protocolo POST. Si lo intentamos saldrá un mensaje.
<img src="https://user-images.githubusercontent.com/76048388/206234860-5bf50ab3-0fd4-44e0-acf3-2652d6028567.png">
Si hay datos, estos se procesarán y se guardarán en la base de datos en la tabla de posts, y al realizarlo con éxito saldrá un mensaje de éxito con un enlace a la página del tema.
<img src="https://user-images.githubusercontent.com/76048388/206235257-97b7b7e4-220c-433b-9ae9-cb6fa7986166.png">
Finalmente, al acceder a la vista del tema veremos que la respuesta se ha guardado correctamente.
<img src="https://user-images.githubusercontent.com/76048388/206235458-8e412d8a-b4c4-4111-8f39-8b96795b7352.png">
<br/>
El código fuente lo podemos ver en este archivo del repositorio:
<a href="https://github.com/AndreaOsma/ProyectoASIR/blob/main/proyecto/foro/respuesta.php">respuesta.php</a>

<a name="aws"></a>
# Creación del servidor web y la base de datos en AWS
<a name="ec2"></a>
<h3>Despliegue de la instancia de EC2</h3>
En primer lugar, hay que ir a <a>https://aws.amazon.com/es/</a>, donde crearemos una cuenta. Una vez creada, iremos a la sección dentro del panel llamada "Crear una solución". Allí elegiremos "Lance una página máquina virtual", que nos llevará a la consola de creación de EC2.
<img src="https://user-images.githubusercontent.com/76048388/207176350-fe972fd5-6759-41d5-847b-11a4acc88e56.png">
Una vez allí, en primer lugar le daremos un nombre a la máquina y en segundo lugar elegiremos un sistema operativo, pudiendo elegir Amazon Linux, Amazon Linux 2, Ubuntu, Windows Server, Red Hat, etcétera. En este caso elegiré Amazon Linux 2, con la arquitectura de 64 bits. Al lado de la arquitectura veremos que sale el ID de la AMI. Esta es la imagen utilizada para crear la máquina.
<img src="https://user-images.githubusercontent.com/76048388/207460732-d4db2f08-837e-4f51-9345-cb960a36d0a2.png">
Posteriormente se nos dará a elegir el tipo de instancia. Esto define el número de núcleos de CPU  y la cantidad de memoria RAM que utilizará. Con la micro para esta página es suficiente ya que no se espera un tráfico muy elevado y además es apta para la capa gratuita. Para otro tipo de recursos que se sepa que van a tener un tráfico mayor, sería necesario coger un tipo de instancia mayor, los precios de instancia salen desplegados debajo para eso. Una vez elegido el tipo, crearemos un par de claves para poder acceder por SSH.
<img src="https://user-images.githubusercontent.com/76048388/207561523-9bee920b-fd9c-484a-8088-dd507ee70a3b.png">
Le daremos un nombre a ese par de claves y un tipo, para lo cual yo he usado RSA, que es un sistema criptográfico que me va a generar una clave de 2048 bits, por lo cual es bastante seguro. Elegiré como formato .pem ya que voy a usar OpenSSH en Ubuntu para acceder, pero si quisiera utilizar la aplicación Putty para Windows elegiría .ppk. Una vez le demos a crear, se nos descargará automáticamente el archivo en el ordenador, y deberemos guardarlo muy bien para no perder el acceso por SSH a la máquina.
<img src="https://user-images.githubusercontent.com/76048388/207180762-17517dac-da89-42e3-8cd0-a91ba5b770ed.png">
Después entraremos en la configuración de red, donde nos saldrá el nombre de red que se va a utilizar. Crearemos un grupo de seguridad, lo cual es un firewall, en el cual permitamos el tráfico SSH solamente desde mi IP para mayor seguridad, y el tráfico HTTP (puerto 80) y HTTPS (puerto 443) desde cualquier punto de Internet. Esta configuración se podrá modificar después si es necesario.
<img src="https://user-images.githubusercontent.com/76048388/207563747-333d6d4c-0ed0-4e6c-81df-44069d3532a6.png">
Finalmente, configuraremos el almacenamiento. Aquí elegiremos la cantidad de almacenamiento que queremos tener en la máquina, y el tipo de unidad de almacenamiento. Por ejemplo, gp2 es un SSD de uso general.
<img src="https://user-images.githubusercontent.com/76048388/207180933-aee3d5d9-714e-41b0-9173-ace8fd1d9100.png">
Al elegir el tipo podremos elegir si queremos que el volumen se elimine cuando eliminemos la máquina virtual y si queremos que el disco esté cifrado.
<img src="https://user-images.githubusercontent.com/76048388/207565567-df461055-08b8-4fa5-b141-c3eb99322d65.png">
Por último, nos iremos a la sección "Resumen", a la derecha, y nos aseguraremos de que toda la configuración está bien. Cuando terminemos, le daremos a "Lanzar instancia" y la máquina se empezaría a crear.
<img src="https://user-images.githubusercontent.com/76048388/207461056-a194be2a-5ac3-4442-9bd5-96f67d6b6a9c.png">

<a name="serv-basedatos"></a>
<h3>Despliegue del servidor de bases de datos</h3>
Una vez creada la instancia, crearemos la base de datos. Para ello iremos a la consola de creación mediante el enlace <a>https://eu-south-2.console.aws.amazon.com/rds</a>. Le daremos a "Crear base de datos".
<img src="https://user-images.githubusercontent.com/76048388/207566507-c2096266-eda0-4bb8-9531-0024cdd719d3.png">
En la consola de creación de base de datos, elegiremos "Creación estándar", para poder elegir todos los parámetros y el motor MySQL ya que es el que se ha usado para crear el foro. En otros motores se podría elegir además otra edición, pero en este la única es "Comunidad de mySQL".
<img src="https://user-images.githubusercontent.com/76048388/207181397-78594edf-35bb-439a-b97a-4d6b64e876bc.png">
En plantillas le daremos a "Capa gratuita", no podremos elegir las opciones de "Disponibilidad y durabilidad" ya que por defecto esta plantilla nos hace una instancia de base de datos única, que para el foro es suficiente.
<img src="https://user-images.githubusercontent.com/76048388/207181584-d7af4508-de93-4898-8f47-8012170a27a0.png">
Le daremos un nombre al clúster (este nombre no es el de la base de datos, si no el de la instancia donde está). Crearemos un nombre de usuario maestro que podrá acceder a todo el contenido de la base de datos y una contraseña maestra.
<img src="https://user-images.githubusercontent.com/76048388/207567495-a2618647-5b68-4c2a-abb9-22052d948b26.png">
Al igual que con la instancia de EC2, elegiremos un tipo de instancia y configuraremos su almacenamiento. Pincharemos "Habilitar escalado automático de almacenamiento" para que si se alcanza el almacenamiento que se le ha asignado al principio se le asigne más hasta un máximo de 1000GB. En este caso no se llegará a usar ni siquiera los 20GB, pero es una opción por si en un futuro la base de datos va a escalar mucho y tener cada vez más datos.
<img src="https://user-images.githubusercontent.com/76048388/207181776-22654200-1af9-4f6a-a179-b51ca8403d75.png">
Posteriormente le indicaremos que se conecte a un recurso de EC2, para conectarlo con la instancia realizada antes, y elegiremos el nombre de dicha instancia. Elegiremos el tipo de red que va a usar la conexión y la VPC.
<img src="https://user-images.githubusercontent.com/76048388/207181824-9caabd98-817a-421a-8818-b1cb0262a212.png">
Posteriormente indicaremos si queremos que la instancia de base de datos tenga una dirección IP pública o no. En este caso no la tendrá ya que solamente se accederá desde la instancia de EC2. La configuración de firewall la dejaremos como por defecto ya que ella sola creará los parámetros necesarios para poder conectar la instancia EC2 con esta.
<img src="https://user-images.githubusercontent.com/76048388/207182086-889b9d20-4483-43da-a5cb-9f37d88b1638.png">
Elegiremos el puerto, que por defecto será 3306 que es el puerto que usa MySQL para las conexiones.
<img src="https://user-images.githubusercontent.com/76048388/207182118-a44f1cb0-3ca1-486b-a60a-0a905f1e5829.png">
Elegiremos cómo queremos autenticarnos en esa base de datos, yo pondré que solo se requiera la contraseña.
<img src="https://user-images.githubusercontent.com/76048388/207182144-c32378a9-3c9b-4575-8eb5-43b37998be1b.png">
Por último, le echaremos un vistazo a la sección de "Costos mensuales estimados" y si estamos conformes crearemos la base de datos.
<img src="https://user-images.githubusercontent.com/76048388/207182179-81c7651a-9f9f-4eaf-935d-f9780952f851.png">

<a name="apache"></a>
<h3>Instalación del servidor web Apache</h3>
Iremos al panel de EC2 y echaremos un vistazo a las instancias que están activas. Elegimos la que queremos, que en mi caso es la única que hay, y clicamos arriba en "Conectar".
<img src="https://user-images.githubusercontent.com/76048388/207570248-b47131c2-53e4-4aab-9649-53a25f72c587.png">

Saldrá la información para acceder por SSH y sus instrucciones. Copiaremos el comando del final y lo usaremos en Ubuntu, en una carpeta donde tengamos metida la clave .pem que descargamos antes. Este comando indica que queremos acceder por SSH con el fichero "servidor-web-proyecto.pem" mediante el usuario root a la dirección asignada a continuación. Esta dirección puede ser IP o DNS. En lugar de acceder al root, es recomendable acceder al ec2-user por seguridad, que es el usuario con poderes sudo que hay en la instancia. 
<img src="https://user-images.githubusercontent.com/76048388/207462154-b845ce2b-c664-4aef-990f-3d3a3b90608e.png">
Una vez ejectuado ese comando, veremos cómo ya estamos dentro de la instancia EC2.
<img src="https://user-images.githubusercontent.com/76048388/207462367-e7a19ffe-7d61-4572-9a42-de33737091d7.png">

A continuación procederemos a instalar Apache y sus dependencias. En primer lugar, actualizaremos los repositorios.
  <pre><code>sudo yum update -y</code></pre>
  Instalaremos los paquetes php8.0 y mariadb10.5.
  <pre><code>sudo amazon-linux-extras install php8.0 mariadb10.5</code></pre>
  Instalaremos el paquete apache, el cuál aquí se llamará <b>httpd</b>.
  <pre><code>sudo yum install -y httpd</code></pre>
  Iniciaremos el servidor web.
  <pre><code>sudo systemctl start httpd</code></pre> 
  Haremos que el servidor web se inicie cada vez que se encienda la instancia.
  <pre><code>sudo systemctl enable httpd</code></pre>  
  Posteriormente, y crearemos el grupo <b>apache</b> y meteremos al usuario <b>ec2-user</b>.
  <pre><code>sudo usermod -a -G apache ec2-user</code></pre>  
  Nos aseguraremos de que este grupo ahora existe.
  <pre><code>[ec2-user@ip-*-*-*-* ~]$ groups
ec2-user adm wheel apache systemd-journal</code></pre>
Ahora, haremos que la carpeta <b>/var/www</b>, que es donde se guarda el contenido a mostrar en el servidor web, sea propiedad del usuario <b>ec2-user</b> y del grupo <b>apache</b>.
  <pre><code>sudo chown -R ec2-user:apache /var/www</code></pre>  
  Le cambiaremos los permisos a <b>/var/www</b> para añadir permisos de escritura de grupo y establecer el ID de grupo en los subdirectorios que se creen en el futuro.
  <pre><code>sudo chmod 2775 /var/www
  find /var/www -type d -exec sudo chmod 2775 {} \;</code></pre>  
  Este comando cambiará recursivamente los permisos de los archivos del directorio <b>/var/www</b> y sus subdirectorios para añadir permisos de escritura de grupo.
  <pre><code>find /var/www -type f -exec sudo chmod 0664 {} \;</code></pre>  
  Con los comandos anteriores, hemos hecho que solamente los miembros del grupo <b>apache</b>, como <b>ec2-user</b>, puedan añadir, eliminar y editar archivos en la raíz de documentos de Apache para poder agregar contenido como esta página web.
  
  Ahora nos moveremos a <b>/var/www</b>, crearemos un directorio llamado <b>inc</b> y nos moveremos a él.
  <pre><code>cd /var/www
mkdir inc
cd inc</code></pre>  
Dentro de esta carpeta crearé un archivo llamado <b>dbinfo.inc</b>
  <pre><code>nano dbinfo.inc</code></pre>  
Aquí irá el siguiente contenido, que indica el punto de enlace de la base de datos (su IP o DNS), el nombre de usuario, su contraseña y la base de datos en cuestión. 
  <img src="https://user-images.githubusercontent.com/76048388/207463470-2f1b4a2e-86ca-4e41-b1ee-0f581938f35f.png">
  Para saber el punto de enlace, iremos al panel de RDS, seleccionaremos la instancia de base de datos, y allí podremos verlo.
  <img src="https://user-images.githubusercontent.com/76048388/207576418-8c0b32b6-fb7a-42be-818a-b6787c4bd213.png">

Para poder tener la página web que ya tengo programada en la instancia, voy a clonar el contenido de este mismo repositorio. Para eso en primer lugar instalaré el comando git, que me permitirá clonar repositorios pero también hacer cambios en repositorios a los que tenga acceso.
  <pre><code>sudo yum install git</code></pre>  
  Me moveré a <b>/var/www/html</b>, donde irá el contenido que va a desplegar el servidor web.
  <pre><code>cd /var/www/html</code></pre>
  Una vez esté allí, clonaré el repositorio.
  <pre><code>git clone https://github.com/AndreaOsma/ProyectoASIR</code></pre>  
  
  Como podemos comprobar en la siguiente imagen, al listar el contenido del directorio veremos que ahora está clonado el repositorio en nuestra instancia.
  <img src="https://user-images.githubusercontent.com/76048388/207464402-f3521711-9b45-4ac0-8197-3aa5b7c1f078.png">

Como quiero que el contenido esté en la carpeta <b>/var/www/html</b>, moveré todo el contenido de <b>ProyectoASIR/proyecto/foro</b> al directorio actual, que es el <b>/var/www/html</b>, y una vez hecho borraré la carpeta ya que ya no la necesito más.
  <pre><code>mv ProyectoASIR/proyecto/foro/* ./
  rm -r ProyectoASIR/</code></pre>  
  
  Si listamos veremos que ahora estaré todo el contenido en <b>/var/www/html</b>
  <img src="https://user-images.githubusercontent.com/76048388/207464639-32df1a13-74c8-46e1-b1b1-1bdb89b80854.png">

Si ahora vamos a la página web mediante su DNS o IP veremos que sale un error de que no se ha podido establecer una conexión con la base de datos. Ese error es el que yo he metido en el fichero <b>connect.php</b> para que muestre si no ha podido establecer una conexión con la base de datos.
  <img src="https://user-images.githubusercontent.com/76048388/207464829-278e1f51-88c9-473c-8e0f-eadd94c8229b.png">
Para solucionarlo, dentro de <b>connect.php</b> hay que poner los mismos parámetros que en <b>dbinfo.inc</b>, es decir: el punto de enlace, el usuario, la contraseña y la base de datos.
  <img src="https://user-images.githubusercontent.com/76048388/207468498-99bd168d-5c4d-4831-b376-da7382d8a883.png">
  
  <a name="contenido"></a>
  <h3>Añadiendo contenido a la base de datos</h3>
  
  Ahora hay que crear la base de datos en el servidor MySQL y las tablas de usuarios, categorías, temas y posts. Como ya hemos instalado antes MariaDB, vamos a acceder al servidor mediante el siguiente comando, donde indicaremos detrás del -h el punto de enlace, detrás del -P el puerto y detrás del -u el usuario. El -p es para que nos pida la contraseña al ejecutarlo.
  
  <pre><code>mysql -h <puntodeenlace> -P 3306 -u <usuario> -p</code></pre>
  
  Como podemos ver en la siguiente imagen, la conexión se ha realizado con éxito.
  <img src="https://user-images.githubusercontent.com/76048388/207466191-3d09d6d3-ae84-45ee-8df8-84f87d499e22.png">

No estamos dentro de ninguna base de datos, por lo que mostraremos las bases de datos que actualmente existen.
  <img src="https://user-images.githubusercontent.com/76048388/207466437-90ff75af-cca0-470d-9820-08742cc4f576.png">
  
Crearemos la base de datos foro, y mostraremos de nuevo las bases de datos existentes para comprobar que se ha creado con éxito.  
<img src="https://user-images.githubusercontent.com/76048388/207466517-4a605c74-201f-48d3-a137-d4168d0fdd2f.png">

Le indicaremos a MySQL que queremos usar la base de datos <b>foro</b>.
<img src="https://user-images.githubusercontent.com/76048388/207466572-0b8fbdfd-0e5b-4558-81ff-3bf2372a421d.png">

Una vez dentro de la base de datos, crearemos las tablas de usuarios, categorías, temas y posts y haremos los alter table.
<img src="https://user-images.githubusercontent.com/76048388/207466706-bc40d66f-5c9d-47fd-a899-8ad664b49689.png">
<img src="https://user-images.githubusercontent.com/76048388/207466740-b42cc4d1-9a0e-481c-9958-0bafe4a9acec.png">
<img src="https://user-images.githubusercontent.com/76048388/207466847-1ff5b6f9-1f0c-4859-897d-67eaa6741ec1.png">

Por último, mostraremos las tablas existentes para comprobar que estén creadas.
<img src="https://user-images.githubusercontent.com/76048388/207467023-8b5e6902-fb2f-4620-a83e-bf6c45a5eacd.png">

Cuando ya podamos acceder a la página web y hacer un registro, si queremos que un usuario tenga permisos de administrador para poder crear categorías, entraremos en la base de datos del foro y haremos un update, donde cambiaremos el nivel de usuario a 1 al usuario cuyo nombre de usuario sea el que queremos cambiar. También se puede usar el código de usuario ya que es una condición también única.
  <img src="https://user-images.githubusercontent.com/76048388/207469031-0330307e-1d5f-4ca4-8c29-5ad9f8e31ba9.png">
  
  <a name="funcionamiento"></a>
  <h3>Prueba de funcionamiento</h3>
  Ahora podremos acceder a la página web y ejecutarla con normalidad, como accedíamos en local.
  <img src="https://user-images.githubusercontent.com/76048388/207477807-3fe91b67-3d6b-40cf-87d4-5a56b0d89b84.png">
  Podremos registrar usuarios e iniciar sesión con ellos, al igual que en local.
<img src="https://user-images.githubusercontent.com/76048388/207477912-e4babd8a-4923-4e43-b663-f82b27cad1a8.png">

Podremos crear categorías, temas, respuestas... y verlos desplegados al igual que en local.
<img src="https://user-images.githubusercontent.com/76048388/207478011-cea6659b-5fa4-4043-a058-8479c39772ec.png">

<a name="https"></a>
<h3>Activación de HTTPS</h3>
En este punto la página web es perfectamente funcional, pero solamente se puede acceder mediante el protocolo HTTP, si intentamos acceder por HTTPS nos saldrá un error de que no se ha podido establecer la conexión. Para poder acceder también por HTTPS, vamos a activar SSL/TLS, que es un protocolo que crea un canal encriptado entre el servidor web y el cliente web para proteger los datos enviados por de poder ser interceptados por terceros.
En primer lugar, nos conectaremos a la instancia y confirmaremos que Apache está activado.
<pre><code>sudo systemctl is-enabled httpd</code></pre>
Actualizaremos los repositorios:
<pre><code>sudo yum update -y</code></pre>

Instalaremos ahora el paquete <b>mod_ssl</b>, que es un módulo de Apache que añade soporte a TLS.
<pre><code>sudo yum install -y mod_ssl</code></pre>

Nos moveremos a <b>/etc/pki/tls/certs</b> y ejecutaré el fichero <b>make-dummy-cert</b> con el parámetro del archivo donde quiero que me cree el certificado SSL. El contenido del archivo será un certificado autofirmado y la clave privada del certificado.
<pre><code>
cd /etc/pki/tls/certs
sudo ./make-dummy-cert localhost.crt
</code></pre>

Entraremos en el archivo <b>/etc/httpd/conf.d/ssl.conf</b> con un editor de texto y nos aseguraremos de que la siguiente línea está descomentada.
<pre><code>SSLCertificateKeyFile /etc/pki/tls/private/localhost.key</code></pre>

Por último, reiniciaremos Apache.
<pre><code>sudo systemctl restart httpd</code></pre>

Finalmente, podremos acceder a la página mediante el protocolo HTTPS, saldrá que no es seguro, pero se podrá acceder.
<img src="https://user-images.githubusercontent.com/76048388/207589569-9e7894f9-7a43-4992-a58c-72b465dc0342.png">

Para evitar que saliese el mensaje "No seguro", habría que crear una petición de certificación y enviarle ese archivo a una autoridad de certificación, que son empresas que comprueban ese archivo, si le dan el visto bueno te enviarían un certificado firmado y finalmente se configuraría Apache para usar ese certificado. También existe la opción de configurar un DNS, para en lugar de acceder mediante la IP del servidor o la DNS "https://ec2-*-*-*-*.eu-south-2.compute.amazonaws.com", acceder mediante una DNS legible y fácil de recordar como podría ser "proyectoasirandrea.com". Para eso tendríamos que comprar un dominio, que mismamente en AWS se puede comprar en el panel de <b>Route 53</b>, o en otras empresas que ofrecen estos servicios. Podríamos comprar el DNS que quisiéramos y estuviera disponible, con un precio que depende del subdominio (por ejemplo <b>.com</b> son 12$ al año) y crear una zona alojada por ese dominio, la cual sería la DNS de nuestra instancia.
<img src="https://user-images.githubusercontent.com/76048388/207591358-41c44b25-9fa0-4155-a4a7-c6c9e2d8dc59.png">

Yo no voy a hacer ninguna de las dos opciones, ya que los objetivos del proyecto son puramente académicos, pero existen las dos opciones. En la bibliografía dejaré más información sobre ello.

<a name="conclusion"></a>
# Conclusión del proyecto
Como conclusión, queda claro que mediante PHP y mySQL no es difícil hacer un foro básico, y mediante otras herramientas como AWS o cualquier otro hosting en la nube ya no es necesario hostearlo en una máquina física. Gracias a esto, aseguro que la página web siempre esté accesible, sin peligros como cortes de luz o peligro de que se comprometa el hardware.

<a name="glosario"></a>
# Glosario

<a name="bibliografia"></a>
# Bibliografía
<ul>
  <li>https://www.apachefriends.org/es/index.html</li>
  <li>https://code.tutsplus.com/es/tutorials/how-to-create-a-phpmysql-powered-forum-from-scratch--net-10188</li>
  <li>https://developer.hashicorp.com/terraform/tutorials/aws-get-started</li>
  <li>https://rm-rf.es/como-conectar-ssh-instancia-aws-ec2-linux/#:~:text=C%C3%B3mo%20conectar%20por%20SSH%20a%20una%20instancia%20AWS,de%20instancia%2C%20IP%20y%20su%20DNS%20p%C3%BAblico%20</li>
  <li>https://docs.aws.amazon.com/es_es/AmazonRDS/latest/UserGuide/TUT_WebAppWithRDS.html</li>
  <li>https://aws.amazon.com/es/getting-started/hands-on/deploy-wordpress-with-amazon-rds</li>
  <li>https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/SSL-on-amazon-linux-2.html</li>
  <li>https://docs.aws.amazon.com/Route53/latest/DeveloperGuide/Welcome.html</li>
</ul>

# Licencia
<a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/"><img alt="Licencia Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc/4.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">Implantación de foro en AWS</span> por <a xmlns:cc="http://creativecommons.org/ns#" href="https://github.com/AndreaOsma" property="cc:attributionName" rel="cc:attributionURL">Andrea Osma Rafael</a> se distribuye bajo una <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/">Licencia Creative Commons Atribución-NoComercial 4.0 Internacional</a>.<br />Basada en una obra en <a xmlns:dct="http://purl.org/dc/terms/" href="https://github.com/AndreaOsma/ProyectoASIR" rel="dct:source">https://github.com/AndreaOsma/ProyectoASIR</a>

<a href="#top">Volver al inicio</a>
