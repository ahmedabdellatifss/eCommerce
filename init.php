<?php 

      // Error Reporting # 90

      ini_set('display_errors', 'On');
      error_reporting(E_ALL);

      include 'admin/connect.php';

      $sessionUser = '';
      if (isset($_SESSION['user'])) {   #90
            $sessionUser = $_SESSION['user'] ;
      }

      // Routes

      $tpl  ='includes/templates/';  // Template Directory
      $lang = 'includes/languages/'; //language Directory
      $func = 'includes/functions/'; // Functions Directory
      $css  = 'layout/css/';          // Css Directory
      $js   = 'layout/js/';          // Js Directory
      

     // Include the important Files

      include $func . 'functions.php';
      include $lang . 'english.php';
      include $tpl  . 'header.php';


