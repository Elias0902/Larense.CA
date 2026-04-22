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
        if ($direccion === '' || strlen($direccion) < 10 || strlen($direccion) > 300) {
            return ['status' => false, 'msj' => 'La dirección es inválida. Debe tener entre 10 y 300 caracteres.'];
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
            $query = "SELECT e.*, c.nombre_cliente, c.apellido_cliente 
                      FROM entregas e
                      LEFT JOIN clientes c ON e.cliente_id = c.id_cliente
                      WHERE e.status = 1 
                      ORDER BY e.fecha_programada ASC";
            $stmt = $conn->prepare($query);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return ['status' => true, 'msj' => 'Entregas encontradas con exito.', 'data' => $data];
            } else {
                return ['status' => false, 'msj' => 'No hay entregas registradas.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para guardar entrega
    private function Guardar_Entrega() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "INSERT INTO entregas (pedido_id, cliente_id, direccion, telefono_contacto, fecha_programada, fecha_entrega, estado, observaciones, repartidor)
                      VALUES (:pedido_id, :cliente_id, :direccion, :telefono, :fecha_programada, :fecha_entrega, :estado, :observaciones, :repartidor)";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':pedido_id', $this->getEntregaPedidoID() ?: null);
            $stmt->bindValue(':cliente_id', $this->getEntregaClienteID());
            $stmt->bindValue(':direccion', $this->getEntregaDireccion());
            $stmt->bindValue(':telefono', $this->getEntregaTelefono());
            $stmt->bindValue(':fecha_programada', $this->getEntregaFechaProgramada());
            $stmt->bindValue(':fecha_entrega', $this->getEntregaFechaEntrega());
            $stmt->bindValue(':estado', $this->getEntregaEstado());
            $stmt->bindValue(':observaciones', $this->getEntregaObservaciones());
            $stmt->bindValue(':repartidor', $this->getEntregaRepartidor());

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
            $query = "SELECT e.*, c.nombre_cliente, c.apellido_cliente 
                      FROM entregas e
                      LEFT JOIN clientes c ON e.cliente_id = c.id_cliente
                      WHERE e.id_entrega = :id AND e.status = 1";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getEntregaID());
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
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
            $query = "UPDATE entregas 
                      SET pedido_id = :pedido_id,
                          cliente_id = :cliente_id,
                          direccion = :direccion,
                          telefono_contacto = :telefono,
                          fecha_programada = :fecha_programada,
                          fecha_entrega = :fecha_entrega,
                          estado = :estado,
                          observaciones = :observaciones,
                          repartidor = :repartidor
                      WHERE id_entrega = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getEntregaID());
            $stmt->bindValue(':pedido_id', $this->getEntregaPedidoID() ?: null);
            $stmt->bindValue(':cliente_id', $this->getEntregaClienteID());
            $stmt->bindValue(':direccion', $this->getEntregaDireccion());
            $stmt->bindValue(':telefono', $this->getEntregaTelefono());
            $stmt->bindValue(':fecha_programada', $this->getEntregaFechaProgramada());
            $stmt->bindValue(':fecha_entrega', $this->getEntregaFechaEntrega());
            $stmt->bindValue(':estado', $this->getEntregaEstado());
            $stmt->bindValue(':observaciones', $this->getEntregaObservaciones());
            $stmt->bindValue(':repartidor', $this->getEntregaRepartidor());

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Entrega actualizada con éxito.'];
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
            $query = "UPDATE entregas SET status = 0 WHERE id_entrega = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getEntregaID());

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Entrega eliminada con éxito.'];
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
                      SET estado = 'entregado',
                          fecha_entrega = :fecha_entrega
                      WHERE id_entrega = :id";
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
            
            // Si se marca como entregado, actualizar la fecha de entrega
            $query = "UPDATE entregas SET estado = :estado";
            if ($nuevo_estado === 'entregado') {
                $query .= ", fecha_entrega = :fecha_entrega";
            }
            $query .= " WHERE id_entrega = :id";
            
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getEntregaID());
            $stmt->bindValue(':estado', $nuevo_estado);
            
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
