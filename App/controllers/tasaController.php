<?php
    // llama el archivo del modelo
    require_once 'app/models/TasaModel.php';
    require_once 'app/models/PermisoModel.php';
    require_once 'app/models/BitacoraModel.php';

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

        case 'modificar':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                Actualizar();
            }
        break;

        case 'obtener':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                Obtener();
            }

        case 'obtenerUltima':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                ObtenerUltima();
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
        $modelo = new Tasa();
        $permiso = new Permiso();
        $bitacora = new Bitacora();
        
        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');
        

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Tasa',
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
                    $tasas = $resultado['data'];

                    // se arma el json de bitacora
                    $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Tasa',
                        'accion' => 'Consultar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha Consultado los datos en dashboard de tasa cambiaria' . ' ' . 'en el sistema.',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                    //carga la vista
                    require_once 'app/views/tasaView.php';

                    // termina el script
                    exit();
                }
                else {
                                
                    // usa mensaje dinamico del modelo
                    //setError($resultado['msj']);

                    //carga la vista
                    require_once 'app/views/tasaView.php';

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
    header('Location: index.php?url=403');
                
    // termina el script
    exit();
    
}

    //funcion para guardar datos
    function Agregar() {

        // instacia el modelo
        $modelo = new Tasa();
        $bitacora = new Bitacora();
        $permiso = new Permiso();
        
        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Tasa',
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
            $monto_tasa = filter_var($_POST['monto_tasa'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $fecha_tasa = $fecha;

            // valida si los campos no estan vacios
            if (empty($monto_tasa) || empty($fecha_tasa)) {

                // manda mensaje de error
                setError('Todos los campos son requeridos no se puede enviar vacios.');

                //redirec
                header('Location: index.php?url=tasa');

                //termina el script
                exit();
            }

            // se arma el josn
            $tasa_json = json_encode([
                'monto' => $monto_tasa,
                'fecha' => $fecha_tasa
            ]);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('agregar', $tasa_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);

                        // se arma el json de bitacora
                        $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Tasa',
                        'accion' => 'Agregar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 'ha ragistras la siguiente tasa' . ' ' . $monto_tasa . ' ' . $fecha_tasa . ' ' . 'en el sistema.',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);
                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=tasa');

                    }
                }
                catch (Exception $e) {

                    //mensaje del exception de pdo
                    error_log('Error al registrar...' . $e->getMessage());
                    
                    // carga la alerta
                    setError('Error en operacion.');
                }

            //redirect
            header('Location: index.php?url=tasa');
            
            // termina el script
            exit();
        }

    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida");

    //redirect
    header('Location: index.php?url=403');

            
    // termina el script
    exit();
        
    }

    //funcion para modificar datos
    function Actualizar() {

         // instacia el modelo
        $modelo = new Tasa();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Tasa',
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
            $id = $_POST['id'];
            $monto_tasa = filter_var($_POST['montoTasaEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

            // valida si los campos no estan vacios
            if (empty($monto_tasa || empty($id) )) {

                // manda mensaje de error
                setError('Todos los campos son requeridos no se puede enviar vacios.');

                //redirec
                header('Location: index.php?url=tasa');

                //termina el script
                exit();
            }

            // se arma el josn
            $tasa_json = json_encode([
                'id' => $id,
                'monto' => $monto_tasa
            ]);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('modificar', $tasa_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);

                        //datos para la bitacora
                        $data_bitacora = $resultado['data_bitacora'];

                        // se arma el json de bitacora
                        $bitacora_json = json_encode([
                            'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                            'modulo' => 'Tasa',
                            'accion' => 'Modificar',
                            'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                                                'ha modificado los datos de la siguiente tasa' . ' ' . 'TS-00' . 
                                                $data_bitacora['id_tasa'] . ' ' . $data_bitacora['monto_tasa'] . 
                                                ' ' . 'por los siguientes datos' . ' ' . 'CT-00' . $id . ' ' . $monto_tasa . 
                                                ' ' . 'en el sistema.',
                            'fecha' => $fecha
                        ]);

                        //realiza la insercion de la bitacora
                        $bitacora->manejarAccion('agregar', $bitacora_json);

                        //redirect
                        header('Location: index.php?url=tasa');
                        
                        // termina el script
                        exit();
                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=tasa');

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
            header('Location: index.php?url=tasa');
            
            // termina el script
            exit();
        }

    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida");

    //redirect
    header('Location: index.php?url=403');

            
    // termina el script
    exit();

    }

    // function para obtener un dato
    function Obtener() {

        // instacia el modelo
        $modelo = new Tasa();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        $id = $_GET['ID'];

         // valida si los campos no estan vacios
        if (empty($id)) {

            // manda mensaje de error
            setError('Todos los campos son requeridos no se puede enviar vacios.');

            //redirec
            header('Location: index.php?url=tasa');

            //termina el script
            exit();
        }

            // se arma el josn
            $tasa_json = json_encode([
                'id' => $id
            ]);

            $resultado = $modelo->manejarAccion('obtener', $tasa_json);

            // se almacena para la vista
            $tasa = $resultado['data'];

            // se almacena para la bitacora
            $data_bitacora = $resultado['data_bitacora'];

            // se arma el json de bitacora
            $bitacora_json = json_encode([
                'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                'modulo' => 'Tasa',
                'accion' => 'Obtener',
                'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                    'ha obtenido los datos de la siguiente tasa' . ' ' . 'TS-00' . 
                    $data_bitacora['id_tasa'] . ' ' . $data_bitacora['monto_tasa'] . 
                    ' ' . 'en el sistema.',
                'fecha' => $fecha
            ]);

            //realiza la insercion de la bitacora
            $bitacora->manejarAccion('agregar', $bitacora_json);

            echo json_encode($tasa);

            exit();
    }

        // function para obtener un dato
    function ObtenerUltima() {

        // instacia el modelo
        $modelo = new Tasa();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

            $resultado = $modelo->manejarAccion('obtenerUltima', null);

            // se almacena para la vista
            $tasa = $resultado['data'];

            // se almacena para la bitacora
            $data_bitacora = $resultado['data_bitacora'];

            // se arma el json de bitacora
            $bitacora_json = json_encode([
                'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                'modulo' => 'Tasa',
                'accion' => 'Obtener',
                'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                    'ha obtenido los datos de la siguiente tasa' . ' ' . 'TS-00' . 
                    $data_bitacora['id_tasa'] . ' ' . $data_bitacora['monto_tasa'] . 
                    ' ' . 'en el sistema.',
                'fecha' => $fecha
            ]);

            //realiza la insercion de la bitacora
            $bitacora->manejarAccion('agregar', $bitacora_json);

            echo json_encode($tasa);

            exit();
    }

    // funcion para eliminar un dato
    function Eliminar() {

         // instacia el modelo
        $modelo = new Tasa();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');


        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Tasa',
            'permiso' => 'Eliminar',
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
            $id = $_GET['ID'];

            // valida si los campos no estan vacios
            if (empty($id)) {

                // manda mensaje de error
                setError('ID vacio.');

                //redirec
                header('Location: index.php?url=tasa');

                //termina el script
                exit();
            }

            // se arma el josn
            $tasa_json = json_encode([
                'id' => $id
            ]);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('eliminar', $tasa_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);

                        //datos para bitacoras
                        $data_bitacora = $resultado['data_bitacora'];

                        // se arma el json de bitacora
                        $bitacora_json = json_encode([
                            'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                            'modulo' => 'Tasa',
                            'accion' => 'Eliminar',
                            'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 'ha eliminado una tasa de codigo' . ' ' . 'TS-00' . $data_bitacora['id_tasa'] . ' ' . $data_bitacora['monto_tasa'] . ' ' . 'en el sistema.',
                            'fecha' => $fecha
                        ]);

                        //realiza la insercion de la bitacora
                        $bitacora->manejarAccion('agregar', $bitacora_json);
                        
                        //redirect
                        header('Location: index.php?url=tasa');
                        
                        // termina el script
                        exit();
                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=tasa');

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
        header('Location: index.php?url=tasa');

        // termina el script
        exit();

    }

    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida");

    //redirect
    header('Location: index.php?url=403');
            
    // termina el script
    exit();    
    
}
?>