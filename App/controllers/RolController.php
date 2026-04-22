<?php
    // llama el archivo del modelo
    require_once 'app/models/RolModel.php'; // para el rol
    require_once 'app/models/PermisoModel.php'; // para los permisos
    require_once 'app/models/BitacoraModel.php'; // para bitacora

    // llama el archivo que contiene la carga de alerta
    require_once 'components/utils.php';

    //zona horaria
    date_default_timezone_set('America/Caracas');

    // se almacena la action o la peticion http 
    //$action = '';
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    // indiferentemente sea la action el switch llama la funcion correspondiente
    switch($action) {

        case 'agregar':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                Agregar();
            }
        break;

        case 'obtener':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                Obtener();
            }
        break;

        case 'obtener_roles':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                Obtener_Roles();
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
            Consultar();
        break;
    }

    // funcion para consultar datos
    function Consultar() {
       
        // instacia el modelo
        $modelo = new Rol();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Roles',
            'permiso' => 'Consultar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);


        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] == 1) {
            
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
                    $roles = $resultado['data'];

                    // se arma el json de bitacora
                    $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Roles',
                        'accion' => 'Consultar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha Consultado los datos en dashboard de los roles' . ' ' .  'en el sistema.',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                    //carga la vista
                    //require_once 'app/views/permisosView.php';

                    // termina el script
                    exit();
                }
                else {
                                
                    // usa mensaje dinamico del modelo
                    setError($resultado['msj']);

                    //carga la vista
                    //require_once 'app/views/permisosView.php';

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
    //muestra un modal de info que dice acceso no permitido
    setError("Error acceso no permitido");

    //redirect
    //require_once 'app/views/categoriasView.php';
                
    // termina el script
    exit();
    
}

    //funcion para guardar datos
    function Agregar() {

        // instacia el modelo
        $modelo = new Rol();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Roles',
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
            $nombre_rol = filter_var($_POST['nombreRol'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

            // valida si los campos no estan vacios
            if (empty($nombre_rol)) {

                // manda mensaje de error
                setError('Todos los campos son requeridos no se puede enviar vacios.');

                //redirec
                header('Location: index.php?url=roles');

                //termina el script
                exit();
            }

            // se arma el josn
            $rol_json = json_encode([
                'nombre' => $nombre_rol
            ]);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('agregar', $rol_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);

                        // se arma json de bitacora
                        // se arma el json de bitacora
                        $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Roles',
                        'accion' => 'Agregar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                        'ha ragistras el siguiente rol' . ' ' . $nombre_rol . ' ' . 'en el sistema.',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=roles');

                    }
                }
                catch (Exception $e) {

                    //mensaje del exception de pdo
                    error_log('Error al registrar...' . $e->getMessage());
                    
                    // carga la alerta
                    setError('Error en operacion.');
                }

            //redirect
            header('Location: index.php?url=roles');
            
            // termina el script
            exit();
        }

    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida");

    //redirect
    header('Location: index.php?url=roles');
            
    // termina el script
    exit();
        
    }

    // funcion para consultar datos
    function Obtener_Roles() {
       
        // instacia el modelo
        $modelo = new Rol();

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
                    $roles = $resultado['data'];
                    
                    // imprime los datos
                    echo json_encode($roles);

                    // termina el script
                    exit();
                }
                else {
                                
                    // usa mensaje dinamico del modelo
                    setError($resultado['msj']);

                    //carga la vista
                    require_once 'app/views/dashboard_permisos.php';

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

    // function para obtener un dato
    function Obtener() {

        // instacia el modelo
        $modelo = new Rol();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

            // para manejo de errores
            try {

            $id = $_GET['ID'];

            // valida si los campos no estan vacios
            if (empty($id)) {

                // manda mensaje de error
                setError('Todos los campos son requeridos no se puede enviar vacios.');

                //redirec
                header('Location: index.php?url=roles');

                //termina el script
                exit();
            }

            // se arma el josn
            $rol_json = json_encode([
                'id' => $id
            ]);

            $resultado = $modelo->manejarAccion('obtener', $rol_json);

            $roles = $resultado['data'];

            $data_bitacora = $resultado['data_bitacora'];

            // se arma el json de bitacora
            $bitacora_json = json_encode([
                'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                'modulo' => 'Roles',
                'accion' => 'Obtener',
                'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                    'ha obtenido los datos del siguiente rol' . ' ' . 'RL-00' . 
                    $data_bitacora['id_rol'] . ' ' . $data_bitacora['nombre_rol'] . 
                    ' ' . 'en el sistema.',
                'fecha' => $fecha
            ]);

            //realiza la insercion de la bitacora
            $bitacora->manejarAccion('agregar', $bitacora_json);

            echo json_encode($roles);

            exit();
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

//funcion para modificar datos
    function Actualizar() {

         // instacia el modelo
        $modelo = new Rol();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Roles',
            'permiso' => 'Modificar',
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
            $id = $_POST['id'];
            $nombre_rol = filter_var($_POST['nombreRol'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

            // valida si los campos no estan vacios
            if (empty($nombre_rol || empty($id) )) {

                // manda mensaje de error
                setError('Todos los campos son requeridos no se puede enviar vacios.');

                //redirec
                header('Location: index.php?url=roles');

                //termina el script
                exit();
            }

            // se arma el josn
            $rol_json = json_encode([
                'id' => $id,
                'nombre' => $nombre_rol
            ]);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('modificar', $rol_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);

                        //datos para la bitacora
                        $data_bitacora = $resultado['data_bitacora'];

                        // se arma el json de bitacora
                        $bitacora_json = json_encode([
                            'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                            'modulo' => 'Roles',
                            'accion' => 'Modificar',
                            'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                                                'ha modificado los datos del siguiente rol' . ' ' . 'RL-00' . 
                                                $data_bitacora['id_rol'] . ' ' . $data_bitacora['nombre_rol'] . 
                                                ' ' . 'por los siguientes datos' . ' ' . 'RL-00' . $id . ' ' . $nombre_rol . 
                                                ' ' . 'en el sistema.',
                            'fecha' => $fecha
                        ]);

                        //realiza la insercion de la bitacora
                        $bitacora->manejarAccion('agregar', $bitacora_json);

                        //redirect
                        header('Location: index.php?url=roles');
                        
                        // termina el script
                        exit();
                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=roles');

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
            header('Location: index.php?url=roles');
            
            // termina el script
            exit();
        }

    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida");

    //redirect
    header('Location: index.php?url=roles');
            
    // termina el script
    exit();

    }

    // funcion para eliminar un dato
    function Eliminar() {

         // instacia el modelo
        $modelo = new Rol();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');


        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Roles',
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
            $id_rol = $_GET['ID'];

            // valida si los campos no estan vacios
            if (empty($id_rol)) {

                // manda mensaje de error
                setError('ID vacio.');

                //redirec
                header('Location: index.php?url=roles');

                //termina el script
                exit();
            }

            // se arma el josn
            $rol_json = json_encode([
                'id' => $id_rol
            ]);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('eliminar', $rol_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);

                        //datos para bitacoras
                        $data_bitacora = $resultado['data_bitacora'];

                        // se arma el json de bitacora
                        $bitacora_json = json_encode([
                            'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                            'modulo' => 'Roles',
                            'accion' => 'Eliminar',
                            'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                                'ha eliminado el siguiente rol' . ' ' . 'RL-00' . $data_bitacora['id_rol'] . ' ' . 
                                $data_bitacora['nombre_rol'] . ' ' . 'en el sistema.',
                            'fecha' => $fecha
                        ]);

                        //realiza la insercion de la bitacora
                        $bitacora->manejarAccion('agregar', $bitacora_json);
                        
                        //redirect
                        header('Location: index.php?url=roles');
                        
                        // termina el script
                        exit();
                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=roles');

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
        header('Location: index.php?url=roles');

        // termina el script
        exit();

    }

    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida");

    //redirect
    header('Location: index.php?url=roles');
            
    // termina el script
    exit();    
    
}
?>