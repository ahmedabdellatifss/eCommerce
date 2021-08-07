<?php 
  
    /* we use Get & Post to send someting from form I will explian that from file such as categories 
       we have the file categories it will control for many section to add or delet ...
       categories were containes => [ Manage | edit | Update | add | Insert | Delete | Statistics]

      The solution will be (actionOutDo) or all queries that get from http request put them in one page
    */


    $do = isset($_GET['do']) ? $_GET['do'] : $do = 'Manage' ;

    // if (isset($_GET['do'])) {
    //      $do =  $_GET['do'];
    // }else {
    //     $do = 'Manage';
    // }
    // If the page is main page

    if ($do == 'Manage') {

        echo' Welcome you are in the Mange Category page';

    } elseif ($do == 'Add' ){
  
        echo 'Welcome You Are in add category Page';

    }elseif ($do == 'Insert') {

        echo' Welcome you are in the Insert Category page';


    } else {
        echo 'Error there\'s No Page with this Name';
    }