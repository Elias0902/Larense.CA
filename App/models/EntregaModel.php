<?php
// llama al modelo conexion
require_once "ConexionModel.php";

// se define la clase
class Entrega extends Conexion {

    // Atributos
    private $entrega_id;
    private $entrega_pedido_id;
    private $entrega_cliente_id;
    private $entrega_direccion;
    private $entrega_telefono;
    private $entrega_fecha_programada;
    private $entrega_fecha_entrega;
    private $entrega_estado;
    private $entrega_observaciones;
    private $entrega_repartidor;

    // constructor
    public function __construct() {
        parent::__construct();
    }

    // SETTER para datos completos
    private function setEntregaUpdateData($entrega_json) {

        // valida si el json es string y lo descompone
        if (is_string($entrega_json)) {
            $entrega = json_decode($entrega_json, true);
            if ($entrega === null) {
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        } else {
            $entrega = $entrega_json;
        }

        // expresiones regulares y validaciones
        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $expre_telefono = '/^[0-9]{4}-[0-9]{7}$/';
        $expre_fecha = '/^\d{4}-\d{2}-\d{2}( \d{2}:\d{2}:\d{2})?$/';

        // Validar ID
        $id = trim($entrega['id'] ?? '');
        if ($id !== '' && (!preg_match($expre_id, $id) || strlen($id) > 10 || $id < 0)) {
            return ['status' => false, 'msj' => 'El ID de la entrega es invalido'];
        }
        $this->entrega_id = $id;

        // Validar pedido_id (opcional)
        $pedido_id = trim($entrega['pedido_id'] ?? '');
        if ($pedido_id !== '' && (!preg_match($expre_id, $pedido_id) || strlen($pedido_id) > 10 || $pedido_id < 0)) {
            return ['status' => false, 'msj' => 'El ID del pedido es invalido'];
        }
        $this->entrega_pedido_id = $pedido_id ?: null;

        // Validar cliente_id
        $cliente_id = trim($entrega['cliente_id'] ?? '');
        if ($cliente_id === '' || !preg_match($expre_id, $cliente_id) || strlen($cliente_id) > 10 || $cliente_id < 0) {
            return ['status' => false, 'msj' => 'El ID del cliente es invalido'];
        }
        $this->entrega_cliente_id = $cliente_id;

        // Validar dirección
        $direccion = trim($entrega['direccion'] ?? '');
        if ($direccion === '' || strlen($direccion) < 5 || strlen($direccion) > 300) {
            return ['status' => false, 'msj' => 'La dirección es inválida. Debe tener entre 5 y 300 caracteres.'];
        }
        $this->entrega_direccion = $direccion;

        // Validar teléfono (opcional pero recomendado)
        $telefono = trim($entrega['telefono'] ?? '');
        if ($telefono !== '' && !preg_match($expre_telefono, $telefono)) {
            return ['status' => false, 'msj' => 'El teléfono debe tener formato: 04XX-XXXXXXX'];
        }
        $this->entrega_telefono = $telefono;

        // Validar fecha programada
        $fecha_programada = trim($entrega['fecha_programada'] ?? '');
        if ($fecha_programada === '') {
            return ['status' => false, 'msj' => 'La fecha programada es requerida.'];
        }
        $this->entrega_fecha_programada = $fecha_programada;

        // Validar estado
        $estado = trim($entrega['estado']);
        if ($estado==='') {
            return ['status' => false, 'msj' => 'El estado de la entrega es inválido. Debe ser: pendiente, en_ruta, entregado o cancelado.'];
        }
        $this->entrega_estado = $estado;

        // Validar observaciones (opcional)
        $observaciones = trim($entrega['observaciones'] ?? '');
        if (strlen($observaciones) > 500) {
            return ['status' => false, 'msj' => 'Las observaciones no pueden exceder 500 caracteres.'];
        }
        $this->entrega_observaciones = $observaciones;

        // Validar repartidor (opcional)
        $repartidor = trim($entrega['repartidor'] ?? '');
        if (strlen($repartidor) > 100) {
            return ['status' => false, 'msj' => 'El nombre del repartidor no puede exceder 100 caracteres.'];
        }
        $this->entrega_repartidor = $repartidor;

        return ['status' => true, 'msj' => 'Datos validados y asignados correctamente.'];
    }

        private function setEntregaData($entrega_json) {

        // valida si el json es string y lo descompone
        if (is_string($entrega_json)) {
            $entrega = json_decode($entrega_json, true);
            if ($entrega === null) {
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        } else {
            $entrega = $entrega_json;
        }

        // expresiones regulares y validaciones
        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $expre_telefono = '/^[0-9]{4}-[0-9]{7}$/';
        $expre_fecha = '/^\d{4}-\d{2}-\d{2}( \d{2}:\d{2}:\d{2})?$/';

        // Validar pedido_id (opcional)
        $pedido_id = trim($entrega['pedido_id'] ?? '');
        if ($pedido_id !== '' && (!preg_match($expre_id, $pedido_id) || strlen($pedido_id) > 10 || $pedido_id < 0)) {
            return ['status' => false, 'msj' => 'El ID del pedido es invalido'];
        }
        $this->entrega_pedido_id = $pedido_id ?: null;

        // Validar cliente_id
        $cliente_id = trim($entrega['cliente_id'] ?? '');
        if ($cliente_id === '' || !preg_match($expre_id, $cliente_id) || strlen($cliente_id) > 10 || $cliente_id < 0) {
            return ['status' => false, 'msj' => 'El ID del cliente es invalido'];
        }
        $this->entrega_cliente_id = $cliente_id;

        // Validar dirección
        $direccion = trim($entrega['direccion'] ?? '');
        if ($direccion === '' || strlen($direccion) < 5 || strlen($direccion) > 300) {
            return ['status' => false, 'msj' => 'La dirección es inválida. Debe tener entre 5 y 300 caracteres.'];
        }
        $this->entrega_direccion = $direccion;

        // Validar teléfono (opcional pero recomendado)
        $telefono = trim($entrega['telefono'] ?? '');
        if ($telefono !== '' && !preg_match($expre_telefono, $telefono)) {
            return ['status' => false, 'msj' => 'El teléfono debe tener formato: 04XX-XXXXXXX'];
        }
        $this->entrega_telefono = $telefono;

        // Validar fecha programada
        $fecha_programada = trim($entrega['fecha_programada'] ?? '');
        if ($fecha_programada === '') {
            return ['status' => false, 'msj' => 'La fecha programada es requerida.'];
        }
        $this->entrega_fecha_programada = $fecha_programada;

        // Validar estado
        $estado = trim($entrega['estado']);
        if ($estado==='') {
            return ['status' => false, 'msj' => 'El estado de la entrega es inválido. Debe ser: pendiente, en_ruta, entregado o cancelado.'];
        }
        $this->entrega_estado = $estado;

        // Validar observaciones (opcional)
        $observaciones = trim($entrega['observaciones'] ?? '');
        if (strlen($observaciones) > 500) {
            return ['status' => false, 'msj' => 'Las observaciones no pueden exceder 500 caracteres.'];
        }
        $this->entrega_observaciones = $observaciones;

        // Validar repartidor (opcional)
        $repartidor = trim($entrega['repartidor'] ?? '');
        if (strlen($repartidor) > 100) {
            return ['status' => false, 'msj' => 'El nombre del repartidor no puede exceder 100 caracteres.'];
        }
        $this->entrega_repartidor = $repartidor;

        return ['status' => true, 'msj' => 'Datos validados y asignados correctamente.'];
    }

    // SETTER para ID
    private function setEntregaID($entrega_json) {

        // valida si el json es string y lo descompone
        if (is_string($entrega_json)) {
            $entrega = json_decode($entrega_json, true);
            if ($entrega === null) {
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        } else {
            $entrega = $entrega_json;
        }

        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $id = trim($entrega['id'] ?? '');
        if ($id === '' || !preg_match($expre_id, $id) || strlen($id) > 10 || $id < 0) {
            return ['status' => false, 'msj' => 'El ID de la entrega es invalido'];
        }
        $this->entrega_id = $id;

        return ['status' => true, 'msj' => 'ID validado correctamente.'];
    }

    // GETTERS
    private function getEntregaID() {
        return $this->entrega_id;
    }

    private function getEntregaPedidoID() {
        return $this->entrega_pedido_id;
    }

    private function getEntregaClienteID() {
        return $this->entrega_cliente_id;
    }

    private function getEntregaDireccion() {
        return $this->entrega_direccion;
    }

    private function getEntregaTelefono() {
        return $this->entrega_telefono;
    }

    private function getEntregaFechaProgramada() {
        return $this->entrega_fecha_programada;
    }

    private function getEntregaFechaEntrega() {
        return $this->entrega_fecha_entrega;
    }

    private function getEntregaEstado() {
        return $this->entrega_estado;
    }

    private function getEntregaObservaciones() {
        return $this->entrega_observaciones;
    }

    private function getEntregaRepartidor() {
        return $this->entrega_repartidor;
    }

    // Obtener nombre de estado desde ID
    private function getEstadoEntrega() {
        return $this->entrega_estado;
    }

    // Manejador de acciones
    public function manejarAccion($action, $entrega_json) {

        switch($action) {

            case 'agregar':

                // llama a validar 
                $validacion = $this->setEntregaData($entrega_json);

                // almacena el sttus de la validacion
                if (!$validacion['status']) {

                    //retorna validacion
                    return $validacion;
                }

                // retorna el modelo
                return $this->Guardar_Entrega();

            break;

            case 'obtener':

                // llama a validar
                $validacion = $this->setEntregaID($entrega_json);

                // almacena el sttus de la validacion
                if (!$validacion['status']) {

                    //retorna validacion
                    return $validacion;
                }

                // retorna el modelo
                return $this->Obtener_Entrega();
            break;

            case 'modificar':

                // llama a validar
                $validacion = $this->setEntregaData($entrega_json);

                // almacena el sttus de la validacion
                if (!$validacion['status']) {

                    //retorna validacion
                    return $validacion;
                }

                // retorna el modelo
                return $this->Actualizar_Entrega();

            break;

            case 'eliminar':

                // llama a validar
                $validacion = $this->setEntregaID($entrega_json);

                // almacena el sttus de la validacion
                if (!$validacion['status']) {

                    //retorna validacion
                    return $validacion;
                }

                // retorna el modelo
                return $this->Eliminar_Entrega();

            break;

            case 'consultar':

                // retorna el modelo
                return $this->Mostrar_Entrega();

            break;

            case 'consultarPDF':

                // retorna el modelo
                return $this->Mostrar_EntregaPDF();

            break;

            case 'consultarEntregaEstadoPDF':

                // retorna el modelo
                return $this->Mostrar_EntregaEstadoPDF($entrega_json);

            break;

            case 'consultarEntregaFechaPDF':

                // retorna el modelo
                return $this->Mostrar_EntregaFechaPDF($entrega_json);

            break;

            case 'consultar_estado':

                // retorna el modelo
                return $this->Mostrar_Estado();

            break;

            case 'confirmar_entrega':

                // llama a validar
                $validacion = $this->setEntregaID($entrega_json);

                // almacena el sttus de la validacion
                if (!$validacion['status']) {

                    //retorna validacion
                    return $validacion;
                }

                // retorna el modelo
                return $this->Confirmar_Entrega();

            break;

            case 'cambiar_estado':

                // valida el json
                if (is_string($entrega_json)) {

                    // almacena el json
                    $data = json_decode($entrega_json, true);
                } else {

                    // almacena por deafult
                    $data = $entrega_json;
                }

                // llama a validar
                $validacion = $this->setEntregaID(['id' => $data['id'] ?? '']);
                
                // valida el status de la validacion
                if (!$validacion['status']) {

                    // retorna validacion
                    return $validacion;
                }

                // define nuevo estado
                $nuevo_estado = isset($data['nuevo_estado']) ? $data['nuevo_estado'] : null;
                
                // retorna modelo
                return $this->CambiarEstado_Entrega($nuevo_estado);
            
            break;

            case 'obtener_pedidos_por_cliente':

                // retorna modelo
                return $this->ObtenerPedidosPorCliente($entrega_json);
            
            break;

            default:

                // retorna msj de error
                
            break;
        }
    }

    // Función para obtener pedidos por cliente
    private function ObtenerPedidosPorCliente($cliente_json) {
        $this->closeConnection();
        try {
            if (is_string($cliente_json)) {
                $data = json_decode($cliente_json, true);
            } else {
                $data = $cliente_json;
            }
            
            $cliente_id = $data['cliente_id'] ?? 0;
            
            if (empty($cliente_id)) {
                return ['status' => false, 'msj' => 'ID de cliente requerido', 'data' => []];
            }
            
            $conn = $this->getConnectionNegocio();
            $query = "SELECT p.id_pedido, p.monto_total_pedido, p.fecha_pedido, 
                             ep.nombre_estado as nombre_estado_pedido
                      FROM pedidos p
                      LEFT JOIN estado_pedido ep ON p.id_estado_pedido = ep.id_estado_pedido
                      WHERE p.id_cliente = :cliente_id AND p.status = 1
                      ORDER BY p.fecha_pedido DESC";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':cliente_id', $cliente_id);
            $stmt->execute();
            
            $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return ['status' => true, 'msj' => 'Pedidos encontrados', 'data' => $pedidos];
        } catch (PDOException $e) {
            error_log('Error al obtener pedidos por cliente: ' . $e->getMessage());
            return ['status' => false, 'msj' => 'Error en la consulta', 'data' => []];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para consultar entregas
    private function Mostrar_Entrega() {

        // conexion cerrada
        $this->closeConnection();

        try {

            // establece conexion
            $conn = $this->getConnectionNegocio();
            
            // Consulta mejorada con los datos completos
            $query = "SELECT e.id_entregas, 
                 e.id_pedido, 
                 e.id_clientes as cliente_id, 
                 e.direccion_entrega as direccion,
                 e.tlf_contacto as telefono_contacto,
                 e.fecha_entrega_programada as fecha_programada,
                 e.fecha_entrega_real as fecha_entrega,
                 e.repartidor,
                 e.observaciones,
                 e.id_estado_entrega as estado_id,
                 ee.nombre_estado as estado,
                 c.nombre_cliente as cliente_nombre,
                 c.tlf_cliente as tlf_cliente
          FROM entregas e
          LEFT JOIN clientes c ON e.id_clientes = c.id_cliente
          LEFT JOIN estado_entrega ee ON e.id_estado_entrega = ee.id_estado_entrega
          WHERE e.status = 1 
          ORDER BY e.fecha_entrega_programada ASC";

          // prepara la consulta
            $stmt = $conn->prepare($query);
            
            // ejecyta la consulta
            $stmt->execute();

            // valida si se ejecuto la consulta
            if ($stmt->rowCount() > 0) {

                // almacena los datos obtenido
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // retorna msj de exito
                return ['status' => true, 'msj' => 'Entregas encontradas con exito.', 'data' => $data];
            } 
            else {
            
                // retorna msj de error
                return ['status' => false, 'msj' => 'No hay entregas registradas.', 'data' => []];
            }
        } catch (PDOException $e) {

            // error log
            error_log('Error en consulta entregas: ' . $e->getMessage());
            
            // retorna msj de error
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage(), 'data' => []];
        } finally {
            
            // cierra conexion
            $this->closeConnection();
        }
    }

    // Función para guardar entrega
    private function Guardar_Entrega() {

        // conexion cerrada
        $this->closeConnection();

        try {

            // establece conexion
            $conn = $this->getConnectionNegocio();
            
            // inicia transaccion
            $conn->beginTransaction();
            
            // consulta para agregar enterga
            $query = "INSERT INTO entregas (id_pedido, id_clientes, direccion_entrega, tlf_contacto, fecha_entrega_programada, fecha_entrega_real, repartidor, observaciones, id_estado_entrega)
                      VALUES (:pedido_id, :cliente_id, :direccion, :telefono, :fecha_programada, :fecha_entrega, :repartidor, :observaciones, :estado_id)";
            
            // prepara la consulta
            $stmt = $conn->prepare($query);

            // vincula los datos
            $stmt->bindValue(':pedido_id', $this->getEntregaPedidoID());
            $stmt->bindValue(':cliente_id', $this->getEntregaClienteID());
            $stmt->bindValue(':direccion', $this->getEntregaDireccion());
            $stmt->bindValue(':telefono', $this->getEntregaTelefono());
            $stmt->bindValue(':fecha_programada', $this->getEntregaFechaProgramada());
            $stmt->bindValue(':fecha_entrega', $this->getEntregaFechaEntrega());
            $stmt->bindValue(':repartidor', $this->getEntregaRepartidor());
            $stmt->bindValue(':observaciones', $this->getEntregaObservaciones());
            $stmt->bindValue(':estado_id', $this->getEntregaEstado());

            // ejecuta la consulta
            $stmt->execute();

            // establece el estado
            $estado = 5;

            // consulta para actualizar estado del pedido
            $queryInsert = "UPDATE id_estado_pedido SET :estado FROM pedidos";

            // prepara la consulta
            $stmtInsert = $conn->prepare($queryInsert);

            // vinula los datos
            $stmtInsert->bindValue(':estado', $estado);

            // ejecuta la consulta
            $stmtInsert->execute();

            // si todo se ejecuta correctamente se confirma la transaccion
            $conn->commit();

            //retorna msj de exito
            return ['status' => true, 'msj' => 'Entrega registrada con éxito.'];

        } catch (PDOException $e) {
            
            // valida la conexion
            if ($conn->inTransaction()) {
        
                // revierte transaccion
                $conn->rollBack();  
            }
            
            // retoname msj de error
            return ['status' => false, 'msj' => 'Error al registrar la entrega.'];
        
        } 
        finally {
        
            // cierra conexion
            $this->closeConnection();
        }
    }

    // Función para obtener una entrega
    private function Obtener_Entrega() {
        
        // conexion cerrada
        $this->closeConnection();

        try {

            // establece conexion
            $conn = $this->getConnectionNegocio();
            
            // consulta para obtener
            $query = "SELECT e.id_entregas, e.id_pedido, e.id_clientes as cliente_id, 
                             e.direccion_entrega as direccion, e.tlf_contacto as telefono_contacto,
                             e.fecha_entrega_programada as fecha_programada,
                             e.fecha_entrega_real as fecha_entrega, e.repartidor, e.observaciones,
                             e.id_estado_entrega as estado_id, ee.nombre_estado as estado,
                             c.nombre_cliente, c.tlf_cliente as tlf_cliente
                      FROM entregas e
                      LEFT JOIN clientes c ON e.id_clientes = c.id_cliente
                      LEFT JOIN estado_entrega ee ON e.id_estado_entrega = ee.id_estado_entrega
                      WHERE e.id_entregas = :id AND e.status = 1";

            // prepara la consulta 
            $stmt = $conn->prepare($query);

            // vincula los datos
            $stmt->bindValue(':id', $this->getEntregaID());
            
            // ejecuta la consulta
            $stmt->execute();

            // valida si se ejecuto la consulta
            if ($stmt->rowCount() > 0) {

                // almacena los datos obtenidos
                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                // retorna msj de exito
                return ['status' => true, 'msj' => 'Entrega encontrada con éxito.', 'data' => $data];
            } 
            else {
            
                // retorna msj de error
                return ['status' => false, 'msj' => 'Entrega no encontrada.'];
            }
        } catch (PDOException $e) {
            
            // error log
            error_log('Error en Obtener_Entrega: ' . $e->getMessage());
            
            // retorna msj de error
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } 
        finally {
            
            // cierra conexion
            $this->closeConnection();
        }
    }

    // Función para actualizar entrega
    private function Actualizar_Entrega() {

        // conexion cerrada 
        $this->closeConnection();
        
        try {
        
            // establece conexion
            $conn = $this->getConnectionNegocio();
            
            // inicia transaccion
            $conn->beginTransaction();
            
            // Obtener datos actuales antes de actualizar para la bitácora
            $query_select = "SELECT * FROM entregas WHERE id_entregas = :id AND status = 1";

            // prepara la consulta
            $stmt_select = $conn->prepare($query_select);
            
            // vincula los datos
            $stmt_select->bindValue(':id', $this->getEntregaID());
            
            // ejecuta la consulta
            $stmt_select->execute();

            // almacena los datos obtenidos
            $datos_anteriores = $stmt_select->fetch(PDO::FETCH_ASSOC);
            

            // consulta para actualizar
            $query = "UPDATE entregas 
                      SET id_pedido = :pedido_id,
                          id_clientes = :cliente_id,
                          direccion_entrega = :direccion,
                          tlf_contacto = :telefono,
                          fecha_entrega_programada = :fecha_programada,
                          repartidor = :repartidor,
                          observaciones = :observaciones,
                          id_estado_entrega = :estado_id
                      WHERE id_entregas = :id AND status = 1";

            // prepara la consulta
            $stmt = $conn->prepare($query);

            // vincula los datos
            $stmt->bindValue(':id', $this->getEntregaID());
            $stmt->bindValue(':pedido_id', $this->getEntregaPedidoID());
            $stmt->bindValue(':cliente_id', $this->getEntregaClienteID());
            $stmt->bindValue(':direccion', $this->getEntregaDireccion());
            $stmt->bindValue(':telefono', $this->getEntregaTelefono());
            $stmt->bindValue(':fecha_programada', $this->getEntregaFechaProgramada());
            $stmt->bindValue(':repartidor', $this->getEntregaRepartidor());
            $stmt->bindValue(':observaciones', $this->getEntregaObservaciones());
            $stmt->bindValue(':estado_id', $this->getEntregaEstado());

            // se ejecuta y valida la ejecucion de la consulta
            if ($stmt->execute()) {

                // Si el estado es "entregado" y hay pedido asociado, actualizar estado del pedido
                if ($this->getEntregaEstado() === 'entregado' && $this->getEntregaPedidoID()) {
                    
                    // llama actualizar
                    $this->actualizarEstadoPedido($this->getEntregaPedidoID(), 5);

                } elseif ($this->getEntregaEstado() === 'en_ruta' && $this->getEntregaPedidoID()) {
                    
                    // llama actualizar
                    $this->actualizarEstadoPedido($this->getEntregaPedidoID(), 3);
                }
                
                // confirma la transaccion
                $conn->commit();

                // retorna msj de exito
                return ['status' => true, 'msj' => 'Entrega actualizada con éxito.', 'data_bitacora' => $datos_anteriores];
            } else {

                // revierte 
                $conn->rollBack();

                // retorna msj de error
                return ['status' => false, 'msj' => 'Error al actualizar la entrega.'];
            }
        } catch (PDOException $e) {

            // revierte 
            $conn->rollBack();

            // error log
            error_log('Error en Actualizar_Entrega: ' . $e->getMessage());
            
            // retorna msj de error
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } 
        finally {
        
            // cierra conexion
            $this->closeConnection();
        }
    }

    // Función para eliminar (desactivar) entrega
    private function Eliminar_Entrega() {

        //conexion cerrada 
        $this->closeConnection();
        
        try {
        
            // establece conexion
            $conn = $this->getConnectionNegocio();
            
            // inicia transaccion
            $conn->beginTransaction();
            
            // Obtener datos actuales antes de eliminar
            $query_select = "SELECT * FROM entregas WHERE id_entregas = :id AND status = 1";
            
            // prepara la consulta
            $stmt_select = $conn->prepare($query_select);
            
            //vincua los datos 
            $stmt_select->bindValue(':id', $this->getEntregaID());
            
            // ejecuta ola consulta
            $stmt_select->execute();

            // almacen alos datos
            $datos_anteriores = $stmt_select->fetch(PDO::FETCH_ASSOC);
            

            // consulta para actualizar el estado
            $query = "UPDATE entregas SET status = 0 WHERE id_entregas = :id";
            
            // prepara la consulta
            $stmt = $conn->prepare($query);

            // vincula los datos
            $stmt->bindValue(':id', $this->getEntregaID());


            // valida si se ejecuto la consulta
            if ($stmt->execute()) {
                
                // conffirma la transaccion
                $conn->commit();

                // retorna msj de exito
                return ['status' => true, 'msj' => 'Entrega eliminada con éxito.', 'data_bitacora' => $datos_anteriores];
            } else {
                
                // revierte 
                $conn->rollBack();
                
                // retorna msj de error
                return ['status' => false, 'msj' => 'Error al eliminar la entrega.'];
            }
        } catch (PDOException $e) {
            
            // revierte 
            $conn->rollBack();
            
            // eror log
            error_log('Error en Eliminar_Entrega: ' . $e->getMessage());
            
            // retorna msj de error
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } 
        finally {
        
            // cierra la conexion
            $this->closeConnection();
        }
    }

    //=============================
    // FUNCIONES PARA LOS REPORTES 
    //=============================
    private function Mostrar_EntregaPDF() {

        // conexion cerrada
        $this->closeConnection();
        
        try {
        
            //establece la conecion
            $conn = $this->getConnectionNegocio();
            
            // Consulta corregida con los nombres de columnas correctos
            $query = "SELECT e.id_entregas as Nro, 
                             CONCAT(c.tipo_id, ' ', c.id_cliente, ' ', c.nombre_cliente) as Cliente, 
                             e.direccion_entrega as Direccion, 
                             e.fecha_entrega_programada as Programada,
                             e.fecha_entrega_real as Entrega,
                             ee.nombre_estado as Estado
                      FROM entregas e
                      LEFT JOIN clientes c ON e.id_clientes = c.id_cliente
                      LEFT JOIN estado_entrega ee ON ee.id_estado_entrega = e.id_estado_entrega
                      WHERE e.status = 1 
                      ORDER BY e.fecha_entrega_programada ASC";
            
            // prepara la conecion
            $stmt = $conn->prepare($query);
            
            // ejecuta la conexion
            $stmt->execute();


            // valida si se ejecuto la consulta
            if ($stmt->rowCount() > 0) {

                // almacena los datos ontenidos
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // retorna msj de exito
                return ['status' => true, 'msj' => 'Entregas encontradas con exito.', 'data' => $data];
            } else {

                // retorna msj de error
                return ['status' => false, 'msj' => 'No hay entregas registradas.', 'data' => []];
            }
        } catch (PDOException $e) {

            // error log 
            error_log('Error en consulta entregas: ' . $e->getMessage());
            
            //retorna msj de error
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage(), 'data' => []];
        } finally {

            // cierra conexion
            $this->closeConnection();
        }
    }

    // duncion para reporte general
    private function Mostrar_EntregaEstadoPdf($estado) {

        // conexion cerrada
        $this->closeConnection();
        try {

            // establece conexion
            $conn = $this->getConnectionNegocio();
            
            // Consulta corregida con los nombres de columnas correctos
            $query = "SELECT  e.id_entregas as Nro, 
                             CONCAT(c.tipo_id, ' ', c.id_cliente, ' ', c.nombre_cliente) as Cliente, 
                             e.direccion_entrega as Direccion, 
                             e.fecha_entrega_programada as Programada,
                             e.fecha_entrega_real as Entrega,
                             ee.nombre_estado as Estado
                      FROM entregas e
                      LEFT JOIN clientes c ON e.id_clientes = c.id_cliente
                      LEFT JOIN estado_entrega ee ON ee.id_estado_entrega = e.id_estado_entrega
                      WHERE e.status = 1 AND e.id_estado_entrega = :estado
                      ORDER BY e.fecha_entrega_programada ASC";

            //prepara la consulta
            $stmt = $conn->prepare($query);

            // vincula los estados
            $stmt->bindValue(':estado', $estado);
            
            // ejecuta la consulta
            $stmt->execute();

            // valida si se ejecuto la consulta
            if ($stmt->rowCount() > 0) {

                // almacena los datos obtenidos
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // retorna msj de exito
                return ['status' => true, 'msj' => 'Entregas encontradas con exito.', 'data' => $data];
            } else {

                // retorna msj de error
                return ['status' => false, 'msj' => 'No hay entregas registradas.', 'data' => []];
            }
        } catch (PDOException $e) {

            //error log
            error_log('Error en consulta entregas: ' . $e->getMessage());
            
            // retorna msj de error
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage(), 'data' => []];
        }
         finally {

            // cierra conexion
            $this->closeConnection();
        }
    }

    // funcion de reporte pdf de entregas por fecha
    private function Mostrar_EntregaFechaPDF($fecha) {

        // conexion cerrada 
        $this->closeConnection();
        
        try {
        
            // establece conexion
            $conn = $this->getConnectionNegocio();
            
            // Consulta corregida con los nombres de columnas correctos
            $query = "SELECT  e.id_entregas as Nro, 
                             CONCAT(c.tipo_id, ' ', c.id_cliente, ' ', c.nombre_cliente) as Cliente, 
                             e.direccion_entrega as Direccion, 
                             e.fecha_entrega_programada as Programada,
                             e.fecha_entrega_real as Entrega,
                             ee.nombre_estado as Estado
                      FROM entregas e
                      LEFT JOIN clientes c ON e.id_clientes = c.id_cliente
                      LEFT JOIN estado_entrega ee ON ee.id_estado_entrega = e.id_estado_entrega
                      WHERE e.status = 1 AND e.fecha_entrega_real = :fecha
                      ORDER BY e.fecha_entrega_programada ASC";

            // prepara la consulta
            $stmt = $conn->prepare($query);
            
            // vincula los datos
            $stmt->bindValue(':fecha', $fecha);
            
            // ejecuta la consulta
            $stmt->execute();

            // valida si se ejecuto la consulta
            if ($stmt->rowCount() > 0) {

                // almacena los datos obtenidos
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // retorna msj de exito
                return ['status' => true, 'msj' => 'Entregas encontradas con exito.', 'data' => $data];
            } else {

                //retorna msj de error
                return ['status' => false, 'msj' => 'No hay entregas registradas.', 'data' => []];
            }
        } catch (PDOException $e) {

            // error log
            error_log('Error en consulta entregas: ' . $e->getMessage());
            
            // retorna msj de error
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage(), 'data' => []];
        } 
        finally {
        
            // cierra la conexion    
            $this->closeConnection();
        }
    }

    // Función para confirmar entrega
    private function Confirmar_Entrega() {

        // coexion cerrada
        $this->closeConnection();

        try {

            // establece conexion
            $conn = $this->getConnectionNegocio();
            
            // inicia transaccion
            $conn->beginTransaction();
            

            // define fecha
            $fecha_entrega = date('Y-m-d H:i:s');
            
            // Obtener el pedido asociado a la entrega
            $query_pedido = "SELECT id_pedido FROM entregas WHERE id_entregas = :id AND status = 1";
            
            // prepara la consulta
            $stmt_pedido = $conn->prepare($query_pedido);
            
            // vincula los datos
            $stmt_pedido->bindValue(':id', $this->getEntregaID());
            
            // ejecuta la consulta
            $stmt_pedido->execute();

            // almaneca los datos obtenidos
            $pedido_data = $stmt_pedido->fetch(PDO::FETCH_ASSOC);
            $pedido_id = $pedido_data['id_pedido'] ?? null;
            

            // consulta para actualizar el estado del pedido
            $query = "UPDATE entregas 
                      SET id_estado_entrega = 3,
                          fecha_entrega_real = :fecha_entrega
                      WHERE id_entregas = :id AND status = 1";

            // prepara la consulta
            $stmt = $conn->prepare($query);
            
            // vncula los datos
            $stmt->bindValue(':id', $this->getEntregaID());
            $stmt->bindValue(':fecha_entrega', $fecha_entrega);


            // valida si se ejcuto la consulta
            if ($stmt->execute()) {

                // Actualizar estado del pedido a "Entregado" (5)
                if ($pedido_id) {
                
                    // llama la funcion
                    $this->actualizarEstadoPedido($pedido_id, 5);
                }

                // confirma la transaccion
                $conn->commit();

                // retorna msj de exito
                return ['status' => true, 'msj' => 'Entrega confirmada con éxito.', 'fecha_entrega' => $fecha_entrega];
            } else {

                // revierte
                $conn->rollBack();

                // retorna msj de error
                return ['status' => false, 'msj' => 'Error al confirmar la entrega.'];
            }
        } catch (PDOException $e) {

            // revierte
            $conn->rollBack();

            // error log
            error_log('Error en Confirmar_Entrega: ' . $e->getMessage());
            
            // retorna msj de error
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } 
        finally {
            
            // cierra la conexion
            $this->closeConnection();
        }
    }

    // Función para cambiar estado de la entrega
    private function CambiarEstado_Entrega($nuevo_estado) {

        // conexion cerrada 
        $this->closeConnection();
        
        try {
            
            // establece conexion
            $conn = $this->getConnectionNegocio();
            
            // inicia transaccion
            $conn->beginTransaction();
            
            // Obtener el pedido asociado a la entrega
            $query_pedido = "SELECT id_pedido FROM entregas WHERE id_entregas = :id AND status = 1";
            
            // prepara la consulta
            $stmt_pedido = $conn->prepare($query_pedido);
            
            // vincula los datos 
            $stmt_pedido->bindValue(':id', $this->getEntregaID());
            
            // ejecuta la consulta
            $stmt_pedido->execute();

            // almacena los datos obtenidos
            $pedido_data = $stmt_pedido->fetch(PDO::FETCH_ASSOC);
            $pedido_id = $pedido_data['id_pedido'] ?? null;
            
            // consutla para actualizar 
            $query = "UPDATE entregas SET id_estado_entrega = :estado_id";
            
            // valida el nuevo estado
            if ($nuevo_estado === 'entregado') {
                
                // ajusta consulta
                $query .= ", fecha_entrega_real = :fecha_entrega";
            }

            // predefine consulta
            $query .= " WHERE id_entregas = :id AND status = 1";
            

            // prepara la consulta
            $stmt = $conn->prepare($query);
            
            // vincula los datos
            $stmt->bindValue(':id', $this->getEntregaID());
            $stmt->bindValue(':estado_id', $estado_id);
            

            // valida el estado
            if ($nuevo_estado === 'entregado') {
                
                //vincula la fecha
                $stmt->bindValue(':fecha_entrega', date('Y-m-d H:i:s'));
            }

            // valida si se ejecuto la consulta
            if ($stmt->execute()) {

                // Actualizar estado del pedido según corresponda
                if ($pedido_id) {

                    // mediante la opcion lama la funcion
                    switch($nuevo_estado) {

                        case 'entregado':
                        
                            // llama funcion
                            $this->actualizarEstadoPedido($pedido_id, 5); // 5 = Entregado
                            
                        //termina    
                        break;

                        case 'en_ruta':
                        
                            //llama la funcion
                            $this->actualizarEstadoPedido($pedido_id, 3); // 3 = Por Enviar/En Ruta
                            
                        //termina    
                        break;

                        case 'cancelado':
                            
                            // llama la funcion
                            $this->actualizarEstadoPedido($pedido_id, 1); // 1 = Pendiente
                        
                        // termina
                        break;
                    }
                }

                // confirma transacion
                $conn->commit();

                //retorna msj exito
                return ['status' => true, 'msj' => 'Estado de entrega actualizado a: ' . $nuevo_estado];
            } else {

                // revierte
                $conn->rollBack();

                // retorna msj de error
                return ['status' => false, 'msj' => 'Error al cambiar el estado de la entrega.'];
            }
        } catch (PDOException $e) {

            // revierte
            $conn->rollBack();

            // error log
            error_log('Error en CambiarEstado_Entrega: ' . $e->getMessage());
            
            // retorna msj de error
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } 
        finally {
        
            // cierra la conescion
            $this->closeConnection();
        }
    }

     private function Mostrar_Estado() {

        // conexion serrada
        $this->closeConnection();
        try {

            // establece conexion
            $conn = $this->getConnectionNegocio();
            
            // consulta para estado
            $query = "SELECT *
                      FROM estado_entrega";

            //prepara la consulta
            $stmt = $conn->prepare($query);
            
            //ejecuta la consulta
            $stmt->execute();

            // valida si se ejecuto la consu;ta
            if ($stmt->rowCount() > 0) {

                // se almacena los datos
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // msj de exito
                return ['status' => true, 'msj' => 'Estado encontrados con exito.', 'data' => $data];
            } else {

                // msj de error
                return ['status' => false, 'msj' => 'No hay estado registrados.'];
            }
        } catch (PDOException $e) {

            // msj de error dinamico
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {

            // cierra la conexion
            $this->closeConnection();
        }
    }
}
?>