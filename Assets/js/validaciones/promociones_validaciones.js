// Función para actualizar el placeholder del valor según el tipo seleccionado
function actualizarPlaceholder() {
  const tipo = document.getElementById('tipoPromocion').value;
  const valorInput = document.getElementById('valorPromocion');

  if (tipo === 'porcentaje') {
    valorInput.placeholder = 'Ej: 10 (para 10%)';
    valorInput.max = 100;
  } else if (tipo === '2x1') {
    valorInput.placeholder = '2';
    valorInput.value = '2';
    valorInput.readOnly = true;
  } else if (tipo === 'monto_fijo') {
    valorInput.placeholder = 'Ej: 50 (monto en $)';
    valorInput.max = 999999;
    valorInput.readOnly = false;
  } else {
    valorInput.placeholder = '10';
    valorInput.readOnly = false;
  }
}

function actualizarPlaceholderEdit() {
  const tipo = document.getElementById('tipoPromocionEdit').value;
  const valorInput = document.getElementById('valorPromocionEdit');

  if (tipo === 'porcentaje') {
    valorInput.placeholder = 'Ej: 10 (para 10%)';
    valorInput.max = 100;
  } else if (tipo === '2x1') {
    valorInput.placeholder = '2';
    valorInput.value = '2';
    valorInput.readOnly = true;
  } else if (tipo === 'monto_fijo') {
    valorInput.placeholder = 'Ej: 50 (monto en $)';
    valorInput.max = 999999;
    valorInput.readOnly = false;
  } else {
    valorInput.placeholder = '10';
    valorInput.readOnly = false;
  }
}

// Funciones de validación para el formulario de agregar
function validar_codigo() {
  var codigo = document.getElementById('codigoPromocion');
  var error = document.getElementById('errorCodigo');

  error.innerHTML = '';
  codigo.classList.remove('input-error', 'input-valid');

  const regex = /^[A-Za-z0-9%\-]{2,10}$/;
  var valor = codigo.value.trim();

  if (valor === '') {
    error.innerHTML = 'El código no puede estar vacío.';
    codigo.classList.add('input-error', 'is-invalid');
    codigo.classList.remove('is-valid');
    return false;
  }

  if (valor.length < 2 || valor.length > 10) {
    error.innerHTML = 'El código debe tener entre 2 y 10 caracteres.';
    codigo.classList.add('input-error', 'is-invalid');
    codigo.classList.remove('is-valid');
    return false;
  }

  if (!regex.test(valor)) {
    error.innerHTML = 'El código solo puede contener letras, números, % y -.';
    codigo.classList.add('input-error', 'is-invalid');
    codigo.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  codigo.classList.add('input-valid', 'is-valid');
  codigo.classList.remove('is-invalid');
  return true;
}

function validar_nombre() {
  var nombre = document.getElementById('nombrePromocion');
  var error = document.getElementById('errorNombre');

  error.innerHTML = '';
  nombre.classList.remove('input-error', 'input-valid');

  const regex = /^[a-zA-Z0-9\s\-_%]{5,50}$/;
  var valor = nombre.value.trim();

  if (valor === '') {
    error.innerHTML = 'El nombre no puede estar vacío.';
    nombre.classList.add('input-error', 'is-invalid');
    nombre.classList.remove('is-valid');
    return false;
  }

  if (valor.length < 5 || valor.length > 50) {
    error.innerHTML = 'El nombre debe tener entre 5 y 50 caracteres.';
    nombre.classList.add('input-error', 'is-invalid');
    nombre.classList.remove('is-valid');
    return false;
  }

  if (!regex.test(valor)) {
    error.innerHTML = 'El nombre contiene caracteres no permitidos.';
    nombre.classList.add('input-error', 'is-invalid');
    nombre.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  nombre.classList.add('input-valid', 'is-valid');
  nombre.classList.remove('is-invalid');
  return true;
}

function validar_descripcion() {
  var descripcion = document.getElementById('descripcionPromocion');
  var error = document.getElementById('errorDescripcion');

  error.innerHTML = '';
  descripcion.classList.remove('input-error', 'input-valid');

  var valor = descripcion.value.trim();

  if (valor === '') {
    error.innerHTML = 'La descripción no puede estar vacía.';
    descripcion.classList.add('input-error', 'is-invalid');
    descripcion.classList.remove('is-valid');
    return false;
  }

  if (valor.length > 200) {
    error.innerHTML = 'La descripción no puede exceder 200 caracteres.';
    descripcion.classList.add('input-error', 'is-invalid');
    descripcion.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  descripcion.classList.add('input-valid', 'is-valid');
  descripcion.classList.remove('is-invalid');
  return true;
}

function validar_tipo() {
  var tipo = document.getElementById('tipoPromocion');
  var error = document.getElementById('errorTipo');

  error.innerHTML = '';
  tipo.classList.remove('input-error', 'input-valid');

  var valor = tipo.value;
  var tiposPermitidos = ['porcentaje', '2x1', 'monto_fijo'];

  if (valor === '') {
    error.innerHTML = 'Debe seleccionar un tipo de promoción.';
    tipo.classList.add('input-error', 'is-invalid');
    tipo.classList.remove('is-valid');
    return false;
  }

  if (!tiposPermitidos.includes(valor)) {
    error.innerHTML = 'Tipo de promoción inválido.';
    tipo.classList.add('input-error', 'is-invalid');
    tipo.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  tipo.classList.add('input-valid', 'is-valid');
  tipo.classList.remove('is-invalid');
  return true;
}

function validar_valor() {
  var valor = document.getElementById('valorPromocion');
  var error = document.getElementById('errorValor');
  var tipo = document.getElementById('tipoPromocion').value;

  error.innerHTML = '';
  valor.classList.remove('input-error', 'input-valid');

  var valorNum = parseFloat(valor.value);

  if (isNaN(valorNum) || valor.value.trim() === '') {
    error.innerHTML = 'El valor es requerido.';
    valor.classList.add('input-error', 'is-invalid');
    valor.classList.remove('is-valid');
    return false;
  }

  if (valorNum < 0) {
    error.innerHTML = 'El valor no puede ser negativo.';
    valor.classList.add('input-error', 'is-invalid');
    valor.classList.remove('is-valid');
    return false;
  }

  if (tipo === 'porcentaje' && valorNum > 100) {
    error.innerHTML = 'El porcentaje no puede exceder 100%.';
    valor.classList.add('input-error', 'is-invalid');
    valor.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  valor.classList.add('input-valid', 'is-valid');
  valor.classList.remove('is-invalid');
  return true;
}

function validar_fechas() {
  var fechaInicio = document.getElementById('fechaInicio');
  var fechaFin = document.getElementById('fechaFin');
  var errorInicio = document.getElementById('errorFechaInicio');
  var errorFin = document.getElementById('errorFechaFin');

  errorInicio.innerHTML = '';
  errorFin.innerHTML = '';
  fechaInicio.classList.remove('input-error', 'input-valid');
  fechaFin.classList.remove('input-error', 'input-valid');

  var inicio = fechaInicio.value;
  var fin = fechaFin.value;

  if (inicio === '') {
    errorInicio.innerHTML = 'La fecha de inicio es requerida.';
    fechaInicio.classList.add('input-error', 'is-invalid');
    fechaInicio.classList.remove('is-valid');
    return false;
  }

  if (fin === '') {
    errorFin.innerHTML = 'La fecha de fin es requerida.';
    fechaFin.classList.add('input-error', 'is-invalid');
    fechaFin.classList.remove('is-valid');
    return false;
  }

  if (inicio > fin) {
    errorInicio.innerHTML = 'La fecha de inicio no puede ser mayor que la fecha de fin.';
    fechaInicio.classList.add('input-error', 'is-invalid');
    fechaInicio.classList.remove('is-valid');
    return false;
  }

  fechaInicio.classList.add('input-valid', 'is-valid');
  fechaInicio.classList.remove('is-invalid');
  fechaFin.classList.add('input-valid', 'is-valid');
  fechaFin.classList.remove('is-invalid');
  return true;
}

function validar_formulario() {
  const codigo_valido = validar_codigo();
  const nombre_valido = validar_nombre();
  const descripcion_valida = validar_descripcion();
  const tipo_valido = validar_tipo();
  const valor_valido = validar_valor();
  const fechas_validas = validar_fechas();

  if (codigo_valido && nombre_valido && descripcion_valida && tipo_valido && valor_valido && fechas_validas) {
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
function validar_codigo_modificado() {
  var codigo = document.getElementById('codigoPromocionEdit');
  var error = document.getElementById('errorCodigoEdit');

  error.innerHTML = '';
  codigo.classList.remove('input-error', 'input-valid');

  const regex = /^[A-Za-z0-9%\-]{2,10}$/;
  var valor = codigo.value.trim();

  if (valor === '') {
    error.innerHTML = 'El código no puede estar vacío.';
    codigo.classList.add('input-error', 'is-invalid');
    codigo.classList.remove('is-valid');
    return false;
  }

  if (valor.length < 2 || valor.length > 10) {
    error.innerHTML = 'El código debe tener entre 2 y 10 caracteres.';
    codigo.classList.add('input-error', 'is-invalid');
    codigo.classList.remove('is-valid');
    return false;
  }

  if (!regex.test(valor)) {
    error.innerHTML = 'El código solo puede contener letras, números, % y -.';
    codigo.classList.add('input-error', 'is-invalid');
    codigo.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  codigo.classList.add('input-valid', 'is-valid');
  codigo.classList.remove('is-invalid');
  return true;
}

function validar_nombre_modificado() {
  var nombre = document.getElementById('nombrePromocionEdit');
  var error = document.getElementById('errorNombreEdit');

  error.innerHTML = '';
  nombre.classList.remove('input-error', 'input-valid');

  const regex = /^[a-zA-Z0-9\s\-_%]{5,50}$/;
  var valor = nombre.value.trim();

  if (valor === '') {
    error.innerHTML = 'El nombre no puede estar vacío.';
    nombre.classList.add('input-error', 'is-invalid');
    nombre.classList.remove('is-valid');
    return false;
  }

  if (valor.length < 5 || valor.length > 50) {
    error.innerHTML = 'El nombre debe tener entre 5 y 50 caracteres.';
    nombre.classList.add('input-error', 'is-invalid');
    nombre.classList.remove('is-valid');
    return false;
  }

  if (!regex.test(valor)) {
    error.innerHTML = 'El nombre contiene caracteres no permitidos.';
    nombre.classList.add('input-error', 'is-invalid');
    nombre.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  nombre.classList.add('input-valid', 'is-valid');
  nombre.classList.remove('is-invalid');
  return true;
}

function validar_descripcion_modificado() {
  var descripcion = document.getElementById('descripcionPromocionEdit');
  var error = document.getElementById('errorDescripcionEdit');

  error.innerHTML = '';
  descripcion.classList.remove('input-error', 'input-valid');

  var valor = descripcion.value.trim();

  if (valor === '') {
    error.innerHTML = 'La descripción no puede estar vacía.';
    descripcion.classList.add('input-error', 'is-invalid');
    descripcion.classList.remove('is-valid');
    return false;
  }

  if (valor.length > 200) {
    error.innerHTML = 'La descripción no puede exceder 200 caracteres.';
    descripcion.classList.add('input-error', 'is-invalid');
    descripcion.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  descripcion.classList.add('input-valid', 'is-valid');
  descripcion.classList.remove('is-invalid');
  return true;
}

function validar_tipo_modificado() {
  var tipo = document.getElementById('tipoPromocionEdit');
  var error = document.getElementById('errorTipoEdit');

  error.innerHTML = '';
  tipo.classList.remove('input-error', 'input-valid');

  var valor = tipo.value;
  var tiposPermitidos = ['porcentaje', '2x1', 'monto_fijo'];

  if (valor === '') {
    error.innerHTML = 'Debe seleccionar un tipo de promoción.';
    tipo.classList.add('input-error', 'is-invalid');
    tipo.classList.remove('is-valid');
    return false;
  }

  if (!tiposPermitidos.includes(valor)) {
    error.innerHTML = 'Tipo de promoción inválido.';
    tipo.classList.add('input-error', 'is-invalid');
    tipo.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  tipo.classList.add('input-valid', 'is-valid');
  tipo.classList.remove('is-invalid');
  return true;
}

function validar_valor_modificado() {
  var valor = document.getElementById('valorPromocionEdit');
  var error = document.getElementById('errorValorEdit');
  var tipo = document.getElementById('tipoPromocionEdit').value;

  error.innerHTML = '';
  valor.classList.remove('input-error', 'input-valid');

  var valorNum = parseFloat(valor.value);

  if (isNaN(valorNum) || valor.value.trim() === '') {
    error.innerHTML = 'El valor es requerido.';
    valor.classList.add('input-error', 'is-invalid');
    valor.classList.remove('is-valid');
    return false;
  }

  if (valorNum < 0) {
    error.innerHTML = 'El valor no puede ser negativo.';
    valor.classList.add('input-error', 'is-invalid');
    valor.classList.remove('is-valid');
    return false;
  }

  if (tipo === 'porcentaje' && valorNum > 100) {
    error.innerHTML = 'El porcentaje no puede exceder 100%.';
    valor.classList.add('input-error', 'is-invalid');
    valor.classList.remove('is-valid');
    return false;
  }

  error.innerHTML = '';
  valor.classList.add('input-valid', 'is-valid');
  valor.classList.remove('is-invalid');
  return true;
}

function validar_fechas_modificado() {
  var fechaInicio = document.getElementById('fechaInicioEdit');
  var fechaFin = document.getElementById('fechaFinEdit');
  var errorInicio = document.getElementById('errorFechaInicioEdit');
  var errorFin = document.getElementById('errorFechaFinEdit');

  errorInicio.innerHTML = '';
  errorFin.innerHTML = '';
  fechaInicio.classList.remove('input-error', 'input-valid');
  fechaFin.classList.remove('input-error', 'input-valid');

  var inicio = fechaInicio.value;
  var fin = fechaFin.value;

  if (inicio === '') {
    errorInicio.innerHTML = 'La fecha de inicio es requerida.';
    fechaInicio.classList.add('input-error', 'is-invalid');
    fechaInicio.classList.remove('is-valid');
    return false;
  }

  if (fin === '') {
    errorFin.innerHTML = 'La fecha de fin es requerida.';
    fechaFin.classList.add('input-error', 'is-invalid');
    fechaFin.classList.remove('is-valid');
    return false;
  }

  if (inicio > fin) {
    errorInicio.innerHTML = 'La fecha de inicio no puede ser mayor que la fecha de fin.';
    fechaInicio.classList.add('input-error', 'is-invalid');
    fechaInicio.classList.remove('is-valid');
    return false;
  }

  fechaInicio.classList.add('input-valid', 'is-valid');
  fechaInicio.classList.remove('is-invalid');
  fechaFin.classList.add('input-valid', 'is-valid');
  fechaFin.classList.remove('is-invalid');
  return true;
}

function validar_formulario_modificado() {
  const codigo_valido = validar_codigo_modificado();
  const nombre_valido = validar_nombre_modificado();
  const descripcion_valida = validar_descripcion_modificado();
  const tipo_valido = validar_tipo_modificado();
  const valor_valido = validar_valor_modificado();
  const fechas_validas = validar_fechas_modificado();

  if (codigo_valido && nombre_valido && descripcion_valida && tipo_valido && valor_valido && fechas_validas) {
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

// Función para eliminar promoción
function EliminarPromocion(event, id) {
  event.preventDefault();
  const url = "index.php?url=promociones&action=eliminar&ID=" + id;

  Swal.fire({
    title: '¿Estás seguro?',
    text: "¡Deseas eliminar esta promoción? No podrás revertir esto!",
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
