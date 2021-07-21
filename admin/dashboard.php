<?php 
    session_start();

    if(isset($_SESSION['Username'])) {
    
    $pageTitle = 'Dashboard';

        include 'init.php';
        
        // Start Dashboard page

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
                            <?php $latestUsers = 5;?>
                            <div class="panel-heading">
                                <i class="fa fa-users"></i>Latest <?php echo $latestUsers ?> Registerd Users
                            </div>
                            <div class="panel-body">
                                <?php          // getlatest this is function from functions.php  #45                   
                                    $theLatest = getLatest("*" , "users" , "UserID" , $latestUsers);

                                    foreach ($theLatest as $user) {
                                        
                                        echo $user['Username'] . '<br>';
                                    }
                                    ?>
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