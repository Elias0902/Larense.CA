<?php
// llama al modelo conexion
require_once "ConexionModel.php";

// se difine la clase
class Notificacion extends Conexion {

    // Atributos
    private $notificacion_id;
    private $notificacion_id_usuario;
    private $notificacion_descripcion;
    private $notificacion_enlace;
    private $notificacion_fecha;

    // construcor
    public function __construct() {
        parent::__construct();
    }

    // SETTERS
    // setters para notificacion completa
    private function setNotificacionData($notificacion_json) {

        // valida si el json es string y lo descompone
        if (is_string($notificacion_json)) {

            // se almacena el contenido del json en la variable notificacion
            $notificacion = json_decode($notificacion_json, true);
            
            // valida que el json cumpla con el formato requerido
            if ($notificacion === null) {

                // retorna un arry con el mensaje y el status
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        // expreciones regulares y validaciones
        $expre_id = '/^(0|[1-9][0-9]*)$/'; // para el id
        $expre_descripcion = '/^[a-zA-Z0-9\s.,;:áéíóúÁÉÍÓÚñÑ\-_]+$/'; // para la descripcion
        $expre_enlace = '/^[a-zA-Z0-9\s.,;:\/\?=&\-_#]+$/'; // para el enlace

        // almacena el id en la variable para despues validar
        $id = trim($notificacion['id'] ?? '');
        // valida el id si cumple con los requisitos
        if ($id === '' || !preg_match($expre_id, $id) || strlen($id) > 10 || $id < 0) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'El id de la notificacion es invalido'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->notificacion_id = $id;

        // almacena el id_usuario en la variable para despues validar
        $id_usuario = trim($notificacion['id_usuario'] ?? '');
        // valida el id_usuario si cumple con los requisitos
        if ($id_usuario === '' || !preg_match($expre_id, $id_usuario) || strlen($id_usuario) > 10 || $id_usuario < 0) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'El id del usuario es invalido'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->notificacion_id_usuario = $id_usuario;

        // almacena la descripcion en la variable para despues validar
        $descripcion = trim($notificacion['descripcion'] ?? '');
        // valida la descripcion si cumple con los requisitos
        if ($descripcion === '' || !preg_match($expre_descripcion, $descripcion) || strlen($descripcion) > 100 || strlen($descripcion) < 5) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'La descripcion de la notificacion es invalida debe tener minimo 5 y maximo 100 caracteres.'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->notificacion_descripcion = $descripcion;

        // almacena el enlace en la variable para despues validar
        $enlace = trim($notificacion['enlace'] ?? '');
        // valida el enlace si cumple con los requisitos (opcional)
        if ($enlace !== '' && (!preg_match($expre_enlace, $enlace) || strlen($enlace) > 100)) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'El enlace de la notificacion es invalido debe tener maximo 100 caracteres.'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->notificacion_enlace = $enlace;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

    // setters para agregar notificacion
    private function setNotificacionAgregar($notificacion_json) {

        // valida si el json es string y lo descompone
        if (is_string($notificacion_json)) {

            // se almacena el contenido del json en la variable notificacion
            $notificacion = json_decode($notificacion_json, true);
            
            // valida que el json cumpla con el formato requerido
            if ($notificacion === null) {

                // retorna un arry con el mensaje y el status
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        // expreciones regulares y validaciones
        $expre_id = '/^(0|[1-9][0-9]*)$/'; // para el id
        $expre_descripcion = '/^[a-zA-Z0-9\s.,;:áéíóúÁÉÍÓÚñÑ\-_]+$/'; // para la descripcion
        $expre_enlace = '/^[a-zA-Z0-9\s.,;:\/\?=&\-_#]+$/'; // para el enlace

        // almacena el id_usuario en la variable para despues validar
        $id_usuario = trim($notificacion['id_usuario'] ?? '');
        // valida el id_usuario si cumple con los requisitos
        if ($id_usuario === '' || !preg_match($expre_id, $id_usuario) || strlen($id_usuario) > 10 || $id_usuario < 0) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'El id del usuario es invalido'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->notificacion_id_usuario = $id_usuario;

        // almacena la descripcion en la variable para despues validar
        $descripcion = trim($notificacion['descripcion'] ?? '');
        // valida la descripcion si cumple con los requisitos
        if ($descripcion === '' || !preg_match($expre_descripcion, $descripcion) || strlen($descripcion) > 100 || strlen($descripcion) < 5) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'La descripcion de la notificacion es invalida debe tener minimo 5 y maximo 100 caracteres.'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->notificacion_descripcion = $descripcion;

        // almacena el enlace en la variable para despues validar
        $enlace = trim($notificacion['enlace'] ?? '');
        // valida el enlace si cumple con los requisitos (opcional)
        if ($enlace !== '' && (!preg_match($expre_enlace, $enlace) || strlen($enlace) > 100)) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'El enlace de la notificacion es invalido debe tener maximo 100 caracteres.'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->notificacion_enlace = $enlace;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

    // setters para el id de la notificacion
    private function setNotificacionID($notificacion_json) {

        // valida si el json es string y lo descompone
        if (is_string($notificacion_json)) {

            // se almacena el contenido del json en la variable notificacion
            $notificacion = json_decode($notificacion_json, true);
            
            // valida que el json cumpla con el formato requerido
            if ($notificacion === null) {

                // retorna un arry con el mensaje y el status
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        // expreciones regulares y validaciones
        $expre_id = '/^(0|[1-9][0-9]*)$/'; // para el id

        // almacena el id en la variable para despues validar
        $id = trim($notificacion['id'] ?? '');
        // valida el id si cumple con los requisitos
        if ($id === '' || !preg_match($expre_id, $id) || strlen($id) > 10 || $id < 0) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'El id de la notificacion es invalido'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->notificacion_id = $id;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

    // setters para el id de usuario (para consultar por usuario)
    private function setNotificacionIDUsuario($notificacion_json) {

        // valida si el json es string y lo descompone
        if (is_string($notificacion_json)) {

            // se almacena el contenido del json en la variable notificacion
            $notificacion = json_decode($notificacion_json, true);
            
            // valida que el json cumpla con el formato requerido
            if ($notificacion === null) {

                // retorna un arry con el mensaje y el status
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        // expreciones regulares y validaciones
        $expre_id = '/^(0|[1-9][0-9]*)$/'; // para el id

        // almacena el usuario_id en la variable para despues validar
        $usuario_id = trim($notificacion['usuario_id'] ?? '');
        // valida el usuario_id si cumple con los requisitos
        if ($usuario_id === '' || !preg_match($expre_id, $usuario_id) || strlen($usuario_id) > 10 || $usuario_id < 0) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'El id del usuario es invalido'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->notificacion_id_usuario = $usuario_id;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

    // GETTERS
    //getters para el id
    private function getNotificacionID() {
        
        // retorna el id a utilizar
        return $this->notificacion_id;
    }

    // getters para el id_usuario
    private function getNotificacionIdUsuario() {

        // retorna el id_usuario a utilizar
        return $this->notificacion_id_usuario;
    }

    // getters para la descripcion
    private function getNotificacionDescripcion() {

        // retorna la descripcion a utilizar
        return $this->notificacion_descripcion;
    }

    // getters para el enlace
    private function getNotificacionEnlace() {

        // retorna el enlace a utilizar
        return $this->notificacion_enlace;
    }

    // Esta se encarga de procesar los action indiferentemente cual sea llama la funcion de 
    // validacio y luego al metodo correspondiente al action
    // donde primero recibe el action como primer parametro que son los de agregar etc.. 
    // y el objeto json como segundo parametro para las validaciones y asiganciones al objeto 
    public function manejarAccion($action, $notificacion_json ){

        // maneja el action y carga la funcion correspondiente a la action
        switch($action){

            case 'agregar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setNotificacionAgregar($notificacion_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Guardar_Notificacion();

            // termina el script    
            break;

            case 'obtener':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setNotificacionID($notificacion_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Obtener_Notificacion();

            // termina el script    
            break;

            case 'modificar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setNotificacionData($notificacion_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Actualizar_Notificacion();

            // termina el script    
            break;

            case 'eliminar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setNotificacionID($notificacion_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Eliminar_Notificacion();

            // termina el script    
            break;

            case 'consultar':

                // llama la funcion y retorna los datos
                return $this->Mostrar_Notificacion();

            // termina el script
            break;

            case 'consultar_por_usuario':

                // valida y asigna el usuario_id
                $validacion = $this->setNotificacionIDUsuario($notificacion_json);
                if (!$validacion['status']) {
                    return $validacion;
                }

                // llama la funcion y retorna los datos
                return $this->Mostrar_NotificacionPorUsuario();

            // termina el script
            break;

            case 'marcar_vista':

                // valida y asigna el id
                $validacion = $this->setNotificacionID($notificacion_json);
                if (!$validacion['status']) {
                    return $validacion;
                }

                // llama la funcion y retorna los datos
                return $this->MarcarComoVista();

            // termina el script
            break;

            default:

                // retorna un mensaje de error en caso de no existir la accion
                return['status' => false, 'msj' => 'Accion Invalida.'];

            // termina el script
            break;
        }
    }

    // funcion para consultar notificaciones
    private function Mostrar_Notificacion() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionSeguridad();

            // consulta las notificaciones con join a usuarios
            $query = "SELECT n.*, u.nombre_usuario 
                        FROM notificaciones n
                        INNER JOIN usuarios u ON n.id_usuario = u.id_usuario
                        WHERE n.status = 1"; //valida el estado si esta activo

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // ejecuta la sentencia
            $stmt->execute(); 

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->rowCount() > 0) {

                // almacena los datos extraidos de la base de datos 
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Notificaciones encontradas con exito.', 'data' => $data];
            }
            else {

                // reti=rona un status de error con un mensaje 
                return['status' => false, 'msj' => 'Notificaciones no encontradas o inactivas'];
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

    // funcion para consultar notificaciones por usuario (para el header)
    private function Mostrar_NotificacionPorUsuario() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionSeguridad();

            // consulta las notificaciones del usuario actual (incluyendo vistas y no vistas)
            $query = "SELECT n.*, u.nombre_usuario 
                        FROM notificaciones n
                        INNER JOIN usuarios u ON n.id_usuario = u.id_usuario
                        WHERE n.id_usuario = :usuario_id AND n.status = 1
                        ORDER BY n.fecha_notificacion DESC
                        LIMIT 10"; //valida el estado si esta activo

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(':usuario_id', $this->getNotificacionIdUsuario());

            // ejecuta la sentencia
            $stmt->execute(); 

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->rowCount() > 0) {

                // almacena los datos extraidos de la base de datos 
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Notificaciones encontradas con exito.', 'data' => $data];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Notificaciones no encontradas o inactivas', 'data' => []];
            }

        } catch (PDOException $e) {
            
            // retorna mensaje de error del exception del pdo
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage(), 'data' => []];
        }
        finally {

            // finaliza la fincion cerrando la conexion a la bd
            $this->closeConnection();
        }
    }

    // funcion para marcar notificacion como vista
    private function MarcarComoVista() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionSeguridad();

            // actualiza la notificacion como vista
            $query = "UPDATE notificaciones
                        SET vista = 1
                        WHERE id_notificaciones = :id";

            // prepar la sentencia 
            $stmt = $conn->prepare($query); 

            // vincula los parametros
            $stmt->bindValue(":id", $this->getNotificacionID());

            // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Notificacion marcada como vista con exito.'];
            }
            else {

                // reti=rona un status de error con un mensaje 
                return['status' => false, 'msj' => 'Notificacion no marcada como vista error.'];
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

    // funcion para registrar notificacion
    private function Guardar_Notificacion() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionSeguridad();

            // inserta una notificacion
            $query = "INSERT INTO notificaciones (id_usuario, descripcion_notificacion, enlace, fecha_notificacion) 
                                            VALUES (:id_usuario, :descripcion, :enlace, NOW())";

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(':id_usuario', $this->getNotificacionIdUsuario());
            $stmt->bindValue(':descripcion', $this->getNotificacionDescripcion());
            $stmt->bindValue(':enlace', $this->getNotificacionEnlace());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos de usuario
                return['status' => true, 'msj' => 'Notificacion Registrada con exito.'];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Error al registrar notificacion.'];
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
    private function Obtener_Notificacion() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionSeguridad();

            // consulta la notificacion
            $query = "SELECT n.*, u.nombre_usuario 
                        FROM notificaciones n
                        INNER JOIN usuarios u ON n.id_usuario = u.id_usuario
                        WHERE n.id_notificaciones = :id AND n.status = 1";

            // prepar la sentencia 
            $stmt = $conn->prepare($query); 

            // vincula los parametros
            $stmt->bindValue(":id", $this->getNotificacionID());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                // obtiene los datos de la consulta
                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Notificacion encontrada con exito.', 'data' => $data];
            }
            else {

                // retiorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Notificacion no encontrada error.'];
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

    // funcion para modificar notificacion
    private function Actualizar_Notificacion() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionSeguridad();

            // actualiza una notificacion
            $query = "UPDATE notificaciones 
                        SET id_usuario = :id_usuario, 
                            descripcion_notificacion = :descripcion, 
                            enlace = :enlace 
                        WHERE id_notificaciones = :id";

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(':id', $this->getNotificacionID());
            $stmt->bindValue(':id_usuario', $this->getNotificacionIdUsuario());
            $stmt->bindValue(':descripcion', $this->getNotificacionDescripcion());
            $stmt->bindValue(':enlace', $this->getNotificacionEnlace());
             
            // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos de usuario
                return['status' => true, 'msj' => 'Notificacion Actualizada con exito.'];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Error al actualizar notificacion.'];
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
    private function Eliminar_Notificacion() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionSeguridad();

            // actualiza el status la notificacion
            $query = "UPDATE notificaciones
                        SET status = 0
                        WHERE id_notificaciones = :id";

            // prepar la sentencia 
            $stmt = $conn->prepare($query); 

            // vincula los parametros
            $stmt->bindValue(":id", $this->getNotificacionID());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Notificacion Eliminada con exito.'];
            }
            else {

                // retiorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Notificacion no eliminada error.'];
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
