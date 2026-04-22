<?php
// llama al modelo conexion
require_once "ConexionModel.php";

// se difine la clase
class TipoCliente extends Conexion {

    // Atributos
    private $tipo_cliente_id;
    private $tipo_cliente_nombre;
    private $dias_credito;

    // construcor
    public function __construct() {
        parent::__construct();
    }

    // SETTERS
    // setters para tipo de cliente
        private function setTipoClienteData($tipoCliente_json) {

        // valida si el json es string y lo descompone
        if (is_string($tipoCliente_json)) {

            // se almacena el contenido del json en la variable usuario
            $tipoCliente = json_decode($tipoCliente_json, true);
            
            // valida que el json cumpla con el formato requerido
            if ($tipoCliente === null) {

                // retorna un arry con el mensaje y el status
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        // expreciones regulares y validaciones
        $expre_nombre = '/^[a-zA-Z\s]+$/'; //para el nombre
        $expre_dias = '/^(0|[1-9][0-9]*)$/'; // para los dias de credito

        // almacena el nombre en la variable para despues validar
        $nombre = trim($tipoCliente['nombre'] ?? '');
        // valida el username si cumple con los requisitos
        if ($nombre === '' || !preg_match($expre_nombre, $nombre) || strlen($nombre) > 20 || strlen($nombre) < 5) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'EL nombre del tipo de cliente es invalido debe tener minimo 5 y maximo 20 caracteres y no debe tener caracteres especiales _  ej:Bebida.'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->tipo_cliente_nombre = $nombre;

        // almacena los dias de credito en la variable para despues validar
        $dias_credito = trim($tipoCliente['dias_credito'] ?? '');
        // valida el username si cumple con los requisitos
        if ($dias_credito === '' || 
            !preg_match($expre_dias, $dias_credito) || 
            strlen($dias_credito) > 3 ||  // Máx 3 dígitos (999 días máx)
            (int)$dias_credito < 7 ||     // Mínimo 7 días
            (int)$dias_credito > 90) {    // Máximo 90 días

            return ['status' => false, 'msj' => 'Días de crédito inválido. Debe ser entero entre 7-90 (ej: 7, 15, 30).'];
        }
    
            // asigna el valor al atributo del objeto si todo salio bien
            $this->dias_credito = $dias_credito;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

    private function setUpdateTipoClienteData($tipoCliente_json) {

        // valida si el json es string y lo descompone
        if (is_string($tipoCliente_json)) {

            // se almacena el contenido del json en la variable usuario
            $tipoCliente = json_decode($tipoCliente_json, true);
            
            // valida que el json cumpla con el formato requerido
            if ($tipoCliente === null) {

                // retorna un arry con el mensaje y el status
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        // expreciones regulares y validaciones
        $expre_nombre = '/^[a-zA-Z\s]+$/'; //para el nombre
        $expre_dias = '/^(0|[1-9][0-9]*)$/'; // para los dias de credito

        // almacena el id en la variable para despues validar
        $id = trim($tipoCliente['id'] ?? '');
        // valida el username si cumple con los requisitos
        if ($id === '') {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'EL id del tipo de cliente es invalido'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->tipo_cliente_id = $id;

        // almacena el nombre en la variable para despues validar
        $nombre = trim($tipoCliente['nombre'] ?? '');
        // valida el username si cumple con los requisitos
        if ($nombre === '' || !preg_match($expre_nombre, $nombre) || strlen($nombre) > 20 || strlen($nombre) < 5) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'EL nombre del tipo de cliente es invalido debe tener minimo 5 y maximo 20 caracteres y no debe tener caracteres especiales _  ej:Bebida.'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->tipo_cliente_nombre = $nombre;

        // almacena los dias de credito en la variable para despues validar
        $dias_credito = trim($tipoCliente['dias_credito'] ?? '');
        
        // valida el username si cumple con los requisitos
        if ($dias_credito === '' || 
            !preg_match($expre_dias, $dias_credito) || 
            strlen($dias_credito) > 3 ||  // Máx 3 dígitos (999 días máx)
            (int)$dias_credito < 7 ||     // Mínimo 7 días
            (int)$dias_credito > 90) {    // Máximo 90 días

            return ['status' => false, 'msj' => 'Días de crédito inválido. Debe ser entero entre 7-90 (ej: 7, 15, 30).'];
        }
    
            // asigna el valor al atributo del objeto si todo salio bien
            $this->dias_credito = $dias_credito;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

    // setters para el id de la categoria
    private function setTipoClienteID($tipoCliente_json) {

        // valida si el json es string y lo descompone
        if (is_string($tipoCliente_json)) {

            // se almacena el contenido del json en la variable usuario
            $tipoCliente = json_decode($tipoCliente_json, true);
            
            // valida que el json cumpla con el formato requerido
            if ($tipoCliente === null) {

                // retorna un arry con el mensaje y el status
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        // expreciones regulares y validaciones
        $expre_id = '/^(0|[1-9][0-9]*)$/'; // para el id

        // almacena el id en la variable para despues validar
        $id = trim($tipoCliente['id'] ?? '');
        // valida el username si cumple con los requisitos
        if ($id === '' || !preg_match($expre_id, $id) || strlen($id) > 10 || strlen($id) < 0) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'EL id del tipo de cliente es invalido'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->tipo_cliente_id = $id;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

    // GETTERS
    //getters para el id
    private function getTipoClienteID() {
        
        // retorna el id a utilizar
        return $this->tipo_cliente_id;
    }

    // getters para el nombre
    private function getTipoClienteNombre() {

        // retorna el nombre a utilizar
        return $this->tipo_cliente_nombre;
    }

    // getters para los dias de credito
    private function getDiasCredito() {

        // retorna los dias de credito a utilizar
        return $this->dias_credito;
    }

    // Esta se encarga de procesar los action indiferentemente cual sea llama la funcion de 
    // validacio y luego al metodo correspondiente al action
    // donde primero recibe el action como primer parametro que son los de agregar etc.. 
    // y el objeto json como segundo parametro para las validaciones y asiganciones al objeto 
    public function manejarAccion($action, $tipoCliente_json ){

        // maneja el action y carga la funcion correspondiente a la action
        switch($action){

            case 'agregar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setTipoClienteData($tipoCliente_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Guardar_TipoCliente();

            // termina el script    
            break;

            case 'obtener':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setTipoClienteID($tipoCliente_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Obtener_TipoCliente();

            // termina el script    
            break;

            case 'modificar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setUpdateTipoClienteData($tipoCliente_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Actualizar_TipoCliente();

            // termina el script    
            break;

            case 'eliminar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setTipoClienteID($tipoCliente_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Eliminar_TipoCliente();

            // termina el script    
            break;

            case 'consultar':

                // llama la funcion y retorna los datos
                return $this->Mostrar_TipoCliente();

            // termina el script
            break;

            default:

                // retorna un mensaje de error en caso de no existir la accion
                return['status' => false, 'msj' => 'Accion Invalida.'];

            // termina el script
            break;
        }
    }

    // funcion para consultar tipos de cliente
    private function Mostrar_TipoCliente() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // consulta los tipos de cliente
            $query = "SELECT *
                        FROM tipos_clientes
                        WHERE status = 1"; //valida el estado si esta activo

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // ejecuta la sentencia
            $stmt->execute(); 

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->rowCount() > 0) {

                // almacena los datos extraidos de la base de datos 
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Tipos de cliente encontrados con exito.', 'data' => $data];
            }
            else {

                // reti=rona un status de error con un mensaje 
                return['status' => false, 'msj' => 'Tipos de cliente no encontrados o inactivos'];
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

    // funcion para registrar tipo de cliente
    private function Guardar_TipoCliente() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // inserta un tipo de cliente
            $query = "INSERT INTO tipos_clientes (nombre_tipo_cliente, dias_credito)
                                            VALUES (:nombre, :dias)";

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(':nombre', $this->getTipoClienteNombre());
            $stmt->bindValue(':dias', $this->getDiasCredito());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos de usuario
                return['status' => true, 'msj' => 'Tipo de cliente Registrado con exito.'];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Error al registar tipo de cliente.'];
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
    private function Obtener_TipoCliente() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // actualiza el status el tipo de cliente
            $query = "SELECT *
                        FROM tipos_clientes
                        WHERE id_tipo_cliente = :id AND status = 1";

            // prepar la sentencia 
            $stmt = $conn->prepare($query); 

            // vincula los parametros
            $stmt->bindValue(":id", $this->getTipoClienteID());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                // obtiene los datos de la consulta
                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Tipo de cliente encontrado con exito.', 'data' => $data, 'data_bitacora' => $data];
            }
            else {

                // retiorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Tipos de clientes no encontrados error.'];
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

    // funcion para modificar tipo de cliente
    private function Actualizar_TipoCliente() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // Obtener datos actuales antes de eliminar (para bitacora)
            $query_select = "SELECT * FROM tipos_clientes 
                                    WHERE id_tipo_cliente = :id 
                                    AND status = 1";

            // oeroara la sentencia
            $stmt_select = $conn->prepare($query_select);

            // vincula los parametros
            $stmt_select->bindValue(':id', $this->getTipoClienteID());

            // ejecuta la sentencia
            $stmt_select->execute();

            // se almacena arry asocc en la var
            $datos_anteriores = $stmt_select->fetch(PDO::FETCH_ASSOC);

            // inserta una categoria
            $query = "UPDATE tipos_clientes 
                        SET nombre_tipo_cliente = :nombre, 
                        dias_credito = :dias
                        WHERE id_tipo_cliente = :id ";

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(':id', $this->getTipoClienteID());
            $stmt->bindValue(':nombre', $this->getTipoClienteNombre());
            $stmt->bindValue(':dias', $this->getDiasCredito());

            // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos de usuario
                return['status' => true, 'msj' => 'Tipo de cliente Actualizado con exito.', 'data_bitacora' => $datos_anteriores];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Error al actualizar tipo de cliente.'];
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
    private function Eliminar_TipoCliente() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // Obtener datos actuales antes de eliminar (para bitacora)
            $query_select = "SELECT * FROM tipos_clientes 
                                    WHERE id_tipo_cliente = :id 
                                    AND status = 1";

            // oeroara la sentencia
            $stmt_select = $conn->prepare($query_select);

            // vincula los parametros
            $stmt_select->bindValue(':id', $this->getTipoClienteID());

            // ejecuta la sentencia
            $stmt_select->execute();

            // se almacena arry asocc en la var
            $datos_anteriores = $stmt_select->fetch(PDO::FETCH_ASSOC);

            // actualiza el status el tipo de cliente
            $query = "UPDATE tipos_clientes
                        SET status = 0
                        WHERE id_tipo_cliente = :id";

            // prepar la sentencia 
            $stmt = $conn->prepare($query); 

            // vincula los parametros
            $stmt->bindValue(":id", $this->getTipoClienteID());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Tipo de cliente Eliminado con exito.', 'data_bitacora' => $datos_anteriores];
            }
            else {

                // retiorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Tipos de clientes no eliminados error.'];
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

    // funcion para obtener estadisticas de clientes por tipo/categoria
    public function Estadisticas_Clientes_Por_Categoria() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT 
                        tc.id_tipo_cliente,
                        tc.nombre_tipo_cliente as categoria,
                        COUNT(c.id_cliente) as total_clientes
                      FROM tipos_clientes tc
                      LEFT JOIN clientes c ON tc.id_tipo_cliente = c.id_tipo_cliente AND c.status = 1
                      WHERE tc.status = 1
                      GROUP BY tc.id_tipo_cliente, tc.nombre_tipo_cliente
                      ORDER BY tc.id_tipo_cliente DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return ['status' => true, 'msj' => 'Estadísticas obtenidas', 'data' => $data];
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }
}

?>