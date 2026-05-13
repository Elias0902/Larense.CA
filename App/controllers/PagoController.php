<?php
    // llama el archivo del modelo
    require_once 'app/models/PagoModel.php';
    require_once 'app/models/ClienteModel.php';
    require_once 'app/models/ProveedorModel.php';
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

        // instacia el modelo
        $modelo = new Pago();
        $permiso = new Permiso();
        $bitacora = new Bitacora();
        
        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');
        

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Pagos',
            'permiso' => 'Consultar',
           'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);


        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] === true) {
            
            // Ejecutar acción permitida

            // para manejo de errores
            try {
            
                // llama la funcion consultar del modelo
                $resultado = $modelo->manejarAccion('consultar', null);

                // valida si esxixte el status y si es true
                if (isset($resultado['status']) && $resultado['status'] === true) {

                    // usa mensaje dinamico del modelo
                    //setSuccess($resultado['msj']);

                    $pagos = $resultado['data'];

                    // se arma el json de bitacora
                    $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Pagos',
                        'accion' => 'Consultar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha Consultado los datos en dashboard de los Paogs' . ' ' . 'en el sistema.',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                    //carga la vista
                    require_once 'app/views/pagosView.php';

                    //termina el script
                    exit();
                }
                else{

                    // usa mensaje dinamico del modelo
                    setError($resultado['msj']);

                    //carga la vista
                    require_once 'app/views/pagosView.php';

                    //termina el script
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
    //muestra un modal de info que dice acceso no permitido
    setError("Error acceso no permitido");

    //redirect
    header('Location: index.php?url=403');
                
    // termina el script
    exit();
    
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
