

<?php  include 'init.php';  ?>

<div class="container">
    <h1 class="text-center">Show Item By Tag</h1>
    <div class="row">
        <?php
            if (isset($_GET['name'])) {
                $tag = $_GET['name'];
                echo "<h1 class='text-center'>" . $tag . "</h1>";

                $tagItems = getAllFrom("*" , "items" , "where tags LIKE '%$tag%' " , "AND Approve = 1" , "Item_ID" );  //115
                foreach ($tagItems as $item) { //#83
                    echo '<div class="col-sm-6 col-md-3">';
                        echo'<div class="thumbnail item-box">';
                            echo '<span class="price-tag">' . $item['Price']. '</span>';
                            echo '<img class="img-responsive" src="img.png" alt="" />';
                            echo '<div class="caption">';
                                echo '<h3><a href="items.php?itemid='. $item['Item_ID'] .'">' . $item['Name']. '</a></h3>';
                                echo '<p>' . $item['Description']. '</p>';
                                echo '<div class="date">' . $item['Add_Date']. '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';    
                }
    
        } else {
            echo 'You Must Enter Tag Name ';
        }

        ?>
    </div>
</div>

<?php  include  $tpl . 'footer.php'; ?>

