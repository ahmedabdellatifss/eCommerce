<?php 
    session_start();

    if(isset($_SESSION['Username'])) {
    
    $pageTitle = 'Dashboard';

        include 'init.php';
        
        // Start Dashboard page

        $latestUsers = 5; // Number of Latest Users'

                        // getlatest this is function from functions.php  #45 
        $theLatest = getLatest("*" , "users" , "UserID" , $latestUsers); // Latest Users Array


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
                            <span><a href="members.php?do=Manage&page=pending">
                                <?php echo checkItem("RegStatus" , "users" , 0) ?>
                            </a></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-item">
                            Total Items
                            <span>1500</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat st-comments">
                            Total Comments
                            <span>3500 </span>
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
                                <i class="fa fa-users"></i>Latest <?php echo $latestUsers ?> Registerd Users
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled latest-users">
                                    <?php                            
                                        foreach ($theLatest as $user) { 
                                            echo '<li>' ;
                                                echo $user['Username'] ;
                                                echo '<a href="members.php?do=Edit&userid=' . $user['UserID'] . '">';
                                                    echo '<span class="btn btn-success pull-right">' ;
                                                        echo '<i class="fa fa-edit"></i> Edit';
                                                            if ($user['RegStatus'] == 0) {
                                                                echo "<a href='members.php?do=Activate&userid=" . $user['UserID'] ."' class='btn btn-info activate pull-right'><i class='fa fa-close'></i>Activate</a> ";
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
                                <i class="fa fa-tag">Latest Items </i>
                            </div>
                            <div class="panel-body">
                                Test
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