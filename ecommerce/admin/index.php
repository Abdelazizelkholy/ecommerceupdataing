<?php
session_start();

$nonavbar     = '';
$PageTitle    ='login';

if(isset($_SESSION['username'])){
     header("location:dashboard.php"); // direct dashboard page
}
include 'init.php';
//include 'includes/temp/header.php';


// check if user coming from http request

if($_SERVER["REQUEST_METHOD"]=="POST"){
    
    $username  = $_POST['user'];
    $password  = $_POST['pass'];
    $hashedpass =  sha1($password);
    
    
    // check if user exist in database
    
    $stmt = $con->prepare(" SELECT  Userid,Username,Password FROM users WHERE Username=? AND Password=? AND Groupid=1 LIMIT 1 ");
    
    $stmt->execute(array($username,$hashedpass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    
    // if count > 0 this means the DB contain record about this username  
    
    if($count > 0 ){
    
        $_SESSION['username'] = $username; // Register session name
        $_SESSION['id']       =$row['Userid']; //Register session id
        header("location:dashboard.php"); // direct dashboard page
        exit();
       
      
    }
}


?>


<form class="login" action="<?php echo $_SERVER['PHP_SELF']  ?>" method="post">
    <h4 class="text-center" > Admin login</h4>
    <input   class="form-control" type="text" name="user" placeholder="Username"  autocomplete="off" />
    <input   class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
    <input    class="btn btn-primary btn-block" type="submit" value="login" />
    
</form>


<?php

include   $tpl. 'footer.php';

//include 'includes/temp/footer.php';
?>

