<?php

require_once "ConexionModel.php";

class Rol extends Conexion {
    
    // Atributos
    private $id_rol;
    private $nombre_rol;

    // construcor
    public function __construct() {
        parent::__construct();
    }

    // SETTERS
    // Setters para los datos del permiso
    private function setRolData($rol_json) {
        
        // valida el json
        if (is_string($rol_json)) {

            //guarda el json
            $rol = json_decode($rol_json, true);
        }
        // en caso de error
        else {

            // retorna el estatus de mensaje 
            return['status' => false, 'msj' => 'JSON invalido.'];
        }

        // expreciones regulares y validaciones
        $expre_nombre = '/^[a-zA-Z\s]+$/'; //para el nombre
        $expre_id = '/^(0|[1-9][0-9]*)$/'; // para el id

        // almacena el id en la variable para despues validar
        $id = trim($rol['id'] ?? '');
        // valida el username si cumple con los requisitos
        if ($id === '' || !preg_match($expre_id, $id) > 10 || ($id) < 0) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'EL id del rol es invalido'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->id_rol = $id;

        // almacena el nombre en la variable para despues validar
        $nombre = trim($rol['nombre'] ?? '');
        // valida el username si cumple con los requisitos
        if ($nombre === '' || !preg_match($expre_nombre, $nombre) || strlen($nombre) > 20 || strlen($nombre) < 5) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'EL nombre del rol es invalido debe tener minimo 5 y maximo 20 caracteres y no debe tener caracteres especiales _  ej:Usuaio.'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->nombre_rol = $nombre;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

    private function setRolNombreData($rol_json) {
        
        // valida el json
        if (is_string($rol_json)) {

            //guarda el json
            $rol = json_decode($rol_json, true);
        }
        // en caso de error
        else {

            // retorna el estatus de mensaje 
            return['status' => false, 'msj' => 'JSON invalido.'];
        }

       // expreciones regulares y validaciones
        $expre_nombre = '/^[a-zA-Z\s]+$/'; //para el nombre
        $expre_id = '/^(0|[1-9][0-9]*)$/'; // para el ide

        // almacena el nombre en la variable para despues validar
        $nombre = trim($rol['nombre'] ?? '');
        // valida el username si cumple con los requisitos
        if ($nombre === '' || !preg_match($expre_nombre, $nombre) || strlen($nombre) > 20 || strlen($nombre) < 5) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'EL nombre del rol es invalido debe tener minimo 5 y maximo 20 caracteres y no debe tener caracteres especiales _  ej:Usuaio.'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->nombre_rol = $nombre;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

    private function setRolIDData($rol_json) {
        
        // valida el json
        if (is_string($rol_json)) {

            //guarda el json
            $rol = json_decode($rol_json, true);
        }
        // en caso de error
        else {

            // retorna el estatus de mensaje 
            return['status' => false, 'msj' => 'JSON invalido.'];
        }

        // expreciones regulares y validaciones
        $expre_nombre = '/^[a-zA-Z\s]+$/'; //para el nombre
        $expre_id = '/^(0|[1-9][0-9]*)$/'; // para el id

       // almacena el id en la variable para despues validar
        $id = trim($rol['id'] ?? '');
        // valida el username si cumple con los requisitos
        if ($id === '' || !preg_match($expre_id, $id) > 10 || ($id) < 0) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'EL id del rol es invalido'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->id_rol = $id;
        
        // retorna true con el mensaje
        return['status' => true, 'msj' => 'Datos asignados correctamente.'];
    }


    //GETTERS
    // getters para el rol
    private function getRolID() {
        return $this->id_rol;
    }

    // getters para el permiso
    private function getRolNombre() {
        return $this->nombre_rol;
    }


    //Indiferentemente sea la accion primero la funcion manejar accion llama a la 
    //funcion setcliente data que validad todos los valores
    //luego de que todo los datos sean validados correctamente
    //verifica que la variable validacion que contiene el status de la funcion sea correcta 
    //si es incorrecta retorna el status de mensajes de errores 
    //si es correcta me llama la funcion correspondiente 
    public function manejarAccion($accion, $rol_json) {
        
        // dependiend de la accion
        switch ($accion) {

            case 'agregar':

                // asidna el resultado de la validacion
                $validacion = $this->setRolNombreData($rol_json);

                // valida el estado de la valicacion
                if (!$validacion['status']) {

                    // retorna el status de la validacion
                    return $validacion;
                }

                // llama el metodo en caso de axito y retorna el status del metodo
                return $this->Guardar_Rol(); 
            break;    

            case 'modificar':

                // asidna el resultado de la validacion
                $validacion = $this->setRolData($rol_json);

                // valida el estado de la valicacion
                if (!$validacion['status']) {

                    // retorna el status de la validacion
                    return $validacion;
                }

                // llama el metodo en caso de axito y retorna el status del metodo
                return $this->Actualizar_Rol(); 
            break;

            case 'obtener':

                // asidna el resultado de la validacion
                $validacion = $this->setRolIDData($rol_json);

                // valida el estado de la valicacion
                if (!$validacion['status']) {

                    // retorna el status de la validacion
                    return $validacion;
                }

                // llama el metodo en caso de axito y retorna el status del metodo
                return $this->Obtener_Rol(); 
            break;

            case 'eliminar':

                // asidna el resultado de la validacion
                $validacion = $this->setRolIDData($rol_json);

                // valida el estado de la valicacion
                if (!$validacion['status']) {

                    // retorna el status de la validacion
                    return $validacion;
                }

                // llama el metodo en caso de axito y retorna el status del metodo
                return $this->Eliminar_Rol(); 
            break;

            case 'consultar':

                // llama el metodo en caso de axito y retorna el status del metodo
                return $this->Mostrar_Rol(); 
            break;

            default:
                return ['status' => false, 'msj' => 'Accion invalida'];
        }
    }

    // funcion para mostrar roles
    private function Mostrar_Rol() {
            
            // la conexion esta cerrado por defecto
            $this->closeConnection();
            
            // para manejo de errores
            try {

                // crea la conexion
                $conn = $this->getConnectionSeguridad();

                // consulta sql
                $query = "SELECT * 
                            FROM roles
                            WHERE status = 1";

                // prepara la sentencia
                $stmt = $conn->prepare($query);

                // se ejecuta la sentencia  
                $stmt->execute();

                // almacena el resultado de la sentencia
                $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // valida si existe y si es true
                if ($resultado) {

                    // retorna un status 
                    return['status' => true, 'msj' => 'Roles encontrados.', 'data' => $resultado];
                }
                    
                // en caso de no tener permiso
                else {

                    // retorna el status de error
                    return['status' => false, 'msj' => 'Error no se encontraron roles.'];
                }
            }

            // en caso de error en la consulta
            catch(PDOException $e) {

                // imprime el error en la consola
                error_log("Error de permisos: " . $e->getMessage());
                
                // retorna estatus de error
                return['status' => false, 'msj' => 'Error intentelo mas tarde' . $e->getMessage()];
            } 

            // para finalizar
            finally {

                // cierra la conexion
                $this->closeConnection();
            }
        }

        // funcion para guardar un rol
        private function Guardar_Rol() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionSeguridad();

            // inserta una categoria
            $query = "INSERT INTO roles (nombre_rol)
                                            VALUES (:nombre)";

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(':nombre', $this->getRolNombre());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {
                
                // OBTENER ID recién creado 
                $id_rol_nuevo = $conn->lastInsertId();
        
                // LLAMAR PreCargaAccess con el ID 
                $precarga = $this->PreCargaAccess($id_rol_nuevo);

                // almacena msj del precarga
                $msj = $precarga['msj'];

                //retorna el status con el mensaje y los datos de usuario
                return['status' => true, 'msj' => 'Rol Registrado con exito.' . $msj];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Error al registar rol.'];
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

        private function Obtener_Rol() {
            
            // la conexion esta cerrado por defecto
            $this->closeConnection();
            
            // para manejo de errores
            try {

                // crea la conexion
                $conn = $this->getConnectionSeguridad();

                // consulta sql
                $query = "SELECT * 
                            FROM roles
                            WHERE id_rol = :id";

                // prepara la sentencia
                $stmt = $conn->prepare($query);

                // vincula los parametros 
                $stmt->bindValue(":id", $this->getRolID());

                // se ejecuta la sentencia  
                $stmt->execute();

                // almacena el resultado de la sentencia
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                // valida si existe y si es true
                if ($resultado) {

                    // retorna un status 
                    return['status' => true, 'msj' => 'Rol encontrado.', 'data' => $resultado, 'data_bitacora' => $resultado];
                }
                    
                // en caso de no tener permiso
                else {

                    // retorna el status de error
                    return['status' => false, 'msj' => 'Error al encontrar rol.'];
                }
            }

            // en caso de error en la consulta
            catch(PDOException $e) {

                // imprime el error en la consola
                error_log("Error de permisos: " . $e->getMessage());
                
                // retorna estatus de error
                return['status' => false, 'msj' => 'Error intentelo mas tarde' . $e->getMessage()];
            } 

            // para finalizar
            finally {

                // cierra la conexion
                $this->closeConnection();
            }
        }

        // funcion para modificar un rol
        private function Actualizar_Rol() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionSeguridad();
            
            // Obtener datos actuales antes de actualizar (para bitacora)
            $query_select = "SELECT * FROM roles 
                                    WHERE id_rol = :id 
                                    AND status = 1";

            // prepara la consulta
            $stmt_select = $conn->prepare($query_select);

            // vincula los parametros
            $stmt_select->bindValue(':id', $this->getRolID());
            
            // ejecuta la sentencia
            $stmt_select->execute();

            // el arry assoc se almacena en la var
            $datos_anteriores = $stmt_select->fetch(PDO::FETCH_ASSOC);

            // modificar un rol
            $query = "UPDATE roles 
                        SET nombre_rol = :nombre 
                        WHERE id_rol = :id ";

            // prepara la sentencia 
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(':id', $this->getRolID());
            $stmt->bindValue(':nombre', $this->getRolNombre());
             
            // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos de usuario
                return['status' => true, 'msj' => 'Rol Actualizado con exito.', 'data_bitacora' => $datos_anteriores];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Error al actualizar rol.'];
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
    private function Eliminar_Rol() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionSeguridad();
            
            // Obtener datos actuales antes de eliminar (para bitacora)
            $query_select = "SELECT * FROM roles 
                                    WHERE id_rol = :id 
                                    AND status = 1";

            // oeroara la sentencia
            $stmt_select = $conn->prepare($query_select);

            // vincula los parametros
            $stmt_select->bindValue(':id', $this->getRolID());

            // ejecuta la sentencia
            $stmt_select->execute();

            // se almacena arry asocc en la var
            $datos_anteriores = $stmt_select->fetch(PDO::FETCH_ASSOC);

            // actualiza el status la categoria
            $query = "UPDATE roles
                        SET status = 0
                        WHERE id_rol = :id";

            // prepar la sentencia 
            $stmt = $conn->prepare($query); 

            // vincula los parametros
            $stmt->bindValue(":id", $this->getRolID());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Rol Eliminado con exito.', 'data_bitacora' => $datos_anteriores];
            }
            else {

                // retiorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Rol no eliminado error.'];
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

    // funcion que carga los pre accesos
    private function PreCargaAccess($id_rol_nuevo) {
    
        $this->closeConnection();
    
        try {
            $conn = $this->getConnectionSeguridad();
            
            // 1. Obtener último ID módulo
            $query_select_modulo = "SELECT MAX(id_modulo) AS ultimo_id FROM modulos";
            $stmt_select = $conn->prepare($query_select_modulo); // prepara la consulta
            $stmt_select->execute(); // ejecuta la consulta
            $ultimo_result = $stmt_select->fetch(PDO::FETCH_ASSOC); // se almacena los datos
            $max_modulo = (int)$ultimo_result['ultimo_id']; // Número (ej: 5)
            
            // valida la cantida de modulo
            if ($max_modulo < 1) {

                // retorna msj
                return ['status' => false, 'msj' => 'No hay módulos'];
            }
            
            //Query INSERT (una por permiso)
            $query_insert = "INSERT INTO accesos (id_rol, id_modulo, id_permiso, status) 
                            VALUES (:id_rol, :id_modulo, :id_permiso, 0)";
            $stmt = $conn->prepare($query_insert); //prepara la consulta
            
            // inicialisa la var en 0
            $total_inserts = 0;
            
            //BUCLE: Para cada módulo 1..$max_modulo
            for ($modulo = 1; $modulo <= $max_modulo; $modulo++) { // 1,2,3,4,5
                // 4 permisos por módulo
                foreach ([1, 2, 3, 4] as $permiso) {
                    $stmt->bindValue(':id_rol', $id_rol_nuevo, PDO::PARAM_INT);
                    $stmt->bindValue(':id_modulo', $modulo, PDO::PARAM_INT);  // 1,2,3...
                    $stmt->bindValue(':id_permiso', $permiso, PDO::PARAM_INT);
                    
                    // valida y incrementa contador
                    if ($stmt->execute()) {
                        
                        // se incrementa
                        $total_inserts++;
                    }
                }
            }
            
            // msj de exito
            return [
                'status' => true, 
                'msj' => " Con $total_inserts accesos para $max_modulo módulos."
            ];
            
        } catch (PDOException $e) {

            // msj de error
            return ['status' => false, 'msj' => 'Error: ' . $e->getMessage()];
        } 
        finally {

            // cierra conexion
            $this->closeConnection();
        }
    }

}
    
?>