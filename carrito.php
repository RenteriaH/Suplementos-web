<?php
session_start();

// Verificar si se ha realizado una compra
if (isset($_SESSION['compra_realizada'])) {
    // Vaciar el carrito en localStorage
    echo '<script>
        localStorage.removeItem("carrito");
    </script>';

    // Eliminar la variable de sesión para que no se ejecute nuevamente
    unset($_SESSION['compra_realizada']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="style.css">

    <!-- Incluir el SDK de PayPal -->
    <script src="https://www.paypal.com/sdk/js?client-id=AUCJF8N3icAUs4NEFK_XuQUMqNKc5WUabxWWQIHCsxizD0Ei7C0BzxKHtXAGPz-53hSxq0nuX6nx5mEY&currency=MXN"></script>

    <style>
        /* Estilos para el carrito */
        #carrito {
            margin: 40px 0;
            padding: 0 20px;
}

#productos-carrito {
    display: flex;
    flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px; /* Espacio entre productos */
}

.producto-carrito {
            width: 200px;
            padding: 15px;
            background-color: #f4f4f4;
    border: 1px solid #ddd;
    border-radius: 8px;
    text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.producto-carrito img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .producto-carrito p {
            font-size: 14px;
            margin: 10px 0;
        }

        .cantidad {
            font-weight: bold;
        }

        .eliminar {
            background-color: green;
            color: white;
            border: none;
            padding: 5px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 12px;
        }

        .eliminar:hover {
            background-color: darkred;
        }

        #total-amount {
            font-size: 20px;
            font-weight: bold;
        }

 Estilos para el contenedor del botón de PayPal 
#paypal-button-container {
width: 100%;            /*     Asegura que el contenedor ocupe todo el ancho disponible */
display: flex;         /*     Utiliza flexbox para centrar */
justify-content: flex-start; /* Esto alineará el contenido hacia la izquierda */
margin-top: 30px;
}

#paypal-button-container iframe {
margin-left: 150px;          /* Mueve el iframe del botón hacia la derecha */
margin-right: 0;            /* Asegura que no haya espacio extra a la derecha */
}

    </style>
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


 

    <!-- Carrito -->
    <section id="carrito">
        <div class="container">
            <h2>Carrito de Compras</h2>
            <div id="productos-carrito"></div>
            <p>Total: $<span id="total-amount">0.00</span></p>
            <div id="paypal-button-container"></div> <!-- Contenedor para el botón de PayPal -->
        </div>
        

    </section>

    <!-- Enlazar el archivo JS -->
    <script src="carrito.js"></script>

    <!-- Footer -->
    <footer class="footer">    
        <div class="footer-content container">
            <div class="link">
                <h3>Contacto</h3>
                <ul>
                    <li><a href="#" class="imagen1"></a><p>Ubicación</p></li>
                    <li><a href="#" class="imagen2"></a><p>+01 1234567890</p></li>
                    <li><a href="#" class="imagen3"></a><p>GYMWarrior@gmail.com</p></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                <p>© 2024 All Rights Reserved. Design by <a href="https://html.design/">Free Html Templates</a></p>
            </div>
        </div>
    </footer>

</body>
</html>
<!---Hola soy el checkpoint//

sb-kwolg33961445@personal.example.com
usq4JDV&
-->

