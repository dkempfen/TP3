    
<?php
if (!defined("URL_SEPARATOR")) {
    define("URL_SEPARATOR", '/');
}

if (!defined("DS")) {
    define("DS", DIRECTORY_SEPARATOR);
}

if (!defined('SITE_ROOT')) {
    define('SITE_ROOT', realpath(dirname(__FILE__)));
}

if (!defined("LIB_PATH_INC")) {
    define("LIB_PATH_INC", SITE_ROOT . DS);
}


require_once(LIB_PATH_INC.'loginAdman.php');
require_once(LIB_PATH_INC.'conexion.php');
require_once(LIB_PATH_INC.'sql.php');
require_once(LIB_PATH_INC.'slqeditar.php');
require_once(LIB_PATH_INC.'sqlaltauser.php');
require_once(LIB_PATH_INC.'sqluser.php');
require_once(LIB_PATH_INC.'funcs.php');
require_once(LIB_PATH_INC.'mensajeRegistro.php');
require_once(LIB_PATH_INC.'funcionesPlan.php');




?>
