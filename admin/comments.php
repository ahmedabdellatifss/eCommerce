<?php 

    /*
    ===========================================================================
    == Mange Comments Page
    == You can Approve | Edit | Delete Comments From Here
    ===========================================================================
    */

    ob_start();  // Output Buffering Start #47

    session_start();

    $pageTitle = 'Comments';
    
    if(isset($_SESSION['Username'])) {
      
       include 'init.php';

       $do = isset($_GET['do']) ? $_GET['do'] : $do = 'Manage' ;

       // Start Mange Page 

       if ($do == 'Manage') {  // Mange page 

       // Select All Users Except Admin
       $stmt = $con->prepare("SELECT
                                    comments.* , items.Name AS Item_Name, users.Username   AS Member
                                FROM 
                                    comments
                                INNER JOIN
                                    items
                                ON
                                    items.Item_ID = comments.item_id
                                INNER JOIN 
                                    users
                                ON 
                                    users.UserID = comments.user_id ");
       $stmt->execute();

       // Assign to Variable 
       $rows = $stmt->fetchAll();
       
       ?>

        <h1 class="text-center"><?php echo lang('MANAGE_COMMENTS') ?></h1>
        <div class="container">
               <div class="table-responsive">
               <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>ID</td>
                        <td>Comment</td>
                        <td>Item Name</td>
                        <td>User Name</td>
                        <td>ADD Date</td>
                        <td>Control</td>
                    </tr>

                    <?php 

                        foreach($rows as $row) {

                            echo "<tr>";
                                echo "<td>" . $row['c_id'] . "</td>";
                                echo "<td>" . $row['comment'] . "</td>";
                                echo "<td>" . $row['Item_Name'] . "</td>";   
                                echo "<td>" . $row['Member'] . "</td>";
                                echo "<td>" . $row['comment_date'] . "</td>";
                                echo "<td> 
                                        <a href='comments.php?do=Edit&comid=" . $row['c_id'] ."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a> 
                                        <a href='comments.php?do=Delete&comid=" . $row['c_id'] ."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a> ";

                                        if ($row['status'] == 0) {
                                            echo "<a 
                                                href='comments.php?do=Approve&comid=
                                                " . $row['c_id'] ."' 
                                                class='btn btn-info activate'>
                                                <i class='fa fa-check'></i>Approve</a> ";
                                        }

                                echo  "</td>";
                                
                            echo "</tr>";
                        }

                    ?>

            </table>
        
        </div>

    <?php 

    }elseif ($do == 'Edit') {  // Edit Page
            // Check if Get Request comid is Numeric & Get the integer value of it
            // Detect the comment Id is number
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;    // intval = intger value
        
        // Select All Data Depend on this ID

        $stmt = $con->prepare("SELECT * FROM  comments  WHERE  c_id = ?  ");

        // Execute Query
        $stmt->execute(array($comid));
        // Fetch The data
        $row = $stmt->fetch();
        // the Row Count
        $count = $stmt->rowCount();
        // If there is such id disply the form
        if ($count > 0) {  ?>

                <h1 class="text-center"><?php echo lang('EDIT_COMMENT') ?></h1>
                <div class="container">
                    <form action="?do=Update" class="form-horizontal" method="POST">
                        <input type="hidden" name="comid" value="<?php echo $comid ?>"> <!-- to send the value of userid without show it in form-->
                        <!-- Start Comment Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('COMMENT') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <textarea class="form-control" name="comment"><?php echo $row['comment'] ?></textarea>
                            </div>
                        </div>
                        <!-- End Comment Field -->
                    
                        <!-- Start submit Field -->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-primary btn-lg" value="<?php echo lang('SAVE') ?>" />
                            </div>
                        </div>
                        <!-- End submit Field -->
                    </form>
                </div>
        
        <?php

            // If There's No such Id Show Erro Message

            } else {

                $theMsg = 'Theres No Such ID';
                redirectHome($theMsg);

            }

     }elseif($do == 'Update'){  // Update Page

        echo "<h1 class ='text-center'>Update Comment</h1>";
        echo "<div class='container'>";

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Get variables from  the Form

            $comid     = $_POST['comid'];
            $comment   = $_POST['comment'];
            

            // Update the database with this info
            $stmt = $con->prepare("UPDATE comments SET comment = ?  WHERE c_id = ?");
            $stmt->execute(array($comment , $comid));


            // Echo Success Message
            $theMsg = "<div class='alert alert-success'>" .  $stmt->rowCount() . ' - Record Updated </div>';

            redirectHome( $theMsg , 'back' , 4);
            

        }else{

            $theMsg = "<div class='alert alert-danger'>Sorry You Cant Browse this page Directly </div>";

            redirectHome($theMsg , 'back');

        }

        echo '</div>';


     }elseif($do == 'Delete'){ // Delete Comment Page
 
            echo "<h1 class ='text-center'>Delete Comment</h1>";
            echo "<div class='container'>";

                // Check if Get Request userid is Numeric & Get the integer value of it
                // Detect the comid Id is number
                $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;    // intval = intger value dh rkom el3do
            
                // Select All Data Depend on this ID
                                                        
                $check = checkItem('c_id' , 'comments' , $comid);  // this is function from function.php file

                // If there is such id disply the form
                if ($check > 0) {  

                    $stmt = $con->prepare('DELETE FROM comments WHERE c_id = :Zcomid');

                    $stmt->bindParam(":Zcomid" , $comid);

                    $stmt->execute();

                    // Echo Success Message
                    $theMsg = "<div class='alert alert-success'>" .  $stmt->rowCount() . ' - Record Deleted </div>';

                    redirectHome($theMsg , 'back');


                }else{
    
                    $theMsg = "<div class='alert alert-danger'>This Id is not Exist </div>";

                    redirectHome($theMsg);

                }   

            echo '</div>';
    
     } elseif($do == 'Approve')  {

        echo "<h1 class ='text-center'>Approve Comment</h1>";
        echo "<div class='container'>";

            // Check if Get Request comid is Numeric & Get the integer value of it
            // Detect the comment Id is number
            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;    // intval = intger value dh rkom el3do
        
            // Select All Data Depend on this ID
                                                    
            $check = checkItem('c_id' , 'comments' , $comid);  // this is function from function.php file

            // If there is such id disply the form
            if ($check > 0) {  

                $stmt = $con->prepare('UPDATE comments SET status = 1  WHERE c_id = ?');

                $stmt->execute(array($comid));

                // Echo Success Message
                $theMsg = "<div class='alert alert-success'>" .  $stmt->rowCount() . ' - Record Approve </div>';

                redirectHome($theMsg , 'back');


            }else{

                $theMsg = "<div class='alert alert-danger'>This Id is not Exist </div>";

                redirectHome($theMsg);

            }   

        echo '</div>';

     }
       include  $tpl . 'footer.php';

   }else{
       //  echo 'You are Not authorized to view this page';
        header('location: index.php');
        exit();
    }

    ob_end_flush();

?>