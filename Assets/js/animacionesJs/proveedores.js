/**
 * JavaScript para proveedoresView.php
 * Gestión de Proveedores
 */

document.addEventListener('DOMContentLoaded', function() {
    inicializarProveedores();
});

function inicializarProveedores() {
    configurarEventListenersProveedores();
    inicializarDataTable();
    configurarValidacionesProveedores();
    inicializarModalesProveedores();
}

function configurarEventListenersProveedores() {
    // Event listeners para los formularios
    const formProveedor = document.getElementById('formProveedor');
    if (formProveedor) {
        formProveedor.addEventListener('submit', function(e) {
            e.preventDefault();
            if (validar_formulario()) {
                this.submit();
            }
        });
    }
    
    const formProveedorModificar = document.getElementById('formProveedorModificar');
    if (formProveedorModificar) {
        formProveedorModificar.addEventListener('submit', function(e) {
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
                { width: '15%' },
                { width: '20%' },
                { width: '25%' },
                { width: '15%' },
                { width: '15%' },
                { width: '10%' }
            ]
        });
    }
}

function configurarValidacionesProveedores() {
    // Configurar validaciones en tiempo real - formulario de agregar
    const camposValidacion = [
        { id: 'tipo_id', validator: validar_tipo_id },
        { id: 'id_proveedor', validator: validar_id_proveedor },
        { id: 'nombreProveedor', validator: validar_nombre },
        { id: 'tlfProveedor', validator: validar_telefono },
        { id: 'emailProveedor', validator: validar_email },
        { id: 'direccionProveedor', validator: validar_direccion }
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
        { id: 'nombreProveedorEdit', validator: validar_nombre_modificado },
        { id: 'tlfProveedorEdit', validator: validar_telefono_modificado },
        { id: 'emailProveedorEdit', validator: validar_email_modificado },
        { id: 'direccionProveedorEdit', validator: validar_direccion_modificada }
    ];
    
    camposValidacionEdit.forEach(campo => {
        const elemento = document.getElementById(campo.id);
        if (elemento) {
            elemento.addEventListener('input', campo.validator);
            elemento.addEventListener('blur', campo.validator);
        }
    });
}

function inicializarModalesProveedores() {
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
function validar_tipo_id() {
    const tipoId = document.getElementById('tipo_id');
    const error = document.getElementById('errorIdProveedor');
    
    if (!tipoId.value) {
        error.textContent = 'Por favor, seleccione un tipo de identificación';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_id_proveedor() {
    const tipoId = document.getElementById('tipo_id');
    const idProveedor = document.getElementById('id_proveedor');
    const error = document.getElementById('errorIdProveedor');
    
    if (!idProveedor.value || idProveedor.value.trim().length < 1) {
        error.textContent = 'Por favor, ingrese el número de RIF';
        return false;
    }
    
    // Validar formato según el tipo
    const rifValue = idProveedor.value.replace(/[^0-9]/g, '');
    
    if (tipoId.value === 'J-' || tipoId.value === 'G-') {
        // Para Jurídicos o Gubernamentales: 8-9 dígitos
        if (rifValue.length < 8 || rifValue.length > 9) {
            error.textContent = 'El RIF debe tener 8-9 dígitos';
            return false;
        }
    } else if (tipoId.value === 'C-') {
        // Para Personas Naturales: 7-8 dígitos
        if (rifValue.length < 7 || rifValue.length > 8) {
            error.textContent = 'La Cédula debe tener 7-8 dígitos';
            return false;
        }
    }
    
    error.textContent = '';
    return true;
}

function validar_nombre() {
    const nombre = document.getElementById('nombreProveedor');
    const error = document.getElementById('errornombreProveedor');
    
    if (!nombre.value || nombre.value.trim().length < 3) {
        error.textContent = 'El nombre debe tener al menos 3 caracteres';
        return false;
    }
    
    if (!/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ.,&-]+$/.test(nombre.value)) {
        error.textContent = 'El nombre contiene caracteres inválidos';
        return false;
    }
    
    if (nombre.value.trim().length > 100) {
        error.textContent = 'El nombre no puede superar los 100 caracteres';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_telefono() {
    const telefono = document.getElementById('tlfProveedor');
    const error = document.getElementById('errorTlfProveedor');
    
    if (!telefono.value || telefono.value.trim().length < 1) {
        error.textContent = 'Por favor, ingrese un teléfono';
        return false;
    }
    
    // Validar formato de teléfono venezolano
    const telefonoLimpio = telefono.value.replace(/[^0-9+()-\s]/g, '');
    
    if (!/^(\+58)?\s?(\d{4}[-\s]?\d{7}|\d{3}[-\s]?\d{7}|\d{11})$/.test(telefonoLimpio)) {
        error.textContent = 'Formato de teléfono inválido. Ej: 0414-1234567';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_email() {
    const email = document.getElementById('emailProveedor');
    const error = document.getElementById('errorEmailProveedor');
    
    if (!email.value || email.value.trim().length < 1) {
        error.textContent = 'Por favor, ingrese un email';
        return false;
    }
    
    // Validar formato de email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email.value.toLowerCase())) {
        error.textContent = 'Formato de email inválido';
        return false;
    }
    
    if (email.value.length > 100) {
        error.textContent = 'El email no puede superar los 100 caracteres';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_direccion() {
    const direccion = document.getElementById('direccionProveedor');
    const error = document.getElementById('errorDireccionProveedor');
    
    if (!direccion.value || direccion.value.trim().length < 10) {
        error.textContent = 'La dirección debe tener al menos 10 caracteres';
        return false;
    }
    
    if (direccion.value.trim().length > 200) {
        error.textContent = 'La dirección no puede superar los 200 caracteres';
        return false;
    }
    
    error.textContent = '';
    return true;
}

// Funciones de validación - Formulario Modificar
function validar_nombre_modificado() {
    const nombre = document.getElementById('nombreProveedorEdit');
    const error = document.getElementById('errorProveedorEdit');
    
    if (!nombre.value || nombre.value.trim().length < 3) {
        error.textContent = 'El nombre debe tener al menos 3 caracteres';
        return false;
    }
    
    if (!/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ.,&-]+$/.test(nombre.value)) {
        error.textContent = 'El nombre contiene caracteres inválidos';
        return false;
    }
    
    if (nombre.value.trim().length > 100) {
        error.textContent = 'El nombre no puede superar los 100 caracteres';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_telefono_modificado() {
    const telefono = document.getElementById('tlfProveedorEdit');
    const error = document.getElementById('errorTlfProveedorEdit');
    
    if (!telefono.value || telefono.value.trim().length < 1) {
        error.textContent = 'Por favor, ingrese un teléfono';
        return false;
    }
    
    // Validar formato de teléfono venezolano
    const telefonoLimpio = telefono.value.replace(/[^0-9+()-\s]/g, '');
    
    if (!/^(\+58)?\s?(\d{4}[-\s]?\d{7}|\d{3}[-\s]?\d{7}|\d{11})$/.test(telefonoLimpio)) {
        error.textContent = 'Formato de teléfono inválido. Ej: 0414-1234567';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_email_modificado() {
    const email = document.getElementById('emailProveedorEdit');
    const error = document.getElementById('errorEmailProveedorEdit');
    
    if (!email.value || email.value.trim().length < 1) {
        error.textContent = 'Por favor, ingrese un email';
        return false;
    }
    
    // Validar formato de email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email.value.toLowerCase())) {
        error.textContent = 'Formato de email inválido';
        return false;
    }
    
    if (email.value.length > 100) {
        error.textContent = 'El email no puede superar los 100 caracteres';
        return false;
    }
    
    error.textContent = '';
    return true;
}

function validar_direccion_modificada() {
    const direccion = document.getElementById('direccionProveedorEdit');
    const error = document.getElementById('errorDireccionProveedorEdit');
    
    if (!direccion.value || direccion.value.trim().length < 10) {
        error.textContent = 'La dirección debe tener al menos 10 caracteres';
        return false;
    }
    
    if (direccion.value.trim().length > 200) {
        error.textContent = 'La dirección no puede superar los 200 caracteres';
        return false;
    }
    
    error.textContent = '';
    return true;
}

// Validaciones generales de formulario
function validar_formulario() {
    const validaciones = [
        validar_tipo_id(),
        validar_id_proveedor(),
        validar_nombre(),
        validar_telefono(),
        validar_email(),
        validar_direccion()
    ];
    
    return validaciones.every(valid => valid === true);
}

function validar_formulario_modificado() {
    const validaciones = [
        validar_nombre_modificado(),
        validar_telefono_modificado(),
        validar_email_modificado(),
        validar_direccion_modificada()
    ];
    
    return validaciones.every(valid => valid === true);
}

// Funciones de gestión de proveedores
function ObtenerProveedor(idProveedor) {
    // Cargar datos del proveedor para edición
    console.log('Obteniendo proveedor para edición:', idProveedor);
    
    fetch(`index.php?url=proveedores&action=obtener&id=${idProveedor}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cargarDatosProveedorEnModal(data.proveedor);
            } else {
                mostrarMensaje('Error al cargar los datos del proveedor', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarMensaje('Error al cargar los datos del proveedor', 'error');
        });
}

function cargarDatosProveedorEnModal(proveedor) {
    // Cargar los datos en el modal de modificación
    const rifCompleto = proveedor.tipo_id + proveedor.id_proveedor;
    
    // Separar tipo y número
    let tipoId = '';
    let numeroRif = '';
    
    if (rifCompleto.startsWith('J-')) {
        tipoId = 'J-';
        numeroRif = rifCompleto.substring(2);
    } else if (rifCompleto.startsWith('G-')) {
        tipoId = 'G-';
        numeroRif = rifCompleto.substring(2);
    } else if (rifCompleto.startsWith('C-')) {
        tipoId = 'C-';
        numeroRif = rifCompleto.substring(2);
    }
    
    document.getElementById('tipo_idEdit').value = tipoId;
    document.getElementById('id_proveedorEdit').value = numeroRif;
    document.getElementById('nombreProveedorEdit').value = proveedor.nombre_proveedor;
    document.getElementById('tlfProveedorEdit').value = proveedor.tlf_proveedor;
    document.getElementById('emailProveedorEdit').value = proveedor.email_proveedor;
    document.getElementById('direccionProveedorEdit').value = proveedor.direccion_proveedor;
}

function EliminarProveedor(event, idProveedor) {
    event.preventDefault();
    
    if (!confirm('¿Está seguro de eliminar este proveedor? Esta acción no se puede deshacer.')) {
        return false;
    }
    
    console.log('Eliminando proveedor:', idProveedor);
    
    fetch(`index.php?url=proveedores&action=eliminar&id=${idProveedor}`, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarMensaje('Proveedor eliminado exitosamente', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            mostrarMensaje('Error al eliminar el proveedor', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensaje('Error al eliminar el proveedor', 'error');
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

function formatearTelefono(input) {
    // Formatear teléfono automáticamente mientras se escribe
    let valor = input.value.replace(/[^0-9]/g, '');
    
    if (valor.length > 0) {
        if (valor.length <= 3) {
            valor = valor;
        } else if (valor.length <= 7) {
            valor = valor.slice(0, 4) + '-' + valor.slice(4);
        } else {
            valor = valor.slice(0, 4) + '-' + valor.slice(4, 11);
        }
    }
    
    input.value = valor;
}

function formatearRIF(input) {
    // Formatear RIF automáticamente mientras se escribe
    let valor = input.value.replace(/[^0-9]/g, '');
    input.value = valor;
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
    
    // Configurar formateo automático para teléfono y RIF
    const telefonoInput = document.getElementById('tlfProveedor');
    if (telefonoInput) {
        telefonoInput.addEventListener('input', function() {
            formatearTelefono(this);
            validar_telefono();
        });
    }
    
    const telefonoEditInput = document.getElementById('tlfProveedorEdit');
    if (telefonoEditInput) {
        telefonoEditInput.addEventListener('input', function() {
            formatearTelefono(this);
            validar_telefono_modificado();
        });
    }
    
    const rifInput = document.getElementById('id_proveedor');
    if (rifInput) {
        rifInput.addEventListener('input', function() {
            formatearRIF(this);
            validar_id_proveedor();
        });
    }
    
    const rifEditInput = document.getElementById('id_proveedorEdit');
    if (rifEditInput) {
        rifEditInput.addEventListener('input', function() {
            formatearRIF(this);
        });
    }
});
