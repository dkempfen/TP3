<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/modals/altaNota.php';



?>


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
                            <!-- Agregamos la clase "align-items-end" aquí -->
                            <div class="form-group col-md-3">
                                <label for="dni">DNI:</label>
                                <input type="text" class="form-control" id="dni">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="nombreUser">Nombre:</label>
                                <input type="text" class="form-control" id="nombreUser">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="apellidoUser">Apellido:</label>
                                <input type="text" class="form-control" id="apellidoUser">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="userNotas">Usuario:</label>
                                <input type="text" class="form-control" id="userNotas">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="carreraNotas">Carrera:</label>
                                <select class="form-control" id="carreraNotas">
                                    <option value="Redes Informaticas">Redes Informaticas</option>
                                    <option value="Analista de Sistema">Analista de Sistema</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="planNotas">Plan:</label>
                                <select class="form-control" id="planNotas">
                                    <option value="Plan 1">Plan 1</option>
                                    <option value="Plan 2">Plan 2</option>
                                    <option value="Plan 3">Plan 3</option>
                                    <!-- Agrega más opciones de plan según sea necesario -->
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <button type="submit" class="btn-primary btn-buscar">
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
                    onclick="openModalNota()"><i class="fas fa-plus"></i> Ingresar Nota</button>

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
                echo '<th class="alumno-header" colspan="10"><i class="fas fa-graduation-cap"></i> Nombre Alumno: ' . $materia['Nombre'] . ' ' . $materia['Apellido'] . '</th>';
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
                echo '<th>Editar</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                // Actualizar los datos del alumno actual
                $alumnoData = $materia;
            }
            ?>
            <tr>
                <td><?php echo $materia['Descripcion']; ?></td>
                <td><?php echo $materia['Primer_Parcial']; ?></td>
                <td><?php echo $materia['Recuperatio_Parcial_1']; ?></td>
                <td><?php echo $materia['Segundo_Parcial']; ?></td>
                <td><?php echo $materia['Recuperatio_Parcial_2']; ?></td>
                <td><?php echo $materia['Promedio']; ?></td>
                <td><?php echo $materia['Final']; ?></td>
                <td><?php echo $materia['Carrera']; ?></td>
                <td><?php echo $materia['Anio']; ?></td>
                <td>
                    <button class="edit-button" data-alumno-id="<?php echo $materia['fk_Usuario']; ?>">
                        Editar
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

