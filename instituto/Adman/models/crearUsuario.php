<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once '../Pantallas/lista_personas.php';

$DatosUsuarios = DatosUsuarios();


?>
<?php foreach ($DatosUsuarios as $DatosUsuarios) { ?>


<div class="modal fade" id="modalCrearUsuario_<?php echo $DatosUsuarios['id_usuario']; ?>" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title fs-5" id="tituloModalEditar">Editar Persona</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditarUsuario" name="formEditarUsuario" action="/instituto/Includes/slqeditar.php"
                    method="POST">
                    <input type="hidden" name="idusuarioeditar" id="idusuarioeditar"
                        value="<?php  echo $DatosUsuarios['Id_Usuario']?>" required>
                    <input type="hidden" name="dni_a_editar" id="dni_a_editar"
                        value="<?php  echo $DatosUsuarios['DNI']?>" required>

                    <div class="form-group">
                        <label for="control-label">DNI:</label>
                        <span id="dniUser" class="form-control"><?php echo $DatosUsuarios['DNI']; ?></span>

                    </div>
                    <div class="form-group">
                        <label for="control-label">Id_Usuario:</label>
                        <input type="text" class="form-control" name="IdUsuario" id="IdUsuario" required>
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
                        <input type="text" class="form-control" name="libromatriz" id="libromatriz" required>
                    </div>
                    <div class="form-group">
                        <label for="control-label">Plan:</label>
                        <input type="text" class="form-control" name="plan" id="plan" required>
                    </div>

                    <div class="form-group">
                        <label for="control-label">Rol:</label>
                        <select class="form-control" name="rol" id="rol" required>
                            <option value="3">Administrador</option>
                            <option value="1">Alumno</option>
                            <option value="2">Profesor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="control-label">Estado:</label>
                        <input type="checkbox" class="form-check-input" name="estadoUser" id="estadoUser">

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

function openModalsCrearUser(usuario_id) {
    document.getElementById('idusuarioeditar').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.getElementById('btnActionEditarForm').classList.replace("btn-info", "btn-open-modal");
    document.getElementById('btnEditartext').innerHTML = 'Guardar';
    document.getElementById('tituloModalEditar').innerHTML = 'Modificar Usuario';
    document.getElementById('formEditarUsuario').reset();
    var modalId = "#modalCrearUsuario_" + usuario_id;
    $(modalId).modal('show');
    $('#modalCrearUsuario_').modal('show');
    $('#modaleditarUsuario').modal('show');
    var usuario_id = DatosUsuarios(); // Debes implementar esta función

}

$(document).ready(function() {
    var tableusuarios = $('#tableUsuarios').DataTable();

    $('#btnActionForm').on('click', function() {
        console.log('Botón Guardar clickeado');
        var dni = $("#dni").val();
        var nombre = $("#IdUsuario").val();
        var apellido = $("#legajo").val();
        var fechanacimiento = $("#user").val();
        var telefono = $("#password").val();
        var email = $("#libromatriz").val();
        var domicilio = $("#plan").val();
        var domicilio = $("#rol").val();

        var inscripto = $("#estadoUser").is(":checked") ? 1 :
            0; // Asigna 1 si está marcado, 0 si no lo está
        var idusuario = $("#idusuario").val();

        console.log('Estado del checkbox "inscripto":', inscripto);


        // Realizar la petición AJAX para insertar o actualizar datos
        $.ajax({
            url: "/instituto/Includes/sqleditar.php", // Reemplaza con la ruta correcta a tu archivo PHP
            type: "POST",
            data: {
                idusuario: idusuario,
                dni: dni,
                IdUsuario: IdUsuario,
                legajo: legajo,
                user: user,
                password: password,
                libromatriz: libromatriz,
                plan: plan,
                rol: rol,
                estadoUser: estadoUser,
                btnaltaPersona: 0
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

    // Obtén el elemento checkbox por su id y agrega un oyente de eventos para el evento "change"
    $('#inscripto').on('change', function() {
        // Obtiene el valor del checkbox (true o false) y realiza alguna acción basada en el valor
        if ($(this).is(':checked')) {
            alert("El usuario está inscrito");
        } else {
            alert("El usuario no está inscrito");
        }
    });

    $("#buscarPersona").on("click", function() {
        // Aquí debes implementar una forma de seleccionar la persona desde la tabla de Personas
        // Puedes abrir un modal o utilizar una ventana emergente para mostrar la lista de personas
        // y permitir al usuario seleccionar una persona.

        // Una vez seleccionada la persona, obtén su DNI y actualiza el elemento <span> correspondiente en el formulario.
        var dniSeleccionado = ObtenerDNIPersonaSeleccionada(); // Implementa esta función para obtener el DNI seleccionado.

        if (dniSeleccionado) {
            $("#dniUser").text(dniSeleccionado);
        } else {
            alert("Debes seleccionar una persona.");
        }
    });
});
</script>