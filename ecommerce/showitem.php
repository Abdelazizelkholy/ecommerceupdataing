<?php


ob_start();
session_start();
$PageTitle    ='Show Items';
include 'init.php';
   
     // check if get request itemid is_numeric & get integer value of it
        $itemid =  isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
        // select all data depend id 
         $stmt = $con->prepare(" SELECT items.*, categories.Name  AS cat_name , users.Username FROM items

                                INNER JOIN categories ON categories.ID = items.Cat_id

                                INNER JOIN users ON users.Userid =items.Member_id
                                WHERE 
                                    item_id=? 
                                AND
                                    Approve = 1");
                //  execute the query
        $stmt->execute(array($itemid));
        
        
        $count = $stmt->rowCount();
        
        if($count > 0){
        
            // fetch data
        $item = $stmt->fetch();     
       
        
?>

<h1 class="text-center"><?php echo $item['name']; ?></h1>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <img   class="img-responsive img-thumbnail center-block" src="image.png" alt="">
        </div>
        <div class="col-md-9 item-info">
            <h2><?php echo  $item['name'] ; ?></h2>
            <p><?php echo  $item['Description'] ; ?></p>
            <ul class="list-unstyled">
                <li><i class="fa fa-calendar fa-fw"></i><span>Added date</span> :<?php echo  $item['Add_date'] ; ?></li>
                <li><i class="fa fa-money fa-fw"></i><span>Price</span> : $<?php echo  $item['Price'] ; ?></li>
                <li><i class="fa fa-building fa-fw"></i><span>Made In</span> : <?php echo  $item['Country_made'] ; ?></li>
                <li><i class="fa fa-tags fa-fw"></i><span>Category </span>:<a href="Categories.php?pageid=<?php echo $item['Cat_id']; ?>"><?php echo $item['cat_name']; ?></a> </li>
                <li><i class="fa fa-user-o fa-fw"></i><span>Add By</span>:<a href="#"><?php echo $item['Username']; ?></a> </li>
                <li class="items-show"><i class="fa fa-user-o fa-fw "></i><span>Tags</span>:
                <?php
                        
                        $alltags=  explode(",", $item['tags']);
                        foreach ($alltags as $tag) {
                            $tag=  str_replace(' ', '', $tag);
                            $lowertag= strtolower($tag);
                            
                                if(!empty($tag)){
                        echo "<a href='tags.php?name={$lowertag}'>".$tag.'</a>  ' ;
                        }
                        }
                ?>
                </li>
            </ul>
        </div>
    </div>
    <hr class="custom-hr">
    <?php
            if(isset($_SESSION['user'])){
    ?>
    <div class="row">
        <div class="col-md-offset-3">
            <div class="add-comment">
            <h3>Add Your Comment</h3>
            <form action="<?php echo $_SERVER['PHP_SELF'] .'?itemid=' .$item['item_id'] ;?>" method="post">
                <textarea name="comment" required="required"></textarea>
                <input  class="btn btn-primary" type="submit" value="Add Comment">
            </form>
            <?php
                     if($_SERVER["REQUEST_METHOD"]=="POST"){
                         
                        $comment   =  filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
                        $itemid    =$item['item_id'];
                        $userid    =$_SESSION['uid'];
                      
                       
                      if(!empty($comment)){
                           
                           $stmt = $con->prepare("INSERT INTO comments (Comment,Status,Comment_date,item_id,Userid) VALUES (:comment , 0 , now() , :itemid , :userid  ) ");
                           $stmt->execute(array(
                 
                                    'comment'  =>    $comment,
                                    'itemid'  =>     $itemid,
                                    'userid' =>     $userid
                                    
                 
                                 ));
                           
                           if($stmt){
                               echo '<div class="alert alert-success">Comment Added</div>';
                           }  
                           
                       }
                  
                     }
            
            ?>
            
            </div>
        </div>
    </div>
    <?php
    
            }  else {
                echo '<a href="login.php">Login</a> or <a href="login.php">Register</a> to add Comment';
            }
    ?>
    <hr class="custom-hr">
                    <?php
            $stmt = $con->prepare("SELECT 
                comments.*,users.Username  
                FROM comments 
                INNER JOIN
                    users
                 ON
                    users.Userid = comments.Userid
                WHERE
                    item_id =?
                AND
                    Status = 1
                 ORDER BY c_id DESC 
                    ");
      
                 $stmt->execute(array($item['item_id']));
                     $comments = $stmt->fetchAll();
            ?>
    
    
        <?php
                 
                    
                foreach ($comments as $comment){ ?>
    <div class="comment-box"> 
                    <div class="row">
                        
                        <div class="col-sm-2 text-center">
                            <img   class="img-responsive img-thumbnail img-circle center-block" src="image.png" alt="">
                            <?php echo $comment['Username']; ?>
                        </div>
                        <div class="col-sm-10">
                            <p class="lead">
                            <?php echo $comment['Comment']; ?>
                            </p>
                        </div>
                   
                    </div>
    </div>
    <hr class="custom-hr">
              <?php  }  ?>
        
        
       
        
        
    </div>


<?php
        }  else {
            echo '<div class="container"><div class="alert alert-danger">there is no Such id Or this Item waitaing Approval</div></div>';
}
    
include   $tpl. 'footer.php';
ob_end_flush();
?>