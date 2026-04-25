// inactivity-timer.js - Temporizador de inactividad (5 minutos)
(function() {
    const INACTIVITY_MS = 300000; // 10 segundos
    const WARNING_MS   = 295000;  // 5 segundos
    const LOGOUT_URL   = 'index.php?url=autenticator&action=cerrar&motivo=inactividad';

    let inactivityTimer = null;
    let warningTimer = null;
    let isWarningShown = false;

    function logoutDueToInactivity() {
        console.log('🔴 Cerrando sesión por inactividad');
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
            alert('Sesión cerrada por inactividad. Será redirigido.');
            window.location.href = LOGOUT_URL;
        }
    }

    function showInactivityWarning() {
        if (isWarningShown) return;
        isWarningShown = true;
        if (inactivityTimer) clearTimeout(inactivityTimer);

        console.log('⚠️ Mostrando advertencia de inactividad');

        if (typeof Swal === 'undefined') {
            console.warn('SweetAlert2 no disponible, usando confirm()');
            const msg = '⚠️ ¡Inactividad detectada!\n\nSe cerrará la sesión en 5 segundos.\nPresione Aceptar para continuar o espere para salir.';
            if (confirm(msg)) {
                isWarningShown = false;
                resetInactivityTimer();
            } else {
                logoutDueToInactivity();
            }
            return;
        }

        Swal.fire({
            title: '¡Inactividad detectada!',
            text: 'Se cerrará la sesión en 5 segundos. ¿Desea continuar?',
            icon: 'warning',
            timer: 5000,
            timerProgressBar: true,
            showConfirmButton: true,
            confirmButtonText: 'Sí, continuar',
            allowOutsideClick: false
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
                logoutDueToInactivity();
            } else if (result.isConfirmed) {
                isWarningShown = false;
                resetInactivityTimer();
            }
        });
    }

    function resetInactivityTimer() {
        console.log('🔄 Reiniciando temporizadores');
        if (inactivityTimer) clearTimeout(inactivityTimer);
        if (warningTimer) clearTimeout(warningTimer);
        if (isWarningShown && typeof Swal !== 'undefined') Swal.close();
        isWarningShown = false;

        warningTimer = setTimeout(showInactivityWarning, WARNING_MS);
        inactivityTimer = setTimeout(logoutDueToInactivity, INACTIVITY_MS);
    }

    const activityEvents = ['click', 'keydown', 'scroll', 'touchstart', 'mousedown'];
    activityEvents.forEach(event => document.addEventListener(event, resetInactivityTimer));

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', resetInactivityTimer);
    } else {
        resetInactivityTimer();
    }
})();