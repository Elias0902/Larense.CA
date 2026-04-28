<?php
// llama al modelo conexion
require_once "ConexionModel.php";

// se define la clase
class Pedido extends Conexion {

    // Atributos
    private $pedido_id;
    private $pedido_cliente_id;
    private $pedido_fecha;
    private $pedido_total;
    private $pedido_estado;
    private $pedido_direccion_entrega;
    private $pedido_telefono;
    private $pedido_observaciones;
    private $pedido_promocion_id;

    // constructor
    public function __construct() {
        parent::__construct();
    }

    // SETTER para datos completos
    private function setPedidoData($pedido_json) {

        // valida si el json es string y lo descompone
        if (is_string($pedido_json)) {
            $pedido = json_decode($pedido_json, true);
            if ($pedido === null) {
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        } else {
            $pedido = $pedido_json;
        }

        // expresiones regulares y validaciones
        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $expre_telefono = '/^[0-9]{4}-[0-9]{7}$/';
        $expre_fecha = '/^\d{4}-\d{2}-\d{2}$/';
        $expre_decimal = '/^\d+(\.\d{1,2})?$/';

        // Validar ID
        $id = trim($pedido['id'] ?? '');
        if ($id !== '' && (!preg_match($expre_id, $id) || strlen($id) > 10 || $id < 0)) {
            return ['status' => false, 'msj' => 'El ID del pedido es invalido'];
        }
        $this->pedido_id = $id;

        // Validar cliente_id
        $cliente_id = trim($pedido['cliente_id'] ?? '');
        if ($cliente_id === '' || !preg_match($expre_id, $cliente_id) || strlen($cliente_id) > 10 || $cliente_id < 0) {
            return ['status' => false, 'msj' => 'El ID del cliente es invalido'];
        }
        $this->pedido_cliente_id = $cliente_id;

        // Validar fecha
        $fecha = trim($pedido['fecha'] ?? '');
        if ($fecha === '' || !preg_match($expre_fecha, $fecha)) {
            return ['status' => false, 'msj' => 'La fecha debe tener formato YYYY-MM-DD.'];
        }
        $this->pedido_fecha = $fecha;

        // Validar total
        $total = trim($pedido['total'] ?? '');
        if ($total === '' || !is_numeric($total) || $total < 0) {
            return ['status' => false, 'msj' => 'El total del pedido es invalido.'];
        }
        if (!preg_match($expre_decimal, $total)) {
            return ['status' => false, 'msj' => 'El total debe tener máximo 2 decimales.'];
        }
        $this->pedido_total = $total;

        // Validar estado
        $estado = trim($pedido['estado'] ?? 'pendiente');
        $estados_permitidos = ['pendiente', 'procesando', 'enviado', 'entregado', 'cancelado'];
        if (!in_array($estado, $estados_permitidos)) {
            return ['status' => false, 'msj' => 'El estado del pedido es inválido. Debe ser: pendiente, procesando, enviado, entregado o cancelado.'];
        }
        $this->pedido_estado = $estado;

        // Validar dirección de entrega (opcional)
        $direccion = trim($pedido['direccion_entrega'] ?? '');
        if (strlen($direccion) > 300) {
            return ['status' => false, 'msj' => 'La dirección no puede exceder 300 caracteres.'];
        }
        $this->pedido_direccion_entrega = $direccion;

        // Validar teléfono (opcional)
        $telefono = trim($pedido['telefono'] ?? '');
        if ($telefono !== '' && !preg_match($expre_telefono, $telefono)) {
            return ['status' => false, 'msj' => 'El teléfono debe tener formato: 04XX-XXXXXXX'];
        }
        $this->pedido_telefono = $telefono;

        // Validar observaciones (opcional)
        $observaciones = trim($pedido['observaciones'] ?? '');
        if (strlen($observaciones) > 500) {
            return ['status' => false, 'msj' => 'Las observaciones no pueden exceder 500 caracteres.'];
        }
        $this->pedido_observaciones = $observaciones;

        // Validar promoción_id (opcional)
        $promocion_id = trim($pedido['promocion_id'] ?? '');
        if ($promocion_id !== '' && (!preg_match($expre_id, $promocion_id) || strlen($promocion_id) > 10 || $promocion_id < 0)) {
            return ['status' => false, 'msj' => 'El ID de la promoción es invalido'];
        }
        $this->pedido_promocion_id = $promocion_id ?: null;

        return ['status' => true, 'msj' => 'Datos validados y asignados correctamente.'];
    }

    // SETTER para ID
    private function setPedidoID($pedido_json) {
        if (is_string($pedido_json)) {
            $pedido = json_decode($pedido_json, true);
            if ($pedido === null) {
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        } else {
            $pedido = $pedido_json;
        }

        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $id = trim($pedido['id'] ?? '');
        if ($id === '' || !preg_match($expre_id, $id) || strlen($id) > 10 || $id < 0) {
            return ['status' => false, 'msj' => 'El ID del pedido es invalido'];
        }
        $this->pedido_id = $id;

        return ['status' => true, 'msj' => 'ID validado correctamente.'];
    }

    // GETTERS
    private function getPedidoID() {
        return $this->pedido_id;
    }

    private function getPedidoClienteID() {
        return $this->pedido_cliente_id;
    }

    private function getPedidoFecha() {
        return $this->pedido_fecha;
    }

    private function getPedidoTotal() {
        return $this->pedido_total;
    }

    private function getPedidoEstado() {
        return $this->pedido_estado;
    }

    private function getPedidoDireccion() {
        return $this->pedido_direccion_entrega;
    }

    private function getPedidoTelefono() {
        return $this->pedido_telefono;
    }

    private function getPedidoObservaciones() {
        return $this->pedido_observaciones;
    }

    private function getPedidoPromocionID() {
        return $this->pedido_promocion_id;
    }

    // Manejador de acciones
    public function manejarAccion($action, $pedido_json) {
        switch($action) {
            case 'agregar':
                $validacion = $this->setPedidoData($pedido_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                $resultado = $this->Guardar_Pedido();
                if ($resultado['status'] && isset($pedido_json['productos'])) {
                    $this->Guardar_Productos_Pedido($pedido_json['productos']);
                }
                return $resultado;
            break;

            case 'obtener':
                $validacion = $this->setPedidoID($pedido_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Obtener_Pedido();
            break;

            case 'obtener_productos':
                $validacion = $this->setPedidoID($pedido_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Obtener_Productos_Pedido();
            break;

            case 'modificar':
                $validacion = $this->setPedidoData($pedido_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                $resultado = $this->Actualizar_Pedido();
                if ($resultado['status'] && isset($pedido_json['productos'])) {
                    $this->Guardar_Productos_Pedido($pedido_json['productos']);
                }
                return $resultado;
            break;

            case 'eliminar':
                $validacion = $this->setPedidoID($pedido_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                $this->Eliminar_Productos_Pedido();
                return $this->Eliminar_Pedido();
            break;

            case 'consultar':
                return $this->Mostrar_Pedidos_Con_Productos();
            break;

            case 'cambiar_estado':
                $validacion = $this->setPedidoID($pedido_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                $nuevo_estado = isset($pedido_json['nuevo_estado']) ? $pedido_json['nuevo_estado'] : null;
                return $this->CambiarEstado_Pedido($nuevo_estado);
            break;

            default:
                return ['status' => false, 'msj' => 'Accion Invalida.'];
            break;
        }
    }

    // Función para consultar pedidos
    private function Mostrar_Pedido() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT p.*, c.nombre_cliente, pr.codigo_promocion, pr.nombre_promocion 
                      FROM pedidos p
                      LEFT JOIN clientes c ON p.cliente_id = c.id_cliente
                      LEFT JOIN promociones pr ON p.promocion_id = pr.id_promocion
                      WHERE p.status = 1 
                      ORDER BY p.id_pedido DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return ['status' => true, 'msj' => 'Pedidos encontrados con exito.', 'data' => $data];
            } else {
                return ['status' => false, 'msj' => 'No hay pedidos registrados.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para guardar pedido
    private function Guardar_Pedido() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "INSERT INTO pedidos (cliente_id, fecha_pedido, total, estado, direccion_entrega, telefono_contacto, observaciones, promocion_id)
                      VALUES (:cliente_id, :fecha, :total, :estado, :direccion, :telefono, :observaciones, :promocion_id)";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':cliente_id', $this->getPedidoClienteID());
            $stmt->bindValue(':fecha', $this->getPedidoFecha());
            $stmt->bindValue(':total', $this->getPedidoTotal());
            $stmt->bindValue(':estado', $this->getPedidoEstado());
            $stmt->bindValue(':direccion', $this->getPedidoDireccion());
            $stmt->bindValue(':telefono', $this->getPedidoTelefono());
            $stmt->bindValue(':observaciones', $this->getPedidoObservaciones());
            $stmt->bindValue(':promocion_id', $this->getPedidoPromocionID());

            if ($stmt->execute()) {
                // Obtener el ID del pedido recién insertado
                $ultimo_id = $conn->lastInsertId();
                $this->pedido_id = $ultimo_id;
                
                $this->registrarAuditoria('Pedidos', Auditoria::OP_INSERT, 'pedidos', $ultimo_id, 'Pedido creado');
                return ['status' => true, 'msj' => 'Pedido registrado con éxito.', 'id' => $ultimo_id];
            } else {
                return ['status' => false, 'msj' => 'Error al registrar el pedido.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para obtener un pedido
    private function Obtener_Pedido() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT p.*, c.nombre_cliente, pr.codigo_promocion, pr.nombre_promocion 
                      FROM pedidos p
                      LEFT JOIN clientes c ON p.cliente_id = c.id_cliente
                      LEFT JOIN promociones pr ON p.promocion_id = pr.id_promocion
                      WHERE p.id_pedido = :id AND p.status = 1";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getPedidoID());
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return ['status' => true, 'msj' => 'Pedido encontrado con éxito.', 'data' => $data];
            } else {
                return ['status' => false, 'msj' => 'Pedido no encontrado.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para actualizar pedido
    private function Actualizar_Pedido() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "UPDATE pedidos 
                      SET cliente_id = :cliente_id,
                          fecha_pedido = :fecha,
                          total = :total,
                          estado = :estado,
                          direccion_entrega = :direccion,
                          telefono_contacto = :telefono,
                          observaciones = :observaciones,
                          promocion_id = :promocion_id
                      WHERE id_pedido = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getPedidoID());
            $stmt->bindValue(':cliente_id', $this->getPedidoClienteID());
            $stmt->bindValue(':fecha', $this->getPedidoFecha());
            $stmt->bindValue(':total', $this->getPedidoTotal());
            $stmt->bindValue(':estado', $this->getPedidoEstado());
            $stmt->bindValue(':direccion', $this->getPedidoDireccion());
            $stmt->bindValue(':telefono', $this->getPedidoTelefono());
            $stmt->bindValue(':observaciones', $this->getPedidoObservaciones());
            $stmt->bindValue(':promocion_id', $this->getPedidoPromocionID());

            if ($stmt->execute()) {
                $this->registrarAuditoria('Pedidos', Auditoria::OP_UPDATE, 'pedidos', $this->getPedidoID(), 'Pedido actualizado');
                return ['status' => true, 'msj' => 'Pedido actualizado con éxito.'];
            } else {
                return ['status' => false, 'msj' => 'Error al actualizar el pedido.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para eliminar (desactivar) pedido
    private function Eliminar_Pedido() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "UPDATE pedidos SET status = 0 WHERE id_pedido = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getPedidoID());

            if ($stmt->execute()) {
                $this->registrarAuditoria('Pedidos', Auditoria::OP_DELETE, 'pedidos', $this->getPedidoID(), 'Pedido eliminado');
                return ['status' => true, 'msj' => 'Pedido eliminado con éxito.'];
            } else {
                return ['status' => false, 'msj' => 'Error al eliminar el pedido.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para cambiar estado del pedido
    private function CambiarEstado_Pedido($nuevo_estado) {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "UPDATE pedidos SET estado = :estado WHERE id_pedido = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getPedidoID());
            $stmt->bindValue(':estado', $nuevo_estado);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Estado del pedido actualizado a: ' . $nuevo_estado];
            } else {
                return ['status' => false, 'msj' => 'Error al cambiar el estado del pedido.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para guardar productos asociados a un pedido
    private function Guardar_Productos_Pedido($productos) {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $id_pedido = $this->getPedidoID();

            // Primero eliminar los productos existentes para este pedido
            $query_delete = "DELETE FROM detalle_pedidos WHERE id_pedido = :id_pedido";
            $stmt_delete = $conn->prepare($query_delete);
            $stmt_delete->bindValue(':id_pedido', $id_pedido);
            $stmt_delete->execute();

            // Insertar los nuevos productos
            if (!empty($productos) && is_array($productos)) {
                $query_insert = "INSERT INTO detalle_pedidos (id_pedido, id_producto, cantidad, precio_unitario) 
                                 VALUES (:id_pedido, :id_producto, :cantidad, :precio_unitario)";
                $stmt_insert = $conn->prepare($query_insert);

                foreach ($productos as $producto) {
                    $stmt_insert->bindValue(':id_pedido', $id_pedido);
                    $stmt_insert->bindValue(':id_producto', $producto['id_producto']);
                    $stmt_insert->bindValue(':cantidad', $producto['cantidad']);
                    $stmt_insert->bindValue(':precio_unitario', $producto['precio_unitario']);
                    $stmt_insert->execute();
                }
            }

            return ['status' => true, 'msj' => 'Productos asociados correctamente.'];
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error al asociar productos: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para obtener productos de un pedido
    private function Obtener_Productos_Pedido() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT dp.id_detalle_pedido, dp.id_producto, dp.cantidad, dp.precio_unitario, 
                             p.nombre_producto, p.precio_venta
                      FROM detalle_pedidos dp
                      INNER JOIN productos p ON dp.id_producto = p.id_producto
                      WHERE dp.id_pedido = :id_pedido AND p.status = 1";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id_pedido', $this->getPedidoID());
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return ['status' => true, 'msj' => 'Productos encontrados.', 'data' => $data];
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error al obtener productos: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para eliminar productos de un pedido
    private function Eliminar_Productos_Pedido() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "DELETE FROM detalle_pedidos WHERE id_pedido = :id_pedido";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id_pedido', $this->getPedidoID());

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Productos eliminados correctamente.'];
            } else {
                return ['status' => false, 'msj' => 'Error al eliminar productos.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error al eliminar productos: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para obtener todos los pedidos con sus productos
    private function Mostrar_Pedidos_Con_Productos() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT p.*,
                             (SELECT GROUP_CONCAT(pr.nombre_producto SEPARATOR ', ')
                              FROM detalle_pedidos dp
                              INNER JOIN productos pr ON dp.id_producto = pr.id_producto
                              WHERE dp.id_pedido = p.id_pedido AND pr.status = 1) as productos
                      FROM pedidos p
                      WHERE p.status = 1
                      ORDER BY p.id_pedido DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return ['status' => true, 'msj' => 'Pedidos encontrados con éxito.', 'data' => $data];
            } else {
                return ['status' => false, 'msj' => 'No hay pedidos registrados.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }
}
?>
