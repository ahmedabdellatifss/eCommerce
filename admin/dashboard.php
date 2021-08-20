<?php 

  
    ob_start();  // Output Buffering Start #47

    session_start();

    if(isset($_SESSION['Username'])) {
    
    $pageTitle = 'Dashboard';

        include 'init.php';
        
        // Start Dashboard page

        $numUsers = 5; // Number of Latest Users'

                        // getlatest this is function from functions.php  #45 
        $latestUsers = getLatest("*" , "users" , "UserID" , $numUsers); // Latest Users Array

        $numItems = 6; // Number of latest Item

        $latestItems = getLatest("*" , "items" , "Item_ID" , $numItems); // Latest Items Array


        ?>
        
        <div class="home-stats">
            <div class="container text-center">
                <h1>Dashboard Page </h1>
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat st-members">
                            Total Members
                            <span><a href="members.php"><?php echo countItems('UserID' , 'users') ?></a></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-pending">
                            pending Members
                            <span>
                                <a href="members.php?do=Manage&page=pending">
                                    <?php echo checkItem("RegStatus" , "users" , 0) ?>
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-item">
                            Total Items
                            <span>
                                <a href="items.php">
                                    <?php echo countItems('item_ID' , 'items') ?>
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-comments">
                            Total Comments
                            <span>0 </span>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        <div class="latest">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-users"></i>Latest <?php echo $numUsers ?> Registerd Users
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled latest-users">
                                    <?php                            
                                        foreach ($latestUsers as $user) { 
                                            echo '<li>' ;
                                                echo $user['Username'] ;
                                                echo '<a href="members.php?do=Edit&userid=' . $user['UserID'] . '">';
                                                    echo '<span class="btn btn-success pull-right">' ;
                                                        echo '<i class="fa fa-edit"></i> Edit';
                                                            if ($user['RegStatus'] == 0) {
                                                                echo "<a href='members.php?do=Activate&userid=" . $user['UserID'] ."' class='btn btn-info activate pull-right'><i class='fa fa-check'></i>Activate</a> ";
                                                            }
                                                    echo '</span>';
                                                echo '</a>';
                                            echo '</li>';
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                            <i class="fa fa-items"></i>Latest <?php echo $numItems ?> Registerd Items
                            </div>
                            <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                                    <?php                            
                                        foreach ($latestItems as $item) { 
                                            echo '<li>' ;
                                                echo $item['Name'] ;
                                                echo '<a href="items.php?do=Edit&itemid=' . $item['Item_ID'] . '">';
                                                    echo '<span class="btn btn-success pull-right">' ;
                                                        echo '<i class="fa fa-edit"></i> Edit';
                                                            if ($item['Approve'] == 0) {
                                                                echo "<a href='items.php?do=Approve&itemid=" . $item['Item_ID'] ."' class='btn btn-info activate pull-right'><i class='fa fa-check'></i>Activate</a> ";
                                                            }
                                                    echo '</span>';
                                                echo '</a>';
                                            echo '</li>';
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<?php
        // End Dashboard page

        include  $tpl . 'footer.php';

    }else{

        //  echo 'You are Not authorized to view this page';

        header('location: index.php');
            exit();

        }

        ob_end_flush();

?>