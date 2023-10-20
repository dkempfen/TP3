<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
</head>

<?php
require_once('load.php');
function showConfirmationMessage($message) {
  echo "<script>
      Swal.fire({
          icon: '" . $message['type'] . "',
          title: '" . $message['text'] . "',
          showConfirmButton: false,
          timer: 1500
      });
  </script>";
}

function count_by_id($table)
{
  global $pdo;
  $sql = "SELECT COUNT(*) AS total FROM " . $table;
  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($row) {
    return $row['total'];
  }

  return 0; 
}
/*--------------------------------------------------------------*/
function count_id($table)
{
  global $pdo;
  $sql = "SELECT COUNT(*) AS total FROM " . $table;
  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($row) {
    return $row['total'];
  }

  return 0; 
}

/*-----------Define las constantes de los roles-----------------------------*/

// Define las constantes de los roles seleccionados
$showAdmins = true; // Mostrar tarjeta de Administrativos
$showAlumnos = true; // Mostrar tarjeta de Alumnos
$showProfesores = true; // Mostrar tarjeta de Profesores

define('ROL_ADMINISTRATIVO', 3);
define('ROL_ALUMNO', 1);
define('ROL_PROFESOR', 2);

// Función para contar usuarios por rol
function countUsersByRole($rol_id) {
    global $pdo;
    $sql = "SELECT COUNT(*) AS total FROM Usuario WHERE fk_Rol = :rol_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':rol_id', $rol_id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        return $row['total'];
    }

    return 0;
}

// Obtiene los totales de usuarios por rol
$totalAdmins = countUsersByRole(ROL_ADMINISTRATIVO);
$totalAlumnos = countUsersByRole(ROL_ALUMNO);
$totalProfesores = countUsersByRole(ROL_PROFESOR);
$totalUsuarios = countUsersByRole(ROL_ADMINISTRATIVO) + countUsersByRole(ROL_ALUMNO) + countUsersByRole(ROL_PROFESOR);

/*--------------------------------------------------------------*/
function cambiarFotoPerfil($table)
{
  global $pdo;

  $sql = "SELECT nueva_foto FROM " . $table;
  $fotocambio = $pdo->prepare($sql);
  $fotocambio->execute();

  $rows = $fotocambio->fetch(PDO::FETCH_ASSOC);
  if ($rows) {
    return $rows['nueva_foto'];
  }

  return ""; 
}


function obtenerFotoPerfilActual()
{
 
  return $_SESSION['foto_perfil'];
}

////////////////////////////////////////////////////////////
function obtenerEstadoTodosUsuarios()
{
  global $pdo;
  $sql = "SELECT Id_Usuario, fk_Estado_Usuario FROM Usuario";
  $stmt = $pdo->query($sql);
  $usersState = array();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $usersState[$row['Id_Usuario']] = $row['fk_Estado_Usuario'];
  }
  echo json_encode($usersState);
}

 
function insertarNuevoUsuario()
{    var_dump($_POST); // Agrega esta línea para depurar
    global $pdo;
    session_start();
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $fechanacimiento = $_POST["fechanacimiento"];
    $telefono = $_POST["telefono"];
    $mailPersona = $_POST["mail"]; // Cambiamos el nombre del campo
    $domicilio = $_POST["domicilio"];
    $usuario = $_POST["usuario"];
    $clave = $_POST["clave"];
    $listRol = $_POST["listRol"];
    $listEstado = isset($_POST["listEstado"]) ? intval($_POST["listEstado"]) : 0;
    $plan = $_POST["plan"];
    $legajo = $_POST["legajo"];
    $matriz = $_POST["matriz"];
    
    if (empty($nombre) || empty($apellido) || empty($fechanacimiento) || empty($telefono) ||  empty($mailPersona) ||  empty($domicilio) ||  
         empty($usuario) || empty($mailPersona) || empty($clave) || empty($listRol) || empty($listEstado)
       || empty($plan) || empty($legajo) || empty($matriz)) {
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'Debe completar todos los datos. Por favor, llene todos los campos requeridos.'
        ];
        return;
    }

    // Insertar en la tabla Persona
    global $pdo;
    $sqlPersona = "INSERT INTO Persona (DNI, Nombre, Apellido, Fechanacimiento, Telefono, Email, Domicilio) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmtPersona = $pdo->prepare($sqlPersona);
    $stmtPersona->execute([$usuario, $nombre, $apellido, $fechanacimiento, $telefono, $mailPersona, $domicilio]);

    // Insertar en la tabla Usuario
    $rol = ($listRol == 1) ? "Administrador" : (($listRol == 2) ? "Profesor" : "Alumno");
    $sqlRol = "SELECT id_Rol FROM Rol WHERE descripcion = ?";
    $stmtRol = $pdo->prepare($sqlRol);
    $stmtRol->execute([$rol]);
    $resultRol = $stmtRol->fetch(PDO::FETCH_ASSOC);

    if ($resultRol) {
        $rol_id = $resultRol['id_Rol'];

        $sqlUsuario = "INSERT INTO Usuario (User, Password, Libromatriz, fk_Plan, fk_Estado_Usuario, fk_Rol, fk_DNI) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtUsuario = $pdo->prepare($sqlUsuario);
        $stmtUsuario->execute([$usuario, $clave, $matriz, $plan, $listEstado, $rol_id, $usuario]);

        if ($stmtUsuario->rowCount() > 0) {
            $_SESSION['message'] = [
                'type' => 'success',
                'text' => 'Usuario insertado exitosamente'
            ];
        } else {
            $_SESSION['message'] = [
                'type' => 'error',
                'text' => 'Ha ocurrido un error al insertar el usuario en la tabla Usuario.'
            ];
        }
    } else {
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'El rol seleccionado no existe.'
        ];
    }
}

if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['fechanacimiento']) && isset($_POST['telefono']) && isset($_POST['mail']) &&
isset($_POST['domicilio']) && isset($_POST['usuario']) && isset($_POST['clave']) && isset($_POST['listRol']) && isset($_POST['listEstado']) && isset($_POST['plan']) &&
isset($_POST['legajo']) && isset($_POST['matriz'])) {
    insertarNuevoUsuario();

    header("Location: /instituto/Adman/Pantallas/lista_personas.php");
    exit();
}
  /////////////////////Actulizar Estado//////////////////////////////

  function actualizarEstadoUsuario()
{
    session_start();
    if (isset($_POST['Id_Usuario']) && isset($_POST['fk_Estado_Usuario'])) {
        $usuario_id = $_POST['Id_Usuario'];
        $estado = isset($_POST["fk_Estado_Usuario"]) ? intval($_POST["fk_Estado_Usuario"]) : 0;

        $estados = ($estado == 1) ? "Habilitado" : "Inhabilitado" ;

        global $pdo;
        $sql = "SELECT Id_Estado FROM Estado WHERE Descripcion_Estado = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$estados]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
          $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'El Estado seleccionado no existe.'
          ];
          return;
        }
  
        $estados = $result['Id_Estado'];
  
        // La consulta SQL se actualiza para usar los marcadores de posición
        global $pdo;
        $sql = "UPDATE Usuario SET fk_Estado_Usuario = :fk_Estado_Usuario WHERE Id_Usuario = :Id_Usuario";
        $stmt = $pdo->prepare($sql);

        // Vincula los valores a los marcadores de posición
        $stmt->bindParam(':fk_Estado_Usuario', $estado, PDO::PARAM_INT);
        $stmt->bindParam(':Id_Usuario', $usuario_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['message'] = [
                'type' => 'success',
                'text' => 'Estado de usuario actualizado exitosamente'
            ];
        } else {
            $_SESSION['
            message'] = [
                'type' => 'error',
                'text' => 'Ha ocurrido un error al actualizar el estado del usuario.'
            ];
        }
    } else {
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'Faltan parámetros requeridos para actualizar el estado del usuario.'
        ];
    }
}

if (isset($_POST['Id_Usuario']) && isset($_POST['fk_Estado_Usuario']) ) {
  actualizarEstadoUsuario();

  header("Location: /instituto/Adman/lista_usuarios.php");
  exit();
}
  /*function actualizarEstadoUsuario($pdo)
  {
      if (isset($_POST['Id_Usuario']) && isset($_POST['fk_Estado_Usuario'])) {
          $usuario_id = $_POST['Id_Usuario'];
          $estado = $_POST['fk_Estado_Usuario'];
  
          try {
              $updateQuery = "UPDATE Usuario SET fk_Estado_Usuario = :fk_Estado_Usuario WHERE Id_Usuario = :Id_Usuario";
              $stmt = $pdo->prepare($updateQuery);
              $stmt->bindParam(':fk_Estado_Usuario', $estado, PDO::PARAM_INT);
              $stmt->bindParam(':Id_Usuario', $usuario_id, PDO::PARAM_INT);
  
              if ($stmt->execute()) {
                  // La consulta se ejecutó correctamente, enviamos el JSON con éxito.
                  echo json_encode(['success' => true, 'message' => 'Estado actualizado']);
              } else {
                  // Ocurrió un error al ejecutar la consulta, enviamos el JSON con el mensaje de error.
                  echo json_encode(['success' => false, 'error' => 'Error updating user state']);
              }
          } catch (PDOException $e) {
              // Manejar errores de PDO
              echo json_encode(['success' => false, 'error' => 'PDO error: ' . $e->getMessage()]);
          }
      } else {
          echo json_encode(['success' => false, 'error' => 'Missing parameters']);
      }
  }
  
  // Llama a la función para procesar la solicitud
  actualizarEstadoUsuario($pdo);*/



//////////////////////////////Actulizar User///////////////////////
function DatosUsuarios()
{
    global $pdo;

    $sql = "SELECT u.id_usuario, p.nombre,p.Apellido ,p.email, p.DNI,p.Fechanacimiento,p.Telefono,p.Email,p.Domicilio,u.User,
    u.fk_Plan,u.Libromatriz,u.Legajo,u.Legajo, u.fk_Rol, u.fk_DNI,u.Password,u.fk_Estado_Usuario, r.descripcion,e.Descripcion_Estado
    FROM Usuario u 
    INNER JOIN Persona p ON p.DNI = u.fk_DNI
    INNER JOIN Rol r ON r.id_Rol = u.fk_Rol
    INNER JOIN Estado e ON e.Id_Estado = u.fk_Estado_Usuario";

    $datosUsuarios = $pdo->prepare($sql);
    $datosUsuarios->execute();

    $rows = $datosUsuarios->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
function tableUsuarios()
{
    global $pdo;

    $sql = "SELECT *
    FROM Usuario";

    $datostableUsuarios = $pdo->prepare($sql);
    $datostableUsuarios->execute();

    $rowTablapersonas = $datostableUsuarios->fetchAll(PDO::FETCH_ASSOC);
    return $rowTablapersonas;
}
function DatosPersonas()
{
    global $pdo;

    $sql = "SELECT *
    FROM Persona";

    $datosPersonas = $pdo->prepare($sql);
    $datosPersonas->execute();

    $rowPersona = $datosPersonas->fetchAll(PDO::FETCH_ASSOC);
    return $rowPersona;
}


function DatosPersonasUsuarios()
{
    global $pdo;

    $sql = "SELECT *
    FROM Persona p
    LEFT JOIN Usuario u ON p.DNI = u.fk_DNI
    INNER JOIN Rol r ON r.id_Rol = u.fk_Rol
    WHERE u.fk_DNI IS NOT NULL";

    $datosPersonasUsuario = $pdo->prepare($sql);
    $datosPersonasUsuario->execute();

    $rowPersonaUsuario = $datosPersonasUsuario->fetchAll(PDO::FETCH_ASSOC);
    return $rowPersonaUsuario;
}

function DatosPlan()
{
    global $pdo;

    $sql = "select Descripcion_Estado,E.Id_Estado, P.Estado_Id_Estado,P.cod_Plan,P.Carrera from Estado E
    INNER JOIN Plan P ON P.Estado_Id_Estado=E.Id_Estado";

    $datosPlam = $pdo->prepare($sql);
    $datosPlam->execute();

    $rowPlan = $datosPlam->fetchAll(PDO::FETCH_ASSOC);
    return $rowPlan;
}
function DatosMateriaProfesor()
{
    global $pdo;

    $sql = "SELECT *
    FROM Materia_Profesor mp
    LEFT JOIN Materia m ON m.id_Materia = mp.id_Materia
    LEFT JOIN Usuario u ON mp.id_Profesor = u.Id_Usuario
    LEFT JOIN Persona pr ON u.fk_DNI = pr.DNI
    LEFT JOIN Estado es ON m.fk_Estado = es.Id_Estado";

    $datosMateriaProf = $pdo->prepare($sql);
    $datosMateriaProf->execute();

    $rowMateriaProf= $datosMateriaProf->fetchAll(PDO::FETCH_ASSOC);
    return $rowMateriaProf;
}


function DatosMateria()
{
    global $pdo;

    $sql = "select  *
    FROM Materia m
    
    LEFT JOIN Estado es ON m.fk_Estado = es.Id_Estado";

    $datosMateria = $pdo->prepare($sql);
    $datosMateria->execute();

    $rowMateria = $datosMateria->fetchAll(PDO::FETCH_ASSOC);
    return $rowMateria;
}

function ()
{
    global $pdo;

    $sql = "SELECT *
    FROM Materia m
    LEFT JOIN Materia_Profesor mp ON m.id_Materia = mp.id_Materia
    LEFT JOIN Usuario u ON mp.id_Profesor = u.Id_Usuario
    LEFT JOIN Persona pr ON u.fk_DNI = pr.DNI
    LEFT JOIN Estado es ON m.fk_Estado = es.Id_Estado";

    $datosMateria = $pdo->prepare($sql);
    $datosMateria->execute();

    $rowMateria = $datosMateria->fetchAll(PDO::FETCH_ASSOC);
    return $rowMateria;
}
/*function ActulizarUser()
    {      

  if(isset($_POST['btnmodificar']))
{session_start();
  global $pdo;
  $idusuarioeditar = $_POST['idusuarioeditar'];
  $nombreeditar = $_POST['nombreeditar'];
  $maileditar = $_POST['maileditar'];
  $claveeditar = $_POST['claveeditar'];
  $listRoleditar = $_POST['listRoleditar'];
  $listEstadoeditar = $_POST['listEstadoeditar'];


  
  $sql = "UPDATE usuario SET nombre = '$nombreeditar', mail = '$maileditar', clave = '$claveeditar', 
  rol = '$listRoleditar', estado = '$listEstadoeditar' WHERE usuario_id = '$idusuarioeditar'";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(":nombreeditar", $nombreeditar);
      $stmt->bindParam(":maileditar", $maileditar);
      $stmt->bindParam(":claveeditar", $claveeditar);
      $stmt->bindParam(":listRoleditar", $listRoleditar);
      $stmt->bindParam(":listEstadoeditar", $listEstadoeditar);
      $stmt->bindParam(":idusuarioeditar", $idusuarioeditar);
      $stmt->execute();
      
      if ($stmt->rowCount() === 0) {        
        $_SESSION['message'] = [
            'type' => 'info',
            'text' => 'No se ha actualizado ningún dato.'
        ];
    } elseif ($stmt->rowCount() > 0) {
        // Al menos un dato se actualizó correctamente
        $_SESSION['message'] = [
            'type' => 'success',
            'text' => 'Usuario actualizado exitosamente.'
        ];
    } else {
        // Ocurrió un error al actualizar el usuario
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'Ha ocurrido un error al actualizar el usuario.'
        ];
    }

    
      
}
}

if (isset($_POST['nombreeditar']) && isset($_POST['idusuarioeditar']) && isset($_POST['maileditar']) && isset($_POST['claveeditar']) && isset($_POST['listRoleditar']) && isset($_POST['listEstadoeditar'])) {
  ActulizarUser();

  header("Location: /instituto/Adman/lista_usuarios.php");
  exit();
}*/
/*function ActualizarUser()
{
    if (isset($_POST['btnmodificar'])) {
        session_start();
        global $pdo;
        $idusuarioeditar = $_POST['idusuarioeditar'];
        $nombreeditar = $_POST['nombreeditar'];
        $maileditar = $_POST['maileditar'];
        $claveeditar = $_POST['claveeditar'];
        $listRoleditar = $_POST['listRoleditar'];
        $listEstadoeditar = $_POST['listEstadoeditar'];
        $dni_a_editar = $_POST['dni_a_editar'];

        try {
            $pdo->beginTransaction();
            
            // Actualizar los datos en la tabla 'usuario'
            $queryUsuario = "UPDATE usuario SET Password=:claveeditar, fk_Rol=:listRoleditar, fk_Estado_Usuario=:listEstadoeditar WHERE Id_Usuario=:idusuarioeditar";
            $stmtUsuario = $pdo->prepare($queryUsuario);
            $stmtUsuario->bindParam(':claveeditar', $claveeditar);
            $stmtUsuario->bindParam(':listRoleditar', $listRoleditar);
            $stmtUsuario->bindParam(':listEstadoeditar', $listEstadoeditar);
            $stmtUsuario->bindParam(':idusuarioeditar', $idusuarioeditar);
            $stmtUsuario->execute();

            // Actualizar los datos en la tabla 'persona'
            $queryPersona = "UPDATE persona SET Nombre=:nombreeditar, Email=:maileditar WHERE DNI=:dni_a_editar";
            $stmtPersona = $pdo->prepare($queryPersona);
            $stmtPersona->bindParam(':nombreeditar', $nombreeditar);
            $stmtPersona->bindParam(':maileditar', $maileditar);
            $stmtPersona->bindParam(':dni_a_editar', $dni_a_editar);
            $stmtPersona->execute();


            $pdo->commit();

            if (($stmtPersona->rowCount() > 0) || ($stmtUsuario->rowCount() > 0)) {
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
        } catch (PDOException $e) {
            $pdo->rollBack();
            $_SESSION['message'] = [
                'type' => 'error',
                'text' => 'Error al actualizar el usuario: ' . $e->getMessage()
            ];
        }
    }
}

if (isset($_POST['nombreeditar']) && isset($_POST['idusuarioeditar']) && isset($_POST['dni_a_editar']) && isset($_POST['maileditar']) && isset($_POST['claveeditar']) && isset($_POST['listRoleditar']) && isset($_POST['listEstadoeditar'])) {
    ActualizarUser();

    header("Location: /instituto/Adman/lista_usuarios.php");
    exit();
}
*/


/*function ActualizarUsers()
{  var_dump($_POST); 
    if (isset($_POST['btnmodificar'])) {
        session_start();
        global $pdo;
        $idusuarioeditar = $_POST['idusuarioeditar'];
        $legajoeditar = $_POST['legajoeditar'];
        $planeditar = $_POST['planeditar'];
        $claveeditar = $_POST['claveeditar'];
        $listRoleditar = $_POST['listRoleditar'];
        $listEstadoeditar = $_POST['listEstadoeditar'];
        $dnieditar = $_POST['dnieditar'];

        try {
            $pdo->beginTransaction();
            
            // Actualizar los datos en la tabla 'usuario'
            $queryUsuario = "UPDATE usuario SET Password=:claveeditar, fk_Rol=:listRoleditar, fk_Estado_Usuario=:listEstadoeditar,
            Legajo=:legajoeditar, fk_Plan=:planeditar, fk_DNI=:dnieditar WHERE Id_Usuario=:idusuarioeditar";
            $stmtUsuario = $pdo->prepare($queryUsuario);
            $stmtUsuario->bindParam(':claveeditar', $claveeditar);
            $stmtUsuario->bindParam(':listRoleditar', $listRoleditar);
            $stmtUsuario->bindParam(':listEstadoeditar', $listEstadoeditar);
            $stmtUsuario->bindParam(':idusuarioeditar', $idusuarioeditar);
            $stmtUsuario->bindParam(':legajoeditar', $legajoeditar);
            $stmtUsuario->bindParam(':planeditar', $planeditar);
            $stmtUsuario->bindParam(':dnieditar', $dnieditar);
            $stmtUsuario->execute();

            // Actualizar los datos en la tabla 'persona'
           /* $queryPersona = "UPDATE persona SET Nombre=:nombreeditar, Email=:maileditar WHERE DNI=:dni_a_editar";
            $stmtPersona = $pdo->prepare($queryPersona);
            $stmtPersona->bindParam(':nombreeditar', $nombreeditar);
            $stmtPersona->bindParam(':maileditar', $maileditar);
            $stmtPersona->bindParam(':dni_a_editar', $dni_a_editar);
            $stmtPersona->execute();*/


            /*  $pdo->commit();

            if (($stmtUsuario->rowCount() > 0)) {
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
        } catch (PDOException $e) {
            $pdo->rollBack();
            $_SESSION['message'] = [
                'type' => 'error',
                'text' => 'Error al actualizar el usuario: ' . $e->getMessage()
            ];
        }
    }
}*/

 /* if (isset($_POST['idusuarioeditar']) && isset($_POST['legajoeditar']) && isset($_POST['dnieditar']) &&
    isset($_POST['maileditar']) && isset($_POST['claveeditar']) && isset($_POST['listRoleditar']) && isset($_POST['listEstadoeditar'])) {
        ActualizarUsers();

    header("Location: /instituto/Adman/lista_usuarios.php");
    exit();
}*/
/*-------------canbiar ckave-----------------------*/
 

/*function cambioClave()
    {   
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  
  session_start();
  global $pdo;
  $oldPassword = $_POST["old_password"];
  $newPassword = $_POST["new_password"];
  $confirmNewPassword = $_POST["confirm_new_password"];
  $usuario_id = 1; // Cambia esto según tu lógica

  $sql = "SELECT Password FROM Usuario WHERE Id_Usuario = :usuario_id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':usuario_id', $usuario_id);
  $stmt->execute();
  $row = $stmt->fetch();
  $clave_actual_almacenada_db = $row['Password'];
  if (empty($oldPassword) || empty($newPassword) || empty($confirmNewPassword)) {
    $_SESSION['password_message'] = [
        'type' => 'error',
        'text' => 'Debe completar todos los datos. Por favor, llene todos los campos requeridos.'
    ];
  } elseif ($oldPassword !== $clave_actual_almacenada_db) {
      $_SESSION['password_message'] = ['type' => 'error', 'text' => 'La contraseña actual ingresada no coincide con la contraseña almacenada.'];
  } elseif ($newPassword !== $confirmNewPassword) {
      $_SESSION['password_message'] = ['type' => 'error', 'text' => 'Las contraseñas no coinciden. No se pudo cambiar la contraseña.'];
  } else {
        try {
            $updateSql = "UPDATE Usuario SET Password = :new_password WHERE Id_Usuario = :usuario_id";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->bindParam(':new_password', $newPassword);
            $updateStmt->bindParam(':usuario_id', $usuario_id);
            $updateStmt->execute();
            $_SESSION['password_message'] = ['type' => 'success', 'text' => '¡Contraseña cambiada exitosamente!'];
        } catch (PDOException $e) {
            $_SESSION['password_message'] = ['type' => 'error', 'text' => 'Error al actualizar la contraseña: ' . $e->getMessage()];
        }
    }    


  header("Location: /instituto/Adman/Pantallas/profile.php");
  exit();
}
if (isset($_SESSION['password_message'])) {
  $messages = $_SESSION['password_message'];
  unset($_SESSION['password_message']);
  showConfirmationMessage($messages);
}

}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["token"])) {

  cambioClave();
}}*/



?>