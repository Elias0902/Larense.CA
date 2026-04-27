<?php

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está logueado
if (!isset($_SESSION['s_usuario'])) {
    header('Location: index.php?url=autenticator');
    exit();
}

// Cargar modelo de permisos
require_once 'app/models/PerfilSistemaModel.php';
$perfilModel = new PerfilSistema();

// Verificar permiso para acceder al dashboard (módulo 20, permiso 2 = Consultar)
$id_rol = $_SESSION['s_usuario']['id_rol_usuario'];
$tiene_permiso_dashboard = $perfilModel->VerificarPermiso($id_rol, 20, 2);

// Si no tiene permiso
if (!$tiene_permiso_dashboard) {
    // Si está en modo de simulación, redirigir a ecommerce
    if (isset($_SESSION['simulando_rol']) && $_SESSION['simulando_rol'] === true) {
        // Evitar bucle de redirección verificando si ya estamos intentando ir a ecommerce
        $current_url = $_SERVER['REQUEST_URI'] ?? '';
        if (strpos($current_url, 'ecommerce') === false) {
            header('Location: index.php?url=ecommerce');
            exit();
        }
    } else {
        // Si no está en modo simulación, mostrar 403
        header('Location: index.php?url=error&action=403');
        exit();
    }
}

// Cargar modelos necesarios
require_once 'app/models/TipoClienteModel.php';
require_once 'app/models/ProductoModel.php';
require_once 'app/models/ClienteModel.php';

// Obtener estadísticas de clientes por categoría
$tipoClienteModel = new TipoCliente();
$estadisticasCategorias = $tipoClienteModel->Estadisticas_Clientes_Por_Categoria();

// Obtener producto más vendido
$productoModel = new Producto();
$productoMasVendido = $productoModel->Producto_Mas_Vendido();

// Obtener últimos clientes registrados
$clienteModel = new Cliente();
$ultimosClientesData = $clienteModel->Ultimos_Clientes(4);
$ultimosClientes = [];
if ($ultimosClientesData['status'] && isset($ultimosClientesData['data'])) {
    $ultimosClientes = $ultimosClientesData['data'];
}

// Preparar datos para la vista
$categoriasClientes = [];
if ($estadisticasCategorias['status'] && isset($estadisticasCategorias['data'])) {
    $categoriasClientes = $estadisticasCategorias['data'];
}

// Datos del producto más vendido
$galletaTop = [
    'nombre' => 'Galletas de Chocolate',
    'categoria' => 'Chocolate',
    'unidades' => 1247,
    'ingresos' => 3740,
    'imagen' => null,
    'variacion' => '+18%'
];

if ($productoMasVendido['status'] && isset($productoMasVendido['data'])) {
    $data = $productoMasVendido['data'];
    $galletaTop['nombre'] = $data['nombre_producto'];
    $galletaTop['categoria'] = $data['nombre_categoria'];
    $galletaTop['unidades'] = $data['total_vendido'];
    $galletaTop['ingresos'] = number_format($data['total_ingresos'], 2);
    $galletaTop['imagen'] = $data['imagen_producto'];
}

// Definir colores y orden para las categorías (de más premium a más básico)
$ordenCategorias = ['Premium', 'Oro', 'Plata', 'Bronce'];
$coloresCategorias = [
    'Premium' => ['color' => '#9370DB', 'bg' => '#9370DB'], // Morado
    'Oro' => ['color' => '#FFD700', 'bg' => '#FFD700'],     // Dorado
    'Plata' => ['color' => '#C0C0C0', 'bg' => '#C0C0C0'],  // Plata
    'Bronce' => ['color' => '#CD7F32', 'bg' => '#CD7F32']  // Bronce
];

// Ordenar categorías según el orden definido
$categoriasOrdenadas = [];
foreach ($ordenCategorias as $nombreCat) {
    foreach ($categoriasClientes as $cat) {
        if (strcasecmp($cat['categoria'], $nombreCat) === 0) {
            $cat['color_config'] = $coloresCategorias[$nombreCat] ?? ['color' => '#6c757d', 'bg' => '#6c757d'];
            $categoriasOrdenadas[] = $cat;
            break;
        }
    }
}

// Si no hay datos de BD, usar datos por defecto con el orden correcto
if (empty($categoriasOrdenadas)) {
    foreach ($ordenCategorias as $nombreCat) {
        $categoriasOrdenadas[] = [
            'categoria' => $nombreCat,
            'total_clientes' => 1,
            'color_config' => $coloresCategorias[$nombreCat] ?? ['color' => '#6c757d', 'bg' => '#6c757d']
        ];
    }
}

require_once 'app/views/dashboardView.php';

?>