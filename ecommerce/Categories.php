


 <?php 
 ob_start();
 session_start();
 include 'init.php'; ?>
      

           
<div class="container">
    <h1 class="text-center"> Show Category Items</h1>
    <div class="row">
            <?php
                    
                      //  $category =  isset($_GET['pageid']) && is_numeric($_GET['pageid']) ?  intval($_GET['pageid']) : 0 ;
            
                      if(isset($_GET['pageid']) && is_numeric($_GET['pageid'])){
                            
                         $category =   intval($_GET['pageid']);
                          
                        $allitems = getAllform("*","items","where Cat_id = {$category}","AND Approve = 1 "  ,"item_id");
                foreach ($allitems as $item){
                    echo '<div class="col-sm-6 col-md-3">';
                    echo '<div class="thumbnail item-box">';
                    echo '<span class="price-tag">$'.$item['Price'].'</span>';
                    echo '<img   class="img-responsive" src="image.png" alt="">';
                    echo '<div class="caption">';
                            echo '<h3><a  href="showitem.php?itemid='.$item['item_id'].'">'.$item['name'].'</a></h3>';
                            echo '<p>'.$item['Description'].'</p>';
                             echo '<div class="data">'.$item['Add_date'].'</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                      } else {
                          
                          echo '<div class="alert alert-danger">you cant browser</div>';
                      }
            ?>
    </div>    
</div>


 <?php include   $tpl. 'footer.php';
 ob_end_flush();
 ?>
