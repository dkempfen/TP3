<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Adman/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';

$dni = isset($_POST['dniBusqueda']) ? $_POST['dniBusqueda'] : '';
$nombre = isset($_POST['nombreUserBusqueda']) ? $_POST['nombreUserBusqueda'] : '';
$apellido = isset($_POST['apellidoUserBusqueda']) ? $_POST['apellidoUserBusqueda'] : '';
$materia = isset($_POST['materiaUserBusqueda']) ? $_POST['materiaUserBusqueda'] : '';

if (empty($dni) && empty($nombre) && empty($apellido) && empty($materia)) {
    // Redirige a Notas.php si no se proporcionan parámetros de búsqueda
    exit();
}
// Query para obtener los datos de la tabla 'DetalleCursada' filtrados por DNI, Nombre y Apellido
$sql = "SELECT *
        FROM DetalleCursada dc 
        INNER JOIN Usuario u ON dc.fk_Usuario = u.Id_Usuario
        INNER JOIN Persona p ON p.DNI = u.fk_DNI
        INNER JOIN Materia m ON m.id_Materia = dc.fk_Materia  
        INNER JOIN Plan pn ON pn.cod_Plan = u.fk_Plan
        WHERE p.DNI LIKE :dni AND p.Nombre LIKE :nombreUserBusqueda AND p.Apellido LIKE :apellidoUserBusqueda
        AND m.Descripcion LIKE :materiaUserBusqueda";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':dni', "%$dni%", PDO::PARAM_STR);
$stmt->bindValue(':nombreUserBusqueda', "%$nombre%", PDO::PARAM_STR);
$stmt->bindValue(':apellidoUserBusqueda', "%$apellido%", PDO::PARAM_STR);
$stmt->bindValue(':materiaUserBusqueda', "%$materia%", PDO::PARAM_STR);

$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($results) > 0) {
    // Crear un array asociativo para agrupar las materias por alumno
    $alumnosMaterias = array();

    foreach ($results as $row) {
        $dniAlumno = $row['fk_DNI'];

        // Crear una entrada para el alumno si no existe
        if (!isset($alumnosMaterias[$dniAlumno])) {
            $alumnosMaterias[$dniAlumno] = array(
                'Nombre' => $row['Nombre'],
                'Apellido' => $row['Apellido'],
                'DNI' => $row['DNI'],
                'Materias' => array()
            );
        }

        // Agregar la materia al array del alumno
        $alumnosMaterias[$dniAlumno]['Materias'][] = $row;
    }

    // Muestra los resultados en una tabla HTML por separado para cada alumno
    foreach ($alumnosMaterias as $alumno) {
        echo '<div class="table-responsive">';
        echo '<table id="calificaciones-table" class="table table-bordered table-striped">';
        echo '<thead class="thead-dark">';
        echo '<tr>';
        echo '<th class="alumno-header" colspan="10">';
        echo '<i class="fas fa-graduation-cap"></i> Detalles del Alumno: ';
        echo 'Nombre: ' . $alumno['Nombre'] . ' ' . $alumno['Apellido'] . ' - DNI: ' . $alumno['DNI'];
        echo '</th>';
        echo '</tr>';
        echo '<tr class="expansible detalles-notas-' . $dniAlumno . '" id="nombre-alumno">';
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

        foreach ($alumno['Materias'] as $materia) {
            echo '<tr>';
            echo '<td>' . $materia['Descripcion'] . '</td>';
            echo '<td>' . $materia['Primer_Parcial'] . '</td>';
            echo '<td>' . $materia['Recuperatio_Parcial_1'] . '</td>';
            echo '<td>' . $materia['Segundo_Parcial'] . '</td>';
            echo '<td>' . $materia['Recuperatio_Parcial_2'] . '</td>';
            echo '<td>' . $materia['Promedio'] . '</td>';
            echo '<td>' . $materia['Final'] . '</td>';
            echo '<td>' . $materia['Carrera'] . '</td>';
            echo '<td>' . $materia['Anio'] . '</td>';
            echo '<td>';
            echo '<button class="btn btn-primary" onclick="openModalAgregarMasNota(' . $materia['id_Cursada'] . ')">';
            echo '<i class="fas fa-plus"></i>';
            echo '</button>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }
} else {
    // Mostrar mensaje si no hay resultados
    echo '<div style="text-align: center; margin-top: 20px; margin-bottom: 20px; font-size: 24px;">Sin resultados</div>';
}
?>
