<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/sistemas/instituto/Includes/conexion.php';




function obtenerLegajoPorAlumno($alumnoId) {
    global $pdo;
    session_start();
    // Realiza la conexión a la base de datos (asegúrate de tener $pdo definido)
    // Si $pdo no está definido aquí, asegúrate de establecerlo antes de llamar a esta función

    // Realiza la consulta SQL
    $sql = "SELECT Legajo FROM Usuario u INNER JOIN Persona p ON u.fk_DNI = p.DNI WHERE u.Id_Usuario = :alumnoId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':alumnoId', $alumnoId, PDO::PARAM_INT);
    $stmt->execute();

    // Obtiene el resultado y lo devuelve como respuesta
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result['Legajo'];
    } else {
        return 'Legajo no encontrado';
    }
}




function obtenerAnioMateria($materiaId) {
    global $pdo;
    session_start();
    // Realiza la conexión a la base de datos (asegúrate de tener $pdo definido)
    // Si $pdo no está definido aquí, asegúrate de establecerlo antes de llamar a esta función

    // Realiza la consulta SQL
    $sql = "SELECT Anio_Carrera FROM Materia  WHERE id_Materia = :materiaId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':materiaId', $materiaId, PDO::PARAM_INT);
    $stmt->execute();

    // Obtiene el resultado y lo devuelve como respuesta
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result['Anio_Carrera'];
    } else {
        return 'Anio no encontrado';
    }
}



function obtenerEstadoMateria($estadoId) {
    global $pdo;
    session_start();
    // Realiza la conexión a la base de datos (asegúrate de tener $pdo definido)
    // Si $pdo no está definido aquí, asegúrate de establecerlo antes de llamar a esta función

    // Realiza la consulta SQL
    $sql = "SELECT fk_Estado FROM Materia  WHERE id_Materia = :estadoId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':estadoId', $estadoId, PDO::PARAM_INT);
    $stmt->execute();

    // Obtiene el resultado y lo devuelve como respuesta
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return intval($result['fk_Estado']);
    } else {
        return 'Estado no encontrado: ' . print_r($stmt->errorInfo(), true);
    }
}



if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    if ($accion === 'legajo') {
        // Lógica para obtener el legajo por alumno
        if (isset($_POST['id'])) {
            $alumnoId = $_POST['id'];
            $legajo = obtenerLegajoPorAlumno($alumnoId);
            echo $legajo;
        } else {
            echo 'ID de alumno no proporcionado';
        }
    } elseif ($accion === 'anio') {
        // Lógica para obtener el año de la materia
        if (isset($_POST['idAnio'])) {
            $materiaId = $_POST['idAnio'];
            $Anio_Carrera = obtenerAnioMateria($materiaId);
            echo $Anio_Carrera;
        } else {
            echo 'ID del año no proporcionado';
        }
    } elseif ($accion === 'estado') {
        // Lógica para obtener el estado de la materia
        if (isset($_POST['idEstado'])) { // Asegúrate de que el nombre de la variable coincida con el formulario
            $estadoId = $_POST['idEstado'];
            $estadoMateria = obtenerEstadoMateria($estadoId);
            echo $estadoMateria;
        } else {
            echo 'ID del estado no proporcionado';
        }
    } else {
        echo 'Acción no válida';
    }
} else {
    echo 'Acción no especificada';
}