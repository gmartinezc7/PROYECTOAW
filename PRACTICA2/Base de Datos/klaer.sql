-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-03-2023 a las 16:00:13
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra/venta`
--

CREATE TABLE `compra/venta` (
  `ID` int(11) NOT NULL,
  `IDComprador` varchar(15) NOT NULL,
  `IDVendedor` varchar(15) NOT NULL,
  `IDProducto` int(11) NOT NULL,
  `Fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conversacion chat`
--

CREATE TABLE `conversacion chat` (
  `ID` int(11) NOT NULL,
  `Usuario1` varchar(15) NOT NULL,
  `Usuario2` varchar(15) NOT NULL,
  `IDMensaje` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foro`
--

CREATE TABLE `foro` (
  `IDForo` int(11) NOT NULL,
  `IDUsuario` varchar(15) NOT NULL,
  `IDMensaje` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE `mensaje` (
  `ID` int(11) NOT NULL,
  `Fecha` datetime NOT NULL,
  `Mensaje` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `ID` int(11) NOT NULL,
  `Precio` decimal(10,0) NOT NULL,
  `Nombre` varchar(15) NOT NULL,
  `Descripción` varchar(2000) NOT NULL,
  `Tipo` varchar(15) NOT NULL,
  `Fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Usuario` varchar(15) NOT NULL,
  `Contraseña` varchar(20) NOT NULL,
  `Nombre` varchar(15) NOT NULL,
  `Apellidos` varchar(15) NOT NULL,
  `Dirección` varchar(30) NOT NULL,
  `tipo` varchar(7) NOT NULL,
  `telefono` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compra/venta`
--
ALTER TABLE `compra/venta`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDComprador` (`IDComprador`),
  ADD KEY `IDVendedor` (`IDVendedor`),
  ADD KEY `IDProducto` (`IDProducto`);

--
-- Indices de la tabla `conversacion chat`
--
ALTER TABLE `conversacion chat`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Usuario1` (`Usuario1`),
  ADD KEY `Usuario2` (`Usuario2`),
  ADD KEY `IDMensaje` (`IDMensaje`);

--
-- Indices de la tabla `foro`
--
ALTER TABLE `foro`
  ADD PRIMARY KEY (`IDForo`),
  ADD KEY `IDUsuario` (`IDUsuario`),
  ADD KEY `IDMensaje` (`IDMensaje`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Precio` (`Precio`),
  ADD KEY `Nombre` (`Nombre`),
  ADD KEY `Tipo` (`Tipo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Usuario`),
  ADD KEY `Nombre` (`Nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compra/venta`
--
ALTER TABLE `compra/venta`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `conversacion chat`
--
ALTER TABLE `conversacion chat`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `foro`
--
ALTER TABLE `foro`
  MODIFY `IDForo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra/venta`
--
ALTER TABLE `compra/venta`
  ADD CONSTRAINT `compra/venta_ibfk_1` FOREIGN KEY (`IDComprador`) REFERENCES `usuario` (`Usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `compra/venta_ibfk_2` FOREIGN KEY (`IDVendedor`) REFERENCES `usuario` (`Usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `compra/venta_ibfk_3` FOREIGN KEY (`IDProducto`) REFERENCES `productos` (`ID`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `conversacion chat`
--
ALTER TABLE `conversacion chat`
  ADD CONSTRAINT `conversacion chat_ibfk_1` FOREIGN KEY (`IDMensaje`) REFERENCES `mensaje` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `conversacion chat_ibfk_2` FOREIGN KEY (`Usuario1`) REFERENCES `usuario` (`Usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `conversacion chat_ibfk_3` FOREIGN KEY (`Usuario2`) REFERENCES `usuario` (`Usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `foro`
--
ALTER TABLE `foro`
  ADD CONSTRAINT `foro_ibfk_1` FOREIGN KEY (`IDMensaje`) REFERENCES `mensaje` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `foro_ibfk_2` FOREIGN KEY (`IDUsuario`) REFERENCES `usuario` (`Usuario`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
