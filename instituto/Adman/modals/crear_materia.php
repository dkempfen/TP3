<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/Pantallas/lista_personas.php';



$DatosMateria = DatosMateria();


?>


<?php



foreach ($DatosMateria as $DatosMateria) {
    // Code to process $DatosPersona goes here
 ?>



<div class="modal fade" id="modalCrearUsuario_<?php echo $DatosMateria['id_Materia']; ?>" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title fs-5" id="tituloModalCrearUser">Crear Usuairo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="formCrearUsuario" name="formCrearUsuario" action="/instituto/Includes/slqeditar.php"
                    method="POST">

                    <input type="hidden" name="dniCrear" id="dniCrear" value="<?php  echo $DatosMateria['id_Materia']?>">


                    <div class="form-group">
                        <label for="control-label">Carrera:</label>
                         <!-- <input type="number" class="form-control" name="dniUser" id="dniUser" required>-->

                         <input type="number" class="form-control" name="carreraMateria" id="carreraMateria" required>

                    </div>
                    <div class="form-group">
                        <label for="control-label">Id_Usuario:</label>
                        <input type="text" class="form-control" name="IdUser" id="IdUser" required>
                    </div>
                    <div class="form-group">
                        <label for="control-label">Legajo:</label>
                        <input type="text" class="form-control" name="legajo" id="legajo" required>
                    </div>
                    <div class="form-group">
                        <label for="control-label">User:</label>
                        <input type="text" class="form-control" name="user" id="user" required>
                    </div>
                    <div class="form-group">
                        <label for="control-label">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="control-label">Libro Matriz:</label>
                        <input type="text" class="form-control" name="libromatriz" id="libromatriz">
                    </div>
                    <div class="form-group">
                        <label for="control-label">Plan:</label>
                        <!--<input type="text" class="form-control" name="plan" id="plan">-->
                        <select class="form-control" name="plan" id="plan" required>
                            <option value="">--Selecione--</option>
                            <option value="5817/03">5817/03</option>
                            <option value="6790/19">6790/19</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="control-label">Rol:</label>
                         <!--<input type="text" class="form-control" name="rol" id="rol">-->
                       <select class="form-control" name="rol" id="rol" required>
                            <option value="">--Selecione--</option>
                            <option value="3">Administrador</option>
                            <option value="1">Alumno</option>
                            <option value="2">Profesor</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="control-label">Estado:</label>
                       <!-- <input type="text" class="form-control" name="estadoUser" id="estadoUser">-->
                        <select class="form-control" name="estadoUser" id="estadoUser" required>
                            <option value="">--Selecione--</option>
                            <option value="1">Habilitado</option>
                            <option value="2">Inhabilitado</option>

                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="btnActionAltaUserForm" class="btn btn-primary btn-open-modal" type="submit"
                            name="btnmCrearUser">
                            <span id="btnCrearUser">Guardar</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<?php } ?>



<!-- Agrega SweetAlert2 y jQuery a tu página -->

<script>
function isValidInput(value) {
    return value.trim() !== '';
}

function openModalsMateriaEdi  (usuario_id) {
    document.getElementById('idusuariocrear').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.getElementById('btnActionAltaUserForm').classList.replace("btn-info", "btn-open-modal");
    document.getElementById('btnCrearUser').innerHTML = 'Guardar';
    document.getElementById('tituloModalCrearUser').innerHTML = 'Crear Usuario';
    document.getElementById('formCrearUsuario').reset();
    var modalIdUser = "#modalCrearUsuario_" + usuario_id;
    $(modalIdUser).modal('show');
    $('#modalCrearUsuario_').modal('show');
    var usuario_id = DatosUsuarios(); // Debes implementar esta función

}

$(document).ready(function() {
    var tableusuarios = $('#tableUsuarios').DataTable();
    $('#formCrearUsuario').on('submit', function(event) {
        event.preventDefault(); //
        console.log('Botón Guardar clickeado');
        var carreraMateria = $("#carreraMateria").text(); // Usar "dniUser" en lugar de "dni"
        var IdUser = $("#IdUser").val();
        var legajo = $("#legajo").val();
        var user = $("#user").val();
        var password = $("#password").val();
        var libromatriz = $("#libromatriz").val();
        var plan = $("#plan").val();
        var rol = $("#rol").val();
        var idusuariocrear = $("#idusuariocrear").val();
        var estadoUser = $("#estadoUser").val(); // En lugar de "estadoUser", usar "estadoUser" si es un campo de selección

        console.log('Estado del campo de selección "estadoUser":', estadoUser);

        // Realizar la petición AJAX para insertar o actualizar datos
        $.ajax({
            url: "/instituto/Includes/slqeditar.php", // Reemplaza con la ruta correcta a tu archivo PHP
            type: "POST",
            data: {
                idusuariocrear: idusuariocrear,
                carreraMateria: carreraMateria,
                IdUser: IdUser,
                legajo: legajo,
                user: user,
                password: password,
                libromatriz: libromatriz,
                plan: plan,
                rol: rol,
                estadoUser: estadoUser,
                btnmCrearUser: 0
            },
            
            success: function(response) {
                // Verificar la respuesta del servidor
                if (response.success) {
                    // Cerrar el modal
                    $('#modalUsuarioCrear').modal('hide');

                    // Mostrar mensaje de éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Datos guardados exitosamente',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.reload();
                    });
                } else {
                    // Mostrar mensaje de error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al guardar los datos',
                        text: response.message
                    });
                }
            },
            error: function(error) {
                console.log("Error en la solicitud AJAX:", error);
            }
        });
    });




});
</script>