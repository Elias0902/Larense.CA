<?php

// llama al modelo
require_once 'app/models/UsuarioModel.php';
require_once 'app/models/RolModel.php';
require_once 'app/models/PermisoModel.php';
require_once 'app/models/BitacoraModel.php';

// llama el archivo que contiene la carga de alerta
require_once 'components/utils.php';

// zona horaria
date_default_timezone_set('America/Caracas');

// se almacena la action o la peticion http
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {

    case 'obtener':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            Obtener();
        }
        break;

    case 'agregar':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Agregar();
        }
        break;

    case 'modificar':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Actualizar();
        }
        break;

    case 'eliminar':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            Eliminar();
        }
        break;

    default:
        consultar();
        break;
}

// funcion para listar todos los usuarios
function Consultar() {
       
        // instacia el modelo
        $modelo = new Usuario();
        $rol = new Rol();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');


        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Usuarios',
            'permiso' => 'Consultar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);


        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] === true) {
            
            // Ejecutar acción permitida

            // para manejo de errores
            try {

                // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                // primer para metro la accion y luego el objeto usuario_json
                $resultado = $modelo->manejarAccion('consultar', null);

                // valida si exixtes el staus del resultado y si es true 
                if (isset($resultado['status']) && $resultado['status'] === true) {

                    // usa mensaje dinamico del modelo
                    //setSuccess($resultado['msj']);

                    // extrae los datos
                    $usuarios = $resultado['data'];
                    
                    $roles = $rol->manejarAccion('consultar', null)['data'];

                    // se arma el json de bitacora
                        $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Usuarios',
                        'accion' => 'Consultar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha Consultado los datos en el dashboard de usuarios en el sistema',
                            'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                    //carga la vista
                    require_once 'app/views/usuariosView.php';

                    // termina el script
                    exit();
                }
                else {
                                
                    // usa mensaje dinamico del modelo
                    setError($resultado['msj']);

                    //carga la vista
                    require_once 'app/views/usuariosView.php';

                    // termina el script
                    exit();
                }
            }
            catch (Exception $e) {

                //mensaje del exception de pdo
                error_log('Error al registrar...' . $e->getMessage());
                
                // carga la alerta
                setError('Error en operacion.');

                //termina el script
                exit();
            }
        }
    header("Location: index.php?url=403");
    exit();
    
}

//funcion para guardar datos
    function Agregar() {

        // instacia el modelo
        $modelo = new Usuario();
        $bitacora = new Bitacora();
        $permiso = new Permiso();
        
        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Usuarios',
            'permiso' => 'Agregar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] === true) {
            
            // Ejecutar acción permitida

            // obtiene y sinatiza los valores
            $nombre_usuario = filter_var($_POST['nombre_usuario'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $password_usuario = filter_var($_POST['password'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $rol_usuario = filter_var($_POST['id_rol'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $email_usuario = filter_var($_POST['email_usuario'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

            // valida si los campos no estan vacios
            if (empty($nombre_usuario) || empty($password_usuario) ||empty($email_usuario) || empty($rol_usuario)) {

                // manda mensaje de error
                setError('Todos los campos son requeridos no se puede enviar vacios.');

                //redirec
                header('Location: index.php?url=usuarios');

                //termina el script
                exit();
            }

            // se arma el josn
            $usuario_json = json_encode([
                'nombre' => $nombre_usuario,
                'password' => $password_usuario,
                'email' => $email_usuario,
                'rol' => $rol_usuario
            ]);
            //print_r($usuario_json);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('agregar', $usuario_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);

                        // se arma el json de bitacora
                        $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Usuarios',
                        'accion' => 'Agregar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                        'ha ragistras el siguiente usuario' . ' ' . 
                        $nombre_usuario . ' ' . $email_usuario . ' ' . 'en el sistema.',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);
                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=usuarios');

                    }
                }
                catch (Exception $e) {

                    //mensaje del exception de pdo
                    error_log('Error al registrar...' . $e->getMessage());
                    
                    // carga la alerta
                    setError('Error en operacion.');
                }

            //redirect
            header('Location: index.php?url=usuarios');
            
            // termina el script
            exit();
        }

    header("Location: index.php?url=403");
    exit();
            
    // termina el script
    exit();
        
}

//funcion para modificar datos
    function Actualizar() {

         // instacia el modelo
        $modelo = new Usuario();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Usuarios',
            'permiso' => 'Modificar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] === true) {
            
            // Ejecutar acción permitida*/

            // obtiene y sinatiza los valores
            $id = $_POST['id_usuarioEdit'];
            $nombre_usuario = filter_var($_POST['nombre_usuarioEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $password_usuario = filter_var($_POST['passwordEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $rol_usuario = filter_var($_POST['id_rolEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $email_usuario = filter_var($_POST['email_usuarioEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

            // valida si los campos no estan vacios
            if (empty($nombre_usuario) || empty($password_usuario) ||empty($email_usuario) || empty($rol_usuario)) {

                // manda mensaje de error
                setError('Todos los campos son requeridos no se puede enviar vacios.');

                //redirec
                header('Location: index.php?url=usuarios');

                //termina el script
                exit();
            }

            // se arma el josn
            $usuario_json = json_encode([
                'id' => $id,
                'nombre' => $nombre_usuario,
                'password' => $password_usuario,
                'email' => $email_usuario,
                'rol' => $rol_usuario
            ]);
            //print_r($usuario_json);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('modificar', $usuario_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);

                        //datos para la bitacora
                        $data_bitacora = $resultado['data_bitacora'];

                        // se arma el json de bitacora
                        $bitacora_json = json_encode([
                            'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                            'modulo' => 'Usuarios',
                            'accion' => 'Modificar',
                            'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                                                'ha modificado los datos del siguinte usuario' . ' ' . 'US-00' . 
                                                $data_bitacora['id_usuario'] . ' ' . $data_bitacora['nombre_usuario'] . ' ' . $data_bitacora['email_usuario'] . 
                                                ' ' . 'por los siguientes datos' . ' ' . 'US-00' . $id . ' ' . $nombre_usuario . ' ' . $email_usuario . 
                                                ' ' . 'en el sistema.',
                            'fecha' => $fecha
                        ]);

                        //realiza la insercion de la bitacora
                        $bitacora->manejarAccion('agregar', $bitacora_json);

                        //redirect
                        header('Location: index.php?url=usuarios');
                        
                        // termina el script
                        exit();
                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=usuarios');

                        // termina el script
                        exit();

                    }
                }
                catch (Exception $e) {

                    //mensaje del exception de pdo
                    error_log('Error al registrar...' . $e->getMessage());
                    
                    // carga la alerta
                    setError('Error en operacion.');

                    // termina el script
                    exit();
                }

            //redirect
            header('Location: index.php?url=usuarios');
            
            // termina el script
            exit();
        }

    header("Location: index.php?url=403");
    exit();
            
    // termina el script
    exit();

    }

    // function para obtener un dato
    function Obtener() {

        // instacia el modelo
        $modelo = new Usuario();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        $id = $_GET['ID'];

         // valida si los campos no estan vacios
        if (empty($id)) {

            // manda mensaje de error
            setError('Todos los campos son requeridos no se puede enviar vacios.');

            //redirec
            header('Location: index.php?url=usuarios');

            //termina el script
            exit();
        }

            // se arma el josn
            $usuario_json = json_encode([
                'id' => $id
            ]);

            $resultado = $modelo->manejarAccion('obtener', $usuario_json);

            // se almacena para la vista
            $usuario = $resultado['data'];

            // se almacena para la bitacora
            $data_bitacora = $resultado['data_bitacora'];

            // se arma el json de bitacora
            $bitacora_json = json_encode([
                'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                'modulo' => 'CUsuario',
                'accion' => 'Obtener',
                'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                    'ha obtenido los datos del usuario' . ' ' . 'US-00' . 
                    $data_bitacora['id_usuario'] . ' ' . $data_bitacora['nombre_usuario'] . ' ' . 
                    $data_bitacora['email_usuario'] . ' ' . 'en el sistema.',
                'fecha' => $fecha
            ]);

            //realiza la insercion de la bitacora
            $bitacora->manejarAccion('agregar', $bitacora_json);

            echo json_encode($usuario);

            exit();
    }

    // funcion para eliminar un dato
    function Eliminar() {

         // instacia el modelo
        $modelo = new Usuario();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');


        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Usuarios',
            'permiso' => 'Eliminar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] == 1) {
            
            // Ejecutar acción permitida*/

            // obtiene y sinatiza los valores
            $id_usuario = $_GET['ID'];

            // valida si los campos no estan vacios
            if (empty($id_usuario)) {

                // manda mensaje de error
                setError('ID vacio.');

                //redirec
                header('Location: index.php?url=usuarios');

                //termina el script
                exit();
            }

            // se arma el josn
            $usuario_json = json_encode([
                'id' => $id_usuario
            ]);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('eliminar', $usuario_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);

                        //datos para bitacoras
                        $data_bitacora = $resultado['data_bitacora'];

                        // se arma el json de bitacora
                        $bitacora_json = json_encode([
                            'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                            'modulo' => 'Usuarios',
                            'accion' => 'Eliminar',
                            'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 'ha eliminado un usuario' . ' ' . 'US-00' . $data_bitacora['id_usuario'] . ' ' . $data_bitacora['nombre_usuario'] . ' ' . 'en el sistema.',
                            'fecha' => $fecha
                        ]);

                        //realiza la insercion de la bitacora
                        $bitacora->manejarAccion('agregar', $bitacora_json);
                        
                        //redirect
                        header('Location: index.php?url=usuarios');
                        
                        // termina el script
                        exit();
                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=usuario');

                        // termina el script
                        exit();

                    }
                }
                catch (Exception $e) {

                    //mensaje del exception de pdo
                    error_log('Error al registrar...' . $e->getMessage());
                    
                    // carga la alerta
                    setError('Error en operacion.');
                }

        //redirect
        header('Location: index.php?url=usuarios');

        // termina el script
        exit();

    }

    header("Location: index.php?url=403");
    exit();
            
    // termina el script
    exit();    
    
}
?>