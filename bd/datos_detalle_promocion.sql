-- Datos de prueba para la tabla puente detalle_promocion
-- Base de datos: larence

USE larence;

-- Insertar productos asociados a la promoción 2x1 (ID: 1)
INSERT INTO detalle_promocion (id_promocion, id_producto) VALUES 
(1, 3),  -- Galletas dulces Natys con sabor a coco
(1, 7),  -- Galletas Natys dulces con sabor a Limon
(1, 2);  -- Galletas Natys dulces con sabor a Naranja

-- Insertar productos asociados a la promoción 10% (ID: 2)
INSERT INTO detalle_promocion (id_promocion, id_producto) VALUES 
(2, 5),  -- Galletas Natys Saladitas queso chedar
(2, 6),  -- Gatellas Natys Polvosas con sabor a vainilla
(2, 4);  -- Gatelltas Natys Chocoking

-- Insertar productos asociados a la promoción VERANO (ID: 3)
INSERT INTO detalle_promocion (id_promocion, id_producto) VALUES 
(3, 8),  -- Galletas Natys dulces con sabor a Colita
(3, 9);  -- Elefante Php laravel

-- Verificar los datos insertados
SELECT 
    dp.id_detalle_promocion,
    dp.id_promocion,
    p.nombre_promocion,
    p.codigo_promocion,
    dp.id_producto,
    pr.nombre_producto,
    pr.precio_venta
FROM detalle_promocion dp
INNER JOIN promociones p ON dp.id_promocion = p.id_promocion
INNER JOIN productos pr ON dp.id_producto = pr.id_producto
ORDER BY dp.id_promocion, dp.id_detalle_promocion;
