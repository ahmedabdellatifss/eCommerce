<?php 
     session_start();
     if(isset($_SESSION['Username'])) {
       echo 'Welcone ' . $_SESSION['Username'];
     }else{

        //  echo 'You are Not authorized to view this page';
         header('location: index.php');
         exit();
     }