<?php
require_once '../includes/load.php';
include_once('../Adman/lista_usuarios.php');

$DatosUsuarios = DatosUsuarios();


?>
<?php foreach ($DatosUsuarios as $DatosUsuarios) { ?>


<div class="modal fade" id="modaleditarUsuario_<?php echo $DatosUsuarios['id_usuario']; ?>" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title fs-5" id="tituloModalEditar">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditarUsuario" name="formEditarUsuario" action="/instituto/Includes/sql.php"
                    method="POST">
                    <input type="hidden" name="idusuarioeditar" id="idusuarioeditar"
                        value="<?php  echo $DatosUsuarios['Id_Usuario']?>" required>
                    <input type="hidden" name="dni_a_editar" id="dni_a_editar"
                        value="<?php  echo $DatosUsuarios['DNI']?>" required>

                    <div class="form-group">
                        <label for="control-label">Legajo:</label>


                        <input type="text" class="form-control" name="legajoeditar" id="legajoeditar"
                            value="<?php  echo $DatosUsuarios['Legajo']?>" required>
                    </div>
                    <div class="form-group">
                        <label for="control-label">Contraseña:</label>
                        <input type="text" class="form-control" name="claveeditar" id="claveeditar"
                            value="<?php echo $DatosUsuarios['Password']; ?>" required>

                    </div>

                    <div class="form-group">
                        <label for="control-label">Plan:</label>
                        <input type="text" class="form-control" name="planeditar" id="planeditar"
                            value="<?php echo $DatosUsuarios['fk_Plan']; ?>" required>

                    </div>
                    <div class="form-group">
                        <label for="control-label">DNI:</label>
                        <input type="text" class="form-control" name="dnieditar" id="dnieditar"
                            value="<?php echo $DatosUsuarios['fk_DNI']; ?>" required>

                    </div>
                    <div class="form-group">
                        <label for="listRol">Rol</label>
                        <select class="form-control" name="listRoleditar" id="listRoleditar" required>
                            <option value="1" <?php echo $DatosUsuarios['descripcion'] == 3 ? 'selected' : ''; ?>>
                                Administrador
                            </option>
                            <option value="2" <?php echo $DatosUsuarios['descripcion'] == 2 ? 'selected' : ''; ?>>
                                Profesor
                            </option>
                            <option value="3" <?php echo $DatosUsuarios['descripcion'] == 1 ? 'selected' : ''; ?>>Alumno
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="listEstado">Estado</label>
                        <select class="form-control" name="listEstadoeditar" id="listEstadoeditar" required>
                            <option value="1"
                                <?php echo $DatosUsuarios['Descripcion_Estado'] == 1 ? 'selected' : ''; ?>>Activo
                            </option>
                            <option value="2"
                                <?php echo $DatosUsuarios['Descripcion_Estado'] == 2 ? 'selected' : ''; ?>>Inactivo
                            </option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="btnActionEditarForm" class="btn btn-primary btn-open-modal" type="submit"
                            name="btnmodificar">
                            <span id="btnEditartext">Guardar</span>
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

function openModals(usuario_id) {
    document.getElementById('idusuarioeditar').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.getElementById('btnActionEditarForm').classList.replace("btn-info", "btn-open-modal");
    document.getElementById('btnEditartext').innerHTML = 'Guardar';
    document.getElementById('tituloModalEditar').innerHTML = 'Modificar Usuario';
    document.getElementById('formEditarUsuario').reset();
    var modalId = "#modaleditarUsuario_" + usuario_id;
    $(modalId).modal('show');
    $('#modaleditarUsuario_').modal('show');
    $('#modaleditarUsuario').modal('show');
    var usuario_id = DatosUsuarios(); // Debes implementar esta función

}

$(document).ready(function() {
    var tableusuarios = $('#tableUsuarios').DataTable();

    $('.btn-open-modal').on('click', function() {
        openModals();
    });

    var formUsuario = document.getElementById('formEditarUsuario');

    // ... Resto del código ...

    // Evento al enviar el formulario de edición de usuario
    $("#formEditarUsuario").on("submit", function(event) {
        event.preventDefault();


        // Obtener los valores del formulario

        var legajo = $("#legajoeditar").val();
        var plan = $("#planeditar").val();
        var dni = $("#dnieditar").val();
        var nombre = $("#nombreeditar").val();
        
        var mail = $("#maileditar").val();
        var clave = $("#claveeditar").val();
        var rol = $("#listRoleditar").val();
        var estado = $("#listEstadoeditar").val();
        var dni_a_editar = $("#dni_a_editar").val();


        // Realizar la petición AJAX para actualizar el usuario

        $.ajax({
            url: "/instituto/Includes/sql.php",
            type: "POST",
            data: {
                legajoeditar: legajo,
                planeditar: plan,
                dnieditar: dni,

                idusuarioeditar: idusuario,
                dni_a_editar: dni,
                nombreeditar: nombre,
                maileditar: mail,
                claveeditar: clave,
                listRoleditar: rol,
                listEstadoeditar: estado,
                btnmodificar: 1 // Agrega una marca para indicar que es una solicitud de modificación
            },
            success: function(response) {
                console.log(response);
                setTimeout(function() {
                    window.location.href = "/instituto/Adman/lista_usuarios.php";
                }, 2000);
            },
            error: function(error) {
                console.log("Error en la solicitud AJAX:", error);
            }
        });
    });
});
</script>