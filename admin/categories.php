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

            $sort = 'ASC';

            $sort_array = array('ASC' , 'DESC');
            
            if( isset($_GET['sort']) && in_array($_GET['sort'] , $sort_array)) {

                $sort = $_GET['sort'];

            }

            $stmt = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");

            $stmt->execute();

            $cats = $stmt->fetchAll(); ?>

                <h1 class="text-center">Mange Categories</h1>
                <div class="container categories">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Mange Categories
                            <div class="ordering pull-right">
                                Ordering:
                                <a class="<?php if ($sort == 'ASC') { echo 'active'; } ?>" href="?sort=ASC">ASC</a> | 
                                <a class="<?php if ($sort == 'DESC') { echo 'active'; } ?>" href="?sort=DESC">DESC</a>
                            </div>
                        </div>
                            <div class="panel-body">
                                <?php 
                                    foreach($cats as $cat ){
                                        echo "<div class='cat'>";
                                            echo "<div class='hidden-buttons'>";
                                                echo "<a href='categories.php?do=Edit&catId=" . $cat['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                                                echo "<a href='#' class='btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
                                            echo "</div>";
                                            echo "<h3>" . $cat['Name'] . '</h3>';
                                            echo "<p>"; if($cat['Description'] == '') { echo 'This Is has no description';} else { echo $cat['Description'];}  echo '<br />';
                                                if($cat['Visibility'] == 1 ){ echo '<span class="visibility">Hidden</span>'; }
                                                if($cat['Allow_Comment'] == 1 ){ echo '<span class="commenting">Comment Disabled</span>'; }
                                                if($cat['Allow_Ads'] == 1 ){ echo '<span class="advertises">Ads Disabled</span>'; }
                                        echo "</div>";
                                        echo "<hr />";
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
                                    required='required'  placeholder="Name of the Category" />
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
                                <input type="submit" class="btn btn-primary btn-lg" value="<?php echo lang('ADD_CATEGORIES') ?>" />
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

            // Check if Get Request catId is Numeric & Get the integer value of it
            // Detect the categories Id is number
            $catId = isset($_GET['catId']) && is_numeric($_GET['catId']) ? intval($_GET['catId']) : 0 ;    // intval = intger value
        
            // Select All Data Depend on this ID
    
            $stmt = $con->prepare("SELECT * FROM  categories  WHERE  ID = ? ");
            // Execute Query
            $stmt->execute(array($catId));
            // Fetch The data
            $cat = $stmt->fetch();
            // the Row Count
            $count = $stmt->rowCount();
            // If there is such id disply the form
            if ($count > 0) {  ?>
    
                <h1 class="text-center"><?php echo lang('EDIT_CATEGORIES') ?></h1>
                <div class="container">
                    <form action="?do=Update" class="form-horizontal" method="POST">
                    <input type="hidden" name="catid" value="<?php echo $catId ?>"
                        <!-- Start Name Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('NAME') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" class="form-control" name='name' value="<?php echo $cat['Name'] ?>"
                                    required='required'  placeholder="Name of the Category" />
                            </div>
                        </div>
                        <!-- End Name Field -->

                        <!-- Start Description Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('DESCRIPTION') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" class="form-control" name='description'
                                    placeholder="Describe The Category" value="<?php echo $cat['Description'] ?>" />
                            </div>
                        </div>
                        <!-- End Description Field -->

                        <!-- Start Ordering Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('ORDERING') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" class="form-control" name='ordering' 
                                placeholder="Number To Arrange The Categories" value="<?php echo $cat['Ordering'] ?>"/>
                            </div>
                        </div>
                        <!-- End Ordering Field -->

                        <!-- Start Visible Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('VISIBLE') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <div>
                                    <input id="visible-yes" type="radio" name="visibility" value="0" <?php if($cat['Visibility'] == 0) { echo 'checked'; } ?> />
                                    <label for="visible-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="visible-no" type="radio" name="visibility" value="1"  <?php if($cat['Visibility'] == 1) { echo 'checked'; } ?>/>
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
                                    <input id="com-yes" type="radio" name="commenting" value="0" <?php if($cat['Allow_Comment'] == 0) { echo 'checked'; } ?> />
                                    <label for="com-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="com-no" type="radio" name="commenting" value="1"  <?php if($cat['Allow_Comment'] == 1) { echo 'checked'; } ?>/>
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
                                    <input id="Ads-yes" type="radio" name="ads" value="0"   <?php if($cat['Allow_Ads'] == 0) { echo 'checked'; } ?> />
                                    <label for="Ads-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="Ads-no" type="radio" name="ads" value="1"  <?php if($cat['Allow_Ads'] == 1) { echo 'checked'; } ?> />
                                    <label for="Ads-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- End Ads Field -->

                        <!-- Start submit Field -->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-primary btn-lg" value="<?php echo lang('SAVE_CATEGORY') ?>" />
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

        }elseif ($do == 'Update') {

            echo "<h1 class ='text-center'>Update Category</h1>";
            echo "<div class='container'>";
    
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
                // Get variables from  the Form
    
                $id        = $_POST['catid'];
                $name      = $_POST['name'];
                $desc      = $_POST['description'];
                $order     = $_POST['ordering'];
                
                $visibl   = $_POST['visibility'];
                $comment     = $_POST['commenting'];
                $ads     = $_POST['ads'];

                // Update the database with this info

                $stmt = $con->prepare("UPDATE 
                                            categories 
                                        SET 
                                            Name = ?, 
                                            Description = ?,
                                            Ordering = ?, 
                                            Visibility = ?,
                                            Allow_Comment =?,
                                            Allow_Ads = ?
                                        WHERE 
                                            ID = ?");

                $stmt->execute(array($name , $desc , $order , $visibl , $comment ,$ads , $id));

                // Echo Success Message
                $theMsg = "<div class='alert alert-success'>" .  $stmt->rowCount() . ' - Record Updated </div>';

                redirectHome( $theMsg , 'back' , 4);
    
            }else{
    
                $theMsg = "<div class='alert alert-danger'>Sorry You Cant Browse this page Directly </div>";
    
                redirectHome($theMsg);
    
            }
    
            echo '</div>';
       
    
        }elseif ($do == 'Delete') {


        }     

    include  $tpl . 'footer.php';

    } else {

        header('Location: index.php');

        exit();
    }      
    
    ob_end_flush();

?>