<div class="modal fade" id="modalUsuario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title fs-5" id="tituloModal">Nueva Persona</h5>
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
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Datos -->
                    <div class="tab-pane active" id="datos" role="tabpanel">
                        <form id="formUsuario" name="formUsuario" action="/instituto/Includes/sql.php" method="POST">
                            <input type="hidden" name="action" value="insert">
                            <input type="hidden" name="idusuario" id="idusuario" value="">
                            <div class="form-group">
                                <label for="control-label">DNI:</label>
                                <input type="number" class="form-control" name="dni" id="dni" required>
                            </div>
                            <div class="form-group">
                                <label for="control-label">Nombre:</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="control-label">Apellido:</label>
                                <input type="text" class="form-control" name="apellido" id="apellido" required>
                            </div>
                            <div class="form-group">
                                <label for="control-label">Fecha Nacimiento:</label>
                                <input type="date" class="form-control" name="fechanacimiento" id="fechanacimiento"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="control-label">Telefono:</label>
                                <input type="number" class="form-control" name="telefono" id="telefono" required>
                            </div>
                            <div class="form-group">
                                <label for="control-label">Mail:</label>
                                <input type="email" class="form-control" name="mail" id="mail" required>
                            </div>
                            <div class="form-group">
                                <label for="control-label">Domicilio:</label>
                                <input type="text" class="form-control" name="domicilio" id="domicilio" required>
                            </div>
                            <div class="form-group">
                                <label for="control-label">Inscripto:</label>
                                <select class="form-control" name="inscripto" id="inscripto">
                                    <option value="0">Seleccione</option> <!-- Opción por defecto con valor "0" -->
                                    <option value="1">Inscripto</option> <!-- Valor "1" para "Inscripto" -->
                                    <!-- Otras opciones aquí -->
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button id="btnActionForm" class="btn btn-primary"
                                    name="btnaltaPersona">Guardar</button>
                            </div>



                        </form>

                    </div>



                </div>


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
    console.log('Abrir modal'); // Agrega este log para verificar si se llama a la función
    document.getElementById('idusuario').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.getElementById('btnActionForm').classList.replace("btn-info", "btn-primary");
    document.getElementById('btnActionForm').innerHTML = 'Guardar';
    document.getElementById('tituloModal').innerHTML = 'Nuevo Usuario';
    document.getElementById('formUsuario').reset();

    $('#modalUsuario').modal('show');
}


$(document).ready(function() {
    var tableusuarios = $('#tableUsuarios').DataTable();

    $('#btnActionForm').on('click', function() {
        console.log('Botón Guardar clickeado');
        var dni = $("#dni").val();
        var nombre = $("#nombre").val();
        var apellido = $("#apellido").val();
        var fechanacimiento = $("#fechanacimiento").val();
        var telefono = $("#telefono").val();
        var email = $("#mail").val();
        var domicilio = $("#domicilio").val();
        var Inscripto = $("#Inscripto").val();
        var idusuario = $("#idusuario").val();
        var inscritoValue = (inscripto === '1') ? 1 : 0;


        // Realizar la petición AJAX para insertar o actualizar datos
        $.ajax({
            url: "/instituto/Includes/sql.php", // Reemplaza con la ruta correcta a tu archivo PHP
            type: "POST",
            data: {
                idusuario: idusuario,
                dni: dni,
                nombre: nombre,
                apellido: apellido,
                fechanacimiento: fechanacimiento,
                telefono: telefono,
                mail: email,
                domicilio: domicilio,
                Inscripto: Inscripto,
                btnaltaPersona: 1 // Agrega una marca para indicar que es una solicitud de inserción o actualización
            },
            success: function(response) {
                // Verificar la respuesta del servidor
                if (response.success) {
                    // Cerrar el modal
                    $('#modalUsuario').modal('hide');

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