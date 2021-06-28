<?php
  

function lang($phrase) {

    static $lang = array(

      'HOME_ADMIN'     => 'الرئيسه',
      'MY_Name'        => 'احمد',
      'Sections'     => 'الفئات',
      'Edit_Profile'   => 'تعديل الصفحه الشخصيه',
      'Settings'       => 'الاعدادات',
      'Logout'         => 'تسجيل الخروج',
      'ITEMS'          => 'العناصر',
      'MEMBERS'        => 'الاعضاء',
      'STATISTICS'     => 'الاحصائيات',
      'LOGS'           => 'سجلات',
 


      );

      return $lang[$phrase];

}