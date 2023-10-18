<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/lista_planes.php';


$DatosPlan = DatosPlan();



?>


<?php 


foreach ($DatosPlan as $DatosPlan) {
    // Code to process $DatosPersona goes here
 ?>



<div class="modal fade" id="modalCrearPlan" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header headerPlan">
                <h5 class="modal-title fs-5" id="tituloModalCrearPlan">Crear Plan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="formCrearPlan" name="formCrearPlan" action="/instituto/Includes/sqluser.php" method="POST">



                    <input type="hidden" name="idPlancrear" id="idPlancrear"
                        value="<?php  echo $DatosPlan['cod_Plan']?>">


                    <div class="form-group">
                        <label for="control-label">Codigo Plan:</label>
                        <input type="text" class="form-control" name="nombreTarjetaCrear" id="nombreTarjetaCrear" required>
                    </div>
                    <div class="form-group">
                        <label for="control-label">Carrera:</label>
                        <input type="text" class="form-control" name="CarreraCrear" id="CarreraCrear" required>
                    </div>

                    <div class="form-group">
                        <label for="control-labelo">Fecha Inicio:</label>
                        <input type="date" class="form-control" id="fechaInicioCrear" name="fechaInicioCrear">
                    </div>
                    <div class="form-group">
                        <label for="control-labelo">Fecha Final:</label>
                        <input type="date" class="form-control" id="fechaFinalCrear" name="fechaFinalCrear">
                    </div>
     
                    <div class="form-group">
                        <label for="control-label">Estado:</label>
                        <!-- <input type="text" class="form-control" name="estadoUser" id="estadoUser">-->
                        <select class="form-control" name="estadoPlanCrear" id="estadoPlanCrear" required>
                            <option value="">--Selecione--</option>
                            <option value="1">Habilitado</option>
                            <option value="2">Inhabilitado</option>

                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="btnActionAltaPlan" class="btn btn-primary btn-open-modal" type="submit"
                            name="btnmCrearPlan">
                            <span id="btnCrearPlan">Guardar</span>
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


$(document).ready(function() {

    $('#btnCrearPlan').on('submit', function(event) {
        event.preventDefault(); //
        console.log('Botón Guardar clickeado');
        var nombreTarjetaCrear = $("#nombreTarjetaCrear").text(); // Usar "dniUser" en lugar de "dni"
        var idPlancrear = $("#idPlancrear").val();
        var CarreraCrear = $("#CarreraCrear").val();
        var estadoPlanCrear = $("#estadoPlanCrear").val();
        var fechaInicioCrear = $("#fechaInicioCrear").val();
        var fechaFinalCrear = $("#fechaFinalCrear").val();
       
    .val(); // En lugar de "estadoUser", usar "estadoUser" si es un campo de selección

        console.log('Estado del campo de selección "estadoUser":', estadoPlanCrear);

        // Realizar la petición AJAX para insertar o actualizar datos
        $.ajax({
            url: "/instituto/Includes/sqluser.php", // Reemplaza con la ruta correcta a tu archivo PHP
            type: "POST",
            data: {
                idPlancrear: idPlancrear,
                nombreTarjetaCrear: nombreTarjetaCrear,
                IdUser: IdUser,
                CarreraCrear: CarreraCrear,
                estadoPlanCrear: estadoPlanCrear,
                fechaInicioCrear: fechaInicioCrear,
                fechaFinalCrear:fechaFinalCrear,
                
                btnmCrearPlan: 0
            },

            success: function(response) {
                // Verificar la respuesta del servidor
                if (response.success) {
                    // Cerrar el modal
                    $('#modalCrearPlan').modal('hide');

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