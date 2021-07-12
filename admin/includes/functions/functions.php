<?php 
   
   /**
    * Title Function That Echo The Page Title In case the page  
    * Has the variable $pageTitle And Echo Defualt title for other pages
    */

    function getTitle(){

        global $pageTitle ;

        if (isset($pageTitle))  {

            echo $pageTitle;

        }else{

            echo 'Default';
        }
    }

    /**
     *  Redirect Function [this Function Accept Parameters]
     * the parameter is $errorMsg = echo the erro message 
     *                  $seconds  = seconds before redirecting
     */

    function redirectHome($errorMsg , $seconds = 3 ){
        
        echo "<div class='container'>";

        echo "<div class='alert alert-danger'> $errorMsg </div>";

        echo "<div class='alert alert-info'>You will be redirected to HomePage after :  $seconds  Seconds. </div>";

        echo "</div>";

        header("refresh: $seconds;url=index.php");

        exit();
     }