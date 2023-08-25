
<?php

    //include_once("../conexion/config.php");
    //include_once("../conexion/conexion.php");
    include_once("persona.php");


    class Usuario implements JsonSerializable
    {

        //  private int $id_usuario;
        private string $legajo;
        private string $user_name;
        private string $password;
        //private string $libromatriz;

        //relation with class Persona
        private Persona $persona;
        private int $estado;

        private int $rol;
        // private Plan $plan;

        //constructor con todos los parametros
        public function __construct(
            /* int $id_usuario,*/
            string $legajo,
            string $user_name,
            string $password,
            //string $libromatriz, 
            //string $email,
            int $estado,
            int $rol,
            Persona $persona
        ) {

            // $this->id_usuario = $id_usuario;
            $this->legajo = $legajo;
            $this->user_name = $user_name;
            $this->password = $password;
            //$this->libromatriz = $libromatriz;
            $this->estado = $estado;
            $this->rol = $rol;

            $this->persona = $persona;
        }

        //todos los getter y setter
        /*  public function getId_usuario(): int{
                return $this->id_usuario;
            }

            public function setId_usuario(int $id_usuario): void{
                $this->id_usuario = $id_usuario;
            }*/

        public function getLegajo(): string
        {
            return $this->legajo;
        }

        public function setLegajo(string $legajo): void
        {
            $this->legajo = $legajo;
        }

        public function getUser_name(): string
        {
            return $this->user_name;
        }

        public function setUser_name(string $user_name): void
        {
            $this->user_name = $user_name;
        }

        public function getPassword(): string
        {
            return $this->password;
        }

        public function setPassword(string $password): void
        {
            $this->password = $password;
        }

        /*      public function getLibromatriz()
            {
                    return $this->libromatriz;
            }

            
            public function setLibromatriz($libromatriz)
            {
                    $this->libromatriz = $libromatriz;

                    return $this;
            }*/


        public function getPersona():Persona
        {
            return $this->persona;
        }

        public function setPersona($persona)
        {
            $this->persona = $persona;

            return $this;
        }


        public function getEstado()
        {
            return $this->estado;
        }

      
        public function setEstado(int $estado)
        {
            $this->estado = $estado;

           
        }

        public function getRol()
        {
            return $this->rol;
        }

        public function setRol(int $rol)
        {
            $this->rol = $rol;

         
        }


        /* public function getFk_dni(){
                return $this->fk_dni;
            }

        
            public function setFk_dni($fk_dni) {
                $this->fk_dni = $fk_dni;
            }
            */

        public static function buscar_por_id(int $id): Usuario
        {

            $con = new db();

            $sql = "SELECT * FROM usuario WHERE DNI=?";

            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            $con->close();
            $stmt->close();

            $obj = $result->fetch_object();

            return new Usuario($obj->DNI, $obj->nombre, $obj->email, $obj->clave, $obj->rol, $obj->estado);
        }


        //int $id_usuario, string $user_name, string $email, string $clave, int $rol, int $estado
        //$user_name,$email,$clave,$rol,$estado,$id_usuario

        public  function ActulizarUser(int $id)
        {

            $con = new db();

            $sql = "UPDATE usuario SET Legajo=?, User= ?, Pssword= ?,  Estado_Usuario= ?, 
                    Rol_id_rol= ?, Personas_DNI= ? WHERE Id_Usuario = ?";

            $stmt = $con->prepare($sql);
            $stmt->bind_param("issiiiii",$this->getLegajo(),$this->getUser_name(), $this->getPassword(), $this->getEstado(), $this->getRol(),  $id);
            $stmt->execute();

            if ($stmt->affected_rows === 0) {

                echo json_encode($con->estado(3, 'No se ha actualizado ningún dato.'));
            } else if ($stmt->affected_rows > 0) {
                // Al menos un dato se actualizó correctamente
                echo json_encode($con->estado(1, 'Usuario actualizado exitosamente.'));
            } else {
                // Ocurrió un error al actualizar el usuario
                echo json_encode($con->estado(2, 'Ha ocurrido un error al actualizar el usuario.'));
            }


            $con->close();
            $stmt->close();
        }


        public function jsonSerialize()
        {
            return [
                //'id_usuario' => $this->id_usuario,
                'legajo' => $this->legajo,
                'user_name' => $this->user_name,
                'password' => $this->password,
                //     'libromatriz' => $this->libromatriz,
                //'persona' => $this->persona
            ];
        }

    }


?>
