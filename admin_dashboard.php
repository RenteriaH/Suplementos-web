<?php
session_start();

// Verificar si el usuario es un administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php"); // Redirigir a la página principal si no es administrador
    exit();
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gymwarrior";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Agregar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'agregar') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $stock = $_POST['stock'];  // Añadir stock al agregar producto
    
   // Subir imagen
$imagen = $_FILES['imagen']['name'];
$imagenPath = "imagenes/" . basename($imagen); // Usando la carpeta 'imagenes'

// Verificar si la imagen se subió correctamente
if (move_uploaded_file($_FILES['imagen']['tmp_name'], $imagenPath)) {
    echo "La imagen se subió correctamente.";
} else {
    echo "Error al mover el archivo a la carpeta de destino.";
}

    // Insertar producto en la base de datos
    $sql = "INSERT INTO productos (nombre, precio, imagen, categoria, stock) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdssi", $nombre, $precio, $imagenPath, $categoria, $stock);

    if ($stmt->execute()) {
        $mensaje = "Producto agregado exitosamente.";
    } else {
        $mensaje = "Error al agregar el producto: " . $stmt->error;
    }

    $stmt->close();
}

// Reducir stock
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'reducir_stock' && isset($_POST['id_producto'])) {
    $idProducto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];

    // Obtener el stock actual del producto
    $sql = "SELECT stock FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idProducto);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();
    
    if ($producto) {
        $nuevoStock = $producto['stock'] - $cantidad;
        if ($nuevoStock < 0) {
            $mensaje = "No hay suficiente stock para reducir.";
        } else {
            // Actualizar el stock
            $sql = "UPDATE productos SET stock = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $nuevoStock, $idProducto);

            if ($stmt->execute()) {
                $mensaje = "Stock reducido exitosamente.";
            } else {
                $mensaje = "Error al reducir el stock: " . $stmt->error;
            }
        }
    } else {
        $mensaje = "Producto no encontrado.";
    }

    $stmt->close();
}

// Aumentar stock
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'aumentar_stock' && isset($_POST['id_producto'])) {
    $idProducto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];

    // Obtener el stock actual del producto
    $sql = "SELECT stock FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idProducto);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();
    
    if ($producto) {
        $nuevoStock = $producto['stock'] + $cantidad;

        // Actualizar el stock
        $sql = "UPDATE productos SET stock = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $nuevoStock, $idProducto);

        if ($stmt->execute()) {
            $mensaje = "Stock aumentado exitosamente.";
        } else {
            $mensaje = "Error al aumentar el stock: " . $stmt->error;
        }
    } else {
        $mensaje = "Producto no encontrado.";
    }

    $stmt->close();
}

// Eliminar producto
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['accion']) && $_GET['accion'] == 'eliminar' && isset($_GET['id'])) {
    $idProducto = $_GET['id'];

    // Verificar stock del producto
    $sql = "SELECT stock FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idProducto);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
        if ($producto['stock'] > 0) {
            $mensaje = "No se puede eliminar el producto mientras haya stock disponible.";
        } else {
            // Eliminar el producto si el stock es 0
            $sql = "DELETE FROM productos WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $idProducto);
    
            if ($stmt->execute()) {
                $mensaje = "Producto eliminado exitosamente.";
            } else {
                $mensaje = "Error al eliminar el producto: " . $stmt->error;
            }
        }
    } else {
        $mensaje = "Producto no encontrado.";
    }

    $stmt->close();
}

// Mostrar productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
   <!-- Este es el menú -->
<header class="main-header">
    <div class="header-wrapper container">
        <a href="#" class="logo">Logo</a>
        <input type="checkbox" id="menu" />
        <label for="menu">
            <img src="images/menu.png" class="menu-icon" alt="">
        </label>
        <nav class="nav-menu">
            <ul class="menu-list">
                <li><a href="index.php"  class="menu-item">Inicio</a></li>
                <li><a href="nuestros_suplementos.php" class="menu-item">Nuestros Suplementos</a></li>
                <li><a href="contacto.php" class="menu-item">Contacto</a></li>
                <li><a href="acerca de.php" class="menu-item">Acerca de</a></li>
                <?php if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario'] == 'Invitado'): ?>
                    <li><a href="acceso.php" class="menu-item">Inicio de sesión</a></li>
                <?php endif; ?>

                <?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario'] != 'Invitado'): ?>
                    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>
                        <li><a href="admin_dashboard.php" class="menu-item">Agregar productos</a></li>
                    <?php endif; ?>
                <?php endif; ?>
                <li><a href="carrito.php" class="menu-item">Carrito (<span id="num-carrito">0</span>)</a></li>
            </ul>
        </nav>
    </div>
    <?php if (isset($_SESSION['usuario'])): ?>
        <a href="perfil.php" class="circulo-flotante">
            <?php echo ($_SESSION['usuario'] == 'Invitado') ? 'INV' : strtoupper(substr($_SESSION['usuario'], 0, 1)); ?>
        </a>
    <?php endif; ?>
</header>

<!-- Contenido entre el footer y el menú -->
<div class="admin">
    <h1>Panel de Administración</h1>

    <!-- Mensaje de éxito o error -->
    <?php if (isset($mensaje)): ?>
        <p><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <!-- Formulario para agregar productos -->
    <h2>Agregar Nuevo Producto</h2>
    <form action="admin_dashboard.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="accion" value="agregar">
        
        <label for="nombre">Nombre del Producto:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" required><br><br>

        <label for="imagen">Imagen del Producto:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*" required><br><br>

        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" required>
            <option value="Pre-entreno">Pre-Entreno</option>
            <option value="Proteína">Proteína</option>
            <option value="Creatina">Creatina</option>
        </select><br><br>

        <label for="stock">Stock Inicial:</label>
        <input type="number" id="stock" name="stock" required><br><br>

        <button type="submit">Agregar Producto</button>
    </form>

    <hr>

    <h2>Lista de Productos</h2>
    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Categoría</th>
                <th>Imagen</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['precio']; ?></td>
                    <td><?php echo $row['categoria']; ?></td>
                    <td><img src="<?php echo $row['imagen']; ?>" alt="Imagen del Producto" width="100"></td>
                    <td><?php echo $row['stock']; ?></td>
                    <td>
                        <!-- Aumentar stock -->
                        <form action="admin_dashboard.php" method="POST">
                            <input type="hidden" name="accion" value="aumentar_stock">
                            <input type="hidden" name="id_producto" value="<?php echo $row['id']; ?>">
                            <label for="cantidad">Aumentar Stock:</label>
                            <input type="number" name="cantidad" min="1" required>
                            <button type="submit">Aumentar</button>
                        </form>

                        <!-- Reducir stock -->
                        <form action="admin_dashboard.php" method="POST">
                            <input type="hidden" name="accion" value="reducir_stock">
                            <input type="hidden" name="id_producto" value="<?php echo $row['id']; ?>">
                            <label for="cantidad">Reducir Stock:</label>
                            <input type="number" name="cantidad" min="1" required>
                            <button type="submit">Reducir</button>
                        </form>

                        <!-- Eliminar producto -->
                        <?php if ($row['stock'] > 0): ?>
                            <p>No se puede eliminar mientras haya stock.</p>
                        <?php else: ?>
                            <a href="admin_dashboard.php?accion=eliminar&id=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No hay productos disponibles.</p>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="footer-content container">
        <div class="link">
            <h3>Contacto</h3>
            <ul>
                <li>
                    <a href="#" class="imagen1"></a>
                    <p>Ubicación</p>
                </li>
                <li>
                    <a href="#" class="imagen2"></a>
                    <p>+01 1234567890</p>
                </li>
                <li>
                    <a href="#" class="imagen3"></a>
                    <p>GYMWarrior@gmail.com</p>
                </li>
            </ul>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <p>© 2019 All Rights Reserved. Design by <a href="https://html.design/">Free Html Templates</a></p>
        </div>
    </div>
</footer>

<!-- Javascript files-->
<script>
// Cargar productos del carrito desde localStorage
let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
const numCarrito = document.getElementById('num-carrito');

// Función para actualizar el número de productos en el carrito
function actualizarNumCarrito() {
    const totalCantidad = carrito.reduce((total, item) => total + item.cantidad, 0);
    numCarrito.textContent = totalCantidad;
}

// Mostrar el número de productos en el carrito al cargar la página
actualizarNumCarrito();
</script>

</body>
</html>
<?php $conn->close(); ?>