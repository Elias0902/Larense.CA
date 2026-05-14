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
        $this->entrega_pedido_id = $pedido_id;

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
        if ($fecha_programada === '' || !preg_match($expre_fecha, $fecha_programada)) {
            return ['status' => false, 'msj' => 'La fecha programada es requerida.'];
        }
        $this->entrega_fecha_programada = $fecha_programada;

        // Validar fecha de entrega (opcional, se llena al confirmar)
        $fecha_entrega = trim($entrega['fecha_entrega'] ?? '');
        $this->entrega_fecha_entrega = $fecha_entrega ?: null;

        // Validar estado
        $estado = trim($entrega['estado'] ?? 'pendiente');
        $estados_permitidos = ['pendiente', 'en_ruta', 'entregado', 'cancelado'];
        if (!in_array($estado, $estados_permitidos)) {
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

    // Manejador de acciones
    public function manejarAccion($action, $entrega_json) {
        switch($action) {
            case 'agregar':
                $validacion = $this->setEntregaData($entrega_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Guardar_Entrega();
            break;

            case 'obtener':
                $validacion = $this->setEntregaID($entrega_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Obtener_Entrega();
            break;

            case 'modificar':
                $validacion = $this->setEntregaData($entrega_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Actualizar_Entrega();
            break;

            case 'eliminar':
                $validacion = $this->setEntregaID($entrega_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Eliminar_Entrega();
            break;

            case 'consultar':
                return $this->Mostrar_Entrega();
            break;

            case 'confirmar_entrega':
                $validacion = $this->setEntregaID($entrega_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Confirmar_Entrega();
            break;

            case 'cambiar_estado':
                $validacion = $this->setEntregaID($entrega_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                $nuevo_estado = isset($entrega_json['nuevo_estado']) ? $entrega_json['nuevo_estado'] : null;
                return $this->CambiarEstado_Entrega($nuevo_estado);
            break;

            default:
                return ['status' => false, 'msj' => 'Accion Invalida.'];
            break;
        }
    }

    // Función para consultar entregas
    private function Mostrar_Entrega() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            
            // Consulta corregida con los nombres de columnas correctos
            $query = "SELECT e.id_entregas, e.id_pedido, e.id_clientes as cliente_id, 
                             e.direccion_entrega as direccion, e.fecha_entrega_programada as fecha_programada,
                             e.fecha_entrega_real as fecha_entrega, e.id_estado_entrega as estado_id,
                             c.nombre_cliente, c.tlf_cliente as telefono_contacto,
                             '' as repartidor, '' as observaciones, 'pendiente' as estado
                      FROM entregas e
                      LEFT JOIN clientes c ON e.id_clientes = c.id_cliente
                      WHERE e.status = 1 
                      ORDER BY e.fecha_entrega_programada ASC";
            $stmt = $conn->prepare($query);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // Mapear estados para compatibilidad
                foreach ($data as &$row) {
                    // Mapear id_estado_entrega a estado legible
                    switch($row['estado_id']) {
                        case 1: $row['estado'] = 'pendiente'; break;
                        case 2: $row['estado'] = 'en_ruta'; break;
                        case 3: $row['estado'] = 'entregado'; break;
                        case 4: $row['estado'] = 'cancelado'; break;
                        default: $row['estado'] = 'pendiente';
                    }
                }
                return ['status' => true, 'msj' => 'Entregas encontradas con exito.', 'data' => $data];
            } else {
                return ['status' => false, 'msj' => 'No hay entregas registradas.', 'data' => []];
            }
        } catch (PDOException $e) {
            error_log('Error en consulta entregas: ' . $e->getMessage());
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage(), 'data' => []];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para guardar entrega
    private function Guardar_Entrega() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            
            // Determinar id_estado_entrega basado en el estado
            $estado_id = 1; // pendiente por defecto
            switch($this->getEntregaEstado()) {
                case 'pendiente': $estado_id = 1; break;
                case 'en_ruta': $estado_id = 2; break;
                case 'entregado': $estado_id = 3; break;
                case 'cancelado': $estado_id = 4; break;
            }
            
            $query = "INSERT INTO entregas (id_pedido, id_clientes, direccion_entrega, 
                      fecha_entrega_programada, fecha_entrega_real, id_estado_entrega, status)
                      VALUES (:pedido_id, :cliente_id, :direccion, :fecha_programada, 
                      :fecha_entrega, :estado_id, 1)";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':pedido_id', $this->getEntregaPedidoID() ?: null);
            $stmt->bindValue(':cliente_id', $this->getEntregaClienteID());
            $stmt->bindValue(':direccion', $this->getEntregaDireccion());
            $stmt->bindValue(':fecha_programada', $this->getEntregaFechaProgramada());
            $stmt->bindValue(':fecha_entrega', $this->getEntregaFechaEntrega());
            $stmt->bindValue(':estado_id', $estado_id);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Entrega registrada con éxito.'];
            } else {
                return ['status' => false, 'msj' => 'Error al registrar la entrega.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para obtener una entrega
    private function Obtener_Entrega() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT e.id_entregas, e.id_pedido, e.id_clientes as cliente_id, 
                             e.direccion_entrega as direccion, e.fecha_entrega_programada as fecha_programada,
                             e.fecha_entrega_real as fecha_entrega, e.id_estado_entrega as estado_id,
                             c.nombre_cliente, c.tlf_cliente as telefono_contacto
                      FROM entregas e
                      LEFT JOIN clientes c ON e.id_clientes = c.id_cliente
                      WHERE e.id_entregas = :id AND e.status = 1";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getEntregaID());
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                // Mapear estado
                switch($data['estado_id']) {
                    case 1: $data['estado'] = 'pendiente'; break;
                    case 2: $data['estado'] = 'en_ruta'; break;
                    case 3: $data['estado'] = 'entregado'; break;
                    case 4: $data['estado'] = 'cancelado'; break;
                    default: $data['estado'] = 'pendiente';
                }
                return ['status' => true, 'msj' => 'Entrega encontrada con éxito.', 'data' => $data];
            } else {
                return ['status' => false, 'msj' => 'Entrega no encontrada.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para actualizar entrega
    private function Actualizar_Entrega() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            
            // Determinar id_estado_entrega
            $estado_id = 1;
            switch($this->getEntregaEstado()) {
                case 'pendiente': $estado_id = 1; break;
                case 'en_ruta': $estado_id = 2; break;
                case 'entregado': $estado_id = 3; break;
                case 'cancelado': $estado_id = 4; break;
            }
            
            // Obtener datos actuales antes de actualizar
            $query_select = "SELECT * FROM entregas WHERE id_entregas = :id";
            $stmt_select = $conn->prepare($query_select);
            $stmt_select->bindValue(':id', $this->getEntregaID());
            $stmt_select->execute();
            $datos_anteriores = $stmt_select->fetch(PDO::FETCH_ASSOC);
            
            $query = "UPDATE entregas 
                      SET id_pedido = :pedido_id,
                          id_clientes = :cliente_id,
                          direccion_entrega = :direccion,
                          fecha_entrega_programada = :fecha_programada,
                          id_estado_entrega = :estado_id
                      WHERE id_entregas = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getEntregaID());
            $stmt->bindValue(':pedido_id', $this->getEntregaPedidoID() ?: null);
            $stmt->bindValue(':cliente_id', $this->getEntregaClienteID());
            $stmt->bindValue(':direccion', $this->getEntregaDireccion());
            $stmt->bindValue(':fecha_programada', $this->getEntregaFechaProgramada());
            $stmt->bindValue(':estado_id', $estado_id);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Entrega actualizada con éxito.', 'data_bitacora' => $datos_anteriores];
            } else {
                return ['status' => false, 'msj' => 'Error al actualizar la entrega.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para eliminar (desactivar) entrega
    private function Eliminar_Entrega() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            
            // Obtener datos actuales antes de eliminar
            $query_select = "SELECT * FROM entregas WHERE id_entregas = :id AND status = 1";
            $stmt_select = $conn->prepare($query_select);
            $stmt_select->bindValue(':id', $this->getEntregaID());
            $stmt_select->execute();
            $datos_anteriores = $stmt_select->fetch(PDO::FETCH_ASSOC);
            
            $query = "UPDATE entregas SET status = 0 WHERE id_entregas = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getEntregaID());

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Entrega eliminada con éxito.', 'data_bitacora' => $datos_anteriores];
            } else {
                return ['status' => false, 'msj' => 'Error al eliminar la entrega.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para confirmar entrega
    private function Confirmar_Entrega() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $fecha_entrega = date('Y-m-d H:i:s');
            
            $query = "UPDATE entregas 
                      SET id_estado_entrega = 3,
                          fecha_entrega_real = :fecha_entrega
                      WHERE id_entregas = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getEntregaID());
            $stmt->bindValue(':fecha_entrega', $fecha_entrega);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Entrega confirmada con éxito.', 'fecha_entrega' => $fecha_entrega];
            } else {
                return ['status' => false, 'msj' => 'Error al confirmar la entrega.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para cambiar estado de la entrega
    private function CambiarEstado_Entrega($nuevo_estado) {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            
            // Mapear nuevo estado a id_estado_entrega
            $estado_id = 1;
            switch($nuevo_estado) {
                case 'pendiente': $estado_id = 1; break;
                case 'en_ruta': $estado_id = 2; break;
                case 'entregado': $estado_id = 3; break;
                case 'cancelado': $estado_id = 4; break;
                default: $estado_id = 1;
            }
            
            $query = "UPDATE entregas SET id_estado_entrega = :estado_id";
            if ($nuevo_estado === 'entregado') {
                $query .= ", fecha_entrega_real = :fecha_entrega";
            }
            $query .= " WHERE id_entregas = :id";
            
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getEntregaID());
            $stmt->bindValue(':estado_id', $estado_id);
            
            if ($nuevo_estado === 'entregado') {
                $stmt->bindValue(':fecha_entrega', date('Y-m-d H:i:s'));
            }

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Estado de entrega actualizado a: ' . $nuevo_estado];
            } else {
                return ['status' => false, 'msj' => 'Error al cambiar el estado de la entrega.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }
}
?>