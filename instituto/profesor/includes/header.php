<?php
  session_start();
  if(empty($_SESSION['activep'])){
    header('Location:/instituto/profesor/index.php');
  }
?> 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="sistema instituto">
    <title>Sistema Instituto</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" tipe ="text/css" href="/instituto/css/style.css">
    <link rel="stylesheet" tipe ="text/css" href="/instituto/css/main.css">
    <link rel="stylesheet" tipe ="text/css" href="/instituto/css/perfile.css">

    <!-- Font-icon css-->
     <!--<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">-->
  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="/instituto/profesor/index.php">Instituto Lujan</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"><i class="fas fa-bars"></i></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <li class="app-search">
          <input class="app-search__input" type="search" placeholder="Search">
          <button class="app-search__button"><i class="fa fa-search"></i></button>
        </li>
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="page-user.html"><i class="fa fa-cog fa-lg"></i> Settings</a></li>
            <li><a class="dropdown-item" href="/instituto/profesor/profile.php"><i class="fa fa-user fa-lg"></i> Profile</a></li>
            <li><a class="dropdown-item" href="/instituto/Login/logout.php"><i class="fas fa-sign-out-alt fa-lg"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </header>

<?php require_once 'includes/nav.php'; ?>