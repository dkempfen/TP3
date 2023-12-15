<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
</head>

<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
//////////Mensajes /////////////////
function showConfirmationMessageCO($message) {
  echo "<script>
      Swal.fire({
          icon: '" . $message['type'] . "',
          title: '" . $message['text'] . "',
          showConfirmButton: false,
          timer: 1500
      });
  </script>";
}


// Incluir el archivo que carga las configuraciones y funciones necesarias
require_once $_SERVER['DOCUMENT_ROOT'] . '/instituto/Includes/load.php';

global $pdo;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    echo "User ID (POST): $user_id, Token (POST): $token";
    
    if (verificaTokenPass($user_id, $token)) {
        // Token válido, cambiar la contraseña en la base de datos
        $hashed_password = hashPassword($password);
        if (cambiaPassword($hashed_password, $user_id, $token)) {
            // Contraseña cambiada con éxito, redirigir a la página de inicio de sesión
            header("Location: index.php");
            exit();
        } else {
            echo "Error al cambiar la contraseña.";
        }
    } else {
        echo "El token no es válido.";
    }
}

?>