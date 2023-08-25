
<?php

    include_once("../conexion/config.php");
    include_once("../conexion/conexion.php");
    include_once("../modelo/usuario.php");

    class Admin extends Usuario
    {

       /* public function __construct(
            string $legajo, 
            string $user_name, 
            string $password, 
            int $estado,
            int $rol,
            Persona $persona){

            parent::__construct($legajo,$user_name,$password,$estado,$rol,$persona);
        }
        */

        public static function lista_usuario():Array{

            $con = new db();
            $sql = "SELECT u.Id_Usuario as id, u.Legajo, u.User as userName, u.Password as pass, u.Libromatriz, 
                    p.Carrera, e.Descripcion_Estado as estado, r.Descripcion as Rol, u.Personas_DNI  
                    from usuario u 
                    INNER JOIN rol  r on u.Rol_id_rol=r.id_rol 
                    INNER JOIN plan p on u.Id_Plan=p.idPlan 
                    INNER JOIN estado e on u.Estado_Usuario=e.Id_Estado";
            
            
            $result=$con->query($sql);
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $con->close();
            
           return $data;
            
        }

    }

    


?>
