function email_validacion() {

  var email = document.getElementById('email');
  var error = document.getElementById('errorEmail');
  var icono = document.getElementById('icono-validacionEmail');
  
  // Limpiar estados anteriores
  email.classList.remove('input-error', 'input-valid', 'is-valid', 'is-invalid');
  icono.classList.remove('error', 'success');
  error.textContent = '';

  const regexEmail= /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  var valor = email.value.trim();

  // valida si el campo email esta vacio
  if (valor === '') {
    error.textContent = 'Este campo no puede estar vacío.';
    email.classList.add('is-invalid');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    return false;
  }

  if (valor.length < 7 || valor.length > 60) {
    error.textContent = 'El email debe tener minimo 7 y maximo 60 caracteres.';
    email.classList.add('is-invalid');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    return false;
  }

    // valida si el formato y es valido y los caracteres especiales admitidos
  if (!regexEmail.test(valor)) {
    error.textContent = "El email debe tener un @ y un .com  ej: example@email.com .";
    email.classList.add('is-invalid');
    icono.innerHTML = '<i class="fa fa-times"></i>'; // ícono X
    icono.classList.add('error');
    return false;
  }

    // Si pasa todas las validaciones
  error.textContent = '';
  email.classList.add('is-valid');
  icono.innerHTML = '<i class="fa fa-check"></i>'; // ícono tilde
  icono.classList.add('success');
  return true;
}

function formulario_validaciones() {

  const email_valido = email_validacion();

  if (email_valido) {

    // retorna true para enviar el form al servidor
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