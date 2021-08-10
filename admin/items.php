<?php 

    /*
    ===========================================================================
    == Items Page
    ===========================================================================
    */

    ob_start();  // Output Buffering Start #47

    session_start();

    $pageTitle = 'Items';
    
    if(isset($_SESSION['Username'])) {
      
        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : $do = 'Manage' ;

        // Start Mange Page 

        if ($do == 'Manage') {  // Mange page 

            echo 'Wellcome items page';

        }elseif ($do == 'Add') { ?>

            <h1 class="text-center"><?php echo lang('ADD_ITEM') ?></h1>
            <div class="container">
                <form action="?do=Insert" class="form-horizontal" method="POST">
                    <!-- Start Name Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-2 control-label'><?php echo lang('NAME') ?></label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text"
                                class="form-control"
                                name='name'
 
                                    placeholder="Name of the Item" />
                        </div>
                    </div>
                    <!-- End Name Field -->

                    <!-- Start Description Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-2 control-label'><?php echo lang('DESCRIPTION') ?></label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text"
                                class="form-control"
                                name='description'
 
                                placeholder="Description of the Item" />
                        </div>
                    </div>
                    <!-- End Description Field -->

                    <!-- Start Price Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-2 control-label'><?php echo lang('PRICE') ?></label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text"
                                class="form-control"
                                name='price'

                                placeholder="Price of the Item" />
                        </div>
                    </div>
                    <!-- End Price Field -->

                    <!-- Start Country Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-2 control-label'><?php echo lang('COUNTRY') ?></label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text"
                                class="form-control"
                                name='country'

                                placeholder="Country of Made" />
                        </div>
                    </div>
                    <!-- End Country Field -->

                    <!-- Start Status Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-2 control-label'><?php echo lang('STATUS') ?></label>
                        <div class="col-sm-10 col-md-6">
                            <select name="status">
                                <option value="0">...</option>
                                <option value="1">New</option>
                                <option value="2">Like New</option>
                                <option value="3">Used</option>
                                <option value="4">Old</option>
                            </select>
                        </div>
                    </div>
                    <!-- End Status Field -->

                    <!-- Start submit Field -->
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit"
                                class="btn btn-primary btn-sm"
                                value="<?php echo lang('ADD_BUTTON') ?>" />
                        </div>
                    </div>
                    <!-- End submit Field -->
                </form>
            </div>

<?php 

    }elseif ($do == 'Insert') {

           // Insert Member Page 
            // the data will come from Add page to insert page to insert it in the database

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo "<h1 class ='text-center'>Insert Member</h1>";
            echo "<div class='container'>";

            // Get variables from  the Form

            $name     = $_POST['name'];
            $desc     = $_POST['description'];
            $price    = $_POST['price'];
            $country  = $_POST['country'];
            $status   = $_POST['status'];

            // Validate The Form 

            $formErrors = array();

            if (empty($name)) {
                $formErrors[] = 'Name can\'t be  <strorng>Empty</strong>';
            }
            if (empty($desc)) {
                $formErrors[] = 'Description can\'t be  <strorng>Empty</strong>';
            }

            if (empty($price)) {
                $formErrors[] = 'Price can\'t be  <strorng>Empty</strong>';
            }
            if (empty($country)) {
                $formErrors[] = 'Country can\'t be  <strorng>Empty</strong>';
            }
            if ( $status == 0 ) {
                $formErrors[] = 'You Must Be Choose The Status <strorng>Status</strong>';
            }
        
            // Loop INTO Errors Array And Echo it 
            foreach($formErrors as $error){
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }

            // Check if ther's no error proceed the upadate operation 
            if (empty($formErrors)) {

                    // Insert Items Info in  the database 

                    $stmt = $con->prepare("INSERT INTO 
                    items( Name , Description , Price ,  Country_Made , Status , Add_Date ) 
                    VALUES(:zname   , :zdesc ,    :zprice , :zcountry , :zstatus ,now()) "); // this values to send to database
                                                                                            // now() Not need to bind becuose it is by default in mysql 
                    $stmt->execute(array(
                    // Key  => value
                    'zname'    => $name,
                    'zdesc'    => $desc,
                    'zprice'   => $price,
                    'zcountry' => $country,
                    'zstatus'  => $status,
                    ));                                

                    // Echo Success Message

                    $theMsg = "<div class='alert alert-success'>" .  $stmt->rowCount() . ' - Record Inserted </div>';

                    redirectHome($theMsg , 'back');
            }

        }else{

            

            $errorMsgIns = '<div class = "alert alert-danger">Sorry You Cant Browse this page Directly</div>';

            redirectHome( $errorMsgIns); // This function from function.php

        }

    echo '</div>';
    

        }elseif ($do == 'Edit') {


        }elseif ($do == 'Update') {

    
        }elseif ($do == 'Delete') {


        }elseif ($do == 'Approve' ) {


        }

    include  $tpl . 'footer.php';

    } else {

        header('Location: index.php');

        exit();
    }      
    
    ob_end_flush();

?>