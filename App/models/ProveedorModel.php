<?php
// llama al modelo conexion
require_once "ConexionModel.php";

// se difine la clase
class Proveedor extends Conexion {

    // Atributos
    private $id_proveedor;
    private $tipo_id;
    private $nombre_proveedor;
    private $direccion_proveedor;
    private $tlf_proveedor;
    private $email_proveedor;



    // construcor
    public function __construct() {
        parent::__construct();
    }

    // SETTERS
    // setters para proveedor
        private function setProveedorData($proveedor_json){

        //Verificar y decodificar JSON
        if (is_string($proveedor_json)) {
            $proveedor = json_decode($proveedor_json, true);

            if ($proveedor === null) {
                return ['status' => false, 'msj' => 'JSON inválido.'];
            }
        } elseif (is_array($proveedor_json)) {
            $proveedor = $proveedor_json;
        } else {
            return ['status' => false, 'msj' => 'Formato de datos inválido.'];
        }

        //Validar nombre
        $nombre_raw = $proveedor['nombre'] ?? '';

        // El nombre se limpia de espacios al inicio y al final
        $nombre = trim($nombre_raw);

        // Expresión regular para validar que el nombre solo contenga letras y espacios
        $expre_nombre = '/^[a-zA-Z]+(?:\s+[a-zA-Z0-9]+)*$/';

        // Valida que el nombre no esté vacío, que solo contenga letras y espacios, y que tenga una longitud adecuada
        if ($nombre === '') {
            
            // Retorna un mensaje de error si el nombre está vacío
            return ['status' => false, 'msj' => 'Debe ingresar un nombre de proveedor.'];
        }

        // Valida que el nombre solo contenga letras y espacios
        if (!preg_match($expre_nombre, $nombre)) {
            
            // Retorna un mensaje de error si el nombre contiene caracteres no permitidos
            return [
                'status' => false,
                'msj' => 'El nombre del producto solo puede contener letras y espacios.'
            ];
        }

        if (strlen($nombre) < 2 || strlen($nombre) > 100) { // ajusta el max según tu js
            
            // Retorna un mensaje de error si el nombre no tiene la longitud adecuada
            return [
                'status' => false,
                'msj' => 'El nombre del proveedor debe tener entre 2 y 100 caracteres.'
            ];
        }

        // Asigna el nombre al atributo del objeto
        $this->nombre_proveedor = $nombre;

        //Validar rif
        $id_proveedor= trim($proveedor['id'] ?? '');

        // Valida que el rif no esté vacío
        if ($id_proveedor === '' || !is_numeric($id_proveedor) || (int)$id_proveedor <= 0) {

            // Retorna un mensaje de error si el rif está vacío
            return ['status' => false, 'msj' => 'Debe ingresar un rif de proveedor válido.'];
        }

        // Asigna el rif al atributo del objeto
        $this->id_proveedor = $id_proveedor;

        //Validar tipo de identificación
        $tipo_id = trim($proveedor['tipo_id'] ?? '');

        // Valida que el tipo de identificación no esté vacío
        if ($tipo_id === '') {
            return ['status' => false, 'msj' => 'Debe seleccionar un tipo de identificación.'];
        }

        // Asigna el tipo de identificación al atributo del objeto
        $this->tipo_id = $tipo_id;

        //Validar dirección
        $direccion_raw = $proveedor['direccion'] ?? '';

        // El precio se limpia de espacios al inicio y al final, y se reemplazan comas por puntos
        $direccion = trim($direccion_raw);

        // Valida que la dirección no esté vacía
        if ($direccion === '' || strlen($direccion) < 5 || strlen($direccion) > 200) {
            return ['status' => false, 'msj' => 'Debe ingresar una dirección de proveedor válida.'];
        }

        // Asigna la dirección al atributo del objeto
        $this->direccion_proveedor = $direccion;

        //Validar tlf
        $tlf_raw = $proveedor['tlf'] ?? '';

        // El teléfono se limpia de espacios al inicio y al final
        $tlf = trim($tlf_raw);
        $tlf_expre = '/^(0251|0212|0412|0414|0416|0422|0424|0426)\d{7}$/'; // Expresión regular para validar un número de teléfono de 8 a 9 dígitos

        // Valida que el teléfono no esté vacío y que sea un número
        if ($tlf === '' || !preg_match($tlf_expre, $tlf) || strlen($tlf) < 11 || strlen($tlf) > 11) {
            return ['status' => false, 'msj' => 'Debe ingresar un teléfono válido (ej: 0412-1234567, +584121234567).'];
        }

        // Asigna el teléfono al atributo del objeto
        $this->tlf_proveedor = $tlf;

        // Validar email
        $email_raw = $proveedor['email'] ?? '';

        // El email se limpia de espacios al inicio y al final
        $email = trim($email_raw);

        // Valida que el email no esté vacío y que tenga un formato válido
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['status' => false, 'msj' => 'Debe ingresar un email de proveedor válido.'];
        }

        // Asigna el email al atributo del objeto
        $this->email_proveedor = $email;

        //Si todo está bien
        return [
            'status' => true,
            'msj'  => 'Datos validados y asignados correctamente.'
        ];
    }

    // setters para el id de proveedor
    private function setProveedorID($proveedor_json) {

        // valida si el json es string y lo descompone
        if (is_string($proveedor_json)) {

            // se almacena el contenido del json en la variable usuario
            $proveedor = json_decode($proveedor_json, true);
            
            // valida que el json cumpla con el formato requerido
            if ($proveedor === null) {

                // retorna un arry con el mensaje y el status
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        // almacena el id en la variable para despues validar
        $id = trim($proveedor['id'] ?? '');
        // valida el username si cumple con los requisitos
        if ($id === '') {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'El rif es invalido'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->id_proveedor = $id;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

    // GETTERS
    //getters para el id
    private function getProveedorID() {
        
        // retorna el id a utilizar
        return $this->id_proveedor;
    }

    //para el tipo de id
    private function getTipoIDProveedor() {

        // retorna el tipo de id a utilizar
        return $this->tipo_id;
    }

    // getters para el nombre
    private function getNombreProveedor() {

        // retorna el nombre a utilizar
        return $this->nombre_proveedor;
    }

    private function getDireccionProveedor() {
        return $this->direccion_proveedor;
    }

    private function getTlfProveedor() {
        
        // retorna el telefono a utilizar
        return $this->tlf_proveedor;
    }

    private function getEmailProveedor() {

        // retorna el email a utilizar
        return $this->email_proveedor;
    }

    // Esta se encarga de procesar los action indiferentemente cual sea llama la funcion de 
    // validacio y luego al metodo correspondiente al action
    // donde primero recibe el action como primer parametro que son los de agregar etc.. 
    // y el objeto json como segundo parametro para las validaciones y asiganciones al objeto 
    public function manejarAccion($action, $proveedor_json ){

        // maneja el action y carga la funcion correspondiente a la action
        switch($action){

            case 'agregar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setProveedorData($proveedor_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Guardar_Proveedor();

            // termina el script    
            break;

            case 'obtener':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setProveedorID($proveedor_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Obtener_Proveedor();

            // termina el script    
            break;

            case 'modificar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setProveedorData($proveedor_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Actualizar_Proveedor();

            // termina el script    
            break;

            case 'eliminar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setProveedorID($proveedor_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Eliminar_Proveedor();

            // termina el script    
            break;

            case 'consultar':

                // llama la funcion y retorna los datos
                return $this->Mostrar_Proveedor();

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
    private function Mostrar_Proveedor() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // consulta los proveedores activos en la base de datos
            $query = "SELECT *
                        FROM proveedores
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
                return['status' => true, 'msj' => 'Proveedores encontrados con exito.', 'data' => $data];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Proveedores no encontrados o inactivos'];
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
    private function Guardar_Proveedor() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // inserta una categoria
            $query = "INSERT INTO proveedores (id_proveedor, tipo_id, nombre_proveedor, direccion_proveedor, tlf_proveedor, email_proveedor)
                                            VALUES (:id, :tipo_id, :nombre, :direccion, :telefono, :email)";

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(':id', $this->getProveedorID());
            $stmt->bindValue(':tipo_id', $this->getTipoIDProveedor());
            $stmt->bindValue(':nombre', $this->getNombreProveedor());
            $stmt->bindValue(':direccion', $this->getDireccionProveedor());
            $stmt->bindValue(':telefono', $this->getTlfProveedor());
            $stmt->bindValue(':email', $this->getEmailProveedor());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos de usuario
                return['status' => true, 'msj' => 'Proveedor Registrado con exito.'];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Error al registrar proveedor.'];
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
    private function Obtener_Proveedor() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // actualiza el status la categoria
            $query = "SELECT *
                        FROM proveedores
                        WHERE id_proveedor = :id AND status = 1";

            // prepar la sentencia 
            $stmt = $conn->prepare($query); 

            // vincula los parametros
            $stmt->bindValue(":id", $this->getProveedorID());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                // obtiene los datos de la consulta
                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Proveedor encontrado con exito.', 'data' => $data, 'data_bitacora' => $data];
            }
            else {

                // retiorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Proveedor no encontrado error.'];
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
    private function Actualizar_Proveedor() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // Obtener datos actuales antes de eliminar (para bitacora)
            $query_select = "SELECT * FROM proveedores 
                                    WHERE id_proveedor = :id 
                                    AND status = 1";

            // oeroara la sentencia
            $stmt_select = $conn->prepare($query_select);

            // vincula los parametros
            $stmt_select->bindValue(':id', $this->getProveedorID());

            // ejecuta la sentencia
            $stmt_select->execute();

            // se almacena arry asocc en la var
            $datos_anteriores = $stmt_select->fetch(PDO::FETCH_ASSOC);

            // inserta una categoria
            $query = "UPDATE proveedores
                        SET id_proveedor = :id,
                        tipo_id = :tipo_id,
                        nombre_proveedor = :nombre, 
                        direccion_proveedor = :direccion, 
                        tlf_proveedor = :telefono, 
                        email_proveedor = :email
                        WHERE id_proveedor = :id ";

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(':id', $this->getProveedorID());
            $stmt->bindValue(':tipo_id', $this->getTipoIDProveedor());
            $stmt->bindValue(':nombre', $this->getNombreProveedor());
            $stmt->bindValue(':direccion', $this->getDireccionProveedor());
            $stmt->bindValue(':telefono', $this->getTlfProveedor());
            $stmt->bindValue(':email', $this->getEmailProveedor());

            // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos de usuario
                return['status' => true, 'msj' => 'Proveedor Actualizado con exito.', 'data_bitacora' => $datos_anteriores];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Error al actualizar proveedor.'];
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
    private function Eliminar_Proveedor() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // Obtener datos actuales antes de eliminar (para bitacora)
            $query_select = "SELECT * FROM proveedores
                                    WHERE id_proveedor = :id 
                                    AND status = 1";

            // oeroara la sentencia
            $stmt_select = $conn->prepare($query_select);

            // vincula los parametros
            $stmt_select->bindValue(':id', $this->getProveedorID());

            // ejecuta la sentencia
            $stmt_select->execute();

            // se almacena arry asocc en la var
            $datos_anteriores = $stmt_select->fetch(PDO::FETCH_ASSOC);

            // actualiza el status la categoria
            $query = "UPDATE proveedores
                        SET status = 0
                        WHERE id_proveedor = :id";

            // prepar la sentencia 
            $stmt = $conn->prepare($query); 

            // vincula los parametros
            $stmt->bindValue(":id", $this->getProveedorID());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Proveedor Eliminado con exito.', 'data_bitacora' => $datos_anteriores];
            }
            else {

                // retiorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Proveedor no eliminado error.'];
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