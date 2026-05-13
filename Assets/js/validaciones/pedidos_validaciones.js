// Función para validar proveedor
function validar_proveedor() {
    var proveedor = document.getElementById('proveedorId');
    var error = document.getElementById('errorProveedor');

    error.innerHTML = '';
    proveedor.classList.remove('input-error', 'input-valid', 'is-invalid', 'is-valid');

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
    
    // Cargar materias primas al seleccionar proveedor
    cargarMateriasPrimasPorProveedor();
    return true;
}

// Función para validar días crédito
function validar_dias_credito() {
    var diasCredito = document.getElementById('diasCredito');
    var error = document.getElementById('errorCredito');

    error.innerHTML = '';
    diasCredito.classList.remove('input-error', 'input-valid', 'is-invalid', 'is-valid');

    var valor = diasCredito.value;

    if (valor === '') {
        error.innerHTML = 'Los días crédito son requeridos.';
        diasCredito.classList.add('input-error', 'is-invalid');
        diasCredito.classList.remove('is-valid');
        return false;
    }

    if (parseInt(valor) < 0) {
        error.innerHTML = 'Los días crédito no pueden ser negativos.';
        diasCredito.classList.add('input-error', 'is-invalid');
        diasCredito.classList.remove('is-valid');
        return false;
    }

    error.innerHTML = '';
    diasCredito.classList.add('input-valid', 'is-valid');
    diasCredito.classList.remove('is-invalid');
    return true;
}

// Función para validar fecha
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

    // Validar que la fecha no sea futura (opcional)
    var fechaActual = new Date().toISOString().split('T')[0];
    if (valor > fechaActual) {
        error.innerHTML = 'La fecha no puede ser futura.';
        fecha.classList.add('input-error', 'is-invalid');
        fecha.classList.remove('is-valid');
        return false;
    }

    error.innerHTML = '';
    fecha.classList.add('input-valid', 'is-valid');
    fecha.classList.remove('is-invalid');
    return true;
}

// Función para validar materia prima seleccionada
function validar_materiaPrima() {
    var materiaPrima = document.getElementById('materiasPrimas');
    var error = document.getElementById('errorMateriaPrima');

    error.innerHTML = '';
    materiaPrima.classList.remove('input-error', 'input-valid', 'is-invalid', 'is-valid');

    var valor = materiaPrima.value;

    if (valor === '') {
        error.innerHTML = 'Debe seleccionar una materia prima.';
        materiaPrima.classList.add('input-error', 'is-invalid');
        materiaPrima.classList.remove('is-valid');
        return false;
    }

    error.innerHTML = '';
    materiaPrima.classList.add('input-valid', 'is-valid');
    materiaPrima.classList.remove('is-invalid');
    return true;
}

// Función para validar cantidad
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

    if (!/^\d+(\.\d+)?$/.test(valor)) {
        error.innerHTML = 'Ingrese una cantidad válida.';
        cantidad.classList.add('input-error', 'is-invalid');
        cantidad.classList.remove('is-valid');
        return false;
    }

    error.innerHTML = '';
    cantidad.classList.add('input-valid', 'is-valid');
    cantidad.classList.remove('is-invalid');
    return true;
}

// Función para validar precio
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

    // Validar máximo 2 decimales
    var partes = valor.toString().split('.');
    if (partes.length > 1 && partes[1].length > 2) {
        error.innerHTML = 'Máximo 2 decimales permitidos.';
        precio.classList.add('input-error', 'is-invalid');
        precio.classList.remove('is-valid');
        return false;
    }

    error.innerHTML = '';
    precio.classList.add('input-valid', 'is-valid');
    precio.classList.remove('is-invalid');
    return true;
}

// Función para validar subtotal
function validar_subtotal() {
    var subtotal = document.getElementById('subtotal');
    var error = document.getElementById('errorSubtotal');

    error.innerHTML = '';
    subtotal.classList.remove('input-error', 'input-valid', 'is-invalid', 'is-valid');

    var valor = subtotal.value;

    if (valor === '' || parseFloat(valor) <= 0) {
        error.innerHTML = 'El subtotal debe ser mayor a 0.';
        subtotal.classList.add('input-error', 'is-invalid');
        subtotal.classList.remove('is-valid');
        return false;
    }

    error.innerHTML = '';
    subtotal.classList.add('input-valid', 'is-valid');
    subtotal.classList.remove('is-invalid');
    return true;
}

// Función para validar total
function validar_total() {
    var total = document.getElementById('total');
    var error = document.getElementById('errorTotal');

    error.innerHTML = '';
    total.classList.remove('input-error', 'input-valid', 'is-invalid', 'is-valid');

    var valor = total.value;

    if (valor === '' || parseFloat(valor) <= 0) {
        error.innerHTML = 'El total debe ser mayor a 0.';
        total.classList.add('input-error', 'is-invalid');
        total.classList.remove('is-valid');
        return false;
    }

    // Validar máximo 2 decimales
    var partes = valor.toString().split('.');
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

// Función para validar observaciones
function validar_observaciones() {
    var observaciones = document.getElementById('observacionesCompra');
    var error = document.getElementById('errorObservaciones');

    error.innerHTML = '';
    observaciones.classList.remove('input-error', 'input-valid', 'is-invalid', 'is-valid');

    var valor = observaciones.value.trim();

    if (valor.length > 500) {
        error.innerHTML = 'Las observaciones no pueden exceder 500 caracteres.';
        observaciones.classList.add('input-error', 'is-invalid');
        observaciones.classList.remove('is-valid');
        return false;
    }

    error.innerHTML = '';
    if (valor !== '') {
        observaciones.classList.add('input-valid', 'is-valid');
    }
    observaciones.classList.remove('is-invalid');
    return true;
}

// Función para validar que haya al menos una materia prima agregada
function validar_materias_agregadas() {
    if (materiasPrimasAgregadas.length === 0) {
        mostrarAlerta('Debe agregar al menos una materia prima', 'warning');
        return false;
    }
    return true;
}

// Función principal de validación del formulario
function validar_formulario() {
    const proveedor_valido = validar_proveedor();
    const dias_credito_valido = validar_dias_credito();
    const fecha_valida = validar_fecha();
    const observaciones_validas = validar_observaciones();
    const materias_validas = validar_materias_agregadas();
    const subtotal_valido = validar_subtotal();
    const total_valido = validar_total();

    // Establecer fecha por defecto si está vacía
    var fechaInput = document.getElementById('fechaCompra');
    if (fechaInput.value === '') {
        var today = new Date().toISOString().split('T')[0];
        fechaInput.value = today;
        validar_fecha();
    }

    // Establecer días crédito por defecto si está vacío
    var diasCreditoInput = document.getElementById('diasCredito');
    if (diasCreditoInput.value === '') {
        diasCreditoInput.value = 0;
        validar_dias_credito();
    }

    if (proveedor_valido && dias_credito_valido && fecha_valida && observaciones_validas && materias_validas && subtotal_valido && total_valido) {
        // Crear inputs ocultos para enviar las materias primas
        crearInputsMateriasPrimas();
        return true;
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Error de validación',
            text: 'Por favor corrija los campos marcados en rojo y asegúrese de agregar al menos una materia prima.',
            confirmButtonText: 'Aceptar',
            timer: 5000,
            timerProgressBar: true,
        });
        return false;
    }
}

// Función para limpiar validaciones al cerrar el modal
function limpiar_validaciones() {
    // Limpiar clases de validación de todos los campos
    const inputs = document.querySelectorAll('#formPedido input, #formPedido select, #formPedido textarea');
    inputs.forEach(input => {
        input.classList.remove('is-valid', 'is-invalid', 'input-valid', 'input-error');
    });
    
    // Limpiar mensajes de error
    const errores = document.querySelectorAll('[id^="error"]');
    errores.forEach(error => {
        error.innerHTML = '';
    });
}

// Event listener para limpiar validaciones al cerrar el modal
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('compraModal');
    if (modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            limpiar_validaciones();
            // Reiniciar variables globales
            materiasPrimasAgregadas = [];
            const tabla = document.getElementById('tablaMateriasPrimas');
            if (tabla) tabla.remove();
        });
    }
    
    // Event listeners para validación en tiempo real
    const proveedorSelect = document.getElementById('proveedorId');
    if (proveedorSelect) {
        proveedorSelect.addEventListener('change', validar_proveedor);
        proveedorSelect.addEventListener('blur', validar_proveedor);
    }
    
    const diasCreditoInput = document.getElementById('diasCredito');
    if (diasCreditoInput) {
        diasCreditoInput.addEventListener('input', validar_dias_credito);
        diasCreditoInput.addEventListener('blur', validar_dias_credito);
    }
    
    const fechaInput = document.getElementById('fechaCompra');
    if (fechaInput) {
        fechaInput.addEventListener('input', validar_fecha);
        fechaInput.addEventListener('blur', validar_fecha);
    }
    
    const observacionesTextarea = document.getElementById('observacionesCompra');
    if (observacionesTextarea) {
        observacionesTextarea.addEventListener('input', validar_observaciones);
        observacionesTextarea.addEventListener('blur', validar_observaciones);
    }
});

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

function validar_producto() {
  var producto = document.getElementById('productosEdit');
  var error = document.getElementById('errorProductoEdit');

  error.innerHTML = '';
  producto.classList.remove('input-error', 'input-valid', 'is-invalid', 'is-valid');

  var valor = producto.value;

  if (valor === '') {
    error.innerHTML = 'Debe seleccionar un producto.';
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
  var cantidad = document.getElementById('cantidadProductoEdit');
  var error = document.getElementById('errorCantidadEdit');

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

function validar_precioEdit() {
  var precio = document.getElementById('precioProductoEdit');
  var error = document.getElementById('errorPrecioEdit');

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

function validar_formulario_modificado() {
  const cliente_valido = validar_cliente_modificado();
  const fecha_valida = validar_fecha_modificado();
  const telefono_valido = validar_telefono_modificado();
  const direccion_valida = validar_direccion_modificado();
  const observaciones_validas = validar_observaciones_modificado();

  if (cliente_valido && fecha_valida && telefono_valido && direccion_valida && observaciones_validas) {
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

// funcion que cambia el estado
function CambiarEstadoPedido(id, nuevoEstado) {

  Swal.fire({
    title: '¿Cambiar Estado?',
    text: `¿Deseas cambiar el estado del pedido"?`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Sí, cambiar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      // Crear formulario temporal para enviar POST
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = 'index.php?url=pedidos&action=cambiar_estado';
      
      const inputId = document.createElement('input');
      inputId.type = 'hidden';
      inputId.name = 'id';
      inputId.value = id;
      
      const inputEstado = document.createElement('input');
      inputEstado.type = 'hidden';
      inputEstado.name = 'nuevo_estado';
      inputEstado.value = nuevoEstado;
      
      form.appendChild(inputId);
      form.appendChild(inputEstado);
      document.body.appendChild(form);
      form.submit();
    }
  });
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
