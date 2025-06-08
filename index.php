<?php
session_start();

// Verificar si se ha cerrado sesión
if (isset($_SESSION['cerrar_sesion'])) {
    // Vaciar el carrito en localStorage
    echo '<script>
        localStorage.removeItem("carrito");
    </script>';

    // Eliminar la variable de sesión para que no se ejecute nuevamente
    unset($_SESSION['cerrar_sesion']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Incluir CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Incluir FontAwesome para los íconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <!-- Opcional: Incluir jQuery si no lo tienes ya -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    

    <link rel="stylesheet" href="style.css">

</head>
<body>
    <header class="header">
          <!---Esto es el menu -->
        <div class="menu container">
            <a href="#" class="logo">Logo
                <!--<img src="imagenes/LogoGym.png" alt="Logo" />  Cambia esto al nombre de tu logo -->

            </a>
            <input type="checkbox" id="menu" />
            <label for="menu">
                <img src="images/menu.png" class="menu-icono" alt="">
            </label>
            <nav class="navbar">
                <ul >
                    <li><a href="index.php">inicio</a></li>
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
        <div class="header-content container">
            <h1>Bienvenido a GYMWarrior</h1>
            <p>
                En GYMWarrior, entendemos que hay innumerables opciones de suplementos en el mercado, pero nuestra tienda se destaca por ofrecer productos de alta calidad a precios competitivos. Nos enfocamos en brindarte los mejores suplementos para apoyar tu estilo de vida activo y ayudarte a alcanzar tus objetivos de salud y rendimiento!!.
            </p>
            <a href="nuestros suplementos.php" class="btn-1">Compra nueva</a>
        </div>
    </header>
    
  <!---Nueva seccion-->
<section class="suplementos">

   <!---- <img class="suplementos-img" src="imagenes/bg2.png" alt="">---->

    <div class="suplementos-content container">
        
        <h2>Nuestos Suplementos</h2>
        
        <p class="txt-p">Potencia tus musculos, maximiza tu rendimineto. 
        </p>
        
        <div class="suplementos-group">

         <div class="suplementos-1">
            <img src="imagenes/Proteína Pro Whey Isolate 5lbs_1.jpg" alt="">
             <h3>Proteína Pro Whey </h3>
             <p>
                <!--<li class="listaSuplementos">Baja en Carbohidratos: Perfecta para complementar tu plan alimenticio sin agregar azúcares ni carbohidratos innecesarios</li>
                <li class="listaSuplementos">Sin Azúcar Añadida: Ideal para mantener el equilibrio en tus niveles de glucosa</li> ------>
                Baja en Carbos. Este producto es bajo en carbohidratos, por lo que es un buen complemento a tu plan alimenticio.
                Sin Azucar. Este producto no tiene azucar añadida por lo que te yuda a mantener un balance en tu nivel se glucosa en tu cuerpo
            
            </p>
         </div>
         <div class="suplementos-1">
            <img src="imagenes/Birdman Creatina Monohidratada de Alta Pureza En Polvo Sin Sabor_2.jpg" alt="">
             <h3>Birdman Creatina </h3>
             <p>Micronizada y de alta pureza, te ayudará a complementar tu rutina
                 diaria y apoyarte para alcanzar tus metas. Además, es completamente 
                 libre de saborizantes y endulzantes
                 por lo que puedes agregarla a cualquier bebida sin cambiar su sabor.
                </p>
         </div>
         <div class="suplementos-1">
            <img src="imagenes/Birdman Falcon Performance Proteina Premium Alto Rendimiento En Polvo_3.jpg" alt="">
             <h3>Birdman Falcon Performance Proteina</h3>
             <p>Rica Fuente de Proteínas cada porción está cargada con hasta 
                31 gramos de proteína, diseñado para aquellos que buscan complementar 
                su ingesta diaria de proteínas y apoyar un estilo de vida activo.
                </p>
         </div>
        </div>
        <a href="nuestros_suplementos.php" class="btn-1">Comprar ahora</a> 
    </div>
</section>

<!--Seccion nueva se usa la etiqueta main solo una vez para decir que es el contenido mas relevante o principal -->
     <main class="services">
     <div class="services-content cotainer">
      <h2>Suplementos Servicios</h2>
       <div class="services-group">

        <div class="services-1">
            <img src="imagenes/m1.png" alt="">
           <!---- <img src="images/i1.svg" alt=""> -->
            <h3>Servicio 1</h3>
        </div>
        <div class="services-1">
            <img src="imagenes/m2.png" alt="">
            <h3>Servicio 2</h3>
        </div>
        <div class="services-1">
            <img src="imagenes/m3.png" alt="">
            <h3>Servicio 3</h3>
        </div>
        <div class="services-1">
            <img src="imagenes/m4.png" alt="">
           <!---- <img src="images/i1.svg" alt=""> -->
            <h3>Servicio 4</h3>
        </div>

       </div>
     <p>
        Los suplementos son útiles cuando la dieta diaria no proporciona todos los nutrientes que el cuerpo necesita. Antes de comenzar a tomar cualquier suplemento, es recomendable consultar con un profesional de la salud, especialmente si tienes condiciones médicas preexistentes o estás tomando medicamentos.
     </p>
     <a href="nuestros_suplementos.php" class="btn-1">Comprar ahora</a>
     </div>
    </main>

    <!--------------------------------------------------------Seccion nueva -------------------------------------------->
    <section class="general ">

        <div class="general-1 contenedor ">
        <h2>Pre Entreno Dragon Pharma Venom </h2>
        <p>Venom® - Preentrenamiento de potencia extrema.
            Venom® es un preentrenamiento formulado para ser un catalizador de energía de alta intensidad y 
            de conducción de enfoque. Con 375 mg de cafeína anhidra y 50 mg de Infinergy® (malato de dicafeína),
             junto con una combinación sinérgica de L-tirosina y huperzina,
             proporciona la concentración necesaria para superar cada sesión de ejercicio.
        </p>
        <a href="nuestros suplementos.html" class="btn-1" >Comprar ahora</a>
        </div>
        <div class="general-2"></div>
    </section>

    <!--------------------------------------------------------Seccion nueva -------------------------------------------->
    <section class="general">

        <div class="general-3"></div>

        <div class="general-1 contenedor">
        <h2>Zombie Pre Entreno Extremo</h2>
        <p>Una nutrición balanceada juega un papel fundamental 
            en la calidad de vida. Con el ritmo acelerado que llevan muchas personas,
             a veces resulta complejo prestar atención a todos los requerimientos que el cuerpo
              necesita para estar sano y fuerte. En ese sentido, los suplementos cumplen la función de complementar 
              la alimentación y ayudan a obtener las vitaminas, minerales, proteínas y otros componentes indispensables para
               el correcto funcionamiento del organismo.
            Recomendado para deportes intensos
            
        </p>
        <a href="nuestros suplementos.php" class="btn-1">Comprar ahora</a>
        </div>
    
    </section>

    <section class="blog container">
        <h2>Blog</h2>
        <p>No importa en qué etapa te encuentres, nuestro blog está aquí para acompañarte en cada paso del camino. ¡Comencemos juntos este viaje hacia un estilo de vida más saludable!
        </p>
        <div class="blog-content">

            <div class="blog-1">
            <img src="imagenes/Suplementos-Para-Principiantes-Blog.jpg" alt="">
            <h3>Guía completa de suplementos según tus objetivos</h3>
            <p><li class="listaSuplementos">Suplementos para ganar masa muscular: Proteínas (como Pro Whey y Birdman Falcon), creatina. Se enfocan en la reparación y crecimiento muscular.</li>
                <li class="listaSuplementos">Suplementos para perder grasa: Proteínas (que ayudan a mantener la masa muscular mientras se quema grasa), y preentrenos (que aumentan la energía para entrenamientos más intensos).</li>
                <li class="listaSuplementos">Suplementos para mejorar el rendimiento: Creatina y preentrenos (como Dragon Pharma Venom) que aumentan la energía y la concentración durante el ejercicio.</li>
                <li class="listaSuplementos"> Conclusión: Cada persona tiene necesidades diferentes, por lo que es vital conocer tus objetivos y elegir los suplementos adecuados.</li>
            </p>
            </div>
            <div class="blog-1">
                <img src="imagenes/Como tomar creatina.png" alt="">
                <h3>¿Qué es la creatina y cómo funciona?</h3>
                <p>
                    <li class="listaSuplementos">Definición: La creatina es un compuesto que se encuentra naturalmente en el cuerpo y ayuda a producir energía durante ejercicios de alta intensidad.</li>
                    <li class="listaSuplementos">Beneficios: Mejora el rendimiento, aumenta la fuerza y potencia muscular, y ayuda en la recuperación.</li>
                    <li class="listaSuplementos">Dosis recomendada: Usualmente se recomienda una carga de 20 g/día durante 5-7 días, seguida de una dosis de mantenimiento de 3-5 g/día.</li>
                    <li class="listaSuplementos">Uso de Birdman Creatina: Micronizada y sin sabor, puede ser mezclada con cualquier bebida, lo que facilita su incorporación en la rutina diaria.</li>
          </p>
          </div>
           <div class="blog-1">
                <img src="imagenes/Pre-entrenos.jpg" alt="">
                   <h3>Pre-entrenos: ¿Cómo pueden mejorar tus sesiones de ejercicio?</h3>
                    <p>
                        <li class="listaSuplementos">Función de los preentrenos: Aumentan la energía y el enfoque mental, ayudando a mejorar la intensidad de los entrenamientos.</li>
                        <li class="listaSuplementos">Ingredientes clave: Cafeína (375 mg en Venom), L-tirosina, y huperzina, que ayudan a mejorar la concentración y el rendimiento físico.</li>
                        <li class="listaSuplementos">Beneficios de Dragon Pharma Venom y Zombie Pre Entreno Extremo: Formulados para potenciar la energía, mejorar el enfoque y la resistencia, ideales para entrenamientos intensos.</li>
                        <li class="listaSuplementos">Consejos: Consumir el preentreno de 20 a 30 minutos antes del ejercicio para obtener mejores resultados.</li>
            </p>
          </div>
        </div>
        <a href="nuestros_suplementos.php" class="btn-1">Comprar ahora</a>
    </section>

  <!-- Clients Section -->
  <div class="clients">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>¿Qué dicen nuestros clientes?</h2>
                        <p>La opinión de nuestros clientes es la más importante</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="myCarousel" class="carousel">
                        <!-- Slides del carrusel -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="clients_box">
                                    <figure><img src="imagenes/Jorge.jpg" alt="Cliente 1"></figure>
                                    <h3>Jorge Marrufo</h3>
                                    <p>Estos productos son de los mejores que he probado, además, el precio se ajusta a nosotros los clientes.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="clients_box">
                                    <figure><img src="imagenes/Tomas.jpg" alt="Cliente 2"></figure>
                                    <h3>Tomas</h3>
                                    <p>Creo que seguiré comprando productos de esta tienda, además, son de muy buena calidad y vienen con el sello de la marca.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="clients_box">
                                    <figure><img src="imagenes/Rick Garcia.jpg" alt="Cliente 3"></figure>
                                    <h3>Rick Garcia</h3>
                                    <p>Las creatinas que vende esta tienda son de calidad, además, los precios son accesibles.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="clients_box">
                                    <figure><img src="imagenes/Francisco Marroqui.jpg" alt="Cliente 4"></figure>
                                    <h3>Francisco Marroquín</h3>
                                    <p>He estado cambiando todos mis hábitos, y comprar productos de calidad como los que venden aquí me han ayudado mucho.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Controles de navegación del carrusel -->
                        <a class="carousel-control-prev hidden-control" href="#" role="button" data-slide="prev">
                            <span class="sr-only">Anterior</span>
                        </a>
                        <a class="carousel-control-next hidden-control" href="#" role="button" data-slide="next">
                            <span class="sr-only">Siguiente</span>
                        </a>
                        <!-- Indicadores -->
                        <ol class="carousel-indicators">
                            <li data-slide-to="0" class="active"></li>
                            <li data-slide-to="1"></li>
                            <li data-slide-to="2"></li>
                            <li data-slide-to="3"></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="carousel.js"></script>

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
<!---Reset de ceunta-->