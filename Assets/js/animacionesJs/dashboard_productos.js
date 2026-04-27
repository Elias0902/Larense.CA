/**
 * JavaScript para productosView.php
 * Gestión de Productos
 */

document.addEventListener('DOMContentLoaded', function() {
    inicializarProductos();
});

function inicializarProductos() {
    configurarEventListenersProductos();
    inicializarDataTable();
    configurarValidacionesProductos();
    inicializarModalesProductos();
}

function configurarEventListenersProductos() {
    // Event listeners para los formularios
    const formProducto = document.getElementById('formProducto');
    if (formProducto) {
        formProducto.addEventListener('submit', function(e) {
            e.preventDefault();
            if (validar_formulario()) {
                this.submit();
            }
        });
    }
    
    const formProductoModificar = document.getElementById('formProductoModificar');
    if (formProductoModificar) {
        formProductoModificar.addEventListener('submit', function(e) {
            e.preventDefault();
            if (validar_formulario_modificado()) {
                this.submit();
            }
        });
    }
}

function inicializarDataTable() {
    // Inicializar DataTable si existe
    if (typeof $.fn.DataTable !== 'undefined') {
        $('#add-row').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
            },
            pageLength: 10,
            order: [[0, 'desc']],
            columns: [
                { width: '10%' },
                { width: '10%' },
                { width: '20%' },
                { width: '15%' },
                { width: '10%' },
                { width: '10%' },
                { width: '10%' },
                { width: '10%' },
                { width: '5%' }
            ]
        });
    }
}

function configurarValidacionesProductos() {
    // Configurar validaciones en tiempo real - formulario de agregar
    const camposValidacion = [
        { id: 'nombreProducto', validator: validar_nombre },
        { id: 'nombreCategoria', validator: validar_categoria },
        { id: 'precioProducto', validator: validar_precio },
        { id: 'stockProducto', validator: validar_stock },
        { id: 'fechaRegistroProducto', validator: validar_fecha },
        { id: 'fechaVencimientoProducto', validator: validar_fecha_vencimiento },
        { id: 'imagenProducto', validator: validar_imagen }
    ];
    
    camposValidacion.forEach(campo => {
        const elemento = document.getElementById(campo.id);
        if (elemento) {
            elemento.addEventListener('input', campo.validator);
            elemento.addEventListener('blur', campo.validator);
        }
    });
    
    // Configurar validaciones en tiempo real - formulario de modificar
    const camposValidacionEdit = [
        { id: 'nombreProductoEdit', validator: validar_nombre_modificado },
        { id: 'nombreCategoriaEdit', validator: validar_categoria_modificado },
        { id: 'precioProductoEdit', validator: validar_precio_modificado },
        { id: 'stockProductoEdit', validator: validar_stock_modificado },
        { id: 'fechaRegistroProductoEdit', validator: validar_fecha_modificado },
        { id: 'fechaVencimientoProductoEdit', validator: validar_fecha_vencimiento_modificado }
    ];
    
    camposValidacionEdit.forEach(campo => {
        const elemento = document.getElementById(campo.id);
        if (elemento) {
            elemento.addEventListener('input', campo.validator);
            elemento.addEventListener('blur', campo.validator);
        }
    });
}

function inicializarModalesProductos() {
    // Configurar modales de Bootstrap
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        new bootstrap.Modal(modal);
    });
    
    // Configurar eventos de modales
    document.addEventListener('show.bs.modal', function (event) {
        const modal = event.target;
        const form = modal.querySelector('form');
        if (form) {
            // Limpiar formulario al abrir modal
            form.reset();
            limpiarMensajesError(form);
        }
    });
}

// Funciones de validación - Formulario Agregar
function validar_nombre() {
    const nombre = document.getElementById('nombreProducto');
    const error = document.getElementById('errorProducto');
    
    if (!nombre.value || nombre.value.trim().length < 2) {
        error.textContent = 'El nombre debe tener al menos 2 caracteres';
        return false;
    }
    
    if (!/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ-]+$/.test(nombre.value)) {
        error.textContent = 'El nombre contiene caracteres inválidos';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_categoria() {
    const categoria = document.getElementById('nombreCategoria');
    const error = document.getElementById('errorCategoria');
    
    if (!categoria.value) {
        error.textContent = 'Por favor, seleccione una categoría';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_precio() {
    const precio = document.getElementById('precioProducto');
    const error = document.getElementById('errorPrecio');
    
    if (!precio.value || precio.value <= 0) {
        error.textContent = 'El precio debe ser mayor a 0';
        return false;
    }
    
    if (!/^\d+(\.\d{1,2})?$/.test(precio.value)) {
        error.textContent = 'Formato de precio inválido';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_stock() {
    const stock = document.getElementById('stockProducto');
    const error = document.getElementById('errorStock');
    
    if (!stock.value || stock.value <= 0) {
        error.textContent = 'El stock debe ser mayor a 0';
        return false;
    }
    
    if (!/^\d+$/.test(stock.value)) {
        error.textContent = 'El stock debe ser un número entero';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_fecha() {
    const fecha = document.getElementById('fechaRegistroProducto');
    const error = document.getElementById('errorFechaRegistro');
    
    if (!fecha.value) {
        error.textContent = 'Por favor, seleccione una fecha';
        return false;
    }
    
    const fechaSeleccionada = new Date(fecha.value);
    const fechaActual = new Date();
    
    if (fechaSeleccionada > fechaActual) {
        error.textContent = 'La fecha no puede ser futura';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_fecha_vencimiento() {
    const fechaRegistro = document.getElementById('fechaRegistroProducto');
    const fechaVencimiento = document.getElementById('fechaVencimientoProducto');
    const error = document.getElementById('errorFechaVencimiento');
    
    if (!fechaVencimiento.value) {
        error.textContent = 'Por favor, seleccione una fecha de vencimiento';
        return false;
    }
    
    if (fechaRegistro.value && fechaVencimiento.value) {
        const fechaReg = new Date(fechaRegistro.value);
        const fechaVen = new Date(fechaVencimiento.value);
        
        if (fechaVen <= fechaReg) {
            error.textContent = 'La fecha de vencimiento debe ser posterior a la fecha de registro';
            return false;
        }
    }
    
    error.textContent = '';
    return true;
}

function validar_imagen() {
    const imagen = document.getElementById('imagenProducto');
    const error = document.getElementById('errorImagen');
    
    if (!imagen.files || imagen.files.length === 0) {
        error.textContent = 'Por favor, seleccione una imagen';
        return false;
    }
    
    const archivo = imagen.files[0];
    
    // Validar tipo de archivo
    const tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!tiposPermitidos.includes(archivo.type)) {
        error.textContent = 'El archivo debe ser una imagen (JPEG, PNG, GIF o WebP)';
        return false;
    }
    
    // Validar tamaño (máximo 5MB)
    if (archivo.size > 5 * 1024 * 1024) {
        error.textContent = 'La imagen no debe superar los 5MB';
        return false;
    }
    
    error.textContent = '';
    return true;
}

// Funciones de validación - Formulario Modificar
function validar_nombre_modificado() {
    const nombre = document.getElementById('nombreProductoEdit');
    const error = document.getElementById('errorProductoEdit');
    
    if (!nombre.value || nombre.value.trim().length < 2) {
        error.textContent = 'El nombre debe tener al menos 2 caracteres';
        return false;
    }
    
    if (!/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ-]+$/.test(nombre.value)) {
        error.textContent = 'El nombre contiene caracteres inválidos';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_categoria_modificado() {
    const categoria = document.getElementById('nombreCategoriaEdit');
    const error = document.getElementById('errorCategoriaEdit');
    
    if (!categoria.value) {
        error.textContent = 'Por favor, seleccione una categoría';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_precio_modificado() {
    const precio = document.getElementById('precioProductoEdit');
    const error = document.getElementById('errorPrecioEdit');
    
    if (!precio.value || precio.value <= 0) {
        error.textContent = 'El precio debe ser mayor a 0';
        return false;
    }
    
    if (!/^\d+(\.\d{1,2})?$/.test(precio.value)) {
        error.textContent = 'Formato de precio inválido';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_stock_modificado() {
    const stock = document.getElementById('stockProductoEdit');
    const error = document.getElementById('errorStockEdit');
    
    if (!stock.value || stock.value <= 0) {
        error.textContent = 'El stock debe ser mayor a 0';
        return false;
    }
    
    if (!/^\d+$/.test(stock.value)) {
        error.textContent = 'El stock debe ser un número entero';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_fecha_modificado() {
    const fecha = document.getElementById('fechaRegistroProductoEdit');
    const error = document.getElementById('errorFechaRegistroEdit');
    
    if (!fecha.value) {
        error.textContent = 'Por favor, seleccione una fecha';
        return false;
    }
    
    const fechaSeleccionada = new Date(fecha.value);
    const fechaActual = new Date();
    
    if (fechaSeleccionada > fechaActual) {
        error.textContent = 'La fecha no puede ser futura';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_fecha_vencimiento_modificado() {
    const fechaRegistro = document.getElementById('fechaRegistroProductoEdit');
    const fechaVencimiento = document.getElementById('fechaVencimientoProductoEdit');
    const error = document.getElementById('errorFechaVencimientoEdit');
    
    if (!fechaVencimiento.value) {
        error.textContent = 'Por favor, seleccione una fecha de vencimiento';
        return false;
    }
    
    if (fechaRegistro.value && fechaVencimiento.value) {
        const fechaReg = new Date(fechaRegistro.value);
        const fechaVen = new Date(fechaVencimiento.value);
        
        if (fechaVen <= fechaReg) {
            error.textContent = 'La fecha de vencimiento debe ser posterior a la fecha de registro';
            return false;
        }
    }
    
    error.textContent = '';
    return true;
}

// Validaciones generales de formulario
function validar_formulario() {
    const validaciones = [
        validar_nombre(),
        validar_categoria(),
        validar_precio(),
        validar_stock(),
        validar_fecha(),
        validar_fecha_vencimiento(),
        validar_imagen()
    ];
    
    return validaciones.every(valid => valid === true);
}

function validar_formulario_modificado() {
    const validaciones = [
        validar_nombre_modificado(),
        validar_categoria_modificado(),
        validar_precio_modificado(),
        validar_stock_modificado(),
        validar_fecha_modificado(),
        validar_fecha_vencimiento_modificado()
    ];
    
    return validaciones.every(valid => valid === true);
}

// Funciones de gestión de productos
function VerDetalleProducto(idProducto) {
    // Cargar detalles del producto
    console.log('Ver detalle del producto:', idProducto);
    
    fetch(`index.php?url=productos&action=detalle&id=${idProducto}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cargarDetalleProductoEnModal(data.producto);
            } else {
                mostrarMensaje('Error al cargar los detalles del producto', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarMensaje('Error al cargar los detalles del producto', 'error');
        });
}

function cargarDetalleProductoEnModal(producto) {
    // Cargar datos en el modal de detalle
    document.getElementById('detalleImgProducto').src = producto.img;
    document.getElementById('detalleNombreProducto').textContent = producto.nombre_producto;
    document.getElementById('detalleIdProducto').textContent = `COD-00${producto.id_producto}`;
    document.getElementById('detallePrecioProducto').textContent = `$${parseFloat(producto.precio_venta).toFixed(2)}`;
    document.getElementById('detalleStockProducto').textContent = `${producto.stock} Cajas`;
    document.getElementById('detalleCategoriaProducto').textContent = producto.nombre_categoria;
    document.getElementById('detalleFechaRegistro').textContent = producto.fecha_registro;
    document.getElementById('detalleFechaVencimiento').textContent = producto.fecha_vencimiento;
    
    // Actualizar barra de progreso de stock
    const stockBar = document.getElementById('detalleStockBar');
    if (stockBar) {
        const stockPercent = Math.min((producto.stock / 100) * 100, 100); // Asumiendo 100 como máximo
        stockBar.style.width = `${stockPercent}%`;
        
        // Cambiar color según nivel de stock
        if (producto.stock < 10) {
            stockBar.style.background = 'linear-gradient(135deg, #dc3545 0%, #c82333 100%)';
            stockBar.textContent = 'Stock Bajo';
        } else if (producto.stock < 30) {
            stockBar.style.background = 'linear-gradient(135deg, #ffc107 0%, #ff9800 100%)';
            stockBar.textContent = 'Stock Medio';
        } else {
            stockBar.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
            stockBar.textContent = 'Stock Disponible';
        }
    }
}

function ObtenerProducto(idProducto) {
    // Cargar datos del producto para edición
    console.log('Obteniendo producto para edición:', idProducto);
    
    fetch(`index.php?url=productos&action=obtener&ID=${idProducto}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cargarDatosProductoEnModal(data.producto);
            } else {
                mostrarMensaje('Error al cargar los datos del producto', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarMensaje('Error al cargar los datos del producto', 'error');
        });
}

function cargarDatosProductoEnModal(producto) {
    // Cargar los datos en el modal de modificación
    document.getElementById('idEdit').value = producto.id_producto;
    document.getElementById('nombreProductoEdit').value = producto.nombre_producto;
    document.getElementById('nombreCategoriaEdit').value = producto.id_categoria;
    document.getElementById('precioProductoEdit').value = producto.precio_venta;
    document.getElementById('stockProductoEdit').value = producto.stock;
    document.getElementById('fechaRegistroProductoEdit').value = producto.fecha_registro;
    document.getElementById('fechaVencimientoProductoEdit').value = producto.fecha_vencimiento;
}

function EliminarProducto(event, idProducto) {
    event.preventDefault();
    
    if (!confirm('¿Está seguro de eliminar este producto? Esta acción no se puede deshacer.')) {
        return false;
    }
    
    console.log('Eliminando producto:', idProducto);
    
    fetch(`index.php?url=productos&action=eliminar&id=${idProducto}`, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarMensaje('Producto eliminado exitosamente', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            mostrarMensaje('Error al eliminar el producto', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensaje('Error al eliminar el producto', 'error');
    });
    
    return false;
}

// Funciones de utilidad
function limpiarMensajesError(form) {
    const errorElements = form.querySelectorAll('.error-messege');
    errorElements.forEach(element => {
        element.textContent = '';
    });
}

function mostrarMensaje(mensaje, tipo = 'info') {
    // Crear y mostrar alerta
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${tipo} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    // Auto-eliminar después de 5 segundos
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

// Inicialización final
document.addEventListener('DOMContentLoaded', function() {
    // Configurar eventos globales
    document.addEventListener('hidden.bs.modal', function (event) {
        // Limpiar formularios al cerrar modales
        const modal = event.target;
        const forms = modal.querySelectorAll('form');
        forms.forEach(form => {
            form.reset();
            limpiarMensajesError(form);
        });
    });
});
