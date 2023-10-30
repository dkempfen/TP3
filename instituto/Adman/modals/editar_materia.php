<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistemas/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistemas/instituto/Adman/lista_materia.php';





$DatosMateria = DatosMateria();

?>


<?php 


foreach ($DatosMateria as $DatosMateria) { ?>
<div class="modal fade" id="modaleditarMateria_<?php echo $DatosMateria['id_Materia']; ?>" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title fs-5" id="tituloModalEditarMateria">Editar Materia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditarMateria" name="formEditarMateria" action="/sistemas/instituto/Includes/slqeditar.php"
                    method="POST">



                    <input type="hidden" name="materiaeditar" id="materiaeditar"
                        value="<?php echo $DatosMateria['id_Materia'] ?>">



                    <div class="form-group">
                        <label for="nombreMateriaeditar">Descripcion:</label>
                        <input type="text" class="form-control" name="nombreMateriaeditar" id="nombreMateriaeditar"
                            value="<?php echo $DatosMateria['Descripcion']; ?>" required>

                    </div>
                    <div class="form-group">
                        <label for="promocionaleditar">Promocional:</label>
                        <select class="form-control" name="promocionaleditar" id="promocionaleditar">
                            <option value="">--Seleccione--</option>
                            <option value="0" <?php echo ($DatosMateria['Promocional'] == 0) ? 'selected' : ''; ?>>NO
                            </option>
                            <option value="1" <?php echo ($DatosMateria['Promocional'] == 1) ? 'selected' : ''; ?>>SI
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nivelCarrera">Nivel</label>
                        <select class="form-control" name="nivelCarrera" id="nivelCarrera">
                            <option value="">--Seleccione--</option>
                            <option value="1" <?php echo ($DatosMateria['Anio_Carrera'] == 1) ? 'selected' : ''; ?>>
                                Nivel 1</option>
                            <option value="2" <?php echo ($DatosMateria['Anio_Carrera'] == 2) ? 'selected' : ''; ?>>
                                Nivel 2</option>
                            <option value="3" <?php echo ($DatosMateria['Anio_Carrera'] == 3) ? 'selected' : ''; ?>>
                                Nivel 3</option>
                            <!-- Agrega más opciones aquí si es necesario -->
                        </select>
                    </div>




                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="btnActionEditarFormMateria" class="btn btn-primary btn-open-modal" type="submit"
                            name="btnmodificarMateria">
                            <span id="btnEditarMateria">Guardar</span>
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

function openModalsMateriaEdi(materiaeditar) {
    document.getElementById('materiaeditar').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.getElementById('btnActionEditarFormMateria').classList.replace("btn-info", "btn-open-modal");
    document.getElementById('btnEditarMateria').innerHTML = 'Guardar';
    document.getElementById('tituloModalEditarMateria').innerHTML = 'Modificar Materia';
    document.getElementById('formEditarMateria').reset();
    var modalId = "#modaleditarMateria_" + materiaeditar;
    $(modalId).modal('show');

}

$(document).ready(function() {
    var tableusuarios = $('#tablemateria').DataTable();


    $('.btn-open-modal').on('click', function() {
        openModalsMateriaEdi();
    });

    var forMateria = document.getElementById('formEditarMateria');

    // ... Resto del código ...

    // Evento al enviar el formulario de edición de usuario
    $("#formEditarMateria").on("submit", function(event) {
        event.preventDefault();

        // Obtener los valores del formulario
        var materiaeditar = $("#materiaeditar").val();
        var nombreMateriaeditar = $("#nombreMateriaeditar").val();
        var promocionaleditar = $("#promocionaleditar").val();
        var nivelCarrera = $("#nivelCarrera").val();




        // Realizar la petición AJAX para actualizar el usuario
        $.ajax({
            url: "/sistemas/instituto/Includes/slqeditar.php",
            type: "POST",
            data: {
                materiaeditar: materiaeditar,
                nombreMateriaeditar: nombreMateriaeditar,
                promocionaleditar: promocionaleditar,
                nivelCarrera: nivelCarrera,
                btnmodificarMateria: 1 // Agrega una marca para indicar que es una solicitud de modificación
            },
            success: function(response) {
                // Verificar la respuesta del servidor
                if (response.success) {
                    // Mostrar mensaje de éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Datos actualizados exitosamente',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.reload();
                    });
                } else {
                    // Mostrar mensaje de error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al actualizar los datos',
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