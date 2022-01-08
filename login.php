<?php
# Las claves de acceso, ahorita las ponemos aquí
# y en otro ejercicio las ponemos en una base de datos
$usuario_correcto = "wagner";
$palabra_secreta_correcta = "1234";
/*
Para leer los datos que fueron enviados al formulario,
accedemos al arreglo superglobal llamado $_POST en PHP, y
para obtener un valor accedemos a $_POST["clave"] en donde
clave es el "name" que le dimos al input
 */
# Nota: no estamos haciendo validaciones
$usuario = $_POST["usuario"];
$palabra_secreta = $_POST["palabra_secreta"];

# Luego de haber obtenido los valores, ya podemos comprobar:
if ($usuario === $usuario_correcto && $palabra_secreta === $palabra_secreta_correcta) {
    # Significa que coinciden, así que vamos a guardar algo
    # en el arreglo superglobal $_SESSION, ya que ese arreglo
    # "persiste" a través de todas las páginas

    # Iniciar sesión para poder usar el arreglo
    session_start();
    # Y guardar un valor que nos pueda decir si el usuario
    # ya ha iniciado sesión o no. En este caso es el nombre
    # de usuario
    $_SESSION["usuario"] = $usuario;

     # Luego redireccionamos a la página de inicio
    header("Location:index.php");
} else {
    # No coinciden, así que simplemente imprimimos un mensaje diciendo que es incorrecto, tomando un codigo Javascript:
    echo '<script language="javascript">
    alert("¡Usuario y contraseña incorrecto!"); 
    window.location.href="login.html"</script>';
}

