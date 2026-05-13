<?php
// llama al modelo conexion
require_once "ConexionModel.php";

// se define la clase
class CuentaPagar extends Conexion {

    // Atributos
    private $cuenta_id;
    private $cuenta_proveedor_id;
    private $cuenta_monto;
    private $cuenta_fecha_pago;
    private $cuenta_concepto;
    private $cuenta_referencia;
    private $cuenta_metodo;

    // constructor
    public function __construct() {
        parent::__construct();
    }

    // SETTER para datos completos
    private function setPagarData($cuenta_json) {

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

        // Validar proveedor_id
        $proveedor_id = trim($cuenta['proveedor'] ?? '');
        if ($proveedor_id === '' || !preg_match($expre_id, $proveedor_id) || strlen($proveedor_id) > 10 || $proveedor_id < 0) {
            return ['status' => false, 'msj' => 'El ID del proveedor es invalido'];
        }
        $this->cuenta_proveedor_id = $proveedor_id;

        // Validar monto
        $monto = trim($cuenta['monto'] ?? '');
        if ($monto === '' || !is_numeric($monto) || $monto <= 0) {
            return ['status' => false, 'msj' => 'El monto es invalido. Debe ser mayor a 0.'];
        }
        if (!preg_match($expre_decimal, $monto)) {
            return ['status' => false, 'msj' => 'El monto debe tener máximo 2 decimales.'];
        }
        $this->cuenta_monto = $monto;

        // Validar fecha de emisión
        $fecha_pago = trim($cuenta['fecha'] ?? '');
        if ($fecha_pago === '' || !preg_match($expre_fecha, $fecha_pago)) {
            return ['status' => false, 'msj' => 'La fecha es requerida.'];
        }
        $this->cuenta_fecha_pago = $fecha_pago;

        // Validar descripción
        $concepto = trim($cuenta['concepto'] ?? '');
        if ($concepto === '' || strlen($concepto) > 300) {
            return ['status' => false, 'msj' => 'El concepto es requerida y debe tener máximo 300 caracteres.'];
        }
        $this->cuenta_concepto = $concepto;

        // Validar referencia
        $referencia = trim($cuenta['referencia'] ?? '');
        if ($referencia === '' || !is_numeric($referencia) || $referencia <= 0) {
            return ['status' => false, 'msj' => 'la referencia es invalido. Debe ser mayor a 0.'];
        }
        $this->cuenta_referencia = $referencia;

        // Validar monto
        $metodo = trim($cuenta['metodo'] ?? '');
        if ($metodo === '' || !is_numeric($metodo) || $metodo <= 0) {
            return ['status' => false, 'msj' => 'El metodo es invalido.'];
        }
        $this->cuenta_metodo = $metodo;

        return ['status' => true, 'msj' => 'Datos validados y asignados correctamente.'];
    }

    // SETTER para ID
    private function setPagarID($cuenta_json) {
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
    private function getCuentaID() { 
        
        //retorna valor
        return $this->cuenta_id;
    }

    private function getCuentaCProveedorID() { 
        
        //retorna valor
        return $this->cuenta_proveedor_id; 
    }
    
    private function getCuentaMonto() { 

        //retorna valor
        return $this->cuenta_monto; 
    }
    
    private function getCuentaFechaPago() { 

        //retorna valor
        return $this->cuenta_fecha_pago; 
    }
    
    private function getCuentaMetodo() { 

        //retorna valor
        return $this->cuenta_metodo; 
    }
    
    private function getCuentaConcepto() {
        
        //retorna valor
        return $this->cuenta_concepto; 
    }

    private function getCuentaReferencia() {
        
        //retorna valor
        return $this->cuenta_referencia; 
    }

    // Manejador de acciones
    public function manejarAccion($action, $cuenta_json) {

        // maneja el action y carga la funcion correspondiente a la action
        switch($action) {

            case 'obtener':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setPagarID($cuenta_json);

                // valida si el status es true o false
                if (!$validacion['status']) {

                    // retorna el status con el mensaje
                    return $validacion;
                }

                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Obtener_Cuenta();

            // termina el script
            break;

            case 'consultar':

                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Mostrar_Cuenta();

            // termina el script
            break;

            case 'consultar_metodo':

                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Mostrar_Metodo_Pago();

            // termina el script
            break;

            case 'registrar_pago':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setPagarData($cuenta_json);

                // valida si el status es true o false
                if (!$validacion['status']) {

                    // retorna el status con el mensaje
                    return $validacion;
                }

                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Registrar_Pago();

            // termina el script
            break;

            default:

                // retorna mensaje derro en acion
                return ['status' => false, 'msj' => 'Accion Invalida.'];

            //termina el script
            break;
        }
    }

    // Función para consultar cuentas por cobrar
    private function Mostrar_Cuenta() {

        // conexion cerrada
        $this->closeConnection();

        try {

            // establece conecion
            $conn = $this->getConnectionNegocio();

            // consulta para mostrar
            $query = "SELECT cp.*, 
                            p.tipo_id,
                            p.nombre_proveedor
                            FROM cuenta_x_pagar cp
                            LEFT JOIN proveedores p ON cp.id_proveedor = p.id_proveedor
                            WHERE cp.status = 1
                            ORDER BY cp.fecha_vencimiento ASC";

            //prepara la consulta
            $stmt = $conn->prepare($query);

            // ejecuta consulta
            $stmt->execute();

            // valida si se ejecuto
            if ($stmt->rowCount() > 0) {

                // se almacena los datos
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // retorna mensaje de exito
                return ['status' => true, 'msj' => 'Cuentas encontradas con exito.', 'data' => $data];
            } else {

                //retorna mensaje de error
                return ['status' => false, 'msj' => 'No hay cuentas por pagar registradas.'];
            }
        } catch (PDOException $e) {

            // retorna mensaje de error con exception
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } 
        finally {

            // cierra la conexion
            $this->closeConnection();
        }
    }

    // Función para obtener una cuenta
    private function Obtener_Cuenta() {

        // conexion cerrada
        $this->closeConnection();

        // manejo de errores
        try {

            // establece conexcion
            $conn = $this->getConnectionNegocio();

            // consulta para obtener la cuenta
            $query = "SELECT cp.*, 
                             p.nombre_proveedor, 
                             p.tipo_id
                             FROM cuenta_x_pagar cp
                             LEFT JOIN proveedores p ON cp.id_proveedor = p.id_proveedor
                             WHERE cp.id_cuenta_x_pagar = :id AND cp.status = 1";

            // prepara la consulta
            $stmt = $conn->prepare($query);

            // vincula los datos 
            $stmt->bindValue(':id', $this->getCuentaID());
            
            // ejecuta la consulta
            $stmt->execute();

            // valida si se ejecuto la consulta
            if ($stmt->rowCount() > 0) {

                // almacena los datos 
                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                // retorna msj de exito
                return ['status' => true, 'msj' => 'Cuenta encontrada con éxito.', 'data' => $data, 'data_bitacora' => $data];
            } else {

                // retorna msj de exito
                return ['status' => false, 'msj' => 'Cuenta no encontrada.'];
            }
        } catch (PDOException $e) {

            // retona msj con eception
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {

            // cierra la conexion
            $this->closeConnection();
        }
    }

    // Función para registrar pago
    private function Registrar_Pago() {

        // conexion cerrada
        $this->closeConnection();

        // para manejo de errores
        try {

            // establece conexion
            $conn = $this->getConnectionNegocio();

            // incia transaccion
            $conn->beginTransaction();
            
            // consulta para Obtener saldo actual
            $query_saldo = "SELECT id_compra, saldo_pendiente, monto_total FROM cuenta_x_pagar WHERE id_cuenta_x_pagar = :id";

            // prepara la consulta
            $stmt_saldo = $conn->prepare($query_saldo);

            // vincula los datos
            $stmt_saldo->bindValue(':id', $this->getCuentaID());

            // ejecuta la cinsulta
            $stmt_saldo->execute();

            // almacena los datos obtenidos
            $cuenta = $stmt_saldo->fetch(PDO::FETCH_ASSOC);
            
            // valida si los datos no estan vacios
            if (!$cuenta) {

                // REVIERTE TRANSACCION
                $conn->rollBack();

                // retorna msj de error
                return ['status' => false, 'msj' => 'Cuenta no encontrada.'];
            }
            
            // se calcula y se define el nuevo saldo
            $compra = $cuenta['id_compra'];
            $saldo_actual = (float) $cuenta['saldo_pendiente'];
            $monto_pago = (float) $this->getCuentaMonto();
            $nuevo_saldo = $saldo_actual - $monto_pago; // nuevo saldo
            
            // valida los montos
            if ($nuevo_saldo < 0) {

                // REVIERTE TRANSACCION
                $conn->rollBack();

                // retorna msj de error
                return ['status' => false, 'msj' => 'El monto del pago excede el saldo pendiente.'];
            }
            

            // valida resultado
            if ($nuevo_saldo == 0) {

                // determina nuevo estado
                $nuevo_estado = 'Pagado';
            }else{

                // determina el estado
                $nuevo_estado = 'Por Pagar';
            }
            
            // consulta para actualizar la cuenta con el nuevo pago
            $queryInsert = "UPDATE cuenta_x_pagar 
                      SET saldo_pendiente = :saldo, estado_pago = :estado
                      WHERE id_cuenta_x_pagar = :id";
            
            // prepara la consulta
            $stmtInsert = $conn->prepare($queryInsert);

            // vincula los datos
            $stmtInsert->bindValue(':id', $this->getCuentaID());
            $stmtInsert->bindValue(':saldo', $nuevo_saldo);
            $stmtInsert->bindValue(':estado', $nuevo_estado);

            // ejecuta la consulta
            $stmtInsert->execute();

            // valida el saldo
            if( $nuevo_saldo == 0){

                // consulta para cambiar estado del pedido
                $queryPedido = "UPDATE compras SET id_estado_pago = 2
                                WHERE id_compra = :id";

                // prepra la consulta
                $stmtPedido = $conn->prepare($queryPedido);

                // vincula los datos
                $stmtPedido->bindValue(':id', $compra);

                // ejecuta la consulta
                $stmtPedido->execute();

            }

            // consulta para registrar detalle del pago en la tabla pagos
            $queryPago = "INSERT INTO pagos_proveedores (id_cuenta_x_pagar, monto, fecha_pago, nro_referencia, Concepto, id_metodo_pago)
                                    VALUES (:cuenta, :monto, :fecha, :referencia, :concepto, :metodo)";

            // prepara la consulta
            $stmtPago = $conn->prepare($queryPago);

            // vincula los datos
            $stmtPago->bindValue(':cuenta', $this->getCuentaID());
            $stmtPago->bindValue(':monto', $this->getCuentaMonto());
            $stmtPago->bindValue(':fecha', $this->getCuentaFechaPago());
            $stmtPago->bindValue(':referencia', $this->getCuentaReferencia());
            $stmtPago->bindValue(':concepto', $this->getCuentaConcepto());
            $stmtPago->bindValue(':metodo', $this->getCuentaMetodo());

            // valida y ejecuta la consulta
            if ($stmtPago->execute()) {

                // confirma
                $conn->commit();

                // retorna msj de exito
                return ['status' => true, 'msj' => 'Pago registrado.'];
            } else {

                // REVIERTE TRANSACCION
                $conn->rollBack();

                //retorna msj de error
                return ['status' => false, 'msj' => 'Error al registrar el pago.'];
            }
        } catch (PDOException $e) {

            // REVIERTE TRANSACCION
            $conn->rollBack();

            // retorna msj de error con eception
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {

            //cierra conexion
            $this->closeConnection();
        }
    }

    private function Mostrar_Metodo_Pago() {

        // conexion cerrada
        $this->closeConnection();

        try {

            // establece conecion
            $conn = $this->getConnectionNegocio();

            // consulta para mostrar
            $query = "SELECT *
                            FROM metodos_pago ";

            //prepara la consulta
            $stmt = $conn->prepare($query);

            // ejecuta consulta
            $stmt->execute();

            // valida si se ejecuto
            if ($stmt->rowCount() > 0) {

                // se almacena los datos
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // retorna mensaje de exito
                return ['status' => true, 'msj' => 'Metodos encontradas con exito.', 'data' => $data];
            } else {

                //retorna mensaje de error
                return ['status' => false, 'msj' => 'No hay metodos registradas.'];
            }
        } catch (PDOException $e) {

            // retorna mensaje de error con exception
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } 
        finally {

            // cierra la conexion
            $this->closeConnection();
        }
    }
}
?>
