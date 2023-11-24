<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
</head>

<?php

//////////Mensajes /////////////////
require_once('load.php');


function obtenerDetallesPlan($codPlan) {
    global $pdo;

    // Verifica si se proporcionó el código del plan
    if (empty($codPlan)) {
        // Devuelve un mensaje de error si no se proporcionó el código del plan
        return ['error' => 'No se proporcionó el código del plan'];
    }

    // Realiza una consulta para obtener los detalles del plan con el código proporcionado
    $sql = "SELECT *
            FROM Detalle_Plan dp
            LEFT JOIN Plan p ON p.cod_Plan = dp.fk_Plan 
            LEFT JOIN Materia m ON dp.fk_Materia = m.id_Materia
            LEFT JOIN Materia_Profesor mp ON dp.fk_Materia = mp.id_Materia
            WHERE cod_Plan = :codPlan
            ORDER BY m.Anio_Carrera DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':codPlan', $codPlan);
    $stmt->execute();

    // Verifica si la ejecución de la consulta fue exitosa
    if ($stmt === false) {
        return ['error' => 'Error al ejecutar la consulta SQL.'];
    }

    // Obtén los datos
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verifica si hay datos antes de intentar acceder a la posición 0
    if (!empty($data)) {
        // Obtén el encabezado
        $header = array_keys($data[0]);
        // Devuelve la respuesta como un array asociativo con el encabezado y los datos
        return ['header' => $header, 'data' => $data];
    } else {
        // Si no hay datos, devuelve un array vacío
        return ['header' => [], 'data' => []];
    }
}


if (isset($_POST['cod_Plan'])) {
    $codPlan = $_POST['cod_Plan'];
    $detallePlan = obtenerDetallesPlan($codPlan);

    // Devuelve la respuesta al frontend
    echo json_encode($detallePlan);
} else {
    // Si no se proporcionó el código del plan, devuelve un mensaje de error
}