-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 14-05-2023 a las 02:41:27
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- CREATE DATABASE IF NOT EXISTS `matriculacionvehicular` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci;
USE `matriculacionVehicular`;
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agencia`
--

DROP TABLE IF EXISTS `agencia`;
CREATE TABLE IF NOT EXISTS `agencia` (
  `id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `direccion` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `telefono` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `horainicio` time NOT NULL,
  `horafin` time NOT NULL,
  `foto` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `agencia`
--

INSERT INTO `agencia` (`id`, `descripcion`, `direccion`, `telefono`, `horainicio`, `horafin`, `foto`) VALUES
(1, 'Los Chillos', 'Gnral. Rumiñahui', '6054874', '00:00:00', '00:00:00', ''),
(2, 'Cotocollao', 'La prensa', '6048754', '00:00:00', '00:00:00', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `color`
--

DROP TABLE IF EXISTS `color`;
CREATE TABLE IF NOT EXISTS `color` (
  `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `color`
--

INSERT INTO `color` (`id`, `descripcion`) VALUES
(2, 'Negro'),
(3, 'Rojo'),
(4, 'Azul'),
(5, 'Plomo'),
(6, 'Verde'),
(7, 'Negro'),
(8, 'Plata'),
(9, 'Morado'),
(10, 'Naranja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

DROP TABLE IF EXISTS `marca`;
CREATE TABLE IF NOT EXISTS `marca` (
  `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `pais` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `direccion` varchar(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `foto` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id`, `descripcion`, `pais`, `direccion`, `foto`) VALUES
(1, 'Chévrolet', 'USA', NULL, NULL),
(2, 'Fiat', 'Italia', NULL, NULL),
(4, 'Great Wall', 'China', NULL, NULL),
(5, 'Toyota', 'Japón', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matricula`
--

DROP TABLE IF EXISTS `matricula`;
CREATE TABLE IF NOT EXISTS `matricula` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `vehiculo` mediumint UNSIGNED NOT NULL,
  `agencia` tinyint UNSIGNED NOT NULL,
  `anio` year NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vehiculo` (`vehiculo`),
  KEY `agencia` (`agencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

DROP TABLE IF EXISTS `vehiculo`;
CREATE TABLE IF NOT EXISTS `vehiculo` (
  `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT,
  `placa` char(7) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `marca` smallint UNSIGNED NOT NULL,
  `motor` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `chasis` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `combustible` enum('Gasolina','Diesel','Eléctrico') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `anio` year NOT NULL,
  `color` smallint UNSIGNED NOT NULL,
  `foto` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `avaluo` decimal(8,2) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `marca` (`marca`),
  KEY `color` (`color`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`id`, `placa`, `marca`, `motor`, `chasis`, `combustible`, `anio`, `color`, `foto`, `avaluo`) VALUES
(1, 'PCH3465', 1, 'dede', 'Dede', 'Gasolina', 2017, 2, 'prkruMMZOugQ.jpg', '25415.00'),
(2, 'PHH2354', 1, 'sswe', 'eddede', 'Gasolina', 1962, 6, 'wDDhfbYRIxxN.jpg', '23541.36'),
(3, 'CHH3465', 5, 'edcdede', 'Dedede', 'Gasolina', 2017, 10, 'QaJKsieMgreb.jpg', '25412.00');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `matricula`
--
ALTER TABLE `matricula`
  ADD CONSTRAINT `matricula_agencia` FOREIGN KEY (`agencia`) REFERENCES `agencia` (`id`),
  ADD CONSTRAINT `matricula_vehiculo` FOREIGN KEY (`vehiculo`) REFERENCES `vehiculo` (`id`);

--
-- Filtros para la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD CONSTRAINT `vehiculo_color` FOREIGN KEY (`color`) REFERENCES `color` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vehiculo_marca` FOREIGN KEY (`marca`) REFERENCES `marca` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
