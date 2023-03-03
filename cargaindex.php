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
    exit();
}
?> <!--En el anterior codigo, es lo que respecta el inicio de sesion de usuario -->

<!DOCTYPE html> <!--Empieza el encabezado de la pagina web -->
<html>
<head>
<title>Historial de expedientes | REDOHIS</title><!--Titulo de que muestra la pestaña del navegador -->

<!-- En este caso, se toma una referencia del estilo CSS que utiliza la pagina web -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

<!-- En este caso, se toma una referencia del estilo CSS que utiliza la pagina web -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!-- En este caso, se toma una referencia del estilo CSS que utiliza la pagina web, con su respectivo javascript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>

<!-- En este caso, se tiene en cuenta la posición delos botones y tablas que se muestran en la pagina web -->
<style> 
.navbar {
	position: relative;
	min-height: 50px;
	margin-bottom: 5px;
}
</style>
</head>

<!-- Comienza el cuerpo de la pagina web, para cargar los expedientes archivados -->
<body>
<div role="navigation" class="navbar navbar-inverse navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a href="#" class="navbar-brand"></a> </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
      </ul>
    </div>
  </div>
</div>

<!-- Se muestra el titulo de la pagina web -->
<div class="container"> 
  <div class="row justify-content-md-center">
  <div class="col-md-center">
    <h4>ARCHIVAR EXPEDIENTES GESTIONADOS | REDOHIS</h4> <!-- Se muestra el titulo de la pagina web -->
    <hr style="margin-top:5px;margin-bottom: 5px;">
    <div class="content"> </div>
    <div class="panel panel-primary">
      <div class="panel-heading">
        <!--<h3 class="panel-title">Cargar Expediente</h3>  Se muestra el titulo y la estructura de la primera tabla, la cual es para hacer el proceso de carga del expediente -->
      <!--</div>
      <div class="panel-body">
        <div class="col-lg-6">
          <form method="POST" action="CargarFicheros.php" enctype="multipart/form-data"> --><!-- Se carga por metodo POST, el archivo del proyecyo, que hace el cargue de los documentos adjuntos  -->

          <!--<div class="form-group">
              <label class="btn btn-primary" for="my-file-selector"> <!-- tipo de archivo a seleccionar en la pagina web-->
               <!-- <input required="" type="file" name="file" id="exampleInputFile">
              </label>-->
<!-- Termina la primera tabla-->          
    
            <!--</div>
        <button class="btn btn-primary" type="submit">Cargar Adjunto</button> <!-- Se crea el boton que al dar clic, carga el ajunto a la carpeta destinada para tal fin en el proyecto -->
        </form>
        </div>
        <div class="col-lg-6"> </div>
        </div>
    </div>
  
<!--Aquí, se elabora y empieza la segunda tabla, que es donde se muestra la lista de los expedientes archivados-->
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Lista de Expedientes Archivados</h3>
      </div>
      <div class="panel-body">
   
<table class="table"> <!--Tipo de codigo que se interpreta como tabla-->
  <thead>
    <tr>
      <th width="7%">#</th>
      <th width="70%">Nombre del Expediente</th> <!-- Se muestra la primera columna de la segunda tabla -->
      <th width="13%">Descargar una copia </th> <!-- Se muestra la segunda columna de la segunda tabla -->
    </tr>
  </thead>
  
<tbody>

<!-- se documenta el codigo PHP, que permite la carga de archivos de cualquier tipo a la carpeta destinada para guardarlos, la cual se llama "exp" -->
<?php
$REDOHIS = scandir("exp");
$num=0;
for ($i=2; $i<count($REDOHIS); $i++)
{$num++;
?>
<p>  
 </p>
         
    <tr>
      <th scope="row"><?php echo $num;?></th>
      <td><?php echo $REDOHIS[$i]; ?></td>
      <td><a title="Descargar Archivo" href="exp/<?php echo $REDOHIS[$i]; ?>" download="<?php echo $REDOHIS[$i]; ?>" style="color: blue; font-size:18px;"> <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> </a></td> <!--Aquí se explica claramente, como hacer el proceso de descarga de archivos y se diseñó un botón para ello--> 
    </tr>
 <?php }?> 

</tbody>
</table>
</div>
</div>
<!-- NOTA: ES DE ANOTAR, QUE ES NECESARIO CONFIGURAR Y DDEFINIR EL NOMBRE DE LS CARPETA O PROYECTO, EN ESTE CASO ES REDOHIS, PARA QUE GUARDE EN EL DIRECTORIO EXP--> 
<!-- Termina la segunda tabla con el codigo PHP--> 

</div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
</body>

<footer> 
<div align ="center">
<a class="btn btn-primary" href="index.php">Volver a inicio <span class="sr-only">(current)</span></a> <!-- Se diseña un botón, para volver el menu inicio o pagina principal--> 
</div>

<footer> <!-- Se documenta el autor del desarrollo--> 
                                <div align ="center">
                                <p>Documentado por: @wagnerfv1117 - SAGEN - CAGESDO - © 2021</p>
</div>

</html>

<!-- Fuente de ayuda: Baul PHP--> 
