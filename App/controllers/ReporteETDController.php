<?php

// llama a los modelos 
require_once 'vendor/autoload.php';
require_once 'app/models/PagoModel.php';
require_once 'app/models/TipoClienteModel.php';
require_once 'app/models/ClienteModel.php';
require_once 'app/models/RolModel.php';
require_once 'app/models/ProductoModel.php';
require_once 'app/models/ProduccionModel.php';
require_once 'app/models/PedidoModel.php';
require_once 'app/models/CompraModel.php';
require_once 'app/models/ProveedorModel.php';
require_once 'app/models/UsuarioModel.php';
require_once 'app/models/CategoriaModel.php';
require_once 'app/models/MateriaPrimaModel.php';
require_once 'app/models/PromocionModel.php';
require_once 'app/models/EntregaModel.php';
require_once 'app/models/CobrarModel.php';
require_once 'app/models/PagarModel.php';
require_once 'app/models/NotificacionModel.php';
require_once 'app/models/BitacoraModel.php';
require_once 'app/models/PermisoModel.php';
require_once 'components/utils.php';

// define zona horaria
date_default_timezone_set('America/Caracas');

// almacena la peticion http
$action = isset($_GET['action']) ? $_GET['action'] : '';

// mediante el case se llama la funcion
switch($action) {

    case 'etd':

        // llama funcion
        generarETD();

    // termina
    break;
    
    default:
    
        // llama la funcion
        mostrarDashboard();

    // termina
    break;

}

// funcion que me llama la vista
function mostrarDashboard() {

    //instancia los modelos 
    $tipoCliente = new TipoCliente();
    $categoria = new Categoria();
    $rol = new Rol();
    $pedido = new Pedido();
    $pago = new Pago();
    $entrega = new Entrega();
    $permiso = new Permiso();
    $bitacora = new Bitacora();

    // se almacena la fecha en la var
    $fecha = (new DateTime())->format('Y-m-d H:i:s');


    // se arma el json
    $permiso_json = json_encode([
        'modulo' => 'Reportes',
        'permiso' => 'Consultar',
        'rol' => $_SESSION['s_usuario']['id_rol_usuario']
    ]);


        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] === true) {
            
            // Ejecutar acción permitida*/

            // para manejo de errores
            try {

                // obtienes los datos para select
                //tipos
                $tipos = $tipoCliente->manejarAccion('consultar', null)['data'];

                // categorias
                $categorias = $categoria->manejarAccion('consultar', null)['data'];

                // roles
                $roles = $rol->manejarAccion('consultar', null)['data'];
                
                //estado pedido
                $estadoPedido = $pedido->manejarAccion('consultar_estado', null)['data'];
                
                //estado pago
                $estadoPago = $pago->manejarAccion('consultar_estado', null)['data'];
                
                //estado entrega
                $estadoEntrega = $entrega->manejarAccion('consultar_estado', null)['data'];

                // se arma el json de bitacora
                $bitacora_json = json_encode([
                    'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                    'modulo' => 'Reportes',
                    'accion' => 'Consultar',
                    'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                        'ha Consultado los datos en el dashboard de reportes en el sistema',
                    'fecha' => $fecha
                ]);

                //realiza la insercion de la bitacora
                $bitacora->manejarAccion('agregar', $bitacora_json);

                // llama la vista
                require_once 'app/views/reportesETDView.php';

                // termina el script
                exit();
            
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


// funcion que genera los reporte estadisticos
function generarETD() {

    // se obtiene y establece el modulo a reportar 
    $tipo = $_GET['tipo'] ?? '';
    
    // Obtener parametros de filtro
    $mes = $_GET['mes'] ?? '';
    $fecha_desde = $_GET['fecha_desde'] ?? '';
    $fecha_hasta = $_GET['fecha_hasta'] ?? '';
    $tiposCliente = $_GET['tipo_cliente'] ?? ''; // para cliente
    $dias = $_GET['dias'] ?? ''; // para tipos clientes
    $cat = $_GET['categoria'] ?? ''; // para producto
    $orden = $_GET['orden'] ?? ''; // para ordenar por modulo
    $fecha = $_GET['fecha'] ?? ''; // para fechas de modulos
    $filtro = $_GET['filtro'] ?? ''; // filtro de los mudulos
    $estado = $_GET['estado'] ?? ''; // estado de los modulos
    
    // mediante el tipo con el case se llama a la funcion del modelo y se 
    // obtiene los datos del modelo
    switch($tipo) {
        case 'clientes':

            // instancia modelo
            $modelo = new Cliente();
            
            // valida si esxixte 
            if(!empty($estado)){

                // obtiene los datos
                $resultado = $modelo->manejarAccion('consultarClienteEstadoPDF', $estado);
            
            }
            //valida si existe
            elseif(!empty($tiposCliente)){

                // obtiene datos
                $resultado = $modelo->manejarAccion('consultarClienteTipoPDF', $tiposCliente);

            }
            // condicion final
            else{
                    
                // obtiene los datos 
                $resultado = $modelo->manejarAccion('consultarPDF', null);
            }

            // valida y asigna los datos obtenidos 
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
        
        // termina
        break;

        case 'tipo_clientes':

            // instancia modelo
            $modelo = new TipoCliente();
            
            // valida si esxixte 
            if(!empty($dias)){

                // obtiene los datos
                $resultado = $modelo->manejarAccion('consultarTipoClienteDiasPDF', $dias);
            
            }
            // condicion final
            else{
                    
                // obtiene los datos 
                $resultado = $modelo->manejarAccion('consultarPDF', null);
            }

            // valida y asigna los datos obtenidos 
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
        
        // termina
        break;

        case 'productos':

            //instancia el modelo
            $modelo = new Producto();

            // valida si existe
            if(!empty($cat)){

                // obtiene los datos
                $resultado = $modelo->manejarAccion('consultarProductoCategoriaPDF', $cat);
            }
            // valida si existe
            elseif(!empty($filtro)){

                //obtiene los datos
                $resultado = $modelo->manejarAccion('consultarProductoFiltroPDF', $filtro);
            }
            // condicion final
            else{
                
                // obtiene los datos
                $resultado = $modelo->manejarAccion('consultarPDF', null);
            }

            // valida y adigna los datos
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
        
        // termina
        break;

        case 'categorias':

            // instancia modelo
            $modelo = new Categoria();
            
            // valida si esxixte 
            if(!empty($orden)){

                // obtiene los datos
                $resultado = $modelo->manejarAccion('consultarCategoriaOrdenPDF', $orden);
            
            }
            // condicion final
            else{
                    
                // obtiene los datos 
                $resultado = $modelo->manejarAccion('consultarPDF', null);
            }

            // valida y asigna los datos obtenidos 
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
        
            // imprime datos
            echo json_encode($datos);

        // termina
        break;

        case 'materia_prima':

            // instancia modelo
            $modelo = new MateriaPrima();
            
            // valida si esxixte 
            if(!empty($filtro)){

                // obtiene los datos
                $resultado = $modelo->manejarAccion('consultarMateriaPrimaStockPDF', $filtro);
            
            }
            // condicion final
            else{
                    
                // obtiene los datos 
                $resultado = $modelo->manejarAccion('consultarPDF', null);
            }

            // valida y asigna los datos obtenidos 
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
        
        // termina
        break;

        case 'produccion':

            // instancia modelo
            $modelo = new Produccion();
            
            // valida si esxixte 
            if(!empty($fecha)){

                // obtiene los datos
                $resultado = $modelo->manejarAccion('consultarProduccionFechaPDF', $fecha);
            
            }
            // condicion final
            else{
                    
                // obtiene los datos 
                $resultado = $modelo->manejarAccion('consultarPDF', null);
            }

            // valida y asigna los datos obtenidos 
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
        
        // termina
        break;

        case 'proveedores':

            // instancia modelo
            $modelo = new Proveedor();
            
            // valida si esxixte 
            if(!empty($filtro)){

                // obtiene los datos
                $resultado = $modelo->manejarAccion('consultarProveedorMateriaPDF', $filtro);
            
            }
            // condicion final
            else{
                    
                // obtiene los datos 
                $resultado = $modelo->manejarAccion('consultarPDF', null);
            }

            // valida y asigna los datos obtenidos 
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
        
        // termina
        break;

        case 'usuarios':

            // instancia modelo
            $modelo = new Usuario();
            
            // valida si esxixte 
            if(!empty($filtro)){

                // obtiene los datos
                $resultado = $modelo->manejarAccion('consultarUsuarioRolPDF', $filtro);
            
            }
            // condicion final
            else{
                    
                // obtiene los datos 
                $resultado = $modelo->manejarAccion('consultarPDF', null);
            }

            // valida y asigna los datos obtenidos 
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
        
        // termina
        break;

        case 'pedidos':

            //instancia el modelo
            $modelo = new Pedido();

            // valida si existe
            if(!empty($estado)){

                // obtiene los datos
                $resultado = $modelo->manejarAccion('consultarPedidoEstadoPDF', $estado);
            }
            // valida si existe
            elseif(!empty($filtro)){

                //obtiene los datos
                $resultado = $modelo->manejarAccion('consultarPedidoFiltroPDF', $filtro);
            }
            // condicion final
            else{
                
                // obtiene los datos
                $resultado = $modelo->manejarAccion('consultarPDF', null);
            }

            // valida y adigna los datos
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
        
        // termina
        break;

        case 'promociones':

            //instancia el modelo
            $modelo = new Promocion();

            // valida si existe
            if(!empty($estado)){

                // obtiene los datos
                $resultado = $modelo->manejarAccion('consultarPromocionEstadoPDF', $estado);
            }
            // valida si existe
            elseif(!empty($filtro)){

                //obtiene los datos
                $resultado = $modelo->manejarAccion('consultarPromocionFiltroPDF', $filtro);
            }
            // condicion final
            else{
                
                // obtiene los datos
                $resultado = $modelo->manejarAccion('consultarPDF', null);
            }

            // valida y adigna los datos
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
        
        // termina
        break;

        case 'compras':

            // instancia modelo
            $modelo = new Compra();
            
            // valida si esxixte 
            if(!empty($estado)){

                // obtiene los datos
                $resultado = $modelo->manejarAccion('consultarCompraEstadoPDF', $estado);
            
            }
            // condicion final
            else{
                    
                // obtiene los datos 
                $resultado = $modelo->manejarAccion('consultarPDF', null);
            }

            // valida y asigna los datos obtenidos 
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
        
        // termina
        break;

        case 'pagos':

            // instancia modelo
            $modelo = new Pago();
                    
            // obtiene los datos 
            $resultado = $modelo->manejarAccion('consultarPDF', null);

            // valida y asigna los datos obtenidos 
            $datosClientes = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data_cliente'] : [];
            $datosProveedores = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data_proveedor'] : [];

            // unific para una sola tabla
            $datos = array_merge($datosClientes, $datosProveedores);
        
        // termina
        break;

        case 'cobrar':

            // instancia modelo
            $modelo = new CuentaCobrar();
            
            // valida si esxixte 
            if(!empty($estado)){

                // obtiene los datos
                $resultado = $modelo->manejarAccion('consultarCuentaEstadoPDF', $estado);
            
            }
            // condicion final
            else{
                    
                // obtiene los datos 
                $resultado = $modelo->manejarAccion('consultarPDF', null);
            }

            // valida y asigna los datos obtenidos 
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
        
        // termina
        break;

        case 'pagar':

            // instancia modelo
            $modelo = new CuentaPagar();
            
            // valida si esxixte 
            if(!empty($estado)){

                // obtiene los datos
                $resultado = $modelo->manejarAccion('consultarCuentaEstadoPDF', $estado);
            
            }
            // condicion final
            else{
                    
                // obtiene los datos 
                $resultado = $modelo->manejarAccion('consultarPDF', null);
            }

            // valida y asigna los datos obtenidos 
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
        
        // termina
        break;

        case 'entregas':

            //instancia el modelo
            $modelo = new Entrega();

            // valida si existe
            if(!empty($estado)){

                // obtiene los datos
                $resultado = $modelo->manejarAccion('consultarEntregaEstadoPDF', $estado);
            }
            // valida si existe
            elseif(!empty($fecha)){

                //obtiene los datos
                $resultado = $modelo->manejarAccion('consultarEntregaFechaPDF', $fecha);
            }
            // condicion final
            else{
                
                // obtiene los datos
                $resultado = $modelo->manejarAccion('consultarPDF', null);
            }

            // valida y adigna los datos
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
        
        // termina
        break;

        case 'notificaciones':

            // instacia el modelo
            $modelo = new Notificacion();

            //obtiene los resultados
            $resultado = $modelo->manejarAccion('consultar', null);

            // valida y asigna los datos
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            
        // termina    
        break;

        default:

            // inicializa en vacio
            $datos = [];

    //termina
    exit;
}
}

?>