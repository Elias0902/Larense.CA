// Función para formatear teléfono automáticamente
function formatear_telefono() {
  var telefono = document.getElementById('telefonoPedido');
  var valor = telefono.value.replace(/\D/g, '');
  
  if (valor.length >= 4) {
    valor = valor.substring(0, 4) + '-' + valor.substring(4, 11);
  }
  
  telefono.value = valor;
}

function formatear_telefono_modificado() {
  var telefono = document.getElementById('telefonoPedidoEdit');
  var valor = telefono.value.replace(/\D/g, '');
  
  if (valor.length >= 4) {
    valor = valor.substring(0, 4) + '-' + valor.substring(4, 11);
  }
  
  telefono.value = valor;
}

// Funciones de validación para el formulario de agregar
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

function validar_fecha() {
  var fecha = document.getElementById('fechaPedido');
  var error = document.getElementById('errorFecha');

  error.innerHTML = '';
  fecha.classList.remove('input-error', 'input-valid');

  var valor = fecha.value;

  if (valor === '') {
    error.innerHTML = 'La fecha es requerida.';
    fecha.classList.add('input-error', 'is-invalid');
    fecha.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  fecha.classList.add('input-valid', 'is-valid');
  fecha.classList.remove('is-invalid');
  return true;
}

function validar_total() {
  var total = document.getElementById('totalPedido');
  var error = document.getElementById('errorTotal');

  error.innerHTML = '';
  total.classList.remove('input-error', 'input-valid');

  var valor = total.value.trim();

  if (valor === '') {
    error.innerHTML = 'El total es requerido.';
    total.classList.add('input-error', 'is-invalid');
    total.classList.remove('is-valid');
    return false;
  }

  var valorNum = parseFloat(valor);
  if (isNaN(valorNum) || valorNum <= 0) {
    error.innerHTML = 'El total debe ser mayor a 0.';
    total.classList.add('input-error', 'is-invalid');
    total.classList.remove('is-valid');
    return false;
  }

  // Validar máximo 2 decimales
  var partes = valor.split('.');
  if (partes.length > 1 && partes[1].length > 2) {
    error.innerHTML = 'Máximo 2 decimales permitidos.';
    total.classList.add('input-error', 'is-invalid');
    total.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  total.classList.add('input-valid', 'is-valid');
  total.classList.remove('is-invalid');
  return true;
}

function validar_telefono() {
  var telefono = document.getElementById('telefonoPedido');
  var error = document.getElementById('errorTelefono');

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

function validar_direccion() {
  var direccion = document.getElementById('direccionPedido');
  var error = document.getElementById('errorDireccion');

  error.innerHTML = '';
  direccion.classList.remove('input-error', 'input-valid');

  var valor = direccion.value.trim();

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

function validar_observaciones() {
  var observaciones = document.getElementById('observacionesPedido');
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
  const fecha_valida = validar_fecha();
  const total_valido = validar_total();
  const telefono_valido = validar_telefono();
  const direccion_valida = validar_direccion();
  const observaciones_validas = validar_observaciones();

  // Establecer fecha por defecto si está vacía
  var fechaInput = document.getElementById('fechaPedido');
  if (fechaInput.value === '') {
    var today = new Date().toISOString().split('T')[0];
    fechaInput.value = today;
    validar_fecha();
  }

  if (cliente_valido && fecha_valida && total_valido && telefono_valido && direccion_valida && observaciones_validas) {
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

function validar_fecha_modificado() {
  var fecha = document.getElementById('fechaPedidoEdit');
  var error = document.getElementById('errorFechaEdit');

  error.innerHTML = '';
  fecha.classList.remove('input-error', 'input-valid');

  var valor = fecha.value;

  if (valor === '') {
    error.innerHTML = 'La fecha es requerida.';
    fecha.classList.add('input-error', 'is-invalid');
    fecha.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  fecha.classList.add('input-valid', 'is-valid');
  fecha.classList.remove('is-invalid');
  return true;
}

function validar_total_modificado() {
  var total = document.getElementById('totalPedidoEdit');
  var error = document.getElementById('errorTotalEdit');

  error.innerHTML = '';
  total.classList.remove('input-error', 'input-valid');

  var valor = total.value.trim();

  if (valor === '') {
    error.innerHTML = 'El total es requerido.';
    total.classList.add('input-error', 'is-invalid');
    total.classList.remove('is-valid');
    return false;
  }

  var valorNum = parseFloat(valor);
  if (isNaN(valorNum) || valorNum <= 0) {
    error.innerHTML = 'El total debe ser mayor a 0.';
    total.classList.add('input-error', 'is-invalid');
    total.classList.remove('is-valid');
    return false;
  }

  var partes = valor.split('.');
  if (partes.length > 1 && partes[1].length > 2) {
    error.innerHTML = 'Máximo 2 decimales permitidos.';
    total.classList.add('input-error', 'is-invalid');
    total.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  total.classList.add('input-valid', 'is-valid');
  total.classList.remove('is-invalid');
  return true;
}

function validar_telefono_modificado() {
  var telefono = document.getElementById('telefonoPedidoEdit');
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

function validar_direccion_modificado() {
  var direccion = document.getElementById('direccionPedidoEdit');
  var error = document.getElementById('errorDireccionEdit');

  error.innerHTML = '';
  direccion.classList.remove('input-error', 'input-valid');

  var valor = direccion.value.trim();

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

function validar_observaciones_modificado() {
  var observaciones = document.getElementById('observacionesPedidoEdit');
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
  const fecha_valida = validar_fecha_modificado();
  const total_valido = validar_total_modificado();
  const telefono_valido = validar_telefono_modificado();
  const direccion_valida = validar_direccion_modificado();
  const observaciones_validas = validar_observaciones_modificado();

  if (cliente_valido && fecha_valida && total_valido && telefono_valido && direccion_valida && observaciones_validas) {
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

// Función para eliminar pedido
function EliminarPedido(event, id) {
  event.preventDefault();
  const url = "index.php?url=pedidos&action=eliminar&ID=" + id;

  Swal.fire({
    title: '¿Estás seguro?',
    text: "¡Deseas eliminar este pedido? No podrás revertir esto!",
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
  var fechaInput = document.getElementById('fechaPedido');
  if (fechaInput) {
    var today = new Date().toISOString().split('T')[0];
    fechaInput.value = today;
  }
});
