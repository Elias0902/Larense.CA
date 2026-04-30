// Variable global para almacenar los permisos
let permisosGlobales = [];

function ObtenerAccesos() {
    var id = document.getElementById('s_usuario').value;
    
    fetch('index.php?url=permisos&action=obtener_modulo&ID=' + id)
        .then(response => response.json())
        .then(data => {
            //console.log('Datos recibidos:', data);
            
            // Almacenar permisos globalmente
            permisosGlobales = data.map(function(item) {
                return {
                    id_rol: item.id_rol,
                    id_modulo: item.id_modulo,
                    id_permiso: item.id_permiso,
                    status: item.status,
                    nombre_permiso: item.nombre_permiso,
                    nombre_modulo: item.nombre_modulo
                };
            });
            
            // Aplicar permisos al menú automáticamente
            aplicarPermisosMenu();
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function TieneAcceso(nombreModulo) {
    // Verificar si el usuario tiene permiso de "Consultar" (o el que necesites)
    // en el módulo especificado
    for (let i = 0; i < permisosGlobales.length; i++) {
        let permiso = permisosGlobales[i];
        
        if (permiso.nombre_modulo === nombreModulo && 
            permiso.status === 1 && 
            permiso.id_permiso === 2) { // 2 = Consultar
            return true;
        }
    }
    return false;
}

function aplicarPermisosMenu() {
    //console.log('🎯 Aplicando permisos al menú...');
    
    // 1. Crear mapa de módulos permitidos
    const modulosPermitidos = {};
    permisosGlobales.forEach(permiso => {
        if (permiso.id_permiso === 2 && permiso.status === 1) {
            modulosPermitidos[permiso.nombre_modulo] = true;
        }
    });
    
    //console.log('📋 Módulos permitidos:', Object.keys(modulosPermitidos));

    // Ocultar enlaces de módulos no permitidos
    const todosLosEnlaces = document.querySelectorAll('a[href*="url="]');
    
    todosLosEnlaces.forEach(enlace => {
        const href = enlace.getAttribute('href');
        const urlMatch = href.match(/url=([^&]+)/);
        
        if (urlMatch) {
            const urlModulo = urlMatch[1];
            
            let tienePermiso = false;
            for (let nombreModuloPermitido in modulosPermitidos) {
                const moduloLower = nombreModuloPermitido.toLowerCase();
                const urlLower = urlModulo.toLowerCase();
                
                if (moduloLower.includes(urlLower) || urlLower.includes(moduloLower)) {
                    tienePermiso = true;
                    break;
                }
            }
            
            if (!tienePermiso) {
                const liPadre = enlace.closest('.nav-item');
                if (liPadre) {
                    liPadre.style.display = 'none';
                }
            }
        }
    });

    // Ocultar secciones vacías
    const secciones = document.querySelectorAll('.nav-section');
    
    secciones.forEach(seccion => {
        const hijosVisibles = seccion.querySelectorAll('.nav-item:not([style*="display: none"])');
        
        if (hijosVisibles.length === 0) {
            seccion.style.display = 'none';
            //console.log('🗑️ Ocultando sección vacía:', seccion.querySelector('h4').textContent.trim());
        }
    });

    //console.log('✅ Menú filtrado completo (incluyendo secciones vacías)');
}

// Esperar a que el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    ObtenerAccesos();
});