<?php

// Cómo subir el archivo
$fichero = $_FILES["file"];

// Cargando el fichero en la carpeta "EXP", por el metodo move_uploadedal servidor
move_uploaded_file($fichero["tmp_name"], "exp/".$fichero["name"]);

// Redirigiendo hacia atrás: es una especie de lo cation reload, pero en el lenguaje PHP
header("Location: " . $_SERVER["HTTP_REFERER"]);
?>