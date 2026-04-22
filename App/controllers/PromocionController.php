<?php
    // llama el archivo del modelo
    require_once 'app/models/PromocionModel.php';
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
        $modelo = new Promocion();
        try {
            $resultado = $modelo->manejarAccion('consultar', null);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                $promociones = $resultado['data'];
                require_once 'app/views/promocionesView.php';
                exit();
            } else {
                $promociones = [];
                require_once 'app/views/promocionesView.php';
                exit();
            }
        } catch (Exception $e) {
            error_log('Error al consultar promociones...' . $e->getMessage());
            setError('Error en operacion.');
            $promociones = [];
            require_once 'app/views/promocionesView.php';
            exit();
        }
    }

    // funcion para guardar datos
    function Agregar() {
        $modelo = new Promocion();

        // obtiene y sanitiza los valores
        $codigo = filter_var($_POST['codigoPromocion'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $nombre = filter_var($_POST['nombrePromocion'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $descripcion = filter_var($_POST['descripcionPromocion'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $tipo = filter_var($_POST['tipoPromocion'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $valor = filter_var($_POST['valorPromocion'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $fecha_inicio = filter_var($_POST['fechaInicio'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $fecha_fin = filter_var($_POST['fechaFin'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $estado = isset($_POST['estadoPromocion']) ? '1' : '0';

        // valida si los campos no estan vacios
        if (empty($codigo) || empty($nombre) || empty($descripcion) || empty($tipo) || empty($valor) || empty($fecha_inicio) || empty($fecha_fin)) {
            setError('Todos los campos son requeridos. No se puede enviar vacíos.');
            header('Location: index.php?url=promociones');
            exit();
        }

        // se arma el json
        $promocion_json = json_encode([
            'codigo' => $codigo,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'tipo' => $tipo,
            'valor' => $valor,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'estado' => $estado
        ]);

        try {
            $resultado = $modelo->manejarAccion('agregar', $promocion_json);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al registrar promoción...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=promociones');
        exit();
    }

    // funcion para modificar datos
    function Actualizar() {
        $modelo = new Promocion();

        // obtiene y sanitiza los valores
        $id = $_POST['id'] ?? '';
        $codigo = filter_var($_POST['codigoPromocion'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $nombre = filter_var($_POST['nombrePromocion'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $descripcion = filter_var($_POST['descripcionPromocion'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $tipo = filter_var($_POST['tipoPromocion'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $valor = filter_var($_POST['valorPromocion'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $fecha_inicio = filter_var($_POST['fechaInicio'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $fecha_fin = filter_var($_POST['fechaFin'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $estado = isset($_POST['estadoPromocion']) ? '1' : '0';

        // valida si los campos no estan vacios
        if (empty($id) || empty($codigo) || empty($nombre) || empty($descripcion) || empty($tipo) || empty($valor) || empty($fecha_inicio) || empty($fecha_fin)) {
            setError('Todos los campos son requeridos. No se puede enviar vacíos.');
            header('Location: index.php?url=promociones');
            exit();
        }

        // se arma el json
        $promocion_json = json_encode([
            'id' => $id,
            'codigo' => $codigo,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'tipo' => $tipo,
            'valor' => $valor,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'estado' => $estado
        ]);

        try {
            $resultado = $modelo->manejarAccion('modificar', $promocion_json);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al actualizar promoción...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=promociones');
        exit();
    }

    // function para obtener un dato
    function Obtener() {
        $modelo = new Promocion();
        $id = $_GET['ID'] ?? '';

        if (empty($id)) {
            setError('ID vacío.');
            header('Location: index.php?url=promociones');
            exit();
        }

        $promocion_json = json_encode(['id' => $id]);
        $resultado = $modelo->manejarAccion('obtener', $promocion_json);

        if (isset($resultado['data'])) {
            echo json_encode($resultado['data']);
        } else {
            echo json_encode(['error' => 'No se encontró la promoción']);
        }
        exit();
    }

    // funcion para eliminar un dato
    function Eliminar() {
        $modelo = new Promocion();
        $id = $_GET['ID'] ?? '';

        if (empty($id)) {
            setError('ID vacío.');
            header('Location: index.php?url=promociones');
            exit();
        }

        $promocion_json = json_encode(['id' => $id]);

        try {
            $resultado = $modelo->manejarAccion('eliminar', $promocion_json);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al eliminar promoción...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=promociones');
        exit();
    }

    // funcion para cambiar estado
    function CambiarEstado() {
        $modelo = new Promocion();
        $id = $_POST['id'] ?? '';
        $nuevo_estado = $_POST['nuevo_estado'] ?? '';

        if (empty($id) || $nuevo_estado === '') {
            setError('Datos incompletos.');
            header('Location: index.php?url=promociones');
            exit();
        }

        $promocion_json = [
            'id' => $id,
            'nuevo_estado' => $nuevo_estado
        ];

        try {
            $resultado = $modelo->manejarAccion('cambiar_estado', $promocion_json);
            if (isset($resultado['status']) && $resultado['status'] === true) {
                setSuccess($resultado['msj']);
            } else {
                setError($resultado['msj']);
            }
        } catch (Exception $e) {
            error_log('Error al cambiar estado de promoción...' . $e->getMessage());
            setError('Error en operacion.');
        }

        header('Location: index.php?url=promociones');
        exit();
    }
?>
