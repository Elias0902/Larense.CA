<?php
    // llama el archivo del modelo
    require_once 'app/models/EntregaModel.php';
    require_once 'app/models/ClienteModel.php';
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
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json de permiso
        $permiso_json = json_encode([
            'modulo' => 'Entregas',
            'permiso' => 'Consultar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        // verifica si el usuario logueado tiene permiso
        if (isset($status['status']) && $status['status'] === true) {
            try {
                // Obtener entregas
                $resultado = $modelo->manejarAccion('consultar', null);
                $entregas = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];

                // Obtener clientes para el select
                $clientes_resultado = $cliente_modelo->manejarAccion('consultar', null);
                $clientes = (isset($clientes_resultado['status']) && $clientes_resultado['status'] === true) ? $clientes_resultado['data'] : [];

                // se arma el json de bitacora
                $bitacora_json = json_encode([
                    'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                    'modulo' => 'Entregas',
                    'accion' => 'Consultar',
                    'descripcion' => 'El usuario: ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ha Consultado los datos en el dashboard de entregas en el sistema',
                    'fecha' => $fecha
                ]);

                // realiza la insercion de la bitacora
                $bitacora->manejarAccion('agregar', $bitacora_json);

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

        setError("Error acceso no permitido");
        header('Location: index.php?url=403');
        exit();
    }

    // funcion para guardar datos
    function Agregar() {
        $modelo = new Entrega();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json de permiso
        $permiso_json = json_encode([
            'modulo' => 'Entregas',
            'permiso' => 'Agregar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        // verifica si el usuario logueado tiene permiso
        if (isset($status['status']) && $status['status'] === true) {
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

                    // se arma el json de bitacora
                    $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Entregas',
                        'accion' => 'Agregar',
                        'descripcion' => 'El usuario: ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ha registrado una nueva entrega para el cliente ID: ' . $cliente_id . ' con dirección: ' . $direccion . ' en el sistema.',
                        'fecha' => $fecha
                    ]);

                    // realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);
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

        setError("Error accion no permitida");
        header('Location: index.php?url=403');
        exit();
    }

    // funcion para modificar datos
    function Actualizar() {
        $modelo = new Entrega();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json de permiso
        $permiso_json = json_encode([
            'modulo' => 'Entregas',
            'permiso' => 'Modificar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        // verifica si el usuario logueado tiene permiso
        if (isset($status['status']) && $status['status'] === true) {
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

                    // se almacena para la bitacora
                    $data_bitacora = $resultado['data_bitacora'] ?? null;

                    // se arma el json de bitacora
                    $descripcion = 'El usuario: ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ha modificado la entrega ID: ' . $id;
                    if ($data_bitacora) {
                        $descripcion .= ' Por los siguientes datos nuevos: Cliente ID: ' . $cliente_id . ', Dirección: ' . $direccion . ', Estado: ' . $estado;
                    }

                    $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Entregas',
                        'accion' => 'Modificar',
                        'descripcion' => $descripcion,
                        'fecha' => $fecha
                    ]);

                    // realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);
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

        setError("Error accion no permitida");
        header('Location: index.php?url=403');
        exit();
    }

    // function para obtener un dato
    function Obtener() {
        $modelo = new Entrega();
        $bitacora = new Bitacora();

        $fecha = (new DateTime())->format('Y-m-d H:i:s');
        $id = $_GET['ID'] ?? '';

        if (empty($id)) {
            setError('ID vacío.');
            header('Location: index.php?url=entregas');
            exit();
        }

        $entrega_json = json_encode(['id' => $id]);
        $resultado = $modelo->manejarAccion('obtener', $entrega_json);

        if (isset($resultado['data'])) {
            // se almacena para la bitacora
            $data_bitacora = $resultado['data_bitacora'] ?? $resultado['data'];

            // se arma el json de bitacora
            $bitacora_json = json_encode([
                'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                'modulo' => 'Entregas',
                'accion' => 'Obtener',
                'descripcion' => 'El usuario: ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ha obtenido la entrega ID: ' . $id . ' en el sistema.',
                'fecha' => $fecha
            ]);

            // realiza la insercion de la bitacora
            $bitacora->manejarAccion('agregar', $bitacora_json);

            echo json_encode($resultado['data']);
        } else {
            echo json_encode(['error' => 'No se encontró la entrega']);
        }
        exit();
    }

    // funcion para eliminar un dato
    function Eliminar() {
        $modelo = new Entrega();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json de permiso
        $permiso_json = json_encode([
            'modulo' => 'Entregas',
            'permiso' => 'Eliminar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        // verifica si el usuario logueado tiene permiso
        if (isset($status['status']) && $status['status'] === true) {
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

                    // se almacena para la bitacora
                    $data_bitacora = $resultado['data_bitacora'] ?? null;

                    // se arma el json de bitacora
                    $descripcion = 'El usuario: ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ha eliminado la entrega ID: ' . $id;
                    if ($data_bitacora) {
                        $descripcion .= ' con dirección: ' . ($data_bitacora['direccion'] ?? 'N/A') . ' del sistema.';
                    }

                    $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Entregas',
                        'accion' => 'Eliminar',
                        'descripcion' => $descripcion,
                        'fecha' => $fecha
                    ]);

                    // realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);
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

        setError("Error accion no permitida");
        header('Location: index.php?url=403');
        exit();
    }

    // funcion para confirmar entrega
    function ConfirmarEntrega() {
        $modelo = new Entrega();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json de permiso
        $permiso_json = json_encode([
            'modulo' => 'Entregas',
            'permiso' => 'Modificar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        // verifica si el usuario logueado tiene permiso
        if (isset($status['status']) && $status['status'] === true) {
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

                    // se arma el json de bitacora
                    $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Entregas',
                        'accion' => 'Confirmar Entrega',
                        'descripcion' => 'El usuario: ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ha confirmado la entrega ID: ' . $id . ' en el sistema.',
                        'fecha' => $fecha
                    ]);

                    // realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);
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

        setError("Error accion no permitida");
        header('Location: index.php?url=403');
        exit();
    }

    // funcion para cambiar estado
    function CambiarEstado() {
        $modelo = new Entrega();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json de permiso
        $permiso_json = json_encode([
            'modulo' => 'Entregas',
            'permiso' => 'Modificar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        // verifica si el usuario logueado tiene permiso
        if (isset($status['status']) && $status['status'] === true) {
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

                    // se arma el json de bitacora
                    $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Entregas',
                        'accion' => 'Cambiar Estado',
                        'descripcion' => 'El usuario: ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ha cambiado el estado de la entrega ID: ' . $id . ' a: ' . $nuevo_estado . ' en el sistema.',
                        'fecha' => $fecha
                    ]);

                    // realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);
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

        setError("Error accion no permitida");
        header('Location: index.php?url=403');
        exit();
    }
?>
