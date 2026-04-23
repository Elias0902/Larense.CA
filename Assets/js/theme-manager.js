// Theme Manager Global - Sistema unificado de modo oscuro/claro
// VERSIÓN MEJORADA - Sin flash de modo claro al cargar la página
(function() {
    // Clave para localStorage
    const THEME_KEY = 'natys_theme_mode';
    
    // NOTA IMPORTANTE:
    // El tema inicial YA fue aplicado por el script crítico en el <head>
    // Este script maneja los cambios posteriores y mantiene la sincronización
    
    // Variable para evitar múltiples inicializaciones
    let isInitialized = false;
    
    // Función para aplicar el tema a TODO el documento
    function applyTheme(isDark) {
        // Aplicar tema al elemento HTML (raíz)
        if (isDark) {
            document.documentElement.setAttribute('data-theme', 'dark');
            document.documentElement.classList.add('dark-mode');
            document.body.classList.add('dark-mode');
        } else {
            document.documentElement.setAttribute('data-theme', 'light');
            document.documentElement.classList.remove('dark-mode');
            document.body.classList.remove('dark-mode');
        }
        
        // Actualizar todos los botones de tema en la página
        const allThemeToggles = document.querySelectorAll('.theme-toggle-nav, .theme-toggle');
        allThemeToggles.forEach(toggle => {
            if (isDark) {
                toggle.classList.add('dark');
                const icon = toggle.querySelector('i');
                if (icon) {
                    if (icon.classList.contains('fa-moon')) {
                        icon.classList.remove('fa-moon');
                        icon.classList.add('fa-sun');
                    } else if (icon.classList.contains('fa-sun')) {
                        // Ya está como sol, no hacer nada
                    } else {
                        // Si no tiene ninguna de las dos, establecer por defecto
                        icon.classList.add('fa-sun');
                    }
                }
            } else {
                toggle.classList.remove('dark');
                const icon = toggle.querySelector('i');
                if (icon) {
                    if (icon.classList.contains('fa-sun')) {
                        icon.classList.remove('fa-sun');
                        icon.classList.add('fa-moon');
                    } else if (icon.classList.contains('fa-moon')) {
                        // Ya está como luna, no hacer nada
                    } else {
                        // Si no tiene ninguna de las dos, establecer por defecto
                        icon.classList.add('fa-moon');
                    }
                }
            }
        });
        
        // Actualizar también el ícono del theme toggle independiente si existe
        const themeToggleBtn = document.getElementById('theme-toggle');
        if (themeToggleBtn) {
            const icon = themeToggleBtn.querySelector('i');
            if (icon) {
                if (isDark) {
                    if (icon.classList.contains('fa-moon')) {
                        icon.classList.remove('fa-moon');
                        icon.classList.add('fa-sun');
                    }
                } else {
                    if (icon.classList.contains('fa-sun')) {
                        icon.classList.remove('fa-sun');
                        icon.classList.add('fa-moon');
                    }
                }
            }
        }
        
        // Guardar preferencia en localStorage
        localStorage.setItem(THEME_KEY, isDark ? 'dark' : 'light');
        
        // Disparar evento personalizado para que otros componentes reaccionen
        window.dispatchEvent(new CustomEvent('themeChanged', { 
            detail: { 
                isDark: isDark,
                theme: isDark ? 'dark' : 'light'
            } 
        }));
        
        // Disparar evento para actualizar gráficos (Chart.js, etc.)
        if (typeof updateChartsTheme === 'function') {
            updateChartsTheme();
        }
        
        // Disparar evento para actualizar DataTables si existen
        if ($.fn && $.fn.DataTable) {
            const tables = $.fn.dataTable.tables();
            for (let i = 0; i < tables.length; i++) {
                const table = $(tables[i]).DataTable();
                if (table && table.draw) {
                    table.draw();
                }
            }
        }
    }
    
    // Función para obtener el tema guardado (sin aplicar cambios visuales)
    function getSavedThemePreference() {
        const saved = localStorage.getItem(THEME_KEY);
        if (saved === 'dark') return true;
        if (saved === 'light') return false;
        // Si no hay preferencia guardada, usar preferencia del sistema
        return window.matchMedia('(prefers-color-scheme: dark)').matches;
    }
    
    // Función para obtener el estado actual del tema desde el DOM
    function getCurrentThemeState() {
        return document.documentElement.classList.contains('dark-mode') || 
               document.body.classList.contains('dark-mode');
    }
    
    // Función para sincronizar el estado del DOM con la preferencia guardada
    function syncThemeWithStorage() {
        const savedIsDark = getSavedThemePreference();
        const currentIsDark = getCurrentThemeState();
        
        if (savedIsDark !== currentIsDark) {
            // Si hay discrepancia, aplicar el tema guardado
            applyTheme(savedIsDark);
        }
    }
    
    // Función para alternar el tema
    function toggleTheme() {
        // Obtener estado actual desde el HTML (fuente de verdad)
        const isCurrentlyDark = document.documentElement.classList.contains('dark-mode') || 
                                document.body.classList.contains('dark-mode');
        
        // Aplicar el tema opuesto
        applyTheme(!isCurrentlyDark);
        
        // Mostrar retroalimentación visual (opcional)
        const message = !isCurrentlyDark ? 'Modo oscuro activado' : 'Modo claro activado';
        console.log(`🌓 Theme Manager: ${message}`);
    }
    
    // Función para inicializar el manager (después de que el DOM esté listo)
    function initThemeManager() {
        if (isInitialized) return;
        
        // Sincronizar cualquier elemento que pueda haberse cargado después
        syncThemeWithStorage();
        
        // Asegurar que todos los botones tengan el ícono correcto
        const allThemeToggles = document.querySelectorAll('.theme-toggle-nav, .theme-toggle');
        const isDark = document.documentElement.classList.contains('dark-mode');
        
        allThemeToggles.forEach(toggle => {
            if (isDark) {
                toggle.classList.add('dark');
                const icon = toggle.querySelector('i');
                if (icon) {
                    if (icon.classList.contains('fa-moon')) {
                        icon.classList.remove('fa-moon');
                        icon.classList.add('fa-sun');
                    }
                }
            } else {
                toggle.classList.remove('dark');
                const icon = toggle.querySelector('i');
                if (icon) {
                    if (icon.classList.contains('fa-sun')) {
                        icon.classList.remove('fa-sun');
                        icon.classList.add('fa-moon');
                    }
                }
            }
        });
        
        isInitialized = true;
    }
    
    // Escuchar cambios en localStorage desde otras pestañas/ventanas
    function handleStorageChange(e) {
        if (e.key === THEME_KEY && e.newValue !== e.oldValue) {
            const isDark = e.newValue === 'dark';
            const currentIsDark = getCurrentThemeState();
            
            // Solo aplicar si es diferente para evitar bucles
            if (isDark !== currentIsDark) {
                applyTheme(isDark);
            }
        }
    }
    
    // Escuchar cambios en la preferencia del sistema (si el usuario cambia mientras la página está abierta)
    function handleSystemThemeChange(e) {
        // Solo aplicar si el usuario NO ha guardado una preferencia manual
        const hasManualPreference = localStorage.getItem(THEME_KEY) !== null;
        if (!hasManualPreference) {
            const isDark = e.matches;
            const currentIsDark = getCurrentThemeState();
            if (isDark !== currentIsDark) {
                applyTheme(isDark);
            }
        }
    }
    
    // Exponer funciones globalmente para uso en toda la aplicación
    window.themeManager = {
        toggle: toggleTheme,
        apply: applyTheme,
        isDark: function() {
            return document.documentElement.classList.contains('dark-mode') || 
                   document.body.classList.contains('dark-mode');
        },
        getPreference: function() {
            return localStorage.getItem(THEME_KEY) || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        },
        setTheme: function(theme) {
            if (theme === 'dark') {
                applyTheme(true);
            } else if (theme === 'light') {
                applyTheme(false);
            }
        },
        sync: syncThemeWithStorage,
        init: initThemeManager
    };
    
    // Exponer toggleTheme globalmente para onclick en HTML (compatibilidad)
    window.toggleTheme = toggleTheme;
    
    // Configurar listeners
    window.addEventListener('storage', handleStorageChange);
    
    // Escuchar cambios en la preferencia del sistema
    const darkModeMediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    if (darkModeMediaQuery.addEventListener) {
        darkModeMediaQuery.addEventListener('change', handleSystemThemeChange);
    } else if (darkModeMediaQuery.addListener) {
        // Fallback para navegadores más antiguos
        darkModeMediaQuery.addListener(handleSystemThemeChange);
    }
    
    // Inicializar cuando el DOM esté completamente cargado
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initThemeManager);
    } else {
        // El DOM ya está cargado, inicializar inmediatamente
        initThemeManager();
    }
    
    // También inicializar cuando todo el contenido (imágenes, etc.) esté cargado
    window.addEventListener('load', function() {
        // Asegurar que todo esté sincronizado después de la carga completa
        syncThemeWithStorage();
    });
    
    // Observar cambios en el DOM para manejar botones de tema que se agreguen dinámicamente
    if (typeof MutationObserver !== 'undefined') {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    // Buscar nuevos botones de tema que se hayan agregado
                    mutation.addedNodes.forEach(function(node) {
                        if (node.nodeType === 1) { // Elemento
                            const themeToggles = node.querySelectorAll ? 
                                node.querySelectorAll('.theme-toggle-nav, .theme-toggle') : [];
                            if (node.classList && (node.classList.contains('theme-toggle-nav') || 
                                node.classList.contains('theme-toggle'))) {
                                // Actualizar el ícono del nuevo botón
                                const isDark = getCurrentThemeState();
                                if (isDark) {
                                    node.classList.add('dark');
                                    const icon = node.querySelector('i');
                                    if (icon && icon.classList.contains('fa-moon')) {
                                        icon.classList.remove('fa-moon');
                                        icon.classList.add('fa-sun');
                                    }
                                } else {
                                    node.classList.remove('dark');
                                    const icon = node.querySelector('i');
                                    if (icon && icon.classList.contains('fa-sun')) {
                                        icon.classList.remove('fa-sun');
                                        icon.classList.add('fa-moon');
                                    }
                                }
                            }
                            // Revisar elementos hijos
                            if (themeToggles.length > 0) {
                                const isDark = getCurrentThemeState();
                                themeToggles.forEach(function(toggle) {
                                    if (isDark) {
                                        toggle.classList.add('dark');
                                        const icon = toggle.querySelector('i');
                                        if (icon && icon.classList.contains('fa-moon')) {
                                            icon.classList.remove('fa-moon');
                                            icon.classList.add('fa-sun');
                                        }
                                    } else {
                                        toggle.classList.remove('dark');
                                        const icon = toggle.querySelector('i');
                                        if (icon && icon.classList.contains('fa-sun')) {
                                            icon.classList.remove('fa-sun');
                                            icon.classList.add('fa-moon');
                                        }
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });
        
        // Observar todo el documento en busca de nuevos botones
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
    
    console.log('🌓 Theme Manager inicializado - Sin flash de modo claro');
})();