<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';

// Suponiendo que $_POST['user_id'], $_POST['token'], $_POST['password'], $_POST['con_password'] existen

$user_id = $_POST['user_id'];
$token = $_POST['token'];
$password = $_POST['password'];
$con_password = $_POST['con_password'];

if (validaPassword($password, $con_password)) {
    $pass_hash = hashPassword($password);

    try {
        $stmt = $pdo->prepare("UPDATE Usuario SET Password = ?, token_password='', password_request=0 WHERE Id_Usuario = ? AND token_password = ?");
        $stmt->bindParam(1, $pass_hash, PDO::PARAM_STR);
        $stmt->bindParam(2, $user_id, PDO::PARAM_INT);
        $stmt->bindParam(3, $token, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Contraseña modificada";
            echo "<br><a href='index.php' > Iniciar Sesión</a>";
        } else {
            $errors[] = "Error al modificar la contraseña";
        }
    } catch (PDOException $e) {
        // Manejo de errores de PDO
        $errors[] = "Error: " . $e->getMessage();
    }
} else {
    echo 'Las Contraseñas no coinciden';
}
?>
