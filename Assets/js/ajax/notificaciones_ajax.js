// Funciones AJAX para notificaciones

function ObtenerNotificacion(id) {
    fetch('index.php?url=notificaciones&action=obtener&ID=' + id)
        .then(response => response.json())
        .then(data => {
            if (data) {
                document.getElementById('id').value = data.id_notificaciones;
                document.getElementById('idUsuarioEdit').value = data.id_usuario;
                document.getElementById('descripcionNotificacionEdit').value = data.descripcion_notificacion;
                document.getElementById('enlaceNotificacionEdit').value = data.enlace;
            }
        })
        .catch(error => {
            console.error('Error al obtener la notificacion:', error);
            alert('Error al obtener la notificacion');
        });
}

function EliminarNotificacion(event, id) {
    event.preventDefault();
    
    if (confirm('¿Esta seguro de que desea eliminar esta notificacion?')) {
        window.location.href = 'index.php?url=notificaciones&action=eliminar&ID=' + id;
    }
    
    return false;
}
