function ObtenerPromocion(id) {
  fetch('index.php?url=promociones&action=obtener&ID=' + id)
    .then(response => response.json())
    .then(data => {
      //console.log('Datos recibidos:', data);

      document.getElementById('id').value = data.id_promocion;
      document.getElementById('nombrePromocionEdit').value = data.nombre_promocion;
      document.getElementById('descripcionPromocionEdit').value = data.descripcion_promocion;
      document.getElementById('productosEdit').value = data.id_producto;
      document.getElementById('tipoPromocionEdit').value = data.tipo_descuento;
      document.getElementById('valorPromocionEdit').value = data.valor_descuento;
      document.getElementById('fechaInicioEdit').value = data.fecha_inicio;
      document.getElementById('fechaFinEdit').value = data.fecha_fin;
      document.getElementById('estadoPromocionEdit').checked = data.status == 1;

          // Abrir el modal después de cargar los datos
          var modal = new bootstrap.Modal(document.getElementById('promocionModalModificar'));
          modal.show();
        })
        .catch(error => {
          // Abrir el modal aunque falle la carga de productos
          var modal = new bootstrap.Modal(document.getElementById('promocionModalModificar'));
          modal.show();
        });
}

// funcion que consulta el estado
function ConsultarEstadoPromocion() {
    fetch('index.php?url=promociones&action=consultar_estado')
        .then(response => response.json())
        .then(data => {
            // Solo muestra el toast si el modelo indica 'mostrar: true'
            if (data.mostrar === true) {
                if (data.status) {
                    Swal.fire({
                        title: 'Estado de promociones',
                        text: data.msj,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        icon: 'success'
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.msj,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        icon: 'error'
                    });
                }
            }
            // Si data.mostrar === false, no se muestra nada
        })
        .catch(error => {
            // Si el fetch falla (error de red / JSON mal formado)
            Swal.fire({
                title: 'Error de conexión',
                text: 'No se pudo actualizar el estado de las promociones.',
                icon: 'error',
                confirmButtonText: 'Cerrar'
            });
        });
}

// llama lafuncion automaticamente
ConsultarEstadoPromocion();