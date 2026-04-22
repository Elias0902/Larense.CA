/**
 * JavaScript para seguridadView.php
 * Gestión de Seguridad y 2FA
 */

document.addEventListener('DOMContentLoaded', function() {
    inicializarSeguridad();
});

function inicializarSeguridad() {
    configurarEventListenersSeguridad();
    inicializarModales();
    configurarValidacionesSeguridad();
    verificarEstadoSeguridad();
}

function configurarEventListenersSeguridad() {
    // Event listener para el formulario SMS
    const formSMS = document.getElementById('formSMS');
    if (formSMS) {
        formSMS.addEventListener('submit', function(e) {
            e.preventDefault();
            procesarFormularioSMS();
        });
    }
    
    // Event listener para solo números en el teléfono
    const telefonoInput = document.getElementById('telefono');
    if (telefonoInput) {
        telefonoInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }
    
    // Event listeners para los métodos de verificación
    const methodOptions = document.querySelectorAll('.method-option');
    methodOptions.forEach(option => {
        option.addEventListener('click', function() {
            const metodo = this.getAttribute('onclick').match(/'([^']+)'/)[1];
            seleccionarMetodo(metodo);
        });
    });
}

function inicializarModales() {
    // Inicializar modales de Bootstrap
    const modalConfigurar = document.getElementById('modalConfigurar');
    const modalSMS = document.getElementById('modalSMS');
    
    if (modalConfigurar) {
        new bootstrap.Modal(modalConfigurar);
    }
    
    if (modalSMS) {
        new bootstrap.Modal(modalSMS);
    }
}

function configurarValidacionesSeguridad() {
    // Configurar validaciones en tiempo real
    const telefonoInput = document.getElementById('telefono');
    if (telefonoInput) {
        telefonoInput.addEventListener('blur', function() {
            validarTelefono();
        });
        
        telefonoInput.addEventListener('input', function() {
            limpiarErrorTelefono();
        });
    }
}

function verificarEstadoSeguridad() {
    // Verificar estado actual de seguridad
    const elementosSeguridad = document.querySelectorAll('.security-item-status');
    elementosSeguridad.forEach(elemento => {
        const estado = elemento.textContent.trim();
        actualizarIndicadorSeguridad(elemento, estado);
    });
    
    // Actualizar nivel de seguridad general
    actualizarNivelSeguridad();
}

function actualizarIndicadorSeguridad(elemento, estado) {
    // Actualizar indicadores visuales según el estado
    elemento.classList.remove('status-verified', 'status-pending', 'status-pending-secondary');
    
    switch(estado.toUpperCase()) {
        case 'VERIFIED':
            elemento.classList.add('status-verified');
            break;
        case 'PENDING':
            elemento.classList.add('status-pending');
            break;
        default:
            elemento.classList.add('status-pending-secondary');
    }
}

function actualizarNivelSeguridad() {
    // Calcular nivel de seguridad general
    const elementosVerificados = document.querySelectorAll('.status-verified').length;
    const totalElementos = document.querySelectorAll('.security-item-status').length;
    
    const nivel = (elementosVerificados / totalElementos) * 100;
    
    // Actualizar alerta de seguridad según el nivel
    const alerta = document.querySelector('.security-alert');
    if (alerta) {
        if (nivel >= 80) {
            alerta.style.display = 'none';
        } else if (nivel >= 50) {
            alerta.querySelector('h4').textContent = 'Seguridad Recomendada';
            alerta.querySelector('p').textContent = 'Tu cuenta tiene un nivel de seguridad medio. Te recomendamos completar la verificación telefónica para habilitar retiros y cambios sensibles.';
        } else {
            alerta.querySelector('h4').textContent = 'Seguridad Baja';
            alerta.querySelector('p').textContent = 'Tu cuenta tiene un nivel de seguridad bajo. Te recomendamos habilitar todos los métodos de verificación disponibles.';
        }
    }
}

// Funciones de modales
function abrirModalConfigurar() {
    const modal = new bootstrap.Modal(document.getElementById('modalConfigurar'));
    modal.show();
}

function seleccionarMetodo(metodo) {
    // Cerrar modal actual
    const modalConfigurar = bootstrap.Modal.getInstance(document.getElementById('modalConfigurar'));
    if (modalConfigurar) {
        modalConfigurar.hide();
    }
    
    // Abrir modal correspondiente al método seleccionado
    switch(metodo) {
        case 'sms':
            setTimeout(() => {
                abrirModalSMS();
            }, 300);
            break;
        case 'app':
            mostrarProximamente();
            break;
        case 'email':
            mostrarProximamente();
            break;
    }
}

function abrirModalSMS() {
    const modalSMS = new bootstrap.Modal(document.getElementById('modalSMS'));
    modalSMS.show();
}

function mostrarProximamente() {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'info',
            title: 'Próximamente',
            text: 'Esta función estará disponible pronto.',
            timer: 2000,
            showConfirmButton: false
        });
    } else {
        alert('Esta función estará disponible pronto.');
    }
}

// Funciones de validación
function validarTelefono() {
    const telefonoInput = document.getElementById('telefono');
    const telefono = telefonoInput.value;
    
    // Validar longitud
    if (telefono.length !== 10) {
        mostrarErrorTelefono('Ingresa un número de 10 dígitos');
        return false;
    }
    
    // Validar que comience con código de operadora venezolana
    const codigosValidos = ['412', '414', '416', '424', '426'];
    const codigo = telefono.substring(0, 3);
    
    if (!codigosValidos.includes(codigo)) {
        mostrarErrorTelefono('Código de operadora inválido. Usa: 412, 414, 416, 424 o 426');
        return false;
    }
    
    limpiarErrorTelefono();
    return true;
}

function mostrarErrorTelefono(mensaje) {
    const telefonoInput = document.getElementById('telefono');
    telefonoInput.classList.add('is-invalid');
    
    // Eliminar mensaje anterior si existe
    limpiarErrorTelefono();
    
    // Crear y mostrar nuevo mensaje
    const errorDiv = document.createElement('div');
    errorDiv.className = 'invalid-feedback';
    errorDiv.textContent = mensaje;
    errorDiv.style.display = 'block';
    
    telefonoInput.parentNode.appendChild(errorDiv);
}

function limpiarErrorTelefono() {
    const telefonoInput = document.getElementById('telefono');
    telefonoInput.classList.remove('is-invalid');
    
    const errorDiv = telefonoInput.parentNode.querySelector('.invalid-feedback');
    if (errorDiv) {
        errorDiv.remove();
    }
}

// Funciones de procesamiento
function procesarFormularioSMS() {
    const telefonoInput = document.getElementById('telefono');
    const telefono = telefonoInput.value;
    
    // Validar teléfono
    if (!validarTelefono()) {
        return;
    }
    
    // Simular envío de código
    enviarCodigoSMS(telefono);
}

function enviarCodigoSMS(telefono) {
    // Mostrar loading
    mostrarLoading(true);
    
    // Simular petición AJAX
    setTimeout(() => {
        mostrarLoading(false);
        
        // Mostrar mensaje de éxito
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Código Enviado',
                text: `Se ha enviado un código de verificación al +58 ${telefono}`,
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            alert(`Se ha enviado un código de verificación al +58 ${telefono}`);
        }
        
        // Cerrar modal y limpiar formulario
        const modalSMS = bootstrap.Modal.getInstance(document.getElementById('modalSMS'));
        if (modalSMS) {
            modalSMS.hide();
        }
        
        document.getElementById('formSMS').reset();
        limpiarErrorTelefono();
        
        // Actualizar estado de verificación
        actualizarEstadoVerificacion('telefono', true);
        
    }, 1500);
}

function actualizarEstadoVerificacion(tipo, verificado) {
    // Actualizar el estado de verificación en la UI
    const elementos = document.querySelectorAll('.security-item');
    
    elementos.forEach(elemento => {
        const titulo = elemento.querySelector('h4');
        if (titulo && titulo.textContent.toLowerCase().includes(tipo)) {
            const estadoElemento = elemento.querySelector('.security-item-status');
            if (estadoElemento) {
                if (verificado) {
                    estadoElemento.className = 'security-item-status status-verified';
                    estadoElemento.innerHTML = '<i class="fas fa-check-circle"></i> VERIFIED';
                } else {
                    estadoElemento.className = 'security-item-status status-pending';
                    estadoElemento.innerHTML = '<i class="fas fa-clock"></i> PENDING';
                }
            }
        }
    });
    
    // Actualizar nivel de seguridad general
    actualizarNivelSeguridad();
}

// Funciones de utilidad
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

function mostrarMensaje(tipo, titulo, mensaje) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: tipo,
            title: titulo,
            text: mensaje,
            confirmButtonColor: '#cc1d1d'
        });
    } else {
        alert(`${titulo}: ${mensaje}`);
    }
}

function formatearTelefono(input) {
    // Formatear teléfono automáticamente mientras se escribe
    let valor = input.value.replace(/[^0-9]/g, '');
    
    // Limitar a 10 dígitos
    if (valor.length > 10) {
        valor = valor.substring(0, 10);
    }
    
    input.value = valor;
}

// Funciones de seguridad adicionales
function verificarContrasena() {
    // Verificar fortaleza de contraseña
    const contrasena = prompt('Ingresa tu contraseña actual para verificar tu identidad:');
    
    if (contrasena) {
        // Aquí se verificaría la contraseña con el backend
        console.log('Verificando contraseña...');
    }
}

function cambiarContrasena() {
    // Función para cambiar contraseña
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Cambiar Contraseña',
            html: `
                <input type="password" id="swal-actual" class="swal2-input" placeholder="Contraseña actual">
                <input type="password" id="swal-nueva" class="swal2-input" placeholder="Nueva contraseña">
                <input type="password" id="swal-confirmar" class="swal2-input" placeholder="Confirmar nueva contraseña">
            `,
            confirmButtonText: 'Cambiar',
            showCancelButton: true,
            confirmButtonColor: '#cc1d1d',
            preConfirm: () => {
                const actual = document.getElementById('swal-actual').value;
                const nueva = document.getElementById('swal-nueva').value;
                const confirmar = document.getElementById('swal-confirmar').value;
                
                if (!actual || !nueva || !confirmar) {
                    Swal.showValidationMessage('Todos los campos son obligatorios');
                    return false;
                }
                
                if (nueva !== confirmar) {
                    Swal.showValidationMessage('Las contraseñas no coinciden');
                    return false;
                }
                
                if (nueva.length < 8) {
                    Swal.showValidationMessage('La contraseña debe tener al menos 8 caracteres');
                    return false;
                }
                
                return { actual, nueva };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Aquí se enviaría la solicitud al backend
                console.log('Cambiando contraseña...');
                mostrarMensaje('success', 'Éxito', 'Contraseña cambiada correctamente');
            }
        });
    }
}

function activar2FA() {
    // Activar autenticación de dos factores
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Activar 2FA',
            text: '¿Estás seguro de activar la autenticación de dos factores?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, activar'
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('Activando 2FA...');
                mostrarMensaje('success', 'Éxito', '2FA activado correctamente');
            }
        });
    }
}

// Event listeners globales
document.addEventListener('DOMContentLoaded', function() {
    // Configurar eventos de teclado
    document.addEventListener('keydown', function(e) {
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
    
    // Configurar eventos de clic fuera de modales
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal')) {
            const instance = bootstrap.Modal.getInstance(e.target);
            if (instance) {
                instance.hide();
            }
        }
    });
});

// Exportar funciones para uso global
window.seguridadFunctions = {
    abrirModalConfigurar,
    seleccionarMetodo,
    verificarContrasena,
    cambiarContrasena,
    activar2FA,
    actualizarEstadoVerificacion
};
