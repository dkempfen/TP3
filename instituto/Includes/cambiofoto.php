<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';


session_start();

// Asumo que $pdo ya está configurado

// Verificar si el usuario ya tiene una foto de perfil
$queryVerificar = "SELECT COUNT(*) FROM cambio_foto_perfil WHERE usuario_id = ?";
$stmtVerificar = $pdo->prepare($queryVerificar);
$stmtVerificar->execute([$_SESSION['id_usuario']]);
$existeFoto = $stmtVerificar->fetchColumn();

if (isset($_FILES["file"])) {
    $file = $_FILES["file"];
    $name = $file["name"];
    $type = $file["type"];
    $tmp_n = $file["tmp_name"];
    $size = $file["size"];

    $folder = "../Imagenes/profiles/";

    // Cambio de foto
    if ($type != 'image/jpg' && $type != 'image/jpeg' && $type != 'image/png' && $type != 'image/gif') {
        echo "<div class='alert alert-success' role='alert'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Error, el archivo no es una imagen</div>";
    } else if ($size > 1024 * 1024) {
        echo "<div class='alert alert-success' role='alert'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              Error, el tamaño máximo permitido es 1MB</div>";
    } else {
        $src = $folder . $name;

        // Si el usuario ya tiene una foto, actualizar; de lo contrario, insertar
        if ($existeFoto) {
            $query = "UPDATE cambio_foto_perfil SET nueva_foto = ? WHERE usuario_id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$name, $_SESSION['id_usuario']]);
        } else {
            $query = "INSERT INTO cambio_foto_perfil (usuario_id, nueva_foto) VALUES (?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$_SESSION['id_usuario'], $name]);
        }

        if (move_uploaded_file($tmp_n, $src)) {
            echo "<div class='alert alert-success' role='alert'>
                ¡Bien hecho! Perfil actualizado correctamente</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>
                Error al subir la imagen</div>";
        }
    }
}
?>


