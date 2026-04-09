function username_validacion() {

  var username = document.getElementById('username');
  var error = document.getElementById('errorUsername');
  var icono = document.getElementById('icono-validacionUsername');
  //error.textContent = ''; // limpia el mensaje
  //icono.innerHTML = ''; // limpia el icono
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

function codigo_validacion() {

  var codigo = document.getElementById('codigo');
  var error = document.getElementById('errorCOD');
  var icono = document.getElementById('icono-validacionCOD');
  error.textContent = ''; //limpia el mensaje de error
  icono.innerHTML = ''; //limpia el icono
  codigo.classList.remove('input-error' , 'input-valid'),
  icono.classList.remove('error');

  const regexCOD= /^\d{6}$/;
  var valor = codigo.value.trim();

  // valida si el campo email esta vacio
  if (valor === '') {
    error.textContent = 'Este campo no puede estar vacío.';
    codigo.classList.add('input-error');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    codigo.classList.add('is-invalid');  // clase bootstrap para borde rojo
    codigo.classList.remove('is-valid');
    return false;
  }

  if (valor.length < 6 || valor.length > 11) {
    error.textContent = 'El codigo debe tener 6 digitos.';
    codigo.classList.add('input-error');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    codigo.classList.add('is-invalid');  // clase bootstrap para borde rojo
    codigo.classList.remove('is-valid');
    return false;
  }

    // valida si el formato y es valido y los caracteres especiales admitidos
  if (!regexCOD.test(valor)) {
    error.textContent = "El codgo debe tener solo numeros.  ej: Example1234 .";
    codigo.classList.add('input-error');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    codigo.classList.add('is-invalid');  // clase bootstrap para borde rojo
    codigo.classList.remove('is-valid');
    return false;
  }

    // Si pasa todas las validaciones
  error.textContent = '';
  password.classList.add('input-valid');
  icono.innerHTML = '<i class="fa fa-check"></i>'; // ícono tilde
  icono.classList.remove('error');
  codigo.classList.add('is-valid');    // clase bootstrap para borde verde
  codigo.classList.remove('is-invalid');
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
  const password_valido = password_validacion();
  const codigo_valido = codigo_validacion();

  if (username_valido && password_valido && codigo_valido) {

    //retorna true para que el formulario se envie al servidor
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