

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
</head>

<?php

require_once('load.php');

function showConfirmationMessagesMateriaEstado($message) {
    echo "<script>
        Swal.fire({
            icon: '" . $message['type'] . "',
            title: '" . $message['text'] . "',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {                                  
            window.location.href = '/sistemas/instituto/Adman/lista_materia.php';
        });
    </script>";
}  



function actualizarEstadoMateria()
{
    session_start();
    if (isset($_POST['id_Materia']) && isset($_POST['fk_Estado'])) {
        $id_Materia = $_POST['id_Materia'];
        $fk_Estado = isset($_POST["fk_Estado"]) ? intval($_POST["fk_Estado"]) : 0;

        $fk_Estado = ($fk_Estado == 1) ? "Habilitado" : "Inhabilitado" ;

        global $pdo;
        $sql = "SELECT Id_Estado FROM Estado WHERE Descripcion_Estado = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$fk_Estado]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
          $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'El Estado seleccionado no existe.'
          ];
          return;
        }
  
        $fk_Estado = $result['Id_Estado'];
  
        // La consulta SQL se actualiza para usar los marcadores de posición
        global $pdo;
        $sql = "UPDATE Materia SET fk_Estado = :fk_Estado WHERE id_Materia = :id_Materia";
        $stmt = $pdo->prepare($sql);

        // Vincula los valores a los marcadores de posición
        $stmt->bindParam(':fk_Estado', $fk_Estado, PDO::PARAM_INT);
        $stmt->bindParam(':id_Materia', $id_Materia, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['message'] = [
                'type' => 'success',
                'text' => 'Estado de materia actualizado exitosamente'
            ];
        } else {
            $_SESSION['
            message'] = [
                'type' => 'error',
                'text' => 'Ha ocurrido un error al actualizar el estado de la materia.'
            ];
        }
    } else {
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'Faltan parámetros requeridos para actualizar el estado de la materia.'
        ];
    }
}

if (isset($_POST['id_Materia']) && isset($_POST['fk_Estado']) ) {
    actualizarEstadoMateria();

  header("Location:/sistemas/instituto/Adman/lista_materia.php");
  exit();
}

