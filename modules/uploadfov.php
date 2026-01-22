<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "../filem/";  // Directorio donde se guardarán los archivos
    $target_file = $target_dir . basename($_FILES["zipFile"]["name"]);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verificar si el archivo es .zip
    if ($fileType != "zip") {
        // Mostrar un popup con JavaScript si el archivo no es .zip
        echo "<script type='text/javascript'>
                alert('Cargue un expediente en formato .zip.');
                window.location.href = 'cargarfov.php'; // Redirigir de nuevo al formulario
              </script>";
        exit(); // Detener la ejecución del script para evitar más procesamiento
    } else {
        // Intentar mover el archivo subido al directorio
        if (move_uploaded_file($_FILES["zipFile"]["tmp_name"], $target_file)) {
            echo "<script type='text/javascript'>
                    alert('El expediente ". htmlspecialchars(basename($_FILES["zipFile"]["name"])) . " ha sido cargado correctamente.');
                    window.location.href = 'cargarfov.php'; // Redirigir después de cargar correctamente
                  </script>";
            exit(); // Detener la ejecución
        } else {
            echo "<script type='text/javascript'>
                    alert('Hubo un error al cargar su archivo.');
                    window.location.href = 'cargarfov.php'; // Redirigir si ocurre un error
                  </script>";
            exit();
        }
    }
}
?>
