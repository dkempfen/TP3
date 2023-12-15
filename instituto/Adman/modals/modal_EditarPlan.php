<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/subPantallas/lista_planes.php';

if (isset($fila) && is_array($fila)) {
    $estadoTarjeta = ($fila['Estado_Id_Estado'] == 1) ? 'Habilitado' : 'Inhabilitado';
} else {
    // Establecer un valor predeterminado en caso de que $fila no esté definida o no sea un arreglo
    $estadoTarjeta = 'No definido';
}
$DatosPlan = DatosPlan();
?>


<div class="modal fade" id="ModalsEditarPlan_" tabindex="-1" role="dialog" aria-labelledby="editarTarjetaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModalEditarPlan">Editar Tarjeta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="ModalsEditarPlan" name="ModalsEditarPlan" action="/instituto/Includes/sqluser.php"
                    method="POST" enctype="multipart/form-data">
                    <!--<input type="hidden" name="cod_Plan" id="cod_Plan" value="<?php  echo $DatosPlan['cod_Plan'] ?>-->

                    <!-- Agregar aquí los campos de edición -->
                    <div class="form-group">
                        <label for="nombreTarjeta">Nombre:</label>
                        <input type="text" class="form-control" id="nombreTarjeta">
                    </div>

                    <div class="form-group">
                        <label for="estadoTarjeta" id="">Estado:</label>
                        <select class="form-control" id="estadoTarjeta" name="estadoTarjeta">
                            <option value="1">Habilitado</option>
                            <option value="2">Inhabilitado</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fechaInicio">Fecha Inicio:</label>
                        <input type="date" class="form-control" id="fechaInicio">
                    </div>
                    <div class="form-group">
                        <label for="fechaFinal">Fecha Final:</label>
                        <input type="date" class="form-control" id="fechaFinal">
                    </div>

                   
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button id="btnActionEditarPlan" class="btn btn-primary btn-open-modal" type="submit"
                    name="btnmodificarPlan">
                    <span id="btnEditarPlan">Guardar</span>
                </button>
            </div>


        </div>
    </div>
</div>


<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Función para mostrar el modal
function mostrarEditarTarjeta(boton) {
    var cod_Plan = boton.getAttribute('data-codigo-plan');
    var nombreTarjeta = boton.getAttribute('data-nombre-tarjeta');
    var estadoTarjeta = boton.getAttribute('data-estado-tarjeta');
    var fechaInicio = boton.getAttribute('data-fecha-inicio');
    var fechaFinal = boton.getAttribute('data-fecha-final');
    var archivoPlan = boton.getAttribute('archivoPlan');

    document.getElementById('cod_Plan').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.getElementById('btnActionEditarPlan').classList.replace("btn-info", "btn-open-modal");
    document.getElementById('btnEditarPlan').innerHTML = 'Guardar';
    document.getElementById('tituloModalEditarPlan').innerHTML = 'Modificar Plan';
    document.getElementById('ModalsEditarPlan').reset();

    $('#cod_Plan').val(cod_Plan);
    $('#nombreTarjeta').val(nombreTarjeta);
    $('#estadoTarjeta').val(estadoTarjeta);
    $('#fechaInicio').val(fechaInicio);
    $('#fechaFinal').val(fechaFinal);

   

    $('#tituloModalEditarPlan').html('Modificar Plan');
    $('#btnEditarPlan').html('Guardar');
    $('#btnActionEditarPlan').removeClass('btn-info').addClass('btn-open-modal');
    $('#ModalsEditarPlan_').modal('show');

    // Agregar el código para mostrar y ocultar la información adicional aquí
    var celdasExpandibles = document.querySelectorAll("td");

    celdasExpandibles.forEach(function(celda) {
        celda.addEventListener("click", function() {
            var infoAdicional = this.querySelector(".info-adicional");
            if (infoAdicional.style.display === "none" || infoAdicional.style.display === "") {
                infoAdicional.style.display = "block";
            } else {
                infoAdicional.style.display = "none";
            }
        });
    });
}

$(document).ready(function() {
    // Función para mostrar el modal
    function mostrarEditarTarjeta(boton) {
        // ... Tu código para mostrar el modal ...
    }

    // Abre el modal de edición al hacer clic en el botón "Editar"
    $('.btn-open-modal').on('click', function() {
        var boton = $(this);
        mostrarEditarTarjeta(boton);
    });

    // Evento para el botón "Guardar"
    $("#btnActionEditarPlan").on("click", function(event) {
        // Llama a una función de validación antes de enviar el formulario
        if (validarAntesDeGuardar()) {
            // Continúa enviando el formulario
            $("#ModalsEditarPlan").submit();
        } else {
            // No envíes el formulario si la validación falla
            alert("La validación ha fallado, no se enviará el formulario.");
        }
    });

    // Función para validar antes de guardar
    function validarAntesDeGuardar() {

        var cod_Plan = $("#cod_Plan").val();
        if (cod_Plan.trim() === "") {
            alert("El cod_Plan de la tarjeta no puede estar vacío.");
            return false;
        }

        var nombreTarjeta = $("#nombreTarjeta").val();
        if (nombreTarjeta.trim() === "") {
            alert("El nombre de la tarjeta no puede estar vacío.");
            return false;
        }

        var estadoTarjeta = $("#estadoTarjeta").val();
        if (estadoTarjeta.trim() === "") {
            alert("El estado de la tarjeta no puede estar vacío.");
            return false;
        }

        var fechaInicio = $("#fechaInicio").val();
        if (fechaInicio.trim() === "") {
            alert("La fecha de inicio no puede estar vacía.");
            return false;
        }

        var fechaFinal = $("#fechaFinal").val();
        if (fechaFinal.trim() === "") {
            alert("La fecha final no puede estar vacía.");
            return false;
        }

        // Otras validaciones...
        return true;
    }


    $("#ModalsEditarPlan").on("submit", function(event) {
        event.preventDefault();
        var cod_Plan = $("#cod_Plan").val();
        var nombreTarjeta = $("#nombreTarjeta").val();
        var estadoTarjeta = $("#estadoTarjeta").val();
        var fechaInicio = $("#fechaInicio").val();
        var fechaFinal = $("#fechaFinal").val();

        $.ajax({
            url: "/instituto/Includes/sqluser.php",
            type: "POST",
            data: {
                cod_Plan: cod_Plan,
                nombreTarjeta: nombreTarjeta,
                estadoTarjeta: estadoTarjeta,
                fechaInicio: fechaInicio,
                fechaFinal: fechaFinal,
                btnmodificarPlan: 1
            },
            success: function(response) {
                if (response.error) { // Verifica si hay un error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al actualizar los datos',
                        text: response.message
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Datos actualizados exitosamente',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Cierra la modal
                        console.log(
                            "Cerrando modal"
                        ); // Agrega esto para verificar si se ejecuta

                        $('#editarTarjetaModal_').modal('hide');
                        // Recarga la página
                        location.reload();
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