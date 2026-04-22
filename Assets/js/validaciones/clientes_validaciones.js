// VALIDACIONES COMPLETAS PARA FORMULARIO DE CLIENTES

function validar_tipo_rif() {
    const select = document.getElementById("tipo_id");
    const error = document.getElementById("errorRif");

    const tipo = select.value.trim();
    
    if (tipo === "") {
        error.innerHTML = "Seleccione el tipo de RIF.";
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

function validar_rif() {
    const tipoInput = document.getElementById("tipo_id");
    const input = document.getElementById("rifCliente");
    const error = document.getElementById("errorRif");

    const tipo = tipoInput.value.trim();
    const valor = input.value.trim().replace(/[^0-9]/g, '');

    if (tipo === "" || valor === "") {
        error.innerHTML = "Complete tipo y número de RIF.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } 

    let maxLength;
    switch(tipo) {
        case 'V': maxLength = 8; break;
        case 'E': case 'J': case 'G': case 'C': maxLength = 9; break;
        default: maxLength = 12;
    }

    if (valor.length < 1 || valor.length > maxLength) {
        error.innerHTML = `RIF ${tipo} máximo ${maxLength} dígitos.`;
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

function validar_nombre() {
    const input = document.getElementById("nombreCliente");
    const error = document.getElementById("errorCliente");
    const icono = document.getElementById("icono-validacionNombre");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Ingrese el nombre del cliente.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else if (valor.length < 3 || valor.length > 100) {
        error.innerHTML = "Nombre: 3-100 caracteres.";
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

function validar_tipo_cliente() {
    const select = document.getElementById("tipoCliente");
    const error = document.getElementById("errorTipoCliente");

    const valor = select.value;

    if (valor === "") {
        error.innerHTML = "Selecciones un tipo de cliente";
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

function validar_telefono() {
    const input = document.getElementById("tlfCliente");
    const error = document.getElementById("errorTelefono");
    const icono = document.getElementById("icono-validacionTelefono");

    let valor = input.value.trim().replace(/[^0-9]/g, '');

    if (valor === "") {
        error.innerHTML = "Ingrese el teléfono.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    if (valor.length < 10 || valor.length > 15) {
        error.innerHTML = "Teléfono: 10-15 dígitos.";
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

function validar_email() {
    const input = document.getElementById("emailCliente");
    const error = document.getElementById("errorEmail");
    const icono = document.getElementById("icono-validacionEmail");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Ingrese el correo.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(valor)) {
        error.innerHTML = "Correo no válido.";
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

function validar_direccion() {
    const input = document.getElementById("direccionCliente");
    const error = document.getElementById("errorDireccion");
    const icono = document.getElementById("icono-validacionDireccion");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Ingrese la dirección.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else if (valor.length < 5 || valor.length > 200) {
        error.innerHTML = "Dirección: 5-200 caracteres.";
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

function validar_esatdo_cliente() {
    const select = document.getElementById("estadoCliente");
    const error = document.getElementById("errorEstado");

    const valor = select.value;

    if (valor === "") {
        error.innerHTML = "Seleccione un estado de cliente";
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

function validar_img() {
    const input = document.getElementById("imgCliente");
    const error = document.getElementById("errorImagen");
    const icono = document.getElementById("icono-validacionImagen");

    const archivo = input.files[0];

    if (!archivo) {
        error.innerHTML = "Seleccione imagen.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    const tipo = archivo.type;
    const size = archivo.size;
    const tiposPermitidos = ["image/jpeg", "image/jpg", "image/png", "image/gif"];

    if (!tiposPermitidos.includes(tipo)) {
        error.innerHTMLt = "JPG, PNG, GIF solamente.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else if (size > 5 * 1024 * 1024) {
        error.innerHTML = "Imagen máximo 5MB.";
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
    const validations = [
        validar_tipo_rif(),
        validar_rif(),
        validar_nombre(),
        validar_telefono(),
        validar_email(),
        validar_direccion(),
        validar_img()
    ];

    // Campos Superusuario (si existen)
    if (document.getElementById("tipoCliente")) validations.push(validar_tipo_cliente());
    if (document.getElementById("estadoCliente")) validations.push(validar_esatdo_cliente());

    if (validations.every(valid => valid === true)) {
        return true;
    } else {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Corrija los campos marcados.',
            confirmButtonText: 'OK',
            timer: 5000,
            timerProgressBar: true
        });
        return false;
    }
}

// VALIDACIONES COMPLETAS PARA FORMULARIO MODIFICAR CLIENTE

function validar_tipo_id_modificado() {
    const select = document.getElementById("tipo_idEdit");
    const error = document.getElementById("errorRifEdit");

    const tipo = select.value.trim();
    
    if (tipo === "") {
        error.innerHTML = "Seleccione el tipo de RIF.";
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

function validar_rif_modificado() {
    const tipoInput = document.getElementById("tipo_idEdit");
    const input = document.getElementById("rifClienteEdit");
    const error = document.getElementById("errorRifEdit");

    const tipo = tipoInput.value.trim();
    const valor = input.value.trim().replace(/[^0-9]/g, '');

    if (tipo === "" || valor === "") {
        error.innerHTML = "Complete tipo y número de RIF.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } 

    let maxLength;
    switch(tipo) {
        case 'V': maxLength = 8; break;
        case 'E': case 'J': case 'G': case 'C': maxLength = 9; break;
        default: maxLength = 12;
    }

    if (valor.length < 1 || valor.length > maxLength) {
        error.innerHTML = `RIF ${tipo} máximo ${maxLength} dígitos.`;
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

function validar_nombre_modificado() {
    const input = document.getElementById("nombreClienteEdit");
    const error = document.getElementById("errorClienteEdit");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Ingrese el nombre del cliente.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else if (valor.length < 3 || valor.length > 100) {
        error.innerHTML = "Nombre: 3-100 caracteres.";
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

function validar_tipo_cliente_modificado() {
    const select = document.getElementById("tipoClienteEdit");
    const error = document.getElementById("errorTipoClienteEdit");

    const valor = select.value;

    if (valor === "") {
        error.innerHTML = "Seleccione tipo de cliente.";
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

function validar_telefono_modificado() {
    const input = document.getElementById("tlfClienteEdit");
    const error = document.getElementById("errorTelefonoEdit");

    let valor = input.value.trim().replace(/[^0-9]/g, '');

    if (valor === "") {
        error.innerHTML = "Ingrese el teléfono.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    if (valor.length < 10 || valor.length > 15) {
        error.innerHTML = "Teléfono: 10-15 dígitos.";
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

function validar_email_modificado() {
    const input = document.getElementById("emailClienteEdit");
    const error = document.getElementById("errorEmailEdit");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Ingrese el correo.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(valor)) {
        error.innerHTML = "Correo no válido.";
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

function validar_direccion_modificado() {
    const input = document.getElementById("direccionClienteEdit");
    const error = document.getElementById("errorDireccionEdit");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Ingrese la dirección.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else if (valor.length < 5 || valor.length > 200) {
        error.innerHTML = "Dirección: 5-200 caracteres.";
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

function validar_esatdo_cliente_modificado() {
    const select = document.getElementById("estadoClienteEdit");
    const error = document.getElementById("errorEstadoEdit");

    const valor = select.value;

    if (valor === "") {
        error.innerHTML = "Seleccione estado.";
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
    const validations = [
        validar_tipo_id_modificado(),
        validar_rif_modificado(),
        validar_nombre_modificado(),
        validar_telefono_modificado(),
        validar_email_modificado(),
        validar_direccion_modificado()
    ];

    // Campo Superusuario (si existe)
    if (document.getElementById("tipoClienteEdit")) validations.push(validar_tipo_cliente_modificado());
    if (document.getElementById("estadoClienteEdit")) validations.push(validar_esatdo_cliente_modificado());

    if (validations.every(valid => valid === true)) {
        return true;
    } else {
        Swal.fire({
            icon: 'warning',
            title: '¡Campos Incorrectos!',
            text: 'Corrija los campos marcados en rojo.',
            confirmButtonText: 'OK',
            timer: 5000,
            timerProgressBar: true
        });
        return false;
    }
}

function EliminarCliente(event, id) {
    // Evitar navegación inmediata
    event.preventDefault();
    
    // Se establece URL del enlace
    const url = "index.php?url=clientes&action=eliminar&ID=" + id;
    
    // Confirmación de la acción
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Deseas eliminar el cliente. No podrás revertir esto!",
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