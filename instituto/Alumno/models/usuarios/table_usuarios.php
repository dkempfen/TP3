<?php
require_once '/instituto/Includes/conexion.php';

$sql = 'select * from usuarios AS U INNER JOIN ROL AS R on u.rol = r.rol_id where estado !=0';
$query = $pdo -> prepare($sql);
$query-> execute();

$consulta = $query->fetchAll(PDO:: FETCH_ASSOC);

for($i = 0; $i < count($consulta); $i++){
    if($consulta[$i]['estado'] ==1){
        $consulta[$i]['estado'] = '<span class="badge bange-success">Activo</span>';
    } else {$consulta[$i]['estado'] = '<span class="badge bange-danger">Inactivo</span>'; }

    $consulta[$i]['Acticiones'] = '
        <button class="btn btn-primary" title="Editar" onclick="editarUsuario('.$consulta[$i]['usuario_id'].')">Editar</button>
        <button class="btn btn-danger" title="Eliminar" onclick="eliminarUsuario('.$consulta[$i]['usuario_id'].')">Eliminar</button>

    ';
}

echo json_encode($consulta,JSON_UNESCAPED_UNICODE); 