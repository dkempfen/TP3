<?php

    class db{

        protected $conexion;

        public function __construct(){

            $this->conexion=new mysqli(SERVER_NAME,USER_NAME,PASSWORD,DATABASE_NAME);

            $this->conexion->set_charset("utf8mb4");

            if($this->conexion->connect_errno){

                echo "error en la conexion ". $this->conexion->connect_error;

                exit();
            }

        // $this->conexion;

        }

        public function query($query){

            return $this->conexion->query($query);
        }

        public function prepare($query){

            return $this->conexion->prepare($query);
        }


        /*
        php mayor a 8.2
        public function query_prepare($query){

            return $this->conexion->execute_query($query);
        }
        
        */

        public function close(){

            return $this->conexion->close();
        }

        public function error_conexion():bool{

            return  $this->conexion->connect_errno;
        
        }

        public function msj_error_conexion(){

            return $this->conexion->connect_error;

        }

        
        public function estado(int $num, string $msj ):array{

            $estado=["estado"=>$num,
            "mensaje"=>$msj
           ];

           
           return $estado;
            
        }

    }

?>