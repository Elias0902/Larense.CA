// Función para formatear teléfono automáticamente
function formatear_telefono() {
  var telefono = document.getElementById('telefonoEntrega');
  var valor = telefono.value.replace(/\D/g, ''); // Eliminar todo lo que no sea número
  
  if (valor.length >= 4) {
    valor = valor.substring(0, 4) + '-' + valor.substring(4, 11);
  }
  
  telefono.value = valor;
}

function formatear_telefono_modificado() {
  var telefono = document.getElementById('telefonoEntregaEdit');
  var valor = telefono.value.replace(/\D/g, '');
  
  if (valor.length >= 4) {
    valor = valor.substring(0, 4) + '-' + valor.substring(4, 11);
  }
  
  telefono.value = valor;
}

// Funciones de validación para el formulario de agregar entrega
function validar_cliente() {
  var cliente = document.getElementById('clienteId');
  var error = document.getElementById('errorCliente');

  error.innerHTML = '';
  cliente.classList.remove('input-error', 'input-valid');

  var valor = cliente.value;

  if (valor === '') {
    error.innerHTML = 'Debe seleccionar un cliente.';
    cliente.classList.add('input-error', 'is-invalid');
    cliente.classList.remove('is-valid');
    return false;
  }

  if (!/^\d+$/.test(valor) || valor <= 0) {
    error.innerHTML = 'Cliente inválido.';
    cliente.classList.add('input-error', 'is-invalid');
    cliente.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  cliente.classList.add('input-valid', 'is-valid');
  cliente.classList.remove('is-invalid');
  return true;
}

function validar_direccion() {
  var direccion = document.getElementById('direccionEntrega');
  var error = document.getElementById('errorDireccion');

  error.innerHTML = '';
  direccion.classList.remove('input-error', 'input-valid');

  var valor = direccion.value.trim();

  if (valor === '') {
    error.innerHTML = 'La dirección es requerida.';
    direccion.classList.add('input-error', 'is-invalid');
    direccion.classList.remove('is-valid');
    return false;
  }

  if (valor.length < 10) {
    error.innerHTML = 'La dirección debe tener al menos 10 caracteres.';
    direccion.classList.add('input-error', 'is-invalid');
    direccion.classList.remove('is-valid');
    return false;
  }

  if (valor.length > 300) {
    error.innerHTML = 'La dirección no puede exceder 300 caracteres.';
    direccion.classList.add('input-error', 'is-invalid');
    direccion.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  direccion.classList.add('input-valid', 'is-valid');
  direccion.classList.remove('is-invalid');
  return true;
}

function validar_telefono() {
  var telefono = document.getElementById('telefonoEntrega');
  var error = document.getElementById('errorTelefono');

  error.innerHTML = '';
  telefono.classList.remove('input-error', 'input-valid');

  var valor = telefono.value.trim();

  // Teléfono es opcional pero si se ingresa debe tener formato correcto
  if (valor !== '') {
    var regex = /^[0-9]{4}-[0-9]{7}$/;
    if (!regex.test(valor)) {
      error.innerHTML = 'Formato inválido. Use: 04XX-XXXXXXX';
      telefono.classList.add('input-error', 'is-invalid');
      telefono.classList.remove('is-valid');
      return false;
    }
  }

  error.innerHTML = '';
  if (valor !== '') {
    telefono.classList.add('input-valid', 'is-valid');
    telefono.classList.remove('is-invalid');
  }
  return true;
}

function validar_fecha() {
  var fecha = document.getElementById('fechaProgramada');
  var error = document.getElementById('errorFecha');

  error.innerHTML = '';
  fecha.classList.remove('input-error', 'input-valid');

  var valor = fecha.value;

  if (valor === '') {
    error.innerHTML = 'La fecha programada es requerida.';
    fecha.classList.add('input-error', 'is-invalid');
    fecha.classList.remove('is-valid');
    return false;
  }

  // Validar que la fecha no sea anterior a hoy
  var fechaSeleccionada = new Date(valor);
  var hoy = new Date();
  hoy.setHours(0, 0, 0, 0);

  if (fechaSeleccionada < hoy) {
    error.innerHTML = 'La fecha no puede ser anterior a hoy.';
    fecha.classList.add('input-error', 'is-invalid');
    fecha.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  fecha.classList.add('input-valid', 'is-valid');
  fecha.classList.remove('is-invalid');
  return true;
}

function validar_observaciones() {
  var observaciones = document.getElementById('observacionesEntrega');
  var error = document.getElementById('errorObservaciones');

  error.innerHTML = '';
  observaciones.classList.remove('input-error', 'input-valid');

  var valor = observaciones.value.trim();

  if (valor.length > 500) {
    error.innerHTML = 'Las observaciones no pueden exceder 500 caracteres.';
    observaciones.classList.add('input-error', 'is-invalid');
    observaciones.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  observaciones.classList.add('input-valid', 'is-valid');
  observaciones.classList.remove('is-invalid');
  return true;
}

function validar_formulario() {
  const cliente_valido = validar_cliente();
  const direccion_valida = validar_direccion();
  const telefono_valido = validar_telefono();
  const fecha_valida = validar_fecha();
  const observaciones_validas = validar_observaciones();

  // Establecer fecha mínima por defecto si está vacía
  var fechaInput = document.getElementById('fechaProgramada');
  if (fechaInput.value === '') {
    var now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    fechaInput.value = now.toISOString().slice(0, 16);
    validar_fecha();
  }

  if (cliente_valido && direccion_valida && telefono_valido && fecha_valida && observaciones_validas) {
    return true;
  } else {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Por favor corrige los campos marcados.',
      confirmButtonText: 'Aceptar',
      timer: 6000,
      timerProgressBar: true,
    });
    return false;
  }
}

// Funciones de validación para el formulario de modificar
function validar_cliente_modificado() {
  var cliente = document.getElementById('clienteIdEdit');
  var error = document.getElementById('errorClienteEdit');

  error.innerHTML = '';
  cliente.classList.remove('input-error', 'input-valid');

  var valor = cliente.value;

  if (valor === '') {
    error.innerHTML = 'Debe seleccionar un cliente.';
    cliente.classList.add('input-error', 'is-invalid');
    cliente.classList.remove('is-valid');
    return false;
  }

  if (!/^\d+$/.test(valor) || valor <= 0) {
    error.innerHTML = 'Cliente inválido.';
    cliente.classList.add('input-error', 'is-invalid');
    cliente.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  cliente.classList.add('input-valid', 'is-valid');
  cliente.classList.remove('is-invalid');
  return true;
}

function validar_direccion_modificado() {
  var direccion = document.getElementById('direccionEntregaEdit');
  var error = document.getElementById('errorDireccionEdit');

  error.innerHTML = '';
  direccion.classList.remove('input-error', 'input-valid');

  var valor = direccion.value.trim();

  if (valor === '') {
    error.innerHTML = 'La dirección es requerida.';
    direccion.classList.add('input-error', 'is-invalid');
    direccion.classList.remove('is-valid');
    return false;
  }

  if (valor.length < 10) {
    error.innerHTML = 'La dirección debe tener al menos 10 caracteres.';
    direccion.classList.add('input-error', 'is-invalid');
    direccion.classList.remove('is-valid');
    return false;
  }

  if (valor.length > 300) {
    error.innerHTML = 'La dirección no puede exceder 300 caracteres.';
    direccion.classList.add('input-error', 'is-invalid');
    direccion.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  direccion.classList.add('input-valid', 'is-valid');
  direccion.classList.remove('is-invalid');
  return true;
}

function validar_telefono_modificado() {
  var telefono = document.getElementById('telefonoEntregaEdit');
  var error = document.getElementById('errorTelefonoEdit');

  error.innerHTML = '';
  telefono.classList.remove('input-error', 'input-valid');

  var valor = telefono.value.trim();

  if (valor !== '') {
    var regex = /^[0-9]{4}-[0-9]{7}$/;
    if (!regex.test(valor)) {
      error.innerHTML = 'Formato inválido. Use: 04XX-XXXXXXX';
      telefono.classList.add('input-error', 'is-invalid');
      telefono.classList.remove('is-valid');
      return false;
    }
  }

  error.innerHTML = '';
  if (valor !== '') {
    telefono.classList.add('input-valid', 'is-valid');
    telefono.classList.remove('is-invalid');
  }
  return true;
}

function validar_fecha_modificado() {
  var fecha = document.getElementById('fechaProgramadaEdit');
  var error = document.getElementById('errorFechaEdit');

  error.innerHTML = '';
  fecha.classList.remove('input-error', 'input-valid');

  var valor = fecha.value;

  if (valor === '') {
    error.innerHTML = 'La fecha programada es requerida.';
    fecha.classList.add('input-error', 'is-invalid');
    fecha.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  fecha.classList.add('input-valid', 'is-valid');
  fecha.classList.remove('is-invalid');
  return true;
}

function validar_observaciones_modificado() {
  var observaciones = document.getElementById('observacionesEntregaEdit');
  var error = document.getElementById('errorObservacionesEdit');

  error.innerHTML = '';
  observaciones.classList.remove('input-error', 'input-valid');

  var valor = observaciones.value.trim();

  if (valor.length > 500) {
    error.innerHTML = 'Las observaciones no pueden exceder 500 caracteres.';
    observaciones.classList.add('input-error', 'is-invalid');
    observaciones.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  observaciones.classList.add('input-valid', 'is-valid');
  observaciones.classList.remove('is-invalid');
  return true;
}

function validar_formulario_modificado() {
  const cliente_valido = validar_cliente_modificado();
  const direccion_valida = validar_direccion_modificado();
  const telefono_valido = validar_telefono_modificado();
  const fecha_valida = validar_fecha_modificado();
  const observaciones_validas = validar_observaciones_modificado();

  if (cliente_valido && direccion_valida && telefono_valido && fecha_valida && observaciones_validas) {
    return true;
  } else {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Por favor corrige los campos marcados.',
      confirmButtonText: 'Aceptar',
      timer: 6000,
      timerProgressBar: true,
    });
    return false;
  }
}

// Función para eliminar entrega
function EliminarEntrega(event, id) {
  event.preventDefault();
  const url = "index.php?url=entregas&action=eliminar&ID=" + id;

  Swal.fire({
    title: '¿Estás seguro?',
    text: "¡Deseas eliminar esta entrega? No podrás revertir esto!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    } else {
      Swal.fire({
        title: 'Cancelado',
        text: 'Se canceló la acción.',
        icon: 'info',
        timer: 1800,
        timerProgressBar: true,
      });
    }
  });
}

// Establecer fecha mínima al cargar el modal
document.addEventListener('DOMContentLoaded', function() {
  var fechaInput = document.getElementById('fechaProgramada');
  if (fechaInput) {
    var now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    fechaInput.min = now.toISOString().slice(0, 16);
    fechaInput.value = now.toISOString().slice(0, 16);
  }
});
