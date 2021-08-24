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

                                        // Episod #68
        $stmt = $con->prepare("SELECT    
                                    items.*,
                                    categories.Name AS category_name,
                                    users.Username 
                                FROM 
                                    items
                                INNER JOIN 
                                    categories 
                                ON 
                                    categories.ID = items.Cat_ID
                                INNER JOIN
                                    users 
                                ON 
                                    users.UserID = items.Member_ID");

       // Execute the Statement

        $stmt->execute();

       // Assign to Variable 
        $items = $stmt->fetchAll();
        
        ?>

        <h1 class="text-center"><?php echo lang('MANAGE_ITEMS') ?></h1>
        <div class="container">
               <div class="table-responsive">
               <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Price</td>
                        <td>Adding Date</td>
                        <td>Category</td>
                        <td>Username</td>
                        <td>Control</td>
                    </tr>

                    <?php 

                        foreach($items as $item) {

                            echo "<tr>";
                                echo "<td>" . $item['Item_ID'] . "</td>";
                                echo "<td>" . $item['Name'] . "</td>";
                                echo "<td>" . $item['Description'] . "</td>";   
                                echo "<td>" . $item['Price'] . "</td>";
                                echo "<td>" . $item['Add_Date'] . "</td>";
                                echo "<td>" . $item['category_name'] . "</td>";
                                echo "<td>" . $item['Username'] . "</td>";
                                echo "<td> 
                                        <a href='items.php?do=Edit&itemid=" . $item['Item_ID'] ."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a> 
                                        <a href='items.php?do=Delete&itemid=" . $item['Item_ID'] ."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a> "; 
                                        if ($item['Approve'] == 0) {
                                            echo "<a 
                                                href='items.php?do=Approve&itemid=" . $item['Item_ID'] ."' 
                                                class='btn btn-info activate'>
                                                <i class='fa fa-check'></i>Approve </a> ";
                                            
                                        }                                      
                                echo  "</td>";
                                
                            echo "</tr>";
                        }

                    ?>

               </table>
               </div>
               <a href="items.php?do=Add" class="btn btn-sm btn-primary"> <i class="fa fa-plus" ></i> New Item</a>
        </div>
    <?php  

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
                                required='required'
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
                                required='required'
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
                                required='required'
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
                                required='required'
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

                    <!-- Start Members Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-2 control-label'><?php echo lang('MEMBER') ?></label>
                        <div class="col-sm-10 col-md-6">
                            <select name="member">
                                <option value="0">...</option>
                                <?php 

                                    $stmt = $con->prepare("SELECT * FROM users");
                                    $stmt->execute();
                                    $users = $stmt->fetchAll();
                                    foreach ($users as $user) {
                                    
                                        echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
                                    
                                    }

                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Status Field -->

                    <!-- Start Categories Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-2 control-label'><?php echo lang('CATEGORY') ?></label>
                        <div class="col-sm-10 col-md-6">
                            <select name="category">
                                <option value="0">...</option>
                                <?php 

                                    $stmt2 = $con->prepare("SELECT * FROM categories");
                                    $stmt2->execute();
                                    $cats = $stmt2->fetchAll();
                                    foreach ($cats as $cat) {
                                    
                                        echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
                                    
                                    }

                                ?>
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
            $member   = $_POST['member'];
            $cat      = $_POST['category'];

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
            if ( $member == 0 ) {
                $formErrors[] = 'You Must Be Choose The Status <strorng>Member</strong>';
            }
            if ( $cat == 0 ) {
                $formErrors[] = 'You Must Be Choose The Status <strorng>Category</strong>';
            }
        
            // Loop INTO Errors Array And Echo it 
            foreach($formErrors as $error){
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }

            // Check if ther's no error proceed the upadate operation 
            if (empty($formErrors)) {

                    // Insert Items Info in  the database 

                    $stmt = $con->prepare("INSERT INTO 
                    items( Name , Description , Price ,  Country_Made , Status , Add_Date , Cat_ID , Member_ID ) 
                    VALUES(:zname   , :zdesc ,    :zprice , :zcountry , :zstatus ,now() , :zcat , :zmember )"); // this values to send to database
                                                                                            // now() Not need to bind becuose it is by default in mysql 
                    $stmt->execute(array(
                    // Key  => value
                    'zname'    => $name,
                    'zdesc'    => $desc,
                    'zprice'   => $price,
                    'zcountry' => $country,
                    'zstatus'  => $status,
                    'zcat'     => $cat,
                    'zmember'  => $member,
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

              // Check if Get Request item is Numeric & Get the integer value of it
            // Detect the item Id is number
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;    // intval = intger value
        
        // Select All Data Depend on this ID

        $stmt = $con->prepare("SELECT * FROM  items  WHERE  item_ID = ? "); 

        // Execute Query
        $stmt->execute(array($itemid));
        // Fetch The data
        $item = $stmt->fetch();
        // the Row Count
        $count = $stmt->rowCount();
        // If there is such id disply the form
        if ($count > 0) {  ?>

    <h1 class="text-center"><?php echo lang('EDIT_ITEM') ?></h1>
            <div class="container">
            <form class="form-horizontal" action="?do=Update" method="POST">
                <input type="hidden" name="itemid" value="<?php echo $itemid ?>"> <!-- to send the value of itemid without show it in form-->
                    <!-- Start Name Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-2 control-label'><?php echo lang('NAME') ?></label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text"
                                class="form-control"
                                name='name'
                                required='required'
                                placeholder="Name of the Item"
                                value ="<?php echo $item['Name']?>" />
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
                                required='required'
                                placeholder="Description of the Item" 
                                value ="<?php echo $item['Description']?>"/>
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
                                required='required'
                                placeholder="Price of the Item" 
                                value ="<?php echo $item['Price']?>"/>
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
                                required='required'
                                placeholder="Country of Made" 
                                value ="<?php echo $item['Country_Made']?>"/>
                        </div>
                    </div>
                    <!-- End Country Field -->

                    <!-- Start Status Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-2 control-label'><?php echo lang('STATUS') ?></label>
                        <div class="col-sm-10 col-md-6">
                            <select name="status">
                                <option value="1" <?php if($item['Status'] == 1) { echo 'selected'; }?>>New</option>
                                <option value="2" <?php if($item['Status'] == 2) { echo 'selected'; }?>>Like New</option>
                                <option value="3" <?php if($item['Status'] == 3) { echo 'selected'; }?>>Used</option>
                                <option value="4" <?php if($item['Status'] == 4) { echo 'selected'; }?>>Old</option>
                            </select>
                        </div>
                    </div>
                    <!-- End Status Field -->

                    <!-- Start Members Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-2 control-label'><?php echo lang('MEMBER') ?></label>
                        <div class="col-sm-10 col-md-6">
                            <select name="member">
                                <?php 

                                    $stmt = $con->prepare("SELECT * FROM users");
                                    $stmt->execute();
                                    $users = $stmt->fetchAll();
                                    foreach ($users as $user) {
                                    
                                        echo "<option value='" . $user['UserID'] . "'";  
                                        if($item['Member_ID'] == $user['UserID']) { echo 'selected'; } 
                                        echo ">" . $user['Username'] . "</option>";
                                    
                                    }

                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Status Field -->

                    <!-- Start Categories Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-2 control-label'><?php echo lang('CATEGORY') ?></label>
                        <div class="col-sm-10 col-md-6">
                            <select name="category">
                                <?php 

                                    $stmt2 = $con->prepare("SELECT * FROM categories");
                                    $stmt2->execute();
                                    $cats = $stmt2->fetchAll();
                                    foreach ($cats as $cat) {
                                    
                                        echo "<option value='" . $cat['ID'] . "'";
                                        if($item['Cat_ID'] == $cat['ID']) { echo 'selected'; } 
                                        echo ">" . $cat['Name'] . "</option>";
                                    
                                    }

                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Status Field -->

                    <!-- Start submit Field -->
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit"
                                class="btn btn-primary btn-sm"
                                value="<?php echo lang('SAVE_ITEM') ?>" />
                        </div>
                    </div>
                    <!-- End submit Field -->
                </form>


                <?php 
                $stmt = $con->prepare("SELECT
                                    comments.* , users.Username AS Member
                                FROM 
                                    comments
                                INNER JOIN 
                                    users
                                ON 
                                    users.UserID = comments.user_id 
                                WHERE 
                                    item_id = ? ");
                $stmt->execute(array($itemid));

                // Assign to Variable 
                $rows = $stmt->fetchAll();

                if (! empty($row)){
                
                    ?>
                    <h1 class="text-center">Manage [ <?php echo $item['Name']?> ] Comments</h1>
                        <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                                <tr>
                                    <td>Comment</td>
                                    <td>User Name</td>
                                    <td>ADD Date</td>
                                    <td>Control</td>
                                </tr>

                    <?php 

                    foreach($rows as $row) {

                        echo "<tr>";
                            echo "<td>" . $row['comment'] . "</td>";
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

        <?php }   ?>

        </div>    
        
        <?php

            // If There's No such Id Show Erro Message

            } else {

                $theMsg = 'Theres No Such ID';
                redirectHome($theMsg);

            }

        } elseif ($do == 'Update') {

            echo "<h1 class='text-center'>Update Item</h1>";
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				// Get Variables From The Form

                $id        = $_POST['itemid'];
                $name      = $_POST['name'];
                $desc      = $_POST['description'];
                $price     = $_POST['price'];
                $country   = $_POST['country'];
                $status    = $_POST['status'];
                $cat       = $_POST['category'];
                $member    = $_POST['member'];



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
                if ( $member == 0 ) {
                    $formErrors[] = 'You Must Be Choose The Status <strorng>Member</strong>';
                }
                if ( $cat == 0 ) {
                    $formErrors[] = 'You Must Be Choose The Status <strorng>Category</strong>';
                }

                // Loop INTO Errors Array And Echo it 
                foreach($formErrors as $error){
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }

                // Check if ther's no error proceed the upadate operation 
                if (empty($formErrors)) {

                    // Update the database with this info

                    $stmt = $con->prepare("UPDATE
                                                items 
                                            SET 
                                                Name = ?,
                                                Description = ?,
                                                Price = ?,
                                                Country_Made = ?,
                                                Status = ?,
                                                Cat_ID = ?,
                                                Member_ID = ?
                                            WHERE 
                                                Item_ID = ?");

                    $stmt->execute(array($name , $desc , $price , $country , $status , $cat , $member ,  $id));

                    // Echo Success Message
                    $theMsg = "<div class='alert alert-success'>" .  $stmt->rowCount() . ' - Record Updated </div>';

                    redirectHome( $theMsg , 'back' , 4);

                }

            }else{

                $theMsg = "<div class='alert alert-danger'>Sorry You Cant Browse this page Directly </div>";

                redirectHome($theMsg , 'back');

            }

            echo '</div>';


    
    
        }elseif ($do == 'Delete') {

            echo "<h1 class='text-center'>Delete Item</h1>";
			echo "<div class='container'>";

				// Check If Get Request Item ID Is Numeric & Get The Integer Value Of It

				$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('Item_ID', 'items', $itemid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zid");

					$stmt->bindParam(":zid", $itemid);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

					redirectHome($theMsg);

				}

			echo '</div>';

        }elseif ($do == 'Approve' ) {

            echo "<h1 class ='text-center'>Approve Item</h1>";
            echo "<div class='container'>";
    
                // Check if Get Request itemid is Numeric & Get the integer value of it
                // Detect the Item Id is number
                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;    // intval = intger value dh rkom el3do
            
                // Select All Data Depend on this ID
                                                        
                $check = checkItem('Item_ID' , 'items' , $itemid);  // this is function from function.php file
    
                // If there is such id disply the form
                if ($check > 0) {  
    
                    $stmt = $con->prepare('UPDATE items SET Approve =1  WHERE Item_ID = ?');
    
                    $stmt->execute(array($itemid));
    
                    // Echo Success Message
                    $theMsg = "<div class='alert alert-success'>" .  $stmt->rowCount() . ' - Record Activated </div>';
    
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