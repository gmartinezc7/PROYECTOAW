-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-03-2023 a las 19:25:01
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
-- Volcado de datos para la tabla `productos`
--

INSERT IGNORE INTO `productos` (`id`, `precio`, `nombre`, `descripcion`, `tipo`, `fecha`, `cantidad`) VALUES
(1, '15', 'Camiseta', 'Camiseta blanca simple', 'Ropa', '2023-03-08', 5),
(2, '160', 'Nike Air Max 27', 'Zapatillas de Nike de la talla 43', 'Zapateria', '2023-03-12', 10),
(3, '210', 'HP ProBook 430', 'Portatil de HP', 'Informatica', '2023-03-15', 1);

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
('Alex', 2),
('Angela', 3),
('Dani', 1),
('Elo', 2),
('Gon', 1),
('Jaime', 3);

--
-- Volcado de datos para la tabla `usuario`
--

INSERT IGNORE INTO `usuario` (`usuario`, `password`, `nombre`, `apellidos`, `direccion`, `telefono`, `email`, `rol`) VALUES
('Alex', 'soyalex', 'Alejandro', 'Nafria', 'Madrid', '222222222', 'alex@gmail.com', 'user'),
('Angela', 'soyangela', 'Angela', 'Lucena', 'Madrid', '333333333', 'angela@gmail.com', 'mod'),
('Dani', 'soydani', 'Daniel', 'Ortiz', 'Madrid', '111111111', 'dani@gmail.com', 'admin'),
('Elo', 'soyelo', 'Eloisa', 'Rodriguez', 'Madrid', '555555555', 'elo@gmail.com', 'user'),
('Gon', 'soygon', 'Gonzalo', 'Martinez', 'Madrid', '444444444', 'gonzalo@gmail.com', 'admin'),
('Jaime', 'soyjaime', 'Jaime', 'Millan', 'Madrid', '666666666', 'jaime@gmail.com', 'mod');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
