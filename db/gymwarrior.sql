-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-06-2025 a las 23:15:49
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gymwarrior`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) UNSIGNED NOT NULL,
  `usuario_id` int(11) UNSIGNED NOT NULL,
  `producto` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cuenta_paypal` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `fecha_agregado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`, `categoria`, `stock`, `fecha_agregado`) VALUES
(91, 'Pre Entreno Dragon Pharma Venom', 'Pre-entreno de Dragon Pharma, sabor Dragon\'s Blood.', 650.99, 'imagenes/Pre Entreno Dragon Pharma Venom Inferno 40 Servs Extremo Sabor Dragons Blood_2.webp', 'Pre-entreno', 147, '2024-11-13 22:16:45'),
(92, 'Zombie Pre Entreno Extremo', 'Pre-entreno Zombie, sabor Algodón de Azúcar.', 700.99, 'imagenes/Zombie Pre Entreno Extremo (algodon De Azúcar)_3.webp', 'Pre-entreno', 129, '2024-11-13 22:16:45'),
(93, 'Pre Workout con Creatina', 'Pre-workout con creatina de PiSA.', 900.99, 'imagenes/Pre Workout con Creatina, Hecho por PiSA_8.jpg', 'Pre-entreno', 255, '2024-11-13 22:16:45'),
(94, 'Preentrenador Workout Hiroshima', 'Preentrenador Workout Hiroshima, sabor Uva.', 500.99, 'imagenes/Preentrenador Workout Hiroshima + Clemb Oxido 30 Servicios Sabor Uva_2.png', 'Pre-entreno', 287, '2024-11-13 22:16:45'),
(95, 'Birdman Creatina', 'Creatina Monohidratada de alta pureza en polvo, sin sabor.', 800.99, 'imagenes/Birdman Creatina Monohidratada de Alta Pureza En Polvo Sin Sabor_2.jpg', 'Creatina', 245, '2024-11-13 22:16:46'),
(96, 'Elemental Creatina Monohidratada', 'Creatina monohidratada de PiSA, pureza certificada.', 679.99, 'imagenes/Elemental Creatina Monohidratada, Hecho por PiSA, Pureza Certificada Laboratorio_7.jpg', 'Creatina', 350, '2024-11-13 22:16:46'),
(97, 'GAT Creatina', 'Creatina GAT de alta calidad.', 490.99, 'imagenes/GAT Creatina.jpg', 'Creatina', 198, '2024-11-13 22:16:46'),
(98, 'B-FIT B Creabet', 'Creatina monohidratada B-FIT B Creabet.', 598.99, 'imagenes/B-FIT B Creabet - Creatina Monohidratada.jpg', 'Creatina', 122, '2024-11-13 22:16:46'),
(99, 'Proteína Pro Whey', 'Proteína de suero Pro Whey Isolate de 5 lbs.', 600.99, 'imagenes/Proteína Pro Whey Isolate 5lbs_1.jpg', 'Proteína', 242, '2024-11-13 22:16:46'),
(100, 'Birdman Falcon Performance Proteina', 'Proteína premium Falcon Performance de Birdman.', 900.99, 'imagenes/Birdman Falcon Performance Proteina Premium Alto Rendimiento En Polvo_3.jpg', 'Proteína', 237, '2024-11-13 22:16:46'),
(101, 'SILVIA STRAUSS Proteína Vegetal', 'Proteína vegetal orgánica de Silvia Strauss.', 600.99, 'imagenes/SILVIA STRAUSS Proteína Vegetal Orgánica_4.jpg', 'Proteína', 200, '2024-11-13 22:16:46'),
(102, 'BHP ULTRA ISO Ultra Pure Cero Carbs', 'Proteína Ultra Pure BHP, sin carbohidratos, sabor fresa con crema.', 490.99, 'imagenes/BHP ULTRA ISO Ultra Pure Cero Carbs fresas con crema_6.jpg', 'Proteína', 245, '2024-11-13 22:16:46'),
(108, 'Creatina Monohidratada De Alta Pureza', '', 500.00, 'imagenes/Creatina Monohidratada De Alta Pureza.webp', 'Creatina', 130, '2024-11-18 23:03:45'),
(112, 'vitamina1', '', 50.00, 'imagenes/Zombie Pre Entreno Extremo (algodon De Azúcar)_3.webp', 'Proteína', 2, '2024-12-12 20:56:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `telefono` varchar(15) NOT NULL,
  `rol` enum('usuario','admin') DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `contraseña`, `fecha_registro`, `telefono`, `rol`) VALUES
(1, 'guillermo1', 'renteg18@gmail.com', '$2y$10$sHcSNDMn/DSanhs0bRq6CegCCdcb.KsQXLMeeD1mOMPtFON9b0GGG', '2024-11-13 16:35:13', '8721171917', 'usuario'),
(2, 'rick', 'alu.22131390@correo.itlalaguna.edu.mx', '$2y$10$8si6VOJLkbmmX.VTS/4WVOoeAM/szbiZ/0wY5mNJmgw3Eh6W0GOd6', '2024-11-13 19:50:50', '9721171918', 'usuario'),
(7, 'admin', 'admin@gymwarrior.com', '$2y$10$WakPL2qFNpqpHvIiBe0vJeg7SAXXZkxjt2bmTWll4LniLatoQbI/S', '2024-11-18 20:00:06', '1234567890', 'admin'),
(9, 'guillermo', 'renteg182@gmail.com', '$2y$10$uLHfxUZmxX6FSx1dpE.K5eIWJnJ8/fLQwy6URHCAbqaslfAiXFZJ.', '2024-12-02 00:45:36', '8282828', 'usuario'),
(11, 'guillermo', 'renteg1824@gmail.com', '$2y$10$sz8e9j3Ra124EibI7zPrl.jAq7UV5ixp2onKZj6fqdH3LlNkM5qj2', '2024-12-02 00:46:34', '8282828', 'usuario'),
(12, 'ds', 'programacionwebtec00@gmail.com', '$2y$10$5UyUsSKB6LE7T42UGbnsfOn/OADsxz8lw.VG4DbM1i8EoxdX46E2e', '2024-12-13 18:09:58', '12121', 'usuario'),
(13, 'Guillermo<>', 'asdsa@ddsads', '$2y$10$fEXmw3Tv7TZ3dCgQtLzQKeZ74dpBdd6Ld/c0gLLNYAZBRJmOoaB3u', '2024-12-13 18:21:09', '3232', 'usuario'),
(14, 'sasad', 'alu.221313920@correo.itlalaguna.edu.mx', '$2y$10$xi1agrbXQIb0hlh/gz1Fi.dsKY2vcD5mtFX.27M83hNjOyu8p3w7y', '2024-12-13 18:31:12', '8721171918', 'usuario'),
(15, 'sadsa<>', 'programacionwebtedsac00@gmail.com', '$2y$10$JPYoKfl.03jCSWF4EEatjOfVGCrJIS2H/6ea2B3lNEzl9DJof2Xc6', '2024-12-13 18:33:18', '2121', 'usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
