
// funcion para validar nombre del formulario
function validar_nombre() {

  var nombre = document.getElementById('nombreCategoria');
  var error = document.getElementById('errorCategoria');

  error.innerHTML = ''; // limpia el mensaje
  //icono.innerHTML = ''; // limpia el icono
  nombre.classList.remove('input-error' , 'input-valid');


  const regex = /^[a-zA-Z\s]+$/;
  var valor = nombre.value.trim();

  // si el nombre esta vacio improme error
  if (valor === '') {
    error.innerHTML = 'Este campo no puede estar vacío.';
    nombre.classList.add('input-error');
    nombre.classList.add('is-invalid');  // clase bootstrap para borde rojo
    nombre.classList.remove('is-valid');
    return false;
  }

  // valida si el nombre cumple con las longitudes de caracteres
  if (valor.length < 5 || valor.length > 20) {
    error.innerHTML = 'El nombre de la categoria debe tener minimo 5 y maximo 20 caracteres.';
    nombre.classList.add('input-error');
    nombre.classList.add('is-invalid');  // clase bootstrap para borde rojo
    nombre.classList.remove('is-valid');
    return false;
  }

  // valida si el formato y es valido y los caracteres especiales admitidos
  if (!regex.test(valor)) {
    error.innerHTML = "El nombre de la categoria no debe tener catacteres especiales y tampoco numeros  ej:Bebida .";
    nombre.classList.add('input-error');
    nombre.classList.add('is-invalid');  // clase bootstrap para borde rojo
    nombre.classList.remove('is-valid');
    return false;
  }

  // Si pasa todas las validaciones
  error.innerHTML = '';
  nombre.classList.add('input-valid');
  nombre.classList.add('is-valid');    // clase bootstrap para borde verde
  nombre.classList.remove('is-invalid');
  return true;
}

// funcion de para validar formulario
function validar_formulario() {

  // almacena el valor
  const nombre_valido = validar_nombre();

  // valida el resulto y retorna true o false
  if (nombre_valido) {

    //retorna true para enviar el form al servidor
    return true;
    
  }else{
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Por favor corrige los campos.',
      confirmButtonText: 'Aceptar',
      timer: 6000,
      timerProgressBar: true,
    });
    return false;
  }
}

// funciones para validar el nombre del formulario de modificar
function validar_nombre_modificado() {

  var nombre = document.getElementById('nombreCategoriaEdit');
  var error = document.getElementById('errorCategoriaEdit');

  error.innerHTML = ''; // limpia el mensaje
  nombre.classList.remove('input-error' , 'input-valid');

  const regex = /^[a-zA-Z\s]+$/;
  var valor = nombre.value.trim();

  // si el nombre esta vacio improme error
  if (valor === '') {
    error.innerHTML = 'Este campo no puede estar vacío.';
    nombre.classList.add('input-error');
    nombre.classList.add('is-invalid');  // clase bootstrap para borde rojo
    nombre.classList.remove('is-valid');
    return false;
  }

  // valida si el nombre cumple con las longitudes de caracteres
  if (valor.length < 5 || valor.length > 20) {
    error.innerHTML = 'El nombre de la categoria debe tener minimo 5 y maximo 20 caracteres.';
    nombre.classList.add('input-error');
    nombre.classList.add('is-invalid');  // clase bootstrap para borde rojo
    nombre.classList.remove('is-valid');
    return false;
  }

  // valida si el formato y es valido y los caracteres especiales admitidos
  if (!regex.test(valor)) {
    error.innerHTML = "El nombre de la categoria no debe tener catacteres especiales y tampoco numeros  ej:Bebida .";
    nombre.classList.add('input-error');
    nombre.classList.add('is-invalid');  // clase bootstrap para borde rojo
    nombre.classList.remove('is-valid');
    return false;
  }

  // Si pasa todas las validaciones
  error.innerHTML = '';
  nombre.classList.add('input-valid');
  nombre.classList.add('is-valid');    // clase bootstrap para borde verde
  nombre.classList.remove('is-invalid');
  return true;
}

// funcion paravalidad formulario de modificacion
function validar_formulario_modificado() {

  // almacena el valor
  const nombre_valido = validar_nombre_modificado();

  // valida el resulto y retorna true o false
  if (nombre_valido) {

    // retorna true en caso de exito
    return true;
    
  }else{

    // maneja los errores
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Por favor corrige los campos.',
      confirmButtonText: 'Aceptar',
      timer: 6000,
      timerProgressBar: true,
    });

    //retorna false en caso de error
    return false;
  }
}

// funcion para validar si quiere eliminar el registro
function EliminarCategoria(event, id){

  // evitar navegación inmediata
  event.preventDefault(); 

  // se establece URL del enlace
  const url = "index.php?url=categorias&action=eliminar&ID=" + id; 

  // confirmacion de la accion
  Swal.fire({
  title: '¿Estás seguro?',
  text: "¡Deseas eliminar la categoria. No podrás revertir esto!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Sí, eliminar',
  cancelButtonText: 'Cancelar'
}).then((result) => {
  if (result.isConfirmed) {

    // Si confirma, redirige a la URL
      window.location.href = url;
  } 
  else {

    // Aquíse manejar la cancelación si lo deseas
    Swal.fire({
      title: 'Cancelado',
      text: 'Se cancelo la accion.',
      icon: 'info',
      timer: 1800,
      timerProgressBar: true,
    });
  }
});

}