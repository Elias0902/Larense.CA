<?php
    // llama el archivo del modelo
    require_once 'app/models/ProduccionModel.php';
    require_once 'app/models/ProductoModel.php';

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

        try {
            // llama la funcion que maneja las acciones en el modelo
            $resultado = $modelo->manejarAccion('consultar', null);

            // valida si exixtes el staus del resultado y si es true
            if (isset($resultado['status']) && $resultado['status'] === true) {
                // extrae los datos de las producciones
                $producciones = $resultado['data'];

                // extrae los datos de los productos
                $productos = $producto->manejarAccion('consultar', null)['data'];
                $prod = $productos;

                //carga la vista
                require_once 'app/views/produccionesView.php';
                exit();
            }
            else {
                // usa mensaje dinamico del modelo
                setError($resultado['msj']);

                // extrae los datos de los productos para los selects
                $productos = $producto->manejarAccion('consultar', null)['data'];
                $prod = $productos;
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

    //funcion para guardar datos
    function Agregar() {
        // instacia el modelo
        $modelo = new Produccion();

        // obtiene y sinatiza los valores
        $producto_produccion = filter_var($_POST['productoProduccion'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $cantidad_produccion = filter_var($_POST['cantidadProduccion'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

        // valida si los campos no estan vacios
        if (empty($producto_produccion) || empty($cantidad_produccion)) {
            setError('Todos los campos son requeridos no se puede enviar vacios.');
            header('Location: index.php?url=producciones');
            exit();
        }

        // se arma el json
        $produccion_json = json_encode([
            'producto' => $producto_produccion,
            'cantidad' => $cantidad_produccion
        ]);

        try {
            // llama la funcion que maneja las acciones en el modelo
            $resultado = $modelo->manejarAccion('agregar', $produccion_json);

            // valida si exixtes el staus del resultado y si es true
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            }
            else {
                setError($resultado['msj']);
                header('Location: index.php?url=producciones');
            }
        }
        catch (Exception $e) {
            error_log('Error al registrar...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=producciones');
        exit();
    }

    //funcion para modificar datos
    function Actualizar() {
        // instacia el modelo
        $modelo = new Produccion();

        // obtiene y sinatiza los valores
        $id = $_POST['idEdit'];
        $producto_produccion = filter_var($_POST['productoProduccionEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $cantidad_produccion = filter_var($_POST['cantidadProduccionEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

        // valida si los campos no estan vacios
        if (empty($id) || empty($producto_produccion) || empty($cantidad_produccion)) {
            setError('Todos los campos son requeridos no se puede enviar vacios.');
            header('Location: index.php?url=producciones');
            exit();
        }

        // se arma el json
        $produccion_json = json_encode([
            'id' => $id,
            'producto' => $producto_produccion,
            'cantidad' => $cantidad_produccion
        ]);

        try {
            // llama la funcion que maneja las acciones en el modelo
            $resultado = $modelo->manejarAccion('modificar', $produccion_json);

            // valida si exixtes el staus del resultado y si es true
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            }
            else {
                setError($resultado['msj']);
                header('Location: index.php?url=producciones');
            }
        }
        catch (Exception $e) {
            error_log('Error al registrar...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=producciones');
        exit();
    }

    // function para obtener un dato
    function Obtener() {
        // instacia el modelo
        $modelo = new Produccion();

        $id = $_GET['ID'];

        // valida si los campos no estan vacios
        if (empty($id)) {
            setError('Todos los campos son requeridos no se puede enviar vacios.');
            header('Location: index.php?url=producciones');
            exit();
        }

        // se arma el json
        $produccion_json = json_encode([
            'id' => $id
        ]);

        $resultado = $modelo->manejarAccion('obtener', $produccion_json);
        $produccion = $resultado['data'];

        echo json_encode($produccion);
        exit();
    }

    // funcion para eliminar un dato
    function Eliminar() {
        // instacia el modelo
        $modelo = new Produccion();

        // obtiene y sinatiza los valores
        $id_produccion = $_GET['ID'];

        // valida si los campos no estan vacios
        if (empty($id_produccion)) {
            setError('ID vacio.');
            header('Location: index.php?url=producciones');
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
            }
            else {
                setError($resultado['msj']);
                header('Location: index.php?url=producciones');
            }
        }
        catch (Exception $e) {
            error_log('Error al registrar...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=producciones');
        exit();
    }
?>
