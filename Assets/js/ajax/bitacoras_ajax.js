function ObtenerBitacora(id) {

  fetch('index.php?url=bitacora&action=obtener&ID=' + id)
    
    .then(response => response.json())
    
    .then(data => {
    
      //console.log(data[0]);

      const bitacora = data[0];
    
      document.getElementById('id_bitacora').value = bitacora.id_bitacora;
      document.getElementById('nombre_usuario').value = bitacora.nombre_usuario;
      document.getElementById('modulo').value = bitacora.modulo;
      document.getElementById('accion').value = bitacora.accion;
      document.getElementById('descripcion').value = bitacora.descripcion;
      document.getElementById('fecha_bitacora').value = bitacora.fecha_bitacora;

    })
    
    .catch(error => {
    
      console.error('Error:', error);
    
    });
  
  }