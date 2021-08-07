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
                                name='price'
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