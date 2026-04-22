<?php
// llama al modelo conexion
require_once "ConexionModel.php";
require_once "AuditoriaModel.php";

// se difine la clase
class MateriaPrima extends Conexion {

    // Atributos
    private $id_materia_prima;
    private $nombre_materia_prima;
    private $descripcion_materia_prima;
    private $stock_materia_prima;
    private $proveedor_materia_prima;
    private $medida_materia_prima;



    // construcor
    public function __construct() {
        parent::__construct();
    }

    // SETTERS
    // setters para materia prima
        private function setMateriaPrimaData($materia_prima_json){

        //Verificar y decodificar JSON
        if (is_string($materia_prima_json)) {
            $materia_prima = json_decode($materia_prima_json, true);

            if ($materia_prima === null) {
                return ['status' => false, 'msj' => 'JSON inválido.'];
            }
        } elseif (is_array($materia_prima_json)) {
            $materia_prima = $materia_prima_json;
        } else {
            return ['status' => false, 'msj' => 'Formato de datos inválido.'];
        }

        //Validar nombre
        $nombre_raw = $materia_prima['nombre'] ?? '';

        // El nombre se limpia de espacios al inicio y al final
        $nombre = trim($nombre_raw);

        // Expresión regular para validar que el nombre solo contenga letras y espacios
        $expre_nombre = '/^[a-zA-Z0-9\s]+$/';

        // Valida que el nombre no esté vacío, que solo contenga letras y espacios, y que tenga una longitud adecuada
        if ($nombre === '') {
            
            // Retorna un mensaje de error si el nombre está vacío
            return ['status' => false, 'msj' => 'Debe ingresar un nombre de materia prima.'];
        }

        // Valida que el nombre solo contenga letras y espacios
        if (!preg_match($expre_nombre, $nombre)) {
            
            // Retorna un mensaje de error si el nombre contiene caracteres no permitidos
            return [
                'status' => false,
                'msj' => 'El nombre de la materia prima solo puede contener letras y espacios.'
            ];
        }

        if (strlen($nombre) < 2 || strlen($nombre) > 100) { // ajusta el max según tu js
            
            // Retorna un mensaje de error si el nombre no tiene la longitud adecuada
            return [
                'status' => false,
                'msj' => 'El nombre de la materia prima debe tener entre 2 y 100 caracteres.'
            ];
        }

        // Asigna el nombre al atributo del objeto
        $this->nombre_materia_prima = $nombre;

        //Validar descripción
        $descripcion_raw = $materia_prima['descripcion'] ?? '';

        // Valida que la descripción no esté vacía
        if ($descripcion_raw === '') {

            // Retorna un mensaje de error si la categoría está vacía
            return ['status' => false, 'msj' => 'Debe seleccionar una categoría.'];
        }

         // Valida que el nombre solo contenga letras y espacios
        if (!preg_match($expre_nombre, $descripcion_raw)) {
            
            // Retorna un mensaje de error si el nombre contiene caracteres no permitidos
            return [
                'status' => false,
                'msj' => 'La descripción de la materia prima solo puede contener letras y espacios.'
            ];
        }

        if (strlen($nombre) < 2 || strlen($nombre) > 100) { // ajusta el max según tu js
            
            // Retorna un mensaje de error si el nombre no tiene la longitud adecuada
            return [
                'status' => false,
                'msj' => 'La descripción de la materia prima debe tener entre 2 y 100 caracteres.'
            ];
        }

        // Asigna la descripción al atributo del objeto
        $this->descripcion_materia_prima = $descripcion_raw;

        //Validar stock
        $stock_raw = $materia_prima['stock'] ?? '';

        // El stock se limpia de espacios al inicio y al final, y se reemplazan comas por puntos
        $stock_raw = str_replace(',', '.', trim($stock_raw));

        // Valida que el stock no esté vacío, que sea un número y que sea mayor que cero
        if ($stock_raw === '' || !is_numeric($stock_raw) || (float)$stock_raw <= 0) {

            // Retorna un mensaje de error si el stock no es válido
            return ['status' => false, 'msj' => 'El stock debe ser un número mayor que cero.'];
        }

        // Asigna el stock al atributo del objeto
        $this->stock_materia_prima = (float)$stock_raw;

        //Validar proveedor
        $proveedor_raw = $materia_prima['proveedor'] ?? '';

        // El proveedor se limpia de espacios al inicio y al final
        $proveedor = trim($proveedor_raw);

        // Valida que el proveedor no esté vacío
        if ($proveedor === '') {
            return ['status' => false, 'msj' => 'Debe ingresar un proveedor.'];
        }

        // Asigna el proveedor al atributo del objeto
        $this->proveedor_materia_prima = $proveedor;

        //Validar medida
        $medida_raw = $materia_prima['medida'] ?? '';

        // la medida se limpia de espacios al inicio y al final
        $medida = trim($medida_raw);

        // Valida que la medida no esté vacía
        if ($medida === '') {
            return ['status' => false, 'msj' => 'Debe ingresar una medida.'];
        }

        // Asigna la medida al atributo del objeto
        $this->medida_materia_prima = $medida;

        //Si todo está bien
        return [
            'status' => true,
            'msj'  => 'Datos validados y asignados correctamente.'
        ];
    }

    private function setUpdateMateriaPrimaData($materia_prima_json){

        //Verificar y decodificar JSON
        if (is_string($materia_prima_json)) {
            $materia_prima = json_decode($materia_prima_json, true);

            if ($materia_prima === null) {
                return ['status' => false, 'msj' => 'JSON inválido.'];
            }
        } elseif (is_array($materia_prima_json)) {
            $materia_prima = $materia_prima_json;
        } else {
            return ['status' => false, 'msj' => 'Formato de datos inválido.'];
        }

                // expreciones regulares y validaciones
        $expre_id = '/^(0|[1-9][0-9]*)$/'; // para el id

        // almacena el id en la variable para despues validar
        $id = $materia_prima['id'] ?? ''; 
        // valida el username si cumple con los requisitos
        if ($id === '') {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'El id de la materia prima es invalido'];
        }

        // Asigna el ID al atributo del objeto
        $this->id_materia_prima = $id;

         //Validar nombre
        $nombre_raw = $materia_prima['nombre'] ?? '';

        // El nombre se limpia de espacios al inicio y al final
        $nombre = trim($nombre_raw);

        // Expresión regular para validar que el nombre solo contenga letras y espacios
        $expre_nombre = '/^[a-zA-Z0-9\s]+$/';

        // Valida que el nombre no esté vacío, que solo contenga letras y espacios, y que tenga una longitud adecuada
        if ($nombre === '') {
            
            // Retorna un mensaje de error si el nombre está vacío
            return ['status' => false, 'msj' => 'Debe ingresar un nombre de materia prima.'];
        }

        // Valida que el nombre solo contenga letras y espacios
        if (!preg_match($expre_nombre, $nombre)) {
            
            // Retorna un mensaje de error si el nombre contiene caracteres no permitidos
            return [
                'status' => false,
                'msj' => 'El nombre de la materia prima solo puede contener letras y espacios.'
            ];
        }

        if (strlen($nombre) < 2 || strlen($nombre) > 100) { // ajusta el max según tu js
            
            // Retorna un mensaje de error si el nombre no tiene la longitud adecuada
            return [
                'status' => false,
                'msj' => 'El nombre de la materia prima debe tener entre 2 y 100 caracteres.'
            ];
        }

        // Asigna el nombre al atributo del objeto
        $this->nombre_materia_prima = $nombre;

        //Validar descripción
        $descripcion_raw = $materia_prima['descripcion'] ?? '';

        // Valida que la descripción no esté vacía
        if ($descripcion_raw === '') {

            // Retorna un mensaje de error si la categoría está vacía
            return ['status' => false, 'msj' => 'Debe seleccionar una categoría.'];
        }

         // Valida que el nombre solo contenga letras y espacios
        if (!preg_match($expre_nombre, $descripcion_raw)) {
            
            // Retorna un mensaje de error si el nombre contiene caracteres no permitidos
            return [
                'status' => false,
                'msj' => 'La descripción de la materia prima solo puede contener letras y espacios.'
            ];
        }

        if (strlen($nombre) < 2 || strlen($nombre) > 100) { // ajusta el max según tu js
            
            // Retorna un mensaje de error si el nombre no tiene la longitud adecuada
            return [
                'status' => false,
                'msj' => 'La descripción de la materia prima debe tener entre 2 y 100 caracteres.'
            ];
        }

        // Asigna la descripción al atributo del objeto
        $this->descripcion_materia_prima = $descripcion_raw;

        //Validar stock
        $stock_raw = $materia_prima['stock'] ?? '';

        // El stock se limpia de espacios al inicio y al final, y se reemplazan comas por puntos
        $stock_raw = str_replace(',', '.', trim($stock_raw));

        // Valida que el stock no esté vacío, que sea un número y que sea mayor que cero
        if ($stock_raw === '' || !is_numeric($stock_raw) || (float)$stock_raw <= 0) {

            // Retorna un mensaje de error si el stock no es válido
            return ['status' => false, 'msj' => 'El stock debe ser un número mayor que cero.'];
        }

        // Asigna el stock al atributo del objeto
        $this->stock_materia_prima = (float)$stock_raw;

        //Validar proveedor
        $proveedor_raw = $materia_prima['proveedor'] ?? '';

        // El proveedor se limpia de espacios al inicio y al final
        $proveedor = trim($proveedor_raw);

        // Valida que el proveedor no esté vacío
        if ($proveedor === '') {
            return ['status' => false, 'msj' => 'Debe ingresar un proveedor.'];
        }

        // Asigna el proveedor al atributo del objeto
        $this->proveedor_materia_prima = $proveedor;

        //Validar medida
        $medida_raw = $materia_prima['medida'] ?? '';

        // la medida se limpia de espacios al inicio y al final
        $medida = trim($medida_raw);

        // Valida que la medida no esté vacía
        if ($medida === '') {
            return ['status' => false, 'msj' => 'Debe ingresar una medida.'];
        }

        // Asigna la medida al atributo del objeto
        $this->medida_materia_prima = $medida;

        //Si todo está bien
        return [
            'status' => true,
            'msj'  => 'Datos validados y asignados correctamente.'
        ];
    }

    // setters para el id de la materia prima
    private function setMateriaPrimaID($materia_prima_json) {

        // valida si el json es string y lo descompone
        if (is_string($materia_prima_json)) {

            // se almacena el contenido del json en la variable usuario
            $materia_prima = json_decode($materia_prima_json, true);
            
            // valida que el json cumpla con el formato requerido
            if ($materia_prima === null) {

                // retorna un arry con el mensaje y el status
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        // expreciones regulares y validaciones
        $expre_id = '/^(0|[1-9][0-9]*)$/'; // para el id

        // almacena el id en la variable para despues validar
        $id = trim($materia_prima['id'] ?? '');
        // valida el username si cumple con los requisitos
        if ($id === '' || !preg_match($expre_id, $id) || strlen($id) > 10 || strlen($id) < 0) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'El id de la materia prima es invalido'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->id_materia_prima = $id;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

    // GETTERS
    //getters para el id
    private function getMateriaPrimaID() {
        
        // retorna el id a utilizar
        return $this->id_materia_prima;
    }

    // getters para el nombre
    private function getMateriaPrimaNombre() {

        // retorna el nombre a utilizar
        return $this->nombre_materia_prima;
    }

    private function getMateriaPrimaDescripcion() {
        return $this->descripcion_materia_prima;
    }

    private function getMateriaPrimaStock() {
        return $this->stock_materia_prima;
    }

    private function getMateriaPrimaProveedor() {
        return $this->proveedor_materia_prima;
    }

    private function getMateriaPrimaMedida() {
        return $this->medida_materia_prima;
    }

    // Esta se encarga de procesar los action indiferentemente cual sea llama la funcion de 
    // validacio y luego al metodo correspondiente al action
    // donde primero recibe el action como primer parametro que son los de agregar etc.. 
    // y el objeto json como segundo parametro para las validaciones y asiganciones al objeto 
    public function manejarAccion($action, $materia_prima_json ){

        // maneja el action y carga la funcion correspondiente a la action
        switch($action){

            case 'agregar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setMateriaPrimaData($materia_prima_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Guardar_MateriaPrima();

            // termina el script    
            break;

            case 'obtener':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setMateriaPrimaID($materia_prima_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Obtener_MateriaPrima();

            // termina el script    
            break;

            case 'modificar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setUpdateMateriaPrimaData($materia_prima_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Actualizar_MateriaPrima();

            // termina el script    
            break;

            case 'eliminar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setMateriaPrimaID($materia_prima_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Eliminar_MateriaPrima();

            // termina el script    
            break;

            case 'consultar':

                // llama la funcion y retorna los datos
                return $this->Mostrar_MateriaPrima();

            // termina el script
            break;

            case 'obtener_Medidas':

                // llama la funcion y retorna los datos
                return $this->Obtener_Unidades_Medida();

            // termina el script
            break;

            default:

                // retorna un mensaje de error en caso de no existir la accion
                return['status' => false, 'msj' => 'Accion Invalida.'];

            // termina el script
            break;
        }
    }

    // funcion para consultar categorias
    private function Mostrar_MateriaPrima() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // consulta los productos activos en la base de datos
            $query = "SELECT m.*, 
                            p.nombre_proveedor,
                            p.tipo_id,
                            u.nombre_medida
                        FROM materia_prima m
                        INNER JOIN proveedores p ON m.id_proveedor = p.id_proveedor
                        INNER JOIN unidad_medidas u ON m.id_unidad_medida = u.id_unidad_medida
                        WHERE m.status = 1"; //valida el estado si esta activo

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // ejecuta la sentencia
            $stmt->execute(); 

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->rowCount() > 0) {

                // almacena los datos extraidos de la base de datos 
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Materia prima encontradas con exito.', 'data' => $data];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Materias primas no encontradas o inactivas'];
            }

        } catch (PDOException $e) {
            
            // retorna mensaje de error del exception del pdo
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {

            // finaliza la fincion cerrando la conexion a la bd
            $this->closeConnection();
        }
    }

    // funcion para registrar categoria
    private function Guardar_MateriaPrima() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // inserta una categoria
            $query = "INSERT INTO materia_prima (nombre_materia_prima, descripcion_materia_prima, stock_actual, id_unidad_medida, id_proveedor)
                                            VALUES (:nombre, :descripcion, :stock, :id_unidad_medida, :id_proveedor)";

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(':nombre', $this->getMateriaPrimaNombre());
            $stmt->bindValue(':descripcion', $this->getMateriaPrimaDescripcion());
            $stmt->bindValue(':stock', $this->getMateriaPrimaStock());
            $stmt->bindValue(':id_unidad_medida', $this->getMateriaPrimaMedida());
            $stmt->bindValue(':id_proveedor', $this->getMateriaPrimaProveedor());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos de usuario
                return['status' => true, 'msj' => 'Materia prima registrada con exito.'];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Error al registrar materia prima.'];
            }

        } catch (PDOException $e) {
            
            // retorna mensaje de error del exception del pdo
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {

            // finaliza la fincion cerrando la conexion a la bd
            $this->closeConnection();
        }
    }

    // funcion para obtener un registro
    private function Obtener_MateriaPrima() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // actualiza el status la categoria
            $query = "SELECT *
                        FROM materia_prima
                        WHERE id_materia_prima = :id AND status = 1";

            // prepar la sentencia 
            $stmt = $conn->prepare($query); 

            // vincula los parametros
            $stmt->bindValue(":id", $this->getMateriaPrimaID());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                // obtiene los datos de la consulta
                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Materia prima encontrada con exito.', 'data' => $data, 'data_bitacora' => $data];
            }
            else {

                // retiorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Materia prima no encontrada error.'];
            }

        } catch (PDOException $e) {
            
            // retorna mensaje de error del exception del pdo
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {

            // finaliza la fincion cerrando la conexion a la bd
            $this->closeConnection();
        }
    }

    // funcion para modificar categoria
    private function Actualizar_MateriaPrima() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // Obtener datos actuales antes de eliminar (para bitacora)
            $query_select = "SELECT * FROM materia_prima 
                                    WHERE id_materia_prima = :id 
                                    AND status = 1";

            // oeroara la sentencia
            $stmt_select = $conn->prepare($query_select);

            // vincula los parametros
            $stmt_select->bindValue(':id', $this->getMateriaPrimaID());

            // ejecuta la sentencia
            $stmt_select->execute();

            // se almacena arry asocc en la var
            $datos_anteriores = $stmt_select->fetch(PDO::FETCH_ASSOC);

            // inserta una categoria
            $query = "UPDATE materia_prima 
                        SET nombre_materia_prima = :nombre, 
                        descripcion_materia_prima = :descripcion, 
                        stock_actual = :stock, 
                        id_unidad_medida = :id_unidad_medida,  
                        id_proveedor = :id_proveedor
                        WHERE id_materia_prima = :id ";

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(':id', $this->getMateriaPrimaID());
            $stmt->bindValue(':nombre', $this->getMateriaPrimaNombre());
            $stmt->bindValue(':descripcion', $this->getMateriaPrimaDescripcion());
            $stmt->bindValue(':stock', $this->getMateriaPrimaStock());
            $stmt->bindValue(':id_unidad_medida', $this->getMateriaPrimaMedida());
            $stmt->bindValue(':id_proveedor', $this->getMateriaPrimaProveedor());
             
            // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos de usuario
                return['status' => true, 'msj' => 'Materia prima actualizada con exito.', 'data_bitacora' => $datos_anteriores];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Error al actualizar materia prima.'];
            }

        } catch (PDOException $e) {
            
            // retorna mensaje de error del exception del pdo
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {

            // finaliza la fincion cerrando la conexion a la bd
            $this->closeConnection();
        }
    }

    // funcion para elimanar un registro
    private function Eliminar_MateriaPrima() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // Obtener datos actuales antes de eliminar (para bitacora)
            $query_select = "SELECT * FROM materia_prima 
                                    WHERE id_materia_prima = :id 
                                    AND status = 1";

            // oeroara la sentencia
            $stmt_select = $conn->prepare($query_select);

            // vincula los parametros
            $stmt_select->bindValue(':id', $this->getMateriaPrimaID());

            // ejecuta la sentencia
            $stmt_select->execute();

            // se almacena arry asocc en la var
            $datos_anteriores = $stmt_select->fetch(PDO::FETCH_ASSOC);

            // actualiza el status la categoria
            $query = "UPDATE materia_prima
                        SET status = 0
                        WHERE id_materia_prima = :id";

            // prepar la sentencia 
            $stmt = $conn->prepare($query); 

            // vincula los parametros
            $stmt->bindValue(":id", $this->getMateriaPrimaID());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Materia prima eliminada con exito.', 'data_bitacora' => $datos_anteriores];
            }
            else {

                // retiorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Materia prima no eliminada error.'];
            }

        } catch (PDOException $e) {
            
            // retorna mensaje de error del exception del pdo
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {

            // finaliza la fincion cerrando la conexion a la bd
            $this->closeConnection();
        }
    }

    // funcion para obtenr la unidad de medida
    private function Obtener_Unidades_Medida() {

        // la conxecion es null por defecto
        $conn = $this->getConnectionNegocio();

        // para manejo de errores
        try {
            
            // consulta las unidades de medida activas en la base de datos
            $query = "SELECT * FROM unidad_medidas";

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // ejecuta la sentencia
            $stmt->execute(); 

            // se valida si se ejecuto la sentencia y si es true
            if ($stmt->rowCount() > 0) {

                // almacena los datos extraidos de la base de datos 
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Unidades de medida encontradas con exito.', 'data' => $data];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Unidades de medida no encontradas o inactivas'];
            }

        } catch (PDOException $e) {
            
            // retorna mensaje de error del exception del pdo
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {

            // finaliza la fincion cerrando la conexion a la bd
            $this->closeConnection();
        }
    }
}

?>