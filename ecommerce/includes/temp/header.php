<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
      <title><?php  getTitle() ?></title>
        <!--<link href="layout/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="layout/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="layout/css/backend.css" rel="stylesheet" type="text/css"/>-->
        
        <link href="<?php echo $css;  ?>bootstrap.min.css" rel="stylesheet" type="text/css"/>  
        <link href="<?php echo $css;  ?>font-awesome.min.css" rel="stylesheet" type="text/css"/>
         <link href="<?php echo $css;  ?>jquery-ui.css" rel="stylesheet" type="text/css"/>
         <link href="<?php echo $css;  ?>jquery.selectB.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $css;  ?>frontend.css" rel="stylesheet" type="text/css"/>
          
        
        
        
     </head>
    <body>
        <div class="upper-bar">
            <div class="container">
                <?php
                
                if(isset($_SESSION['user'])){  ?>
                 <img  class="my-img img-thumbnail img-circle" src="image.png" alt="">   
                <div class="btn-group my-info">
                    <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <?php echo $ssessonUser ; ?>
                    <span class="caret"></span>
                    </span>
                    <ul class="dropdown-menu">
                        <li><a href="profile.php">My Profile</a></li>
                        <li><a href="newadd.php">new Item</a></li>
                        <li><a href="profile.php#my-info">My Item</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
                
                    <?php
                   
                    echo '<a class="pull-right" href="logout.php">Logout</a>';
                        
                     // User not Active
                   
                }  else {
                        
                    
                ?>
                <a href="login.php"><span class="pull-right"> Login/Signup</span></a>
                    <?php  }  ?>
            </div>
        </div>
        <nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app_nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Home page</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="app_nav">
      <ul class="nav navbar-nav navbar-right">
          <?php
                  $allcat = getAllform( "*" , "categories"   , "where parent = 0" ,"" ,"ID" ,  "ASC"  );
        //   $catogries = getcat();
            foreach ($allcat as $cat){
                echo '<li>
                <a href="Categories.php?pageid='.$cat['ID'].'">'.$cat['Name'].'</a>
                        </li>';
            }
          
          
          ?>
         
      
      </ul>
 
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


       
 
