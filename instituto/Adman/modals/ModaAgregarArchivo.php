<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/Pantallas/documentacion.php';


$DatosUsuarios = DatosUsuarios();
$DatosPersonas = DatosPersonas();



?>


<div class="modal fade" id="modalDocuementacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header headerDocumentacion">
                <h5 class="modal-title fs-5" id="tituloModal">Nueva Documentacion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="tab-content">

                    <div class="tab-pane active" id="datos" role="tabpanel">
                        <form id="formDocuementacion" name="formDocuementacion" action="/instituto/Includes/sql.php"
                            method="POST" enctype="multipart/form-data">


                            <input type="hidden" name="idDocumentacionArchivo" id="idDocumentacionArchivo"
                                value="<?php  echo $obtenerDocumentos['id_Documentacion']?>">

                            <div class="form-group">
                                <label for="control-label">Archivo:</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ArchivoDocumentacion"
                                        name="ArchivoDocumentacion" maxlength="45" required>
                                    <label class="custom-file-label" for="ArchivoDocumentacion"
                                        id="ArchivoLabel">Seleccionar Archivo</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="control-label">Asunto:</label>
                                <input type="text" class="form-control" name="AsuntoArchivoocumentacion"
                                    id="AsuntoArchivoocumentacion" required>
                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button id="btnActionAltaDocumentacion" class="btn btn-primary btn-open-modal"
                                    type="submit" name="btnaltaDocumentacion">
                                    <span id="btnActionFormDocumentacion">Guardar</span>
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
</div>


<!-- Agrega SweetAlert2 y jQuery a tu página -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<script>
function isValidInput(value) {
    return value.trim() !== '';
}

function openModaArchivo() {
    console.log('Abrir modal'); // Agrega este log para verificar si se llama a la función
    document.getElementById('idDocumentacionArchivo').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerDocumentacion");
    document.getElementById('btnActionFormDocumentacion').classList.replace("btn-info", "btn-primary");
    document.getElementById('btnActionFormDocumentacion').innerHTML = 'Guardar';
    document.getElementById('formDocuementacion').reset();

    $('#modalDocuementacion').modal('show');
}


$(document).ready(function() {
    var tabledoc = $('#tabledoc').DataTable();

    $('#formDocuementacion').on('click', function() {
        console.log('Botón Guardar clickeado');
        var idDocumentacionArchivo = $("#idDocumentacionArchivo").val();
        var ArchivoDocumentacion = $("#ArchivoDocumentacion").val();
        var AsuntoArchivo = $("#AsuntoArchivo").val();


        console.log('Estado del checkbox "inscripto":', inscripto);

        var formData = new FormData();
        formData.append('ArchivoDocumentacion', archivo);
        formData.append('AsuntoArchivo', AsuntoArchivo);

        // Realizar la petición AJAX para insertar o actualizar datos
        $.ajax({
            url: "/instituto/Includes/sql.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // Verificar la respuesta del servidor
                if (response.success) {
                    // Cerrar el modal
                    $('#modalDocuementacion').modal('hide');

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

$(document).ready(function() {
    // Escuchar el evento de cambio del input de archivo
    $('#ArchivoDocumentacion').on('change', function() {
        // Obtener el nombre del archivo seleccionado
        var fileName = $(this).val().split('\\').pop();
        // Mostrar el nombre del archivo en la etiqueta personalizada
        $('#ArchivoLabel').text(fileName);
    });
});

document.getElementById('ArchivoDocumentacion').addEventListener('change', function () {
        var maxLength = 45;
        var fileName = this.value.split('\\').pop();
        var fileLength = fileName.length;

        if (fileLength > maxLength) {
            alert('¡Te has excedido! El nombre del archivo debe tener como máximo 45 caracteres.');
            this.value = '';
            document.getElementById('ArchivoLabel').innerHTML = 'Seleccionar Archivo';
        } else {
            document.getElementById('ArchivoLabel').innerHTML = fileName;
        }
    });
</script>