<?php
    ob_start();
    session_start();
    $pageTitle = 'Login';

    if (isset($_SESSION['user'])) {
        header('Location: index.php'); // Redirect To Dashboard Page
    }

    include 'init.php';

    // Check if the user coming from HTTP Post Requst
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['login'])) {

        $user = $_POST['username'];
        $pass = $_POST['password'];
        $hashePass = sha1($pass);

        // check if the User Exist in Database

        $stmt = $con->prepare("SELECT
                                    Username , Password
                                FROM 
                                    users 
                                WHERE 
                                    Username = ?  
                                AND
                                    Password  = ?                          
                                ");

        $stmt->execute(array($user , $hashePass));

        $count = $stmt->rowCount(); // rowCount it's count how many rows he is find 

        // If $count > 0 this mean the Database Contain Record About this Username

        if ($count > 0) {

            $_SESSION['user'] = $user;      // Register Session Name 


            header('location: index.php');      // Redirect To Dashboard Page

            exit();

        }

    } else {
        
        $formErrors = array();

        if (isset($_POST['username'])) {
            $filterdUser = filter_var($_POST['username'] , FILTER_SANITIZE_STRING);
            if (strlen($filterdUser) < 4 ) {
                $formErrors[] = 'Username Must be larger than 4 characters';
            }
        }
        if (isset($_POST['password']) && isset($_POST['password2'])) {
            $pass1 = sha1($_POST['password']);
            $pass2 = sha1($_POST['password2']);

            if ($pass1 !== $pass2) {
                $formErrors[] = ' Sorry password is not Match';
            }

        }
    }
}
?>

<div class="container login-page">
    <h1 class="text-center">
        <span class="selected" data-class="login">Login</span> | 
        <span data-class="signup" > Signup </span>
    </h1>

    <!-- Start Login Form -->

    <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="input-container">
            <input 
                type="text" 
                class = "form-control"
                name="username" 
                autocomplete="off" 
                placeholder="Type your username"
                required
            />
        </div>
        <div class="input-container">
            <input 
                type="password" 
                class = "form-control" 
                name="password"  
                autocomplete="new-password" 
                placeholder="Type your Password"
            />
        </div>
        <input 
            type="submit" 
            class = "btn btn-primary btn-block" 
            value="Login"
            name="login"
        >
    </form>

    <!-- End Login Form -->

    <!-- Start Signup  Form -->

    <form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" >
        <div class="input-container">
            <input 
                type="text" 
                class = "form-control" 
                name="username" 
                autocomplete="off" 
                placeholder="Type your username"
            />
        </div>
        <div class="input-container">
            <input 
                type="password" 
                class = "form-control" 
                name="password"  
                autocomplete="new-password" 
                placeholder="Type a Complex Password"
            />
        </div>
        <div class="input-container">
            <input 
                type="password" 
                class = "form-control" 
                name="password2"  
                autocomplete="new-password" 
                placeholder="Type a password again"
            />
        </div>
        <div class="input-container">
            <input 
                type="email" 
                class = "form-control" 
                name="email"  
                placeholder="Type a Valid Email"
            />
        </div>
        <input 
            type="submit" 
            class = "btn btn-success btn-block" 
            value="Signup"
            name="signup"
        >
    </form>
    <!-- End Signup  Form -->
    <div class="the-errors text-center">
        <?php

            if (!empty($formErrors)) {
                foreach ($formErrors as $error) {
                    echo $error . '<br>';
                }
            }

        ?>

    </div>
</div>

<?php

    include $tpl . 'footer.php';
    ob_end_flush();
?>