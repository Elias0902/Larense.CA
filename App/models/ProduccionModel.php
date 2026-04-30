<?php
// llama al modelo conexion
require_once "ConexionModel.php";
require_once "AuditoriaModel.php";

// se difine la clase
class Produccion extends Conexion {

    // Atributos
    private $id_produccion;
    private $motivo_produccion;
    private $id_producto;
    private $cantidad_producto;
    private $id_material = [];
    private $cantidad_produccion = [];
    private $observaciones_produccion;
    private $fecha_produccion;

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

        // para validad motivo y observaciones
        $expre = '/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s\.,:;\(\)\-]*$/u'; 

        // validar motivo
            $motivo_raw = $produccion['motivo'] ?? '';
            $motivo = trim($motivo_raw);
            if ($motivo === '' || !preg_match($expre, $motivo) || strlen($motivo) > 255) {
                return ['status' => false, 'msj' => 'El motivo es requerido y no debe tener caracteres especiales y menor a 255 caracteres.'];
            }

            // asigna el motivo a la variable
            $this->motivo_produccion = $motivo;

        //Validar producto
        $producto_raw = $produccion['producto'] ?? '';
        $producto = trim($producto_raw);
        if ($producto === '') {
            return ['status' => false, 'msj' => 'Debe seleccionar un producto.'];
        }

        // asigna el id del producto a la variable
        $this->id_producto = $producto;

        // valida cantidad de producto
        $cantidad_producto = $produccion['cantidad_producto'] ?? '';
        $cantidad_producto = str_replace(',', '.', trim($cantidad_producto));
        if ($cantidad_producto === '' || !is_numeric($cantidad_producto) || (float)$cantidad_producto <= 0) {
            return ['status' => false, 'msj' => 'La cantidad debe ser un número mayor que cero.'];
        }

        // asigna la cantidad a la variable
        $this->cantidad_producto = (int)$cantidad_producto;

        //Validar materia prima y cantidad
        $materiales_raw = $produccion['materia_prima'] ?? [];
        $cantidades_raw = $produccion['cantidad'] ?? [];

        // Inicializar arrays vacíos
        $this->id_material = [];
        $this->cantidad_produccion = [];

        // Validar arrays primero
        if (empty($materiales_raw)) {
            return ['status' => false, 'msj' => 'Al menos un material requerido.'];
        }

        // Validar arrays del mismo tamaño
        if (!is_array($materiales_raw) || !is_array($cantidades_raw) || count($materiales_raw) !== count($cantidades_raw)) {
            return ['status' => false, 'msj' => 'Materiales y cantidades deben ser arrays del mismo tamaño.'];
        }

        // bucle para validar cada material y cantidad
        foreach ($materiales_raw as $index => $materia_raw) {
        $idMateria = trim($materia_raw);
        if ($idMateria === '' || !is_numeric($idMateria) || (int)$idMateria <= 0) {
            return ['status' => false, 'msj' => "Material #$index inválido (ID numérico >0)."];
        }
        
        // Validar cantidad correspondiente al material
        $cantidad_raw = str_replace(',', '.', trim($cantidades_raw[$index]));
        if ($cantidad_raw === '' || !is_numeric($cantidad_raw) || (float)$cantidad_raw <= 0) {
            return ['status' => false, 'msj' => "Cantidad material #$index > 0."];
        }

        // Agregar a arrays
        $this->id_material[] = (int)$idMateria;
        $this->cantidad_produccion[] = (int)$cantidad_raw;
        }

        // validar observaciones
        $observaciones_raw = $produccion['observacion'] ?? '';
        $observaciones = trim($observaciones_raw);
        if ($observaciones !== '' && (!preg_match($expre, $observaciones) || strlen($observaciones) > 255)) {
            return ['status' => false, 'msj' => 'Las observaciones deben tener caracteres especiales y ser menores a 255 caracteres.'];
        }

        // asigna las observaciones a la variable
        $this->observaciones_produccion = $observaciones;

        //valida fecha
        $fecha_raw = $produccion['fecha'] ?? '';
        $fecha = trim($fecha_raw);
        if ($fecha === '') {
            return ['status' => false, 'msj' => 'La fecha es requerida.'];
        }

        // asigna la fecha a la variable
        $this->fecha_produccion = $fecha;

        // si todo es correcto, se retorna un mensaje de exito
        return ['status' => true, 'msj'  => 'Datos validados y asignados correctamente.'
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
        $expre = '/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s\.,:;\(\)\-]*$/u'; 

        // almacena el id en la variable para despues validar
        $id = $produccion['id'] ?? '';
        if ($id === '') {
            return ['status' => false, 'msj' => 'El id de la producción es invalido'];
        }

        // asigna el id a la variable
        $this->id_produccion = $id;

        // validar motivo
            $motivo_raw = $produccion['motivo'] ?? '';
            $motivo = trim($motivo_raw);
            if ($motivo === '' || !preg_match($expre, $motivo) || strlen($motivo) > 255) {
                return ['status' => false, 'msj' => 'El motivo es requerido y debe tener caracteres especiales y menor a 255 caracteres.'];
            }

            // asigna el motivo a la variable
            $this->motivo_produccion = $motivo;

        //Validar producto
        $producto_raw = $produccion['producto'] ?? '';
        $producto = trim($producto_raw);
        if ($producto === '') {
            return ['status' => false, 'msj' => 'Debe seleccionar un producto.'];
        }

        // asigna el id del producto a la variable
        $this->id_producto = $producto;

        // valida cantidad de producto
        $cantidad_producto = $produccion['cantidad_producto'] ?? '';
        $cantidad_producto = str_replace(',', '.', trim($cantidad_producto));
        if ($cantidad_producto === '' || !is_numeric($cantidad_producto) || (float)$cantidad_producto <= 0) {
            return ['status' => false, 'msj' => 'La cantidad debe ser un número mayor que cero.'];
        }

        // asigna la cantidad a la variable
        $this->cantidad_producto = (int)$cantidad_producto;

        // asigna la cantidad a la variable
        $this->cantidad_producto = (int)$cantidad_producto;

        //Validar materia prima y cantidad
        $materiales_raw = $produccion['materia_prima'] ?? [];
        $cantidades_raw = $produccion['cantidad'] ?? [];

        // Inicializar arrays vacíos
        $this->id_material = [];
        $this->cantidad_produccion = [];

        // Validar arrays primero
        if (empty($materiales_raw)) {
            return ['status' => false, 'msj' => 'Al menos un material requerido.'];
        }

        // Validar arrays del mismo tamaño
        if (!is_array($materiales_raw) || !is_array($cantidades_raw) || count($materiales_raw) !== count($cantidades_raw)) {
            return ['status' => false, 'msj' => 'Materiales y cantidades deben ser arrays del mismo tamaño.'];
        }


        // Usamos un bucle for tradicional para mantener la sincronía de índices
        for ($i = 0; $i < count($materiales_raw); $i++) {
        $idMateria = trim((string)$materiales_raw[$i]);
        
        // Si el material está vacío, lo saltamos y continuamos al siguiente
        if ($idMateria === '') {
            continue;
        }
        
        // Validamos el material
        if (!is_numeric($idMateria) || (int)$idMateria <= 0) {
            return ['status' => false, 'msj' => "El material en la posición $i no es un ID válido."];
        }
        
        // Validamos la cantidad usando el MISMO índice $i
        $cantidad_raw = str_replace(',', '.', trim((string)$cantidades_raw[$i]));
        
        if ($cantidad_raw === '' || !is_numeric($cantidad_raw) || (float)$cantidad_raw <= 0) {
            return ['status' => false, 'msj' => "La cantidad para el material en la posición $i debe ser > 0."];
        }

        // Agregar a arrays
        $this->id_material[] = (int)$idMateria;
        $this->cantidad_produccion[] = (int)$cantidad_raw;
        }

        // validar observaciones
        $observaciones_raw = $produccion['observacion'] ?? '';
        $observaciones = trim($observaciones_raw);
        if ($observaciones !== '' && (!preg_match($expre, $observaciones) || strlen($observaciones) > 255)) {
            return ['status' => false, 'msj' => 'Las observaciones deben tener caracteres especiales y ser menores a 255 caracteres.'];
        }

        // asigna las observaciones a la variable
        $this->observaciones_produccion = $observaciones;

        //valida fecha
        $fecha_raw = $produccion['fecha'] ?? '';
        $fecha = trim($fecha_raw);
        if ($fecha === '') {
            return ['status' => false, 'msj' => 'La fecha es requerida.'];
        }

        // asigna la fecha a la variable
        $this->fecha_produccion = $fecha;

        // si todo es correcto, se retorna un mensaje de exito
        return ['status' => true, 'msj'  => 'Datos validados y asignados correctamente.'
        ];
    }

    private function setProduccionID($produccion_json) {
        if (is_string($produccion_json)) {
            $produccion = json_decode($produccion_json, true);
            if ($produccion === null) {
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        // exprecion regular para validar el id
        $expre_id = '/^(0|[1-9][0-9]*)$/';

        // almacena el id en la variable para despues validar
        $id = trim($produccion['id'] ?? '');
        if ($id === '' || !preg_match($expre_id, $id) || strlen($id) > 10 || strlen($id) < 0) {
            return ['status' => false, 'msj' => 'El id de la producción es invalido'];
        }

        // asigna el id a la variable
        $this->id_produccion = $id;

        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.'];
    }

    // GETTERS
    private function getProduccionID() {

        // retorna el id de la produccion
        return $this->id_produccion;
    }

    private function getCantidadProducto() {

        // retorna la cantidad de producto
        return $this->cantidad_producto;
    }

    private function getProduccionMotivo() {

        // retorna el motivo de la produccion
        return $this->motivo_produccion;
    }

    private function getProduccionProducto() {

        // retorna el producto de la produccion
        return $this->id_producto;
    }

    private function getProduccionMaterial() {
        
        // retorna el material de la produccion
        return $this->id_material;
    }

    private function getProduccionCantidad() {

        // retorna la cantidad de la produccion
        return $this->cantidad_produccion;
    }

    private function getProduccionObservacion() {

        // retorna las observaciones de la produccion
        return $this->observaciones_produccion;
    }

    private function getProduccionFecha() {
        
        // retorna la fecha de la produccion
        return $this->fecha_produccion;
    }

    public function manejarAccion($action, $produccion_json ){
        switch($action){

            case 'agregar':
                
                // valida los datos y los asigna a las variables
                $validacion = $this->setProduccionData($produccion_json);
                
                // si la validacion no es correcta, se retorna el error
                if (!$validacion['status']) {
                    
                    // retorna el error de validacion
                    return $validacion;
                }

                // si la validacion es correcta, se guarda la produccion    
                return $this->Guardar_Produccion();
            
            break;

            case 'obtener':
                
                // valida el id de la produccion y lo asigna a la variable
                $validacion = $this->setProduccionID($produccion_json);
                
                // si la validacion no es correcta, se retorna el error
                if (!$validacion['status']) {
                    
                    // retorna el error de validacion
                    return $validacion;
                }

                // si la validacion es correcta, se obtiene la produccion
                return $this->Obtener_Produccion();
            
            break;

            case 'modificar':
                
                // valida los datos y los asigna a las variables
                $validacion = $this->setUpdateProduccionData($produccion_json);
                
                // si la validacion no es correcta, se retorna el error
                if (!$validacion['status']) {
                    
                    // retorna el error de validacion
                    return $validacion;
                }
                
                // si la validacion es correcta, se actualiza la produccion
                return $this->Actualizar_Produccion();
            
            break;

            case 'eliminar':
                
                // valida el id de la produccion y lo asigna a la variable
                $validacion = $this->setProduccionID($produccion_json);
                
                // si la validacion no es correcta, se retorna el error
                if (!$validacion['status']) {
                    
                    // retorna el error de validacion
                    return $validacion;
                }
                
                // si la validacion es correcta, se elimina la produccion
                return $this->Eliminar_Produccion();
            
            break;

            case 'consultar':
                
                // se obtiene la lista de producciones
                return $this->Mostrar_Produccion();
            
            break;

            default:
                
                // si la accion no es valida, se retorna un error
                return['status' => false, 'msj' => 'Accion Invalida.'];
            break;
        }
    }

    // Funciones privadas para cada accion
    //funcion para mostrar las producciones
    private function Mostrar_Produccion() {

        // cierra la conexion por si acaso esta abierta
        $this->closeConnection();
        
        // se obtiene la conexion
        try {

            // estabece la conexion
            $conn = $this->getConnectionNegocio();
            
            // consulta para obtener las producciones
            $query = "SELECT p.*, 
                            dp.id_materia_prima, 
                            pr.nombre_producto,
                            GROUP_CONCAT(m.nombre_materia_prima SEPARATOR '<br> ') AS nombre_materia_prima,
                            GROUP_CONCAT(dp.cantidad_utilizada SEPARATOR '<br> ') AS cantidad_utilizada
                        FROM producciones p
                        INNER JOIN detalle_producciones dp ON p.id_produccion = dp.id_produccion
                        INNER JOIN productos pr ON p.id_producto = pr.id_producto
                        INNER JOIN materia_prima m ON dp.id_materia_prima = m.id_materia_prima
                        WHERE p.status = 1
                        GROUP BY p.id_produccion, p.id_producto, pr.nombre_producto";

            // se prepara la consulta
            $stmt = $conn->prepare($query);
            
            // se ejecuta la consulta
            $stmt->execute();

            //valida si encuentra las producciones
            if ($stmt->rowCount() > 0) {

                // se obtienen los datos de las producciones
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // se retorna el resultado exitoso con los datos
                return['status' => true, 'msj' => 'Producciones encontradas con exito.', 'data' => $data];
            }
            else {

                //se retorna un mensaje de error si no encuentra producciones
                return['status' => false, 'msj' => 'Producciones no encontradas o inactivas'];
            }
        } catch (PDOException $e) {
            
            // se retorna un mensaje de error si hay un problema con la consulta
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {

            // se cierra la conexion
            $this->closeConnection();
        }
    }

    private function Guardar_Produccion() {

        // cierra la conexion por si acaso esta abierta
        $this->closeConnection();

        try {

            // estabece la conexion
            $conn = $this->getConnectionNegocio();

            // se inicia la transaccion para asegurar que todas las consultas se ejecuten correctamente o ninguna se ejecute en caso de error
            $conn->beginTransaction();

            // consulta para insertar la produccion
            $queryInsertProduccion = "INSERT INTO producciones (id_producto, cantidad_producida, fecha_produccion, motivo_produccion, observacion)
                                            VALUES (:id_producto, :cantidad_producida, :fecha_produccion, :motivo_produccion, :observacion_produccion)";

            // se prepara la consulta
            $stmtInsertProduccion = $conn->prepare($queryInsertProduccion);
            
            // se asignan los valores a los parametros de la consulta
            $stmtInsertProduccion->bindValue(':id_producto', $this->getProduccionProducto());
            $stmtInsertProduccion->bindValue(':cantidad_producida', $this->getCantidadProducto());
            $stmtInsertProduccion->bindValue(':fecha_produccion', $this->getProduccionFecha());
            $stmtInsertProduccion->bindValue(':motivo_produccion', $this->getProduccionMotivo());
            $stmtInsertProduccion->bindValue(':observacion_produccion', $this->getProduccionObservacion());

            // se ejecuta la consulta
            $stmtInsertProduccion->execute();

            // se obtiene el id de la produccion recien insertada
            $idProduccion = $conn->lastInsertId();

            // obtener arrys los materiales y cantidades de la produccion
            $materiales = $this->getProduccionMaterial();  // array [1, 2, 3]
            $cantidades = $this->getProduccionCantidad();  // array [10.5, 20.0, 5.0]
        
            // valida que los arrays de materiales y cantidades no esten vacios y tengan la misma cantidad de elementos
            if (empty($materiales) || count($materiales) !== count($cantidades)) {
                
                // Revierte la transacción si los arrays no son válidos
                $conn->rollBack();

                // se retorna un mensaje de error si los arrays no son válidos
                return ['status' => false, 'msj' => 'Materiales y cantidades no coinciden'];
            }
        
            // bucle para insertar los detalles de la produccion y actualizar el stock de materia prima y producto
            foreach ($materiales as $index => $idMateriaPrima) {
            $cantidadUtilizada = $cantidades[$index];
            
                // consulta para insertar el detalle de la produccion
                $queryInsertDetalleProduccion = "INSERT INTO detalle_producciones (id_produccion, id_materia_prima, cantidad_utilizada) 
                                                                    VALUES (:id_produccion, :id_materia_prima, :cantidad_utilizada)";
                                                    
                // se prepara la consulta
                $stmtInsertDetalleProduccion = $conn->prepare($queryInsertDetalleProduccion);

                // se asignan los valores a los parametros de la consulta
                $stmtInsertDetalleProduccion->bindValue(':id_produccion', $idProduccion);
                $stmtInsertDetalleProduccion->bindValue(':id_materia_prima', $idMateriaPrima);
                $stmtInsertDetalleProduccion->bindValue(':cantidad_utilizada', $cantidadUtilizada);

                // se ejecuta la consulta
                $stmtInsertDetalleProduccion->execute();
                
                //consulta para obtener el stcok actual de la materia prima
                $queryStockMateriaPrima = "SELECT stock_actual
                                            FROM materia_prima 
                                            WHERE id_materia_prima = :id_materia_prima";

                // se prepara la consulta
                $stmtStockMateriaPrima = $conn->prepare($queryStockMateriaPrima);

                // se asignan los valores a los parametros de la consulta
                $stmtStockMateriaPrima->bindValue(':id_materia_prima', $idMateriaPrima);

                // se ejecuta la consulta
                $stmtStockMateriaPrima->execute();

                // se obtiene el stock actual de la materia prima
                $stockActual = $stmtStockMateriaPrima->fetch(PDO::FETCH_ASSOC)['stock_actual'];

                // se valida si el stock actual es suficiente para la cantidad utilizada
                if ($stockActual < $cantidadUtilizada) {

                    // Revierte la transacción si el stock no es suficiente
                    $conn->rollBack();  

                    // se retorna un mensaje de error si el stock no es suficiente
                    return['status' => false, 'msj' => 'Stock insuficiente para la materia prima seleccionada. Stock actual: ' . $stockActual];
                }

                // se define el nuevo stock de la materia prima despues de la produccion
                $nuevoStock = $stockActual - $cantidadUtilizada;

                // consulta para actualizar el stock de la materia prima
                $queryUpdateStockMateriaPrima = "UPDATE materia_prima 
                                                SET stock_actual = :nuevoStock 
                                                WHERE id_materia_prima = :id_materia_prima";
                
                // se prepara la consulta
                $stmtUpdateStockMateriaPrima = $conn->prepare($queryUpdateStockMateriaPrima);

                // se asignan los valores a los parametros de la consulta
                $stmtUpdateStockMateriaPrima->bindValue(':id_materia_prima', $idMateriaPrima);
                $stmtUpdateStockMateriaPrima->bindValue(':nuevoStock', $nuevoStock);

                // se ejecuta la consulta
                $stmtUpdateStockMateriaPrima->execute();
            }

            // se obtiene el stock actual del producto
            $queryStockProducto = "SELECT stock
                                    FROM productos 
                                    WHERE id_producto = :id_producto";

            // se prepara la consulta
            $stmtStockProducto = $conn->prepare($queryStockProducto);

            // se asignan los valores a los parametros de la consulta
            $stmtStockProducto->bindValue(':id_producto', $this->getProduccionProducto());

            // se ejecuta la consulta
            $stmtStockProducto->execute();

            // se obtiene el stock actual del producto
            $stockProducto = $stmtStockProducto->fetch(PDO::FETCH_ASSOC)['stock'];

            // se define el nuevo stock del producto despues de la produccion
            $nuevoStockProducto = $stockProducto + $this->getCantidadProducto();

            // consulta para actualizar el stock del producto
            $queryUpdateStockProducto = "UPDATE productos 
                                            SET stock = :nuevoStockProducto 
                                            WHERE id_producto = :id_producto";

            // se prepara la consulta
            $stmtUpdateStockProducto = $conn->prepare($queryUpdateStockProducto);

            // se asignan los valores a los parametros de la consulta
            $stmtUpdateStockProducto->bindValue(':id_producto', $this->getProduccionProducto());
            $stmtUpdateStockProducto->bindValue(':nuevoStockProducto', $nuevoStockProducto);

            // se ejecuta la consulta
            $stmtUpdateStockProducto->execute();

            // si todo se ejecuta correctamente se confirma la transaccion
            $conn->commit();
            return ['status' => true, 'msj' => 'Producción guardada exitosamente.'];

        } 
        catch (PDOException $e) {

            // valida si hay un error en alguna consulta
            if ($conn->inTransaction()) {

                // Revierte la transacción si hay un error
                $conn->rollBack();
            }
            
            // se retorna un mensaje de error si hay un problema con la consulta
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {

            // se cierra la conexion
            $this->closeConnection();
        }
    }


    private function Obtener_Produccion() {

        // la conexion esta cerrada por defecto
        $this->closeConnection();

        try {

            // establece la cenexion
            $conn = $this->getConnectionNegocio();

            // consulta para obtener la produccion por id
            $query = "SELECT p.*, 
                            dp.cantidad_utilizada,
                            dp.id_materia_prima, 
                            pr.nombre_producto,
                            m.nombre_materia_prima
                        FROM producciones p
                        INNER JOIN detalle_producciones dp ON p.id_produccion = dp.id_produccion
                        INNER JOIN productos pr ON p.id_producto = pr.id_producto
                        INNER JOIN materia_prima m ON dp.id_materia_prima = m.id_materia_prima
                        WHERE p.id_produccion = :id AND p.status = 1
                        GROUP BY p.id_produccion";

            // se prepara la consulta
            $stmt = $conn->prepare($query);

            // se asigna el valor del id a el parametro de la consulta
            $stmt->bindValue(":id", $this->getProduccionID());

            // se ejecuta la consulta
            if ($stmt->execute()) {

                // se obtiene la produccion
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // se retorna el resultado exitoso con los datos
                return['status' => true, 'msj' => 'Producción encontrada con exito.', 'data' => $data];
            }
            else {

            // se retorna un mensaje de error si no encuentra la produccion
                return['status' => false, 'msj' => 'Producción no encontrada error.'];
            }

        } catch (PDOException $e) {

        // se retorna un mensaje de error si hay un problema con la consulta
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {

        // se cierra la conexion
            $this->closeConnection();
        }
    }

    private function Actualizar_Produccion() {

        // cierra la conexion por si acaso esta abierta
        $this->closeConnection();

        try {

            // estabece la conexion
            $conn = $this->getConnectionNegocio();

            // se inicia la transaccion para asegurar que todas las consultas se ejecuten correctamente o ninguna se ejecute en caso de error
            $conn->beginTransaction();

            // consulta para obtener todos los datos de la produccion y sus detalles
            $querySelectProduccion = "SELECT p.*,  
                            pr.nombre_producto,
                            GROUP_CONCAT(m.nombre_materia_prima) AS nombre_materia_prima,
                            GROUP_CONCAT(dp.cantidad_utilizada) AS cantidad_utilizada,
                            GROUP_CONCAT(dp.id_materia_prima) AS id_materia_prima
                            FROM producciones p
                            INNER JOIN detalle_producciones dp ON p.id_produccion = dp.id_produccion
                            INNER JOIN productos pr ON p.id_producto = pr.id_producto
                            INNER JOIN materia_prima m ON dp.id_materia_prima = m.id_materia_prima
                            WHERE p.id_produccion = :id_produccion AND p.status = 1
                            GROUP BY p.id_produccion, p.id_producto, pr.nombre_producto";

            // se prepara la consulta
            $stmtSelectProduccion = $conn->prepare($querySelectProduccion);

            // se asigna el valor del id a el parametro de la consulta
            $stmtSelectProduccion->bindValue(':id_produccion', $this->getProduccionID());

            // se ejecuta la consulta
            $stmtSelectProduccion->execute();

            // se obtiene la produccion y sus detalles
            $data = $stmtSelectProduccion->fetch(PDO::FETCH_ASSOC);

            // se obtiene los datos de forma separasda en arrays
            $idProduccion = $data['id_produccion']; // produccion
            $idProducto = $data['id_producto']; // producto
            $catidadProducida = $data['cantidad_producida']; //cantidad producida
            $idMateriaPrimaArray = explode(',', $data['id_materia_prima']); // array de id de materia prima
            $cantidadUtilizadaArray = explode(',', $data['cantidad_utilizada']); // array de cantidad utilizada

            // consulta para actualizar la produccion
            $queryUpdateProduccion = "UPDATE producciones 
                                            SET id_producto = :id_producto, 
                                                cantidad_producida = :cantidad_producida, 
                                                fecha_produccion = :fecha_produccion, 
                                                motivo_produccion = :motivo_produccion, 
                                                observacion = :observacion 
                                            WHERE id_produccion = :id_produccion";

            // se prepara la consulta
            $stmtUpdateProduccion = $conn->prepare($queryUpdateProduccion);
            
            // se asignan los valores a los parametros de la consulta
            $stmtUpdateProduccion->bindValue(':id_producto', $this->getProduccionProducto());
            $stmtUpdateProduccion->bindValue(':cantidad_producida', $this->getCantidadProducto());
            $stmtUpdateProduccion->bindValue(':fecha_produccion', $this->getProduccionFecha());
            $stmtUpdateProduccion->bindValue(':motivo_produccion', $this->getProduccionMotivo());
            $stmtUpdateProduccion->bindValue(':observacion', $this->getProduccionObservacion());
            $stmtUpdateProduccion->bindValue(':id_produccion', $this->getProduccionID());

            // se ejecuta la consulta
            $stmtUpdateProduccion->execute();

            // obtener arrys los materiales y cantidades de la produccion modificada
            $materiales = $this->getProduccionMaterial();  // array [1, 2, 3]
            $cantidades = $this->getProduccionCantidad();  // array [10.5, 20.0, 5.0]
        
            // valida que los arrays de materiales y cantidades no esten vacios y tengan la misma cantidad de elementos
            if (empty($materiales) || count($materiales) !== count($cantidades)) {
                
                // Revierte la transacción si los arrays no son válidos
                $conn->rollBack();

                // se retorna un mensaje de error si los arrays no son válidos
                return ['status' => false, 'msj' => 'Materiales y cantidades no coinciden'];
            }
        
            // bucle para insertar los detalles de la produccion modificada y actualizar el stock de materia prima y producto
            foreach ($materiales as $index => $idMateriaPrima) {
            $cantidadUtilizada = $cantidades[$index];
            
                // consulta para modificar el detalle de la produccion
                $queryUpdateDetalleProduccion = "UPDATE detalle_producciones 
                                                SET id_materia_prima = :id_materia_prima, 
                                                    cantidad_utilizada = :cantidad_utilizada 
                                                WHERE id_produccion = :id_produccion AND id_materia_prima = :id_materia_prima";
                                                    
                // se prepara la consulta
                $stmtUpdateDetalleProduccion = $conn->prepare($queryUpdateDetalleProduccion);

                // se asignan los valores a los parametros de la consulta
                $stmtUpdateDetalleProduccion->bindValue(':id_produccion', $this->getProduccionID());
                $stmtUpdateDetalleProduccion->bindValue(':id_materia_prima', $idMateriaPrima);
                $stmtUpdateDetalleProduccion->bindValue(':cantidad_utilizada', $cantidadUtilizada);

                // se ejecuta la consulta
                $stmtUpdateDetalleProduccion->execute();
                
                //consulta para obtener el stcok actual de la materia prima
                $queryStockMateriaPrima = "SELECT stock_actual
                                            FROM materia_prima 
                                            WHERE id_materia_prima = :id_materia_prima";

                // se prepara la consulta
                $stmtStockMateriaPrima = $conn->prepare($queryStockMateriaPrima);

                // se asignan los valores a los parametros de la consulta
                $stmtStockMateriaPrima->bindValue(':id_materia_prima', $idMateriaPrima);

                // se ejecuta la consulta
                $stmtStockMateriaPrima->execute();

                // se obtiene el stock actual de la materia prima
                $stockActual = $stmtStockMateriaPrima->fetch(PDO::FETCH_ASSOC)['stock_actual'];

                // Encuentra la posición del material actual en el array original de IDs
                $index_buscado = array_search($idMateriaPrima, $idMateriaPrimaArray);

                // Obtén la cantidad original usando ese índice
                // Si array_search falla, devolvemos 0 para evitar errores
                $cantidad_original = $index_buscado !== false ? (float)$cantidadUtilizadaArray[$index_buscado] : 0;

                // Ahora realiza la suma correctamente
                $stockAnterior = $stockActual + $cantidad_original;

                // se valida si el stock actual es suficiente para la cantidad utilizada
                if ($stockAnterior < $cantidadUtilizada) {

                    // Revierte la transacción si el stock no es suficiente
                    $conn->rollBack();  

                    // se retorna un mensaje de error si el stock no es suficiente
                    return['status' => false, 'msj' => 'Stock insuficiente para la materia prima seleccionada. Stock actual: ' . $stockActual];
                }

                // se define el nuevo stock de la materia prima despues de la produccion
                $nuevoStock = $stockAnterior - $cantidadUtilizada;

                // consulta para actualizar el stock de la materia prima
                $queryUpdateStockMateriaPrima = "UPDATE materia_prima 
                                                SET stock_actual = :nuevoStock 
                                                WHERE id_materia_prima = :id_materia_prima";
                
                // se prepara la consulta
                $stmtUpdateStockMateriaPrima = $conn->prepare($queryUpdateStockMateriaPrima);

                // se asignan los valores a los parametros de la consulta
                $stmtUpdateStockMateriaPrima->bindValue(':id_materia_prima', $idMateriaPrima);
                $stmtUpdateStockMateriaPrima->bindValue(':nuevoStock', $nuevoStock);

                // se ejecuta la consulta
                $stmtUpdateStockMateriaPrima->execute();
            }

            // se obtiene el stock actual del producto
            $queryStockProducto = "SELECT stock
                                    FROM productos 
                                    WHERE id_producto = :id_producto";

            // se prepara la consulta
            $stmtStockProducto = $conn->prepare($queryStockProducto);

            // se asignan los valores a los parametros de la consulta
            $stmtStockProducto->bindValue(':id_producto', $this->getProduccionProducto());

            // se ejecuta la consulta
            $stmtStockProducto->execute();

            // se obtiene el stock actual del producto
            $stockProducto = $stmtStockProducto->fetch(PDO::FETCH_ASSOC)['stock'];

            // se defina el estock anterior
            $stockAnteriorProducto = $stockProducto - $catidadProducida;

            // se define el nuevo stock del producto despues de la produccion
            $nuevoStockProducto = $stockAnteriorProducto + $this->getCantidadProducto();

            // consulta para actualizar el stock del producto
            $queryUpdateStockProducto = "UPDATE productos 
                                            SET stock = :nuevoStockProducto 
                                            WHERE id_producto = :id_producto";

            // se prepara la consulta
            $stmtUpdateStockProducto = $conn->prepare($queryUpdateStockProducto);

            // se asignan los valores a los parametros de la consulta
            $stmtUpdateStockProducto->bindValue(':id_producto', $this->getProduccionProducto());
            $stmtUpdateStockProducto->bindValue(':nuevoStockProducto', $nuevoStockProducto);

            // se ejecuta la consulta
            $stmtUpdateStockProducto->execute();

            // si todo se ejecuta correctamente se confirma la transaccion
            $conn->commit();

            // se muentra un mensaje de exito
            return ['status' => true, 'msj' => 'Producción Modificada exitosamente.'];

        } 
        catch (PDOException $e) {

            // valida si hay un error en alguna consulta
            if ($conn->inTransaction()) {

                // Revierte la transacción si hay un error
                $conn->rollBack();
            }
            
            // se retorna un mensaje de error si hay un problema con la consulta
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {

            // se cierra la conexion
            $this->closeConnection();
        }
    }

    private function Eliminar_Produccion() {

        // cierra la conexion por si acaso esta abierta
        $this->closeConnection();
        
        try {

            // estabece la conexion
            $conn = $this->getConnectionNegocio();

            // se inicia la transaccion para asegurar que todas las consultas se ejecuten correctamente o ninguna se ejecute en caso de error
            $conn->beginTransaction();

            // consulta para obtener todos los datos de la produccion y sus detalles
            $querySelectProduccion = "SELECT p.*,  
                            pr.nombre_producto,
                            GROUP_CONCAT(m.nombre_materia_prima) AS nombre_materia_prima,
                            GROUP_CONCAT(dp.cantidad_utilizada) AS cantidad_utilizada,
                            GROUP_CONCAT(dp.id_materia_prima) AS id_materia_prima
                            FROM producciones p
                            INNER JOIN detalle_producciones dp ON p.id_produccion = dp.id_produccion
                            INNER JOIN productos pr ON p.id_producto = pr.id_producto
                            INNER JOIN materia_prima m ON dp.id_materia_prima = m.id_materia_prima
                            WHERE p.id_produccion = :id_produccion AND p.status = 1
                            GROUP BY p.id_produccion, p.id_producto, pr.nombre_producto";

            // se prepara la consulta
            $stmtSelectProduccion = $conn->prepare($querySelectProduccion);

            // se asigna el valor del id a el parametro de la consulta
            $stmtSelectProduccion->bindValue(':id_produccion', $this->getProduccionID());

            // se ejecuta la consulta
            $stmtSelectProduccion->execute();

            // se obtiene la produccion y sus detalles
            $data = $stmtSelectProduccion->fetch(PDO::FETCH_ASSOC);

            // se obtiene los datos de forma separasda en arrays
            $idProduccion = $data['id_produccion']; // produccion
            $idProducto = $data['id_producto']; // producto
            $catidadProducida = $data['cantidad_producida']; //cantidad producida
            $idMateriaPrimaArray = explode(',', $data['id_materia_prima']); // array de id de materia prima
            $cantidadUtilizadaArray = explode(',', $data['cantidad_utilizada']); // array de cantidad utilizada

             // bucle para actualizar el stock de materia prima al eliminar la produccion
             foreach ($idMateriaPrimaArray as $index => $idMateriaPrima) {
                
                $cantidadUtilizada = $cantidadUtilizadaArray[$index];

                // se obtiene el stock actual de la materia prima
                $queryStockMateriaPrima = "SELECT stock_actual
                                            FROM materia_prima 
                                            WHERE id_materia_prima = :id_materia_prima";

                // se prepara la consulta
                $stmtStockMateriaPrima = $conn->prepare($queryStockMateriaPrima);

                // se asignan los valores a los parametros de la consulta
                $stmtStockMateriaPrima->bindValue(':id_materia_prima', $idMateriaPrima);

                // se ejecuta la consulta
                $stmtStockMateriaPrima->execute();

                // se obtiene el stock actual de la materia prima
                $stockActual = $stmtStockMateriaPrima->fetch(PDO::FETCH_ASSOC)['stock_actual'];

                // se define el nuevo stock de la materia prima despues de eliminar la produccion
                $nuevoStock = $stockActual + $cantidadUtilizada;

                // consulta para actualizar el stock de la materia prima
                $queryUpdateStockMateriaPrima = "UPDATE materia_prima 
                                                SET stock_actual = :nuevoStock 
                                                WHERE id_materia_prima = :id_materia_prima";
                
                // se prepara la consulta
                $stmtUpdateStockMateriaPrima = $conn->prepare($queryUpdateStockMateriaPrima);

                // se asignan los valores a los parametros de la consulta
                $stmtUpdateStockMateriaPrima->bindValue(':id_materia_prima', $idMateriaPrima);
                $stmtUpdateStockMateriaPrima->bindValue(':nuevoStock', $nuevoStock);

                // se ejecuta la consulta
                $stmtUpdateStockMateriaPrima->execute();
            }

            // se obtiene el stock actual del producto
            $queryStockProducto = "SELECT stock
                                    FROM productos 
                                    WHERE id_producto = :id_producto";
            
            // se prepara la consulta
            $stmtStockProducto = $conn->prepare($queryStockProducto);

            // se asignan los valores a los parametros de la consulta
            $stmtStockProducto->bindValue(':id_producto', $idProducto);

            // se ejecuta la consulta
            $stmtStockProducto->execute();

            // se obtiene el stock actual del producto
            $stockActualProducto = $stmtStockProducto->fetch(PDO::FETCH_ASSOC)['stock'];

            // se define el nuevo stock del producto despues de eliminar la produccion
            $nuevoStockProducto = $stockActualProducto - $catidadProducida;

            // consulta para actualizar el stock del producto
            $queryUpdateStockProducto = "UPDATE productos 
                                            SET stock = :nuevoStockProducto 
                                            WHERE id_producto = :id_producto";
            
            // se prepara la consulta
            $stmtUpdateStockProducto = $conn->prepare($queryUpdateStockProducto);

            // se asignan los valores a los parametros de la consulta
            $stmtUpdateStockProducto->bindValue(':id_producto', $idProducto);

            $stmtUpdateStockProducto->bindValue(':nuevoStockProducto', $nuevoStockProducto);

            // se ejecuta la consulta
            $stmtUpdateStockProducto->execute();

            // consulta para eliminar la produccion (cambia el status a 0 para mantener la integridad de los datos y poder recuperar la informacion en caso de ser necesario)
            $query = "UPDATE producciones 
                        SET status = 0 
                        WHERE id_produccion = :id";

            // se prepara la consulta
            $stmt = $conn->prepare($query);
            
            // se asigna el valor del id a el parametro de la consulta
            $stmt->bindValue(":id", $this->getProduccionID());

            // se ejecuta la consulta
            if ($stmt->execute()) {

                // si todo se ejecuta correctamente se confirma la transaccion
                $conn->commit();

                // se muentra un mensaje de exito
                return ['status' => true, 'msj' => 'Producción eliminada exitosamente.'];
            }
            else {

                // Revierte la transacción si no se pudo eliminar la producción
                $conn->rollBack();

                // se retorna un mensaje de error si no se pudo eliminar la producción
                return['status' => false, 'msj' => 'Error al eliminar la producción.'];
            }

        } catch (PDOException $e) {

            // valida si hay un error en alguna consulta
            if ($conn->inTransaction()) {

                // Revierte la transacción si hay un error
                $conn->rollBack();
                return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
            }
        }
        finally {

        // se cierra la conexion
            $this->closeConnection();
        }
    }
 }
?>
