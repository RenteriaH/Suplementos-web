<?php
$host = 'localhost';
$usuario = 'root';
$contraseña = '';
$base_de_datos = 'gymwarrior';

// Crear conexión
$conexion = new mysqli($host, $usuario, $contraseña, $base_de_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>