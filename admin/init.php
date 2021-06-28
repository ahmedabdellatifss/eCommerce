<?php 

      include 'connect.php';

      // Routes

      $tpl  ='includes/templates/';  // Template Directory
      $css  = 'layout/css/';          // Css Directory
      $js   = 'layout/js/';          // Js Directory
      $lang = 'includes/languages/'; //language Directory

     // Include the important Files

     include $lang . 'english.php';
     include $tpl  . 'header.php';


     // Include Navbar On All Pages expect the one with $noNavbar Variable

     if(!isset($noNavbar)) { include $tpl  . 'navbar.php';  }   // if you don't have navebar variables ($noNavbar) put the navbar in page

      
     
     