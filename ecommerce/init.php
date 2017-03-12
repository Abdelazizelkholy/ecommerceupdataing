<?php


    // Reporting error
    ini_set('display_errors', 'on');
    error_reporting(E_ALL);

    $ssessonUser = '';
    if(isset($_SESSION['user'])){
        $ssessonUser = $_SESSION['user'];
    }
    
    
include 'admin/connect.php';

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







   
 

