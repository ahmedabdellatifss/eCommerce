<?php 

    /*
    ===========================================================================
    == Mange Members Page
    == You can Add | Edit | Delete Members From Here
    ===========================================================================
    */

    session_start();
    
    if(isset($_SESSION['Username'])) {
      
       include 'init.php';

       $do = isset($_GET['do']) ? $_GET['do'] : $do = 'Manage' ;

       // Start Mange Page 

       if ($do == 'Mange') {

        // Mange page

       }elseif ($do == 'Edit') {

        // Edit Page

        echo 'Welcome To Edit Page Your ID is :' . $_GET['userid'];

       }
       include  $tpl . 'footer.php';

   }else{

       //  echo 'You are Not authorized to view this page';
        header('location: index.php');
        exit();
    }