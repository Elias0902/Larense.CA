function username_validacion() {

  var username = document.getElementById('username');
  var error = document.getElementById('errorUsername');
  var icono = document.getElementById('icono-validacionUsername');
  
  // Limpiar estados anteriores
  username.classList.remove('input-error', 'input-valid', 'is-valid', 'is-invalid');
  icono.classList.remove('error', 'success');
  error.textContent = '';

  const regex = /^[a-zA-Z0-9@_]+$/;
  var valor = username.value.trim();

  // si el usuario esta vacio impirme error
  if (valor === '') {
    error.textContent = 'Este campo no puede estar vacío.';
    username.classList.add('is-invalid');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    return false;
  }

  // valida si el usuario cumple con las longitudes de caracteres
  if (valor.length < 5 || valor.length > 20) {
    error.textContent = 'El usuario debe tener minimo 5 y maximo 20 caracteres.';
    username.classList.add('is-invalid');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    return false;
  }

  // valida si el formato y es valido y los caracteres especiales admitidos
  if (!regex.test(valor) || !valor.includes('@') || !valor.includes('_')) {
    error.textContent = "El usuario solo debe tener un @ y/o un _  ej:@usuario_123 .";
    username.classList.add('is-invalid');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    return false;
  }

  // Si pasa todas las validaciones
  error.textContent = '';
  username.classList.add('is-valid');
  icono.innerHTML = '<i class="fa fa-check"></i>'; // ícono tilde
  icono.classList.add('success');
  return true;
}

function password_validacion() {

  var password = document.getElementById('password');
  var error = document.getElementById('errorPW');
  var icono = document.getElementById('icono-validacionPW');
  
  // Limpiar estados anteriores
  password.classList.remove('input-error', 'input-valid', 'is-valid', 'is-invalid');
  icono.classList.remove('error', 'success');
  error.textContent = '';

  const regexPW= /^(?=.*[A-Z])(?=.*\.)[a-zA-Z0-9.]{6,}$/;
  var valor = password.value.trim();

  // valida si el campo password esta vacio
  if (valor === '') {
    error.textContent = 'Este campo no puede estar vacío.';
    password.classList.add('is-invalid');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    return false;
  }

  if (valor.length < 6 || valor.length > 11) {
    error.textContent = 'El password debe tener minimo 6 y maximo 11 caracteres.';
    password.classList.add('is-invalid');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    return false;
  }

    // valida si el formato y es valido y los caracteres especiales admitidos
  if (!regexPW.test(valor)) {
    error.textContent = "El password debe tener un caracter mayuscula y un .  ej: Example12. .";
    password.classList.add('is-invalid');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    return false;
  }

    // Si pasa todas las validaciones
  error.textContent = '';
  password.classList.add('is-valid');
  icono.innerHTML = '<i class="fa fa-check"></i>'; // ícono tilde
  icono.classList.add('success');
  return true;
}

function formulario_validaciones() {

  const username_valido = username_validacion();
  const password_valido = password_validacion();

  if (username_valido && password_valido) {

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