<?php
  

function lang($phrase) {

    static $lang = array(

      // Dashboard page
        'HOME_ADMIN'     => 'Home',
        'MY_Name'        => 'Ahmed',
        'Sections'       => 'Categories',
        'Edit_Profile'   => 'Edit Profile',
        'Settings'       => 'Settings',
        'Logout'         => 'Logout',
        'ITEMS'          => 'Items',
        'MEMBERS'        => 'Members',
        'STATISTICS'     => 'Statistics',
        'LOGS'           => 'Logs',



      );

      return $lang[$phrase];

}

//    $lang = array(

//     'Osama' => 'Zero'
//    );

//   echo $lang['Osama'];
