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
?>

<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<title>Radicar y visualizar documentos salidos | REDOHIS</title>
</head>

<?php 
include('conexion.php'); # En este caso, acá empieza el codigo PHP  para que este formulario conecte con la bse de datos almacenanda en el servidor.

$tmp = array();
$res = array();

$sel = $con->query("SELECT * FROM files");
while ($row = $sel->fetch_assoc()) {
    $tmp = $row;
    array_push($res, $tmp);
} # se montó la base de datos en el local host, para que enumere secuencialmente el numero de documentos.
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-center">
                    <h1>RADICAR Y VISUALIZAR DOCUMENTOS SALIDOS | REDOHIS</h1>
                </div>
            </div>

            <div class="row justify-content-md-left"> <!--SE AJUSTÓ LA PAGINA HACIA LA IZQUIERDA -->
                <div class="col-8">

                <footer>
                                <div align ="center">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Cargar nuevo documento</button>
        
                    <a class="btn btn-primary" href="index.php">Volver a inicio <span class="sr-only">(current)</span></a>
      
                </div>


                    <table class="table"> <!-- SE PONE TABLA PARA AJUSTARLA EN TODA LA PANTALLA -->
                    <thead class="thead-dark"> <!-- SE PONE AL ENCABEZADO DE LA TABLA UN COLOR NEGRITO -->
                            <tr>
                                <th scope="col">No. de orden</th>
                                <th scope="col">Número de Radicado</th>
                                <th scope="col">Fecha de carga del documento</th>
                                <th scope="col">Fecha del documento</th>
                                <th scope="col">Título del documento</th>
                                <th scope="col">Asunto del documento</th>
                                <th scope="col">Remitente</th>
                                <th scope="col">Destinatario</th>
                                <th scope="col">Dirección o Correo Electrónico</th>
                                <th scope="col">Acciones</th><!--Boton para dar clic-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($res as $val) { ?>
                                <tr>
                                    <td><?php echo $val['id'] ?> </td> <!--Estas son las columnas que se encuentran en la base datos del proyecto-->
                                    <td><?php echo $val['pin'] ?> </td>
                                    <td><?php echo $val['date'] ?> </td>
                                    <td><?php echo $val['dater'] ?> </td>
                                    <td><?php echo $val['title'] ?></td>
                                    <td><?php echo $val['description'] ?></td>
                                    <td><?php echo $val['sender'] ?></td>
                                    <td><?php echo $val['adresse'] ?></td>
                                    <td><?php echo $val['adress'] ?></td>
                                    <td>
                                        <button onclick="openModelPDF('<?php echo $val['url'] ?>')" class="btn btn-primary" type="button">Visualizar Documento</button><!--la acción que debe ejecutar la maquina, al momento de presionar ael boton visualizar documento-->
    
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal --><!--cuando se habla de modal, es la ventana flotante donde se puede visualizar los documentos PDF.-->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cargar nuevo documento</h5><!--este es el boton para que se ejecute la tarea de cargar el documento en el servidor-->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"><!--lo que se mostrará en pantalla-->
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
                                <input type="text" class="form-control" id="pin" name="pin" value="<?php echo rand() . "\n"; echo rand(1,1);?>"> <!-- SE COLOCA ESTO EN EL PROYECTO ORIGINAL-->
                            </div>


                            <div class="form-group">
                                <label for="description">Adjuntar Documento</label>
                                <input type="file" class="form-control" id="file" name="file">
                            </div>
                        </form><!--termina lo que se mostrará en pantalla-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="location.reload()">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="onSubmitForm()">Guardar</button><!--Este es el boton para guardar datos en el formulario + base de datos y en el Ajax-->
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modalPdf" tabindex="-1" aria-labelledby="modalPdf" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Vista del documento</h5><!--Este boton sirve mas que todo para que al presionar en el mismo, se puede ver el documento en pdf cargado, esa una función JavaScript-->
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
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
       
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
                                xhttp.open("POST", "upload.php", true);
                                xhttp.send(data);
                                $('#form1').trigger('reset');
                            }
                            function openModelPDF(url) {
                                $('#modalPdf').modal('show');
                                $('#iframePDF').attr('src','<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/REDOHIS/'; ?>'+url); 
                            }
        </script>
        <!-- EN EL SIGUIENTE SCRIPT, LO QUE HACE ES RECARGAR LA PAGINA, AL MOMENTO DE PRESIONAR EL BOTÓN "CERRAR" DEL NODAL ESCRITO EN LA LINEA 119; LA CUAL ES UNA FUNCIÓN JAVASCRIPT -->
        <script>
                                location.reload(cargardoc.php); 
        </script> 
       





       <footer>
                                <div align ="center">
                                <p>Documentado por: @wagnerfer - SAGEN - CAGESDO - © 2021</p>
        </div>

 </body>

</html>

<!--borrador para comentario en ->

