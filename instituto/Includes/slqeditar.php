<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
</head>

<?php
require_once('load.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();
    global $pdo;
    $oldPassword = $_POST["old_password"];
    $newPassword = $_POST["new_password"];
    $confirmNewPassword = $_POST["confirm_new_password"];
    $usuario_id = 1;
    $sql = "SELECT clave FROM usuarios WHERE usuario_id = :usuario_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->execute();
    $row = $stmt->fetch();
    $clave_actual_almacenada_db = $row['clave'];

    if (empty($oldPassword) || empty($newPassword) || empty($confirmNewPassword)) {
        echo "Por favor, complete todos los campos.";
    } else {
        if ($oldPassword !== $clave_actual_almacenada_db) {
            echo "La contraseña actual ingresada no coincide con la contraseña almacenada.";
        } else if ($newPassword !== $confirmNewPassword) {
            echo "Las contraseñas no coinciden. No se pudo cambiar la contraseña.";
        } else {
            try {
                $sql = "UPDATE usuarios SET clave = :new_password WHERE usuario_id = :usuario_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':new_password', $newPassword);
                $stmt->bindParam(':usuario_id', $usuario_id);
                $stmt->execute();
                echo "¡Contraseña cambiada exitosamente!";
            } catch (PDOException $e) {
                echo "Error al actualizar la contraseña: " . $e->getMessage();
            }
        }
    }
}

/*if (isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['confirm_new_password'])) {
    cambiarClave();
  
    header("Location: /instituto/Adman/profile.php");
    exit();
  }*/

?>