// Inicializar el contador fuera de las funciones
let contadorProductos = 0;
function agregarProducto() {
    const productoSelect = document.getElementById('productos');
    // Verifica si hay algo seleccionado
    if (!productoSelect.value) {
        Swal.fire({ icon: 'error', title: '¡Error!', text: 'Por favor, seleccione un producto', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
        return;
    }

    // Evitar duplicados (Opcional, pero recomendado)
    if (document.querySelector(`input[value="${productoSelect.value}"][name="productos[]"]`)) {
        Swal.fire({ icon: 'warning', title: 'Duplicado', text: 'Este producto ya fue agregado', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
        return;
    }

    const contenedor = document.getElementById('contenedorProductos');
    contadorProductos++;
    
    const div = document.createElement('div');
    div.className = 'row mb-3 p-3 border rounded bg-light';
    div.id = `producto_${contadorProductos}`;
    
    const productoSeleccionado = productoSelect.options[productoSelect.selectedIndex].text;
    
    div.innerHTML = `
        <div class="col-md-9">
            <input type="hidden" name="productos[]" value="${productoSelect.value}">
            <span class="badge bg-primary fs-6 px-3 py-2">${productoSeleccionado}</span>
        </div>
        <div class="col-md-3">
            <button type="button" class="btn btn-danger w-100" onclick="eliminarProducto(${contadorProductos})">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    `;
    
    contenedor.appendChild(div);
    productoSelect.value = ''; // Limpiar select
    actualizarContadorProductos();
}

function eliminarProducto(id) {
    const elemento = document.getElementById(`producto_${id}`);
    if (elemento) {
        elemento.remove();
        actualizarContadorProductos();
    }
}

function actualizarContadorProductos() {
    const total = document.querySelectorAll('[id^="producto_"]').length;
    const contadorElement = document.getElementById('contadorProductos');
    if (contadorElement) {
        contadorElement.textContent = total;
    }
}

// Funciones para edición
function agregarProductoEdit() {
    const productoSelect = document.getElementById('productosEdit');
    // Verifica si hay algo seleccionado
    if (!productoSelect.value) {
        Swal.fire({ icon: 'error', title: '¡Error!', text: 'Por favor, seleccione un producto', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
        return;
    }

    // Evitar duplicados (Opcional, pero recomendado)
    if (document.querySelector(`input[value="${productoSelect.value}"][name="productosEdit[]"]`)) {
        Swal.fire({ icon: 'warning', title: 'Duplicado', text: 'Este producto ya fue agregado', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
        return;
    }

    const contenedor = document.getElementById('contenedorProductosEdit');
    contadorProductos++;
    
    const div = document.createElement('div');
    div.className = 'row mb-3 p-3 border rounded bg-light';
    div.id = `producto_${contadorProductos}`;
    
    const productoSeleccionado = productoSelect.options[productoSelect.selectedIndex].text;
    
    div.innerHTML = `
        <div class="col-md-9">
            <input type="hidden" name="productosEdit[]" value="${productoSelect.value}">
            <span class="badge bg-primary fs-6 px-3 py-2">${productoSeleccionado}</span>
        </div>
        <div class="col-md-3">
            <button type="button" class="btn btn-danger w-100" onclick="eliminarProductoEdit(${contadorProductos})">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    `;
    
    contenedor.appendChild(div);
    productoSelect.value = ''; // Limpiar select
    actualizarContadorProductosEdit();
}

function eliminarProductoEdit(id) {
    const elemento = document.getElementById(`producto_${id}`);
    if (elemento) {
        elemento.remove();
        actualizarContadorProductosEdit();
    }
}

function actualizarContadorProductosEdit() {
    const total = document.querySelectorAll('[id^="producto_"]').length;
    const contadorElement = document.getElementById('contadorProductosEdit');
    if (contadorElement) {
        contadorElement.textContent = total;
    }
}