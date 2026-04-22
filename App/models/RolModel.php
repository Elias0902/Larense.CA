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

       if (empty($rol['id']) || empty($rol['nombre'])) {
            
            // retorna status de error
            return ['status' => false, 'msj' => 'Permisos vacios.'];
        }


        // asidna el modulo
        $this->id_rol = $rol['id'];

        // asigna el permiso
        $this->nombre_rol = $rol['nombre_rol'];
        
        // retorna true con el mensaje
        return['status' => true, 'msj' => 'Datos asignados correctamente.'];
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

       if (empty($rol['id'])) {
            
            // retorna status de error
            return ['status' => false, 'msj' => 'Permisos vacios.'];
        }

        // asigna el rol
        $this->id_rol = $rol['id'];
        
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

            case 'modificar':

                // asidna el resultado de la validacion
                $validacion = $this->setRolData($rol_json);

                // valida el estado de la valicacion
                if (!$validacion['status']) {

                    // retorna el status de la validacion
                    return $validacion;
                }

                // llama el metodo en caso de axito y retorna el status del metodo
                return $this->Modificar_Rol(); 
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

            case 'consultar':

                // llama el metodo en caso de axito y retorna el status del metodo
                return $this->Mostrar_Rol(); 
            break;

            default:
                return ['status' => false, 'msj' => 'Accion invalida'];
        }
    }

    private function Modificar_Rol() {
        
        // la conexion esta cerrado por defecto
        $this->closeConnection();
        
        // para manejo de errores
        try {

            // crea la conexion
            $conn = $this->getConnectionSeguridad();

            // consulta sql
            $query = "SELECT a.status, p.nombre_permiso, m.nombre_modulo 
                      FROM accesos a
                      JOIN modulos m ON a.id_modulo = m.id_modulo
                      JOIN permisos p ON a.id_permiso = p.id_permisos
                      WHERE a.id_rol = :rol
                      AND m.nombre_modulo = :modulo
                      AND p.nombre_permiso = :permiso
                      AND a.status = 1";

            // prepara la sentencia
            $stmt = $conn->prepare($query);

            // vincula los parametros 
            $stmt->bindValue(":rol", $this->getRol());
            $stmt->bindValue(":modulo", $this->getModulo());
            $stmt->bindValue(":permiso", $this->getPermiso());

            // se ejecuta la sentencia  
            $stmt->execute();

            // almacena el resultado de la sentencia
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            // valida si existe y si es true
            if ($resultado) {

                // retorna un status 
                return['status' => true, 'msj' => 'Permiso concedido.'];
            }
                
            // en caso de no tener permiso
            else {

                // retorna el status de error
                return['status' => false, 'msj' => 'No tiene permiso.'];
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
                    return['status' => false, 'msj' => 'No tiene permiso.'];
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

        private function Obtener_Rol() {
            
            // la conexion esta cerrado por defecto
            $this->closeConnection();
            
            // para manejo de errores
            try {

                // crea la conexion
                $conn = $this->getConnectionSeguridad();

                // consulta sql
                $query = "SELECT a.*, p.nombre_permiso, m.nombre_modulo 
                            FROM accesos a
                            JOIN modulos m ON a.id_modulo = m.id_modulo
                            JOIN permisos p ON a.id_permiso = p.id_permisos
                            WHERE id_rol = :rol";

                // prepara la sentencia
                $stmt = $conn->prepare($query);

                // vincula los parametros 
                $stmt->bindValue(":rol", $this->getRol());

                // se ejecuta la sentencia  
                $stmt->execute();

                // almacena el resultado de la sentencia
                $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // valida si existe y si es true
                if ($resultado) {

                    // retorna un status 
                    return['status' => true, 'msj' => 'Permiso concedido.', 'data' => $resultado];
                }
                    
                // en caso de no tener permiso
                else {

                    // retorna el status de error
                    return['status' => false, 'msj' => 'No tiene permiso.'];
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
}
    
?>