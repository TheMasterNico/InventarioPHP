-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 31-12-2014 a las 01:17:46
-- Versión del servidor: 5.6.12-log
-- Versión de PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `inventario`
--
CREATE DATABASE IF NOT EXISTS `inventario` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `inventario`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE IF NOT EXISTS `almacen` (
  `Referencia` varchar(40) NOT NULL COMMENT 'Identificación',
  `Nombre` varchar(64) NOT NULL COMMENT 'Nombre del producto',
  `Descripcion` varchar(256) NOT NULL COMMENT 'Descripcion del producto',
  `Cantidad` int(12) NOT NULL COMMENT 'Cantidad actual en el almacen',
  `Precio` int(12) NOT NULL COMMENT 'Precio por Unidad',
  PRIMARY KEY (`Referencia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros`
--

CREATE TABLE IF NOT EXISTS `registros` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Referencia` varchar(40) NOT NULL,
  `Nombre` varchar(64) NOT NULL,
  `Entrada` int(12) NOT NULL DEFAULT '0' COMMENT 'Cuantos entran',
  `Proveedor` varchar(64) NOT NULL COMMENT 'Quien es el que lo vende',
  `PrecioTotal` int(15) NOT NULL COMMENT 'El precio por el que entro total',
  `PrecioUnidad` int(15) NOT NULL COMMENT 'Precio por unidad que entra',
  `Salida` int(11) NOT NULL DEFAULT '0',
  `DescT` int(11) NOT NULL,
  `DescU` int(11) NOT NULL,
  `Tipo` int(11) NOT NULL DEFAULT '0',
  `Recibido` int(15) NOT NULL DEFAULT '0',
  `PrecioTotalVenta` int(15) NOT NULL,
  `Fecha` int(12) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
