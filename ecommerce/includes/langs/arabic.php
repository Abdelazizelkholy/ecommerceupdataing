<?php

function lang($phrase){
    
  static $lang=array(
      
      'message' =>'welcome to arabic',
      'user' =>'abdelaziz  elkholy'
      
      
  );  
  
  return $lang[$phrase] ;
    
}

