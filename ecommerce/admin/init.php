<?php


include 'connect.php';

        // Routes

$tpl ='includes/temp/';    //temp directory
$lang = 'includes/langs/';
$func ='includes/functions/';
$css ='layout/css/';      // css directory
$js = 'layout/js/';       // js directory




// include important file
include $func.'function.php';
include  $lang. 'eng.php';
include  $tpl. 'header.php';


// include the navbar in all pages expect the one with $nonavbar Variablie

if(!isset($nonavbar)){


include  $tpl. 'navbar.php';
}



   
 

