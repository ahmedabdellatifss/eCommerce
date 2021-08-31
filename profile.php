<?php

    session_start();

    $pageTitle = 'Profile';

    include 'init.php';

    echo 'Welcome ' . $_SESSION['user'];

    include  $tpl . 'footer.php';

?>