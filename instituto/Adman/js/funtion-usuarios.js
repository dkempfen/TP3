   
    var tableusuarios

    /*var tableusuarios = $('#tableUsuarios').DataTable({
        "paging": false, // Disable pagination
        "lengthMenu": [25, 50, 100, -1], // Show different lengths of records per page, -1 means "All"
      })
   /* function isValidInput(value) {
        return value.trim() !== '';
    }
    
    function openModal() {
        document.getElementById('idusuario').value = "";
        document.querySelector('.modal-header').classList.replace("headerUpdate","headerRegister");
        document.getElementById('btnActionForm').classList.replace("btn-info","btn-primary");
        document.getElementById('btntext').innerHTML = 'Guardar';
        document.getElementById('tituloModal').innerHTML = 'Nuevo Usuario';
        document.getElementById('formUsuario').reset();
        $('#modalUsuario').modal('show');
    }
    
   $(document).ready(function() {
        var tableusuarios = $('#tableUsuarios').DataTable();
    
        $('.btn-primary').on('click', function() {
            openModal();
        });
    
        var formUsuario = document.getElementById('formUsuario');
        formUsuario.onsubmit = function(e) {
            e.preventDefault();
    
            var nombre = document.getElementById('nombre').value.trim();
            var usuario = document.getElementById('usuario').value.trim();
            var mail = document.getElementById('mail').value.trim();
            var clave = document.getElementById('clave').value.trim();
            var rol = document.getElementById('listRol').value;
            var estado = document.getElementById('listEstado').value;
    
    
            if (!isValidInput(nombre) || !isValidInput(usuario) || !isValidInput(mail) || !isValidInput(clave)) {
                swal('Atención', 'Todos los campos son necesarios', 'error');
                return false;
            }
    
            var formData = new FormData();
            formData.append('nombre', nombre);
            formData.append('usuario', usuario);
            formData.append('mail', mail);
            formData.append('clave', clave);
            formData.append('listRol', rol);
            formData.append('listEstado', estado);
    
            var request = new XMLHttpRequest();
            var url = '/instituto/Includes/sql.php'; // Reemplaza con la ruta correcta a tu archivo PHP
            request.open('POST', url, true);
    
            request.onreadystatechange = function() {
                if (request.readyState == 4) {
                    if (request.status == 200) {
                        var data = JSON.parse(request.responseText);
                        if (data.status) {
                            $('#modalUsuario').modal('hide');
                            formUsuario.reset();
                            swal('Usuario', 'El usuario se insertó correctamente', 'success');
                            // Realiza acciones adicionales si es necesario
                            tableusuarios.ajax.reload(); // Recarga la tabla DataTables después de una inserción exitosa
                        } else {
                            swal('Usuario', 'Error al insertar usuario.', 'error');
                        }
                    } else {
                        swal('Error', 'Ocurrió un error al realizar la petición.', 'error');
                    }
                }
            };
    
            request.send(formData);
        };
    
        // AJAX request to load user states on page load
        $.ajax({
            url: "/instituto/Includes/sql.php", // Reemplaza con la ruta correcta a tu archivo PHP
            type: "POST",
            data: {
                get_users_state: true
            },
            success: function(data) {
                var usersState = JSON.parse(data);
                for (var usuario_id in usersState) {
                    var estado = usersState[usuario_id];
                    var checkbox = $('input[data-usuario-id="' + usuario_id + '"]');
                    checkbox.prop("checked", estado === "activo");
                }
            },
            error: function(error) { // Eliminamos 'xhr' de los parámetros de la función
                console.log("Error en la solicitud AJAX:", error); // Imprime el mensaje de error en la consola
            }
        });
    
        // Event to change user state via AJAX
        $(".onoffswitch-checkbox").on("change", function() {
            var usuario_id = $(this).data("usuario-id");
            var estado = this.checked ? 'activo' : 'inactivo';
    
            $.ajax({
                url: "/instituto/Includes/sql.php", // Reemplaza con la ruta correcta a tu archivo PHP
                type: "POST",
                data: {
                    usuario_id: usuario_id,
                    estado: estado
                },
                success: function(response) {
                    console.log(response);
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                },
                error: function(error) { // Eliminamos 'xhr' de los parámetros de la función
                    console.log("Error en la solicitud AJAX:", error); // Imprime el mensaje de error en la consola
                }
            });
        });
    });*/