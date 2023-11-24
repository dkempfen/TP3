<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/modals/altaPrimerNota.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/modals/AgregarTodasNotas.php';


?>

<style>

</style>
<?php

   
if (isset($_SESSION['messageNota'])) {
    $messageNota = $_SESSION['messageNota'];
    unset($_SESSION['messageNota']); // Clear the session variable after displaying the message
    showConfirmationMessagesNotas($messageNota);
}

if ($pdo) {
  

    $sqlmaterianota = "select dc.id_Cursada,u.fk_DNI,p.Nombre,p.Apellido, dc.fk_Usuario, dc.fk_Legajo, dc.fk_Materia,m.Descripcion,dc.fk_Estado, dc.Primer_Parcial, 
    dc.Recuperatio_Parcial_1, dc.Primer_TP, dc.Recuperatio_TP_1, dc.Segundo_Parcial,dc.Recuperatio_Parcial_2, dc.Segundo_TP,
     dc.Recuperatio_TP_2, dc.Promedio, dc.Anio, pn.cod_Plan, pn.Carrera, Final
     from DetalleCursada dc INNER JOIN Usuario u ON dc.fk_Usuario=u.Id_Usuario
     INNER JOIN Persona p ON p.DNI=u.fk_DNI 
     INNER JOIN Materia m ON m.id_Materia=dc.fk_Materia  
     INNER JOIN Plan pn  ON pn.cod_Plan=u.fk_Plan";

    $materianota = $pdo->query($sqlmaterianota);



    // Inicializar $alumnoData
    $alumnoData = null;
?>
<main class="app-content">

    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i>Lista de Calificaciones</h1>

        </div>



    </div>
    <div id="menu-container" class="container">

        <div class="row espaciado-entre-filas align-items-center">

            <div class="container mt-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Filtrar Alumnos</h4>
                        <form id="busquedaForm" class="form-row align-items-end">
                            <div class="form-group col-md-3">
                                <label for="dni">DNI:</label>
                                <input type="number" class="form-control" name="btnBuscarAlumnosDNI" id="dni"
                                    placeholder="Ingrese DNI">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="nombreUser">Nombre:</label>
                                <input type="text" class="form-control" name="btnBuscarAlumnosNombre" id="nombreUser"
                                    placeholder="Ingrese nombre">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="apellidoUser">Apellido:</label>
                                <input type="text" class="form-control" name="btnBuscarAlumnosApellido"
                                    placeholder="Ingrese apellido">
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-primary btn-lg" onclick="realizarBusqueda()">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 text-left">
                <!-- Divide la fila en 2 columnas y alinea a la derecha -->
                <a id="generarPDFBtn" href="#" onclick="descargarMateriaPDF(); return false;" class="planpdf-button">
                    <i class="fas fa-file-pdf"></i> Descargar PDF
                </a>

                <a id="generareEXCLBtn" href="#" onclick="descargarMateriaEXCL(); return false;"
                    class="planexcel-button">
                    <i class="fas fa-file-excel"></i> Descargar Excel
                </a>

                <!-- <a id="crearNuevoPlanBtn" href="#crearNuevoPlanModal" class="planalta-button"
                    onclick="mostrarCrearNuevoPlan(); return false;">
                    <i class="fas fa-plus"></i> Crear Nuevo Plan
                </a>-->
            </div>

            <div class="col-lg-6 text-right">
                <!-- Divide la fila en 2 columnas y alinea a la derecha -->



                <button data-toggle="modal" class="planalta-button" id="crearNuevoPlanBtn" type="button"
                    onclick="openModalNota()"><i class="fas fa-plus"></i>Primer Nota</button>

                <!-- <a id="crearNuevoPlanBtn" href="#crearNuevoPlanModal" class="planalta-button"
                    onclick="mostrarCrearNuevoPlan(); return false;">
                    <i class="fas fa-plus"></i> Crear Nuevo Plan
                </a>-->
            </div>

        </div>
        <div class="container">

            <h2>Calificaciones de Alumnos</h2>

            <?php while ($materia = $materianota->fetch(PDO::FETCH_ASSOC)) : ?>
            <?php
                    // Verificar si los datos del alumno actual son diferentes de los datos anteriores
                    if ($alumnoData === null || $alumnoData['fk_DNI'] !== $materia['fk_DNI']) {
                        if ($alumnoData !== null) {
                            // Cerrar la tabla anterior si no es el primer grupo de calificaciones
                            echo '</tbody></table>';
                        }
                        // Iniciar una nueva tabla para el nuevo alumno
                        
                        echo '<table id="calificaciones-table">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th  id="nombreAlumno" name="nombreAlumno" class="alumno-header" colspan="10"><i class="fas fa-graduation-cap"></i> Nombre Alumno: ' . $materia['Nombre'] . ' ' . $materia['Apellido'] . '</th>';
                        echo '</tr>';
                        echo '<tr id="nombre-alumno">';
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
                        // Actualizar los datos del alumno actual
                        $alumnoData = $materia;
                    }
                    ?>

            <?php
                    // Obtener las notas y aplicar las condiciones
                    $primerParcial = $materia['Primer_Parcial'];
                    $recuperatorio1 = $materia['Recuperatio_Parcial_1'];
                    $segundoParcial = $materia['Segundo_Parcial'];
                    $recuperatorio2 = $materia['Recuperatio_Parcial_2'];

                    $promedio = 0;

                    // Condiciones para calcular el promedio
                    if ($primerParcial >= 4) {
                        // Condición 1: Si el Primer_Parcial es mayor o igual a 4
                        $promedio = ($primerParcial + $segundoParcial) / 2;
                    } elseif ($primerParcial < 4 && $recuperatorio1 >= 4) {
                        // Condición 2: Si el Primer_Parcial es menor a 4 pero Recuperatio_Parcial_1 es mayor o igual a 4
                        $promedio = ($recuperatorio1 + $segundoParcial) / 2;
                    } elseif ($primerParcial >= 4 && $segundoParcial < 4) {
                        // Condición 3: Si el Primer_Parcial es mayor o igual a 4 pero el Segundo_Parcial es menor a 4
                        $promedio = ($primerParcial + $recuperatorio2) / 2;
                    } elseif ($recuperatorio1 < 4 && $recuperatorio2 < 4) {
                        // Condición 4: Si Recuperatio_Parcial_1 y Recuperatio_Parcial_2 son ambos menores a 4
                        $promedio = ($primerParcial + $recuperatorio2) / 2;
                    }

                    // Actualizar el promedio en la base de datos
                    $idCursada = $materia['id_Cursada'];
                    // Aquí debes realizar la conexión a tu base de datos y ejecutar la consulta de actualización
                    // Asegúrate de usar consultas preparadas para evitar inyecciones SQL
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
                        // Manejo de errores: Puedes mostrar un mensaje de error o registrar el error en algún lugar
                        echo "Error al actualizar el promedio: " . $e->getMessage();
                    }
                    ?>
            <tr>
                <td id="materiaEditar" name="materiaEditar" class="no-editable">
                    <?php echo $materia['Descripcion']; ?>
                </td>
                <td id="parcial1Editar" name="parcial1Editar" class="editable">
                    <?php echo $materia['Primer_Parcial']; ?>
                </td>
                <td id="recuperatorio1Editar" name="recuperatorio1Editar" class="editable">
                    <?php echo $materia['Recuperatio_Parcial_1']; ?></td>
                <td id="parcial2Editar" name="parcial2Editar" class="editable">
                    <?php echo $materia['Segundo_Parcial']; ?></td>
                <td id="recuperatorio2Editar" name="recuperatorio2Editar" class="editable">
                    <?php echo $materia['Recuperatio_Parcial_2']; ?></td>

                <td id="promedioEditar" name="promedioEditar" class="no-editable"><?php echo $promedio; ?>
                </td>
                <td id="finalnotaEditar" name="finalnotaEditar" class="editable"><?php echo $materia['Final']; ?>
                </td>
                <td id="carreraEditar" name="carreraEditar" class="no-editable"><?php echo $materia['Carrera']; ?>
                </td>
                <td id="anioMateriaEditar" name="anioMateriaEditar" class="no-editable">
                    <?php echo $materia['Anio']; ?>
                </td>
                <input type="hidden" name="nota_IDALUMNO_0" value="1">

                <td>
                    <button class="btn-icon" id="AgregarMasNota"
                        onclick="openModalAgregarMasNota(<?php echo $materia['id_Cursada']; ?>)">
                        <i class="fas fa-plus" style="color: blue;"></i>
                    </button>
                </td>




            </tr>
            <?php endwhile; ?>



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
</script>

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

<script>
$(document).ready(function() {
    var calificacionestable = $('#calificaciones-table').DataTable();
})

$(document).ready(function() {
    // Asignar el evento click al botón de búsqueda
    $('#buscarBtn').on('click', function() {
        realizarBusqueda();
    });
});


function realizarBusqueda() {
    // Collect filter values
    var dni = document.getElementById('dni').value;
    var nombre = document.getElementById('nombreUser').value;
    var apellido = document.getElementById('btnBuscarAlumnosApellido').value;

    // Make an asynchronous request to the server
    fetch('/instituto/Includes/sql.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'dni=' + dni + '&nombre=' + nombre + '&apellido=' + apellido,
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response data
        // Update the table or perform other actions based on the filtered data
        console.log(data);
    })
    .catch(error => console.error('Error:', error));
}


</script>