// VALIDACIONES INDIVIDUALES
function validar_nombre() {
    const input = document.getElementById("nombreProducto");
    const error = document.getElementById("errorProducto");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Debe ingresar un nombre de producto.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false
    } else if (valor.length < 3 || valor.length > 100) {
        error.innerHTML = "El nombre debe tener entre 3 y 100 caracteres.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false
    } else {
        error.innerHTML = "";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true
    }
}

function validar_categoria() {
    const select = document.getElementById("nombreCategoria");
    const error = document.getElementById("errorCategoria");

    const valor = select.value;

    if (valor === "") {
        error.innerHTML = "Debe seleccionar una categoría.";
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

function validar_precio() {
    const input = document.getElementById("precioProducto");
    const error = document.getElementById("errorPrecio");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Debe ingresar un precio.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    const num = parseFloat(valor.replace(",", "."));

    if (isNaN(num) || num <= 0) {
        error.innerHTML = "El precio debe ser un número mayor que cero.";
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

function validar_stock() {
    const input = document.getElementById("stockProducto");
    const error = document.getElementById("errorStock");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Debe ingresar el stock.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    const num = parseInt(valor, 10);

    if (isNaN(num) || num < 0) {
        error.innerHTML = "El stock debe ser un número entero no negativo.";
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

function validar_fecha() {
    const input = document.getElementById("fechaRegistroProducto");
    const error = document.getElementById("errorFechaRegistro");

    const valor = input.value;

    if (valor === "") {
        error.innerHTML = "Debe ingresar la fecha de registro.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    const fecha = new Date(valor);
    const ahora = new Date();

    if (isNaN(fecha.getTime()) || fecha > ahora) {
        error.innerHTML = "La fecha de registro no puede ser futura.";
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

function validar_fecha_vencimiento() {
    const input = document.getElementById("fechaVencimientoProducto");
    const fechaRegistro = document.getElementById("fechaRegistroProducto");
    const error = document.getElementById("errorFechaVencimiento");

    const valor = input.value;

    if (valor === "") {
        error.innerHTML = "Debe ingresar la fecha de vencimiento.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    const fechaV = new Date(valor);
    const fechaR = fechaRegistro.value ? new Date(fechaRegistro.value) : null;

    if (isNaN(fechaV.getTime())) {
        error.innerHTML = "Fecha de vencimiento no válida.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    if (fechaR && fechaV < fechaR) {
        error.innerHTML = "La fecha de vencimiento no puede ser anterior a la fecha de registro.";
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

function validar_imagen() {
    const input = document.getElementById("imagenProducto");
    const error = document.getElementById("errorImagen");

    const archivo = input.files[0];

    if (!archivo) {
        error.innerHTML = "Debe seleccionar al menos una imagen.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    const tipo = archivo.type;
    const size = archivo.size;

    const tiposPermitidos = ["image/jpeg", "image/jpg", "image/png", "image/gif"];

    if (!tiposPermitidos.includes(tipo)) {
        error.innerHTML = "Solo se permiten imágenes (jpg, jpeg, png, gif).";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    } else if (size > 5 * 1024 * 1024) { // 5 MB
        error.innerHTML = "La imagen no debe superar 5 MB.";
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

// VALIDACIÓN GLOBAL DEL FORMULARIO (para el onsubmit)
function validar_formulario() {
    // volvemos a disparar cada validación por si el usuario nunca cambió el campo
    const nombre = validar_nombre();
    const categoria = validar_categoria();
    const precio = validar_precio();
    const stock = validar_stock();
    const fecha = validar_fecha();
    const fechaVencimiento = validar_fecha_vencimiento();
    const imagen = validar_imagen();

    if (nombre && categoria && precio && stock && fecha && fechaVencimiento && imagen) {
    
        // envia form si todo esta bien
        return true;
    }
    else {
    Swal.fire({
      icon: 'error',
      title: '¡Error!',
      text: 'Formulario con errores, corrija los campos marcados.',
      confirmButtonText: 'Aceptar',
      timer: 6000,
      timerProgressBar: true,

    })
    return false;
    }   

}

// VALIDAR NOMBRE - MODIFICAR
function validar_nombre_modificado() {
    const input = document.getElementById("nombreProductoEdit");
    const error = document.getElementById("errorProductoEdit");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Debe ingresar un nombre de producto.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false
    } else if (valor.length < 3 || valor.length > 100) {
        error.innerHTML = "El nombre debe tener entre 3 y 100 caracteres.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false
    } else {
        error.innerHTML = "";
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true
    }
}

// VALIDAR CATEGORÍA - MODIFICAR
function validar_categoria_modificado() {
    const select = document.getElementById("nombreCategoriaEdit");
    const error = document.getElementById("errorCategoriaEdit");

    const valor = select.value;

    if (valor === "") {
        error.innerHTML = "Debe seleccionar una categoría.";;
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

// VALIDAR PRECIO - MODIFICAR
function validar_precio_modificado() {
    const input = document.getElementById("precioProductoEdit");
    const error = document.getElementById("errorPrecioEdit");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Debe ingresar un precio.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    const num = parseFloat(valor.replace(",", "."));

    if (isNaN(num) || num <= 0) {
        error.innerHTML = "El precio debe ser un número mayor que cero.";
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

// VALIDAR STOCK - MODIFICAR
function validar_stock_modificado() {
    const input = document.getElementById("stockProductoEdit");
    const error = document.getElementById("errorStockEdit");

    const valor = input.value.trim();

    if (valor === "") {
        error.innerHTML = "Debe ingresar el stock.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    const num = parseInt(valor, 10);

    if (isNaN(num) || num < 0) {
        error.innerHTML = "El stock debe ser un número entero no negativo.";
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

// VALIDAR FECHA REGISTRO - MODIFICAR
function validar_fecha_modificado() {
    const input = document.getElementById("fechaRegistroProductoEdit");
    const error = document.getElementById("errorFechaRegistroEdit");

    const valor = input.value;

    if (valor === "") {
        error.innerHTML = "Debe ingresar la fecha de registro.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    const fecha = new Date(valor);
    const ahora = new Date();

    if (isNaN(fecha.getTime()) || fecha > ahora) {
        error.innerHTML = "La fecha de registro no puede ser futura.";
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

// VALIDAR FECHA VENCIMIENTO - MODIFICAR
function validar_fecha_vencimiento_modificado() {
    const input = document.getElementById("fechaVencimientoProductoEdit");
    const fechaRegistro = document.getElementById("fechaRegistroProductoEdit");
    const error = document.getElementById("errorFechaVencimientoEdit");

    const valor = input.value;

    if (valor === "") {
        error.textCoinnerHTMLntent = "Debe ingresar la fecha de vencimiento.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    const fechaV = new Date(valor);
    const fechaR = fechaRegistro.value ? new Date(fechaRegistro.value) : null;

    if (isNaN(fechaV.getTime())) {
        error.innerHTML = "Fecha de vencimiento no válida.";
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        return false;
    }

    if (fechaR && fechaV < fechaR) {
        error.innerHTML = "La fecha de vencimiento no puede ser anterior a la fecha de registro.";
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

// VALIDACIÓN GLOBAL DEL FORMULARIO MODIFICAR
function validar_formulario_modificado() {
    // Volvemos a disparar cada validación por si el usuario nunca cambió el campo
    const nombre = validar_nombre_modificado();
    const categoria = validar_categoria_modificado();
    const precio = validar_precio_modificado();
    const stock = validar_stock_modificado();
    const fecha = validar_fecha_modificado();
    const fechaVencimiento = validar_fecha_vencimiento_modificado();

    if (nombre && categoria && precio && stock && fecha && fechaVencimiento && imagen) {
        // Envía form si todo está bien
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

function EliminarProducto(event, id) {
    // Evitar navegación inmediata
    event.preventDefault();
    
    // Se establece URL del enlace
    const url = "index.php?url=productos&action=eliminar&ID=" + id;
    
    // Confirmación de la acción
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Deseas eliminar el producto. No podrás revertir esto!",
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