<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
</head>

<?php

require_once('load.php');

function showConfirmationMessageUser($message, $rolUserEditar) {
    echo "<script>
        Swal.fire({
            icon: '" . $message['type'] . "',
            title: '" . $message['text'] . "',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {";

    if ($rolUserEditar == 3) {
        echo "window.location.href = '/instituto/Adman/lista_usuarios.php?rol=3';";
    } elseif ($rolUserEditar == 2) {
        echo "window.location.href = '/instituto/Adman/lista_usuarios.php?rol=2';";
    } elseif ($rolUserEditar == 1) {
        echo "window.location.href = '/instituto/Adman/lista_usuarios.php?rol=1';";
    } else {
        echo "window.location.href = '/instituto/Adman/lista_usuarios.php';";
    }

    echo "});
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


function showConfirmationMessagesNotas($messageNota) {
    echo "<script>
        Swal.fire({
            icon: '" . $messageNota['type'] . "',
            title: '" . $messageNota['text'] . "',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {                                  
            window.location.href = '/instituto/Adman/Pantallas/Notas.php';
        });
    </script>";
}  




///////////////Actuañ Datos Pantalla User///////////////////////
function editarUsuarios($legajoUser, $claveeditaruser, $libromatrizEditar, $planUserEditar, $rolUserEditar, $UserId) {
    session_start();
    global $pdo;

    $sql = "UPDATE Usuario SET Legajo = ?, Password = ?, Libromatriz = ?, fk_Plan = ?, fk_Rol = ? WHERE Id_Usuario = ?";
    $stmt = $pdo->prepare($sql);

    // Verifica si los valores son nulos antes de ejecutar la consulta
    $stmt->execute([$legajoUser, $claveeditaruser, $libromatrizEditar, $planUserEditar, $rolUserEditar, $UserId]);

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

    // Llamar a la función editarUsuarios solo si los campos requeridos no están vacíos
    editarUsuarios($legajoUser, $claveeditaruser, $libromatrizEditar, $planUserEditar, $rolUserEditar, $UserId);
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



function insertarNuevaNota($alumnoNota, $LegajoNota, $materia, $anioMateria, $estadoMateria, $parcial1, $recuperatorio1, $parcial2, $recuperatorio2, $finalnota) {
    session_start();
    global $pdo;

    $sql = "INSERT INTO DetalleCursada 
            (fk_Usuario, fk_Legajo, fk_Materia, Anio, fk_Estado, Primer_Parcial, Recuperatio_Parcial_1, 
            Segundo_Parcial, Recuperatio_Parcial_2, Final)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$alumnoNota, $LegajoNota, $materia, $anioMateria, $estadoMateria, $parcial1, $recuperatorio1, $parcial2, $recuperatorio2, $finalnota]);


    if ($stmt->rowCount() > 0) {
        $_SESSION['messageNota'] = [
            'type' => 'success',
            'text' => 'Nota insertada exitosamente.'
        ];
    } else {
        $_SESSION['messageNota'] = [
            'type' => 'error',
            'text' => 'Ha ocurrido un error al insertar la nota.'
        ];
    }

    header("Location: /instituto/Adman/Pantallas/Notas.php");
    exit();
}

// Verificar si se ha enviado una solicitud de inserción
if (isset($_POST['btnmCrearNota'])) {
    $alumnoNota = $_POST['alumnoNota'];
    $LegajoNota = $_POST['LegajoNota'];
    $materia = $_POST['materia'];
    $anioMateria = $_POST['anioMateria'];
    $estadoMateria = $_POST['estadoMateria'];
    $parcial1 = $_POST['parcial1'];
    $recuperatorio1 = $_POST['recuperatorio1'];
    $parcial2 = $_POST['parcial2'];
    $recuperatorio2 = $_POST['recuperatorio2'];
    $finalnota = $_POST['finalnota'];

    insertarNuevaNota($alumnoNota, $LegajoNota, $materia, $anioMateria, $estadoMateria, $parcial1, $recuperatorio1, $parcial2, $recuperatorio2, $finalnota);
    header("Location: /instituto/Adman/Pantallas/Notas.php");
    exit();
}



function ActualizarNuevaNota($alumnoNotaEditar, $LegajoNotaEditar, $materiaEditar, $anioMateriaEditar, $estadoMateriaEditar, $parcial1Editar, $recuperatorio1Editar, $parcial2Editar, $recuperatorio2Editar, $finalnotaEditar, $idCursada) {
    session_start();
    global $pdo;

    $sql = "UPDATE DetalleCursada SET
         fk_Usuario = ?, fk_Legajo = ?, fk_Materia = ?, Anio = ?, fk_Estado = ?, Primer_Parcial = ?, Recuperatio_Parcial_1 = ?, 
            Segundo_Parcial = ?, Recuperatio_Parcial_2 = ?, Final = ? WHERE id_Cursada = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$alumnoNotaEditar, $LegajoNotaEditar, $materiaEditar, $anioMateriaEditar, $estadoMateriaEditar, $parcial1Editar, $recuperatorio1Editar, $parcial2Editar, $recuperatorio2Editar, $finalnotaEditar, $idCursada]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['messageNota'] = [
            'type' => 'success',
            'text' => 'Nota actualizada exitosamente.'
        ];
    } else {
        $_SESSION['messageNota'] = [
            'type' => 'error',
            'text' => 'Ha ocurrido un error al actualizar la nota.'
        ];
    }

    header("Location: /instituto/Adman/Pantallas/Notas.php");
    exit();
}

// Verificar si se ha enviado una solicitud de actualización
if (isset($_POST['alumnoNotaEditar'])) {
    $alumnoNotaEditar = $_POST['alumnoNotaEditar'];
    $LegajoNotaEditar = 0; // Asegúrate de obtener este valor adecuadamente
    $materiaEditar = $_POST['materiaEditar'];
    $anioMateriaEditar = $_POST['anioMateriaEditar'];
    $estadoMateriaEditar = 0; // Asegúrate de obtener este valor adecuadamente
    $parcial1Editar = $_POST['parcial1Editar'];
    $recuperatorio1Editar = $_POST['recuperatorio1Editar'];
    $parcial2Editar = $_POST['parcial2Editar'];
    $recuperatorio2Editar = $_POST['recuperatorio2Editar'];
    $finalnotaEditar = $_POST['finalnotaEditar'];
    $idCursada = $_POST['idCursada'];

    ActualizarNuevaNota($alumnoNotaEditar, $LegajoNotaEditar, $materiaEditar, $anioMateriaEditar, $estadoMateriaEditar, $parcial1Editar, $recuperatorio1Editar, $parcial2Editar, $recuperatorio2Editar, $finalnotaEditar, $idCursada);
    header("Location: /instituto/Adman/Pantallas/Notas.php");

    exit();
}

?>