<?php
/**
 * Configuración de Timeout de Inactividad
 * Maneja el temporizador de inactividad para usuarios logueados.
 * Tiempo por defecto: 5 minutos (300 segundos).
 */

/**
 * Obtiene el código JavaScript del temporizador de inactividad.
 *
 * @param int $inactivitySeconds Tiempo total en segundos antes del logout (por defecto 300).
 * @param int $warningSeconds    Tiempo en segundos antes de mostrar advertencia (por defecto 285).
 * @return string Código HTML con el script.
 */
function getInactivityTimerScript($inactivitySeconds = 300, $warningSeconds = 295) {
    // Validar tiempos
    $inactivityMs = $inactivitySeconds * 1000;
    $warningMs   = $warningSeconds * 1000;
    $logoutUrl   = htmlspecialchars('index.php?url=autenticator&action=cerrar&motivo=inactividad');

    ob_start();
    ?>
    <script>
    (function() {
        // Configuración desde PHP
        const INACTIVITY_MS = <?php echo (int)$inactivityMs; ?>;
        const WARNING_MS   = <?php echo (int)$warningMs; ?>;
        const LOGOUT_URL   = '<?php echo $logoutUrl; ?>';

        //console.log('🔐 Inicializando temporizador de inactividad:', (INACTIVITY_MS/1000) + ' segundos');

        let inactivityTimer = null;
        let warningTimer = null;
        let isWarningShown = false;

        // Cerrar sesión por inactividad
        function logoutDueToInactivity() {
            //console.log('🔴 Cerrando sesión por inactividad');
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Sesión cerrada',
                    text: 'Ha sido deslogueado por inactividad.',
                    icon: 'info',
                    confirmButtonText: 'Aceptar',
                    allowOutsideClick: false
                }).then(() => {
                    window.location.href = LOGOUT_URL;
                });
            } else {
                //alert('Sesión cerrada por inactividad. Será redirigido.');
                window.location.href = LOGOUT_URL;
            }
        }

        // Mostrar advertencia de inactividad
        function showInactivityWarning() {
            if (isWarningShown) return;
            isWarningShown = true;

            // Cancelar el temporizador principal para evitar doble logout
            if (inactivityTimer) clearTimeout(inactivityTimer);

            //console.log('⚠️ Mostrando advertencia de inactividad');

            if (typeof Swal === 'undefined') {
                 //Fallback con confirm + timeout automático
                //console.warn('SweetAlert2 no disponible, usando confirm()');
                const msg = '⚠️ ¡Inactividad detectada!\n\nSe cerrará la sesión en 5 segundos.\nPresione Aceptar para continuar o espere para salir.';
                const warningConfirmed = confirm(msg);
                if (warningConfirmed) {
                    //console.log('✅ Usuario activo, reiniciando temporizador');
                    isWarningShown = false;
                    resetInactivityTimer();
                } else {
                    logoutDueToInactivity();
                }
                return;
            }

            // Usar SweetAlert2 con botón de acción
            Swal.fire({
                title: '¡Inactividad detectada!',
                text: 'Se cerrará la sesión en 5 segundos. ¿Desea continuar?',
                icon: 'warning',
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: true,
                confirmButtonText: 'Sí, continuar',
                showCancelButton: false,
                allowOutsideClick: false
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    // No interactuó en 5 segundos
                    //console.log('⏰ Tiempo agotado, cerrando sesión');
                    logoutDueToInactivity();
                } else if (result.isConfirmed) {
                    // Hizo clic en "Continuar"
                    //console.log('✅ Usuario confirmó, reiniciando temporizador');
                    isWarningShown = false;
                    resetInactivityTimer();
                }
            });
        }

        // Reiniciar ambos temporizadores
        function resetInactivityTimer() {
            //console.log('🔄 Reiniciando temporizadores');
            if (inactivityTimer) clearTimeout(inactivityTimer);
            if (warningTimer) clearTimeout(warningTimer);
            if (isWarningShown && typeof Swal !== 'undefined') {
                Swal.close(); // Cerrar cualquier alerta abierta
                isWarningShown = false;
            }

            // Temporizador de advertencia
            warningTimer = setTimeout(() => {
                showInactivityWarning();
            }, WARNING_MS);

            // Temporizador de logout (respaldo, se cancelará si se muestra advertencia)
            inactivityTimer = setTimeout(() => {
                logoutDueToInactivity();
            }, INACTIVITY_MS);
        }

        // Eventos que indican actividad del usuario
        const activityEvents = ['click', 'keydown', 'scroll', 'touchstart', 'mousedown'];
        //console.log('📡 Eventos monitoreados:', activityEvents.join(', '));

        activityEvents.forEach(event => {
            document.addEventListener(event, resetInactivityTimer);
        });

        // Iniciar el temporizador cuando la página esté lista
        function startTimer() {
            //console.log('🚀 Iniciando temporizador de inactividad');
            resetInactivityTimer();
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', startTimer);
        } else {
            startTimer();
        }
    })();
    </script>
    <?php
    return ob_get_clean();
}

/**
 * Imprime el script de temporizador solo si el usuario está logueado.
 * Opcionalmente puede recibir tiempos personalizados.
 */
function printInactivityTimerScript($inactivitySeconds = 300, $warningSeconds = 295) {
    if (isset($_SESSION['s_usuario'])) {
        echo getInactivityTimerScript($inactivitySeconds, $warningSeconds);
    }
}
?>