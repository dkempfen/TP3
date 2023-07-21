<?php
require '/instituto/Includes/conexion.php';


if(!empty($_GET)){

    $idusuario =$_GET['idusuario'];

    $sql ="SELECT * FROM usuarios WHERE usuario_id=?";
    $query= $pdo->prepare($sql);
    $query->execute(array($idusuario));
    $result=$query->fetch(PDO::FETCH_ASSOC);

    if(!empty($result)){
        $respuesta= array('status' => false, 'msg' => 'datos no encontrados');
    }else{
        $respuesta= array('status' => false, 'data' => $result);
    }

    echo json_decode($respuesta, JSON_UNESCAPED_UNICODE);
    
}