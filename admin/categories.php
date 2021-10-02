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

            $sort = 'asc';

            $sort_array = array('asc' , 'desc');
            
            if( isset($_GET['sort']) && in_array($_GET['sort'] , $sort_array)) {

                $sort = $_GET['sort'];

            }

            $stmt = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY Ordering $sort");

            $stmt->execute();

            $cats = $stmt->fetchAll(); 

            if (!empty($cats)) {

            ?>

                <h1 class="text-center">Mange Categories</h1>
                <div class="container categories">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-edit"></i>Mange Categories
                            <div class="option pull-right">
                            <i class ="fa fa-sort"></i>Ordering: [
                                <a class="<?php if ($sort == 'asc') { echo 'active'; } ?>" href="?sort=asc">Asc</a> | 
                                <a class="<?php if ($sort == 'desc') { echo 'active'; } ?>" href="?sort=desc">Desc</a> ]
                                <i class ="fa fa-eye"></i>View: [
                                <span class="active" data-view="full">Full</span> |
                                <span data-view="classic">Classic</span> ]
                            </div>
                        </div>
                            <div class="panel-body">
                                <?php 
                                    foreach($cats as $cat ){
                                        echo "<div class='cat'>";
                                            echo "<div class='hidden-buttons'>";
                                                echo "<a href='categories.php?do=Edit&catId=" . $cat['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                                                echo "<a href='categories.php?do=Delete&catId=" . $cat['ID'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
                                            echo "</div>";
                                            echo "<h3>" . $cat['Name'] . '</h3>';
                                            echo "<div class='full-view'>";
                                                echo "<p>"; if($cat['Description'] == '') { echo 'This Is has no description';} else { echo $cat['Description'];}  echo '<br />';
                                                if($cat['Visibility'] == 1 ){ echo '<span class="visibility"><i class ="fa fa-eye"></i> Hidden</span>'; }
                                                if($cat['Allow_Comment'] == 1 ){ echo '<span class="commenting"><i class ="fa fa-close"></i>Comment Disabled</span>'; }
                                                if($cat['Allow_Ads'] == 1 ){ echo '<span class="advertises"><i class ="fa fa-close"></i>Ads Disabled</span>'; }
                                            echo "</div>";    

                                        // Get Chiled Categories
                                        $childCats = getAllFrom("*" , "categories" ,"where parent = {$cat['ID']}", "" , "ID" , "ASC");
                                            if (! empty($childCats)) {
                                                echo "<h4 class='child-head'>Child Categories</h4>";
                                                echo "<ul class='list-unstyled child-cats'>";
                                            foreach ($childCats as $c) {
                                                echo "<li class='child-link'>
                                                    <a href='categories.php?do=Edit&catId=" . $c['ID'] . "'>" . $c['Name'] . "</a>
                                                    <a href='categories.php?do=Delete&catid=" . $c['ID'] . "' class='show-delete confirm'> Delete</a>
                                                </li>";
                                            }
                                            echo "</ul>";
                                            
                                        }
                                        echo "</div>";
                                        echo "<hr />";
                                    }
                                ?>
                            </div>
                    </div>
                    <a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus" ></i>Add New Category</a>
                </div>
                <?php }else{
                    echo '<div class="container">';
                        echo '<div class="nice-message">There\'s No Categories To Show</div>';
                        echo '<a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus" ></i>Add New Category</a>';
                    echo '</div>';
            } ?>                        
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

                        <!--Start Category Type  -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'>Parent?</label>
                            <div class="col-sm-10 col-md-6">
                                <select name= "parent">
                                    <option value="0">None</option>
                                    <?php
                                        $allCats = getAllFrom("*" , "categories" , "WHERE parent = 0" , "" , "ID" , "ASC");
                                        foreach($allCats as $cat ) {
                                            echo "<option value=' ". $cat['ID'] ." '>" . $cat['Name'] . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!--End Category Type  -->


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
                    $parent    = $_POST['parent'];
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

                                        categories( Name , Description , parent ,  Ordering ,  Visibility , Allow_Comment , Allow_Ads ) 

                        VALUES(:zname   , :zdesc , :parent , :zorder , :zvisible , :zcomment , :zads) "); // this values to send to database

                        $stmt->execute(array(
                        // Key  => value
                        'zname'   => $name,
                        'zdesc'   => $desc,
                        'parent'  => $parent,
                        'zorder'    => $order,
                        'zvisible' => $visible,
                        'zcomment' => $comment,
                        'zads'    => $ads,
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

                        <!--Start Category Type  -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'>Parent?</label>
                            <div class="col-sm-10 col-md-6">
                                <select name= "parent">
                                    <option value="0">None</option>
                                    <?php
                                        $allCats = getAllFrom("*" , "categories" , "WHERE parent = 0" , "" , "ID" , "ASC");
                                        foreach($allCats as $c ) {
                                            echo "<option value=' ". $c['ID'] ."'";
                                            if ($cat['parent'] == $c['ID']) { echo 'selected';}
                                            echo ">" . $c['Name'] . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!--End Category Type  -->

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
                $parent     = $_POST['parent'];
                
                $visibl    = $_POST['visibility'];
                $comment   = $_POST['commenting'];
                $ads       = $_POST['ads'];

                // Update the database with this info

                $stmt = $con->prepare("UPDATE 
                                            categories 
                                        SET 
                                            Name = ?, 
                                            Description = ?,
                                            Ordering = ?, 
                                            parent = ?, 
                                            Visibility = ?,
                                            Allow_Comment =?,
                                            Allow_Ads = ?
                                        WHERE 
                                            ID = ?");

                $stmt->execute(array($name , $desc , $order , $parent , $visibl , $comment ,$ads , $id));

                // Echo Success Message
                $theMsg = "<div class='alert alert-success'>" .  $stmt->rowCount() . ' - Record Updated </div>';

                redirectHome( $theMsg , 'back' , 4);
    
            }else{
    
                $theMsg = "<div class='alert alert-danger'>Sorry You Cant Browse this page Directly </div>";
    
                redirectHome($theMsg);
    
            }
    
            echo '</div>';

    
        }elseif ($do == 'Delete') {
            echo "<h1 class ='text-center'>Delete Categories</h1>";
            echo "<div class='container'>";

                // Check if Get Request catid is Numeric & Get the integer value of it
                // Detect the user Id is number
                $catid = isset($_GET['catId']) && is_numeric($_GET['catId']) ? intval($_GET['catId']) : 0 ;    // intval = intger value dh rkom el3do
            
                // Select All Data Depend on this ID
                                                        
                $check = checkItem('ID' , 'categories' , $catid);  // this is function from function.php file

                // If there is such id disply the form
                if ($check > 0) {  

                    $stmt = $con->prepare('DELETE FROM categories WHERE ID = :Zid');

                    $stmt->bindParam(":Zid" , $catid);

                    $stmt->execute();

                    // Echo Success Message
                    $theMsg = "<div class='alert alert-success'>" .  $stmt->rowCount() . ' - Record Deleted </div>';

                    redirectHome($theMsg , 'back');


                }else{
    
                    $theMsg = "<div class='alert alert-danger'>This Id is not Exist </div>";

                    redirectHome($theMsg);

                }   

            echo '</div>';
    

        }     

    include  $tpl . 'footer.php';

    } else {

        header('Location: index.php');

        exit();
    }      
    
    ob_end_flush();

?>