// Theme Critical Script - Evita flash de modo claro al cargar
// Este script DEBE cargarse en el <head> antes que cualquier CSS

(function() {
    'use strict';
    
    const THEME_KEY = 'natys_theme_mode';
    
    // Función para obtener el tema guardado o preferencia del sistema
    function getInitialTheme() {
        try {
            const saved = localStorage.getItem(THEME_KEY);
            if (saved === 'dark') return 'dark';
            if (saved === 'light') return 'light';
            // Si no hay preferencia, usar preferencia del sistema
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        } catch (e) {
            // Fallback si localStorage no está disponible
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }
    }
    
    // Aplicar tema INMEDIATAMENTE antes de cualquier renderizado
    const theme = getInitialTheme();
    
    // 1. Aplicar al HTML element (más importante y rápido)
    document.documentElement.setAttribute('data-theme', theme);
    
    if (theme === 'dark') {
        document.documentElement.classList.add('dark-mode');
    } else {
        document.documentElement.classList.remove('dark-mode');
    }
    
    // 2. Crear y aplicar estilos CSS críticos inmediatamente
    const criticalStyles = document.createElement('style');
    criticalStyles.id = 'theme-critical-styles';
    criticalStyles.textContent = `
        /* Prevenir parpadeo - Estilos críticos aplicados inmediatamente */
        html[data-theme="dark"] {
            background-color: #1a1b2b !important;
            color: #e7e9f0 !important;
        }
        
        html[data-theme="dark"] body {
            background-color: #1a1b2b !important;
            color: #e7e9f0 !important;
        }
        
        html[data-theme="dark"] .container,
        html[data-theme="dark"] .page-inner {
            background-color: #1a1b2b !important;
        }
        
        html[data-theme="dark"] .card {
            background-color: #1a1f2e !important;
        }
        
        /* Ocultar contenido brevemente para evitar flash */
        body:not(.theme-ready) {
            opacity: 0;
            transition: opacity 0.1s ease-in;
        }
        
        body.theme-ready {
            opacity: 1;
        }
    `;
    
    // 3. Insertar estilos antes que cualquier otro CSS
    if (document.head) {
        document.head.insertBefore(criticalStyles, document.head.firstChild);
    } else {
        // Fallback si head no existe aún
        document.addEventListener('DOMContentLoaded', function() {
            document.head.insertBefore(criticalStyles, document.head.firstChild);
        });
    }
    
    // 4. Aplicar clases al body cuando esté disponible
    function applyBodyTheme() {
        if (document.body) {
            if (theme === 'dark') {
                document.body.classList.add('dark-mode');
            } else {
                document.body.classList.remove('dark-mode');
            }
            // Marcar como listo para mostrar el contenido
            setTimeout(() => {
                document.body.classList.add('theme-ready');
            }, 50);
        }
    }
    
    if (document.body) {
        applyBodyTheme();
    } else {
        document.addEventListener('DOMContentLoaded', applyBodyTheme);
    }
    
    // 5. Exponer el tema inicial para que otros scripts puedan usarlo
    window.__INITIAL_THEME = theme;
    
    // 6. Prevenir cambios de tema hasta que todo esté cargado
    window.__THEME_LOCKED = true;
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            window.__THEME_LOCKED = false;
        }, 100);
    });
    
    console.log('🌓 Theme Critical: Tema inicial aplicado -', theme);
})();
