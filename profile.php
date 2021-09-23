<?php
    ob_start();
    session_start();
    $pageTitle = 'Profile';
    include 'init.php';
    if (isset($_SESSION['user']) ) {

    $getUser = $con->prepare("SELECT * FROM  users WHERE Username = ?") ; #91
    $getUser->execute(array($sessionUser));
    $info = $getUser->fetch();


?>
<h1 class="text-center">My Profile</h1>

<div class="information block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">Main Information</div>
            <div class="panel-body">
                <ul class="list-unstyled">
                    <li>
                        <i class="fa fa-unlock-alt fa-fw"></i>
                        <span>Name :</span> <?php echo $info['Username'] ?>
                    </li>  
                    <li>
                        <i class="fa fa-envelope-o fa-fw"></i>
                        <span>Email :</span> <?php echo $info['Email'] ?>
                    </li> 
                    <li>
                        <i class="fa fa-user fa-fw"></i>
                        <span>Full Name :</span> <?php echo $info['FullName'] ?>
                    </li> 
                    <li>
                        <i class="fa fa-calendar fa-fw"></i>
                        <span>Register Date :</span> <?php echo $info['Date'] ?>
                    </li> 
                    <li>
                        <i class="fa fa-tags fa-fw"></i>
                        <span>Favourite Category :</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="my-ads block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">My Ads</div>
            <div class="panel-body">
                    <?php
                        if (! empty(getItems( 'Member_ID' , $info['UserID'] ) ) ) {
                            echo '<div class="row">';
                            foreach (getItems( 'Member_ID' , $info['UserID'] , 1) as $item) { //#83
                                echo '<div class="col-sm-6 col-md-3">';
                                    echo'<div class="thumbnail item-box">';
                                        echo '<span class="price-tag">$' . $item['Price']. '</span>';
                                        echo '<img class="img-responsive" src="img.png" alt="" />';
                                        echo '<div class="caption">';
                                            echo '<h3><a href="items.php?itemid='. $item['Item_ID'] .'"> ' . $item['Name']. '</a></h3>';
                                            echo '<p>' . $item['Description']. '</p>';
                                            echo '<div class="date">' . $item['Add_Date']. '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>'; 
                            }  
                            echo '</div>';                         
                        }else {
                            echo 'Sorry There\' No Ads to show Create <a href="newad.php"> New Ad</a>';
                        }
                    ?>
            </div>
        </div>
    </div>
</div>

<div class="my-comments block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">Latest Comments</div>
            <div class="panel-body">
                
                <?php 
                    $stmt = $con->prepare(" SELECT comment FROM comments WHERE user_id = ? ");
                    // Execute the Statement
                    $stmt->execute(array($info['UserID']));
                    // Assign to Variable 
                    $comments = $stmt->fetchAll();

                    if (! empty($comments) ) {

                        foreach ($comments as $comment ) 

                            echo '<p>' . $comment['comment'] . '</p>';

                    } else {

                        echo 'There\'s No Comments to show '; 
                    }
                ?>    
            </div>
        </div>
    </div>
</div>

<?php
    } else {
        header('Location: login.php');
        exit();
    }    
    include  $tpl . 'footer.php';
    ob_end_flush();
?>