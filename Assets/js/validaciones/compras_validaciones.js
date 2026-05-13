// Función para formatear teléfono automáticamente
function formatear_telefono() {
  var telefono = document.getElementById('telefonoCompra');
  var valor = telefono.value.replace(/\D/g, '');
  
  if (valor.length >= 4) {
    valor = valor.substring(0, 4) + '-' + valor.substring(4, 11);
  }
  
  telefono.value = valor;
}

// Funciones de validación para el formulario de agregar
function validar_proveedor() {
  var cliente = document.getElementById('proveedorId');
  var error = document.getElementById('errorProveedor');

  error.innerHTML = '';
  cliente.classList.remove('input-error', 'input-valid');

  var valor = cliente.value;

  if (valor === '') {
    error.innerHTML = 'Debe seleccionar un proveedor.';
    cliente.classList.add('input-error', 'is-invalid');
    cliente.classList.remove('is-valid');
    return false;
  }

  if (!/^\d+$/.test(valor) || valor <= 0) {
    error.innerHTML = 'Proveedor inválido.';
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
  var fecha = document.getElementById('fechaCompra');
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

function validar_materiaPrima() {
  var producto = document.getElementById('materiasPrimas');
  var error = document.getElementById('errorMateriaPrima');

  error.innerHTML = '';
  producto.classList.remove('input-error', 'input-valid', 'is-invalid', 'is-valid');

  var valor = producto.value;

  if (valor === '') {
    error.innerHTML = 'Debe seleccionar un a materia Prima.';
    producto.classList.add('input-error', 'is-invalid');
    producto.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  producto.classList.add('input-valid', 'is-valid');
  producto.classList.remove('is-invalid');
  return true;
}

function validar_cantidad() {
  var cantidad = document.getElementById('cantidadMateriaPrima');
  var error = document.getElementById('errorCantidad');

  error.innerHTML = '';
  cantidad.classList.remove('input-error', 'input-valid', 'is-invalid', 'is-valid');

  var valor = cantidad.value;

  if (valor === '' || parseFloat(valor) <= 0) {
    error.innerHTML = 'La cantidad es requerida y debe ser mayor a 0.';
    cantidad.classList.add('input-error', 'is-invalid');
    cantidad.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  cantidad.classList.add('input-valid', 'is-valid');
  cantidad.classList.remove('is-invalid');
  return true;
}

function validar_diasCredito() {
  var precio = document.getElementById('diasCredito');
  var error = document.getElementById('errorCredito');

  error.innerHTML = '';
  precio.classList.remove('input-error', 'input-valid', 'is-invalid', 'is-valid');

  var valor = precio.value;

  if (valor === '' || valor <= 0 || valor > 30) {
    error.innerHTML = 'Los son requeridos debe ser mayor a 0 menor a 30.';
    precio.classList.add('input-error', 'is-invalid');
    precio.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  precio.classList.add('input-valid', 'is-valid');
  precio.classList.remove('is-invalid');
  return true;
}

function validar_precio() {
  var precio = document.getElementById('precioMateriaPrima');
  var error = document.getElementById('errorPrecio');

  error.innerHTML = '';
  precio.classList.remove('input-error', 'input-valid', 'is-invalid', 'is-valid');

  var valor = precio.value;

  if (valor === '' || parseFloat(valor) <= 0) {
    error.innerHTML = 'El precio es requerido y debe ser mayor a 0.';
    precio.classList.add('input-error', 'is-invalid');
    precio.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  precio.classList.add('input-valid', 'is-valid');
  precio.classList.remove('is-invalid');
  return true;
}

function validar_fecha() {
  var fecha = document.getElementById('fechaCompra');
  var error = document.getElementById('errorFecha');

  error.innerHTML = '';
  fecha.classList.remove('input-error', 'input-valid', 'is-invalid', 'is-valid');

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
  var total = document.getElementById('totalCompra');
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

function validar_observaciones() {
  var observaciones = document.getElementById('observacionesCompra');
  var error = document.getElementById('errorObservaciones');
  var valor = observaciones.value.trim();

  if (valor === '') {
    error.innerHTML = 'La observación es requerida.';
    observaciones.style.border = '2px solid #dc3545';
    observaciones.style.backgroundColor = '#fff8f8';
    return false;
  }
  else if (valor.length > 300) {
    error.innerHTML = 'Las observaciones no pueden exceder 300 caracteres.';
    observaciones.style.border = '2px solid #dc3545';
    observaciones.style.backgroundColor = '#fff8f8';
    return false;
  }
  else {
    error.innerHTML = '';
    observaciones.style.border = '2px solid #28a745';
    observaciones.style.backgroundColor = '#f8fff8';
    return true;
  }
}

function validar_formulario() {
  const proveedor_valido = validar_proveedor();
  const fecha_valida = validar_fecha();
  const total_valido = validar_total();
  const observaciones_validas = validar_observaciones();

  // Establecer fecha por defecto si está vacía
  var fechaInput = document.getElementById('fechaCompra');
  if (fechaInput.value === '') {
    var today = new Date().toISOString().split('T')[0];
    fechaInput.value = today;
    validar_fecha();
  }

  if (proveedor_valido && fecha_valida && total_valido && observaciones_validas) {
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

function EliminarCompra(event, id) {
  event.preventDefault();
  const url = "index.php?url=compras&action=eliminar&ID=" + id;

  Swal.fire({
    title: '¿Estás seguro?',
    text: "¡Deseas eliminar esta Compra? No podrás revertir esto!",
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