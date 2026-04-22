// Validaciones para el formulario de notificaciones

function validar_id_usuario() {
    const idUsuario = document.getElementById('idUsuario').value;
    const errorIdUsuario = document.getElementById('errorIdUsuario');
    const iconoValidacion = document.getElementById('icono-validacionIdUsuario');
    
    if (idUsuario === '' || idUsuario <= 0) {
        errorIdUsuario.innerHTML = 'El ID de usuario es requerido y debe ser mayor a 0';
        iconoValidacion.innerHTML = '<i class="fas fa-times-circle" style="color:red"></i>';
        return false;
    } else {
        errorIdUsuario.innerHTML = '';
        iconoValidacion.innerHTML = '<i class="fas fa-check-circle" style="color:green"></i>';
        return true;
    }
}

function validar_descripcion() {
    const descripcion = document.getElementById('descripcionNotificacion').value;
    const errorDescripcion = document.getElementById('errorDescripcion');
    const iconoValidacion = document.getElementById('icono-validacionDescripcion');
    
    const expre_descripcion = /^[a-zA-Z0-9\s.,;:áéíóúÁÉÍÓÚñÑ\-_]+$/;
    
    if (descripcion === '' || descripcion.length < 5 || descripcion.length > 100) {
        errorDescripcion.innerHTML = 'La descripcion debe tener entre 5 y 100 caracteres';
        iconoValidacion.innerHTML = '<i class="fas fa-times-circle" style="color:red"></i>';
        return false;
    } else if (!expre_descripcion.test(descripcion)) {
        errorDescripcion.innerHTML = 'La descripcion contiene caracteres no permitidos';
        iconoValidacion.innerHTML = '<i class="fas fa-times-circle" style="color:red"></i>';
        return false;
    } else {
        errorDescripcion.innerHTML = '';
        iconoValidacion.innerHTML = '<i class="fas fa-check-circle" style="color:green"></i>';
        return true;
    }
}

function validar_enlace() {
    const enlace = document.getElementById('enlaceNotificacion').value;
    const errorEnlace = document.getElementById('errorEnlace');
    const iconoValidacion = document.getElementById('icono-validacionEnlace');
    
    const expre_enlace = /^[a-zA-Z0-9\s.,;:\/\?=&\-_#]*$/;
    
    if (enlace !== '' && (enlace.length > 100 || !expre_enlace.test(enlace))) {
        errorEnlace.innerHTML = 'El enlace debe tener maximo 100 caracteres validos';
        iconoValidacion.innerHTML = '<i class="fas fa-times-circle" style="color:red"></i>';
        return false;
    } else {
        errorEnlace.innerHTML = '';
        iconoValidacion.innerHTML = enlace !== '' ? '<i class="fas fa-check-circle" style="color:green"></i>' : '';
        return true;
    }
}

function validar_formulario() {
    const validoIdUsuario = validar_id_usuario();
    const validoDescripcion = validar_descripcion();
    const validoEnlace = validar_enlace();
    
    if (validoIdUsuario && validoDescripcion && validoEnlace) {
        return true;
    } else {
        return false;
    }
}

// Validaciones para el formulario de modificacion

function validar_id_usuario_modificado() {
    const idUsuario = document.getElementById('idUsuarioEdit').value;
    const errorIdUsuario = document.getElementById('errorIdUsuarioEdit');
    const iconoValidacion = document.getElementById('icono-validacionIdUsuarioEdit');
    
    if (idUsuario === '' || idUsuario <= 0) {
        errorIdUsuario.innerHTML = 'El ID de usuario es requerido y debe ser mayor a 0';
        iconoValidacion.innerHTML = '<i class="fas fa-times-circle" style="color:red"></i>';
        return false;
    } else {
        errorIdUsuario.innerHTML = '';
        iconoValidacion.innerHTML = '<i class="fas fa-check-circle" style="color:green"></i>';
        return true;
    }
}

function validar_descripcion_modificado() {
    const descripcion = document.getElementById('descripcionNotificacionEdit').value;
    const errorDescripcion = document.getElementById('errorDescripcionEdit');
    const iconoValidacion = document.getElementById('icono-validacionDescripcionEdit');
    
    const expre_descripcion = /^[a-zA-Z0-9\s.,;:áéíóúÁÉÍÓÚñÑ\-_]+$/;
    
    if (descripcion === '' || descripcion.length < 5 || descripcion.length > 100) {
        errorDescripcion.innerHTML = 'La descripcion debe tener entre 5 y 100 caracteres';
        iconoValidacion.innerHTML = '<i class="fas fa-times-circle" style="color:red"></i>';
        return false;
    } else if (!expre_descripcion.test(descripcion)) {
        errorDescripcion.innerHTML = 'La descripcion contiene caracteres no permitidos';
        iconoValidacion.innerHTML = '<i class="fas fa-times-circle" style="color:red"></i>';
        return false;
    } else {
        errorDescripcion.innerHTML = '';
        iconoValidacion.innerHTML = '<i class="fas fa-check-circle" style="color:green"></i>';
        return true;
    }
}

function validar_enlace_modificado() {
    const enlace = document.getElementById('enlaceNotificacionEdit').value;
    const errorEnlace = document.getElementById('errorEnlaceEdit');
    const iconoValidacion = document.getElementById('icono-validacionEnlaceEdit');
    
    const expre_enlace = /^[a-zA-Z0-9\s.,;:\/\?=&\-_#]*$/;
    
    if (enlace !== '' && (enlace.length > 100 || !expre_enlace.test(enlace))) {
        errorEnlace.innerHTML = 'El enlace debe tener maximo 100 caracteres validos';
        iconoValidacion.innerHTML = '<i class="fas fa-times-circle" style="color:red"></i>';
        return false;
    } else {
        errorEnlace.innerHTML = '';
        iconoValidacion.innerHTML = enlace !== '' ? '<i class="fas fa-check-circle" style="color:green"></i>' : '';
        return true;
    }
}

function validar_formulario_modificado() {
    const validoIdUsuario = validar_id_usuario_modificado();
    const validoDescripcion = validar_descripcion_modificado();
    const validoEnlace = validar_enlace_modificado();
    
    if (validoIdUsuario && validoDescripcion && validoEnlace) {
        return true;
    } else {
        return false;
    }
}
