<?php
# Página de inicio con barra superior y barra lateral izquierda (basada en cargadoc2.php)

session_start();

if (empty($_SESSION["usuario"])) {
    header("Location: login.html");
    exit();
}

# Helper sencillo para salida segura
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

    <!-- Bootstrap 4.5 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
          crossorigin="anonymous">

    <style>
        /* Basado en el ejemplo cargadoc2.php */
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

<!-- Barra superior -->
<nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <button class="btn btn-outline-light d-md-none mr-2" id="toggleSidebarBtn" type="button">☰</button>
    <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="logo/docec.jpg" alt="CIDOHIS" class="brand-logo">
        REDOHIS
    </a>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <!-- espacio para ítems si necesita -->
        </ul>
    </div>

    <div class="ml-auto d-flex align-items-center">

        <a class="btn btn-light" href="logout.php">Cerrar Sesión</a>
    </div>
</nav>

<!-- Sidebar (izquierda) -->
<div id="sidebar" class="bg-light border-right position-fixed d-none d-md-block">
    <div class="p-3">
        <h6>Menú</h6>
        <div class="list-group">
            <a class="list-group-item list-group-item-action" href="cargadoc2.php">Documentos Salidos</a>
            <a class="list-group-item list-group-item-action" href="cargardocr.php">Documentos Recibidos</a>
            <a class="list-group-item list-group-item-action" href="cargaindex1.php">Expedientes Archivados</a>
            <a class="list-group-item list-group-item-action" href="index2.php">Gestionar Usuario y Contraseña</a>

        </div>
        <hr>
        <p class="small text-muted mb-0">Usuario conectado: <?php echo htmlspecialchars($_SESSION['usuario']); ?></p>
    </div>
</div>

<!-- Contenido principal -->
<!-- El título -->
<div class="content-with-sidebar">
    <div class="container-fluid pt-4">
        <div class="row mb-3 align-items-center">
            <div class="col-md-8">
                <h4>Bienvenido a REDOHIS - Repositorio de Documentos Históricos</h4>
            </div>

<!-- El carretazo -->
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

<!-- Cuadro de información -->
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

        <footer class="text-center mt-3 mb-4">
            <p class="small">Documentado por: <a href="https://github.com/wafervi" target="_blank">@wafervi</a> - SAGEN - CAGESDO - © 2021</p>
        </footer>
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
    // Toggle sidebar en móviles (misma lógica que en cargadoc2.php)
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