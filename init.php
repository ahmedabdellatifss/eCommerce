<?php 

      include 'admin/connect.php';

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


