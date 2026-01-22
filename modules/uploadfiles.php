<?php

include('conexion.php');#se procede con utilizar el metodo POST, para cargar los datos consignados en el formulario, a la base de datos.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dater = $con->real_escape_string(htmlentities($_POST['dater']));
    $pages = $con->real_escape_string(htmlentities($_POST['pages']));
    $title = $con->real_escape_string(htmlentities($_POST['title']));
    $description = $con->real_escape_string(htmlentities($_POST['description']));
    $sender = $con->real_escape_string(htmlentities($_POST['sender']));
    $adresse = $con->real_escape_string(htmlentities($_POST['adresse']));
    $adress = $con->real_escape_string(htmlentities($_POST['adress']));
    $pin = $con->real_escape_string(htmlentities($_POST['pin']));
    

    #se toman los datos definidos como variables, para que se puedan almacenar en la base de datos.
    # se procede a montar el algoritmo, para cargar el archivo PDF en la base de datos y la carpeta dentro del proyecto.
    $file_name = $_FILES['file']['name'];

    $new_name_file = null;

    if ($file_name != '' || $file_name != null) {
        $file_type = $_FILES['file']['type'];
        list($type, $extension) = explode('/', $file_type);
        if ($extension == 'pdf') {
            $dir = '../files/';
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

   #luego se hace una consulta mediante INSERT INTO* de los datos escritos en el formulario (cargardoc.php) para que sean almacenados.
    $ins = $con->query("INSERT INTO files(title,description,sender,adresse,adress,dater,pages,pin,url) VALUES ('$title','$description','$sender','$adresse','$adress','$dater','$pages','$pin','$new_name_file')");

   #se proyecta un mensaje o cuadro de dialogo. 
    if ($ins) {
        echo '¡Documento cargado exitosamente!';
    } else {
        echo '¡Error al cargar el documento!';
    }
} else {
    echo '¡Error al cargar el documento!';
}
