// Funciones de validación para Cuentas por Pagar

function actualizarSaldo() {
  var monto = document.getElementById('montoCuenta').value;
  var saldoInput = document.getElementById('saldoCuenta');
  if (monto && !isNaN(monto) && monto > 0) {
    saldoInput.value = monto;
  }
}

function actualizarSaldoModificado() {
  var monto = document.getElementById('montoCuentaEdit').value;
  var saldoInput = document.getElementById('saldoCuentaEdit');
  var saldoActual = saldoInput.value;
  if (!saldoActual || saldoActual == 0 || saldoActual == document.getElementById('montoCuentaEdit').dataset.montoAnterior) {
    saldoInput.value = monto;
  }
  document.getElementById('montoCuentaEdit').dataset.montoAnterior = monto;
}

function validar_proveedor() {
  var proveedor = document.getElementById('proveedorId');
  var error = document.getElementById('errorProveedor');

  error.innerHTML = '';
  proveedor.classList.remove('input-error', 'input-valid');

  var valor = proveedor.value;

  if (valor === '') {
    error.innerHTML = 'Debe seleccionar un proveedor.';
    proveedor.classList.add('input-error', 'is-invalid');
    proveedor.classList.remove('is-valid');
    return false;
  }

  if (!/^\d+$/.test(valor) || valor <= 0) {
    error.innerHTML = 'Proveedor inválido.';
    proveedor.classList.add('input-error', 'is-invalid');
    proveedor.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  proveedor.classList.add('input-valid', 'is-valid');
  proveedor.classList.remove('is-invalid');
  return true;
}

function validar_monto() {
  var monto = document.getElementById('montoCuenta');
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

function validar_fecha_emision() {
  var fecha = document.getElementById('fechaEmision');
  var error = document.getElementById('errorFechaEmision');

  error.innerHTML = '';
  fecha.classList.remove('input-error', 'input-valid');

  var valor = fecha.value;

  if (valor === '') {
    error.innerHTML = 'La fecha de emisión es requerida.';
    fecha.classList.add('input-error', 'is-invalid');
    fecha.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  fecha.classList.add('input-valid', 'is-valid');
  fecha.classList.remove('is-invalid');
  return true;
}

function validar_fechas() {
  var fechaEmision = document.getElementById('fechaEmision');
  var fechaVencimiento = document.getElementById('fechaVencimiento');
  var error = document.getElementById('errorFechaVencimiento');

  error.innerHTML = '';
  fechaVencimiento.classList.remove('input-error', 'input-valid');

  var emision = fechaEmision.value;
  var vencimiento = fechaVencimiento.value;

  if (vencimiento === '') {
    error.innerHTML = 'La fecha de vencimiento es requerida.';
    fechaVencimiento.classList.add('input-error', 'is-invalid');
    fechaVencimiento.classList.remove('is-valid');
    return false;
  }

  if (vencimiento < emision) {
    error.innerHTML = 'La fecha de vencimiento no puede ser anterior a la emisión.';
    fechaVencimiento.classList.add('input-error', 'is-invalid');
    fechaVencimiento.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  fechaVencimiento.classList.add('input-valid', 'is-valid');
  fechaVencimiento.classList.remove('is-invalid');
  return true;
}

function validar_descripcion() {
  var descripcion = document.getElementById('descripcionCuenta');
  var error = document.getElementById('errorDescripcion');

  error.innerHTML = '';
  descripcion.classList.remove('input-error', 'input-valid');

  var valor = descripcion.value.trim();

  if (valor === '') {
    error.innerHTML = 'La descripción es requerida.';
    descripcion.classList.add('input-error', 'is-invalid');
    descripcion.classList.remove('is-valid');
    return false;
  }

  if (valor.length > 300) {
    error.innerHTML = 'La descripción no puede exceder 300 caracteres.';
    descripcion.classList.add('input-error', 'is-invalid');
    descripcion.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  descripcion.classList.add('input-valid', 'is-valid');
  descripcion.classList.remove('is-invalid');
  return true;
}

function validar_formulario() {
  const proveedor_valido = validar_proveedor();
  const monto_valido = validar_monto();
  const fecha_emision_valida = validar_fecha_emision();
  const fechas_validas = validar_fechas();
  const descripcion_valida = validar_descripcion();

  // Establecer fechas por defecto si están vacías
  var fechaEmisionInput = document.getElementById('fechaEmision');
  var fechaVencimientoInput = document.getElementById('fechaVencimiento');
  
  if (fechaEmisionInput.value === '') {
    var today = new Date().toISOString().split('T')[0];
    fechaEmisionInput.value = today;
    validar_fecha_emision();
  }
  
  if (fechaVencimientoInput.value === '') {
    var vencimiento = new Date();
    vencimiento.setDate(vencimiento.getDate() + 30);
    fechaVencimientoInput.value = vencimiento.toISOString().split('T')[0];
    validar_fechas();
  }

  if (proveedor_valido && monto_valido && fecha_emision_valida && fechas_validas && descripcion_valida) {
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

// Funciones para modificar
function validar_proveedor_modificado() {
  var proveedor = document.getElementById('proveedorIdEdit');
  var error = document.getElementById('errorProveedorEdit');

  error.innerHTML = '';
  proveedor.classList.remove('input-error', 'input-valid');

  var valor = proveedor.value;

  if (valor === '') {
    error.innerHTML = 'Debe seleccionar un proveedor.';
    proveedor.classList.add('input-error', 'is-invalid');
    proveedor.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  proveedor.classList.add('input-valid', 'is-valid');
  proveedor.classList.remove('is-invalid');
  return true;
}

function validar_monto_modificado() {
  var monto = document.getElementById('montoCuentaEdit');
  var error = document.getElementById('errorMontoEdit');

  error.innerHTML = '';
  monto.classList.remove('input-error', 'input-valid');

  var valor = monto.value.trim();

  if (valor === '' || parseFloat(valor) <= 0) {
    error.innerHTML = 'El monto debe ser mayor a 0.';
    monto.classList.add('input-error', 'is-invalid');
    monto.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  monto.classList.add('input-valid', 'is-valid');
  monto.classList.remove('is-invalid');
  return true;
}

function validar_fecha_emision_modificado() {
  var fecha = document.getElementById('fechaEmisionEdit');
  var error = document.getElementById('errorFechaEmisionEdit');

  error.innerHTML = '';
  fecha.classList.remove('input-error', 'input-valid');

  if (fecha.value === '') {
    error.innerHTML = 'La fecha es requerida.';
    fecha.classList.add('input-error', 'is-invalid');
    fecha.classList.remove('is-valid');
    return false;
  }

  fecha.classList.add('input-valid', 'is-valid');
  fecha.classList.remove('is-invalid');
  return true;
}

function validar_fechas_modificado() {
  var fechaEmision = document.getElementById('fechaEmisionEdit');
  var fechaVencimiento = document.getElementById('fechaVencimientoEdit');
  var error = document.getElementById('errorFechaVencimientoEdit');

  error.innerHTML = '';
  fechaVencimiento.classList.remove('input-error', 'input-valid');

  if (fechaVencimiento.value === '') {
    error.innerHTML = 'La fecha de vencimiento es requerida.';
    fechaVencimiento.classList.add('input-error', 'is-invalid');
    fechaVencimiento.classList.remove('is-valid');
    return false;
  }

  if (fechaVencimiento.value < fechaEmision.value) {
    error.innerHTML = 'La fecha de vencimiento no puede ser anterior.';
    fechaVencimiento.classList.add('input-error', 'is-invalid');
    fechaVencimiento.classList.remove('is-valid');
    return false;
  }

  fechaVencimiento.classList.add('input-valid', 'is-valid');
  fechaVencimiento.classList.remove('is-invalid');
  return true;
}

function validar_descripcion_modificado() {
  var descripcion = document.getElementById('descripcionCuentaEdit');
  var error = document.getElementById('errorDescripcionEdit');

  error.innerHTML = '';
  descripcion.classList.remove('input-error', 'input-valid');

  var valor = descripcion.value.trim();

  if (valor === '') {
    error.innerHTML = 'La descripción es requerida.';
    descripcion.classList.add('input-error', 'is-invalid');
    descripcion.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  descripcion.classList.add('input-valid', 'is-valid');
  descripcion.classList.remove('is-invalid');
  return true;
}

function validar_formulario_modificado() {
  const proveedor_valido = validar_proveedor_modificado();
  const monto_valido = validar_monto_modificado();
  const fecha_emision_valida = validar_fecha_emision_modificado();
  const fechas_validas = validar_fechas_modificado();
  const descripcion_valida = validar_descripcion_modificado();

  if (proveedor_valido && monto_valido && fecha_emision_valida && fechas_validas && descripcion_valida) {
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

function EliminarCuentaPagar(event, id) {
  event.preventDefault();
  const url = "index.php?url=pagar&action=eliminar&ID=" + id;

  Swal.fire({
    title: '¿Estás seguro?',
    text: "¡Deseas eliminar esta cuenta por pagar?",
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

// Establecer fechas por defecto al cargar
document.addEventListener('DOMContentLoaded', function() {
  var fechaEmisionInput = document.getElementById('fechaEmision');
  var fechaVencimientoInput = document.getElementById('fechaVencimiento');
  
  if (fechaEmisionInput) {
    var today = new Date().toISOString().split('T')[0];
    fechaEmisionInput.value = today;
    
    var vencimiento = new Date();
    vencimiento.setDate(vencimiento.getDate() + 30);
    fechaVencimientoInput.value = vencimiento.toISOString().split('T')[0];
  }
});
