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
                                    UserID , Username , Password
                                FROM 
                                    users 
                                WHERE 
                                    Username = ?  
                                AND
                                    Password  = ?                          
                                ");

        $stmt->execute(array($user , $hashePass));

        $get = $stmt->fetch();

        $count = $stmt->rowCount(); // rowCount it's count how many rows he is find 

        // If $count > 0 this mean the Database Contain Record About this Username

        if ($count > 0) {

            $_SESSION['user'] = $user;      // Register Session Name 

            $_SESSION['uid'] = $get['UserID']; // Register User ID in Session

            header('location: index.php');      // Redirect To Dashboard Page

            exit();

        }

    } else {
        
        $formErrors = array();

        $username   = $_POST['username'];
        $password   = $_POST['password'];
        $password2  = $_POST['password2'];
        $email      = $_POST['email'];

        if (isset($username)) {
            $filterdUser = filter_var($username , FILTER_SANITIZE_STRING);
            if (strlen($filterdUser) < 4 ) {
                $formErrors[] = 'Username Must be larger than 4 characters';
            }
        }
        if (isset($password) && isset($password2)) {
            if (empty($password)) {
                $formErrors[] = 'Sorry Password Cant Be Empty';
            }
            $pass1 = sha1($password);
            $pass2 = sha1($password2);

            if ($pass1 !== $pass2) {
                $formErrors[] = ' Sorry password is not Match';
            }

        }
        if (isset($email)) {
            $filterdEmail = filter_var($email , FILTER_SANITIZE_EMAIL);
            if (filter_var($filterdEmail , FILTER_VALIDATE_EMAIL ) != true ) {
                $formErrors[] = 'This Email Is Not Valid';
            
            }
        }

          // Check if ther's no error proceed the user Add  
        if (empty($formErrors)) {

            // Check if user Exist in Database

            $check = checkItem("Username" , "users" , $username);

            if ($check == 1){

                $formErrors[] = 'Sorry This User Is Exists';


            }else{

            
                // Insert User Info in  the database 

                $stmt = $con->prepare("INSERT INTO 
                                            users( Username , Password , Email  , RegStatus , Date ) 
                                        VALUES(:zuser   , :zpass ,  :zmail , 0 ,now()) "); // this values to send to database
                $stmt->execute(array(
                // Key  => value
                'zuser' => $username,
                'zpass' =>sha1($password),
                'zmail' => $email,

                ));                                

                // Echo Success Message

                $succesMsg = 'Congrats You Are Now Registered user';

            

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
                pattern=".{4,8}" 
                title="UserName Must be 4 & 8 characters"
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
                minlength="4"
                type="password" 
                class = "form-control" 
                name="password"  
                autocomplete="new-password" 
                placeholder="Type your Password"
                required
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
                pattern=".{4,12}" 
                title="UserName Must be 4 & 12 characters"
                required
                type="text" 
                class = "form-control" 
                name="username" 
                autocomplete="off" 
                placeholder="Type your username"
            />
        </div>
        <div class="input-container">
            <input 
            minlength="4"
                type="password" 
                class = "form-control" 
                name="password"  
                autocomplete="new-password" 
                placeholder="Type a Complex Password"
                required
            />
        </div>
        <div class="input-container">
            <input
                minlength="4" 
                type="password" 
                class = "form-control" 
                name="password2"  
                autocomplete="new-password" 
                placeholder="Type a password again"
                required
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

					echo '<div class="msg error">' . $error . '</div>';

				}

			}

			if (isset($succesMsg)) {

				echo '<div class="msg success">' . $succesMsg . '</div>';

			}
            
		?>
	</div>
</div>

<?php

    include $tpl . 'footer.php';
    ob_end_flush();
?>