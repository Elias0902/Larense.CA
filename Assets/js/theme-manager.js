// Theme Manager Global - Sistema unificado de modo oscuro/claro
(function() {
    // Clave para localStorage
    const THEME_KEY = 'natys_theme_mode';
    
    // Función para aplicar el tema a TODO el documento
    function applyTheme(isDark) {
        if (isDark) {
            document.documentElement.setAttribute('data-theme', 'dark');
            document.body.classList.add('dark-mode');
        } else {
            document.documentElement.setAttribute('data-theme', 'light');
            document.body.classList.remove('dark-mode');
        }
        
        // Actualizar todos los botones de tema en la página
        const allThemeToggles = document.querySelectorAll('.theme-toggle-nav, .theme-toggle');
        allThemeToggles.forEach(toggle => {
            if (isDark) {
                toggle.classList.add('dark');
                const icon = toggle.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                }
            } else {
                toggle.classList.remove('dark');
                const icon = toggle.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-sun');
                    icon.classList.add('fa-moon');
                }
            }
        });
        
        // Guardar preferencia en localStorage
        localStorage.setItem(THEME_KEY, isDark ? 'dark' : 'light');
        
        // Disparar evento personalizado
        window.dispatchEvent(new CustomEvent('themeChanged', { detail: { isDark: isDark } }));
    }
    
    // Función para obtener el tema guardado
    function getSavedTheme() {
        const saved = localStorage.getItem(THEME_KEY);
        if (saved === 'dark') return true;
        if (saved === 'light') return false;
        // Si no hay preferencia guardada, usar preferencia del sistema
        return window.matchMedia('(prefers-color-scheme: dark)').matches;
    }
    
    // Función para alternar el tema
    function toggleTheme() {
        const isCurrentlyDark = document.body.classList.contains('dark-mode');
        applyTheme(!isCurrentlyDark);
    }
    
    // Inicializar tema al cargar la página
    function initTheme() {
        const isDark = getSavedTheme();
        applyTheme(isDark);
    }
    
    // Exponer funciones globalmente
    window.themeManager = {
        toggle: toggleTheme,
        apply: applyTheme,
        isDark: () => document.body.classList.contains('dark-mode'),
        init: initTheme
    };
    
    // Exponer toggleTheme globalmente para onclick en HTML
    window.toggleTheme = toggleTheme;
    
    // Inicializar automáticamente cuando el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTheme);
    } else {
        initTheme();
    }
    
    // Escuchar cambios en localStorage desde otras pestañas
    window.addEventListener('storage', function(e) {
        if (e.key === THEME_KEY) {
            const isDark = e.newValue === 'dark';
            applyTheme(isDark);
        }
    });
})();