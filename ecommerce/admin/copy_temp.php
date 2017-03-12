<?php



ob_start();
session_start();

$PageTitle = 'members';

if(isset($_SESSION['username'])){

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';
            // start mange page
    
    if($do == 'mange'){
        // mange page
        
   
        
    }elseif ($do == 'Add') {
        // Add page 
        


    }elseif ($do == 'insert') {
         // inser page  
   
           
  
    
    
    } elseif ($do == 'Edit') {
        //Edit page
    
    
           

        
    }elseif ($do == 'Update') {
        // Update page
      
       
         
         
    } elseif ($do == 'Delete') {
        
        
}elseif ($do == 'Activate') {
    
    
    
    
    
    
    }
   
    
include   $tpl. 'footer.php';
   
}  else {
    
    header("location:index.php");
    exit();
    
}

ob_end_flush();