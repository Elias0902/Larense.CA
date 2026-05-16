<?php
/**
 * PDFTemplate profesional La Larense / Natys
 * - Logo como marca de agua centrada y semitransparente
 * - Header compacto, footer corporativo
 * - Tablas con diseño limpio y alternado
 * - Soporte UTF-8 real (sin utf8_decode deprecado)
 */

require_once 'vendor/setasign/fpdf/fpdf.php';

class PDFTemplate extends FPDF {
    // Datos corporativos
    protected $empresa   = 'La Larense de Alimentos C.A.';
    protected $marca     = 'Natys';
    protected $direccion = 'Carrera 3 entre calles 2 y 4, Zona Industrial II, Barquisimeto, Estado Lara';
    protected $telefono  = '+58 (251) 555-1234';
    protected $email     = 'ventas@lalarense.com';
    protected $rif       = 'J-12345678-0';

    // Rutas de imágenes
    protected $logoPath;       // Logo pequeño para el encabezado (esquina superior izquierda)
    protected $watermarkPath;  // Logo grande semitransparente para marca de agua central

    // Textos dinámicos
    protected $titulo    = '';
    protected $subtitulo = '';
    protected $fechaGeneracion;
    protected $usuario;

    // Colores corporativos
    const COLOR_PRIMARY   = [204, 29, 29];
    const COLOR_DARK      = [33, 37, 41];
    const COLOR_GRAY      = [108, 117, 125];
    const COLOR_LIGHT_BG  = [248, 249, 250];
    const COLOR_WHITE     = [255, 255, 255];
    const COLOR_GREEN     = [40, 167, 69];
    const COLOR_YELLOW    = [255, 193, 7];
    const COLOR_RED_ALERT = [204, 29, 29];

    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4') {
        parent::__construct($orientation, $unit, $size);

        // Buscar logo normal (pequeño)
        $this->logoPath = $this->findImage([
            'assets/img/natys/natys.png',
            'Assets/img/natys.png',
            '../../Assets/img/natys.png',
            $_SERVER['DOCUMENT_ROOT'] . '/larence/Assets/img/natys.png',
        ]);

        // Buscar logo para marca de agua (mismo archivo pero lo usaremos con transparencia)
        // Si no se configura otra ruta, usa el mismo logo.
        $this->watermarkPath = 'assets/img/natys/natys2.png';

        $this->fechaGeneracion = date('d/m/Y H:i:s');
        $this->usuario = $_SESSION['s_usuario']['nombre_usuario'] ?? 'Sistema';

        $this->SetMargins(15, 20, 15);
        $this->SetAutoPageBreak(true, 30);
        $this->SetTitle('Reporte - ' . $this->empresa);
    }

    /**
     * Busca la primera imagen existente entre una lista de rutas.
     */
    private function findImage(array $paths): ?string {
        foreach ($paths as $path) {
            if (file_exists($path)) return $path;
        }
        return null;
    }

    /**
     * Convierte UTF-8 a ISO-8859-1 de forma segura.
     */
    protected function encode($str): string {
        return mb_convert_encoding($str, 'ISO-8859-1', 'UTF-8');
    }

    // ------------------------------------------------------------------------
    // HEADER Y FOOTER
    // ------------------------------------------------------------------------

    public function Header() {
        // --- Marca de agua centrada (logo semitransparente) ---
        if ($this->watermarkPath) {
            // Calculamos dimensiones para centrarla y darle tamaño adecuado
            $pageWidth = $this->GetPageWidth();
            $pageHeight = $this->GetPageHeight();
            $imgWidth = 100;  // Ancho deseado (mm)
            $imgHeight = 0;   // Se calcula automáticamente manteniendo proporción

            // Posición: centro absoluto de la página
            $x = ($pageWidth - $imgWidth) / 2;
            $y = ($pageHeight - $imgHeight) / 2; // FPDF ajusta si height = 0

            // Opacidad: la imagen debe ser PNG con transparencia (canal alfa)
            // Si se usa el mismo logo, debe ser una versión con opacidad reducida.
            $this->Image($this->watermarkPath, $x, $y, $imgWidth, $imgHeight, 'PNG');
        }

        // --- Cabecera superior (barra roja, logo pequeño, info empresa) ---
        $this->SetFillColor(...self::COLOR_PRIMARY);
        $this->Rect(0, 0, 210, 2.5, 'F');

        $this->SetY(4);
        // Logo pequeño a la izquierda
        if ($this->logoPath) {
            $this->Image($this->logoPath, 15, 6, 18, 0, 'PNG');
            $xStart = 38;
        } else {
            $xStart = 15;
        }

        // Info empresa alineada a la derecha
        $this->SetXY(120, 6);
        $this->SetFont('Arial', 'B', 13);
        $this->SetTextColor(...self::COLOR_PRIMARY);
        $this->Cell(75, 6, $this->encode($this->empresa), 0, 1, 'R');

        $this->SetX(120);
        $this->SetFont('Arial', '', 8);
        $this->SetTextColor(...self::COLOR_GRAY);
        $this->Cell(75, 4, $this->encode($this->direccion), 0, 1, 'R');

        $this->SetX(120);
        $this->Cell(75, 4, $this->encode("Telf: {$this->telefono}  |  Email: {$this->email}"), 0, 1, 'R');

        // Línea separadora
        $this->SetDrawColor(...self::COLOR_PRIMARY);
        $this->SetLineWidth(0.4);
        $this->Line(15, 23, 195, 23);

        // Título del reporte
        $this->Ln(8);
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(...self::COLOR_DARK);
        $this->Cell(0, 10, $this->encode($this->titulo), 0, 1, 'C');

        if ($this->subtitulo) {
            $this->SetFont('Arial', '', 10);
            $this->SetTextColor(...self::COLOR_GRAY);
            $this->Cell(0, 6, $this->encode($this->subtitulo), 0, 1, 'C');
        }
        $this->Ln(5);
    }

    public function Footer() {
        $this->SetY(-25);
        // Línea roja fina
        $this->SetDrawColor(...self::COLOR_PRIMARY);
        $this->SetLineWidth(0.3);
        $this->Line(15, $this->GetY(), 195, $this->GetY());

        // Info pie
        $this->SetY(-20);
        $this->SetFont('Arial', 'I', 7);
        $this->SetTextColor(...self::COLOR_GRAY);
        $this->Cell(90, 5, $this->encode("Generado: {$this->fechaGeneracion} | Usuario: {$this->usuario}"), 0, 0, 'L');
        $this->Cell(90, 5, $this->encode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'R');

        $this->SetY(-15);
        $this->SetFont('Arial', '', 6);
        $this->SetTextColor(150);
        $this->Cell(0, 4, $this->encode("{$this->empresa} | {$this->marca} - Documento confidencial"), 0, 1, 'C');
    }

    // ------------------------------------------------------------------------
    // SETTERS
    // ------------------------------------------------------------------------
    public function setTitulo(string $titulo) {
        $this->titulo = $titulo;
        $this->SetTitle($this->encode($titulo));
    }
    public function setSubtitulo(string $subtitulo) {
        $this->subtitulo = $subtitulo;
    }
    public function setUsuario(string $nombre) {
        $this->usuario = $nombre;
    }
    /**
     * Establece una ruta personalizada para el logo pequeño del encabezado.
     */
    public function setLogo(string $path) {
        if (file_exists($path)) $this->logoPath = $path;
    }
    /**
     * Establece la ruta de la imagen para la marca de agua central.
     * Debe ser un PNG con transparencia (ej. logo con 20% opacidad).
     */
    public function setWatermark(string $path) {
        if (file_exists($path)) $this->watermarkPath = $path;
    }

    // ------------------------------------------------------------------------
    // TABLAS PROFESIONALES
    // ------------------------------------------------------------------------
    public function TablaProfesional(array $headers, array $datos, array $anchos = []) {
        $anchoTotal = 180;
        if (empty($anchos)) {
            $anchoCol = $anchoTotal / count($headers);
            $anchos = array_fill(0, count($headers), $anchoCol);
        }

        // Encabezado
        $this->SetFillColor(...self::COLOR_PRIMARY);
        $this->SetTextColor(...self::COLOR_WHITE);
        $this->SetFont('Arial', 'B', 9);
        $this->SetDrawColor(210);
        foreach ($headers as $i => $header) {
            $this->Cell($anchos[$i], 9, $this->encode(strtoupper($header)), 1, 0, 'C', true);
        }
        $this->Ln();

        // Datos
        $this->SetTextColor(...self::COLOR_DARK);
        $this->SetFont('Arial', '', 8);
        $fill = false;
        $altColor = [245, 245, 245];
        foreach ($datos as $fila) {
            $bg = $fill ? $altColor : self::COLOR_WHITE;
            $this->SetFillColor(...$bg);
            $i = 0;
            foreach ($fila as $valor) {
                $this->Cell($anchos[$i], 7, $this->encode($valor), 'LR', 0, 'L', true);
                $i++;
            }
            $this->Ln();
            $fill = !$fill;
        }
        $this->SetDrawColor(180);
        $this->Cell(array_sum($anchos), 0, '', 'T');
        $this->Ln(4);
    }

    public function TablaCreditosClientes(array $headers, array $datos, array $anchos = []) {
        // Similar a TablaProfesional pero con resaltado en la columna de días (índice 3)
        if (empty($anchos)) {
            $anchoTotal = 180;
            $anchoCol = $anchoTotal / count($headers);
            $anchos = array_fill(0, count($headers), $anchoCol);
        }
        $this->SetFillColor(...self::COLOR_PRIMARY);
        $this->SetTextColor(...self::COLOR_WHITE);
        $this->SetFont('Arial', 'B', 9);
        foreach ($headers as $i => $header) {
            $this->Cell($anchos[$i], 9, $this->encode(strtoupper($header)), 1, 0, 'C', true);
        }
        $this->Ln();

        $this->SetTextColor(...self::COLOR_DARK);
        $this->SetFont('Arial', '', 8);
        $fill = false;
        $altColor = [245, 245, 245];
        foreach ($datos as $fila) {
            $bg = $fill ? $altColor : self::COLOR_WHITE;
            $this->SetFillColor(...$bg);
            $i = 0;
            foreach ($fila as $valor) {
                if ($i === 3 && is_numeric($valor) && $valor > 15) {
                    $this->SetTextColor(...self::COLOR_RED_ALERT);
                    $this->SetFont('Arial', 'B', 8);
                    $this->Cell($anchos[$i], 7, $this->encode($valor), 'LR', 0, 'C', true);
                    $this->SetFont('Arial', '', 8);
                    $this->SetTextColor(...self::COLOR_DARK);
                } else {
                    $this->Cell($anchos[$i], 7, $this->encode($valor), 'LR', 0, 'L', true);
                }
                $i++;
            }
            $this->Ln();
            $fill = !$fill;
        }
        $this->Cell(array_sum($anchos), 0, '', 'T');
        $this->Ln(4);
    }

    // ------------------------------------------------------------------------
    // SECCIONES Y NOTAS
    // ------------------------------------------------------------------------
    public function Seccion(string $titulo) {
        $this->Ln(4);
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(...self::COLOR_PRIMARY);
        $this->Cell(0, 7, $this->encode($titulo), 0, 1, 'L');
        $this->SetDrawColor(...self::COLOR_PRIMARY);
        $this->Line(15, $this->GetY(), 195, $this->GetY());
        $this->Ln(5);
    }

    public function ResumenEstadistico(string $titulo, array $datos) {
        $this->Seccion($titulo);
        $this->SetFillColor(...self::COLOR_LIGHT_BG);
        $this->SetFont('Arial', 'B', 9);
        $wLabel = 80;
        $wValue = 100;
        foreach ($datos as $label => $valor) {
            $this->Cell($wLabel, 8, $this->encode($label), 'LBR', 0, 'L', true);
            $this->Cell($wValue, 8, $this->encode($valor), 'BR', 1, 'R', true);
        }
        $this->Ln(4);
    }

    public function Nota(string $texto) {
        $this->Ln(3);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(...self::COLOR_GRAY);
        $this->MultiCell(0, 5, $this->encode($texto), 0, 'L');
    }

    public function EstadoPago(string $estado): array {
        return match (strtolower($estado)) {
            'pagado', 'confirmado' => self::COLOR_GREEN,
            'pendiente', 'por pagar' => self::COLOR_YELLOW,
            'vencido', 'atrasado' => self::COLOR_RED_ALERT,
            default => self::COLOR_GRAY,
        };
    }

    public function InfoEmpresa(): array {
        return [
            'empresa' => $this->empresa,
            'marca'   => $this->marca,
            'direccion' => $this->direccion,
            'telefono'  => $this->telefono,
            'email'     => $this->email,
            'rif'       => $this->rif,
        ];
    }
}