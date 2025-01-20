<?php 
    session_start();
    if( empty($_SESSION["email_emp"]) ){
        header("Location: ./login-form.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title> Employee EMS</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="../plugs/css/style.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>

    <style> 
     .hidden {
         display: none;
     }
    </style>

</head>

<body>

  
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
  
     

    <div id="main-wrapper">

       
        <div class="nav-header">
    <div class="nav-control">
    <center> <div class="hamburger">
            <span class="toggle-icon">
                <i class="fa fa-bars"></i>
            </span> 
        </div></center>
    </div>
</div>
       
        <div class="header">    
            <div class="header-content clearfix">
                
                
                
            </div>
        </div>
      
        <div class="nk-sidebar">           
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                   <br> <br>       
                    <li>
                        <a href="./dashboard.php"  >
                        <i class="fa fa-tachometer menu-icon"></i><span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="./leadership.php" >
                        <i class="fa fa-users menu-icon"></i><span class="nav-text">Leadership</span>
                        </a>
                    </li>
                    <li>
                        <a href="./leave-status.php" >
                        <i class="fa fa-calendar menu-icon"></i><span class="nav-text">Leave Status</span>
                        </a>
                    </li>

                    <li>
                        <a href="./apply-leave.php" >
                            <i class="fa fa-paper-plane menu-icon"></i><span class="nav-text">Apply for Leave</span>
                        </a>
                    </li>

                    <li>
                        <a href="./profile.php"  >
                        <i class="fa fa-user-circle menu-icon"></i><span class="nav-text">Profile</span>
                        </a>
                    </li>    
                    <li>
                        <a href="./logout.php" >
                        <i class="fa fa-sign-out menu-icon"></i><span class="nav-text">Logout</span>
                        </a>
                    </li>             
                </ul>
            </div>
        </div>
       
        <div class="content-body">



        <div class="modal fade" id="showModal" data-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div id="modalHead" class="modal-header">
                    <button id="modal_cross_btn" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span  aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <p id="addMsg" class="text-center font-weight-bold"></p>
                </div>
                <div class="modal-footer ">
                    <div class="mx-auto">
                        <a type="button" id="linkBtn" href="#" class="btn btn-primary" >Add</a>
                        <a type="button" id="closeBtn" href="#" data-dismiss="modal" class="btn btn-primary">Close</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
            

            <div class="container-fluid">

            