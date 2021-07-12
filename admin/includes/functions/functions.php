<?php 
   
   /**
    *  Title Function v1.0
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
     * Home Redirect Function   V1.0
     * this Function Accept Parameters
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

     /**
      ** Check items Function  V1.0
      ** Function to check item in database  [ Function Accept Parameters ]
      ** $select = the item to Select  [ Example: user, or item, or category ]
      ** $from = The table to select from [ Example: users , items , categories ]
      ** $value = The value of select or the item which I select based on [ Example: Osama , box , electronics]
      */

      function checkItem($select , $from , $value){

        global $con;

        $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ? "); /** ? = $value */

        $statement->execute(array($value));

        $count = $statement->rowCount();

        return $count;

      }