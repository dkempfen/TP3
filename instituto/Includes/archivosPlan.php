<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';

session_start();
$response = array();

$rutaBase = $_SERVER['DOCUMENT_ROOT'] . '/instituto/';
$rutaAlmacenamiento = $rutaBase . 'documentos/plan/';

$queryVerificar = "SELECT Descripcion_Documentacion FROM Documentacion WHERE fk_Plan = ?";
$stmtVerificar = $pdo->prepare($queryVerificar);
$stmtVerificar->execute([$_POST['cod_Plan']]);
$nombreArchivoExistente = $stmtVerificar->fetchColumn();

echo '<div class="tu-clase-para-el-mensaje">'; // Puedes agregar clases según tu estilo CSS

if ($nombreArchivoExistente) {
    echo '<p><strong>Archivo del Plan:</strong> Se ha adjuntado un archivo</p>';
    // Eliminar el archivo existente
    $queryDelete = "DELETE FROM Documentacion WHERE fk_Plan = ?";
    $stmtDelete = $pdo->prepare($queryDelete);
    $stmtDelete->execute([$_POST['cod_Plan']]);
    unlink('/instituto/documentos/plan/' . $nombreArchivoExistente);
} else {
    echo '<p><strong>Archivo del Plan:</strong> No se ha adjuntado archivo</p>';
}

echo '<div id="respuestaPlanArchivo"></div>';
echo '</div>';

if (isset($_FILES["archivoPlan"])) {
    $archivoPlan = $_FILES["archivoPlan"];
    $nombreArchivo = $archivoPlan["name"];
    $tipoArchivo = $archivoPlan["type"];
    $tmpArchivo = $archivoPlan["tmp_name"];
    $tamañoArchivo = $archivoPlan["size"];
    
    // Verificar si el archivo es un PDF Word
    $extensionesValidas = array('pdf', 'doc', 'docx');
    $extensionArchivo = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));

    if (!in_array($extensionArchivo,$extensionesValidas)) {
        echo "<div class='alert alert-danger' role='alert'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Error, el archivo debe ser PDF o Word</div>";
    } else if ($tamañoArchivo > 1024 * 1024) {
        echo "<div class='alert alert-danger' role='alert'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Error, el tamaño máximo permitido es 1MB</div>";
    } else {
        $rutaArchivo = $rutaAlmacenamiento . $nombreArchivo;

        // Insertar el nuevo archivo
        $query = "INSERT INTO Documentacion (Descripcion_Documentacion, Estado_Documentacion, Ubicacion, fk_Plan) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $estadoDocumentacion = 1; // Cambiar a 1 para indicar el estado deseado
        $stmt->execute([$nombreArchivo, $estadoDocumentacion, $rutaArchivo, $_POST['cod_Plan']]);

       
    // Mover el archivo a la ubicación deseada
    if (move_uploaded_file($tmpArchivo, $rutaArchivo)) {
        echo "<div class='alert alert-success' role='alert'>
            ¡Bien hecho! Archivo del plan actualizado correctamente</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>
            Error al subir el archivo</div>";
    }
    }
}
?>