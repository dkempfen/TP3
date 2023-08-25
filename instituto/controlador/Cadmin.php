
<?php 

    include_once("../modelo/persona.php");
    include_once("../modelo/admin.php");

    $metodo=$_SERVER["REQUEST_METHOD"]; //metodo de la peticion http

    $accion=$_GET["accion"]; //parametro de la url

    $info= json_decode(file_get_contents("php://input"),true); // recibe los datos en formato json

    if($metodo=="POST"){

        if(isset($_GET["accion"])){

            if($accion=="crear_persona"){

                $persona=new Persona( $info["dni"],
                    $info["nombre"],
                    $info["apellido"],
                    $info["fecha_nac"],
                    $info["telefono"],
                    $info["email"],
                    $info["domicilio"],
                    $info["inscripto"]
                );

                $persona->guardarPersona();
                echo json_encode($persona->buscar_por_id($persona->get_dni()));

            }
            else if($accion=="crear_alumno"){

                if(isset($_GET["dni"])){
                    $dni=$_GET["dni"];
                    $persona=Persona::buscar_por_id($dni);

                    /*  $persona=new Persona( $$persona[0],
                          $$persona[1],
                          $$persona[2],
                          $$persona[3],
                          $$persona[4],
                          $$persona[5],
                          $$persona[6],s
                          $$persona[7]
                      );
                  */
      
                      $user=new Usuario("primer legajo",
                                          "primer usuario",
                                         "password",
                                       //   "libro 1 foja 1",
                                       1,
                                       1,
                                          $persona);
                      
                    
                     // print_r($user);
                     echo json_encode($user);
               

                }
               

            }
            else if($accion=="modificar_usuario"){ 

                if(isset($_GET["Id_Usuario"])){

                    $id=$_GET["Id_Usuario"];
                    $user=Usuario::buscar_por_id($id);

                    
                    $user->setUser_name($info["User"]);
                    $user->setPassword($info["Password"]);
                    $user->setEstado($info["Estado_Usuario"]);
                    $user->setRol($info["Rol_id_rol"]);

                    $user->ActulizarUser($id);

                }

            }
                
                

        }
    
    }
    else if($metodo="GET"){
        
        if($accion=="listar_usuarios"){

            echo json_encode(Admin::lista_usuario());
        }

       
    }




?>