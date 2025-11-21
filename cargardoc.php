<?php
# Inicio de sesión
session_start();

if (empty($_SESSION["usuario"])) {
    header("Location: login.html");
    exit();
}

include('conexion.php');

# Helper: decodifica entidades HTML (si existen en la BD) y luego escapa para salida segura
function safe_output($s) {
    // Forzamos a string por si viene null
    $s = (string)$s;
    // Primero decodificamos entidades HTML (&aacute; -> á). Esto corrige textos que se guardaron como entidades.
    $decoded = html_entity_decode($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    // Luego escapamos con htmlspecialchars para prevenir XSS y mantener caracteres UTF-8
    return htmlspecialchars($decoded, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

# Manejar búsqueda
$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchEsc = $con->real_escape_string($search);

# Paginación
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $limit;

# Contar total de registros (con filtro)
$totalQuery = $con->query("SELECT COUNT(*) as total FROM files WHERE title LIKE '%$searchEsc%' OR description LIKE '%$searchEsc%' OR sender LIKE '%$searchEsc%' OR adresse LIKE '%$searchEsc%'");
$totalRow = $totalQuery->fetch_assoc();
$totalRecords = (int)$totalRow['total'];
$totalPages = $totalRecords > 0 ? ceil($totalRecords / $limit) : 1;

# Obtener registros para la página actual
$sel = $con->query("SELECT * FROM files WHERE title LIKE '%$searchEsc%' OR description LIKE '%$searchEsc%' OR sender LIKE '%$searchEsc%' OR adresse LIKE '%$searchEsc%' ORDER BY id DESC LIMIT $limit OFFSET $offset");

$res = [];
while ($row = $sel->fetch_assoc()) {
    $res[] = $row;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Radicar y visualizar documentos salidos | REDOHIS</title>
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
        /* Ajuste cuando el sidebar esté oculto en móviles */
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

<!-- Barra superior -->
<nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <button class="btn btn-outline-light d-md-none mr-2" id="toggleSidebarBtn" type="button">☰</button>
    <a class="navbar-brand" href="#">REDOHIS</a>

    <div class="collapse navbar-collapse">
        <!-- Espacio para otros elementos si es necesario -->
    </div>

    <div class="ml-auto">
        <a class="btn btn-light" href="logout.php">Cerrar Sesión</a>
    </div>
</nav>

<!-- Sidebar (izquierda) -->
<div id="sidebar" class="bg-light border-right position-fixed d-none d-md-block">
    <div class="p-3">
        <h6>Menú</h6>
        <div class="list-group">
            <button type="button" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#exampleModal">
                Radicar Nuevo Documento
            </button>
            <a class="list-group-item list-group-item-action" href="cargardocr.php">Documentos Recibidos</a>
            <a class="list-group-item list-group-item-action" href="cargaindex.php">Expedientes Archivados</a>
            <a class="list-group-item list-group-item-action" href="index.php">Volver a Inicio</a>


        </div>
        <hr>
        <p class="small text-muted mb-0">Usuario conectado: <?php echo safe_output($_SESSION['usuario']); ?></p>
    </div>
</div>

<!-- Contenido principal -->
<div class="content-with-sidebar">
    <div class="container-fluid pt-4">
        <div class="row mb-3 align-items-center">
            <div class="col-md-8">
                <h4>RADICAR Y VISUALIZAR DOCUMENTOS SALIDOS</h4>
            </div>

            <!-- Buscador -->
            <div class="col-md-4">
                <form method="GET" action="">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Buscar documentos"
                               value="<?php echo htmlspecialchars($search, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Botones (visibles en pantallas pequeñas o por conveniencia) -->
        <div class="d-block d-md-none mb-3">
            <div class="btn-group btn-group-sm" role="group" aria-label="Menú móvil">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Radicar</button>
                <a class="btn btn-secondary" href="index.php">Inicio</a>
                <a class="btn btn-secondary" href="cargaindex.php">Archivados</a>
            </div>
        </div>

        <!-- Tabla de resultados -->
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

                <!-- Paginación -->
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

        <footer class="text-center mt-3 mb-4">
            <p class="small">Documentado por: <a href="https://github.com/wafervi" target="_blank">@wafervi</a> - SAGEN - CAGESDO - © 2021</p>
        </footer>
    </div>
</div>

<!-- Modal para radicar nuevo documento -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">Radicar nuevo documento</h5>
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
                        <input type="text" class="form-control" id="pin" name="pin" value="<?php echo rand(); ?>">
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

<!-- Modal para visualizar PDF -->
<div class="modal fade" id="modalPdf" tabindex="-1" aria-labelledby="modalPdfLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalPdfLabel" class="modal-title">VISTA DEL DOCUMENTO RADICADO</h5>
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

<script>
    // Toggle sidebar en móviles
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
                    $('#exampleModal').modal('hide');
                    // Recargar para actualizar la lista de documentos
                    location.reload();
                } else {
                    alert(msg);
                }
            }
        };
        xhttp.open("POST", "upload.php", true);
        xhttp.send(data);
        frm.reset();
    }

    function openModelPDF(url) {
        // Construir la URL absoluta basándonos en el host actual
        var hostRoot = '<?php echo (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on" ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . rtrim(dirname($_SERVER["SCRIPT_NAME"]), "/\\\\") . "/"; ?>';
        // url viene codificada con rawurlencode desde PHP para evitar problemas con espacios/caracteres
        $('#iframePDF').attr('src', hostRoot + decodeURIComponent(url));
        $('#modalPdf').modal('show');
    }
</script>
</body>
</html>