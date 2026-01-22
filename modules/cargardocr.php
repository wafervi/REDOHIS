<?php

session_start();

if (empty($_SESSION["usuario"])) {
    
    header("Location: login.html");
    
    exit();
}
?> <!-- Lo anterior, es el procedimiento de inicio de seión-->

<!DOCTYPE html> 
<head> 
	<meta charset="UTF-8">
	<title>Radicar y visualizar documentos recibidos| REDOHIS</title> <!--Titulo que mostrará en la pestaña del navegador web-->
</head>

<?php


if (empty($_SESSION["usuario"])) {
    header("Location: login.html");
    exit();
}

include('conexion.php');

function safe_output($s) {

    $s = (string)$s;
    
    $decoded = html_entity_decode($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    return htmlspecialchars($decoded, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

# Manejar búsqueda
$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchEsc = $con->real_escape_string($search);

# Se programa para que la paginación se muestre de a 5 registros en el módulo
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $limit;

# Contar total de registros (con filtro al consultar en la DB)
$totalQuery = $con->query("SELECT COUNT(*) as total FROM filer WHERE title LIKE '%$searchEsc%' OR description LIKE '%$searchEsc%' OR sender LIKE '%$searchEsc%' OR adresse LIKE '%$searchEsc%'");
$totalRow = $totalQuery->fetch_assoc();
$totalRecords = (int)$totalRow['total'];
$totalPages = $totalRecords > 0 ? ceil($totalRecords / $limit) : 1;

# Obtener registros para la página actual al momento de hacer filtrado en la barra de busqueda
$sel = $con->query("SELECT * FROM filer WHERE title LIKE '%$searchEsc%' OR description LIKE '%$searchEsc%' OR sender LIKE '%$searchEsc%' OR adresse LIKE '%$searchEsc%' ORDER BY id DESC LIMIT $limit OFFSET $offset");

$res = [];
while ($row = $sel->fetch_assoc()) {
    $res[] = $row;
}

?>

<!-- Inicia la estructura de toda la pagina web -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Radicar y visualizar documentos recibidos | REDOHIS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap 4.5 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
        crossorigin="anonymous">

    <style>
        /* Estilos para sidebar */
        #sidebar {
            min-height: 100vh;
            width: 220px;
        }
        /* Ajuste cuando el sidebar esté oculto en visualización en dispositivos móviles */
        .content-with-sidebar {
            margin-left: 0;
        }
        @media (min-width: 768px) {
            .content-with-sidebar {
                margin-left: 220px;
            }
        }
        /* Tabla responsive */
        .table-responsive {
            overflow-x: auto;
        }
        /* Forzar iframe a ocupar el 100% del modal */
        #iframePDF {
            width: 100%;
            height: 70vh;
        }
    </style>
</head>
<body>

<!-- Barra superior  del módulo que va en color azul -->
<nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="../assets/images/redohis_icon.jpg" alt="CIDOHIS" class="brand-logo mr-2" style="height:32px; width:auto; object-fit:contain;">
        REDOHIS
    </a>

    <div class="collapse navbar-collapse">
        <!-- Espacio para otros elementos si es necesario en futuras actualizaciones -->
    </div>

    <div class="ml-auto">
        <a class="btn btn-light d-flex align-items-center" href="../auth/logout.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-2" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                <path d="M7.5 1v7h1V1z"/>
                <path d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812"/>
            </svg>
            Cerrar Sesión
        </a>
    </div>
</nav>

<!-- Sidebar barra lateral (izquierda) con respectivos botones y accesos -->
<div id="sidebar" class="bg-light border-right position-fixed d-none d-md-block">
    <div class="p-3">
        <h6>Menú</h6>
        <div class="list-group">
            
            <button type="button" class="list-group-item list-group-item-action d-flex align-items-center" data-toggle="modal" data-target="#exampleModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-database-fill mr-2" viewBox="0 0 16 16">
                <path d="M3.904 1.777C4.978 1.289 6.427 1 8 1s3.022.289 4.096.777C13.125 2.245 14 2.993 14 4s-.875 1.755-1.904 2.223C11.022 6.711 9.573 7 8 7s-3.022-.289-4.096-.777C2.875 5.755 2 5.007 2 4s.875-1.755 1.904-2.223"/>
                <path d="M2 6.161V7c0 1.007.875 1.755 1.904 2.223C4.978 9.71 6.427 10 8 10s3.022-.289 4.096-.777C13.125 8.755 14 8.007 14 7v-.839c-.457.432-1.004.751-1.490.972C11.278 7.693 9.682 8 8 8s-3.278-.307-4.510-.867c-.486-.220-1.033-.540-1.490-.972"/>
                <path d="M2 9.161V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13s3.022-.289 4.096-.777C13.125 11.755 14 11.007 14 10v-.839c-.457.432-1.004.751-1.490.972-1.232.560-2.828.867-4.510.867s-3.278-.307-4.510-.867c-.486-.220-1.033-.540-1.490-.972"/>
                <path d="M2 12.161V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16s3.022-.289 4.096-.777C13.125 14.755 14 14.007 14 13v-.839c-.457.432-1.004.751-1.490.972-1.232.560-2.828.867-4.510.867s-3.278-.307-4.510-.867c-.486-.220-1.033-.540-1.490-.972"/>
                </svg>
                <div class="text-left">Recibir Nuevo Documento</div>
            </button>
            
            <a class="list-group-item list-group-item-action d-flex align-items-center" href="cargardocs.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-2" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
                <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                </svg>
                Documentos Salidos
            </a>


            <a class="list-group-item list-group-item-action d-flex align-items-center" href="cargarexp.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-2" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                <path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1M.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8z"/>
                </svg>
            Expedientes Cerrados
            </a>

            <a class="list-group-item list-group-item-action d-flex align-items-center" href="index.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-2" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                <path d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6zm6.258-6.437a.5.5 0 0 1 .507.013l4 2.5a.5.5 0 0 1 0 .848l-4 2.5A.5.5 0 0 1 6 12V7a.5.5 0 0 1 .258-.437"/>
                </svg>
                Fotos y Videos
            </a>

            <a class="list-group-item list-group-item-action" href="index.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
                <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/>
                </svg>
            Volver a Inicio
            </a>
        </div>
        <hr>
        <p class="small text-muted mb-0">Usuario conectado: <?php echo safe_output($_SESSION['usuario']); ?></p>
    </div>
</div>

<!-- Contenido que se mostrará en la página -->
<div class="content-with-sidebar">
    <div class="container-fluid pt-4">
        <div class="row mb-3 align-items-center">
            <div class="col-md-8">
                <h4>RADICAR Y VISUALIZAR DOCUMENTOS RECIBIDOS</h4>
            </div>

            <!-- Barra para Búsqueda de registros -->
            <div class="col-md-4">
                <form method="GET" action="">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Buscar en documentos recibidos"
                            value="<?php echo htmlspecialchars($search, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Botones (visibles en pantallas pequeñas o por conveniencia) en el caso de móviles -->
        <div class="d-block d-md-none mb-3">
            <div class="btn-group btn-group-sm" role="group" aria-label="Menú móvil">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Radicar</button>
                <a class="btn btn-secondary" href="index.php">Inicio</a>
                <a class="btn btn-secondary" href="cargarexp.php">Archivados</a>
            </div>
        </div>

        <!-- Tabla que muestra los datos consultados en la DB -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead class="thead-dark">
                        <tr>
                            <th>Número de Radicado</th>
                            <th>Fecha de carga</th>
                            <th>Numero de Páginas</th>
                            <th>Fecha del documento</th>
                            <th>Título</th>
                            <th>Asunto</th>
                            <th>Remitente</th>
                            <th>Destinatario</th>
                            <th>Dirección/Email</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (count($res) === 0): ?>
                            <tr>
                                <td colspan="10" class="text-center">No se encontraron registros.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($res as $val): ?>
                                <tr>
                                    <td><?php echo safe_output($val['pin']); ?></td>
                                    <td><?php echo safe_output($val['date']); ?></td>
                                    <td><?php echo safe_output($val['pages']); ?></td>
                                    <td><?php echo safe_output($val['dater']); ?></td>
                                    <td><?php echo safe_output($val['title']); ?></td>
                                    <td><?php echo safe_output($val['description']); ?></td>
                                    <td><?php echo safe_output($val['sender']); ?></td>
                                    <td><?php echo safe_output($val['adresse']); ?></td>
                                    <td><?php echo safe_output($val['adress']); ?></td>
                                    <td>
                                        <button onclick="openModelPDF('<?php echo rawurlencode($val['url']); ?>')" class="btn btn-sm btn-primary" type="button">
                                            Visualizar
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación de la web -->
                <nav aria-label="Paginación">
                    <ul class="pagination justify-content-center mb-0">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?search=<?php echo urlencode($search); ?>&page=<?php echo $page - 1; ?>">Anterior</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                <a class="page-link" href="?search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?search=<?php echo urlencode($search); ?>&page=<?php echo $page + 1; ?>">Siguiente</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>

<!-- etiqueta del pie de página con el copyright y versionamiento del aplicativo -->
<footer class="text-center mt-3 mb-4">
    <p class="small"> Desarrollado por: <a href="https://github.com/wafervi" target="_blank">wafervi</a> - SAGEN / CAGESDO © 2022 - <?php echo date('Y'); ?> -  
        <?php
        // Link al repositorio GitHub de Wagner Fernández
        $repo = "wafervi/REDOHIS";
        $url = "https://api.github.com/repos/$repo/releases/latest";

        // Inicio cURL - (Transferencia de Archivos)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'wafervi'); // Usuario GitHub
        $response = curl_exec($ch);
        curl_close($ch);

        // Decodificación de esa petición
        $data = json_decode($response, true);

        // Muestra la versión (tag_name) que tenga el repositorio GitHub
        echo isset($data['tag_name']) ? htmlspecialchars($data['tag_name']) : 'No disponible';
        ?>
    </p>
</footer>
    </div>
</div>

<!-- Modal para radicar nuevo documento recibibido -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">Recibir nuevo documento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
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
                        <label for="sender">Remitente</label>
                        <input type="text" class="form-control" id="sender" name="sender">
                    </div>

                    <div class="form-group">
                        <label for="pages">Páginas</label>
                        <input type="number" class="form-control" id="pages" name="pages" min="1">
                    </div>

                    <div class="form-group">
                        <label for="dater">Fecha del documento</label>
                        <input type="date" class="form-control" id="dater" name="dater" min="1900-01-01" max="2099-12-31" value="<?php echo date("Y-m-d"); ?>">
                    </div>

                    <div class="form-group">
                        <label for="adresse">Destinatario</label>
                        <input type="text" class="form-control" id="adresse" name="adresse">
                    </div>

                    <div class="form-group">
                        <label for="adress">Dirección</label>
                        <input type="text" class="form-control" id="adress" name="adress">
                    </div>

                    <div class="form-group">
                        <label for="pin">Radicado del documento</label>
                        <input type="text" class="form-control" id="pin" name="pin" value="<?php echo rand(); ?>"> <!-- método echo rand(); para numeros aleatorios -->
                    </div>

                    <div class="form-group">
                        <label for="file">Adjuntar Documento</label>
                        <input type="file" class="form-control" id="file" name="file" accept="application/pdf">
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="onSubmitForm()">1- Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">2- Cerrar</button> <!-- location.reload() para actualizar la pagina al momento de insertar datos en la Base de Datos -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para visualizar PDF del documento radicado -->
<div class="modal fade" id="modalPdf" tabindex="-1" aria-labelledby="modalPdfLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalPdfLabel" class="modal-title">VISTA DEL DOCUMENTO RECIBIDO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe id="iframePDF" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>

<!-- Librerías JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
        crossorigin="anonymous"></script>

<!-- Acceso a funciones para cargar archivos PDF a la carpeta 'filer' del proyecto -->
<script>
    // Toggle sidebar para visualización en dispositivos móviles
    document.getElementById('toggleSidebarBtn').addEventListener('click', function () {
        var sb = document.getElementById('sidebar');
        if (sb.classList.contains('d-none')) {
            sb.classList.remove('d-none');
        } else {
            sb.classList.add('d-none');
        }
    });
    
    function onSubmitForm() {
        var frm = document.getElementById('form1');
        var data = new FormData(frm);
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4) {
                var msg = xhttp.responseText;
                if (this.status === 200 && msg.indexOf('¡Archivo cargado exitosamente!') !== -1) {
                    alert(msg);
                    location.reload();
                } else {
                    alert(msg);
                }
            }
        };
        xhttp.open("POST", "uploadfiler.php", true);
        xhttp.send(data);
    }

    function openModelPDF(url) {
        // Construir la URL absoluta basándose en el host actual
        var hostRoot = '<?php echo (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on" ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . rtrim(dirname($_SERVER["SCRIPT_NAME"]), "/\\\\") . "/"; ?>';
        // url viene codificada con rawurlencode desde PHP para evitar problemas con espacios/caracteres
        $('#iframePDF').attr('src', hostRoot + decodeURIComponent(url));
        $('#modalPdf').modal('show');
    }
</script>
</body>
</html>