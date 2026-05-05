<?php
    // llama el archivo del modelo
    require_once 'app/models/ProduccionModel.php';
    require_once 'app/models/ProductoModel.php';
    require_once 'app/models/MateriaPrimaModel.php';
    require_once 'app/models/PermisoModel.php';
    require_once 'app/models/BitacoraModel.php';

    // llama el archivo que contiene la carga de alerta
    require_once 'components/utils.php';

    //zona horaria
    date_default_timezone_set('America/Caracas');

    // se almacena la action o la peticion http
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
        $modelo = new Produccion();
        $producto = new Producto();
        $materiaPrima = new MateriaPrima();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Producciones',
            'permiso' => 'Consultar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la accion requerida
        if (isset($status['status']) && $status['status'] === true) {

            try {
                // llama la funcion que maneja las acciones en el modelo
                $resultado = $modelo->manejarAccion('consultar', null);

                // valida si exixtes el staus del resultado y si es true
                if (isset($resultado['status']) && $resultado['status'] === true) {
                    // extrae los datos de las producciones
                    $producciones = $resultado['data'];

                    // extrae los datos de los productos
                    $prod = $productos = $producto->manejarAccion('consultar', null)['data'];
                    $materia =$materiaPrimas = $materiaPrima->manejarAccion('consultar', null)['data'];

                    // se arma el json de bitacora
                    $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Producciones',
                        'accion' => 'Consultar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' .
                            'ha Consultado los datos en el dashboard de producciones en el sistema',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                    //carga la vista
                    require_once 'app/views/produccionesView.php';
                    exit();
                }
                else {
                    // usa mensaje dinamico del modelo
                    //setError($resultado['msj']);

                    // extrae los datos de los productos para los selects
                    $prod = $productos = $producto->manejarAccion('consultar', null)['data'];
                    $materia =$materiaPrimas = $materiaPrima->manejarAccion('consultar', null)['data'];
                    $producciones = [];

                    //carga la vista
                    require_once 'app/views/produccionesView.php';
                }
            }
            catch (Exception $e) {
                error_log('Error al consultar...' . $e->getMessage());
                setError('Error en operacion.');
                exit();
            }
        }
        else {

        //muestra un modal de info que dice acceso no permitido
        setError("Error acceso no permitido");

        //redirect
        header("Location: index.php?url=403");
                
        // termina el script
        exit();
    }

}

    //funcion para guardar datos
    function Agregar() {
        // instacia el modelo
        $modelo = new Produccion();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Producciones',
            'permiso' => 'Agregar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la accion requerida
        if (isset($status['status']) && $status['status'] === true) {

            // obtiene y sinatiza los valores
            $motivo_produccion = filter_var($_POST['motivoProduccion'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $producto_produccion = filter_var($_POST['productoProduccion'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $cantidad_producto = filter_var($_POST['cantidadProducto'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $materia_prima_produccion = $_POST['materiaPrimaProduccion'] ?? [];
            $cantidad_produccion = $_POST['cantidadProduccion'] ?? [];
            $observacion_produccion = filter_var($_POST['observacionProduccion'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $fecha_produccion = filter_var($_POST['fechaProduccion'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

            // valida si los campos no estan vacios
            if (empty($producto_produccion)  || empty($cantidad_producto) || empty($cantidad_produccion ) || empty($materia_prima_produccion) || empty($observacion_produccion) || empty($fecha_produccion) || empty($motivo_produccion)) {
                
                // usa mensaje dinamico del modelo
                setError('Todos los campos son requeridos no se puede enviar vacios.');
                
                // redirige ai estan vacios
                header('Location: index.php?url=producciones');

                // detiene la ejecucion del script
                exit();
            }

            // se arma el json
            $produccion_json = json_encode([
                'motivo' => $motivo_produccion,
                'producto' => $producto_produccion,
                'cantidad_producto' => $cantidad_producto,
                'materia_prima' => $materia_prima_produccion,
                'cantidad' => $cantidad_produccion,
                'observacion' => $observacion_produccion,
                'fecha' => $fecha_produccion
            ]);
            //print_r($produccion_json);

            try {
                // llama la funcion que maneja las acciones en el modelo
                $resultado = $modelo->manejarAccion('agregar', $produccion_json);

                // valida si exixtes el staus del resultado y si es true
                if (isset($resultado['status']) && $resultado['status'] === true) {
                    setSuccess($resultado['msj']);

                    // se arma el json de bitacora
                    $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Producciones',
                        'accion' => 'Agregar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' .
                            'ha Agregado una producción' . ' ' . 
                            'Con los siguientes datos:' . ' ' .
                            'Motivo:' . ' ' . $motivo_produccion . ',' . ' ' .
                            'Producto:' . ' ' . $producto_produccion . ',' . ' ' . 
                            'Cantidad Producto:' . ' ' . $cantidad_producto . ',' . ' ' .
                            'Materia Prima:' . ' ' . implode(', ', $materia_prima_produccion) . ',' . ' ' .
                            'Cantidad:' . ' ' . implode(', ', $cantidad_produccion) . ',' . ' ' .
                            'Observacion:' . ' ' . $observacion_produccion . ',' . ' ' . 
                            'Fecha:' . ' ' . $fecha_produccion . ',' . ' ' .
                            'en el sistema',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);
                }
                else {

                    // muestra el mensaje dinamico del modelo
                    setError($resultado['msj']);

                    // redirige ai esta condicion no se cumple
                    header('Location: index.php?url=producciones');

                    // termina la ejecucion del script
                    exit();
                }
            }
            catch (Exception $e) {
                error_log('Error al registrar...' . $e->getMessage());
                setError('Error en operacion.');
            }

            header('Location: index.php?url=producciones');
            exit();
        }

        header("Location: index.php?url=403");
        exit();
    }

    //funcion para modificar datos
    function Actualizar() {
        // instacia el modelo
        $modelo = new Produccion();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Producciones',
            'permiso' => 'Modificar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la accion requerida
        if (isset($status['status']) && $status['status'] === true) {

            // obtiene y sinatiza los valores
            $id = $_POST['idEdit'];
            $motivo_produccion = filter_var($_POST['motivoProduccionEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $producto_produccion = filter_var($_POST['productoProduccionEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $cantidad_producto = filter_var($_POST['cantidadProductoEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $materia_prima_produccion = $_POST['materiaPrimaEdit'] ?? [];
            $cantidad_produccion = $_POST['cantidadEdit'] ?? [];
            $observacion_produccion = filter_var($_POST['observacionProduccionEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $fecha_produccion = filter_var($_POST['fechaProduccionEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

            // valida si los campos no estan vacios
            if (empty($id) || empty($producto_produccion) || empty($cantidad_produccion) || empty($cantidad_producto) || empty($materia_prima_produccion) || empty($observacion_produccion) || empty($fecha_produccion) || empty($motivo_produccion)) {
                setError('Todos los campos son requeridos no se puede enviar vacios.');
                header('Location: index.php?url=producciones');
                exit();
            }

            // se arma el json
            $produccion_json = json_encode([
                'id' => $id,
                'motivo' => $motivo_produccion,
                'producto' => $producto_produccion,
                'cantidad_producto' => $cantidad_producto,
                'materia_prima' => $materia_prima_produccion,
                'cantidad' => $cantidad_produccion,
                'observacion' => $observacion_produccion,
                'fecha' => $fecha_produccion
            ]);
            //print_r($produccion_json);

            try {
                // llama la funcion que maneja las acciones en el modelo
                $resultado = $modelo->manejarAccion('modificar', $produccion_json);

                // valida si exixtes el staus del resultado y si es true
                if (isset($resultado['status']) && $resultado['status'] === true) {
                    setSuccess($resultado['msj']);

                    // se arma el json de bitacora
                    $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Producciones',
                        'accion' => 'Modificar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' .
                            'ha Modificado una producción' . ' ' . 
                            'Con los siguientes datos:' . ' ' .
                            'Codigo de produccion:' . ' ' . $id . ',' . ' ' .
                            'Motivo:' . ' ' . $motivo_produccion . ',' . ' ' .
                            'Producto:' . ' ' . $producto_produccion . ',' . ' ' . 
                            'Cantidad Producto:' . ' ' . $cantidad_producto . ',' . ' ' .
                            'Materia Prima:' . ' ' . implode(', ', $materia_prima_produccion) . ',' . ' ' .
                            'Cantidad:' . ' ' . implode(', ', $cantidad_produccion) . ',' . ' ' .
                            'Observacion:' . ' ' . $observacion_produccion . ',' . ' ' . 
                            'Fecha:' . ' ' . $fecha_produccion . ',' . ' ' .
                            'en el sistema',
                            'en el sistema',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);
                }
                else {

                    // usa mensaje dinamico del modelo
                    setError($resultado['msj']);

                    // redirige ai esta condicion no se cumple
                    header('Location: index.php?url=producciones');
                }
            }
            catch (Exception $e) {

                // registra el error en el log del servidor
                error_log('Error al registrar...' . $e->getMessage());

                // usa mensaje dinamico del modelo
                setError('Error en operacion.');
            }

            // redirige ai se cumple todo
            header('Location: index.php?url=producciones');
            
            // detiene la ejecucion del script
            exit();
        }

        //muestra un modal de info que dice acceso no permitido
        header("Location: index.php?url=403");
        
        // termina el script
        exit();
    }


    // function para obtener un dato
    function Obtener() {

        // instacia el modelo
        $modelo = new Produccion();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // obtiene y sinatiza los valores
        $id = $_GET['ID'];

        // valida si los campos no estan vacios
        if (empty($id)) {

            // usa mensaje dinamico del modelo
            setError('Todos los campos son requeridos no se puede enviar vacios.');
            
            // redirige ai estan vacios
            header('Location: index.php?url=producciones');
            
            // detiene la ejecucion del script
            exit();
        }

        // se arma el json
        $produccion_json = json_encode([
            'id' => $id
        ]);

        // llama la funcion que maneja las acciones en el modelo
        $resultado = $modelo->manejarAccion('obtener', $produccion_json);
        
        // obtiene los datos de la produccion
        $produccion = $resultado['data'];

        // se almacena para la bitacora
        $data_bitacora = $resultado['data_bitacora'];

        // se arma el json de bitacora
            $bitacora_json = json_encode([
                'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                'modulo' => 'Producciones',
                'accion' => 'Obtener',
                'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                    'ha obtenido los datos de la siguiente produccion' . ' ' . 
                    'PR-00' . $data_bitacora['id_produccion'] . ' ' . 
                    $data_bitacora['motivo_produccion'] . ' ' . 
                    $data_bitacora['nombre_producto'] . ' ' . 
                    $data_bitacora['cantidad_producida'] . ' ' . 
                    $data_bitacora['nombre_materia_prima'] . ' ' . 
                    $data_bitacora['cantidad_utilizada'] . ' ' . 
                    $data_bitacora['observacion'] . ' ' . 
                    $data_bitacora['fecha_produccion'] . ' ' . 
                    ' ' . 'en el sistema.',
                'fecha' => $fecha
            ]);

            //realiza la insercion de la bitacora
            $bitacora->manejarAccion('agregar', $bitacora_json);

        // retorna el resultado en formato json
        echo json_encode($produccion);
        
        // detiene la ejecucion del script
        exit();
    }

    // funcion para eliminar un dato
    function Eliminar() {
        // instacia el modelo
        $modelo = new Produccion();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Producciones',
            'permiso' => 'Eliminar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la accion requerida
        if (isset($status['status']) && $status['status'] === true) {

            // obtiene y sinatiza los valores
            $id_produccion = $_GET['ID'];

            // valida si los campos no estan vacios
            if (empty($id_produccion)) {

                // usa mensaje dinamico del modelo
                setError('ID vacio.');

                // redirige ai estan vacios
                header('Location: index.php?url=producciones');
                
                // detiene la ejecucion del script
                exit();
            }

            // se arma el json
            $produccion_json = json_encode([
                'id' => $id_produccion
            ]);

            try {
                // llama la funcion que maneja las acciones en el modelo
                $resultado = $modelo->manejarAccion('eliminar', $produccion_json);

                // valida si exixtes el staus del resultado y si es true
                if (isset($resultado['status']) && $resultado['status'] === true) {
                    setSuccess($resultado['msj']);

                    // se arma el json de bitacora
                    $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Producciones',
                        'accion' => 'Eliminar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' .
                            'ha Eliminado una producción' . ' ' . 
                            'Codigo de produccion:' . ' ' . $id_produccion . ' ' .
                            'en el sistema',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);
                }
                else {

                    // usa mensaje dinamico del modelo
                    setError($resultado['msj']);

                    // redirige ai esta condicion no se cumple
                    header('Location: index.php?url=producciones');
                }
            }
            catch (Exception $e) {

                // registra el error en el log del servidor
                error_log('Error al registrar...' . $e->getMessage());
                
                // usa mensaje dinamico del modelo
                setError('Error en operacion.');
            }

            // redirige ai se cumple todo
            header('Location: index.php?url=producciones');
            
            // detiene la ejecucion del script
            exit();
        }

        //muestra un modal de info que dice acceso no permitido
        header("Location: index.php?url=403");

        // termina el script
        exit();
    }
?>
