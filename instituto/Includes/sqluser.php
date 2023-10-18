<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
</head>

<?php

require_once('load.php');

function showConfirmationMessageUser($message) {
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


function showConfirmationMessagePlan($messagePlan) {
    echo "<script>
        Swal.fire({
            icon: '" . $messagePlan['type'] . "',
            title: '" . $messagePlan['text'] . "',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {                                  
            window.location.href = '/instituto/Adman/lista_planes.php';

        });
    </script>";
}       

function showConfirmationMessageEditarPlan($messageEditarPlan) {
    echo "<script>
        Swal.fire({
            icon: '" . $messageEditarPlan['type'] . "',
            title: '" . $messageEditarPlan['text'] . "',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {                                  
            window.location.href = '/instituto/Adman/lista_planes.php';

        });
    </script>";
}      



///////////////Actuañ Datos Pantalla User///////////////////////

function editarUsuarios($legajoUser, $claveeditaruser,$libromatrizEditar ,$planUserEditar, $rolUserEditar,$UserId) {
    session_start();
    global $pdo;
    

    $sql = "UPDATE Usuario SET Legajo = ?, Password = ?, Libromatriz = ?, fk_Plan = ?, fk_Rol = ? WHERE Id_Usuario = ?";
    $stmt = $pdo->prepare($sql);

    // Verifica si los valores son nulos antes de ejecutar la consulta
    $stmt->execute([$legajoUser, $claveeditaruser,$libromatrizEditar ,$planUserEditar, $rolUserEditar,$UserId]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = [
            'type' => 'success',
            'text' => 'Datos del usuario actualizados exitosamente'
        ];
    } else {
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'Ha ocurrido un error al actualizar los datos del usuario.'
        ];
    }

     // Redirige según el rol
    if ($rolUserEditar == 3) {
        header("Location: /instituto/Adman/lista_usuarios.php?rol=3");
    } elseif ($rolUserEditar == 2) {
        header("Location: /instituto/Adman/lista_usuarios.php?rol=2");
    } elseif ($rolUserEditar == 1) {
        header("Location: /instituto/Adman/lista_usuarios.php?rol=1");
    } else {
        header("Location: /instituto/Adman/lista_usuarios.php");
    }
    exit();
}

// Verificar si se ha enviado una solicitud de edición (update)
if (isset($_POST['btnmodificarUsuario'])) {
    $UserId = $_POST['UserId'];
    $dniUserEditar = $_POST['dniUserEditar'];
    $legajoUser = $_POST['Legajoeditar'];
    $claveeditaruser = $_POST['claveeditaruser'];
    $libromatrizEditar = $_POST['libromatrizEditar'];
    $planUserEditar = $_POST['planUserEditar'];
    $rolUserEditar = $_POST['rolUserEditar'];
   

    // Llamar a la función EditarPersona solo si los campos requeridos no están vacíos
    editarUsuarios($legajoUser, $claveeditaruser,$libromatrizEditar ,$planUserEditar, $rolUserEditar,$UserId);



    if ($rolUserEditar == 3) {
        header("Location: /instituto/Adman/lista_usuarios.php?rol=3");
    } elseif ($rolUserEditar == 2) {
        header("Location: /instituto/Adman/lista_usuarios.php?rol=2");
    } elseif ($rolUserEditar == 1) {
        header("Location: /instituto/Adman/lista_usuarios.php?rol=1");
    } else {
        header("Location: /instituto/Adman/lista_usuarios.php");
    }
    exit();
}

///////////////Actuañ Datos Pantalla User///////////////////////

function guardarCambios($nombreTarjeta, $estadoTarjeta, $fechaInicio, $fechaFinal, $cod_Plan) {
    session_start();
    global $pdo;
    

    $sql = "UPDATE Plan SET Carrera = ?, Estado_Id_Estado = ?, Fecha_Inicio = ?, Fecha_Final = ? WHERE cod_Plan = ?";
    $stmt = $pdo->prepare($sql);

    // Verifica si los valores son nulos antes de ejecutar la consulta
    $stmt->execute([$nombreTarjeta, $estadoTarjeta, $fechaInicio, $fechaFinal, $cod_Plan]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['messageEditarPlan'] = [
            'type' => 'success',
            'text' => 'Datos del plan  actualizados exitosamente'
        ];
    } else {
        $_SESSION['messageEditarPlan'] = [
            'type' => 'error',
            'text' => 'Ha ocurrido un error al actualizar los datos del plan.'
        ];
    }

    header("Location: /instituto/Adman/lista_planes.php");
    exit();
}

// Verificar si se ha enviado una solicitud de edición (update)
if (isset($_POST['btnmodificarPlan'])) {
    $cod_Plan = $_POST['cod_Plan']; // Asegúrate de obtener el código de plan desde el formulario
    $nombreTarjeta = $_POST['nombreTarjeta'];
    $estadoTarjeta = $_POST['estadoTarjeta'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFinal = $_POST['fechaFinal'];

   

    // Llamar a la función EditarPersona solo si los campos requeridos no están vacíos
    guardarCambios($nombreTarjeta, $estadoTarjeta, $fechaInicio, $fechaFinal, $cod_Plan);

    header("Location: /instituto/Adman/lista_planes.php");
    exit();
}





function InsertarPlan($nombreTarjetaCrear, $CarreraCrear, $fechaInicioCrear, $fechaFinalCrear, $estadoPlanCrear) {
    session_start();
    global $pdo;
    

    $sql = "INSERT INTO Plan (cod_Plan, Carrera, Fecha_Inicio, Fecha_Final,Estado_Id_Estado) VALUES (?, ?, ?, ?,?)";
    $stmt = $pdo->prepare($sql);

    // Verifica si los valores son nulos antes de ejecutar la consulta
    $stmt->execute([$nombreTarjetaCrear, $CarreraCrear, $fechaInicioCrear, $fechaFinalCrear, $estadoPlanCrear]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['messagePlan'] = [
            'type' => 'success',
            'text' => 'Datos del plan crear exitosamente'
        ];
    } else {
        $_SESSION['messagePlan'] = [
            'type' => 'error',
            'text' => 'Ha ocurrido un error al crear los datos del plan.'
        ];
    }

    header("Location: /instituto/Adman/lista_planes.php");
    exit();
}

// Verificar si se ha enviado una solicitud de edición (update)
if (isset($_POST['btnmCrearPlan'])) {
    $nombreTarjetaCrear = $_POST['nombreTarjetaCrear']; // Asegúrate de obtener el código de plan desde el formulario
    $CarreraCrear = $_POST['CarreraCrear'];
    $fechaInicioCrear = $_POST['fechaInicioCrear'];
    $fechaFinalCrear = $_POST['fechaFinalCrear'];
    $estadoPlanCrear = $_POST['estadoPlanCrear'];

   

    // Llamar a la función EditarPersona solo si los campos requeridos no están vacíos
    InsertarPlan($nombreTarjetaCrear, $CarreraCrear, $fechaInicioCrear, $fechaFinalCrear, $estadoPlanCrear);

    header("Location: /instituto/Adman/lista_planes.php");
    exit();
}





?>