<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
</head>

<?php

//////////Mensajes /////////////////
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

function showConfirmationMessageDocuementacion($messageDocuementacion) {
    echo "<script>
        Swal.fire({
            icon: '" . $messageDocuementacion['type'] . "',
            title: '" . $messageDocuementacion['text'] . "',
            showConfirmButton: false,
            timer: 1500
        });
    </script>";
  }

  function showConfirmationMessageFechaFinCursada($messageFinCursada) {
    echo "<script>
        Swal.fire({
            icon: '" . $messageFinCursada['type'] . "',
            title: '" . $messageFinCursada['text'] . "',
            showConfirmButton: false,
            timer: 1500
        });
    </script>";
  }
  
  
///////////Contadores En Tablas//////////////////
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
/////////////////////////////



function nuevo_archivo($table)
{
  global $pdo;

  $sql = "SELECT Descripcion FROM " . $table;
  $archivoPlan = $pdo->prepare($sql);
  $archivoPlan->execute();

  $rowp = $archivoPlan->fetch(PDO::FETCH_ASSOC);
  if ($rowp) {
    return $rowp['nuevo_archivo'];
  }

  return ""; 
}


/*--------------------------------------------------------------*/
function cambiarFotoPerfil()
{
    global $pdo;

    $sql = "SELECT cp.nueva_foto 
            FROM cambio_foto_perfil cp
            INNER JOIN Usuario u ON cp.usuario_id = u.Id_Usuario";
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
  /////////////////////Actulizar Estado Usuario//////////////////////////////

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



function actualizarEstadoMaterias()
{
    session_start();
    if (isset($_POST['id_Materia']) && isset($_POST['fk_Estado'])) {
        $usuario_id = $_POST['id_Materia'];
        $estado = isset($_POST["fk_Estado"]) ? intval($_POST["fk_Estado"]) : 0;

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
        $sql = "UPDATE Materia SET fk_Estado = :fk_Estado WHERE id_Materia = :id_Materia";
        $stmt = $pdo->prepare($sql);

        // Vincula los valores a los marcadores de posición
        $stmt->bindParam(':fk_Estado', $estado, PDO::PARAM_INT);
        $stmt->bindParam(':id_Materia', $usuario_id, PDO::PARAM_INT);

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

if (isset($_POST['id_Materia']) && isset($_POST['fk_Estado']) ) {
    actualizarEstadoMaterias();

  header("Location: /instituto/Adman/lista_materia.php");
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


////////////CAMBIO CLAVE///////////////


function cambioClave()
{
    session_start();

    global $pdo;

    // Obtener el ID de usuario de la sesión
    if (!isset($_SESSION['id_usuario'])) {
        exit('El usuario no ha iniciado sesión');
    }

    $usuario_id = $_SESSION['id_usuario'];
    $oldPassword = $_POST["old_password"];
    $newPassword = $_POST["new_password"];
    $confirmNewPassword = $_POST["confirm_new_password"];

    $sql = "SELECT Password FROM Usuario WHERE Id_Usuario = :usuario_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->execute();
    $row = $stmt->fetch();
    $clave_actual_almacenada_db = trim($row['Password']);

    //$clave_actual_almacenada_db = $oldPassword;

    if (empty($oldPassword) || empty($newPassword) || empty($confirmNewPassword)) {
        $_SESSION['password_message'] = [
            'type' => 'error',
            'text' => 'Debe completar todos los datos. Por favor, llene todos los campos requeridos.'
        ];
    } elseif ($oldPassword !== $clave_actual_almacenada_db) {
   

        $_SESSION['password_message'] = ['type' => 'error', 'text' => 'La contraseña actual ingresada no coincide con la contraseña almacenada.'];
    } else {
        // La contraseña actual es correcta, proceder con el cambio de contraseña
        if ($newPassword === $confirmNewPassword) {
            // Hash de la nueva contraseña
            $hashNuevaContrasena = $newPassword;

            // Actualizar la contraseña en la base de datos
            $updateSql = "UPDATE Usuario SET Password = :new_password WHERE Id_Usuario = :usuario_id";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->bindParam(':new_password', $hashNuevaContrasena);
            $updateStmt->bindParam(':usuario_id', $usuario_id);
            $updateStmt->execute();

            if ($updateStmt->rowCount() > 0) {
                // Contraseña actualizada con éxito
                $_SESSION['password_message'] = ['type' => 'success', 'text' => '¡Contraseña cambiada exitosamente!'];
            } else {
                // Error al actualizar la contraseña en la base de datos
                $_SESSION['password_message'] = ['type' => 'error', 'text' => 'Error al actualizar la contraseña.'];
            }
        } else {
            // Las contraseñas nuevas no coinciden
            $_SESSION['password_message'] = ['type' => 'error', 'text' => 'Las contraseñas no coinciden.'];
        }
    }

    // Redirigir a la página de perfil después de procesar el formulario
    header("Location: /instituto/Adman/Pantallas/profile.php");
    exit();
}

// Ejemplo de uso
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["token"])) {
    cambioClave();
}

function mailPersonal()
{
    session_start();

    global $pdo;

    // Obtener el ID de usuario de la sesión
    if (!isset($_SESSION['dni'])) {
        exit('El dni no ha iniciado sesión');
    }

    $DNI = $_SESSION['dni'];
    $emailPerfil = $_POST["emailPerfil"];
   
        // La contraseña actual es correcta, proceder con el cambio de contraseña
       
            // Hash de la nueva contraseña

            // Actualizar la contraseña en la base de datos
            $updateSql = "UPDATE Persona SET Email = :emailPerfil WHERE DNI = :DNI";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->bindParam(':emailPerfil', $emailPerfil);
            $updateStmt->bindParam(':DNI', $DNI);
            $updateStmt->execute();

            if ($updateStmt->rowCount() > 0) {
                // Contraseña actualizada con éxito
                $_SESSION['password_message'] = ['type' => 'success', 'text' => '¡Email cambiado exitosamente!'];
            } else {
                // Error al actualizar la contraseña en la base de datos
                $_SESSION['password_message'] = ['type' => 'error', 'text' => 'Error al actualizar el email.'];
            }
        
    

    // Redirigir a la página de perfil después de procesar el formulario
    header("Location: /instituto/Adman/Pantallas/profile.php");
    exit();
}

// Ejemplo de uso
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["tokenMail"])) {
    mailPersonal();
}


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

    $sql = "select Descripcion_Documentacion, Descripcion_Estado,E.Id_Estado, P.Estado_Id_Estado,P.cod_Plan,P.Carrera from Estado E
    INNER JOIN Plan P ON P.Estado_Id_Estado=E.Id_Estado
    INNER JOIN Documentacion AS d
    ON P.cod_Plan = d.fk_Plan";

    $datosPlam = $pdo->prepare($sql);
    $datosPlam->execute();

    $rowPlan = $datosPlam->fetchAll(PDO::FETCH_ASSOC);
    return $rowPlan;
}

function DatosPlanMateria()
{
    global $pdo;

    $sql = "SELECT * FROM Persona p 
    INNER JOIN Usuario u ON p.DNI = u.fk_DNI
    INNER JOIN Materia_Profesor mp ON u.Id_Usuario = mp.id_Profesor
    INNER JOIN Detalle_Plan dp ON mp.id_Materia = dp.fk_Materia 
    INNER JOIN Materia m ON m.id_Materia = mp.id_Materia";

    $datosPlanDetalle = $pdo->prepare($sql);
    $datosPlanDetalle->execute();

    $rowPlanDetalle = $datosPlanDetalle->fetchAll(PDO::FETCH_ASSOC);
    return $rowPlanDetalle;
}

function Plan()
{
    global $pdo;

    $sql = "select * from Plan";

    $datoslanCarrera = $pdo->prepare($sql);
    $datoslanCarrera->execute();

    $rowPlanCarrera = $datoslanCarrera->fetchAll(PDO::FETCH_ASSOC);
    return $rowPlanCarrera;
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

function DatosMateriaEstado()
{
    global $pdo;

    $sql = "SELECT Id_Estado, Descripcion_Estado From Estado";


    $datosMateriaEstado = $pdo->prepare($sql);
    $datosMateriaEstado->execute();

    $rowMateriaEstado= $datosMateriaEstado->fetchAll(PDO::FETCH_ASSOC);
    return $rowMateriaEstado;

    
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

function DatosAlumnoNota()
{
    global $pdo;

    $sql = "select * from Usuario u INNER JOIN Persona p ON u.fk_DNI=p.DNI
    WHERE u.fk_Rol=1";

    $datosAlumnoNota = $pdo->prepare($sql);
    $datosAlumnoNota->execute();

    $rowNota = $datosAlumnoNota->fetchAll(PDO::FETCH_ASSOC);
    return $rowNota;
}
function DatosMateriaPlan() {

    global $pdo;

    $sql = "SELECT *
    FROM Detalle_Plan dp
    LEFT JOIN Plan p ON p.cod_Plan = dp.fk_Plan 
    LEFT JOIN Materia m ON dp.fk_Materia = m.id_Materia
    LEFT JOIN Materia_Profesor mp ON dp.fk_Materia = mp.id_Materia
    WHERE cod_Plan = :codPlan
    ORDER BY m.Anio_Carrera DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':codPlan', $codPlan);
    $stmt->execute();

    $rowNotaPlan = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rowNotaPlan;
}


function DatosMateriaNota()
{
    global $pdo;

    $sql = "SELECT *
    FROM Materia mp
    LEFT JOIN Materia m ON m.id_Materia = mp.id_Materia
    LEFT JOIN Usuario u ON mp.id_Profesor = u.Id_Usuario
    LEFT JOIN Persona pr ON u.fk_DNI = pr.DNI
    LEFT JOIN Estado es ON m.fk_Estado = es.Id_Estado";

    $datosMateriaNota = $pdo->prepare($sql);
    $datosMateriaNota->execute();

    $rowMateriaNota= $datosMateriaNota->fetchAll(PDO::FETCH_ASSOC);
    return $rowMateriaNota;
}


function DatosMateriaDetalle()
{
    global $pdo;

    $sql = "SELECT *
     from DetalleCursada dc INNER JOIN Usuario u ON dc.fk_Usuario=u.Id_Usuario
     INNER JOIN Persona p ON p.DNI=u.fk_DNI 
     INNER JOIN Materia m ON m.id_Materia=dc.fk_Materia  
     INNER JOIN Plan pn  ON pn.cod_Plan=u.fk_Plan";

    $datosMateriaDetalle= $pdo->prepare($sql);
    $datosMateriaDetalle->execute();

    $rowMateriaDetalle= $datosMateriaDetalle->fetchAll(PDO::FETCH_ASSOC);
    return $rowMateriaDetalle;
}


function DatosMateriaDetalleAgregar()
{
    global $pdo;

    $sql = "SELECT *
     from DetalleCursada";

    $datosMateriaDetalleAgregar= $pdo->prepare($sql);
    $datosMateriaDetalleAgregar->execute();

    $rowMateriaDetalleAgregar= $datosMateriaDetalleAgregar->fetchAll(PDO::FETCH_ASSOC);
    return $rowMateriaDetalleAgregar;
}

function obtenerMateriasAnalista (){
     
    global $pdo;
    $fechaActual = date('Y-m-d');

    // Calcula la fecha hace dos meses
    $fechaLimite = date('Y-m-d', strtotime('-2 months', strtotime($fechaActual)));

    $sql = "SELECT * FROM FechasFinales fs
    INNER JOIN Materia mt ON fs.fk_Materia = mt.id_Materia
    INNER JOIN Detalle_Plan dn ON dn.fk_Materia = fs.fk_Materia
    WHERE dn.fk_Plan ='6790/19' AND fs.Fecha >= :fechaLimite AND fs.Fecha <= :fechaActual";

    $datosFinalesAnlista= $pdo->prepare($sql);
    $datosFinalesAnlista->bindParam(':fechaLimite', $fechaLimite);
    $datosFinalesAnlista->bindParam(':fechaActual', $fechaActual);
    $datosFinalesAnlista->execute();

    $rowFinalesAnlista= $datosFinalesAnlista->fetchAll(PDO::FETCH_ASSOC);
    return $rowFinalesAnlista;

}

function obtenerMateriasRedes(){
    global $pdo;

    // Obtén la fecha actual
    $fechaActual = date('Y-m-d');

    // Calcula la fecha hace dos meses
    $fechaLimite = date('Y-m-d', strtotime('-2 months', strtotime($fechaActual)));

    $sqlRedes = "SELECT * FROM FechasFinales fs
        INNER JOIN Materia mt ON fs.fk_Materia = mt.id_Materia
        INNER JOIN Detalle_Plan dn ON dn.fk_Materia = fs.fk_Materia
        WHERE dn.fk_Plan ='5817/03' AND fs.Fecha >= :fechaLimite AND fs.Fecha <= :fechaActual";

    $datosFinalesRedes = $pdo->prepare($sqlRedes);
    $datosFinalesRedes->bindParam(':fechaLimite', $fechaLimite);
    $datosFinalesRedes->bindParam(':fechaActual', $fechaActual);
    $datosFinalesRedes->execute();

    $rowFinalesRedes = $datosFinalesRedes->fetchAll(PDO::FETCH_ASSOC);
    return $rowFinalesRedes;
}
function obtenerFinales (){
     
    global $pdo;

    $sql = "SELECT * FROM FechasFinales ff 
    INNER JOIN Materia m ON ff.fk_Materia = m.id_Materia
    INNER JOIN Detalle_Plan dp ON dp.fk_Materia = ff.fk_Materia";

    $datosFinales= $pdo->prepare($sql);
    $datosFinales->execute();

    $rowFinales= $datosFinales->fetchAll(PDO::FETCH_ASSOC);
    return $rowFinales;

}

function fechaFinales (){
     
    global $pdo;

    $sql = "SELECT * FROM FechasFinales";

    $datosFechaFinales= $pdo->prepare($sql);
    $datosFechaFinales->execute();

    $rowFechaFinales= $datosFechaFinales->fetchAll(PDO::FETCH_ASSOC);
    return $rowFechaFinales;

}


function DetallePlan (){
     
    global $pdo;

    $sql = "SELECT * FROM Detalle_Plan";

    $datosDetallePlan= $pdo->prepare($sql);
    $datosDetallePlan->execute();

    $rowDetallePlan= $datosDetallePlan->fetchAll(PDO::FETCH_ASSOC);
    return $rowDetallePlan;

}

////Funciones de Documentacion/////
function obtenerDocumentos (){
     
    global $pdo;

    $sql = "SELECT * FROM Documentacion d
    LEFT JOIN Materia m ON d.fk_Materia = m.id_Materia";

    $datosDocumentacion= $pdo->prepare($sql);
    $datosDocumentacion->execute();

    $rowDocumentacion= $datosDocumentacion->fetchAll(PDO::FETCH_ASSOC);
    return $rowDocumentacion;

}

function InsertarDocumentos ($ArchivoDocumentacion, $AsuntoArchivoocumentacion) {
    session_start();
    global $pdo;
    

    $sql = "INSERT INTO Documentacion (Descripcion_Documentacion, Estado_Documentacion, Asunto, fecha_documentacion) VALUES (?, 1, ?,NOW())";
    $stmt = $pdo->prepare($sql);

    // Verifica si los valores son nulos antes de ejecutar la consulta
    $stmt->execute([$ArchivoDocumentacion, $AsuntoArchivoocumentacion]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['messageDocuementacion'] = [
            'type' => 'success',
            'text' => 'Documentacion insertados exitosamente'
        ];
    } else {
        $_SESSION['messageDocuementacion'] = [
            'type' => 'error',
            'text' => 'Ha ocurrido un error al insertar el documento.'
        ];
    }

    header("Location: /instituto/Adman/Pantallas/documentacion.php");
    exit();
}

// Verificar si se ha enviado una solicitud de edición (update)
if (isset($_POST['btnaltaDocumentacion'])) {
    $ArchivoDocumentacion = $_POST['ArchivoDocumentacion']; // Asegúrate de obtener el código de plan desde el formulario
    $AsuntoArchivoocumentacion = $_POST['AsuntoArchivoocumentacion'];
 

    // Llamar a la función EditarPersona solo si los campos requeridos no están vacíos
    InsertarDocumentos($ArchivoDocumentacion, $AsuntoArchivoocumentacion);

    header("Location: /instituto/Adman/Pantallas/documentacion.php");
    exit();
}

function actualizarAsuntoDocumentacion($idDocumentacion, $nuevoAsunto) {
    session_start();
    global $pdo;

    // Inicializar la respuesta
    $response = array();

    try {
        $sql = "SELECT Asunto FROM Documentacion WHERE id_Documentacion = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idDocumentacion]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el nuevo asunto es diferente al existente
        if ($resultado['Asunto'] == $nuevoAsunto) {
            // Si no hay cambios, informar al usuario y devolver la respuesta
            $_SESSION['messageDocuementacion'] = [
                'type' => 'info',
                'text' => 'No se actualizaron datos.'
            ];
            $response['success'] = true;
            $response['messageDocuementacion'] = 'No se actualizaron datos.';
            return $response;
        }

        $sql = "UPDATE Documentacion SET Asunto = ? WHERE id_Documentacion = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nuevoAsunto, $idDocumentacion]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['messageDocuementacion'] = [
                'type' => 'success',
                'text' => 'Asunto actualizado exitosamente'
            ];
            // Indicar éxito en la respuesta
            $response['success'] = true;
        } else {
            $_SESSION['messageDocuementacion'] = [
                'type' => 'error',
                'text' => 'Ha ocurrido un error al actualizar el asunto.'
            ];
            // Indicar error en la respuesta
            $response['success'] = false;
            $response['message'] = 'Ha ocurrido un error al actualizar el asunto.';
        }
    } catch (PDOException $e) {
        // En caso de un error en la base de datos
        $_SESSION['messageDocuementacion'] = [
            'type' => 'error',
            'text' => 'Error en la base de datos al actualizar el asunto.'
        ];

        // Indicar error en la respuesta
        $response['success'] = false;
        $response['messageDocuementacion'] = 'Error en la base de datos al actualizar el asunto.';
    }

    return $response;

}

if (isset($_POST['btnActualizarAsunto'])) {
    $idDocumentacion = $_POST['idDocumentacionArchivo'];
    $nuevoAsunto = $_POST['NuevoAsunto'];

    $response = actualizarAsuntoDocumentacion($idDocumentacion, $nuevoAsunto);

    // Devolver la respuesta al cliente
    echo json_encode($response);
    exit();
}



function BorrarDocumentacion($idDocumentacion) {
    session_start();
    global $pdo;

   
    // Inicializar la respuesta
    $response = array();

    // Obtén el mensaje de confirmación del lado del servidor
    $confirmacion = "¿Seguro que quieres borrar este documento?";

    // Agrega el mensaje de confirmación a la respuesta
    $response['confirmacion'] = $confirmacion;

    try {
       
        $sql = "DELETE FROM Documentacion  WHERE id_Documentacion = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idDocumentacion]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['messageDocuementacion'] = [
                'type' => 'success',
                'text' => 'Docuemento borrado exitosamente'
            ];
            // Indicar éxito en la respuesta
            $response['success'] = true;
        } else {
            $_SESSION['messageDocuementacion'] = [
                'type' => 'error',
                'text' => 'Ha ocurrido un error al borrar el documento.'
            ];
            // Indicar error en la respuesta
            $response['success'] = false;
            $response['messageDocuementacion'] = 'Ha ocurrido un error al borrar el documento.';
        }
    } catch (PDOException $e) {
        // En caso de un error en la base de datos
        $_SESSION['messageDocuementacion'] = [
            'type' => 'error',
            'text' => 'Error en la base de datos al borrar el documento.'
        ];

        // Indicar error en la respuesta
        $response['success'] = false;
        $response['messageDocuementacion'] = 'Error en la base de datos al borrar el documento.';
    }

    return $response;

}

if (isset($_POST['btnABorrarDoc'])) {
    $idDocumentacion = $_POST['idDocumentacionArchivo'];

    $response = BorrarDocumentacion($idDocumentacion);

    // Devolver la respuesta al cliente
    echo json_encode($response);
    exit();
}


function borrarDocumentosMasivos($documentosSeleccionados) {
    session_start();

    global $pdo;

    try {
        // Utiliza la lista de identificadores para construir la cláusula IN en la consulta
        $placeholders = str_repeat('?,', count($documentosSeleccionados) - 1) . '?';

        $sql = "DELETE FROM Documentacion WHERE id_Documentacion IN ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($documentosSeleccionados);

        if ($stmt->rowCount() > 0) {
            $_SESSION['messageDocuementacion'] = [
                'type' => 'success',
                'text' => 'Docuemento borrado exitosamente'
            ];
            // Indicar éxito en la respuesta
            $response['success'] = true;
        } else {
            $_SESSION['messageDocuementacion'] = [
                'type' => 'error',
                'text' => 'Ha ocurrido un error al borrar el documento.'
            ];
            // Indicar error en la respuesta
            $response['success'] = false;
            $response['messageDocuementacion'] = 'Ha ocurrido un error al borrar el documento.';
        }
    } catch (PDOException $e) {
        // En caso de un error en la base de datos
        $_SESSION['messageDocuementacion'] = [
            'type' => 'error',
            'text' => 'Error en la base de datos al borrar el documento.'
        ];

        // Indicar error en la respuesta
        $response['success'] = false;
        $response['messageDocuementacion'] = 'Error en la base de datos al borrar el documento.';
    }

    return $response;

}

if (isset($_POST['btnABorrarDocMasivos'])) {
 
    $documentosSeleccionados = $_POST['documentos'];

    $response = borrarDocumentosMasivos($documentosSeleccionados);

    // Devolver la respuesta al cliente
    echo json_encode($response);
    exit();
}


function buscarAranceles()
{

    global $pdo;

    $sql = "SELECT * FROM Documentacion WHERE Asunto LIKE '%aranceles%'";
   
    $datosAranceles= $pdo->prepare($sql);
    $datosAranceles->execute();

    $rowDatosAranceles= $datosAranceles->fetchAll(PDO::FETCH_ASSOC);
    return $rowDatosAranceles;
}

function fechaFinCursada()
{

    global $pdo;
    $anio = date("Y") - 1;

    $sql = "SELECT * FROM fecha_fin_cursada WHERE YEAR(fecha_fin_cursada) > $anio";
   
    $datosfechaFinCursada= $pdo->prepare($sql);
    $datosfechaFinCursada->execute();

    $rowfechaFinCursada= $datosfechaFinCursada->fetchAll(PDO::FETCH_ASSOC);
    return $rowfechaFinCursada;
}

function actualizarFechaFinalCursada($idFechaCursada, $nuevoValorFecha) {
    session_start();
    global $pdo;

    // Inicializar la respuesta
    $response = array();

    try {
        $sql = "SELECT fecha_fin_cursada FROM fecha_fin_cursada WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idFechaCursada]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si la nueva fecha es diferente a la existente
        if ($resultado['fecha_fin_cursada'] == $nuevoValorFecha) {
            // Si no hay cambios, informar al usuario y devolver la respuesta
            $_SESSION['messageFinCursada'] = [
                'type' => 'info',
                'text' => 'No se actualizaron datos.'
            ];
            $response['success'] = true;
            $response['messageFinCursada'] = 'No se actualizaron datos.';
            return $response;
        }

        $sql = "UPDATE fecha_fin_cursada SET fecha_fin_cursada = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nuevoValorFecha, $idFechaCursada]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['messageFinCursada'] = [
                'type' => 'success',
                'text' => 'Fecha actualizada exitosamente'
            ];
            // Indicar éxito en la respuesta
            $response['success'] = true;
        } else {
            $_SESSION['messageFinCursada'] = [
                'type' => 'error',
                'text' => 'Ha ocurrido un error al actualizar la fecha.'
            ];
            // Indicar error en la respuesta
            $response['success'] = false;
            $response['message'] = 'Ha ocurrido un error al actualizar la fecha.';
        }
    } catch (PDOException $e) {
        // En caso de un error en la base de datos
        $_SESSION['messageFinCursada'] = [
            'type' => 'error',
            'text' => 'Error en la base de datos al actualizar la fecha.'
        ];

        // Indicar error en la respuesta
        $response['success'] = false;
        $response['messageFinCursada'] = 'Error en la base de datos al actualizar la fecha.';
    }

    return $response;
}

if (isset($_POST['btnActualizarFecha'])) {
    $idFechaCursada = $_POST['idFecha'];
    $nuevoValorFecha = $_POST['nuevoValorFecha'];

    $response = actualizarFechaFinalCursada($idFechaCursada, $nuevoValorFecha);

    // Devolver la respuesta al cliente
    echo json_encode($response);
    exit();
}

function obtenerDatosParaGrafico() {
    global $pdo;

    // Inicializar el array para almacenar los datos
    $datos = array(
        'sexos' => array(),
        'cantidades' => array()
    );

    // Consulta SQL para obtener la cantidad de cada género
    $sql = "SELECT sexo, COUNT(*) as cantidad FROM Persona GROUP BY sexo";
    $resultado = $pdo->query($sql);

    // Verificar si la consulta fue exitosa
    if ($resultado->rowCount() > 0) {
        while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
            // Agregar datos a los arrays
            $datos['sexos'][] = $fila['sexo'];
            $datos['cantidades'][] = (int)$fila['cantidad'];
        }
    }

    // Convierte el array a formato JSON
    $datos_json = json_encode($datos);

    return $datos_json;
}

function obtenerDatosParaGraficoEdades() {
    // Realiza la conexión a la base de datos (ajusta los detalles de conexión según tu configuración)
    global $pdo;

    // Consulta SQL para obtener las edades
    $sql = "SELECT TIMESTAMPDIFF(YEAR, Fechanacimiento, CURDATE()) AS Edad FROM Persona";
    $stmt = $pdo->query($sql);

    // Inicializa un array para almacenar las edades
    $edades = array();

    // Recorre los resultados y agrega las edades al array
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Asegúrate de que Edad sea un valor numérico antes de agregarlo al array
        $edad = (int)$row['Edad'];
        if (!is_numeric($edad)) {
            // Puedes manejar o registrar el error de alguna manera si es necesario
            continue;
        }

        $edades[] = $edad;
    }

    // Contar la frecuencia de cada edad
    $conteoEdades = array_count_values($edades);

    // Crear un array para almacenar las etiquetas (edades) y los datos (cantidad)
    $etiquetas = array_keys($conteoEdades);
    $datos = array_values($conteoEdades);

    // Convertir los datos a formato JSON
    $datos_json = json_encode(array('etiquetas' => $etiquetas, 'datos' => $datos));

    // Cerrar la conexión
    $pdo = null;

    return $datos_json;
}

function nosedeestafuncion ()
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

