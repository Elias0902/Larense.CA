<?php

require_once "ConexionModel.php";

class Permiso extends Conexion {
    
    // Atributos
    private $estatus;
    private $modulo;
    private $id;
    private $rol;
    private $permiso;

    // construcor
    public function __construct() {
        parent::__construct();
    }

    // SETTERS
    // Setters para los datos del permiso
    private function setPermisoData($permiso_json) {
        
        // valida el json
        if (is_string($permiso_json)) {

            //guarda el json
            $permiso = json_decode($permiso_json, true);
        }
        // en caso de error
        else {

            // retorna el estatus de mensaje 
            return['status' => false, 'msj' => 'JSON invalido.'];
        }

       if (empty($permiso['modulo']) || empty($permiso['permiso']) || empty($permiso['rol'])) {
            
            // retorna status de error
            return ['status' => false, 'msj' => 'Permisos vacios.'];
        }


        // asidna el modulo
        $this->modulo = $permiso['modulo'];

        // asigna el permiso
        $this->permiso = $permiso['permiso'];

        // asigna el rol
        $this->rol = $permiso['rol'];
        
        // retorna true con el mensaje
        return['status' => true, 'msj' => 'Datos asignados correctamente.'];
    }

    private function setPermisoUpdateData($permiso_json) {
        
        // valida el json
        if (is_string($permiso_json)) {

            //guarda el json
            $permiso = json_decode($permiso_json, true);
        }
        // en caso de error
        else {

            // retorna el estatus de mensaje 
            return['status' => false, 'msj' => 'JSON invalido.'];
        }

       if (empty($permiso['id_modulo']) || empty($permiso['id_permiso']) || empty($permiso['id_rol'])) {
            
            // retorna status de error
            return ['status' => false, 'msj' => 'Permisos vacios.'];
        }


        // asidna el modulo
        $this->modulo = $permiso['id_modulo'];

        // asigna el permiso
        $this->permiso = $permiso['id_permiso'];

        // asigna el rol
        $this->rol = $permiso['id_rol'];

        // asigna status
        $this->status = $permiso['status'];
        
        // retorna true con el mensaje
        return['status' => true, 'msj' => 'Datos asignados correctamente.'];
    }

    private function setPermisoRolData($permiso_json) {

        // valida el json
        if (is_string($permiso_json)) {

            //guarda el json
            $permiso = json_decode($permiso_json, true);
        }
        // en caso de error
        else {

            // retorna el estatus de mensaje
            return['status' => false, 'msj' => 'JSON invalido.'];
        }

       if (empty($permiso['id'])) {

            // retorna status de error
            return ['status' => false, 'msj' => 'Permisos vacios.'];
        }

        // asigna el rol
        $this->rol = $permiso['id'];

        // retorna true con el mensaje
        return['status' => true, 'msj' => 'Datos asignados correctamente.'];
    }


    //GETTERS
    //getters para el modulo
    private function getModulo() {
        return $this->modulo;
    }

    // getters para el rol
    private function getRol() {
        return $this->rol;
    }

    // getters para el permiso
    private function getPermiso() {
        return $this->permiso;
    }

    private function getStatus() {
        return $this->status;
    }


    //Indiferentemente sea la accion primero la funcion manejar accion llama a la 
    //funcion setcliente data que validad todos los valores
    //luego de que todo los datos sean validados correctamente
    //verifica que la variable validacion que contiene el status de la funcion sea correcta 
    //si es incorrecta retorna el status de mensajes de errores 
    //si es correcta me llama la funcion correspondiente 
    public function manejarAccion($accion, $permiso_json) {
        
        // dependiend de la accion
        switch ($accion) {

            case 'verificar':

                // asidna el resultado de la validacion
                $validacion = $this->setPermisoData($permiso_json);

                // valida el estado de la valicacion
                if (!$validacion['status']) {

                    // retorna el status de la validacion
                    return $validacion;
                }

                // llama el metodo en caso de axito y retorna el status del metodo
                return $this->Verificar_Permiso(); 
            break;

            case 'actualizar':

                // asidna el resultado de la validacion
                $validacion = $this->setPermisoUpdateData($permiso_json);

                // valida el estado de la valicacion
                if (!$validacion['status']) {

                    // retorna el status de la validacion
                    return $validacion;
                }

                // llama el metodo en caso de axito y retorna el status del metodo
                return $this->Actualizar_Permiso(); 
            break;

            case 'obtener':

                // asidna el resultado de la validacion
                $validacion = $this->setPermisoRolData($permiso_json);

                // valida el estado de la valicacion
                if (!$validacion['status']) {

                    // retorna el status de la validacion
                    return $validacion;
                }

                // llama el metodo en caso de axito y retorna el status del metodo
                return $this->Obtener_Permisos();
            break;

            case 'obtener_modulo':

                // asidna el resultado de la validacion
                $validacion = $this->setPermisoRolData($permiso_json);

                // valida el estado de la valicacion
                if (!$validacion['status']) {

                    // retorna el status de la validacion
                    return $validacion;
                }

                // llama el metodo en caso de axito y retorna el status del metodo
                return $this->Obtener_Permisos_Modulo();
            break;

            case 'obtener_modulos':

                // asidna el resultado de la validacion
                $validacion = $this->setPermisoRolData($permiso_json);

                // valida el estado de la valicacion
                if (!$validacion['status']) {

                    // retorna el status de la validacion
                    return $validacion;
                }

                // llama el metodo en caso de axito y retorna el status del metodo
                return $this->Obtener_Modulos_Por_Rol();
            break;

            default:
                return ['status' => false, 'msj' => 'Accion invalida'];
        }
    }

    private function verificar_Permiso() {
        
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

    private function Actualizar_Permiso() {
        
        // la conexion esta cerrado por defecto
        $this->closeConnection();
        
        // para manejo de errores
        try {

            // crea la conexion
            $conn = $this->getConnectionSeguridad();

            // consulta sql
            $query = "UPDATE accesos 
                        SET status = :estado 
                        WHERE id_permiso = :permiso
                        AND id_modulo = :modulo
                        AND id_rol = :rol";

            // prepara la sentencia
            $stmt = $conn->prepare($query);

            // vincula los parametros 
            $stmt->bindValue(":rol", $this->getRol());
            $stmt->bindValue(":modulo", $this->getModulo());
            $stmt->bindValue(":permiso", $this->getPermiso());
            $stmt->bindValue(":estado", $this->getStatus());

            // se ejecuta la sentencia  
            $stmt->execute();

            // almacena el resultado de la sentencia
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            // valida si existe y si es true
            if ($resultado) {

                // retorna un status 
                return['status' => true, 'msj' => 'Permiso actualizado.'];
            }
                
            // en caso de no tener permiso
            else {

                // retorna el status de error
                return['status' => false, 'msj' => 'Error al actualizar permiso.'];
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

    private function Obtener_Permisos() {

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

    private function Obtener_Permisos_Modulo() {

            // la conexion esta cerrado por defecto
            $this->closeConnection();

            // para manejo de errores
            try {

                // crea la conexion
                $conn = $this->getConnectionSeguridad();

                // consulta sql - obtiene módulos donde el rol tiene al menos un permiso activo
                $query = "SELECT a.id_rol,
                                 a.id_modulo,
                                 a.id_permiso,
                                 a.status,
                                 p.nombre_permiso,
                                 m.nombre_modulo
                            FROM accesos a
                            INNER JOIN modulos m ON a.id_modulo = m.id_modulo
                            INNER JOIN permisos p ON a.id_permiso = p.id_permisos
                            WHERE a.id_rol = :rol
                            AND a.status = 1
                            ORDER BY m.id_modulo";

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

                    // retorna un status con los módulos
                    return['status' => true, 'msj' => 'Módulos encontrados.', 'data' => $resultado];
                }

                // en caso de no tener módulos
                else {

                    // retorna el status de error
                    return['status' => false, 'msj' => 'No tiene módulos asignados.'];
                }
            }

            // en caso de error en la consulta
            catch(PDOException $e) {

                // imprime el error en la consola
                error_log("Error de módulos: " . $e->getMessage());

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