/**
 * JavaScript para reportesView.php
 * Gestión de Reportes y Estadísticas
 */

document.addEventListener('DOMContentLoaded', function() {
    inicializarReportes();
});

function inicializarReportes() {
    configurarEventListenersReportes();
    inicializarAcordeon();
    configurarValidacionesFechas();
    inicializarFormulariosReporte();
}

function configurarEventListenersReportes() {
    // Event listeners para los formularios de reporte
    const formularios = document.querySelectorAll('form[action*="reportes"]');
    formularios.forEach(formulario => {
        formulario.addEventListener('submit', function(e) {
            if (!validarFormularioReporte(this)) {
                e.preventDefault();
                return false;
            }
            mostrarLoading(true);
            return true;
        });
    });
    
    // Event listeners para cambios en filtros
    const selects = document.querySelectorAll('.form-select');
    selects.forEach(select => {
        select.addEventListener('change', function() {
            actualizarFiltros(this);
        });
    });
    
    // Event listeners para inputs de fecha
    const fechaInputs = document.querySelectorAll('input[type="date"]');
    fechaInputs.forEach(input => {
        input.addEventListener('change', function() {
            validarRangoFechas(this);
        });
    });
}

function inicializarAcordeon() {
    // Configurar acordeón de Bootstrap
    const accordionItems = document.querySelectorAll('.accordion-button');
    accordionItems.forEach(button => {
        button.addEventListener('click', function() {
            const target = this.getAttribute('data-bs-target');
            const collapse = document.querySelector(target);
            
            if (collapse) {
                // Cargar datos dinámicamente si es necesario
                if (!collapse.classList.contains('show')) {
                    cargarDatosSeccion(target);
                }
            }
        });
    });
}

function configurarValidacionesFechas() {
    // Establecer fecha actual como límite
    const fechaInputs = document.querySelectorAll('input[type="date"]');
    const hoy = new Date().toISOString().split('T')[0];
    
    fechaInputs.forEach(input => {
        if (!input.hasAttribute('max') && input.name.includes('hasta')) {
            input.setAttribute('max', hoy);
        }
    });
}

function inicializarFormulariosReporte() {
    // Configurar validaciones específicas para cada tipo de reporte
    configurarValidacionesDashboard();
    configurarValidacionesEcommerce();
    configurarValidacionesNotificaciones();
    configurarValidacionesCatalogo();
}

function configurarValidacionesDashboard() {
    // Validaciones específicas para reportes de dashboard
    const formDashboard = document.querySelector('form[tipo="dashboard"]');
    if (formDashboard) {
        const fechaDesde = formDashboard.querySelector('input[name="fecha_desde"]');
        const fechaHasta = formDashboard.querySelector('input[name="fecha_hasta"]');
        
        if (fechaDesde && fechaHasta) {
            fechaDesde.addEventListener('change', function() {
                validarFechasDashboard(fechaDesde, fechaHasta);
            });
            
            fechaHasta.addEventListener('change', function() {
                validarFechasDashboard(fechaDesde, fechaHasta);
            });
        }
    }
}

function configurarValidacionesEcommerce() {
    // Validaciones específicas para reportes de ecommerce
    const formEcommerce = document.querySelector('form[tipo="ecommerce"]');
    if (formEcommerce) {
        const mes = formEcommerce.querySelector('select[name="mes"]');
        const anio = formEcommerce.querySelector('select[name="anio"]');
        
        if (mes && anio) {
            mes.addEventListener('change', function() {
                validarPeriodoEcommerce(mes, anio);
            });
            
            anio.addEventListener('change', function() {
                validarPeriodoEcommerce(mes, anio);
            });
        }
    }
}

function configurarValidacionesNotificaciones() {
    // Validaciones específicas para reportes de notificaciones
    const formNotificaciones = document.querySelector('form[tipo="notificaciones"]');
    if (formNotificaciones) {
        const fechaDesde = formNotificaciones.querySelector('input[name="fecha_desde"]');
        const fechaHasta = formNotificaciones.querySelector('input[name="fecha_hasta"]');
        
        if (fechaDesde && fechaHasta) {
            fechaDesde.addEventListener('change', function() {
                validarFechasNotificaciones(fechaDesde, fechaHasta);
            });
            
            fechaHasta.addEventListener('change', function() {
                validarFechasNotificaciones(fechaDesde, fechaHasta);
            });
        }
    }
}

function configurarValidacionesCatalogo() {
    // Validaciones específicas para reportes de catálogo
    const formCatalogo = document.querySelectorAll('form[tipo="clientes"], form[tipo="productos"], form[tipo="usuarios"]');
    formCatalogo.forEach(form => {
        configurarValidacionesFormularioCatalogo(form);
    });
}

function configurarValidacionesFormularioCatalogo(form) {
    const precioMin = form.querySelector('input[name="precio_min"]');
    const precioMax = form.querySelector('input[name="precio_max"]');
    
    if (precioMin && precioMax) {
        precioMin.addEventListener('change', function() {
            validarRangoPrecios(precioMin, precioMax);
        });
        
        precioMax.addEventListener('change', function() {
            validarRangoPrecios(precioMin, precioMax);
        });
    }
}

// Funciones de validación
function validarFormularioReporte(form) {
    let esValido = true;
    const errores = [];
    
    // Validar fechas si existen
    const fechaDesde = form.querySelector('input[name="fecha_desde"]');
    const fechaHasta = form.querySelector('input[name="fecha_hasta"]');
    
    if (fechaDesde && fechaHasta) {
        if (!validarRangoFechasGeneral(fechaDesde, fechaHasta)) {
            errores.push('El rango de fechas no es válido');
            esValido = false;
        }
    }
    
    // Validar rangos de precios si existen
    const precioMin = form.querySelector('input[name="precio_min"]');
    const precioMax = form.querySelector('input[name="precio_max"]');
    
    if (precioMin && precioMax) {
        if (!validarRangoPrecios(precioMin, precioMax)) {
            errores.push('El rango de precios no es válido');
            esValido = false;
        }
    }
    
    // Mostrar errores si existen
    if (!esValido) {
        mostrarErroresValidacion(errores);
    }
    
    return esValido;
}

function validarFechasDashboard(fechaDesde, fechaHasta) {
    if (!fechaDesde.value || !fechaHasta.value) {
        return true;
    }
    
    const desde = new Date(fechaDesde.value);
    const hasta = new Date(fechaHasta.value);
    
    if (hasta < desde) {
        mostrarError(fechaHasta, 'La fecha hasta debe ser posterior a la fecha desde');
        return false;
    }
    
    // Validar que el rango no sea mayor a 1 año
    const unAnio = 365 * 24 * 60 * 60 * 1000;
    if (hasta - desde > unAnio) {
        mostrarError(fechaHasta, 'El rango de fechas no puede superar 1 año');
        return false;
    }
    
    limpiarError(fechaHasta);
    return true;
}

function validarPeriodoEcommerce(mes, anio) {
    if (!mes.value || !anio.value) {
        return true;
    }
    
    // Validar que el mes y año no sean futuros
    const fechaSeleccionada = new Date(anio.value, mes.value - 1, 1);
    const fechaActual = new Date();
    
    if (fechaSeleccionada > fechaActual) {
        mostrarError(mes, 'No puedes seleccionar un período futuro');
        return false;
    }
    
    limpiarError(mes);
    return true;
}

function validarFechasNotificaciones(fechaDesde, fechaHasta) {
    if (!fechaDesde.value || !fechaHasta.value) {
        return true;
    }
    
    const desde = new Date(fechaDesde.value);
    const hasta = new Date(fechaHasta.value);
    
    if (hasta < desde) {
        mostrarError(fechaHasta, 'La fecha hasta debe ser posterior a la fecha desde');
        return false;
    }
    
    // Validar que el rango no sea mayor a 6 meses
    const seisMeses = 6 * 30 * 24 * 60 * 60 * 1000;
    if (hasta - desde > seisMeses) {
        mostrarError(fechaHasta, 'El rango de fechas no puede superar 6 meses');
        return false;
    }
    
    limpiarError(fechaHasta);
    return true;
}

function validarRangoPrecios(precioMin, precioMax) {
    if (!precioMin.value && !precioMax.value) {
        return true;
    }
    
    if (precioMin.value && precioMax.value) {
        const min = parseFloat(precioMin.value);
        const max = parseFloat(precioMax.value);
        
        if (min >= max) {
            mostrarError(precioMax, 'El precio máximo debe ser mayor al precio mínimo');
            return false;
        }
    }
    
    limpiarError(precioMax);
    return true;
}

function validarRangoFechasGeneral(fechaDesde, fechaHasta) {
    if (!fechaDesde.value || !fechaHasta.value) {
        return true;
    }
    
    const desde = new Date(fechaDesde.value);
    const hasta = new Date(fechaHasta.value);
    
    return hasta >= desde;
}

function validarRangoFechas(input) {
    const form = input.closest('form');
    const fechaDesde = form.querySelector('input[name="fecha_desde"]');
    const fechaHasta = form.querySelector('input[name="fecha_hasta"]');
    
    if (fechaDesde && fechaHasta) {
        validarRangoFechasGeneral(fechaDesde, fechaHasta);
    }
}

// Funciones de gestión de UI
function cargarDatosSeccion(target) {
    // Cargar datos dinámicamente para una sección del acordeón
    const seccion = target.replace('#collapse', '').toLowerCase();
    
    switch(seccion) {
        case 'dashboard':
            cargarEstadisticasDashboard();
            break;
        case 'notif':
            cargarEstadisticasNotificaciones();
            break;
        case 'admin':
            cargarEstadisticasCatalogo();
            break;
    }
}

function cargarEstadisticasDashboard() {
    // Simular carga de estadísticas del dashboard
    console.log('Cargando estadísticas del dashboard');
}

function cargarEstadisticasNotificaciones() {
    // Simular carga de estadísticas de notificaciones
    console.log('Cargando estadísticas de notificaciones');
}

function cargarEstadisticasCatalogo() {
    // Simular carga de estadísticas del catálogo
    console.log('Cargando estadísticas del catálogo');
}

function actualizarFiltros(select) {
    // Actualizar filtros dependientes
    const form = select.closest('form');
    const tipo = select.getAttribute('name');
    
    switch(tipo) {
        case 'tipo_cliente':
            actualizarFiltrosCliente(select, form);
            break;
        case 'categoria':
            actualizarFiltrosCategoria(select, form);
            break;
        case 'estado':
            actualizarFiltrosEstado(select, form);
            break;
    }
}

function actualizarFiltrosCliente(select, form) {
    // Actualizar filtros dependientes del tipo de cliente
    console.log('Actualizando filtros de cliente:', select.value);
}

function actualizarFiltrosCategoria(select, form) {
    // Actualizar filtros dependientes de la categoría
    console.log('Actualizando filtros de categoría:', select.value);
}

function actualizarFiltrosEstado(select, form) {
    // Actualizar filtros dependientes del estado
    console.log('Actualizando filtros de estado:', select.value);
}

// Funciones de utilidad
function mostrarLoading(show = true) {
    const loadingElements = document.querySelectorAll('.loading-overlay');
    if (loadingElements.length === 0) {
        // Crear overlay de carga si no existe
        const overlay = document.createElement('div');
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
                <span class="visually-hidden">Generando reporte...</span>
            </div>
        `;
        document.body.appendChild(overlay);
    }
    
    document.querySelectorAll('.loading-overlay').forEach(overlay => {
        overlay.style.display = show ? 'flex' : 'none';
    });
}

function mostrarError(input, mensaje) {
    // Limpiar error anterior
    limpiarError(input);
    
    // Crear elemento de error
    const errorDiv = document.createElement('div');
    errorDiv.className = 'invalid-feedback';
    errorDiv.textContent = mensaje;
    errorDiv.style.display = 'block';
    
    // Agregar clase de error al input
    input.classList.add('is-invalid');
    
    // Insertar mensaje de error
    input.parentNode.appendChild(errorDiv);
}

function limpiarError(input) {
    input.classList.remove('is-invalid');
    const errorDiv = input.parentNode.querySelector('.invalid-feedback');
    if (errorDiv) {
        errorDiv.remove();
    }
}

function mostrarErroresValidacion(errores) {
    const mensaje = errores.join('\n');
    
    // Usar SweetAlert si está disponible, si no usar alert
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'error',
            title: 'Error de validación',
            text: mensaje,
            confirmButtonColor: '#cc1d1d'
        });
    } else {
        alert('Error de validación:\n\n' + mensaje);
    }
}

function mostrarMensajeExito(mensaje) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: mensaje,
            timer: 3000,
            showConfirmButton: false
        });
    } else {
        alert(mensaje);
    }
}

// Funciones de exportación
function exportarReporte(tipo, formato = 'pdf') {
    // Función genérica para exportar reportes
    const form = document.querySelector(`form[tipo="${tipo}"]`);
    if (form) {
        if (validarFormularioReporte(form)) {
            // Abrir en nueva ventana
            const originalTarget = form.target;
            form.target = '_blank';
            form.submit();
            form.target = originalTarget;
        }
    }
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
    
    // Configurar evento para limpiar loading cuando se cierra una ventana
    window.addEventListener('beforeunload', function() {
        mostrarLoading(false);
    });
    
    // Configurar eventos de teclado
    document.addEventListener('keydown', function(e) {
        // Ctrl+Enter para generar reporte rápidamente
        if (e.ctrlKey && e.key === 'Enter') {
            const formActivo = document.activeElement.closest('form');
            if (formActivo && formActivo.hasAttribute('action')) {
                formActivo.dispatchEvent(new Event('submit'));
            }
        }
    });
});

// Función para inicialización cuando se carga dinámicamente
function reinicializarReportes() {
    inicializarReportes();
}

// Exportar funciones para uso global
window.reportesFunctions = {
    exportarReporte,
    mostrarLoading,
    mostrarMensajeExito,
    reinicializarReportes
};
