function validar_nombre() {
    var nombre = document.getElementById('nombreTipoCliente');
    var error = document.getElementById('errorTipoCliente');
    var icono = document.getElementById('icono-validacionTipoCliente');
    
    // Si no existe icono, créalo
    if (!icono) {
        icono = document.createElement('span');
        icono.id = 'icono-validacionTipoCliente';
        error.parentNode.appendChild(icono);
    }
    
    error.textContent = ''; // limpia el mensaje
    icono.innerHTML = ''; // limpia el icono
    nombre.classList.remove('input-error', 'input-valid');
    icono.classList.remove('error');

    const regex = /^[a-zA-Z\s]+$/;
    var valor = nombre.value.trim();

    // si el nombre esta vacio
    if (valor === '') {
        error.textContent = 'Este campo no puede estar vacío.';
        nombre.classList.add('input-error');
        icono.classList.add('error');
        nombre.classList.add('is-invalid');
        nombre.classList.remove('is-valid');
        return false;
    }

    // valida longitud
    if (valor.length < 3 || valor.length > 30) {
        error.textContent = 'El nombre debe tener entre 3 y 30 caracteres.';
        nombre.classList.add('input-error');
        icono.classList.add('error');
        nombre.classList.add('is-invalid');
        nombre.classList.remove('is-valid');
        return false;
    }

    // valida formato
    if (!regex.test(valor)) {
        error.textContent = "Solo letras y espacios. Ej: Cliente Mayorista";
        nombre.classList.add('input-error');
        icono.classList.add('error');
        nombre.classList.add('is-invalid');
        nombre.classList.remove('is-valid');
        return false;
    }

    // ✓ Válido
    error.textContent = '';
    nombre.classList.add('input-valid');
    icono.classList.remove('error');
    nombre.classList.add('is-valid');
    nombre.classList.remove('is-invalid');
    return true;
}

function validar_diaCreditos() {
    var input = document.getElementById('diaCreditos');
    var error = document.getElementById('errorDiaCreditos');
    var icono = document.getElementById('icono-validacionDiaCreditos');
    
    // Crea icono si no existe
    if (!icono) {
        icono = document.createElement('span');
        icono.id = 'icono-validacionDiaCreditos';
        error.parentNode.appendChild(icono);
    }
    
    error.textContent = '';
    icono.innerHTML = '';
    input.classList.remove('input-error', 'input-valid');
    icono.classList.remove('error');

    var valor = input.value.trim();

    // Vacío
    if (valor === '') {
        error.textContent = 'Debe ingresar los días de crédito.';
        input.classList.add('input-error');
        icono.classList.add('error');
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        return false;
    }

    // Solo números
    if (!/^\d+$/.test(valor)) {
        error.textContent = 'Solo números enteros.';
        input.classList.add('input-error');
        icono.classList.add('error');
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        return false;
    }

    var dias = parseInt(valor);
    // Rango lógico: 7 a 90 días
    if (dias < 7 || dias > 90) {
        error.textContent = 'Días entre 7 y 90.';
        input.classList.add('input-error');
        icono.classList.add('error');
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        return false;
    }

    // ✓ Válido
    error.textContent = '';
    input.classList.add('input-valid');
    icono.classList.remove('error');
    input.classList.add('is-valid');
    input.classList.remove('is-invalid');
    return true;
}

function validar_formulario() {
    const nombre_valido = validar_nombre();
    const dias_validos = validar_diaCreditos();

    if (nombre_valido && dias_validos) {
        return true; // Envía el form
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

function validar_nombre_modificado() {
    var nombre = document.getElementById('nombreTipoClienteEdit');
    var error = document.getElementById('errorTipoClienteEdit');
    var icono = document.getElementById('icono-validacionTipoClienteEdit');
    
    // Crea icono si no existe
    if (!icono) {
        icono = document.createElement('span');
        icono.id = 'icono-validacionTipoClienteEdit';
        error.parentNode.appendChild(icono);
    }
    
    error.textContent = ''; // limpia el mensaje
    icono.innerHTML = ''; // limpia el icono
    nombre.classList.remove('input-error', 'input-valid');
    icono.classList.remove('error');

    const regex = /^[a-zA-Z\s]+$/;
    var valor = nombre.value.trim();

    // si el nombre esta vacio
    if (valor === '') {
        error.textContent = 'Este campo no puede estar vacío.';
        nombre.classList.add('input-error');
        icono.classList.add('error');
        nombre.classList.add('is-invalid');
        nombre.classList.remove('is-valid');
        return false;
    }

    // valida longitud
    if (valor.length < 3 || valor.length > 30) {
        error.textContent = 'El nombre debe tener entre 3 y 30 caracteres.';
        nombre.classList.add('input-error');
        icono.classList.add('error');
        nombre.classList.add('is-invalid');
        nombre.classList.remove('is-valid');
        return false;
    }

    // valida formato
    if (!regex.test(valor)) {
        error.textContent = "Solo letras y espacios. Ej: Cliente Mayorista";
        nombre.classList.add('input-error');

        icono.classList.add('error');
        nombre.classList.add('is-invalid');
        nombre.classList.remove('is-valid');
        return false;
    }

    // ✓ Válido
    error.textContent = '';
    nombre.classList.add('input-valid');
    icono.classList.remove('error');
    nombre.classList.add('is-valid');
    nombre.classList.remove('is-invalid');
    return true;
}

function validar_diaCreditos_modificado() {
    var input = document.getElementById('diaCreditosEdit');
    var error = document.getElementById('errorDiaCreditosEdit');
    var icono = document.getElementById('icono-validacionDiaCreditosEdit');
    
    // Crea icono si no existe
    if (!icono) {
        icono = document.createElement('span');
        icono.id = 'icono-validacionDiaCreditosEdit';
        error.parentNode.appendChild(icono);
    }
    
    error.textContent = '';
    icono.innerHTML = '';
    input.classList.remove('input-error', 'input-valid');
    icono.classList.remove('error');

    var valor = input.value.trim();

    // Vacío
    if (valor === '') {
        error.textContent = 'Debe ingresar los días de crédito.';
        input.classList.add('input-error');

        icono.classList.add('error');
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        return false;
    }

    // Solo números
    if (!/^\d+$/.test(valor)) {
        error.textContent = 'Solo números enteros.';
        input.classList.add('input-error');
        icono.classList.add('error');
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        return false;
    }

    var dias = parseInt(valor);
    // Rango: 7 a 90 días
    if (dias < 7 || dias > 90) {
        error.textContent = 'Días entre 7 y 90.';
        input.classList.add('input-error');
        icono.classList.add('error');
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        return false;
    }

    // ✓ Válido
    error.textContent = '';
    input.classList.add('input-valid');
    icono.classList.remove('error');
    input.classList.add('is-valid');
    input.classList.remove('is-invalid');
    return true;
}

function validar_formulario_modificado() {
    const nombre_valido = validar_nombre_modificado();
    const dias_validos = validar_diaCreditos_modificado();

    if (nombre_valido && dias_validos) {
        return true; // Envía el form
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

// funcion para validar si quiere eliminar el registro
function EliminarTipoCliente(event, id){

  // evitar navegación inmediata
  event.preventDefault(); 

  // se establece URL del enlace
  const url = "index.php?url=tipos_clientes&action=eliminar&ID=" + id; 

  // confirmacion de la accion
  Swal.fire({
  title: '¿Estás seguro?',
  text: "¡Deseas eliminar el tipo de cliente. No podrás revertir esto!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Sí, eliminar',
  cancelButtonText: 'Cancelar'
}).then((result) => {
  if (result.isConfirmed) {

    // Si confirma, redirige a la URL
      window.location.href = url;
  } 
  else {

    // Aquíse manejar la cancelación si lo deseas
    Swal.fire({
      title: 'Cancelado',
      text: 'Se cancelo la accion.',
      icon: 'info',
      timer: 1800,
      timerProgressBar: true,
    });
  }
});

}