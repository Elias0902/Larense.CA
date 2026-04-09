function validar_tipo_id() {
    const select = document.getElementById("tipo_id");
    const error = document.getElementById("errorTipoId");
    const icono = document.getElementById("icono-validacionTipoId");

    const valor = select.value;

    if (valor === "") {
        error.textContent = "Debe seleccionar un tipo de RIF.";
        icono.innerHTML = "❌";
        select.classList.add("is-invalid");
        select.classList.remove("is-valid");
        return false;
    } else {
        error.textContent = "";
        icono.innerHTML = "✔️";
        select.classList.add("is-valid");
        select.classList.remove("is-invalid");
        return true;
    }
}

function validar_id_proveedor() {
    const input = document.getElementById("id_proveedor");
    const error = document.getElementById("errorIdProveedor");
    const icono = document.getElementById("icono-validacionIdProveedor");

    const valor = input.value.trim();

    if (valor === "" || valor.length < 8 || valor.length > 9) {
        error.textContent = "Debe contener entre 8 y 9 caracteres.";
        icono.innerHTML = "❌";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    else {
        error.textContent = "";
        icono.innerHTML = "✔️";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
}

function validar_nombre() {
    const input = document.getElementById("nombreProveedor");
    const error = document.getElementById("errornombreProveedor");
    const icono = document.getElementById("icono-validacionNombreProveedor");

    const valor = input.value.trim();
    const regex_nombre = /^[a-zA-Z]+(?:\s+[a-zA-Z0-9]+)*$/;

    if (valor === "" || !regex_nombre.test(valor)) {
        error.textContent = "Debe ingresar un nombre de proveedor válido.";
        icono.innerHTML = "❌";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else if (valor.length < 3 || valor.length > 100) {
        error.textContent = "El nombre debe tener entre 3 y 100 caracteres.";
        icono.innerHTML = "❌";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else {
        error.textContent = "";
        icono.innerHTML = "✔️";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
}

function validar_direccion() {
    const input = document.getElementById("direccionProveedor");
    const error = document.getElementById("errorDireccionProveedor");
    const icono = document.getElementById("icono-validacionDireccionProveedor");

    const valor = input.value.trim();

    if (valor === "") {
        error.textContent = "Debe ingresar la dirección del proveedor.";
        icono.innerHTML = "❌";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else if (valor.length < 5 || valor.length > 200) {
        error.textContent = "La dirección debe tener entre 5 y 200 caracteres.";
        icono.innerHTML = "❌";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else {
        error.textContent = "";
        icono.innerHTML = "✔️";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
}

function validar_telefono() {
    const input = document.getElementById("tlfProveedor");
    const error = document.getElementById("errorTlfProveedor");
    const icono = document.getElementById("icono-validacionTlfProveedor");

    const valor = input.value.trim();

    if (valor === "") {
        error.textContent = "Debe ingresar el teléfono del proveedor.";
        icono.innerHTML = "❌";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    // Teléfono venezolano: 11 dígitos (0424-XXX-XXXX) o 10 dígitos
    const telefonoRegex = /^(0251|0212|0412|0414|0416|0422|0424|0426)\d{7}$/;
    if (!telefonoRegex.test(valor) && !(valor.length === 10 || valor.length === 11)) {
        error.textContent = "Teléfono inválido. Use formato 0424XXXXXXXXX o 10-11 dígitos.";
        icono.innerHTML = "❌";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else {
        error.textContent = "";
        icono.innerHTML = "✔️";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
}

function validar_email() {
    const input = document.getElementById("emailProveedor");
    const error = document.getElementById("errorEmailProveedor");
    const icono = document.getElementById("icono-validacionEmailProveedor");

    const valor = input.value.trim();

    if (valor === "") {
        error.textContent = "Debe ingresar el email del proveedor.";
        icono.innerHTML = "❌";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(valor)) {
        error.textContent = "El email debe tener un formato válido.";
        icono.innerHTML = "❌";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else {
        error.textContent = "";
        icono.innerHTML = "✔️";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
}

// VALIDACIÓN GLOBAL DEL FORMULARIO PROVEEDOR
function validar_formulario() {

    const validaciones = [
        validar_tipo_id(),
        validar_id_proveedor(),
        validar_nombre(),
        validar_direccion(),
        validar_telefono(),
        validar_email()
    ];

    if (validaciones.every(Boolean)) {
        return true;
    } else {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Corrija los campos marcados en rojo.',
        });
        return false;
    }
}

//TIPO ID (select)
function validar_tipo_id_modificado() {
    const select = document.getElementById("tipo_idEdit");
    const error = document.getElementById("errorTipoIdEdit");

    if (!select || !error) return true; // Si no existen, pasa

    const valor = select.value;
    if (valor === "") {
        error.textContent = "Debe seleccionar un tipo de RIF.";
        select.classList.add("is-invalid");
        select.classList.remove("is-valid");
        return false;
    } else {
        error.textContent = "";
        select.classList.add("is-valid");
        select.classList.remove("is-invalid");
        return true;
    }
}

//RIF Proveedor
function validar_id_proveedor_modificado() {
    const input = document.getElementById("id_proveedorEdit");
    const error = document.getElementById("errorIdProveedorEdit");

    if (!input || !error) return true;

    const valor = input.value.trim();
    if (valor === "" || valor.length < 8 || valor.length > 9) {
        error.textContent = "Debe contener entre 8 y 9 caracteres.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else {
        error.textContent = "";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
}

//Nombre Proveedor
function validar_nombre_modificado() {
    const input = document.getElementById("nombreProveedorEdit");
    const error = document.getElementById("errorProveedorEdit");

    if (!input || !error) return true;

    const valor = input.value.trim();
    const regex_nombre = /^[a-zA-Z]+(?:\s+[a-zA-Z0-9]+)*$/;

    if (valor === "" || !regex_nombre.test(valor)) {
        error.textContent = "Debe ingresar un nombre válido.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else if (valor.length < 3 || valor.length > 100) {
        error.textContent = "Entre 3 y 100 caracteres.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else {
        error.textContent = "";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
}

//Dirección
function validar_direccion_modificada() {
    const input = document.getElementById("direccionProveedorEdit");
    const error = document.getElementById("errorDireccionProveedorEdit");

    if (!input || !error) return true;

    const valor = input.value.trim();
    if (valor === "" || valor.length < 5 || valor.length > 200) {
        error.textContent = "Dirección entre 5 y 200 caracteres.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else {
        error.textContent = "";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
}

// TELÉFONO VENEZOLANO (tu ejemplo 02513213495)
function validar_telefono_modificado() {
    const input = document.getElementById("tlfProveedorEdit");
    const error = document.getElementById("errorTlfProveedorEdit");

    if (!input || !error) return true;

    const valor = input.value.trim();
    if (valor === "") {
        error.textContent = "Debe ingresar el teléfono.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    // Regex para Venezuela: 10-11 dígitos, 0251, 0412, etc.
    const telefonoRegex = /^(0251|0212|0412|0414|0416|0422|0424|0426)\d{7}$/;
    if (!telefonoRegex.test(valor.replace(/[^\d+]/g, ''))) {
        error.textContent = "Teléfono inválido (ej: 02513213495, 04121234567)";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else {
        error.textContent = "";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
}

//Email
function validar_email_modificado() {
    const input = document.getElementById("emailProveedorEdit");
    const error = document.getElementById("errorEmailProveedorEdit");

    if (!input || !error) return true;

    const valor = input.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (valor === "" || !emailRegex.test(valor)) {
        error.textContent = "Email inválido.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else {
        error.textContent = "";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
}

// VALIDACIÓN GLOBAL MODIFICAR
function validar_formulario_modificado() {
    const validaciones = [
        validar_tipo_id_modificado(),
        validar_id_proveedor_modificado(),
        validar_nombre_modificado(),
        validar_direccion_modificada(),
        validar_telefono_modificado(),
        validar_email_modificado()
    ];

    if (validaciones.every(Boolean)) {
        return true;
    } else {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Corrija los campos marcados en rojo.',
        });
        return false;
    }
}

function EliminarProveedor(event, id) {
    // Evitar navegación inmediata
    event.preventDefault();
    
    // Se establece URL del enlace
    const url = "index.php?url=proveedores&action=eliminar&ID=" + id;
    //console.log(id);
    
    // Confirmación de la acción
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Deseas eliminar el proveedor. No podrás revertir esto!",
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