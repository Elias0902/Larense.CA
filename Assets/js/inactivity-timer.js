// Temporizador de inactividad - 10 segundos
console.log('=== SCRIPT DE INACTIVIDAD CARGADO ===');

let inactivityTimer;
let warningTimer;
const INACTIVITY_LIMIT = 300000; // 5 minutos en milisegundos
const WARNING_TIME = 285000; // Mostrar advertencia a los 4 minutos y 45 segundos
let isWarningShown = false;
let timerStarted = false;

// Reiniciar el temporizador cuando hay actividad
function resetInactivityTimer() {
    console.log('Reiniciando temporizador de inactividad');
    clearTimeout(inactivityTimer);
    clearTimeout(warningTimer);
    isWarningShown = false;
    
    // Iniciar temporizador de advertencia
    warningTimer = setTimeout(() => {
        console.log('⚠️ Mostrando advertencia de inactividad');
        showInactivityWarning();
    }, WARNING_TIME);
    
    // Iniciar temporizador de deslogueo
    inactivityTimer = setTimeout(() => {
        console.log('🚪 Ejecutando logout por inactividad');
        logoutDueToInactivity();
    }, INACTIVITY_LIMIT);
    
    console.log('✅ Temporizador reiniciado - Logout en', INACTIVITY_LIMIT/1000, 'segundos');
}

// Mostrar advertencia de inactividad
function showInactivityWarning() {
    if (isWarningShown) return;
    isWarningShown = true;
    
    console.log('📢 Mostrando alerta de advertencia');
    
    if (typeof Swal === 'undefined') {
        console.error('Swal no está definido, usando fallback');
        const warningConfirmed = confirm('⚠️ ¡Inactividad detectada!\n\nSe cerrará la sesión en 5 segundos por inactividad.\n\nHaga clic en Aceptar para mantener la sesión activa o espere para ser deslogueado.');
        
        if (warningConfirmed) {
            console.log('✅ Usuario interactuó, reiniciando temporizador');
            isWarningShown = false;
            resetInactivityTimer();
        } else {
            console.log('⏰ Usuario no interactuó, procediendo al logout');
            logoutDueToInactivity();
        }
        return;
    }
    
    Swal.fire({
        title: '¡Inactividad detectada!',
        text: 'Se cerrará la sesión en 5 segundos por inactividad. Realice alguna acción para mantener la sesión activa.',
        icon: 'warning',
        timer: 5000,
        timerProgressBar: true,
        showConfirmButton: false,
        allowOutsideClick: true,
        allowEscapeKey: true
    }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log('⏰ Timer terminó, procediendo al logout');
            logoutDueToInactivity();
        } else {
            console.log('✅ Usuario interactuó, reiniciando temporizador');
            isWarningShown = false;
            resetInactivityTimer();
        }
    });
}

// Desloguear por inactividad
function logoutDueToInactivity() {
    console.log('🔴 INICIANDO LOGOUT POR INACTIVIDAD');
    
    if (typeof Swal === 'undefined') {
        console.error('Swal no está definido, redirigiendo directamente');
        window.location.href = 'index.php?url=autenticator&action=cerrar&motivo=inactividad';
        return;
    }
    
    Swal.fire({
        title: 'Sesión cerrada',
        text: 'Ha sido deslogueado por inactividad.',
        icon: 'info',
        confirmButtonText: 'Aceptar',
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then(() => {
        console.log('🔄 Redirigiendo a:', 'index.php?url=autenticator&action=cerrar&motivo=inactividad');
        window.location.href = 'index.php?url=autenticator&action=cerrar&motivo=inactividad';
    });
}

// Eventos que reinician el temporizador
const activityEvents = [
    'mousedown', 'mousemove', 'keypress', 
    'scroll', 'touchstart', 'click'
];

console.log('📡 Registrando eventos de actividad:', activityEvents.join(', '));

activityEvents.forEach(event => {
    document.addEventListener(event, () => {
        resetInactivityTimer();
        // Si hay una advertencia mostrada y el usuario interactúa, cerrarla
        if (isWarningShown && typeof Swal !== 'undefined') {
            Swal.close();
            isWarningShown = false;
        }
    });
});

// Iniciar el temporizador cuando se carga la página
function startTimer() {
    console.log('🚀 Iniciando temporizador de inactividad');
    resetInactivityTimer();
    timerStarted = true;
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', startTimer);
} else {
    console.log('📄 Documento ya cargado, iniciando temporizador inmediatamente');
    startTimer();
}

console.log('=== SCRIPT DE INACTIVIDAD CONFIGURADO ===');
