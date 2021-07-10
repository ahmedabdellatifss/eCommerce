<?php
  

function lang($phrase) {

    static $lang = array(

      'HOME_ADMIN'     => 'الرئيسه',
      'MY_Name'        => 'احمد',
      'Sections'       => 'الفئات',
      'Edit_Profile'   => 'تعديل الصفحه الشخصيه',
      'Settings'       => 'الاعدادات',
      'Logout'         => 'تسجيل الخروج',
      'ITEMS'          => 'العناصر',
      'MEMBERS'        => 'الاعضاء',
      'STATISTICS'     => 'الاحصائيات',
      'LOGS'           => 'سجلات',
      'EDIT_MEMBER'    => "تحرير الاعضاء",
      'USERNAME'       => 'اسم المستخدم',
      'PASSWORD'       => 'الرقم السري',
      'EMAIL'          => 'البريد الالكتروني',
      'FULL_NAME'      => 'الاسم كامل',
      'SAVE'           => 'حفط',
      'ADD_MEMBER'     => 'أضافه عضو جديد',
      'Manage_Member'  => 'أدارة الأعضاء',


      );

      return $lang[$phrase];

}