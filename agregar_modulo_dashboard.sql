-- Agregar módulo Dashboard a la tabla de modulos
INSERT INTO modulos (id_modulo, nombre_modulo) VALUES (20, 'Dashboard');

-- Agregar permisos de consulta para el dashboard a todos los roles existentes
-- Por defecto, roles 1 (Super Admin) y 2 (Gerente) tendrán acceso
-- Roles de clientes y otros tendrán acceso restringido

-- Dar acceso a Super Admin (id_rol = 1)
INSERT INTO accesos (id_rol, id_modulo, id_permiso, status) VALUES (1, 20, 2, 1);

-- Dar acceso a Gerente (id_rol = 2)
INSERT INTO accesos (id_rol, id_modulo, id_permiso, status) VALUES (2, 20, 2, 1);

-- NOTA: Los otros roles (clientes, vendedores, etc.) NO tendrán acceso por defecto
-- Se puede agregar acceso manualmente si es necesario
