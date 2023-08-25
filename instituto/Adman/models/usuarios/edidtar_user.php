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
                    <input type="hidden" name="idusuarioeditar" id="idusuarioeditar" value="<?php  echo $DatosUsuarios['Id_Usuario']?>" required>
                    <input type="hidden" name="dni_a_editar" id="dni_a_editar" value="<?php  echo $DatosUsuarios['DNI']?>" required>

                    <div class="form-group">
                        <label for="control-label">Nombre:</label>


                        <input type="text" class="form-control" name="nombreeditar" id="nombreeditar"
                            value="<?php  echo $DatosUsuarios['nombre']?>" required>
                    </div>
                    <div class="form-group">
                        <label for="control-label">Mail:</label>
                        <input type="text" class="form-control" name="maileditar" id="maileditar"
                            value="<?php echo $DatosUsuarios['email']; ?>" required>

                    </div>
                    <div class="form-group">
                        <label for="control-label">Contraseña:</label>
                        <input type="text" class="form-control" name="claveeditar" id="claveeditar"
                            value="<?php echo $DatosUsuarios['clave']; ?>" required>

                    </div>
                    <div class="form-group">
                        <label for="listRol">Rol</label>
                        <select class="form-control" name="listRoleditar" id="listRoleditar" required>
                            <option value="1" <?php echo $DatosUsuarios['descripcion'] == 1 ? 'selected' : ''; ?>>Administrador
                            </option>
                            <option value="2" <?php echo $DatosUsuarios['descripcion'] == 2 ? 'selected' : ''; ?>>Profesor
                            </option>
                            <option value="3" <?php echo $DatosUsuarios['descripcion'] == 3 ? 'selected' : ''; ?>>Alumno
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="listEstado">Estado</label>
                        <select class="form-control" name="listEstadoeditar" id="listEstadoeditar" required>
                            <option value="1" <?php echo $DatosUsuarios['Descripcion_Estado'] == 1 ? 'selected' : ''; ?>>Activo
                            </option>
                            <option value="2" <?php echo $DatosUsuarios['Descripcion_Estado'] == 2 ? 'selected' : ''; ?>>Inactivo
                            </option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="btnActionEditarForm" class="btn btn-primary btn-open-modal" type="submit" name="btnmodificar">
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
        var idusuario = $("#idusuarioeditar").val();
        var nombre = $("#nombreeditar").val();
        var usuario = $("#usuarioeditar").val();
        var mail = $("#maileditar").val();
        var clave = $("#claveeditar").val();
        var rol = $("#listRoleditar").val();
        var estado = $("#listEstadoeditar").val();
        var dni = $("#dni_a_editar").val();

        // Realizar la petición AJAX para actualizar el usuario
        
        $.ajax({
                url: "/instituto/Includes/sql.php", // Reemplaza con la ruta correcta a tu archivo PHP
                type: "POST",
                data: {
                Id_Usuario: idusuario,
                dni_a_editar: dni,
                nombre: nombre,
                usuario: usuario,
                mail: mail,
                clave: clave,
                rol: rol,
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
});
</script>