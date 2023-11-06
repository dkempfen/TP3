<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/Pantallas/lista_personas.php';

$DatosUsuarios = DatosUsuarios();
$DatosPersonas = DatosPersonas();



?>



<?php foreach ($DatosUsuarios as $DatosUsuarios); foreach ($DatosPersonas as $DatosPersonas)  { ?>

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
                        <form id="formUsuario" name="formUsuario" action="/instituto/Includes/slqeditar.php"
                            method="POST">
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
                                <label for="inscripto">Inscripto:</label>
                                <div class="custom-control custom-switch custom-control-lg">
                                    <input type="hidden" name="inscripto" value="0">
                                    <input type="checkbox" class="custom-control-input" id="inscripto"
                                        name="inscripto" value="1"
                                        <?php echo isset($_POST['inscripto']) && $_POST['inscripto'] == '1' ? 'checked' : ''; ?>>
                                    <label class="custom-control-label custom-control-label-lg" for="inscripto">
                                        <span id="inscripto-label">
                                            <?php echo isset($_POST['inscripto']) && $_POST['inscripto'] == '1' ? 'Sí, es inscripto' : 'No, es inscripto'; ?>
                                        </span>
                                    </label>
                                </div>
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
<?php } ?>

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
    document.getElementById('tituloModal').innerHTML = 'Nueva Persona';
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
        var inscripto = $("#inscripto").val();
        0; // Asigna 1 si está marcado, 0 si no lo está
        var idusuario = $("#idusuario").val();

        console.log('Estado del checkbox "inscripto":', inscripto);


        // Realizar la petición AJAX para insertar o actualizar datos
        $.ajax({
            url: "/instituto/Includes/slqeditar.php",
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
                inscripto: inscripto,
                btnaltaPersona: 0
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

    // Obtén el elemento checkbox por su id y agrega un oyente de eventos para el evento "change"
    $('#inscripto').on('change', function() {
        // Obtiene el valor del checkbox (true o false) y realiza alguna acción basada en el valor
        if ($(this).is(':checked')) {
            alert("El usuario está inscrito");
        } else {
            alert("El usuario no está inscrito");
        }
    });
});
</script>

<script>
document.getElementById("inscripto").addEventListener("change", function() {
    var promocionalLabel = document.getElementById("inscripto-label");
    promocionalLabel.textContent = this.checked ? "Sí, es inscripto" : "No, es inscripto";
});
</script>