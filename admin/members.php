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

       }elseif ($do == 'Edit') {  // Edit Page?>

        <h1 class="text-center"><?php echo lang('EDIT_MEMBER') ?></h1>
         
        <div class="container">
            <form action="" class="form-horizontal">
                <!-- Start UserName Field -->
                <div class="form-group form-group-lg">
                    <label for="" class='col-sm-2 control-label'><?php echo lang('USERNAME') ?></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" class="form-control" name='username' autocomplete="off"/>
                    </div>
                </div>
                <!-- End UserName Field -->
                <!-- Start Password Field -->
                <div class="form-group form-group-lg">
                    <label for="" class='col-sm-2 control-label'><?php echo lang('PASSWORD') ?></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="password" class="form-control" name='password' autocomplete="new-pas"/>
                    </div>
                </div>
                <!-- End Password Field -->
                <!-- Start Email Field -->
                <div class="form-group form-group-lg">
                    <label for="" class='col-sm-2 control-label'><?php echo lang('EMAIL') ?></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="email" class="form-control" name='email' />
                    </div>
                </div>
                <!-- End Email Field -->
                <!-- Start Full Name Field -->
                <div class="form-group form-group-lg">
                    <label for="" class='col-sm-2 control-label'><?php echo lang('FULL_NAME') ?></label>
                    <div class="col-sm-10 col-md-4">
                        <input type="text" class="form-control" name='full' />
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
      

      <?php }
       include  $tpl . 'footer.php';

   }else{

       //  echo 'You are Not authorized to view this page';
        header('location: index.php');
        exit();
    }