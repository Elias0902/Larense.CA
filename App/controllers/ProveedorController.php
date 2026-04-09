<?php
    // llama el archivo del modelo
    require_once 'app/models/ProveedorModel.php';
    require_once 'app/models/PermisoModel.php';
    //require_once 'app/models/BitacoraModel.php';

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
        $modelo = new Proveedor();
        /*$permiso = new Permiso();
        //$bitacora = new Bitacora();

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Productos',
            'permiso' => 'Consultar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);


        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] == 1) {
            
            // Ejecutar acción permitida*/

            // para manejo de errores
            try {

                // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                // primer para metro la accion y luego el objeto usuario_json
                $resultado = $modelo->manejarAccion('consultar', null);

                // valida si exixtes el staus del resultado y si es true 
                if (isset($resultado['status']) && $resultado['status'] === true) {

                    // usa mensaje dinamico del modelo
                    //setSuccess($resultado['msj']);
                    
                    // extrae los datos de los proveedores
                    $proveedores = $resultado['data'];

                    //carga la vista
                    require_once 'app/views/dashboard_proveedores.php';

                    // termina el script
                    exit();
                }
                else {
                                
                    // usa mensaje dinamico del modelo
                    //setError($resultado['msj']);

                    //carga la vista
                    require_once 'app/views/dashboard_proveedores.php';

                    // termina el script
                    //exit();
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
    //setError("Error acceso no permitido");

    //redirect
    //require_once 'app/views/dashboard_proveedores.php';
                
    // termina el script
    //exit();
    
//}

    //funcion para guardar datos
    function Agregar() {

        // instacia el modelo
        $modelo = new Proveedor();
        /*$permiso = new Permiso();
        //$bitacora = new Bitacora();

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Productos',
            'permiso' => 'Agregar',
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
            $id_proveedor = filter_var($_POST['id_proveedor'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $tipo_id = filter_var($_POST['tipo_id'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $nombre_proveedor = filter_var($_POST['nombreProveedor'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $direccion_proveedor = filter_var($_POST['direccionProveedor'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $tlf_proveedor = filter_var($_POST['tlfProveedor'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $email_proveedor = filter_var($_POST['emailProveedor'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

            // valida si los campos no estan vacios
            if (empty($id_proveedor) || empty($tipo_id) || empty($nombre_proveedor) || empty($direccion_proveedor) || empty($tlf_proveedor) || empty($email_proveedor)) {

                // manda mensaje de error
                setError('Todos los campos son requeridos no se puede enviar vacios.');

                //redirec
                header('Location: index.php?url=proveedores');

                //termina el script
                exit();
            }
            

            // se arma el josn
            $proveedor_json = json_encode([
                'id' => $id_proveedor,
                'tipo_id' => $tipo_id,
                'nombre' => $nombre_proveedor,
                'direccion' => $direccion_proveedor,
                'tlf' => $tlf_proveedor,
                'email' => $email_proveedor
            ]);
            //print_r($proveedor_json);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('agregar', $proveedor_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);

                        // se arma json de bitacora
                        /*$bitacora_json = json_encode([
                            'usuario_id' => $_SESSION['s_usuario']['usuario_id'],
                            'modulo' => 'Productos',
                            'titulos' => 'Registro de Productos',
                            'descripcion' => 'El usuario: ' . $_SESSION['s_usuario']['usuario_nombre'] . ', realizo 
                                                un registro del siguiente producto: ' . $proucto_json['nombre'] . ', en 
                                                el modulo de productos.',
                            'fecha' => date('Y-m-d H:i:s')
                        ]);

                        // realiza la insercion de la bitacora
                        $bitacora->manejarAccion('agregar', $bitacora_json);*/
                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=proveedores');

                    }
                }
                catch (Exception $e) {

                    //mensaje del exception de pdo
                    error_log('Error al registrar...' . $e->getMessage());
                    
                    // carga la alerta
                    setError('Error en operacion.');
                }

            //redirect
            header('Location: index.php?url=proveedores');
            
            // termina el script
            exit();
        }

    //muestra un modal de info que dice acceso no permitido
    //setError("Error accion no permitida");

    //redirect
    //header('Location: index.php?url=productoss');
            
    // termina el script
    //exit();
        
    //}

    //funcion para modificar datos
    function Actualizar() {

         // instacia el modelo
        $modelo = new Proveedor();
        /*$permiso = new Permiso();
        //$bitacora = new Bitacora();

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Productos',
            'permiso' => 'Modificar',
            'rol' => $_SESSION['s_usuario']['usuario_rol_id']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] == 1) {
            
            // Ejecutar acción permitida*/

            // obtiene y sinatiza los valores
            $id_proveedor = $_POST['id_proveedorEdit'];
            $tipo_id = $_POST['tipo_idEdit'];
            $nombre_proveedor = filter_var($_POST['nombreProveedorEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $direccion_proveedor = filter_var($_POST['direccionProveedorEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $tlf_proveedor = filter_var($_POST['tlfProveedorEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $email_proveedor = filter_var($_POST['emailProveedorEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            
            // valida si los campos no estan vacios
            if (empty($id_proveedor) || empty($tipo_id) || empty($nombre_proveedor) || empty($direccion_proveedor) || empty($tlf_proveedor) || empty($email_proveedor)) {

                // manda mensaje de error
                setError('Todos los campos son requeridos no se puede enviar vacios.');

                //redirec
                header('Location: index.php?url=proveedores');

                //termina el script
                exit();
            }

            // se arma el josn
            $proveedor_json = json_encode([
                'id' => $id_proveedor,
                'tipo_id' => $tipo_id,
                'nombre' => $nombre_proveedor,
                'direccion' => $direccion_proveedor,
                'tlf' => $tlf_proveedor,
                'email' => $email_proveedor
            ]);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('modificar', $proveedor_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);

                        // se arma json de bitacora
                        /*$bitacora_json = json_encode([
                            'usuario_id' => $_SESSION['s_usuario']['usuario_id'],
                            'modulo' => 'Productos',
                            'titulos' => 'Registro de Producto',
                            'descripcion' => 'El usuario: ' . $_SESSION['s_usuario']['usuario_nombre'] . ', realizo 
                                                un registro del siguiente producto: ' . $producto_json['nombre'] . ', en 
                                                el modulo de productos.',
                            'fecha' => date('Y-m-d H:i:s')
                        ]);

                        // realiza la insercion de la bitacora
                        $bitacora->manejarAccion('agregar', $bitacora_json);*/
                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=proveedores');

                    }
                }
                catch (Exception $e) {

                    //mensaje del exception de pdo
                    error_log('Error al registrar...' . $e->getMessage());
                    
                    // carga la alerta
                    setError('Error en operacion.');
                }

            //redirect
            header('Location: index.php?url=proveedores');
            
            // termina el script
            exit();
        }

    //muestra un modal de info que dice acceso no permitido
    //setError("Error accion no permitida");

    //redirect
    //header('Location: index.php?url=productos');
            
    // termina el script
    //exit();

    //}

    // function para obtener un dato
    function Obtener() {

        // instacia el modelo
        $modelo = new Proveedor();

        $id = $_GET['ID'];

         // valida si los campos no estan vacios
        if (empty($id)) {

            // manda mensaje de error
            setError('Todos los campos son requeridos no se puede enviar vacios.');

            //redirec
            header('Location: index.php?url=proveedores');

            //termina el script
            exit();
        }

            // se arma el josn
            $proveedor_json = json_encode([
                'id' => $id
            ]);

            $resultado = $modelo->manejarAccion('obtener', $proveedor_json);

            $proveedor = $resultado['data'];

            echo json_encode($proveedor);

            exit();
    }

    // funcion para eliminar un dato
    function Eliminar() {

         // instacia el modelo
        $modelo = new Proveedor();
        /*$permiso = new Permiso();
        //$bitacora = new Bitacora();

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Productos',
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
            $id_proveedor = $_GET['ID'];

            // valida si los campos no estan vacios
            if (empty($id_proveedor)) {

                // manda mensaje de error
                setError('ID vacio.');

                //redirec
                header('Location: index.php?url=proveedores');

                //termina el script
                exit();
            }

            // se arma el josn
            $proveedor_json = json_encode([
                'id' => $id_proveedor
            ]);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('eliminar', $proveedor_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);
                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=proveedores');

                    }
                }
                catch (Exception $e) {

                    //mensaje del exception de pdo
                    error_log('Error al registrar...' . $e->getMessage());
                    
                    // carga la alerta
                    setError('Error en operacion.');
                }

        //redirect
        header('Location: index.php?url=proveedores');

        // termina el script
        exit();

    }

    //muestra un modal de info que dice acceso no permitido
    //setError("Error accion no permitida");

    //redirect
    //header('Location: index.php?url=productos');
            
    // termina el script
    //exit();    
    
//}
?>