<?php
    session_start();
    $pageTitle = 'Create New Ad';
    include 'init.php';
    if (isset($_SESSION['user']) ) {


?>
<h1 class="text-center">Create New Ad</h1>

<div class="create-ad block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">Create New Ad</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">

                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form-horizontal" method="POST">
                    <!-- Start Name Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-2 control-label'><?php echo lang('NAME') ?></label>
                        <div class="col-sm-10 col-md-9">
                            <input type="text"
                                class="form-control live-name"
                                name='name'
                                required='required'
                                    placeholder="Name of the Item" />
                        </div>
                    </div>
                    <!-- End Name Field -->

                    <!-- Start Description Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-2 control-label'><?php echo lang('DESCRIPTION') ?></label>
                        <div class="col-sm-10 col-md-9">
                            <input type="text"
                                class="form-control live-desc"
                                name='description'
                                required='required'
                                placeholder="Description of the Item" />
                        </div>
                    </div>
                    <!-- End Description Field -->

                    <!-- Start Price Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-2 control-label'><?php echo lang('PRICE') ?></label>
                        <div class="col-sm-10 col-md-9">
                            <input type="text"
                                class="form-control live-price"
                                name='price'
                                required='required'
                                placeholder="Price of the Item" />
                        </div>
                    </div>
                    <!-- End Price Field -->

                    <!-- Start Country Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-2 control-label'><?php echo lang('COUNTRY') ?></label>
                        <div class="col-sm-10 col-md-9">
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
                        <div class="col-sm-10 col-md-9">
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

                    <!-- Start Categories Field -->
                    <div class="form-group form-group-lg">
                        <label for="" class='col-sm-2 control-label'><?php echo lang('CATEGORY') ?></label>
                        <div class="col-sm-10 col-md-9">
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
                    <div class="col-md-4">
                        <div class="thumbnail item-box live-preview">
                            <span class="price-tag"> 0 </span>
                            <img class="img-responsive" src="img.png" alt="" />
                            <div class="caption">
                                <h3>Title</h3>
                                <p>Description </p>
                            </div>
                        </div>
                    </div>
                </div>
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