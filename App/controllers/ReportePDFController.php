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

// usa las lib de fpdf, excel, word 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

// define zona horaria
date_default_timezone_set('America/Caracas');

// almacena la peticion http
$action = isset($_GET['action']) ? $_GET['action'] : '';

// mediante el case se llama la funcion
switch($action) {

    case 'excel':
    
        // llama funcion
        generarExcel();

    // termina
    break;
    
    case 'word':
    
        // llama funcion
        generarWord();
    
    // termina 
    break;

    case 'pdf':

        // llama funcion
        generarPDF();

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
                require_once 'app/views/reportesPDFView.php';

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

// funcion que genera los reporte PDF
function generarPDF() {

    // se obtiene y establece el modulo a reportar 
    $tipo = $_GET['tipo'] ?? '';
    
    // valida si esxixte fpdf
    if (!class_exists('FPDF')) {

    // llama a fpdf
    require_once 'lib/fpdf.php';  // Solo si NO existe
    };

    // llama al template
    require_once 'app/helpers/PDFTemplate.php';
    
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
    
    // Crear PDF con plantilla
    $pdf = new PDFTemplate();
    $pdf->AliasNbPages();
    
    // Configurar titulo y subtitulo segun tipo
    $tituloReporte = '';
    $filtros = [];
    
    // establece el titulo del reporte por case
    switch($tipo) {
        
        case 'clientes':

            // define titulo
            $tituloReporte = 'Reporte de Clientes';

        // termina
        break;
        
        case 'tipo_clientes':

            // establece titulo
            $tituloReporte = 'Reporte de Tipos de Clientes';
        
        // termina
        break;

        case 'categorias':

            // establece titulo
            $tituloReporte = 'Reporte de Categorias';

        // termina
        break;

        case 'productos':

            // establece titulo
            $tituloReporte = 'Reporte de Productos';

        // termina
        break;

        case 'materia_prima':

            // establece titulo
            $tituloReporte = 'Reporte de Materias Primas';

        // termina
        break;

        case 'produccion':

            // establece titulo
            $tituloReporte = 'Reporte de Produccion';

        // termina
        break;

        case 'proveedores':

            // establece titulo
            $tituloReporte = 'Reporte de Proveedores';

        // termina
        break;

        case 'usuarios':

            // establece titulo
            $tituloReporte = 'Reporte de Usuarios';

        // termina
        break;

        case 'pedidos':

            // establece titulo
            $tituloReporte = 'Reporte de Pedidos';

        // termina
        break;
        
        case 'promociones':

            // establece titulo
            $tituloReporte = 'Reporte de Promociones';

        // termina
        break;
        
        case 'compras':

            // establece titulo
            $tituloReporte = 'Reporte de Compras';

        // termina
        break;

        case 'pagos':

            // establece titulo
            $tituloReporte = 'Reporte de Pagos';

        // termina
        break;

        case 'cobrar':

            // establece titulo
            $tituloReporte = 'Reporte de Cuentas por Cobrar';

        // termina
        break;

        case 'pagar':

            // establece titulo
            $tituloReporte = 'Reporte de Cuentas por Pagar';

        // termina
        break;

        case 'entregas':

            // establece titulo
            $tituloReporte = 'Reporte de Entregas';

        // termina    
        break;
        
        case 'notificaciones':

            // establece titulo
            $tituloReporte = 'Reporte de Notificaciones';

        // termina
        break;

        case 'dashboard':

            //establece titulo
            $tituloReporte = 'Resumen General del Sistema';

        //termina
        break;
        
        case 'ecommerce':
        
            // establece titulo
            $tituloReporte = 'Reporte Ecommerce';

        //termina
        break;

        default:
            
            // establece titulo
            $tituloReporte = 'Reporte del Sistema';
    }
    
    // apunta a la funcion de titulo del reporte 
    $pdf->setTitulo($tituloReporte);

    // valida si exixte filtros
    if(!empty($filtros)) {

        // apunta a la funcion de filtros en el reporte
        $pdf->setSubtitulo('Filtros: ' . implode(' | ', $filtros));
    }
    
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
    }
    
    // llama a la funcion de agg una pagina
    $pdf->AddPage();
    
    // almacena los datos preparados
    $datosProcesados = prepararDatosParaPDF($datos, $tipo);
    

    // valida si existen los datos preparados
    if(!empty($datosProcesados['datos'])) {

        // Generar tabla profesional con labels amigables
        $pdf->TablaProfesional($datosProcesados['headers'], $datosProcesados['datos']);
        
        // Agregar resumen si es aplicable
        $pdf->Ln(10);
        $pdf->Seccion('Resumen del Reporte');
        
        // arry de resumen
        $resumen = [
            'Total de registros' => count($datos) . ' items',
            'Fecha de generacion' => date('d/m/Y H:i:s'),
            'Generado por' => isset($_SESSION['s_usuario']) ? $_SESSION['s_usuario']['nombre_usuario'] : 'Sistema'
        ];
        

        // bucle se resumen
        foreach($resumen as $label => $valor) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetTextColor(108, 117, 125);
            $pdf->Cell(60, 7, utf8_decode($label . ':'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetTextColor(33, 37, 41);
            $pdf->Cell(0, 7, utf8_decode($valor), 0, 1, 'L');
        }
    } 
    else {
        $pdf->SetFont('Arial', 'I', 12);
        $pdf->SetTextColor(150, 150, 150);
        $pdf->Cell(0, 20, utf8_decode('No se encontraron datos para los filtros seleccionados.'), 0, 1, 'C');
    }
    
    // llama la funcion salida
    $pdf->Output('I', 'Reporte_' . ucfirst($tipo) . '_' . date('Y-m-d') . '.pdf');
    
    //termina
    exit;
}

// funcion que me prepara la tabla del PDF
function prepararDatosParaPDF(array $datos, string $tipo): array {
   
    // establece cabecera header 
    $friendlyHeaders = [
        'id_producto' => 'ID',
        'nombre_producto' => 'Nombre',
        'precio_venta' => 'Precio',
        'stock' => 'Stock',
        'fecha_registro' => 'Fecha registro',
        'fecha_vencimiento' => 'Fecha vencimiento',
        'id_categoria' => 'ID categoría',
        'nombre_categoria' => 'Categoría',
        'img' => 'Imagen',
        'status' => 'Estado',
        'id_cliente' => 'ID',
        'nombre_cliente' => 'Cliente',
        'direccion_cliente' => 'Dirección',
        'tlf_cliente' => 'Teléfono',
        'email_cliente' => 'Email',
        'id_usuario' => 'ID',
        'nombre_usuario' => 'Usuario',
        'id_rol' => 'Rol',
        'id_proveedor' => 'Proveedor',
        'fecha_emision' => 'Fecha emisión',
        'monto' => 'Monto',
        'saldo' => 'Saldo',
        'estado' => 'Estado',
        'nombre_categoría' => 'Categoría',
    ];

    // establece img
    $skipColumns = ['img'];
    
    // establece columns
    $keepColumnsPerTipo = [
        'productos' => ['nombre_producto', 'precio_venta', 'stock', 'fecha_registro', 'fecha_vencimiento', 'nombre_categoria'],
    ];

    //inicializa parte de la tabla
    $allowedColumns = $keepColumnsPerTipo[$tipo] ?? null;
    $headers = [];
    $datosTabla = [];

    // valida si existe datos
    if (!empty($datos)) {

        // almacena arry de datos
        $firstRowKeys = array_keys($datos[0]);

        // bucle que valida 
        foreach ($firstRowKeys as $key) {

            // valida si es null o no es arry
            if ($allowedColumns !== null && !in_array($key, $allowedColumns, true)) {
                
                // avanza
                continue;
            }
            //valida si no es null y si no es arry
            if ($allowedColumns === null && in_array($key, $skipColumns, true)) {
                
                //avanza
                continue;
            }

            // almacana header
            $headers[] = $friendlyHeaders[$key] ?? ucwords(str_replace('_', ' ', $key));
        }

        // bucle que recorre datos a fila
        foreach ($datos as $fila) {

            // inicia fila
            $row = [];

            // recorre 
            foreach ($firstRowKeys as $key) {
                
                // valida si es null y arry
                if ($allowedColumns !== null && !in_array($key, $allowedColumns, true)) {
                    
                    // avanza
                    continue;
                }
                // valida si es null y arry
                if ($allowedColumns === null && in_array($key, $skipColumns, true)) {
                    
                    // avanza
                    continue;
                }

                // almacena valor 
                $valor = $fila[$key] ?? '';
                
                // valida si se trata de precio
                if ($key === 'precio_venta' && is_numeric($valor)) {
                    
                    // acomoda valor
                    $valor = number_format($valor, 2, ',', '.');
                }

                // guarda valor
                $row[] = $valor;
            }

            // guarda en tabla
            $datosTabla[] = $row;
        }
    }

    // retorna arry de datos procesados
    return ['headers' => $headers, 'datos' => $datosTabla];
}

// funcion que me genera los reportes de excel
function generarExcel() {

    // define el tipo de modulo
    $tipo = $_GET['tipo'] ?? '';

    // crea el objeto de excel
    $spreadsheet = new Spreadsheet();

    // almacena hoja
    $sheet = $spreadsheet->getActiveSheet();
    
    // llama ya sea el tipo case en el modulo
    switch($tipo) {

        case 'clientes':

            // instacia el modelo
            $modelo = new Cliente();

            // obtiene datos
            $resultado = $modelo->manejarAccion('consultar', null);
            
            // valida y guarda datos
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            
            // define titulo
            $sheet->setTitle('Reporte de Clientes');
            
            // define cabecera
            $headers = ['ID', 'Nombre', 'Apellido', 'Cedula', 'Telefono', 'Email', 'Direccion', 'Tipo Cliente', 'Estado'];
            
        //termina    
        break;

        case 'productos':

            // intancia el modelo
            $modelo = new Producto();

            // obtiene los datos 
            $resultado = $modelo->manejarAccion('consultar', null);
            
            // valida y guarda los datos 
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            
            // define titulo
            $sheet->setTitle('Reporte de Productos');
            
            // define cabecera
            $headers = ['ID', 'Codigo', 'Nombre', 'Descripcion', 'Precio', 'Stock', 'Categoria', 'Estado'];
        
        // termina
        break;

        case 'pedidos':

            //indtancia el modelo
            $modelo = new Pedido();

            // obtiene los datos 
            $resultado = $modelo->manejarAccion('consultar', null);
            
            // valida o guarda los datos
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            
            // define titulo
            $sheet->setTitle('Reporte de Pedidos');
            
            // define cabecera
            $headers = ['ID', 'Cliente', 'Fecha', 'Total', 'Estado', 'Direccion'];
            
        // termina    
        break;

        default:

            // inicialica datos y header en vacio
            $datos = [];
            $headers = [];
    }
    
    // Encabezados
    $col = 'A';
    foreach($headers as $header) {
        $sheet->setCellValue($col . '1', $header);
        $sheet->getStyle($col . '1')->getFont()->setBold(true);
        $col++;
    }
    
    // Datos
    $row = 2;
    foreach($datos as $dato) {
        $col = 'A';
        foreach($dato as $valor) {
            $sheet->setCellValue($col . $row, $valor);
            $col++;
        }
        $row++;
    }
    
    // Autoajustar columnas
    foreach(range('A', $col) as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: inline; filename="Reporte_' . ucfirst($tipo) . '_' . date('Y-m-d') . '.xlsx"');
    header('Cache-Control: public, max-age=0');
    header('Pragma: public');
    
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

//funcion que me genera los reportes en word
function generarWord() {
    $tipo = $_GET['tipo'] ?? 'clientes';
    $phpWord = new PhpWord();
    $section = $phpWord->addSection();
    
    $section->addText('Reporte de ' . ucfirst($tipo), ['bold' => true, 'size' => 16]);
    $section->addText('Fecha: ' . date('d/m/Y H:i:s'));
    $section->addTextBreak();
    
    switch($tipo) {
        case 'clientes':
            $modelo = new Cliente();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            break;
        case 'productos':
            $modelo = new Producto();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            break;
        case 'pedidos':
            $modelo = new Pedido();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            break;
        case 'proveedores':
            $modelo = new Proveedor();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            break;
        case 'usuarios':
            $modelo = new Usuario();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            break;
        case 'categorias':
            $modelo = new Categoria();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            break;
        case 'materia_prima':
            $modelo = new MateriaPrima();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            break;
        case 'promociones':
            $modelo = new Promocion();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            break;
        case 'entregas':
            $modelo = new Entrega();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            break;
        case 'cobros':
            $modelo = new Cobrar();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            break;
        case 'pagos':
            $modelo = new Pagar();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            break;
        case 'notificaciones':
            $modelo = new Notificacion();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            break;
        default:
            $datos = [];
    }
    
    $table = $section->addTable(['borderSize' => 6, 'borderColor' => '000000']);
    
    if(!empty($datos)) {
        // Header
        $table->addRow();
        foreach(array_keys($datos[0]) as $header) {
            $table->addCell(2000)->addText(strtoupper($header), ['bold' => true]);
        }
        
        // Data
        foreach($datos as $fila) {
            $table->addRow();
            foreach($fila as $valor) {
                $table->addCell(2000)->addText($valor);
            }
        }
    }
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: inline; filename="Reporte_' . ucfirst($tipo) . '_' . date('Y-m-d') . '.docx"');
    header('Cache-Control: public, max-age=0');
    header('Pragma: public');
    
    $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save('php://output');
    exit;
}




function reporteClientes() {
    echo json_encode(['status' => 200, 'message' => 'Reporte de clientes']);
}

function reporteProductos() {
    echo json_encode(['status' => 200, 'message' => 'Reporte de productos']);
}

function reportePedidos() {
    echo json_encode(['status' => 200, 'message' => 'Reporte de pedidos']);
}

function reporteVentas() {
    echo json_encode(['status' => 200, 'message' => 'Reporte de ventas']);
}

function reporteInventario() {
    echo json_encode(['status' => 200, 'message' => 'Reporte de inventario']);
}
?>
