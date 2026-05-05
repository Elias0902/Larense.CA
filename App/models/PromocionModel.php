<?php
// llama al modelo conexion
require_once "ConexionModel.php";

// se define la clase
class Promocion extends Conexion {

    // Atributos
    private $promocion_id;
    private $promocion_nombre;
    private $promocion_descripcion;
    private $promocion_productos = [];
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

        if (is_string($promocion_json)) {
            $promocion = json_decode($promocion_json, true);
            if ($promocion === null) {
                return ['status' => false, 'msj' => 'JSON inválido.'];
            }
        } elseif (is_array($promocion_json)) {
            $promocion = $promocion_json;
        } else {
            return ['status' => false, 'msj' => 'Formato de datos inválido.'];
        }

        // expresiones regulares y validaciones
        $expre_nombre = '/^[a-zA-Z0-9\s\-_%]{5,70}$/'; // permite letras, números, espacios, -, _ con longitud entre 5 y 70
        $expre_fecha = '/^\d{4}-\d{2}-\d{2}$/'; // formato YYYY-MM-DD

        // Validar nombre
        $nombre = trim($promocion['nombre'] ?? '');
        if ($nombre === '' || !preg_match($expre_nombre, $nombre) || strlen($nombre) > 70 || strlen($nombre) < 5) {
            return ['status' => false, 'msj' => 'El nombre de la promoción es inválido. Debe tener entre 5 y 70 caracteres.'];
        }
        $this->promocion_nombre = $nombre;

        // Validar descripción
        $descripcion = trim($promocion['descripcion'] ?? '');
        if ($descripcion === '' || strlen($descripcion) > 200) {
            return ['status' => false, 'msj' => 'La descripción es inválida. Debe tener máximo 200 caracteres.'];
        }
        $this->promocion_descripcion = $descripcion;

        // Validar productos (ARRAY)
        $productos_raw = $promocion['productos'] ?? [];
        if (!is_array($productos_raw)) {
            $productos_raw = [$productos_raw];  // convertir string único a array
        }

        $productos = array_filter(array_map('trim', $productos_raw), function($p) {
            return !empty($p);
        });

        if (empty($productos)) {
            return ['status' => false, 'msj' => 'Debe seleccionar al menos un producto.'];
        }

        $this->promocion_productos = $productos;  // array limpio ["7", "6"]

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

    private function setPromocionUpdateData($promocion_json) {

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
        $expre_id = '/^(0|[1-9][0-9]*)$/'; // permite números enteros no negativos
        $expre_nombre = '/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ\-_%]{5,70}$/u'; // permite letras, números, espacios, -, _ con longitud entre 5 y 70
        $expre_fecha = '/^\d{4}-\d{2}-\d{2}$/'; // formato YYYY-MM-DD

        // Validar ID
        $id = trim($promocion['id'] ?? '');
        if ($id === '') {
            return ['status' => false, 'msj' => 'El ID de la promoción es invalido'];
        }
        $this->promocion_id = $id;

        // Validar nombre
        $nombre = trim($promocion['nombre'] ?? '');
        if ($nombre === '' || !preg_match($expre_nombre, $nombre) || strlen($nombre) > 70 || strlen($nombre) < 5) {
            return ['status' => false, 'msj' => 'El nombre de la promoción es inválido. Debe tener entre 5 y 70 caracteres.'];
        }
        $this->promocion_nombre = $nombre;

        // Validar descripción
        $descripcion = trim($promocion['descripcion'] ?? '');
        if ($descripcion === '' || strlen($descripcion) > 200) {
            return ['status' => false, 'msj' => 'La descripción es inválida. Debe tener máximo 200 caracteres.'];
        }
        $this->promocion_descripcion = $descripcion;

        // Validar productos (ARRAY)
        $productos_raw = $promocion['productos'] ?? [];
        if (!is_array($productos_raw)) {
            $productos_raw = [$productos_raw];  // convertir string único a array
        }

        $productos = array_filter(array_map('trim', $productos_raw), function($p) {
            return !empty($p);
        });

        if (empty($productos)) {
            return ['status' => false, 'msj' => 'Debe seleccionar al menos un producto.'];
        }

        $this->promocion_productos = $productos;  // array limpio ["7", "6"]

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

        // retorna el ID de la promoción
        return $this->promocion_id;
    }

    private function getPromocionNombre() {

        // retorna el nombre de la promoción
        return $this->promocion_nombre;
    }

    private function getPromocionDescripcion() {

        // retorna la descripción de la promoción
        return $this->promocion_descripcion;
    }

    private function getPromocionProductos() {

        // retorna los productos asociados a la promoción
        return $this->promocion_productos;
    }

    private function getPromocionTipo() {

        // retorna el tipo de la promoción
        return $this->promocion_tipo;
    }

    private function getPromocionValor() {

        // retorna el valor de la promoción
        return $this->promocion_valor;
    }

    private function getPromocionFechaInicio() {

    // retorna la fecha de inicio de la promoción
        return $this->promocion_fecha_inicio;
    }

    private function getPromocionFechaFin() {

    // retorna la fecha de fin de la promoción
        return $this->promocion_fecha_fin;
    }

    private function getPromocionEstado() {

        // retorna el estado de la promoción
        return $this->promocion_estado;
    }

    // Manejador de acciones
    public function manejarAccion($action, $promocion_json) {
        switch($action) {

            case 'agregar':
                
                // valida y asigna los datos de la promoción
                $validacion = $this->setPromocionData($promocion_json);
                    
                    // si la validación falla, retorna el mensaje de error
                    if (!$validacion['status']) {

                        // retorna el mensaje de error al controlador
                        return $validacion;
                    }

                    // si es exitosa la validacion, llama la duncion guardar promoción
                    return $this->Guardar_Promocion();

            break;

            case 'obtener':

                // valida y asigna el ID de la promoción
                $validacion = $this->setPromocionID($promocion_json);
                
                // si la validación falla, retorna el mensaje de error
                if (!$validacion['status']) {

                    // retorna el mensaje de error al controlador
                    return $validacion;
                }

                // si es exitosa la validacion, llama la función obtener promoción
                return $this->Obtener_Promocion();

            break;

            case 'modificar':
                
                // valida y asigna los datos de la promoción
                $validacion = $this->setPromocionUpdateData($promocion_json);
                
                // si la validación falla, retorna el mensaje de error
                if (!$validacion['status']) {
                    
                    // retorna el mensaje de error al controlador
                    return $validacion;
                }

                // si es exitosa la validacion, llama la función actualizar promoción
                return $this->Actualizar_Promocion();

            break;

            case 'eliminar':

                // valida y asigna el ID de la promoción
                $validacion = $this->setPromocionID($promocion_json);
                
                // si la validación falla, retorna el mensaje de error
                if (!$validacion['status']) {
                    
                    // retorna el mensaje de error al controlador
                    return $validacion;
                }

                // si es exitosa la validacion, llama la función eliminar promoción
                return $this->Eliminar_Promocion();

            break;

            case 'consultar':

                // llama la función para consultar promociones
                return $this->Mostrar_Promocion();

            break;

            case 'cambiar_estado':

                // valida y asigna el ID de la promoción
                $validacion = $this->setPromocionID($promocion_json);

                // si la validación falla, retorna el mensaje de error
                if (!$validacion['status']) {

                    // retorna el mensaje de error al controlador
                    return $validacion;
                }
                
                // retorna el nuevo estado desde el json
                return $this->CambiarEstado_Promocion();
            
            break;

            case 'consultar_estado':

                // llama la función para consultar promociones
                return $this->Consultar_Estado();

            break;

            default:
                return ['status' => false, 'msj' => 'Accion Invalida.'];
            break;
        }
    }

    // Función para consultar promociones
    private function Mostrar_Promocion() {

        //conexion cerrado 
        $this->closeConnection();

        try {

            // se establrece la conexión
            $conn = $this->getConnectionNegocio();

            // consulta para mostras las promociones
            $query = "SELECT * FROM promociones 
                                WHERE status = 1 
                                ORDER BY id_promocion DESC";

            // se prepara la consulta
            $stmt = $conn->prepare($query);
 
            // se ejecuta la consulta
            $stmt->execute();

            // se verifica si se encontraron promociones
            if ($stmt->rowCount() > 0) {

                // se almacen en una var las promociones
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // retorna las promociones encontradas
                return ['status' => true, 'msj' => 'Promociones encontradas con exito.', 'data' => $data];
            } 
            else {

                // no se encontraron promociones, retorna mensaje
                return ['status' => false, 'msj' => 'No hay promociones registradas.'];
            }
        } catch (PDOException $e) {

            // en caso de error, retorna mensaje de error
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } 
        finally {

            // se cierra la conexión
            $this->closeConnection();
        }
    }

    // Función para guardar promoción
    private function Guardar_Promocion() {

        //conexion cerrado
        $this->closeConnection();

        try {

            // se establrece la conexión
            $conn = $this->getConnectionNegocio();

            // Iniciar transacción
            $conn->beginTransaction();

            // consulta para insertar la promoción
            $queryInsetr = "INSERT INTO promociones (nombre_promocion, descripcion_promocion, tipo_descuento, valor_descuento, fecha_inicio, fecha_fin, estado)
                      VALUES (:nombre, :descripcion, :tipo, :valor, :fecha_inicio, :fecha_fin, :estado)";
            
            // se prepara la consulta
            $stmtInsert = $conn->prepare($queryInsetr);

            // se vinculan los datos
            $stmtInsert->bindValue(':nombre', $this->getPromocionNombre());
            $stmtInsert->bindValue(':descripcion', $this->getPromocionDescripcion());
            $stmtInsert->bindValue(':tipo', $this->getPromocionTipo());
            $stmtInsert->bindValue(':valor', $this->getPromocionValor());
            $stmtInsert->bindValue(':fecha_inicio', $this->getPromocionFechaInicio());
            $stmtInsert->bindValue(':fecha_fin', $this->getPromocionFechaFin());
            $stmtInsert->bindValue(':estado', $this->getPromocionEstado());

            // se ejecuta la consulta para insertar la promoción
            $stmtInsert->execute();

            // Obtener el ID de la promoción recién insertada
            $ultimo_id = $conn->lastInsertId();

            //consulta para inserta detalles de la promoción
            $queryDetalle = "INSERT INTO detalle_promocion (id_promocion, id_producto) 
                                                    VALUES (:id_promocion, :id_producto)";
            
            // se prepara la consulta
            $stmtDetalle = $conn->prepare($queryDetalle);

            // se extraen los productos
            $productos = $this->getPromocionProductos();
            
            // bucle para isertar varios valores
            foreach ($productos as $id_producto) {

                //se vinculan los daotos
                $stmtDetalle->bindValue(':id_promocion', $ultimo_id);
                $stmtDetalle->bindValue(':id_producto', $id_producto);
            
                // EJECUTA POR CADA PRODUCTO
                $stmtDetalle->execute();  
        }

            // Confirmar transacción
            $conn->commit();

            // retorna mensaje de exito
            return ['status' => true, 'msj' => 'Promoción registrada con éxito.'];

    } catch (PDOException $e) {

        // valida si hay un error en alguna consulta
            if ($conn->inTransaction()) {

                // Revierte la transacción si hay un error
                $conn->rollBack();
            }
            
            // se retorna un mensaje de error si hay un problema con la consulta
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
    } finally {

        // se cierra la conexión
        $this->closeConnection();
    }
}

    // Función para obtener una promoción
    private function Obtener_Promocion() {

        //conexion cerrado
        $this->closeConnection();
        
        try {
        
            // se establrece la conexión
            $conn = $this->getConnectionNegocio();

            // consulta para obtener la promoción por ID
            $query = "SELECT p.*, dp.id_producto 
                                FROM promociones p
                                INNER JOIN detalle_promocion dp ON p.id_promocion = dp.id_promocion
                                WHERE p.id_promocion = :id AND p.status = 1";
            
            // se prepara la consulta
            $stmt = $conn->prepare($query);

            // se vincula el ID de la promoción
            $stmt->bindValue(':id', $this->getPromocionID());
            
            // se ejecuta la consulta
            $stmt->execute();

            // se verifica si se encontró la promoción
            if ($stmt->rowCount() > 0) {

                // se almacena en una var la promoción encontrada
                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                // retorna la promoción encontrada
                return ['status' => true, 'msj' => 'Promoción encontrada con éxito.', 'data' => $data, 'data_bitacora' => $data];
            } 
            else {

                // no se encontró la promoción, retorna mensaje
                return ['status' => false, 'msj' => 'Promoción no encontrada.'];
            }
        } catch (PDOException $e) {

            // mensaje de error dinamico
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {

            // cierra la conexion
            $this->closeConnection();
        }
    }

    // Función para actualizar promoción
    private function Actualizar_Promocion() {

        //conexion cerrado
        $this->closeConnection();
        
        try {
        
            // se establrece la conexión
            $conn = $this->getConnectionNegocio();
            
            // Iniciar transacción
            $conn->beginTransaction();

            // consulta para obtener la promoción por ID
            $query = "SELECT p.*, dp.id_producto 
                                FROM promociones p
                                INNER JOIN detalle_promocion dp ON p.id_promocion = dp.id_promocion
                                WHERE p.id_promocion = :id AND p.status = 1";
            
            // se prepara la consulta
            $stmt = $conn->prepare($query);

            // se vincula el ID de la promoción
            $stmt->bindValue(':id', $this->getPromocionID());
            
            // se ejecuta la consulta
            $stmt->execute();

            // se almacena en una var la promoción encontrada
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // consulta para actualizar la promoción por ID
            $queryUpadte = "UPDATE promociones 
                      SET nombre_promocion = :nombre,
                          descripcion_promocion = :descripcion,
                          tipo_descuento = :tipo,
                          valor_descuento = :valor,
                          fecha_inicio = :fecha_inicio,
                          fecha_fin = :fecha_fin,
                          estado = :estado
                      WHERE id_promocion = :id";

            // se prepara la consulta
            $stmtUpdate = $conn->prepare($queryUpadte);

            // se vinculan los datos
            $stmtUpdate->bindValue(':id', $this->getPromocionID());
            $stmtUpdate->bindValue(':nombre', $this->getPromocionNombre());
            $stmtUpdate->bindValue(':descripcion', $this->getPromocionDescripcion());
            $stmtUpdate->bindValue(':tipo', $this->getPromocionTipo());
            $stmtUpdate->bindValue(':valor', $this->getPromocionValor());
            $stmtUpdate->bindValue(':fecha_inicio', $this->getPromocionFechaInicio());
            $stmtUpdate->bindValue(':fecha_fin', $this->getPromocionFechaFin());
            $stmtUpdate->bindValue(':estado', $this->getPromocionEstado());

            // se ejecuta la consulta para actualizar la promoción
            $stmtUpdate->execute();

            // se extraen los productos
            $productos = $this->getPromocionProductos();

            // consulta para elimanr detalle
            $queryDelet = "DELETE FROM detalle_promocion
                                WHERE id_promocion = :id_promocion";

            // prepara la consulta
            $stmtDelete = $conn->prepare($queryDelet);

            // vincula los datos
            $stmtDelete->bindValue(':id_promocion', $this->getPromocionID());

            // ejecuta la consulta
            $stmtDelete->execute();

            //consulta para insertar los nuevo datos modificados
            $queryDetalleInsert = "INSERT INTO detalle_promocion (id_promocion, id_producto)
                                        VALUES (:id_promocion, :id_producto)";

            // prepara la consulta
            $stmtDetalleInsert = $conn->prepare($queryDetalleInsert);

            foreach ($productos as $id_producto) {

                // vincula los datos
                $stmtDetalleInsert->bindValue(':id_promocion', $this->getPromocionID());
                $stmtDetalleInsert->bindValue(':id_producto', $id_producto);
                
                // ejecuta la sentencia
                $stmtDetalleInsert->execute();
            }

            // Confirmar transacción
            $conn->commit();

            // retorna mensaje de exito   
            return ['status' => true, 'msj' => 'Promoción actualizada con éxito.', 'data_bitacora'=>$data];
            
        } catch (PDOException $e) {

            // valida si hay un error en alguna consulta
            if ($conn->inTransaction()) {

                // Revierte la transacción si hay un error
                $conn->rollBack();
            }
            
            // se retorna un mensaje de error si hay un problema con la consulta
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        } finally {

            // CIERRA LA CONEXION
            $this->closeConnection();
        }
    }

    // Función para eliminar (desactivar) promoción
    private function Eliminar_Promocion() {

        //conexion cerrado
        $this->closeConnection();
        
        try {
        
            // se establrece la conexión
            $conn = $this->getConnectionNegocio();
            
            // consulta para eliminar (desactivar) la promoción por ID
            $query = "UPDATE promociones 
                            SET status = 0 
                            WHERE id_promocion = :id";
            
            // se prepara la consulta
            $stmt = $conn->prepare($query);

            // se vincula el ID de la promoción
            $stmt->bindValue(':id', $this->getPromocionID());

            // se ejecuta la consulta para eliminar (desactivar) la promoción
            if ($stmt->execute()) {

                // retorna mensaje de éxito
                return ['status' => true, 'msj' => 'Promoción eliminada con éxito.'];
            } 
            else {

                // retorna mensaje de error
                return ['status' => false, 'msj' => 'Error al eliminar la promoción.'];
            }
        } catch (PDOException $e) {

            // mensaje de error dinamico
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {

            // cierra la conexion
            $this->closeConnection();
        }
    }

    // funcion verifica fecha y estado de la proocion
    private function Consultar_Estado() {

        // conexion cerrada
        $this->closeConnection();

        try {

            // establece conexion
            $conn = $this->getConnectionNegocio();

            // Iniciar transacción
            $conn->beginTransaction();

            // Obtener todas las promociones con estado = 1 (activas) y comparar con hoy
            $query = "SELECT id_promocion, fecha_inicio, fecha_fin
                            FROM promociones
                            WHERE status = 1";

            // prepara la consulta
            $stmt = $conn->prepare($query);

            // ejecuta la consulta
            $stmt->execute();

            // se establece fecha 
            $hoy = date('Y-m-d'); // solo fecha

            // se establece contador
            $desactivadas = 0; // inicializar el contador

            // bucle que recorre cada registro y verifica la fecha limite
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $id         = $fila['id_promocion'];
                $fecha_fin  = $fila['fecha_fin'] ?? '';

                // Si la fecha_fin es válida y es menor a hoy → desactivar
                if ($fecha_fin && $fecha_fin < $hoy) {

                    // consulta para la actualizacion
                    $queryUpdate = "UPDATE promociones
                                    SET estado = 0
                                    WHERE id_promocion = :id_promocion";

                    // prepara la consulta
                    $stmtUpdate = $conn->prepare($queryUpdate);

                    // vincula los datos
                    $stmtUpdate->bindValue(':id_promocion', $id, PDO::PARAM_INT);

                    // ejecuta la sentencia
                    $stmtUpdate->execute();

                    // contador
                    $desactivadas++;
                }
            }

            // Confirmar transacción
            $conn->commit();

            if ($desactivadas > 0) {
            return [
                'status'   => true,
                'mostrar'  => true,
                'msj'      => "Una Promocion acaba de vencer y se ha desactivado."
            ];
            } else {
                return [
                    'status'   => true,
                    'mostrar'  => false,
                    'msj'      => 'No hay promociones vencidas.'
                ];
            }

        } catch (PDOException $e) {
            if ($conn->inTransaction()) {
                $conn->rollBack();
            }
            return [
                'status' => false,
                'msj' => 'Error al verificar estado de promociones: ' . $e->getMessage()
            ];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para cambiar estado de la promoción
    private function CambiarEstado_Promocion() {

        //conexion cerrado
        $this->closeConnection();
        
        try {
        
            // se establrece la conexión
            $conn = $this->getConnectionNegocio();

            // consulta para cambiar el estado de la promoción por ID
            $query = "UPDATE promociones 
                            SET status = :estado 
                            WHERE id_promocion = :id";
            
            // se prepara la consulta
            $stmt = $conn->prepare($query);
            
            //se vincula el ID de la promoción y el nuevo estado
            $stmt->bindValue(':id', $this->getPromocionID());
            $stmt->bindValue(':estado', $estado);

            // se ejecuta la consulta para cambiar el estado de la promoción
            if ($stmt->execute()) {

                // se declara la var de msj de estado
                $msg = $estado ? 'activada' : 'desactivada';

                // retorna mensaje de éxito
                return ['status' => true, 'msj' => 'Promoción ' . $msg . ' con éxito.'];
            } 
            else {
                
                // retorna mensaje de error
                return ['status' => false, 'msj' => 'Error al cambiar el estado de la promoción.'];
            }
        } catch (PDOException $e) {

            // mensaje de error dinamico    
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {

            // cierra la conexion
            $this->closeConnection();
        }
    }

    // Función para obtener productos de una promoción
    private function Obtener_Productos_Promocion() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT dp.id_detalle_promocion, dp.id_producto, p.nombre_producto, p.precio_producto
                      FROM detalle_promocion dp
                      INNER JOIN productos p ON dp.id_producto = p.id_producto
                      WHERE dp.id_promocion = :id_promocion AND p.status = 1";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id_promocion', $this->getPromocionID());
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return ['status' => true, 'msj' => 'Productos encontrados.', 'data' => $data];
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error al obtener productos: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para obtener todas las promociones con sus productos
    private function Mostrar_Promociones_Con_Productos() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT p.*, 
                      (SELECT GROUP_CONCAT(pr.nombre_producto SEPARATOR ', ')
                       FROM detalle_promocion dp
                       INNER JOIN productos pr ON dp.id_producto = pr.id_producto
                       WHERE dp.id_promocion = p.id_promocion AND pr.status = 1) as productos
                      FROM promociones p
                      WHERE p.status = 1
                      ORDER BY p.id_promocion DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return ['status' => true, 'msj' => 'Promociones encontradas con éxito.', 'data' => $data];
            } else {
                return ['status' => false, 'msj' => 'No hay promociones registradas.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }
}
?>
