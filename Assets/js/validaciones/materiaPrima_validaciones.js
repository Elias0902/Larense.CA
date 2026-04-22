// Validación nombre materia prima
function validar_nombre() {
    const input = document.getElementById("nombreMateriaPrima");
    const error = document.getElementById("errorMateriaPrima");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Debe ingresar un nombre de materia prima.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else if (valor.length < 3 || valor.length > 100) {
        error.innerHTML = "El nombre debe tener entre 3 y 100 caracteres.";
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

// Validación descripción materia prima
function validar_descripcion() {
    const input = document.getElementById("descripcionMateriaPrima");
    const error = document.getElementById("errorDescripcion");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Debe ingresar una descripción.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else if (valor.length < 5 || valor.length > 255) {
        error.innerHTML = "La descripción debe tener entre 5 y 255 caracteres.";
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

// Validación stock materia prima
function validar_stock() {
    const input = document.getElementById("stockMateriaPrima");
    const error = document.getElementById("errorStock");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Debe ingresar el stock.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    const num = parseFloat(valor);

    if (isNaN(num) || num < 0) {
        error.innerHTML = "El stock debe ser un número no negativo.";
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

// Validación unidad de medida
function validar_unidad_medida() {
    const select = document.getElementById("unidadMedida");
    const error = document.getElementById("errorMedida");

    const valor = select.value;

    if (valor === "") {
        error.innerHTML = "Debe seleccionar una unidad de medida.";
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

// Validación proveedor
function validar_proveedor() {
    const select = document.getElementById("proveedorMateriaPrima");
    const error = document.getElementById("errorProveedor");

    const valor = select.value;

    if (valor === "") {
        error.innerHTML = "Debe seleccionar un proveedor.";
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

function validar_formulario() {
    const nombre = validar_nombre();
    const descripcion = validar_descripcion();
    const stock = validar_stock();
    const unidad = validar_unidad_medida();
    const proveedor = validar_proveedor();

    if (nombre && descripcion && stock && unidad && proveedor) {
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

// Validación nombre materia prima (modificar)
function validar_nombre_modificado() {
    const input = document.getElementById("nombreMateriaPrimaEdit");
    const error = document.getElementById("errorMateriaPrimaEdit");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Debe ingresar un nombre de materia prima.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else if (valor.length < 3 || valor.length > 100) {
        error.innerHTML = "El nombre debe tener entre 3 y 100 caracteres.";
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

// Validación descripción materia prima (modificar)
function validar_descripcion_modificado() {
    const input = document.getElementById("descripcionMateriaPrimaEdit");
    const error = document.getElementById("errorDescripcionEdit");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Debe ingresar una descripción.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else if (valor.length < 5 || valor.length > 255) {
        error.innerHTML = "La descripción debe tener entre 5 y 255 caracteres.";
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

// Validación stock materia prima (modificar)
function validar_stock_modificado() {
    const input = document.getElementById("stockMateriaPrimaEdit");
    const error = document.getElementById("errorStockEdit");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Debe ingresar el stock.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    const num = parseFloat(valor);

    if (isNaN(num) || num < 0) {
        error.innerHTML = "El stock debe ser un número no negativo.";
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

// Validación unidad de medida (modificar)
function validar_unidad_medida_modificado() {
    const select = document.getElementById("unidadMedidaEdit");
    const error = document.getElementById("errorMedidaEdit");

    const valor = select.value;

    if (valor === "") {
        error.innerHTML = "Debe seleccionar una unidad de medida.";
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

// Validación proveedor (modificar)
function validar_proveedor_modificado() {
    const select = document.getElementById("proveedorMateriaPrimaEdit");
    const error = document.getElementById("errorProveedorEdit");

    const valor = select.value;

    if (valor === "") {
        error.innerHTML = "Debe seleccionar un proveedor.";
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

function validar_formulario_modificado() {
    const nombre = validar_nombre_modificado();
    const descripcion = validar_descripcion_modificado();
    const stock = validar_stock_modificado();
    const unidad = validar_unidad_medida_modificado();
    const proveedor = validar_proveedor_modificado();

    if (nombre && descripcion && stock && unidad && proveedor) {
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

function EliminarMateriaPrima(event, id) {
    // Evitar navegación inmediata
    event.preventDefault();
    
    // Se establece URL del enlace
    const url = "index.php?url=materias_primas&action=eliminar&ID=" + id;
    
    // Confirmación de la acción
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Deseas eliminar la materia prima. No podrás revertir esto!",
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