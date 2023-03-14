-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-03-2023 a las 14:40:01
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
CREATE DATABASE IF NOT EXISTS `klaer` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `klaer`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transaccion`
--

DROP TABLE IF EXISTS `transaccion`;
CREATE TABLE `transaccion` (
  `ID` int(11) NOT NULL,
  `IDComprador` varchar(15) NOT NULL,
  `IDVendedor` varchar(15) NOT NULL,
  `Admin` varchar(15) NOT NULL,
  `IDProducto` int(11) NOT NULL,
  `Fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conversacion`
--

DROP TABLE IF EXISTS `conversacion`;
CREATE TABLE `conversacion` (
  `ID` int(11) NOT NULL,
  `Usuario1` varchar(15) NOT NULL,
  `Usuario2` varchar(15) NOT NULL,
  `Admin` varchar(15) NOT NULL,
  `IDMensaje` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foro`
--

DROP TABLE IF EXISTS `foro`;
CREATE TABLE `foro` (
  `IDForo` int(11) NOT NULL,
  `IDUsuario` varchar(15) NOT NULL,
  `Admin/Mod` varchar(15) NOT NULL,
  `IDMensaje` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

DROP TABLE IF EXISTS `mensaje`;
CREATE TABLE `mensaje` (
  `ID` int(11) NOT NULL,
  `Fecha` datetime NOT NULL,
  `Mensaje` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto` (
  `ID` int(11) NOT NULL,
  `Precio` decimal(10,0) NOT NULL,
  `Nombre` varchar(15) NOT NULL,
  `Descripción` varchar(2000) NOT NULL,
  `Tipo` varchar(15) NOT NULL,
  `Fecha` date NOT NULL,
  `Cantidad` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rolesusuario`
--

DROP TABLE IF EXISTS `rolesusuario`;
CREATE TABLE `rolesusuario` (
  `Usuario` varchar(15) NOT NULL,
  `Rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `Usuario` varchar(15) NOT NULL,
  `Contraseña` varchar(70) NOT NULL,
  `Nombre` varchar(15) NOT NULL,
  `Apellidos` varchar(15) NOT NULL,
  `Dirección` varchar(30) NOT NULL,
  `Teléfono` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `transaccion`
--
ALTER TABLE `transaccion`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDComprador` (`IDComprador`),
  ADD KEY `IDVendedor` (`IDVendedor`),
  ADD KEY `IDProducto` (`IDProducto`),
  ADD KEY `Admin` (`Admin`);

--
-- Indices de la tabla `conversacion`
--
ALTER TABLE `conversacion`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Usuario1` (`Usuario1`),
  ADD KEY `Usuario2` (`Usuario2`),
  ADD KEY `IDMensaje` (`IDMensaje`),
  ADD KEY `Admin` (`Admin`);

--
-- Indices de la tabla `foro`
--
ALTER TABLE `foro`
  ADD PRIMARY KEY (`IDForo`),
  ADD KEY `IDUsuario` (`IDUsuario`),
  ADD KEY `IDMensaje` (`IDMensaje`),
  ADD KEY `Admin/Mod` (`Admin/Mod`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Precio` (`Precio`),
  ADD KEY `Nombre` (`Nombre`),
  ADD KEY `Tipo` (`Tipo`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Nombre` (`Nombre`);

--
-- Indices de la tabla `rolesusuario`
--
ALTER TABLE `rolesusuario`
  ADD PRIMARY KEY (`Usuario`,`Rol`),
  ADD KEY `rol` (`Rol`);

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
-- AUTO_INCREMENT de la tabla `transaccion`
--
ALTER TABLE `transaccion`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `conversacion`
--
ALTER TABLE `conversacion`
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
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `transaccion`
--
ALTER TABLE `transaccion`
  ADD CONSTRAINT `transaccion_ibfk_1` FOREIGN KEY (`IDComprador`) REFERENCES `usuario` (`Usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `transaccion_ibfk_2` FOREIGN KEY (`IDVendedor`) REFERENCES `usuario` (`Usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `transaccion_ibfk_3` FOREIGN KEY (`IDProducto`) REFERENCES `producto` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `transaccion_ibfk_4` FOREIGN KEY (`Admin`) REFERENCES `usuario` (`Usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `conversacion`
--
ALTER TABLE `conversacion`
  ADD CONSTRAINT `conversacion_ibfk_1` FOREIGN KEY (`IDMensaje`) REFERENCES `mensaje` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `conversacion_ibfk_2` FOREIGN KEY (`Usuario1`) REFERENCES `usuario` (`Usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `conversacion_ibfk_3` FOREIGN KEY (`Usuario2`) REFERENCES `usuario` (`Usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `conversacion_ibfk_4` FOREIGN KEY (`Admin`) REFERENCES `usuario` (`Usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `foro`
--
ALTER TABLE `foro`
  ADD CONSTRAINT `foro_ibfk_1` FOREIGN KEY (`IDMensaje`) REFERENCES `mensaje` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `foro_ibfk_2` FOREIGN KEY (`IDUsuario`) REFERENCES `usuario` (`Usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `foro_ibfk_3` FOREIGN KEY (`Admin/Mod`) REFERENCES `usuario` (`Usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `rolesusuario`
--
ALTER TABLE `rolesusuario`
  ADD CONSTRAINT `rolesusuario_ibfk_1` FOREIGN KEY (`Usuario`) REFERENCES `usuario` (`Usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `rolesusuario_ibfk_2` FOREIGN KEY (`Rol`) REFERENCES `roles` (`ID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
