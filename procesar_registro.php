<?php
include('conexion.php'); // Incluir el archivo de conexión

// Verificar si se enviaron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $usuario = trim($_POST['usuario']);
    $contraseña = trim($_POST['contraseña']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);

    // Comprobar si el correo o el usuario ya están registrados
    $query_check = "SELECT id, correo, nombre FROM usuarios WHERE correo = '$email' OR nombre = '$usuario'";
    $result = $conexion->query($query_check);

    if ($result->num_rows > 0) {
        // Obtener el tipo de duplicado (correo o usuario)
        $row = $result->fetch_assoc();
        if ($row['correo'] === $email) {
            echo "El correo electrónico ya está registrado. Por favor, utiliza otro.";
        } elseif ($row['nombre'] === $usuario) {
            echo "El nombre de usuario ya está registrado. Por favor, elige otro.";
        }
    } else {
        // Encriptar la contraseña
        $contraseña_encriptada = password_hash($contraseña, PASSWORD_BCRYPT);

        // Insertar los datos en la base de datos
        $query_insert = "INSERT INTO usuarios (nombre, correo, contraseña, telefono) VALUES ('$usuario', '$email', '$contraseña_encriptada', '$telefono')";
        
        if ($conexion->query($query_insert) === TRUE) {
            // Redirigir a la página de inicio de sesión después de un registro exitoso
            header("Location: acceso.php");
            exit();
        } else {
            echo "Error: " . $query_insert . "<br>" . $conexion->error;
        }
    }
}
?>