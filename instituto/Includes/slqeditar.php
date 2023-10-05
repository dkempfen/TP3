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
            window.location.href = '/instituto/Adman/Pantallas/lista_personas.php';
        });
    </script>";
}       

function actualizarUser($dni, $nombre, $apellido, $fechanacimiento, $telefono, $email, $domicilio) {
    session_start();
    global $pdo;

 
    // Actualizar los campos de la tabla Persona
    $sql = "UPDATE Persona SET Nombre = ?, Apellido = ?, Fechanacimiento = ?, Telefono = ?, Email = ?, Domicilio = ? WHERE DNI = ?";
    $stmt = $pdo->prepare($sql);

    // Verifica si los valores son nulos antes de ejecutar la consulta
    $stmt->execute([$nombre, $apellido, $fechanacimiento, $telefono, $email, $domicilio, $dni]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = [
            'type' => 'success',
            'text' => 'Datos de persona actualizados exitosamente'
        ];
    } else {
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'Ha ocurrido un error al actualizar los datos de persona.'
        ];
    }

    header("Location: /instituto/Adman/Pantallas/lista_personas.php");
    exit();
}

// Verificar si se ha enviado una solicitud de edición (update)
if (isset($_POST['btnmodificar'])) {
    $dni = $_POST['dnioeditar'];
    $nombre = $_POST['nombreeditar'];
    $apellido = $_POST['apellidoeditar'];
    $fechanacimiento = $_POST['fechanacimientoeditar'];
    $telefono = $_POST['telefonoeditar'];
    $email = $_POST['emailoeditar'];
    $domicilio = $_POST['domicilioeditar'];

    // Llamar a la función EditarPersona solo si los campos requeridos no están vacíos
    actualizarUser($dni, $nombre, $apellido, $fechanacimiento, $telefono, $email, $domicilio);

    header("Location: /instituto/Adman/Pantallas/lista_personas.php");
    exit();
}



function AltaPersona($dni, $nombre, $apellido, $fechanacimiento, $telefono, $mail, $domicilio, $inscripto) {
    session_start();
    global $pdo;

    // Verificar si el DNI ya existe en la base de datos
    $sqlCheckDNI = "SELECT COUNT(*) FROM Persona WHERE DNI = ?";
    $stmtCheckDNI = $pdo->prepare($sqlCheckDNI);
    $stmtCheckDNI->execute([$dni]);
    $dniExists = $stmtCheckDNI->fetchColumn();

    if ($dniExists > 0) {
        // El DNI ya existe, mostrar un mensaje de error
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'El DNI ya está registrado en la base de datos.'
        ];
    } else {
        // El DNI no existe, proceder con la inserción

        // Asignar el valor adecuado a la columna "Inscripto" según la selección del usuario
        $inscritoValue = ($inscripto === '1') ? 1 : 0;

        $sql = "INSERT INTO Persona (DNI, Nombre, Apellido, Fechanacimiento, Telefono, Email, Domicilio, Inscripto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$dni, $nombre, $apellido, $fechanacimiento, $telefono, $mail, $domicilio, $inscritoValue]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['message'] = [
                'type' => 'success',
                'text' => 'Datos de persona insertados exitosamente'
            ];
        } else {
            $_SESSION['message'] = [
                'type' => 'error',
                'text' => 'Ha ocurrido un error al insertar los datos de persona.'
            ];
        }
    }

    header("Location: /instituto/Adman/Pantallas/lista_personas.php");
    exit();
}


// Verificar si se ha enviado una solicitud de inserción
if (isset($_POST['btnaltaPersona'])) {
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fechanacimiento = $_POST['fechanacimiento'];
    $telefono = $_POST['telefono'];
    $mail = $_POST['mail'];
    $domicilio = $_POST['domicilio'];
    $inscripto = $_POST['inscripto']; // Agregar el campo "inscripto" al formulario y obtener su valor

    AltaPersona($dni, $nombre, $apellido, $fechanacimiento, $telefono, $mail, $domicilio, $inscripto);

    header("Location: /instituto/Adman/Pantallas/lista_personas.php");
    exit();
}

?>