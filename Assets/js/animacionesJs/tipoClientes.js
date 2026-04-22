/**
 * JavaScript para tipoClientesView.php
 * Gestión de Tipos de Clientes
 */

document.addEventListener('DOMContentLoaded', function() {
    inicializarTipoClientes();
});

function inicializarTipoClientes() {
    configurarEventListenersTipoClientes();
    inicializarDataTable();
    configurarValidacionesTipoClientes();
    inicializarModalesTipoClientes();
}

function configurarEventListenersTipoClientes() {
    // Event listeners para los formularios
    const formTipoCliente = document.getElementById('formTipoCliente');
    if (formTipoCliente) {
        formTipoCliente.addEventListener('submit', function(e) {
            e.preventDefault();
            if (validar_formulario()) {
                this.submit();
            }
        });
    }
    
    const formTipoClienteModificar = document.getElementById('formTipoClienteModificar');
    if (formTipoClienteModificar) {
        formTipoClienteModificar.addEventListener('submit', function(e) {
            e.preventDefault();
            if (validar_formulario_modificado()) {
                this.submit();
            }
        });
    }
    
    // Event listeners para los botones de acción
    const botonesVer = document.querySelectorAll('[onclick^="VerDetalleTipoCliente"]');
    botonesVer.forEach(boton => {
        boton.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('onclick').match(/\d+/)[0];
            VerDetalleTipoCliente(parseInt(id));
        });
    });
    
    const botonesEditar = document.querySelectorAll('[onclick^="ObtenerTipoCliente"]');
    botonesEditar.forEach(boton => {
        boton.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('onclick').match(/\d+/)[0];
            ObtenerTipoCliente(parseInt(id));
        });
    });
    
    const botonesEliminar = document.querySelectorAll('[onclick^="EliminarTipoCliente"]');
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('onclick').match(/\d+/)[0];
            return EliminarTipoCliente(e, parseInt(id));
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
                { width: '15%' },
                { width: '45%' },
                { width: '20%' },
                { width: '20%' }
            ]
        });
    }
}

function configurarValidacionesTipoClientes() {
    // Configurar validaciones en tiempo real - formulario de agregar
    const camposValidacion = [
        { id: 'nombreTipoCliente', validator: validar_nombre },
        { id: 'diaCreditos', validator: validar_diaCreditos }
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
        { id: 'nombreTipoClienteEdit', validator: validar_nombre_modificado },
        { id: 'diaCreditosEdit', validator: validar_diaCreditos_modificado }
    ];
    
    camposValidacionEdit.forEach(campo => {
        const elemento = document.getElementById(campo.id);
        if (elemento) {
            elemento.addEventListener('input', campo.validator);
            elemento.addEventListener('blur', campo.validator);
        }
    });
}

function inicializarModalesTipoClientes() {
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
    const nombre = document.getElementById('nombreTipoCliente');
    const error = document.getElementById('errorTipoCliente');
    
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

function validar_diaCreditos() {
    const dias = document.getElementById('diaCreditos');
    const error = document.getElementById('errorDiaCreditos');
    
    if (!dias.value || dias.value.trim().length < 1) {
        error.textContent = 'Por favor, ingrese los días de crédito';
        return false;
    }
    
    const diasNumero = parseInt(dias.value);
    
    if (isNaN(diasNumero) || diasNumero < 0) {
        error.textContent = 'Los días deben ser un número positivo';
        return false;
    }
    
    if (diasNumero > 365) {
        error.textContent = 'Los días no pueden superar 365';
        return false;
    }
    
    error.textContent = '';
    return true;
}

// Funciones de validación - Formulario Modificar
function validar_nombre_modificado() {
    const nombre = document.getElementById('nombreTipoClienteEdit');
    const error = document.getElementById('errorTipoClienteEdit');
    
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

function validar_diaCreditos_modificado() {
    const dias = document.getElementById('diaCreditosEdit');
    const error = document.getElementById('errorDiaCreditosEdit');
    
    if (!dias.value || dias.value.trim().length < 1) {
        error.textContent = 'Por favor, ingrese los días de crédito';
        return false;
    }
    
    const diasNumero = parseInt(dias.value);
    
    if (isNaN(diasNumero) || diasNumero < 0) {
        error.textContent = 'Los días deben ser un número positivo';
        return false;
    }
    
    if (diasNumero > 365) {
        error.textContent = 'Los días no pueden superar 365';
        return false;
    }
    
    error.textContent = '';
    return true;
}

// Validaciones generales de formulario
function validar_formulario() {
    const validaciones = [
        validar_nombre(),
        validar_diaCreditos()
    ];
    
    return validaciones.every(valid => valid === true);
}

function validar_formulario_modificado() {
    const validaciones = [
        validar_nombre_modificado(),
        validar_diaCreditos_modificado()
    ];
    
    return validaciones.every(valid => valid === true);
}

// Funciones de gestión de tipos de clientes
function VerDetalleTipoCliente(id) {
    // Obtener datos de la fila correspondiente
    const fila = document.querySelector(`tr[data-id='${id}']`);
    if (!fila) {
        mostrarMensaje('error', 'Error', 'No se encontró el registro del tipo de cliente');
        return;
    }
    
    // Extraer datos de la fila
    const nombreTipo = fila.querySelector('td:nth-child(2)').textContent.trim();
    const idTipo = fila.querySelector('td:nth-child(1) .badge').textContent.trim();
    const diasCredito = fila.querySelector('td:nth-child(3) .badge').textContent.replace(' días', '').trim();
    
    // Actualizar el modal de detalle
    document.getElementById('detalleNombreTipo').textContent = nombreTipo;
    document.getElementById('detalleIdTipo').textContent = idTipo;
    document.getElementById('detalleDiasCredito').textContent = diasCredito;
    document.getElementById('infoDiasCredito').textContent = diasCredito + ' días';
    
    // Simular número de clientes asignados (esto debería venir del backend)
    const clientesAsignados = Math.floor(Math.random() * 50) + 5;
    document.getElementById('detalleClientesAsignados').textContent = clientesAsignados;
    
    // Actualizar características según los días de crédito
    actualizarCaracteristicasPorDias(parseInt(diasCredito));
}

function actualizarCaracteristicasPorDias(dias) {
    const caracteristicas = document.querySelectorAll('.col-md-6.mb-2 span.text-muted');
    
    // Actualizar características según el rango de días
    if (dias === 0) {
        caracteristicas[0].textContent = 'Solo compras de contado';
        caracteristicas[1].textContent = 'Facturación inmediata';
        caracteristicas[2].textContent = 'Sin reportes de crédito';
        caracteristicas[3].textContent = 'Sin notificaciones de vencimiento';
    } else if (dias <= 15) {
        caracteristicas[0].textContent = 'Compras a crédito limitadas';
        caracteristicas[1].textContent = 'Facturación corta plazo';
        caracteristicas[2].textContent = 'Reportes básicos de crédito';
        caracteristicas[3].textContent = 'Notificaciones semanales';
    } else if (dias <= 30) {
        caracteristicas[0].textContent = 'Compras a crédito disponibles';
        caracteristicas[1].textContent = 'Facturación diferida';
        caracteristicas[2].textContent = 'Reportes de crédito';
        caracteristicas[3].textContent = 'Notificaciones de vencimiento';
    } else {
        caracteristicas[0].textContent = 'Compras a crédito extendidas';
        caracteristicas[1].textContent = 'Facturación mensual';
        caracteristicas[2].textContent = 'Reportes detallados de crédito';
        caracteristicas[3].textContent = 'Notificaciones personalizadas';
    }
}

function ObtenerTipoCliente(idTipoCliente) {
    // Cargar datos del tipo de cliente para edición
    console.log('Obteniendo tipo de cliente para edición:', idTipoCliente);
    
    fetch(`index.php?url=tipos_clientes&action=obtener&id=${idTipoCliente}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cargarDatosTipoClienteEnModal(data.tipoCliente);
            } else {
                mostrarMensaje('error', 'Error', 'Error al cargar los datos del tipo de cliente');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarMensaje('error', 'Error', 'Error al cargar los datos del tipo de cliente');
        });
}

function cargarDatosTipoClienteEnModal(tipoCliente) {
    // Cargar los datos en el modal de modificación
    document.getElementById('id').value = tipoCliente.id_tipo_cliente;
    document.getElementById('nombreTipoClienteEdit').value = tipoCliente.nombre_tipo_cliente;
    document.getElementById('diaCreditosEdit').value = tipoCliente.dias_credito;
}

function EliminarTipoCliente(event, idTipoCliente) {
    event.preventDefault();
    
    if (!confirm('¿Está seguro de eliminar este tipo de cliente? Esta acción podría afectar a los clientes asociados.')) {
        return false;
    }
    
    console.log('Eliminando tipo de cliente:', idTipoCliente);
    
    fetch(`index.php?url=tipos_clientes&action=eliminar&id=${idTipoCliente}`, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarMensaje('success', 'Éxito', 'Tipo de cliente eliminado exitosamente');
            setTimeout(() => location.reload(), 1500);
        } else {
            mostrarMensaje('error', 'Error', data.message || 'Error al eliminar el tipo de cliente');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensaje('error', 'Error', 'Error al eliminar el tipo de cliente');
    });
    
    return false;
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

function formatearInputNumerico(input) {
    // Formatear input para solo permitir números
    let valor = input.value.replace(/[^0-9]/g, '');
    
    // Limitar a 3 dígitos para días de crédito
    if (valor.length > 3) {
        valor = valor.substring(0, 3);
    }
    
    input.value = valor;
}

// Funciones de búsqueda y filtrado
function buscarTipoCliente(termino) {
    const filas = document.querySelectorAll('#add-row tbody tr');
    let coincidencias = 0;
    
    filas.forEach(fila => {
        const textoFila = fila.textContent.toLowerCase();
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
        mensaje.innerHTML = '<td colspan="4" class="text-center py-4">No se encontraron registros que coincidan con la búsqueda</td>';
        document.querySelector('#add-row tbody').appendChild(mensaje);
    } else if (coincidencias > 0 && noRegistros) {
        noRegistros.remove();
    }
}

// Funciones de exportación
function exportarTiposClientes(formato = 'pdf') {
    // Función para exportar tipos de clientes
    const url = `index.php?url=tipos_clientes&action=exportar&formato=${formato}`;
    window.open(url, '_blank');
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
            if (formActivo && (formActivo.id === 'formTipoCliente' || formActivo.id === 'formTipoClienteModificar')) {
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
    
    // Configurar formateo automático para campos numéricos
    const diaCreditos = document.getElementById('diaCreditos');
    if (diaCreditos) {
        diaCreditos.addEventListener('input', function() {
            formatearInputNumerico(this);
            validar_diaCreditos();
        });
    }
    
    const diaCreditosEdit = document.getElementById('diaCreditosEdit');
    if (diaCreditosEdit) {
        diaCreditosEdit.addEventListener('input', function() {
            formatearInputNumerico(this);
            validar_diaCreditos_modificado();
        });
    }
    
    // Configurar búsqueda si existe campo de búsqueda
    const busquedaInput = document.getElementById('busquedaTipoCliente');
    if (busquedaInput) {
        busquedaInput.addEventListener('input', function() {
            buscarTipoCliente(this.value);
        });
    }
});

// Función para inicialización cuando se carga dinámicamente
function reinicializarTipoClientes() {
    inicializarTipoClientes();
}

// Exportar funciones para uso global
window.tipoClientesFunctions = {
    VerDetalleTipoCliente,
    ObtenerTipoCliente,
    EliminarTipoCliente,
    exportarTiposClientes,
    reinicializarTipoClientes
};
