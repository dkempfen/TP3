<?php 

session_start();
session_unset();
session_destroy();

header('location:/sistemas/instituto/Login/index.php');