<?php 

session_start();
session_unset();
session_destroy();

header('location:/sistema/instituto/Login/index.php');