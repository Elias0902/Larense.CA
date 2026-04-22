<?php
require_once 'vendor/setasign/fpdf/fpdf.php';

class PDFTemplate extends FPDF {
    protected $logoPath;
    protected $titulo;
    protected $subtitulo;
    protected $empresa = 'La Larense de Alimentos C.A.';
    protected $marca = 'Natys';
    protected $direccion = 'Carrera 3 entre calles 2 y 4, Zona Industrial II, Barquisimeto, Estado Lara';
    protected $telefono = '+58 (251) 555-1234';
    protected $email = 'ventas@lalarense.com';
    protected $fechaGeneracion;
    protected $usuario;
    
    public function __construct($orientation='P', $unit='mm', $size='A4') {
        parent::__construct($orientation, $unit, $size);
        
        // Ruta fija del logo (desde la ubicación del helper)
        // D:\XAAMP\htdocs\larence\Assets\img\natys.png
        // El helper está en: D:\XAAMP\htdocs\larence\App\helpers\PDFTemplate.php
        // La ruta relativa desde el helper hacia el logo sería: ../../Assets/img/natys.png
        $logoPathFromHelper = '../../Assets/img/natys.png';
        
        if(file_exists($logoPathFromHelper)) {
            $this->logoPath = $logoPathFromHelper;
        } else {
            // Buscar también en otras ubicaciones comunes como fallback
            $possibleLogos = [
                'Assets/img/natys.png',
                'Assets/img/logo.png',
                'Assets/img/logoproduct.png',
                '../../Assets/img/natys.png',
                '../../../Assets/img/natys.png',
                $_SERVER['DOCUMENT_ROOT'] . '/larence/Assets/img/natys.png',
                'D:/XAAMP/htdocs/larence/Assets/img/natys.png'
            ];
            foreach($possibleLogos as $logo) {
                if(file_exists($logo)) {
                    $this->logoPath = $logo;
                    break;
                }
            }
        }
        
        $this->fechaGeneracion = date('d/m/Y H:i:s');
        $this->usuario = isset($_SESSION['s_usuario']) ? $_SESSION['s_usuario']['nombre_usuario'] : 'Sistema';
        
        // Activar auto page break con margen para footer
        $this->SetAutoPageBreak(true, 35);
    }
    
    // Header con logo y formato profesional de La Larense
    public function Header() {
        // Fondo de color claro en el header
        $this->SetFillColor(248, 249, 250);
        $this->Rect(0, 0, 210, 42, 'F');
        
        // Linea decorativa superior (rojo corporativo)
        $this->SetFillColor(204, 29, 29); // Rojo #cc1d1d
        $this->Rect(0, 0, 210, 3, 'F');
        
        // Logo (solo si existe y es formato compatible con FPDF)
        if($this->logoPath && file_exists($this->logoPath)) {
            $this->Image($this->logoPath, 10, 8, 22, 0, 'PNG');
            $xOffset = 38; // Desplazamiento cuando hay logo
        } else {
            $xOffset = 10; // Sin desplazamiento si no hay logo
        }
        
        // Nombre de la empresa
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(204, 29, 29); // Rojo #cc1d1d
        $this->SetXY($xOffset, 9);
        $this->Cell(0, 7, utf8_decode($this->empresa), 0, 1, 'L');
        
        // Marca filial
        $this->SetFont('Arial', 'B', 11);
        $this->SetTextColor(204, 29, 29);
        $this->SetX($xOffset);
        $this->Cell(0, 5, utf8_decode('Marca: ' . $this->marca), 0, 1, 'L');
        
        // Subtitulo corporativo
        $this->SetFont('Arial', '', 8);
        $this->SetTextColor(108, 117, 125); // Gris
        $this->SetX($xOffset);
        $this->Cell(0, 4, utf8_decode('Elaboración y comercialización de productos de galletería y pastelería'), 0, 1, 'L');
        
        // Informacion de contacto
        $this->SetFont('Arial', '', 7);
        $this->SetTextColor(100, 100, 100);
        $this->SetX($xOffset);
        $this->Cell(0, 4, utf8_decode('Dirección: ' . $this->direccion), 0, 1, 'L');
        $this->SetX($xOffset);
        $this->Cell(0, 4, utf8_decode('Teléfono: ' . $this->telefono . ' | Email: ' . $this->email), 0, 1, 'L');
        
        // Linea separadora
        $this->SetDrawColor(204, 29, 29);
        $this->Line(10, 44, 200, 44);
        
        // Titulo del reporte
        $this->SetY(50);
        $this->SetFont('Arial', 'B', 14);
        $this->SetTextColor(33, 37, 41);
        $this->Cell(0, 10, utf8_decode($this->titulo), 0, 1, 'C');
        
        // Subtitulo/filtros aplicados
        if($this->subtitulo) {
            $this->SetFont('Arial', '', 10);
            $this->SetTextColor(108, 117, 125);
            $this->Cell(0, 6, utf8_decode($this->subtitulo), 0, 1, 'C');
        }
        
        // Espacio antes del contenido
        $this->Ln(8);
    }
    
    // Footer con info de pagina y generacion
    public function Footer() {
        $this->SetY(-28);
        
        // Linea separadora
        $this->SetDrawColor(204, 29, 29);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        
        // Info de generacion
        $this->SetY(-23);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(108, 117, 125);
        $this->Cell(0, 5, utf8_decode('Generado el: ' . $this->fechaGeneracion . ' | Usuario: ' . $this->usuario), 0, 0, 'L');
        
        // Numeracion de pagina
        $this->Cell(0, 5, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
        
        // Nota legal y confidencialidad
        $this->SetY(-14);
        $this->SetFont('Arial', '', 7);
        $this->SetTextColor(150, 150, 150);
        $this->Cell(0, 4, utf8_decode('Este documento es confidencial y para uso interno de ' . $this->empresa . '. Natys - 100% venezolana'), 0, 0, 'C');
    }
    
    // Metodo para establecer titulo
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }
    
    // Metodo para establecer subtitulo/filtros
    public function setSubtitulo($subtitulo) {
        $this->subtitulo = $subtitulo;
    }
    
    // Metodo para establecer logo personalizado
    public function setLogo($path) {
        if(file_exists($path)) {
            $this->logoPath = $path;
        }
    }
    
    // Metodo para obtener el titulo principal del sistema
    public function getSistemaTitulo() {
        return 'Sistema de Gestión de Pedidos, Créditos y Compras para La Larense C.A.';
    }
    
    // Tabla con estilo profesional rojo corporativo
    public function TablaProfesional($headers, $datos, $anchos = []) {
        // Colores del encabezado (rojo corporativo)
        $this->SetFillColor(204, 29, 29);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 9);
        $this->SetDrawColor(200, 200, 200);
        
        // Calcular anchos si no se proporcionan
        if(empty($anchos)) {
            $anchoTotal = 190;
            $anchoCol = $anchoTotal / count($headers);
            $anchos = array_fill(0, count($headers), $anchoCol);
        }
        
        // Encabezados
        foreach($headers as $i => $header) {
            $this->Cell($anchos[$i], 10, utf8_decode(strtoupper($header)), 1, 0, 'C', true);
        }
        $this->Ln();
        
        // Datos
        $this->SetFillColor(248, 249, 250);
        $this->SetTextColor(33, 37, 41);
        $this->SetFont('Arial', '', 8);
        
        $fill = false;
        foreach($datos as $fila) {
            // Alternar colores
            $this->SetFillColor($fill ? 248 : 255, $fill ? 249 : 255, $fill ? 250 : 255);
            
            $i = 0;
            foreach($fila as $valor) {
                $this->Cell($anchos[$i], 8, utf8_decode($valor), 'LR', 0, 'L', true);
                $i++;
            }
            $this->Ln();
            $fill = !$fill;
        }
        
        // Linea de cierre
        $this->Cell(array_sum($anchos), 0, '', 'T');
        $this->Ln();
    }
    
    // Tabla con formato de resumen de créditos (especial para clientes)
    public function TablaCreditosClientes($headers, $datos, $anchos = []) {
        // Colores del encabezado (rojo corporativo)
        $this->SetFillColor(204, 29, 29);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 9);
        $this->SetDrawColor(200, 200, 200);
        
        if(empty($anchos)) {
            $anchoTotal = 190;
            $anchoCol = $anchoTotal / count($headers);
            $anchos = array_fill(0, count($headers), $anchoCol);
        }
        
        foreach($headers as $i => $header) {
            $this->Cell($anchos[$i], 10, utf8_decode(strtoupper($header)), 1, 0, 'C', true);
        }
        $this->Ln();
        
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(33, 37, 41);
        $this->SetFont('Arial', '', 8);
        
        foreach($datos as $fila) {
            $i = 0;
            foreach($fila as $valor) {
                // Resaltar días de crédito vencidos (si aplica)
                if($i == 3 && is_numeric($valor) && $valor > 15) { // Columna días de crédito
                    $this->SetTextColor(204, 29, 29);
                    $this->SetFont('Arial', 'B', 8);
                    $this->Cell($anchos[$i], 8, utf8_decode($valor), 'LR', 0, 'C', true);
                    $this->SetFont('Arial', '', 8);
                    $this->SetTextColor(33, 37, 41);
                } else {
                    $this->Cell($anchos[$i], 8, utf8_decode($valor), 'LR', 0, 'L', true);
                }
                $i++;
            }
            $this->Ln();
        }
        
        $this->Cell(array_sum($anchos), 0, '', 'T');
        $this->Ln();
    }
    
    // Resumen estadistico con estilo La Larense
    public function ResumenEstadistico($titulo, $datos) {
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 11);
        $this->SetTextColor(204, 29, 29);
        $this->Cell(0, 8, utf8_decode($titulo), 0, 1, 'L');
        
        $this->SetFillColor(248, 249, 250);
        $this->SetDrawColor(204, 29, 29);
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(33, 37, 41);
        
        foreach($datos as $label => $valor) {
            $this->Cell(80, 8, utf8_decode($label), 'LB', 0, 'L', true);
            $this->Cell(0, 8, utf8_decode($valor), 'RB', 1, 'R', true);
        }
        $this->Ln(5);
    }
    
    // Metodo para encabezado de seccion con estilo rojo
    public function Seccion($titulo) {
        $this->Ln(8);
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(204, 29, 29);
        $this->Cell(0, 8, utf8_decode($titulo), 0, 1, 'L');
        
        $this->SetDrawColor(204, 29, 29);
        $this->Line($this->GetX(), $this->GetY(), $this->GetX() + 190, $this->GetY());
        $this->Ln(5);
    }
    
    // Metodo para nota o mensaje
    public function Nota($texto) {
        $this->Ln(5);
        $this->SetFont('Arial', 'I', 9);
        $this->SetTextColor(108, 117, 125);
        $this->MultiCell(0, 5, utf8_decode($texto), 0, 'L');
        $this->Ln(3);
    }
    
    // Metodo para mostrar estado de pago con colores
    public function EstadoPago($estado) {
        switch(strtolower($estado)) {
            case 'pagado':
            case 'confirmado':
                $this->SetTextColor(40, 167, 69); // Verde
                break;
            case 'pendiente':
            case 'por pagar':
                $this->SetTextColor(255, 193, 7); // Amarillo
                break;
            case 'vencido':
            case 'atrasado':
                $this->SetTextColor(204, 29, 29); // Rojo
                break;
            default:
                $this->SetTextColor(108, 117, 125); // Gris
        }
        return $estado;
    }
    
    // Informacion de la empresa para reportes
    public function InfoEmpresa() {
        return [
            'empresa' => $this->empresa,
            'marca' => $this->marca,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'rif' => 'J-12345678-0', // Agregar si tienes el RIF real
            'slogan' => 'Galletas y Dulces Artesanales - 100% venezolana'
        ];
    }
}
?>