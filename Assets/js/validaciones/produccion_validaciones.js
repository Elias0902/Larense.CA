// valida motivo de produccion
function validar_motivo() {
    const input = document.getElementById("motivoProduccion");
    const error = document.getElementById("errorMotivo");

    const regex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s\.,:;\-\(\)]*$/; // Permite letras, números, espacios, puntos, comas y guiones

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Debe ingresar el motivo de producción."; 
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }
    if (!regex.test(valor)) {
        error.innerHTML = "El motivo contiene caracteres no permitidos.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }  
    else {
        error.innerHTML = "";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
}

// Validación producto producción
function validar_producto() {
    const select = document.getElementById("productoProduccion");
    const error = document.getElementById("errorProducto");

    const valor = select.value;

    if (valor === "") {
        error.innerHTML = "Debe seleccionar un producto.";
        select.classList.add("is-invalid");
        select.classList.remove("is-valid");
        return false;
    } else {
        error.innerHTML = "";
        select.classList.add("is-valid");
        select.classList.remove("is-invalid");
        return true;
    }
}

// Validación cantidad producto
function validar_cantidad_producto() {
    const input = document.getElementById("cantidadProducto");
    const error = document.getElementById("errorCantidadProducto");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Debe ingresar la cantidad de producto.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    const num = parseInt(valor);

    if (isNaN(num) || num <= 0) {
        error.innerHTML = "La cantidad debe ser un número mayor que cero.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else {
        error.innerHTML = "";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
}

// Validación materia prima producción
function validar_materia() {
    const select = document.getElementById("materiaPrimaProduccion");
    const error = document.getElementById("errorMateria");

    const valor = select.value;

    if (valor === "") {
        error.innerHTML = "Debe seleccionar una materia prima.";
        select.classList.add("is-invalid");
        select.classList.remove("is-valid");
        return true;
    } else {
        error.innerHTML = "";
        select.classList.add("is-valid");
        select.classList.remove("is-invalid");
        return true;
    }
}

// Validación cantidad producción
function validar_cantidad() {
    const input = document.getElementById("cantidadProduccion");
    const error = document.getElementById("errorCantidad");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Debe ingresar la cantidad producida.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    const num = parseInt(valor);

    if (isNaN(num) || num <= 0) {
        error.innerHTML = "La cantidad debe ser un número mayor que cero.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else {
        error.innerHTML = "";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
}

// funcion para validar observacion de la produccion
function validar_observacion() {
    const input = document.getElementById("observacionProduccion");
    const error = document.getElementById("errorObservacion");

    const regex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s\.,:;\-\(\)]*$/; // Permite letras, números, espacios, puntos, comas y guiones

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Debe ingresar una observación.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }
    if (!regex.test(valor)) {
        error.innerHTML = "La observación contiene caracteres no permitidos.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else {
        error.innerHTML = "";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
}

// funcion para la validar la fecha de la produccion
function validar_fecha() {
    const input = document.getElementById("fechaProduccion");
    const error = document.getElementById("errorFecha");

    const valor = input.value.trim();
    
    if (valor === "") {
        error.innerHTML = "Debe ingresar la fecha de producción.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else {
        error.innerHTML = "";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
}

function validar_formulario() {
    const motivo = validar_motivo();
    const producto = validar_producto();
    const cantidad_producto = validar_cantidad_producto();
    const observacion = validar_observacion();
    const fecha = validar_fecha();

    if (producto && cantidad_producto && observacion && fecha && motivo) {
        return true;
    } else {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Formulario con errores, corrija los campos marcados.',
            confirmButtonText: 'Aceptar',
            timer: 6000,
            timerProgressBar: true,
        });
        return false;
    }
}

// valida motivo de produccion
function validar_motivo_modificado() {
    const input = document.getElementById("motivoProduccionEdit");
    const error = document.getElementById("errorMotivoEdit");

    const regex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s\.,:;\-\(\)]*$/; // Permite letras, números, espacios, puntos, comas y guiones

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Debe ingresar el motivo de producción."; 
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }
    if (!regex.test(valor)) {
        error.innerHTML = "El motivo contiene caracteres no permitidos.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }  
    else {
        error.innerHTML = "";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
}

// Validación producto producción
function validar_producto_modificado() {
    const select = document.getElementById("productoProduccionEdit");
    const error = document.getElementById("errorProductoEdit");

    const valor = select.value;

    if (valor === "") {
        error.innerHTML = "Debe seleccionar un producto.";
        select.classList.add("is-invalid");
        select.classList.remove("is-valid");
        return false;
    } else {
        error.innerHTML = "";
        select.classList.add("is-valid");
        select.classList.remove("is-invalid");
        return true;
    }
}

// Validación cantidad producto
function validar_cantidad_producto_modificado() {
    const input = document.getElementById("cantidadProductoEdit");
    const error = document.getElementById("errorCantidadProductoEdit");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Debe ingresar la cantidad de producto.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    const num = parseInt(valor);

    if (isNaN(num) || num <= 0) {
        error.innerHTML = "La cantidad debe ser un número mayor que cero.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else {
        error.innerHTML = "";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
}

// Validación materia prima producción
function validar_materia_prima_modificada() {
    const select = document.getElementById("materiaPrimaEdit");
    const error = document.getElementById("errorMateriaPrimaEdit");

    const valor = select.value;

    if (valor === "") {
        error.innerHTML = "Debe seleccionar una materia prima.";
        select.classList.add("is-invalid");
        select.classList.remove("is-valid");
        return true;
    } else {
        error.innerHTML = "";
        select.classList.add("is-valid");
        select.classList.remove("is-invalid");
        return true;
    }
}

// Validación cantidad producción
function validar_cantidad_modificada() {
    const input = document.getElementById("cantidadProduccionEdit");
    const error = document.getElementById("errorCantidadEdit");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Debe ingresar la cantidad producida.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    const num = parseInt(valor);

    if (isNaN(num) || num <= 0) {
        error.innerHTML = "La cantidad debe ser un número mayor que cero.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else {
        error.innerHTML = "";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
}

// funcion para validar observacion de la produccion
function validar_observacion_modificada() {
    const input = document.getElementById("observacionProduccionEdit");
    const error = document.getElementById("errorObservacionEdit");

    const regex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s\.,:;\-\(\)]*$/; // Permite letras, números, espacios, puntos, comas y guiones

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Debe ingresar una observación.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }
    if (!regex.test(valor)) {
        error.innerHTML = "La observación contiene caracteres no permitidos.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else {
        error.innerHTML = "";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
}

// funcion para la validar la fecha de la produccion
function validar_fecha_modificada() {
    const input = document.getElementById("fechaProduccionEdit");
    const error = document.getElementById("errorFechaEdit");

    const valor = input.value.trim();
    
    if (valor === "") {
        error.innerHTML = "Debe ingresar la fecha de producción.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else {
        error.innerHTML = "";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
}

function validar_formulario_modificado() {
    const motivo = validar_motivo_modificado();
    const producto = validar_producto_modificado();
    const cantidad_producto = validar_cantidad_producto_modificado();
    const observacion = validar_observacion_modificada();
    const fecha = validar_fecha_modificada();

    if (producto && cantidad_producto && observacion && fecha && motivo) {
        return true;
    } else {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Formulario con errores, corrija los campos marcados.',
            confirmButtonText: 'Aceptar',
            timer: 6000,
            timerProgressBar: true,
        });
        return false;
    }
}

function EliminarProduccion(event, id) {
    // Evitar navegación inmediata
    event.preventDefault();
    
    // Se establece URL del enlace
    const url = "index.php?url=producciones&action=eliminar&ID=" + id;
    
    // Confirmación de la acción
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Deseas eliminar la producción. No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si confirma, redirige a la URL
            window.location.href = url;
        } else {
            // Manejar la cancelación
            Swal.fire({
                title: 'Cancelado',
                text: 'Se canceló la acción.',
                icon: 'info',
                timer: 1800,
                timerProgressBar: true,
            });
        }
    });
    return false;
}