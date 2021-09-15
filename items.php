<?php
    ob_start();
    session_start();
    $pageTitle = 'Show Items';
    include 'init.php';

      // Check if Get Request item is Numeric & Get the integer value of it
    // Detect the item Id is number
    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;    // intval = intger value

    // Select All Data Depend on this ID

    $stmt = $con->prepare("SELECT * FROM  items  WHERE  item_ID = ? "); 

    // Execute Query
    $stmt->execute(array($itemid));
    // Fetch The data
    $item = $stmt->fetch();

?>
<h1 class="text-center"><?php echo $item['Name'] ?></h1>



<?php
      
    include  $tpl . 'footer.php';
    ob_end_flush();
?>