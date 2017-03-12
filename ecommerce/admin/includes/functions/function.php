<?php


//  function get  ALL from DB

    function getAllform( $field , $table   , $where = NULL ,$and =NULL ,$orderfield , $ordring = "DESC"  ){
        
        global $con;
        
          
             
        $getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordring ");
        $getAll->execute();
        $all = $getAll->fetchAll();
        return $all ;
        
                
                
                
    }





// function   to  get title page ya baby


function getTitle(){
    
    global $PageTitle;
    
    if(isset($PageTitle)){
        
        echo $PageTitle;
    }  else {
        echo 'Default';    
    }
}


//  Redirect function  to show   user errors by secands

        function  Redirecthome($TheMessage, $url=NULL  ,$secands = 5){
            
            if($url === NULL){
                $url='index.php';
                  $link='Home page';
            }  else {
                
                if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != ''){
                    
                      $url = $_SERVER['HTTP_REFERER'];
                      $link='previous page';
                }  else {
                      $url = 'index.php';
                      $link='Home page';
                }
                
  
            }
            
            echo  $TheMessage ;
            echo "<div  class='alert alert-info'> you will be Rediredted $link  after $secands. </div>";
            header("refresh:$secands;url=$url");
            exit();
        }

 // function to check items in DB
 //  1-function accept parameters
 // 2-select ->the item to select as(user , item ,Catogeries)
 // 3-from -> the table to select from as(users , items)
 // 4-value ->the value of select as(abdelaziz , box)
        
        
        function CheckItem($select , $from , $value){
            
            global $con;
            
            $statment =$con->prepare("SELECT  $select FROM $from WHERE $select = ? ");
            $statment->execute(array($value));
            $count = $statment->rowCount();
            return $count;
            
            
            
            
        }
        
//  count number of items  

    function  CheckItems($items , $table ){
        
        
        global $con;


            $stmt2 = $con->prepare("SELECT COUNT($items) FROM $table");
            $stmt2->execute();
            return $stmt2->fetchColumn();
    }    



 //  function get latest items from DB

    function getLaTest($select , $table , $order ,$limit = 5){
        
        global $con;
        
        $getstmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit ");
        $getstmt->execute();
        $row = $getstmt->fetchAll();
        return $row ;
        
                
                
                
    }
        
        
        
        
        
        