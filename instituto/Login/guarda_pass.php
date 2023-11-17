<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';

// Obtener datos del formulario
$user_id = $_POST['user_id'] ?? null;
$token = $_POST['token'] ?? null;
$password = $_POST['password'] ?? null;
$con_password = $_POST['con_password'] ?? null;

// Verificar si las contraseñas coinciden
if ($password == $con_password) {
    // Verifica que el token y el usuario son válidos
    if (verificaTokenPass($user_id, $token)) {
        // Realiza el cambio de contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $result = cambiaPassword($hashed_password, $user_id, $token);
        echo $result;
    } else {
        echo 'No se pudo verificar los datos';
    }
} else {
    echo 'Las contraseñas no coinciden.';
}

function cambiaPassword($password, $user_id, $token)
{
    global $pdo;

    try {
        $stmt = $pdo->prepare("UPDATE Usuario SET Password = :password, token_password='', password_request=0 WHERE Id_Usuario = :user_id AND token_password = :token");
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // La contraseña se cambió con éxito
            return 'Contraseña modificada con éxito.';
        } else {
            // No se pudo cambiar la contraseña
            return 'Error al modificar la contraseña.';
        }
    } catch (PDOException $e) {
        // Manejo de errores de PDO
        return 'Error en la base de datos: ' . $e->getMessage();
    }
}
?>
