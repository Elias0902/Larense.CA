<?php
// Iniciar sesión primero
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cargar modelos usando ruta absoluta
require_once __DIR__ . '/../models/ProductoModel.php';

// Instanciar modelo
$productoModel = new Producto();

// Consultar productos
$productos_result = $productoModel->manejarAccion('consultar', null);
$productos = ($productos_result['status'] === true) ? $productos_result['data'] : [];

// Filtrar productos con stock disponible (> 0 unidades)
$productos_con_stock = array_filter($productos, function($prod) {
    return isset($prod['stock']) && $prod['stock'] > 0;
});

// Mostrar todos los productos disponibles
$productos_destacados = array_slice($productos_con_stock, 0, 20);

// Función helper para obtener la imagen
function getProductImage($img) {
    // Usar ruta absoluta para verificar existencia
    $basePath = dirname(__DIR__, 2);
    if (!empty($img) && file_exists($basePath . '/' . $img)) {
        return $img;
    }
    return 'Assets/img/natys/natys.png';
}

// Función helper para el badge de stock
function getStockBadge($stock) {
    if ($stock <= 0) {
        return ['class' => 'stock-out', 'text' => 'SIN STOCK'];
    } elseif ($stock <= 5) {
        return ['class' => 'stock-low', 'text' => 'ÚLTIMAS ' . $stock . ' UNIDADES'];
    } elseif ($stock <= 15) {
        return ['class' => 'stock-low', 'text' => 'POCO STOCK'];
    } else {
        return ['class' => 'stock-available', 'text' => 'DISPONIBLE'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naty's - Galletas 100% Venezolanas</title>
    <link rel="icon" type="image/png" href="Assets/img/natys/natys.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --natys-red: #cc1d1d;
            --natys-dark-red: #8b1515;
            --natys-light: #fff5f5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, var(--natys-red) 0%, var(--natys-dark-red) 100%) !important;
            padding: 15px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }

        .navbar-brand img {
            height: 50px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        }

        .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 500;
            padding: 10px 20px !important;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #ffd700 !important;
            transform: translateY(-2px);
        }

        .btn-nav {
            background: #fff;
            color: var(--natys-red) !important;
            border-radius: 25px;
            padding: 8px 20px !important;
            font-weight: 600;
            margin-left: 10px;
            transition: all 0.3s ease;
        }

        .btn-nav:hover {
            background: #ffd700;
            color: var(--natys-dark-red) !important;
            transform: scale(1.05);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--natys-red) 0%, var(--natys-dark-red) 100%);
            min-height: 80vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="0.5"/></svg>');
            background-size: 150px;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.3rem;
            color: rgba(255,255,255,0.9);
            margin-bottom: 30px;
        }

        .hero-logo {
            max-width: 350px;
            filter: drop-shadow(0 10px 30px rgba(0,0,0,0.3));
        }

        .btn-hero {
            background: #fff;
            color: var(--natys-red);
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            border: none;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-hero:hover {
            background: #ffd700;
            color: var(--natys-dark-red);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        /* Section Styles */
        .section {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--natys-dark-red);
            margin-bottom: 15px;
        }

        .section-title .line {
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--natys-red), var(--natys-dark-red));
            margin: 0 auto;
            border-radius: 2px;
        }

        /* Quienes Somos */
        .about {
            background: #fff;
        }

        .about-text {
            font-size: 1.15rem;
            line-height: 1.8;
            color: #555;
        }

        .about-highlight {
            background: linear-gradient(135deg, var(--natys-light) 0%, #fff 100%);
            border-left: 5px solid var(--natys-red);
            padding: 30px;
            border-radius: 0 15px 15px 0;
            margin-top: 30px;
        }

        /* Historia Timeline */
        .history {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .timeline {
            position: relative;
            padding: 20px 0;
        }

        .timeline-item {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
            margin-bottom: 30px;
            position: relative;
            border-left: 5px solid var(--natys-red);
        }

        .timeline-year {
            background: linear-gradient(135deg, var(--natys-red) 0%, var(--natys-dark-red) 100%);
            color: #fff;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 1.2rem;
            display: inline-block;
            margin-bottom: 20px;
        }

        .timeline-text {
            font-size: 1.1rem;
            color: #555;
            line-height: 1.8;
        }

        /* Mision Vision */
        .mission-vision {
            background: #fff;
        }

        .mv-card {
            background: linear-gradient(135deg, #fff 0%, var(--natys-light) 100%);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(204, 29, 29, 0.1);
            height: 100%;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .mv-card:hover {
            transform: translateY(-10px);
            border-color: var(--natys-red);
        }

        .mv-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--natys-red) 0%, var(--natys-dark-red) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
        }

        .mv-icon i {
            font-size: 2rem;
            color: #fff;
        }

        .mv-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--natys-dark-red);
            margin-bottom: 15px;
        }

        .mv-card p {
            font-size: 1.05rem;
            color: #666;
            line-height: 1.7;
        }

        /* Valores */
        .values {
            background: linear-gradient(135deg, var(--natys-red) 0%, var(--natys-dark-red) 100%);
            color: #fff;
        }

        .values .section-title h2 {
            color: #fff;
        }

        .values .section-title .line {
            background: #fff;
        }

        .value-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            padding: 35px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(255,255,255,0.2);
            height: 100%;
        }

        .value-card:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.2);
        }

        .value-icon {
            font-size: 2.5rem;
            color: #ffd700;
            margin-bottom: 20px;
        }

        .value-card h4 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .value-card p {
            font-size: 0.95rem;
            opacity: 0.9;
            line-height: 1.6;
        }

        /* Unete al equipo */
        .join-team {
            background: #fff;
            text-align: center;
        }

        .join-box {
            background: linear-gradient(135deg, var(--natys-light) 0%, #fff 100%);
            padding: 60px;
            border-radius: 20px;
            border: 2px dashed var(--natys-red);
        }

        .join-box h3 {
            font-size: 2rem;
            color: var(--natys-dark-red);
            margin-bottom: 20px;
        }

        .join-box p {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 25px;
        }

        .email-link {
            color: var(--natys-red);
            font-weight: 600;
            font-size: 1.2rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .email-link:hover {
            color: var(--natys-dark-red);
            text-decoration: underline;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #2c3e50 0%, #1a252f 100%);
            color: #fff;
            padding: 60px 0 30px;
        }

        .footer-logo {
            max-width: 200px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
            margin-bottom: 20px;
        }

        .footer h5 {
            color: #ffd700;
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 1.1rem;
        }

        .footer ul {
            list-style: none;
            padding: 0;
        }

        .footer ul li {
            margin-bottom: 10px;
        }

        .footer ul li a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer ul li a:hover {
            color: var(--natys-red);
        }

        .footer-contact {
            color: rgba(255,255,255,0.8);
            margin-bottom: 10px;
        }

        .footer-contact i {
            color: var(--natys-red);
            margin-right: 10px;
            width: 20px;
        }

        .social-links {
            margin-top: 20px;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            color: #fff;
            margin-right: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-links a:hover {
            background: var(--natys-red);
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: 40px;
            padding-top: 20px;
            text-align: center;
            color: rgba(255,255,255,0.6);
            font-size: 0.9rem;
        }

        /* Product Cards - Destacados */
        .products-destacados {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 80px 0;
        }

        .product-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .product-image {
            height: 200px;
            background: linear-gradient(135deg, var(--natys-light) 0%, #ffe0e0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .product-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .product-image i {
            font-size: 4rem;
            color: var(--natys-red);
        }

        .stock-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .stock-available { background: #28a745; color: #fff; }
        .stock-low { background: #ffc107; color: #333; }
        .stock-out { background: #dc3545; color: #fff; }

        .category-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255,255,255,0.95);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--natys-red);
        }

        .product-info { padding: 25px; }

        .product-info h5 {
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
            font-size: 1rem;
        }

        .product-info .category {
            color: var(--natys-red);
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .product-info .description {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--natys-red);
            margin-bottom: 15px;
        }

        .btn-add-cart {
            width: 100%;
            background: var(--natys-red);
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-add-cart:hover {
            background: var(--natys-dark-red);
            transform: scale(1.02);
        }

        .btn-add-cart:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .btn-ver-tienda {
            display: inline-block;
            background: var(--natys-red);
            color: #fff;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-top: 30px;
            border: none;
            cursor: pointer;
        }

        .btn-ver-tienda:hover {
            background: var(--natys-dark-red);
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .productos-extra {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            
            .section-title h2 {
                font-size: 1.8rem;
            }
            
            .hero-logo {
                max-width: 200px;
                margin-top: 30px;
            }
            
            .join-box {
                padding: 30px;
            }
            
            .timeline-item {
                padding: 25px;
            }
            
            .mv-card {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="Assets/img/natys/natys.png" alt="Naty's">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#inicio">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#nosotros">Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link" href="#productos">Productos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#aliado">Ser Aliado</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
                    <li class="nav-item"><a class="btn-nav" href="../index.php?url=autenticator"><i class="fas fa-user me-2"></i>Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="inicio" style="padding-top: 100px;">
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1>Galletas 100% Venezolanas</h1>
                    <p>Elaboradas con los más altos estándares de calidad y nutrición para toda la familia.</p>
                    <a href="#productos" class="btn-hero">Ver Productos <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="Assets/img/natys/natys.png" alt="Naty's Logo" class="hero-logo">
                </div>
            </div>
        </div>
    </section>

    <!-- Productos Destacados -->
    <section class="products-destacados" id="productos">
        <div class="container">
            <div class="section-title">
                <h2>Productos Destacados</h2>
                <div class="line"></div>
            </div>
            
            <?php if (empty($productos_destacados)): ?>
                <div class="text-center">
                    <i class="fas fa-cookie-bite fa-3x mb-3" style="color: var(--natys-red);"></i>
                    <h4>No hay productos disponibles</h4>
                    <p class="text-muted">Vuelve más tarde para ver nuestras deliciosas galletas.</p>
                </div>
            <?php else: ?>
                <div class="row" id="productos-iniciales">
                    <?php foreach ($productos_destacados as $prod):
                        $stock_info = getStockBadge($prod['stock']);
                        $imagen = getProductImage($prod['img'] ?? '');
                    ?>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="product-card">
                                <div class="product-image">
                                    <span class="stock-badge <?php echo $stock_info['class']; ?>"><?php echo $stock_info['text']; ?></span>
                                    <span class="category-badge"><?php echo htmlspecialchars($prod['nombre_categoria']); ?></span>
                                    <?php if (!empty($prod['img']) && file_exists(dirname(__DIR__, 2) . '/' . $prod['img'])): ?>
                                        <img src="<?php echo $imagen; ?>" alt="<?php echo htmlspecialchars($prod['nombre_producto']); ?>">
                                    <?php else: ?>
                                        <i class="fas fa-cookie"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="product-info">
                                    <h5><?php echo htmlspecialchars($prod['nombre_producto']); ?></h5>
                                    <p class="category"><?php echo htmlspecialchars($prod['nombre_categoria']); ?></p>
                                    <p class="description">Producto artesanal de alta calidad</p>
                                    <div class="product-price">$<?php echo number_format($prod['precio_venta'], 2); ?></div>
                                    <?php if ($prod['stock'] > 0): ?>
                                        <button class="btn-add-cart" onclick="window.location.href='../check_cart_login.php'">
                                            <i class="fas fa-shopping-cart"></i>Agregar
                                        </button>
                                    <?php else: ?>
                                        <button class="btn-add-cart" disabled>
                                            <i class="fas fa-ban"></i>Sin Stock
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>
        </div>
    </section>

    <!-- Quienes Somos -->
    <section class="section about" id="nosotros">
        <div class="container">
            <div class="section-title">
                <h2>¿Quiénes somos?</h2>
                <div class="line"></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <p class="about-text text-center">
                        <strong>Naty's</strong> es una marca 100% venezolana, que cree en el crecimiento del país y su gente aun cuando el horizonte pinte obstáculos. Nacida en diciembre de 2014 como marca filial de <strong>Larense de Alimentos, C.A</strong> con el claro objetivo de satisfacer la alta y exigente demanda de los consumidores en Venezuela y fuera de ella, elaborando galletas con los más altos estándares de calidad y nutrición.
                    </p>
                    <div class="about-highlight">
                        <p class="mb-0"><i class="fas fa-heart text-danger me-2"></i>Comprometidos con la calidad, la tradición y el sabor que caracteriza a los productos venezolanos.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Historia -->
    <section class="section history">
        <div class="container">
            <div class="section-title">
                <h2>Nuestra Historia</h2>
                <div class="line"></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="timeline">
                        <div class="timeline-item">
                            <span class="timeline-year">2002</span>
                            <p class="timeline-text">
                                Desde el año 2002 su fundador, el <strong>Sr. Rances González</strong>, quien con más de 20 años de trayectoria en el ramo comercial adquirió su primera máquina artesanal para elaborar galletas, lo que le proporcionó mayor rentabilidad en sus operaciones comerciales, gracias a la rápida aceptación en los hogares venezolanos, por su calidad y relación precio valor; el trabajo en el ramo galletero siguió fortaleciéndose poco a poco con la adquisición de nuevas maquinas.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mision y Vision -->
    <section class="section mission-vision">
        <div class="container">
            <div class="section-title">
                <h2>Misión y Visión</h2>
                <div class="line"></div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="mv-card">
                        <div class="mv-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3>Misión</h3>
                        <p>Fabricar y comercializar, productos de galletería y pastelería, producidos bajo los más altos estándares de calidad, tecnología y un excelente talento humano, generando así la mayor suma de satisfacción y confianza a nuestros aliados comerciales y clientes.</p>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="mv-card">
                        <div class="mv-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3>Visión</h3>
                        <p>Consolidarnos como una de las principales marcas de productos alimenticios en el país, anclándonos en el paladar de la familia venezolana siendo reconocidos por nuestra excelente calidad y relación precio/valor.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Valores -->
    <section class="section values">
        <div class="container">
            <div class="section-title">
                <h2>Nuestros Valores</h2>
                <div class="line"></div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card">
                        <div class="value-icon"><i class="fas fa-hand-holding-heart"></i></div>
                        <h4>Honestidad</h4>
                        <p>Actuamos con transparencia y rectitud, en cada una de las facetas de nuestro quehacer diario.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card">
                        <div class="value-icon"><i class="fas fa-award"></i></div>
                        <h4>Calidad</h4>
                        <p>Cuidamos los detalles, manteniendo los estándares, la inocuidad y la utilización de materias primas certificadas.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card">
                        <div class="value-icon"><i class="fas fa-handshake"></i></div>
                        <h4>Responsabilidad</h4>
                        <p>Cumplimos cabalmente con nuestros compromisos con ética, respeto y puntualidad.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card">
                        <div class="value-icon"><i class="fas fa-chart-line"></i></div>
                        <h4>Productividad</h4>
                        <p>Somos altamente proactivos y eficientes, cuidamos nuestros recursos e invertimos sabiamente en el tiempo.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card">
                        <div class="value-icon"><i class="fas fa-tasks"></i></div>
                        <h4>Disciplina</h4>
                        <p>Trabajamos de manera planificada, ordenada y constante, para alcanzar nuestros objetivos.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-card">
                        <div class="value-icon"><i class="fas fa-trophy"></i></div>
                        <h4>Competitividad</h4>
                        <p>Garantizamos productos de excelente calidad y relación precio/beneficio a nuestros consumidores.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Unete al equipo -->
    <section class="section join-team">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="join-box">
                        <div class="value-icon" style="color: var(--natys-red);"><i class="fas fa-users fa-3x"></i></div>
                        <h3>Únete a nuestro equipo de trabajo</h3>
                        <p>¿Quieres formar parte de la familia Naty's? Envía tu currículo vitae</p>
                        <a href="mailto:rrhh@natys.com.ve" class="email-link"><i class="fas fa-envelope me-2"></i>rrhh@natys.com.ve</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contacto">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <img src="Assets/img/natys/natys.png" alt="Naty's" class="footer-logo">
                    <p style="color: rgba(255,255,255,0.8); line-height: 1.7;">
                        Marca 100% venezolana, comprometida con la calidad y el sabor que une a las familias.
                    </p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5>Nosotros</h5>
                    <ul>
                        <li><a href="#nosotros">Quiénes somos</a></li>
                        <li><a href="#">Misión y Visión</a></li>
                        <li><a href="#">Valores</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5>Productos</h5>
                    <ul>
                        <li><a href="#">Línea tradicional</a></li>
                        <li><a href="#">Línea Chocoking</a></li>
                        <li><a href="#">Línea Panchi</a></li>
                        <li><a href="#">Línea Pastelería</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5>Contacto</h5>
                    <ul>
                        <li><a href="#">Ventas</a></li>
                        <li><a href="#" id="aliado">Ser aliado comercial</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 mb-4">
                    <h5>Información</h5>
                    <div class="footer-contact">
                        <i class="fas fa-envelope"></i> info@natys.com.ve
                    </div>
                    <div class="footer-contact">
                        <i class="fas fa-phone"></i> +58.424.521.7016
                    </div>
                    <div class="footer-contact">
                        <i class="fas fa-map-marker-alt"></i> Carrera 3 entre calles 2 y 4 zona industrial 2 Barquisimeto estado Lara
                    </div>
                    <div class="footer-contact mt-2">
                        <i class="fab fa-instagram"></i> @natysvzla
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Naty's - Larense de Alimentos, C.A. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

    </script>
</body>
</html>
