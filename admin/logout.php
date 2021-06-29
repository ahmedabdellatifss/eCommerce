<?php 
    session_start();     // Start the session 

    session_unset();    //   Unset the Data

    session_destroy(); // Destroy the session


    header('Location: index.php');

    exit();   // the exit after the header location to deny any output Error in case I send any header by wrong