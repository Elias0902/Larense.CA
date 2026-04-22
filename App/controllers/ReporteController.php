<?php
require_once 'vendor/autoload.php';
require_once 'app/models/ClienteModel.php';
require_once 'app/models/ProductoModel.php';
require_once 'app/models/PedidoModel.php';
require_once 'app/models/ProveedorModel.php';
require_once 'app/models/UsuarioModel.php';
require_once 'app/models/CategoriaModel.php';
require_once 'app/models/MateriaPrimaModel.php';
require_once 'app/models/PromocionModel.php';
require_once 'app/models/EntregaModel.php';
require_once 'app/models/CobrarModel.php';
require_once 'app/models/PagarModel.php';
require_once 'app/models/NotificacionModel.php';
require_once 'components/utils.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

date_default_timezone_set('America/Caracas');

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action) {
    case 'excel':
        generarExcel();
        break;
    case 'word':
        generarWord();
        break;
    case 'pdf':
        generarPDF();
        break;
    case 'clientes':
        reporteClientes();
        break;
    case 'productos':
        reporteProductos();
        break;
    case 'pedidos':
        reportePedidos();
        break;
    case 'ventas':
        reporteVentas();
        break;
    case 'inventario':
        reporteInventario();
        break;
    default:
        mostrarDashboard();
        break;
}

function mostrarDashboard() {
    require_once 'app/views/reportesView.php';
}

function generarExcel() {
    $tipo = $_GET['tipo'] ?? 'clientes';
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    switch($tipo) {
        case 'clientes':
            $modelo = new Cliente();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            $sheet->setTitle('Reporte de Clientes');
            $headers = ['ID', 'Nombre', 'Apellido', 'Cedula', 'Telefono', 'Email', 'Direccion', 'Tipo Cliente', 'Estado'];
            break;
        case 'productos':
            $modelo = new Producto();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            $sheet->setTitle('Reporte de Productos');
            $headers = ['ID', 'Codigo', 'Nombre', 'Descripcion', 'Precio', 'Stock', 'Categoria', 'Estado'];
            break;
        case 'pedidos':
            $modelo = new Pedido();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            $sheet->setTitle('Reporte de Pedidos');
            $headers = ['ID', 'Cliente', 'Fecha', 'Total', 'Estado', 'Direccion'];
            break;
        case 'proveedores':
            $modelo = new Proveedor();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            $sheet->setTitle('Reporte de Proveedores');
            $headers = ['ID', 'Nombre', 'RIF', 'Telefono', 'Email', 'Direccion', 'Estado'];
            break;
        case 'usuarios':
            $modelo = new Usuario();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            $sheet->setTitle('Reporte de Usuarios');
            $headers = ['ID', 'Nombre', 'Usuario', 'Email', 'Rol', 'Estado'];
            break;
        case 'categorias':
            $modelo = new Categoria();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            $sheet->setTitle('Reporte de Categorias');
            $headers = ['ID', 'Nombre', 'Descripcion', 'Estado'];
            break;
        case 'materia_prima':
            $modelo = new MateriaPrima();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            $sheet->setTitle('Reporte de Materia Prima');
            $headers = ['ID', 'Nombre', 'Descripcion', 'Cantidad', 'Unidad', 'Estado'];
            break;
        case 'promociones':
            $modelo = new Promocion();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            $sheet->setTitle('Reporte de Promociones');
            $headers = ['ID', 'Nombre', 'Descuento', 'Fecha Inicio', 'Fecha Fin', 'Estado'];
            break;
        case 'entregas':
            $modelo = new Entrega();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            $sheet->setTitle('Reporte de Entregas');
            $headers = ['ID', 'Pedido', 'Fecha', 'Transportista', 'Estado'];
            break;
        case 'cobros':
            $modelo = new Cobrar();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            $sheet->setTitle('Reporte de Cobros');
            $headers = ['ID', 'Cliente', 'Monto', 'Fecha', 'Estado'];
            break;
        case 'pagos':
            $modelo = new Pagar();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            $sheet->setTitle('Reporte de Pagos');
            $headers = ['ID', 'Proveedor', 'Monto', 'Fecha', 'Estado'];
            break;
        case 'notificaciones':
            $modelo = new Notificacion();
            $resultado = $modelo->manejarAccion('consultar', null);
            $datos = (isset($resultado['status']) && $resultado['status'] === true) ? $resultado['data'] : [];
            $sheet->setTitle('Reporte de Notificaciones');
            $headers = ['ID', 'Titulo', 'Mensaje', 'Fecha', 'Estado'];
            break;
        default:
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

function prepararDatosParaPDF(array $datos, string $tipo): array {
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

    $skipColumns = ['img'];
    $keepColumnsPerTipo = [
        'productos' => ['nombre_producto', 'precio_venta', 'stock', 'fecha_registro', 'fecha_vencimiento', 'nombre_categoria'],
    ];

    $allowedColumns = $keepColumnsPerTipo[$tipo] ?? null;
    $headers = [];
    $datosTabla = [];

    if (!empty($datos)) {
        $firstRowKeys = array_keys($datos[0]);
        foreach ($firstRowKeys as $key) {
            if ($allowedColumns !== null && !in_array($key, $allowedColumns, true)) {
                continue;
            }
            if ($allowedColumns === null && in_array($key, $skipColumns, true)) {
                continue;
            }
            $headers[] = $friendlyHeaders[$key] ?? ucwords(str_replace('_', ' ', $key));
        }

        foreach ($datos as $fila) {
            $row = [];
            foreach ($firstRowKeys as $key) {
                if ($allowedColumns !== null && !in_array($key, $allowedColumns, true)) {
                    continue;
                }
                if ($allowedColumns === null && in_array($key, $skipColumns, true)) {
                    continue;
                }
                $valor = $fila[$key] ?? '';
                if ($key === 'precio_venta' && is_numeric($valor)) {
                    $valor = number_format($valor, 2, ',', '.');
                }
                $row[] = $valor;
            }
            $datosTabla[] = $row;
        }
    }

    return ['headers' => $headers, 'datos' => $datosTabla];
}

function generarPDF() {
    $tipo = $_GET['tipo'] ?? 'clientes';
    
    if (!class_exists('FPDF')) {
    require_once 'lib/fpdf.php';  // Solo si NO existe
    };
    require_once 'app/helpers/PDFTemplate.php';
    
    // Obtener parametros de filtro
    $mes = $_GET['mes'] ?? '';
    $fecha_desde = $_GET['fecha_desde'] ?? '';
    $fecha_hasta = $_GET['fecha_hasta'] ?? '';
    $estado = $_GET['estado'] ?? '';
    
    // Crear PDF con plantilla
    $pdf = new PDFTemplate();
    $pdf->AliasNbPages();
    
    // Configurar titulo y subtitulo segun tipo
    $tituloReporte = '';
    $filtros = [];
    
    switch($tipo) {
        case 'clientes':
            $tituloReporte = 'Reporte de Clientes';
            if($mes) $filtros[] = 'Mes: ' . date('F', mktime(0,0,0,$mes,1));
            if($estado && $estado != 'todos') $filtros[] = 'Estado: ' . ucfirst($estado);
            break;
        case 'productos':
            $tituloReporte = 'Reporte de Productos';
            if($estado && $estado != 'todos') $filtros[] = 'Stock: ' . ucfirst($estado);
            break;
        case 'pedidos':
            $tituloReporte = 'Reporte de Pedidos';
            if($mes) $filtros[] = 'Mes: ' . date('F', mktime(0,0,0,$mes,1));
            if($estado && $estado != 'todos') $filtros[] = 'Estado: ' . ucfirst($estado);
            break;
        case 'proveedores':
            $tituloReporte = 'Reporte de Proveedores';
            break;
        case 'usuarios':
            $tituloReporte = 'Reporte de Usuarios';
            break;
        case 'categorias':
            $tituloReporte = 'Reporte de Categorias';
            break;
        case 'materia_prima':
            $tituloReporte = 'Reporte de Materia Prima';
            break;
        case 'promociones':
            $tituloReporte = 'Reporte de Promociones';
            break;
        case 'entregas':
            $tituloReporte = 'Reporte de Entregas';
            if($fecha_desde) $filtros[] = 'Desde: ' . $fecha_desde;
            if($fecha_hasta) $filtros[] = 'Hasta: ' . $fecha_hasta;
            break;
        case 'cobros':
            $tituloReporte = 'Reporte de Cuentas por Cobrar';
            if($mes) $filtros[] = 'Mes: ' . date('F', mktime(0,0,0,$mes,1));
            break;
        case 'pagos':
            $tituloReporte = 'Reporte de Cuentas por Pagar';
            if($mes) $filtros[] = 'Mes: ' . date('F', mktime(0,0,0,$mes,1));
            break;
        case 'notificaciones':
            $tituloReporte = 'Reporte de Notificaciones';
            break;
        case 'facturas':
            $tituloReporte = 'Reporte de Facturas';
            if($mes) $filtros[] = 'Mes: ' . date('F', mktime(0,0,0,$mes,1));
            break;
        case 'inventario':
            $tituloReporte = 'Reporte de Inventario';
            break;
        case 'compras':
            $tituloReporte = 'Reporte de Compras';
            if($mes) $filtros[] = 'Mes: ' . date('F', mktime(0,0,0,$mes,1));
            break;
        case 'dashboard':
            $tituloReporte = 'Resumen General del Sistema';
            if($fecha_desde) $filtros[] = 'Desde: ' . $fecha_desde;
            if($fecha_hasta) $filtros[] = 'Hasta: ' . $fecha_hasta;
            break;
        case 'ecommerce':
            $tituloReporte = 'Reporte Ecommerce';
            if($mes) $filtros[] = 'Mes: ' . date('F', mktime(0,0,0,$mes,1));
            break;
        default:
            $tituloReporte = 'Reporte del Sistema';
    }
    
    $pdf->setTitulo($tituloReporte);
    if(!empty($filtros)) {
        $pdf->setSubtitulo('Filtros: ' . implode(' | ', $filtros));
    }
    
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
    
    $pdf->AddPage();
    
    $datosProcesados = prepararDatosParaPDF($datos, $tipo);
    
    if(!empty($datosProcesados['datos'])) {
        // Generar tabla profesional con labels amigables
        $pdf->TablaProfesional($datosProcesados['headers'], $datosProcesados['datos']);
        
        // Agregar resumen si es aplicable
        $pdf->Ln(10);
        $pdf->Seccion('Resumen del Reporte');
        
        $resumen = [
            'Total de registros' => count($datos) . ' items',
            'Fecha de generacion' => date('d/m/Y H:i:s'),
            'Generado por' => isset($_SESSION['s_usuario']) ? $_SESSION['s_usuario']['nombre_usuario'] : 'Sistema'
        ];
        
        foreach($resumen as $label => $valor) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetTextColor(108, 117, 125);
            $pdf->Cell(60, 7, utf8_decode($label . ':'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetTextColor(33, 37, 41);
            $pdf->Cell(0, 7, utf8_decode($valor), 0, 1, 'L');
        }
    } else {
        $pdf->SetFont('Arial', 'I', 12);
        $pdf->SetTextColor(150, 150, 150);
        $pdf->Cell(0, 20, utf8_decode('No se encontraron datos para los filtros seleccionados.'), 0, 1, 'C');
    }
    
    $pdf->Output('I', 'Reporte_' . ucfirst($tipo) . '_' . date('Y-m-d') . '.pdf');
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
