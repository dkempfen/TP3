
<?php

    include_once("../conexion/config.php");
    include_once("../conexion/conexion.php");

    class Persona implements JsonSerializable{

        private int $dni;
        private string $nombre;
        private string $apellido;
        private string $fecha_nac;
        private string $telefono;
        private string $email;
        private string $domicilio;
        private string $inscripto;

        public function __construct($dni,$nombre,$apellido,$fecha_nac,$telefono,$email,$domicilio,$inscripto){

            try{

                if (!is_int($dni) || !is_string($telefono)) {
                    throw new Exception("El DNI y el teléfono deben ser valores enteros.");
                }else{
                $this->dni=$dni;
                $this->nombre=$nombre;
                $this->apellido=$apellido;
                $this->fecha_nac=$fecha_nac;
                $this->telefono=$telefono;
                $this->email=$email;
                $this->domicilio=$domicilio;
                $this->inscripto=$inscripto;
            }
            
            }
            catch(Exception $e){

                echo "el error que se produjo es ". $e->getMessage();
            }
        
        }

        public function get_dni(){

            return $this->dni;
        }

        public function get_inscripto(){

            return $this->inscripto;
        }

        public function get_telefono(){

            return $this->telefono;
        }


        public function setDni($dni)
        {
            $this->dni = $dni;

        
        }

        
        public function setTelefono($telefono)
        {
            $this->telefono = $telefono;

        }

    
        public function setInscripto($inscripto)
        {
            $this->inscripto = $inscripto;

        }



        public function getDomicilio()
        {
            return $this->domicilio;
        }

        
    
        public function setDomicilio($domicilio)
        {
            $this->domicilio = $domicilio;

        }


        
        public function getFecha_nac()
        {
            return $this->fecha_nac;
        }

    
        public function setFecha_nac($fecha_nac)
        {
            $this->fecha_nac = $fecha_nac;

            
        }


        public function getApellido()
        {
            return $this->apellido;
        }


        public function setApellido($apellido)
        {
            $this->apellido = $apellido;

        
        }

    
        public function getNombre()
        {
            return $this->nombre;
        }

    
        public function setNombre($nombre)
        {
            $this->nombre = $nombre;
        }

         /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
                $this->email = $email;

                //return $this;
        }
    

        public function guardarPersona(){

            $con=new db();

            $dni=$this->get_dni();
            $nombre=$this->getNombre();
            $apellido=$this->getApellido();
            $fecha_nac=$this->getFecha_nac();
            $telefono=$this->get_telefono();
            $email=$this->getEmail();
            $domicilio=$this->getDomicilio();
            $inscripto=$this->get_inscripto();

            $sql="select if(dni= ?, 1 , 0) as bool from personas where dni=?";
            $stmt=$con->prepare($sql);
            $stmt->bind_param("ii",$dni,$dni );
            $stmt->execute(); 
            
            $stmt->bind_result($num);
            $stmt->fetch();
            $stmt->close();
 
           

            if($num==1){
               
                echo json_encode($con->estado(3,"el usuario ya esta registrado")); 

            }else{
                
                $sql2="insert into personas (dni,nombre,apellido,fechanacimiento,telefono,email,domicilio,inscripto)
                    SELECT ?,?,?,?,?,?,?,?
                    FROM dual
                    WHERE NOT EXISTS ( SELECT dni FROM personas where dni= ? ) ";

                $stmt2=$con->prepare($sql2);

                $stmt2->bind_param("isssssssi",$dni,$nombre,$apellido,$fecha_nac,$telefono,$email,$domicilio,$inscripto,$dni );
                    
                if($stmt2->execute()){
                    
                    $stmt2->close();
                    echo json_encode($con->estado(1,"ingresado con exito"));
                
                }else{

                    $stmt2->close();
                    echo json_encode($con->estado(2,"no se ingreso"));
                }

            } 
            
            
            $con->close();

        }



        public static function buscar_por_id(?int $id):Persona{

            $con = new db();

            $sql = "SELECT * FROM personas WHERE DNI=?";
            
            $stmt=$con->prepare($sql);
            $stmt->bind_param("i",$id);
            $stmt->execute();

          //  $stmt->bind_result($a,$b,$c,$d,$e,$f,$g,$h);
            //$stmt->fetch();
           $result = $stmt->get_result();

            $con->close();
            $stmt->close();

           $obj=$result->fetch_object();
          
           return    new Persona($obj->DNI,
                           $obj->Nombre,
                           $obj->Apellido,
                           $obj->Fechanacimiento,
                           $obj->Telefono,
                           $obj->Email,
                           $obj->Domicilio,
                           $obj->Inscripto );
           // return [$a,$b,$c,$d,$e,$f,$g,$h];

           /* 
           
            $data = $result->fetch_all(MYSQLI_ASSOC);

            return    new Persona($data[0]["DNI"],
                            $data[0]["Nombre"],
                            $data[0]["Apellido"],
                            $data[0]["Fechanacimiento"],
                            $data[0]["Telefono"],
                            $data[0]["Email"],
                            $data[0]["Domicilio"],
                            $data[0]["Inscripto"] );
            
            */

        }

        public function jsonSerialize() {
            return [
                'dni' => $this->dni,
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'fecha_nac' => $this->fecha_nac,
                'email'=>$this->email,
                'telefono' => $this->telefono,
                'domicilio' => $this->domicilio,
                'inscripto' => $this->inscripto
            ];
        }





    
    }


?>