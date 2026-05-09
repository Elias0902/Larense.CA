// FUNCIONES PARA EL FORM DINAMICO
// se establecen var
let contadorProductos = 0; // para contar los productos agregador
let promocionesActivas = []; // parry para almacenar la promociones activas

//funcion para cargar la promociones por medio de ajax
function cargarPromocion() {

    // peticion ajax
    fetch('index.php?url=promociones&action=obtener_promociones')
        .then(response => response.json()) // response de ajax
        .then(data => { 

            // para debug
            //console.log(data);

            // se almacena las promo 
            promocionesActivas = (data.status && Array.isArray(data.data)) ? data.data : [];
        })
        .catch(error => {

            // msj de error 
            console.error('Error:', error);
            
            // igual de define el arry de promo
            promocionesActivas = [];
        });
}

// funcion para calcular promociones
function recalcularPromociones() {

    // se obtiene el elemento y se aplica un forEach de cantidad 
    document.querySelectorAll('.cantidad-item').forEach(inputCantidad => {
        
        // llama la funcion que actualiza los precio de las filas
        actualizarPrecioFila(inputCantidad);
    });
}

// funcion para obtener promo seleccionada del select
function obtenerPromocionSeleccionada() {

    // se obtienen los elementos
    const promoSelect = document.getElementById('promocionId');

    // se define el valor
    const promoId = promoSelect.value;

    // valida si existe la id de la promo
    if (!promoId) return null;

    // retorna las promo activa
    return promocionesActivas.find(p => String(p.id_promocion) === String(promoId)) || null;
}

// funcion para productos perteneciente a promocion
function productoPerteneceAPromocion(productoId, promo) {

    // valida si existen tanto la promo como el producto
    if (!promo || !promo.id_productos) return false;

    // se define los id de los productos
    const ids = String(promo.id_productos).split(',').map(id => id.trim());
    
    // retorna los id
    return ids.includes(String(productoId).trim());
}

// funcion para calcular el precion con la promo
function calcularPrecioConPromocion(cantidad, precioUnitario, promo) {
    
    // se define los valores
    const qty = Number(cantidad) || 0; // cantidad
    const price = Number(precioUnitario) || 0; // precio
    let subtotal = qty * price; // subtotal

    // valida si existe y retornal el subtotal
    if (!promo) return subtotal;

    // se almacena el tipo de promo
    const tipo = String(promo.tipo_descuento || '').trim().toLowerCase();

    // valida el tipo de promo
    if (tipo === '2x1') {

        // se define valor 
        const pagas = Math.ceil(qty / 2);
        
        // se calcula el subtotal
        subtotal = pagas * price;
    } 
    // en caso de ser otro tipo de promo
    else if (tipo === 'porcentaje') {

        //se define valor
        const porcentaje = Number(promo.valor_descuento) || 0;
        
        // se calcula el subtotal
        subtotal = subtotal - (subtotal * porcentaje / 100);
    }

    // retorna el subtotal
    return subtotal;
}

// suncion que muestra un mensaje si el producto es de una promo
function mostrarAlertaPromocion(promo) {
    
    // estructura del msj
    Swal.fire({
        icon: 'info',
        title: '¡Producto en promoción!',
        text: promo.nombre_promocion,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
    });
}

// funcion para cargar precio de los productos
function cargarPrecioProducto() {

    // se define los valores
    const productoSelect = document.getElementById('productos');//producto
    const precioInput = document.getElementById('precioProducto');//precio
    const cantidadInput = document.getElementById('cantidadProducto');//cantidad
    const opcion = productoSelect.options[productoSelect.selectedIndex];//opcion del producto

    // se define precio unitario del producto
    precioInput.dataset.precioUnitario = opcion.dataset.precio || '';

    // llama la funcion de actualizar precio del producto
    actualizarPrecioProducto();
}

// funcion para actualizar precio del producto
function actualizarPrecioProducto() {

    // se obtien los vlores
    const cantidadInput = document.getElementById('cantidadProducto');//cantidad
    const precioInput = document.getElementById('precioProducto');//precio

    // se almacena los valores
    const cantidad = parseFloat(cantidadInput.value) || 0;//cantidad
    const precioUnitario = parseFloat(precioInput.dataset.precioUnitario || 0);//precio

    // validad la cantidad y el precio
    if (cantidad > 0 && precioUnitario > 0) {

        //se almacena el precio
        precioInput.value = (cantidad * precioUnitario).toFixed(2);
    } else {

        // se almacena en caso de error igualmente
        precioInput.value = precioUnitario ? precioUnitario.toFixed(2) : '';
    }
}

// funcion para actualizar precio de fila
function actualizarPrecioFila(inputCantidad) {

    // se obtiene los valores
    const fila = inputCantidad.closest('.row');//fila
    const precioBadge = fila.querySelector('.precio-item');//precio
    const hiddenPrecio = fila.querySelector('input[name="precios[]"]');//precio oculto
    const productoId = fila.querySelector('input[name="productos[]"]').value;// producto

    const cantidad = Number(inputCantidad.value) || 0;// cantidad
    const precioUnitario = Number(inputCantidad.dataset.precioUnitario) || 0;// precio unitario

    const promoId = document.getElementById('promocionId').value;// promo
    const promoSeleccionada = promoId// promo seleccionada
        ? promocionesActivas.find(p => String(p.id_promocion) === String(promoId)) || null
        : null;

    // se define en null
    let promo = null;

    // valida la promo seleccionada
    if (promoSeleccionada && productoPerteneceAPromocion(productoId, promoSeleccionada)) {
        
        // se almacena
        promo = promoSeleccionada;
    }

    // se define nuevo subtotal
    const nuevoSubtotal = calcularPrecioConPromocion(cantidad, precioUnitario, promo);

    // precioa
    precioBadge.textContent = nuevoSubtotal.toFixed(2);
    hiddenPrecio.value = nuevoSubtotal.toFixed(2);

    // llamala funcion actualizar subtotal
    actualizarSubtotal();
}

//funcion para actualizar subtotal
function actualizarSubtotal() {

    // lo inicia en cero
    let subtotal = 0;

    // obtiene valores
    document.querySelectorAll('input[name="precios[]"]').forEach(input => {
        subtotal += parseFloat(input.value) || 0;
    });

    // define valores
    const subtotalInput = document.getElementById('subtotal');
    if (subtotalInput) {
        subtotalInput.value = subtotal.toFixed(2);
    }

    // llama la funcion altualizar total con iva
    actualizarTotalConIva();
}

// funcion que actualiza el total si tiene iva o no
function actualizarTotalConIva() {

    // se obtiene valores
    const subtotalInput = document.getElementById('subtotal');
    const totalInput = document.getElementById('total');
    const aplicarIva = document.getElementById('aplicarIva');

    // se define
    const subtotal = parseFloat(subtotalInput.value) || 0;
    const iva = 0.16;

    //valida
    if (aplicarIva.checked) {
        totalInput.value = (subtotal * (1 + iva)).toFixed(2);
    } else {
        totalInput.value = subtotal.toFixed(2);
    }
}

// funcion para agregar un producto dinamicamente
function agregarProducto() {

    // se obtiene los valores
    const productoSelect = document.getElementById('productos');
    const cantidadInput = document.getElementById('cantidadProducto');
    const precioInput = document.getElementById('precioProducto');
    const promoSelect = document.getElementById('promocionId');

    // valida
    if (!productoSelect.value || !cantidadInput.value || cantidadInput.value <= 0) {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Por favor, seleccione un producto e ingrese una cantidad válida',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
        });
        return;
    }

    // se define
    const contenedor = document.getElementById('contenedorProducto');
    contadorProductos++;

    // elementos dinamicos
    const div = document.createElement('div');
    div.className = 'row mb-3 p-3 border rounded bg-light';
    div.id = `producto_${contadorProductos}`;

    // se almacena los valores 
    const productoId = productoSelect.value;
    const productoSeleccionado = productoSelect.options[productoSelect.selectedIndex].text;
    const cantidad = parseFloat(cantidadInput.value) || 0;
    const precioUnitario = parseFloat(precioInput.dataset.precioUnitario || 0);

    // se almacen al funcion
    const promoSeleccionada = obtenerPromocionSeleccionada();
    let promo = null;

    // valida
    if (promoSeleccionada && productoPerteneceAPromocion(productoId, promoSeleccionada)) {
        promo = promoSeleccionada;
    }

    // se almacena funion
    let subtotal = calcularPrecioConPromocion(cantidad, precioUnitario, promo);

    //valida
    if (promo) {
        mostrarAlertaPromocion(promo);
    }

    // elemento dinamoco de prodctos agregados
    div.innerHTML = `
        <div class="row align-items-center w-100">
            <div class="col-md-7">
                <label class="form-label fw-bold text-muted d-block mb-1">
                    <i class="fa fa-box me-1 text-danger"></i>Producto:
                </label>
                <input type="hidden" name="productos[]" value="${productoId}">
                <span class="badge bg-primary fs-6 px-3 py-2">${productoSeleccionado}</span>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold text-muted d-block mb-1">
                    <i class="fa fa-cubes me-1 text-success"></i>Cantidad:
                </label>
                <input type="number"
                       name='cantidades[]'
                       class="form-control cantidad-item"
                       min="1"
                       value="${cantidad}"
                       data-precio-unitario="${precioUnitario}"
                       data-promo-id="${promo ? promo.id_promocion : ''}"
                       oninput="actualizarPrecioFila(this)">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold text-muted d-block mb-1">
                    <i class="fa fa-dollar-sign me-1 text-warning"></i>Precio:
                </label>
                <input type="hidden" name="precios[]" value="${subtotal}">
                <span class="badge bg-warning text-dark fs-6 px-3 py-2 precio-item">${subtotal.toFixed(2)}</span>
            </div>

            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger w-100" onclick="eliminarProducto(${contadorProductos})">
                    <i class="fa fa-trash me-1"></i>
                </button>
            </div>
        </div>
    `;

    // contenedor
    contenedor.appendChild(div);

    // se define en vacio
    productoSelect.value = '';
    cantidadInput.value = '';
    precioInput.value = '';
    delete precioInput.dataset.precioUnitario;

    // se defina en vacio
    document.getElementById('errorCantidad').textContent = '';
    document.getElementById('errorPrecio').textContent = '';

    // llama a las funciones
    actualizarContadorProductos();
    actualizarSubtotal();
}

// funcion para aliminar un producto
function eliminarProducto(id) {

    // se define valor
    const elemento = document.getElementById(`producto_${id}`);
    
    // valida
    if (elemento) {

        //accion de remove
        elemento.remove();

        // llama funcion
        actualizarContadorProductos();
        actualizarSubtotal();
    }
}

// funion que cuenta los productos
function actualizarContadorProductos() {

    // se define valores
    const total = document.querySelectorAll('[id^="producto_"]').length;
    const contadorElement = document.getElementById('contadorProductos');
    
    // valida
    if (contadorElement) {
        contadorElement.textContent = total;
    }
}

// llama la funion que carga las promo
cargarPromocion();

//FUNCION PARA CLIENTES
// funcion para cargar dias de credito del cliente
function cargarCreditoCliente() {
    fetch('index.php?url=tipos_clientes&action=obtener_tipos_clientes')
        .then(response => response.json())
        .then(data => {
            data.data.forEach(tipo => {
                // Busca por data-tipo-id (NO por value=id_cliente)
                const option = document.querySelector(`#clienteId option[data-tipo-id="${tipo.id_tipo_cliente}"]`);
                if (option) {
                    option.dataset.dias = tipo.dias_credito;  // Actualiza si cambió
                }
            });
        })
        .catch(console.error);
}


// funcion carga dias de credito
function cargarDiasCredito() {
    const clienteSelect = document.getElementById('clienteId');
    const diasCreditoInput = document.getElementById('diasCredito');
    const opcion = clienteSelect.options[clienteSelect.selectedIndex];

    diasCreditoInput.value = opcion.dataset.dias || '';
}

// Lláma la funcion:
document.addEventListener('DOMContentLoaded', cargarCreditoCliente);


// ==========================================
// FUNCIONES PARA EL MODAL DE MODIFICAR PEDIDO
// ==========================================

// Variables específicas para el modal de modificar
let contadorProductosEdit = 0; // Contador específico para modificar
let productosEditAgregados = []; // Almacena productos agregados en editar

// Inicializar al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    cargarPromocionesEdit();
});

// 1. CARGAR PROMOCIONES PARA MODIFICAR
function cargarPromocionesEdit() {
    fetch('index.php?url=promociones&action=obtener_promociones')
        .then(response => response.json())
        .then(data => {
            promocionesActivas = (data.status && Array.isArray(data.data)) ? data.data : [];
        })
        .catch(error => {
            console.error('Error cargando promociones:', error);
            promocionesActivas = [];
        });
}

// 2. CARGAR DÍAS DE CRÉDITO PARA MODIFICAR
function cargarDiasCreditoEdit() {
    const clienteSelect = document.getElementById('clienteIdEdit');
    const diasCreditoInput = document.getElementById('diasCreditoEdit');
    
    if (clienteSelect && clienteSelect.value) {
        const opcion = clienteSelect.options[clienteSelect.selectedIndex];
        diasCreditoInput.value = opcion.dataset.dias || '';
    } else {
        diasCreditoInput.value = '';
    }
}

// 3. RECALCULAR PROMOCIONES PARA MODIFICAR
function recalcularPromocionesEdit() {
    document.querySelectorAll('#listaProductosEdit .cantidad-item-edit').forEach(inputCantidad => {
        actualizarPrecioFilaEdit(inputCantidad);
    });
}

// 4. OBTENER PROMOCIÓN SELECCIONADA (EDIT)
function obtenerPromocionSeleccionadaEdit() {
    const promoSelect = document.getElementById('promocionIdEdit');
    const promoId = promoSelect.value;
    
    if (!promoId) return null;
    return promocionesActivas.find(p => String(p.id_promocion) === String(promoId)) || null;
}

// 5. VERIFICAR SI PRODUCTO PERTENECE A PROMOCIÓN (EDIT)
function productoPerteneceAPromocionEdit(productoId, promo) {
    if (!promo || !promo.id_productos) return false;
    const ids = String(promo.id_productos).split(',').map(id => id.trim());
    return ids.includes(String(productoId).trim());
}

// 6. CALCULAR PRECIO CON PROMOCIÓN (EDIT)
function calcularPrecioConPromocionEdit(cantidad, precioUnitario, promo) {
    const qty = Number(cantidad) || 0;
    const price = Number(precioUnitario) || 0;
    let subtotal = qty * price;
    
    if (!promo) return subtotal;
    
    const tipo = String(promo.tipo_descuento || '').trim().toLowerCase();
    
    if (tipo === '2x1') {
        const pagas = Math.ceil(qty / 2);
        subtotal = pagas * price;
    } else if (tipo === 'porcentaje') {
        const porcentaje = Number(promo.valor_descuento) || 0;
        subtotal = subtotal - (subtotal * porcentaje / 100);
    }
    
    return subtotal;
}

// 7. CARGAR PRECIO PRODUCTO (EDIT)
function cargarPrecioProductoEdit() {
    const productoSelect = document.getElementById('productosEdit');
    const precioInput = document.getElementById('precioProductoEdit');
    const opcion = productoSelect.options[productoSelect.selectedIndex];
    
    if (opcion.dataset.precio) {
        precioInput.dataset.precioUnitario = opcion.dataset.precio;
        actualizarPrecioProductoEdit();
    }
}

// 8. ACTUALIZAR PRECIO PRODUCTO (EDIT)
function actualizarPrecioProductoEdit() {
    const cantidadInput = document.getElementById('cantidadProductoEdit');
    const precioInput = document.getElementById('precioProductoEdit');
    
    const cantidad = parseFloat(cantidadInput.value) || 0;
    const precioUnitario = parseFloat(precioInput.dataset.precioUnitario || 0);
    
    if (cantidad > 0 && precioUnitario > 0) {
        precioInput.value = (cantidad * precioUnitario).toFixed(2);
    } else {
        precioInput.value = precioUnitario ? precioUnitario.toFixed(2) : '';
    }
}

// 9. ACTUALIZAR PRECIO FILA (EDIT)
function actualizarPrecioFilaEdit(inputCantidad) {
    const fila = inputCantidad.closest('.producto-edit-row');
    const precioBadge = fila.querySelector('.precio-item-edit');
    const hiddenPrecio = fila.querySelector('.precio-hidden-edit');
    const productoIdInput = fila.querySelector('.producto-id-edit');
    
    const cantidad = Number(inputCantidad.value) || 0;
    const precioUnitario = Number(inputCantidad.dataset.precioUnitario) || 0;
    const productoId = productoIdInput.value;
    
    const promoSeleccionada = obtenerPromocionSeleccionadaEdit();
    let promo = null;
    
    if (promoSeleccionada && productoPerteneceAPromocionEdit(productoId, promoSeleccionada)) {
        promo = promoSeleccionada;
    }
    
    const nuevoSubtotal = calcularPrecioConPromocionEdit(cantidad, precioUnitario, promo);
    
    precioBadge.textContent = nuevoSubtotal.toFixed(2);
    hiddenPrecio.value = nuevoSubtotal.toFixed(2);
    
    actualizarSubtotalEdit();
}

// 10. ACTUALIZAR SUBTOTAL (EDIT)
function actualizarSubtotalEdit() {
    let subtotal = 0;
    document.querySelectorAll('#listaProductosEdit .precio-hidden-edit').forEach(input => {
        subtotal += parseFloat(input.value) || 0;
    });
    
    const subtotalInput = document.getElementById('subtotalEdit');
    if (subtotalInput) {
        subtotalInput.value = subtotal.toFixed(2);
    }
    
    actualizarTotalConIvaEdit();
}

// 11. ACTUALIZAR TOTAL CON IVA (EDIT)
function actualizarTotalConIvaEdit() {
    const subtotalInput = document.getElementById('subtotalEdit');
    const totalInput = document.getElementById('totalPedidoEdit');
    const aplicarIva = document.getElementById('aplicarIvaEdit');
    
    const subtotal = parseFloat(subtotalInput.value) || 0;
    const iva = 0.16;
    
    if (aplicarIva && aplicarIva.checked) {
        totalInput.value = (subtotal * (1 + iva)).toFixed(2);
    } else {
        totalInput.value = subtotal.toFixed(2);
    }
}

// 12. AGREGAR/MODIFICAR PRODUCTO (EDIT)
function agregarProductoEdit() {
    const productoSelect = document.getElementById('productosEdit');
    const cantidadInput = document.getElementById('cantidadProductoEdit');
    const precioInput = document.getElementById('precioProductoEdit');
    
    if (!productoSelect.value || !cantidadInput.value || cantidadInput.value <= 0) {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Seleccione un producto e ingrese cantidad válida',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
        });
        return;
    }
    
    contadorProductosEdit++;
    const contenedor = document.getElementById('listaProductosEdit');
    
    const productoId = productoSelect.value;
    const productoSeleccionado = productoSelect.options[productoSelect.selectedIndex].text;
    const cantidad = parseFloat(cantidadInput.value) || 0;
    const precioUnitario = parseFloat(precioInput.dataset.precioUnitario || 0);
    
    const promoSeleccionada = obtenerPromocionSeleccionadaEdit();
    let promo = null;
    
    if (promoSeleccionada && productoPerteneceAPromocionEdit(productoId, promoSeleccionada)) {
        promo = promoSeleccionada;
        mostrarAlertaPromocionEdit(promo);
    }
    
    let subtotal = calcularPrecioConPromocionEdit(cantidad, precioUnitario, promo);
    
    // Verificar si ya existe el producto
    const productoExistente = Array.from(contenedor.children).find(child => 
        child.querySelector('.producto-id-edit')?.value === productoId
    );
    
    if (productoExistente) {
        // Actualizar existente
        const cantidadInputExist = productoExistente.querySelector('.cantidad-item-edit');
        const precioBadgeExist = productoExistente.querySelector('.precio-item-edit');
        const hiddenPrecioExist = productoExistente.querySelector('.precio-hidden-edit');
        
        cantidadInputExist.value = cantidad;
        cantidadInputExist.dataset.precioUnitario = precioUnitario;
        precioBadgeExist.textContent = subtotal.toFixed(2);
        hiddenPrecioExist.value = subtotal.toFixed(2);
    } else {
        // Crear nuevo
        const div = document.createElement('div');
        div.className = 'producto-edit-row alert alert-info mb-2 p-3';
        div.id = `productoEdit_${contadorProductosEdit}`;
        
        div.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
                <div class="flex-grow-1">
                    <strong class="d-block mb-1">${productoSeleccionado}</strong>
                    <input type="hidden" class="producto-id-edit" value="${productoId}">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">Cant:</span>
                        <input type="number" class="form-control cantidad-item-edit" 
                               value="${cantidad}" min="1" 
                               data-precio-unitario="${precioUnitario}"
                               oninput="actualizarPrecioFilaEdit(this)">
                        <span class="input-group-text">Precio: $<span class="precio-item-edit">${subtotal.toFixed(2)}</span></span>
                        <input type="hidden" class="precio-hidden-edit" value="${subtotal}">
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger ms-2" 
                        onclick="removerProductoEdit(this)">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        `;
        
        contenedor.appendChild(div);
    }
    
    // Limpiar campos
    productoSelect.value = '';
    cantidadInput.value = '';
    precioInput.value = '';
    delete precioInput.dataset.precioUnitario;
    
    actualizarSubtotalEdit();
}

// 13. MOSTRAR ALERTA PROMOCIÓN (EDIT)
function mostrarAlertaPromocionEdit(promo) {
    Swal.fire({
        icon: 'info',
        title: '¡Producto en promoción!',
        text: promo.nombre_promocion,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
    });
}

// 14. REMOVER PRODUCTO (EDIT)
function removerProductoEdit(button) {
    const fila = button.closest('.producto-edit-row');
    if (fila) {
        fila.remove();
        actualizarSubtotalEdit();
    }
}

// 15. FUNCIÓN PRINCIPAL PARA INICIALIZAR TODO EN MODIFICAR
function inicializarModalModificar() {
    contadorProductosEdit = 0;
    document.getElementById('listaProductosEdit').innerHTML = '';
    document.getElementById('subtotalEdit').value = '0.00';
    document.getElementById('totalPedidoEdi').value = '0.00';
    document.getElementById('aplicarIvaEdit').checked = false;
}

// Al final de ObtenerPedido(), después de cargar productos:
//inicializarModalModificar();
// Llamar cargarDiasCreditoEdit() ya está incluido