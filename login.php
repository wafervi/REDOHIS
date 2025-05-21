<?php
# Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "uploadfile");

# Verificar si hubo error en la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

# Obtener los datos enviados desde el formulario
$usuario = $_POST["usuario"];
$palabra_secreta = $_POST["palabra_secreta"];

# Consulta para verificar el nickname y password
$sql = "SELECT * FROM users WHERE nickname = ? AND password = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $usuario, $palabra_secreta);
$stmt->execute();
$resultado = $stmt->get_result();

# Comprobar si hay un registro que coincida
if ($resultado->num_rows > 0) {
    # Iniciar sesión para poder usar el arreglo
    session_start();
    # Guardar el nombre de usuario en la sesión
    $_SESSION["usuario"] = $usuario;

    # Redireccionar a la página de inicio
    header("Location:index.php");
} else {
    # No coinciden, así que simplemente imprimimos un mensaje diciendo que es incorrecto, tomando un codigo Javascript:
    echo '<script language="javascript">
    alert("¡Usuario y contraseña incorrecto!"); 
    window.location.href="login.html"</script>';
}

