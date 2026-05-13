// Variables globales
let materiasPrimasAgregadas = [];
let costoTotalCompra = 0;

// Función para cargar materias primas según el proveedor seleccionado
function cargarMateriasPrimasPorProveedor() {
    const proveedorId = document.getElementById('proveedorId').value;
    const selectMateriaPrima = document.getElementById('materiasPrimas');
    
    if (!proveedorId) {
        selectMateriaPrima.innerHTML = '<option value="">Primero seleccione un proveedor...</option>';
        return;
    }
    
    // Mostrar indicador de carga
    selectMateriaPrima.innerHTML = '<option value="">Cargando materias primas...</option>';
    
    // Realizar petición AJAX
    fetch(`index.php?url=compras&action=obtenerMateriaProveedor&ID=${proveedorId}`)
    .then(response => response.json())
    .then(data => {
        // data YA ES el array de materias primas
        if (data && data.length > 0) {
            let options = '<option value="">Seleccione una materia prima</option>';
            data.forEach(materia => {
                options += `<option value="${materia.id_materia_prima}" data-precio="${materia.precio_compra || 0}">
                    ${materia.nombre_materia_prima}
                </option>`;
            });
            selectMateriaPrima.innerHTML = options;
        } else {
            selectMateriaPrima.innerHTML = '<option value="">No hay materias primas para este proveedor</option>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        selectMateriaPrima.innerHTML = '<option value="">Error al cargar materias primas</option>';
    });
}

// Función para cargar el precio de la materia prima seleccionada
function cargarPrecioMateriaPrima() {
    const selectMateriaPrima = document.getElementById('materiasPrimas');
    const selectedOption = selectMateriaPrima.options[selectMateriaPrima.selectedIndex];
    const precio = selectedOption.getAttribute('data-precio');
    
    if (precio && precio > 0) {
        document.getElementById('precioMateriaPrima').value = precio;
    } else {
        document.getElementById('precioMateriaPrima').value = '';
    }
    
    // Actualizar el total del producto actual
    actualizarPrecioProducto();
}

// Función para actualizar el precio del producto actual
function actualizarPrecioProducto() {
    const cantidad = parseFloat(document.getElementById('cantidadMateriaPrima').value) || 0;
    const precio = parseFloat(document.getElementById('precioMateriaPrima').value) || 0;
    const totalProducto = cantidad * precio;
    
    // Mostrar el total del producto actual (opcional)
    const totalActualizado = totalProducto;
}

// Función para validar la materia prima seleccionada
function validar_materiaPrima() {
    const materiaPrima = document.getElementById('materiasPrimas').value;
    const errorSpan = document.getElementById('errorMateriaPrima');
    
    if (!materiaPrima) {
        errorSpan.textContent = 'Debe seleccionar una materia prima';
        return false;
    } else {
        errorSpan.textContent = '';
        return true;
    }
}

// Función para validar la cantidad
function validar_cantidad() {
    const cantidad = document.getElementById('cantidadMateriaPrima').value;
    const errorSpan = document.getElementById('errorCantidad');
    
    if (!cantidad || cantidad <= 0) {
        errorSpan.textContent = 'La cantidad debe ser mayor a 0';
        return false;
    } else {
        errorSpan.textContent = '';
        return true;
    }
}

// Función para validar el precio
function validar_precio() {
    const precio = document.getElementById('precioMateriaPrima').value;
    const errorSpan = document.getElementById('errorPrecio');
    
    if (!precio || precio <= 0) {
        errorSpan.textContent = 'El precio debe ser mayor a 0';
        return false;
    } else {
        errorSpan.textContent = '';
        return true;
    }
}

// Función para agregar materia prima a la lista
function agregarMateriaPrima() {
    // Validar que se haya seleccionado una materia prima
    const materiaPrimaId = document.getElementById('materiasPrimas').value;
    const materiaPrimaNombre = document.getElementById('materiasPrimas').options[document.getElementById('materiasPrimas').selectedIndex]?.text;
    const cantidad = document.getElementById('cantidadMateriaPrima').value;
    const precio = document.getElementById('precioMateriaPrima').value;
    
    if (!validar_materiaPrima() || !validar_cantidad() || !validar_precio()) {
        mostrarAlerta('Por favor, complete todos los campos correctamente', 'warning');
        return;
    }
    
    const cantidadNum = parseFloat(cantidad);
    const precioNum = parseFloat(precio);
    const subtotal = cantidadNum * precioNum;
    
    // Crear objeto de materia prima
    const materiaPrima = {
        id: materiaPrimaId,
        nombre: materiaPrimaNombre,
        cantidad: cantidadNum,
        precio: precioNum,
        subtotal: subtotal
    };
    
    // Agregar al array
    materiasPrimasAgregadas.push(materiaPrima);
    
    // Actualizar la tabla de materias primas agregadas
    actualizarTablaMateriasPrimas();
    
    // Calcular y actualizar totales
    calcularTotales();
    
    // Limpiar los campos del formulario
    limpiarCamposMateriaPrima();
    
    // Mostrar mensaje de éxito
    mostrarAlerta('Materia prima agregada correctamente', 'success');
}

// Función para actualizar la tabla de materias primas
function actualizarTablaMateriasPrimas() {
    let tablaExistente = document.getElementById('tablaMateriasPrimas');
    
    if (!tablaExistente) {
        // Crear la tabla si no existe
        const contenedor = document.getElementById('contenedorMateriaPrima');
        const tablaHTML = `
            <div class="col-12 mt-3">
                <h6 class="mb-2">Materias Primas Agregadas:</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered" id="tablaMateriasPrimas">
                        <thead class="table-light">
                            <tr>
                                <th>Materia Prima</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyMateriasPrimas"></tbody>
                    </table>
                </div>
            </div>
        `;
        contenedor.insertAdjacentHTML('afterend', tablaHTML);
        tablaExistente = document.getElementById('tablaMateriasPrimas');
    }
    
    const tbody = document.getElementById('tbodyMateriasPrimas');
    tbody.innerHTML = '';
    
    materiasPrimasAgregadas.forEach((item, index) => {
        const row = tbody.insertRow();
        row.innerHTML = `
            <td>${item.nombre}</td>
            <td>${item.cantidad}</td>
            <td>$${item.precio.toFixed(2)}</td>
            <td>$${item.subtotal.toFixed(2)}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarMateriaPrima(${index})">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        `;
    });
}

// Función para eliminar materia prima de la lista
function eliminarMateriaPrima(index) {
    materiasPrimasAgregadas.splice(index, 1);
    actualizarTablaMateriasPrimas();
    calcularTotales();
    
    if (materiasPrimasAgregadas.length === 0) {
        const tabla = document.getElementById('tablaMateriasPrimas');
        if (tabla) tabla.remove();
    }
    
    mostrarAlerta('Materia prima eliminada', 'info');
}

// Función para calcular los totales
function calcularTotales() {
    // Calcular subtotal
    let subtotal = 0;
    materiasPrimasAgregadas.forEach(item => {
        subtotal += item.subtotal;
    });
    
    // Actualizar campo subtotal
    document.getElementById('subtotal').value = subtotal.toFixed(2);
    
    // Actualizar total con/sin IVA
    actualizarTotalConIva();
}

// Función para actualizar el total con IVA
function actualizarTotalConIva() {
    const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
    const aplicarIva = document.getElementById('aplicarIva').checked;
    let total = subtotal;
    
    if (aplicarIva) {
        total = subtotal * 1.16; // 16% de IVA
    }
    
    document.getElementById('total').value = total.toFixed(2);
}

// Función para limpiar los campos de materia prima
function limpiarCamposMateriaPrima() {
    document.getElementById('materiasPrimas').value = '';
    document.getElementById('cantidadMateriaPrima').value = '';
    document.getElementById('precioMateriaPrima').value = '';
    
    // Limpiar mensajes de error
    document.getElementById('errorMateriaPrima').textContent = '';
    document.getElementById('errorCantidad').textContent = '';
    document.getElementById('errorPrecio').textContent = '';
}

// Funciones de validación existentes
function validar_proveedor() {
    const proveedor = document.getElementById('proveedorId').value;
    const errorSpan = document.getElementById('errorProveedor');
    
    if (!proveedor) {
        errorSpan.textContent = 'Debe seleccionar un proveedor';
        return false;
    } else {
        errorSpan.textContent = '';
        cargarMateriasPrimasPorProveedor(); // Cargar materias primas al seleccionar proveedor
        return true;
    }
}

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

  error.innerHTML = '';
  fecha.classList.add('input-valid', 'is-valid');
  fecha.classList.remove('is-invalid');
  return true;
}

function validar_observaciones() {
  var observaciones = document.getElementById('observacionesCompra');
  var error = document.getElementById('errorObservaciones');
  var valor = observaciones.value.trim();

  if (valor === '') {
    error.innerHTML = 'La observación es requerida.';
    observaciones.style.border = '2px solid #dc3545';
    observaciones.style.backgroundColor = '#fff8f8';
    return false;
  }
  else if (valor.length > 300) {
    error.innerHTML = 'Las observaciones no pueden exceder 300 caracteres.';
    observaciones.style.border = '2px solid #dc3545';
    observaciones.style.backgroundColor = '#fff8f8';
    return false;
  }
  else {
    error.innerHTML = '';
    observaciones.style.border = '2px solid #28a745';
    observaciones.style.backgroundColor = '#f8fff8';
    return true;
  }
}

function validar_total() {
    const total = document.getElementById('total').value;
    const errorSpan = document.getElementById('errorTotal');
    
    if (!total || total <= 0) {
        errorSpan.textContent = 'El total debe ser mayor a 0';
        return false;
    } else {
        errorSpan.textContent = '';
        return true;
    }
}

// Función principal de validación del formulario
function validar_formulario() {
    // Validar que haya al menos una materia prima agregada
    if (materiasPrimasAgregadas.length === 0) {
        mostrarAlerta('Debe agregar al menos una materia prima', 'warning');
        return false;
    }
    
    // Validar proveedor
    if (!validar_proveedor()) return false;
    
    // Validar días crédito
    const diasCredito = document.getElementById('diasCredito').value;
    if (!diasCredito || diasCredito < 0) {
        document.getElementById('errorCredito').textContent = 'Ingrese días de crédito válidos';
        return false;
    } else {
        document.getElementById('errorCredito').textContent = '';
    }
    
    // Validar fecha
    if (!validar_fecha()) return false;
    
    // Validar total
    if (!validar_total()) return false;
    
    // Crear input ocultos para enviar las materias primas
    crearInputsMateriasPrimas();
    
    return true;
}

// Función para crear inputs ocultos con las materias primas
function crearInputsMateriasPrimas() {
    // Eliminar inputs existentes para evitar duplicados
    const inputsExistentes = document.querySelectorAll('input[name^="materiasPrimas"], input[name^="cantidades"], input[name^="precios"]');
    inputsExistentes.forEach(input => input.remove());
    
    // Crear arrays paralelos como espera tu PHP
    materiasPrimasAgregadas.forEach((item, index) => {
        // Input para ID de materia prima
        const inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = `materiasPrimas[${index}]`;  // Cambiado: array simple
        inputId.value = item.id;
        
        // Input para cantidad
        const inputCantidad = document.createElement('input');
        inputCantidad.type = 'hidden';
        inputCantidad.name = `cantidades[${index}]`;  // Cambiado: nombre diferente
        inputCantidad.value = item.cantidad;
        
        // Input para precio
        const inputPrecio = document.createElement('input');
        inputPrecio.type = 'hidden';
        inputPrecio.name = `precios[${index}]`;  // Cambiado: nombre diferente
        inputPrecio.value = item.precio;
        
        document.getElementById('formPedido').appendChild(inputId);
        document.getElementById('formPedido').appendChild(inputCantidad);
        document.getElementById('formPedido').appendChild(inputPrecio);
    });
}

// Función para mostrar alertas
function mostrarAlerta(mensaje, tipo) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
    
    Toast.fire({
        icon: tipo, // 'success', 'warning', 'info', 'error'
        title: mensaje
    });
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Event listener para el checkbox de IVA
    const checkboxIva = document.getElementById('aplicarIva');
    if (checkboxIva) {
        checkboxIva.addEventListener('change', actualizarTotalConIva);
    }
    
    // Event listener para cambios en cantidad y precio
    const cantidadInput = document.getElementById('cantidadMateriaPrima');
    const precioInput = document.getElementById('precioMateriaPrima');
    
    if (cantidadInput) {
        cantidadInput.addEventListener('input', function() {
            validar_cantidad();
            actualizarPrecioProducto();
        });
    }
    
    if (precioInput) {
        precioInput.addEventListener('input', function() {
            validar_precio();
            actualizarPrecioProducto();
        });
    }
    
    // Event listener para el select de proveedor
    const proveedorSelect = document.getElementById('proveedorId');
    if (proveedorSelect) {
        proveedorSelect.addEventListener('change', validar_proveedor);
    }
    
    // Limpiar la tabla al cerrar el modal
    const modal = document.getElementById('compraModal');
    if (modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            materiasPrimasAgregadas = [];
            const tabla = document.getElementById('tablaMateriasPrimas');
            if (tabla) tabla.remove();
            limpiarCamposMateriaPrima();
            document.getElementById('subtotal').value = '';
            document.getElementById('total').value = '';
            document.getElementById('aplicarIva').checked = false;
        });
    }
});