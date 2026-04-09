function username_validacion() {

  var username = document.getElementById('username');
  var error = document.getElementById('errorUsername');
  var icono = document.getElementById('icono-validacionUsername');
  error.textContent = ''; // limpia el mensaje
  icono.innerHTML = ''; // limpia el icono
  username.classList.remove('input-error' , 'input-valid');
  icono.classList.remove('error');

  const regex = /^[a-zA-Z0-9@_]+$/;
  var valor = username.value.trim();

  // si el usuario esta vacio improme error
  if (valor === '') {
    error.textContent = 'Este campo no puede estar vacío.';
    username.classList.add('input-error');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    username.classList.add('is-invalid');  // clase bootstrap para borde rojo
    username.classList.remove('is-valid');
    return false;
  }

  // valida si el usuario cumple con las longitudes de caracteres
  if (valor.length < 5 || valor.length > 20) {
    error.textContent = 'El usuario debe tener minimo 5 y maximo 20 caracteres.';
    username.classList.add('input-error');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    username.classList.add('is-invalid');  // clase bootstrap para borde rojo
    username.classList.remove('is-valid');
    return false;
  }

  // valida si el formato y es valido y los caracteres especiales admitidos
  if (!regex.test(valor) || !valor.includes('@') || !valor.includes('_')) {
    error.textContent = "El usuario solo debe tener un @ y/o un _  ej:@usuario_123 .";
    username.classList.add('input-error');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    username.classList.add('is-invalid');  // clase bootstrap para borde rojo
    username.classList.remove('is-valid');
    return false;
  }

  // Si pasa todas las validaciones
  error.textContent = '';
  username.classList.add('input-valid');
  icono.innerHTML = '<i class="fa fa-check"></i>'; // ícono tilde
  icono.classList.remove('error');
  username.classList.add('is-valid');    // clase bootstrap para borde verde
  username.classList.remove('is-invalid');
  return true;
}

function email_validacion() {

  var email = document.getElementById('email');
  var error = document.getElementById('errorEmail');
  var icono = document.getElementById('icono-validacionEmail');
  error.textContent = ''; //limpia el mensaje de error
  icono.innerHTML = ''; //limpia el icono
  email.classList.remove('input-error' , 'input-valid'),
  icono.classList.remove('error');

  const regexEmail= /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  var valor = email.value.trim();

  // valida si el campo email esta vacio
  if (valor === '') {
    error.textContent = 'Este campo no puede estar vacío.';
    email.classList.add('input-error');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    email.classList.add('is-invalid');  // clase bootstrap para borde rojo
    email.classList.remove('is-valid');
    return false;
  }

  if (valor.length < 7 || valor.length > 60) {
    error.textContent = 'El email debe tener minimo 7 y maximo 60 caracteres.';
    email.classList.add('input-error');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    email.classList.add('is-invalid');  // clase bootstrap para borde rojo
    email.classList.remove('is-valid');
    return false;
  }

    // valida si el formato y es valido y los caracteres especiales admitidos
  if (!regexEmail.test(valor)) {
    error.textContent = "El email debe tener un @ y un .com  ej: example@email.com .";
    email.classList.add('input-error');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    email.classList.add('is-invalid');  // clase bootstrap para borde rojo
    email.classList.remove('is-valid');
    return false;
  }

    // Si pasa todas las validaciones
  error.textContent = '';
  email.classList.add('input-valid');
  icono.innerHTML = '<i class="fa fa-check"></i>'; // ícono tilde
  icono.classList.remove('error');
  email.classList.add('is-valid');    // clase bootstrap para borde verde
  email.classList.remove('is-invalid');
  return true;
}

function password_validacion() {

  var password = document.getElementById('password');
  var error = document.getElementById('errorPW');
  var icono = document.getElementById('icono-validacionPW');
  error.textContent = ''; //limpia el mensaje de error
  icono.innerHTML = ''; //limpia el icono
  password.classList.remove('input-error' , 'input-valid'),
  icono.classList.remove('error');

  const regexPW= /^(?=.*[A-Z])(?=.*\.)[a-zA-Z0-9.]{6,}$/;
  var valor = password.value.trim();

  // valida si el campo email esta vacio
  if (valor === '') {
    error.textContent = 'Este campo no puede estar vacío.';
    password.classList.add('input-error');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    password.classList.add('is-invalid');  // clase bootstrap para borde rojo
    password.classList.remove('is-valid');
    return false;
  }

  if (valor.length < 6 || valor.length > 11) {
    error.textContent = 'El password debe tener minimo 6 y maximo 11 caracteres.';
    password.classList.add('input-error');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    password.classList.add('is-invalid');  // clase bootstrap para borde rojo
    password.classList.remove('is-valid');
    return false;
  }

    // valida si el formato y es valido y los caracteres especiales admitidos
  if (!regexPW.test(valor)) {
    error.textContent = "El password debe tener un caracter mayuscula y un .  ej: Example12. .";
    password.classList.add('input-error');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    password.classList.add('is-invalid');  // clase bootstrap para borde rojo
    password.classList.remove('is-valid');
    return false;
  }

    // Si pasa todas las validaciones
  error.textContent = '';
  password.classList.add('input-valid');
  icono.innerHTML = '<i class="fa fa-check"></i>'; // ícono tilde
  icono.classList.remove('error');
  password.classList.add('is-valid');    // clase bootstrap para borde verde
  password.classList.remove('is-invalid');
  return true;
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