<?php
  require_once('load.php');


/*--------------------------------------------------------------*/
/* Function for Count id  By table name
/*--------------------------------------------------------------*/
function count_by_id($table){
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
function count_id($table){
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

  return ""; // Retorna 0 si la consulta falla o no se encuentran filas
}

  
  /*--------------------------------------------------------------*/

