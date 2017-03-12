<?php

ob_start();   //output buffring start 
session_start();



if(isset($_SESSION['username'])){
   
   $PageTitle    ='Dashboard';
    
    include 'init.php';
    
 
        $numUsers = 3 ;
       $latestUsers = getLaTest('*' , 'users' , 'Userid' , $numUsers);
       
       
       
       $numItems = 3 ;
       $latestItems = getLaTest('*' , 'items' , 'item_id' , $numItems);
       
       
       $numcomments = 2;
    
   /* start Dashboard page */
    
    
    
    
    ?>

      <div class="container  home-stats text-center">
         <h1>Dashboard</h1>
         <div class="row">
             <div class="col-lg-3">
                 <div class="stat st-members">
                     
                     <i class="fa fa-users"></i>
                     <div class="info">
                          Total Members
                     <span><a href="members.php"><?php echo CheckItems('Userid', 'users');  ?></a></span>
                         
                     </div>
                 </div>
             </div>
               <div class="col-lg-3">
                 <div class="stat st-pending">
                     <i class="fa fa-user-plus"></i>
                     <div class="info">
                         Pending Members
                     <span><a href="members.php?do=mange&page=pending">
                         
                             <?php echo  CheckItem('Regstatus' , 'users' , '0'); ?>
                             
                             
                         </a></span>
                         
                     </div>
                 </div>
             </div>
               <div class="col-lg-3">
                 <div class="stat st-items">
                     <i class="fa fa-tag"></i>
                     <div class="info">
                         Total Items
                 <span><a href="items.php"><?php echo CheckItems('item_id', 'items');  ?></a></span>
                     </div>
                 </div>
             </div>
               <div class="col-lg-3">
                 <div class="stat st-comments">
                     <i class="fa fa-comments"></i>
                     <div class="info">
                          Total Comments
                          <span><a href="comments.php"><?php echo CheckItems('c_id', 'comments');  ?></a></span>            
                     </div>
                 </div>
             </div>
         </div>
    
     </div>


        <div class="container latest">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-users"></i> Latest <?php echo $numUsers; ?> Register Users
                            <span class=" toggle-info  pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled Latest-users">
                            <?php
                                if(!empty($latestUsers)){
                                foreach ($latestUsers as $users){

                                    echo '<li>'.$users['Username'].'<a href="members.php?do=Edit&Userid='.$users['Userid'].'"><span class="btn btn-success pull-right" ><i class="fa fa-edit"></i> Edit';
                                            
                                             if( $users['Regstatus'] == 0 ){
                                           
                                                
                                                echo ' <a href="members.php?do=Activate&Userid='.$users['Userid'].'" class="btn btn-info pull-right "><i class="fa fa-check"></i> Activate</a> ';

                                            }
                                            
                                            echo '   </span></a></li>';
                                }
                                }  else {
                                    echo ' there\'s no Members to show  ';
                                }
                            ?>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-tag"></i> Latest <?php echo $numItems; ?> Items
                             <span class=" toggle-info  pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                            
                        </div>
                        <div class="panel-body">
                              <ul class="list-unstyled Latest-users">
                            <?php
                                if(!empty($latestItems)){
                                foreach ($latestItems as $item){

                                    echo '<li>'.$item['name'].'<a href="items.php?do=Edit&itemid='.$item['item_id'].'"><span class="btn btn-success pull-right" ><i class="fa fa-edit"></i> Edit';
                                            
                                             if( $item['Approve'] == 0 ){
                                           
                                                
                                                echo ' <a href="items.php?do=Approve&itemid='.$item['item_id'].'" class="btn btn-info pull-right "><i class="fa fa-check"></i> Approve</a> ';

                                            }
                                            
                                            echo '   </span></a></li>';
                                }
                                } else {
                                    echo ' there\'s no Item to show  ';
                                }
                            ?>
                            </ul>
                        </div>
                    </div>
                </div>
                
                
            </div>
            
            <!--   ---------------------->
            
             <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-comments-o"></i> Latest <?php echo $numcomments; ?> Comments
                            <span class=" toggle-info  pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <?php
                             $stmt = $con->prepare("SELECT 
                comments.*,users.Username  
                FROM comments 

                INNER JOIN
                    users
                 ON
                    users.Userid = comments.Userid
                ORDER BY c_id DESC    
                    LIMIT $numcomments
                    ");
                        $stmt->execute();
                        $comments = $stmt->fetchAll();
                        if(!empty($comments)){
                        foreach ($comments as $comment) {
                            echo '<div class="comment-box">';
                            echo '<a href="comments.php?do=Edit&comid='.$comment['c_id'].'"><span class="member-n" >'.$comment['Username'].'</span></a>' ;
                            echo '<p class="member-c" >'.$comment['Comment'].'</p>' ;
                            echo '</div>';
                        }
                        }  else {
                            echo ' there\'s no Comments to show  ';
                        }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>



    <?php
    
   /* Ebd Dashboard page */

    
    
    

include   $tpl. 'footer.php';



    
}  else {
    
    header("location:index.php");
    exit();
    
}
ob_end_flush();