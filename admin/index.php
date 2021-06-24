<?php 
     include 'init.php';
     include $tpl . 'header.php';
     include 'includes/languages/arabic.php'
 ?>


   <form class="login">
     <h4 class="text-center">Admin Login</h4>
     <input class="form-control input-lg" type="text" name="user" placeholder="Username" autocomplete="off" />
     <input class="form-control input-lg" type="password" name="pass" placeholder="Password" autocomplete="new-password" /> <!--  this (new-password) is special for chroom to deny auto complete or remmber this passowrds -->
     <input class="btn btn-lg btn-primary btn-block" type="submit" value="login" />
   </form>


 <?php 
     include  $tpl . 'footer.php';

 ?>    