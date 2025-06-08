<?php
session_start();

// Establecer el nombre de usuario como 'Invitado' y el ID como null
$_SESSION['usuario'] = 'Invitado';
$_SESSION['usuario_id'] = null;  // No tiene un ID de usuario en la base de datos

// Redirigir al usuario a la página principal (index.php)
header("Location: index.php");
exit();
?>