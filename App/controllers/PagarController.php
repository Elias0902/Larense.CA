<?php
    // llama el archivo del modelo
    require_once 'app/models/PagarModel.php';
    require_once 'app/models/ProveedorModel.php';
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

        case 'registrar_pago':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                RegistrarPago();
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
        $modelo = new CuentaPagar();
        $proveedor_modelo = new Proveedor();

        try {
            // Obtener cuentas
            $resultado = $modelo->manejarAccion('consultar', null);
            $cuentas = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];

            // Obtener proveedores para el select
            $proveedores_resultado = $proveedor_modelo->manejarAccion('consultar', null);
            $proveedores = (isset($proveedores_resultado['status']) && $proveedores_resultado['status'] === true) ? $proveedores_resultado['data'] : [];

            require_once 'app/views/pagarView.php';
            exit();
        } catch (Exception $e) {
            error_log('Error al consultar cuentas por pagar...' . $e->getMessage());
            setError('Error en operacion.');
            $cuentas = [];
            $proveedores = [];
            require_once 'app/views/pagarView.php';
            exit();
        }
    }

    // funcion para guardar datos
    function Agregar() {
        $modelo = new CuentaPagar();

        // obtiene y sanitiza los valores
        $proveedor_id = filter_var($_POST['proveedorId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $compra_id = filter_var($_POST['compraId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $monto = filter_var($_POST['montoCuenta'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $saldo = filter_var($_POST['saldoCuenta'] ?? $monto, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $fecha_emision = filter_var($_POST['fechaEmision'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $fecha_vencimiento = filter_var($_POST['fechaVencimiento'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $descripcion = filter_var($_POST['descripcionCuenta'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $estado = filter_var($_POST['estadoCuenta'] ?? 'pendiente', FILTER_SANITIZE_SPECIAL_CHARS);

        // valida campos requeridos
        if (empty($proveedor_id) || empty($monto) || empty($fecha_emision) || empty($fecha_vencimiento) || empty($descripcion)) {
            setError('Los campos Proveedor, Monto, Fechas y Descripción son requeridos.');
            header('Location: index.php?url=pagar');
            exit();
        }

        // se arma el json
        $cuenta_json = json_encode([
            'proveedor_id' => $proveedor_id,
            'compra_id' => $compra_id,
            'monto' => $monto,
            'saldo' => $saldo,
            'fecha_emision' => $fecha_emision,
            'fecha_vencimiento' => $fecha_vencimiento,
            'descripcion' => $descripcion,
            'estado' => $estado
        ]);

        try {
            $resultado = $modelo->manejarAccion('agregar', $cuenta_json);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al registrar cuenta...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=pagar');
        exit();
    }

    // funcion para modificar datos
    function Actualizar() {
        $modelo = new CuentaPagar();

        $id = $_POST['id'] ?? '';
        $proveedor_id = filter_var($_POST['proveedorId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $compra_id = filter_var($_POST['compraId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $monto = filter_var($_POST['montoCuenta'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $saldo = filter_var($_POST['saldoCuenta'] ?? $monto, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $fecha_emision = filter_var($_POST['fechaEmision'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $fecha_vencimiento = filter_var($_POST['fechaVencimiento'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $descripcion = filter_var($_POST['descripcionCuenta'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $estado = filter_var($_POST['estadoCuenta'] ?? 'pendiente', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($id) || empty($proveedor_id) || empty($monto) || empty($fecha_emision) || empty($fecha_vencimiento) || empty($descripcion)) {
            setError('Los campos requeridos no pueden estar vacíos.');
            header('Location: index.php?url=pagar');
            exit();
        }

        $cuenta_json = json_encode([
            'id' => $id,
            'proveedor_id' => $proveedor_id,
            'compra_id' => $compra_id,
            'monto' => $monto,
            'saldo' => $saldo,
            'fecha_emision' => $fecha_emision,
            'fecha_vencimiento' => $fecha_vencimiento,
            'descripcion' => $descripcion,
            'estado' => $estado
        ]);

        try {
            $resultado = $modelo->manejarAccion('modificar', $cuenta_json);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al actualizar cuenta...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=pagar');
        exit();
    }

    // function para obtener un dato
    function Obtener() {
        $modelo = new CuentaPagar();
        $id = $_GET['ID'] ?? '';

        if (empty($id)) {
            setError('ID vacío.');
            header('Location: index.php?url=pagar');
            exit();
        }

        $cuenta_json = json_encode(['id' => $id]);
        $resultado = $modelo->manejarAccion('obtener', $cuenta_json);

        if (isset($resultado['data'])) {
            echo json_encode($resultado['data']);
        } else {
            echo json_encode(['error' => 'No se encontró la cuenta']);
        }
        exit();
    }

    // funcion para eliminar
    function Eliminar() {
        $modelo = new CuentaPagar();
        $id = $_GET['ID'] ?? '';

        if (empty($id)) {
            setError('ID vacío.');
            header('Location: index.php?url=pagar');
            exit();
        }

        $cuenta_json = json_encode(['id' => $id]);

        try {
            $resultado = $modelo->manejarAccion('eliminar', $cuenta_json);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al eliminar cuenta...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=pagar');
        exit();
    }

    // funcion para registrar pago
    function RegistrarPago() {
        $modelo = new CuentaPagar();
        $id = $_POST['id'] ?? '';
        $monto_pago = filter_var($_POST['monto_pago'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        if (empty($id) || empty($monto_pago) || $monto_pago <= 0) {
            setError('ID y monto de pago son requeridos.');
            header('Location: index.php?url=pagar');
            exit();
        }

        $cuenta_json = [
            'id' => $id,
            'monto_pago' => $monto_pago
        ];

        try {
            $resultado = $modelo->manejarAccion('registrar_pago', $cuenta_json);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al registrar pago...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=pagar');
        exit();
    }

    // funcion para cambiar estado
    function CambiarEstado() {
        $modelo = new CuentaPagar();
        $id = $_POST['id'] ?? '';
        $nuevo_estado = $_POST['nuevo_estado'] ?? '';

        if (empty($id) || $nuevo_estado === '') {
            setError('Datos incompletos.');
            header('Location: index.php?url=pagar');
            exit();
        }

        $cuenta_json = [
            'id' => $id,
            'nuevo_estado' => $nuevo_estado
        ];

        try {
            $resultado = $modelo->manejarAccion('cambiar_estado', $cuenta_json);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al cambiar estado...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=pagar');
        exit();
    }
?>
