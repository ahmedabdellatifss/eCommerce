<?php
    include 'init.php';
?>

<div class="container login-page">
    <h1 class="text-center">
        <span class="selected" data-class="login">Login</span> | 
        <span data-class="signup" > Signup </span>
    </h1>
    <form class="login" action="">
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
        <input 
            type="password" 
            class = "form-control" 
            name="password"  
            autocomplete="new-password" 
            placeholder="Type your Password"
        />
        <input 
            type="submit" 
            class = "btn btn-primary btn-block" 
            value="Login"
        >
    </form>

    <form class="signup" action="">
        <input 
            type="text" 
            class = "form-control" 
            name="username" 
            autocomplete="off" 
            placeholder="Type your username"
        />
        <input 
            type="password" 
            class = "form-control" 
            name="password"  
            autocomplete="new-password" 
            placeholder="Type a Complex Password"
        />
        <input 
            type="password" 
            class = "form-control" 
            name="password2"  
            autocomplete="new-password" 
            placeholder="Type a password again"
        />
        <input 
            type="email" 
            class = "form-control" 
            name="email"  
            placeholder="Type a Valid Email"
        />
        <input 
            type="submit" 
            class = "btn btn-success btn-block" 
            value="Signup"
        >
    </form>
</div>



<?php
    include $tpl . 'footer.php';
?>