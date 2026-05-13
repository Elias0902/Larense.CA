<?php
    // llama el archivo del modelo
    require_once 'app/models/PagarModel.php';
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

        case 'obtener':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                Obtener();
            }
        break;

        case 'registrar_pago':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                RegistrarPago();
            }
        break;

        default:
            Consultar();
        break;
    }

    // funcion para consultar datos
    function Consultar() {

        // instacia el modelo
        $modelo = new CuentaPagar();
        $proveedor = new Proveedor();
        $permiso = new Permiso();
        $bitacora = new Bitacora();
        
        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Cuentas por Pagar',
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
                    $cuentasPagar = $resultado['data'];

                    // extrae cliente
                    $proveedores = $proveedor->manejarAccion('consultar', null)['data'];

                    // extrae los metodo de pagos
                    $metodos = $modelo->manejarAccion('consultar_metodo', null)['data'];


                    // se arma el json de bitacora
                    $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Cuentas por Pagar',
                        'accion' => 'Consultar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha Consultado los datos en dashboard de las Cuentas por Pagar' . ' ' . 'CT-00' . 'en el sistema.',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                    //carga la vista
                    require_once 'app/views/pagarView.php';

                    // termina el script
                    exit();
                }
                else {
                                
                    // usa mensaje dinamico del modelo
                    setError($resultado['msj']);

                    //carga la vista
                    require_once 'app/views/pagarView.php';

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

    // function para obtener un dato
    function Obtener() {

        // instancia el modelo
        $modelo = new CuentaPagar();
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
            header('Location: index.php?url=pagar');
            
            // termina el script
            exit();
        }

        // se arma el json
        $cuenta_json = json_encode(['id' => $id]);
        
        // llama la funcion obtener del modelo
        $resultado = $modelo->manejarAccion('obtener', $cuenta_json);

        // se extrae dato de la cuenta
        $cuentasPagar = $resultado['data'];

        // se extrae dartos para la bitacora
        $data = $resultado['data_bitacora'];

        // se arma el json de bitacora
        $bitacora_json = json_encode([
            'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
            'modulo' => 'Cuentas por Pagar',
            'accion' => 'Obtener',
            'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                'ha obtenido los datos de la Cuentas por Pagar' . ' ' . 
                'CT-00' . ' ' . $data['id_cuenta_x_pagar'] . ' ' . 
                'cliente' . ' ' . $data['nombre_proveedor'] . ' ' . 
                'monto' . ' ' . $data['monto_total'] . ' ' .  
                'en el sistema.',
            'fecha' => $fecha
        ]);

        //realiza la insercion de la bitacora
        $bitacora->manejarAccion('agregar', $bitacora_json);

        echo json_encode($cuentasPagar);
    }

    // funcion para registrar pago
    function RegistrarPago() {

        // instacia el modelo
        $modelo = new CuentaPagar();
        $permiso = new Permiso();
        $bitacora = new Bitacora();
        
        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Cuentas por Pagar',
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
            $proveedor = filter_var($_POST['id_proveedor'] ?? '');
            $monto_pago = filter_var($_POST['montoPago'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $fechaPago = filter_var($_POST['fechaPago'] ?? '');
            $referencia = filter_var($_POST['nroReferencia'] ?? '');
            $concepto = filter_var($_POST['concepto'] ?? '');
            $metodo = filter_var($_POST['metodoPago'] ?? '');

            // valida que ningun dato este vacio
            if (empty($id) || empty($proveedor) || empty($monto_pago) || empty($fechaPago) || empty($referencia) || empty($concepto) || empty($metodo)) {
                
                // msj de error
                setError('Todos los campos son requeridos.');
                
                // redirige
                header('Location: index.php?url=pagar');
                
                // termina el script
                exit();
            }

            // se arma el json
            $cuenta_json = [
                'id' => $id,
                'proveedor' => $proveedor,
                'monto' => $monto_pago,
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
                        'modulo' => 'Cuentas por Pagar',
                        'accion' => 'Agregar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha registrado un pago de la Cuentas por Pagar' . ' ' . 
                            'CT-00' . ' ' . $id . ' ' . 
                            'proveedor' . ' ' . $proveedor . ' ' . 
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
        header('Location: index.php?url=pagar');

        // termina el script
        exit();
    }

    //redirige
    header('Location: index.php?url=pagar');

    // termina el script
    exit();
}
?>
