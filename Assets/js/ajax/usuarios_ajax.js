function ObtenerUsuario(id) {

  fetch('index.php?url=usuarios&action=obtener&ID=' + id)
    
    .then(response => response.json())
    
    .then(data => {
    
      //console.log(data);
    
      document.getElementById('id_usuarioEdit').value = data.id_usuario;
      document.getElementById('nombre_usuarioEdit').value = data.nombre_usuario;
      document.getElementById('email_usuarioEdit').value = data.email_usuario;
      document.getElementById('id_rolEdit').value = data.id_rol_usuario;
    
    })
    
    .catch(error => {
    
      console.error('Error:', error);
    
    });
  
  }