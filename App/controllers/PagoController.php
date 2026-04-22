<?php
    // llama el archivo del modelo
    require_once 'app/models/PagoModel.php';
    require_once 'app/models/ClienteModel.php';
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

        default:
            Consultar();
        break;
    }

    // funcion para consultar datos
    function Consultar() {
        $modelo = new Pago();
        $cliente_modelo = new Cliente();

        try {
            // Obtener pagos
            $resultado = $modelo->manejarAccion('consultar', null);
            $pagos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];

            // Obtener clientes para el select
            $clientes_resultado = $cliente_modelo->manejarAccion('consultar', null);
            $clientes = (isset($clientes_resultado['status']) && $clientes_resultado['status'] === true) ? $clientes_resultado['data'] : [];

            require_once 'app/views/pagosView.php';
            exit();
        } catch (Exception $e) {
            error_log('Error al consultar pagos...' . $e->getMessage());
            setError('Error en operacion.');
            $pagos = [];
            $clientes = [];
            require_once 'app/views/pagosView.php';
            exit();
        }
    }

    // funcion para guardar datos
    function Agregar() {
        $modelo = new Pago();

        // obtiene y sanitiza los valores
        $pedido_id = filter_var($_POST['pedidoId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $cliente_id = filter_var($_POST['clienteId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $monto = filter_var($_POST['montoPago'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $metodo = filter_var($_POST['metodoPago'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $referencia = filter_var($_POST['referenciaPago'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $fecha = filter_var($_POST['fechaPago'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $observaciones = filter_var($_POST['observacionesPago'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $estado = isset($_POST['estadoPago']) ? 'completado' : 'pendiente';

        // valida si los campos requeridos no estan vacios
        if (empty($cliente_id) || empty($monto) || empty($metodo) || empty($fecha)) {
            setError('Los campos Cliente, Monto, Método de pago y Fecha son requeridos.');
            header('Location: index.php?url=pagos');
            exit();
        }

        // se arma el json
        $pago_json = json_encode([
            'pedido_id' => $pedido_id,
            'cliente_id' => $cliente_id,
            'monto' => $monto,
            'metodo' => $metodo,
            'referencia' => $referencia,
            'fecha' => $fecha,
            'observaciones' => $observaciones,
            'estado' => $estado
        ]);

        try {
            $resultado = $modelo->manejarAccion('agregar', $pago_json);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al registrar pago...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=pagos');
        exit();
    }

    // funcion para modificar datos
    function Actualizar() {
        $modelo = new Pago();

        // obtiene y sanitiza los valores
        $id = $_POST['id'] ?? '';
        $pedido_id = filter_var($_POST['pedidoId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $cliente_id = filter_var($_POST['clienteId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $monto = filter_var($_POST['montoPago'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $metodo = filter_var($_POST['metodoPago'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $referencia = filter_var($_POST['referenciaPago'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $fecha = filter_var($_POST['fechaPago'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $observaciones = filter_var($_POST['observacionesPago'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $estado = isset($_POST['estadoPago']) ? 'completado' : 'pendiente';

        // valida si los campos requeridos no estan vacios
        if (empty($id) || empty($cliente_id) || empty($monto) || empty($metodo) || empty($fecha)) {
            setError('Los campos Cliente, Monto, Método de pago y Fecha son requeridos.');
            header('Location: index.php?url=pagos');
            exit();
        }

        // se arma el json
        $pago_json = json_encode([
            'id' => $id,
            'pedido_id' => $pedido_id,
            'cliente_id' => $cliente_id,
            'monto' => $monto,
            'metodo' => $metodo,
            'referencia' => $referencia,
            'fecha' => $fecha,
            'observaciones' => $observaciones,
            'estado' => $estado
        ]);

        try {
            $resultado = $modelo->manejarAccion('modificar', $pago_json);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al actualizar pago...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=pagos');
        exit();
    }

    // function para obtener un dato
    function Obtener() {
        $modelo = new Pago();
        $id = $_GET['ID'] ?? '';

        if (empty($id)) {
            setError('ID vacío.');
            header('Location: index.php?url=pagos');
            exit();
        }

        $pago_json = json_encode(['id' => $id]);
        $resultado = $modelo->manejarAccion('obtener', $pago_json);

        if (isset($resultado['data'])) {
            echo json_encode($resultado['data']);
        } else {
            echo json_encode(['error' => 'No se encontró el pago']);
        }
        exit();
    }

    // funcion para eliminar un dato
    function Eliminar() {
        $modelo = new Pago();
        $id = $_GET['ID'] ?? '';

        if (empty($id)) {
            setError('ID vacío.');
            header('Location: index.php?url=pagos');
            exit();
        }

        $pago_json = json_encode(['id' => $id]);

        try {
            $resultado = $modelo->manejarAccion('eliminar', $pago_json);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al eliminar pago...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=pagos');
        exit();
    }

    // funcion para cambiar estado
    function CambiarEstado() {
        $modelo = new Pago();
        $id = $_POST['id'] ?? '';
        $nuevo_estado = $_POST['nuevo_estado'] ?? '';

        if (empty($id) || $nuevo_estado === '') {
            setError('Datos incompletos.');
            header('Location: index.php?url=pagos');
            exit();
        }

        $pago_json = [
            'id' => $id,
            'nuevo_estado' => $nuevo_estado
        ];

        try {
            $resultado = $modelo->manejarAccion('cambiar_estado', $pago_json);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al cambiar estado del pago...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=pagos');
        exit();
    }
?>
