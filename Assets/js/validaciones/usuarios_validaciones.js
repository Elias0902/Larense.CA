function username_validacion() {

  var username = document.getElementById('nombre_usuario');
  var error = document.getElementById('errorUsername');

  error.innerHTML = ''; // limpia el icono
  username.classList.remove('input-error' , 'input-valid');

  const regex = /^[a-zA-Z0-9@_]+$/;
  var valor = username.value.trim();

  // si el usuario esta vacio improme error
  if (valor === '') {
    error.innerHTML = 'Este campo no puede estar vacío.';
    username.classList.add('is-invalid');  // clase bootstrap para borde rojo
    username.classList.remove('is-valid');
    return false;
  }

  // valida si el usuario cumple con las longitudes de caracteres
  if (valor.length < 5 || valor.length > 20) {
    error.innerHTML = 'El usuario debe tener minimo 5 y maximo 20 caracteres.';
    username.classList.add('is-invalid');  // clase bootstrap para borde rojo
    username.classList.remove('is-valid');
    return false;
  }

  // valida si el formato y es valido y los caracteres especiales admitidos
  if (!regex.test(valor) || !valor.includes('@') || !valor.includes('_')) {
    error.innerHTML = "El usuario solo debe tener un @ y/o un _  ej:@usuario_123 .";
    username.classList.add('is-invalid');  // clase bootstrap para borde rojo
    username.classList.remove('is-valid');
    return false;
  }

  // Si pasa todas las validaciones
  error.innerHTML = '';
  username.classList.add('is-valid');    // clase bootstrap para borde verde
  username.classList.remove('is-invalid');
  return true;
}

function email_validacion() {

  var email = document.getElementById('email_usuario');
  var error = document.getElementById('errorEmail');
  error.innerHTML = ''; //limpia el mensaje de error
  email.classList.remove('input-error' , 'input-valid');

  const regexEmail= /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  var valor = email.value.trim();

  // valida si el campo email esta vacio
  if (valor === '') {
    error.innerHTML = 'Este campo no puede estar vacío.';
    email.classList.add('is-invalid');  // clase bootstrap para borde rojo
    email.classList.remove('is-valid');
    return false;
  }

  if (valor.length < 7 || valor.length > 60) {
    error.innerHTML = 'El email debe tener minimo 7 y maximo 60 caracteres.';
    email.classList.add('is-invalid');  // clase bootstrap para borde rojo
    email.classList.remove('is-valid');
    return false;
  }

    // valida si el formato y es valido y los caracteres especiales admitidos
  if (!regexEmail.test(valor)) {
    error.innerHTML = "El email debe tener un @ y un .com  ej: example@email.com .";
    email.classList.add('is-invalid');  // clase bootstrap para borde rojo
    email.classList.remove('is-valid');
    return false;
  }

    // Si pasa todas las validaciones
  error.innerHTML = '';
  email.classList.add('is-valid');    // clase bootstrap para borde verde
  email.classList.remove('is-invalid');
  return true;
}

function password_validacion() {

  var password = document.getElementById('password');
  var error = document.getElementById('errorPW');
  error.innerHTML = ''; //limpia el mensaje de error
  password.classList.remove('input-error' , 'input-valid');

  const regexPW= /^(?=.*[A-Z])(?=.*\.)[a-zA-Z0-9.]{6,}$/;
  var valor = password.value.trim();

  // valida si el campo email esta vacio
  if (valor === '') {
    error.innerHTML = 'Este campo no puede estar vacío.';
    password.classList.add('is-invalid');  // clase bootstrap para borde rojo
    password.classList.remove('is-valid');
    return false;
  }

  if (valor.length < 6 || valor.length > 11) {
    error.innerHTML = 'El password debe tener minimo 6 y maximo 11 caracteres.';
    password.classList.add('is-invalid');  // clase bootstrap para borde rojo
    password.classList.remove('is-valid');
    return false;
  }

    // valida si el formato y es valido y los caracteres especiales admitidos
  if (!regexPW.test(valor)) {
    error.innerHTML = "El password debe tener un caracter mayuscula y un .  ej: Example12. .";
    password.classList.add('is-invalid');  // clase bootstrap para borde rojo
    password.classList.remove('is-valid');
    return false;
  }

    // Si pasa todas las validaciones
  error.innerHTML = '';
  password.classList.add('is-valid');    // clase bootstrap para borde verde
  password.classList.remove('is-invalid');
  return true;
}

function validar_rol() {
    const select = document.getElementById("id_rol");
    const error = document.getElementById("errorRol");

    const valor = select.value;

    if (valor === "") {
        error.innerHTML = "Selecciones un Rol";
        select.classList.add("is-invalid");
        select.classList.remove("is-valid");
        return false;
    } else {
        error.innerHTML = "";
        select.classList.add("is-valid");
        select.classList.remove("is-invalid");
        return true;
    }
}

function formulario_validaciones() {

  const username_valido = username_validacion();
  const email_valido = email_validacion();
  const password_valido = password_validacion();

  if (username_valido && email_valido && password_valido) {

    //retorna true para enviar el form al servidor
    return true;
    
  }else{
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Por favor corrige los campos.',
      confirmButtonText: 'Aceptar',
      timer: 6000,
      timerProgressBar: true,
    });
    return false;
  }
}

// Username MODIFICAR
function validar_nombre_modificado() {
    var username = document.getElementById('nombre_usuarioEdit');
    var error = document.getElementById('errorUsernameEdit');
    
    error.innerHTML = '';
    username.classList.remove('is-invalid', 'is-valid');
    
    const regex = /^[a-zA-Z0-9@_]+$/;
    var valor = username.value.trim();
    
    if (valor === '') {
        error.innerHTML = 'Este campo no puede estar vacío.';
        username.classList.add('is-invalid');
        return false;
    }
    
    if (valor.length < 5 || valor.length > 20) {
        error.innerHTML = 'Mínimo 5 y máximo 20 caracteres.';
        username.classList.add('is-invalid');
        return false;
    }
    
    if (!regex.test(valor)) {
        error.innerHTML = "Solo letras, números, @ y _ (ej: usuario_123).";
        username.classList.add('is-invalid');
        return false;
    }
    
    username.classList.add('is-valid');
    return true;
}

// Email MODIFICAR
function validar_email_modificado() {
    var email = document.getElementById('email_usuarioEdit');
    var error = document.getElementById('errorEmailEdit');
    
    error.innerHTML = '';
    email.classList.remove('is-invalid', 'is-valid');
    
    const regexEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    var valor = email.value.trim();
    
    if (valor === '') {
        error.innerHTML = 'Este campo no puede estar vacío.';
        email.classList.add('is-invalid');
        return false;
    }
    
    if (valor.length < 7 || valor.length > 60) {
        error.innerHTML = 'Mínimo 7 y máximo 60 caracteres.';
        email.classList.add('is-invalid');
        return false;
    }
    
    if (!regexEmail.test(valor)) {
        error.innerHTML = "Formato inválido (ej: usuario@dominio.com).";
        email.classList.add('is-invalid');
        return false;
    }
    
    email.classList.add('is-valid');
    return true;
}

// Password MODIFICAR (OPCIONAL)
function validar_password_modificado() {
    var password = document.getElementById('passwordEdit');
    var error = document.getElementById('errorPWMod');
    
    error.innerHTML = '';
    password.classList.remove('is-invalid', 'is-valid');
    
    var valor = password.value.trim();
    
    // ✅ VACÍO = OK (no cambiar password)
    if (valor === '') {
        password.classList.add('is-valid');
        return true;
    }
    
    // Validar si se llena
    const regexPW = /^(?=.*[A-Z])(?=.*\.)[a-zA-Z0-9.]{6,}$/;
    
    if (valor.length < 6 || valor.length > 11) {
        error.innerHTML = 'Mínimo 6 y máximo 11 caracteres.';
        password.classList.add('is-invalid');
        return false;
    }
    
    if (!regexPW.test(valor)) {
        error.innerHTML = "Debe tener mayúscula y punto (ej: Example12.).";
        password.classList.add('is-invalid');
        return false;
    }
    
    password.classList.add('is-valid');
    return true;
}

// Rol MODIFICAR
function validar_rol_modificado() {
    const select = document.getElementById("id_rolEdit");
    const error = document.getElementById("errorRolEdit");
    
    if (select.value === "") {
        error.innerHTML = "Selecciona un rol";
        select.classList.add("is-invalid");
        select.classList.remove("is-valid");
        return false;
    } else {
        error.innerHTML = "";
        select.classList.add("is-valid");
        select.classList.remove("is-invalid");
        return true;
    }
}

// VALIDACIÓN FORMULARIO MODIFICAR
function validar_formulario_modificado() {
    const username_valido = validar_nombre_modificado();
    const email_valido = validar_email_modificado();
    const password_valido = validar_password_modificado();
    const rol_valido = validar_rol_modificado();
    
    if (username_valido && email_valido && rol_valido && password_valido) {
        return true;
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Error de Validación',
            text: 'Corrige los campos marcados en rojo.',
            confirmButtonText: 'Aceptar',
            timer: 5000,
            timerProgressBar: true,
        });
        return false;
    }
}

// LIMPIAR MODAL
function limpiarModalModificar() {
    document.getElementById('formUsuarioModificar').reset();
    // Limpiar errores visuales
    ['errorUsernameEdit', 'errorEmailEdit', 'errorRolEdit', 'errorPWMod'].forEach(id => {
        document.getElementById(id).innerHTML = '';
    });
    ['nombre_usuarioEdit', 'email_usuarioEdit', 'id_rolEdit', 'passwordEdit'].forEach(id => {
        document.getElementById(id).classList.remove('is-valid', 'is-invalid');
    });
}

function EliminarUsuario(event, id) {
    // Evitar navegación inmediata
    event.preventDefault();
    
    // Se establece URL del enlace
    const url = "index.php?url=usuarios&action=eliminar&ID=" + id;
    
    // Confirmación de la acción
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Deseas eliminar el usuario. No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si confirma, redirige a la URL
            window.location.href = url;
        } else {
            // Manejar la cancelación
            Swal.fire({
                title: 'Cancelado',
                text: 'Se canceló la acción.',
                icon: 'info',
                timer: 1800,
                timerProgressBar: true,
            });
        }
    });
    return false;
}