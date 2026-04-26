// ==============================================
// FUNCIONES DEL CARRITO PARA EL HEADER (VERSIÓN COMPLETA Y CORREGIDA)
// ==============================================

// Variables globales
let carritoActual = [];
let carritoUpdateInterval = null;
let modalAbierto = false;
let bsModalInstance = null;

// Obtener carrito del localStorage
function getCarrito() {
    return JSON.parse(localStorage.getItem('carrito_usuario')) || [];
}

// Guardar carrito y disparar eventos de actualización
function saveCarrito(carrito) {
    localStorage.setItem('carrito_usuario', JSON.stringify(carrito));
    carritoActual = carrito;
    
    // Actualizar contador
    actualizarContadorHeader();
    
    // Disparar evento global de actualización
    const event = new CustomEvent('cartUpdated', { detail: { carrito: carrito } });
    document.dispatchEvent(event);
    
    // Actualizar dropdown si está abierto
    actualizarDropdownSiVisible();
    
    // Actualizar modal SOLO si está abierto (SIN CERRARLO)
    if (modalAbierto) {
        actualizarContenidoModalSinCerrar();
    }
}

// Actualizar contador del carrito en el header
function actualizarContadorHeader() {
    const carrito = getCarrito();
    const totalItems = carrito.reduce((sum, item) => sum + item.cantidad, 0);
    const cartBadge = document.getElementById('headerCartCount');
    
    if (cartBadge) {
        if (totalItems > 0) {
            cartBadge.innerText = totalItems;
            cartBadge.style.display = 'flex';
            cartBadge.style.backgroundColor = '#cc1d1d';
        } else {
            cartBadge.innerText = '0';
            cartBadge.style.display = 'flex';
            cartBadge.style.backgroundColor = '#6c757d';
        }
    }
}

// Actualizar dropdown del carrito si está visible
function actualizarDropdownSiVisible() {
    const dropdownMenu = document.getElementById('cartDropdownMenu');
    if (dropdownMenu && dropdownMenu.classList.contains('show')) {
        mostrarCarritoEnHeader();
    }
}

// Función para obtener la ruta correcta de la imagen
function obtenerRutaImagen(img) {
    if (!img) return null;
    
    if (img.startsWith('http://') || img.startsWith('https://')) {
        return img;
    }
    
    if (img.startsWith('assets/img/') || img.startsWith('Assets/img/')) {
        return img;
    }
    
    if (img.startsWith('img/')) {
        return 'assets/' + img;
    }
    
    if (img.startsWith('productos/')) {
        return 'assets/img/' + img;
    }
    
    return 'assets/img/productos/' + img;
}

// Función de seguridad para evitar XSS
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Mostrar carrito en el dropdown
function mostrarCarritoEnHeader() {
    const carrito = getCarrito();
    const cartItemsList = document.getElementById('cartItemsList');
    const cartFooter = document.getElementById('cartFooter');
    const headerCartTotal = document.getElementById('headerCartTotal');
    
    if (!cartItemsList) return;
    
    if (carrito.length === 0) {
        cartItemsList.innerHTML = `
            <div class="cart-empty">
                <i class="fas fa-shopping-cart"></i>
                <p>Tu carrito está vacío</p>
                <small>¡Agrega algunos productos!</small>
            </div>
        `;
        if (cartFooter) cartFooter.style.display = 'none';
        return;
    }
    
    if (cartFooter) cartFooter.style.display = 'block';
    
    let html = '';
    let total = 0;
    
    carrito.forEach((item, index) => {
        const subtotal = item.precio * item.cantidad;
        total += subtotal;
        
        const rutaImagen = obtenerRutaImagen(item.img);
        
        let imgHtml = '';
        if (rutaImagen) {
            imgHtml = `<img src="${rutaImagen}" alt="${escapeHtml(item.nombre)}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\\'fas fa-cookie-bite\\'></i>';">`;
        } else {
            imgHtml = '<i class="fas fa-cookie-bite"></i>';
        }
        
        html += `
            <div class="cart-item" data-index="${index}">
                <div class="cart-item-img">
                    ${imgHtml}
                </div>
                <div class="cart-item-info">
                    <div class="cart-item-name">${escapeHtml(item.nombre)}</div>
                    <div class="cart-item-price">$${item.precio.toFixed(2)} c/u</div>
                </div>
                <div class="cart-item-actions">
                    <button class="cart-qty-btn" onclick="modificarCantidadHeader(${index}, -1, event)">-</button>
                    <span class="cart-item-qty">${item.cantidad}</span>
                    <button class="cart-qty-btn" onclick="modificarCantidadHeader(${index}, 1, event)">+</button>
                    <button class="cart-remove-btn" onclick="eliminarDelCarritoHeader(${index}, event)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
    });
    
    cartItemsList.innerHTML = html;
    if (headerCartTotal) headerCartTotal.innerText = `$${total.toFixed(2)}`;
}

// Modificar cantidad desde el header
function modificarCantidadHeader(index, cambio, event) {
    if (event) event.stopPropagation();
    
    const carrito = getCarrito();
    if (!carrito[index]) return;
    
    const item = carrito[index];
    const nuevaCantidad = item.cantidad + cambio;
    
    if (nuevaCantidad < 1) {
        eliminarDelCarritoHeader(index, event);
        return;
    }
    
    if (nuevaCantidad > item.stock) {
        mostrarToastHeader(`No hay suficiente stock de "${item.nombre}"`, 'error');
        return;
    }
    
    item.cantidad = nuevaCantidad;
    
    localStorage.setItem('carrito_usuario', JSON.stringify(carrito));
    carritoActual = carrito;
    
    actualizarContadorHeader();
    actualizarDropdownSiVisible();
    
    if (modalAbierto) {
        actualizarContenidoModalSinCerrar();
    }
    
    mostrarToastHeader(`${item.nombre}: ${item.cantidad} unidades`, 'success');
}

// Eliminar del carrito desde el header
function eliminarDelCarritoHeader(index, event) {
    if (event) event.stopPropagation();
    
    const carrito = getCarrito();
    const producto = carrito[index];
    const nombreProducto = producto.nombre;
    
    carrito.splice(index, 1);
    
    localStorage.setItem('carrito_usuario', JSON.stringify(carrito));
    carritoActual = carrito;
    
    actualizarContadorHeader();
    actualizarDropdownSiVisible();
    
    if (modalAbierto) {
        actualizarContenidoModalSinCerrar();
    }
    
    mostrarToastHeader(`"${nombreProducto}" eliminado del carrito`, 'info');
}

// ==============================================
// VACIAR CARRITO CON NOTIFICACIÓN DINÁMICA
// ==============================================

function vaciarCarritoHeader() {
    const carrito = getCarrito();
    const totalItems = carrito.reduce((sum, item) => sum + item.cantidad, 0);
    
    if (totalItems === 0) {
        mostrarToastHeader('El carrito ya está vacío', 'info');
        return;
    }
    
    // Crear modal de confirmación dinámico
    const confirmModal = document.createElement('div');
    confirmModal.className = 'modal fade';
    confirmModal.id = 'confirmVaciarModal';
    confirmModal.setAttribute('tabindex', '-1');
    confirmModal.setAttribute('aria-hidden', 'true');
    confirmModal.innerHTML = `
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header" style="background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%); color: white; border: none;">
                    <h5 class="modal-title">
                        <i class="fas fa-trash-alt me-2"></i>Vaciar Carrito
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-shopping-cart fa-3x mb-3" style="color: #cc1d1d;"></i>
                    <h4 class="mb-3">¿Estás seguro?</h4>
                    <p class="mb-0 text-muted">Esta acción eliminará <strong id="itemCountVaciar">${totalItems}</strong> producto(s) de tu carrito.</p>
                    <p class="text-muted small">Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e5e7eb; justify-content: space-between;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 10px; padding: 10px 20px;">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmarVaciarBtn" style="border-radius: 10px; padding: 10px 20px; background: #dc2626; border: none;">
                        <i class="fas fa-trash-alt me-2"></i>Sí, vaciar carrito
                    </button>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(confirmModal);
    
    // Inicializar el modal
    const modalElement = document.getElementById('confirmVaciarModal');
    let bsModal;
    
    if (typeof bootstrap !== 'undefined') {
        bsModal = new bootstrap.Modal(modalElement);
        bsModal.show();
    } else {
        modalElement.style.display = 'block';
        modalElement.classList.add('show');
        document.body.classList.add('modal-open');
    }
    
    // Evento para confirmar vaciado
    const confirmBtn = document.getElementById('confirmarVaciarBtn');
    confirmBtn.addEventListener('click', function() {
        // Vaciar carrito
        const carritoVacio = [];
        saveCarrito(carritoVacio);
        mostrarCarritoEnHeader();
        if (modalAbierto) {
            actualizarContenidoModalSinCerrar();
        }
        
        // Mostrar notificación de éxito dinámica
        mostrarNotificacionExitosa(totalItems);
        
        // Cerrar modal de confirmación
        if (typeof bootstrap !== 'undefined' && bsModal) {
            bsModal.hide();
        } else {
            modalElement.style.display = 'none';
            modalElement.classList.remove('show');
            document.body.classList.remove('modal-open');
        }
        
        // Eliminar el modal del DOM después de cerrarlo
        setTimeout(() => {
            if (modalElement && modalElement.parentNode) {
                modalElement.parentNode.removeChild(modalElement);
            }
        }, 300);
    });
    
    // Evento para cerrar modal sin eliminar
    modalElement.addEventListener('hidden.bs.modal', function() {
        setTimeout(() => {
            if (modalElement && modalElement.parentNode) {
                modalElement.parentNode.removeChild(modalElement);
            }
        }, 300);
    });
}

// Función para mostrar notificación dinámica de éxito al vaciar carrito
function mostrarNotificacionExitosa(totalItems) {
    const notificacion = document.createElement('div');
    notificacion.className = 'toast-notification-dinamica';
    notificacion.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 16px 24px;
        border-radius: 12px;
        z-index: 10000;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        animation: slideInRight 0.3s ease;
        font-size: 14px;
        min-width: 280px;
    `;
    
    notificacion.innerHTML = `
        <div style="background: rgba(255,255,255,0.2); border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-check-circle" style="font-size: 24px;"></i>
        </div>
        <div style="flex: 1;">
            <strong style="font-size: 16px;">¡Carrito vaciado!</strong>
            <p style="margin: 5px 0 0; font-size: 12px; opacity: 0.9;">Se eliminaron ${totalItems} producto(s) del carrito</p>
        </div>
        <button style="background: none; border: none; color: white; cursor: pointer; font-size: 16px;" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    document.body.appendChild(notificacion);
    
    // Auto-cerrar después de 3 segundos
    setTimeout(() => {
        if (notificacion && notificacion.parentNode) {
            notificacion.style.animation = 'slideOutRight 0.3s ease forwards';
            setTimeout(() => {
                if (notificacion && notificacion.parentNode) {
                    notificacion.parentNode.removeChild(notificacion);
                }
            }, 300);
        }
    }, 3000);
}

// Ir al carrito (abre modal)
function irAlCarrito() {
    const dropdownElement = document.querySelector('.cart-dropdown');
    if (dropdownElement && dropdownElement.parentElement) {
        const bsDropdown = bootstrap.Dropdown.getInstance(dropdownElement.parentElement);
        if (bsDropdown) bsDropdown.hide();
    }
    abrirModalCarrito();
}

// Mostrar toast notificaciones
function mostrarToastHeader(mensaje, tipo = 'success') {
    const existingToast = document.querySelector('.toast-header-custom');
    if (existingToast) existingToast.remove();
    
    const toast = document.createElement('div');
    toast.className = 'toast-header-custom';
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

// Agregar producto al carrito (función global)
function agregarAlCarrito(producto) {
    if (!producto || !producto.id_producto) {
        console.error('Producto inválido:', producto);
        mostrarToastHeader('Error: Producto inválido', 'error');
        return;
    }
    
    const carrito = getCarrito();
    const existeIndex = carrito.findIndex(item => item.id_producto === producto.id_producto);
    
    let imagenGuardada = producto.img || null;
    if (imagenGuardada && !imagenGuardada.startsWith('assets/')) {
        if (imagenGuardada.startsWith('img/')) {
            imagenGuardada = 'assets/' + imagenGuardada;
        } else if (imagenGuardada.startsWith('productos/')) {
            imagenGuardada = 'assets/img/' + imagenGuardada;
        } else {
            imagenGuardada = 'assets/img/productos/' + imagenGuardada;
        }
    }
    
    if (existeIndex !== -1) {
        const nuevaCantidad = carrito[existeIndex].cantidad + producto.cantidad;
        if (nuevaCantidad <= carrito[existeIndex].stock) {
            carrito[existeIndex].cantidad = nuevaCantidad;
            mostrarToastHeader(`Se agregó otro ${producto.nombre} al carrito`, 'success');
        } else {
            mostrarToastHeader(`No hay suficiente stock de "${producto.nombre}"`, 'error');
            return;
        }
    } else {
        carrito.push({
            id_producto: producto.id_producto,
            nombre: producto.nombre,
            precio: producto.precio,
            cantidad: producto.cantidad,
            stock: producto.stock,
            img: imagenGuardada
        });
        mostrarToastHeader(`${producto.nombre} agregado al carrito`, 'success');
    }
    
    saveCarrito(carrito);
    mostrarCarritoEnHeader();
    if (modalAbierto) {
        actualizarContenidoModalSinCerrar();
    }
}

// ==============================================
// FUNCIONES PARA EL MODAL DEL CARRITO
// ==============================================

function abrirModalCarrito() {
    const modal = document.getElementById('cartModal');
    if (modal) {
        modalAbierto = true;
        
        if (typeof bootstrap !== 'undefined') {
            if (!bsModalInstance) {
                bsModalInstance = new bootstrap.Modal(modal);
            }
            modal.addEventListener('hidden.bs.modal', function() {
                modalAbierto = false;
                bsModalInstance = null;
            }, { once: true });
            bsModalInstance.show();
        } else {
            modal.style.display = 'block';
            modal.classList.add('show');
            document.body.classList.add('modal-open');
        }
        actualizarContenidoModalSinCerrar();
    } else {
        window.location.href = 'index.php?url=ecommerce&action=usuarioIndex';
    }
}

function actualizarContenidoModalSinCerrar() {
    const carrito = getCarrito();
    const modalBody = document.getElementById('cartModalBody');
    const modalFooter = document.getElementById('cartModalFooter');
    
    if (!modalBody) return;
    
    const scrollContainer = modalBody.parentElement;
    const scrollPosition = scrollContainer ? scrollContainer.scrollTop : 0;
    
    if (carrito.length === 0) {
        modalBody.innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                <h5>Tu carrito está vacío</h5>
                <p class="text-muted">¡Agrega algunos productos para continuar!</p>
                <button class="btn btn-primary mt-3" onclick="cerrarModalCarrito(event)">
                    <i class="fas fa-store me-2"></i>Seguir comprando
                </button>
            </div>
        `;
        if (modalFooter) modalFooter.style.display = 'none';
        return;
    }
    
    if (modalFooter) modalFooter.style.display = 'block';
    
    let html = '<div class="list-group list-group-flush">';
    let total = 0;
    
    carrito.forEach((item, index) => {
        const subtotal = item.precio * item.cantidad;
        total += subtotal;
        
        const rutaImagen = obtenerRutaImagen(item.img);
        let imgHtml = rutaImagen 
            ? `<img src="${rutaImagen}" alt="${escapeHtml(item.nombre)}" class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\\'fas fa-cookie-bite fa-2x text-muted\\'></i>';">`
            : '<i class="fas fa-cookie-bite fa-2x text-muted"></i>';
        
        html += `
            <div class="list-group-item cart-modal-item" data-index="${index}">
                <div class="row align-items-center">
                    <div class="col-3 col-md-2">
                        <div class="cart-item-img-modal">${imgHtml}</div>
                    </div>
                    <div class="col-5 col-md-6">
                        <h6 class="mb-1">${escapeHtml(item.nombre)}</h6>
                        <small class="text-muted">$${item.precio.toFixed(2)} c/u</small>
                    </div>
                    <div class="col-4 col-md-4">
                        <div class="d-flex align-items-center justify-content-end gap-2">
                            <button class="btn btn-sm btn-outline-secondary" onclick="modificarCantidadModal(${index}, -1, event)">
                                <i class="fas fa-minus"></i>
                            </button>
                            <span class="mx-2 fw-bold" style="min-width: 30px; text-align: center;">${item.cantidad}</span>
                            <button class="btn btn-sm btn-outline-secondary" onclick="modificarCantidadModal(${index}, 1, event)">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger ms-2" onclick="eliminarDelCarritoModal(${index}, event)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    html += '</div>';
    modalBody.innerHTML = html;
    
    if (modalFooter) {
        modalFooter.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Total:</h5>
                <h5 class="mb-0 text-danger">$${total.toFixed(2)}</h5>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-success btn-lg" onclick="procesarPago(event)">
                    <i class="fas fa-credit-card me-2"></i>Proceder al Pago
                </button>
                <button class="btn btn-outline-secondary" onclick="cerrarModalCarrito(event)">
                    <i class="fas fa-store me-2"></i>Seguir comprando
                </button>
            </div>
        `;
    }
    
    if (scrollContainer) {
        scrollContainer.scrollTop = scrollPosition;
    }
}

function modificarCantidadModal(index, cambio, event) {
    if (event) event.stopPropagation();
    modificarCantidadHeader(index, cambio, event);
}

function eliminarDelCarritoModal(index, event) {
    if (event) event.stopPropagation();
    eliminarDelCarritoHeader(index, event);
}

function cerrarModalCarrito(event) {
    if (event) event.stopPropagation();
    modalAbierto = false;
    const modal = document.getElementById('cartModal');
    if (modal) {
        if (typeof bootstrap !== 'undefined' && bsModalInstance) {
            bsModalInstance.hide();
            bsModalInstance = null;
        } else {
            modal.style.display = 'none';
            modal.classList.remove('show');
            document.body.classList.remove('modal-open');
        }
    }
}

function procesarPago(event) {
    if (event) event.stopPropagation();
    cerrarModalCarrito(event);
    window.location.href = 'index.php?url=checkout';
}

// ==============================================
// FUNCIONES DE NOTIFICACIONES
// ==============================================

function cargarNotificaciones() {
    fetch('index.php?url=notificaciones&action=obtener_header')
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                mostrarNotificaciones(data.data);
            } else {
                mostrarNotificaciones([]);
            }
        })
        .catch(error => {
            console.error('Error al cargar notificaciones:', error);
            mostrarNotificaciones([]);
        });
}

function mostrarNotificaciones(notificaciones) {
    const badge = document.getElementById('notificationBadge');
    const count = document.getElementById('notificationCount');
    const list = document.getElementById('notificationList');
    const noNotif = document.getElementById('noNotifications');
    
    // Contar solo las no vistas
    const noVistas = notificaciones.filter(n => n.vista == 0);
    
    if (badge) badge.textContent = noVistas.length;
    if (count) count.textContent = notificaciones.length + ' total (' + noVistas.length + ' nuevas)';
    if (!list) return;
    
    list.innerHTML = '';
    
    if (notificaciones.length === 0) {
        if (noNotif) {
            list.appendChild(noNotif);
            noNotif.style.display = 'block';
        }
        return;
    }
    
    if (noNotif) noNotif.style.display = 'none';
    
    notificaciones.forEach(notif => {
        const notifElement = document.createElement('a');
        notifElement.href = notif.enlace || '#';
        notifElement.className = 'notif-link';
        
        // Resaltar las no vistas
        if (notif.vista == 0) {
            notifElement.style.background = 'linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%)';
            notifElement.style.borderLeft = '4px solid #ff9800';
        }
        
        // Marcar como vista al hacer clic
        notifElement.onclick = function(e) {
            if (notif.vista == 0) {
                e.preventDefault();
                marcarComoVista(notif.id_notificaciones, notif.enlace);
            }
        };
        
        const fecha = new Date(notif.fecha_notificacion);
        const ahora = new Date();
        const diffMs = ahora - fecha;
        const diffMins = Math.floor(diffMs / 60000);
        const diffHoras = Math.floor(diffMins / 60);
        const diffDias = Math.floor(diffHoras / 24);
        
        let tiempoTexto = '';
        if (diffMins < 1) tiempoTexto = 'Ahora mismo';
        else if (diffMins < 60) tiempoTexto = `Hace ${diffMins} minuto${diffMins > 1 ? 's' : ''}`;
        else if (diffHoras < 24) tiempoTexto = `Hace ${diffHoras} hora${diffHoras > 1 ? 's' : ''}`;
        else tiempoTexto = `Hace ${diffDias} día${diffDias > 1 ? 's' : ''}`;
        
        notifElement.innerHTML = `
            <div class="notif-icon notif-primary">
                <i class="fa fa-bell"></i>
                ${notif.vista == 0 ? '<span class="badge badge-warning" style="position:absolute;top:-5px;right:-5px;">Nueva</span>' : ''}
            </div>
            <div class="notif-content">
                <span class="block">${notif.descripcion_notificacion}</span>
                <span class="time">${tiempoTexto}</span>
            </div>
        `;
        list.appendChild(notifElement);
    });
}

function marcarComoVista(id, enlace) {
    fetch('index.php?url=notificaciones&action=marcar_vista', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + id
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            cargarNotificaciones();
            if (enlace) {
                window.location.href = enlace;
            }
        }
    })
    .catch(error => {
        console.error('Error al marcar como vista:', error);
    });
}

// ==============================================
// OTRAS FUNCIONES
// ==============================================

function toggleLanguage() {
    Swal.fire({
        icon: 'info',
        title: 'Selector de Idioma',
        text: 'Funcion en desarrollo. Idiomas disponibles: Español, English.',
        timer: 2000,
        showConfirmButton: false
    });
}

function simularVista(id_rol, nombre_rol) {
    Swal.fire({
        icon: 'info',
        title: 'Ver como ' + nombre_rol,
        text: 'Simulando vista de ' + nombre_rol + '... (Funcion en desarrollo)',
        timer: 2000,
        showConfirmButton: false
    });
    console.log('Simulando rol ID:', id_rol, 'Nombre:', nombre_rol);
}

function toggleSubmenu(event, submenuId) {
    event.stopPropagation();
    const submenu = document.getElementById(submenuId);
    if (!submenu) return;

    if (submenu.classList.contains('active')) {
        submenu.classList.add('closing');
        setTimeout(() => {
            submenu.classList.remove('active', 'closing');
        }, 250);
    } else {
        submenu.classList.add('active');
    }
}

function toggleTheme() {
    document.body.classList.toggle('dark-mode');
    
    const isDarkMode = document.body.classList.contains('dark-mode');
    localStorage.setItem('darkMode', isDarkMode);
    
    const themeBtn = document.querySelector('.theme-toggle-nav i');
    if (themeBtn) {
        themeBtn.className = isDarkMode ? 'fas fa-sun' : 'fas fa-moon';
    }
    
    const dropdownMenu = document.getElementById('cartDropdownMenu');
    if (dropdownMenu && dropdownMenu.classList.contains('show')) {
        mostrarCarritoEnHeader();
    }
    if (modalAbierto) {
        actualizarContenidoModalSinCerrar();
    }
}

// Iniciar monitoreo de cambios en tiempo real
function iniciarMonitoreoCarrito() {
    if (carritoUpdateInterval) clearInterval(carritoUpdateInterval);
    
    carritoUpdateInterval = setInterval(() => {
        const carritoActualStorage = getCarrito();
        if (JSON.stringify(carritoActualStorage) !== JSON.stringify(carritoActual)) {
            carritoActual = carritoActualStorage;
            actualizarContadorHeader();
            actualizarDropdownSiVisible();
            if (modalAbierto) {
                actualizarContenidoModalSinCerrar();
            }
        }
    }, 500);
}

function detenerMonitoreoCarrito() {
    if (carritoUpdateInterval) {
        clearInterval(carritoUpdateInterval);
        carritoUpdateInterval = null;
    }
}

// Agregar estilos adicionales para las animaciones del modal de vaciado
const styleNotificacion = document.createElement('style');
styleNotificacion.textContent = `
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .toast-notification-dinamica {
        backdrop-filter: blur(10px);
    }
    
    body.dark-mode .modal-content {
        background: #181d2d !important;
    }
    
    body.dark-mode .modal-footer {
        border-top-color: #2a3041 !important;
    }
    
    body.dark-mode .modal-body .text-muted {
        color: #9ca3af !important;
    }
    
    body.dark-mode .btn-outline-secondary {
        color: #e7e9f0;
        border-color: #4a5568;
    }
    
    body.dark-mode .btn-outline-secondary:hover {
        background: #2a3041;
        color: white;
    }
`;
document.head.appendChild(styleNotificacion);

// ==============================================
// INICIALIZACIÓN
// ==============================================

document.addEventListener('DOMContentLoaded', function() {
    carritoActual = getCarrito();
    actualizarContadorHeader();
    iniciarMonitoreoCarrito();
    cargarNotificaciones();
    
    const cartDropdown = document.getElementById('cartDropdown');
    if (cartDropdown) {
        cartDropdown.addEventListener('click', function() {
            setTimeout(() => mostrarCarritoEnHeader(), 100);
        });
    }
    
    window.addEventListener('storage', function(e) {
        if (e.key === 'carrito_usuario') {
            const nuevoCarrito = JSON.parse(e.newValue) || [];
            carritoActual = nuevoCarrito;
            actualizarContadorHeader();
            actualizarDropdownSiVisible();
            if (modalAbierto) {
                actualizarContenidoModalSinCerrar();
            }
        }
    });
    
    document.addEventListener('cartUpdated', function(e) {
        carritoActual = e.detail?.carrito || getCarrito();
        actualizarContadorHeader();
        if (modalAbierto) {
            actualizarContenidoModalSinCerrar();
        }
    });
    
    document.addEventListener('openCartModal', function() {
        abrirModalCarrito();
    });
    
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class') {
                const dropdownMenu = document.getElementById('cartDropdownMenu');
                if (dropdownMenu && dropdownMenu.classList.contains('show')) {
                    mostrarCarritoEnHeader();
                }
            }
        });
    });
    observer.observe(document.body, { attributes: true });
});

document.addEventListener('click', function(e) {
    const submenus = document.querySelectorAll('.submenu-panel.active');
    submenus.forEach(function(submenu) {
        if (!submenu.contains(e.target) && !e.target.closest('.has-submenu')) {
            submenu.classList.add('closing');
            setTimeout(() => {
                submenu.classList.remove('active', 'closing');
            }, 250);
        }
    });
});

if (typeof $ !== 'undefined') {
    $(document).on('hidden.bs.dropdown', '.dropdown', function () {
        const submenus = document.querySelectorAll('.submenu-panel');
        submenus.forEach(function(submenu) {
            submenu.classList.remove('active', 'closing');
        });
    });
}

window.addEventListener('beforeunload', function() {
    detenerMonitoreoCarrito();
});

setInterval(cargarNotificaciones, 30000);