<?php
  

function lang($phrase) {

    static $lang = array(

        'MESSAGE' => 'Welcome',
        'ADMIN'   => 'Administrator'


      );

      return $lang[$phrase];

}

//    $lang = array(

//     'Osama' => 'Zero'
//    );

//   echo $lang['Osama'];
