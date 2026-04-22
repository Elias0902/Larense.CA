-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-04-2026 a las 19:23:28
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacoras`
--

CREATE TABLE `bitacoras` (
  `id_bitacora` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `modulo` varchar(100) NOT NULL,
  `accion` varchar(100) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `fecha_bitacora` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `bitacoras`
--

INSERT INTO `bitacoras` (`id_bitacora`, `id_usuario`, `modulo`, `accion`, `descripcion`, `fecha_bitacora`) VALUES
(59, 8, 'Autenticator', 'Cerrar Session', 'El usuario: @profe_01 ha Cerrado session en el sistema.', '2026-04-15 13:18:31.000000');

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
(16, 'Usuario'),
(17, 'Roles');

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
(20, 2, 140873, 'f26e427947885ec44a5d664527874338c48546c34616254dc3bb44ad604a1995', '2026-04-15 13:56:18.000000', 1, '0000-00-00 00:00:00.000000');

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
(4, 'Vendedor', 1);

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
(2, '@superusuario_24', '$2y$10$yE0P4IsU7C8iyGNSIedK4uMmw2DFOA9Kn89q5GYGfZqda.tNDziyq', 'moises2005pereira@gmail.com', 1, 'assets/img/perfiles/img_perfil_moy.jpeg', 1),
(3, '@moises_24', '$2y$10$LD2zUh7Vavwz3JhuLFD/BOuWxwstGSL0SCsbKX7D8a/s98cXA2vhS', 'david24queralez@gmail.com', 4, 'assets/img/perfiles/img_perfil_moy.jpeg', 1),
(4, '@elias_09', '$2y$10$.jDZzsEh3oSOrK71F1ryPOtcpvPQMJbhI7NFoV2ju7zZaXzR8It8a', 'eliasarma0902@gmail.com', 3, 'assets/img/perfiles/img_perfil_elias.jpg', 1),
(5, '@ismael_63', '$2y$10$kAwrYgkVIfw2nvnwa/7IL..W6nOOeOR0f6GOsV2ZVKEqhx3AN8zIa', 'ismaeltorres634@gmail.com', 3, 'assets/img/perfiles/profile.jpg', 1),
(6, '@santiago_20', '$2y$10$zdAzKuoVpiH/hyO5BHuQZOT3apFnOCWR4L5ABYA.602EEnPHy5Y3S', 'santiagoloyo2005@gmail.com', 3, 'assets/img/perfiles/profile.jpg', 1),
(7, '@edgmairys_01', '$2y$10$3xKR7Q.Mpx0Jvs2mg/xHwuQNkp9goGuWNTkb.lTQcKWYKO3MT/Ch.', 'edgmarrispena@gmail.com', 3, 'assets/img/perfiles/profile.jpg', 1),
(8, '@profe_01', '$2y$10$ogEa9Kr/7j9E49bVqQtUoO42kC15fB9GEYNZk.pmMnREkBAh2RLpq', 'profe@gmail.com', 1, 'assets/img/perfiles/profile.jpg', 1);

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
  MODIFY `id_accesos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bitacoras`
--
ALTER TABLE `bitacoras`
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id_notificaciones` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permisos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recuperar_codigos`
--
ALTER TABLE `recuperar_codigos`
  MODIFY `id_recuperar_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
