<?php




ob_start();
session_start();

$PageTitle = 'Categories';

if(isset($_SESSION['username'])){

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';
            // start mange page
    
    if($do == 'mange'){
        // mange page
        
        $sort = 'ASC';
        
        $sort_array = array('ASC','DESC');
       
        if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){
            
            $sort = $_GET['sort'];
        }
       
        
        $stmt2 = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY Ordring $sort");
        $stmt2->execute();
        $cats = $stmt2->fetchAll();
        
        if(!empty($cats)){
        
        ?>

            <h1 class="text-center">Mange categories</h1>
            <div class="container  categories ">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-edit"></i>  Mange categories
                        <div class="option pull-right">
                            <i class="fa fa-sort"></i> Ordring:[
                            <a  class="<?php if($sort == 'ASC'){echo 'active' ;}   ?>"  href="?sort=ASC">Asc</a> |
                            <a   class="<?php if($sort == 'DESC'){echo 'active' ;}   ?>" href="?sort=DESC">Desc</a> ]
                            <i class="fa fa-eye"></i> View: [
                            <span class="active" data-view="full">full</span> |
                            <span data-view="classic">Classic</span> ]
                            
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                                foreach ($cats as $cat){
                                            echo "<div class='cat'>";
                                            echo "<div class='hidden-button'>";
                                            echo "<a href='Categories.php?do=Edit&catid=".$cat['ID']."' class='btn btn-xs btn-success'><i class='fa fa-edit'></i>Edit</a>";
                                            echo "<a href='Categories.php?do=Delete&catid=".$cat['ID']."' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
                                            echo "</div>";
                                            echo "<h3>".$cat['Name']."</h3>";
                                            echo "<div class='full-view'>";
                                            echo "<p>"; if($cat['Description'] == ''){ echo 'This is Category Empty'; }else{ echo $cat['Description'] ; }  echo "</p>";
                                             if($cat['Visiblity'] == 1){  echo '<span class="visiblity"><i class="fa fa-eye"></i>Hidden</span>';}
                                             if($cat['Allow_comment'] == 1){  echo '<span class="comment"><i class="fa fa-close"></i>Comment Disable</span>' ;}
                                              if($cat['Allow_Ads'] == 1){  echo '<span class="ads"><i class="fa fa-close"></i>Ads Disable</span>';}
                                            echo "</div>";
                                                                     //get child gaterories
                                            $chlidcats = getAllform( "*" , "categories"   , "where parent = {$cat['ID']}" ,"" ,"ID" ,  "ASC"  );
                                                        
                                                if(!empty($chlidcats)){
                                                    
                                                    echo "<h4 class='chlid-head'>Chlid Parent</h4>";
                                                    
                                                    foreach ($chlidcats as $c){
                                                        echo "<ul class='list-unstyled chlid-cat'>";
                                                        echo  "<li class='chlid-link'>
                                                        <a href='Categories.php?do=Edit&catid=".$c['ID']."' >".$c['Name']."</a>
                                                        <a href='Categories.php?do=Delete&catid=".$c['ID']."' class='show-delete confirm '>Delete</a>       
                                                                </li>";
                                                                
                                                                
                                                               
                                                    }
                                                    echo "</ul>";
                                                     
                                                }
                                            
                                            
                                            
                                    echo "</div>";
                                     
                                           
                                            echo "<hr>";   
                                }
                                           
                                
                        
                        ?>
                    </div>
                </div>
              <a  class="add-category  btn btn-primary" href="Categories.php?do=Add" ><i class="fa fa-plus"></i> Add New Gategory</a>

            </div>
            
        <?php }  else {
                     echo '<div class="container">';
                    echo '<div  class="alert alert-info" > there\'s no Category to Show </div>';
                    echo'<a  class="add-category  btn btn-primary" href="Categories.php?do=Add" ><i class="fa fa-plus"></i> Add New Gategory</a>';
                    echo '</div>';    
                    } ?>
        
      <?php  
    }elseif ($do == 'Add') {
        // Add page
       
        
        ?>


              <h1 class="text-center">Add New Category </h1>
                <div class="container">
 
    
                    <form class="form-horizontal" action="?do=insert" method="post">
                       
                    <!--  Name input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text"  name="name" class="form-control" id="inputEmail3"    autocomplete="off" required="required" placeholder="Name of the Category " >
                  
                </div>
            
              </div>
                    <!--  Description input  -->
              <div class="form-group form-group-lg">
                <label for="inputPassword3" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10 col-md-6">
                    
                    <input type="text" name="description" class=" form-control" id="inputPassword3"   placeholder=" description the Catogery  ">
                    
                </div>
              </div>
                    <!--  Ordring input  -->
                    <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Ordring</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text"  name="ordring" class="form-control" id="inputEmail3"   placeholder="Ordring to Arrang the Catogery ">
               
                </div>
              </div>
                    
                       <!--  cat type input  -->
                    <div class="form-group form-group-lg">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Parent?  </label>
                <div class="col-sm-10 col-md-6">
                    <select name="parent">
                        <option value="0">None</option>
                        <?php
                            $mycat = getAllform( "*" , "categories" , "where parent = 0" ,"" ," ID","ASC"  );
                            foreach ($mycat as $cat){
                                echo "<option value='".$cat['ID']."' >".$cat['Name']."</option>";
                            }
                        
                        ?>
                    </select>
               
                </div>
              </div>
                    
                    <!--  Visiblity input  -->
                    <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Visiblie</label>
                <div class="col-sm-10 col-md-6">
                    <div>
                        <input  id="vis-yes" type="radio" value="0"  name="Visiblity" checked />
                        <label for="vis-yes">Yes</label>
                    </div>
                     <div>
                        <input  id="vis-no" type="radio" value="1"  name="Visiblity"  />
                        <label for="vis-no">No</label>
                    </div>
                </div>
              </div>
                    <!--  Commenting input  -->
                         <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Allow Commenting</label>
                <div class="col-sm-10 col-md-6">
                    <div>
                        <input  id="com-yes" type="radio" value="0"  name="Commenting" checked />
                        <label for="com-yes">Yes</label>
                    </div>
                     <div>
                        <input  id="com-no" type="radio" value="1"  name="Commenting"  />
                        <label for="com-no">No</label>
                    </div>
                </div>
              </div>
                    
                    
                     <!--  ads input  -->
                         <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Allow Ads</label>
                <div class="col-sm-10 col-md-6">
                    <div>
                        <input  id="ads-yes" type="radio" value="0"  name="ads" checked />
                        <label for="ads-yes">Yes</label>
                    </div>
                     <div>
                        <input  id="ads-no" type="radio" value="1"  name="ads"  />
                        <label for="ads-no">No</label>
                    </div>
                </div>
              </div>
                    
                    
              
              
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary btn-lg">Add Category </button>
                </div>
              </div>
            </form>
    
    
                </div> 






        


<?php
    }elseif ($do == 'insert') {
         // insert page 
        
                
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            
              echo '<h1 class="text-center">insert Category</h1>';
              echo '<div class="container">';
                //get variable from the form  
            
            $name                   = $_POST['name'];
            $description            =   $_POST['description'];
            $parent                 =   $_POST['parent'];
            $order                  = $_POST['ordring'];
            $Visiblity              = $_POST['Visiblity'];
            $comment                = $_POST['Commenting'];
            $ads                    = $_POST['ads'];
            
                    // check if Category in Exist in DB
                $check= CheckItem('Name', 'categories', $name);
                
                if($check == 1){
                    
                    
                    $TheMessage = '<div class="alert alert-danger">sorry,this Category exist</div>';
                    Redirecthome($TheMessage ,'back' );
                    
                } else {
 
                 //   insert categoryinfo in DB 
            
             $stmt = $con->prepare("INSERT INTO categories (Name,Description,parent,Ordring,Visiblity,Allow_comment,Allow_Ads) VALUES (:name , :description ,:parent ,:order , :Visiblity , :comment ,:ads  ) ");
             $stmt->execute(array(
                 
                 'name'           =>    $name,
                 'description'    =>    $description,
                 'parent'         =>    $parent,
                 'order'          =>    $order,
                 'Visiblity'      =>    $Visiblity,
                 'comment'        =>    $comment,
                 'ads'            =>    $ads
                 
             ));
           
            
            // echo sucess message 
            
            $TheMessage =  '<div class="alert alert-success">'.$stmt->rowCount() .' Record Inserted</div> ' ;
                
            Redirecthome($TheMessage,'back');
               }
            
            
            
           
            
        
    }else {
      //  echo 'sorry,you can not Browse this page ';
            
      echo '<div class="container">';
        
        $TheMessage = '<div class="alert alert-danger" >sorry,you can not Browse this page</div> ';
        Redirecthome($TheMessage,'back');
        echo '</div>';
    }
    echo '</div>';
        
        
        
   
           
  
    
    
    } elseif ($do == 'Edit') {
        //Edit page
    
    
           
          // check if get request Categories is_numeric & get integer value of it
        $catid =  isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;
        // select all data depend id 
         $stmt = $con->prepare(" SELECT  * FROM categories WHERE ID=?  ");
                //  execute the query
        $stmt->execute(array($catid));
        
            // fetch data
        $cat = $stmt->fetch();
        // the row count
        $count = $stmt->rowCount();
        
        if($stmt->rowCount() > 0){

        ?>

             
       <h1 class="text-center">Edit Category </h1>
                <div class="container">
 
    
                    <form class="form-horizontal" action="?do=Update" method="post">
                        <input type="hidden" name="catid" value="<?php echo $catid;  ?>" >
                    <!--  Name input  -->
              <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text"  name="name" class="form-control" id="inputEmail3"    required="required" placeholder="Name of the Category " value="<?php echo $cat['Name'];  ?>"  >
                  
                </div>
            
              </div>
                    <!--  Description input  -->
              <div class="form-group form-group-lg">
                <label for="inputPassword3" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10 col-md-6">
                    
                    <input type="text" name="description" class=" form-control" id="inputPassword3"   placeholder=" description the Catogery "   value="<?php echo $cat['Description'];  ?>">
                    
                </div>
              </div>
                    <!--  Ordring input  -->
                    <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Ordring</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text"  name="ordring" class="form-control" id="inputEmail3"   placeholder="Ordring to Arrang the Catogery " value="<?php echo $cat['Ordring'];  ?>">
               
                </div>
              </div>
                    
                    
                       <!--  cat type input  -->
                    <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label"> Parent?  </label>
                <div class="col-sm-10 col-md-6">
                    <select name="parent">
                        <option value="0">None</option>
                        <?php
                            $mycat = getAllform( "*" , "categories" , "where parent = 0" ,"" ," ID","ASC"  );
                            foreach ($mycat as $c){
                                echo "<option value='".$c['ID']."' ";
                                        
                                    if(  $cat['parent'] == $c['ID'] ){   echo 'selected'; }
                                
                                echo " >".$c['Name']."</option>";
                            }
                        
                        ?>
                    </select>
               
                </div>
              </div>
                    
                    
                    
                    
                    <!--  Visiblity input  -->
                    <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Visiblie</label>
                <div class="col-sm-10 col-md-6">
                    <div>
                        <input  id="vis-yes" type="radio" value="0"  name="Visiblity" <?php  if($cat['Visiblity'] == 0){ echo 'checked'; }   ?>  />
                        <label for="vis-yes">Yes</label>
                    </div>
                     <div>
                        <input  id="vis-no" type="radio" value="1"  name="Visiblity" <?php  if($cat['Visiblity'] == 1){ echo 'checked'; }   ?>   />
                        <label for="vis-no">No</label>
                    </div>
                </div>
              </div>
                    <!--  Commenting input  -->
                         <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Allow Commenting</label>
                <div class="col-sm-10 col-md-6">
                    <div>
                        <input  id="com-yes" type="radio" value="0"  name="Commenting" <?php  if($cat['Allow_comment'] == 0){ echo 'checked'; }   ?> />
                        <label for="com-yes">Yes</label>
                    </div>
                     <div>
                        <input  id="com-no" type="radio" value="1"  name="Commenting"  <?php  if($cat['Allow_comment'] == 1){ echo 'checked'; }   ?> />
                        <label for="com-no">No</label>
                    </div>
                </div>
              </div>
                    
                    
                     <!--  ads input  -->
                         <div class="form-group form-group-lg">
                <label for="inputEmail3" class="col-sm-2 control-label">Allow Ads</label>
                <div class="col-sm-10 col-md-6">
                    <div>
                        <input  id="ads-yes" type="radio" value="0"  name="ads" <?php  if($cat['Allow_Ads'] == 0){ echo 'checked'; }   ?> />
                        <label for="ads-yes">Yes</label>
                    </div>
                     <div>
                        <input  id="ads-no" type="radio" value="1"  name="ads" <?php  if($cat['Allow_Ads'] == 1){ echo 'checked'; }   ?> />
                        <label for="ads-no">No</label>
                    </div>
                </div>
              </div>
                    
                    
              
              
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary btn-lg">Save  </button>
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
        
        
        
          echo '<h1 class="text-center">Update Category</h1>';
             echo '<div class="container">';
        
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            
            
            
                //get variable from the form  
            $id                = $_POST['catid'];
            $name              = $_POST['name'];
            $description       = $_POST['description'];
            $order             = $_POST['ordring'];
            $parent             = $_POST['parent'];
            $Visiblity         = $_POST['Visiblity'];
            $comment           = $_POST['Commenting'];
            $ads               = $_POST['ads'];
            
         
 
                 //   update the DB with this info  
            
             
            $stmt = $con->prepare(" UPDATE   categories SET  Name=? , Description=? , Ordring=?,parent=? , Visiblity=?  , Allow_Comment=? , Allow_Ads=? WHERE ID=?  ");
    
            $stmt->execute(array($name,$description,$order,$parent,$Visiblity,$comment,$ads,$id));
            
            // echo sucess message 
            
            $TheMessage =  '<div class="alert alert-success">'.$stmt->rowCount() .' Record Update</div> ' ;
               
            Redirecthome($TheMessage,'back');
            
 
    }else {
        
        $TheMessage = '<div class="alert alert-danger">sorry,you can not Browse this page</div> ';
          Redirecthome($TheMessage);
          
    }
    echo '</div>';
        
        
        
        
        
      
       
         
         
    } elseif ($do == 'Delete') {
        
        
            echo '<h1 class="text-center">Delete Category</h1>';
             echo '<div class="container">';
        
        
         $catid =  isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;
        // select all data depend id 
      //   $stmt = $con->prepare(" SELECT  * FROM users WHERE Userid=?  LIMIT 1 ");
                //  execute the query
         
         $check = CheckItem('ID' , 'categories' , $catid);
         
         
         
    //    $stmt->execute(array($Userid));
        
           
          // the row count
    //    $count = $stmt->rowCount();
        
        if($check > 0){
        
            $stmt = $con->prepare("DELETE FROM categories WHERE ID= :id ");
            $stmt->bindParam(":id",$catid);
            $stmt->execute();
            
            $TheMessage =  '<div class="alert alert-success">'.$stmt->rowCount() .' Record Deleted</div> ' ;
            
           Redirecthome($TheMessage,'back');
            
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
