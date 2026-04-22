/**
 * JavaScript para permisosView.php
 * Gestión de Permisos del Sistema
 */

document.addEventListener('DOMContentLoaded', function() {
    inicializarPermisos();
});

function inicializarPermisos() {
    configurarEventListenersPermisos();
    cargarUsuariosIniciales();
    inicializarModales();
}

function configurarEventListenersPermisos() {
    // Event listener para búsqueda de usuarios
    const buscarUsuario = document.getElementById('buscarUsuario');
    if (buscarUsuario) {
        buscarUsuario.addEventListener('keyup', filtrarUsuarios);
    }
    
    // Event listener para selección de rol
    const rolSelect = document.getElementById('rolSelectPermisos');
    if (rolSelect) {
        rolSelect.addEventListener('change', function() {
            ObtenerPermisosRol(this.value);
        });
    }
    
    // Event listeners para formularios
    const formUsuario = document.getElementById('formUsuario');
    if (formUsuario) {
        formUsuario.addEventListener('submit', function(e) {
            e.preventDefault();
            guardarUsuario();
        });
    }
    
    const formRol = document.getElementById('formRol');
    if (formRol) {
        formRol.addEventListener('submit', function(e) {
            e.preventDefault();
            guardarRol();
        });
    }
    
    const formCasoEspecial = document.getElementById('formCasoEspecial');
    if (formCasoEspecial) {
        formCasoEspecial.addEventListener('submit', function(e) {
            e.preventDefault();
            guardarCasoEspecial();
        });
    }
}

function cargarUsuariosIniciales() {
    // Los usuarios ya se cargan via PHP, solo configuramos los eventos
    const userItems = document.querySelectorAll('.user-item');
    userItems.forEach(item => {
        item.addEventListener('click', function() {
            seleccionarUsuario(this.dataset.id);
        });
    });
}

function inicializarModales() {
    // Configurar modales de Bootstrap
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        new bootstrap.Modal(modal);
    });
}

function filtrarUsuarios() {
    const searchTerm = document.getElementById('buscarUsuario').value.toLowerCase();
    const userItems = document.querySelectorAll('.user-item');
    
    userItems.forEach(item => {
        const userName = item.querySelector('.user-name').textContent.toLowerCase();
        const userRole = item.querySelector('.user-role').textContent.toLowerCase();
        
        if (userName.includes(searchTerm) || userRole.includes(searchTerm)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
}

function seleccionarUsuario(idUsuario) {
    // Resaltar usuario seleccionado
    const userItems = document.querySelectorAll('.user-item');
    userItems.forEach(item => {
        item.classList.remove('active');
        if (item.dataset.id == idUsuario) {
            item.classList.add('active');
        }
    });
    
    // Cargar detalles del usuario
    cargarDetallesUsuario(idUsuario);
}

function cargarDetallesUsuario(idUsuario) {
    const detailPanel = document.getElementById('userDetailPanel');
    const template = document.getElementById('userDetailTemplate');
    
    if (detailPanel && template) {
        // Clonar el template y mostrar detalles
        const clone = template.content.cloneNode(true);
        detailPanel.innerHTML = '';
        detailPanel.appendChild(clone);
        
        // Aquí se cargarían los datos reales del usuario desde el backend
        // Por ahora, mostramos datos de ejemplo
        actualizarDetallesUsuario({
            id: idUsuario,
            nombre: 'Usuario Ejemplo',
            rol: 'Administrador',
            email: 'usuario@ejemplo.com',
            ultimoAcceso: '2024-01-01 10:00:00'
        });
        
        // Configurar botones de acción
        configurarBotonesUsuario(idUsuario);
    }
}

function actualizarDetallesUsuario(usuario) {
    // Actualizar los elementos del detalle con los datos del usuario
    const elements = {
        'detailAvatar': usuario.nombre.charAt(0).toUpperCase(),
        'detailName': usuario.nombre,
        'detailRole': usuario.rol,
        'detailId': `USR-00${usuario.id}`,
        'detailEmail': usuario.email,
        'detailLastAccess': usuario.ultimoAcceso
    };
    
    Object.keys(elements).forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            if (id === 'detailAvatar') {
                element.textContent = elements[id];
            } else {
                element.textContent = elements[id];
            }
        }
    });
}

function configurarBotonesUsuario(idUsuario) {
    const btnEditar = document.getElementById('btnEditarUsuario');
    const btnEliminar = document.getElementById('btnEliminarUsuario');
    
    if (btnEditar) {
        btnEditar.addEventListener('click', function() {
            editarUsuario(idUsuario);
        });
    }
    
    if (btnEliminar) {
        btnEliminar.addEventListener('click', function() {
            eliminarUsuario(idUsuario);
        });
    }
}

function editarUsuario(idUsuario) {
    // Cargar datos del usuario en el modal de edición
    console.log('Editando usuario:', idUsuario);
    // Implementar lógica de edición
}

function eliminarUsuario(idUsuario) {
    if (confirm('¿Está seguro de eliminar este usuario?')) {
        console.log('Eliminando usuario:', idUsuario);
        // Implementar lógica de eliminación
    }
}

function guardarUsuario() {
    const form = document.getElementById('formUsuario');
    const formData = new FormData(form);
    
    // Validar formulario
    if (!validarFormularioUsuario(formData)) {
        return;
    }
    
    // Enviar datos al backend
    console.log('Guardando usuario:', Object.fromEntries(formData));
    // Implementar lógica de guardado
}

function guardarRol() {
    const form = document.getElementById('formRol');
    const formData = new FormData(form);
    
    // Validar formulario
    if (!validarFormularioRol(formData)) {
        return;
    }
    
    // Enviar datos al backend
    console.log('Guardando rol:', Object.fromEntries(formData));
    // Implementar lógica de guardado
}

function guardarCasoEspecial() {
    const form = document.getElementById('formCasoEspecial');
    const formData = new FormData(form);
    
    // Validar formulario
    if (!validarFormularioCasoEspecial(formData)) {
        return;
    }
    
    // Enviar datos al backend
    console.log('Guardando caso especial:', Object.fromEntries(formData));
    // Implementar lógica de guardado
}

function validarFormularioUsuario(formData) {
    // Implementar validaciones del formulario de usuario
    const nombre = formData.get('nombre_usuario');
    const email = formData.get('email_usuario');
    const rol = formData.get('id_rol');
    
    if (!nombre || !email || !rol) {
        alert('Por favor, complete todos los campos obligatorios');
        return false;
    }
    
    return true;
}

function validarFormularioRol(formData) {
    // Implementar validaciones del formulario de rol
    const nombre = formData.get('nombre_rol');
    
    if (!nombre) {
        alert('Por favor, ingrese el nombre del rol');
        return false;
    }
    
    return true;
}

function validarFormularioCasoEspecial(formData) {
    // Implementar validaciones del formulario de caso especial
    const usuario = formData.get('casoUsuario');
    const modulo = formData.get('casoModulo');
    const motivo = formData.get('casoMotivo');
    
    if (!usuario || !modulo || !motivo) {
        alert('Por favor, complete todos los campos obligatorios');
        return false;
    }
    
    return true;
}

function simularRol(idRol) {
    // Mostrar alerta de simulación
    const alert = document.getElementById('simulationAlert');
    const roleName = document.getElementById('simulatedRoleName');
    
    if (alert && roleName) {
        const roles = {
            3: 'Vendedor',
            4: 'Usuario'
        };
        
        roleName.textContent = roles[idRol] || 'Usuario';
        alert.classList.add('show');
    }
}

function restaurarRol() {
    // Ocultar alerta de simulación
    const alert = document.getElementById('simulationAlert');
    if (alert) {
        alert.classList.remove('show');
    }
}

function exportarAuditoria() {
    // Implementar exportación de auditoría
    console.log('Exportando auditoría de permisos');
    // Generar y descargar archivo CSV o PDF
}

function eliminarCasoEspecial(idCaso) {
    if (confirm('¿Está seguro de eliminar este caso especial?')) {
        console.log('Eliminando caso especial:', idCaso);
        // Implementar lógica de eliminación
    }
}

// Función placeholder para ObtenerPermisosRol (se implementará en el archivo AJAX)
function ObtenerPermisosRol(idRol) {
    console.log('Obteniendo permisos del rol:', idRol);
    // Esta función se implementará en el archivo AJAX correspondiente
}
