<?php

include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dater = $con->real_escape_string(htmlentities($_POST['dater']));
    $title = $con->real_escape_string(htmlentities($_POST['title']));
    $description = $con->real_escape_string(htmlentities($_POST['description']));
    $sender = $con->real_escape_string(htmlentities($_POST['sender']));
    $adresse = $con->real_escape_string(htmlentities($_POST['adresse']));
    $adress = $con->real_escape_string(htmlentities($_POST['adress']));
    $pin = $con->real_escape_string(htmlentities($_POST['pin']));

 


    $file_name = $_FILES['file']['name'];

    $new_name_file = null;

    if ($file_name != '' || $file_name != null) {
        $file_type = $_FILES['file']['type'];
        list($type, $extension) = explode('/', $file_type);
        if ($extension == 'pdf') {
            $dir = 'files/';
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $file_tmp_name = $_FILES['file']['tmp_name'];
            //$new_name_file = 'files/' . date('Ymdhis') . '.' . $extension;
            $new_name_file = $dir . file_name($file_name) . '.' . $extension;
            if (copy($file_tmp_name, $new_name_file)) {
                
            }
        }
    }

    $ins = $con->query("INSERT INTO files(title,description,sender,adresse,adress,dater,pin,url) VALUES ('$title','$description','$sender','$adresse','$adress','$dater','$pin','$new_name_file')");

    if ($ins) {
        echo '¡Documento cargado exitosamente!';
    } else {
        echo '¡Error al cargar el documento!';
    }
} else {
    echo '¡Error al cargar el documento!';
}
