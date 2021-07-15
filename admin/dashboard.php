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
                        <div class="stat">
                            Total Members
                            <span><?php echo countItems('UserID' , 'users') ?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat">
                            pending Members
                            <span>25</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat">
                            Total Items
                            <span>1500</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat">
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
                                <i class="fa fa-users">Latest Registerd Users</i>
                            </div>
                            <div class="panel-body">
                                Test
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