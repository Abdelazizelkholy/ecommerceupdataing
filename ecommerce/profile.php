<?php

ob_start();
session_start();
$PageTitle    ='Profile';
include 'init.php';
    if(isset($_SESSION['user'])){
        
        $getUser= $con->prepare("SELECT * FROM users WHERE Username=? ");
        $getUser->execute(array($ssessonUser));
        $info = $getUser->fetch();
        $userid = $info['Userid'];
        
?>

<h1 class="text-center">My Profile</h1>
<div class="information block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">My-Information</div>
            <div class="panel-body">
                <ul class="list-unstyled">
                    <li><i class="fa fa-unlock-alt fa-fw"></i><span>login Name </span>   : <?php echo $info['Username'];  ?> </li>
                    <li><i class="fa fa-envelope-o fa-fw"></i><span> Email</span> : <?php echo $info['Email'];  ?> </li>
                    <li><i class="fa fa-user fa-fw"></i><span> Full Name</span> : <?php echo $info['Fullname'];  ?> </li>
                    <li><i class="fa fa-calendar fa-fw"></i><span> Register Date</span> : <?php echo $info['Date'];  ?> </li>
                    <li><i class="fa fa-tags fa-fw"></i><span>Fav Catrgory </span> : </li>
                </ul>
                <a  href="#" class="btn btn-default ">Edit Information</a>
            </div>
        </div>
    </div>
</div>

<div  id="my-info" class="my-ads block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">My Item</div>
            <div class="panel-body">
                          
            <?php
                        $myitems = getAllform( "*" , "items"   , "where Member_id = $userid  " ,"" ,"item_id"   );
                            if(!empty($myitems)){
                                echo '<div class="row">';
                foreach ($myitems as $item){
                    echo '<div class="col-sm-6 col-md-3">';
                    echo '<div class="thumbnail item-box">';
                        if($item['Approve'] == 0 ){ 
                            echo '<span class="approve-status">Waiting Approve</span>';   }
                    echo '<span class="price-tag">$'.$item['Price'].'</span>';
                    echo '<img   class="img-responsive" src="image.png" alt="">';
                    echo '<div class="caption">';
                            echo '<h3><a href="showitem.php?itemid='.$item['item_id'].'">'.$item['name'].'</a></h3>';
                            echo '<p>'.$item['Description'].'</p>';
                            echo '<div class="data">'.$item['Add_date'].'</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
                            }  else {
                                echo 'Sorry, there is no Ads to show,Greate <a href="newadd.php"> new add</a>';
                                
                            }
            ?>
    </div> 
            </div>
        </div>
    </div>
</div>

<div  class="my-comments block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">Latest-comments</div>
            <div class="panel-body">
                <?php
                
                        $mycomments =getAllform( "comment" , "comments"   , "where Userid = $userid " ,"" ,"c_id"  );
                /*
                        $stmt = $con->prepare("SELECT  comment FROM comments WHERE Userid = ? ");
                    $stmt->execute(array($info['Userid']));
                    $comments = $stmt->fetchAll();
                    */
                    if(!empty($mycomments)){
                        
                        foreach ($mycomments as $comment){
                            echo '<p>'.$comment['comment'].'</p>';
                        }
                        
                    }  else {
                        echo 'No Comments';
                    }
                
                
                ?>
            </div>
        </div>
    </div>
</div>


<?php
         }else {
             header("location:login.php");
             exit();
         }
    
include   $tpl. 'footer.php';
ob_end_flush();
?>