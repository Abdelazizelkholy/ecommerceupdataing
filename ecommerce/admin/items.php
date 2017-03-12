<?php


ob_start();
session_start();

$PageTitle = 'Items';

if(isset($_SESSION['username'])){

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';
            // start mange page
    
    if($do == 'mange'){
        // mange page
        
   
        
        $stmt = $con->prepare("SELECT items.*, categories.Name  AS cat_name , users.Username FROM items

                                INNER JOIN categories ON categories.ID = items.Cat_id

                                INNER JOIN users ON users.Userid =items.Member_id
                                
                                ORDER BY item_id DESC

                                ");
        $stmt->execute();
        $items = $stmt->fetchAll();
        
        if(!empty($items)){
        
        ?>

                <h1 class="text-center">Mange Items </h1>
                <div class="container">
                    <div class="table-responsive">
                        <table class="main-table  text-center  table table-bordered">
                            <tr>
                                <td>#ID</td>
                                <td>Name</td>
                                <td>Description</td>
                                <td>Price</td>
                                <td>Adding Date</td>
                                <td>Category</td>
                                <td>Username</td>
                                <td>Control</td>
                            </tr>
                         <?php
                                 foreach ($items as $item){
                                     echo '<tr>';
                                     echo '<td>'.$item['item_id'].'</td>';
                                     echo '<td>'.$item['name'].'</td>';
                                     echo '<td>'.$item['Description'].'</td>';
                                     echo '<td>'.$item['Price'].'</td>';
                                     echo '<td>'.$item['Add_date'].'</td>';
                                     echo '<td>'.$item['cat_name'].'</td>';
                                     echo '<td>'.$item['Username'].'</td>';
                                     echo '<td>
                                            <a href="items.php?do=Edit&itemid='.$item['item_id'].'" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                            <a href="items.php?do=Delete&itemid='.$item['item_id'].'" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a> ';
                                            
                                             if( $item['Approve'] == 0 ){
                                           
                                                
                                                echo ' <a href="items.php?do=Approve&itemid='.$item['item_id'].'" class="btn btn-info "><i class="fa fa-check"></i> Approve</a> ';

                                            }
                                     
                                     
                                     echo   '</td>';
                                     echo '</tr>';  
                                 }
                         
                         
                         ?>
                            
                        </table>
                    </div>
                    <a href="items.php?do=Add" class="btn btn-primary" ><i class="fa fa-plus"></i> Add New Item </a>
                </div>
        
                <?php   }  else {
                    echo '<div class="container">';
                    echo '<div  class="alert alert-info" > thert\'s no Items to Show </div>';
                    echo'<a href="items.php?do=Add" class="btn btn-primary" ><i class="fa fa-plus"></i> Add New Item </a>';
                    echo '</div>';
                     } ?>
        <?php
        
        
        
        
        
        
        
    }elseif ($do == 'Add') {
        // Add page 
        ?>

        
              <h1 class="text-center">Add New Item </h1>
                <div class="container">
 
    
                    <form class="form-horizontal" action="?do=insert" method="post">
                       
                    <!--  Name input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text"  name="name" class="form-control" id="inputEmail3" required="required"   placeholder="Name of the Item " >
                  
                </div>
              </div>
                    
                    
                   <!--  Description input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text"  name="description" class="form-control" id="inputEmail3" required="required"   placeholder="Description of the Item " >
                  
                </div>
              </div> 
                   
                   
                     <!--  Price input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Price</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text"  name="price" class="form-control" id="inputEmail3" required="required"   placeholder="Price of the Item " >
                  
                </div>
              </div>  
                     
                           <!--  Country_made input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Country</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text"  name="country" class="form-control" id="inputEmail3"  required="required"   placeholder="Country of Made " >
                  
                </div>
              </div> 
                           
                                        <!--  Status input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Status</label>
                <div class="col-sm-10 col-md-6">
                    <select  name="status">
                        <option value="0">....</option>
                        <option value="1">New</option>
                        <option value="2">Like New</option>
                        <option value="3">Used</option>
                        <option value="4">Old</option>
                    </select>
                  
                </div>
              </div> 
                                        
                                        
                                        
                                                                    <!--  Member input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Member</label>
                <div class="col-sm-10 col-md-6">
                    <select  name="member">
                        <option value="0">....</option>
                        <?php
                        $allMember = getAllform( "*" , "users" , "" ,"" ,"Userid"  );
                        /*
                        $stmt = $con->prepare("SELECT * FROM users ");
                        $stmt->execute();
                        $users = $stmt->fetchAll();
                         
                         */
                        foreach ($allMember as $user){
                            echo "<option value='".$user['Userid']."'>".$user['Username']."</option>";
                        }
                        
                        
                        ?>
                    </select>
                  
                </div>
              </div> 
                                                                    
                                                                    
                                        <!--  categories input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Categories</label>
                <div class="col-sm-10 col-md-6">
                    <select  name="categories">
                        <option value="0">....</option>
                        <?php
                         $allcats = getAllform( "*" , "categories" , "where parent = 0" ,"" ,"ID"  );
                         /*
                        $stmt2 = $con->prepare("SELECT * FROM categories ");
                        $stmt2->execute();
                        $cats = $stmt2->fetchAll();
                          
                          */
                        foreach ($allcats as $cat){
                            echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
                            $allchlid = getAllform( "*" , "categories" , "where parent = {$cat['ID']}" ,"" ,"ID"  );
                            foreach ($allchlid as $chlid){
                                echo "<option value='".$chlid['ID']."'>---".$chlid['Name']."</option>"; 
                            }
                        }
                        
                        
                        ?>
                    </select>
                  
                </div>
              </div> 
                                        
                                                
                           <!--  Country_made input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Tags</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text"  name="tags" class="form-control" id="inputEmail3"     placeholder="Spearte tags With Comma(,) " >
                  
                </div>
              </div> 
                                        

                    
           <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary btn-lg">Add Item </button>
                </div>
              </div>
            </form>
    
    
                </div> 

        <?php
    }elseif ($do == 'insert') {
         // inser page  
   
             
            
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            
              echo '<h1 class="text-center">insert Item</h1>';
              echo '<div class="container">';
                //get variable from the form  
            
            $name                  = $_POST['name'];
            $description           =   $_POST['description'];
            $price                 = $_POST['price'];
            $country               = $_POST['country'];
            $status                = $_POST['status'];
            $member                = $_POST['member'];
            $categories            = $_POST['categories'];
            $tags                  = $_POST['tags'];
            //  validte the form
            
            $formerrors = array();
      
            if(empty($name)){
                
                $formerrors[] = ' Name cant be empty ';
                
            }
             if(empty($description)){
                
                $formerrors[] = ' Description cant be empty ';
                
            }
            
             if(empty($price)){
                
               $formerrors[] = ' Price cant be empty ';
            }
            
             if(empty($country)){
                
                $formerrors[] = ' Country cant be empty ';
            }
             if($status == 0){
                
                $formerrors[] = 'please, you must chose the Status ';
            }
             if($member == 0){
                
                $formerrors[] = 'please, you must chose the member ';
            }
             if($categories == 0){
                
                $formerrors[] = 'please, you must chose the categories ';
            }
            // loop the  empty input
            foreach ($formerrors as $error){
                
                echo '<div class="alert alert-danger" >'. $error. '</div>';
            }
            //  check if there no error update all data 
            
            if(empty($formerrors)){

                 //   insert iteminfo in DB 
            
             $stmt = $con->prepare("INSERT INTO items (name,Description,Price,Country_made,Status,Add_date,Cat_id,Member_id,tags) VALUES (:name , :description , :price , :country, :status , now(), :catid , :memberid , :tags) ");
             $stmt->execute(array(
                 
                 'name'             =>    $name,
                 'description'      =>    $description,
                 'price'            =>    $price,
                 'country'          =>    $country,
                 'status'           =>    $status,
                 'catid'            =>    $categories,
                 'memberid'         =>    $member,
                 'tags'             =>    $tags
             ));
           
            
            // echo sucess message 
            
            $TheMessage =  '<div class="alert alert-success">'.$stmt->rowCount() .' Record Inserted</div> ' ;
                
            Redirecthome($TheMessage , 'back');
               
            
            }
            
           
            
        
    }else {
      //  echo 'sorry,you can not Browse this page ';
            
      echo '<div class="container">';
        
        $TheMessage = '<div class="alert alert-danger" >sorry,you can not Browse this page</div> ';
        Redirecthome($TheMessage);
        echo '</div>';
    }
    echo '</div>';
        
        
        
           
  
    
    
    } elseif ($do == 'Edit') {
        //Edit page
    
            
        // check if get request itemid is_numeric & get integer value of it
        $itemid =  isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
        // select all data depend id 
         $stmt = $con->prepare(" SELECT  * FROM items WHERE item_id=?   ");
                //  execute the query
        $stmt->execute(array($itemid));
        
            // fetch data
        $item = $stmt->fetch();
        // the row count
        $count = $stmt->rowCount();
        
        if($stmt->rowCount() > 0){

        ?>

       <h1 class="text-center">Edit Item </h1>
                <div class="container">
 
    
                    <form class="form-horizontal" action="?do=Update" method="post">
                        <input type="hidden" name="itemid" value="<?php echo $itemid;  ?>" >
                    <!--  Name input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text"  name="name" class="form-control" id="inputEmail3" required="required"   placeholder="Name of the Item " value="<?php echo $item['name']; ?>" >
                  
                </div>
              </div>
                    
                    
                   <!--  Description input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text"  name="description" class="form-control" id="inputEmail3" required="required"   placeholder="Description of the Item " value="<?php echo $item['Description']; ?>" >
                  
                </div>
              </div> 
                   
                   
                     <!--  Price input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Price</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text"  name="price" class="form-control" id="inputEmail3" required="required"   placeholder="Price of the Item " value="<?php echo $item['Price']; ?>" >
                  
                </div>
              </div>  
                     
                           <!--  Country_made input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Country</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text"  name="country" class="form-control" id="inputEmail3"  required="required"   placeholder="Country of Made " value="<?php echo $item['Country_made']; ?>" >
                  
                </div>
              </div> 
                           
                                        <!--  Status input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Status</label>
                <div class="col-sm-10 col-md-6">
                    <select  name="status">
                        <option value="0">....</option>
                        <option value="1" <?php  if($item['Status'] == 1 ) {echo 'selected';}  ?>  >New</option>
                        <option value="2" <?php  if($item['Status'] == 2 ) {echo 'selected';}  ?>>Like New</option>
                        <option value="3" <?php  if($item['Status'] == 3 ) {echo 'selected';}  ?>>Used</option>
                        <option value="4" <?php  if($item['Status'] == 4 ) {echo 'selected';}  ?>>Old</option>
                    </select>
                  
                </div>
              </div> 
                                        
                                        
                                        
                                                                    <!--  Member input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Member</label>
                <div class="col-sm-10 col-md-6">
                    <select  name="member">
                        <option value="0">....</option>
                        <?php
                        $stmt = $con->prepare("SELECT * FROM users ");
                        $stmt->execute();
                        $users = $stmt->fetchAll();
                        foreach ($users as $user){
                            echo "<option value='".$user['Userid']."'" ;  
                            if($item['Member_id'] == $user['Userid'] ) {echo 'selected';}  
                            echo " >".$user['Username']."</option>";
                        }
                        
                        
                        ?>
                    </select>
                  
                </div>
              </div> 
                                                                    
                                                                    
                                        <!--  categories input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Categories</label>
                <div class="col-sm-10 col-md-6">
                    <select  name="categories">
                        <option value="0">....</option>
                        <?php
                        $stmt2 = $con->prepare("SELECT * FROM categories ");
                        $stmt2->execute();
                        $cats = $stmt2->fetchAll();
                        foreach ($cats as $cat){
                            echo "<option value='".$cat['ID']."'";
                            if($item['Cat_id'] == $cat['ID'] ) {echo 'selected';} 
                            echo">".$cat['Name']."</option>";
                        }
                        
                        
                        ?>
                    </select>
                  
                </div>
              </div> 
                                        
                                        
                                                     <!--  Country_made input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Tags</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text"  name="tags" class="form-control" id="inputEmail3"     placeholder="Spearte tags With Comma(,) "  value="<?php echo $item['tags']; ?>" >
                  
                </div>
              </div> 
                                        

                    
           <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary btn-lg">Save Item </button>
                </div>
              </div>
            </form>
    
           <?php          
        $stmt = $con->prepare("SELECT 
                comments.*,users.Username  
                FROM comments 
              
                INNER JOIN
                    users
                 ON
                    users.Userid = comments.Userid
                 WHERE
                    item_id = ?
                    ");
        $stmt->execute(array($itemid));
        $rows = $stmt->fetchAll();
        if(! empty($rows)){
        
        ?>

                <h1 class="text-center">Mange [ <?php echo $item['name']; ?> ] Comment </h1>
               
                    <div class="table-responsive">
                        <table class="main-table  text-center  table table-bordered">
                            <tr>
                                <td>Comment</td>
                                <td>User Name</td>
                                <td>Add Date</td>
                                <td>Control</td>
                            </tr>
                         <?php
                                 foreach ($rows as $row){
                                     echo '<tr>';
                                     echo '<td>'.$row['Comment'].'</td>';
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
                   
                <?php
                
                
        }
                
                ?>
                    
                    
    
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
      
        
          echo '<h1 class="text-center">Update Item</h1>';
             echo '<div class="container">';
        
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            
            
            
                //get variable from the form  
            $id                = $_POST['itemid'];
            $name              = $_POST['name'];
            $description       = $_POST['description'];
            $price             = $_POST['price'];
            $country           = $_POST['country'];
            $status            = $_POST['status'];
            $member            = $_POST['member'];
            $categories        = $_POST['categories'];
            $tags              = $_POST['tags'];
    
           
            // valdation
            $formerrors = array();
      
            if(empty($name)){
                
                $formerrors[] = ' Name cant be empty ';
                
            }
             if(empty($description)){
                
                $formerrors[] = ' Description cant be empty ';
                
            }
            
             if(empty($price)){
                
               $formerrors[] = ' Price cant be empty ';
            }
            
             if(empty($country)){
                
                $formerrors[] = ' Country cant be empty ';
            }
             if($status == 0){
                
                $formerrors[] = 'please, you must chose the Status ';
            }
             if($member == 0){
                
                $formerrors[] = 'please, you must chose the member ';
            }
             if($categories == 0){
                
                $formerrors[] = 'please, you must chose the categories ';
            }
            // loop the  empty input
            foreach ($formerrors as $error){
                
                echo '<div class="alert alert-danger" >'. $error. '</div>';
            }
            //  check if there no error update all data 
            
            if(empty($formerrors)){
                
                
                 //   update the DB with this info  
            
             
            $stmt = $con->prepare(" UPDATE   items SET  name=? , Description=? , Price=? , Country_made=? , Status=? , Cat_id=? , Member_id=? , tags=? WHERE item_id=?  ");
    
            $stmt->execute(array($name,$description,$price,$country,$status,$categories,$member,$tags,$id));
            
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
        
        
          echo '<h1 class="text-center">Delete Item</h1>';
             echo '<div class="container">';
        
        
         $itemid =  isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
        // select all data depend id 
      //   $stmt = $con->prepare(" SELECT  * FROM users WHERE Userid=?  LIMIT 1 ");
                //  execute the query
         
         $check = CheckItem('item_id' , 'items' , $itemid);
         
         
         
    //    $stmt->execute(array($Userid));
        
           
          // the row count
    //    $count = $stmt->rowCount();
        
        if($check > 0){
        
            $stmt = $con->prepare("DELETE FROM items WHERE item_id= :itemid ");
            $stmt->bindParam(":itemid",$itemid);
            $stmt->execute();
            
            $TheMessage =  '<div class="alert alert-success">'.$stmt->rowCount() .' Record Deleted</div> ' ;
            
           Redirecthome($TheMessage , 'back');
            
        }  else {
            
            $TheMessage = '<div class="alert alert-danger">this ID not found</div> ';  
            Redirecthome($TheMessage);
            
        }
       
       
        echo '</div>'; 
        
        
        
        
        
        
        
        
}elseif ($do == 'Approve') {
    
      
          echo '<h1 class="text-center">Approve Item</h1>';
             echo '<div class="container">';
        
        
         $itemid =  isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
        // select all data depend id 
      //   $stmt = $con->prepare(" SELECT  * FROM users WHERE Userid=?  LIMIT 1 ");
                //  execute the query
         
         $check = CheckItem('item_id' , 'items' , $itemid);
         
         
         
    //    $stmt->execute(array($Userid));
        
           
          // the row count
    //    $count = $stmt->rowCount();
        
        if($check > 0){
        
            $stmt = $con->prepare("UPDATE  items SET Approve= 1 WHERE item_id=? ");
            
            $stmt->execute(array($itemid));
            
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

