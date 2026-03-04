<?php
session_start();
if (empty($_SESSION["usuario"])) {
    header("Location: login.html");
    exit();
}
?>

    <!-- Inicia la estructura de toda la pagina web -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | REDOHIS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap 4.5 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
        crossorigin="anonymous">

    <style>
        /* Sidebar */
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

        /* Table responsive */
        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>
<body>
    
<nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="../assets/images/redohis_icon.jpg" alt="CIDOHIS" class="brand-logo mr-2" style="height:32px; width:auto; object-fit:contain;">
        REDOHIS
    </a>

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

<!-- Sidebar -->
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
                Expedientes Cerrados
            </a>

            <a class="list-group-item list-group-item-action d-flex align-items-center" href="cargarfov.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-2" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                    <path d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6zm6.258-6.437a.5.5 0 0 1 .507.013l4 2.5a.5.5 0 0 1 0 .848l-4 2.5A.5.5 0 0 1 6 12V7a.5.5 0 0 1 .258-.437"/>
                </svg>
                Fotos y Videos
            </a>


            <a class="list-group-item list-group-item-action d-flex align-items-center" href="index.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill mr-2" viewBox="0 0 16 16">
                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
                <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/>
                </svg>
                Volver a Inicio
            </a>
        </div>
        <hr>
        <p class="small text-muted mb-0">Usuario conectado: <?php echo htmlspecialchars($_SESSION['usuario']); ?></p>
    </div>
</div>

<div class="content-with-sidebar">
    <div class="container-fluid pt-4">
        <div class="row mb-3 align-items-center">
            <div class="col-12">
                <h4>DASHBOARD - ANALISIS PREDICTIVO (KAKEBIA) </h4>
                <p class="text-muted">Predicción de gastos mensuales en el hogar</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <iframe src="dashboard/arima_forecast.html" 
                                style="width: 100%; height: 600px; border: none;" 
                                title="Dashboard ARIMA">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mb-3 d-block d-md-none mt-3">
            <div class="btn-group btn-group-sm" role="group">
                <a class="btn btn-primary" href="index.php">Inicio</a>
                <a class="btn btn-secondary" href="cargardocs.php">Documentos Salidos</a> 
                <a class="btn btn-secondary" href="cargardocr.php">Documentos Recibidos</a>
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
    // Filtrar tabla por palabras clave (cliente)
    var searchElement = document.getElementById('search');
    if (searchElement) {
        searchElement.addEventListener('keyup', function () {
            var input = this.value.toLowerCase();
            var rows = document.querySelectorAll('#expedientes tr');

            rows.forEach(function (row) {
                var expediente = row.querySelector('td:nth-child(1)');
                if (!expediente) {
                    // si la estructura cambia, intenta tomar la columna por índice 2
                    expediente = row.querySelector('td:nth-child(2)');
                }
                if (expediente && expediente.innerText.toLowerCase().includes(input)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
</script>
</body>
</html>