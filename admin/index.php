<?php 
     session_start();
     $noNavbar  = '';
     $pageTitle = 'Login';

     if(isset($_SESSION['Username'])) {
       header('location: dashboard.php'); // Redirect To Dashboard Page
     }
     
     include 'init.php';
   
     // Check if the user coming from HTTP Post Requst
     if ($_SERVER['REQUEST_METHOD'] == "POST") {

      $username = $_POST['user'];
      $password = $_POST['pass'];
      $hashePass = sha1($password);
      
      // check if the User Exist in Database

      $stmt = $con->prepare("SELECT Username , Password FROM users WHERE Username = ? AND Password = ? AND GroupID = 1");
      $stmt->execute(array($username , $hashePass));
      $count = $stmt->rowCount(); // rowCount it's count how many rows he is find 

     // If $count > 0 this mean the Database Contain Record About this Username
     
     if($count > 0) {
       
      $_SESSION['Username'] = $username; // Register Session Name 
      header('location: dashboard.php'); // Redirect To Dashboard Page
      exit();

      
     }
      
     }
 ?>




   <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST"> 
     <h4 class="text-center">Admin Login</h4>
     <input class="form-control input-lg" type="text" name="user" placeholder="Username" autocomplete="off" />
     <input class="form-control input-lg" type="password" name="pass" placeholder="Password" autocomplete="new-password" /> <!--  this (new-password) is special for chroom to deny auto complete or remmber this passowrds -->
     <input class="btn btn-lg btn-primary btn-block" type="submit" value="login" />
   </form>


 <?php 
     include  $tpl . 'footer.php';

 ?>    