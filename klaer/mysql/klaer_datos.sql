-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-04-2023 a las 11:29:51
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `klaer`
--

--
-- Volcado de datos para la tabla `foro`
--

INSERT IGNORE INTO `foro` (`id`, `titulo`, `idUsuario`, `mensaje`, `respuestas`, `fecha`) VALUES
(1, 'FUNDA PARA AURICULARES ESSENTIALS TINY', 2, 'ELEGANTE Y FUNCIONAL\r\nNo te olvides de los auriculares ni de la tarjeta del gimnasio. Es más fácil seguir tu rutina de entrenamiento cuando tienes todo lo que necesitas. Esta pequeña funda adidas cuenta con una correa extraíble que te permite llevarla en el cuello o guardarla en el bolso. Se ha fabricado en piel sintética y luce un logotipo que añade un toque deportivo a tus looks.', 3, '2023-04-11 13:48:01'),
(15, 'Nike Jordan', 3, 'nuevas zapatillas de la tienda a tus pies', 1, '2023-04-12 10:26:43');

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT IGNORE INTO `respuestas` (`id`, `idUsuario`, `texto`, `fecha`, `idPub`) VALUES
(1, 1, 'Me encanta, es super útil!', '2023-04-11 16:21:41', 1),
(2, 3, 'Yo ya me lo compre!', '2023-04-12 07:30:52', 1),
(7, 2, 'Me gustan mucho', '2023-04-13 07:14:54', 15);

--
-- Volcado de datos para la tabla `productos`
--

INSERT IGNORE INTO `productos` (`id`, `precio`, `nombre`, `descripcion`, `tipo`, `fecha`, `cantidad`, `idUsuario`) VALUES
(1, '15', 'Camiseta', 'Camiseta blanca simple', 'Ropa', '2023-03-08', 5, 0),
(2, '160', 'Nike Air Max 27', 'Zapatillas de Nike de la talla 43', 'Zapateria', '2023-03-12', 10, 0),
(3, '210', 'HP ProBook 430', 'Portatil de HP', 'Informatica', '2023-03-15', 1, 0);

--
-- Volcado de datos para la tabla `roles`
--

INSERT IGNORE INTO `roles` (`id`, `nombre`) VALUES
(1, 'admin'),
(3, 'mod'),
(2, 'user');

--
-- Volcado de datos para la tabla `rolesusuario`
--

INSERT IGNORE INTO `rolesusuario` (`usuario`, `rol`) VALUES
(1, 2),
(2, 3),
(3, 1);
--
-- Volcado de datos para la tabla `usuario`
--

-- Las contraseñas para cada usuario son: soyalex, soyangela, soydani

INSERT IGNORE INTO `usuario` (`usuario`, `password`, `nombre`, `apellidos`, `direccion`, `telefono`, `email`) VALUES
('Alejandro', '$2y$10$r0l23e6wAcaF8L7gI3PhmuJZ0pjZdzsohBwfj049oM3NarX2J5JFq', 'Alejandro', 'Nafria', 'Madrid', '222222222', 'alex@gmail.com'),
('Angela', '$2y$10$cl3h4MhOVtPS9qK.LcZE7OiBlh1OGPMr1E497/VCcI1AsUUIaYNXW', 'Angela', 'Lucena', 'Madrid', '333333333', 'angela@gmail.com'),
('Dani', '$2y$10$2b/msAvjbYEe1Vm3pFQHee4vTwK7sI7zXpxdykg0IhmdFkGEVaUJK', 'Daniel', 'Ortiz', 'Madrid', '111111111', 'dani@gmail.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;