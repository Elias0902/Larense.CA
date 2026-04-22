// Funciones de validación para el formulario de agregar pago
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

function validar_monto() {
  var monto = document.getElementById('montoPago');
  var error = document.getElementById('errorMonto');

  error.innerHTML = '';
  monto.classList.remove('input-error', 'input-valid');

  var valor = monto.value.trim();

  if (valor === '') {
    error.innerHTML = 'El monto es requerido.';
    monto.classList.add('input-error', 'is-invalid');
    monto.classList.remove('is-valid');
    return false;
  }

  var valorNum = parseFloat(valor);
  if (isNaN(valorNum) || valorNum <= 0) {
    error.innerHTML = 'El monto debe ser mayor a 0.';
    monto.classList.add('input-error', 'is-invalid');
    monto.classList.remove('is-valid');
    return false;
  }

  // Validar máximo 2 decimales
  var partes = valor.split('.');
  if (partes.length > 1 && partes[1].length > 2) {
    error.innerHTML = 'Máximo 2 decimales permitidos.';
    monto.classList.add('input-error', 'is-invalid');
    monto.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  monto.classList.add('input-valid', 'is-valid');
  monto.classList.remove('is-invalid');
  return true;
}

function validar_metodo() {
  var metodo = document.getElementById('metodoPago');
  var error = document.getElementById('errorMetodo');

  error.innerHTML = '';
  metodo.classList.remove('input-error', 'input-valid');

  var valor = metodo.value;
  var metodosPermitidos = ['efectivo', 'transferencia', 'debito', 'credito', 'biopago', 'pago_movil', 'zelle'];

  if (valor === '') {
    error.innerHTML = 'Debe seleccionar un método de pago.';
    metodo.classList.add('input-error', 'is-invalid');
    metodo.classList.remove('is-valid');
    return false;
  }

  if (!metodosPermitidos.includes(valor)) {
    error.innerHTML = 'Método de pago inválido.';
    metodo.classList.add('input-error', 'is-invalid');
    metodo.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  metodo.classList.add('input-valid', 'is-valid');
  metodo.classList.remove('is-invalid');
  return true;
}

function validar_fecha() {
  var fecha = document.getElementById('fechaPago');
  var error = document.getElementById('errorFecha');

  error.innerHTML = '';
  fecha.classList.remove('input-error', 'input-valid');

  var valor = fecha.value;

  if (valor === '') {
    error.innerHTML = 'La fecha de pago es requerida.';
    fecha.classList.add('input-error', 'is-invalid');
    fecha.classList.remove('is-valid');
    return false;
  }

  // Validar formato de fecha
  var fechaRegex = /^\d{4}-\d{2}-\d{2}$/;
  if (!fechaRegex.test(valor)) {
    error.innerHTML = 'Formato de fecha inválido.';
    fecha.classList.add('input-error', 'is-invalid');
    fecha.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  fecha.classList.add('input-valid', 'is-valid');
  fecha.classList.remove('is-invalid');
  return true;
}

function validar_referencia() {
  var referencia = document.getElementById('referenciaPago');
  var error = document.getElementById('errorReferencia');
  var metodo = document.getElementById('metodoPago').value;

  error.innerHTML = '';
  referencia.classList.remove('input-error', 'input-valid');

  var valor = referencia.value.trim();

  // Referencia es requerida para ciertos métodos
  var metodosConReferencia = ['transferencia', 'zelle', 'pago_movil'];
  if (metodosConReferencia.includes(metodo) && valor === '') {
    error.innerHTML = 'La referencia es requerida para este método de pago.';
    referencia.classList.add('input-error', 'is-invalid');
    referencia.classList.remove('is-valid');
    return false;
  }

  // Validar formato si tiene valor
  if (valor !== '') {
    var regex = /^[a-zA-Z0-9\-]{0,50}$/;
    if (!regex.test(valor)) {
      error.innerHTML = 'La referencia solo puede contener letras, números y guiones.';
      referencia.classList.add('input-error', 'is-invalid');
      referencia.classList.remove('is-valid');
      return false;
    }
  }

  error.innerHTML = '';
  referencia.classList.add('input-valid', 'is-valid');
  referencia.classList.remove('is-invalid');
  return true;
}

function validar_observaciones() {
  var observaciones = document.getElementById('observacionesPago');
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
  const monto_valido = validar_monto();
  const metodo_valido = validar_metodo();
  const fecha_valida = validar_fecha();
  const referencia_valida = validar_referencia();
  const observaciones_validas = validar_observaciones();

  // Establecer fecha por defecto si está vacía
  var fechaInput = document.getElementById('fechaPago');
  if (fechaInput.value === '') {
    var today = new Date().toISOString().split('T')[0];
    fechaInput.value = today;
    validar_fecha();
  }

  if (cliente_valido && monto_valido && metodo_valido && fecha_valida && referencia_valida && observaciones_validas) {
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

function validar_monto_modificado() {
  var monto = document.getElementById('montoPagoEdit');
  var error = document.getElementById('errorMontoEdit');

  error.innerHTML = '';
  monto.classList.remove('input-error', 'input-valid');

  var valor = monto.value.trim();

  if (valor === '') {
    error.innerHTML = 'El monto es requerido.';
    monto.classList.add('input-error', 'is-invalid');
    monto.classList.remove('is-valid');
    return false;
  }

  var valorNum = parseFloat(valor);
  if (isNaN(valorNum) || valorNum <= 0) {
    error.innerHTML = 'El monto debe ser mayor a 0.';
    monto.classList.add('input-error', 'is-invalid');
    monto.classList.remove('is-valid');
    return false;
  }

  // Validar máximo 2 decimales
  var partes = valor.split('.');
  if (partes.length > 1 && partes[1].length > 2) {
    error.innerHTML = 'Máximo 2 decimales permitidos.';
    monto.classList.add('input-error', 'is-invalid');
    monto.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  monto.classList.add('input-valid', 'is-valid');
  monto.classList.remove('is-invalid');
  return true;
}

function validar_metodo_modificado() {
  var metodo = document.getElementById('metodoPagoEdit');
  var error = document.getElementById('errorMetodoEdit');

  error.innerHTML = '';
  metodo.classList.remove('input-error', 'input-valid');

  var valor = metodo.value;
  var metodosPermitidos = ['efectivo', 'transferencia', 'debito', 'credito', 'biopago', 'pago_movil', 'zelle'];

  if (valor === '') {
    error.innerHTML = 'Debe seleccionar un método de pago.';
    metodo.classList.add('input-error', 'is-invalid');
    metodo.classList.remove('is-valid');
    return false;
  }

  if (!metodosPermitidos.includes(valor)) {
    error.innerHTML = 'Método de pago inválido.';
    metodo.classList.add('input-error', 'is-invalid');
    metodo.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  metodo.classList.add('input-valid', 'is-valid');
  metodo.classList.remove('is-invalid');
  return true;
}

function validar_fecha_modificado() {
  var fecha = document.getElementById('fechaPagoEdit');
  var error = document.getElementById('errorFechaEdit');

  error.innerHTML = '';
  fecha.classList.remove('input-error', 'input-valid');

  var valor = fecha.value;

  if (valor === '') {
    error.innerHTML = 'La fecha de pago es requerida.';
    fecha.classList.add('input-error', 'is-invalid');
    fecha.classList.remove('is-valid');
    return false;
  }

  // Validar formato de fecha
  var fechaRegex = /^\d{4}-\d{2}-\d{2}$/;
  if (!fechaRegex.test(valor)) {
    error.innerHTML = 'Formato de fecha inválido.';
    fecha.classList.add('input-error', 'is-invalid');
    fecha.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  fecha.classList.add('input-valid', 'is-valid');
  fecha.classList.remove('is-invalid');
  return true;
}

function validar_referencia_modificado() {
  var referencia = document.getElementById('referenciaPagoEdit');
  var error = document.getElementById('errorReferenciaEdit');
  var metodo = document.getElementById('metodoPagoEdit').value;

  error.innerHTML = '';
  referencia.classList.remove('input-error', 'input-valid');

  var valor = referencia.value.trim();

  // Referencia es requerida para ciertos métodos
  var metodosConReferencia = ['transferencia', 'zelle', 'pago_movil'];
  if (metodosConReferencia.includes(metodo) && valor === '') {
    error.innerHTML = 'La referencia es requerida para este método de pago.';
    referencia.classList.add('input-error', 'is-invalid');
    referencia.classList.remove('is-valid');
    return false;
  }

  // Validar formato si tiene valor
  if (valor !== '') {
    var regex = /^[a-zA-Z0-9\-]{0,50}$/;
    if (!regex.test(valor)) {
      error.innerHTML = 'La referencia solo puede contener letras, números y guiones.';
      referencia.classList.add('input-error', 'is-invalid');
      referencia.classList.remove('is-valid');
      return false;
    }
  }

  error.innerHTML = '';
  referencia.classList.add('input-valid', 'is-valid');
  referencia.classList.remove('is-invalid');
  return true;
}

function validar_observaciones_modificado() {
  var observaciones = document.getElementById('observacionesPagoEdit');
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
  const monto_valido = validar_monto_modificado();
  const metodo_valido = validar_metodo_modificado();
  const fecha_valida = validar_fecha_modificado();
  const referencia_valida = validar_referencia_modificado();
  const observaciones_validas = validar_observaciones_modificado();

  if (cliente_valido && monto_valido && metodo_valido && fecha_valida && referencia_valida && observaciones_validas) {
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

// Función para eliminar pago
function EliminarPago(event, id) {
  event.preventDefault();
  const url = "index.php?url=pagos&action=eliminar&ID=" + id;

  Swal.fire({
    title: '¿Estás seguro?',
    text: "¡Deseas eliminar este pago? No podrás revertir esto!",
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

// Establecer fecha por defecto al cargar el modal
document.addEventListener('DOMContentLoaded', function() {
  var fechaInput = document.getElementById('fechaPago');
  if (fechaInput) {
    var today = new Date().toISOString().split('T')[0];
    fechaInput.value = today;
    fechaInput.max = today;
  }
});
