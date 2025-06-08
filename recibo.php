<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Pago</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .recibo {
            position: relative;
            font-family: 'Arial', sans-serif;
            width: 70%;
            margin: 120px  auto 40px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .recibo h2 {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .detalle-producto {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .total {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }

        .btn-imprimir {
            display: inline-block;
            padding: 12px 40px;
            background-color: #0070ba;
            color: #fff;
            text-transform: uppercase;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            font-size: 16px;
        }
        .btn-salir{
            display: inline-block;
            padding: 12px 40px;
            background-color: #0070ba;
            color: #fff;
            text-transform: uppercase;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: -50% 0 3% 71%;
            font-size: 16px;
            
        }

        .detalle-producto span {
            font-size: 16px;
        }

        .recibo .titulo {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .recibo .detalles {
            margin-top: 20px;
        }

        .recibo .detalles p {
            font-size: 14px;
            color: #555;
        }

        .recibo .detalle-producto span:nth-child(1) {
            text-align: left;
        }

        .recibo .detalle-producto span:nth-child(2) {
            text-align: right;
        }

        /* Header del recibo */
        .recibo-header {
            display: flex;
            margin: auto;/*editarrrrrrrrr*/
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 2px solid #0070ba;
            padding-bottom: 10px;
        }

        .recibo-header .logo {
            font-size: 18px;
            font-weight: bold;
            color: #0070ba;
            text-transform: uppercase;
        }

        .recibo-header .fecha {
            font-size: 14px;
            color: #555;
            text-align: right;
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

<!-- Menú de navegación -->

    <!-- Recibo de Pago -->
    <div class="recibo" id="recibo">
        <!-- Header con el logo y la fecha -->
        <div class="recibo-header">
            <div class="logo">GYMWarrior</div>
            <div class="fecha" id="fecha"></div>
        </div>

        <h2>Recibo de Pago</h2>
        <p><strong>ID de Transacción:</strong> <span id="id-transaccion"></span></p>

        <!-- Detalles de productos -->
        <div id="productos"></div>

        <p class="total"><strong>Total: $<span id="total"></span></strong></p>

        <!-- Botón para imprimir recibo -->
        <button class="btn-imprimir" onclick="window.print()">Imprimir Recibo</button>

        <!-- Detalles adicionales -->
        <div class="detalles">
            <p><strong>Dirección de Envío:</strong> Calle Ficticia 123, Ciudad, País</p>
            <p><strong>Método de Pago:</strong> PayPal</p>
        </div>
    </div>
    <!---Esto es para el boton de salir -->
    <a href="index.php" class="btn-salir">Volver al inicio</a> 

    <script>
        // Recuperar los detalles del pago desde localStorage
const pagoDetalles = JSON.parse(localStorage.getItem('pagoDetalles'));

        // Obtener la fecha actual para mostrarla en el recibo
        const fecha = new Date();
        const fechaFormateada = `${fecha.getDate()}/${fecha.getMonth() + 1}/${fecha.getFullYear()}`;

if (pagoDetalles) {
            // Mostrar la fecha
            document.getElementById('fecha').textContent = `Fecha: ${fechaFormateada}`;

            // Mostrar el ID de la transacción
            document.getElementById('id-transaccion').textContent = pagoDetalles.idTransaccion;

            // Mostrar los productos comprados
            const productosDiv = document.getElementById('productos');
            pagoDetalles.productos.forEach(item => {
                const div = document.createElement('div');
                div.classList.add('detalle-producto');
                div.innerHTML = `
                    <span>${item.nombre} x ${item.cantidad}</span>
                    <span>$${(item.precio * item.cantidad).toFixed(2)}</span>
                `;
                productosDiv.appendChild(div);
            });

            // Mostrar el total
            document.getElementById('total').textContent = pagoDetalles.total;
        } else {
            document.getElementById('recibo').innerHTML = '<p>No se encontraron detalles de pago.</p>';
}
    </script>

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

<!------Holaaaaaaa soy checkpoint-->