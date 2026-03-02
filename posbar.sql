-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para posbar
CREATE DATABASE IF NOT EXISTS `posbar` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci */;
USE `posbar`;

-- Volcando estructura para tabla posbar.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL DEFAULT '0',
  `estado` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla posbar.categorias: ~6 rows (aproximadamente)
INSERT INTO `categorias` (`id_categoria`, `descripcion`, `estado`) VALUES
	(1, 'alcoholicas', 1),
	(2, 'energizantes', 1),
	(3, 'hidratantes', 1),
	(4, 'comidas', 1),
	(5, 'drogas', 1),
	(6, 'OTROS', 0);

-- Volcando estructura para tabla posbar.movimiento
CREATE TABLE IF NOT EXISTS `movimiento` (
  `id_movimiento` int(11) NOT NULL AUTO_INCREMENT,
  `id_factura` int(11) NOT NULL,
  `tipo_transaccion` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 0,
  `precio_unitario` double NOT NULL DEFAULT 0,
  `total` double NOT NULL DEFAULT 0,
  `descripcion` varchar(50) DEFAULT '',
  PRIMARY KEY (`id_movimiento`),
  KEY `FK_movimiento_tipo_transaccion` (`tipo_transaccion`),
  KEY `FK_movimiento_productos` (`producto_id`),
  CONSTRAINT `FK_movimiento_productos` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_movimiento_tipo_transaccion` FOREIGN KEY (`tipo_transaccion`) REFERENCES `tipo_transaccion` (`id_transaccion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla posbar.movimiento: ~39 rows (aproximadamente)

-- Volcando estructura para tabla posbar.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_producto` varchar(50) NOT NULL DEFAULT '0',
  `categoria` int(11) NOT NULL DEFAULT 0,
  `estado` int(11) NOT NULL DEFAULT 0,
  `cantidad_existente` int(11) NOT NULL DEFAULT 0,
  `precio_unitario` double NOT NULL DEFAULT 0,
  `minimo_stock` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_producto`),
  KEY `FK_productos_categorias` (`categoria`),
  CONSTRAINT `FK_productos_categorias` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla posbar.productos: ~13 rows (aproximadamente)

-- Volcando estructura para tabla posbar.tipo_transaccion
CREATE TABLE IF NOT EXISTS `tipo_transaccion` (
  `id_transaccion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_transaccion`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla posbar.tipo_transaccion: ~4 rows (aproximadamente)
INSERT INTO `tipo_transaccion` (`id_transaccion`, `descripcion`) VALUES
	(1, 'venta'),
	(2, 'egreso'),
	(3, 'insumo'),
	(4, 'perdida');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
