<?php

/**
 * CRUD modal en PHP y MySQL con barra de búsqueda
 * 
 * Este archivo muestra el listado de registros, las opciones para agregar,
 * editar y eliminar registros desde ventanas modal de Bootstrap,
 * e implementa una barra de búsqueda para filtrar la tabla 'peliculas'.
 * @author MRoblesDev
 * @version 1.1
 * https://github.com/mroblesdev
 * 
 */

session_start();

if (empty($_SESSION["usuario"])) {
    # Lo redireccionamos al formulario de inicio de sesión
    header("Location: /REDOHIS/login.html");
    # Y salimos del script
    exit();
}

require 'config/database.php';

// Manejar la consulta de búsqueda y filtrar resultados
$searchQuery = "";
if (isset($_GET['search'])) {
    $searchQuery = filter_var($_GET['search'], FILTER_SANITIZE_STRING); // Sanitizar el término de búsqueda
}

$sqlPeliculas = "SELECT p.id, p.nombre, p.descripcion, g.nombre AS genero FROM pelicula AS p
INNER JOIN genero AS g ON p.id_genero=g.id";

// Agregar cláusula WHERE para la consulta de búsqueda si se proporciona
if (!empty($searchQuery)) {
    $sqlPeliculas .= " WHERE p.nombre LIKE '%$searchQuery%' OR p.descripcion LIKE '%$searchQuery%'";
}

$peliculas = $conn->query($sqlPeliculas);

$sqlFiles = "SELECT id, title FROM files"; // Consulta simplificada para obtener el título de los archivos
$filesResult = $conn->query($sqlFiles); // Ejecutar la consulta para los archivos

// Array para almacenar los títulos de los archivos en un formato clave-valor
$fileTitles = [];
while ($row = $filesResult->fetch_assoc()) {
    $fileTitles[$row['id']] = $row['title'];
}

$dir = "posters/";

?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trazabilidad | REDOHIS</title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/all.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

<div class="container py-3">

    <h4 class="text-rigth">TRAZABILIDAD (MODO PRUEBA) | REDOHIS</h4>

    <hr>

    <?php if (isset($_SESSION['msg']) && isset($_SESSION['color'])) { ?>
        <div class="alert alert-<?= $_SESSION['color']; ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['msg']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

    <?php
        unset($_SESSION['color']);
        unset($_SESSION['msg']);
    } ?>


    <div class="row justify-content-md-center mb-3">
        <div class="col-md-6">
            <form class="form-inline" action="" method="GET">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Buscar comentarios" value="<?= $searchQuery ?>">
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </div>
            </form>
        </div>
    </div>



    <div class="row justify-content-end">
        <div align="center">
            <div class="col-auto">
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoModal"><i class="fa-solid fa-circle-plus"></i> Nuevo comentario</a>
                <a class="btn btn-primary" href="/REDOHIS/index.php">Volver a inicio <span class="sr-only">(current)</span></a>
                <a class="btn btn-primary" href="/REDOHIS/cargardoc.php">Docs radicados <span class="sr-only">(current)</span></a>
            </div>
        </div>
    </div>



    <table class="table table-sm table-striped table-hover mt-4">
        <thead class="table-dark">
            <tr>
                <th>Titulo del documento</th>
                <th> - </th>
                <th>Asunto del documento</th>
                <th width="45%">comentario</th>
                <th>Estado</th>
                <th>Soporte</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $peliculas->fetch_assoc()) { ?>
                <tr>
                    <td><?= isset($fileTitles[$row['id']]) ? $fileTitles[$row['id']] : 'No hay archivo'; ?></td> <td>
                    </td>
                    <td><?= $row['nombre']; ?></td>
                    <td><?= $row['descripcion']; ?></td>
                    <td><?= $row['genero']; ?></td>
                    <td><img src="<?= $dir . $row['id'] . '.jpg?n=' . time(); ?>" width="100"></td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editaModal" data-bs-id="<?= $row['id']; ?>"><i class="fa-solid fa-pen-to-square"></i> Editar</a>

                        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminaModal" data-bs-id="<?= $row['id']; ?>"><i class="fa-solid fa-trash"></i></i> Eliminar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <p class="text-center">Desarrollado por <a href="https://github.com/wagnerfv1117">@wagnerfv1117 - SAGEN - CAGESDO - © 2021</a></p>
    </div>
</footer>

<?php
$sqlGenero = "SELECT id, nombre FROM genero";
$generos = $conn->query($sqlGenero);
?>

<?php include 'nuevoModal.php'; ?>

<?php $generos->data_seek(0); ?>

<?php include 'editaModal.php'; ?>
<?php include 'eliminaModal.php'; ?>

<script>
    // ... (resto del código JavaScript)
</script>

<script src="assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>