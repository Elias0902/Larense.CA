<?php
// llama al modelo conexion
require_once "ConexionModel.php";

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

        // conexion cerrada
        $this->closeConnection();

        // para manejo de errores
        try {

            // establece conexion
            $conn = $this->getConnectionNegocio();

            // Iniciar transacción 
            $conn->beginTransaction();

            // consulta para pagos proveedores
            $queryProveedor = "SELECT pp.*,
                            pp.id_pago_proveedor as pago,
                            pp.monto as monto_pago,
                            c.id_compra as ID, 
                            p.tipo_id,
                            p.id_proveedor as id,
                            c.id_estado_pago,
                            ep.nombre_estado,
                            p.nombre_proveedor as nombre,
                            mp.nombre_metodo 
                      FROM pagos_proveedores pp
                      LEFT JOIN metodos_pago mp ON mp.id_metodo_pago = pp.id_metodo_pago
                      LEFT JOIN cuenta_x_pagar cp ON cp.id_cuenta_x_pagar = pp.id_cuenta_x_pagar
                      LEFT JOIN compras c ON c.id_compra = cp.id_compra
                      LEFT JOIN estado_pago ep ON ep.id_estado_pago = c.id_estado_pago
                      LEFT JOIN proveedores p ON p.id_proveedor = cp.id_proveedor
                      ORDER BY pp.id_pago_proveedor DESC";

            // prepara la consulta
            $stmtProveedor = $conn->prepare($queryProveedor);
            
            // ejecuta la consulta
            $stmtProveedor->execute();

            // consulta para pagos clientes
            $queryCliente = "SELECT p.*, 
                            p.id_pago as pago,
                            p.id_pedido as ID,
                            c.tipo_id,
                            c.id_cliente as id,
                            pd.id_estado_pago,
                            ep.nombre_estado,
                            c.nombre_cliente as nombre,
                            mp.nombre_metodo 
                      FROM pagos p
                      LEFT JOIN metodos_pago mp ON mp.id_metodo_pago = p.id_metodo_pago
                      LEFT JOIN pedidos pd ON pd.id_pedido = p.id_pedido
                      LEFT JOIN estado_pago ep ON ep.id_estado_pago = pd.id_estado_pago
                      LEFT JOIN clientes c ON c.id_cliente = pd.id_cliente
                      ORDER BY p.id_pago DESC";

            // prepara la consulta
            $stmtCliente = $conn->prepare($queryCliente);

            // ejecuta la consulta
            $stmtCliente->execute();

            // Confirmar transacción
            $conn->commit();

            // almacena los datos
            $dataCliente = $stmtCliente->fetchAll(PDO::FETCH_ASSOC);
            $dataProveedor = $stmtProveedor->fetchAll(PDO::FETCH_ASSOC);

            //retorna msj de exito
            return ['status' => true, 'msj' => 'Pagos encontrados con exito.', 'data_cliente' => $dataCliente, 'data_proveedor' => $dataProveedor];

        } catch (PDOException $e) {

            // revierte
            $conn->rollBack();

            // retorna msj de exito
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {

            // cierra conexion
            $this->closeConnection();
        }
    }
}
?>
