<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: acceso.html"); // Si no está logueado, redirigir al inicio de sesión
    exit();
}

// Obtener los datos del usuario desde la sesión
$usuario = $_SESSION['usuario'];
$usuario_id = $_SESSION['usuario_id'];

// Aquí puedes obtener más información del usuario desde la base de datos si es necesario
// Ejemplo de conexión a la base de datos y obtención de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gymwarrior";
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del usuario solo si no es invitado
if ($_SESSION['usuario'] != 'Invitado') {
    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
} else {
    // Si es invitado, no se obtienen datos de la base de datos
    $user_data = [
        'nombre' => 'Invitado',
        'correo' => 'No disponible',
        'telefono' => 'No disponible'
    ];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
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

  
 <!-- Información del perfil en una tabla centrada -->
<div class="perfil-container">



    <h1>Bienvenido, <?php echo $usuario; ?></h1>
    
    <!-- Tabla con los datos del usuario -->
    <table class="perfil-table">
        <tr>
            <th>Nombre</th>
            <td><?php echo $user_data['nombre']; ?></td>
        </tr>
        <tr>
            <th>Correo</th>
            <td><?php echo $user_data['correo']; ?></td>
        </tr>
        <tr>
            <th>Teléfono</th>
            <td><?php echo $user_data['telefono']; ?></td>
        </tr>
    </table>

    <!-- Botón de cerrar sesión -->
    <a href="cerrar_sesion.php" class="btn-cerrar-sesion">Cerrar sesión</a>
    <!-- Botón para volver al inicio -->
    <a href="index.php" class="btn-volver">Volver al inicio</a>
</div>

    <!-------------------------Footer----------------------------->
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