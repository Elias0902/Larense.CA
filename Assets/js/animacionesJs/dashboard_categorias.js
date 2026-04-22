/**
 * JavaScript para categoriasView.php
 * Gestión de Categorías
 */

document.addEventListener('DOMContentLoaded', function() {
    inicializarCategorias();
});

function inicializarCategorias() {
    configurarEventListenersCategorias();
    inicializarDataTable();
    configurarValidacionesCategorias();
    inicializarModalesCategorias();
}

function configurarEventListenersCategorias() {
    // Event listeners para los formularios
    const formCategoria = document.getElementById('formCategoria');
    if (formCategoria) {
        formCategoria.addEventListener('submit', function(e) {
            e.preventDefault();
            if (validar_formulario()) {
                this.submit();
            }
        });
    }
    
    const formCategoriaModificar = document.getElementById('formCategoriaModificar');
    if (formCategoriaModificar) {
        formCategoriaModificar.addEventListener('submit', function(e) {
            e.preventDefault();
            if (validar_formulario_modificado()) {
                this.submit();
            }
        });
    }
    
    // Event listeners para los botones de acción
    const botonesVer = document.querySelectorAll('[onclick^="VerDetalleCategoria"]');
    botonesVer.forEach(boton => {
        boton.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('onclick').match(/\d+/)[0];
            VerDetalleCategoria(parseInt(id));
        });
    });
    
    const botonesEditar = document.querySelectorAll('[onclick^="ObtenerCategoria"]');
    botonesEditar.forEach(boton => {
        boton.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('onclick').match(/\d+/)[0];
            ObtenerCategoria(parseInt(id));
        });
    });
    
    const botonesEliminar = document.querySelectorAll('[onclick^="EliminarCategoria"]');
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('onclick').match(/\d+/)[0];
            return EliminarCategoria(e, parseInt(id));
        });
    });
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
                { width: '20%' },
                { width: '60%' },
                { width: '20%' }
            ]
        });
    }
}

function configurarValidacionesCategorias() {
    // Configurar validaciones en tiempo real - formulario de agregar
    const camposValidacion = [
        { id: 'nombreCategoria', validator: validar_nombre }
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
        { id: 'nombreCategoriaEdit', validator: validar_nombre_modificado }
    ];
    
    camposValidacionEdit.forEach(campo => {
        const elemento = document.getElementById(campo.id);
        if (elemento) {
            elemento.addEventListener('input', campo.validator);
            elemento.addEventListener('blur', campo.validator);
        }
    });
}

function inicializarModalesCategorias() {
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
    const nombre = document.getElementById('nombreCategoria');
    const error = document.getElementById('errorCategoria');
    
    if (!nombre.value || nombre.value.trim().length < 2) {
        error.textContent = 'El nombre debe tener al menos 2 caracteres';
        return false;
    }
    
    if (!/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ-]+$/.test(nombre.value)) {
        error.textContent = 'El nombre contiene caracteres inválidos';
        return false;
    }
    
    if (nombre.value.trim().length > 50) {
        error.textContent = 'El nombre no puede superar los 50 caracteres';
        return false;
    }
    
    // Verificar si ya existe (simulado)
    if (verificarNombreDuplicado(nombre.value.trim())) {
        error.textContent = 'Esta categoría ya existe';
        return false;
    }
    
    error.textContent = '';
    return true;
}

// Funciones de validación - Formulario Modificar
function validar_nombre_modificado() {
    const nombre = document.getElementById('nombreCategoriaEdit');
    const error = document.getElementById('errorCategoriaEdit');
    
    if (!nombre.value || nombre.value.trim().length < 2) {
        error.textContent = 'El nombre debe tener al menos 2 caracteres';
        return false;
    }
    
    if (!/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ-]+$/.test(nombre.value)) {
        error.textContent = 'El nombre contiene caracteres inválidos';
        return false;
    }
    
    if (nombre.value.trim().length > 50) {
        error.textContent = 'El nombre no puede superar los 50 caracteres';
        return false;
    }
    
    error.textContent = '';
    return true;
}

// Validaciones generales de formulario
function validar_formulario() {
    const validaciones = [
        validar_nombre()
    ];
    
    return validaciones.every(valid => valid === true);
}

function validar_formulario_modificado() {
    const validaciones = [
        validar_nombre_modificado()
    ];
    
    return validaciones.every(valid => valid === true);
}

// Funciones de gestión de categorías
function VerDetalleCategoria(id) {
    // Obtener datos de la fila correspondiente
    const fila = document.querySelector(`tr[data-id='${id}']`);
    if (!fila) {
        mostrarMensaje('error', 'Error', 'No se encontró el registro de la categoría');
        return;
    }
    
    // Extraer datos de la fila
    const idCategoria = fila.querySelector('td:nth-child(1) .badge').textContent.trim();
    const nombreCategoria = fila.querySelector('td:nth-child(2)').textContent.trim();
    
    // Actualizar el modal de detalle
    document.getElementById('detalleIdCategoria').textContent = idCategoria;
    document.getElementById('detalleNombreCategoria').textContent = nombreCategoria;
    
    // Simular estadísticas (esto debería venir del backend)
    const estadisticas = generarEstadisticasCategoria(id);
    actualizarEstadisticasModal(estadisticas);
}

function generarEstadisticasCategoria(id) {
    // Simular generación de estadísticas
    return {
        totalProductos: Math.floor(Math.random() * 50) + 5,
        productosActivos: Math.floor(Math.random() * 40) + 3,
        productosInactivos: Math.floor(Math.random() * 10) + 1,
        valorInventario: Math.floor(Math.random() * 10000) + 1000,
        fechaCreacion: generarFechaAleatoria(),
        ultimaModificacion: generarFechaAleatoria(true)
    };
}

function actualizarEstadisticasModal(estadisticas) {
    // Actualizar elementos del modal con estadísticas
    const elementos = {
        'detalleTotalProductos': estadisticas.totalProductos,
        'detalleProductosActivos': estadisticas.productosActivos,
        'detalleProductosInactivos': estadisticas.productosInactivos,
        'detalleValorInventario': `$${estadisticas.valorInventario.toLocaleString()}`,
        'detalleFechaCreacion': estadisticas.fechaCreacion,
        'detalleUltimaModificacion': estadisticas.ultimaModificacion
    };
    
    Object.keys(elementos).forEach(id => {
        const elemento = document.getElementById(id);
        if (elemento) {
            elemento.textContent = elementos[id];
        }
    });
    
    // Actualizar barra de progreso de productos activos
    const progresoActivos = (estadisticas.productosActivos / estadisticas.totalProductos) * 100;
    const barraProgreso = document.getElementById('detalleProgresoActivos');
    if (barraProgreso) {
        barraProgreso.style.width = `${progresoActivos}%`;
        barraProgreso.textContent = `${Math.round(progresoActivos)}%`;
    }
}

function generarFechaAleatoria(reciente = false) {
    const ahora = new Date();
    const diasAtras = reciente ? Math.floor(Math.random() * 30) : Math.floor(Math.random() * 365) + 30;
    const fecha = new Date(ahora.getTime() - diasAtras * 24 * 60 * 60 * 1000);
    return fecha.toLocaleDateString('es-ES');
}

function ObtenerCategoria(idCategoria) {
    // Cargar datos de la categoría para edición
    console.log('Obteniendo categoría para edición:', idCategoria);
    
    fetch(`index.php?url=categorias&action=obtener&id=${idCategoria}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cargarDatosCategoriaEnModal(data.categoria);
            } else {
                mostrarMensaje('error', 'Error', 'Error al cargar los datos de la categoría');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarMensaje('error', 'Error', 'Error al cargar los datos de la categoría');
        });
}

function cargarDatosCategoriaEnModal(categoria) {
    // Cargar los datos en el modal de modificación
    document.getElementById('id').value = categoria.id_categoria;
    document.getElementById('nombreCategoriaEdit').value = categoria.nombre_categoria;
}

function EliminarCategoria(event, idCategoria) {
    event.preventDefault();
    
    if (!confirm('¿Está seguro de eliminar esta categoría? Esta acción podría afectar a los productos asociados.')) {
        return false;
    }
    
    console.log('Eliminando categoría:', idCategoria);
    
    fetch(`index.php?url=categorias&action=eliminar&id=${idCategoria}`, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarMensaje('success', 'Éxito', 'Categoría eliminada exitosamente');
            setTimeout(() => location.reload(), 1500);
        } else {
            mostrarMensaje('error', 'Error', data.message || 'Error al eliminar la categoría');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensaje('error', 'Error', 'Error al eliminar la categoría');
    });
    
    return false;
}

function verificarNombreDuplicado(nombre) {
    // Verificar si el nombre ya existe en la tabla
    const filas = document.querySelectorAll('#add-row tbody tr');
    const nombresExistentes = Array.from(filas).map(fila => 
        fila.querySelector('td:nth-child(2)').textContent.trim().toLowerCase()
    );
    
    return nombresExistentes.includes(nombre.toLowerCase());
}

// Funciones de utilidad
function limpiarMensajesError(form) {
    const errorElements = form.querySelectorAll('.error-messege');
    errorElements.forEach(element => {
        element.textContent = '';
    });
    
    // Limpiar clases de validación
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.classList.remove('is-invalid', 'is-valid');
    });
}

function mostrarMensaje(tipo, titulo, mensaje) {
    // Usar SweetAlert si está disponible, si no usar alert
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: tipo,
            title: titulo,
            text: mensaje,
            confirmButtonColor: '#dc3545'
        });
    } else {
        alert(`${titulo}: ${mensaje}`);
    }
}

function mostrarLoading(show = true) {
    // Crear overlay de carga si no existe
    let overlay = document.querySelector('.loading-overlay');
    
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.className = 'loading-overlay';
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        `;
        overlay.innerHTML = `
            <div class="spinner-border text-light" role="status">
                <span class="visually-hidden">Procesando...</span>
            </div>
        `;
        document.body.appendChild(overlay);
    }
    
    overlay.style.display = show ? 'flex' : 'none';
}

// Funciones de búsqueda y filtrado
function buscarCategoria(termino) {
    const filas = document.querySelectorAll('#add-row tbody tr');
    let coincidencias = 0;
    
    filas.forEach(fila => {
        const nombre = fila.querySelector('td:nth-child(2)').textContent.toLowerCase();
        const id = fila.querySelector('td:nth-child(1)').textContent.toLowerCase();
        
        if (nombre.includes(termino.toLowerCase()) || id.includes(termino.toLowerCase())) {
            fila.style.display = '';
            coincidencias++;
        } else {
            fila.style.display = 'none';
        }
    });
    
    // Mostrar mensaje si no hay coincidencias
    const noRegistros = document.querySelector('.no-registros');
    if (coincidencias === 0 && !noRegistros) {
        const mensaje = document.createElement('tr');
        mensaje.className = 'no-registros';
        mensaje.innerHTML = '<td colspan="3" class="text-center py-4">No se encontraron categorías que coincidan con la búsqueda</td>';
        document.querySelector('#add-row tbody').appendChild(mensaje);
    } else if (coincidencias > 0 && noRegistros) {
        noRegistros.remove();
    }
}

// Funciones de exportación
function exportarCategorias(formato = 'pdf') {
    // Función para exportar categorías
    const url = `index.php?url=categorias&action=exportar&formato=${formato}`;
    window.open(url, '_blank');
}

// Funciones de gestión de productos por categoría
function verProductosPorCategoria(idCategoria) {
    // Mostrar productos asociados a una categoría
    fetch(`index.php?url=categorias&action=productos&id=${idCategoria}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarModalProductos(data.productos);
            } else {
                mostrarMensaje('error', 'Error', 'Error al cargar los productos');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarMensaje('error', 'Error', 'Error al cargar los productos');
        });
}

function mostrarModalProductos(productos) {
    // Crear modal para mostrar productos
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.id = 'productosCategoriaModal';
    modal.innerHTML = `
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: #dc3545; color: white;">
                    <h5 class="modal-title">
                        <i class="fa fa-box me-2"></i>Productos de la Categoría
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Stock</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${productos.map(producto => `
                                    <tr>
                                        <td>${producto.id_producto}</td>
                                        <td>${producto.nombre_producto}</td>
                                        <td>${producto.stock}</td>
                                        <td>$${parseFloat(producto.precio_venta).toFixed(2)}</td>
                                        <td>
                                            <span class="badge ${producto.status ? 'bg-success' : 'bg-danger'}">
                                                ${producto.status ? 'Activo' : 'Inactivo'}
                                            </span>
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    const modalInstance = new bootstrap.Modal(modal);
    modalInstance.show();
    
    // Eliminar modal del DOM al cerrarlo
    modal.addEventListener('hidden.bs.modal', function() {
        modal.remove();
    });
}

// Event listeners globales
document.addEventListener('DOMContentLoaded', function() {
    // Configurar tooltips si existe Bootstrap
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Configurar eventos de teclado
    document.addEventListener('keydown', function(e) {
        // Ctrl+Enter para guardar en formularios activos
        if (e.ctrlKey && e.key === 'Enter') {
            const formActivo = document.activeElement.closest('form');
            if (formActivo && (formActivo.id === 'formCategoria' || formActivo.id === 'formCategoriaModificar')) {
                formActivo.dispatchEvent(new Event('submit'));
            }
        }
        
        // Escape para cerrar modales
        if (e.key === 'Escape') {
            const modals = document.querySelectorAll('.modal.show');
            modals.forEach(modal => {
                const instance = bootstrap.Modal.getInstance(modal);
                if (instance) {
                    instance.hide();
                }
            });
        }
    });
    
    // Configurar búsqueda si existe campo de búsqueda
    const busquedaInput = document.getElementById('busquedaCategoria');
    if (busquedaInput) {
        busquedaInput.addEventListener('input', function() {
            buscarCategoria(this.value);
        });
    }
});

// Función para inicialización cuando se carga dinámicamente
function reinicializarCategorias() {
    inicializarCategorias();
}

// Exportar funciones para uso global
window.categoriasFunctions = {
    VerDetalleCategoria,
    ObtenerCategoria,
    EliminarCategoria,
    exportarCategorias,
    verProductosPorCategoria,
    reinicializarCategorias
};
