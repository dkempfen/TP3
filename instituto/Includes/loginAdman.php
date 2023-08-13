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
        
       
        $sql="SELECT * FROM usuarios u INNER JOIN rol  r on u.rol=r.rol_id
        left JOIN Alumnos A on u.usuario= A.alumno_id
       left JOIN Carrera_Alumno ca on ca.id_Alumno=A.alumno_id
       left JOIN Carrera c on c.id_Carrera=ca.id_Carrera
        WHERE usuario='$login' AND clave='$pass'";
        $query = $pdo->prepare($sql);
        $query->execute([$login, $pass]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

       
        


        if ($query->rowCount() > 0) {
           
            if( $result["rol_id"]==1){
                $_SESSION['active'] = true;
                header('Location:/instituto/Adman/index.php');
                $_SESSION['id_usuario'] = $result['usuario_id'];
                $_SESSION['nombre'] = $result['nombre'];
                $_SESSION['mail'] = $result['mail'];
                $_SESSION['clave'] = $result['clave'];
                $_SESSION['rol'] = $result['rol_id'];
                $_SESSION['nombre_rol'] = $result['nombre_rol'];
                $_SESSION['edad'] = $result['edad'];
                $_SESSION['fechanac'] = $result['fecha_nac'];
                $_SESSION['carrrea'] = $result['nombre_Carrera'];
                $_SESSION['usuario_id'] = $result['usuario'];
                echo '<div class="alert alert-success"><button type="button" class="close"
                data-dismiss="alert"></button>Redirecting</div>';}

            if( $result["rol_id"]==0){
                $_SESSION['activep'] = true;
                header('Location:/instituto/profesor/index.php');
                $_SESSION['id_usuario'] = $result['usuario_id'];
                $_SESSION['nombre'] = $result['nombre'];
                $_SESSION['mail'] = $result['mail'];
                $_SESSION['usuario'] = $result['usuario'];
                $_SESSION['clave'] = $result['clave'];
                $_SESSION['rol'] = $result['rol_id'];
                $_SESSION['nombre_rol'] = $result['nombre_rol'];
                $_SESSION['edad'] = $result['edad'];
                $_SESSION['fechanac'] = $result['fecha_nac'];
                $_SESSION['carrrea'] = $result['nombre_Carrera'];
                $_SESSION['usuario_id'] = $result['usuario'];
                echo '<div class="alert alert-success"><button type="button" class="close"
                data-dismiss="alert"></button>Redirecting</div>';}


            if( $result["rol_id"]==3){
                $_SESSION['activea'] = true;
                header('Location:/instituto/Alumno/index.php');
                $_SESSION['id_usuario'] = $result['usuario_id'];
                $_SESSION['nombre'] = $result['nombre'];
                $_SESSION['mail'] = $result['mail'];    
                $_SESSION['usuario'] = $result['usuario'];
                $_SESSION['clave'] = $result['clave'];
                $_SESSION['rol'] = $result['rol_id'];
                $_SESSION['nombre_rol'] = $result['nombre_rol'];
                $_SESSION['edad'] = $result['edad'];
                $_SESSION['fechanac'] = $result['fecha_nac'];
                $_SESSION['carrrea'] = $result['nombre_Carrera'];
                $_SESSION['usuario_id'] = $result['usuario'];
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

