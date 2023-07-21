<?php

$host = 'localhost';
$user = 'root';
$db = 'sistema-escolar';
$pass = '';


try {
    $pdo = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8', $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {      
    'error: '.$e->getMessage();                                                                                                                                                           
     echo 'Connection failed: ' .$e->getMessage();
}

/*$host=new mysqli("localhost", "root", "", "sistema-escolar", "3000");*/


/*$host = new mysqli("localhost", "root", "", "sistema-escolar");
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
/*echo $mysqli->host_info . "\n";*/

/*$host                                                                                                                                                                             ->set_charset("utf8")*/;

?>                                                                                                                                  