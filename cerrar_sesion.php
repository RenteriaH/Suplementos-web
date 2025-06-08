<?php
session_start();

// Eliminar todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Establecer una variable de sesión para indicar que se ha cerrado sesión
session_start();
$_SESSION['cerrar_sesion'] = true;

// Redirigir al usuario a la página de inicio
header("Location: index.php");
exit();
?>