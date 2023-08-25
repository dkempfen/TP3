



<?php

/*
        pp3-back/
        
        { 
            "dni":199441,
            "nombre":"hoy",
            "apellido":"mañana",
            "fecha_nac":"2023-07-31",
            "telefono":"45534115",
            "email":"mi_email@email.com",
            "domicilio":"calle siempre viva 123",
            "inscripto":1
        }
        
        */

try{

    $obj=new Persona("!11","facu","ro","123","123","facu_ro@email.com","calle siempre viva 123","1");

    echo $obj->get_dni();
    echo "<br>";
    echo $obj->get_inscripto();
    echo "<br>";
    echo $obj->get_telefono();

}catch(Exception $e){
    echo "el error que se produjo es ". $e->getMessage();


   
}

//valor por referencia

$foo = 'Bob';  
echo $foo;              // Asigna el valor 'Bob' a $foo
$bar = &$foo;   
echo $bar;             // Referenciar $foo vía $bar.
$bar = "Mi nombre es $bar";  // Modifica $bar...
echo $bar;
echo $foo;                   // $foo también se modifica.


?>