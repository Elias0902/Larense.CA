
function validar_monto() {
    var monto = document.getElementById('montoPago');
    var error = document.getElementById('errorMontoPago');

    error.innerHTML = '';
    monto.classList.remove('input-error', 'input-valid', 'is-invalid', 'is-valid');

    var valor = monto.value.trim();

    if (valor === '') {
        error.innerHTML = 'El monto es requerido.';
        monto.classList.add('input-error', 'is-invalid');
        return false;
    }

    var valorNum = parseFloat(valor);
    if (isNaN(valorNum) || valorNum <= 0) {
        error.innerHTML = 'El monto debe ser mayor a 0.';
        monto.classList.add('input-error', 'is-invalid');
        return false;
    }

    var partes = valor.split('.');
    if (partes.length > 1 && partes[1].length > 2) {
        error.innerHTML = 'Máximo 2 decimales permitidos.';
        monto.classList.add('input-error', 'is-invalid');
        return false;
    }

    monto.classList.add('input-valid', 'is-valid');
    return true;
}

function validar_fecha() {
    var fecha = document.getElementById('fechaPago');
    var error = document.getElementById('errorFechaPago');

    error.innerHTML = '';
    fecha.classList.remove('input-error', 'input-valid', 'is-invalid', 'is-valid');

    var valor = fecha.value;

    if (valor === '') {
        error.innerHTML = 'La fecha es requerida.';
        fecha.classList.add('input-error', 'is-invalid');
        return false;
    }

    fecha.classList.add('input-valid', 'is-valid');
    return true;
}

function validar_nroReferencia() {
    var nroRef = document.getElementById('nroReferencia');
    var error = document.getElementById('errorNroReferencia');

    error.innerHTML = '';
    nroRef.classList.remove('input-error', 'input-valid', 'is-invalid', 'is-valid');

    var valor = nroRef.value.trim();

    if (valor === '') {
        error.innerHTML = 'El número de referencia es requerido.';
        nroRef.classList.add('input-error', 'is-invalid');
        return false;
    }

    if (!/^\d{1,11}$/.test(valor)) {
        error.innerHTML = 'Debe ser un número de hasta 11 dígitos.';
        nroRef.classList.add('input-error', 'is-invalid');
        return false;
    }

    nroRef.classList.add('input-valid', 'is-valid');
    return true;
}

function validar_concepto() {
    var descripcion = document.getElementById('concepto');
    var error = document.getElementById('errorConcepto');

    error.innerHTML = '';
    descripcion.classList.remove('input-error', 'input-valid', 'is-invalid', 'is-valid');

    var valor = descripcion.value.trim();

    if (valor === '') {
        error.innerHTML = 'La descripción es requerida.';
        descripcion.classList.add('input-error', 'is-invalid');
        return false;
    }

    if (valor.length > 300) {
        error.innerHTML = 'Máximo 300 caracteres.';
        descripcion.classList.add('input-error', 'is-invalid');
        return false;
    }

    descripcion.classList.add('input-valid', 'is-valid');
    return true;
}

function validar_metodo() {
    var metodo = document.getElementById('metodoPago');
    var error = document.getElementById('errorMetodoPago');

    error.innerHTML = '';
    metodo.classList.remove('input-error', 'input-valid', 'is-invalid', 'is-valid');

    if (metodo.value === '' || metodo.value === null || metodo.selectedIndex === 0) {
        error.innerHTML = 'Seleccione un método de pago.';
        metodo.classList.add('input-error', 'is-invalid');
        return false;
    }

    metodo.classList.add('input-valid', 'is-valid');
    return true;
}

function validar_formulario() {
    const monto_valido = validar_monto();
    const fecha_valida = validar_fecha();
    const metodo_valido = validar_metodo();
    const referencia_valida = validar_nroReferencia();
    const descripcion_valida = validar_concepto();

    // Fecha por defecto
    var fechaInput = document.getElementById('fechaPago');
    if (fechaInput.value === '') {
        var today = new Date().toISOString().split('T')[0];
        fechaInput.value = today;
        validar_fecha();
    }

    if (monto_valido && fecha_valida && metodo_valido && referencia_valida && descripcion_valida) {
        return true;
    } else {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Por favor corrige los campos marcados.',
            confirmButtonText: 'Aceptar',
            timer: 6000,
            timerProgressBar: true,
        });
        return false;
    }
}


// Establecer fechas por defecto al cargar
document.addEventListener('DOMContentLoaded', function() {
  var fechaEmisionInput = document.getElementById('fechaPago');
  
  if (fechaEmisionInput) {
    var today = new Date().toISOString().split('T')[0];
    fechaEmisionInput.value = today;
  }
});
