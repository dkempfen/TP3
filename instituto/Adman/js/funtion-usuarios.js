$('#tableUsuarios').DataTable();

var tableusuarios;

document.addEventListener('DOMContentLoaded', function() {
  var formUsuario = document.querySelector('#formUsuario');
  formUsuario.onsubmit = function(e) {
    e.preventDefault(); // Evita que se recargue la página

    var nombre = document.querySelector('#nombre').value;
    var usuario = document.querySelector('#usuario').value;
    var clave = document.querySelector('#clave').value;
    var rol = document.querySelector('#listRol').value;
    var estado = document.querySelector('#listEstado').value;

    // Validar campos requeridos
    if (nombre === '' || usuario === '' || clave === '') {
      swal('Atención', 'Todos los campos son necesarios', 'error');
      return false;
    }

    // Crear un objeto FormData con los datos del formulario
    var formData = new FormData();
    formData.append('nombre', nombre);
    formData.append('usuario', usuario);
    formData.append('clave', clave);
    formData.append('listRol', rol);
    formData.append('listEstado', estado);

    // Realizar la petición AJAX para insertar el usuario
    var request = new XMLHttpRequest();
    var url = '/instituto/Includes/sql.php'; // Reemplaza con la ruta correcta
    request.open('POST', url, true);

    request.onreadystatechange = function() {
      if (request.readyState == 4 && request.status == 200) {
        var data = JSON.parse(request.responseText);
        if (data.status) {
          $('#modalUsuario').modal('hide'); // Oculta el modal
          formUsuario.reset(); // Reinicia el formulario
          swal('Usuario', data.msg, 'success');
          // Aquí puedes realizar alguna acción adicional si es necesario
        } else {
          swal('Usuario', data.msg, 'error');
        }
      }
    };

    request.send(formData);
  };
});

function openModal() {
  document.querySelector('#tituloModal').innerHTML = 'Nuevo Usuario';
  document.querySelector('#formUsuario').reset();
  $('#modalUsuario').modal('show');
}


function editarUsuario(id){
var idusuario = id;

        document.querySelector('#tituloModal').innerHTML ='Actualizar Uusario';
        document.querySelector('#action').innerHTML ='Actualizar';
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
        var url ='/instituto/Adman/models/usuarios/edit_usuarios.php?'+idusuario;
        request.open('GET',URL,true);
        request.send();
        request.onreadystatechange=function(){
          if(request.readyState == 4 && request.status == 200){//validad que todo este ok{
                var data = JSON.parse(request.responseText);
                  if(request.status){
                  document.querySelector('#idusuario').value =data.data.usuario_id;
                  document.querySelector('#nombre').value =data.data.nombre;
                  document.querySelector('#usuario').value =data.data.usuario;
                  document.querySelector('#listRol').value =data.data.rol;
                  document.querySelector('#listEstado').value =data.data.estado;


                  $('#modalUsuario').modal('show'); 
                }else{
                    swal('Atencion',data.msg,'error');

                }
            }
}
    }
    
    

