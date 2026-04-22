<?php

// llama al modelo conexion
require_once "ConexionModel.php";

class Usuario extends Conexion {

    // atributos
    private $id_usuario;
    private $nombre_usuario;
    private $email_usuario;
    private $password_usuario;
    private $id_rol_usuario;
    private $status;

    // constructor
    public function __construct() {
        parent::__construct();
    }

     // metodo que me valida y asigna los datos del objeto recibido para la funcion registrar
    private function setUsuarioUpdateData($usuario_json) {

        // valida si el json es string y lo descompone
        if (is_string($usuario_json)) {

            // se almacena el contenido del json en la variable usuario
            $usuario = json_decode($usuario_json, true);
            
            // valida que el json cumpla con el formato requerido
            if ($usuario === null) {

                // retorna un arry con el mensaje y el status
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        // expreciones regulares y validaciones
        $expre_username = '/^[a-zA-Z0-9@_]+$/'; //para el usernmae
        $expre_email = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'; // para el email
        $expre_password = '/^(?=.*[A-Z])(?=.*\.)[a-zA-Z0-9.]{6,}$/'; // para el password
        $expre_numeric = '/^\d+$/'; // para los numeros

        // almacena el id en la variable para despues validar
        $id = trim($usuario['id'] ?? '');
        // valida el rol si cumple con todos los requisitos
        if ($id === '' || !preg_match($expre_numeric, $id)) {
            //retorna un arry de status con el mensaje en caso de error 
            return['status' => false, 'msj' => 'El id es invalido intentenlo de nuevo.'];
        }

        // asigna el valor en el atributo del objeto si todo salio bien
        $this->id_usuario = $id;

        // almacena el username en la variable para despues validar
        $username = trim($usuario['nombre'] ?? '');
        // valida el username si cumple con los requisitos
        if ($username === '' || !preg_match($expre_username, $username) || strlen($username) > 20 || strlen($username) < 5) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'EL nombre de usuario es invalido debe tener minimo 5 y maximo 20 caracteres y debe tener un @ y/o un _  ej:@usuario_123 .'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->nombre_usuario = $username;

        // almacena el email en la variable para despues validar
        $email = trim($usuario['email'] ?? '');
        // valida el email si cumple con los requisitos
        if ($email === '' || !preg_match($expre_email, $email) || strlen($email) > 60 || strlen($email) < 7) {
            //retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'El email es invalido debe tener minimo 7 y maximo 60 caracteres y debe tener un @ y un .com  ej: example@email.com .'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->email_usuario = $email;

        // almacena la password en la variable para despues validar
        $password = trim($usuario['password'] ?? '');
        // valida la password si cumple con todos los requisitos
        if ($password === '' || !preg_match($expre_password, $password) || strlen($password) > 11 || strlen($password) < 6) {
            //retorna un arry de status con el mensaje en caso de error
            return['status' => false, 'msj' => 'La password es invalida debe tener minimo 6 y maximo 11 caracteres y debe tener un caracter mayuscula y un .  ej: Example12. .'];
        }

        // encripta la password una ves validada
        $password_hash = password_hash($password, PASSWORD_DEFAULT); 

        // asigna el valor al atributo del objeto si todo salio bien
        $this->password_usuario = $password_hash;

        // almacena el rol en la variable para despues validar
        $rol = trim($usuario['rol'] ?? '');
        // valida el rol si cumple con todos los requisitos
        if ($rol === '' && !preg_match($expre_numeric, $rol)) {
            //retorna un arry de status con el mensaje en caso de error 
            return['status' => true, 'msj' => 'El rol es invalido intentenlo de nuevo.'];
        }

        // asigna el valor en el atributo del objeto si todo salio bien
        $this->id_rol_usuario = $rol;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

    private function setUsuarioData($usuario_json) {

        // valida si el json es string y lo descompone
        if (is_string($usuario_json)) {

            // se almacena el contenido del json en la variable usuario
            $usuario = json_decode($usuario_json, true);
            
            // valida que el json cumpla con el formato requerido
            if ($usuario === null) {

                // retorna un arry con el mensaje y el status
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        // expreciones regulares y validaciones
        $expre_username = '/^[a-zA-Z0-9@_]+$/'; //para el usernmae
        $expre_email = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'; // para el email
        $expre_password = '/^(?=.*[A-Z])(?=.*\.)[a-zA-Z0-9.]{6,}$/'; // para el password
        $expre_numeric = '/^\d+$/'; // para los numeros

        // almacena el username en la variable para despues validar
        $username = trim($usuario['nombre'] ?? '');
        // valida el username si cumple con los requisitos
        if ($username === '' || !preg_match($expre_username, $username) || strlen($username) > 20 || strlen($username) < 5) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'EL nombre de usuario es invalido debe tener minimo 5 y maximo 20 caracteres y debe tener un @ y/o un _  ej:@usuario_123 .'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->nombre_usuario = $username;

        // almacena el email en la variable para despues validar
        $email = trim($usuario['email'] ?? '');
        // valida el email si cumple con los requisitos
        if ($email === '' || !preg_match($expre_email, $email) || strlen($email) > 60 || strlen($email) < 7) {
            //retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'El email es invalido debe tener minimo 7 y maximo 60 caracteres y debe tener un @ y un .com  ej: example@email.com .'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->email_usuario = $email;

        // almacena la password en la variable para despues validar
        $password = trim($usuario['password'] ?? '');
        // valida la password si cumple con todos los requisitos
        if ($password === '' || !preg_match($expre_password, $password) || strlen($password) > 11 || strlen($password) < 6) {
            //retorna un arry de status con el mensaje en caso de error
            return['status' => false, 'msj' => 'La password es invalida debe tener minimo 6 y maximo 11 caracteres y debe tener un caracter mayuscula y un .  ej: Example12. .'];
        }

        // encripta la password una ves validada
        $password_hash = password_hash($password, PASSWORD_DEFAULT); 

        // asigna el valor al atributo del objeto si todo salio bien
        $this->password_usuario = $password_hash;

        // almacena el rol en la variable para despues validar
        $rol = trim($usuario['rol'] ?? '');
        // valida el rol si cumple con todos los requisitos
        if ($rol === '' && !preg_match($expre_numeric, $rol)) {
            //retorna un arry de status con el mensaje en caso de error 
            return['status' => true, 'msj' => 'El rol es invalido intentenlo de nuevo.'];
        }

        // asigna el valor en el atributo del objeto si todo salio bien
        $this->id_rol_usuario = $rol;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

    // metodo que me valida y asigna los datos del objeto recibido para la funcion obtener
    private function setUsuarioID($usuario_json) {

         // valida si el json es string y lo descompone
        if (is_string($usuario_json)) {

            // se almacena el contenido del json en la variable usuario
            $usuario = json_decode($usuario_json, true);
            
            // valida que el json cumpla con el formato requerido
            if ($usuario === null) {

                // retorna un arry con el mensaje y el status
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        $expre_numeric = '/^\d+$/'; // para los numeros

        // almacena el id en la variable para despues validar
        $id = trim($usuario['id'] ?? '');
        // valida el rol si cumple con todos los requisitos
        if ($id === '' || !preg_match($expre_numeric, $id)) {
            //retorna un arry de status con el mensaje en caso de error 
            return['status' => false, 'msj' => 'El id es invalido intentenlo de nuevo.'];
        }

        // asigna el valor en el atributo del objeto si todo salio bien
        $this->id_usuario = $id;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

        // GETTERS

    // para el id
    private function getID() {

        // retorna el id
        return $this->id_usuario;
    }

    // para el username
    private function getNombre() {

        // retorna el username
        return $this->nombre_usuario;
    }

    // para el email
    private function getEmail() {

        // retorna el email
        return $this->email_usuario;
    }

    // para el password
    private function getPassword() {

        //retorna el password
        return $this->password_usuario;
    }

    // para el rol
    private function getRol() {

        //retorna el rol
        return $this->id_rol_usuario;
    }

    // Esta se encarga de procesar los action indiferentemente cual sea llama la funcion de 
    // validacio y luego al metodo correspondiente al action
    // donde primero recibe el action como primer parametro que son los de agregar etc.. 
    // y el objeto json como segundo parametro para las validaciones y asiganciones al objeto 
    public function manejarAccion($action, $usuario_json ){

        // maneja el action y carga la funcion correspondiente a la action
        switch($action){

            case 'agregar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setUsuarioData($usuario_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Guardar_Usuario();

            // termina el script    
            break;

            case 'obtener':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setUsuarioID($usuario_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Obtener_Usuario();

            // termina el script    
            break;

            case 'modificar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setUsuarioUpdateData($usuario_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Actualizar_Usuario();

            // termina el script    
            break;

            case 'eliminar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setUsuarioID($usuario_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Eliminar_Usuario();

            // termina el script    
            break;

            case 'consultar':

                // llama la funcion y retorna los datos
                return $this->Mostrar_Usuario();

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
    private function Mostrar_Usuario() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionSeguridad();

            // consulta las categorias
            $query = "SELECT u.*, r.nombre_rol
                        FROM usuarios u
                        INNER JOIN roles r ON r.id_rol = u.id_rol_usuario
                        WHERE u.status = 1"; //valida el estado si esta activo

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // ejecuta la sentencia
            $stmt->execute(); 

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->rowCount() > 0) {

                // almacena los datos extraidos de la base de datos 
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Usuarios encontrados con exito.', 'data' => $data];
            }
            else {

                // reti=rona un status de error con un mensaje 
                return['status' => false, 'msj' => 'Usuarios no encontrados o inactivas'];
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
    private function Guardar_Usuario() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionSeguridad();

            // ruta img default
            $img = 'assets/img/perfiles/profile.jpg';

            // inserta una categoria
            $query = "INSERT INTO usuarios (nombre_usuario, password_usuario, email_usuario, id_rol_usuario, img_usuario)
                                            VALUES (:nombre, :pw, :email, :rol, :img )";

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(':nombre', $this->getNombre());
            $stmt->bindValue(':pw', $this->getPassword());
            $stmt->bindValue(':email', $this->getEmail());
            $stmt->bindValue(':rol', $this->getRol());
            $stmt->bindValue(':img', $img);

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {
                
                // Obtener el ID del registro creado
                $id_creado = $conn->lastInsertId();

                //retorna el status con el mensaje y los datos de usuario
                return['status' => true, 'msj' => 'Usuario Registrado con exito.'];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Error al registar usuario.'];
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
    private function Obtener_Usuario() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionSeguridad();

            // actualiza el status la categoria
            $query = "SELECT *
                        FROM usuarios
                        WHERE id_usuario = :id AND status = 1";

            // prepar la sentencia 
            $stmt = $conn->prepare($query); 

            // vincula los parametros
            $stmt->bindValue(":id", $this->getID());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                // obtiene los datos de la consulta
                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Usuario encontrado con exito.', 'data' => $data, 'data_bitacora' => $data];
            }
            else {

                // retiorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Usuario no encontrado error.'];
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
    private function Actualizar_Usuario() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionSeguridad();
            
            // Obtener datos actuales antes de actualizar (para bitacora)
            $query_select = "SELECT * FROM usuarios 
                                    WHERE id_usuario = :id 
                                    AND status = 1";

            // prepara la consulta
            $stmt_select = $conn->prepare($query_select);

            // vincula los parametros
            $stmt_select->bindValue(':id', $this->getID());
            
            // ejecuta la sentencia
            $stmt_select->execute();

            // el arry assoc se almacena en la var
            $datos_anteriores = $stmt_select->fetch(PDO::FETCH_ASSOC);

            // modificar una categoria
            $query = "UPDATE usuarios 
                        SET nombre_usuario = :nombre, 
                            email_usuario = :email,
                            id_rol_usuario = :rol,
                            password_usuario = :pw 
                        WHERE id_usuario = :id ";

            // prepara la sentencia 
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(':id', $this->getID());
            $stmt->bindValue(':nombre', $this->getNombre());
            $stmt->bindValue(':email', $this->getEmail());
            $stmt->bindValue(':rol', $this->getRol());
            $stmt->bindValue(':pw', $this->getPassword());
             
            // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos de usuario
                return['status' => true, 'msj' => 'Usuario Actualizado con exito.', 'data_bitacora' => $datos_anteriores];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Error al actualizar usuario.'];
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
    private function Eliminar_Usuario() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionSeguridad();
            
            // Obtener datos actuales antes de eliminar (para bitacora)
            $query_select = "SELECT * FROM usuarios 
                                    WHERE id_usuario = :id 
                                    AND status = 1";

            // oeroara la sentencia
            $stmt_select = $conn->prepare($query_select);

            // vincula los parametros
            $stmt_select->bindValue(':id', $this->getID());

            // ejecuta la sentencia
            $stmt_select->execute();

            // se almacena arry asocc en la var
            $datos_anteriores = $stmt_select->fetch(PDO::FETCH_ASSOC);

            // actualiza el status la categoria
            $query = "UPDATE usuarios
                        SET status = 0
                        WHERE id_usuario = :id";

            // prepar la sentencia 
            $stmt = $conn->prepare($query); 

            // vincula los parametros
            $stmt->bindValue(":id", $this->getID());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Usuario Eliminado con exito.', 'data_bitacora' => $datos_anteriores];
            }
            else {

                // retiorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Usuario no eliminado error.'];
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
