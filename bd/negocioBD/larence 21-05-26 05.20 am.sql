-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2026 a las 11:19:04
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
-- Base de datos: `larence`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`, `status`) VALUES
(1, 'Galletas', 1),
(2, 'Postres', 1),
(3, 'Reposteria', 1),
(4, 'Electrodomesticos', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `tipo_id` varchar(11) NOT NULL,
  `id_tipo_cliente` int(11) DEFAULT NULL,
  `nombre_cliente` varchar(100) NOT NULL,
  `direccion_cliente` varchar(100) NOT NULL,
  `tlf_cliente` varchar(11) NOT NULL,
  `email_cliente` varchar(100) NOT NULL,
  `estado_cliente` varchar(100) NOT NULL,
  `img_cliente` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `tipo_id`, `id_tipo_cliente`, `nombre_cliente`, `direccion_cliente`, `tlf_cliente`, `email_cliente`, `estado_cliente`, `img_cliente`, `status`) VALUES
(1234567, 'J', 2, 'Elite super', 'Andres Eloy carrera 6 calle 11', '04162372439', 'elite@gmail.com', 'Activo', 'assets/img/clientes/php.png', 1),
(32200771, 'J', 3, 'Mi Super ca', 'Cale 54 con Carrera 20', '02514408820', 'misuper@gmail.com', 'Activo', 'assets/img/clientes/miSuper.png', 1),
(171009981, 'J', 2, 'Farmatodo', 'Av Pedro leon con calle 54', '02511358621', 'farmatodo@gmail.com', 'Anulado', 'assets/img/clientes/farmatodo.png', 1),
(176263540, 'J', 2, 'Forum', 'Av Libertador con calle 51 CC Babilon', '02512372439', 'forum@gmail.com', 'Activo', 'assets/img/clientes/forum.jpg', 0),
(310398110, 'J', 4, 'PaTodo', 'Av Urb Patarata con Calle 20', '02513213495', 'patodo@gmail.com', 'Pendiente', 'assets/img/clientes/patodo.jpg', 1),
(322007710, 'J', 2, 'Hause ca', 'Cale 54 con Carrera 20', '02514408820', 'hause@gmail.com', 'Activo', 'assets/img/clientes/logo php.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id_compra` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `fecha_compra` datetime(6) NOT NULL,
  `monto_total_compra` float(11,2) NOT NULL,
  `id_tasa` int(11) NOT NULL,
  `id_estado_pago` int(11) NOT NULL,
  `observaciones` varchar(300) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id_compra`, `id_proveedor`, `fecha_compra`, `monto_total_compra`, `id_tasa`, `id_estado_pago`, `observaciones`, `status`) VALUES
(1, 310397110, '2026-05-13 00:00:00.000000', 155.00, 2, 1, 'Prueba compra', 1),
(2, 322007710, '2026-05-13 00:00:00.000000', 40.00, 2, 2, 'Abastecimiento', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta_x_cobrar`
--

CREATE TABLE `cuenta_x_cobrar` (
  `id_cuenta_x_cobrar` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `monto_total` float(11,2) NOT NULL,
  `saldo_pendiente` float(11,2) NOT NULL,
  `fecha_emision` date NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `estado_cuenta` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `cuenta_x_cobrar`
--

INSERT INTO `cuenta_x_cobrar` (`id_cuenta_x_cobrar`, `id_pedido`, `id_cliente`, `monto_total`, `saldo_pendiente`, `fecha_emision`, `fecha_vencimiento`, `estado_cuenta`, `status`) VALUES
(1, 12, 1234567, 6.25, 0.00, '2026-05-07', '2026-05-22', 'Pagado', 1),
(2, 13, 1234567, 17.50, 0.00, '2026-05-07', '2026-05-22', 'Pagado', 1),
(3, 14, 32200771, 6.50, 6.50, '2026-05-12', '2026-06-11', 'Por Pagar', 1),
(4, 15, 310398110, 6.00, 3.00, '2026-05-13', '2026-06-12', 'Por Pagar', 1),
(5, 16, 322007710, 15.00, 15.00, '2026-05-13', '2026-05-28', 'Por Pagar', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta_x_pagar`
--

CREATE TABLE `cuenta_x_pagar` (
  `id_cuenta_x_pagar` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `monto_total` float(11,2) NOT NULL,
  `saldo_pendiente` float(11,2) NOT NULL,
  `fecha_emision` datetime(6) NOT NULL,
  `fecha_vencimiento` datetime(6) NOT NULL,
  `estado_pago` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `cuenta_x_pagar`
--

INSERT INTO `cuenta_x_pagar` (`id_cuenta_x_pagar`, `id_compra`, `id_proveedor`, `monto_total`, `saldo_pendiente`, `fecha_emision`, `fecha_vencimiento`, `estado_pago`, `status`) VALUES
(1, 1, 310397110, 155.00, 100.00, '2026-05-13 00:00:00.000000', '2026-06-12 00:00:00.000000', 'Por Pagar', 1),
(2, 2, 322007710, 40.00, 0.00, '2026-05-13 00:00:00.000000', '2026-06-12 00:00:00.000000', 'Pagado', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `id_detalle_compra` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_materia_prima` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` float(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `detalle_compras`
--

INSERT INTO `detalle_compras` (`id_detalle_compra`, `id_compra`, `id_materia_prima`, `cantidad`, `precio_unitario`) VALUES
(1, 1, 2, 10, 5.00),
(2, 1, 4, 15, 7.00),
(3, 2, 3, 10, 4.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedidos`
--

CREATE TABLE `detalle_pedidos` (
  `id_detalle_pedido` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` float(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `detalle_pedidos`
--

INSERT INTO `detalle_pedidos` (`id_detalle_pedido`, `id_pedido`, `id_producto`, `cantidad`, `precio_unitario`) VALUES
(1, 6, 3, 2, 3.50),
(2, 6, 8, 4, 10.00),
(3, 7, 8, 4, 5.00),
(4, 7, 3, 4, 14.00),
(5, 8, 3, 4, 14.00),
(6, 8, 4, 1, 2.50),
(7, 9, 8, 5, 6.25),
(8, 10, 8, 5, 6.25),
(9, 11, 3, 2, 3.50),
(10, 11, 8, 5, 12.50),
(11, 12, 8, 5, 6.25),
(12, 13, 3, 5, 17.50),
(13, 14, 2, 1, 1.50),
(14, 14, 8, 2, 5.00),
(15, 15, 3, 2, 3.50),
(16, 15, 8, 1, 2.50),
(17, 16, 2, 10, 15.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_producciones`
--

CREATE TABLE `detalle_producciones` (
  `id_detalle_produccion` int(11) NOT NULL,
  `id_produccion` int(11) NOT NULL,
  `id_materia_prima` int(11) NOT NULL,
  `cantidad_utilizada` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `detalle_producciones`
--

INSERT INTO `detalle_producciones` (`id_detalle_produccion`, `id_produccion`, `id_materia_prima`, `cantidad_utilizada`) VALUES
(2, 3, 1, 5),
(3, 3, 2, 10),
(4, 3, 3, 10),
(5, 3, 4, 4),
(6, 4, 1, 15),
(7, 4, 2, 15),
(8, 4, 3, 5),
(9, 4, 4, 13),
(10, 5, 1, 5),
(11, 5, 2, 5),
(12, 5, 3, 5),
(13, 5, 4, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_promocion`
--

CREATE TABLE `detalle_promocion` (
  `id_detalle_promocion` int(11) NOT NULL,
  `id_promocion` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `detalle_promocion`
--

INSERT INTO `detalle_promocion` (`id_detalle_promocion`, `id_promocion`, `id_producto`) VALUES
(10, 3, 8),
(11, 3, 9),
(12, 4, 3),
(13, 5, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregas`
--

CREATE TABLE `entregas` (
  `id_entregas` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_clientes` int(11) NOT NULL,
  `fecha_entrega_programada` date NOT NULL,
  `fecha_entrega_real` date DEFAULT NULL,
  `direccion_entrega` int(11) NOT NULL,
  `id_estado_entrega` int(11) NOT NULL,
  `tlf_contacto` varchar(11) NOT NULL,
  `repartidor` varchar(200) NOT NULL,
  `observaciones` varchar(300) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `entregas`
--

INSERT INTO `entregas` (`id_entregas`, `id_pedido`, `id_clientes`, `fecha_entrega_programada`, `fecha_entrega_real`, `direccion_entrega`, `id_estado_entrega`, `tlf_contacto`, `repartidor`, `observaciones`, `status`) VALUES
(2, 7, 310398110, '2026-05-14', '2026-05-16', 0, 1, '', '', '', 1),
(3, 7, 310398110, '2026-05-14', NULL, 0, 1, '', '', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_entrega`
--

CREATE TABLE `estado_entrega` (
  `id_estado_entrega` int(11) NOT NULL,
  `nombre_estado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `estado_entrega`
--

INSERT INTO `estado_entrega` (`id_estado_entrega`, `nombre_estado`) VALUES
(1, 'Entregado'),
(2, 'En ruta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_pago`
--

CREATE TABLE `estado_pago` (
  `id_estado_pago` int(11) NOT NULL,
  `nombre_estado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `estado_pago`
--

INSERT INTO `estado_pago` (`id_estado_pago`, `nombre_estado`) VALUES
(1, 'Por Pagar'),
(2, 'Pagado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_pedido`
--

CREATE TABLE `estado_pedido` (
  `id_estado_pedido` int(11) NOT NULL,
  `nombre_estado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `estado_pedido`
--

INSERT INTO `estado_pedido` (`id_estado_pedido`, `nombre_estado`) VALUES
(1, 'Pendiente'),
(2, 'Procesando'),
(3, 'Por Enviar'),
(4, 'Por Pagar'),
(5, 'Entregado'),
(6, 'Pagado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia_prima`
--

CREATE TABLE `materia_prima` (
  `id_materia_prima` int(11) NOT NULL,
  `nombre_materia_prima` varchar(100) NOT NULL,
  `descripcion_materia_prima` varchar(100) NOT NULL,
  `id_unidad_medida` int(11) NOT NULL,
  `stock_actual` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `materia_prima`
--

INSERT INTO `materia_prima` (`id_materia_prima`, `nombre_materia_prima`, `descripcion_materia_prima`, `id_unidad_medida`, `stock_actual`, `id_proveedor`, `status`) VALUES
(1, 'Harina de Trigo', 'Harina de trigo para la elaboracion de galletas secas y polvorosas', 1, 75, 171009980, 1),
(2, 'Huevos', 'Elaboracion de galletas a base de huevo', 8, 45, 310397110, 1),
(3, 'Leche', 'Para elaboracion de galletas humedas', 5, 35, 322007710, 1),
(4, 'Azucar Nevada', 'Para la dulcura de las galletas de limon', 1, 30, 310397110, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_pago`
--

CREATE TABLE `metodos_pago` (
  `id_metodo_pago` int(11) NOT NULL,
  `nombre_metodo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `metodos_pago`
--

INSERT INTO `metodos_pago` (`id_metodo_pago`, `nombre_metodo`) VALUES
(1, 'Transferencia'),
(2, 'Pago Movil'),
(3, 'Efectivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `monto_pago` float(11,2) NOT NULL,
  `fecha_pago` datetime(6) NOT NULL,
  `nro_referencia` varchar(11) NOT NULL,
  `concepto` varchar(200) NOT NULL,
  `id_metodo_pago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id_pago`, `id_pedido`, `monto_pago`, `fecha_pago`, `nro_referencia`, `concepto`, `id_metodo_pago`) VALUES
(1, 13, 7.50, '2026-05-12 00:00:00.000000', '45546674353', 'Abono de deuda', 1),
(2, 13, 6.25, '2026-05-12 00:00:00.000000', '23445546788', 'Pago completo de la deuda', 1),
(3, 12, 6.25, '2026-05-12 00:00:00.000000', '34534554354', 'Pago Deuda', 1),
(4, 13, 3.75, '2026-05-12 00:00:00.000000', '12323123232', 'Pago de la deuda', 1),
(7, 15, 3.00, '2026-05-13 00:00:00.000000', '45235234523', 'Pago', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos_proveedores`
--

CREATE TABLE `pagos_proveedores` (
  `id_pago_proveedor` int(11) NOT NULL,
  `id_cuenta_x_pagar` int(11) NOT NULL,
  `monto` float(11,2) NOT NULL,
  `fecha_pago` float NOT NULL,
  `id_metodo_pago` int(11) NOT NULL,
  `nro_referencia` text NOT NULL,
  `concepto` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `pagos_proveedores`
--

INSERT INTO `pagos_proveedores` (`id_pago_proveedor`, `id_cuenta_x_pagar`, `monto`, `fecha_pago`, `id_metodo_pago`, `nro_referencia`, `concepto`) VALUES
(1, 1, 55.00, 2026, 1, '45356356546', 'Prueba pago deuda proveedor'),
(2, 2, 40.00, 2026, 1, '98734545908', 'Pago deuda total a proveedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha_pedido` datetime(6) NOT NULL,
  `id_estado_pedido` int(11) NOT NULL,
  `id_estado_pago` int(11) NOT NULL,
  `monto_total_pedido` float(11,2) NOT NULL,
  `direccion_entrega` varchar(200) NOT NULL,
  `tlf_contacto` varchar(11) NOT NULL,
  `observaciones` varchar(250) NOT NULL,
  `id_promocion` int(11) DEFAULT NULL,
  `id_tasa` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_cliente`, `fecha_pedido`, `id_estado_pedido`, `id_estado_pago`, `monto_total_pedido`, `direccion_entrega`, `tlf_contacto`, `observaciones`, `id_promocion`, `id_tasa`, `status`) VALUES
(6, 32200771, '2026-05-06 00:00:00.000000', 1, 1, 13.50, 'calle 1 las delicias', '0416-321349', 'pedido prueba', 4, 2, 1),
(7, 310398110, '2026-05-06 00:00:00.000000', 1, 1, 19.00, 'Av princival las delicias final de la carrera 11', '0426-321349', 'prueba nuemro 2 del pedido', 5, 2, 1),
(8, 32200771, '2026-05-07 00:00:00.000000', 5, 1, 16.50, 'av la salle con horcone', '0416-440882', 'prueba de pedido sin promo y con edicion', NULL, 2, 1),
(9, 310398110, '2026-05-07 00:00:00.000000', 5, 1, 6.25, 'calle principal', '0426-321349', 'con promo', 5, 2, 1),
(10, 310398110, '2026-05-07 00:00:00.000000', 1, 1, 6.25, 'calle principal', '0426-321349', 'con promo', 5, 2, 1),
(11, 1234567, '2026-05-07 00:00:00.000000', 1, 1, 16.00, 'calle 9 con carrera 2', '0426-321349', 'pedido bajo credito', 4, 2, 1),
(12, 1234567, '2026-05-07 00:00:00.000000', 1, 2, 6.25, 'calle 1 con carrera 2', '0426-321349', 'pedido bajo credito y con promocion', 5, 2, 1),
(13, 1234567, '2026-05-07 00:00:00.000000', 1, 2, 17.50, 'calle 10', '0426-321349', 'pedido bajo credito sin promocion', NULL, 2, 1),
(14, 32200771, '2026-05-12 00:00:00.000000', 1, 1, 6.50, 'Av libertador', '0416-440882', 'pedido bajo demanda', NULL, 2, 1),
(15, 310398110, '2026-05-13 00:00:00.000000', 1, 1, 6.00, 'calle 11', '0416-440882', 'pedido unico', 4, 2, 1),
(16, 322007710, '2026-05-13 00:00:00.000000', 1, 1, 15.00, 'carrera 11', '0426-321349', 'pedido primario', NULL, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producciones`
--

CREATE TABLE `producciones` (
  `id_produccion` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_producida` int(11) NOT NULL,
  `fecha_produccion` date NOT NULL,
  `motivo_produccion` varchar(100) NOT NULL,
  `observacion` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `producciones`
--

INSERT INTO `producciones` (`id_produccion`, `id_producto`, `cantidad_producida`, `fecha_produccion`, `motivo_produccion`, `observacion`, `status`) VALUES
(3, 8, 10, '2026-04-29', 'para stock', 'produccion encargo del supervicion de prueba', 0),
(4, 8, 20, '2026-04-30', 'para stock', 'produccion encargo del supervicion de prueba', 1),
(5, 2, 10, '2026-04-30', 'para abastecimiento de Stock', 'produccion de pueba a cargo del supervisor nuevo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(100) NOT NULL,
  `precio_venta` float(11,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `fecha_registro` date NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `precio_venta`, `stock`, `fecha_registro`, `fecha_vencimiento`, `id_categoria`, `img`, `status`) VALUES
(2, 'Galletas Natys dulces con sabor a Naranja 90g cont', 1.50, 9, '2026-04-02', '2026-04-30', 2, 'assets/img/productos/img6.png', 1),
(3, 'Galletas dulces Natys con sabor a coco 90g cont', 3.50, 37, '2026-04-02', '2026-05-30', 1, 'assets/img/productos/img1.png', 1),
(4, 'Gatelltas Natys Chocoking 40g cont', 2.50, 45, '2026-04-02', '2026-05-30', 1, 'assets/img/productos/img2.png', 1),
(5, 'Galletas Natys Saladitas queso chedar 90g cont', 2.00, 25, '2026-04-02', '2026-05-30', 1, 'assets/img/productos/img3.png', 1),
(6, 'Gatellas Natys Polvosas con sabor a vainilla 90g cont', 2.50, 28, '2026-04-03', '2026-05-30', 1, 'assets/img/productos/img3.png', 1),
(7, 'Galletas Natys dulces con sabor a Limon 90g cont', 1.50, 60, '2026-04-03', '2026-05-30', 1, 'assets/img/productos/img5.png', 1),
(8, 'Galletas Natys dulces con sabor a Colita 90g Cont', 2.50, 3, '2026-04-03', '2026-05-30', 1, 'assets/img/productos/img4.png', 1),
(9, 'Elefante Php laravel', 1.20, 59, '2026-04-12', '2026-05-30', 1, 'assets/img/productos/php.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

CREATE TABLE `promociones` (
  `id_promocion` int(11) NOT NULL,
  `nombre_promocion` varchar(100) NOT NULL,
  `descripcion_promocion` varchar(100) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `tipo_descuento` varchar(100) NOT NULL,
  `valor_descuento` float(11,2) NOT NULL,
  `estado` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `promociones`
--

INSERT INTO `promociones` (`id_promocion`, `nombre_promocion`, `descripcion_promocion`, `fecha_inicio`, `fecha_fin`, `tipo_descuento`, `valor_descuento`, `estado`, `status`) VALUES
(3, 'Galletas sabor vainilla y limon 10% de descuentos', 'En todas las Galletas con sabor a vainilla y limon tendran un  descuento del 10%', '2026-05-04', '2026-05-07', 'porcentaje', 10.00, 0, 1),
(4, '2x1 en Galletas sabor a coco', 'En la compra de 2 galletas sabor a coco el precio te queda en 1', '2026-05-02', '2026-05-07', '2x1', 2.00, 0, 1),
(5, 'Galletas sabor a colita 50% de descuentos', 'L Galleta sabor a colita tendra un descuento de hasta el 50%', '2026-05-05', '2026-05-08', 'porcentaje', 49.99, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `tipo_id` varchar(11) NOT NULL,
  `nombre_proveedor` varchar(100) NOT NULL,
  `direccion_proveedor` varchar(100) NOT NULL,
  `tlf_proveedor` varchar(11) NOT NULL,
  `email_proveedor` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `tipo_id`, `nombre_proveedor`, `direccion_proveedor`, `tlf_proveedor`, `email_proveedor`, `status`) VALUES
(12321234, 'J-', 'La Polar CA', 'Zona industrial II calle 1 carrera 4 4b', '02513213490', 'lapolar@gmail.com', 1),
(12345321, 'J-', 'Amazon', 'Zona industrial II calle 1 carrera 1', '02123213490', 'amazon@gmail.com', 1),
(171009980, 'J-', 'La Especial ca', 'Zona industrial II calle 4', '02514408820', 'Laespecial@gmail.com', 1),
(301234543, 'J-', 'La Nestle CA', 'Carrera 21 con calle 29 y 22', '02513213499', 'nestle@gmail.com', 1),
(310397110, 'J-', 'Distribuidor la 21ca', 'Carrera 21 con calle 29 y 30', '02513213495', 'Dis21ca@gmail.com', 1),
(322007710, 'J-', 'La Friz ca', 'Zona industrial II calle 9', '02511358622', 'Lafriz@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasa_dia`
--

CREATE TABLE `tasa_dia` (
  `id_tasa` int(11) NOT NULL,
  `monto_tasa` float(11,2) NOT NULL,
  `fecha_tasa` datetime(6) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tasa_dia`
--

INSERT INTO `tasa_dia` (`id_tasa`, `monto_tasa`, `fecha_tasa`, `status`) VALUES
(1, 484.74, '2026-04-27 12:17:28.000000', 1),
(2, 486.20, '2026-04-29 09:32:55.000000', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_clientes`
--

CREATE TABLE `tipos_clientes` (
  `id_tipo_cliente` int(11) NOT NULL,
  `nombre_tipo_cliente` varchar(100) NOT NULL,
  `dias_credito` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tipos_clientes`
--

INSERT INTO `tipos_clientes` (`id_tipo_cliente`, `nombre_tipo_cliente`, `dias_credito`, `status`) VALUES
(1, 'Bodegas', 7, 1),
(2, 'Empresas', 15, 1),
(3, 'Distribuidores', 30, 1),
(4, 'Sucursales', 30, 1),
(5, 'Abastos', 15, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_medidas`
--

CREATE TABLE `unidad_medidas` (
  `id_unidad_medida` int(11) NOT NULL,
  `nombre_medida` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `unidad_medidas`
--

INSERT INTO `unidad_medidas` (`id_unidad_medida`, `nombre_medida`) VALUES
(1, 'Sacos'),
(2, 'Bultos'),
(3, 'Kilogramos'),
(4, 'Gramos'),
(5, 'Litros'),
(6, 'Mililitros'),
(7, 'Galon'),
(8, 'Cajas');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `id_tipo_cliente` (`id_tipo_cliente`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `id_tasa` (`id_tasa`),
  ADD KEY `id_estado_pago` (`id_estado_pago`);

--
-- Indices de la tabla `cuenta_x_cobrar`
--
ALTER TABLE `cuenta_x_cobrar`
  ADD PRIMARY KEY (`id_cuenta_x_cobrar`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `cuenta_x_pagar`
--
ALTER TABLE `cuenta_x_pagar`
  ADD PRIMARY KEY (`id_cuenta_x_pagar`),
  ADD KEY `id_compra` (`id_compra`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`id_detalle_compra`),
  ADD KEY `id_compra` (`id_compra`),
  ADD KEY `id_materia_prima` (`id_materia_prima`);

--
-- Indices de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD PRIMARY KEY (`id_detalle_pedido`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `detalle_producciones`
--
ALTER TABLE `detalle_producciones`
  ADD PRIMARY KEY (`id_detalle_produccion`),
  ADD KEY `id_produccion` (`id_produccion`),
  ADD KEY `id_materia_prima` (`id_materia_prima`);

--
-- Indices de la tabla `detalle_promocion`
--
ALTER TABLE `detalle_promocion`
  ADD PRIMARY KEY (`id_detalle_promocion`),
  ADD KEY `id_promocion` (`id_promocion`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `entregas`
--
ALTER TABLE `entregas`
  ADD PRIMARY KEY (`id_entregas`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_clientes` (`id_clientes`),
  ADD KEY `id_estado_entrega` (`id_estado_entrega`);

--
-- Indices de la tabla `estado_entrega`
--
ALTER TABLE `estado_entrega`
  ADD PRIMARY KEY (`id_estado_entrega`);

--
-- Indices de la tabla `estado_pago`
--
ALTER TABLE `estado_pago`
  ADD PRIMARY KEY (`id_estado_pago`);

--
-- Indices de la tabla `estado_pedido`
--
ALTER TABLE `estado_pedido`
  ADD PRIMARY KEY (`id_estado_pedido`);

--
-- Indices de la tabla `materia_prima`
--
ALTER TABLE `materia_prima`
  ADD PRIMARY KEY (`id_materia_prima`),
  ADD KEY `id_unidad_medida` (`id_unidad_medida`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  ADD PRIMARY KEY (`id_metodo_pago`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_metodo_pago` (`id_metodo_pago`);

--
-- Indices de la tabla `pagos_proveedores`
--
ALTER TABLE `pagos_proveedores`
  ADD PRIMARY KEY (`id_pago_proveedor`),
  ADD KEY `id_cuenta_x_pagar` (`id_cuenta_x_pagar`),
  ADD KEY `id_metodo_pago` (`id_metodo_pago`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_estado_pedido` (`id_estado_pedido`),
  ADD KEY `id_estado_pago` (`id_estado_pago`),
  ADD KEY `id_tasa` (`id_tasa`),
  ADD KEY `id_promocion` (`id_promocion`);

--
-- Indices de la tabla `producciones`
--
ALTER TABLE `producciones`
  ADD PRIMARY KEY (`id_produccion`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD PRIMARY KEY (`id_promocion`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `tasa_dia`
--
ALTER TABLE `tasa_dia`
  ADD PRIMARY KEY (`id_tasa`);

--
-- Indices de la tabla `tipos_clientes`
--
ALTER TABLE `tipos_clientes`
  ADD PRIMARY KEY (`id_tipo_cliente`);

--
-- Indices de la tabla `unidad_medidas`
--
ALTER TABLE `unidad_medidas`
  ADD PRIMARY KEY (`id_unidad_medida`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=322007711;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cuenta_x_cobrar`
--
ALTER TABLE `cuenta_x_cobrar`
  MODIFY `id_cuenta_x_cobrar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cuenta_x_pagar`
--
ALTER TABLE `cuenta_x_pagar`
  MODIFY `id_cuenta_x_pagar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id_detalle_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  MODIFY `id_detalle_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `detalle_producciones`
--
ALTER TABLE `detalle_producciones`
  MODIFY `id_detalle_produccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `detalle_promocion`
--
ALTER TABLE `detalle_promocion`
  MODIFY `id_detalle_promocion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `entregas`
--
ALTER TABLE `entregas`
  MODIFY `id_entregas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `estado_entrega`
--
ALTER TABLE `estado_entrega`
  MODIFY `id_estado_entrega` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado_pago`
--
ALTER TABLE `estado_pago`
  MODIFY `id_estado_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado_pedido`
--
ALTER TABLE `estado_pedido`
  MODIFY `id_estado_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `materia_prima`
--
ALTER TABLE `materia_prima`
  MODIFY `id_materia_prima` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  MODIFY `id_metodo_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pagos_proveedores`
--
ALTER TABLE `pagos_proveedores`
  MODIFY `id_pago_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `producciones`
--
ALTER TABLE `producciones`
  MODIFY `id_produccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `promociones`
--
ALTER TABLE `promociones`
  MODIFY `id_promocion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=322007711;

--
-- AUTO_INCREMENT de la tabla `tasa_dia`
--
ALTER TABLE `tasa_dia`
  MODIFY `id_tasa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipos_clientes`
--
ALTER TABLE `tipos_clientes`
  MODIFY `id_tipo_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `unidad_medidas`
--
ALTER TABLE `unidad_medidas`
  MODIFY `id_unidad_medida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`id_tipo_cliente`) REFERENCES `tipos_clientes` (`id_tipo_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cuenta_x_cobrar`
--
ALTER TABLE `cuenta_x_cobrar`
  ADD CONSTRAINT `cuenta_x_cobrar_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cuenta_x_pagar`
--
ALTER TABLE `cuenta_x_pagar`
  ADD CONSTRAINT `cuenta_x_pagar_ibfk_1` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id_compra`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD CONSTRAINT `detalle_compras_ibfk_1` FOREIGN KEY (`id_materia_prima`) REFERENCES `materia_prima` (`id_materia_prima`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_compras_ibfk_2` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id_compra`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD CONSTRAINT `detalle_pedidos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_pedidos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_producciones`
--
ALTER TABLE `detalle_producciones`
  ADD CONSTRAINT `detalle_producciones_ibfk_1` FOREIGN KEY (`id_produccion`) REFERENCES `producciones` (`id_produccion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_producciones_ibfk_2` FOREIGN KEY (`id_materia_prima`) REFERENCES `materia_prima` (`id_materia_prima`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_promocion`
--
ALTER TABLE `detalle_promocion`
  ADD CONSTRAINT `detalle_promocion_ibfk_1` FOREIGN KEY (`id_promocion`) REFERENCES `promociones` (`id_promocion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_promocion_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `entregas`
--
ALTER TABLE `entregas`
  ADD CONSTRAINT `entregas_ibfk_1` FOREIGN KEY (`id_estado_entrega`) REFERENCES `estado_entrega` (`id_estado_entrega`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entregas_ibfk_2` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `materia_prima`
--
ALTER TABLE `materia_prima`
  ADD CONSTRAINT `materia_prima_ibfk_1` FOREIGN KEY (`id_unidad_medida`) REFERENCES `unidad_medidas` (`id_unidad_medida`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pagos_ibfk_2` FOREIGN KEY (`id_metodo_pago`) REFERENCES `metodos_pago` (`id_metodo_pago`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagos_proveedores`
--
ALTER TABLE `pagos_proveedores`
  ADD CONSTRAINT `pagos_proveedores_ibfk_1` FOREIGN KEY (`id_cuenta_x_pagar`) REFERENCES `cuenta_x_pagar` (`id_cuenta_x_pagar`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`id_estado_pago`) REFERENCES `estado_pago` (`id_estado_pago`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedidos_ibfk_3` FOREIGN KEY (`id_estado_pedido`) REFERENCES `estado_pedido` (`id_estado_pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedidos_ibfk_4` FOREIGN KEY (`id_tasa`) REFERENCES `tasa_dia` (`id_tasa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producciones`
--
ALTER TABLE `producciones`
  ADD CONSTRAINT `producciones_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
