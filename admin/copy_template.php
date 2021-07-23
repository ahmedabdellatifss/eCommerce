<?php 

    /*
    ===========================================================================
    == Template Page
    ===========================================================================
    */

    ob_start();  // Output Buffering Start #47

    session_start();

    $pageTitle = 'Members';
    
    if(isset($_SESSION['Username'])) {
      
        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : $do = 'Manage' ;

        // Start Mange Page 

        if ($do == 'Manage') {  // Mange page 

            echo 'Wellcome';

        }elseif ($do == 'Add') {


        }elseif ($do == 'Insert') {


        }elseif ($do == 'Edit') {


        }elseif ($do == 'Update') {

    
        }elseif ($do == 'Delete') {


        }elseif ($do == 'Activate' ) {


        }

    include  $tpl . 'footer.php';

    } else {

        header('Location: index.php');

        exit();
    }      
    
    ob_end_flush();

?>