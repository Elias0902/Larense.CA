<?php

require_once "ConexionModel.php";

class Bitacora extends Conexion{
    //Atributos
    private $id_bitacora;
    private $id_usuario;
    private $fecha_bitacora;
    private $modulo_bitacora;
    private $accion_bitacora;
    private $descripcion_bitacora;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    // SETTERS
    // set para la bitacora
    private function setBitacoraData($bitacora_json){

        // valida si el json es string y lo descompone
        if (is_string($bitacora_json)) {

            // se almacena el contenido del json en la variable usuario
            $bitacora = json_decode($bitacora_json, true);
            
            // valida que el json cumpla con el formato requerido
            if ($bitacora === null) {

                // retorna un arry con el mensaje y el status
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        //esprex
        $expre = '/^[a-zA-Z\s]+$/'; //para modulo, accion y descripcion

        // almacena el id del usuario en la variable para despues validar
        $usuario = $bitacora['id_usuario'] ?? null;
        // valida el username si cumple con los requisitos
        if ($usuario === '' || $usuario === 'null' || $usuario === null) {
            
            // asigna valor null
            $this->id_usuario = null;
        }
        else{
            
            // asigna el valor al atributo del objeto si todo salio bien
            $this->id_usuario = $usuario;
        }


        // almacena el id del usuario en la variable para despues validar
        $fecha = trim($bitacora['fecha'] ?? '');
        // valida el username si cumple con los requisitos
        if ($fecha === '') {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'La fecha es invalido'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->fecha_bitacora = $fecha;


        // almacena el valor en la variable para despues validar
        $modulo = trim($bitacora['modulo'] ?? '');
        // valida el valor si cumple con los requisitos
        if ($modulo === '' || !preg_match($expre, $modulo) || strlen($modulo) > 50 || strlen($modulo) < 3) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'EL modulo es invalido debe tener minimo 3 y maximo 50 caracteres y no debe tener caracteres especiales _  ej:Cliente.'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->modulo_bitacora = $modulo;


        // almacena el valor en la variable para despues validar
        $accion = trim($bitacora['accion'] ?? '');
        // valida el valor si cumple con los requisitos
        if ($accion === '' || !preg_match($expre, $accion) || strlen($accion) > 50 || strlen($accion) < 3) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'EL modulo es invalido debe tener minimo 3 y maximo 50 caracteres y no debe tener caracteres especiales _  ej:Cliente.'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->accion_bitacora = $accion;


        // almacena el valor en la variable para despues validar
        $descripcion = trim($bitacora['descripcion'] ?? '');
        // valida el valor si cumple con los requisitos
        if ($descripcion === '' || strlen($descripcion) > 500 || strlen($descripcion) < 3) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'La descripcion es invalido debe tener minimo 3 y maximo 500 caracteres y no debe tener caracteres especiales _  ej:Cliente.'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->descripcion_bitacora = $descripcion;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

    // set para el id de la bitacora
    private function setIdBitacoraData($bitacora_json){

        // valida si el json es string y lo descompone
        if (is_string($bitacora_json)) {

            // se almacena el contenido del json en la variable usuario
            $bitacora = json_decode($bitacora_json, true);
            
            // valida que el json cumpla con el formato requerido
            if ($bitacora === null) {

                // retorna un arry con el mensaje y el status
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        // almacena el id en la variable para despues validar
        $id = trim($bitacora['id'] ?? '');
        // valida el username si cumple con los requisitos
        if ($id === '') {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'EL id de la bitacora es invalido'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->id_bitacora = $id;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

    // GETTERRS
    // get para el id de la bitacora
    private function getIdBitacora(){

        //retorna valor
        return $this->id_bitacora;
    }

    // get para el id usuario
    private function getIdUsuario(){

        // retorna valor
        return $this->id_usuario;
    }

    // get para la fecha
    private function getFecha(){

        // retorna valor
        return $this->fecha_bitacora;
    }

    // get para el modulo
    private function getModulo(){

        //retorna valor 
        return $this->modulo_bitacora;
    }

    // get para la accion
    private function getAccion(){

        //retorna el valor
        return $this->accion_bitacora;
    }

    // get para la descripcion
    private function getDescripcion(){

        // retorna el valor
        return $this->descripcion_bitacora;
    }

    // Esta se encarga de procesar los action indiferentemente cual sea llama la funcion de 
    // validacio y luego al metodo correspondiente al action
    // donde primero recibe el action como primer parametro que son los de agregar etc.. 
    // y el objeto json como segundo parametro para las validaciones y asiganciones al objeto 
    public function manejarAccion($action, $bitacora_json ){

        // maneja el action y carga la funcion correspondiente a la action
        switch($action){

            case 'agregar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setBitacoraData($bitacora_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Guardar_Bitacora();

            // termina el script    
            break;

            case 'obtener':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setIdBitacoraData($bitacora_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Obtener_Bitacora();

            // termina el script    
            break;

            case 'consultar':

                // llama la funcion y retorna los datos
                return $this->Mostrar_Bitacora();

            // termina el script
            break;

            default:

                // retorna un mensaje de error en caso de no existir la accion
                return['status' => false, 'msj' => 'Accion Invalida.'];

            // termina el script
            break;
        }
    }

    // Funcion para mostrar los registro de la bitacora
    private function Mostrar_Bitacora() {

        // la conexxion por defecto cerrada
        $this->closeConnection();

        // para manejo de errores
        try{

            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionSeguridad();
            
            // Consulta
            $query = "SELECT b.*, u.nombre_usuario
                      FROM bitacoras b
                      LEFT JOIN usuarios u ON b.id_usuario = u.id_usuario
                      ";
            
            // prepara la sentencia
            $stmt = $conn->prepare($query);

            //ejecuta la sentencia
            $stmt->execute();
            
            // se valida si se ejecuto la sentencia y si es true
            if ($stmt->rowCount() > 0) {

                // almacena los datos extraidos de la base de datos 
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Bitacora encontradas con exito.', 'data' => $data];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Bitacora no encontradas o inactivas'];
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

    // funcion para guardar los registro de la bitacoras
    private function Guardar_Bitacora()
    {
        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {

            // para la coneccion a la bd de seguridad
            $conn = $this->getConnectionSeguridad();

            // consulta la para la insercion de la bitacora en la bd
            $query = "INSERT INTO bitacoras (id_usuario, modulo, accion, descripcion, fecha_bitacora) 
                      VALUES (:id_usuario, :modulo, :accion, :descripcion, :fecha)";
            
            // prepara la sentencia
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(":id_usuario", $this->getIdUsuario());
            $stmt->bindValue(":modulo", $this->getModulo());
            $stmt->bindValue(":accion", $this->getAccion());
            $stmt->bindValue(":descripcion", $this->getDescripcion());
            $stmt->bindValue(":fecha", $this->getFecha());
            
            // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos de usuario
                return['status' => true, 'msj' => 'Bitacora Registrado con exito.'];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Error al registrar bitacora.'];
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

    // Método para obtener bitacora
    private function Obtener_Bitacora(){

        // la conexxion por defecto cerrada
        $this->closeConnection();

        // para manejo de errores
        try{

            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionSeguridad();
            
            // Consulta
            $query = "SELECT b.*, u.nombre_usuario
                      FROM bitacoras b
                      LEFT JOIN usuarios u ON b.id_usuario = u.id_usuario
                      WHERE id_bitacora = :id";
            
            // prepara la sentencia
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(":id", $this->getIdBitacora());

            //ejecuta la sentencia
            $stmt->execute();
            
            // se valida si se ejecuto la sentencia y si es true
            if ($stmt->rowCount() > 0) {

                // almacena los datos extraidos de la base de datos 
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Bitacora encontradas con exito.', 'data' => $data];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Bitacora no encontradas'];
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