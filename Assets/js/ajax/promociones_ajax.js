function ObtenerPromocion(id) {
  fetch('index.php?url=promociones&action=obtener&ID=' + id)
    .then(response => response.json())
    .then(data => {
      console.log('Datos recibidos:', data);
      if (data.error) {
        console.error('Error del servidor:', data.error);
        return;
      }
      document.getElementById('id').value = data.id_promocion;
      document.getElementById('codigoPromocionEdit').value = data.codigo_promocion;
      document.getElementById('nombrePromocionEdit').value = data.nombre_promocion;
      document.getElementById('descripcionPromocionEdit').value = data.descripcion;
      document.getElementById('tipoPromocionEdit').value = data.tipo_descuento;
      document.getElementById('valorPromocionEdit').value = data.valor_descuento;
      document.getElementById('fechaInicioEdit').value = data.fecha_inicio;
      document.getElementById('fechaFinEdit').value = data.fecha_fin;
      document.getElementById('estadoPromocionEdit').checked = data.status == 1;

      // Actualizar el placeholder del valor según el tipo
      actualizarPlaceholderEdit();

      // Abrir el modal después de cargar los datos
      var modal = new bootstrap.Modal(document.getElementById('promocionModalModificar'));
      modal.show();
    })
    .catch(error => {
      console.error('Error:', error);
    });
}
