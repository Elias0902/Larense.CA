/**
 * JavaScript para promocionesView.php
 * Gestión de Promociones y Descuentos
 */

document.addEventListener('DOMContentLoaded', function() {
    inicializarPromociones();
});

function inicializarPromociones() {
    configurarEventListenersPromociones();
    inicializarDataTable();
    configurarValidacionesPromociones();
    inicializarModalesPromociones();
}

function configurarEventListenersPromociones() {
    // Event listeners para los formularios
    const formPromocion = document.getElementById('formPromocion');
    if (formPromocion) {
        formPromocion.addEventListener('submit', function(e) {
            e.preventDefault();
            if (validar_formulario()) {
                this.submit();
            }
        });
    }
    
    const formPromocionModificar = document.getElementById('formPromocionModificar');
    if (formPromocionModificar) {
        formPromocionModificar.addEventListener('submit', function(e) {
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
                { width: '8%' },
                { width: '12%' },
                { width: '20%' },
                { width: '12%' },
                { width: '10%' },
                { width: '15%' },
                { width: '10%' },
                { width: '13%' }
            ]
        });
    }
}

function configurarValidacionesPromociones() {
    // Configurar validaciones en tiempo real - formulario de agregar
    const camposValidacion = [
        { id: 'codigoPromocion', validator: validar_codigo },
        { id: 'tipoPromocion', validator: validar_tipo },
        { id: 'nombrePromocion', validator: validar_nombre },
        { id: 'valorPromocion', validator: validar_valor },
        { id: 'descripcionPromocion', validator: validar_descripcion },
        { id: 'fechaInicio', validator: validar_fechas },
        { id: 'fechaFin', validator: validar_fechas }
    ];
    
    camposValidacion.forEach(campo => {
        const elemento = document.getElementById(campo.id);
        if (elemento) {
            elemento.addEventListener('input', campo.validator);
            elemento.addEventListener('blur', campo.validator);
            elemento.addEventListener('change', campo.validator);
        }
    });
    
    // Configurar validaciones en tiempo real - formulario de modificar
    const camposValidacionEdit = [
        { id: 'codigoPromocionEdit', validator: validar_codigo_modificado },
        { id: 'tipoPromocionEdit', validator: validar_tipo_modificado },
        { id: 'nombrePromocionEdit', validator: validar_nombre_modificado },
        { id: 'valorPromocionEdit', validator: validar_valor_modificado },
        { id: 'descripcionPromocionEdit', validator: validar_descripcion_modificado },
        { id: 'fechaInicioEdit', validator: validar_fechas_modificado },
        { id: 'fechaFinEdit', validator: validar_fechas_modificado }
    ];
    
    camposValidacionEdit.forEach(campo => {
        const elemento = document.getElementById(campo.id);
        if (elemento) {
            elemento.addEventListener('input', campo.validator);
            elemento.addEventListener('blur', campo.validator);
            elemento.addEventListener('change', campo.validator);
        }
    });
}

function inicializarModalesPromociones() {
    // Configurar modales de Bootstrap
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        new bootstrap.Modal(modal);
    });
    
    // Configurar eventos de modales
    document.addEventListener('show.bs.modal', function (event) {
        const modal = event.target;
        const form = modal.querySelector('form');
        // Solo limpiar el modal de agregar, no el de modificar
        if (form && modal.id === 'promocionModal') {
            form.reset();
            limpiarMensajesError(form);
        }
    });
}

// Funciones de validación - Formulario Agregar
function validar_codigo() {
    const codigo = document.getElementById('codigoPromocion');
    const error = document.getElementById('errorCodigo');
    
    if (!codigo.value || codigo.value.trim().length < 2) {
        error.textContent = 'El código debe tener al menos 2 caracteres';
        return false;
    }
    
    if (!/^[A-Z0-9%\-_]+$/.test(codigo.value.toUpperCase())) {
        error.textContent = 'El código solo puede contener letras, números, %, guiones y guiones bajos';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_tipo() {
    const tipo = document.getElementById('tipoPromocion');
    const error = document.getElementById('errorTipo');
    
    if (!tipo.value) {
        error.textContent = 'Por favor, seleccione un tipo de promoción';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_nombre() {
    const nombre = document.getElementById('nombrePromocion');
    const error = document.getElementById('errorNombre');
    
    if (!nombre.value || nombre.value.trim().length < 3) {
        error.textContent = 'El nombre debe tener al menos 3 caracteres';
        return false;
    }
    
    if (!/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ-]+$/.test(nombre.value)) {
        error.textContent = 'El nombre contiene caracteres inválidos';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_valor() {
    const valor = document.getElementById('valorPromocion');
    const tipo = document.getElementById('tipoPromocion');
    const error = document.getElementById('errorValor');
    
    if (!valor.value) {
        error.textContent = 'Por favor, ingrese un valor';
        return false;
    }
    
    const valorNumerico = parseFloat(valor.value);
    
    if (tipo.value === 'porcentaje') {
        if (valorNumerico < 0 || valorNumerico > 100) {
            error.textContent = 'El porcentaje debe estar entre 0 y 100';
            return false;
        }
    } else if (tipo.value === 'monto_fijo') {
        if (valorNumerico <= 0) {
            error.textContent = 'El monto debe ser mayor a 0';
            return false;
        }
    } else if (tipo.value === '2x1') {
        // Para 2x1, el valor debería ser "2x1" o un número entero
        if (valor.value !== '2x1' && !/^\d+$/.test(valor.value)) {
            error.textContent = 'Para 2x1, ingrese "2x1" o un número entero';
            return false;
        }
    }
    
    error.textContent = '';
    return true;
}

function validar_descripcion() {
    const descripcion = document.getElementById('descripcionPromocion');
    const error = document.getElementById('errorDescripcion');
    
    if (!descripcion.value || descripcion.value.trim().length < 10) {
        error.textContent = 'La descripción debe tener al menos 10 caracteres';
        return false;
    }
    
    if (descripcion.value.trim().length > 500) {
        error.textContent = 'La descripción no puede superar los 500 caracteres';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_fechas() {
    const fechaInicio = document.getElementById('fechaInicio');
    const fechaFin = document.getElementById('fechaFin');
    const errorInicio = document.getElementById('errorFechaInicio');
    const errorFin = document.getElementById('errorFechaFin');
    
    let esValido = true;
    
    // Validar fecha de inicio
    if (!fechaInicio.value) {
        errorInicio.textContent = 'Por favor, seleccione una fecha de inicio';
        esValido = false;
    } else {
        const fechaInicioDate = new Date(fechaInicio.value);
        const fechaActual = new Date();
        
        if (fechaInicioDate < fechaActual.setHours(0, 0, 0, 0)) {
            errorInicio.textContent = 'La fecha de inicio no puede ser anterior a hoy';
            esValido = false;
        } else {
            errorInicio.textContent = '';
        }
    }
    
    // Validar fecha de fin
    if (!fechaFin.value) {
        errorFin.textContent = 'Por favor, seleccione una fecha de fin';
        esValido = false;
    } else {
        errorFin.textContent = '';
    }
    
    // Validar que la fecha de fin sea posterior a la de inicio
    if (fechaInicio.value && fechaFin.value) {
        const fechaInicioDate = new Date(fechaInicio.value);
        const fechaFinDate = new Date(fechaFin.value);
        
        if (fechaFinDate <= fechaInicioDate) {
            errorFin.textContent = 'La fecha de fin debe ser posterior a la fecha de inicio';
            esValido = false;
        }
    }
    
    return esValido;
}

// Funciones de validación - Formulario Modificar
function validar_codigo_modificado() {
    const codigo = document.getElementById('codigoPromocionEdit');
    const error = document.getElementById('errorCodigoEdit');
    
    if (!codigo.value || codigo.value.trim().length < 2) {
        error.textContent = 'El código debe tener al menos 2 caracteres';
        return false;
    }
    
    if (!/^[A-Z0-9%\-_]+$/.test(codigo.value.toUpperCase())) {
        error.textContent = 'El código solo puede contener letras, números, %, guiones y guiones bajos';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_tipo_modificado() {
    const tipo = document.getElementById('tipoPromocionEdit');
    const error = document.getElementById('errorTipoEdit');
    
    if (!tipo.value) {
        error.textContent = 'Por favor, seleccione un tipo de promoción';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_nombre_modificado() {
    const nombre = document.getElementById('nombrePromocionEdit');
    const error = document.getElementById('errorNombreEdit');
    
    if (!nombre.value || nombre.value.trim().length < 3) {
        error.textContent = 'El nombre debe tener al menos 3 caracteres';
        return false;
    }
    
    if (!/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ-]+$/.test(nombre.value)) {
        error.textContent = 'El nombre contiene caracteres inválidos';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_valor_modificado() {
    const valor = document.getElementById('valorPromocionEdit');
    const tipo = document.getElementById('tipoPromocionEdit');
    const error = document.getElementById('errorValorEdit');
    
    if (!valor.value) {
        error.textContent = 'Por favor, ingrese un valor';
        return false;
    }
    
    const valorNumerico = parseFloat(valor.value);
    
    if (tipo.value === 'porcentaje') {
        if (valorNumerico < 0 || valorNumerico > 100) {
            error.textContent = 'El porcentaje debe estar entre 0 y 100';
            return false;
        }
    } else if (tipo.value === 'monto_fijo') {
        if (valorNumerico <= 0) {
            error.textContent = 'El monto debe ser mayor a 0';
            return false;
        }
    } else if (tipo.value === '2x1') {
        if (valor.value !== '2x1' && !/^\d+$/.test(valor.value)) {
            error.textContent = 'Para 2x1, ingrese "2x1" o un número entero';
            return false;
        }
    }
    
    error.textContent = '';
    return true;
}

function validar_descripcion_modificado() {
    const descripcion = document.getElementById('descripcionPromocionEdit');
    const error = document.getElementById('errorDescripcionEdit');
    
    if (!descripcion.value || descripcion.value.trim().length < 10) {
        error.textContent = 'La descripción debe tener al menos 10 caracteres';
        return false;
    }
    
    if (descripcion.value.trim().length > 500) {
        error.textContent = 'La descripción no puede superar los 500 caracteres';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_fechas_modificado() {
    const fechaInicio = document.getElementById('fechaInicioEdit');
    const fechaFin = document.getElementById('fechaFinEdit');
    const errorInicio = document.getElementById('errorFechaInicioEdit');
    const errorFin = document.getElementById('errorFechaFinEdit');
    
    let esValido = true;
    
    // Validar fecha de inicio
    if (!fechaInicio.value) {
        errorInicio.textContent = 'Por favor, seleccione una fecha de inicio';
        esValido = false;
    } else {
        errorInicio.textContent = '';
    }
    
    // Validar fecha de fin
    if (!fechaFin.value) {
        errorFin.textContent = 'Por favor, seleccione una fecha de fin';
        esValido = false;
    } else {
        errorFin.textContent = '';
    }
    
    // Validar que la fecha de fin sea posterior a la de inicio
    if (fechaInicio.value && fechaFin.value) {
        const fechaInicioDate = new Date(fechaInicio.value);
        const fechaFinDate = new Date(fechaFin.value);
        
        if (fechaFinDate <= fechaInicioDate) {
            errorFin.textContent = 'La fecha de fin debe ser posterior a la fecha de inicio';
            esValido = false;
        }
    }
    
    return esValido;
}

// Validaciones generales de formulario
function validar_formulario() {
    const validaciones = [
        validar_codigo(),
        validar_tipo(),
        validar_nombre(),
        validar_valor(),
        validar_descripcion(),
        validar_fechas()
    ];
    
    return validaciones.every(valid => valid === true);
}

function validar_formulario_modificado() {
    const validaciones = [
        validar_codigo_modificado(),
        validar_tipo_modificado(),
        validar_nombre_modificado(),
        validar_valor_modificado(),
        validar_descripcion_modificado(),
        validar_fechas_modificado()
    ];
    
    return validaciones.every(valid => valid === true);
}

// Funciones de gestión de promociones
// Estas funciones están definidas en promociones_ajax.js

// Funciones de utilidad
function actualizarPlaceholder() {
    const tipoPromocion = document.getElementById('tipoPromocion');
    const valorPromocion = document.getElementById('valorPromocion');
    
    if (tipoPromocion && valorPromocion) {
        switch(tipoPromocion.value) {
            case 'porcentaje':
                valorPromocion.placeholder = 'Ej: 10';
                valorPromocion.max = '100';
                valorPromocion.step = '0.01';
                valorPromocion.readOnly = false;
                break;
            case 'monto_fijo':
                valorPromocion.placeholder = 'Ej: 50.00';
                valorPromocion.removeAttribute('max');
                valorPromocion.step = '0.01';
                valorPromocion.readOnly = false;
                break;
            case '2x1':
                valorPromocion.value = '2x1';
                valorPromocion.readOnly = true;
                break;
            default:
                valorPromocion.placeholder = '10';
                valorPromocion.readOnly = false;
        }
    }
}

function actualizarPlaceholderEdit() {
    const tipoPromocion = document.getElementById('tipoPromocionEdit');
    const valorPromocion = document.getElementById('valorPromocionEdit');
    
    if (tipoPromocion && valorPromocion) {
        switch(tipoPromocion.value) {
            case 'porcentaje':
                valorPromocion.placeholder = 'Ej: 10';
                valorPromocion.max = '100';
                valorPromocion.step = '0.01';
                valorPromocion.readOnly = false;
                break;
            case 'monto_fijo':
                valorPromocion.placeholder = 'Ej: 50.00';
                valorPromocion.removeAttribute('max');
                valorPromocion.step = '0.01';
                valorPromocion.readOnly = false;
                break;
            case '2x1':
                valorPromocion.value = '2x1';
                valorPromocion.readOnly = true;
                break;
            default:
                valorPromocion.placeholder = '10';
                valorPromocion.readOnly = false;
        }
    }
}

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
    
    // Configurar evento change para el tipo de promoción
    const tipoPromocion = document.getElementById('tipoPromocion');
    if (tipoPromocion) {
        tipoPromocion.addEventListener('change', actualizarPlaceholder);
    }
    
    const tipoPromocionEdit = document.getElementById('tipoPromocionEdit');
    if (tipoPromocionEdit) {
        tipoPromocionEdit.addEventListener('change', actualizarPlaceholderEdit);
    }
});
