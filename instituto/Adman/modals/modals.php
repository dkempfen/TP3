<div class="modal fade" id="modalUsuario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title fs-5" id="tituloModal">Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#datos" role="tab">Datos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#datosAdicionales" role="tab">Datos Adicionales</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Datos -->
                    <div class="tab-pane active" id="datos" role="tabpanel">
                        <form id="formUsuario" name="formUsuario" action="/instituto/Includes/sql.php" method="POST">
                            <input type="hidden" name="action" value="insert">
                            <input type="hidden" name="idusuario" id="idusuario" value="">
                            <div class="form-group">
                                <label for="control-label">Nombre:</label>
                                <input type="text" class="form-control" name="nombre" id="nombre">
                            </div>
                            <div class="form-group">
                                <label for="control-label">Apellido:</label>
                                <input type="text" class="form-control" name="apellido" id="apellido">
                            </div>
                            <div class="form-group">
                                <label for="control-label">Fecha Nacimiento:</label>
                                <input type="date" class="form-control" name="fechanacimiento" id="fechanacimiento">
                            </div>
                            <div class="form-group">
                                <label for="control-label">Telefono:</label>
                                <input type="tel" class="form-control" name="telefono" id="telefono">
                            </div>
                            <div class="form-group">
                                <label for="control-label">Mail:</label>
                                <input type="text" class="form-control" name="mail" id="mail">
                            </div>
                            <div class="form-group">
                                <label for="control-label">Domicilio:</label>
                                <input type="text" class="form-control" name="domicilio" id="domicilio">
                            </div>


                        </form>
                    </div>

                    <!-- Datos Adicionales -->
                    <div class="tab-pane" id="datosAdicionales" role="tabpanel">
                        <form id="formDatosAdicionales" name="formDatosAdicionales" action="/instituto/Includes/sql.php"
                            method="POST">
                            <input type="hidden" name="action" value="insert">
                            <input type="hidden" name="idusuarios" id="idusuarios" value="">
                            <div class="form-group">
                                <label for="control-label">Usuario:</label>
                                <input type="text" class="form-control" name="usuario" id="usuario">
                            </div>
                            <div class="form-group">
                                <label for="control-label">Legajo:</label>
                                <input type="text" class="form-control" name="legajo" id="legajo">
                            </div>
                            <div class="form-group">
                                <label for="control-label">Contraseña:</label>
                                <input type="text" class="form-control" name="clave" id="clave">
                            </div>
                            <div class="form-group">
                                <label for="control-label">Plan:</label>
                                <input type="text" class="form-control" name="plan" id="plan">
                            </div>
                            <div class="form-group">
                                <label for="control-label">Matriz:</label>
                                <input type="text" class="form-control" name="matriz" id="matriz">
                            </div>

                            <div class="form-group">
                                <label for="listRol">Rol</label>
                                <select class="form-control" name="listRol" id="listRol">
                                    <option value="1">Administrador</option>
                                    <option value="2">Profesor</option>
                                    <option value="3">Alumno</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="listEstado">Estado</label>
                                <select class="form-control" name="listEstado" id="listEstado">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button id="btnActionForm" class="btn btn-primary">Guardar</button>

            </div>
        </div>
    </div>
</div>
</div>

<!-- Agrega SweetAlert2 y jQuery a tu página -->


<script>
function isValidInput(value) {
    return value.trim() !== '';
}

function openModal() {
    document.getElementById('idusuario').value = "";
    document.getElementById('idusuarios').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.getElementById('btnActionForm').classList.replace("btn-info", "btn-primary");
    document.getElementById('btnActionForm').innerHTML = 'Guardar';
    document.getElementById('tituloModal').innerHTML = 'Nuevo Usuario';
    document.getElementById('formUsuario').reset();
    document.getElementById('formDatosAdicionales').reset();

    $('#modalUsuario').modal('show');
}


$(document).ready(function() {
    var tableusuarios = $('#tableUsuarios').DataTable();

    $('.btn-primary').on('click', function() {
        openModal();
    });

    var formUsuario = document.getElementById('formUsuario');
    var formDatosAdicionales = document.getElementById('formDatosAdicionales');


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
            console.log("Error en la solicitud AJAX:",
            error); // Imprime el mensaje de error en la consola
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
                console.log("Error en la solicitud AJAX:",
                error); // Imprime el mensaje de error en la consola
            }
        });
    });


});



</script>