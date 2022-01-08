<?php
# Este es el procedimiento PHP para hacer login. y al momento de insertar los datos correctamente, se abra la pagína de inicio.

# Iniciar sesión para usar $_SESSION
session_start();

# Y ahora leer si NO hay algo llamado usuario en la sesión,
# usando empty (vacío, ¿está vacío?)
if (empty($_SESSION["usuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    header("Location: login.html");
    # Y salimos del script
    exit(); #en este caso, para que pueda abrir esta pagina web, se debe pasar por el proceso de autenticado.
}
?>
<!DOCTYPE html> 
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Menú Principal | REDOHIS</title>
	<link rel="stylesheet" href="mascarainicio.css">
</head>
<body>
	<header>
		<div class="wrapp">
			<div class="logo">
				<a href="#"><img src="logo/docec.jpg" alt="CIDOHIS"></a>
			</div>
			<nav>
				<ul>
					<li><a href="cargardoc.php">Ver o radicar Documentos salidos</a></li>
					<li><a href="cargaindex.php">Consultar expedientes historicos</a></li>
					<li><a href="logout.php">Cerrar sesión</a></li>
				</ul>
			</nav>
		</div>
	</header>
	<section class="main">
		<div class="wrapp">
			<div align ="center">
				<h1>Bienvenido a REDOHIS - El repositorio documental histórico
				</h1>
			</div>
			<div class="mensaje">
				<h1>¿Qué es REDOHIS?</h1>
			</div>
			<div class="articulo"> <!--TODO: Toca meterle o quitarle la carreta a la cuestión de los textos. -->
				<article> 
					<p>El Repositorio de Documentos Históricos - (REHODIS) es una herramienta para gestionar la información histórica en documentos, de acorde a los Sistemas de Gestión de Documentos Electrónicos de Archivo – SGDEA; lo cual orienta conformar y custodiar un archivo electrónico personal e institucional en sus diferentes fases. Por ende, coadyuva a constituir el patrimonio documental electrónico y digital de las personas, empresas, entidades, regiónes o naciones.</p>
					<br/>
					<p>Está ligado, y hace parte del Componente de Gestión Documental (CAGESDO) del Sistema de Administración General (SAGEN) para conservar esa memoria histórica ante problemas jurídicos, legales y/o administrativos que se presenten.</p>
					<br/>
					<p>Este sistema, servirá para almacenar  y mostrar los documentos gestionados, producto de las actuaciones a nivel personal, laboral y/o profesional, que han terminado su tiempo de gestión y vigencia en la plataforma Evernote y OneNote de Microsoft Office 365.</p>
					<br/>
					<p>Con esto, se da cumplimiento la conservación de los archivos en su etapa final y semiactiva.

					"La poesía es la memoria de la vida y los archivos son su lengua."-(Octavio Paz).</p>
				</article>
			</div>

			<aside>
				<div class="widget">
					<h3> Archivos de Gestión </h3>
					<ul>

						<li><a href="https://evernote.com/intl/es"Target="blank">EVERNOTE - Archivo Personal</a></li> <!-- Ya se hizo lo de los enlaces a la plataforma Evernote. --> <!--Para poder abrir los enlaces en otra pagina, se utiliza ls etiqueta "<a href ="URL">Texto</a>." , que sirve para que la computadora entienda la orden y abra el enlace en la página en blanco -->

						<li><a href="https://www.office.com/launch/onenote?auth=2" Target="blank">ONENOTE - Archivo Laboral</a></li>   <!-- Ya se hizo lo de los enlaces a la plataforma OFFICE 365 --> <!--Para poder abrir los enlaces en otra pagina, se utiliza ls etiqueta "<a href ="URL">Texto</a>." , que sirve para que la computadora entienda la orden y abra el enlace en la página en blanco -->

					</ul>
				</div>
			</aside>
		</div>
	</section>
	<footer>
		<div class="wrapp">
			<p>Documentado por: @wagnerfer - SAGEN - CAGESDO - © 2021</p> <!--TODO:Cambiarle esta cuestión de las pruebas, cuando el software sea operativo-->

		</div>
	</footer>
</body>
</html>
