<?php 
     session_start();
    
     if(isset($_SESSION['Username'])) {
       
        include 'init.php';
          echo 'Welcome';
        include  $tpl . 'footer.php';

    }else{

        //  echo 'You are Not authorized to view this page';
         header('location: index.php');
         exit();
     }