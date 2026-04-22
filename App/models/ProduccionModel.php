<?php
// llama al modelo conexion
require_once "ConexionModel.php";
require_once "AuditoriaModel.php";

// se difine la clase
class Produccion extends Conexion {

    // Atributos
    private $id_produccion;
    private $id_producto;
    private $cantidad_producida;

    // construcor
    public function __construct() {
        parent::__construct();
    }

    // SETTERS
    private function setProduccionData($produccion_json){
        //Verificar y decodificar JSON
        if (is_string($produccion_json)) {
            $produccion = json_decode($produccion_json, true);
            if ($produccion === null) {
                return ['status' => false, 'msj' => 'JSON inválido.'];
            }
        } elseif (is_array($produccion_json)) {
            $produccion = $produccion_json;
        } else {
            return ['status' => false, 'msj' => 'Formato de datos inválido.'];
        }

        //Validar producto
        $producto_raw = $produccion['producto'] ?? '';
        $producto = trim($producto_raw);
        if ($producto === '') {
            return ['status' => false, 'msj' => 'Debe seleccionar un producto.'];
        }
        $this->id_producto = $producto;

        //Validar cantidad
        $cantidad_raw = $produccion['cantidad'] ?? '';
        $cantidad_raw = str_replace(',', '.', trim($cantidad_raw));
        if ($cantidad_raw === '' || !is_numeric($cantidad_raw) || (float)$cantidad_raw <= 0) {
            return ['status' => false, 'msj' => 'La cantidad debe ser un número mayor que cero.'];
        }
        $this->cantidad_producida = (int)$cantidad_raw;

        return [
            'status' => true,
            'msj'  => 'Datos validados y asignados correctamente.'
        ];
    }

    private function setUpdateProduccionData($produccion_json){
        //Verificar y decodificar JSON
        if (is_string($produccion_json)) {
            $produccion = json_decode($produccion_json, true);
            if ($produccion === null) {
                return ['status' => false, 'msj' => 'JSON inválido.'];
            }
        } elseif (is_array($produccion_json)) {
            $produccion = $produccion_json;
        } else {
            return ['status' => false, 'msj' => 'Formato de datos inválido.'];
        }

        // expreciones regulares y validaciones
        $expre_id = '/^(0|[1-9][0-9]*)$/';

        // almacena el id en la variable para despues validar
        $id = $produccion['id'] ?? '';
        if ($id === '') {
            return ['status' => false, 'msj' => 'El id de la producción es invalido'];
        }
        $this->id_produccion = $id;

        //Validar producto
        $producto_raw = $produccion['producto'] ?? '';
        $producto = trim($producto_raw);
        if ($producto === '') {
            return ['status' => false, 'msj' => 'Debe seleccionar un producto.'];
        }
        $this->id_producto = $producto;

        //Validar cantidad
        $cantidad_raw = $produccion['cantidad'] ?? '';
        $cantidad_raw = str_replace(',', '.', trim($cantidad_raw));
        if ($cantidad_raw === '' || !is_numeric($cantidad_raw) || (float)$cantidad_raw <= 0) {
            return ['status' => false, 'msj' => 'La cantidad debe ser un número mayor que cero.'];
        }
        $this->cantidad_producida = (int)$cantidad_raw;

        return [
            'status' => true,
            'msj'  => 'Datos validados y asignados correctamente.'
        ];
    }

    private function setProduccionID($produccion_json) {
        if (is_string($produccion_json)) {
            $produccion = json_decode($produccion_json, true);
            if ($produccion === null) {
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $id = trim($produccion['id'] ?? '');
        if ($id === '' || !preg_match($expre_id, $id) || strlen($id) > 10 || strlen($id) < 0) {
            return ['status' => false, 'msj' => 'El id de la producción es invalido'];
        }
        $this->id_produccion = $id;

        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.'];
    }

    // GETTERS
    private function getProduccionID() {
        return $this->id_produccion;
    }

    private function getProductoID() {
        return $this->id_producto;
    }

    private function getCantidadProducida() {
        return $this->cantidad_producida;
    }

    public function manejarAccion($action, $produccion_json ){
        switch($action){
            case 'agregar':
                $validacion = $this->setProduccionData($produccion_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Guardar_Produccion();
            break;

            case 'obtener':
                $validacion = $this->setProduccionID($produccion_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Obtener_Produccion();
            break;

            case 'modificar':
                $validacion = $this->setUpdateProduccionData($produccion_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Actualizar_Produccion();
            break;

            case 'eliminar':
                $validacion = $this->setProduccionID($produccion_json);
                if (!$validacion['status']) {
                    return $validacion;
                }
                return $this->Eliminar_Produccion();
            break;

            case 'consultar':
                return $this->Mostrar_Produccion();
            break;

            default:
                return['status' => false, 'msj' => 'Accion Invalida.'];
            break;
        }
    }

    private function Mostrar_Produccion() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT p.*, 
                            pr.nombre_producto
                        FROM producciones p
                        INNER JOIN productos pr ON p.id_producto = pr.id_producto";

            $stmt = $conn->prepare($query);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return['status' => true, 'msj' => 'Producciones encontradas con exito.', 'data' => $data];
            }
            else {
                return['status' => false, 'msj' => 'Producciones no encontradas o inactivas'];
            }

        } catch (PDOException $e) {
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {
            $this->closeConnection();
        }
    }

    private function Guardar_Produccion() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "INSERT INTO producciones (id_producto, cantidad_producida)
                                            VALUES (:id_producto, :cantidad_producida)";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id_producto', $this->getProductoID());
            $stmt->bindValue(':cantidad_producida', $this->getCantidadProducida());

            if ($stmt->execute()) {
                $insertedId = $conn->lastInsertId();
                if ($insertedId) {
                    $this->registrarAuditoria('Producciones', Auditoria::OP_INSERT, 'producciones', $insertedId, 'Producción registrada');
                }
                return['status' => true, 'msj' => 'Producción registrada con exito.'];
            }
            else {
                return['status' => false, 'msj' => 'Error al registrar producción.'];
            }

        } catch (PDOException $e) {
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {
            $this->closeConnection();
        }
    }

    private function Obtener_Produccion() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT *
                        FROM producciones
                        WHERE id_produccion = :id";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(":id", $this->getProduccionID());

            if ($stmt->execute()) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return['status' => true, 'msj' => 'Producción encontrada con exito.', 'data' => $data];
            }
            else {
                return['status' => false, 'msj' => 'Producción no encontrada error.'];
            }

        } catch (PDOException $e) {
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {
            $this->closeConnection();
        }
    }

    private function Actualizar_Produccion() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "UPDATE producciones 
                        SET id_producto = :id_producto, 
                        cantidad_producida = :cantidad_producida
                        WHERE id_produccion = :id";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $this->getProduccionID());
            $stmt->bindValue(':id_producto', $this->getProductoID());
            $stmt->bindValue(':cantidad_producida', $this->getCantidadProducida());

            if ($stmt->execute()) {
                $this->registrarAuditoria('Producciones', Auditoria::OP_UPDATE, 'producciones', $this->getProduccionID(), 'Producción actualizada');
                return['status' => true, 'msj' => 'Producción actualizada con exito.'];
            }
            else {
                return['status' => false, 'msj' => 'Error al actualizar producción.'];
            }

        } catch (PDOException $e) {
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {
            $this->closeConnection();
        }
    }

    private function Eliminar_Produccion() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "DELETE FROM producciones
                        WHERE id_produccion = :id";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(":id", $this->getProduccionID());

            if ($stmt->execute()) {
                $this->registrarAuditoria('Producciones', Auditoria::OP_DELETE, 'producciones', $this->getProduccionID(), 'Producción eliminada');
                return['status' => true, 'msj' => 'Producción eliminada con exito.'];
            }
            else {
                return['status' => false, 'msj' => 'Producción no eliminada error.'];
            }

        } catch (PDOException $e) {
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {
            $this->closeConnection();
        }
    }
}
?>
