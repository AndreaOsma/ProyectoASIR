<a name="top"></a>
> Andrea Osma Rafael  
> CFP Juan XXIII - Ciclo 2020/2022
> CFGS Administración de Sistemas Informáticos en Red 

# Implantación de foro en AWS mediante Terraform
# Índice
<p>Este proyecto se compone de varias partes.</p>
<ul>
  <li><a href="#introduccion">Introducción</a></li>
  <li><a href="#programas">Programas e infraestructura utilizados</a></li>
    <ul>
      <li>XAMPP</li>
      <li>Visual Studio Code</li>
      <li>Terraform</li>
      <li>Amazon Web Services</li>
    </ul>
  <li><a href="#foro">Foro</a></li>
     <ul>
       <li>Base de datos</li>
       <li>Código</li>
     </ul>
  <li><a href="#aws">Implantanción en AWS mediante Terraform y Kubernetes</li>
  <li>Glosario</li>
  <li>Bibliografía</li>
</ul>

<a name="introduccion"></a>
# Introducción
En este proyecto he querido mostrar los beneficios que el almacenamiento en la nube puede tener, tanto para una persona individual como para una empresa, como espacio para desplegar nuestros proyectos. Lo he querido mostrar mediante un foro que yo misma he programado mediante PHP y mySQL, debido a mi interés específico en la programación de páginas web. También he querido utilizar Terraform debido a los beneficios que veremos posteriormente.

El proyecto consistirá en un foro en el que los miembros podrán compartir sus pensamientos con el resto de los usuarios, por lo tanto podrán:
<ul>
  <li>Crear su propia cuenta.</li>
  <li>Iniciar o cerrar sesión.</li>
  <li>Ver el contenido, pudiendo desplegar cada una de las categorías y temas para ver el contenido ya publicado.</li>
  <li>Crear sus propias categorías (solamente si son administradores).</li>
  <li>Crear sus propios temas.</li>
  <li>Responder a los temas que ya haya publicados.</li>
</ul>

A continuación, usaré AWS (Amazon Web Services) para desplegar esa página web, y que cualquier persona con su IP o DNS pueda acceder sin problemas. Para esto, utilizaré Terraform, para tener la posibilidad de reducir los costes y que  si en un futuro queramos cambiar a otro proveedor de infraestructura (como Microsoft Azure o Google Cloud) podamos hacerlo sin ninguna complicación.

<a name="programas"></a>
# Programas e infraestructura utilizados
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

<h3>Visual Studio Code</h3>
Visual Studio Code es un editor de código fuente desarrollado por Microsoft, que tiene aplicaciones para Windows, Linux, macOS y web. Tiene control integrado de Git y permite la instalación de extensiones para depurar el código de cualquier lenguaje y encontrar errores. He decidido utilizar este programa ya que, primero, ayuda con la depuración de errores y la sintaxis, y segundo, permite iniciar sesión con la cuenta de Microsoft o la de Github para poder tener una copia de seguridad del código o en el caso de Github poder clonar repositorios con facilidad.
<br/>

<h3>Terraform</h3>
<p>Una vez programada la página web habiendo utilizado XAMPP como entorno de pruebas, utilizaré <a href="https://www.terraform.io">Terraform</a> para el despliegue en AWS. Terraform permite definir la infraestructura como código, esto quiere decir que es posible escribir en un fichero de texto la definición de la infraestructura usando un lenguaje de programación declarativo y simple. Esto tiene varios beneficios:
<ul>
<li>En primer lugar, que toda la infraestructura utilizada se puede administrar desde una sola aplicación, lo cual a una empresa, donde a la larga existen un volumen de servicios elevados, le permite desplegar estos servicios y sus dependencias, y cuando se quiera dejar de usar el proveedor que se esté utilizando (como por ejemplo AWS), cerrar estos servicios y dependencias para poder llevarlos a otro proveedor. Si no se utilizase Terraform, podría quedar algún servicio abierto por error, suponiendo esto un coste extra a la empresa o usuario, ya que todos los servicios que se utilicen en la nube tienen un coste que cobran a final de mes. Con Terraform, todo quedaría cerrado evitando estas situaciones.</li>
<li>En segundo lugar, relacionado con lo dicho en el punto anterior, Terraform no se limita a un solo proveedor, por lo que por ejemplo una empresa que utilizase AWS, podría migrar toda la infraestructura a otros proveedores como Azure de una forma sencilla y evitando los posibles errores que comenté en el punto anterior.</li>
<li>Como extra, todas las configuraciones que se hacen en Terraform pueden ser compartidas y reutilizables, con lo que los diferentes trabajadores que gestionasen Terraform en la empresa tendrían acceso a los mismos archivos y configuraciones.</li>
</ul>

<br/>

<h3>Amazon Web Services</h3>
Amazon Web Services, abreviado como AWS, es una colección de servicios web que en conjunto forman una plataforma de computación en la nube. La mayoría de estos servicios no están expuestos directamente a los usuarios finales, sino que ofrecen una funcionalidad que otros desarrolladores puedan utilizar en sus aplicaciones. Se accede a través de HTTP, pudiendo realizar todas las gestiones a través de una consola web, pero una vez ya realizado el registro también se puede acceder mediante línea de comandos instalando el paquete que lo permite.
AWS está situado en 18 regiones geográficas, y solamente en Europa hay servidores en cuatro diferentes ciudades, cada una con tres zonas diferentes de disponibilidad. Las zonas de seguridad son los centros de datos que proporcionan sus servicios, y están aisladas unas de otras para evitar la propagación de cortes entre las zonas. Esto nos da la seguridad de que es prácticamente imposible que nuestros servicios dejen de estar disponibles en algún periodo de tiempo, ya que sería muy complicado que todas las zonas de disponibilidad cayesen a la vez, y si cayese solamente una no importaría ya que nuestros datos tienen una réplica en otra.
Hay otros servicios como Azure, de Microsoft, o Gcloud, de Google, siendo estos son competidores más directos, pero yo he elegido AWS debido a que es donde tengo cierta experiencia.

<a name="foro"></a>
# Foro
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
# Creando el servidor web y la base de datos en AWS y desplegando el foro
<h3>Despliegue de la instancia de EC2
![image](https://user-images.githubusercontent.com/76048388/207176350-fe972fd5-6759-41d5-847b-11a4acc88e56.png)
![image](https://user-images.githubusercontent.com/76048388/207460732-d4db2f08-837e-4f51-9345-cb960a36d0a2.png)
![image](https://user-images.githubusercontent.com/76048388/207180737-f53fa87e-3d62-435e-b9ab-8c39ef1f43a2.png)
![image](https://user-images.githubusercontent.com/76048388/207180762-17517dac-da89-42e3-8cd0-a91ba5b770ed.png)
![image](https://user-images.githubusercontent.com/76048388/207180861-460a0183-7037-493d-9c7f-7d90ec8a63b5.png)
![image](https://user-images.githubusercontent.com/76048388/207180933-aee3d5d9-714e-41b0-9173-ace8fd1d9100.png)
![image](https://user-images.githubusercontent.com/76048388/207461056-a194be2a-5ac3-4442-9bd5-96f67d6b6a9c.png)

<h3>Despliegue del servidor de bases de datos</h3>
![image](https://user-images.githubusercontent.com/76048388/207181202-6f01ef5a-08cf-4ebf-a891-53405e4033fc.png)
![image](https://user-images.githubusercontent.com/76048388/207181299-ba2f8d7b-ca26-4f74-8eb0-e12653fa942e.png)
![image](https://user-images.githubusercontent.com/76048388/207181397-78594edf-35bb-439a-b97a-4d6b64e876bc.png)
![image](https://user-images.githubusercontent.com/76048388/207181584-d7af4508-de93-4898-8f47-8012170a27a0.png)
![image](https://user-images.githubusercontent.com/76048388/207181727-baa40511-51d4-4c87-8aa5-af1ee1083f7a.png)
![image](https://user-images.githubusercontent.com/76048388/207181776-22654200-1af9-4f6a-a179-b51ca8403d75.png)
![image](https://user-images.githubusercontent.com/76048388/207181824-9caabd98-817a-421a-8818-b1cb0262a212.png)
![image](https://user-images.githubusercontent.com/76048388/207182086-889b9d20-4483-43da-a5cb-9f37d88b1638.png)
![image](https://user-images.githubusercontent.com/76048388/207182118-a44f1cb0-3ca1-486b-a60a-0a905f1e5829.png)
![image](https://user-images.githubusercontent.com/76048388/207182144-c32378a9-3c9b-4575-8eb5-43b37998be1b.png)
![image](https://user-images.githubusercontent.com/76048388/207182179-81c7651a-9f9f-4eaf-935d-f9780952f851.png)

<h3>Instalación del servidor web Apache</h3>
![image](https://user-images.githubusercontent.com/76048388/207461955-f9b06c6d-cfe6-43d9-bb8f-1758d57cf365.png)
![image](https://user-images.githubusercontent.com/76048388/207462154-b845ce2b-c664-4aef-990f-3d3a3b90608e.png)
![image](https://user-images.githubusercontent.com/76048388/207462367-e7a19ffe-7d61-4572-9a42-de33737091d7.png)

  <pre><code>sudo yum update -y</code></pre>
  <pre><code>sudo amazon-linux-extras install php8.0 mariadb10.5</code></pre>
  <pre><code>sudo yum install -y httpd</code></pre>
  <pre><code>sudo systemctl start httpd</code></pre>  
  <pre><code>sudo systemctl enable httpd</code></pre>  
  <pre><code>sudo usermod -a -G apache ec2-user</code></pre>  
  <pre><code>exit</code></pre>  
  <pre><code>[ec2-user@ip-*-*-*-* ~]$ groups
ec2-user adm wheel apache systemd-journal</code></pre>  
  <pre><code>sudo chown -R ec2-user:apache /var/www</code></pre>  
  <pre><code>sudo chmod 2775 /var/www</code></pre>  
  <pre><code>find /var/www -type d -exec sudo chmod 2775 {} \;</code></pre>  
  <pre><code>find /var/www -type f -exec sudo chmod 0664 {} \;</code></pre>  
  <pre><code>cd /var/www
mkdir inc
cd inc</code></pre>  
  <pre><code>nano dbinfo.inc</code></pre>  
  ![image](https://user-images.githubusercontent.com/76048388/207463470-2f1b4a2e-86ca-4e41-b1ee-0f581938f35f.png)
  
  <pre><code>sudo yum install git</code></pre>  
  <pre><code>git clone https://github.com/AndreaOsma/ProyectoASIR</code></pre>  
  
  ![image](https://user-images.githubusercontent.com/76048388/207464402-f3521711-9b45-4ac0-8197-3aa5b7c1f078.png)

  <pre><code>mv ProyectoASIR/proyecto/foro/* ./
  rm -r ProyectoASIR/</code></pre>  
  
  ![image](https://user-images.githubusercontent.com/76048388/207464639-32df1a13-74c8-46e1-b1b1-1bdb89b80854.png)

  ![image](https://user-images.githubusercontent.com/76048388/207464829-278e1f51-88c9-473c-8e0f-eadd94c8229b.png)

  ![image](https://user-images.githubusercontent.com/76048388/207468498-99bd168d-5c4d-4831-b376-da7382d8a883.png)
  
  <h3>Añadiendo contenido a la base de datos</h3>
  
  <pre><code>yum install mariadb</code></pre>  
  <pre><code>mysql --version</code></pre>  
  
  ![image](https://user-images.githubusercontent.com/76048388/207466191-3d09d6d3-ae84-45ee-8df8-84f87d499e22.png)

  ![image](https://user-images.githubusercontent.com/76048388/207466437-90ff75af-cca0-470d-9820-08742cc4f576.png)
![image](https://user-images.githubusercontent.com/76048388/207466517-4a605c74-201f-48d3-a137-d4168d0fdd2f.png)
![image](https://user-images.githubusercontent.com/76048388/207466572-0b8fbdfd-0e5b-4558-81ff-3bf2372a421d.png)
![image](https://user-images.githubusercontent.com/76048388/207466706-bc40d66f-5c9d-47fd-a899-8ad664b49689.png)
![image](https://user-images.githubusercontent.com/76048388/207466740-b42cc4d1-9a0e-481c-9958-0bafe4a9acec.png)
![image](https://user-images.githubusercontent.com/76048388/207466847-1ff5b6f9-1f0c-4859-897d-67eaa6741ec1.png)
![image](https://user-images.githubusercontent.com/76048388/207467023-8b5e6902-fb2f-4620-a83e-bf6c45a5eacd.png)

![image](https://user-images.githubusercontent.com/76048388/207469031-0330307e-1d5f-4ca4-8c29-5ad9f8e31ba9.png)
  
  <h3>Prueba de funcionamiento</h3>
  ![image](https://user-images.githubusercontent.com/76048388/207469271-00a5dd54-1f16-451e-b6fe-56c9cb655988.png)
![image](https://user-images.githubusercontent.com/76048388/207469349-8eabfc45-c370-42f3-838d-7b1c2905092d.png)
![image](https://user-images.githubusercontent.com/76048388/207469387-0702bb71-2c90-41ba-a61f-7c0c6405618d.png)

  
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

Copiaremos el siguiente repositorio:
<pre><code>git clone https://github.com/hashicorp/learn-terraform-provision-eks-cluster</code></pre>

Nos moveremos al repositorio:
<pre><code>cd learn-terraform-provision-eks-cluster</code></pre>

Al listar veremos que dentro hay varios archivos:
<img src="https://user-images.githubusercontent.com/76048388/206292640-19471772-352e-4c19-8a51-d5ff9c938734.png">

El archivo <b>variables.tf</b> sirve para definir las variables, como por ejemplo la región. Si hacemos un cat del archivo, nos saldrá este contenido, que podremos ajustar al que necesitemos.
<pre><code>variable "region" {
  description = "AWS region"
  type        = string
  default     = "eu-west-1"
}
</code></pre>

El archivo <b>vpc.tf</b> contiene el VPC, las subredes, las zonas de disponibilidad, etcétera.
<pre><code>module "vpc" {
  source  = "terraform-aws-modules/vpc/aws"
  version = "3.14.2"

  name = "education-vpc"

  cidr = "10.0.0.0/16"
  azs  = slice(data.aws_availability_zones.available.names, 0, 3)

  private_subnets = ["10.0.1.0/24", "10.0.2.0/24", "10.0.3.0/24"]
  public_subnets  = ["10.0.4.0/24", "10.0.5.0/24", "10.0.6.0/24"]

  enable_nat_gateway   = true
  single_nat_gateway   = true
  enable_dns_hostnames = true

  public_subnet_tags = {
    "kubernetes.io/cluster/${local.cluster_name}" = "shared"
    "kubernetes.io/role/elb"                      = 1
  }

  private_subnet_tags = {
    "kubernetes.io/cluster/${local.cluster_name}" = "shared"
    "kubernetes.io/role/internal-elb"             = 1
  }
}
</code></pre>

En el archivo <b>terraform.tf</b> veremos los proveedores requeridos para Kubernetes y sus versiones.
<pre><code>terraform {
  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "~> 4.15.0"
    }

    random = {
      source  = "hashicorp/random"
      version = "~> 3.1.0"
    }

    tls = {
      source  = "hashicorp/tls"
      version = "~> 3.4.0"
    }

    cloudinit = {
      source  = "hashicorp/cloudinit"
      version = "~> 2.2.0"
    }

    kubernetes = {
      source  = "hashicorp/kubernetes"
      version = "~> 2.12.1"
    }
  }

  required_version = "~> 1.3"
}</code></pre>

En el archivo security-groups.tf podremos definir los grupos de seguridad a modo de firewall.
<pre><code>resource "aws_security_group" "node_group_one" {
  name_prefix = "node_group_one"
  vpc_id      = module.vpc.vpc_id

  ingress {
    from_port = 22
    to_port   = 22
    protocol  = "tcp"

    cidr_blocks = [
      "10.0.0.0/8",
    ]
  }
}

resource "aws_security_group" "node_group_two" {
  name_prefix = "node_group_two"
  vpc_id      = module.vpc.vpc_id

  ingress {
    from_port = 22
    to_port   = 22
    protocol  = "tcp"

    cidr_blocks = [
      "192.168.0.0/16",
    ]
  }
}</code></pre>

En el archivo <b>outputs.tf</b> aparecerán las salidas que se obtendrán al terminar de iniciar el Terraform.

<pre><code>output "cluster_id" {
  description = "EKS cluster ID"
  value       = module.eks.cluster_id
}

output "cluster_endpoint" {
  description = "Endpoint for EKS control plane"
  value       = module.eks.cluster_endpoint
}

output "cluster_security_group_id" {
  description = "Security group ids attached to the cluster control plane"
  value       = module.eks.cluster_security_group_id
}

output "region" {
  description = "AWS region"
  value       = var.region
}

output "cluster_name" {
  description = "Kubernetes Cluster Name"
  value       = local.cluster_name
}</code></pre>

Por último, en el archivo <b>eks-cluster</b> tenemos las configuraciones relativas al EKS. Lo he ajustado a t2.micro ya que haré el mínimo uso.
<pre><code>module "eks" {
  source  = "terraform-aws-modules/eks/aws"
  version = "18.26.6"

  cluster_name    = local.cluster_name
  cluster_version = "1.22"

  vpc_id     = module.vpc.vpc_id
  subnet_ids = module.vpc.private_subnets

  eks_managed_node_group_defaults = {
    ami_type = "AL2_x86_64"

    attach_cluster_primary_security_group = true

    # Disabling and using externally provided security groups
    create_security_group = false
  }

  eks_managed_node_groups = {
    one = {
      name = "node-group-1"

      instance_types = ["t2.micro"]

      min_size     = 1
      max_size     = 3
      desired_size = 2

      pre_bootstrap_user_data = <<-EOT
      echo 'foo bar'
      EOT

      vpc_security_group_ids = [
        aws_security_group.node_group_one.id
      ]
    }

    two = {
      name = "node-group-2"

      instance_types = ["t2.micro"]

      min_size     = 1
      max_size     = 2
      desired_size = 1

      pre_bootstrap_user_data = <<-EOT
      echo 'foo bar'
      EOT

      vpc_security_group_ids = [
        aws_security_group.node_group_two.id
      ]
    }
  }
}
</code></pre>

Una vez configurados todos los archivos, iniciaremos Terraform mediante el siguiente comando:
<pre><code>terraform init</code></pre>

Una vez creado, podremos ver que está activo mediante la consola.
<img src="https://user-images.githubusercontent.com/76048388/206270144-f7001f7b-bcd2-4a75-bf7d-55b1c64154d3.png">

# Implantación del foro en un servidor Nginx
Una vez sabiendo cómo se crea el clúster de Kubernetes, solamente queda habilitar el servidor web, para lo que utilizaremos Nginx, y el servidor mySQL.
Crearé un archivo llamado <b>nginx.tf</b> que llevará dentro el módulo Nginx.
<pre><code>
module "eks-ingress-nginx" {
  source  = "lablabs/eks-ingress-nginx/aws"
  version = "1.2.0"
}
</code></pre>

# Acceder por SSH
Una vez realizada la configuración, habremos creado un servidor, que actuará como cualquier otra máquina en la que hubiéramos instalado Ubuntu Server 22.04.
Querremos acceder por SSH, para ello tenemos primero que configurar la CLI de AWS con el siguiente comando. Pedirá las claves de acceso que generamos anteriormente.
<pre><code>aws configure</code></pre>
Ahora tenemos que crear un keypair en la CLI de AWS con el siguiente comando. Esto generará una clave pública y una privada.
<pre><code>aws ec2 create-key-pair --key-name ElNombreQueQueramos</code></pre>

Copiaremos el contenido de "KeyMaterial" a un archivo vacío en la ruta que queramos, lo normal es guardarlo en la carpeta ~/.ssh.

Nos aseguraremos de la IP pública o del DNS público de la instancia de AWS mediante uno de los siguientes comandos:
<pre><code>terraform show | grep public_dns
terraform show | grep public_ip</code></pre>

Copiaremos ese DNS o IP y para acceder por SSH usaremos el siguiente comando:
<pre><code>ssh -i RutaClavePrivada ec2-user@ec2-34-*-*-*.eu-west-1.compute.amazonaws.com</code></pre>

# Conclusión del proyecto
Como conclusión, queda claro que mediante PHP y mySQL no es difícil hacer un foro básico, y mediante otras herramientas como AWS o cualquier otro hosting en la nube ya no es necesario hostearlo en una máquina física.

# Bibliografía
<ul>
  <li>https://www.apachefriends.org/es/index.html</li>
  <li>https://openwebinars.net/blog/por-que-usar-terraform/</li>
  <li>https://code.tutsplus.com/es/tutorials/how-to-create-a-phpmysql-powered-forum-from-scratch--net-10188</li>
  <li>https://developer.hashicorp.com/terraform/tutorials/aws-get-started</li>
  <li>https://developer.hashicorp.com/terraform/tutorials/kubernetes/eks</li>
  <li>https://rm-rf.es/como-conectar-ssh-instancia-aws-ec2-linux/#:~:text=C%C3%B3mo%20conectar%20por%20SSH%20a%20una%20instancia%20AWS,de%20instancia%2C%20IP%20y%20su%20DNS%20p%C3%BAblico%20</li>
  <li>https://developer.hashicorp.com/terraform/tutorials/kubernetes/kubernetes-provider</li>
  <li>https://docs.aws.amazon.com/es_es/AmazonRDS/latest/UserGuide/TUT_WebAppWithRDS.html
  https://aws.amazon.com/es/getting-started/hands-on/deploy-wordpress-with-amazon-rds/4/</li>
</ul>

# Autoría
<p>Este proyecto ha sido creado por Andrea Osma Rafael, como proyecto de fin de grado del Grado Superior de Administración de Sistemas Informáticos en Red terminado en el año 2022.</p>

# Licencia
<p xmlns:cc="http://creativecommons.org/ns#" xmlns:dct="http://purl.org/dc/terms/"><a property="dct:title" rel="cc:attributionURL" href="https://github.com/Andify28/ProyectoASIR">Red empresarial en AWS - Proyecto de fin de grado de ASIR</a> by <a rel="cc:attributionURL dct:creator" property="cc:attributionName" href="https://github.com/Andify28">Andrea Osma Rafael</a> is licensed under <a href="http://creativecommons.org/licenses/by-nc-sa/4.0/?ref=chooser-v1" target="_blank" rel="license noopener noreferrer" style="display:inline-block;">CC BY-NC-SA 4.0<img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/cc.svg?ref=chooser-v1"><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/by.svg?ref=chooser-v1"><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/nc.svg?ref=chooser-v1"><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/sa.svg?ref=chooser-v1"></a></p>

<a href="#top">Volver al inicio</a>
