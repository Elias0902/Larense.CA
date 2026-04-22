<?php
    // llama el archivo del modelo
    require_once 'app/models/EntregaModel.php';
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

        case 'confirmar_entrega':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                ConfirmarEntrega();
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
        $modelo = new Entrega();
        $cliente_modelo = new Cliente();

        try {
            // Obtener entregas
            $resultado = $modelo->manejarAccion('consultar', null);
            $entregas = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];

            // Obtener clientes para el select
            $clientes_resultado = $cliente_modelo->manejarAccion('consultar', null);
            $clientes = (isset($clientes_resultado['status']) && $clientes_resultado['status'] === true) ? $clientes_resultado['data'] : [];

            require_once 'app/views/entregasView.php';
            exit();
        } catch (Exception $e) {
            error_log('Error al consultar entregas...' . $e->getMessage());
            setError('Error en operacion.');
            $entregas = [];
            $clientes = [];
            require_once 'app/views/entregasView.php';
            exit();
        }
    }

    // funcion para guardar datos
    function Agregar() {
        $modelo = new Entrega();

        // obtiene y sanitiza los valores
        $pedido_id = filter_var($_POST['pedidoId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $cliente_id = filter_var($_POST['clienteId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $direccion = filter_var($_POST['direccionEntrega'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $telefono = filter_var($_POST['telefonoEntrega'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $fecha_programada = filter_var($_POST['fechaProgramada'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $repartidor = filter_var($_POST['repartidorEntrega'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $observaciones = filter_var($_POST['observacionesEntrega'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $estado = filter_var($_POST['estadoEntrega'] ?? 'pendiente', FILTER_SANITIZE_SPECIAL_CHARS);

        // valida si los campos requeridos no estan vacios
        if (empty($cliente_id) || empty($direccion) || empty($fecha_programada)) {
            setError('Los campos Cliente, Dirección y Fecha Programada son requeridos.');
            header('Location: index.php?url=entregas');
            exit();
        }

        // se arma el json
        $entrega_json = json_encode([
            'pedido_id' => $pedido_id,
            'cliente_id' => $cliente_id,
            'direccion' => $direccion,
            'telefono' => $telefono,
            'fecha_programada' => $fecha_programada,
            'repartidor' => $repartidor,
            'observaciones' => $observaciones,
            'estado' => $estado
        ]);

        try {
            $resultado = $modelo->manejarAccion('agregar', $entrega_json);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al registrar entrega...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=entregas');
        exit();
    }

    // funcion para modificar datos
    function Actualizar() {
        $modelo = new Entrega();

        // obtiene y sanitiza los valores
        $id = $_POST['id'] ?? '';
        $pedido_id = filter_var($_POST['pedidoId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $cliente_id = filter_var($_POST['clienteId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $direccion = filter_var($_POST['direccionEntrega'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $telefono = filter_var($_POST['telefonoEntrega'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $fecha_programada = filter_var($_POST['fechaProgramada'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $repartidor = filter_var($_POST['repartidorEntrega'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $observaciones = filter_var($_POST['observacionesEntrega'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $estado = filter_var($_POST['estadoEntrega'] ?? 'pendiente', FILTER_SANITIZE_SPECIAL_CHARS);

        // valida si los campos requeridos no estan vacios
        if (empty($id) || empty($cliente_id) || empty($direccion) || empty($fecha_programada)) {
            setError('Los campos Cliente, Dirección y Fecha Programada son requeridos.');
            header('Location: index.php?url=entregas');
            exit();
        }

        // se arma el json
        $entrega_json = json_encode([
            'id' => $id,
            'pedido_id' => $pedido_id,
            'cliente_id' => $cliente_id,
            'direccion' => $direccion,
            'telefono' => $telefono,
            'fecha_programada' => $fecha_programada,
            'repartidor' => $repartidor,
            'observaciones' => $observaciones,
            'estado' => $estado
        ]);

        try {
            $resultado = $modelo->manejarAccion('modificar', $entrega_json);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al actualizar entrega...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=entregas');
        exit();
    }

    // function para obtener un dato
    function Obtener() {
        $modelo = new Entrega();
        $id = $_GET['ID'] ?? '';

        if (empty($id)) {
            setError('ID vacío.');
            header('Location: index.php?url=entregas');
            exit();
        }

        $entrega_json = json_encode(['id' => $id]);
        $resultado = $modelo->manejarAccion('obtener', $entrega_json);

        if (isset($resultado['data'])) {
            echo json_encode($resultado['data']);
        } else {
            echo json_encode(['error' => 'No se encontró la entrega']);
        }
        exit();
    }

    // funcion para eliminar un dato
    function Eliminar() {
        $modelo = new Entrega();
        $id = $_GET['ID'] ?? '';

        if (empty($id)) {
            setError('ID vacío.');
            header('Location: index.php?url=entregas');
            exit();
        }

        $entrega_json = json_encode(['id' => $id]);

        try {
            $resultado = $modelo->manejarAccion('eliminar', $entrega_json);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al eliminar entrega...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=entregas');
        exit();
    }

    // funcion para confirmar entrega
    function ConfirmarEntrega() {
        $modelo = new Entrega();
        $id = $_POST['id'] ?? '';

        if (empty($id)) {
            setError('ID vacío.');
            header('Location: index.php?url=entregas');
            exit();
        }

        $entrega_json = json_encode(['id' => $id]);

        try {
            $resultado = $modelo->manejarAccion('confirmar_entrega', $entrega_json);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al confirmar entrega...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=entregas');
        exit();
    }

    // funcion para cambiar estado
    function CambiarEstado() {
        $modelo = new Entrega();
        $id = $_POST['id'] ?? '';
        $nuevo_estado = $_POST['nuevo_estado'] ?? '';

        if (empty($id) || $nuevo_estado === '') {
            setError('Datos incompletos.');
            header('Location: index.php?url=entregas');
            exit();
        }

        $entrega_json = [
            'id' => $id,
            'nuevo_estado' => $nuevo_estado
        ];

        try {
            $resultado = $modelo->manejarAccion('cambiar_estado', $entrega_json);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al cambiar estado de entrega...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=entregas');
        exit();
    }
?>
