<?php 
   
   $dsn = 'mysql:host=localhost;dbname=shop';
   $user ='root';
   $pass = '';
   $option = array(
       PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
   );

   try {
       $con = new PDO($dsn , $user , $pass , $option);
       $con->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION); // to activation  method the exception to handel Error
     
   }

   catch(PDOException $e) {
       echo 'Failed To Conntcted' . $e->getMessage();
   }