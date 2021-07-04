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

       if ($do == 'Mange') {

        // Mange page

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
                                <input type="text" class="form-control" name='username' value = "<?php echo $row['Username'] ?>" autocomplete="off"/>
                            </div>
                        </div>
                        <!-- End UserName Field -->

                        <!-- Start Password Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('PASSWORD') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <input type="hidden"  name='oldpassword' value="<?php echo $row['Password'] ?>" />
                                <input type="password" class="form-control" name='newpassword' autocomplete="new-pas"/>
                            </div>
                        </div>
                        <!-- End Password Field -->

                        <!-- Start Email Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('EMAIL') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <input type="email" class="form-control" name='email' value = "<?php echo $row['Email'] ?>" />
                            </div>
                        </div>
                        <!-- End Email Field -->

                        <!-- Start Full Name Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('FULL_NAME') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" class="form-control" name='full' value = "<?php echo $row['FullName'] ?>"/>
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
                echo 'Theres No Such ID';
            }
     }elseif($do == 'Update'){  // Update Page

        echo "<h1 class ='text-center'>Update Member</h1>";

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
                $formErrors[] = 'Username cant be less than 4 characters';
            }
            if (strlen($user) > 20 ) {
                $formErrors[] = 'Username cant be More than 20 characters';
            }

            if (empty($user)) {
                $formErrors[] = 'UserName Cant be Empty' ;
            }
            if (empty($name)) {
                $formErrors[] = 'Full Name  Cant be Empty' ;
            }
            if (empty($email)) {
                $formErrors[] = 'Email Cant be Empty' ;
            }

            foreach($formErrors as $error){
                echo $error . '<br />' ;
            }


          // Update the database with this info

          $stmt = $con->prepare("UPDATE users SET Username = ? , Email = ? , FullName = ? , Password = ?WHERE UserID = ?");
          $stmt->execute(array($user , $email , $name , $pass , $id));

          // Echo Success Message

          echo $stmt->rowCount() . 'Record Updated';

        }else{
            echo 'Sorry You Cant Browse this page Directly';
        }


     }
       include  $tpl . 'footer.php';

   }else{
       //  echo 'You are Not authorized to view this page';
        header('location: index.php');
        exit();
    }