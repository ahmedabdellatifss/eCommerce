<?php
  

function lang($phrase) {

    static $lang = array(

        'MESSAGE' => 'اهلا',
        'ADMIN'   => 'يا مدير'


      );

      return $lang[$phrase];

}