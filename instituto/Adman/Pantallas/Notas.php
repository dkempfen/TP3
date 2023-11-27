<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/modals/altaPrimerNota.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/modals/AgregarTodasNotas.php';
?>

<?php
if (isset($_SESSION['messageNota'])) {
    $messageNota = $_SESSION['messageNota'];
    unset($_SESSION['messageNota']); // Clear the session variable after displaying the message
    showConfirmationMessagesNotas($messageNota);
}

if ($pdo) {
    $sqlmaterianota = "SELECT dc.id_Cursada, u.fk_DNI, p.Nombre, p.Apellido, dc.fk_Usuario, dc.fk_Legajo, dc.fk_Materia, m.Descripcion, dc.fk_Estado, dc.Primer_Parcial,
        dc.Recuperatio_Parcial_1, dc.Primer_TP, dc.Recuperatio_TP_1, dc.Segundo_Parcial, dc.Recuperatio_Parcial_2, dc.Segundo_TP,
        dc.Recuperatio_TP_2, dc.Promedio, dc.Anio, pn.cod_Plan, pn.Carrera, Final
        FROM DetalleCursada dc
        INNER JOIN Usuario u ON dc.fk_Usuario = u.Id_Usuario
        INNER JOIN Persona p ON p.DNI = u.fk_DNI
        INNER JOIN Materia m ON m.id_Materia = dc.fk_Materia
        INNER JOIN Plan pn ON pn.cod_Plan = u.fk_Plan";

    $materianota = $pdo->query($sqlmaterianota);

    $alumnoData = null;
?>

<main class="app-content">
    <div class="container-fluid">
        <div class="row espaciado-entre-filas align-items-center">


            <div class="col-lg-6 text-left">
                <!-- Divide la fila en 2 columnas y alinea a la derecha -->
                <a id="generarPDFBtn" href="#" onclick="descargarMateriaPDF(); return false;" class="planpdf-button">
                    <i class="fas fa-file-pdf"></i> Descargar PDF
                </a>

                <a id="generareEXCLBtn" href="#" onclick="descargarMateriaEXCL(); return false;"
                    class="planexcel-button">
                    <i class="fas fa-file-excel"></i> Descargar Excel
                </a>

            </div>

            <div class="col-lg-6 text-right">
                <button data-toggle="modal" class="planalta-button" id="crearNuevoPlanBtn" type="button"
                    onclick="openModalNota()"><i class="fas fa-plus"></i>Primer Nota</button>
            </div>

        </div>
       

        <div class="card mt-4">
            <div class="card-body">
                <h2>Calificaciones de Alumnos</h2>

                <div class="container mt-4">
                    <div class="card">
                        <div class="card-body">
                            <form id="busquedaForm" class="form-row align-items-end" method="POST">
                                <div class="form-group col-md-3">
                                    <label for="dni">DNI:</label>
                                    <input type="number" class="form-control" name="btnBuscarAlumnosDNI" id="dni"
                                        placeholder="Ingrese DNI">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="nombreUser">Nombre:</label>
                                    <input type="text" class="form-control" name="btnBuscarAlumnosNombre"
                                        id="nombreUser" placeholder="Ingrese nombre">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="apellidoUser">Apellido:</label>
                                    <input type="text" class="form-control" name="btnBuscarAlumnosApellido"
                                        id="apellidoUser" placeholder="Ingrese apellido">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="materiaUser">Materia:</label>
                                    <input type="text" class="form-control" name="btnBuscarAlumnosMatera"
                                        id="materiaUser" placeholder="Ingrese la materia">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="tablaNotas" class="mt-4">
                    <?php
                    // Mostrar la tabla solo si se ha realizado una búsqueda
                    if (isset($_POST['dniBusqueda']) || isset($_POST['nombreUserBusqueda']) || isset($_POST['apellidoUserBusqueda'])) :
                        while ($materia = $materianota->fetch(PDO::FETCH_ASSOC)) :
                            if ($alumnoData === null || $alumnoData['fk_DNI'] !== $materia['fk_DNI']) :
                                if ($alumnoData !== null) :
                                    echo '</tbody></table>';
                                endif;
                                echo '<div class="table-responsive">';
                                echo '<table id="calificaciones-table" class="table table-bordered table-striped">';
                                echo '<thead class="thead-dark">';
                                echo '<tr>';
                                echo '<th class="alumno-header" colspan="10">';
                                echo '<i class="fas fa-graduation-cap"></i> Detalles del Alumno: ';
                                echo 'Nombre: ' . $materia['Nombre'] . ' ' . $materia['Apellido'] . ' - DNI: ' . $materia['fk_DNI'];
                                echo '</th>';
                                echo '</tr>';
                                echo '<tr class="expansible detalles-notas-' . $materia['fk_DNI'] . '" id="nombre-alumno">';
                                echo '<th>Materia</th>';
                                echo '<th>1 Parcial</th>';
                                echo '<th>1 Recuperatorio</th>';
                                echo '<th>2 Parcial</th>';
                                echo '<th>2 Recuperatorio</th>';
                                echo '<th>Promedio</th>';
                                echo '<th>Final</th>';
                                echo '<th>Carrera</th>';
                                echo '<th>Año</th>';
                                echo '<th>Agregar</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';
                                $alumnoData = $materia;
                            endif;
                            $primerParcial = $materia['Primer_Parcial'];
                            $recuperatorio1 = $materia['Recuperatio_Parcial_1'];
                            $segundoParcial = $materia['Segundo_Parcial'];
                            $recuperatorio2 = $materia['Recuperatio_Parcial_2'];
                            $promedio = 0;

                            if ($primerParcial >= 4) {
                                $promedio = ($primerParcial + $segundoParcial) / 2;
                            } elseif ($primerParcial < 4 && $recuperatorio1 >= 4) {
                                $promedio = ($recuperatorio1 + $segundoParcial) / 2;
                            } elseif ($primerParcial >= 4 && $segundoParcial < 4) {
                                $promedio = ($primerParcial + $recuperatorio2) / 2;
                            } elseif ($recuperatorio1 < 4 && $recuperatorio2 < 4) {
                                $promedio = ($primerParcial + $recuperatorio2) / 2;
                            }

                            $idCursada = $materia['id_Cursada'];
                            $pdo->beginTransaction();
                            try {
                                $updatePromedio = "UPDATE DetalleCursada SET Promedio = :promedio WHERE id_Cursada = :idCursada";
                                $stmt = $pdo->prepare($updatePromedio);
                                $stmt->bindParam(':promedio', $promedio, PDO::PARAM_STR);
                                $stmt->bindParam(':idCursada', $idCursada, PDO::PARAM_INT);
                                $stmt->execute();
                                $pdo->commit();
                            } catch (Exception $e) {
                                $pdo->rollBack();
                                echo "Error al actualizar el promedio: " . $e->getMessage();
                            }
                    ?>
                    <tr>
                        <td><?php echo $materia['Descripcion']; ?></td>
                        <td><?php echo $materia['Primer_Parcial']; ?></td>
                        <td><?php echo $materia['Recuperatio_Parcial_1']; ?></td>
                        <td><?php echo $materia['Segundo_Parcial']; ?></td>
                        <td><?php echo $materia['Recuperatio_Parcial_2']; ?></td>
                        <td><?php echo $promedio; ?></td>
                        <td><?php echo $materia['Final']; ?></td>
                        <td><?php echo $materia['Carrera']; ?></td>
                        <td><?php echo $materia['Anio']; ?></td>
                        <td>
                            <button class="btn btn-primary"
                                onclick="openModalAgregarMasNota(<?php echo $materia['id_Cursada']; ?>)">
                                <i class="fas fa-plus"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    </div>
</main>

<?php
} else {
    echo "Error: No se pudo establecer la conexión a la base de datos.";
}
require_once '../includes/footer.php';
?>

<script>
// Agregar función para filtrar por alumno
$('#nombreAlumno').on('change', function() {
    var nombreAlumno = $(this).data('alumno');
    table.column(0).search(nombreAlumno).draw();
});


$(document).ready(function() {
    $('#dni, #nombreUser, #apellidoUser, #materiaUser').on('input', function() {
        realizarBusqueda();
    });

    $('#busquedaForm').on('submit', function(event) {
        event.preventDefault(); // Evita el envío del formulario por defecto
        realizarBusqueda();
    });

    // Limpia los campos cuando se hace clic en el botón de limpiar
    $('#limpiarFiltros').on('click', function() {
        $('#dni, #nombreUser, #apellidoUser, #materiaUser').val('');
        realizarBusqueda();
    });
});

function realizarBusqueda() {
    var dniBusqueda = $('#dni').val();
    var nombreUserBusqueda = $('#nombreUser').val();
    var apellidoUserBusqueda = $('#apellidoUser').val();
    var materiaUserBusqueda = $('#materiaUser').val();

    // Realiza la solicitud AJAX
    $.ajax({
        url: "/instituto/Includes/notasSQL.php",
        type: 'POST',
        data: {
            dniBusqueda: dniBusqueda,
            nombreUserBusqueda: nombreUserBusqueda,
            apellidoUserBusqueda: apellidoUserBusqueda,
            materiaUserBusqueda: materiaUserBusqueda
        },
        success: function(response) {
            $('#tablaNotas').html(response);
        },
        error: function(error) {
            console.log("Error en la solicitud AJAX:", error);
        }
    });
}
</script>