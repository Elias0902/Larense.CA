<?php
    // llama el archivo del modelo
    require_once 'app/models/CobrarModel.php';
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

        // instacia el modelo
        $modelo = new CuentaCobrar();
        $cliente = new Cliente();
        $permiso = new Permiso();
        $bitacora = new Bitacora();
        
        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Cuentas por Cobrar',
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

                // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                // primer para metro la accion y luego el objeto usuario_json
                $resultado = $modelo->manejarAccion('consultar', null);

                // valida si exixtes el staus del resultado y si es true 
                if (isset($resultado['status']) && $resultado['status'] === true) {

                    // usa mensaje dinamico del modelo
                    //setSuccess($resultado['msj']);

                    // extrae los datos
                    $cuentasCobrar = $resultado['data'];

                    // extrae cliente
                    $clientes = $cliente->manejarAccion('consultar', null)['data'];

                    // extrae los metodo de pagos
                    $metodos = $modelo->manejarAccion('consultar_metodo', null)['data'];


                    // se arma el json de bitacora
                    $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Cuentas por Cobrar',
                        'accion' => 'Consultar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha Consultado los datos en dashboard de las Cuentas por Cobrar' . ' ' . 'CT-00' . 'en el sistema.',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                    //carga la vista
                    require_once 'app/views/cobrarView.php';

                    // termina el script
                    exit();
                }
                else {
                                
                    // usa mensaje dinamico del modelo
                    setError($resultado['msj']);

                    //carga la vista
                    require_once 'app/views/cobrarView.php';

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
    //muestra un modal de info que dice acceso no permitido
    setError("Error acceso no permitido");

    //redirect
    header('Location: index.php?url=403');
                
    // termina el script
    exit();
    
}

    // funcion para guardar datos
    function Agregar() {
        $modelo = new CuentaCobrar();

        // obtiene y sanitiza los valores
        $cliente_id = filter_var($_POST['clienteId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $pedido_id = filter_var($_POST['pedidoId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $monto = filter_var($_POST['montoCuenta'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $saldo = filter_var($_POST['saldoCuenta'] ?? $monto, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $fecha_emision = filter_var($_POST['fechaEmision'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $fecha_vencimiento = filter_var($_POST['fechaVencimiento'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $descripcion = filter_var($_POST['descripcionCuenta'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $estado = filter_var($_POST['estadoCuenta'] ?? 'pendiente', FILTER_SANITIZE_SPECIAL_CHARS);

        // valida campos requeridos
        if (empty($cliente_id) || empty($monto) || empty($fecha_emision) || empty($fecha_vencimiento) || empty($descripcion)) {
            setError('Los campos Cliente, Monto, Fechas y Descripción son requeridos.');
            header('Location: index.php?url=cobrar');
            exit();
        }

        // se arma el json
        $cuenta_json = json_encode([
            'cliente_id' => $cliente_id,
            'pedido_id' => $pedido_id,
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

        header('Location: index.php?url=cobrar');
        exit();
    }

    // funcion para modificar datos
    function Actualizar() {
        $modelo = new CuentaCobrar();

        $id = $_POST['id'] ?? '';
        $cliente_id = filter_var($_POST['clienteId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $pedido_id = filter_var($_POST['pedidoId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $monto = filter_var($_POST['montoCuenta'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $saldo = filter_var($_POST['saldoCuenta'] ?? $monto, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $fecha_emision = filter_var($_POST['fechaEmision'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $fecha_vencimiento = filter_var($_POST['fechaVencimiento'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $descripcion = filter_var($_POST['descripcionCuenta'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $estado = filter_var($_POST['estadoCuenta'] ?? 'pendiente', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($id) || empty($cliente_id) || empty($monto) || empty($fecha_emision) || empty($fecha_vencimiento) || empty($descripcion)) {
            setError('Los campos requeridos no pueden estar vacíos.');
            header('Location: index.php?url=cobrar');
            exit();
        }

        $cuenta_json = json_encode([
            'id' => $id,
            'cliente_id' => $cliente_id,
            'pedido_id' => $pedido_id,
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

        header('Location: index.php?url=cobrar');
        exit();
    }

    // function para obtener un dato
    function Obtener() {

        // instancia el modelo
        $modelo = new CuentaCobrar();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se obtien el valor
        $id = $_GET['ID'] ?? '';

        // valida si el valor no esta vacio
        if (empty($id)) {

            //msj de error 
            setError('ID vacío.');

            // redirige
            header('Location: index.php?url=cobrar');
            
            // termina el script
            exit();
        }

        // se arma el json
        $cuenta_json = json_encode(['id' => $id]);
        
        // llama la funcion obtener del modelo
        $resultado = $modelo->manejarAccion('obtener', $cuenta_json);

        // se extrae dato de la cuenta
        $cuentaCobrar = $resultado['data'];

        // se extrae dartos para la bitacora
        $data = $resultado['data_bitacora'];

        // se arma el json de bitacora
        $bitacora_json = json_encode([
            'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
            'modulo' => 'Cuentas por Cobrar',
            'accion' => 'Obtener',
            'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                'ha obtenido los datos de la Cuentas por Cobrar' . ' ' . 
                'CT-00' . ' ' . $data['id_cuenta_x_cobrar'] . ' ' . 
                'cliente' . ' ' . $data['nombre_cliente'] . ' ' . 
                'monto' . ' ' . $data['monto_total'] . ' ' .  
                'en el sistema.',
            'fecha' => $fecha
        ]);

        //realiza la insercion de la bitacora
        $bitacora->manejarAccion('agregar', $bitacora_json);

        echo json_encode($cuentaCobrar);
    }

    // funcion para eliminar
    function Eliminar() {
        $modelo = new CuentaCobrar();
        $id = $_GET['ID'] ?? '';

        if (empty($id)) {
            setError('ID vacío.');
            header('Location: index.php?url=cobrar');
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

        header('Location: index.php?url=cobrar');
        exit();
    }

    // funcion para registrar pago
    function RegistrarPago() {

        // instacia el modelo
        $modelo = new CuentaCobrar();
        $permiso = new Permiso();
        $bitacora = new Bitacora();
        
        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Cuentas por Cobrar',
            'permiso' => 'Agregar',
           'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] === true) {

            // obtiene los datos
            $id = $_POST['id'] ?? '';
            $cliente = filter_var($_POST['id_cliente'] ?? '');
            $monto_pago = filter_var($_POST['montoPago'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $fechaPago = filter_var($_POST['fechaPago'] ?? '');
            $referencia = filter_var($_POST['nroReferencia'] ?? '');
            $concepto = filter_var($_POST['concepto'] ?? '');
            $metodo = filter_var($_POST['metodoPago'] ?? '');

            // valida que ningun dato este vacio
            if (empty($id) || empty($cliente) || empty($monto_pago) || empty($fechaPago) || empty($referencia) || empty($concepto) || empty($metodo)) {
                
                // msj de error
                setError('Todos los campos son requeridos.');
                
                // redirige
                header('Location: index.php?url=cobrar');
                
                // termina el script
                exit();
            }

            // se arma el json
            $cuenta_json = [
                'id' => $id,
                'cliente' => $cliente,
                'monto_pago' => $monto_pago,
                'fecha' => $fechaPago,
                'referencia' => $referencia,
                'concepto' => $concepto,
                'metodo' => $metodo,
            ];
            //print_r($cuenta_json);

            try {

                // llama al metodo registrar pago del modelo
                $resultado = $modelo->manejarAccion('registrar_pago', $cuenta_json);

                // valida si el staus existe y si es true
                if (isset($resultado['status']) && $resultado['status'] === true) {

                    // msj de exito
                    setSuccess($resultado['msj']);

                    // se arma el json de bitacora
                    $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Cuentas por Cobrar',
                        'accion' => 'Agregar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha registrado un pago de la Cuentas por Cobrar' . ' ' . 
                            'CT-00' . ' ' . $id . ' ' . 
                            'cliente' . ' ' . $cliente . ' ' . 
                            'monto' . ' ' . $monto_pago . ' ' .  
                            'fecha' . ' ' . $fechaPago . ' ' .  
                            'referencia' . ' ' . $referencia . ' ' .  
                            'concepto' . ' ' . $concepto . ' ' .  
                            'metodo' . ' ' . $metodo . ' ' .  
                            'en el sistema.',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                } else {

                    // msj de error
                    setError($resultado['msj']);

                }
            } catch (Exception $e) {

                // error log
                error_log('Error al registrar pago...' . $e->getMessage());

                // msj de error generico
                setError('Error en operacion.');
            }
        
        //redirige
        header('Location: index.php?url=cobrar');

        // termina el script
        exit();
    }

    //redirige
    header('Location: index.php?url=cobrar');

    // termina el script
    exit();
}

    // funcion para cambiar estado
    function CambiarEstado() {
        $modelo = new CuentaCobrar();
        $id = $_POST['id'] ?? '';
        $nuevo_estado = $_POST['nuevo_estado'] ?? '';

        if (empty($id) || $nuevo_estado === '') {
            setError('Datos incompletos.');
            header('Location: index.php?url=cobrar');
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

        header('Location: index.php?url=cobrar');
        exit();
    }
?>
