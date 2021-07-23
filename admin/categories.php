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

            echo 'Wellcome';

        }elseif ($do == 'Add') { ?>

                <h1 class="text-center"><?php echo lang('ADD_CATEGORIES') ?></h1>
                <div class="container">
                    <form action="?do=Insert" class="form-horizontal" method="POST">
                        <!-- Start Name Field -->
                        <div class="form-group form-group-lg">
                            <label for="" class='col-sm-2 control-label'><?php echo lang('NAME') ?></label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" class="form-control" name='username' autocomplete="off"
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
                                    <input id="com-yes" type="radio" name="visibility" value="0" checked />
                                    <label for="com-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="com-no" type="radio" name="visibility" value="1"  />
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