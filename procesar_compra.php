<?php
session_start();
header('Content-Type: application/json');

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gymwarrior";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Error de conexión: " . $conn->connect_error]));
}

// Obtener los datos de la compra desde la solicitud
$data = json_decode(file_get_contents("php://input"), true);
$productos = $data['productos'];

// Actualizar el stock para cada producto comprado
foreach ($productos as $producto) {
    $productoID = $producto['id'];
    $cantidadComprada = $producto['cantidad'];

    // Actualizar el stock en la base de datos
    $sql = "UPDATE productos SET stock = stock - ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $cantidadComprada, $productoID);

    if (!$stmt->execute()) {
        echo json_encode(["status" => "error", "message" => "Error al actualizar el stock del producto ID: $productoID"]);
        $stmt->close();
        $conn->close();
        exit;
    }
    $stmt->close();
}

// Cerrar conexión a la base de datos
$conn->close();

// Establecer una variable de sesión para indicar que la compra se ha realizado
$_SESSION['compra_realizada'] = true;

// Devolver una respuesta de éxito y la URL del recibo
echo json_encode(["status" => "success", "message" => "Compra procesada y stock actualizado.", "redirect" => "recibo.php"]);
?>