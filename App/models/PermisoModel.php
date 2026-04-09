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
            $conn = $this->getConnection();

            // consulta sql
            $query = "SELECT a.status, p.permiso_nombre, m.modulo_nombre 
                      FROM accesos a
                      JOIN modulos m ON a.modulo_id = m.modulo_id
                      JOIN permisos p ON a.permiso_id = p.permiso_id
                      WHERE a.rol_id = :rol
                      AND m.modulo_nombre = :modulo
                      AND p.permiso_nombre = :permiso
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
}
    
?>