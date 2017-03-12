<?php

// data source name
$dsn     ='mysql:host=localhost;dbname=shop';
$user    ='root'; 
$pass    ='';
$options =array(
    
    //  define value options to insert ARABIC data
    
    PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',
    
    
);


// connection with PDO(mysql)

try{
    
    $con = new PDO($dsn, $user, $pass , $options);
    
    //  ERROR_MODE
    
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
 
  
    
    
    
    
} catch (PDOException $e){
    
    echo ' failed connection '.$e->getMessage();
    
}
