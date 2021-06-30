<?php 
   
   /**
    * Title Function That Echo The Page Title In case the page  
    * Has the variable $pageTitle And Echo Defualt title for other pages
    */

    function getTitle(){

        global $pageTitle;

        if (isset($pageTitle))  {

            echo $pageTitle;

        }else{
            echo 'Default';
        }
    }