<?php

//   you can mange members page

// you can add || edit || delete  members from here   



ob_start();

session_start();

$PageTitle = 'members';

if(isset($_SESSION['username'])){

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';
            // start mange page
    
    if($do == 'mange'){
        // mange page
        
        $query= ' ';
        
        if(isset($_GET['page']) && $_GET['page'] == 'pending'){
            
            $query ='AND Regstatus = 0 ';
            
        }
        
        
        
        $stmt = $con->prepare("SELECT * FROM users WHERE Groupid !=1 $query  ORDER BY Userid DESC ");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        
        if(!empty($rows)){
        ?>

                <h1 class="text-center">Mange Members </h1>
                <div class="container">
                    <div class="table-responsive">
                        <table class="main-table  text-center  table table-bordered">
                            <tr>
                                <td>#ID</td>
                                <td>UserName</td>
                                <td>Email</td>
                                <td>Fullname</td>
                                <td>Registered Date</td>
                                <td>Control</td>
                            </tr>
                         <?php
                                 foreach ($rows as $row){
                                     echo '<tr>';
                                     echo '<td>'.$row['Userid'].'</td>';
                                     echo '<td>'.$row['Username'].'</td>';
                                     echo '<td>'.$row['Email'].'</td>';
                                     echo '<td>'.$row['Fullname'].'</td>';
                                     echo '<td>'.$row['Date'].'</td>';
                                     echo '<td>
                                            <a href="members.php?do=Edit&Userid='.$row['Userid'].'" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                            <a href="members.php?do=Delete&Userid='.$row['Userid'].'" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a> ';
                                                
                                            if( $row['Regstatus'] == 0 ){
                                           
                                                
                                                echo ' <a href="members.php?do=Activate&Userid='.$row['Userid'].'" class="btn btn-info "><i class="fa fa-check"></i> Activate</a> ';

                                            }
                                                
                                     echo   '</td>';
                                     echo '</tr>';  
                                 }
                         
                         
                         ?>
                            
                        </table>
                    </div>
                    <a href="members.php?do=Add" class="btn btn-primary" ><i class="fa fa-plus"></i> Add New Member </a>
                </div>
        <?php   }  else {
                    echo '<div class="container">';
                    echo '<div  class="alert alert-info" > there\'s no Members to Show </div>';
                    echo '<a href="members.php?do=Add" class="btn btn-primary" ><i class="fa fa-plus"></i> Add New Member </a>';
                    echo '</div>';
                     } ?>
        <?php
        
    }elseif ($do == 'Add') {
        // Add page 
        ?>


                    <h1 class="text-center">Add New Member </h1>
                <div class="container">
 
    
                    <form class="form-horizontal" action="?do=insert" method="post">
                       
                    <!--  username input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text"  name="Username" class="form-control" id="inputEmail3"    autocomplete="off" required="required" placeholder="Username to login shop" >
                  <!--  <span class="asterisk" >*</span>-->
                </div>
            
              </div>
                    <!--  password input  -->
              <div class="form-group form-group-lg">
                <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10 col-md-6">
                    
                    <input type="password" name="Password" class="password form-control" id="inputPassword3"  autocomplete="new-password" required="required" placeholder="Password must be hard & complex ">
                    <i class="show-pass fa fa-eye fa-2x"  ></i>
                </div>
              </div>
                    <!--  email input  -->
                    <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10 col-md-6">
                    <input type="email"  name="Email" class="form-control" id="inputEmail3"  autocomplete="off" required="required" placeholder="Email must be vaild ">
               <!-- <span class="asterisk" >*</span>-->
                </div>
              </div>
                    <!--  fullname input  -->
                    <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Fullname</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text"  name="Fullname" class="form-control" id="inputEmail3"    autocomplete="off" required="required"  placeholder="Fullname Apper in your profile  ">
               <!-- <span class="asterisk" >*</span>-->
                </div>
              </div>
                    
              
              
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary btn-lg">Add Member </button>
                </div>
              </div>
            </form>
    
    
                </div> 




<?php





    }elseif ($do == 'insert') {
         // inser page  
      
        
        
            
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            
              echo '<h1 class="text-center">insert Member</h1>';
              echo '<div class="container">';
                //get variable from the form  
            
            $username    = $_POST['Username'];
            $password    =   $_POST['Password'];
            $Email       = $_POST['Email'];
            $Fullname    = $_POST['Fullname'];
            $hashpass    =  sha1($_POST['Password']);
        
            //  validte the form
            
            $formerrors = array();
            
            if(strlen($username) < 4 ){
                
                $formerrors[] = ' Username cant be less than 4 char ';
                
            }
              if(strlen($username) > 20 ){
                
                $formerrors[] = ' Username cant be more than 20 char ';
                
            }
            
            
            if(empty($username)){
                
                $formerrors[] = ' Username cant be empty ';
                
            }
             if(empty($password)){
                
                $formerrors[] = ' Password cant be empty ';
                
            }
            
             if(empty($Email)){
                
               $formerrors[] = ' Email cant be empty ';
            }
            
             if(empty($Fullname)){
                
                $formerrors[] = ' Fullname cant be empty ';
            }
            // loop the  empty input
            foreach ($formerrors as $error){
                
                echo '<div class="alert alert-danger" >'. $error. '</div>';
            }
            //  check if there no error update all data 
            
            if(empty($formerrors)){
                
                $check= CheckItem('Username', 'users', $username);
                
                if($check == 1){
                    
                    
                    $TheMessage = '<div class="alert alert-danger">sorry,this user exist</div>';
                    Redirecthome($TheMessage ,'back' );
                    
                } else {
                    
             
         
                
                 //   insert userinfo in DB 
            
             $stmt = $con->prepare("INSERT INTO users (Username,Password,Email,Fullname,Regstatus,Date) VALUES (:user , :pass , :email , :Full, 1 , now() ) ");
             $stmt->execute(array(
                 
                 'user'  =>    $username,
                 'pass'  =>    $hashpass,
                 'email' =>    $Email,
                 'Full'  =>    $Fullname
                 
             ));
           
            
            // echo sucess message 
            
            $TheMessage =  '<div class="alert alert-success">'.$stmt->rowCount() .' Record Inserted</div> ' ;
                
            Redirecthome($TheMessage,'back');
               }
            
            }
            
           
            
        
    }else {
      //  echo 'sorry,you can not Browse this page ';
            
      echo '<div class="container">';
        
        $TheMessage = '<div class="alert alert-danger" >sorry,you can not Browse this page</div> ';
        Redirecthome($TheMessage,'back');
        echo '</div>';
    }
    echo '</div>';
        
        
        
    }
    
    
    elseif ($do == 'Edit') {
        //Edit page
        
        // check if get request userid is_numeric & get integer value of it
        $Userid =  isset($_GET['Userid']) && is_numeric($_GET['Userid']) ? intval($_GET['Userid']) : 0 ;
        // select all data depend id 
         $stmt = $con->prepare(" SELECT  * FROM users WHERE Userid=?  LIMIT 1 ");
                //  execute the query
        $stmt->execute(array($Userid));
        
            // fetch data
        $row = $stmt->fetch();
        // the row count
        $count = $stmt->rowCount();
        
        if($stmt->rowCount() > 0){

        ?>

                <h1 class="text-center">Edit Member</h1>
                <div class="container">
 
    
                    <form class="form-horizontal" action="?do=Update" method="post">
                        <input type="hidden" name="Userid" value="<?php echo $Userid;  ?>" >
                    <!--  username input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text"  name="Username" class="form-control" id="inputEmail3" value="<?php echo $row['Username']; ?>"   autocomplete="off" required="required" >
                  <!--  <span class="asterisk" >*</span>-->
                </div>
            
              </div>
                    <!--  password input  -->
              <div class="form-group form-group-lg">
                <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10 col-md-6">
                    <input type="hidden" name="oldPassword"  id="inputPassword3"  value="<?php echo $row['Password']; ?>"  >
                    <input type="password" name="newPassword" class="form-control" id="inputPassword3" placeholder=" leave this blabk if you dont change password "   autocomplete="new-password">
                
                </div>
              </div>
                    <!--  email input  -->
                    <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10 col-md-6">
                    <input type="email"  name="Email" class="form-control" id="inputEmail3"  value="<?php echo $row['Email']; ?>" autocomplete="off" required="required">
               <!-- <span class="asterisk" >*</span>-->
                </div>
              </div>
                    <!--  fullname input  -->
                    <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Fullname</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text"  name="Fullname" class="form-control" id="inputEmail3"  value="<?php echo $row['Fullname']; ?>"  autocomplete="off" required="required">
               <!-- <span class="asterisk" >*</span>-->
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
            $id          = $_POST['Userid'];
            $username    = $_POST['Username'];
            $Email       = $_POST['Email'];
            $Fullname    = $_POST['Fullname'];
            
            // Password trick
            // condition ? true : false ;
            $pass = empty($_POST['newPassword']) ? $_POST['oldPassword'] : sha1($_POST['newPassword']);
            
            /*
            $pass  = ' ';
            
            if(empty($_POST['newPassword'])){
                
                $pass =$_POST['oldPassword'];
            }  else {
            
                $pass = sha1($_POST['newPassword']);
            }
            */
            //  validte the form
            
            $formerrors = array();
            
            if(strlen($username) < 4 ){
                
                $formerrors[] = ' Username cant be less than 4 char ';
                
            }
              if(strlen($username) > 20 ){
                
                $formerrors[] = ' Username cant be more than 20 char ';
                
            }
            
            
            if(empty($username)){
                
                $formerrors[] = ' Username cant be empty ';
                
            }
            
             if(empty($Email)){
                
               $formerrors[] = ' Email cant be empty ';
            }
            
             if(empty($Fullname)){
                
                $formerrors[] = ' Fullname cant be empty ';
            }
            // loop the  empty input
            foreach ($formerrors as $error){
                
                echo '<div class="alert alert-danger" >'. $error. '</div>';
            }
            //  check if there no error update all data 
            
            if(empty($formerrors)){
  
  
             
            $stmt = $con->prepare(" UPDATE   users SET  Username=? , Email=? , Fullname=? , Password=? WHERE Userid=?  ");
    
            $stmt->execute(array($username,$Email,$Fullname,$pass,$id));
            
            // echo sucess message 
            
            $TheMessage =  '<div class="alert alert-success">'.$stmt->rowCount() .' Record Update</div> ' ;
               
            Redirecthome($TheMessage,'back');
               
               
            }  
   
    }else {
        
        $TheMessage = '<div class="alert alert-danger">sorry,you can not Browse this page</div> ';
          Redirecthome($TheMessage);
          
    }
    echo '</div>';
    } elseif ($do == 'Delete') {
        
            //  Delete page
        
          echo '<h1 class="text-center">Delete Member</h1>';
             echo '<div class="container">';
        
        
         $Userid =  isset($_GET['Userid']) && is_numeric($_GET['Userid']) ? intval($_GET['Userid']) : 0 ;
        // select all data depend id 
      //   $stmt = $con->prepare(" SELECT  * FROM users WHERE Userid=?  LIMIT 1 ");
                //  execute the query
         
         $check = CheckItem('Userid' , 'users' , $Userid);
         
         
         
    //    $stmt->execute(array($Userid));
        
           
          // the row count
    //    $count = $stmt->rowCount();
        
        if($check > 0){
        
            $stmt = $con->prepare("DELETE FROM users WHERE Userid= :userid ");
            $stmt->bindParam(":userid",$Userid);
            $stmt->execute();
            
            $TheMessage =  '<div class="alert alert-success">'.$stmt->rowCount() .' Record Deleted</div> ' ;
            
           Redirecthome($TheMessage , 'back');
            
        }  else {
            
            $TheMessage = '<div class="alert alert-danger">this ID not found</div> ';  
            Redirecthome($TheMessage);
            
        }
       
       
        echo '</div>';  
}elseif ($do == 'Activate') {
    
    
       
          echo '<h1 class="text-center">Activate Member</h1>';
             echo '<div class="container">';
        
        
         $Userid =  isset($_GET['Userid']) && is_numeric($_GET['Userid']) ? intval($_GET['Userid']) : 0 ;
        // select all data depend id 
      //   $stmt = $con->prepare(" SELECT  * FROM users WHERE Userid=?  LIMIT 1 ");
                //  execute the query
         
         $check = CheckItem('Userid' , 'users' , $Userid);
         
         
         
    //    $stmt->execute(array($Userid));
        
           
          // the row count
    //    $count = $stmt->rowCount();
        
        if($check > 0){
        
            $stmt = $con->prepare("UPDATE  users SET Regstatus= 1 WHERE Userid=? ");
            
            $stmt->execute(array($Userid));
            
            $TheMessage =  '<div class="alert alert-success">'.$stmt->rowCount() .' Record Activate</div> ' ;
            
           Redirecthome($TheMessage);
            
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

