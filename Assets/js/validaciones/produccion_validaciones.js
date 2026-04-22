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

function validar_formulario() {
    const producto = validar_producto();
    const cantidad = validar_cantidad();

    if (producto && cantidad) {
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

// Validación producto producción (modificar)
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

// Validación cantidad producción (modificar)
function validar_cantidad_modificado() {
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

function validar_formulario_modificado() {
    const producto = validar_producto_modificado();
    const cantidad = validar_cantidad_modificado();

    if (producto && cantidad) {
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
