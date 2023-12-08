<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/subPantallas/lista_materia.php';


$DatosMateriaProfesor = DatosMateriaProfesor();
$DatosMateriaEstado = DatosMateriaEstado();
$DatosMateria = DatosMateria();
$DatosPersonasUsuarios =DatosPersonasUsuarios ();
 ?>



<div class="modal fade" id="modalMateria" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header headerMateria">
                <h5 class="modal-title fs-5" id="tituloModalMateria">Nueva Materia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formMateria" name="formMateria" action="/instituto/Includes/slqeditar.php" method="POST">

                    <input type="hidden" name="idMateria" id="idMateria"
                        value="<?php  echo $DatosMateriaProfesor['id_Materia']?>">

                    <div class="form-group">
                        <label for="control-label">Nombre Materia:</label>
                        <input type="text" class="form-control" name="nombreMateria" id="nombreMateria">
                    </div>

                    <!--<div class="form-group">
                        <label for="control-label">Nombre Profesor:</label>
                        <select class="form-control" name="nombreProfesor" id="nombreProfesor">
                            <option value="">-- Selecciona un profesor --</option>
                            <?php foreach ($DatosPersonasUsuarios as $profesor): ?>
                            <?php if ($profesor['fk_Rol'] == 2): ?>
                            <option value="<?php echo $profesor['DNI']; ?>">
                                <?php echo $profesor['Nombre'] . ' ' . $profesor['Apellido']; ?>
                            </option>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>-->

                    <div class="form-group">
                        <label for="control-label">Nivel Carrera:</label>
                        <select class="form-control" name="nivelCarrera" id="nivelCarrera">
                            <option value="">-- Selecciona un Nivel --</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>


                        </select>
                    </div>


                    <div class="form-group">
                        <label for="listEstado">Estado</label>
                        <select class="form-control" name="listEstado" id="listEstado">
                            <option value="">-- Selecciona un Estado --</option>
                            <?php
                            $estadosUnicos = array(); // Array para rastrear estados únicos
                            foreach ($DatosMateriaEstado as $estado):
                                if ($estado['Id_Estado'] == 1 || $estado['Id_Estado'] == 2) {
                                    $idEstado = $estado['Id_Estado'];
                                    if (!in_array($idEstado, $estadosUnicos)) {
                                        // Si el estado no está en la lista de estados únicos, agrégalo y muéstralo
                                        array_push($estadosUnicos, $idEstado);
                                        ?>
                            <option value="<?php echo $idEstado; ?>">
                                <?php echo $estado['Descripcion_Estado']; ?>
                            </option>
                            <?php
                                    }
                                }
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="promocional">Promocional:</label>
                        <div class="custom-control custom-switch custom-control-lg">
                            <input type="hidden" name="promocional" value="0">
                            <input type="checkbox" class="custom-control-input" id="promocional" name="promocional"
                                value="1"
                                <?php echo isset($_POST['promocional']) && $_POST['promocional'] == '1' ? 'checked' : ''; ?>>
                            <label class="custom-control-label custom-control-label-lg" for="promocional">
                                <span id="promocional-label">
                                    <?php echo isset($_POST['promocional']) && $_POST['promocional'] == '1' ? 'Sí, es promocional' : 'No, es promocional'; ?>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="btnActionAltaMateriaForm" class="btn btn-primary btn-open-modal" type="submit"
                            name="btnCrearMateria">
                            <span id="btnCrearMateria">Guardar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<!-- Agrega SweetAlert2 y jQuery a tu página -->

<script>
function isValidInput(value) {
    return value.trim() !== '';
}

function openModalMateria() {
    console.log('Abrir modal'); // Agrega este log para verificar si se llama a la función

    document.getElementById('idMateria').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerMateria");
    document.getElementById('btnCrearMateria').classList.replace("btn-info", "btn-open-modal");
    document.getElementById('btnCrearMateria').innerHTML = 'Guardar';
    document.getElementById('tituloModalMateria').innerHTML = 'Crear Materia';
    document.getElementById('formMateria').reset();

    $('#modalMateria').modal('show');


}
$(document).ready(function() {
    var tableusuarios = $('#tablemateria').DataTable();
    $('#formMateria').on('submit', function(event) {
        event.preventDefault(); //
        console.log('Botón Guardar clickeado');
        var idMateria = $("#idMateria").text(); // Usar "dniUser" en lugar de "dni"
        var nombreMateria = $("#nombreMateria").val();
        var nombreProfesor = $("#nombreProfesor").val();
        var listEstado = $("#listEstado").val();
        var nivelCarrera = $("#nivelCarrera").val();
        var promocional = $("#promocional").val();


        // Realizar la petición AJAX para insertar o actualizar datos
        $.ajax({
            url: "/instituto/Includes/slqeditar.php", // Reemplaza con la ruta correcta a tu archivo PHP
            type: "POST",
            data: {
                idMateria: idMateria,
                nombreMateria: nombreMateria,
                nombreProfesor: nombreProfesor,
                listEstado: listEstado,
                nivelCarrera: nivelCarrera,
                promocional: promocional,

                btnCrearMateria: 0
            },

            success: function(response) {
                // Verificar la respuesta del servidor
                if (response.success) {
                    // Cerrar el modal
                    $('#modalMateriaCrear').modal('hide');

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

<script>
document.getElementById("promocional").addEventListener("change", function() {
    var promocionalLabel = document.getElementById("promocional-label");
    promocionalLabel.textContent = this.checked ? "Sí, es promocional" : "No, es promocional";
});
</script>