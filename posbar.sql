-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla posbar.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL DEFAULT '0',
  `estado` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla posbar.categorias: ~6 rows (aproximadamente)
INSERT INTO `categorias` (`id_categoria`, `descripcion`, `estado`) VALUES
	(4, 'comidas', 1),
	(5, 'drogas', 1),
	(6, 'OTROS', 0),
	(7, 'alcoholicas', 1),
	(8, 'energizantes', 1),
	(9, 'hidratantes', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla posbar.movimiento: ~0 rows (aproximadamente)

-- Volcando estructura para tabla posbar.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_producto` varchar(50) NOT NULL DEFAULT '0',
  `categoria` int(11) NOT NULL DEFAULT 0,
  `estado` int(11) NOT NULL DEFAULT 0,
  `cantidad_existente` int(11) NOT NULL DEFAULT 0,
  `precio_unitario` double NOT NULL DEFAULT 0,
  `minimo_stock` int(11) NOT NULL DEFAULT 0,
  `codigo` double NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_producto`),
  KEY `FK_productos_categorias` (`categoria`),
  CONSTRAINT `FK_productos_categorias` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla posbar.productos: ~36 rows (aproximadamente)
INSERT INTO `productos` (`id_producto`, `nombre_producto`, `categoria`, `estado`, `cantidad_existente`, `precio_unitario`, `minimo_stock`, `codigo`) VALUES
	(3, 'cocacola 1.5 lt', 9, 1, 0, 7000, 0, 7709183732),
	(4, 'coca cola 1 lt', 9, 1, 0, 5000, 0, 7709183733),
	(5, 'coca cola 400 mg', 9, 1, 0, 3000, 0, 7709183734),
	(6, 'soda personal', 9, 1, 0, 3000, 0, 7709183735),
	(7, 'botella de agua', 9, 1, 0, 2500, 0, 7709183736),
	(8, 'btella de agua Gas', 9, 1, 0, 2500, 0, 7709183737),
	(9, 'jarra guarapo', 9, 1, 0, 5000, 0, 7709183738),
	(10, 'jarra limonada', 9, 1, 0, 5000, 0, 7709183739),
	(11, 'cerveza personal', 9, 1, 0, 4000, 0, 7709183740),
	(12, 'cerveza six', 9, 1, 0, 24000, 0, 7709183741),
	(13, 'jarra guarapo grande', 9, 1, 0, 7000, 0, 7709183744),
	(14, 'jarra limonada grande', 9, 1, 0, 7000, 0, 7709183745),
	(15, 'vaso limonada', 9, 1, 0, 2000, 0, 7709183750),
	(16, 'vaso guarapo', 9, 1, 0, 2000, 0, 7709183751),
	(17, 'tinto grande', 9, 1, 0, 2000, 0, 7709183754),
	(18, 'tinto pequeño', 9, 1, 0, 1500, 0, 7709183755),
	(19, 'Chicharrón 20k', 7, 1, 0, 20000, 0, 7709183720),
	(20, 'Chicharrón 25k', 7, 1, 0, 25000, 0, 7709183721),
	(21, 'Chicharrón 30k', 7, 1, 0, 30000, 0, 7709183722),
	(22, 'Chicharrón 35k', 7, 1, 0, 35000, 0, 7709183723),
	(23, 'costillitas', 7, 1, 0, 25000, 0, 7709183728),
	(24, 'salchicharron', 7, 1, 0, 30000, 0, 7709183730),
	(25, 'pulpo', 7, 1, 0, 60000, 0, 7709183731),
	(26, 'porcheta 60k', 7, 1, 0, 60000, 0, 7709183742),
	(27, 'porcheta 50k', 7, 1, 0, 50000, 0, 7709183743),
	(28, 'bastimento', 7, 1, 0, 14000, 0, 7709183746),
	(29, 'empanada chicharron', 7, 1, 0, 3000, 0, 7709183747),
	(30, 'empanada pollo', 7, 1, 0, 3000, 0, 7709183748),
	(31, 'marranitas', 7, 1, 0, 3500, 0, 7709183749),
	(32, 'vastimento con arepa', 7, 1, 0, 18000, 0, 7709183752),
	(33, 'carimañola chicharron', 7, 1, 0, 3500, 0, 7709183753),
	(34, 'guacamole', 8, 1, 0, 2000, 0, 7709183724),
	(35, 'patacones', 8, 1, 0, 3000, 0, 7709183725),
	(36, 'yuca', 8, 1, 0, 2000, 0, 7709183726),
	(37, 'papa frita', 8, 1, 0, 5000, 0, 7709183727),
	(38, 'ensalada', 8, 1, 0, 3000, 0, 7709183729);

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
