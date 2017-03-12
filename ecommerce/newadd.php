<?php


ob_start();
session_start();
$PageTitle    ='Create New Item';
include 'init.php';
    if(isset($_SESSION['user'])){
        
        
        
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            
           $formerrors=array();
           
           $name            =  filter_var( $_POST['name'] , FILTER_SANITIZE_STRING);
           $description     = filter_var( $_POST['description'],FILTER_SANITIZE_STRING);
           $price           = filter_var( $_POST['price'],FILTER_SANITIZE_NUMBER_INT);
           $country         = filter_var( $_POST['country'],FILTER_SANITIZE_STRING);
           $status          = filter_var( $_POST['status'],FILTER_SANITIZE_NUMBER_INT);
           $categories      = filter_var( $_POST['categories'],FILTER_SANITIZE_NUMBER_INT);
           $tags            = filter_var( $_POST['tags'],FILTER_SANITIZE_STRING);
           
                    if(strlen($name) < 4){
                        
                        $formerrors[] = ' Item Title Must Be At Least 4 chars ';
                    }
                    if(strlen($description) < 10){
                        
                        $formerrors[] = ' Item description Must Be At Least 10 chars ';
                    }
                    if(strlen($country) < 2){
                        
                        $formerrors[] = ' Item country Must Be At Least 2 chars ';
                    }
                    if(empty($price)){
                        $formerrors[] = 'Item Price Must Be Not Empty';
                    }
                    if(empty($status)){
                        $formerrors[] = 'Item status Must Be Not Empty';
                    }
                    if(empty($categories)){
                        $formerrors[] = 'Item categories Must Be Not Empty';
                    }
                    
                    
                       if(empty($formerrors)){

                 //   insert iteminfo in DB 
            
             $stmt = $con->prepare("INSERT INTO items (name,Description,Price,Country_made,Status,Add_date,Cat_id,Member_id,tags) VALUES (:name , :description , :price , :country, :status , now(), :catid , :memberid , :tags ) ");
             $stmt->execute(array(
                 
                 'name'             =>    $name,
                 'description'      =>    $description,
                 'price'            =>    $price,
                 'country'          =>    $country,
                 'status'           =>    $status,
                 'catid'            =>    $categories,
                 'memberid'         =>    $_SESSION['uid'],
                 'tags'             =>    $tags
             ));
           
            
            // echo sucess message 
            
                      if($stmt){
                            $succesMsg = 'Item Added';
                      }
                
            
            }
                    
                    
           
        }
    
?>

<h1 class="text-center"><?php echo $PageTitle; ?></h1>
<div class="Create-add block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading"><?php echo $PageTitle; ?></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        
                        <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                       
                    <!--  Name input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-3 control-label">Name</label>
                <div class="col-sm-10 col-md-9">
                    <input type="text"  name="name" class="form-control live" id="inputEmail3"   placeholder="Name of the Item " data-class=".live-title" required="required" >
                  
                </div>
              </div>
                    
                    
                   <!--  Description input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-3 control-label">Description</label>
                <div class="col-sm-10 col-md-9">
                    <input type="text"  name="description" class="form-control live" id="inputEmail3"   placeholder="Description of the Item " data-class=".live-desc" required="required" >
                  
                </div>
              </div> 
                   
                   
                     <!--  Price input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-3 control-label">Price</label>
                <div class="col-sm-10 col-md-9">
                    <input type="text"  name="price" class="form-control live" id="inputEmail3"    placeholder="Price of the Item "  data-class=".live-price" required="required">
                  
                </div>
              </div>  
                     
                           <!--  Country_made input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-3 control-label">Country</label>
                <div class="col-sm-10 col-md-9">
                    <input type="text"  name="country" class="form-control" id="inputEmail3"     placeholder="Country of Made " required="required" >
                  
                </div>
              </div> 
                           
                                        <!--  Status input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-3 control-label">Status</label>
                <div class="col-sm-10 col-md-9">
                    <select  name="status" required="required">
                        <option value="">....</option>
                        <option value="1">New</option>
                        <option value="2">Like New</option>
                        <option value="3">Used</option>
                        <option value="4">Old</option>
                    </select>
                  
                </div>
              </div> 
                                                     
                                        <!--  categories input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-3 control-label">Categories</label>
                <div class="col-sm-10 col-md-9">
                    <select  name="categories" required="required">
                        <option value="">....</option>
                        <?php
                        
                        /*
                        $stmt2 = $con->prepare("SELECT * FROM categories ");
                        $stmt2->execute();
                        $cats = $stmt2->fetchAll();
                         
                         */
                            $cats = getAllform('*','categories','','','ID');
                        foreach ($cats as $cat){
                            echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
                        }
                        
                        
                        ?>
                    </select>
                  
                </div>
              </div> 
                                        
                                                     <!--  Country_made input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-3 control-label">Tags</label>
                <div class="col-sm-10 col-md-9">
                    <input type="text"  name="tags" class="form-control" id="inputEmail3"     placeholder="Spearte tags With Comma(,) " >
                  
                </div>
              </div> 
                                        

                    
           <div class="form-group">
                <div class="col-sm-offset-3 col-sm-10">
                  <button type="submit" class="btn btn-primary btn-md">Add Item </button>
                </div>
              </div>
            </form>
                        
                        
                        
                        
                    </div>
                    <div class="col-md-4">
                         <div class="thumbnail item-box live-preview">
                             <span class="price-tag ">
                                 $ <span class="live-price">
                                     0
                                 </span>  
                              
                             </span>
                            <img   class="img-responsive" src="image.png" alt="">
                            <div class="caption">
                                <h3 class="live-title">test</h3>
                                <p class="live-desc">Description</p>
                            </div>
                    </div>
                    </div>
                </div>
                <?php
                    if(!empty($formerrors)){
                        foreach ($formerrors as $errors) {
                            
                            echo '<div class="alert alert-danger">'.$errors.'</div>';
                            
                        }
                    }
                    if(isset($succesMsg)){
                    echo '<div class="alert alert-success">'.$succesMsg.'</div>';
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
