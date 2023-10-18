    
<?php

define("URL_SEPARATOR", '/');

define("DS", DIRECTORY_SEPARATOR);

// DEFINE ROOT PATHS

defined('SITE_ROOT')? null: define('SITE_ROOT', realpath(dirname(__FILE__)));
define("LIB_PATH_INC", SITE_ROOT.DS);



require_once(LIB_PATH_INC.'loginAdman.php');
require_once(LIB_PATH_INC.'conexion.php');
require_once(LIB_PATH_INC.'sql.php');
require_once(LIB_PATH_INC.'slqeditar.php');
require_once(LIB_PATH_INC.'sqlaltauser.php');
require_once(LIB_PATH_INC.'sqluser.php');
?>
