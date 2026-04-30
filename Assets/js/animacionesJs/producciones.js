// funcion para agregar y eliminar materi de forma dinamica
let contadorMaterias = 0; // Contador para IDs únicos

function agregarMateriaPrima() {
    // Validar que se haya seleccionado materia prima y cantidad
    const materiaSelect = document.getElementById('materiaPrimaProduccion');
    const cantidadInput = document.getElementById('cantidadProduccion');
    
    if (!materiaSelect.value || !cantidadInput.value || cantidadInput.value <= 0) {
        Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Por favor, seleccione una materia prima y ingrese una cantidad válida',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                });
        return;
    }

    const contenedor = document.getElementById('contenedorMateriaPrima');
    contadorMaterias++;
    
    // Crear el nuevo div para la materia prima
    const div = document.createElement('div');
    div.className = 'row mb-3 p-3 border rounded bg-light';
    div.id = `materia_${contadorMaterias}`;
    
    // Obtener el nombre de la materia prima seleccionada
    const materiaSeleccionada = materiaSelect.options[materiaSelect.selectedIndex].text;
    const cantidad = cantidadInput.value;
    
    div.innerHTML = `
        <div class="col-md-5">
            <label class="form-label fw-bold text-muted">
                <i class="fa fa-box me-1 text-danger"></i>Materia Prima:
            </label>
            <input type="hidden" name="materiaPrimaProduccion[]" value="${materiaSelect.value}">
            <span class="badge bg-primary fs-6 px-3 py-2">${materiaSeleccionada}</span>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-bold text-muted">
                <i class="fa fa-cubes me-1 text-success"></i>Cantidad:
            </label>
            <input type="hidden" name="cantidadProduccion[]" value="${cantidad}">
            <span class="badge bg-success fs-6 px-3 py-2">${cantidad}</span>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="button" class="btn btn-danger w-100" onclick="eliminarMateriaPrima(${contadorMaterias})">
                <i class="fa fa-trash me-1"></i>Eliminar
            </button>
        </div>
    `;
    
    // Agregar al contenedor
    contenedor.appendChild(div);
    
    // Limpiar y resetear los campos
    materiaSelect.value = '';
    cantidadInput.value = '';
    document.getElementById('errorMateria').textContent = '';
    document.getElementById('errorCantidad').textContent = '';
    
    // Actualizar contador visual
    actualizarContadorMaterias();
}

function eliminarMateriaPrima(id) {
    const elemento = document.getElementById(`materia_${id}`);
    if (elemento) {
        elemento.remove();
        actualizarContadorMaterias();
    }
}

function actualizarContadorMaterias() {
    const total = document.querySelectorAll('[id^="materia_"]').length;
    const contadorElement = document.getElementById('contadorMaterias');
    if (contadorElement) {
        contadorElement.textContent = total;
    }
}


function agregarMateriaPrimaModificada() {
    // Validar que se haya seleccionado materia prima y cantidad
    const materiaSelect = document.getElementById('materiaPrimaEdit');
    const cantidadInput = document.getElementById('cantidadProduccionEdit');
    
    if (!materiaSelect.value || !cantidadInput.value || cantidadInput.value <= 0) {
        Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Por favor, seleccione una materia prima y ingrese una cantidad válida',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                });
        return;
    }

    const contenedor = document.getElementById('contenedorMateriaPrimaEdit');
    contadorMaterias++;
    
    // Crear el nuevo div para la materia prima
    const div = document.createElement('div');
    div.className = 'row mb-3 p-3 border rounded bg-light';
    div.id = `materia_${contadorMaterias}`;
    
    // Obtener el nombre de la materia prima seleccionada
    const materiaSeleccionada = materiaSelect.options[materiaSelect.selectedIndex].text;
    const cantidad = cantidadInput.value;
    
    div.innerHTML = `
        <div class="col-md-5">
            <label class="form-label fw-bold text-muted">
                <i class="fa fa-box me-1 text-danger"></i>Materia Prima:
            </label>
            <input type="hidden" name="materiaPrimaEdit[]" value="${materiaSelect.value}">
            <span class="badge bg-primary fs-6 px-3 py-2">${materiaSeleccionada}</span>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-bold text-muted">
                <i class="fa fa-cubes me-1 text-success"></i>Cantidad:
            </label>
            <input type="hidden" name="cantidadEdit[]" value="${cantidad}">
            <span class="badge bg-success fs-6 px-3 py-2">${cantidad}</span>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="button" class="btn btn-danger w-100" onclick="eliminarMateriaPrimaModificada(${contadorMaterias})">
                <i class="fa fa-trash me-1"></i>Eliminar
            </button>
        </div>
    `;
    
    // Agregar al contenedor
    contenedor.appendChild(div);
    
    // Limpiar y resetear los campos
    materiaSelect.value = '';
    cantidadInput.value = '';
    document.getElementById('errorMateriaPrimaEdit').textContent = '';
    document.getElementById('errorCantidadEdit').textContent = '';
    
    // Actualizar contador visual
    actualizarContadorMaterias();
}

function eliminarMateriaPrimaModificada(id) {
    const elemento = document.getElementById(`materia_${id}`);
    if (elemento) {
        elemento.remove();
        actualizarContadorMateriasModificar();
    }
}

function actualizarContadorMateriasModificar() {
    const total = document.querySelectorAll('[id^="materia_"]').length;
    const contadorElement = document.getElementById('contadorMaterias');
    if (contadorElement) {
        contadorElement.textContent = total;
    }
}