<?php
include('conexion.php');

// Consulta SQL para obtener todos los productos
$sql = "SELECT * FROM productos";
$resultado = mysqli_query($conexion, $sql);

// Verificar si la consulta fue exitosa
if (mysqli_num_rows($resultado) > 0) {
    // Crear una tabla para mostrar los productos
    echo "<h1>Lista de Productos</h1>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
            </tr>";

    // Mostrar los resultados de la consulta
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<tr>
                <td>" . $fila['id'] . "</td>
                <td>" . $fila['nombre'] . "</td>
                <td>" . $fila['precio'] . "</td>
                <td>" . $fila['stock'] . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No se encontraron productos.";
}

// Cerrar la conexión
mysqli_close($conexion);
?>