<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
</head>

<?php

require_once('load.php');

function showConfirmationMessages($message) {
    echo "<script>
        Swal.fire({
            icon: '" . $message['type'] . "',
            title: '" . $message['text'] . "',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {
            window.location.href = '/instituto/Adman/lista_usuarios.php';
        });
    </script>";
}


    
    function actualizaruser($idUsuario, $legajo, $plan, $password, $rol, $estado) {
        global $pdo;
        session_start();
    
        try {
            $pdo->beginTransaction();
    
            // Realizar la actualización en la base de datos
            $query = "UPDATE Usuario SET Legajo = ?, fk_Plan = ?, Password = ?, fk_Rol = ?, fk_Estado = ? WHERE Id_Usuario = ?";
            $stmtUsuario = $pdo->prepare($query);
            $stmtUsuario->execute([$legajo, $plan, $password, $rol, $estado, $idUsuario]);
    
            if ($stmtUsuario->rowCount() > 0) {
                $_SESSION['message'] = [
                    'type' => 'success',
                    'text' => 'Usuario actualizado exitosamente.'
                ];
            } else {
                $_SESSION['message'] = [
                    'type' => 'info',
                    'text' => 'No se ha actualizado ningún dato.'
                ];
            }

            $pdo->commit();
        } catch (PDOException $e) {
            $pdo->rollBack();
            $_SESSION['message'] = [
                'type' => 'error',
                'text' => 'Error al actualizar el usuario: ' . $e->getMessage()
            ];
        }
    }
    
    if (isset($_POST['btnmodificar'])) {
        $idUsuario = $_POST['idusuarioeditar'];
        $legajo = $_POST['legajoeditar'];
        $plan = $_POST['planeditar'];
        $password = $_POST['claveeditar'];
        $rol = $_POST['listRoleditar'];
        $estado = $_POST['listEstadoeditar'];
    
        // Llamar a la función actualizaruser
        actualizaruser($idUsuario, $legajo, $plan, $password, $rol, $estado);
    
        header("Location: /instituto/Adman/lista_usuarios.php");
        exit();
    }
    ?>
?>