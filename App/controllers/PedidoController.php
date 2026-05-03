<?php
    // llama el archivo del modelo
    require_once 'app/models/PedidoModel.php';
    require_once 'app/models/ClienteModel.php';
    require_once 'app/models/PromocionModel.php';
    require_once 'app/models/ProductoModel.php';
    require_once 'app/models/PermisoModel.php';

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

        case 'cambiar_estado':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                CambiarEstado();
            }
        break;

        case 'obtener_productos':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                ObtenerProductos();
            }
        break;

        default:
            Consultar();
        break;
    }

    // funcion para consultar datos
    function Consultar() {
        $modelo = new Pedido();
        $cliente_modelo = new Cliente();
        $promocion_modelo = new Promocion();
        $producto_modelo = new Producto();

        try {
            // Obtener pedidos
            $resultado = $modelo->manejarAccion('consultar', null);
            $pedidos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];

            // Obtener clientes para el select
            $clientes_resultado = $cliente_modelo->manejarAccion('consultar', null);
            $clientes = (isset($clientes_resultado['status']) && $clientes_resultado['status'] === true) ? $clientes_resultado['data'] : [];

            // Obtener promociones activas para el select
            $promociones_resultado = $promocion_modelo->manejarAccion('consultar', null);
            $promociones = (isset($promociones_resultado['status']) && $promociones_resultado['status'] === true) ? $promociones_resultado['data'] : [];

            // Obtener productos para el select
            $productos_resultado = $producto_modelo->manejarAccion('consultar', null);
            $productos = (isset($productos_resultado['status']) && $productos_resultado['status'] === true) ? $productos_resultado['data'] : [];

            require_once 'app/views/pedidosView.php';
            exit();
        } catch (Exception $e) {
            error_log('Error al consultar pedidos...' . $e->getMessage());
            setError('Error en operacion.');
            $pedidos = [];
            $clientes = [];
            $promociones = [];
            $productos = [];
            require_once 'app/views/pedidosView.php';
            exit();
        }
    }

    // funcion para guardar datos
    function Agregar() {
        $modelo = new Pedido();

        // obtiene y sanitiza los valores
        $cliente_id = filter_var($_POST['clienteId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $fecha = filter_var($_POST['fechaPedido'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $total = filter_var($_POST['totalPedido'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $estado = filter_var($_POST['estadoPedido'] ?? 'pendiente', FILTER_SANITIZE_SPECIAL_CHARS);
        $direccion = filter_var($_POST['direccionPedido'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $telefono = filter_var($_POST['telefonoPedido'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $observaciones = filter_var($_POST['observacionesPedido'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $promocion_id = filter_var($_POST['promocionId'] ?? '', FILTER_SANITIZE_NUMBER_INT);

        // obtiene los productos seleccionados
        $productos = isset($_POST['productos']) ? $_POST['productos'] : [];

        // valida si los campos requeridos no estan vacios
        if (empty($cliente_id) || empty($fecha) || empty($total)) {
            setError('Los campos Cliente, Fecha y Total son requeridos.');
            header('Location: index.php?url=pedidos');
            exit();
        }

        // se arma el json
        $pedido_json = [
            'cliente_id' => $cliente_id,
            'fecha' => $fecha,
            'total' => $total,
            'estado' => $estado,
            'direccion_entrega' => $direccion,
            'telefono' => $telefono,
            'observaciones' => $observaciones,
            'promocion_id' => $promocion_id
        ];

        // agrega los productos si existen (con cantidad y precio)
        if (!empty($productos)) {
            $productos_con_detalle = [];
            foreach ($productos as $id_producto) {
                $productos_con_detalle[] = [
                    'id_producto' => $id_producto,
                    'cantidad' => 1, // Por defecto 1, se puede ajustar según necesidad
                    'precio_unitario' => 0 // Se puede obtener del producto si es necesario
                ];
            }
            $pedido_json['productos'] = $productos_con_detalle;
        }

        try {
            $resultado = $modelo->manejarAccion('agregar', json_encode($pedido_json));
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al registrar pedido...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=pedidos');
        exit();
    }

    // funcion para modificar datos
    function Actualizar() {
        $modelo = new Pedido();

        // obtiene y sanitiza los valores
        $id = $_POST['id'] ?? '';
        $cliente_id = filter_var($_POST['clienteId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $fecha = filter_var($_POST['fechaPedido'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $total = filter_var($_POST['totalPedido'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $estado = filter_var($_POST['estadoPedido'] ?? 'pendiente', FILTER_SANITIZE_SPECIAL_CHARS);
        $direccion = filter_var($_POST['direccionPedido'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $telefono = filter_var($_POST['telefonoPedido'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $observaciones = filter_var($_POST['observacionesPedido'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $promocion_id = filter_var($_POST['promocionId'] ?? '', FILTER_SANITIZE_NUMBER_INT);

        // obtiene los productos seleccionados
        $productos = isset($_POST['productos']) ? $_POST['productos'] : [];

        // valida si los campos requeridos no estan vacios
        if (empty($id) || empty($cliente_id) || empty($fecha) || empty($total)) {
            setError('Los campos Cliente, Fecha y Total son requeridos.');
            header('Location: index.php?url=pedidos');
            exit();
        }

        // se arma el json
        $pedido_json = [
            'id' => $id,
            'cliente_id' => $cliente_id,
            'fecha' => $fecha,
            'total' => $total,
            'estado' => $estado,
            'direccion_entrega' => $direccion,
            'telefono' => $telefono,
            'observaciones' => $observaciones,
            'promocion_id' => $promocion_id
        ];

        // agrega los productos si existen (con cantidad y precio)
        if (!empty($productos)) {
            $productos_con_detalle = [];
            foreach ($productos as $id_producto) {
                $productos_con_detalle[] = [
                    'id_producto' => $id_producto,
                    'cantidad' => 1, // Por defecto 1, se puede ajustar según necesidad
                    'precio_unitario' => 0 // Se puede obtener del producto si es necesario
                ];
            }
            $pedido_json['productos'] = $productos_con_detalle;
        }

        try {
            $resultado = $modelo->manejarAccion('modificar', json_encode($pedido_json));
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al actualizar pedido...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=pedidos');
        exit();
    }

    // function para obtener un dato
    function Obtener() {
        $modelo = new Pedido();
        $id = $_GET['ID'] ?? '';

        if (empty($id)) {
            setError('ID vacío.');
            header('Location: index.php?url=pedidos');
            exit();
        }

        $pedido_json = json_encode(['id' => $id]);
        $resultado = $modelo->manejarAccion('obtener', $pedido_json);

        if (isset($resultado['data'])) {
            echo json_encode($resultado['data']);
        } else {
            echo json_encode(['error' => 'No se encontró el pedido']);
        }
        exit();
    }

    // funcion para eliminar un dato
    function Eliminar() {
        $modelo = new Pedido();
        $id = $_GET['ID'] ?? '';

        if (empty($id)) {
            setError('ID vacío.');
            header('Location: index.php?url=pedidos');
            exit();
        }

        $pedido_json = json_encode(['id' => $id]);

        try {
            $resultado = $modelo->manejarAccion('eliminar', $pedido_json);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al eliminar pedido...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=pedidos');
        exit();
    }

    // funcion para cambiar estado
    function CambiarEstado() {
        $modelo = new Pedido();
        $id = $_POST['id'] ?? '';
        $nuevo_estado = $_POST['nuevo_estado'] ?? '';

        if (empty($id) || $nuevo_estado === '') {
            setError('Datos incompletos.');
            header('Location: index.php?url=pedidos');
            exit();
        }

        $pedido_json = [
            'id' => $id,
            'nuevo_estado' => $nuevo_estado
        ];

        try {
            $resultado = $modelo->manejarAccion('cambiar_estado', $pedido_json);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al cambiar estado del pedido...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=pedidos');
        exit();
    }

    // function para obtener productos de un pedido
    function ObtenerProductos() {
        $modelo = new Pedido();
        $id = $_GET['ID'] ?? '';

        if (empty($id)) {
            echo json_encode(['error' => 'ID vacío']);
            exit();
        }

        $pedido_json = json_encode(['id' => $id]);
        $resultado = $modelo->manejarAccion('obtener_productos', $pedido_json);

        if (isset($resultado['data'])) {
            echo json_encode($resultado['data']);
        } else {
            echo json_encode([]);
        }
        exit();
    }
?>
