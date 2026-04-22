-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-04-2026 a las 01:11:08
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
-- Base de datos: `larence_seguridad`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesos`
--

CREATE TABLE `accesos` (
  `id_accesos` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `accesos`
--

INSERT INTO `accesos` (`id_accesos`, `id_rol`, `id_modulo`, `id_permiso`, `status`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 1, 2, 1),
(3, 1, 1, 3, 1),
(4, 1, 1, 4, 1),
(5, 1, 2, 1, 1),
(6, 1, 2, 2, 1),
(7, 1, 2, 3, 1),
(8, 1, 2, 4, 1),
(9, 1, 3, 1, 1),
(10, 1, 3, 2, 1),
(11, 1, 3, 3, 1),
(12, 1, 3, 4, 1),
(13, 1, 4, 1, 1),
(14, 1, 4, 2, 1),
(15, 1, 4, 3, 1),
(16, 1, 4, 4, 1),
(17, 1, 5, 1, 1),
(18, 1, 5, 2, 1),
(19, 1, 5, 3, 1),
(20, 1, 5, 4, 1),
(21, 1, 6, 1, 1),
(22, 1, 6, 2, 1),
(23, 1, 6, 3, 1),
(24, 1, 6, 4, 1),
(25, 1, 7, 1, 1),
(26, 1, 7, 2, 1),
(27, 1, 7, 3, 1),
(28, 1, 7, 4, 1),
(29, 1, 8, 1, 1),
(30, 1, 8, 2, 1),
(31, 1, 8, 3, 1),
(32, 1, 8, 4, 1),
(33, 1, 9, 1, 1),
(34, 1, 9, 2, 1),
(35, 1, 9, 3, 1),
(36, 1, 9, 4, 1),
(37, 1, 10, 1, 1),
(38, 1, 10, 2, 1),
(39, 1, 10, 3, 1),
(40, 1, 10, 4, 1),
(41, 1, 11, 1, 1),
(42, 1, 11, 2, 1),
(43, 1, 11, 3, 1),
(44, 1, 11, 4, 1),
(45, 1, 12, 1, 1),
(46, 1, 12, 2, 1),
(47, 1, 12, 3, 1),
(48, 1, 12, 4, 1),
(49, 1, 13, 1, 1),
(50, 1, 13, 2, 1),
(51, 1, 13, 3, 1),
(52, 1, 13, 4, 1),
(53, 1, 14, 1, 1),
(54, 1, 14, 2, 1),
(55, 1, 14, 3, 1),
(56, 1, 14, 4, 1),
(57, 1, 15, 1, 1),
(58, 1, 15, 2, 1),
(59, 1, 15, 3, 1),
(60, 1, 15, 4, 1),
(61, 1, 16, 1, 1),
(62, 1, 16, 2, 1),
(63, 1, 16, 3, 1),
(64, 1, 16, 4, 1),
(65, 1, 17, 1, 1),
(66, 1, 17, 2, 1),
(67, 1, 17, 3, 1),
(68, 1, 17, 4, 1),
(69, 2, 1, 1, 1),
(70, 2, 1, 2, 1),
(71, 2, 1, 3, 1),
(72, 2, 1, 4, 1),
(73, 2, 2, 1, 1),
(74, 2, 2, 2, 1),
(75, 2, 2, 3, 1),
(76, 2, 2, 4, 1),
(77, 2, 3, 1, 1),
(78, 2, 3, 2, 1),
(79, 2, 3, 3, 1),
(80, 2, 3, 4, 1),
(81, 2, 4, 1, 1),
(82, 2, 4, 2, 1),
(83, 2, 4, 3, 1),
(84, 2, 4, 4, 1),
(85, 2, 5, 1, 1),
(86, 2, 5, 2, 1),
(87, 2, 5, 3, 1),
(88, 2, 5, 4, 1),
(89, 2, 6, 1, 1),
(90, 2, 6, 2, 1),
(91, 2, 6, 3, 1),
(92, 2, 6, 4, 1),
(93, 2, 7, 1, 1),
(94, 2, 7, 2, 1),
(95, 2, 7, 3, 1),
(96, 2, 7, 4, 1),
(97, 2, 8, 1, 1),
(98, 2, 8, 2, 1),
(99, 2, 8, 3, 1),
(100, 2, 8, 4, 1),
(101, 2, 9, 1, 1),
(102, 2, 9, 2, 1),
(103, 2, 9, 3, 1),
(104, 2, 9, 4, 1),
(105, 2, 10, 1, 1),
(106, 2, 10, 2, 1),
(107, 2, 10, 3, 1),
(108, 2, 10, 4, 1),
(109, 2, 11, 1, 1),
(110, 2, 11, 2, 1),
(111, 2, 11, 3, 1),
(112, 2, 11, 4, 1),
(113, 2, 12, 1, 1),
(114, 2, 12, 2, 1),
(115, 2, 12, 3, 1),
(116, 2, 12, 4, 1),
(117, 2, 13, 1, 1),
(118, 2, 13, 2, 1),
(119, 2, 13, 3, 1),
(120, 2, 13, 4, 1),
(121, 2, 14, 1, 0),
(122, 2, 14, 2, 0),
(123, 2, 14, 3, 0),
(124, 2, 14, 4, 0),
(125, 2, 15, 1, 1),
(126, 2, 15, 2, 1),
(127, 2, 15, 3, 1),
(128, 2, 15, 4, 1),
(129, 2, 16, 1, 1),
(130, 2, 16, 2, 1),
(131, 2, 16, 3, 1),
(132, 2, 16, 4, 1),
(133, 2, 17, 1, 0),
(134, 2, 17, 2, 0),
(135, 2, 17, 3, 0),
(136, 2, 17, 4, 0),
(137, 3, 1, 1, 0),
(138, 3, 1, 2, 0),
(139, 3, 1, 3, 0),
(140, 3, 1, 4, 0),
(141, 3, 2, 1, 0),
(142, 3, 2, 2, 0),
(143, 3, 2, 3, 0),
(144, 3, 2, 4, 0),
(145, 3, 3, 1, 0),
(146, 3, 3, 2, 0),
(147, 3, 3, 3, 0),
(148, 3, 3, 4, 0),
(149, 3, 4, 1, 0),
(150, 3, 4, 2, 0),
(151, 3, 4, 3, 0),
(152, 3, 4, 4, 0),
(153, 3, 5, 1, 0),
(154, 3, 5, 2, 0),
(155, 3, 5, 3, 0),
(156, 3, 5, 4, 0),
(157, 3, 6, 1, 0),
(158, 3, 6, 2, 0),
(159, 3, 6, 3, 0),
(160, 3, 6, 4, 0),
(161, 3, 7, 1, 0),
(162, 3, 7, 2, 0),
(163, 3, 7, 3, 0),
(164, 3, 7, 4, 0),
(165, 3, 8, 1, 0),
(166, 3, 8, 2, 0),
(167, 3, 8, 3, 0),
(168, 3, 8, 4, 0),
(169, 3, 9, 1, 0),
(170, 3, 9, 2, 0),
(171, 3, 9, 3, 0),
(172, 3, 9, 4, 0),
(173, 3, 10, 1, 1),
(174, 3, 10, 2, 1),
(175, 3, 10, 3, 1),
(176, 3, 10, 4, 1),
(177, 3, 11, 1, 0),
(178, 3, 11, 2, 0),
(179, 3, 11, 3, 0),
(180, 3, 11, 4, 0),
(181, 3, 12, 1, 0),
(182, 3, 12, 2, 0),
(183, 3, 12, 3, 0),
(184, 3, 12, 4, 0),
(185, 3, 13, 1, 0),
(186, 3, 13, 2, 0),
(187, 3, 13, 3, 0),
(188, 3, 13, 4, 0),
(189, 3, 14, 1, 0),
(190, 3, 14, 2, 0),
(191, 3, 14, 3, 0),
(192, 3, 14, 4, 0),
(193, 3, 15, 1, 0),
(194, 3, 15, 2, 0),
(195, 3, 15, 3, 0),
(196, 3, 15, 4, 0),
(197, 3, 16, 1, 0),
(198, 3, 16, 2, 0),
(199, 3, 16, 3, 0),
(200, 3, 16, 4, 0),
(201, 3, 17, 1, 0),
(202, 3, 17, 2, 0),
(203, 3, 17, 3, 0),
(204, 3, 17, 4, 0),
(205, 4, 1, 1, 1),
(206, 4, 1, 2, 1),
(207, 4, 1, 3, 1),
(208, 4, 1, 4, 1),
(209, 4, 2, 1, 1),
(210, 4, 2, 2, 1),
(211, 4, 2, 3, 1),
(212, 4, 2, 4, 1),
(213, 4, 3, 1, 1),
(214, 4, 3, 2, 1),
(215, 4, 3, 3, 1),
(216, 4, 3, 4, 1),
(217, 4, 4, 1, 1),
(218, 4, 4, 2, 1),
(219, 4, 4, 3, 1),
(220, 4, 4, 4, 1),
(221, 4, 5, 1, 0),
(222, 4, 5, 2, 0),
(223, 4, 5, 3, 0),
(224, 4, 5, 4, 0),
(225, 4, 6, 1, 1),
(226, 4, 6, 2, 1),
(227, 4, 6, 3, 1),
(228, 4, 6, 4, 1),
(229, 4, 7, 1, 0),
(230, 4, 7, 2, 0),
(231, 4, 7, 3, 0),
(232, 4, 7, 4, 0),
(233, 4, 8, 1, 0),
(234, 4, 8, 2, 0),
(235, 4, 8, 3, 0),
(236, 4, 8, 4, 0),
(237, 4, 9, 1, 0),
(238, 4, 9, 2, 0),
(239, 4, 9, 3, 0),
(240, 4, 9, 4, 0),
(241, 4, 10, 1, 0),
(242, 4, 10, 2, 0),
(243, 4, 10, 3, 0),
(244, 4, 10, 4, 0),
(245, 4, 11, 1, 0),
(246, 4, 11, 2, 0),
(247, 4, 11, 3, 0),
(248, 4, 11, 4, 0),
(249, 4, 12, 1, 0),
(250, 4, 12, 2, 0),
(251, 4, 12, 3, 0),
(252, 4, 12, 4, 0),
(253, 4, 13, 1, 0),
(254, 4, 13, 2, 0),
(255, 4, 13, 3, 0),
(256, 4, 13, 4, 0),
(257, 4, 14, 1, 0),
(258, 4, 14, 2, 0),
(259, 4, 14, 3, 0),
(260, 4, 14, 4, 0),
(261, 4, 15, 1, 1),
(262, 4, 15, 2, 1),
(263, 4, 15, 3, 1),
(264, 4, 15, 4, 1),
(265, 4, 16, 1, 0),
(266, 4, 16, 2, 0),
(267, 4, 16, 3, 0),
(268, 4, 16, 4, 0),
(269, 4, 17, 1, 0),
(270, 4, 17, 2, 0),
(271, 4, 17, 3, 0),
(272, 4, 17, 4, 0),
(273, 7, 1, 1, 1),
(274, 7, 1, 2, 1),
(275, 7, 1, 3, 1),
(276, 7, 1, 4, 1),
(277, 7, 2, 1, 1),
(278, 7, 2, 2, 1),
(279, 7, 2, 3, 1),
(280, 7, 2, 4, 1),
(281, 7, 3, 1, 1),
(282, 7, 3, 2, 1),
(283, 7, 3, 3, 1),
(284, 7, 3, 4, 1),
(285, 7, 4, 1, 1),
(286, 7, 4, 2, 1),
(287, 7, 4, 3, 1),
(288, 7, 4, 4, 1),
(289, 7, 5, 1, 1),
(290, 7, 5, 2, 1),
(291, 7, 5, 3, 1),
(292, 7, 5, 4, 1),
(293, 7, 6, 1, 1),
(294, 7, 6, 2, 1),
(295, 7, 6, 3, 1),
(296, 7, 6, 4, 1),
(297, 7, 7, 1, 1),
(298, 7, 7, 2, 1),
(299, 7, 7, 3, 1),
(300, 7, 7, 4, 1),
(301, 7, 8, 1, 1),
(302, 7, 8, 2, 1),
(303, 7, 8, 3, 1),
(304, 7, 8, 4, 1),
(305, 7, 9, 1, 1),
(306, 7, 9, 2, 1),
(307, 7, 9, 3, 1),
(308, 7, 9, 4, 1),
(309, 7, 10, 1, 1),
(310, 7, 10, 2, 1),
(311, 7, 10, 3, 1),
(312, 7, 10, 4, 1),
(313, 7, 11, 1, 1),
(314, 7, 11, 2, 1),
(315, 7, 11, 3, 1),
(316, 7, 11, 4, 1),
(317, 7, 12, 1, 1),
(318, 7, 12, 2, 1),
(319, 7, 12, 3, 1),
(320, 7, 12, 4, 1),
(321, 7, 13, 1, 1),
(322, 7, 13, 2, 1),
(323, 7, 13, 3, 1),
(324, 7, 13, 4, 1),
(325, 7, 14, 1, 1),
(326, 7, 14, 2, 1),
(327, 7, 14, 3, 1),
(328, 7, 14, 4, 1),
(329, 7, 15, 1, 1),
(330, 7, 15, 2, 1),
(331, 7, 15, 3, 1),
(332, 7, 15, 4, 1),
(333, 7, 16, 1, 1),
(334, 7, 16, 2, 1),
(335, 7, 16, 3, 1),
(336, 7, 16, 4, 1),
(337, 7, 17, 1, 1),
(338, 7, 17, 2, 1),
(339, 7, 17, 3, 1),
(340, 7, 17, 4, 1),
(341, 8, 1, 1, 1),
(342, 8, 1, 2, 1),
(343, 8, 1, 3, 1),
(344, 8, 1, 4, 1),
(345, 8, 2, 1, 1),
(346, 8, 2, 2, 1),
(347, 8, 2, 3, 1),
(348, 8, 2, 4, 1),
(349, 8, 3, 1, 1),
(350, 8, 3, 2, 1),
(351, 8, 3, 3, 1),
(352, 8, 3, 4, 1),
(353, 8, 4, 1, 1),
(354, 8, 4, 2, 1),
(355, 8, 4, 3, 1),
(356, 8, 4, 4, 1),
(357, 8, 5, 1, 1),
(358, 8, 5, 2, 1),
(359, 8, 5, 3, 1),
(360, 8, 5, 4, 1),
(361, 8, 6, 1, 1),
(362, 8, 6, 2, 1),
(363, 8, 6, 3, 1),
(364, 8, 6, 4, 1),
(365, 8, 7, 1, 1),
(366, 8, 7, 2, 1),
(367, 8, 7, 3, 1),
(368, 8, 7, 4, 1),
(369, 8, 8, 1, 1),
(370, 8, 8, 2, 1),
(371, 8, 8, 3, 1),
(372, 8, 8, 4, 1),
(373, 8, 9, 1, 1),
(374, 8, 9, 2, 1),
(375, 8, 9, 3, 1),
(376, 8, 9, 4, 1),
(377, 8, 10, 1, 1),
(378, 8, 10, 2, 1),
(379, 8, 10, 3, 1),
(380, 8, 10, 4, 1),
(381, 8, 11, 1, 1),
(382, 8, 11, 2, 1),
(383, 8, 11, 3, 1),
(384, 8, 11, 4, 1),
(385, 8, 12, 1, 1),
(386, 8, 12, 2, 1),
(387, 8, 12, 3, 1),
(388, 8, 12, 4, 1),
(389, 8, 13, 1, 1),
(390, 8, 13, 2, 1),
(391, 8, 13, 3, 1),
(392, 8, 13, 4, 1),
(393, 8, 14, 1, 0),
(394, 8, 14, 2, 0),
(395, 8, 14, 3, 0),
(396, 8, 14, 4, 0),
(397, 8, 15, 1, 1),
(398, 8, 15, 2, 1),
(399, 8, 15, 3, 1),
(400, 8, 15, 4, 1),
(401, 8, 16, 1, 0),
(402, 8, 16, 2, 0),
(403, 8, 16, 3, 0),
(404, 8, 16, 4, 0),
(405, 8, 17, 1, 0),
(406, 8, 17, 2, 0),
(407, 8, 17, 3, 0),
(408, 8, 17, 4, 0),
(443, 1, 18, 1, 1),
(444, 1, 18, 2, 1),
(445, 1, 18, 3, 1),
(446, 1, 18, 4, 1),
(447, 1, 19, 1, 1),
(448, 1, 19, 2, 1),
(449, 1, 19, 3, 1),
(450, 1, 19, 4, 1),
(451, 8, 18, 1, 0),
(452, 8, 18, 2, 0),
(453, 8, 18, 3, 0),
(454, 8, 18, 4, 0),
(455, 8, 19, 1, 0),
(456, 8, 19, 2, 0),
(457, 8, 19, 3, 0),
(458, 8, 19, 4, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacoras`
--

CREATE TABLE `bitacoras` (
  `id_bitacora` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `modulo` varchar(100) NOT NULL,
  `accion` varchar(100) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `fecha_bitacora` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `bitacoras`
--

INSERT INTO `bitacoras` (`id_bitacora`, `id_usuario`, `modulo`, `accion`, `descripcion`, `fecha_bitacora`) VALUES
(59, 8, 'Autenticator', 'Cerrar Session', 'El usuario: @profe_01 ha Cerrado session en el sistema.', '2026-04-15 13:18:31.000000'),
(60, 2, 'Autenticator', 'Iniciar Session', 'El usuario: @superusuario_24 ha iniciado session en el sistema.', '2026-04-15 17:28:01.000000'),
(61, 2, 'Autenticator', 'Cerrar Session', 'El usuario: @superusuario_24 ha Cerrado session en el sistema.', '2026-04-15 17:28:34.000000'),
(62, 2, 'Autenticator', 'Iniciar Session', 'El usuario: @superusuario_24 ha iniciado session en el sistema.', '2026-04-15 18:01:15.000000'),
(63, 2, 'Autenticator', 'Iniciar Session', 'El usuario: @superusuario_24 ha iniciado session en el sistema.', '2026-04-15 18:15:09.000000'),
(64, 2, 'Autenticator', 'Iniciar Session', 'El usuario: @superusuario_24 ha iniciado session en el sistema.', '2026-04-15 18:18:20.000000'),
(65, 2, 'Autenticator', 'Cerrar Session', 'El usuario: @superusuario_24 ha Cerrado session en el sistema.', '2026-04-15 20:02:47.000000'),
(66, 2, 'Autenticator', 'Iniciar Session', 'El usuario: @superusuario_24 ha iniciado session en el sistema.', '2026-04-15 20:03:34.000000'),
(67, 2, 'Autenticator', 'Cerrar Session', 'El usuario: @superusuario_24 ha Cerrado session en el sistema.', '2026-04-15 21:06:07.000000'),
(68, 2, 'Autenticator', 'Iniciar Session', 'El usuario: @superusuario_24 ha iniciado session en el sistema.', '2026-04-16 23:28:41.000000'),
(69, 2, 'Proveedores', 'Modificar', 'El usuario: @superusuario_24 ha modificado el siguiente Proveedor RIF J--301234543 Nombre La Nestle ', '2026-04-16 23:40:38.000000'),
(70, 2, 'Proveedores', 'Eliminar', 'El usuario: @superusuario_24 ha elimando el siguiente proveedor RIF 301234543 en el sistema.', '2026-04-16 23:40:53.000000'),
(71, 2, 'Proveedores', 'Agregar', 'El usuario: @superusuario_24 ha registrado el siguiente Proveedor RIF J--12345321 Nombre Amazon Tlf ', '2026-04-16 23:42:01.000000'),
(72, 2, 'Autenticator', 'LOGIN', 'El usuario: @superusuario_24 ha iniciado session en el sistema.', '2026-04-17 22:38:47.000000'),
(73, 2, 'Autenticator', 'Cerrar Session', 'El usuario: @superusuario_24 ha Cerrado session en el sistema.', '2026-04-17 22:45:33.000000'),
(74, 2, 'Autenticator', 'LOGIN', 'El usuario: @superusuario_24 ha iniciado session en el sistema.', '2026-04-20 09:43:07.000000'),
(75, 2, 'Categorias', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos de la siguiente categoria CT-002 Postres en el si', '2026-04-20 09:43:47.000000'),
(76, 2, 'Categorias', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos de la siguiente categoria CT-001 Galletas en el sistema.', '2026-04-20 09:44:41.000000'),
(77, 2, 'Categorias', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-20 09:48:25.000000'),
(78, 2, 'Productos', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los productos en el sistema.', '2026-04-20 09:54:52.000000'),
(79, 2, 'Productos', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los productos en el sistema.', '2026-04-20 10:46:32.000000'),
(80, 2, 'Productos', 'Modificar', 'El usuario: @superusuario_24 ha modificado el siguiente producto Codigo del producto 8 Nombre Galletas Natys dulces con sabor a Colita 90g cont Precio 2.5 Stock 5 Fecha Registro 2026-04-03 Fecha Vencimiento 2026-05-30 Por los siguientes datos nuevos Codigo del producto  Nombre Galletas Natys dulces con sabor a Colita 90g Precio 2.5 Stock 5 Fecha Registro 2026-04-03 Fecha vencimiento 2026-05-30 en el sistema.', '2026-04-20 10:47:11.000000'),
(81, 2, 'Productos', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los productos en el sistema.', '2026-04-20 10:47:12.000000'),
(82, 2, 'Productos', 'Modificar', 'El usuario: @superusuario_24 ha modificado el siguiente producto Codigo del producto 8 Nombre Galletas Natys dulces con sabor a Colita 90g Precio 2.5 Stock 5 Fecha Registro 2026-04-03 Fecha Vencimiento 2026-05-30 Por los siguientes datos nuevos Codigo del producto  Nombre Galletas Natys dulces con sabor a Colita 90g Cont Precio 2.5 Stock 5 Fecha Registro 2026-04-03 Fecha vencimiento 2026-05-30 en el sistema.', '2026-04-20 10:47:52.000000'),
(83, 2, 'Productos', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los productos en el sistema.', '2026-04-20 10:47:52.000000'),
(84, 2, 'Productos', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los productos en el sistema.', '2026-04-20 10:53:28.000000'),
(85, 2, 'Productos', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del siguiente producto COD-00Codigo del producto 8 Nombre Galletas Natys dulces con sabor a Colita 90g Cont Precio 2.5 Stock 5 Fecha Registro 2026-04-03 Fecha Vencimiento 2026-05-30  en el sistema.', '2026-04-20 10:53:36.000000'),
(86, 2, 'Productos', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los productos en el sistema.', '2026-04-20 11:00:05.000000'),
(87, 2, 'Productos', 'Eliminar', 'El usuario: @superusuario_24 ha eliminado el siguiente producto Codigo del producto 8 Nombre Galletas Natys dulces con sabor a Colita 90g Cont Precio 2.5 Stock 5 Fecha Registro 2026-04-03 Fecha Vencimiento 2026-05-30  en el sistema.', '2026-04-20 11:00:19.000000'),
(88, 2, 'Productos', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los productos en el sistema.', '2026-04-20 11:00:19.000000'),
(89, 2, 'Materias Primas', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de materia prima en el sistema', '2026-04-20 11:27:47.000000'),
(90, 2, 'Materias Primas', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos de la siguiente materia primas Codigo de materia prima 3 Nombre Leche Descripcion Para elaboracion de galletas humedas Stock 25 en el sistema', '2026-04-20 11:28:20.000000'),
(91, 2, 'Materias Primas', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos de la siguiente materia primas Codigo de materia prima 3 Nombre Leche Descripcion Para elaboracion de galletas humedas Stock 25 en el sistema', '2026-04-20 11:29:00.000000'),
(92, 2, 'Materias Primas', 'Modificar', 'El usuario: @superusuario_24 ha modificado la siguiente materia prima Codigo de materia prima 3 Nombre Leche Descripcion Para elaboracion de galletas humedas Stock 25 Por los siguientes datos nuevos Codigo de la materia prima 3Nombre Leche Donbom Descripcion Para elaboracion de galletas humedas Stock  Proveedor 322007710 en el sistema', '2026-04-20 11:29:19.000000'),
(93, 2, 'Materias Primas', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de materia prima en el sistema', '2026-04-20 11:29:19.000000'),
(94, 2, 'Materias Primas', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos de la siguiente materia primas Codigo de materia prima 3 Nombre Leche Donbom Descripcion Para elaboracion de galletas humedas Stock 25 en el sistema', '2026-04-20 11:29:49.000000'),
(95, 2, 'Materias Primas', 'Modificar', 'El usuario: @superusuario_24 ha modificado la siguiente materia prima Codigo de materia prima 3 Nombre Leche Donbom Descripcion Para elaboracion de galletas humedas Stock 25 Por los siguientes datos nuevos Codigo de la materia prima 3Nombre Leche Descripcion Para elaboracion de galletas humedas Stock  Proveedor 322007710 en el sistema', '2026-04-20 11:29:55.000000'),
(96, 2, 'Materias Primas', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de materia prima en el sistema', '2026-04-20 11:29:55.000000'),
(97, 2, 'Materias Primas', 'Eliminar', 'El usuario: @superusuario_24 ha eliminado la siguiente materia prima Codigo de materia prima 3 Nombre Leche Descripcion Para elaboracion de galletas humedas Stock 25 en el sistema.', '2026-04-20 11:30:12.000000'),
(98, 2, 'Materias Primas', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de materia prima en el sistema', '2026-04-20 11:30:12.000000'),
(99, 2, 'Proveedores', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de proveedores en el sistema', '2026-04-20 11:47:57.000000'),
(100, 2, 'Proveedores', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del siguiente proveedor RIF J-322007710 Nombre La Friz ca Tlf 02511358622 Email Lafriz@gmail.com Direccion Zona industrial II calle 9 en el sistema', '2026-04-20 11:48:06.000000'),
(101, 2, 'Proveedores', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de proveedores en el sistema', '2026-04-20 11:50:37.000000'),
(102, 2, 'Proveedores', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de proveedores en el sistema', '2026-04-20 11:50:44.000000'),
(103, 2, 'Proveedores', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de proveedores en el sistema', '2026-04-20 11:50:52.000000'),
(104, 2, 'Proveedores', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del siguiente proveedor RIF J-322007710 Nombre La Friz ca Tlf 02511358622 Email Lafriz@gmail.com Direccion Zona industrial II calle 9 en el sistema', '2026-04-20 11:51:00.000000'),
(105, 2, 'Categorias', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-20 11:51:11.000000'),
(106, 2, 'Proveedores', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de proveedores en el sistema', '2026-04-20 11:53:10.000000'),
(107, 2, 'Autenticator', 'LOGIN', 'El usuario: @superusuario_24 ha iniciado session en el sistema.', '2026-04-20 16:31:06.000000'),
(108, 2, 'Proveedores', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de proveedores en el sistema', '2026-04-20 16:31:39.000000'),
(109, 2, 'Proveedores', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del siguiente proveedor RIF J-322007710 Nombre La Friz ca Tlf 02511358622 Email Lafriz@gmail.com Direccion Zona industrial II calle 9 en el sistema', '2026-04-20 16:31:58.000000'),
(110, 2, 'Proveedores', 'Modificar', 'El usuario: @superusuario_24 ha modificado el siguiente Proveedor RIF J-322007710 Nombre La Friz ca Tlf 02511358622 Email Lafriz@gmail.com Direccion Zona industrial II calle 9 Por los siguientes datos nuevos RIF J--322007710 Nombre La Friz  Tlf 02511358622 Email Lafriz@gmail.com Direccion Zona industrial II calle 9 en el sistema.', '2026-04-20 16:32:04.000000'),
(111, 2, 'Proveedores', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de proveedores en el sistema', '2026-04-20 16:32:05.000000'),
(112, 2, 'Proveedores', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del siguiente proveedor RIF J-322007710 Nombre La Friz Tlf 02511358622 Email Lafriz@gmail.com Direccion Zona industrial II calle 9 en el sistema', '2026-04-20 16:32:43.000000'),
(113, 2, 'Proveedores', 'Modificar', 'El usuario: @superusuario_24 ha modificado el siguiente Proveedor RIF J-322007710 Nombre La Friz Tlf 02511358622 Email Lafriz@gmail.com Direccion Zona industrial II calle 9 Por los siguientes datos nuevos RIF J--322007710 Nombre La Friz ca Tlf 02511358622 Email Lafriz@gmail.com Direccion Zona industrial II calle 9 en el sistema.', '2026-04-20 16:32:47.000000'),
(114, 2, 'Proveedores', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de proveedores en el sistema', '2026-04-20 16:32:47.000000'),
(115, 2, 'Proveedores', 'Eliminar', 'El usuario: @superusuario_24 ha elimando el siguiente proveedor RIF  Nombre  Tlf  Email  Direccion  en el sistema.', '2026-04-20 16:33:59.000000'),
(116, 2, 'Proveedores', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de proveedores en el sistema', '2026-04-20 16:33:59.000000'),
(117, 2, 'Proveedores', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de proveedores en el sistema', '2026-04-20 16:39:59.000000'),
(118, 2, 'Proveedores', 'Eliminar', 'El usuario: @superusuario_24 ha elimando el siguiente proveedor RIF J-310397110 Nombre Distribuidor la 21ca Tlf 02513213495 Email Dis21ca@gmail.com Direccion Carrera 21 con calle 29 y 30 en el sistema.', '2026-04-20 16:40:26.000000'),
(119, 2, 'Proveedores', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de proveedores en el sistema', '2026-04-20 16:40:26.000000'),
(120, 2, 'Tipos Clientes', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de tipos de clientes en el sistema', '2026-04-20 17:06:34.000000'),
(121, 2, 'Tipos Clientes', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de tipos de clientes en el sistema', '2026-04-20 17:15:10.000000'),
(122, 2, 'Tipos Clientes', 'Obetener', 'El usuario: @superusuario_24 ha obtenido el siguiente Tipo de Cliente Codigo del Tipo Cliente 4 Nombre Sucursales en el sistema.', '2026-04-20 17:16:04.000000'),
(123, 2, 'Tipos Clientes', 'Eliminar', 'El usuario: @superusuario_24 ha eliminado el siguiente Tipo de Cliente Codigo del Tipo Cliente 5 Nombre Abastos en el sistema.', '2026-04-20 17:16:36.000000'),
(124, 2, 'Tipos Clientes', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de tipos de clientes en el sistema', '2026-04-20 17:16:36.000000'),
(125, 2, 'Clientes', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de clientes en el sistema', '2026-04-20 17:55:53.000000'),
(126, 2, 'Clientes', 'Obtener', 'El usuario: @superusuario_24 ha obtenido el siguiente Cliente C.I / RIF J-32200771 Nombre Mi Super Tlf 02514408820 Email misuper@gmail.com Direcion Cale 54 con Carrera 20 Estado Activo en el sistema.', '2026-04-20 17:56:13.000000'),
(127, 2, 'Clientes', 'Modificar', 'El usuario: @superusuario_24 ha modificado el siguiente Cliente C.I / RIF J-32200771 Nombre Mi Super Tlf 02514408820 Email misuper@gmail.com Direcion Cale 54 con Carrera 20 Estado Activo Por los siguientes datos nuevos C.I / RIF J-32200771 Nombre Mi Super ca Tlf 02514408820 Email misuper@gmail.com Direcion Cale 54 con Carrera 20 Estado Activo en el sistema.', '2026-04-20 17:56:43.000000'),
(128, 2, 'Clientes', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de clientes en el sistema', '2026-04-20 17:56:43.000000'),
(129, 2, 'Clientes', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de clientes en el sistema', '2026-04-20 17:57:30.000000'),
(130, 2, 'Clientes', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de clientes en el sistema', '2026-04-20 17:57:55.000000'),
(131, 2, 'Clientes', 'Eliminar', 'El usuario: @superusuario_24 ha eliminado el siguiente cliente C.I / RIF J-176263540 Nombre Forum Tlf 02512372439 Email forum@gmail.com Direcion Av Libertador con calle 51 CC Babilon Estado Activo en el sistema.', '2026-04-20 17:58:06.000000'),
(132, 2, 'Clientes', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de clientes en el sistema', '2026-04-20 17:58:06.000000'),
(133, 2, 'Clientes', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de clientes en el sistema', '2026-04-20 17:58:52.000000'),
(134, 2, 'Tipos Clientes', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de tipos de clientes en el sistema', '2026-04-20 21:53:47.000000'),
(135, 2, 'Tipos Clientes', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de tipos de clientes en el sistema', '2026-04-20 21:54:22.000000'),
(136, 2, 'Categorias', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-20 22:06:50.000000'),
(137, 2, 'Categorias', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-20 22:07:23.000000'),
(138, 2, 'Categorias', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos de la siguiente categoria CT-001 Galletas en el sistema.', '2026-04-20 22:28:29.000000'),
(139, 2, 'Categorias', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos de la siguiente categoria CT-001 Galletas en el sistema.', '2026-04-20 22:28:49.000000'),
(140, 2, 'Autenticator', 'LOGIN', 'El usuario: @superusuario_24 ha iniciado session en el sistema.', '2026-04-21 13:47:37.000000'),
(141, 2, 'Productos', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los productos en el sistema.', '2026-04-21 15:02:24.000000'),
(142, 2, 'Autenticator', 'LOGIN', 'El usuario: @superusuario_24 ha iniciado session en el sistema.', '2026-04-21 15:20:54.000000'),
(143, 2, 'Categorias', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-21 18:34:54.000000'),
(144, 2, 'Tipos Clientes', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de tipos de clientes en el sistema', '2026-04-21 18:34:58.000000'),
(145, 2, 'Tipos Clientes', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de tipos de clientes en el sistema', '2026-04-21 18:35:17.000000'),
(146, 2, 'Categorias', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-21 18:35:24.000000'),
(147, 2, 'Autenticator', 'LOGIN', 'El usuario: @superusuario_24 ha iniciado session en el sistema.', '2026-04-22 08:20:17.000000'),
(148, 2, 'Tipos Clientes', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de tipos de clientes en el sistema', '2026-04-22 08:46:27.000000'),
(149, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:26:11.000000'),
(150, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:26:23.000000'),
(151, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:26:51.000000'),
(152, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:26:51.000000'),
(153, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:27:33.000000'),
(154, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:27:34.000000'),
(155, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:27:34.000000'),
(156, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:27:34.000000'),
(157, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:27:35.000000'),
(158, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:27:35.000000'),
(159, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:27:46.000000'),
(160, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:28:18.000000'),
(161, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:28:18.000000'),
(162, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:29:10.000000'),
(163, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:29:11.000000'),
(164, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:29:58.000000'),
(165, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:29:59.000000'),
(166, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:30:28.000000'),
(167, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:31:28.000000'),
(168, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:31:43.000000'),
(169, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:32:22.000000'),
(170, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:32:26.000000'),
(171, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:32:34.000000'),
(172, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:34:05.000000'),
(173, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado un rol en el select en el sistema.', '2026-04-22 10:34:06.000000'),
(174, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:34:09.000000'),
(175, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado un rol en el select en el sistema.', '2026-04-22 10:34:09.000000'),
(176, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:34:11.000000'),
(177, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado un rol en el select en el sistema.', '2026-04-22 10:34:11.000000'),
(178, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:35:22.000000'),
(179, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado un rol en el select en el sistema.', '2026-04-22 10:35:23.000000'),
(180, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:35:24.000000'),
(181, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:36:02.000000'),
(182, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado un rol en el select en el sistema.', '2026-04-22 10:36:02.000000'),
(183, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 10:37:00.000000'),
(184, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:15:19.000000'),
(185, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:15:28.000000'),
(186, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:16:52.000000'),
(187, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:16:53.000000'),
(188, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:17:11.000000'),
(189, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:23:04.000000'),
(190, 2, 'Roles', 'Agregar', 'El usuario: @superusuario_24 ha ragistras el siguiente rol Finanzas en el sistema.', '2026-04-22 11:23:16.000000'),
(191, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:23:16.000000'),
(192, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:24:07.000000'),
(193, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:26:27.000000'),
(194, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:28:40.000000'),
(195, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:28:43.000000'),
(196, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:29:48.000000'),
(197, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:29:53.000000'),
(198, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:31:13.000000'),
(199, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:31:15.000000'),
(200, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:31:28.000000'),
(201, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:34:15.000000'),
(202, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:34:18.000000'),
(203, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:36:22.000000'),
(204, 2, 'Roles', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del siguiente rol RL-005 Finanzas en el sistema.', '2026-04-22 11:36:48.000000'),
(205, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:38:29.000000'),
(206, 2, 'Roles', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del siguiente rol RL-005 Finanzas en el sistema.', '2026-04-22 11:38:39.000000'),
(207, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:39:31.000000'),
(208, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:42:58.000000'),
(209, 2, 'Roles', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del siguiente rol RL-005 Finanzas en el sistema.', '2026-04-22 11:43:27.000000'),
(210, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:43:43.000000'),
(211, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:46:53.000000'),
(212, 2, 'Roles', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del siguiente rol RL-005 Finanzas en el sistema.', '2026-04-22 11:47:13.000000'),
(213, 2, 'Roles', 'Modificar', 'El usuario: @superusuario_24 ha modificado los datos del siguiente rol RL-005 Finanzas por los siguientes datos RL-005 Finanzas edit en el sistema.', '2026-04-22 11:47:27.000000'),
(214, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:47:27.000000'),
(215, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:55:58.000000'),
(216, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:56:00.000000'),
(217, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:56:06.000000'),
(218, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 11:59:38.000000'),
(219, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 12:01:27.000000'),
(220, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 12:01:56.000000'),
(221, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 12:01:59.000000'),
(222, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 12:04:17.000000'),
(223, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 12:04:57.000000'),
(224, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 12:04:58.000000'),
(225, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 12:05:06.000000'),
(226, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 12:05:26.000000'),
(227, 2, 'Roles', 'Eliminar', 'El usuario: @superusuario_24 ha eliminado el siguiente rol RL-005 Finanzas edit en el sistema.', '2026-04-22 12:05:33.000000'),
(228, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 12:05:34.000000'),
(229, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 12:06:34.000000'),
(230, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 12:58:22.000000'),
(231, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 12:58:45.000000'),
(232, 2, 'Roles', 'Agregar', 'El usuario: @superusuario_24 ha ragistras el siguiente rol Gerente en el sistema.', '2026-04-22 12:58:52.000000'),
(233, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 12:58:53.000000'),
(234, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:02:48.000000'),
(235, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:02:51.000000'),
(236, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:03:01.000000'),
(237, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:03:16.000000'),
(238, 2, 'Roles', 'Agregar', 'El usuario: @superusuario_24 ha ragistras el siguiente rol Finanzas en el sistema.', '2026-04-22 13:03:24.000000'),
(239, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:03:26.000000'),
(240, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:11:52.000000'),
(241, 2, 'Roles', 'Agregar', 'El usuario: @superusuario_24 ha ragistras el siguiente rol Gerente en el sistema.', '2026-04-22 13:12:00.000000'),
(242, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:12:02.000000'),
(243, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:12:28.000000'),
(244, 3, 'Autenticator', 'LOGIN', 'El usuario: @moises_24 ha iniciado session en el sistema.', '2026-04-22 13:13:55.000000'),
(245, 3, 'Tipos Clientes', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en el dashboard de tipos de clientes en el sistema', '2026-04-22 13:14:02.000000'),
(246, 3, 'Categorias', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 13:14:38.000000'),
(247, 3, 'Tipos Clientes', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en el dashboard de tipos de clientes en el sistema', '2026-04-22 13:14:44.000000'),
(248, 3, 'Tipos Clientes', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en el dashboard de tipos de clientes en el sistema', '2026-04-22 13:17:10.000000'),
(249, 3, 'Categorias', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 13:17:25.000000'),
(250, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:33:54.000000'),
(251, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:33:57.000000'),
(252, 2, 'Autenticator', 'LOGIN', 'El usuario: @superusuario_24 ha iniciado session en el sistema.', '2026-04-22 13:34:36.000000'),
(253, 2, 'Tipos Clientes', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de tipos de clientes en el sistema', '2026-04-22 13:34:49.000000'),
(254, 2, 'Clientes', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de clientes en el sistema', '2026-04-22 13:34:54.000000'),
(255, 2, 'Categorias', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 13:34:58.000000'),
(256, 2, 'Productos', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los productos en el sistema.', '2026-04-22 13:35:01.000000'),
(257, 2, 'Materias Primas', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de materia prima en el sistema', '2026-04-22 13:35:11.000000'),
(258, 2, 'Proveedores', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de proveedores en el sistema', '2026-04-22 13:35:16.000000'),
(259, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:35:30.000000'),
(260, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:37:39.000000'),
(261, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:39:59.000000'),
(262, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:41:52.000000'),
(263, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:42:26.000000'),
(264, 2, 'Autenticator', 'LOGIN', 'El usuario: @superusuario_24 ha iniciado session en el sistema.', '2026-04-22 13:46:07.000000'),
(265, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:46:11.000000'),
(266, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:49:12.000000'),
(267, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:49:19.000000'),
(268, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:49:21.000000'),
(269, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:49:28.000000'),
(270, 2, 'Roles', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del siguiente rol RL-003 Usuario en el sistema.', '2026-04-22 13:50:54.000000'),
(271, 2, 'Roles', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del siguiente rol RL-008 Gerente en el sistema.', '2026-04-22 13:50:58.000000'),
(272, 2, 'Autenticator', 'LOGIN', 'El usuario: @superusuario_24 ha iniciado session en el sistema.', '2026-04-22 13:53:03.000000'),
(273, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:53:08.000000'),
(274, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 13:57:43.000000'),
(275, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 14:00:13.000000'),
(276, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 14:00:59.000000'),
(277, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 14:05:06.000000'),
(278, 3, 'Autenticator', 'LOGIN', 'El usuario: @moises_24 ha iniciado session en el sistema.', '2026-04-22 14:05:38.000000'),
(279, 3, 'Tipos Clientes', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en el dashboard de tipos de clientes en el sistema', '2026-04-22 14:05:54.000000'),
(280, 3, 'Categorias', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 14:05:56.000000'),
(281, 2, 'Autenticator', 'LOGIN', 'El usuario: @superusuario_24 ha iniciado session en el sistema.', '2026-04-22 14:11:13.000000'),
(282, 2, 'Categorias', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 14:11:18.000000'),
(283, 2, 'Categorias', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 14:11:39.000000'),
(284, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 14:11:43.000000'),
(285, 2, 'Categorias', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 14:11:55.000000'),
(286, 2, 'Tipos Clientes', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de tipos de clientes en el sistema', '2026-04-22 14:12:51.000000'),
(287, 2, 'Autenticator', 'Cerrar Session', 'El usuario: @superusuario_24 ha Cerrado session en el sistema.', '2026-04-22 14:14:05.000000'),
(288, 3, 'Autenticator', 'LOGIN', 'El usuario: @moises_24 ha iniciado session en el sistema.', '2026-04-22 14:14:15.000000'),
(289, 3, 'Categorias', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 14:14:30.000000'),
(290, 3, 'Categorias', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 14:14:55.000000'),
(291, 3, 'Categorias', 'Agregar', 'El usuario: @moises_24 ha ragistras la siguiente categoria Electrodomesticos en el sistema.', '2026-04-22 14:15:24.000000'),
(292, 3, 'Categorias', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 14:15:24.000000'),
(293, 3, 'Categorias', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 14:15:30.000000'),
(294, 3, 'Categorias', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 14:15:30.000000'),
(295, 3, 'Categorias', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 14:15:35.000000'),
(296, 3, 'Categorias', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 14:15:35.000000'),
(297, 3, 'Categorias', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 14:15:41.000000'),
(298, 3, 'Categorias', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 14:15:42.000000'),
(299, 3, 'Categorias', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 14:19:09.000000'),
(300, 3, 'Categorias', 'Obtener', 'El usuario: @moises_24 ha obtenido los datos de la siguiente categoria CT-004 Electrodomesticos en el sistema.', '2026-04-22 14:19:12.000000'),
(301, 3, 'Categorias', 'Obtener', 'El usuario: @moises_24 ha obtenido los datos de la siguiente categoria CT-004 Electrodomesticos en el sistema.', '2026-04-22 14:19:20.000000'),
(302, 3, 'Categorias', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 14:19:38.000000'),
(303, 3, 'Categorias', 'Obtener', 'El usuario: @moises_24 ha obtenido los datos de la siguiente categoria CT-004 Electrodomesticos en el sistema.', '2026-04-22 14:20:11.000000'),
(304, 3, 'Categorias', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 14:20:14.000000'),
(305, 3, 'Categorias', 'Obtener', 'El usuario: @moises_24 ha obtenido los datos de la siguiente categoria CT-004 Electrodomesticos en el sistema.', '2026-04-22 14:22:11.000000'),
(306, 3, 'Categorias', 'Modificar', 'El usuario: @moises_24 ha modificado los datos de la siguiente categoria CT-004 Electrodomesticos por los siguientes datos CT-004 Electrodomesticos ed en el sistema.', '2026-04-22 14:22:14.000000'),
(307, 3, 'Categorias', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 14:22:14.000000'),
(308, 3, 'Categorias', 'Obtener', 'El usuario: @moises_24 ha obtenido los datos de la siguiente categoria CT-004 Electrodomesticos ed en el sistema.', '2026-04-22 14:22:19.000000'),
(309, 3, 'Categorias', 'Modificar', 'El usuario: @moises_24 ha modificado los datos de la siguiente categoria CT-004 Electrodomesticos ed por los siguientes datos CT-004 Electrodomesticos en el sistema.', '2026-04-22 14:22:22.000000'),
(310, 3, 'Categorias', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 14:22:22.000000'),
(311, 3, 'Categorias', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 14:22:26.000000'),
(312, 3, 'Categorias', 'Eliminar', 'El usuario: @moises_24 ha eliminado una categoria de codigo CT-004 Electrodomesticos en el sistema.', '2026-04-22 14:22:40.000000'),
(313, 3, 'Categorias', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de las categorias CT-00en el sistema.', '2026-04-22 14:22:40.000000'),
(314, 3, 'Bitacoras', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en el dashboard de bitaoras en el sistema', '2026-04-22 14:53:53.000000'),
(315, 3, 'Bitacoras', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en el dashboard de bitaoras en el sistema', '2026-04-22 14:54:02.000000'),
(316, 3, 'Bitacoras', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en el dashboard de bitaoras en el sistema', '2026-04-22 14:54:32.000000'),
(317, 3, 'Bitacoras', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en el dashboard de bitaoras en el sistema', '2026-04-22 14:54:43.000000'),
(318, 3, 'Bitacoras', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en el dashboard de bitaoras en el sistema', '2026-04-22 14:55:14.000000'),
(319, 3, 'Bitacoras', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en el dashboard de bitaoras en el sistema', '2026-04-22 14:55:44.000000'),
(320, 3, 'Roles', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 14:56:15.000000'),
(321, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 14:56:55.000000'),
(322, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:24:07.000000'),
(323, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:26:51.000000'),
(324, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:28:27.000000'),
(325, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:29:41.000000'),
(326, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:33:05.000000'),
(327, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:35:07.000000'),
(328, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:37:50.000000'),
(329, 2, 'Roles', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del siguiente rol RL-004 Vendedor en el sistema.', '2026-04-22 15:38:15.000000'),
(330, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:39:22.000000'),
(331, 3, 'Roles', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:39:36.000000'),
(332, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:39:39.000000'),
(333, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:39:55.000000'),
(334, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:41:15.000000'),
(335, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:42:42.000000'),
(336, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:42:48.000000'),
(337, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:44:12.000000'),
(338, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:50:07.000000'),
(339, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:50:14.000000'),
(340, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:51:06.000000'),
(341, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:51:15.000000'),
(342, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:52:34.000000'),
(343, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:53:28.000000'),
(344, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:55:24.000000'),
(345, 3, 'Roles', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:55:54.000000'),
(346, 3, 'Roles', 'Consultar', 'El usuario: @moises_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:56:24.000000'),
(347, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 15:56:44.000000'),
(348, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 16:44:13.000000'),
(349, 2, 'Roles', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en dashboard de los roles en el sistema.', '2026-04-22 16:48:41.000000'),
(350, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 16:53:31.000000');
INSERT INTO `bitacoras` (`id_bitacora`, `id_usuario`, `modulo`, `accion`, `descripcion`, `fecha_bitacora`) VALUES
(351, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 16:54:59.000000'),
(352, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 16:57:19.000000'),
(353, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 16:59:51.000000'),
(354, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 17:01:23.000000'),
(355, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 17:02:04.000000'),
(356, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 17:02:13.000000'),
(357, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 17:03:25.000000'),
(358, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 17:24:02.000000'),
(359, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 17:26:21.000000'),
(360, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 17:28:02.000000'),
(361, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 17:41:34.000000'),
(362, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 17:41:36.000000'),
(363, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 17:41:49.000000'),
(364, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 17:42:35.000000'),
(365, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 17:42:49.000000'),
(366, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 17:44:01.000000'),
(367, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 17:45:02.000000'),
(368, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 17:45:36.000000'),
(369, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 17:46:00.000000'),
(370, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:01:01.000000'),
(371, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:01:50.000000'),
(372, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:02:32.000000'),
(373, 2, 'Usuarios', 'Agregar', 'El usuario: @superusuario_24 ha ragistras el siguiente usuario @prueba_01 prueba@gmail.com en el sistema.', '2026-04-22 18:02:44.000000'),
(374, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:02:44.000000'),
(375, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:04:50.000000'),
(376, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:12:27.000000'),
(377, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:13:08.000000'),
(378, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:23:57.000000'),
(379, 2, 'CUsuario', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del usuario US-009 @prueba_01 prueba@gmail.com en el sistema.', '2026-04-22 18:24:06.000000'),
(380, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:25:57.000000'),
(381, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:25:59.000000'),
(382, 2, 'CUsuario', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del usuario US-009 @prueba_01 prueba@gmail.com en el sistema.', '2026-04-22 18:26:01.000000'),
(383, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:39:15.000000'),
(384, 2, 'CUsuario', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del usuario US-009 @prueba_01 prueba@gmail.com en el sistema.', '2026-04-22 18:39:17.000000'),
(385, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:39:32.000000'),
(386, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:40:33.000000'),
(387, 2, 'CUsuario', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del usuario US-009 @prueba_01 prueba@gmail.com en el sistema.', '2026-04-22 18:40:35.000000'),
(388, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:40:47.000000'),
(389, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:41:24.000000'),
(390, 2, 'CUsuario', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del usuario US-009 @prueba_01 prueba@gmail.com en el sistema.', '2026-04-22 18:41:26.000000'),
(391, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:41:36.000000'),
(392, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:42:46.000000'),
(393, 2, 'CUsuario', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del usuario US-009 @prueba_01 prueba@gmail.com en el sistema.', '2026-04-22 18:42:48.000000'),
(394, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:43:03.000000'),
(395, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:43:58.000000'),
(396, 2, 'CUsuario', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del usuario US-009 @prueba_01 prueba@gmail.com en el sistema.', '2026-04-22 18:44:00.000000'),
(397, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:46:12.000000'),
(398, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:46:14.000000'),
(399, 2, 'CUsuario', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del usuario US-009 @prueba_01 prueba@gmail.com en el sistema.', '2026-04-22 18:46:16.000000'),
(400, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:46:36.000000'),
(401, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:48:53.000000'),
(402, 2, 'CUsuario', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del usuario US-009 @prueba_01 prueba@gmail.com en el sistema.', '2026-04-22 18:48:55.000000'),
(403, 2, 'Usuarios', 'Modificar', 'El usuario: @superusuario_24 ha modificado los datos del siguinte usuario US-009 @prueba_01 prueba@gmail.com por los siguientes datos US-009 @prueba_09 prueba9@gmail.com en el sistema.', '2026-04-22 18:49:09.000000'),
(404, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:49:09.000000'),
(405, 2, 'CUsuario', 'Obtener', 'El usuario: @superusuario_24 ha obtenido los datos del usuario US-009 @prueba_09 prueba9@gmail.com en el sistema.', '2026-04-22 18:49:16.000000'),
(406, 2, 'Usuarios', 'Modificar', 'El usuario: @superusuario_24 ha modificado los datos del siguinte usuario US-009 @prueba_09 prueba9@gmail.com por los siguientes datos US-009 @prueba_01 prueba1@gmail.com en el sistema.', '2026-04-22 18:49:27.000000'),
(407, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:49:27.000000'),
(408, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:52:13.000000'),
(409, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:52:34.000000'),
(410, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:53:00.000000'),
(411, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:53:06.000000'),
(412, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:53:07.000000'),
(413, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:53:17.000000'),
(414, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:54:03.000000'),
(415, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:55:28.000000'),
(416, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:55:34.000000'),
(417, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:55:57.000000'),
(418, 2, 'Usuarios', 'Eliminar', 'El usuario: @superusuario_24 ha eliminado un usuario US-009 @prueba_01 en el sistema.', '2026-04-22 18:56:00.000000'),
(419, 2, 'Usuarios', 'Consultar', 'El usuario: @superusuario_24 ha Consultado los datos en el dashboard de usuarios en el sistema', '2026-04-22 18:56:01.000000'),
(420, 9, 'Autenticator', 'LOGIN', 'El usuario: @prueba_01 ha iniciado session en el sistema.', '2026-04-22 19:00:22.000000'),
(421, 9, 'Autenticator', 'Cerrar Session', 'El usuario: @prueba_01 ha Cerrado session en el sistema.', '2026-04-22 19:01:06.000000'),
(422, 2, 'Autenticator', 'Cerrar Session', 'El usuario: @superusuario_24 ha Cerrado session en el sistema.', '2026-04-22 19:04:13.000000'),
(423, NULL, 'Autenticator', 'Cambio de Clave', 'El usuario: @superusuario_24 ha realizado un cambio de clave en el sistema.', '2026-04-22 19:10:16.000000'),
(424, 2, 'Autenticator', 'LOGIN', 'El usuario: @superusuario_24 ha iniciado session en el sistema.', '2026-04-22 19:10:28.000000'),
(425, 2, 'Autenticator', 'Cerrar Session', 'El usuario: @superusuario_24 ha Cerrado session en el sistema.', '2026-04-22 19:10:39.000000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id_modulo` int(11) NOT NULL,
  `nombre_modulo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id_modulo`, `nombre_modulo`) VALUES
(1, 'Productos'),
(2, 'Categorias'),
(3, 'Clientes'),
(4, 'Tipos Clientes'),
(5, 'Proveedores'),
(6, 'Pedidos'),
(7, 'Compras'),
(8, 'Pagos'),
(9, 'Promociones'),
(10, 'Ecommerce'),
(11, 'Entregas'),
(12, 'Producciones'),
(13, 'Materias Prima'),
(14, 'Bitacoras'),
(15, 'Notificaciones'),
(16, 'Usuarios'),
(17, 'Roles'),
(18, 'Permisos'),
(19, 'Bitacoras');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id_notificaciones` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `descripcion_notificacion` varchar(100) NOT NULL,
  `enlace` varchar(100) NOT NULL,
  `fecha_notificacion` datetime(6) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permisos` int(11) NOT NULL,
  `nombre_permiso` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permisos`, `nombre_permiso`) VALUES
(1, 'Agregar'),
(2, 'Consultar'),
(3, 'Modificar'),
(4, 'Eliminar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recuperar_codigos`
--

CREATE TABLE `recuperar_codigos` (
  `id_recuperar_codigo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  `expira` datetime(6) NOT NULL,
  `usado` int(11) NOT NULL,
  `created_at` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `recuperar_codigos`
--

INSERT INTO `recuperar_codigos` (`id_recuperar_codigo`, `id_usuario`, `codigo`, `token`, `expira`, `usado`, `created_at`) VALUES
(23, 2, 164958, '829bb66e698eb2e351d328e8d8537137f0cb1d51115e52c7c58c1cc616fea4e4', '2026-04-22 20:09:31.000000', 1, '0000-00-00 00:00:00.000000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`, `status`) VALUES
(1, 'Superusuario', 1),
(2, 'Administrador', 1),
(3, 'Usuario', 1),
(4, 'Vendedor', 1),
(7, 'Finanzas', 1),
(8, 'Gerente', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `password_usuario` text NOT NULL,
  `email_usuario` varchar(100) NOT NULL,
  `id_rol_usuario` int(11) NOT NULL,
  `img_usuario` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `password_usuario`, `email_usuario`, `id_rol_usuario`, `img_usuario`, `status`) VALUES
(2, '@superusuario_24', '$2y$10$GV.Vc6usoNNUjxCa6BoaMeUSjHd/QmT0CAEosfdBSAzav53uBIbVi', 'moises2005pereira@gmail.com', 1, 'assets/img/perfiles/img_perfil_moy.jpeg', 1),
(3, '@moises_24', '$2y$10$LD2zUh7Vavwz3JhuLFD/BOuWxwstGSL0SCsbKX7D8a/s98cXA2vhS', 'david24queralez@gmail.com', 8, 'assets/img/perfiles/img_perfil_moy.jpeg', 1),
(4, '@elias_09', '$2y$10$.jDZzsEh3oSOrK71F1ryPOtcpvPQMJbhI7NFoV2ju7zZaXzR8It8a', 'eliasarma0902@gmail.com', 3, 'assets/img/perfiles/img_perfil_elias.jpg', 1),
(5, '@ismael_63', '$2y$10$kAwrYgkVIfw2nvnwa/7IL..W6nOOeOR0f6GOsV2ZVKEqhx3AN8zIa', 'ismaeltorres634@gmail.com', 3, 'assets/img/perfiles/profile.jpg', 1),
(6, '@santiago_20', '$2y$10$zdAzKuoVpiH/hyO5BHuQZOT3apFnOCWR4L5ABYA.602EEnPHy5Y3S', 'santiagoloyo2005@gmail.com', 3, 'assets/img/perfiles/profile.jpg', 1),
(7, '@edgmairys_01', '$2y$10$3xKR7Q.Mpx0Jvs2mg/xHwuQNkp9goGuWNTkb.lTQcKWYKO3MT/Ch.', 'edgmarrispena@gmail.com', 3, 'assets/img/perfiles/profile.jpg', 1),
(8, '@profe_01', '$2y$10$ogEa9Kr/7j9E49bVqQtUoO42kC15fB9GEYNZk.pmMnREkBAh2RLpq', 'profe@gmail.com', 3, 'assets/img/perfiles/profile.jpg', 1),
(9, '@prueba_01', '$2y$10$GNuQlgjM2CNuRQot1N0HcugdZAelx2uDPckoBgBzZ8xTDfmyhzUrS', 'prueba1@gmail.com', 3, 'assets/img/perfiles/profile.jpg', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accesos`
--
ALTER TABLE `accesos`
  ADD PRIMARY KEY (`id_accesos`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `id_modulo` (`id_modulo`),
  ADD KEY `id_permiso` (`id_permiso`);

--
-- Indices de la tabla `bitacoras`
--
ALTER TABLE `bitacoras`
  ADD PRIMARY KEY (`id_bitacora`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulo`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id_notificaciones`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id_permisos`);

--
-- Indices de la tabla `recuperar_codigos`
--
ALTER TABLE `recuperar_codigos`
  ADD PRIMARY KEY (`id_recuperar_codigo`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_rol_usuario` (`id_rol_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accesos`
--
ALTER TABLE `accesos`
  MODIFY `id_accesos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=459;

--
-- AUTO_INCREMENT de la tabla `bitacoras`
--
ALTER TABLE `bitacoras`
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=426;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id_notificaciones` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permisos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `recuperar_codigos`
--
ALTER TABLE `recuperar_codigos`
  MODIFY `id_recuperar_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accesos`
--
ALTER TABLE `accesos`
  ADD CONSTRAINT `accesos_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accesos_ibfk_2` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accesos_ibfk_3` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id_permisos`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `bitacoras`
--
ALTER TABLE `bitacoras`
  ADD CONSTRAINT `bitacoras_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recuperar_codigos`
--
ALTER TABLE `recuperar_codigos`
  ADD CONSTRAINT `recuperar_codigos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol_usuario`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
