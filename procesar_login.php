<?php
// Iniciar sesión
session_start();

// Conectar a la base de datos
$servername = "localhost";
$username = "root"; // Usuario de MySQL
$password = ""; // Contraseña de MySQL
$dbname = "gymwarrior"; // Ejemplo de nombre de base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el usuario ha solicitado ingresar como invitado
if (isset($_POST['modo_invitado'])) {
    // Ingresar como invitado (sin necesidad de verificar la base de datos)
    $_SESSION['usuario_id'] = null;  // No tiene un ID real
    $_SESSION['usuario'] = 'Invitado'; // Nombre como "Invitado"
    $_SESSION['rol'] = 'invitado'; // Establecer rol de invitado
    header("Location: nuestros_suplementos.php"); // Redirigir a la página de productos
    exit();
}

// Obtener datos del formulario para inicio de sesión
if (isset($_POST['usuario']) && isset($_POST['contraseña'])) {
    $usuario = trim($_POST['usuario']);
    $contraseña = trim($_POST['contraseña']);

    // Verificar que los campos no estén vacíos
    if (empty($usuario) || empty($contraseña)) {
        echo "Por favor, completa todos los campos.";
        exit();
    }

    // Consultar si el usuario existe en la base de datos
    $sql = "SELECT * FROM usuarios WHERE nombre = ?"; // O 'correo' si usas correo para iniciar sesión
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario); // "s" para cadena de texto
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró el usuario
    if ($result->num_rows > 0) {
        // Obtener los datos del usuario
        $row = $result->fetch_assoc();
        
        // Verificar la contraseña (asumiendo que está cifrada en la base de datos)
        if (password_verify($contraseña, $row['contraseña'])) {
            // Establecer sesión
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['usuario'] = $row['nombre'];
            $_SESSION['rol'] = $row['rol']; // Guardar el rol del usuario
            
            // Redirigir dependiendo del rol
            if ($row['rol'] === 'admin') {
                header("Location: index.php"); // Página para el administrador
            } else {
                header("Location: index.php"); // Página para usuarios normales
            }
            exit();
        } else {
            // Si la contraseña es incorrecta
            echo "Contraseña incorrecta.";
        }
    } else {
        // Si el usuario no existe
        echo "Usuario no encontrado.";
    }
}

$conn->close();
?>