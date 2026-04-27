<?php
// llama al modelo conexion
require_once "ConexionModel.php";
require_once "AuditoriaModel.php";

// se define la clase
class Pago extends Conexion {

    // Atributos
    private $pago_id;
    private $pago_pedido_id;
    private $pago_cliente_id;
    private $pago_monto;
    private $pago_metodo;
    private $pago_referencia;
    private $pago_fecha;
    private $pago_estado;
    private $pago_observaciones;

    // constructor
    public function __construct() {
        parent::__construct();
    }

    // SETTER para datos completos
    private function setPagoData($pago_json) {

        // valida si el json es string y lo descompone
        if (is_string($pago_json)) {
            $pago = json_decode($pago_json, true);
            if ($pago === null) {
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        } else {
            $pago = $pago_json;
        }

        // expresiones regulares y validaciones
        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $expre_monto = '/^\d+(\.\d{1,2})?$/';
        $expre_fecha = '/^\d{4}-\d{2}-\d{2}$/';
        $expre_referencia = '/^[a-zA-Z0-9\-]{0,50}$/';

        // Validar ID
        $id = trim($pago['id'] ?? '');
        if ($id !== '' && (!preg_match($expre_id, $id) || strlen($id) > 10 || $id < 0)) {
            return ['status' => false, 'msj' => 'El ID del pago es invalido'];
        }
        $this->pago_id = $id;

        // Validar pedido_id (opcional)
        $pedido_id = trim($pago['pedido_id'] ?? '');
        if ($pedido_id !== '' && (!preg_match($expre_id, $pedido_id) || strlen($pedido_id) > 10 || $pedido_id < 0)) {
            return ['status' => false, 'msj' => 'El ID del pedido es invalido'];
        }
        $this->pago_pedido_id = $pedido_id;

        // Validar cliente_id
        $cliente_id = trim($pago['cliente_id'] ?? '');
        if ($cliente_id === '' || !preg_match($expre_id, $cliente_id) || strlen($cliente_id) > 10 || $cliente_id < 0) {
            return ['status' => false, 'msj' => 'El ID del cliente es invalido'];
        }
        $this->pago_cliente_id = $cliente_id;

        // Validar monto
        $monto = trim($pago['monto'] ?? '');
        if ($monto === '' || !is_numeric($monto) || $monto <= 0) {
            return ['status' => false, 'msj' => 'El monto del pago es invalido. Debe ser mayor a 0.'];
        }
        if (!preg_match($expre_monto, $monto)) {
            return ['status' => false, 'msj' => 'El monto debe tener máximo 2 decimales.'];
        }
        $this->pago_monto = $monto;

        // Validar método de pago
        $metodo = trim($pago['metodo'] ?? '');
        $metodos_permitidos = ['efectivo', 'transferencia', 'debito', 'credito', 'biopago', 'pago_movil', 'zelle'];
        if ($metodo === '' || !in_array($metodo, $metodos_permitidos)) {
            return ['status' => false, 'msj' => 'El método de pago es inválido. Debe ser: efectivo, transferencia, debito, credito, biopago, pago_movil o zelle.'];
        }
        $this->pago_metodo = $metodo;

        // Validar referencia (opcional)
        $referencia = trim($pago['referencia'] ?? '');
        if ($referencia !== '' && !preg_match($expre_referencia, $referencia)) {
            return ['status' => false, 'msj' => 'La referencia solo puede contener letras, números y guiones (máx 50 caracteres).'];
        }
        $this->pago_referencia = $referencia;

        // Validar fecha
        $fecha = trim($pago['fecha'] ?? '');
        if ($fecha === '' || !preg_match($expre_fecha, $fecha)) {
            return ['status' => false, 'msj' => 'La fecha debe tener formato YYYY-MM-DD.'];
        }
        $this->pago_fecha = $fecha;

        // Validar estado
        $estado = trim($pago['estado'] ?? '1');
        $estados_permitidos = ['0', '1', 'completado', 'pendiente', 'anulado'];
        if (!in_array($estado, $estados_permitidos)) {
            return ['status' => false, 'msj' => 'El estado del pago es inválido.'];
        }
        if ($estado === 'completado' || $estado === '1') {
            $this->pago_estado = 1;
        } else if ($estado === 'pendiente') {
            $this->pago_estado = 0;
        } else {
            $this->pago_estado = 0;
        }

        // Validar observaciones (opcional)
        $observaciones = trim($pago['observaciones'] ?? '');
        if (strlen($observaciones) > 500) {
            return ['status' => false, 'msj' => 'Las observaciones no pueden exceder 500 caracteres.'];
        }
        $this->pago_observaciones = $observaciones;

        return ['status' => true, 'msj' => 'Datos validados y asignados correctamente.'];
    }

    // SETTER para ID
    private function setPagoID($pago_json) {
        if (is_string($pago_json)) {
            $pago = json_decode($pago_json, true);
            if ($pago === null) {
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        } else {
            $pago = $pago_json;
        }

        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $id = trim($pago['id'] ?? '');
        if ($id === '' || !preg_match($expre_id, $id) || strlen($id) > 10 || $id < 0) {
            return ['status' => false, 'msj' => 'El ID del pago es invalido'];
        }
        $this->pago_id = $id;

        return ['status' => true, 'msj' => 'ID validado correctamente.'];
    }

    // GETTERS
    private function getPagoID() {
        return $this->pago_id;
    }

    private function getPagoPedidoID() {
        return $this->pago_pedido_id;
    }

    private function getPagoClienteID() {
        return $this->pago_cliente_id;
    }

    private function getPagoMonto() {
        return $this->pago_monto;
    }

    private function getPagoMetodo() {
        return $this->pago_metodo;
    }

    private function getPagoReferencia() {
        return $this->pago_referencia;
    }

    private function getPagoFecha() {
        return $this->pago_fecha;
    }

    private function getPagoEstado() {
        return $this->pago_estado;
    }

    private function getPagoObservaciones() {
        return $this->pago_observaciones;
    }

    // Manejador de acciones
    public function manejarAccion($action, $pago_json) {
        switch($action) {
            case 'agregar':
                $validacion = $this->setPagoData($pago_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Guardar_Pago();
            break;

            case 'obtener':
                $validacion = $this->setPagoID($pago_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Obtener_Pago();
            break;

            case 'modificar':
                $validacion = $this->setPagoData($pago_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Actualizar_Pago();
            break;

            case 'eliminar':
                $validacion = $this->setPagoID($pago_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Eliminar_Pago();
            break;

            case 'consultar':
                return $this->Mostrar_Pago();
            break;

            case 'consultar_por_cliente':
                $validacion = $this->setPagoID($pago_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Mostrar_PagoPorCliente();
            break;

            case 'cambiar_estado':
                $validacion = $this->setPagoID($pago_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                $nuevo_estado = isset($pago_json['nuevo_estado']) ? $pago_json['nuevo_estado'] : null;
                return $this->CambiarEstado_Pago($nuevo_estado);
            break;

            default:
                return ['status' => false, 'msj' => 'Accion Invalida.'];
            break;
        }
    }

    // Función para consultar pagos
    private function Mostrar_Pago() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT p.*, c.nombre_cliente 
                      FROM pagos p
                      LEFT JOIN clientes c ON p.cliente_id = c.id_cliente
                      WHERE p.status = 1 
                      ORDER BY p.id_pago DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return ['status' => true, 'msj' => 'Pagos encontrados con exito.', 'data' => $data];
            } else {
                return ['status' => false, 'msj' => 'No hay pagos registrados.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para consultar pagos por cliente
    private function Mostrar_PagoPorCliente() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT p.*, c.nombre_cliente 
                      FROM pagos p
                      LEFT JOIN clientes c ON p.cliente_id = c.id_cliente
                      WHERE p.cliente_id = :cliente_id AND p.status = 1 
                      ORDER BY p.id_pago DESC";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':cliente_id', $this->getPagoClienteID());
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return ['status' => true, 'msj' => 'Pagos del cliente encontrados.', 'data' => $data];
            } else {
                return ['status' => false, 'msj' => 'No hay pagos para este cliente.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para guardar pago
    private function Guardar_Pago() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "INSERT INTO pagos (pedido_id, cliente_id, monto, metodo_pago, referencia, fecha_pago, status, observaciones)
                      VALUES (:pedido_id, :cliente_id, :monto, :metodo, :referencia, :fecha, :estado, :observaciones)";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':pedido_id', $this->getPagoPedidoID() ?: null);
            $stmt->bindValue(':cliente_id', $this->getPagoClienteID());
            $stmt->bindValue(':monto', $this->getPagoMonto());
            $stmt->bindValue(':metodo', $this->getPagoMetodo());
            $stmt->bindValue(':referencia', $this->getPagoReferencia());
            $stmt->bindValue(':fecha', $this->getPagoFecha());
            $stmt->bindValue(':estado', $this->getPagoEstado());
            $stmt->bindValue(':observaciones', $this->getPagoObservaciones());

            if ($stmt->execute()) {
                $insertedId = $conn->lastInsertId();
                if ($insertedId) {
                    $this->registrarAuditoria('Pagos', Auditoria::OP_INSERT, 'pagos', $insertedId, 'Pago registrado');
                }
                return ['status' => true, 'msj' => 'Pago registrado con éxito.'];
            } else {
                return ['status' => false, 'msj' => 'Error al registrar el pago.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para obtener un pago
    private function Obtener_Pago() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT p.*, c.nombre_cliente 
                      FROM pagos p
                      LEFT JOIN clientes c ON p.cliente_id = c.id_cliente
                      WHERE p.id_pago = :id AND p.status = 1";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getPagoID());
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return ['status' => true, 'msj' => 'Pago encontrado con éxito.', 'data' => $data];
            } else {
                return ['status' => false, 'msj' => 'Pago no encontrado.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para actualizar pago
    private function Actualizar_Pago() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "UPDATE pagos 
                      SET pedido_id = :pedido_id,
                          cliente_id = :cliente_id,
                          monto = :monto,
                          metodo_pago = :metodo,
                          referencia = :referencia,
                          fecha_pago = :fecha,
                          status = :estado,
                          observaciones = :observaciones
                      WHERE id_pago = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getPagoID());
            $stmt->bindValue(':pedido_id', $this->getPagoPedidoID() ?: null);
            $stmt->bindValue(':cliente_id', $this->getPagoClienteID());
            $stmt->bindValue(':monto', $this->getPagoMonto());
            $stmt->bindValue(':metodo', $this->getPagoMetodo());
            $stmt->bindValue(':referencia', $this->getPagoReferencia());
            $stmt->bindValue(':fecha', $this->getPagoFecha());
            $stmt->bindValue(':estado', $this->getPagoEstado());
            $stmt->bindValue(':observaciones', $this->getPagoObservaciones());

            if ($stmt->execute()) {
                $this->registrarAuditoria('Pagos', Auditoria::OP_UPDATE, 'pagos', $this->getPagoID(), 'Pago actualizado');
                return ['status' => true, 'msj' => 'Pago actualizado con éxito.'];
            } else {
                return ['status' => false, 'msj' => 'Error al actualizar el pago.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para eliminar (desactivar) pago
    private function Eliminar_Pago() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "UPDATE pagos SET status = 0 WHERE id_pago = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getPagoID());

            if ($stmt->execute()) {
                $this->registrarAuditoria('Pagos', Auditoria::OP_DELETE, 'pagos', $this->getPagoID(), 'Pago eliminado');
                return ['status' => true, 'msj' => 'Pago eliminado con éxito.'];
            } else {
                return ['status' => false, 'msj' => 'Error al eliminar el pago.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para cambiar estado del pago
    private function CambiarEstado_Pago($nuevo_estado) {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $estado = ($nuevo_estado === 'completado' || $nuevo_estado === '1' || $nuevo_estado === 1) ? 1 : 0;
            $query = "UPDATE pagos SET status = :estado WHERE id_pago = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getPagoID());
            $stmt->bindValue(':estado', $estado);

            if ($stmt->execute()) {
                $this->registrarAuditoria('Pagos', Auditoria::OP_UPDATE, 'pagos', $this->getPagoID(), 'Estado de pago cambiado');
                $msg = $estado ? 'completado' : 'marcado como pendiente';
                return ['status' => true, 'msj' => 'Pago ' . $msg . ' con éxito.'];
            } else {
                return ['status' => false, 'msj' => 'Error al cambiar el estado del pago.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }
}
?>
