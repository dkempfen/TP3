<?php
/*session_start();*/
if (!empty($_POST) && $_SERVER['REQUEST_URI'] === '/instituto/Login/index.php') {
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
        TIMESTAMPDIFF(YEAR, Fechanacimiento, CURDATE()) AS edad FROM Usuario u INNER JOIN Rol  r on u.fk_Rol=r.id_rol
        left JOIN Persona p on p.DNI= u.fk_DNI
        INNER JOIN Estado e on e.Id_Estado= u.fk_Estado_Usuario
         /*left JOIN Carrera_Alumno ca on ca.id_Alumno=A.alumno_id*/
        left JOIN Plan pn on pn.cod_Plan=u.fk_Plan
         WHERE User='$login' AND Password='$pass'";
        $query = $pdo->prepare($sql);
        $query->execute([$login, $pass]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

       
        


        if ($query->rowCount() > 0) {
           
            if( $result["fk_Rol"]==3){
                $_SESSION['active'] = true;
                header('Location:/instituto/Adman/Pantallas/home.php');
                $_SESSION['id_usuario'] = $result['Id_Usuario'];
                $_SESSION['nombre'] = $result['Nombre'];
                $_SESSION['mail'] = $result['Email'];
                $_SESSION['usuario'] = $result['user'];
                $_SESSION['clave'] = $result['Password'];
                $_SESSION['rol'] = $result['fk_Rol'];
                $_SESSION['nombre_rol'] = $result['descripcion'];
                $_SESSION['edad'] = $result['edad'];
                $_SESSION['fechanac'] = $result['Fechanacimiento'];
                $_SESSION['carrrea'] = $result['carrera'];
                $_SESSION['estado'] = $result['fk_Estado_Usuario'];
                $_SESSION['dni'] = $result['fk_DNI'];
                $_SESSION['plan'] = $result['fk_Plan'];
                $_SESSION['libromatriz'] = $result['Libromatriz'];
               // Resto de las asignaciones para el rol 3

                // Mostrar el mensaje de carga y redirigir después de un breve retraso
 
               echo '
               <div class="alert alert-success">
                   <button type="button" class="close" data-dismiss="alert"></button>
                   <span id="loading-message">Cargando...</span>
               </div>
               <script>
                   setTimeout(function() {
                       document.getElementById("loading-message").innerHTML = "Ingresando...";
                       window.location.href = "/sistema/instituto/Adman/Pantallas/home.php";
                   }, 2000); // 2000 milisegundos (2 segundos) de retraso
               </script>';
           exit(); // Asegura que el script se detenga después de la redirección
       } elseif ($result["fk_Rol"] == 2) {
           $_SESSION['activeP'] = true;
          
           // Resto de las asignaciones para el rol 2
       } elseif ($result["fk_Rol"] == 1) {
           $_SESSION['activea'] = true;
           // Resto de las asignaciones para el rol 1
       } else {
           echo '<div class="alert alert-danger"><button type="button" class="close"
           data-dismiss="alert"></button>Rol no reconocido</div>';
       }
   } else {
       echo '<div class="alert alert-danger"><button type="button" class="close"
       data-dismiss="alert"></button>Usuario y Claves incorrectas</div>';
   }
}

}
?>