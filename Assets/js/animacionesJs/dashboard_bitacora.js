/**
 * JavaScript para bitacoraView.php
 * Gestión de Bitácora del Sistema
 */

document.addEventListener('DOMContentLoaded', function() {
    inicializarBitacora();
});

function inicializarBitacora() {
    configurarEventListenersBitacora();
    inicializarDataTable();
    configurarFiltrosBitacora();
    configurarAutoActualizacion();
}

function configurarEventListenersBitacora() {
    // Event listener para el botón de actualizar
    const btnActualizar = document.querySelector('button[onclick="location.reload()"]');
    if (btnActualizar) {
        btnActualizar.addEventListener('click', function(e) {
            e.preventDefault();
            actualizarBitacora();
        });
    }
    
    // Event listeners para filtros si existen
    const filtros = document.querySelectorAll('.filtro-bitacora');
    filtros.forEach(filtro => {
        filtro.addEventListener('change', function() {
            aplicarFiltros();
        });
        
        filtro.addEventListener('input', function() {
            if (this.type === 'text' || this.type === 'search') {
                aplicarFiltros();
            }
        });
    });
    
    // Event listeners para botones de acción
    const botonesVer = document.querySelectorAll('[onclick^="VerDetalleBitacora"]');
    botonesVer.forEach(boton => {
        boton.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('onclick').match(/\d+/)[0];
            VerDetalleBitacora(parseInt(id));
        });
    });
    
    const botonesExportar = document.querySelectorAll('[onclick^="exportarBitacora"]');
    botonesExportar.forEach(boton => {
        boton.addEventListener('click', function(e) {
            e.preventDefault();
            const formato = this.getAttribute('data-formato') || 'pdf';
            exportarBitacora(formato);
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
            pageLength: 25,
            order: [[0, 'desc']],
            columns: [
                { width: '10%' },
                { width: '15%' },
                { width: '15%' },
                { width: '12%' },
                { width: '12%' },
                { width: '30%' },
                { width: '6%' }
            ],
            initComplete: function() {
                // Agregar controles de filtrado personalizados
                agregarControlesFiltro();
            }
        });
    }
}

function configurarFiltrosBitacora() {
    // Configurar filtros de fecha
    const fechaDesde = document.getElementById('fechaDesde');
    const fechaHasta = document.getElementById('fechaHasta');
    
    if (fechaDesde && fechaHasta) {
        fechaDesde.addEventListener('change', function() {
            validarRangoFechas();
            aplicarFiltros();
        });
        
        fechaHasta.addEventListener('change', function() {
            validarRangoFechas();
            aplicarFiltros();
        });
        
        // Establecer fecha por defecto (últimos 7 días)
        establecerFechasPorDefecto();
    }
    
    // Configurar filtro de módulo
    const filtroModulo = document.getElementById('filtroModulo');
    if (filtroModulo) {
        filtroModulo.addEventListener('change', aplicarFiltros);
    }
    
    // Configurar filtro de acción
    const filtroAccion = document.getElementById('filtroAccion');
    if (filtroAccion) {
        filtroAccion.addEventListener('change', aplicarFiltros);
    }
    
    // Configurar filtro de usuario
    const filtroUsuario = document.getElementById('filtroUsuario');
    if (filtroUsuario) {
        filtroUsuario.addEventListener('input', debounce(aplicarFiltros, 300));
    }
}

function configurarAutoActualizacion() {
    // Configurar actualización automática cada 30 segundos
    setInterval(function() {
        if (!document.hidden) { // Solo actualizar si la pestaña está visible
            verificarNuevosRegistros();
        }
    }, 30000);
}

// Funciones principales
function actualizarBitacora() {
    mostrarLoading(true);
    
    // Simular actualización
    setTimeout(() => {
        location.reload();
    }, 500);
}

function VerDetalleBitacora(idBitacora) {
    // Obtener datos del registro
    const fila = document.querySelector(`tr[data-id='${idBitacora}']`);
    if (!fila) {
        mostrarMensaje('error', 'Error', 'No se encontró el registro de bitácora');
        return;
    }
    
    // Extraer datos de la fila
    const datos = {
        id: fila.querySelector('td:nth-child(1) .badge').textContent.trim(),
        usuario: fila.querySelector('td:nth-child(2)').textContent.trim(),
        fecha: fila.querySelector('td:nth-child(3)').textContent.trim(),
        modulo: fila.querySelector('td:nth-child(4) .badge').textContent.trim(),
        accion: fila.querySelector('td:nth-child(5) .badge').textContent.trim(),
        descripcion: fila.querySelector('td:nth-child(6)').textContent.trim()
    };
    
    // Mostrar modal con detalles
    mostrarModalDetalleBitacora(datos);
}

function mostrarModalDetalleBitacora(datos) {
    // Crear modal dinámicamente si no existe
    let modal = document.getElementById('detalleBitacoraModal');
    if (!modal) {
        modal = crearModalDetalleBitacora();
        document.body.appendChild(modal);
    }
    
    // Actualizar contenido del modal
    document.getElementById('detalleId').textContent = datos.id;
    document.getElementById('detalleUsuario').textContent = datos.usuario;
    document.getElementById('detalleFecha').textContent = datos.fecha;
    document.getElementById('detalleModulo').textContent = datos.modulo;
    document.getElementById('detalleAccion').textContent = datos.accion;
    document.getElementById('detalleDescripcion').textContent = datos.descripcion;
    
    // Mostrar modal
    const modalInstance = new bootstrap.Modal(modal);
    modalInstance.show();
}

function crearModalDetalleBitacora() {
    const modal = document.createElement('div');
    modal.id = 'detalleBitacoraModal';
    modal.className = 'modal fade';
    modal.innerHTML = `
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: #dc3545; color: white;">
                    <h5 class="modal-title">
                        <i class="fa fa-clipboard-list me-2"></i>Detalle de Bitácora
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">ID Registro:</label>
                                <p id="detalleId" class="form-control-plaintext"></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Usuario:</label>
                                <p id="detalleUsuario" class="form-control-plaintext"></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Fecha y Hora:</label>
                                <p id="detalleFecha" class="form-control-plaintext"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Módulo:</label>
                                <p id="detalleModulo" class="form-control-plaintext"></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Acción:</label>
                                <p id="detalleAccion" class="form-control-plaintext"></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Descripción:</label>
                                <p id="detalleDescripcion" class="form-control-plaintext"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    `;
    return modal;
}

function aplicarFiltros() {
    const table = $('#add-row').DataTable();
    
    // Obtener valores de los filtros
    const fechaDesde = document.getElementById('fechaDesde')?.value || '';
    const fechaHasta = document.getElementById('fechaHasta')?.value || '';
    const modulo = document.getElementById('filtroModulo')?.value || '';
    const accion = document.getElementById('filtroAccion')?.value || '';
    const usuario = document.getElementById('filtroUsuario')?.value.toLowerCase() || '';
    
    // Aplicar filtros a la tabla
    table.search('').draw(); // Limpiar búsqueda global
    
    // Filtrar por cada columna
    table.column(2).search(fechaDesde).draw(); // Fecha
    table.column(3).search(modulo).draw();     // Módulo
    table.column(4).search(accion).draw();     // Acción
    table.column(1).search(usuario).draw();    // Usuario
    
    // Aplicar filtro de rango de fechas si existe
    if (fechaDesde || fechaHasta) {
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            const fechaRegistro = data[2]; // Columna de fecha
            
            if (!fechaDesde && !fechaHasta) return true;
            
            const fecha = new Date(fechaRegistro.split(' ')[0].split('/').reverse().join('-'));
            const desde = fechaDesde ? new Date(fechaDesde) : new Date('1900-01-01');
            const hasta = fechaHasta ? new Date(fechaHasta) : new Date('2100-12-31');
            
            return fecha >= desde && fecha <= hasta;
        });
        table.draw();
    }
}

function validarRangoFechas() {
    const fechaDesde = document.getElementById('fechaDesde');
    const fechaHasta = document.getElementById('fechaHasta');
    
    if (fechaDesde.value && fechaHasta.value) {
        const desde = new Date(fechaDesde.value);
        const hasta = new Date(fechaHasta.value);
        
        if (hasta < desde) {
            mostrarMensaje('warning', 'Advertencia', 'La fecha "hasta" debe ser posterior a la fecha "desde"');
            fechaHasta.value = '';
            return false;
        }
        
        // Validar que el rango no sea mayor a 30 días
        const diasDiferencia = Math.ceil((hasta - desde) / (1000 * 60 * 60 * 24));
        if (diasDiferencia > 30) {
            mostrarMensaje('warning', 'Advertencia', 'El rango de fechas no puede superar los 30 días');
            fechaHasta.value = '';
            return false;
        }
    }
    
    return true;
}

function establecerFechasPorDefecto() {
    const fechaDesde = document.getElementById('fechaDesde');
    const fechaHasta = document.getElementById('fechaHasta');
    
    if (fechaDesde && fechaHasta && !fechaDesde.value && !fechaHasta.value) {
        const hoy = new Date();
        const hace7Dias = new Date(hoy.getTime() - 7 * 24 * 60 * 60 * 1000);
        
        fechaDesde.value = hace7Dias.toISOString().split('T')[0];
        fechaHasta.value = hoy.toISOString().split('T')[0];
    }
}

function agregarControlesFiltro() {
    // Agregar controles de filtrado personalizados al DataTable
    const table = $('#add-row').DataTable();
    
    // Crear contenedor para filtros
    const filterContainer = document.createElement('div');
    filterContainer.className = 'row mb-3';
    filterContainer.innerHTML = `
        <div class="col-md-3">
            <input type="date" id="fechaDesde" class="form-control form-control-sm" placeholder="Fecha desde">
        </div>
        <div class="col-md-3">
            <input type="date" id="fechaHasta" class="form-control form-control-sm" placeholder="Fecha hasta">
        </div>
        <div class="col-md-2">
            <select id="filtroModulo" class="form-select form-select-sm">
                <option value="">Todos los módulos</option>
                <option value="Usuarios">Usuarios</option>
                <option value="Productos">Productos</option>
                <option value="Clientes">Clientes</option>
                <option value="Ventas">Ventas</option>
            </select>
        </div>
        <div class="col-md-2">
            <select id="filtroAccion" class="form-select form-select-sm">
                <option value="">Todas las acciones</option>
                <option value="Crear">Crear</option>
                <option value="Modificar">Modificar</option>
                <option value="Eliminar">Eliminar</option>
                <option value="Login">Login</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="text" id="filtroUsuario" class="form-control form-control-sm" placeholder="Usuario...">
        </div>
    `;
    
    // Insertar filtros antes de la tabla
    const tableWrapper = $('#add-row_wrapper').first();
    if (tableWrapper.length) {
        tableWrapper.prepend(filterContainer);
        
        // Reconfigurar event listeners para los nuevos elementos
        configurarFiltrosBitacora();
    }
}

function verificarNuevosRegistros() {
    // Verificar si hay nuevos registros mediante AJAX
    fetch('index.php?url=bitacora&action=verificar_nuevos')
        .then(response => response.json())
        .then(data => {
            if (data.nuevos > 0) {
                mostrarNotificacionNuevosRegistros(data.nuevos);
            }
        })
        .catch(error => {
            console.error('Error verificando nuevos registros:', error);
        });
}

function mostrarNotificacionNuevosRegistros(cantidad) {
    const notificacion = document.createElement('div');
    notificacion.className = 'alert alert-info alert-dismissible fade show position-fixed';
    notificacion.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notificacion.innerHTML = `
        <i class="fa fa-info-circle me-2"></i>
        Hay ${cantidad} nuevos registros en la bitácora
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <button type="button" class="btn btn-sm btn-primary ms-2" onclick="actualizarBitacora()">Actualizar</button>
    `;
    
    document.body.appendChild(notificacion);
    
    // Auto-eliminar después de 10 segundos
    setTimeout(() => {
        if (notificacion.parentNode) {
            notificacion.remove();
        }
    }, 10000);
}

function exportarBitacora(formato = 'pdf') {
    // Obtener filtros actuales
    const filtros = {
        fechaDesde: document.getElementById('fechaDesde')?.value || '',
        fechaHasta: document.getElementById('fechaHasta')?.value || '',
        modulo: document.getElementById('filtroModulo')?.value || '',
        accion: document.getElementById('filtroAccion')?.value || '',
        usuario: document.getElementById('filtroUsuario')?.value || ''
    };
    
    // Construir URL de exportación
    const params = new URLSearchParams({
        action: 'exportar',
        formato: formato,
        ...filtros
    });
    
    const url = `index.php?url=bitacora&${params.toString()}`;
    
    // Abrir en nueva ventana
    window.open(url, '_blank');
}

// Funciones de utilidad
function mostrarLoading(show = true) {
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
                <span class="visually-hidden">Cargando...</span>
            </div>
        `;
        document.body.appendChild(overlay);
    }
    
    overlay.style.display = show ? 'flex' : 'none';
}

function mostrarMensaje(tipo, titulo, mensaje) {
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

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
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
        // F5 para actualizar
        if (e.key === 'F5') {
            e.preventDefault();
            actualizarBitacora();
        }
        
        // Ctrl+E para exportar
        if (e.ctrlKey && e.key === 'e') {
            e.preventDefault();
            exportarBitacora('pdf');
        }
    });
});

// Función para inicialización cuando se carga dinámicamente
function reinicializarBitacora() {
    inicializarBitacora();
}

// Exportar funciones para uso global
window.bitacoraFunctions = {
    VerDetalleBitacora,
    exportarBitacora,
    actualizarBitacora,
    reinicializarBitacora
};
