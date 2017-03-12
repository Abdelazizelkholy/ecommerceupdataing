<?php



ob_start();

session_start();

$PageTitle = 'Comments';

if(isset($_SESSION['username'])){

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';
            // start mange page
    
    if($do == 'mange'){
        // mange page
        
       
        
        
        
        $stmt = $con->prepare("SELECT 
                comments.*,items.name,users.Username  
                FROM comments 
                
                INNER JOIN
                    items
                 ON
                    items.item_id = comments.item_id
                INNER JOIN
                    users
                 ON
                    users.Userid = comments.Userid
                 ORDER BY c_id DESC 
                    ");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        
        if(!empty($rows)){
            
        ?>

                <h1 class="text-center">Mange Comment </h1>
                <div class="container">
                    <div class="table-responsive">
                        <table class="main-table  text-center  table table-bordered">
                            <tr>
                                <td>#ID</td>
                                <td>Comment</td>
                                <td>Item Name</td>
                                <td>User Name</td>
                                <td>Add Date</td>
                                <td>Control</td>
                            </tr>
                         <?php
                                 foreach ($rows as $row){
                                     echo '<tr>';
                                     echo '<td>'.$row['c_id'].'</td>';
                                     echo '<td>'.$row['Comment'].'</td>';
                                     echo '<td>'.$row['name'].'</td>';
                                     echo '<td>'.$row['Username'].'</td>';
                                     echo '<td>'.$row['Comment_date'].'</td>';
                                     echo '<td>
                                            <a href="comments.php?do=Edit&comid='.$row['c_id'].'" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                            <a href="comments.php?do=Delete&comid='.$row['c_id'].'" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a> ';
                                                
                                            if( $row['Status'] == 0 ){
                                           
                                                
                                                echo ' <a href="comments.php?do=Approve&comid='.$row['c_id'].'" class="btn btn-info "><i class="fa fa-check"></i> Approve</a> ';

                                            }
                                                
                                     echo   '</td>';
                                     echo '</tr>';  
                                 }
       
                         
                         ?>
                            
                        </table>
                    </div>
                   
                </div>
    <?php  }  else {
                     echo '<div class="container">';
                    echo '<div  class="alert alert-info" > there\'s no Comments to Show </div>';
                    echo '</div>'; 
                       
                     } ?>
        <?php
        
    }
    
    
    elseif ($do == 'Edit') {
        //Edit page
        
        // check if get request userid is_numeric & get integer value of it
        $comid =  isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;
        // select all data depend id 
         $stmt = $con->prepare(" SELECT  * FROM comments WHERE c_id=?   ");
                //  execute the query
        $stmt->execute(array($comid));
        
            // fetch data
        $row = $stmt->fetch();
        // the row count
        $count = $stmt->rowCount();
        
        if($stmt->rowCount() > 0){

        ?>

                <h1 class="text-center">Edit Comment </h1>
                <div class="container">
 
    
                    <form class="form-horizontal" action="?do=Update" method="post">
                        <input type="hidden" name="comid" value="<?php echo $comid;  ?>" >
                    <!--  username input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Comment</label>
                <div class="col-sm-10 col-md-6">
                    <textarea  class="form-control" name="comment" ><?php echo  $row['Comment'] ; ?></textarea>
                </div>
            
              </div>
                    
                    
              
              
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary btn-lg">Save</button>
                </div>
              </div>
            </form>
    
    
                </div>    
        
       
    

    
    <?php
    
        }  else {
            
            echo '<div class="container">';
            $TheMessage = '<div class="alert alert-danger"> There is no Such ID</div>';
            
            Redirecthome($TheMessage);
            echo '</div>';
        }
    }elseif ($do == 'Update') {
        // Update page
        echo '<h1 class="text-center">Update Member</h1>';
             echo '<div class="container">';
        
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            
            
            
                //get variable from the form  
            $comid        = $_POST['comid'];
            $comment    = $_POST['comment'];
           
            
  
                 //   update the DB with this info  
            
             
            $stmt = $con->prepare(" UPDATE   comments SET  Comment=?  WHERE c_id=?  ");
    
            $stmt->execute(array($comment,$comid));
            
            // echo sucess message 
            
            $TheMessage =  '<div class="alert alert-success">'.$stmt->rowCount() .' Record Update</div> ' ;
               
            Redirecthome($TheMessage,'back');
            
            
            
            
           
            
        
    }else {
        
        $TheMessage = '<div class="alert alert-danger">sorry,you can not Browse this page</div> ';
          Redirecthome($TheMessage);
          
    }
    echo '</div>';
    } elseif ($do == 'Delete') {
        
            //  Delete page
        
          echo '<h1 class="text-center">Delete Comment</h1>';
             echo '<div class="container">';
        
        
         $comid =  isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;
        // select all data depend id 
     
         
         $check = CheckItem('c_id' , 'comments' , $comid);
         
 
        
        if($check > 0){
        
            $stmt = $con->prepare("DELETE FROM comments WHERE c_id= :id ");
            $stmt->bindParam(":id",$comid);
            $stmt->execute();
            
            $TheMessage =  '<div class="alert alert-success">'.$stmt->rowCount() .' Record Deleted</div> ' ;
            
           Redirecthome($TheMessage , 'back');
           
            
        }  else {
            
            $TheMessage = '<div class="alert alert-danger">this ID not found</div> ';  
            Redirecthome($TheMessage);
            
        }
       
       
        echo '</div>';  
}elseif ($do == 'Approve') {
    
    
       
          echo '<h1 class="text-center">Approve Comment</h1>';
             echo '<div class="container">';
        
        
         $comid =  isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;
        // select all data depend id 
      //   $stmt = $con->prepare(" SELECT  * FROM users WHERE Userid=?  LIMIT 1 ");
                //  execute the query
         
         $check = CheckItem('c_id' , 'comments' , $comid);
         

        
        if($check > 0){
        
            $stmt = $con->prepare("UPDATE  comments SET Status= 1 WHERE c_id=? ");
            
            $stmt->execute(array($comid));
            
            $TheMessage =  '<div class="alert alert-success">'.$stmt->rowCount() .' Record Approve</div> ' ;
            
           Redirecthome($TheMessage , 'back');
           
            
        }  else {
            
            $TheMessage = '<div class="alert alert-danger">this ID not found</div> ';  
            Redirecthome($TheMessage);
            
        }
       
       
        echo '</div>';
    
    
    
    }
   
    
include   $tpl. 'footer.php';
   
}  else {
    
    header("location:index.php");
    exit();
    
}

ob_end_flush();



