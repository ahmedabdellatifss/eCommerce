<?php 

    /*
    ===========================================================================
    == Categories Page
    ===========================================================================
    */

    ob_start();  // Output Buffering Start #47

    session_start();

    $pageTitle = 'Categories';
    
    if(isset($_SESSION['Username'])) {
      
        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : $do = 'Manage' ;

        // Start Mange Page 

        if ($do == 'Manage') {  // Mange page 

            $stmt = $con->prepare("SELECT * FROM categories");

            $stmt->execute();

            $cats = $stmt->fetchAll(); ?>

                <h1 class="text-center">Mange Categories</h1>
                <div class="container">
                    <div class="panel panel-default">
                        <div class="panel-heading">Mange Categories</div>
                            <div class="panel-body">
                                <?php 
                                    foreach($cats as $cat ){
                                        echo $cat['Name'] . '<br />';
                                        echo $cat['Description'] . '<br />';
                                        echo 'Ordering Is: ' . $cat['Ordering'] . '<br />';
                                        echo 'Visibility IS: ' . $cat['Visibility'] . '<br />';
                                        echo 'Allow Comment Is: ' . $cat['Allow_Comment'] . '<br />';
                                        echo 'Allow Ads Is: ' . $cat['Allow_Ads'] . '<br />';
                                    }
                                ?>
                            </div>
                    </div>
                </div>

            <?php

        }elseif ($do == 'Add') { ?>

                <h1 class="text-center"><?php echo lang('ADD_CATEGORIES') ?></h1>
                <div class="container">
                    <form action="?do=Insert" class="form-horizontal" method="POST">
                        <!-- Start Name Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('NAME') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" class="form-control" name='name' autocomplete="off"
                                 required='required'  placeholder="Name of the Category"/>
                            </div>
                        </div>
                        <!-- End Name Field -->

                        <!-- Start Description Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('DESCRIPTION') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" class="form-control" name='description'  placeholder="Describe The Category"/>
                            </div>
                        </div>
                        <!-- End Description Field -->

                        <!-- Start Ordering Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('ORDERING') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" class="form-control" name='ordering' placeholder="Number To Arrange The Categories"/>
                            </div>
                        </div>
                        <!-- End Ordering Field -->

                        <!-- Start Visible Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('VISIBLE') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input id="visible-yes" type="radio" name="visibility" value="0" checked />
                                    <label for="visible-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="visible-no" type="radio" name="visibility" value="1"  />
                                    <label for="visible-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- End Visible Field -->

                        <!-- Start Commenting Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('COMMENTING') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input id="com-yes" type="radio" name="commenting" value="0" checked />
                                    <label for="com-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="com-no" type="radio" name="commenting" value="1"  />
                                    <label for="com-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- End Commenting Field -->

                        <!-- Start Ads Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('ADS') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input id="Ads-yes" type="radio" name="ads" value="0" checked />
                                    <label for="Ads-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="Ads-no" type="radio" name="ads" value="1"  />
                                    <label for="Ads-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- End Ads Field -->

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
        }elseif ($do == 'Insert') {


                if($_SERVER['REQUEST_METHOD'] == 'POST') {

                    echo "<h1 class ='text-center'>Insert Category</h1>";
                    echo "<div class='container'>";

                    // Get variables from  the Form

                    $name      = $_POST['name'];
                    $desc      = $_POST['description'];
                    $order     = $_POST['ordering'];
                    $visible   = $_POST['visibility'];
                    $comment   = $_POST['commenting'];
                    $ads       = $_POST['ads'];

                    // Check if Category Exist in Database

                    $check = checkItem("Name" , "categories" , $name);

                    if ($check == 1){

                        $theMsg = '<div class="alert alert-danger">sorry this categories is exist</div>';

                        redirectHome($theMsg , 'back');

                    }else{

                        // Insert categories Info in  the database 

                        $stmt = $con->prepare("INSERT INTO 

                                        categories( Name , Description , Ordering ,  Visibility , Allow_Comment , Allow_Ads ) 

                        VALUES(:zname   , :zdesc , :zorder , :zvisible , :zcomment , :zads) "); // this values to send to database

                        $stmt->execute(array(
                        // Key  => value
                        'zname' => $name,
                        'zdesc' => $desc,
                        'zorder' => $order,
                        'zvisible' => $visible,
                        'zcomment' => $comment,
                        'zads' => $ads,
                        ));                                

                        // Echo Success Message

                        $theMsg = "<div class='alert alert-success'>" .  $stmt->rowCount() . ' - Record Inserted </div>';

                        redirectHome($theMsg , 'back');

                    }

                }else{

                    $errorMsgIns = '<div class = "alert alert-danger">Sorry You Cant Browse this page Directly</div>';

                    redirectHome( $errorMsgIns , 'back'); // This function from function.php
                                                // 'back' mean I'm not left the $url empty this means he will redirect to the last page as function said

                }

            echo '</div>';
                

        }elseif ($do == 'Edit') {


        }elseif ($do == 'Update') {

    
        }elseif ($do == 'Delete') {


        }     

    include  $tpl . 'footer.php';

    } else {

        header('Location: index.php');

        exit();
    }      
    
    ob_end_flush();

?>