<?php
require 'conexion.php';

if (!empty($_GET['idusuario'])) {
    $idusuario = $_GET['idusuario'];

    $sql = "SELECT * FROM usuarios WHERE usuario_id=?";
    $query = $pdo->prepare($sql);
    $query->execute(array($idusuario));
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        $respuesta = array('status' => true, 'data' => $result);
    } else {
        $respuesta = array('status' => false, 'msg' => 'Datos no encontrados');
    }

    echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
} else {
    $respuesta = array('status' => false, 'msg' => 'ID de usuario no proporcionado');
    echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
}