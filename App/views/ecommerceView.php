<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Larense C.A</title>
    <?php require_once 'components/links.php'; ?>
    <style>
        .marketplace-header {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            border-radius: 16px;
            padding: 40px;
            color: white;
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
        }
        .marketplace-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        .marketplace-header .cube-icon {
            position: absolute;
            right: 40px;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0.3;
            font-size: 120px;
        }
        .btn-ver-ofertas {
            background: white;
            color: #dc2626;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-ver-ofertas:hover {
            background: #f3f4f6;
            transform: translateY(-2px);
        }
        .categoria-filters {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }
        .categoria-btn {
            padding: 8px 20px;
            border-radius: 20px;
            border: 1px solid #e5e7eb;
            background: white;
            color: #6b7280;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .categoria-btn:hover,
        .categoria-btn.active {
            background: #dc2626;
            color: white;
            border-color: #dc2626;
        }
        .producto-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        .producto-card:hover {
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            transform: translateY(-5px);
        }
        .producto-img-container {
            width: 100%;
            height: 180px;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 15px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .producto-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .producto-img-placeholder {
            font-size: 60px;
            color: #d1d5db;
        }
        .stock-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #d1fae5;
            color: #065f46;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        .categoria-badge {
            display: inline-block;
            background: #f3f4f6;
            color: #6b7280;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
            margin-bottom: 10px;
        }
        .producto-nombre {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }
        .producto-descripcion {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 15px;
            flex-grow: 1;
        }
        .producto-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }
        .producto-precio {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
        }
        .btn-agregar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #111827;
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-agregar:hover {
            background: #374151;
            transform: scale(1.05);
        }
        .marketplace-title {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 5px;
        }
        .marketplace-subtitle {
            color: #6b7280;
            font-size: 14px;
        }
        .verificacion-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #f3f4f6;
            color: #6b7280;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            float: right;
        }
        
        /* Tarjeta de Crédito pequeña al final */
        .credito-mini-card {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            border-radius: 12px;
            padding: 12px 20px;
            color: white;
            margin-top: 40px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
            position: relative;
            overflow: hidden;
        }
        .credito-mini-card::before {
            content: '💳';
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 50px;
            opacity: 0.1;
        }
        .credito-mini-info {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .credito-mini-item {
            display: flex;
            align-items: baseline;
            gap: 8px;
        }
        .credito-mini-label {
            font-size: 11px;
            opacity: 0.7;
            letter-spacing: 0.5px;
        }
        .credito-mini-value {
            font-size: 18px;
            font-weight: 700;
        }
        .credito-mini-value.disponible {
            color: #4ade80;
        }
        .credito-mini-bar {
            width: 150px;
            height: 4px;
            background: rgba(255,255,255,0.2);
            border-radius: 2px;
            overflow: hidden;
        }
        .credito-mini-bar-fill {
            height: 100%;
            background: #4ade80;
            border-radius: 2px;
            width: 0%;
            transition: width 0.3s ease;
        }
        .credito-mini-badge {
            background: rgba(255,255,255,0.15);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        /* Motor de Búsqueda Inteligente */
        .search-container {
            position: relative;
            max-width: 500px;
            margin-top: 20px;
        }
        .search-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .search-input {
            width: 100%;
            padding: 14px 50px 14px 20px;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            background: rgba(255,255,255,0.95);
            color: #374151;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .search-input:focus {
            outline: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        .search-btn {
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
            background: #dc2626;
            color: white;
            border: none;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        .search-btn:hover {
            background: #b91c1c;
        }
        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 12px;
            margin-top: 8px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            max-height: 350px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }
        .search-suggestions.active {
            display: block;
        }
        .suggestion-item {
            padding: 14px 18px;
            cursor: pointer;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s ease;
        }
        .suggestion-item:hover {
            background: #f9fafb;
        }
        .suggestion-item:last-child {
            border-bottom: none;
        }
        .suggestion-img {
            width: 45px;
            height: 45px;
            border-radius: 8px;
            object-fit: cover;
            background: #f3f4f6;
        }
        .suggestion-img i {
            font-size: 20px;
            color: #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }
        .suggestion-info {
            flex: 1;
        }
        .suggestion-name {
            font-weight: 600;
            color: #111827;
            font-size: 14px;
        }
        .suggestion-status {
            font-size: 12px;
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .status-disponible {
            color: #059669;
        }
        .status-agotado {
            color: #dc2626;
        }
        .status-crear {
            color: #f59e0b;
        }
        .suggestion-price {
            font-weight: 700;
            color: #dc2626;
            font-size: 15px;
        }
        .suggestion-add {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #111827;
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .suggestion-add:hover {
            background: #374151;
            transform: scale(1.1);
        }
        .suggestion-add:disabled {
            background: #d1d5db;
            cursor: not-allowed;
            transform: none;
        }
        .suggestion-no-results {
            padding: 20px;
            text-align: center;
            color: #6b7280;
        }
        .suggestion-no-results i {
            font-size: 40px;
            margin-bottom: 10px;
            display: block;
        }
        .search-highlight {
            background: #fef3c7;
            padding: 0 2px;
            border-radius: 2px;
        }

        /* ==============================================
           ESTILOS MODO OSCURO PARA MARKETPLACE
           ============================================== */
        body.dark-mode {
            background: #12131d !important;
        }

        body.dark-mode .marketplace-title,
        body.dark-mode .marketplace-subtitle,
        body.dark-mode h1,
        body.dark-mode h2,
        body.dark-mode h3 {
            color: #e7e9f0 !important;
        }

        body.dark-mode .producto-card {
            background: #1a1f2e !important;
            border-color: #2a3041 !important;
        }

        body.dark-mode .producto-nombre {
            color: #e7e9f0 !important;
        }

        body.dark-mode .producto-descripcion {
            color: #9ca3af !important;
        }

        body.dark-mode .producto-precio {
            color: #e7e9f0 !important;
        }

        body.dark-mode .categoria-badge {
            background: #2a3041 !important;
            color: #9ca3af !important;
        }

        body.dark-mode .categoria-btn {
            background: #1a1f2e !important;
            border-color: #3a4055 !important;
            color: #e7e9f0 !important;
        }

        body.dark-mode .categoria-btn:hover,
        body.dark-mode .categoria-btn.active {
            background: #cc1d1d !important;
            color: white !important;
            border-color: #cc1d1d !important;
        }

        body.dark-mode .search-input {
            background: #2a3041 !important;
            color: #e7e9f0 !important;
            border-color: #3a4055 !important;
        }

        body.dark-mode .search-suggestions {
            background: #1a1f2e !important;
            border-color: #2a3041 !important;
        }

        body.dark-mode .suggestion-item {
            border-bottom-color: #2a3041 !important;
        }

        body.dark-mode .suggestion-item:hover {
            background: #2a3041 !important;
        }

        body.dark-mode .suggestion-name {
            color: #e7e9f0 !important;
        }

        body.dark-mode .verificacion-badge {
            background: #2a3041 !important;
            color: #9ca3af !important;
        }
    </style>
</head>
<body>
    <?php require_once 'components/menu.php'; ?>
    <?php require_once 'components/header.php'; ?>

    <div class="container">
        <div class="page-inner">
            
            <!-- Header del Marketplace -->
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <br>
                    <br>
                    <h1 class="marketplace-title">Marketplace</h1>
                    <p class="marketplace-subtitle">Gestión integral de la empresa Larense C.A</p>
                </div>

            </div>

            <!-- Banner de Promoción con Motor de Búsqueda -->
            <div class="marketplace-header">
                <div class="cube-icon">
                    <i class="fas fa-cube"></i>
                </div>
                <h2 class="fw-bold mb-2">¡Nuevas Galletas de Temporada!</h2>
                <p class="mb-3" style="max-width: 400px;">Descubre nuestros nuevos sabores artesanales preparados con los mejores ingredientes.</p>
                
                <!-- Motor de Búsqueda Inteligente -->
                <div class="search-container">
                    <div class="search-input-wrapper">
                        <input 
                            type="text" 
                            id="searchInput" 
                            class="search-input" 
                            placeholder="¿Qué galleta estás buscando? Ej: chocolate, avena, limón..."
                            autocomplete="off"
                        >
                        <button class="search-btn" id="searchBtn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <!-- Sugerencias en tiempo real -->
                    <div id="searchSuggestions" class="search-suggestions">
                        <!-- Se llena dinámicamente con JavaScript -->
                    </div>
                </div>
                
                <button class="btn-ver-ofertas mt-3">Ver Ofertas</button>
            </div>

            <!-- Filtros de Categoría -->
            <div class="categoria-filters">
                <a href="index.php?url=ecommerce" class="categoria-btn <?php echo !isset($_GET['categoria']) || $_GET['categoria'] == 'todas' ? 'active' : ''; ?>">Todas</a>
                <?php if(isset($categorias) && is_array($categorias)): ?>
                    <?php foreach($categorias as $cat): ?>
                        <a href="index.php?url=ecommerce&action=filtrar&categoria=<?php echo $cat['id_categoria']; ?>" 
                           class="categoria-btn <?php echo isset($_GET['categoria']) && $_GET['categoria'] == $cat['id_categoria'] ? 'active' : ''; ?>">
                            <?php echo $cat['nombre_categoria']; ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Grid de Productos -->
            <div class="row g-4">
                <?php 
                if(isset($productos) && is_array($productos) && !empty($productos)):
                    foreach ($productos as $producto): 
                ?>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="producto-card">
                        <!-- Badge de Stock -->
                        <span class="stock-badge">STOCK: <?php echo $producto['stock']; ?> CAJA<?php echo $producto['stock'] > 1 ? 'S' : ''; ?></span>
                        
                        <!-- Imagen del Producto -->
                        <div class="producto-img-container">
                            <?php if(!empty($producto['img']) && file_exists($producto['img'])): ?>
                                <img src="<?php echo $producto['img']; ?>" alt="<?php echo $producto['nombre_producto']; ?>">
                            <?php else: ?>
                                <div class="producto-img-placeholder">
                                    <i class="fas fa-cube"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Badge de Categoría -->
                        <span class="categoria-badge"><?php echo $producto['nombre_categoria']; ?></span>
                        
                        <!-- Nombre del Producto -->
                        <h3 class="producto-nombre"><?php echo $producto['nombre_producto']; ?></h3>
                        
                        <!-- Descripción -->
                        <p class="producto-descripcion">
                            <?php 
                            // Descripción basada en el nombre del producto
                            $descripciones = [
                                'chispas' => 'Galletas clásicas con chispas de chocolate belga',
                                'avena' => 'Galletas saludables de avena y pasas',
                                'suspiro' => 'Suspiros artesanales de colores',
                                'limón' => 'Galletas cítricas con glaseado real',
                                'brownie' => 'Brownies melcochudos de chocolate oscuro',
                                'alfajor' => 'Rellenos de dulce de leche y coco',
                                'chocolate' => 'Galletas de chocolate artesanal',
                                'vainilla' => 'Galletas clásicas de vainilla',
                                'nuez' => 'Galletas con trozos de nuez',
                                'mantequilla' => 'Galletas de mantequilla caseras'
                            ];
                            
                            $desc = 'Producto artesanal de alta calidad';
                            foreach($descripciones as $key => $val) {
                                if(stripos($producto['nombre_producto'], $key) !== false) {
                                    $desc = $val;
                                    break;
                                }
                            }
                            echo $desc;
                            ?>
                        </p>
                        
                        <!-- Footer con Precio y Botón -->
                        <div class="producto-footer">
                            <span class="producto-precio">$<?php echo number_format($producto['precio_venta'], 2); ?></span>
                            <button class="btn-agregar" title="Agregar al carrito">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php 
                    endforeach;
                else:
                ?>
                <div class="col-12 text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-box-open" style="font-size: 60px; color: #d1d5db;"></i>
                    </div>
                    <h3 class="text-muted">No hay productos disponibles</h3>
                    <p class="text-muted">Actualmente no tenemos productos en stock.</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Tarjeta de Crédito pequeña al final -->
            <div class="credito-mini-card" id="creditoMiniCard" style="display: none;">
                <div class="credito-mini-info">
                    <div class="credito-mini-item">
                        <span class="credito-mini-label">💰 CRÉDITO</span>
                        <span class="credito-mini-value disponible" id="creditoMiniDisponible">$0.00</span>
                    </div>
                    <div class="credito-mini-item">
                        <span class="credito-mini-label">📊 USADO</span>
                        <span class="credito-mini-value" id="creditoMiniUtilizado">$0.00</span>
                    </div>
                    <div class="credito-mini-bar">
                        <div class="credito-mini-bar-fill" id="creditoMiniBar"></div>
                    </div>
                    <div class="credito-mini-item">
                        <span class="credito-mini-label">🎯 LÍMITE</span>
                        <span class="credito-mini-value" id="creditoMiniLimite">$0.00</span>
                    </div>
                </div>
                <div class="credito-mini-badge" id="creditoMiniBadge">
                    <i class="fas fa-credit-card"></i> Crédito disponible
                </div>
            </div>

        </div>
    </div>

    <?php require_once 'components/scripts.php'; ?>
    
    <script>
        // Productos disponibles para la búsqueda (convertidos desde PHP)
        const productos = <?php echo json_encode($productos ?? []); ?>;
        
        // Elementos del DOM
        const searchInput = document.getElementById('searchInput');
        const searchBtn = document.getElementById('searchBtn');
        const searchSuggestions = document.getElementById('searchSuggestions');
        
        // Función para resaltar texto buscado
        function highlightText(text, searchTerm) {
            if (!searchTerm) return text;
            const regex = new RegExp(`(${searchTerm})`, 'gi');
            return text.replace(regex, '<span class="search-highlight">$1</span>');
        }
        
        // Función para obtener descripción del producto
        function getDescripcion(nombre) {
            const descripciones = {
                'chispas': 'Galletas clásicas con chispas de chocolate belga',
                'avena': 'Galletas saludables de avena y pasas',
                'suspiro': 'Suspiros artesanales de colores',
                'limón': 'Galletas cítricas con glaseado real',
                'brownie': 'Brownies melcochudos de chocolate oscuro',
                'alfajor': 'Rellenos de dulce de leche y coco',
                'chocolate': 'Galletas de chocolate artesanal',
                'vainilla': 'Galletas clásicas de vainilla',
                'nuez': 'Galletas con trozos de nuez',
                'mantequilla': 'Galletas de mantequilla caseras'
            };
            
            for (let key in descripciones) {
                if (nombre.toLowerCase().includes(key)) {
                    return descripciones[key];
                }
            }
            return 'Producto artesanal de alta calidad';
        }
        
        // Función para buscar productos
        function buscarProductos(termino) {
            if (!termino || termino.length < 1) {
                searchSuggestions.classList.remove('active');
                return;
            }
            
            const terminoLower = termino.toLowerCase();
            
            // Buscar coincidencias en nombre, categoría o descripción
            const resultados = productos.filter(p => {
                const nombre = p.nombre_producto.toLowerCase();
                const categoria = (p.nombre_categoria || '').toLowerCase();
                const descripcion = getDescripcion(p.nombre_producto).toLowerCase();
                
                return nombre.includes(terminoLower) || 
                       categoria.includes(terminoLower) ||
                       descripcion.includes(terminoLower);
            }).slice(0, 6); // Máximo 6 sugerencias
            
            mostrarSugerencias(resultados, termino);
        }
        
        // Función para mostrar sugerencias
        function mostrarSugerencias(resultados, termino) {
            if (resultados.length === 0) {
                searchSuggestions.innerHTML = `
                    <div class="suggestion-no-results">
                        <i class="fas fa-search" style="color: #f59e0b;"></i>
                        <p class="mb-1"><strong>No tenemos "${termino}" disponible</strong></p>
                        <p class="small mb-2">Pero podemos crearlo especialmente para ti</p>
                        <button class="btn btn-sm" style="background: #f59e0b; color: white; border: none; padding: 6px 16px; border-radius: 6px;"
                                onclick="solicitarProductoPersonalizado('${termino}')">
                            <i class="fas fa-magic me-1"></i> Solicitar Producto
                        </button>
                    </div>
                `;
                searchSuggestions.classList.add('active');
                return;
            }
            
            let html = '';
            resultados.forEach(producto => {
                const tieneStock = parseInt(producto.stock) > 0;
                const statusClass = tieneStock ? 'status-disponible' : 'status-agotado';
                const statusText = tieneStock 
                    ? `<i class="fas fa-check-circle"></i> ${producto.stock} disponibles` 
                    : '<i class="fas fa-times-circle"></i> Agotado - Podemos hacerlo';
                
                const imgHtml = producto.img && producto.img !== '' 
                    ? `<img src="${producto.img}" class="suggestion-img" alt="${producto.nombre_producto}">`
                    : `<div class="suggestion-img" style="display: flex; align-items: center; justify-content: center;"><i class="fas fa-cube"></i></div>`;
                
                html += `
                    <div class="suggestion-item" onclick="seleccionarProducto(${producto.id_producto})">
                        ${imgHtml}
                        <div class="suggestion-info">
                            <div class="suggestion-name">${highlightText(producto.nombre_producto, termino)}</div>
                            <div class="suggestion-status ${statusClass}">
                                ${statusText}
                            </div>
                        </div>
                        <div class="suggestion-price">$${parseFloat(producto.precio_venta).toFixed(2)}</div>
                        <button class="suggestion-add" 
                                onclick="event.stopPropagation(); agregarAlCarrito(${producto.id_producto}, '${producto.nombre_producto.replace(/'/g, "\\'")}', ${producto.precio_venta}, ${producto.stock})"
                                ${!tieneStock ? 'disabled' : ''}
                                title="${tieneStock ? 'Agregar al carrito' : 'Sin stock disponible'}">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                `;
            });
            
            if (resultados.length > 0) {
                html += `
                    <div class="suggestion-item" style="justify-content: center; background: #f9fafb; border-top: 2px solid #e5e7eb;" onclick="filtrarProductosGrid('${termino}')">
                        <span style="color: #dc2626; font-weight: 600;">
                            <i class="fas fa-search me-2"></i>Ver todos los resultados de "${termino}"
                        </span>
                    </div>
                `;
            }
            
            searchSuggestions.innerHTML = html;
            searchSuggestions.classList.add('active');
        }
        
        // Función para solicitar producto personalizado
        function solicitarProductoPersonalizado(nombre) {
            alert(`Solicitud enviada: "${nombre}"\n\nNuestro equipo de repostería se pondrá en contacto contigo para crear este producto especial.`);
            searchInput.value = '';
            searchSuggestions.classList.remove('active');
        }
        
        // Función para seleccionar un producto de las sugerencias
        function seleccionarProducto(id) {
            const producto = productos.find(p => p.id_producto == id);
            if (producto) {
                searchInput.value = producto.nombre_producto;
                searchSuggestions.classList.remove('active');
                
                const productoElement = document.querySelector(`[data-producto-id="${id}"]`);
                if (productoElement) {
                    productoElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    productoElement.style.animation = 'pulse 1s ease';
                    setTimeout(() => {
                        productoElement.style.animation = '';
                    }, 1000);
                }
            }
        }
        
        // Función para agregar al carrito
        function agregarAlCarrito(id, nombre, precio, stock) {
            if (stock <= 0) {
                alert(`Lo sentimos, "${nombre}" está agotado.\n\nPero podemos prepararlo especialmente para ti. Contacta con nosotros.`);
                return;
            }
            
            const carrito = JSON.parse(localStorage.getItem('carrito_usuario')) || [];
            const itemExistente = carrito.find(item => item.id === id);
            
            if (itemExistente) {
                if (itemExistente.cantidad + 1 > stock) {
                    mostrarToastHeader('No hay suficiente stock disponible', 'error');
                    return;
                }
                itemExistente.cantidad++;
            } else {
                carrito.push({
                    id: id,
                    nombre: nombre,
                    precio: precio,
                    stock: stock,
                    cantidad: 1,
                    img: null
                });
            }
            
            localStorage.setItem('carrito_usuario', JSON.stringify(carrito));
            
            const btn = event.target.closest('.suggestion-add, .btn-agregar');
            if (btn) {
                btn.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    btn.style.transform = 'scale(1)';
                }, 150);
            }
            
            mostrarToastHeader(`"${nombre}" agregado al carrito`, 'success');
            
            // Disparar evento para actualizar contador en header
            const cartEvent = new CustomEvent('cartUpdated');
            document.dispatchEvent(cartEvent);
        }
        
        // Función para mostrar toast (compatible con header)
        function mostrarToastHeader(mensaje, tipo = 'success') {
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                bottom: 20px;
                right: 20px;
                background: ${tipo === 'success' ? '#10b981' : (tipo === 'error' ? '#ef4444' : '#f59e0b')};
                color: white;
                padding: 12px 20px;
                border-radius: 12px;
                z-index: 9999;
                animation: slideInRight 0.3s ease;
                font-size: 14px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            `;
            toast.innerHTML = `<i class="fas ${tipo === 'success' ? 'fa-check-circle' : (tipo === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle')} me-2"></i>${mensaje}`;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
        
        // Función para filtrar productos en el grid
        function filtrarProductosGrid(termino) {
            searchInput.value = termino;
            searchSuggestions.classList.remove('active');
            
            const terminoLower = termino.toLowerCase();
            const cards = document.querySelectorAll('.producto-card');
            let encontrados = 0;
            
            cards.forEach((card, index) => {
                const nombre = productos[index]?.nombre_producto?.toLowerCase() || '';
                const categoria = productos[index]?.nombre_categoria?.toLowerCase() || '';
                
                if (nombre.includes(terminoLower) || categoria.includes(terminoLower)) {
                    card.closest('.col-md-6').style.display = 'block';
                    encontrados++;
                } else {
                    card.closest('.col-md-6').style.display = 'none';
                }
            });
            
            document.querySelector('.row.g-4').scrollIntoView({ behavior: 'smooth', block: 'start' });
            
            if (encontrados === 0) {
                mostrarToastHeader('No se encontraron productos con ese término', 'error');
            }
        }
        
        // Event listeners
        let timeoutId;
        searchInput.addEventListener('input', (e) => {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                buscarProductos(e.target.value.trim());
            }, 200);
        });
        
        searchInput.addEventListener('focus', () => {
            if (searchInput.value.trim().length > 0) {
                buscarProductos(searchInput.value.trim());
            }
        });
        
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.search-container')) {
                searchSuggestions.classList.remove('active');
            }
        });
        
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                filtrarProductosGrid(searchInput.value.trim());
            }
        });
        
        searchBtn.addEventListener('click', () => {
            filtrarProductosGrid(searchInput.value.trim());
        });
        
        // Agregar data-producto-id a las cards
        document.querySelectorAll('.producto-card').forEach((card, index) => {
            if (productos[index]) {
                card.setAttribute('data-producto-id', productos[index].id_producto);
            }
        });
        
        // Funcionalidad para agregar al carrito desde las cards
        document.querySelectorAll('.btn-agregar').forEach((btn, index) => {
            btn.addEventListener('click', function() {
                const producto = productos[index];
                if (producto && parseInt(producto.stock) > 0) {
                    agregarAlCarrito(producto.id_producto, producto.nombre_producto, producto.precio_venta, producto.stock);
                } else {
                    mostrarToastHeader('Producto sin stock disponible', 'error');
                }
            });
        });
        
        // Estilos de animación
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes pulse {
                0%, 100% { transform: scale(1); box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
                50% { transform: scale(1.02); box-shadow: 0 10px 30px rgba(0,0,0,0.15); }
            }
        `;
        document.head.appendChild(style);
        
        // ==============================================
        // CRÉDITO MINI CARD (para admin/usuarios)
        // ==============================================
        function cargarCreditoMini() {
            // Verificar si hay datos de crédito desde PHP
            <?php if(isset($creditoDisponible)): ?>
                const creditoInfo = {
                    limite: <?php echo $creditoLimite ?? 500; ?>,
                    utilizado: <?php echo $creditoUtilizado ?? 0; ?>,
                    disponible: <?php echo $creditoDisponible ?? 500; ?>
                };
                actualizarCreditoMini(creditoInfo);
            <?php else: ?>
                // Intentar obtener crédito desde API (si existe)
                fetch('index.php?url=ecommerce&action=getCredito')
                    .then(response => response.json())
                    .then(data => {
                        if(data.success && data.credito) {
                            actualizarCreditoMini(data.credito);
                        }
                    })
                    .catch(error => console.log('Crédito no disponible para este rol'));
            <?php endif; ?>
        }
        
        function actualizarCreditoMini(credito) {
            const card = document.getElementById('creditoMiniCard');
            if (!card) return;
            
            const disponible = credito.disponible || (credito.limite - credito.utilizado);
            const porcentaje = (credito.utilizado / credito.limite) * 100;
            
            document.getElementById('creditoMiniDisponible').innerText = `$${disponible.toFixed(2)}`;
            document.getElementById('creditoMiniUtilizado').innerText = `$${credito.utilizado.toFixed(2)}`;
            document.getElementById('creditoMiniLimite').innerText = `$${credito.limite.toFixed(2)}`;
            document.getElementById('creditoMiniBar').style.width = `${porcentaje}%`;
            
            card.style.display = 'flex';
        }
        
        // Cargar crédito al iniciar
        cargarCreditoMini();
    </script>
</body>
</html>