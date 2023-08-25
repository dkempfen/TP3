<?php
/*session_start();*/
if (!empty($_POST)) {
    if (empty($_POST['usuario']) || empty($_POST['pass'])) {
        echo '<div class="alert alert-danger"><button type="button" class="close"
        data-dismiss="alert"></button>Todos los campos son requeridos</div>';
    }
    /*if ($_POST['usuario'] === '') {
        echo "<div class= 'alert alert-danger'><button type='button' class='close'
        data-dismiss='alert'></button>Debe Ingresar el nombre de Usuario válido </div>";
    } elseif ($_POST['pass'] === '') {
        echo "<div class= 'alert alert-danger'><button type='button' class='close'
        data-dismiss='alert'></button>Debe ingresar la contraseña</div>";
    }*/ else {

        require_once 'conexion.php';
       
        $login = $_POST['usuario'];
        $pass = $_POST['pass'];
        
        
        $sql="SELECT *, Fechanacimiento,
        TIMESTAMPDIFF(YEAR, Fechanacimiento, CURDATE()) AS edad FROM usuario u INNER JOIN rol  r on u.fk_Rol=r.id_rol
        left JOIN persona p on p.DNI= u.fk_DNI
         /*left JOIN Carrera_Alumno ca on ca.id_Alumno=A.alumno_id*/
        left JOIN plan pn on pn.cod_Plan=u.fk_Plan
         WHERE user='$login' AND clave='$pass'";
        $query = $pdo->prepare($sql);
        $query->execute([$login, $pass]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

       
        


        if ($query->rowCount() > 0) {
           
            if( $result["fk_Rol"]==3){
                $_SESSION['active'] = true;
                header('Location:/instituto/Adman/index.php');
                $_SESSION['id_usuario'] = $result['Id_Usuario'];
                $_SESSION['nombre'] = $result['Nombre'];
                $_SESSION['mail'] = $result['Email'];
                $_SESSION['usuario'] = $result['user'];
                $_SESSION['clave'] = $result['clave'];
                $_SESSION['rol'] = $result['fk_Rol'];
                $_SESSION['nombre_rol'] = $result['descripcion'];
                $_SESSION['edad'] = $result['edad'];
                $_SESSION['fechanac'] = $result['Fechanacimiento'];
                $_SESSION['carrrea'] = $result['carrera'];
               /* $_SESSION['usuario_id'] = $result['id_usuario'];*/
               echo '<div class="alert alert-success"><button type="button" class="close"
                data-dismiss="alert"></button>Redirecting</div>';}

            if( $result["fk_Rol"]==2){
                $_SESSION['activep'] = true;
                header('Location:/instituto/profesor/index.php');
                $_SESSION['id_usuario'] = $result['Id_Usuario'];
                $_SESSION['nombre'] = $result['Nombre'];
                $_SESSION['mail'] = $result['Email'];
                $_SESSION['usuario'] = $result['user'];
                $_SESSION['clave'] = $result['clave'];
                $_SESSION['rol'] = $result['fk_Rol'];
                $_SESSION['nombre_rol'] = $result['descripcion'];
                $_SESSION['edad'] = $result['edad'];
                $_SESSION['fechanac'] = $result['Fechanacimiento'];
                $_SESSION['carrrea'] = $result['carrera'];
               /* $_SESSION['usuario_id'] = $result['id_usuario'];*/
                echo '<div class="alert alert-success"><button type="button" class="close"
                data-dismiss="alert"></button>Redirecting</div>';}


            if( $result["fk_Rol"]==1){
                $_SESSION['activea'] = true;
                header('Location:/instituto/Alumno/index.php');
                $_SESSION['id_usuario'] = $result['Id_Usuario'];
                $_SESSION['nombre'] = $result['Nombre'];
                $_SESSION['mail'] = $result['Email'];
                $_SESSION['usuario'] = $result['user'];
                $_SESSION['clave'] = $result['clave'];
                $_SESSION['rol'] = $result['fk_Rol'];
                $_SESSION['nombre_rol'] = $result['descripcion'];
                $_SESSION['edad'] = $result['edad'];
                $_SESSION['fechanac'] = $result['Fechanacimiento'];
                $_SESSION['carrrea'] = $result['carrera'];
               /* $_SESSION['usuario_id'] = $result['id_usuario'];*/
               echo '<div class="alert alert-success"><button type="button" class="close"
                data-dismiss="alert"></button>Redirecting</div>';}

           /*if (password_verify($pass, $result['clave'])) {
                $_SESSION['active'] = true;
                $_SESSION['id_usuario'] = $result['usuario_id'];
                $_SESSION['nombre'] = $result['usuario'];
                $_SESSION['rol'] = $result['rol_id'];
                $_SESSION['nombre_rol'] = $result['nombre_rol'];

                echo '<div class="alert alert-success"><button type="button" class="close"
                data-dismiss="alert"></button>Redirecting</div>';

            }*/ else {
                echo '<div class="alert alert-danger"><button type="button" class="close"
                data-dismiss="alert"></button>Usuario ó Clave incorrectas</div>';
            }
        } else {
            echo '<div class="alert alert-danger"><button type="button" class="close"
            data-dismiss="alert"></button>Usuario y Claves incorrectas</div>';
        }
    }
   
}




