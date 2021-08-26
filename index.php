<?php

    include 'init.php';

             $stmt = $con->prepare("SELECT * FROM categories ");

            $stmt->execute();

            $cats = $stmt->fetchAll(); 

            foreach($cats as $cat) {
              echo $cat['Name'];
            }

    include  $tpl . 'footer.php';

?>