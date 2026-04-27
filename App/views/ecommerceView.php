<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Larense C.A</title>
    <?php require_once 'components/links.php'; ?>
    <link rel="stylesheet" href="assets/css/stylesModules/ecommerce.css" />
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
                    <div id="searchSuggestions" class="search-suggestions"></div>
                </div>
                
                <button class="btn-ver-ofertas mt-3">Ver Ofertas</button>
            </div>

            <!-- Filtros de Disponibilidad -->
            <div class="categoria-filters">
                <a href="index.php?url=ecommerce&action=filtrar&disponibilidad=todos&orden=<?php echo isset($_GET['orden']) ? $_GET['orden'] : 'todos'; ?>" 
                   class="categoria-btn <?php echo !isset($_GET['disponibilidad']) || $_GET['disponibilidad'] == 'todos' ? 'active' : ''; ?>">
                    Todos
                </a>
                <a href="index.php?url=ecommerce&action=filtrar&disponibilidad=disponibles&orden=<?php echo isset($_GET['orden']) ? $_GET['orden'] : 'todos'; ?>" 
                   class="categoria-btn <?php echo isset($_GET['disponibilidad']) && $_GET['disponibilidad'] == 'disponibles' ? 'active' : ''; ?>">
                    Disponibles
                </a>
                <a href="index.php?url=ecommerce&action=filtrar&disponibilidad=encargo&orden=<?php echo isset($_GET['orden']) ? $_GET['orden'] : 'todos'; ?>" 
                   class="categoria-btn <?php echo isset($_GET['disponibilidad']) && $_GET['disponibilidad'] == 'encargo' ? 'active' : ''; ?>">
                    Por Encargo
                </a>
            </div>

            <!-- Subfiltro de Ordenamiento -->
            <div class="categoria-filters" style="margin-top: 15px;">
                <a href="index.php?url=ecommerce&action=filtrar&disponibilidad=<?php echo isset($_GET['disponibilidad']) ? $_GET['disponibilidad'] : 'todos'; ?>&orden=todos" 
                   class="categoria-btn <?php echo !isset($_GET['orden']) || $_GET['orden'] == 'todos' ? 'active' : ''; ?>">
                    Todos
                </a>
                <a href="index.php?url=ecommerce&action=filtrar&disponibilidad=<?php echo isset($_GET['disponibilidad']) ? $_GET['disponibilidad'] : 'todos'; ?>&orden=recientes" 
                   class="categoria-btn <?php echo isset($_GET['orden']) && $_GET['orden'] == 'recientes' ? 'active' : ''; ?>">
                    Más Recientes
                </a>
                <a href="index.php?url=ecommerce&action=filtrar&disponibilidad=<?php echo isset($_GET['disponibilidad']) ? $_GET['disponibilidad'] : 'todos'; ?>&orden=mejores" 
                   class="categoria-btn <?php echo isset($_GET['orden']) && $_GET['orden'] == 'mejores' ? 'active' : ''; ?>">
                    Mejores
                </a>
                <a href="index.php?url=ecommerce&action=filtrar&disponibilidad=<?php echo isset($_GET['disponibilidad']) ? $_GET['disponibilidad'] : 'todos'; ?>&orden=mas_vendidos" 
                   class="categoria-btn <?php echo isset($_GET['orden']) && $_GET['orden'] == 'mas_vendidos' ? 'active' : ''; ?>">
                    Más Vendidos
                </a>
                <a href="index.php?url=ecommerce&action=filtrar&disponibilidad=<?php echo isset($_GET['disponibilidad']) ? $_GET['disponibilidad'] : 'todos'; ?>&orden=menos_vendidos" 
                   class="categoria-btn <?php echo isset($_GET['orden']) && $_GET['orden'] == 'menos_vendidos' ? 'active' : ''; ?>">
                    Menos Vendidos
                </a>
            </div>

            <!-- Grid de Productos -->
            <div class="row g-4">
                <?php 
                if(isset($productos) && is_array($productos) && !empty($productos)):
                    foreach ($productos as $producto): 
                ?>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="producto-card" data-producto-id="<?php echo $producto['id_producto']; ?>">
                        <span class="stock-badge">STOCK: <?php echo $producto['stock']; ?> CAJA<?php echo $producto['stock'] > 1 ? 'S' : ''; ?></span>
                        
                        <div class="producto-img-container">
                            <?php if(!empty($producto['img']) && file_exists($producto['img'])): ?>
                                <img src="<?php echo $producto['img']; ?>" alt="<?php echo $producto['nombre_producto']; ?>">
                            <?php else: ?>
                                <div class="producto-img-placeholder">
                                    <i class="fas fa-cube"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <span class="categoria-badge"><?php echo $producto['nombre_categoria']; ?></span>
                        <h3 class="producto-nombre"><?php echo $producto['nombre_producto']; ?></h3>
                        <p class="producto-descripcion"><?php echo $producto['descripcion'] ?? 'Producto artesanal de alta calidad'; ?></p>
                        
                        <div class="producto-footer">
                            <span class="producto-precio">$<?php echo number_format($producto['precio_venta'], 2); ?></span>
                            <button class="btn-agregar" data-id="<?php echo $producto['id_producto']; ?>" data-nombre="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" data-precio="<?php echo $producto['precio_venta']; ?>" data-stock="<?php echo $producto['stock']; ?>" data-img="<?php echo $producto['img']; ?>" title="Agregar al carrito">
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
        
        // ==============================================
        // FUNCIÓN AGREGAR AL CARRITO - CORREGIDA CON IMAGEN
        // ==============================================
        function agregarAlCarrito(id, nombre, precio, stock, imagen) {
            if (stock <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Producto Agotado',
                    text: `"${nombre}" está agotado. Podemos prepararlo especialmente para ti.`,
                    confirmButtonColor: '#cc1d1d'
                });
                return;
            }
            
            let carrito = JSON.parse(localStorage.getItem('carrito_usuario')) || [];
            const itemExistente = carrito.find(item => item.id_producto === id);
            
            if (itemExistente) {
                if (itemExistente.cantidad + 1 > stock) {
                    mostrarToastHeader('No hay suficiente stock disponible', 'error');
                    return;
                }
                itemExistente.cantidad++;
            } else {
                // Buscar el producto completo para obtener la imagen si no viene
                let rutaImagen = imagen;
                if (!rutaImagen) {
                    const productoCompleto = productos.find(p => p.id_producto == id);
                    rutaImagen = productoCompleto ? productoCompleto.img : null;
                }
                
                carrito.push({
                    id_producto: id,
                    nombre: nombre,
                    precio: parseFloat(precio),
                    stock: stock,
                    cantidad: 1,
                    img: rutaImagen
                });
            }
            
            localStorage.setItem('carrito_usuario', JSON.stringify(carrito));
            
            // Efecto visual en el botón
            const btn = event?.target?.closest('.suggestion-add, .btn-agregar');
            if (btn) {
                btn.style.transform = 'scale(0.9)';
                setTimeout(() => btn.style.transform = 'scale(1)', 150);
            }
            
            mostrarToastHeader(`"${nombre}" agregado al carrito`, 'success');
            
            // Disparar evento para actualizar el header
            const cartEvent = new CustomEvent('cartUpdated');
            document.dispatchEvent(cartEvent);
            
            // Actualizar directamente si las funciones existen
            if (typeof actualizarContadorHeader === 'function') {
                actualizarContadorHeader();
            }
            if (typeof mostrarCarritoEnHeader === 'function') {
                setTimeout(() => mostrarCarritoEnHeader(), 100);
            }
        }
        
        // Función para mostrar toast
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
        
        // Función para buscar productos
        function buscarProductos(termino) {
            if (!termino || termino.length < 1) {
                searchSuggestions.classList.remove('active');
                return;
            }
            
            const terminoLower = termino.toLowerCase();
            
            const resultados = productos.filter(p => {
                const nombre = p.nombre_producto.toLowerCase();
                const categoria = (p.nombre_categoria || '').toLowerCase();
                const descripcion = getDescripcion(p.nombre_producto).toLowerCase();
                
                return nombre.includes(terminoLower) || 
                       categoria.includes(terminoLower) ||
                       descripcion.includes(terminoLower);
            }).slice(0, 6);
            
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
                    ? `<img src="${producto.img}" class="suggestion-img" alt="${producto.nombre_producto}" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'suggestion-img\' style=\'display: flex; align-items: center; justify-content: center;\'><i class=\'fas fa-cube\'></i></div>';">`
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
                                onclick="event.stopPropagation(); agregarAlCarrito(${producto.id_producto}, '${producto.nombre_producto.replace(/'/g, "\\'")}', ${producto.precio_venta}, ${producto.stock}, '${producto.img}')"
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
        
        function solicitarProductoPersonalizado(nombre) {
            Swal.fire({
                icon: 'info',
                title: 'Solicitud Enviada',
                text: `"${nombre}"\n\nNuestro equipo de repostería se pondrá en contacto contigo.`,
                confirmButtonColor: '#cc1d1d'
            });
            searchInput.value = '';
            searchSuggestions.classList.remove('active');
        }
        
        function seleccionarProducto(id) {
            const producto = productos.find(p => p.id_producto == id);
            if (producto) {
                searchInput.value = producto.nombre_producto;
                searchSuggestions.classList.remove('active');
                
                const productoElement = document.querySelector(`.producto-card[data-producto-id="${id}"]`);
                if (productoElement) {
                    productoElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    productoElement.style.animation = 'pulse 1s ease';
                    setTimeout(() => {
                        productoElement.style.animation = '';
                    }, 1000);
                }
            }
        }
        
        function filtrarProductosGrid(termino) {
            searchInput.value = termino;
            searchSuggestions.classList.remove('active');
            
            const terminoLower = termino.toLowerCase();
            const cards = document.querySelectorAll('.producto-card');
            let encontrados = 0;
            
            cards.forEach((card) => {
                const nombre = card.querySelector('.producto-nombre')?.innerText?.toLowerCase() || '';
                const categoria = card.querySelector('.categoria-badge')?.innerText?.toLowerCase() || '';
                
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
        
        // Event listeners para búsqueda
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
        
        // Inicializar botones de agregar al carrito
        document.querySelectorAll('.btn-agregar').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const id = this.getAttribute('data-id');
                const nombre = this.getAttribute('data-nombre');
                const precio = this.getAttribute('data-precio');
                const stock = this.getAttribute('data-stock');
                const img = this.getAttribute('data-img');
                
                agregarAlCarrito(parseInt(id), nombre, parseFloat(precio), parseInt(stock), img);
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
            .search-highlight {
                background: #fef3c7;
                color: #92400e;
                padding: 0 2px;
                border-radius: 3px;
            }
        `;
        document.head.appendChild(style);
        
        // ==============================================
        // CRÉDITO MINI CARD
        // ==============================================
        function cargarCreditoMini() {
            <?php if(isset($creditoDisponible)): ?>
                const creditoInfo = {
                    limite: <?php echo $creditoLimite ?? 500; ?>,
                    utilizado: <?php echo $creditoUtilizado ?? 0; ?>,
                    disponible: <?php echo $creditoDisponible ?? 500; ?>
                };
                actualizarCreditoMini(creditoInfo);
            <?php else: ?>
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
        
        cargarCreditoMini();
    </script>
</body>
</html>