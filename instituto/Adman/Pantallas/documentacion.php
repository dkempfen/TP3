<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/modals/ModaAgregarArchivo.php';


if (isset($_SESSION['messageDocuementacion'])) {
    $messageDocuementacion = $_SESSION['messageDocuementacion'];
    unset($_SESSION['messageDocuementacion']); // Clear the session variable after displaying the message
    showConfirmationMessageDocuementacion($messageDocuementacion);
}

?>
<link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">

<main class="app-content">
    <div class="app-title" id="botonesArchivos">

        <div class="row">
            <div class="col-md-12">
                <h1><i class="fa fa-dashboard"></i>Archivo</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-success" type="button" onclick="openModaArchivo()" style="white-space: nowrap;"><i class="fa fa-plus"></i>Archivo
                </button>
            </div>
            <div class="col-md-6">

                <button class="btn btn-danger" type="button" name="btnABorrarDocMasivos" onclick="borrarMasivo()" style="white-space: nowrap;">
                <i class="fa fa-trash"></i>Masivo
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tabledoc">
                            <thead>
                                <tr>
                                    <th>Selecione</th>
                                    <th>Nombre Archivo</th>
                                    <th>Asunto</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="messageFecha">
                                <?php
                                // Comprueba si la consulta fue exitosa
                                $rowDocumentacion = obtenerDocumentos();
                                if ($rowDocumentacion) {
                                    // Loop a través del resultado y generar filas de la tabla
                                    foreach ($rowDocumentacion as $rowDocumentacion) {
                                        echo '<tr>';   
                                        echo '<td>';
                                        echo '<input type="checkbox" name="documentoSeleccionado[]" value="' . $rowDocumentacion['id_Documentacion'] . '">';
                                        echo '</td>';
                                        echo '<td>' . $rowDocumentacion['Descripcion_Documentacion'] . '</td>';
                                        echo '<td id="asunto_' . $rowDocumentacion['id_Documentacion'] . '" contenteditable="false">' . $rowDocumentacion['Asunto'] . '</td>';
                                        echo '<td>' . $rowDocumentacion['fecha_documentacion'] . '</td>';
                                        echo '<td>';
                                        echo '<button class="btn-icon" onclick="habilitarEdicion(' . $rowDocumentacion['id_Documentacion'] . ')"><i class="edit-btn"></i>✏️</button>';
                                        echo '<button class="btn-icon borrar-btn" id="borrarBtn_' . $rowDocumentacion['id_Documentacion'] . '"  name="btnABorrarDoc"  onclick="borrarDocumento(' . $rowDocumentacion['id_Documentacion'] . ')"><i class="delete-btn" style="margin-left: 10px; font-size: 20px;"></i>🗑️</button>';
                                        echo '<button class="btn-icon guardar-btn d-none" id="guardarBtn_' . $rowDocumentacion['id_Documentacion'] . '" name="btnActualizarAsunto" onclick="actualizarAsunto(' . $rowDocumentacion['id_Documentacion'] . ')"><i class="mdi mdi-content-save" style="margin-left: 10px; font-size: 20px;"></i></button>';
                                        echo '<button class="btn-icon cerrar-btn d-none" id="cerrarBtn_' . $rowDocumentacion['id_Documentacion'] . '" onclick="cerrarEdicion(' . $rowDocumentacion['id_Documentacion'] . ')"><i class="close-btn"  style="margin-left: 10px; font-size: 20px;"></i>❌</button>';
                                        echo '</td>';

                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<p style="font-size: 18px; color: #333;">Sin datos que mostrar</p>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
</main>

<?php
require_once '../includes/footer.php';
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
function habilitarEdicion(idDocumento) {
    // Obtén el elemento td correspondiente al asunto
    var tdAsunto = document.getElementById('asunto_' + idDocumento);

    // Habilita la edición cambiando el atributo contenteditable a true
    tdAsunto.contentEditable = true;

    // Puedes agregar estilos adicionales para indicar que el campo es editable
    tdAsunto.style.border = '1px solid blue';
    tdAsunto.style.backgroundColor = '#f0f8ff'; // Un tono de azul claro

    // Muestra el botón de guardar correspondiente a este campo
    var guardarBtn = document.getElementById('guardarBtn_' + idDocumento);
    guardarBtn.classList.remove('d-none');

    // Muestra el botón de cerrar correspondiente a este campo
    var cerrarBtn = document.getElementById('cerrarBtn_' + idDocumento);
    cerrarBtn.classList.remove('d-none');

    // Oculta el botón de editar correspondiente a este campo
    var editarBtn = document.getElementById('editarBtn_' + idDocumento);
    editarBtn.classList.add('d-none');

    // Oculta el botón de borrar correspondiente a este campo
    var borrarBtn = document.getElementById('borrarBtn_' + idDocumento);
    borrarBtn.classList.add('d-none');
}

function actualizarAsunto(idDocumento) {
    // Obtén el elemento td correspondiente al asunto
    var tdAsunto = document.getElementById('asunto_' + idDocumento);

    // Obtén el nuevo valor del asunto
    var nuevoAsunto = tdAsunto.innerText;

    // Deshabilita la edición cambiando el atributo contenteditable a false
    tdAsunto.contentEditable = false;

    // Puedes quitar los estilos adicionales si lo deseas
    tdAsunto.style.border = 'none';
    tdAsunto.style.backgroundColor = 'transparent';

    // Oculta el botón de guardar correspondiente a este campo
    var guardarBtn = document.getElementById('guardarBtn_' + idDocumento);
    guardarBtn.classList.add('d-none');

    $.ajax({
        url: "/instituto/Includes/sql.php",
        type: "POST",
        data: {
            idDocumentacionArchivo: idDocumento,
            NuevoAsunto: nuevoAsunto,
            btnActualizarAsunto: 0
        },
        success: function(response) {
            // Verificar la respuesta del servidor
            if (response.success) {
                // Actualizar el contenido del td con el nuevo asunto
                tdAsunto.innerText = nuevoAsunto;
            } else {
                // Mostrar mensaje de error
                /* Swal.fire({
                     icon: 'error',
                     title: 'Error al guardar los datos',
                     text: response.message
                 });*/
            }
        },
        error: function(error) {
            console.log("Error en la solicitud AJAX:", error);
        },
        complete: function() {
            // Recargar la página inmediatamente después de la actualización
            location.reload();
        }
    });
}


function cerrarEdicion(idDocumento) {
    // Obtén el elemento td correspondiente al asunto
    var tdAsunto = document.getElementById('asunto_' + idDocumento);

    // Deshabilita la edición cambiando el atributo contenteditable a false
    tdAsunto.contentEditable = false;

    // Puedes quitar los estilos adicionales si lo deseas
    tdAsunto.style.border = 'none';
    tdAsunto.style.backgroundColor = 'transparent';

    // Oculta el botón de guardar correspondiente a este campo
    var guardarBtn = document.getElementById('guardarBtn_' + idDocumento);
    guardarBtn.classList.add('d-none');

    // Oculta el botón de cerrar correspondiente a este campo
    var cerrarBtn = document.getElementById('cerrarBtn_' + idDocumento);
    cerrarBtn.classList.add('d-none');

    // Muestra el botón de editar correspondiente a este campo
    var editarBtn = document.getElementById('editarBtn_' + idDocumento);
    editarBtn.classList.remove('d-none');

    // Muestra el botón de borrar correspondiente a este campo
    var borrarBtn = document.getElementById('borrarBtn_' + idDocumento);
    borrarBtn.classList.remove('d-none');
}

function borrarDocumento(idDocumento) {
    // Aquí puedes implementar la lógica para confirmar la eliminación o realizar una solicitud AJAX para eliminar el documento.
    Swal.fire({
        title: '¿Seguro que quieres borrar este documento?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, borrarlo'
    }).then((result) => {
        if (result.isConfirmed) {
            // Llama a tu función de borrado o realiza la acción correspondiente
            borrarDocumentoConfirmado(idDocumento);
        }
    });

    if (confirmacion) {
        $.ajax({
            url: "/instituto/Includes/sql.php",
            type: "POST",
            data: {
                idDocumentacionArchivo: idDocumento,
                btnABorrarDoc: 0,
            },
            success: function(response) {
                // Verificar la respuesta del servidor
                if (response.success) {
                    // Actualizar el contenido del td con el nuevo asunto
                    // Nota: La siguiente línea parece incorrecta, ya que 'tdAsunto' no está definido aquí.
                    // Puedes corregirlo según tus necesidades específicas.
                    // tdAsunto.innerText = nuevoAsunto;
                } else {
                    // Mostrar mensaje de error
                    /* Swal.fire({
                         icon: 'error',
                         title: 'Error al guardar los datos',
                         text: response.message
                     });*/
                }
            },
            error: function(error) {
                console.log("Error en la solicitud AJAX:", error);
            },
            complete: function() {
                // Recargar la página inmediatamente después de la actualización
                location.reload();
            }
        });
    }
}


function borrarDocumentoConfirmado(idDocumento) {
    // Realiza la lógica de borrado aquí, ya sea mediante AJAX o como lo prefieras
    $.ajax({
        url: "/instituto/Includes/sql.php",
        type: "POST",
        data: {
            idDocumentacionArchivo: idDocumento,
            btnABorrarDoc: 0,
        },
        success: function(response) {
            // Verificar la respuesta del servidor y actuar en consecuencia
            if (response.success) {
                // Actualizar el contenido del td con el nuevo asunto
                console.log("Documento borrado exitosamente");
            } else {
                console.log("Error al borrar el documento");
            }
        },
        error: function(error) {
            console.log("Error en la solicitud AJAX:", error);
        },
        complete: function() {
            // Recargar la página inmediatamente después de la actualización
            location.reload();
        }
    });
}

function borrarMasivo() {
    // Obtener los documentos seleccionados
    var documentosSeleccionados = [];
    var checkboxes = document.querySelectorAll('input[name="documentoSeleccionado[]"]:checked');
    checkboxes.forEach(function(checkbox) {
        documentosSeleccionados.push(checkbox.value);
    });

    if (documentosSeleccionados.length === 0) {
        // Mostrar mensaje de advertencia si no se seleccionaron documentos
        Swal.fire('Advertencia', 'Selecciona al menos un documento para borrar.', 'warning');
        return;
    }

    // Utilizar SweetAlert2 para la confirmación del borrado masivo
    Swal.fire({
        title: '¿Seguro que quieres borrar estos documentos?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, borrarlos'
    }).then((result) => {
        if (result.isConfirmed) {
            // Realizar la solicitud AJAX para el borrado masivo
            borrarMasivoConfirmado(documentosSeleccionados);
        }
    });
}



function borrarMasivoConfirmado(documentosSeleccionados) {
    // Realiza la lógica de borrado aquí, ya sea mediante AJAX o como lo prefieras
    $.ajax({
        url: "/instituto/Includes/sql.php",
        type: "POST",
        data: {
            documentos: documentosSeleccionados,
            btnABorrarDocMasivos: 0,
        },
        success: function(response) {
            // Verificar la respuesta del servidor y actuar en consecuencia
            if (response.success) {
                // Actualizar el contenido del td con el nuevo asunto
                console.log("Documento borrado exitosamente");
            } else {
                console.log("Error al borrar el documento");
            }
        },
        error: function(error) {
            console.log("Error en la solicitud AJAX:", error);
        },
        complete: function() {
            // Recargar la página inmediatamente después de la actualización
            location.reload();
        }
    });
}
</script>