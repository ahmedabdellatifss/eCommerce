<?php 

    /**
     ** Get All Function v2.0
        ** Function To Get All Records From Any Database Table 
        ** 
        */

    function getAllFrom($field , $table , $where = NULL , $and = NULL , $orderfield , $ordering = 'DESC') {  

        global $con ;


        $getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

        $getAll->execute();

        $all = $getAll->fetchAll();

        return $all;

    }


        /**
         ** Get Categories Function v1.0
         ** Function To Get Categories From Database 
         ** 
         */

        function getCat() {  //#82

            global $con ;

            $getCat = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");

            $getCat->execute();

            $cats = $getCat->fetchAll();

            return $cats;

        }

        /**
         ** Get Advertisement Items Function v2.0
         ** Function To Get  AD Items From Database 
         ** 
         */

        function getItems($where , $value , $approve = NULL ) {  //#82  #109

            global $con ;

            $sql = $approve == NULL ? 'AND Approve = 1 ' : '';
            
            $getItems = $con->prepare("SELECT * FROM items WHERE $where = ? $sql ORDER BY Item_ID DESC");

            $getItems->execute(array($value));

            $items = $getItems->fetchAll();

            return $items;

        }


    /**
     * Check if user is not Activated
     * Function To check the RegStatus of the User
     *  */   

    function checkUserStatus($user) {

    global $con ;

    $stmtx = $con->prepare("SELECT
                                Username , RegStatus
                            FROM 
                                users 
                            WHERE 
                                Username = ?  
                            AND
                                RegStatus  = 0                          
                            ");

    $stmtx->execute(array($user));

    $status = $stmtx->rowCount(); // rowCount it's count how many rows he is find 

    return $status;

    }    

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
     * 
     *  Home Redirect Function   V2.0
     * $theMsg = echo the message [ maybe | Errore | success | Warrning ]
     * $url = THe link you want to redirect to it 
     * $seconds  = seconds before redirecting
     * 
     */

    function redirectHome($theMsg , $url = null , $seconds = 3 ){

        if ($url === null) {

            $url = 'index.php';

            $link = 'Homepage';

        }else {

            //  $url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ?  $url = $_SERVER['HTTP_REFERER'] : 'index.php';

            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') { // If he is set and not empty because if he the first page this mean he didn't have any referrer page and will cause error

                $url = $_SERVER['HTTP_REFERER'];  /* Referer this http Requset witch  you come from or the last page*/
                $link = 'Previous Page';

            }else {

                $url = 'index.php';
                $link = 'Homepage';
            }

            
            

        }
        
        echo "<div class='container'>";

        echo $theMsg ;
 
        echo "<div class='alert alert-info'>You will be redirected to $link after :  $seconds  Seconds. </div>";

        echo "</div>";

        header("refresh: $seconds;url=$url");

        exit();
     }

     /**
      ** Check items Function  V1.0
      ** Function to check item in database  [ Function Accept Parameters ]
      ** $select = the item to Select from table in database  [ Example: user, or item, or category ]
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

      /**
       **  Count Number or Items Function v1.0
       **  Function To Count Number of Items Rows
       **   $item = the item to count  
       **   $table = the table to choose From
       */

       function countItems($item , $table) {

        global $con; /** we use global to allow us use $con inside the function  */

        $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

        $stmt2->execute();

        return $stmt2->fetchColumn();

        }

        /**
         ** Get Latest Records Function v1.0
         ** Function To Get Latest Items From Database such as [ users , items , Comments] 
         ** $select = Field to select 
         ** $table = the table to choose from
         ** $limit = Number of Records you need 
         ** $order = what you need to order by such as( UserID , categoriID , ...) 
         ** DESC = descending
         ** ASC  = tsa3odian
         */

         function getLatest($select , $table , $order , $limit = 5 ) {

            global $con ;

            $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC  LIMIT $limit");

            $getStmt->execute();

            $rows = $getStmt->fetchAll();

            return $rows;

         }