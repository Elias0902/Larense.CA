<?php
// llama al modelo conexion
require_once "ConexionModel.php";

// se define la clase
class CuentaCobrar extends Conexion {

    // Atributos
    private $cuenta_id;
    private $cuenta_cliente_id;
    private $cuenta_pedido_id;
    private $cuenta_monto;
    private $cuenta_saldo;
    private $cuenta_fecha_emision;
    private $cuenta_fecha_vencimiento;
    private $cuenta_estado;
    private $cuenta_descripcion;

    // constructor
    public function __construct() {
        parent::__construct();
    }

    // SETTER para datos completos
    private function setCobrarData($cuenta_json) {

        // valida si el json es string y lo descompone
        if (is_string($cuenta_json)) {
            $cuenta = json_decode($cuenta_json, true);
            if ($cuenta === null) {
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        } else {
            $cuenta = $cuenta_json;
        }

        // expresiones regulares y validaciones
        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $expre_fecha = '/^\d{4}-\d{2}-\d{2}$/';
        $expre_decimal = '/^\d+(\.\d{1,2})?$/';

        // Validar ID
        $id = trim($cuenta['id'] ?? '');
        if ($id !== '' && (!preg_match($expre_id, $id) || strlen($id) > 10 || $id < 0)) {
            return ['status' => false, 'msj' => 'El ID de la cuenta es invalido'];
        }
        $this->cuenta_id = $id;

        // Validar cliente_id
        $cliente_id = trim($cuenta['cliente_id'] ?? '');
        if ($cliente_id === '' || !preg_match($expre_id, $cliente_id) || strlen($cliente_id) > 10 || $cliente_id < 0) {
            return ['status' => false, 'msj' => 'El ID del cliente es invalido'];
        }
        $this->cuenta_cliente_id = $cliente_id;

        // Validar pedido_id (opcional)
        $pedido_id = trim($cuenta['pedido_id'] ?? '');
        if ($pedido_id !== '' && (!preg_match($expre_id, $pedido_id) || strlen($pedido_id) > 10 || $pedido_id < 0)) {
            return ['status' => false, 'msj' => 'El ID del pedido es invalido'];
        }
        $this->cuenta_pedido_id = $pedido_id ?: null;

        // Validar monto
        $monto = trim($cuenta['monto'] ?? '');
        if ($monto === '' || !is_numeric($monto) || $monto <= 0) {
            return ['status' => false, 'msj' => 'El monto es invalido. Debe ser mayor a 0.'];
        }
        if (!preg_match($expre_decimal, $monto)) {
            return ['status' => false, 'msj' => 'El monto debe tener máximo 2 decimales.'];
        }
        $this->cuenta_monto = $monto;

        // Validar saldo (si no se proporciona, es igual al monto)
        $saldo = trim($cuenta['saldo'] ?? $monto);
        if (!is_numeric($saldo) || $saldo < 0 || $saldo > $monto) {
            return ['status' => false, 'msj' => 'El saldo es invalido.'];
        }
        $this->cuenta_saldo = $saldo;

        // Validar fecha de emisión
        $fecha_emision = trim($cuenta['fecha_emision'] ?? '');
        if ($fecha_emision === '' || !preg_match($expre_fecha, $fecha_emision)) {
            return ['status' => false, 'msj' => 'La fecha de emisión es requerida.'];
        }
        $this->cuenta_fecha_emision = $fecha_emision;

        // Validar fecha de vencimiento
        $fecha_vencimiento = trim($cuenta['fecha_vencimiento'] ?? '');
        if ($fecha_vencimiento === '' || !preg_match($expre_fecha, $fecha_vencimiento)) {
            return ['status' => false, 'msj' => 'La fecha de vencimiento es requerida.'];
        }
        if ($fecha_vencimiento < $fecha_emision) {
            return ['status' => false, 'msj' => 'La fecha de vencimiento no puede ser anterior a la fecha de emisión.'];
        }
        $this->cuenta_fecha_vencimiento = $fecha_vencimiento;

        // Validar estado
        $estado = trim($cuenta['estado'] ?? 'pendiente');
        $estados_permitidos = ['pendiente', 'parcial', 'pagada', 'vencida', 'anulada'];
        if (!in_array($estado, $estados_permitidos)) {
            return ['status' => false, 'msj' => 'El estado es inválido.'];
        }
        $this->cuenta_estado = $estado;

        // Validar descripción
        $descripcion = trim($cuenta['descripcion'] ?? '');
        if ($descripcion === '' || strlen($descripcion) > 300) {
            return ['status' => false, 'msj' => 'La descripción es requerida y debe tener máximo 300 caracteres.'];
        }
        $this->cuenta_descripcion = $descripcion;

        return ['status' => true, 'msj' => 'Datos validados y asignados correctamente.'];
    }

    // SETTER para ID
    private function setCobrarID($cuenta_json) {
        if (is_string($cuenta_json)) {
            $cuenta = json_decode($cuenta_json, true);
            if ($cuenta === null) {
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        } else {
            $cuenta = $cuenta_json;
        }

        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $id = trim($cuenta['id'] ?? '');
        if ($id === '' || !preg_match($expre_id, $id) || strlen($id) > 10 || $id < 0) {
            return ['status' => false, 'msj' => 'El ID de la cuenta es invalido'];
        }
        $this->cuenta_id = $id;

        return ['status' => true, 'msj' => 'ID validado correctamente.'];
    }

    // GETTERS
    private function getCuentaID() { return $this->cuenta_id; }
    private function getCuentaClienteID() { return $this->cuenta_cliente_id; }
    private function getCuentaPedidoID() { return $this->cuenta_pedido_id; }
    private function getCuentaMonto() { return $this->cuenta_monto; }
    private function getCuentaSaldo() { return $this->cuenta_saldo; }
    private function getCuentaFechaEmision() { return $this->cuenta_fecha_emision; }
    private function getCuentaFechaVencimiento() { return $this->cuenta_fecha_vencimiento; }
    private function getCuentaEstado() { return $this->cuenta_estado; }
    private function getCuentaDescripcion() { return $this->cuenta_descripcion; }

    // Manejador de acciones
    public function manejarAccion($action, $cuenta_json) {
        switch($action) {
            case 'agregar':
                $validacion = $this->setCobrarData($cuenta_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Guardar_Cuenta();
            break;

            case 'obtener':
                $validacion = $this->setCobrarID($cuenta_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Obtener_Cuenta();
            break;

            case 'modificar':
                $validacion = $this->setCobrarData($cuenta_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Actualizar_Cuenta();
            break;

            case 'eliminar':
                $validacion = $this->setCobrarID($cuenta_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Eliminar_Cuenta();
            break;

            case 'consultar':
                return $this->Mostrar_Cuenta();
            break;

            case 'registrar_pago':
                $validacion = $this->setCobrarID($cuenta_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                $monto_pago = isset($cuenta_json['monto_pago']) ? $cuenta_json['monto_pago'] : 0;
                return $this->Registrar_Pago($monto_pago);
            break;

            case 'cambiar_estado':
                $validacion = $this->setCobrarID($cuenta_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                $nuevo_estado = isset($cuenta_json['nuevo_estado']) ? $cuenta_json['nuevo_estado'] : null;
                return $this->CambiarEstado_Cuenta($nuevo_estado);
            break;

            default:
                return ['status' => false, 'msj' => 'Accion Invalida.'];
            break;
        }
    }

    // Función para consultar cuentas por cobrar
    private function Mostrar_Cuenta() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT cc.*, c.nombre_cliente, c.apellido_cliente 
                      FROM cuentas_cobrar cc
                      LEFT JOIN clientes c ON cc.cliente_id = c.id_cliente
                      WHERE cc.status = 1 
                      ORDER BY cc.fecha_vencimiento ASC";
            $stmt = $conn->prepare($query);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return ['status' => true, 'msj' => 'Cuentas encontradas con exito.', 'data' => $data];
            } else {
                return ['status' => false, 'msj' => 'No hay cuentas por cobrar registradas.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para guardar cuenta
    private function Guardar_Cuenta() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "INSERT INTO cuentas_cobrar (cliente_id, pedido_id, monto, saldo, fecha_emision, fecha_vencimiento, estado, descripcion)
                      VALUES (:cliente_id, :pedido_id, :monto, :saldo, :fecha_emision, :fecha_vencimiento, :estado, :descripcion)";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':cliente_id', $this->getCuentaClienteID());
            $stmt->bindValue(':pedido_id', $this->getCuentaPedidoID());
            $stmt->bindValue(':monto', $this->getCuentaMonto());
            $stmt->bindValue(':saldo', $this->getCuentaSaldo());
            $stmt->bindValue(':fecha_emision', $this->getCuentaFechaEmision());
            $stmt->bindValue(':fecha_vencimiento', $this->getCuentaFechaVencimiento());
            $stmt->bindValue(':estado', $this->getCuentaEstado());
            $stmt->bindValue(':descripcion', $this->getCuentaDescripcion());

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Cuenta por cobrar registrada con éxito.'];
            } else {
                return ['status' => false, 'msj' => 'Error al registrar la cuenta.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para obtener una cuenta
    private function Obtener_Cuenta() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT cc.*, c.nombre_cliente, c.apellido_cliente 
                      FROM cuentas_cobrar cc
                      LEFT JOIN clientes c ON cc.cliente_id = c.id_cliente
                      WHERE cc.id_cuenta_cobrar = :id AND cc.status = 1";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getCuentaID());
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return ['status' => true, 'msj' => 'Cuenta encontrada con éxito.', 'data' => $data];
            } else {
                return ['status' => false, 'msj' => 'Cuenta no encontrada.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para actualizar cuenta
    private function Actualizar_Cuenta() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "UPDATE cuentas_cobrar 
                      SET cliente_id = :cliente_id,
                          pedido_id = :pedido_id,
                          monto = :monto,
                          saldo = :saldo,
                          fecha_emision = :fecha_emision,
                          fecha_vencimiento = :fecha_vencimiento,
                          estado = :estado,
                          descripcion = :descripcion
                      WHERE id_cuenta_cobrar = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getCuentaID());
            $stmt->bindValue(':cliente_id', $this->getCuentaClienteID());
            $stmt->bindValue(':pedido_id', $this->getCuentaPedidoID());
            $stmt->bindValue(':monto', $this->getCuentaMonto());
            $stmt->bindValue(':saldo', $this->getCuentaSaldo());
            $stmt->bindValue(':fecha_emision', $this->getCuentaFechaEmision());
            $stmt->bindValue(':fecha_vencimiento', $this->getCuentaFechaVencimiento());
            $stmt->bindValue(':estado', $this->getCuentaEstado());
            $stmt->bindValue(':descripcion', $this->getCuentaDescripcion());

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Cuenta actualizada con éxito.'];
            } else {
                return ['status' => false, 'msj' => 'Error al actualizar la cuenta.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para eliminar (desactivar) cuenta
    private function Eliminar_Cuenta() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "UPDATE cuentas_cobrar SET status = 0 WHERE id_cuenta_cobrar = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getCuentaID());

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Cuenta eliminada con éxito.'];
            } else {
                return ['status' => false, 'msj' => 'Error al eliminar la cuenta.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para registrar pago
    private function Registrar_Pago($monto_pago) {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            
            // Obtener saldo actual
            $query_saldo = "SELECT saldo, monto FROM cuentas_cobrar WHERE id_cuenta_cobrar = :id";
            $stmt_saldo = $conn->prepare($query_saldo);
            $stmt_saldo->bindValue(':id', $this->getCuentaID());
            $stmt_saldo->execute();
            $cuenta = $stmt_saldo->fetch(PDO::FETCH_ASSOC);
            
            if (!$cuenta) {
                return ['status' => false, 'msj' => 'Cuenta no encontrada.'];
            }
            
            $saldo_actual = $cuenta['saldo'];
            $nuevo_saldo = $saldo_actual - $monto_pago;
            
            if ($nuevo_saldo < 0) {
                return ['status' => false, 'msj' => 'El monto del pago excede el saldo pendiente.'];
            }
            
            // Determinar nuevo estado
            $nuevo_estado = 'parcial';
            if ($nuevo_saldo == 0) {
                $nuevo_estado = 'pagada';
            }
            
            $query = "UPDATE cuentas_cobrar 
                      SET saldo = :saldo, estado = :estado
                      WHERE id_cuenta_cobrar = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getCuentaID());
            $stmt->bindValue(':saldo', $nuevo_saldo);
            $stmt->bindValue(':estado', $nuevo_estado);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Pago registrado. Saldo restante: $' . number_format($nuevo_saldo, 2)];
            } else {
                return ['status' => false, 'msj' => 'Error al registrar el pago.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para cambiar estado
    private function CambiarEstado_Cuenta($nuevo_estado) {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "UPDATE cuentas_cobrar SET estado = :estado WHERE id_cuenta_cobrar = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getCuentaID());
            $stmt->bindValue(':estado', $nuevo_estado);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Estado actualizado a: ' . $nuevo_estado];
            } else {
                return ['status' => false, 'msj' => 'Error al cambiar el estado.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }
}
?>
