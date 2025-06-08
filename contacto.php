<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
     
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
<!-- contact section -->
<div id="contact" class="contact">
    <div class="container">
       <div class="row">
          <div class="col-md-6">
             <form id="request" class="main_form">
                <div class="row">
                   <div class="col-md-12 ">
                      <h3>Contactanos</h3>
                   </div>
                   <div class="col-md-12 ">
                      <input class="contactus" placeholder="Nombre" type="type" name="Nombre"> 
                   </div>
                   <div class="col-md-12">
                      <input class="contactus" placeholder="Numero de telefono" type="type" name="Numero de telefono"> 
                   </div>
                   <div class="col-md-12">
                      <input class="contactus" placeholder="Email" type="type" name="Email">                          
                   </div>
                   <div class="col-md-12">
                      <input class="contactusmess" placeholder="Mensaje" type="type" Message="Nombre">
                   </div>
                   <div class="col-md-12">
                      <button class="send_btn">Send</button>
                   </div>
                </div>
             </form>
          </div>
       </div>
    </div>
    <div class="container-fluid">
       <div class="map_section">
          <div id="map">
          </div>
       </div>
    </div>
 </div>
 </div>
 <!-- end contact section -->
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

<!-- Javascript files-->
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery-3.0.0.min.js"></script>
<!-- sidebar -->
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="js/custom.js"></script>
<script>
   // This example adds a marker to indicate the position of Bondi Beach in Sydney,
   // Australia.
   function initMap() {
     var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 18, // Ajusta el nivel de zoom según sea necesario
        center: { lat: 25.53513393227987, lng: -103.4348764968571 }, // Coordenadas del Instituto
       });
   
  // Agregar marcador
var marker = new google.maps.Marker({
    position: {lat: 25.53513393227987, lng: -103.4348764968571},
       
       map: map,
       title: 'Instituto Tecnológico de La Laguna',
     });
   }
</script>
<!-- google map js -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8eaHt9Dh5H57Zh0xVTqxVdBFCvFMqFjQ&callback=initMap"></script>
<!-- end google map js --> 

</body>
</html>