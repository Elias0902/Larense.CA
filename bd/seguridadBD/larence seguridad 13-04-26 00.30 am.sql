-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-04-2026 a las 06:04:12
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
  `id_usuario` int(11) NOT NULL,
  `modulo` varchar(100) NOT NULL,
  `accion` varchar(100) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `fecha_bitacora` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `bitacoras`
--

INSERT INTO `bitacoras` (`id_bitacora`, `id_usuario`, `modulo`, `accion`, `descripcion`, `fecha_bitacora`) VALUES
(1, 3, 'Autenticacion', 'Inicio de sesion exitoso [Tabla: usuarios] [Op: LOGIN]', 'Usuario inicio sesion en el sistema', '2026-04-12 21:23:40.000000'),
(2, 2, 'Autenticacion', 'Inicio de sesion exitoso [Tabla: usuarios] [Op: LOGIN]', 'Usuario inicio sesion en el sistema', '2026-04-12 21:33:34.000000'),
(3, 2, 'Autenticacion', 'Inicio de sesion exitoso [Tabla: usuarios] [Op: LOGIN]', 'Usuario inicio sesion en el sistema', '2026-04-12 21:35:29.000000'),
(4, 2, 'Autenticacion', 'Inicio de sesion exitoso [Tabla: usuarios] [Op: LOGIN]', 'Usuario inicio sesion en el sistema', '2026-04-12 21:50:22.000000'),
(5, 2, 'Categorias', 'Registro creado [Tabla: categorias] [Op: INSERT]', 'Categoria registrada: Bebidas', '2026-04-12 21:50:41.000000'),
(6, 2, 'Categorias', 'Registro actualizado [Tabla: categorias] [Op: UPDATE]', 'Categoria actualizada: Reposteria', '2026-04-12 21:51:05.000000'),
(7, 2, 'Categorias', 'Registro eliminado [Tabla: categorias] [Op: DELETE]', 'Categoria eliminada (status=0): Reposteria', '2026-04-12 21:51:10.000000'),
(8, 2, 'Productos', 'Registro creado [Tabla: productos] [Op: INSERT]', 'Producto registrado: Elefante Php', '2026-04-12 21:51:51.000000'),
(9, 2, 'Productos', 'Registro actualizado [Tabla: productos] [Op: UPDATE]', 'Producto actualizado: Elefante Php laravel', '2026-04-12 21:52:43.000000'),
(10, 2, 'Productos', 'Registro eliminado [Tabla: productos] [Op: DELETE]', 'Producto eliminado (status=0): Elefante Php laravel', '2026-04-12 21:52:52.000000'),
(11, 2, 'Materias primas', 'Registro creado [Tabla: materia_prima] [Op: INSERT]', 'Materia prima registrada', '2026-04-12 21:53:53.000000'),
(12, 2, 'Materias primas', 'Registro actualizado [Tabla: materia_prima] [Op: UPDATE]', 'Materia prima actualizada', '2026-04-12 21:54:20.000000'),
(13, 2, 'Materias primas', 'Registro eliminado [Tabla: materia_prima] [Op: DELETE]', 'Materia prima eliminada', '2026-04-12 21:54:27.000000'),
(14, 2, 'Clientes', 'Registro creado [Tabla: clientes] [Op: INSERT]', 'Cliente creado', '2026-04-12 22:00:02.000000'),
(15, 2, 'Clientes', 'Registro actualizado [Tabla: clientes] [Op: UPDATE]', 'Cliente actualizado', '2026-04-12 22:01:06.000000'),
(16, 2, 'Clientes', 'Registro eliminado [Tabla: clientes] [Op: DELETE]', 'Cliente eliminado', '2026-04-12 22:01:14.000000'),
(17, 2, 'Autenticacion', 'Solicitud de recuperacion de password [Tabla: recuperar_codigos] [Op: SELECT]', 'Usuario solicito recuperacion de password', '2026-04-12 23:05:00.000000'),
(18, 2, 'Autenticacion', 'Solicitud de recuperacion de password [Tabla: recuperar_codigos] [Op: SELECT]', 'Usuario solicito recuperacion de password', '2026-04-12 23:10:03.000000'),
(19, 2, 'Autenticacion', 'Solicitud de recuperacion de password [Tabla: recuperar_codigos] [Op: SELECT]', 'Usuario solicito recuperacion de password', '2026-04-12 23:13:29.000000'),
(20, 2, 'Autenticacion', 'Solicitud de recuperacion de password [Tabla: recuperar_codigos] [Op: SELECT]', 'Usuario solicito recuperacion de password', '2026-04-12 23:16:44.000000'),
(21, 2, 'Autenticacion', 'Registro actualizado [Tabla: usuarios] [Op: UPDATE]', 'Password actualizada exitosamente via recuperacion', '2026-04-12 23:17:19.000000'),
(22, 2, 'Autenticacion', 'Inicio de sesion exitoso [Tabla: usuarios] [Op: LOGIN]', 'Usuario inicio sesion en el sistema', '2026-04-12 23:17:26.000000'),
(23, 2, 'Autenticacion', 'Solicitud de recuperacion de password [Tabla: recuperar_codigos] [Op: SELECT]', 'Usuario solicito recuperacion de password', '2026-04-12 23:17:48.000000'),
(24, 2, 'Autenticacion', 'Registro actualizado [Tabla: usuarios] [Op: UPDATE]', 'Password actualizada exitosamente via recuperacion', '2026-04-12 23:18:14.000000'),
(25, 2, 'Autenticacion', 'Inicio de sesion exitoso [Tabla: usuarios] [Op: LOGIN]', 'Usuario inicio sesion en el sistema', '2026-04-12 23:18:27.000000'),
(26, 4, 'Autenticacion', 'Inicio de sesion exitoso [Tabla: usuarios] [Op: LOGIN]', 'Usuario inicio sesion en el sistema', '2026-04-12 23:25:19.000000'),
(27, 5, 'Autenticacion', 'Inicio de sesion exitoso [Tabla: usuarios] [Op: LOGIN]', 'Usuario inicio sesion en el sistema', '2026-04-12 23:28:29.000000'),
(28, 6, 'Autenticacion', 'Inicio de sesion exitoso [Tabla: usuarios] [Op: LOGIN]', 'Usuario inicio sesion en el sistema', '2026-04-12 23:31:10.000000'),
(29, 7, 'Autenticacion', 'Inicio de sesion exitoso [Tabla: usuarios] [Op: LOGIN]', 'Usuario inicio sesion en el sistema', '2026-04-12 23:35:16.000000'),
(30, 2, 'Autenticacion', 'Solicitud de recuperacion de password [Tabla: recuperar_codigos] [Op: SELECT]', 'Usuario solicito recuperacion de password', '2026-04-12 23:53:25.000000'),
(31, 2, 'Autenticacion', 'Solicitud de recuperacion de password [Tabla: recuperar_codigos] [Op: SELECT]', 'Usuario solicito recuperacion de password', '2026-04-12 23:55:24.000000'),
(32, 2, 'Autenticacion', 'Solicitud de recuperacion de password [Tabla: recuperar_codigos] [Op: SELECT]', 'Usuario solicito recuperacion de password', '2026-04-12 23:57:03.000000');

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
(12, 2, 927081, '36c191d1933ac744a0f5b61dcc08242fbe8726a146f0101b95ac7341ff1ee9a0', '2026-04-13 00:56:59.000000', 0, '0000-00-00 00:00:00.000000');

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
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `password_usuario`, `email_usuario`, `id_rol_usuario`, `status`) VALUES
(2, '@superusuario_24', '$2y$10$5Im261slXfOi5BgQ/loM0.oLTkBwmcAGYj0xKzaAZ8FmQDdbN3Jpy', 'moises2005pereira@gmail.com', 1, 1),
(3, '@moises_24', '$2y$10$LD2zUh7Vavwz3JhuLFD/BOuWxwstGSL0SCsbKX7D8a/s98cXA2vhS', 'david24queralez@gmail.com', 4, 1),
(4, '@elias_09', '$2y$10$.jDZzsEh3oSOrK71F1ryPOtcpvPQMJbhI7NFoV2ju7zZaXzR8It8a', 'eliasarma0902@gmail.com', 3, 1),
(5, '@ismael_63', '$2y$10$kAwrYgkVIfw2nvnwa/7IL..W6nOOeOR0f6GOsV2ZVKEqhx3AN8zIa', 'ismaeltorres634@gmail.com', 3, 1),
(6, '@santiago_20', '$2y$10$zdAzKuoVpiH/hyO5BHuQZOT3apFnOCWR4L5ABYA.602EEnPHy5Y3S', 'santiagoloyo2005@gmail.com', 3, 1),
(7, '@edgmairys_01', '$2y$10$3xKR7Q.Mpx0Jvs2mg/xHwuQNkp9goGuWNTkb.lTQcKWYKO3MT/Ch.', 'edgmarrispena@gmail.com', 3, 1);

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
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
  MODIFY `id_recuperar_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
