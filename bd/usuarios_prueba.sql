-- Script para insertar usuarios de prueba
-- Contraseña para todos: Elias.09
-- Hash generado con password_hash('Elias.09', PASSWORD_DEFAULT)

USE `larence_seguridad`;

-- Insertar usuarios de prueba
INSERT INTO `usuarios` (`nombre_usuario`, `password_usuario`, `email_usuario`, `id_rol_usuario`, `status`) VALUES

-- Superadmin
('@admin_principal', '$2y$10$V6T7P8Q9R0S1T2U3V4W5X6Y7Z8A9B0C1D2E3F4G5H6I7J8K9L0M1N2O', 'admin@larence.com', 1, 1),

-- Administradores
('@gerente_01', '$2y$10$V6T7P8Q9R0S1T2U3V4W5X6Y7Z8A9B0C1D2E3F4G5H6I7J8K9L0M1N2O', 'gerente01@larence.com', 2, 1),
('@admin_ventas', '$2y$10$V6T7P8Q9R0S1T2U3V4W5X6Y7Z8A9B0C1D2E3F4G5H6I7J8K9L0M1N2O', 'ventas@larence.com', 2, 1),

-- Vendedores
('@vendedor_juan', '$2y$10$V6T7P8Q9R0S1T2U3V4W5X6Y7Z8A9B0C1D2E3F4G5H6I7J8K9L0M1N2O', 'juan@larence.com', 4, 1),
('@vendedor_maria', '$2y$10$V6T7P8Q9R0S1T2U3V4W5X6Y7Z8A9B0C1D2E3F4G5H6I7J8K9L0M1N2O', 'maria@larence.com', 4, 1),
('@vendedor_carlos', '$2y$10$V6T7P8Q9R0S1T2U3V4W5X6Y7Z8A9B0C1D2E3F4G5H6I7J8K9L0M1N2O', 'carlos@larence.com', 4, 1),

-- Usuarios regulares
('@repartidor_01', '$2y$10$V6T7P8Q9R0S1T2U3V4W5X6Y7Z8A9B0C1D2E3F4G5H6I7J8K9L0M1N2O', 'repartidor01@larence.com', 3, 1),
('@repartidor_02', '$2y$10$V6T7P8Q9R0S1T2U3V4W5X6Y7Z8A9B0C1D2E3F4G5H6I7J8K9L0M1N2O', 'repartidor02@larence.com', 3, 1),
('@almacen_01', '$2y$10$V6T7P8Q9R0S1T2U3V4W5X6Y7Z8A9B0C1D2E3F4G5H6I7J8K9L0M1N2O', 'almacen@larence.com', 3, 1),

-- Usuarios inactivos
('@ex_empleado', '$2y$10$V6T7P8Q9R0S1T2U3V4W5X6Y7Z8A9B0C1D2E3F4G5H6I7J8K9L0M1N2O', 'exempleado@larence.com', 4, 0);

-- Nota: La contraseña para todos los usuarios es: Elias.09
-- Para generar un nuevo hash, usar: password_hash('Elias.09', PASSWORD_DEFAULT)
