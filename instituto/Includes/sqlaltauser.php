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
            window.location.href = '/instituto/Adman/subPantallas/lista_materia.php';
        });
    </script>";
}  


function showConfirmationMessageFecha($messageFecha) {
    echo "<script>
        Swal.fire({
            icon: '" . $messageFecha['type'] . "',
            title: '" . $messageFecha['text'] . "',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {                                  
            window.location.href = '/instituto/Adman/Pantallas/finales.php';
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

  header("Location: /instituto/Adman/subPantallas/lista_materia.php");
  exit();
}

function actualizarEstadoFecha()
{
    session_start();
    global $pdo;
    if (isset($_POST['toggleAll']) && isset($_POST['estado'])) {
        $estado = $_POST['estado'];
    
        // Actualiza todos los registros en la tabla FechasFinales
        $sql = "UPDATE FechasFinales SET fk_Estado_Final = :estado";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            $_SESSION['messageFecha'] = [
                'type' => 'success',
                'text' => 'Estado de fecha final actualizado exitosamente'
            ];
        } else {
            $_SESSION['messageFecha'] = [
                'type' => 'error',
                'text' => 'Ha ocurrido un error al actualizar el estado de la fecha final.'
            ];
        }
    } else {
        $_SESSION['messageFecha'] = [
            'type' => 'error',
            'text' => 'Faltan parámetros requeridos para actualizar el estado de la fecha final.'
        ];
    }
    header("Location: /instituto/Adman/Pantallas/finales.php");
    exit();
}

if (isset($_POST['toggleAll']) && isset($_POST['estado']) ) {
    actualizarEstadoFecha();
    header("Location: /instituto/Adman/Pantallas/finales.php");
    exit();
}



function obtenerEstadoToggleAll() {
    global $pdo;
    
    // Cambié la tabla de 'Materias' a 'FechasFinales' en la consulta
    $sql = "SELECT COUNT(*) FROM FechasFinales WHERE fk_Estado_Final = 1";
    $estadoToggleAll = $pdo->query($sql)->fetchColumn();

    // Si hay al menos un registro habilitado, devolvemos 1, de lo contrario, devolvemos 0
    return $estadoToggleAll > 0 ? 1 : 2;
}

if (isset($_POST['isChecked'])) {
    $isChecked = $_POST['isChecked'];
    $result = toggleStatusMessage($isChecked);
    echo json_encode($result);
}

function toggleStatusMessage($isChecked) {
    $result = [];

    if ($isChecked) {
        $fechasActivas = obtenerEstadoToggleAll();

        if ($fechasActivas === 1) {
            $result['message'] = 'Las fechas están activas para anotarse.';
            // Usar la misma clave 'dateRows1' aquí
            $result['dateRows1'] = '<tr><td>Fecha activa</td><td>2023-09-25</td></tr>';
        } else {
            $result['message'] = 'No hay fechas activas para anotarse.';
            // Usar la misma clave 'dateRows1' aquí
            $result['dateRows1'] = '';
        }
    } else {
        $result['message'] = '';
        $result['dateRows1'] = '';
    }

    return $result;
}