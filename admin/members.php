<?php 

    /*
    ===========================================================================
    == Mange Members Page
    == You can Add | Edit | Delete Members From Here
    ===========================================================================
    */

    session_start();

    $pageTitle = 'Members';
    
    if(isset($_SESSION['Username'])) {
      
       include 'init.php';

       $do = isset($_GET['do']) ? $_GET['do'] : $do = 'Manage' ;

       // Start Mange Page 

       if ($do == 'Manage') {  // Mange page 


       // Select All Users Except Admin
       $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1");
       $stmt->execute();

       // Assign to Variable 
       $rows = $stmt->fetchAll();
       
       ?>

        <h1 class="text-center"><?php echo lang('Manage_Member') ?></h1>
        <div class="container">
               <div class="table-responsive">
               <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Full Name</td>
                        <td>Registerd Date</td>
                        <td>Control</td>
                    </tr>

                    <?php 

                        foreach($rows as $row) {

                            echo "<tr>";
                                echo "<td>" . $row['UserID'] . "</td>";
                                echo "<td>" . $row['Username'] . "</td>";
                                echo "<td>" . $row['Email'] . "</td>";   
                                echo "<td>" . $row['FullName'] . "</td>";
                                echo "<td>" . $row['Date'] . "</td>";
                                echo "<td> 
                                        <a href='members.php?do=Edit&userid=" . $row['UserID'] ."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a> 
                                        <a href='members.php?do=Delete&userid=" . $row['UserID'] ."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a> 
                                    </td>";
                                
                            echo "</tr>";
                        }

                    ?>

               </table>
               </div>
               <a href="members.php?do=Add" class="btn btn-primary"> <i class="fa fa-plus" ></i> New Member</a>
        </div>

  <?php }elseif($do == 'Add'){  // Add Members Page ?>

           <h1 class="text-center"><?php echo lang('ADD_MEMBER') ?></h1>
                <div class="container">
                    <form action="?do=Insert" class="form-horizontal" method="POST">
                        <!-- Start UserName Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('USERNAME') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" class="form-control" name='username' autocomplete="off" required='required'  placeholder="Username to login into shop"/>
                            </div>
                        </div>
                        <!-- End UserName Field -->

                        <!-- Start Password Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('PASSWORD') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <input type="password" class="password form-control" name='password' autocomplete="new-pas" required='required' placeholder="Password Must be hard & complex"/>
                                <i class='show-pass fa fa-eye fa-2x'></i>
                            </div>
                        </div>
                        <!-- End Password Field -->

                        <!-- Start Email Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('EMAIL') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <input type="email" class="form-control" name='email'  required='required' placeholder="Email must be valid"/>
                            </div>
                        </div>
                        <!-- End Email Field -->

                        <!-- Start Full Name Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('FULL_NAME') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" class="form-control" name='full' required='required'  placeholder="Full Name appear in your profil page"/>
                            </div>
                        </div>
                        <!-- End Full Name Field -->

                        <!-- Start submit Field -->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-primary btn-lg" value="<?php echo lang('ADD_MEMBER') ?>" />
                            </div>
                        </div>
                        <!-- End submit Field -->
                    </form>
                </div>


       <?php 
       
       }elseif ($do == 'Insert'){

        // Insert Member Page 
        // the data will come from Add page to insert page to insert it in the database

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

                echo "<h1 class ='text-center'>Update Member</h1>";
                echo "<div class='container'>";

                // Get variables from  the Form

                $user   = $_POST['username'];
                $pass   = $_POST['password'];
                $email  = $_POST['email'];
                $name   = $_POST['full'];

                $hashPass = sha1($_POST['password']);

                // Validate The Form 

                $formErrors = array();

                if (strlen($user) < 4) {
                    $formErrors[] = 'Username cant be less than <strorng>4 characters</strong>';
                }
                if (strlen($user) > 20 ) {
                    $formErrors[] = 'Username cant be More than <strorng>20 characters</strong>';
                }

                if (empty($user)) {
                    $formErrors[] = 'UserName Cant be <strorng>Empty</strong>' ;
                }
                if (empty($pass)) {
                    $formErrors[] = 'Password Cant be <strorng>Empty</strong>' ;
                }
                if (empty($name)) {
                    $formErrors[] = 'Full Name  Cant be <strorng>Empty</strong>' ;
                }
                if (empty($email)) {
                    $formErrors[] = 'Email Cant be<strorng>Empty</strong>' ;
                }

                // Loop INTO Errors Array And Echo it 
                foreach($formErrors as $error){
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }

                // Check if ther's no error proceed the upadate operation 
                if (empty($formErrors)) {

                    // Check if user Exist in Database

                    $check = checkItem("Username" , "users" , $user);

                    if ($check == 1){

                        $theMsg = '<div class="alert alert-danger">sorry this user is exist</div>';

                        redirectHome($theMsg , 'back');

                    }else{

                        // Insert User Info in  the database 

                        $stmt = $con->prepare("INSERT INTO 
                        users( Username , Password , Email ,  FullName , RegStatus , Date ) 
                        VALUES(:zuser   , :zpass ,    :zmail , :zname , 1 ,now()) "); // this values to send to database
                        $stmt->execute(array(
                        // Key  => value
                        'zuser' => $user,
                        'zpass' => $hashPass,
                        'zmail' => $email,
                        'zname' => $name,
                        ));                                

                        // Echo Success Message

                        $theMsg = "<div class='alert alert-success'>" .  $stmt->rowCount() . ' - Record Inserted </div>';

                        redirectHome($theMsg , 'back');

                    }

                }

            }else{

                

                $errorMsgIns = '<div class = "alert alert-danger">Sorry You Cant Browse this page Directly</div>';

                redirectHome( $errorMsgIns , 'back'); // This function from function.php
                                            // 'back' mean I'm not left the $url empty this means he will redirect to the last page as function said

            }

        echo '</div>';
        
      

    }elseif ($do == 'Edit') {  // Edit Page
            // Check if Get Request userid is Numeric & Get the integer value of it
            // Detect the user Id is number
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;    // intval = intger value
        
        // Select All Data Depend on this ID

        $stmt = $con->prepare("SELECT * FROM  users  WHERE  UserID = ?  LIMIT 1");  // (limit 1) => means, I need one result

        // Execute Query
        $stmt->execute(array($userid));
        // Fetch The data
        $row = $stmt->fetch();
        // the Row Count
        $count = $stmt->rowCount();
        // If there is such id disply the form
        if ($count > 0) {  ?>

                <h1 class="text-center"><?php echo lang('EDIT_MEMBER') ?></h1>
                <div class="container">
                    <form action="?do=Update" class="form-horizontal" method="POST">
                        <input type="hidden" name="userid" value="<?php echo $userid ?>"> <!-- to send the value of userid without show it in form-->
                        <!-- Start UserName Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('USERNAME') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" class="form-control" name='username' value = "<?php echo $row['Username'] ?>" autocomplete="off" required="required"/>
                            </div>
                        </div>
                        <!-- End UserName Field -->

                        <!-- Start Password Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('PASSWORD') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <input type="hidden"  name='oldpassword' value="<?php echo $row['Password'] ?>" />
                                <input type="password" class="form-control" name='newpassword' autocomplete="new-pas" placeholder="Leave Blank if you dont wont to change"/>
                            </div>
                        </div>
                        <!-- End Password Field -->

                        <!-- Start Email Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('EMAIL') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <input type="email" class="form-control" name='email' value = "<?php echo $row['Email'] ?>"  required="required" />
                            </div>
                        </div>
                        <!-- End Email Field -->

                        <!-- Start Full Name Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('FULL_NAME') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" class="form-control" name='full' value = "<?php echo $row['FullName'] ?>"  required="required" />
                            </div>
                        </div>
                        <!-- End Full Name Field -->

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

        echo "<h1 class ='text-center'>Update Member</h1>";
        echo "<div class='container'>";

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Get variables from  the Form

            $id     = $_POST['userid'];
            $user   = $_POST['username'];
            $email  = $_POST['email'];
            $name   = $_POST['full'];

            // Password Trick 
            //condition ? True : False;

            $pass = (empty($_POST['newpassword'])) ?  $_POST['oldpassword'] : sha1($_POST['newpassword']) ;

            // Validate The Form 

            $formErrors = array();

            if (strlen($user) < 4) {
                $formErrors[] = 'Username cant be less than <strorng>4 characters</strong>';
            }
            if (strlen($user) > 20 ) {
                $formErrors[] = 'Username cant be More than <strorng>20 characters</strong>';
            }

            if (empty($user)) {
                $formErrors[] = 'UserName Cant be <strorng>Empty</strong>' ;
            }
            if (empty($name)) {
                $formErrors[] = 'Full Name  Cant be <strorng>Empty</strong>' ;
            }
            if (empty($email)) {
                $formErrors[] = 'Email Cant be<strorng>Empty</strong>' ;
            }

            // Loop INTO Errors Array And Echo it 
            foreach($formErrors as $error){
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }

            // Check if ther's no error proceed the upadate operation 
            if (empty($formErrors)) {

                // Update the database with this info

                $stmt = $con->prepare("UPDATE users SET Username = ? , Email = ? , FullName = ? , Password = ? WHERE UserID = ?");
                $stmt->execute(array($user , $email , $name , $pass , $id));

                // Echo Success Message
                $theMsg = "<div class='alert alert-success'>" .  $stmt->rowCount() . ' - Record Updated </div>';

                redirectHome( $theMsg , 'back' , 4);

            }

        }else{

            $theMsg = "<div class='alert alert-danger'>Sorry You Cant Browse this page Directly </div>";

            redirectHome($theMsg);

        }

        echo '</div>';


     }elseif($do == 'Delete'){ // Delete Member Page
 
            echo "<h1 class ='text-center'>Delete Member</h1>";
            echo "<div class='container'>";

                // Check if Get Request userid is Numeric & Get the integer value of it
                // Detect the user Id is number
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;    // intval = intger value dh rkom el3do
            
                // Select All Data Depend on this ID
                                                        
                $check = checkItem('userid' , 'users' , $userid);  // this is function from function.php file

                // If there is such id disply the form
                if ($check > 0) {  

                    $stmt = $con->prepare('DELETE FROM users WHERE UserID = :Zuserid');

                    $stmt->bindParam(":Zuserid" , $userid);

                    $stmt->execute();

                    // Echo Success Message
                    $theMsg = "<div class='alert alert-success'>" .  $stmt->rowCount() . ' - Record Deleted </div>';

                    redirectHome($theMsg);


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