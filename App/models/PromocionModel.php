<?php
// llama al modelo conexion
require_once "ConexionModel.php";

// se define la clase
class Promocion extends Conexion {

    // Atributos
    private $promocion_id;
    private $promocion_codigo;
    private $promocion_nombre;
    private $promocion_descripcion;
    private $promocion_tipo;
    private $promocion_valor;
    private $promocion_fecha_inicio;
    private $promocion_fecha_fin;
    private $promocion_estado;

    // constructor
    public function __construct() {
        parent::__construct();
    }

    // SETTER para datos completos
    private function setPromocionData($promocion_json) {

        // valida si el json es string y lo descompone
        if (is_string($promocion_json)) {
            $promocion = json_decode($promocion_json, true);
            if ($promocion === null) {
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        } else {
            $promocion = $promocion_json;
        }

        // expresiones regulares y validaciones
        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $expre_codigo = '/^[A-Za-z0-9%\-]{2,10}$/';
        $expre_nombre = '/^[a-zA-Z0-9\s\-_%]{5,50}$/';
        $expre_fecha = '/^\d{4}-\d{2}-\d{2}$/';

        // Validar ID
        $id = trim($promocion['id'] ?? '');
        if ($id === '' || !preg_match($expre_id, $id) || strlen($id) > 10 || $id < 0) {
            return ['status' => false, 'msj' => 'El ID de la promoción es invalido'];
        }
        $this->promocion_id = $id;

        // Validar código
        $codigo = trim($promocion['codigo'] ?? '');
        if ($codigo === '' || !preg_match($expre_codigo, $codigo) || strlen($codigo) > 10 || strlen($codigo) < 2) {
            return ['status' => false, 'msj' => 'El código de la promoción es inválido. Debe tener entre 2 y 10 caracteres. Ej: 2x1, 10%'];
        }
        $this->promocion_codigo = $codigo;

        // Validar nombre
        $nombre = trim($promocion['nombre'] ?? '');
        if ($nombre === '' || !preg_match($expre_nombre, $nombre) || strlen($nombre) > 50 || strlen($nombre) < 5) {
            return ['status' => false, 'msj' => 'El nombre de la promoción es inválido. Debe tener entre 5 y 50 caracteres.'];
        }
        $this->promocion_nombre = $nombre;

        // Validar descripción
        $descripcion = trim($promocion['descripcion'] ?? '');
        if ($descripcion === '' || strlen($descripcion) > 200) {
            return ['status' => false, 'msj' => 'La descripción es inválida. Debe tener máximo 200 caracteres.'];
        }
        $this->promocion_descripcion = $descripcion;

        // Validar tipo
        $tipo = trim($promocion['tipo'] ?? '');
        $tipos_permitidos = ['porcentaje', '2x1', 'monto_fijo'];
        if ($tipo === '' || !in_array($tipo, $tipos_permitidos)) {
            return ['status' => false, 'msj' => 'El tipo de promoción es inválido. Debe ser: porcentaje, 2x1 o monto_fijo.'];
        }
        $this->promocion_tipo = $tipo;

        // Validar valor
        $valor = trim($promocion['valor'] ?? '');
        if ($valor === '' || !is_numeric($valor) || $valor < 0 || $valor > 100) {
            return ['status' => false, 'msj' => 'El valor de la promoción es inválido. Debe ser un número entre 0 y 100.'];
        }
        $this->promocion_valor = $valor;

        // Validar fechas
        $fecha_inicio = trim($promocion['fecha_inicio'] ?? '');
        $fecha_fin = trim($promocion['fecha_fin'] ?? '');
        if (!preg_match($expre_fecha, $fecha_inicio) || !preg_match($expre_fecha, $fecha_fin)) {
            return ['status' => false, 'msj' => 'Las fechas deben tener formato YYYY-MM-DD.'];
        }
        if ($fecha_inicio > $fecha_fin) {
            return ['status' => false, 'msj' => 'La fecha de inicio no puede ser mayor que la fecha de fin.'];
        }
        $this->promocion_fecha_inicio = $fecha_inicio;
        $this->promocion_fecha_fin = $fecha_fin;

        // Validar estado
        $estado = trim($promocion['estado'] ?? '1');
        $estados_permitidos = ['0', '1', 'activa', 'inactiva'];
        if (!in_array($estado, $estados_permitidos)) {
            return ['status' => false, 'msj' => 'El estado de la promoción es inválido.'];
        }
        $this->promocion_estado = ($estado === 'activa' || $estado === '1') ? 1 : 0;

        return ['status' => true, 'msj' => 'Datos validados y asignados correctamente.'];
    }

    // SETTER para ID
    private function setPromocionID($promocion_json) {
        if (is_string($promocion_json)) {
            $promocion = json_decode($promocion_json, true);
            if ($promocion === null) {
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        } else {
            $promocion = $promocion_json;
        }

        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $id = trim($promocion['id'] ?? '');
        if ($id === '' || !preg_match($expre_id, $id) || strlen($id) > 10 || $id < 0) {
            return ['status' => false, 'msj' => 'El ID de la promoción es invalido'];
        }
        $this->promocion_id = $id;

        return ['status' => true, 'msj' => 'ID validado correctamente.'];
    }

    // GETTERS
    private function getPromocionID() {
        return $this->promocion_id;
    }

    private function getPromocionCodigo() {
        return $this->promocion_codigo;
    }

    private function getPromocionNombre() {
        return $this->promocion_nombre;
    }

    private function getPromocionDescripcion() {
        return $this->promocion_descripcion;
    }

    private function getPromocionTipo() {
        return $this->promocion_tipo;
    }

    private function getPromocionValor() {
        return $this->promocion_valor;
    }

    private function getPromocionFechaInicio() {
        return $this->promocion_fecha_inicio;
    }

    private function getPromocionFechaFin() {
        return $this->promocion_fecha_fin;
    }

    private function getPromocionEstado() {
        return $this->promocion_estado;
    }

    // Manejador de acciones
    public function manejarAccion($action, $promocion_json) {
        switch($action) {
            case 'agregar':
                $validacion = $this->setPromocionData($promocion_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Guardar_Promocion();
            break;

            case 'obtener':
                $validacion = $this->setPromocionID($promocion_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Obtener_Promocion();
            break;

            case 'modificar':
                $validacion = $this->setPromocionData($promocion_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Actualizar_Promocion();
            break;

            case 'eliminar':
                $validacion = $this->setPromocionID($promocion_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Eliminar_Promocion();
            break;

            case 'consultar':
                return $this->Mostrar_Promocion();
            break;

            case 'cambiar_estado':
                $validacion = $this->setPromocionID($promocion_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                $nuevo_estado = isset($promocion_json['nuevo_estado']) ? $promocion_json['nuevo_estado'] : null;
                return $this->CambiarEstado_Promocion($nuevo_estado);
            break;

            default:
                return ['status' => false, 'msj' => 'Accion Invalida.'];
            break;
        }
    }

    // Función para consultar promociones
    private function Mostrar_Promocion() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT * FROM promociones WHERE status = 1 ORDER BY id_promocion DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return ['status' => true, 'msj' => 'Promociones encontradas con exito.', 'data' => $data];
            } else {
                return ['status' => false, 'msj' => 'No hay promociones registradas.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para guardar promoción
    private function Guardar_Promocion() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "INSERT INTO promociones (codigo_promocion, nombre_promocion, descripcion, tipo_descuento, valor_descuento, fecha_inicio, fecha_fin, status)
                      VALUES (:codigo, :nombre, :descripcion, :tipo, :valor, :fecha_inicio, :fecha_fin, :estado)";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':codigo', $this->getPromocionCodigo());
            $stmt->bindValue(':nombre', $this->getPromocionNombre());
            $stmt->bindValue(':descripcion', $this->getPromocionDescripcion());
            $stmt->bindValue(':tipo', $this->getPromocionTipo());
            $stmt->bindValue(':valor', $this->getPromocionValor());
            $stmt->bindValue(':fecha_inicio', $this->getPromocionFechaInicio());
            $stmt->bindValue(':fecha_fin', $this->getPromocionFechaFin());
            $stmt->bindValue(':estado', $this->getPromocionEstado());

            if ($stmt->execute()) {
                $this->registrarAuditoria('Promociones', Auditoria::OP_INSERT, 'promociones', $this->getPromocionID(), 'Promoción creada');
                return ['status' => true, 'msj' => 'Promoción registrada con éxito.'];
            } else {
                return ['status' => false, 'msj' => 'Error al registrar la promoción.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para obtener una promoción
    private function Obtener_Promocion() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT * FROM promociones WHERE id_promocion = :id AND status = 1";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getPromocionID());
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return ['status' => true, 'msj' => 'Promoción encontrada con éxito.', 'data' => $data];
            } else {
                return ['status' => false, 'msj' => 'Promoción no encontrada.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para actualizar promoción
    private function Actualizar_Promocion() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "UPDATE promociones 
                      SET codigo_promocion = :codigo,
                          nombre_promocion = :nombre,
                          descripcion = :descripcion,
                          tipo_descuento = :tipo,
                          valor_descuento = :valor,
                          fecha_inicio = :fecha_inicio,
                          fecha_fin = :fecha_fin,
                          status = :estado
                      WHERE id_promocion = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getPromocionID());
            $stmt->bindValue(':codigo', $this->getPromocionCodigo());
            $stmt->bindValue(':nombre', $this->getPromocionNombre());
            $stmt->bindValue(':descripcion', $this->getPromocionDescripcion());
            $stmt->bindValue(':tipo', $this->getPromocionTipo());
            $stmt->bindValue(':valor', $this->getPromocionValor());
            $stmt->bindValue(':fecha_inicio', $this->getPromocionFechaInicio());
            $stmt->bindValue(':fecha_fin', $this->getPromocionFechaFin());
            $stmt->bindValue(':estado', $this->getPromocionEstado());

            if ($stmt->execute()) {
                $this->registrarAuditoria('Promociones', Auditoria::OP_UPDATE, 'promociones', $this->getPromocionID(), 'Promoción actualizada');
                return ['status' => true, 'msj' => 'Promoción actualizada con éxito.'];
            } else {
                return ['status' => false, 'msj' => 'Error al actualizar la promoción.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para eliminar (desactivar) promoción
    private function Eliminar_Promocion() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "UPDATE promociones SET status = 0 WHERE id_promocion = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getPromocionID());

            if ($stmt->execute()) {
                $this->registrarAuditoria('Promociones', Auditoria::OP_DELETE, 'promociones', $this->getPromocionID(), 'Promoción eliminada');
                return ['status' => true, 'msj' => 'Promoción eliminada con éxito.'];
            } else {
                return ['status' => false, 'msj' => 'Error al eliminar la promoción.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para cambiar estado de la promoción
    private function CambiarEstado_Promocion($nuevo_estado) {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $estado = ($nuevo_estado === 'activa' || $nuevo_estado === '1' || $nuevo_estado === 1) ? 1 : 0;
            $query = "UPDATE promociones SET status = :estado WHERE id_promocion = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getPromocionID());
            $stmt->bindValue(':estado', $estado);

            if ($stmt->execute()) {
                $msg = $estado ? 'activada' : 'desactivada';
                return ['status' => true, 'msj' => 'Promoción ' . $msg . ' con éxito.'];
            } else {
                return ['status' => false, 'msj' => 'Error al cambiar el estado de la promoción.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }
}
?>
