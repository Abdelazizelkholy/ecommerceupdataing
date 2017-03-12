<?php



$do= ' ';

if(isset($_GET['do'])){
    
     $do = $_GET['do'];
}  else {
    
    $do = 'mange';
}

// if in catgeries page


if( $do == 'mange' ){
    
    echo ' welcome mange catogery page ';
    echo '<a href = "page.php?do=add" > Add new Catogery + </a>';
} elseif ($do == 'add') {
    echo 'welcome add catogery page';
    
}elseif ($do == 'insert') {
    echo 'welcome insert catogery page';
}  else {
    echo 'threr is no page';
}

