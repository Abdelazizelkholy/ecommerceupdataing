<?php

function lang($phrase){
    
  static $lang=array(
      
      // navbar links
      
         'HOME'             =>'Home',
         'CATOGERIES'       =>'Catogeries',
         'ITEMS'            =>'Items',
         'MEMBERS'          =>'Member',
         'COMMENTS'          =>'Comments',
         'STATISTICS'       =>'Statitics',
         'LOGS'             =>'Logs',
         'EDIT PROFILE'     =>'Edit profile',
         'SETTING'          =>'Setting',
         'LOGOUT'           =>'Logout',
      
      
      
  );  
  
  return $lang[$phrase] ;
    
}

