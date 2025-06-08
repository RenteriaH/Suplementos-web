<?php
// Iniciar la sesión si no está ya iniciada
session_start();

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "gymwarrior");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Verifica si se ha enviado el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);

    // Validar que los campos no estén vacíos
    if (empty($usuario) || empty($contrasena)) {
        echo "Por favor, completa todos los campos.";
        exit();
    }

    // Consulta para verificar el usuario
    $sql = "SELECT id, nombre, contraseña FROM usuarios WHERE nombre = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $usuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $usuarioId, $nombreUsuario, $contrasenaHash);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Verificar si se encontró el usuario y si la contraseña es correcta
    if ($usuarioId && password_verify($contrasena, $contrasenaHash)) {
        // Establecer las variables de sesión
        $_SESSION['usuario_id'] = $usuarioId; // Guarda el ID del usuario en la sesión
        $_SESSION['usuario'] = $nombreUsuario; // Guarda el nombre del usuario en la sesión
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}

// Verifica si el usuario está logueado basándote en las variables de sesión de PHP
$estaLogueado = isset($_SESSION['usuario_id']);
$esInvitado = $estaLogueado && $_SESSION['usuario'] === 'Invitado'; // Asegúrate de usar '===' para comparación estricta

// Pasar las variables de sesión a JavaScript
echo "<script>var estaLogueado = " . json_encode($estaLogueado) . ";</script>";
echo "<script>var esInvitado = " . json_encode($esInvitado) . ";</script>";

// Consulta para obtener productos
$sql = "SELECT * FROM productos ORDER BY categoria";
$result = mysqli_query($conexion, $sql);

// Variables para cada categoría
$pre_entreno = [];
$proteina = [];
$creatina = [];

// Clasificar productos por categorías
if (mysqli_num_rows($result) > 0) {
    while ($producto = mysqli_fetch_assoc($result)) {
        switch ($producto['categoria']) {
            case 'Pre-entreno':
                $pre_entreno[] = $producto;
                break;
            case 'Proteína':
                $proteina[] = $producto;
                break;
            case 'Creatina':
                $creatina[] = $producto;
                break;
        }
    }
} else {
    echo "No se encontraron productos.";
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suplementos</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
   <!--- Este es el menú -->
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
                  <li><a href="contacto.php" class="menu-item" >Contacto</a></li>
                  <li><a href="acerca de.php" class="menu-item">Acerca de</a></li>
                             <!-- Mostrar solo si el usuario NO está logueado o está en modo invitado -->
                     <!-- Opciones para invitados -->
                     <?php if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario'] == 'Invitado'): ?>
                    <li><a href="acceso.php" class="menu-item">Inicio de sesión</a></li>
                <?php endif; ?>

                <!-- Opciones para usuarios logueados -->
                <?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario'] != 'Invitado'): ?>
                    <!-- Si es administrador, mostrar la opción de agregar productos -->
                    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>
                        <li><a href="admin_dashboard.php" class="menu-item">Agregar productos</a></li>
                    <?php endif; ?>
                    <!-- Cerrar sesión -->
                    <!---<li><a href="cerrar_sesion.php" class="menu-item">Cerrar sesión</a></li>---->
                <?php endif; ?>
                <li><a href="carrito.php" class="menu-item">Carrito (<span id="num-carrito">0</span>)</a></li>

                <!-- Mostrar solo si el usuario NO está logueado --><!-- Mostrar solo si el usuario está logueado -->
                </ul>
        </nav>
    </div>
        <!-- Círculo de usuario flotante con la inicial -->
    <?php if (isset($_SESSION['usuario'])): ?>
                 <!-- Círculo de usuario con la inicial o "Invitado" -->
        <a href="perfil.php" class="circulo-flotante">
            <?php
            // Mostrar inicial del usuario o "INV" si es invitado
            echo ($_SESSION['usuario'] == 'Invitado') ? 'INV' : strtoupper(substr($_SESSION['usuario'], 0, 1));
            ?>
        </a>
    <?php endif; ?>
<!-------------------------------------- Círculo de usuario flotante con la inicial -->
  </header>

    <!-- Sección de suplementos -->
<section id="suplementos" class="suplementos">
    <div class="container">
        <!-- Títulos de categorías -->
        <h2>Pre-entreno</h2>
            <div class="row">
            <?php foreach ($pre_entreno as $producto): ?>
                    <div class="suplemento-item">
                        <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                        <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                        <p>$<?= htmlspecialchars($producto['precio']) ?></p>
                        <p> stock: <?= htmlspecialchars($producto['stock'])?></p>
                       <!-- Botón de agregar al carrito -->
                       <button class="add-to-cart"
<?php if (!$estaLogueado && !$esInvitado): ?>
    onclick="alert('Debes iniciar sesión o continuar como invitado para agregar productos al carrito.');" 
<?php else: ?>
    data-id="<?= htmlspecialchars($producto['id'], ENT_QUOTES, 'UTF-8') ?>"
    data-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?>"
    data-precio="<?= htmlspecialchars($producto['precio'], ENT_QUOTES, 'UTF-8') ?>"
    data-imagen="<?= htmlspecialchars($producto['imagen'], ENT_QUOTES, 'UTF-8') ?>"
<?php endif; ?>>
    Agregar al carrito
</button>
                    </div>
                <?php endforeach; ?>
            </div>

            <h2>Creatina</h2>
<div class="row">
    <?php foreach ($creatina as $producto): ?>
        <div class="suplemento-item">
            <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
            <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
            <p>$<?= htmlspecialchars($producto['precio']) ?></p>
            <p>Stock: <?= htmlspecialchars($producto['stock']) ?></p>
            <!-- Botón de agregar al carrito -->
            <button class="add-to-cart"
<?php if (!$estaLogueado && !$esInvitado): ?>
    onclick="alert('Debes iniciar sesión o continuar como invitado para agregar productos al carrito.');" 
<?php else: ?>
    data-id="<?= htmlspecialchars($producto['id'], ENT_QUOTES, 'UTF-8') ?>"
    data-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?>"
    data-precio="<?= htmlspecialchars($producto['precio'], ENT_QUOTES, 'UTF-8') ?>"
    data-imagen="<?= htmlspecialchars($producto['imagen'], ENT_QUOTES, 'UTF-8') ?>"
<?php endif; ?>>
    Agregar al carrito
</button>
        </div>
    <?php endforeach; ?>
</div>

<h2>Proteína</h2>
<div class="row">
    <?php foreach ($proteina as $producto): ?>
        <div class="suplemento-item">
            <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
            <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
            <p>$<?= htmlspecialchars($producto['precio']) ?></p>
            <p> stock: <?= htmlspecialchars($producto['stock'])?></p>
            <button class="add-to-cart"
                <?php if (!$estaLogueado && !$esInvitado): ?>
                    onclick="window.location.href='acceso.php';" 
                <?php else: ?>
                    data-id="<?= htmlspecialchars($producto['id'], ENT_QUOTES, 'UTF-8') ?>"
                    data-nombre="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?>"
                    data-precio="<?= htmlspecialchars($producto['precio'], ENT_QUOTES, 'UTF-8') ?>"
                    data-imagen="<?= htmlspecialchars($producto['imagen'], ENT_QUOTES, 'UTF-8') ?>"
                <?php endif; ?>>
                Agregar al carrito
            </button>
        </div>
    <?php endforeach; ?>
</div>
</section>
</body>

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

// Función para agregar productos al carrito
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', (event) => {
        // Verifica si el usuario es invitado o está logueado
        if (!estaLogueado && !esInvitado) {
            alert('Debes iniciar sesión o continuar como invitado para agregar productos al carrito.');
            return; // Detener la ejecución
        }

        // Obtener los atributos de datos del botón
        const productoID = event.target.getAttribute('data-id');
        const productoNombre = event.target.getAttribute('data-nombre');
        const productoPrecio = parseFloat(event.target.getAttribute('data-precio'));
        const productoImagen = event.target.getAttribute('data-imagen');

        // Validación de los datos
        if (!productoID || !productoNombre || isNaN(productoPrecio) || !productoImagen) {
            alert('Hubo un error al agregar el producto al carrito.');
            return;
        }

        // Verifica si el producto ya existe en el carrito
        let productoExistente = carrito.find(item => item.id === productoID);
        if (productoExistente) {
            productoExistente.cantidad++;
        } else {
            carrito.push({ id: productoID, nombre: productoNombre, precio: productoPrecio, imagen: productoImagen, cantidad: 1 });
        }

        // Guarda el carrito en localStorage
        localStorage.setItem('carrito', JSON.stringify(carrito));
        actualizarNumCarrito(); // Actualiza el número de productos en el carrito
        alert('Producto agregado al carrito exitosamente.');
    });
});
</script>
<!-------------------------Footer------------------------------>
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
</body>
</html>