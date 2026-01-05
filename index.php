<?php
# Inicio de sesión

session_start();

if (empty($_SESSION["usuario"])) {
    header("Location: login.html");
    exit();
}

# Helper sencillo para salida segura con la función safe_output
function safe_output($s) {
    $s = (string)$s;
    $decoded = html_entity_decode($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    return htmlspecialchars($decoded, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú Principal | REDOHIS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Ejecución de la librería Bootstrap 4.5 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
          crossorigin="anonymous">

    <style>
        /* Diseño del slidebar en CSS */
        #sidebar {
            min-height: 100vh;
            width: 220px;
        }
        .content-with-sidebar {
            margin-left: 0;
        }
        @media (min-width: 768px) {
            .content-with-sidebar {
                margin-left: 220px;
            }
        }
        .brand-logo { height: 30px; width: auto; border-radius: 4px; margin-right:8px; }
        /* Ajustes para encabezados/contenido */
        .hero {
            padding: 24px 0;
        }
    </style>
</head>
<body>

<!-- Diseño de la barra superior (en color azul) -->
<nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <button class="btn btn-outline-light d-md-none mr-2" id="toggleSidebarBtn" type="button">☰</button>
    <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="assets/images/redohis_icon.jpg" alt="CIDOHIS" class="brand-logo">
        REDOHIS  <!-- Título de aplicativo en la parte superior izquierda -->
    </a>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <!-- Espacio para ítems si es necesario, mas adelante en futuras actualizaciones -->
        </ul>
    </div>

    <div class="ml-auto d-flex align-items-center">

        <a class="btn btn-light d-flex align-items-center" href="logout.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-2" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                <path d="M7.5 1v7h1V1z"/>
                <path d="M3 8.812a5 5 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812"/>
            </svg>
            Cerrar Sesión
        </a>
    </div>
</nav>

<!-- Sidebar de la  izquierda donde se muestra los botones en la página, para acceder a los diferentes módulos -->
<div id="sidebar" class="bg-light border-right position-fixed d-none d-md-block">
    <div class="p-3">
        <h6>Menú</h6>
        <div class="list-group">
            <a class="list-group-item list-group-item-action d-flex align-items-center" href="cargardocs.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-2" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                    <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
                    <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                </svg>
                Documentos Salidos
            </a>

            <a class="list-group-item list-group-item-action d-flex align-items-center" href="cargardocr.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-2" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                    <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0z"/>
                    <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
                </svg>
                Documentos Recibidos
            </a>

            <a class="list-group-item list-group-item-action d-flex align-items-center" href="cargarexp.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-2" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                    <path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1M.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8z"/>
                </svg>
                Expedientes Administrativos Archivados
            </a>

            <a class="list-group-item list-group-item-action d-flex align-items-center" href="cargarfov.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-2" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                    <path d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6zm6.258-6.437a.5.5 0 0 1 .507.013l4 2.5a.5.5 0 0 1 0 .848l-4 2.5A.5.5 0 0 1 6 12V7a.5.5 0 0 1 .258-.437"/>
                </svg>
                Fotos y Videos
            </a>

            
            
            <a class="list-group-item list-group-item-action d-flex align-items-center" href="index.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-2" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                </svg>
                Gestionar Usuarios
            </a> <!--Módulo para la actualización v4.0 -->
        </div>
        <hr>
        <p class="small text-muted mb-0">Usuario conectado: <?php echo htmlspecialchars($_SESSION['usuario']); ?></p>
    </div>
</div>

<!-- Acá se muestra el ontenido de la página principal (index.php) -->
<!-- El título de bienvenida -->
<div class="content-with-sidebar">
    <div class="container-fluid pt-4">
        <div class="row mb-3 align-items-center">
            <div class="col-md-8">
                <h4>Bienvenido a REDOHIS - Repositorio de Documentos Históricos</h4>
            </div>

<!-- Viene el carretazo -->
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <h3>¿Qué es REDOHIS?</h3>
                        <article>
                            <p>El Repositorio de Documentos Históricos - (REHODIS) es una herramienta para gestionar la información histórica en documentos y expedientes, de acorde a los Sistemas de Gestión de Documentos Electrónicos de Archivo – SGDEA; lo cual orienta conformar y custodiar un archivo electrónico personal e institucional en sus diferentes fases. Por ende, coadyuva a constituir el patrimonio documental electrónico y digital de las personas, empresas, entidades, regiónes o naciones.</p>

                            <p>Está ligado, y hace parte del Componente de Gestión Documental (CAGESDO) del Sistema de Administración General (SAGEN) para conservar esa memoria histórica ante problemas jurídicos, legales y/o administrativos que se presenten.</p>

                            <p>Este sistema, servirá para almacenar  y mostrar los documentos gestionados, producto de las actuaciones a nivel personal, laboral y/o profesional, que han terminado su tiempo de gestión y vigencia en la plataforma Evernote y OneNote de Microsoft Office 365.</p>

                            <p>Con esto, se da cumplimiento la conservación de los archivos en su etapa final y semiactiva.</p>

                            <p>"La poesía es la memoria de la vida y los archivos son su lengua." - Octavio Paz</p>
                        </article>
                    </div>
                </div>
            </div>

<!-- Cuadro de información al lado del contenido -->
            <aside class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>Archivos de Gestión</h5>
                        <ul class="list-unstyled">
                            <li><a href="https://www.evernote.com/client/web?login=true#?hm=true&" target="_blank">EVERNOTE - Archivo Personal</a></li>
                            <li><a href="https://www.office.com/launch/onenote?auth=2" target="_blank">ONENOTE - Archivo Laboral</a></li>
                        </ul>
                        <hr>
                        <h6>Repositorios de Software</h6>
                        <ul class="list-unstyled">
                            <li><a href="https://github.com/wafervi?tab=repositories" target="_blank">GitHub</a></li>
                        </ul>
                    </div>
                </div>
            </aside>
        </div>

<!-- Etiqueta del pie de página con copyright -->
<footer class="text-center mt-3 mb-4">
    <p class="small"> Desarrollado por: <a href="https://github.com/wafervi" target="_blank">wafervi</a> - SAGEN / CAGESDO © 2022 - <?php echo date('Y'); ?> -  
        <?php
        // Acceso al repositorio GitHub de Wagner Fernández
        $repo = "wafervi/REDOHIS";
        $url = "https://api.github.com/repos/$repo/releases/latest";

        // Inicializa cURL o transferencia de datos
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'wafervi'); // Mi usuario GitHub
        $response = curl_exec($ch);
        curl_close($ch);

        // Decodificación de esa la respuesta
        $data = json_decode($response, true);

        // Mostrar la versión actual (tag_name) del repositorio GitHub
        echo isset($data['tag_name']) ? htmlspecialchars($data['tag_name']) : 'No disponible';
        ?>
    </p>
</footer>
    </div>
</div>

<!-- Librerías JS para el funcionamiento de modales, formularios efectos con Boostrap  -->
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
    // Toggle sidebar en móviles, mejor vista en estos dispositivos
    document.getElementById('toggleSidebarBtn').addEventListener('click', function () {
        var sb = document.getElementById('sidebar');
        if (sb.classList.contains('d-none')) {
            sb.classList.remove('d-none');
        } else {
            sb.classList.add('d-none');
        }
    });
</script>
</body>
</html>
