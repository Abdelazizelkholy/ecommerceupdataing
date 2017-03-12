

<?php 
ob_start();
session_start();
$PageTitle    ='login';

if(isset($_SESSION['user'])){
     header("location:index.php"); // direct index page
}

include 'init.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
    
        if(isset($_POST['login'])){
    
    $user  = $_POST['username'];
    $pass  = $_POST['password'];
    $hashedpass =  sha1($pass);
    
    
    // check if user exist in database
    
    $stmt = $con->prepare(" SELECT  Userid,Username,Password FROM users WHERE Username=? AND Password=?  ");
    
    $stmt->execute(array($user,$hashedpass));
    $get=$stmt->fetch();
    $count = $stmt->rowCount();
    
    // if count > 0 this means the DB contain record about this username  
    
    if($count > 0 ){
    
        $_SESSION['user'] = $user; // Register session name
        $_SESSION['uid'] =$get['Userid'];
        header("location:index.php"); // direct dashboard page
        exit();
       
      
    }
     
        } else {
            $formerrors = array();
                    
                        $username  = $_POST['username'];
                        $paaword   = $_POST['password'];
                        $paaword2  = $_POST['password2'];
                        $email     = $_POST['email'];
            
            if(isset($username)){
                $filterUser =  filter_var($username,FILTER_SANITIZE_STRING);
                    if(strlen($filterUser) < 4){
                        $formerrors[]='Username Must be larger than 4 char';
                    }
            }
            
             if(isset($paaword) && isset($paaword2) ){
                        
                             if(empty($_POST['password'])){
                            $formerrors[]='Password can Not Empty';
                        }
                 
                       
                        if(sha1($paaword) !== sha1($paaword2)){
                            
                            $formerrors[]='Sory,Your Password not match';
                        }
                    }
                    
                     if(isset($email)){
                $filteremail =  filter_var($email,FILTER_SANITIZE_EMAIL);
                    if(filter_var($filteremail,FILTER_VALIDATE_EMAIL) != TRUE){
                        $formerrors[]='This is Email is Not Vaild';
                    }
            }
            
            
                   if(empty($formerrors)){
                
                $check= CheckItem('Username', 'users', $username);
                
                if($check == 1){
                    
                    
                      $formerrors[]='Sorry,This User is Exist';
                    
                    
                } else {
                    
             
         
                
                 //   insert userinfo in DB 
            
             $stmt = $con->prepare("INSERT INTO users (Username,Password,Email,Regstatus,Date) VALUES (:user , :pass , :email , 0 , now() ) ");
             $stmt->execute(array(
                 
                 'user'  =>    $username,
                 'pass'  =>    sha1($paaword),
                 'email' =>    $email,
                 
                 
             ));
           
            
            // echo sucess message 
            
            $succesMsg = 'Congrats, You are no Register user';
             
             
               }
            
            }
            
            
            
            
            
                    
                    
            }
            
        }
        
            




?>

<div class="container login-page">
    <h1 class="text-center"><span class="selected" data-class="login">Login</span> | <span data-class="signup">Signup</span></h1>
    <!-- start login form -->
    <form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="input-contaner">
            <input  class="form-control"   type="text"  name="username"  autocomplete="off" placeholder="Username" required="required" />
        </div>
         <div class="input-contaner">
        <input  class="form-control"   type="password" name="password" autocomplete="new-password" placeholder="Password" required="required" />
         </div>
        <input  class="btn btn-primary btn-block" type="submit" name="login" value="Login" /> 
    </form>
      <!-- end login form -->
      <!-- start signup form -->
    <form class="signup" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="input-contaner">
            <input  pattern=".{4,}"  title="Username Must be 4 chars"  class="form-control"   type="text"  name="username"  autocomplete="off" placeholder="Username" required="required" />
        </div>
        <div class="input-contaner">
            <input  minlength="4"  class="form-control"   type="password" name="password" autocomplete="new-password" placeholder="Type a Complex Password"  required="required" />
        </div>
        <div class="input-contaner">
            <input  minlength="4" class="form-control"   type="password" name="password2" autocomplete="new-password" placeholder="Type a Password agin" required="required"  />
        </div>
        <div class="input-contaner">
            <input  class="form-control"   type="email"  name="email"   placeholder="type a Vaild e-mail"  required="required"  />
        </div>
        <input  class="btn btn-success btn-block" type="submit" name="signup" value="Signup" /> 
    </form> 
      <!-- end signup form -->
</div>
        <div class="the-errors text-center" >
            
            <?php
                if(!empty($formerrors)){
                    foreach ($formerrors as $error) {
                        echo '<div class="msg">'.$error .'</div>';
                    }
                }
                
                if(isset($succesMsg)){
                    echo '<div class="msg">'.$succesMsg.'</div>';
                }
            
            ?>
        </div>



<?php include   $tpl. 'footer.php'; 
 ob_end_flush();
?>
