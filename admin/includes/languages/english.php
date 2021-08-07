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
        'EDIT_MEMBER'    => 'Edit Member',
        'USERNAME'       => 'Username',
        'PASSWORD'       => 'Password',
        'EMAIL'          => 'Email',
        'FULL_NAME'      => 'Full Name',
        'SAVE'           => 'Save',
        'ADD_MEMBER'     => 'Add New Member',
        'Manage_Member'  => 'Manage Member',
        'ADD_CATEGORIES' => 'Add New Categories',
        'NAME'           => 'Name',
        'DESCRIPTION'    => 'Description',
        'ORDERING'       => 'Ordering',
        'VISIBLE'        => 'Visible',
        'COMMENTING'     => 'Allow Commenting',
        'ADS'            => 'Allow Ads',
        'EDIT_CATEGORIES' =>'Edit New Categories',
        'SAVE_CATEGORY'  => 'Save',
        'ADD_ITEM'       => 'Add New Item',
        'ADD_BUTTON'     => 'Add Item',
        'PRICE'          => 'Price',
        'COUNTRY'        => 'Country',
        'STATUS'         => 'Status',
        'RATING'         => 'Rating',
        

      );

      return $lang[$phrase];

}

//    $lang = array(

//     'Osama' => 'Zero'
//    );

//   echo $lang['Osama'];
