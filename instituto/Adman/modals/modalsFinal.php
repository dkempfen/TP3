<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/Pantallas/finales.php';

$DatosMateriaDetalle=DatosMateriaDetalle();
$DatosAlumnoNota = DatosAlumnoNota();
$DatosMateria = DatosMateria();
$DatosUsuarios =DatosUsuarios();
$fechaFinales=fechaFinales ();
$Plan = Plan();


?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<div class="modal fade" id="modalFechaFinal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header headerRegisterFechFinal">
                <h5 class="modal-title fs-5" id="tituloModalFinal">Nueva Fecha Final</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tab-content">
                    <!-- Datos -->
                    <div class="tab-pane active" id="datos" role="tabpanel">
                        <form id="formAltaFinal" name="formAltaFinal" action="/instituto/Includes/slqeditar.php"
                            method="POST">
                            <input type="hidden" name="action" value="insert">
                            <input type="hidden" name="idFechaFinal" id="idFechaFinal"
                                value="<?php  echo $fechaFinales['Id_Fecha_Final']?>">

                            <div class="form-group">
                                <label for="materiaFinal">Materia</label>
                                <select id="materiaFinal" name="materiaFinal" class="form-control"
                                    style="margin-bottom: 10px;">
                                    <option value="">--Seleccione--</option>
                                    <?php foreach ($DatosMateria as $materia) : ?>
                                    <option value="<?= $materia['id_Materia'] ?>">
                                        <?= $materia['Descripcion'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="fechaFinal">Fecha de Final:</label>
                                <input type="date" class="form-control" name="fechaFinal" id="fechaFinal" required>
                            </div>



                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button id="btnActionAltaFechaFInal" class="btn btn-primary btn-open-modal" type="submit"
                                    name="btnaltaFechaFinal">
                                    <span id="btnActionFormFechaFinal">Guardar</span>
                                </button>
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

function openFinalDateModal() {
    console.log('Abrir modal'); // Agrega este log para verificar si se llama a la función
    document.getElementById('idFechaFinal').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegisterFechFinal");
    document.getElementById('btnActionFormFechaFinal').classList.replace("btn-info", "btn-primary");
    document.getElementById('btnActionFormFechaFinal').innerHTML = 'Guardar';
    document.getElementById('tituloModalFinal').innerHTML = 'Nueva Fecha Final';
    document.getElementById('formAltaFinal').reset();

    $('#modalFechaFinal').modal('show');
}


(document).ready(function() {

    $('#formAltaFinal').on('click', function() {
        console.log('Botón Guardar clickeado');
        var materiaFinal = $("#materiaFinal").val();
        var fechaFinal = $("#fechaFinal").val();
        var idFechaFinal = $("#idFechaFinal").val();



        // Realizar la petición AJAX para insertar o actualizar datos
        $.ajax({
            url: "/instituto/Includes/slqeditar.php",
            type: "POST",
            data: {
                materiaFinal: materiaFinal,
                fechaFinal: fechaFinal,
                idFechaFinal: idFechaFinal,
                btnaltaFechaFinal: 0
            },
            success: function(response) {
                // Verificar la respuesta del servidor
                if (response.success) {
                    // Cerrar el modal
                    $('#modalCrearFecha').modal('hide');

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