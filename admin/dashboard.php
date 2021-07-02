<?php 
     session_start();
    
     if(isset($_SESSION['Username'])) {
       
      $pageTitle = 'Dashboard';

        include 'init.php';
        
        

        include  $tpl . 'footer.php';

    }else{

        //  echo 'You are Not authorized to view this page';
         header('location: index.php');
         exit();
     }