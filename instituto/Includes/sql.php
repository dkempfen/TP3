<?php
require_once('load.php');


/*--------------------------------------------------------------*/
/* Function for Count id  By table name
/*--------------------------------------------------------------*/
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

  return 0; // Retorna 0 si la consulta falla o no se encuentran filas
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

  return 0; // Retorna 0 si la consulta falla o no se encuentran filas
}


/*--------------------------------------------------------------*/
function cambiarFotoPerfil($table)
{
    global $pdo;

    // Si no se cargó una nueva foto, realizamos la consulta a la base de datos para obtener el nombre de la foto actual
    $sql = "SELECT nueva_foto FROM " . $table;
    $fotocambio = $pdo->prepare($sql);
    $fotocambio->execute();

    $rows = $fotocambio->fetch(PDO::FETCH_ASSOC);
    if ($rows) {
        return $rows['nueva_foto'];
    }

    return ""; // Retorna un valor por defecto si no se cargó una nueva foto y no se encontraron filas en la consulta
}


function obtenerFotoPerfilActual()
{
  // En este ejemplo, suponemos que el nombre de la foto de perfil está almacenado en una variable de sesión
  // $_SESSION['foto_perfil'] = 'nombre_de_la_foto_actual.jpg';
  // Puedes cambiar esta lógica según cómo estés almacenando el nombre de la foto de perfil en tu sistema
  return $_SESSION['foto_perfil'];
}

////////////////////////////////////////////////////////////
if (isset($_POST['usuario_id']) && isset($_POST['estado'])) {
  $usuario_id = $_POST['usuario_id'];
  $estado = ($_POST['estado'] == 'activo') ? 1 : 0;

  // Actualizar el estado del usuario en la base de datos
  $sql = "UPDATE usuarios SET estado = :estado WHERE usuario_id = :usuario_id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':estado', $estado);
  $stmt->bindParam(':usuario_id', $usuario_id);
  $stmt->execute();

  echo "Estado del usuario actualizado correctamente.";
} elseif (isset($_POST['get_users_state'])) {
  // Obtener el estado actual de todos los usuarios
  $sql = "SELECT usuario_id, estado FROM usuarios";
  $stmt = $pdo->query($sql);
  $usersState = array();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $usersState[$row['usuario_id']] = ($row['estado'] == 1) ? 'activo' : 'inactivo';
  }
  echo json_encode($usersState);
} else {
  echo "Error: Datos de usuario no recibidos correctamente.";
}