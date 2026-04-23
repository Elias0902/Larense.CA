<?php
    // llama el archivo del modelo
    require_once 'app/models/MateriaPrimaModel.php'; // para la materia prima
    require_once 'app/models/ProveedorModel.php'; // para los proveedores
    require_once 'app/models/BitacoraModel.php'; // para la bitacoras
    require_once 'app/models/PermisoModel.php'; // para los permisos

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
        $modelo = new MateriaPrima();
        $proveedor = new Proveedor();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');
        

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
        if (isset($status['status']) && $status['status'] === true) {
            
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
                    
                    // extrae los datos de las materias primas
                    $materiaPrima = $resultado['data'];

                    // extrae los datos de los proveedores
                    $prov = $proveedores = $proveedor->manejarAccion('consultar', null)['data'];
                    $medida = $unidades_medida = $modelo->manejarAccion('obtener_Medidas', null)['data'];

                     // se arma el json de bitacora
                        $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Materias Primas',
                        'accion' => 'Consultar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha Consultado los datos en el dashboard de materia prima en el sistema',
                            'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                    //carga la vista
                    require_once 'app/views/materiasPrimasView.php';

                    // termina el script
                    exit();
                }
                else {
                                
                    // usa mensaje dinamico del modelo
                    setError($resultado['msj']);

                    //carga la vista
                    require_once 'app/views/materiasPrimasView.php';

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
    
    require_once 'App/views/errors/403.php';
    exit();
    
}

    //funcion para guardar datos
    function Agregar() {

        // instacia el modelo
        $modelo = new MateriaPrima();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');


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
            $nombre_materia_prima = filter_var($_POST['nombreMateriaPrima'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $descripcion_materia_prima = filter_var($_POST['descripcionMateriaPrima'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $stock_materia_prima = filter_var($_POST['stockMateriaPrima'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $proveedor_materia_prima = filter_var($_POST['proveedorMateriaPrima'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $medida_materia_prima = filter_var($_POST['unidadMedida'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

            // valida si los campos no estan vacios
            if (empty($nombre_materia_prima) || empty($descripcion_materia_prima) || empty($stock_materia_prima) || empty($proveedor_materia_prima) || empty($medida_materia_prima)) {

                // manda mensaje de error
                setError('Todos los campos son requeridos no se puede enviar vacios.');

                //redirec
                header('Location: index.php?url=materias_primas');

                //termina el script
                exit();
            }
            

            // se arma el josn
            $materiaPrima_json = json_encode([
                'nombre' => $nombre_materia_prima,
                'descripcion' => $descripcion_materia_prima,
                'stock' => $stock_materia_prima,
                'proveedor' => $proveedor_materia_prima,
                'medida' => $medida_materia_prima
            ]);
            //print_r($materiaPrima_json);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('agregar', $materiaPrima_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);

                        // se arma el json de bitacora
                        $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Materias Primas',
                        'accion' => 'Agregar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha ragistrado la siguiente materia prima' . ' ' . 
                            'Nombre' . ' ' . $nombre_materia_prima . ' ' .
                            'Descripcion' . ' ' . $descripcion_materia_prima . ' ' . 
                            'Stock' . ' ' . $stock_producto . ' ' . 
                            'Proveedor' . ' ' . $proveedor_materia_prima . ' ' . 'en el sistema',
                            'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=materias_primas');

                    }
                }
                catch (Exception $e) {

                    //mensaje del exception de pdo
                    error_log('Error al registrar...' . $e->getMessage());
                    
                    // carga la alerta
                    setError('Error en operacion.');
                }

            //redirect
            header('Location: index.php?url=materias_primas');
            
            // termina el script
            exit();
        }

    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida");

    //redirect
    header('Location: index.php?url=productoss');
            
    // termina el script
    exit();
        
}

    //funcion para modificar datos
    function Actualizar() {

         // instacia el modelo
        $modelo = new MateriaPrima();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');


        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Productos',
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
            $id = $_POST['idEdit'];
            $nombre_materia_prima = filter_var($_POST['nombreMateriaPrimaEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $descripcion_materia_prima = filter_var($_POST['descripcionMateriaPrimaEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $stock_materia_prima = filter_var($_POST['stockMateriaPrimaEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $proveedor_materia_prima = filter_var($_POST['proveedorMateriaPrimaEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $medida_materia_prima = filter_var($_POST['unidadMedidaEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

            // valida si los campos no estan vacios
            if (empty($nombre_materia_prima) || empty($id) || empty($descripcion_materia_prima) || empty($stock_materia_prima) || empty($proveedor_materia_prima) || empty($medida_materia_prima)) {

                // manda mensaje de error
                setError('Todos los campos son requeridos no se puede enviar vacios.');

                //redirec
                header('Location: index.php?url=materias_primas');

                //termina el script
                exit();
            }

            // se arma el josn
            $materiaPrima_json = json_encode([
                'id' => $id,
                'nombre' => $nombre_materia_prima,
                'descripcion' => $descripcion_materia_prima,
                'stock' => $stock_materia_prima,
                'proveedor' => $proveedor_materia_prima,
                'medida' => $medida_materia_prima
            ]);
            //print_r($materiaPrima_json);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('modificar', $materiaPrima_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);

                        // se almacena para la bitacora
                        $data_bitacora = $resultado['data_bitacora'];

                        // se arma el json de bitacora
                        $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Materias Primas',
                        'accion' => 'Modificar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha modificado la siguiente materia prima' . ' ' .
                            'Codigo de materia prima' . ' ' . $data_bitacora['id_materia_prima'] . ' ' . 
                            'Nombre' . ' ' . $data_bitacora['nombre_materia_prima'] . ' ' . 
                            'Descripcion' . ' ' . $data_bitacora['descripcion_materia_prima'] . ' ' . 
                            'Stock' . ' ' . $data_bitacora['stock_actual'] . ' ' . 
                            'Por los siguientes datos nuevos' . ' ' . 
                            'Codigo de la materia prima' . ' ' . $id . 
                            'Nombre' . ' ' . $nombre_materia_prima . ' ' .
                            'Descripcion' . ' ' . $descripcion_materia_prima . ' ' . 
                            'Stock' . ' ' . $stock_producto . ' ' . 
                            'Proveedor' . ' ' . $proveedor_materia_prima . ' ' . 'en el sistema',
                            'fecha' => $fecha
                        ]);

                        //realiza la insercion de la bitacora
                        $bitacora->manejarAccion('agregar', $bitacora_json);
                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=materias_primas ');

                    }
                }
                catch (Exception $e) {

                    //mensaje del exception de pdo
                    error_log('Error al registrar...' . $e->getMessage());
                    
                    // carga la alerta
                    setError('Error en operacion.');
                }

            //redirect
            header('Location: index.php?url=materias_primas');
            
            // termina el script
            exit();
        }

    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida");

    //redirect
    header('Location: index.php?url=productos');
            
    // termina el script
    exit();

}

    // function para obtener un dato
    function Obtener() {

        // instacia el modelo
        $modelo = new MateriaPrima();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        $id = $_GET['ID'];

         // valida si los campos no estan vacios
        if (empty($id)) {

            // manda mensaje de error
            setError('Todos los campos son requeridos no se puede enviar vacios.');

            //redirec
            header('Location: index.php?url=materias_primas');

            //termina el script
            exit();
        }

            // se arma el josn
            $materiaPrima_json = json_encode([
                'id' => $id
            ]);

            $resultado = $modelo->manejarAccion('obtener', $materiaPrima_json);

            // se almacena para la vista
            $materiaPrima = $resultado['data'];

            // se almacena para la bitacora
            $data_bitacora = $resultado['data_bitacora'];

            // se arma el json de bitacora
            $bitacora_json = json_encode([
                'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                'modulo' => 'Materias Primas',
                'accion' => 'Obtener',
                'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                    'ha obtenido los datos de la siguiente materia primas' . ' ' .  
                    'Codigo de materia prima' . ' ' . $data_bitacora['id_materia_prima'] . ' ' . 
                    'Nombre' . ' ' . $data_bitacora['nombre_materia_prima'] . ' ' . 
                    'Descripcion' . ' ' . $data_bitacora['descripcion_materia_prima'] . ' ' . 
                    'Stock' . ' ' . $data_bitacora['stock_actual'] . 
                    ' ' . 'en el sistema',
                'fecha' => $fecha
            ]);

            //realiza la insercion de la bitacora
            $bitacora->manejarAccion('agregar', $bitacora_json);

            echo json_encode($materiaPrima);

            exit();
    }

    // funcion para eliminar un dato
    function Eliminar() {

         // instacia el modelo
        $modelo = new MateriaPrima();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');


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
        if (isset($status['status']) && $status['status'] === true) {
            
            // Ejecutar acción permitida*/

            // obtiene y sinatiza los valores
            $id_materia_prima = $_GET['ID'];

            // valida si los campos no estan vacios
            if (empty($id_materia_prima)) {

                // manda mensaje de error
                setError('ID vacio.');

                //redirec
                header('Location: index.php?url=materias_primas');

                //termina el script
                exit();
            }

            // se arma el josn
            $materiaPrima_json = json_encode([
                'id' => $id_materia_prima
            ]);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('eliminar', $materiaPrima_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);

                        // se almacena para la bitacora
                        $data_bitacora = $resultado['data_bitacora'];

                        // se arma el json de bitacora
                        $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Materias Primas',
                        'accion' => 'Eliminar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha eliminado la siguiente materia prima' . ' ' .
                            'Codigo de materia prima' . ' ' . $data_bitacora['id_materia_prima'] . ' ' . 
                            'Nombre' . ' ' . $data_bitacora['nombre_materia_prima'] . ' ' . 
                            'Descripcion' . ' ' . $data_bitacora['descripcion_materia_prima'] . ' ' . 
                            'Stock' . ' ' . $data_bitacora['stock_actual'] . 
                            ' ' . 'en el sistema.',
                        'fecha' => $fecha
                        ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=materias_primas');

                    }
                }
                catch (Exception $e) {

                    //mensaje del exception de pdo
                    error_log('Error al registrar...' . $e->getMessage());
                    
                    // carga la alerta
                    setError('Error en operacion.');
                }

        //redirect
        header('Location: index.php?url=materias_primas');

        // termina el script
        exit();

    }

    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida");

    //redirect
    header('Location: index.php?url=productos');
            
    // termina el script
    exit();    
    
}
?>