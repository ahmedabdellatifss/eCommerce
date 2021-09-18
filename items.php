<?php
    ob_start();
    session_start();
    $pageTitle = 'Show Items';
    include 'init.php';

      // Check if Get Request item is Numeric & Get the integer value of it
    // Detect the item Id is number
    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;    // intval = intger value

    // Select All Data Depend on this ID

    $stmt = $con->prepare("SELECT 
                                items.*,
                                categories.Name AS category_name,
                                users.Username 
                            FROM 
                                items
                            INNER JOIN 
                                categories 
                            ON 
                                categories.ID = items.Cat_ID
                            INNER JOIN
                                users 
                            ON 
                                users.UserID = items.Member_ID      
                            WHERE  
                                item_ID = ? "); 

    // Execute Query
    $stmt->execute(array($itemid));

    $count = $stmt->rowCount();

    if ($count > 0 ) {
    // Fetch The data
    $item = $stmt->fetch();
?>
<h1 class="text-center"><?php echo $item['Name'] ?></h1>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <img class="img-responsive img-thumbnail center-block" src="img.png" alt="" />
        </div>
        <div class="col-md-9 item-info">
            <h2><?php echo $item['Name'] ?></h2>
            <p><?php echo $item['Description'] ?></p>
            <ul class="list-unstyled">
                <li>
                    <i class="fa fa-calendar fa-fw"></i>
                    <span>Added Date</span> : <?php echo $item['Add_Date'] ?>
                </li>
                <li>
                    <i class="fa fa-money fa-fw"></i>
                    <span>Price</span> : $<?php echo $item['Price'] ?>
                </li>
                <li>
                    <i class="fa fa-building fa-fw"></i>
                    <span>Made In</span> : <?php echo $item['Country_Made'] ?>
                </li>
                <li>
                    <i class="fa fa-tags fa-fw"></i>
                    <span>Category</span> :<a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?> "> <?php echo $item['category_name'] ?> </a>
                </li>
                <li>
                    <i class="fa fa-user fa-fw"></i>
                    <span>Added By</span> :<a href="#"> <?php echo $item['Username'] ?> </a> 
                </li>
            </ul>

        </div>
    </div>
    <hr class="custom-hr">
    <div class="row">
        <div class="col-md-3">
            user Image
        </div>
        <div class="col-md-9">
            User Comment
        </div>
    </div>
</div>

<?php

    } else {
        echo 'There\'s no such Id';
    }

    include  $tpl . 'footer.php';
    ob_end_flush();
?>