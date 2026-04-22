/**
 * JavaScript para perfilesView.php
 * Gestión de Perfiles, Roles y Permisos
 */

document.addEventListener('DOMContentLoaded', function() {
    // Inicialización de componentes
    inicializarPerfiles();
});

function inicializarPerfiles() {
    // Configuración inicial de la interfaz
    configurarEventListeners();
    cargarRolesIniciales();
}

function configurarEventListeners() {
    // Event listeners para la gestión de usuarios y permisos
    const rolSelect = document.getElementById('rolSelectPermisos');
    if (rolSelect) {
        rolSelect.addEventListener('change', function() {
            ObtenerPermisosRol(this.value);
        });
    }
}

function cargarRolesIniciales() {
    // Cargar roles disponibles en el select
    const rolSelect = document.getElementById('rolSelectPermisos');
    if (rolSelect) {
        // Simular carga de roles (esto debería venir del backend)
        const roles = [
            { id: 1, nombre: 'SUPER ADMIN' },
            { id: 4, nombre: 'Vendedor' },
            { id: 3, nombre: 'Repartidor' },
            { id: 2, nombre: 'Cliente' }
        ];
        
        roles.forEach(rol => {
            const option = document.createElement('option');
            option.value = rol.id;
            option.textContent = rol.nombre;
            rolSelect.appendChild(option);
        });
    }
}

// Funciones de gestión de usuarios
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
    // Implementar carga de detalles desde backend
    console.log('Cargando detalles del usuario:', idUsuario);
}

// Funciones de modales
function abrirModalUsuario() {
    const modal = new bootstrap.Modal(document.getElementById('modalUsuario'));
    modal.show();
}

function abrirModalBibliotecaCasos() {
    const modal = new bootstrap.Modal(document.getElementById('modalBibliotecaCasos'));
    modal.show();
}

// Funciones de simulación
function simularRol(idRol) {
    // Implementar simulación de rol
    console.log('Simulando rol:', idRol);
}

function restaurarRol() {
    // Implementar restauración de rol original
    console.log('Restaurando rol original');
}

// Funciones de exportación
function exportarAuditoria() {
    // Implementar exportación de auditoría
    console.log('Exportando auditoría');
}

// Funciones de gestión de casos especiales
function eliminarCasoEspecial(idCaso) {
    // Implementar eliminación de caso especial
    console.log('Eliminando caso especial:', idCaso);
}

// Función placeholder para ObtenerPermisosRol (se implementará en el archivo AJAX)
function ObtenerPermisosRol(idRol) {
    // Esta función se implementará en el archivo AJAX correspondiente
    console.log('Obteniendo permisos del rol:', idRol);
}
