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




function actualizarUser($dni, $nombre, $apellido, $fechanacimiento, $telefono, $email, $domicilio, $inscripto) {
    session_start();
    global $pdo;
    

    $sql = "UPDATE Persona SET Nombre = ?, Apellido = ?, Fechanacimiento = ?, Telefono = ?, Email = ?, Domicilio = ?, Inscripto=? WHERE DNI = ?";
    $stmt = $pdo->prepare($sql);

    // Verifica si los valores son nulos antes de ejecutar la consulta
    $stmt->execute([$nombre, $apellido, $fechanacimiento, $telefono, $email, $domicilio,$inscripto,$dni]);

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
    $dni = $_POST['nuevoDNI'];
    $nombre = $_POST['nombreeditar'];
    $apellido = $_POST['apellidoeditar'];
    $fechanacimiento = $_POST['fechanacimientoeditar'];
    $telefono = $_POST['telefonoeditar'];
    $email = $_POST['emailoeditar'];
    $domicilio = $_POST['domicilioeditar'];
    $inscripto= $_POST['inscriptoeditar'];


    // Llamar a la función EditarPersona solo si los campos requeridos no están vacíos
    actualizarUser($dni, $nombre, $apellido, $fechanacimiento, $telefono, $email, $domicilio,$inscripto);

    header("Location: /instituto/Adman/Pantallas/lista_personas.php");
    exit();
}
/*function cambioDNI() {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        session_start();
        global $pdo;
        $oldDNI = $_POST["old_dni"];
        $newDNI = $_POST["nuevoDNI"]; // Cambiamos esto para usar el campo 'nuevoDNI' del formulario

        $sql = "SELECT DNI FROM Persona WHERE DNI = :old_dni";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':old_dni', $oldDNI);
        $stmt->execute();
        $row = $stmt->fetch();

        if (empty($oldDNI) || empty($newDNI)) {
            $_SESSION['dni_message'] = [
                'type' => 'error',
                'text' => 'Debe completar todos los datos. Por favor, llene todos los campos requeridos.'
            ];
        } elseif (!$row) {
            $_SESSION['dni_message'] = [
                'type' => 'error',
                'text' => 'El DNI actual ingresado no coincide con ningún registro en la base de datos.'
            ];
        } else {
            try {
                $updateSql = "UPDATE Persona SET DNI = :new_dni WHERE DNI = :old_dni";
                $updateStmt = $pdo->prepare($updateSql);
                $updateStmt->bindParam(':new_dni', $newDNI);
                $updateStmt->bindParam(':old_dni', $oldDNI);
                $updateStmt->execute();
                $_SESSION['dni_message'] = [
                    'type' => 'success',
                    'text' => '¡DNI cambiado exitosamente!'
                ];
            } catch (PDOException $e) {
                $_SESSION['dni_message'] = [
                    'type' => 'error',
                    'text' => 'Error al actualizar el DNI: ' . $e->getMessage()
                ];
            }
        }

        header("Location: /instituto/Adman/Pantallas/lista_personas.php");
        exit();
    }
}*/

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

        
        $sql = "INSERT INTO Persona (DNI, Nombre, Apellido, Fechanacimiento, Telefono, Email, Domicilio, Inscripto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$dni, $nombre, $apellido, $fechanacimiento, $telefono, $mail, $domicilio, $inscripto]);
        

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
    $inscripto = isset($_POST['inscripto']) ? 1 : 0; // Verifica si se envió 'inscripto' y asigna 1 si se marcó, 0 si no se marcó

    AltaPersona($dni, $nombre, $apellido, $fechanacimiento, $telefono, $mail, $domicilio, $inscripto);

    header("Location: /instituto/Adman/Pantallas/lista_personas.php");
    exit();
}


function insertarUsuario($dni, $idUsuario, $legajo, $user, $password, $libroMatriz, $plan, $rol) {
    global $pdo; // Supongo que ya tienes una conexión PDO establecida

    // Verificar si el DNI ya existe en la tabla Persona
    $sql = "SELECT DNI FROM Persona WHERE DNI = :dni";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':dni', $dni, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        // El DNI no existe en la tabla Persona, no se puede insertar el usuario
        return false;
    }

    // Insertar el usuario en la tabla Usuario
    $sql = "INSERT INTO Usuario (id_usuario, fk_DNI, Legajo, User, Password, Libromatriz, fk_Plan, fk_Rol)
            VALUES (:idUsuario, :dni, :legajo, :user, :password, :libroMatriz, :plan, :rol)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmt->bindParam(':dni', $dni, PDO::PARAM_INT);
    $stmt->bindParam(':legajo', $legajo, PDO::PARAM_STR);
    $stmt->bindParam(':user', $user, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->bindParam(':libromatriz', $libroMatriz, PDO::PARAM_STR);
    $stmt->bindParam(':plan', $plan, PDO::PARAM_STR);
    $stmt->bindParam(':rol', $rol, PDO::PARAM_INT);

    return $stmt->execute();

    
}



?>

