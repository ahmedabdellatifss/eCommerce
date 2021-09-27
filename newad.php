<?php
    session_start();
    $pageTitle = 'Create New Item';
    include 'init.php';
    if (isset($_SESSION['user']) ) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $formErrors = array();

        $name     =  filter_var($_POST['name'], FILTER_SANITIZE_STRING );
        $desc     =  filter_var($_POST['description'] ,FILTER_SANITIZE_STRING );
        $price    =  filter_var($_POST['price'] , FILTER_SANITIZE_NUMBER_INT );
        $country  =  filter_var($_POST['country'], FILTER_SANITIZE_STRING );
        $status   =  filter_var($_POST['status'] , FILTER_SANITIZE_NUMBER_INT );
        $category =  filter_var($_POST['category'] , FILTER_SANITIZE_NUMBER_INT );

        if (strlen($name) < 4 ) {
            $formErrors[] = 'Item Title Must Be At least 4 Characters';
        }
        if (strlen($desc) < 10 ) {
            $formErrors[] = 'Item Description  Must Be At least 10 Characters';
        }
        if (strlen($country) < 2 ) {
            $formErrors[] = 'Item Country Must Be At least 2 Characters';
        }
        if (empty($price) ) {
            $formErrors[] = 'Item price Must Be Not Empty';
        }
        if (empty($status) ) {
            $formErrors[] = 'Item status Must Be Not Empty';
        }
        if (empty ($category) ) {
            $formErrors[] = 'Item category Must Be Not Empty';
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
            'zcat'     => $category,
            'zmember'  => $_SESSION['uid'],
            ));                                

            // Echo Success Message
            if ($stmt) {
                $succesMsg = 'Item Has Been Added';
            }
            
        }

        
    }    


?>
<h1 class="text-center"><?php echo $pageTitle ?></h1>

<div class="create-ad block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading"><?php echo $pageTitle ?></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">

                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form-horizontal main-form" method="POST">
                    <!-- Start Name Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-3 control-label'><?php echo lang('NAME') ?></label>
                        <div class="col-sm-10 col-md-9">
                            <input
                                pattern=".{4,}"
                                title="This Field Require At Least 4 Characters"
                                type="text"
                                class="form-control live"
                                name='name'
                                required='required'
                                placeholder="Name of the Item" 
                                data-class=".live-title"/>
                        </div>
                    </div>
                    <!-- End Name Field -->

                    <!-- Start Description Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-3 control-label'><?php echo lang('DESCRIPTION') ?></label>
                        <div class="col-sm-10 col-md-9">
                            <input
                                pattern=".{10,}"
                                title="This Field Require At Least 10 Characters"
                                type="text"
                                class="form-control live"
                                name='description'
                                required='required'
                                placeholder="Description of the Item" 
                                data-class=".live-desc"/>
                        </div>
                    </div>
                    <!-- End Description Field -->

                    <!-- Start Price Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-3 control-label'><?php echo lang('PRICE') ?></label>
                        <div class="col-sm-10 col-md-9">
                            <input 
                                type="text"
                                class="form-control live"
                                name='price'
                                required='required'
                                placeholder="Price of the Item" 
                                data-class=".live-price"/>
                        </div>
                    </div>
                    <!-- End Price Field -->

                    <!-- Start Country Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-3 control-label'><?php echo lang('COUNTRY') ?></label>
                        <div class="col-sm-10 col-md-9">
                            <input 
                                type="text"
                                class="form-control"
                                name='country'
                                required='required'
                                placeholder="Country of Made" />
                        </div>
                    </div>
                    <!-- End Country Field -->

                    <!-- Start Status Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-3 control-label'><?php echo lang('STATUS') ?></label>
                        <div class="col-sm-10 col-md-9">
                            <select name="status" required>
                                <option value="">...</option>
                                <option value="1">New</option>
                                <option value="2">Like New</option>
                                <option value="3">Used</option>
                                <option value="4">Old</option>
                            </select>
                        </div>
                    </div>
                    <!-- End Status Field -->

                    <!-- Start Categories Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-3 control-label'><?php echo lang('CATEGORY') ?></label>
                        <div class="col-sm-10 col-md-9">
                            <select name="category" required>
                                <option value="">...</option>
                                <?php 
                                    $cats = getAllFrom( '*' , 'categories' , '' , '','ID'); // #113
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
                        <div class="col-sm-offset-3 col-sm-9">
                            <input 
                                type="submit"
                                class="btn btn-primary btn-sm"
                                value="<?php echo lang('ADD_BUTTON') ?>" />
                        </div>
                    </div>
                    <!-- End submit Field -->
                </form>
                    </div>
                    <div class="col-md-4">
                        <div class="thumbnail item-box live-preview">
                            <span class="price-tag"> 
                                $<span class="live-price"></span>
                            </span>
                            <img class="img-responsive" src="img.png" alt="" />
                            <div class="caption">
                                <h3 class="live-title">Title</h3>
                                <p class="live-desc">Description </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Satrt Looping  in Errors -->
                <?php

                    if (! empty($formErrors)) {
                        foreach ($formErrors as $error) {
                            echo '<div class ="alert alert-danger">' . $error . '</div>';
                        }
                    }
                    if (isset($succesMsg)) {
                        echo '<div class="alert alert-success">' . $succesMsg . '</div>';
                    }

                ?>
                <!-- End Looping  in Errors -->
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
?>