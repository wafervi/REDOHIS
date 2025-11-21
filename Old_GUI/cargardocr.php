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
?> <!-- Lo anterior, el procedimiento de inicio de seión-->

<!DOCTYPE html> 
<head> <!-- Aquí empieza el encabezado del modulo para radicar documentos-->
	<meta charset="UTF-8">
	<title>Radicar y visualizar documentos salidos | REDOHIS</title> <!--Titulo que mostrará en la pestaña del navegador web-->
</head>

<?php


if (empty($_SESSION["usuario"])) {
    header("Location: login.html");
    exit();
}

include('conexion.php');

$tmp = array();
$res = array();

# Manejar búsqueda
$search = isset($_GET['search']) ? $_GET['search'] : '';

# Consulta SQL con filtro de búsqueda
$sel = $con->query("SELECT * FROM filer WHERE title LIKE '%$search%' OR description LIKE '%$search%' OR sender LIKE '%$search%' OR adresse LIKE '%$search%'");

while ($row = $sel->fetch_assoc()) {
    $tmp = $row;
    array_push($res, $tmp);
}
?>

<html>

    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    </head> <!-- Se toma una referencia, para que en la pagina web, se muestre el codigo CSS establecido, se puede colocar un archivo local y ajustarlo-->
    
    <body>
        
        <div class="container">
            <div class="row justify-content-md-left">
                <div class="col-md-center">
                    <h4>RADICAR Y VISUALIZAR DOCUMENTOS RECIBIDOS|REDOHIS</h4> <!--Titulo que mostrará en la pagina web-->
                </div>
            </div>

    <!-- Formulario de búsqueda -->
    <div class="row justify-content-md-center mb-3">
        <div class="col-md-8">
            <form method="GET" action="">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Buscar documentos" value="<?php echo htmlspecialchars($search); ?>">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

            <div class="row justify-content-md-left"> <!--SE AJUSTÓ LA PAGINA HACIA LA IZQUIERDA -->
                <div class="col-12">

                <footer> <!--Se crear y ajustan los botones hacia el centro, y por encima de la tabla que muestra los datos que hacen relación a los documentos radicados -->
                <div align ="center">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Radicar nuevo documento</button> <!--Boton para radicar un nuevo documento -->
                    <a class="btn btn-primary" href="index.php">Volver a Inicio <span class="sr-only">(current)</span></a><!--para volver a la pagina principal -->
                    <a class="btn btn-primary" href="cargaindex.php">Expedientes Archivados <span class="sr-only">(current)</span></a>
                    <a class="btn btn-primary" href="logout.php">Cerrar Sesión <span class="sr-only">(current)</span></a>
                
                    <hr style="margin-top:10px;margin-bottom: 10px;">
                    
                    
                </div>
                <div align ="center">
            </div>


<?php
        // Número de registros por página
        $limit = 5;

        // Página actual
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max($page, 1); // Asegurarse de que la página sea al menos 1

        // Calcular el offset
        $offset = ($page - 1) * $limit;

        // Contar el total de registros
        $totalQuery = $con->query("SELECT COUNT(*) as total FROM filer WHERE title LIKE '%$search%' OR description LIKE '%$search%' OR sender LIKE '%$search%' OR adresse LIKE '%$search%'");
        $totalRow = $totalQuery->fetch_assoc();
        $totalRecords = $totalRow['total'];

        // Calcular el total de páginas
        $totalPages = ceil($totalRecords / $limit);

        // Consulta SQL con límite y offset
        $sel = $con->query("SELECT * FROM filer WHERE title LIKE '%$search%' OR description LIKE '%$search%' OR sender LIKE '%$search%' OR adresse LIKE '%$search%' LIMIT $limit OFFSET $offset");

        $res = [];
        while ($row = $sel->fetch_assoc()) {
            $res[] = $row;
        }
        ?>
        
<!-- En el siguiente fragmento de codigo, se muestra como se mostrará la estructura de la tabla,  -->
                    <table class="table"> <!-- SE PONE TABLA PARA AJUSTARLA EN TODA LA PANTALLA -->
                    <thead class="thead-dark"> <!-- SE PONE AL ENCABEZADO DE LA TABLA UN COLOR NEGRITO -->
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Número de Radicado</th>
                                <th scope="col">Fecha de carga del documento</th>
                                <th scope="col">Número de Páginas</th>
                                <th scope="col">Fecha del documento</th>
                                <th scope="col">Título del documento</th>
                                <th scope="col">Asunto del documento</th>
                                <th scope="col">Remitente</th>
                                <th scope="col">Destinatario</th>
                                <th scope="col">Dirección o Correo Electrónico</th>
                                <th scope="col">Acciones</th><!--Boton para dar clic-->

                            </tr><!-- termina el codigo, que se muestra como se mostrará la estructura de la tabla,  -->
                        </thead>
                       
                        <tbody> <!-- En este fragmento de codigo, se referencian los valores que se estipularon en la tabla anterior; cuyos valores son los mismos que están escritos en la BD -->
                            <?php foreach ($res as $val) { ?>
                                <tr>
                                    <td><?php echo $val['id'] ?> </td> <!--Estas son las columnas que se encuentran en la base datos del proyecto-->
                                    <td><?php echo $val['pin'] ?> </td>
                                    <td><?php echo $val['date'] ?> </td>
                                    <td><?php echo $val['pages'] ?> </td>
                                    <td><?php echo $val['dater'] ?> </td>
                                    <td><?php echo $val['title'] ?></td>
                                    <td><?php echo $val['description'] ?></td>
                                    <td><?php echo $val['sender'] ?></td>
                                    <td><?php echo $val['adresse'] ?></td>
                                    <td><?php echo $val['adress'] ?></td>
                                    <td>
                                        <button onclick="openModelPDF('<?php echo $val['url'] ?>')" class="btn btn-primary" type="button">Visualizar Documento</button><!--la acción que debe ejecutar la maquina, al momento de presionar ael boton visualizar documento es mostrar la ventana, que visualizará el documento PDF, ver lineas 161 a 178-->
                                    </td>

                                </tr> 
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
   
  <!--En este fragmento, se diseña y optimiza un modal, cuando se habla de modal, es la ventana flotante en donde se puede visualizar los documentos PDF.-->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Radicar nuevo documento</h5><!--este es el boton para que se ejecute la tarea de cargar el documento en el servidor-->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"><!--formulario que se mostrará en pantalla, al momento de empezar a radicar el documento-->
                        <form enctype="multipart/form-data" id="form1">
                            <div class="form-group">
                                <label for="title">Título del documento</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                            <div class="form-group">
                                <label for="description">Asunto del documento</label>
                                <input type="text" class="form-control" id="description" name="description">
                            </div>
                            <div class="form-group">
                                <label for="description">Remitente</label>
                                <input type="text" class="form-control" id="sender" name="sender">
                            </div>

                            <div class="form-group">
                                <label for="pages">Páginas</label>
                                <input type="text" class="form-control" id="pages" name="pages">
                            </div>
                            
                            <div class="form-group">
                            <label for="description">Fecha del documento</label>
                            <input type="date" class="form-control" id="dater" name="dater" min="1900-01-01" max="2099-12-31" value="<?php echo date("Y-m-d");?>">
                            </div>

                            <div class="form-group">
                                <label for="description">Destinatario</label>
                                <input type="text" class="form-control" id="adresse" name="adresse">
                            </div>
                            <div class="form-group">
                                <label for="description">Dirección</label>
                                <input type="text" class="form-control" id="adress" name="adress">
                            </div>

                            <div class="form-group">
                                <label for="description">Radicado del documento</label>
                                <input type="text" class="form-control" id="pin" name="pin" value="<?php echo rand() . "\n"; echo rand(1,1);?>"> <!-- Aquí se programa un condicional en PHP RAND, para que muestre un numero aleatorio, que no sea repetible, y sea insertado en la DB, que viene siendo el radicado del documento-->
                            </div>


                            <div class="form-group">
                                <label for="description">Adjuntar Documento</label>
                                <input type="file" class="form-control" id="file" name="file">
                            </div>
                        </form><!--termina el formulario que se mostrará en pantalla, al momento de empezar a radicar el documento-->
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="onSubmitForm()">1- Guardar</button><!--Este es el boton para guardar datos en el formulario + base de datos y en el Ajax, -->
                    <button type="button" class="btn btn-secondary" onclick="location.reload()">2- Cerrar</button><!--Este es el boton es para cerrar el formulario, al momento de radicar y guardar el documento, se anexa un script de Js para que vuelva a recargar la pagina-->
                    </div>
                </div>
            </div><!--Termina el fragmento donde se diseña y optimiza un modal, cuando se habla de modal, es la ventana flotante en donde se puede visualizar los documentos PDF.-->
        
        </div><!--Luego de diseñar la tabla, se muestra la estructura del visualizador de documentos en formato PDF,  -->
        <div class="modal fade" id="modalPdf" tabindex="-1" aria-labelledby="modalPdf" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">VISTA DEL DOCUMENTO RADICADO</h5><!--Este texto sirve mas que todo para mostrar en el modal la palabra escrita en blanco-->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <iframe id="iframePDF" frameborder="0" scrolling="no" width="100%" height="500px"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div><!--Termina la ultima opción, que es un botón para que muestre ventana o modal, para poder visdualizar los documentos en formato PDF,  -->
        
        </div>
        <!--Acontinuación en este fragmento de codigo, se muestra las referencias de las librerías, que nos ayudan a que la pagina esté animada,  -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> <!--referencias del jquery para personalizar la pagina-->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script> <!-- referencias del jsdelivr para personalizar la pagina, es un CDN  por sus siglas en inglés, es una red de distribución de contenidos, para optimizar el ancho de banda -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script> <!--referencias del Boostrap para personalizar la pagina -->
       <!--Termina el codigo, que muestra las referencias de las librerías, que nos ayudan a que la pagina esté animada,  -->
 
 
        <!-- EN EL SIGUIENTE SCRIPT, LO QUE HACE ES CARGAR EL DOCUMENTO EN PDF, CUANDO SE DA CLIC EN EL BOTON GUARGAR, INTEGRADO EN EL FORMULARIO; ESCRITO EN LA LINA 120, se trabaja con AJAX y javascript-->
        <script>
                            function onSubmitForm() {
                                var frm = document.getElementById('form1');
                                var data = new FormData(frm);
                                var xhttp = new XMLHttpRequest();
                                xhttp.onreadystatechange = function () {
                                    if (this.readyState == 4) {
                                        var msg = xhttp.responseText;
                                        if (msg == '¡Archivo cargado exitosamente!') {
                                            alert(msg);
                                            $('#exampleModal').modal('hide')
                                        } else {
                                            alert(msg);
                                        }

                                    }
                                };
                                xhttp.open("POST", "uploadfiler.php", true);
                                xhttp.send(data);
                                $('#form1').trigger('reset');
                            }
                            function openModelPDF(url) {
                                $('#modalPdf').modal('show');
                                $('#iframePDF').attr('src','<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/REDOHIS/'; ?>'+url); 
                            }
        </script>
       <!-- TERMINA EL SCRIPT, LO QUE HACE ES CARGAR EL DOCUMENTO EN PDF, CUANDO SE DA CLIC EN EL BOTON GUARGAR, INTEGRADO EN EL FORMULARIO; ESCRITO EN LA LINA 120, se trabaja con AJAX y javascript-->
       
       <!-- EN EL SIGUIENTE SCRIPT, que es un javascript, LO QUE HACE ES RECARGAR LA PAGINA, AL MOMENTO DE PRESIONAR EL BOTÓN "CERRAR" DEL NODAL ESCRITO EN LA LINEA 119; LA CUAL ES UNA FUNCIÓN JAVASCRIPT -->
        <script>
                                location.reload(cargardoc.php); 
        </script> 
    

       <footer> <!--Para el pie de pagina, se hace colocar el nobre del autor, alineado al centro -->
                                <div align ="center">
                                <p>Documentado por: <a href="https://github.com/wafervi" target="_blank">@wafervi</a> - SAGEN - CAGESDO - © 2021</p> 
        </div>
<!-- Paginación -->
        <div class="row justify-content-md-center">
            <nav>
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?search=<?php echo htmlspecialchars($search); ?>&page=<?php echo $page - 1; ?>">Anterior</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                            <a class="page-link" href="?search=<?php echo htmlspecialchars($search); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?search=<?php echo htmlspecialchars($search); ?>&page=<?php echo $page + 1; ?>">Siguiente</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>

 </body><!--Termina el cuerpo de la pagina o modulo -->



 
</html>

