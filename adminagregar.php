<?php
include('conexion.php'); // Incluir el archivo de conexión

// Cifrar la contraseña del administrador
$contraseña_admin = password_hash('admin123', PASSWORD_BCRYPT);

// Insertar al administrador en la base de datos
$usuario_admin = 'admin';
$email_admin = 'admin@gymwarrior.com';
$telefono_admin = '1234567890'; // Puedes cambiar el número

$query = "INSERT INTO usuarios (nombre, correo, contraseña, telefono, rol) 
          VALUES ('$usuario_admin', '$email_admin', '$contraseña_admin', '$telefono_admin', 'admin')";

if ($conexion->query($query) === TRUE) {
    echo "Administrador insertado correctamente.";
} else {
    echo "Error: " . $query . "<br>" . $conexion->error;
}
?>