<?php                                                                           
include('includes/functions.php');
if(!isset($_SESSION['adminId'])){
    //header("Location:".admin_url()."login.php");
	echo "<script>location.href='login.php'</script>";
}

$userrole =  $_SESSION['cur_user'];
$curFileName = currentFileName();
$adminId = $_SESSION['adminId'];
global $prbsl;
//$curFileName="";



?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Morphe forma</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=admin_url()?>css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=admin_url()?>css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=admin_url()?>css/ionicons.min.css">
  <!--<link rel="stylesheet" href="<?=admin_url()?>/css/jquery-ui.min.css">
   Theme style -->
  <link rel="stylesheet" href="<?=admin_url()?>css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?=admin_url()?>css/style.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?=admin_url()?>css/_all-skins.min.css">
  <link rel="stylesheet" href="<?=admin_url()?>css/blue.css">
  <link rel="stylesheet" href="<?=admin_url()?>css/bootstrap-datetimepicker.min.css">
  <script src="https://cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
  
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="<?=admin_url()?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Morphe forma</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b> Morphe forma</b></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
        <div class="navbar-custom-menu pull-left">
            <ul class="nav navbar-nav">
                <!--<li><a href="about">About</a></li>-->
            </ul>
        </div>    
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
         
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?=admin_url()?>images/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">Morphe forma Admin</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?=admin_url()?>images/user2-160x160.jpg" class="img-circle" alt="User Image">
              <p>
                 Admin
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="change_password.php" class="btn btn-default btn-flat">Change Password</a>
                </div>
                <div class="pull-right">
                  <a href="login.php?action=logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
     <!--sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
           <!--Sidebar user panel -->
           <div class="user-panel">
            <div class="pull-left image">
              <img src="<?=admin_url()?>images/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p> Admin</p>
            </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
                <li class="header">MAIN NAVIGATION</li>
                
               <!-- <li class="<?=($curFileName == 'users-list.php')?'active':''?>">
                  <a href="<?=admin_url()?>users-list.php">
                  <i class="fa fa-users"></i>
                     <span>Users</span> 
                  </a>
                </li>-->
                <li class="<?=($curFileName == 'slider.php')?'active':''?>">
					<a href="<?=admin_url()?>slider.php">
                  <i class="fa fa-picture-o"></i>
                     <span>Slider</span> 
                  </a>
                </li>
				  <li class="<?=($curFileName == 'banner.php')?'active':''?>">
					<a href="<?=admin_url()?>banner.php">
                  <i class="fa fa-picture-o"></i>
                     <span>Banner</span> 
                  </a>
                </li>
				<li class="<?=($curFileName == 'home.php')?'active':''?>">
					<a href="<?=admin_url()?>home.php">
                  <i class="fa fa-home"></i>
                     <span>Home</span> 
                  </a>
                </li>
				<li class="<?=($curFileName == 'home_service.php')?'active':''?>">
					<a href="<?=admin_url()?>home_service.php">
                  <i class="fa fa-home"></i>
                     <span>Home services</span> 
                  </a>
                </li>
				<li class="<?=($curFileName == 'services.php')?'active':''?>">
					<a href="<?=admin_url()?>services.php">
                  <i class="fa fa-smile-o"></i>
                     <span>Services</span> 
                  </a>
                </li>
                <li class="<?=($curFileName == 'aboutus.php')?'active':''?>">
					<a href="<?=admin_url()?>aboutus.php">
                  <i class="fa fa-user"></i>
                     <span>About us</span> 
                  </a>
                </li>
				<li class="<?=($curFileName == 'portfolio.php')?'active':''?>">
					<a href="<?=admin_url()?>portfolio.php">
						<i class="fa fa-picture-o"></i>
                     <span>Portfolio
               </span> 
                  </a>
                </li>
				<li class="<?=($curFileName == 'countact-us.php')?'active':''?>">
                  <a href="<?=admin_url()?>contact-us.php">
                  <i class="fa fa-phone"></i>
                     <span>Contact Us</span> 
                  </a>
                </li>
				<li class="<?=($curFileName == 'footer_content.php')?'active':''?>">
					<a href="<?=admin_url()?>footer_content.php">
                  <i class="fa fa-smile-o"></i>
                     <span>Footer</span> 
                  </a>
                </li>
				<li>
					<a href="login.php?action=logout">
                  <i class="fa fa-sign-out"></i>
                     <span>Sign Out</span> 
                  </a>
                </li>
				 <!--<li class="<?=($curFileName == 'privacy_policy.php')?'active':''?>">
					<a href="<?=admin_url()?>privacy_policy.php">
                  <i class="fa fa-smile-o"></i>
                     <span>Privacy Policy</span> 
                  </a>
                </li>
				<li class="<?=($curFileName == 'legal-disclaimer.php')?'active':''?>">
					<a href="<?=admin_url()?>legal-disclaimer.php">
                  <i class="fa fa-smile-o"></i>
                     <span>Legal Disclaimer</span> 
                  </a>
                </li>
				<li class="<?=($curFileName == 'cookie-policy.php')?'active':''?>">
					<a href="<?=admin_url()?>cookie-policy.php">
                  <i class="fa fa-smile-o"></i>
                     <span>Cookie & Policy</span> 
                  </a>
                </li>
				<li class="<?=($curFileName == 'terms-conditions.php')?'active':''?>">
					<a href="<?=admin_url()?>terms-conditions.php">
                  <i class="fa fa-smile-o"></i>
                     <span>Terms and Conditions
</span> 
                  </a>
                </li>
				<li class="<?=($curFileName == 'portfolio.php')?'active':''?>">
					<a href="<?=admin_url()?>portfolio.php">
						<i class="fa fa-smile-o"></i>
                     <span>Portfolio
               </span> 
                  </a>
                </li>
				
				<li class="<?=($curFileName == 'testimonial.php')?'active':''?>">
					<a href="<?=admin_url()?>testimonial.php">
						<i class="fa fa-smile-o"></i>
                     <span>Testimonial
               </span> 
                  </a>
                </li>
        <li class="<?=($curFileName == 'blog.php')?'active':''?>">
          <a href="<?=admin_url()?>blog.php">
            <i class="fa fa-smile-o"></i>
                     <span>Blog
               </span> 
                  </a>
                </li>
				<li class="<?=($curFileName == 'career.php')?'active':''?>">
					<a href="<?=admin_url()?>career.php">
						<i class="fa fa-smile-o"></i>
                     <span>Career
               </span> 
                  </a>
                </li>
				<li class="<?=($curFileName == 'news_letter.php')?'active':''?>">
					<a href="<?=admin_url()?>news_letter.php">
						<i class="fa fa-smile-o"></i>
                     <span>News Letter
               </span> 
                  </a>
                </li>
				<li class="<?=($curFileName == 'technology.php')?'active':''?>">
					<a href="<?=admin_url()?>technology.php">
						<i class="fa fa-smile-o"></i>
                     <span>Speak Technology
               </span> 
                  </a>
                </li>
				<li class="<?=($curFileName == 'sitemap.php')?'active':''?>">
					<a href="<?=admin_url()?>sitemap.php">
						<i class="fa fa-smile-o"></i>
                     <span>Site MAp
               </span> 
                  </a>
                </li>-->
				
		<!--<li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Job Portal</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="current_opening.php"><i class="fa fa-circle-o"></i>Job Post</a></li>
            <li><a href="keyword.php"><i class="fa fa-circle-o"></i>Keyskills</a></li>
			<li><a href="jobtitle.php"><i class="fa fa-circle-o"></i>Job Title</a></li>
			<li><a href="<?=admin_url()?>apply-job.php"><i class="fa fa-circle-o"></i>Job Application</a></li>
          </ul>
        </li>

       
			
			
			<li class="<?=($curFileName == 'setting.php')?'active':''?>">
                  <a href="<?=admin_url()?>setting.php">
                  <i class="fa fa-street-view"></i>
                     <span>Setting</span> 
                  </a>
                </li>
				<li class="<?=($curFileName == 'countact-us.php')?'active':''?>">
                  <a href="<?=admin_url()?>contact-us.php">
                  <i class="fa fa-street-view"></i>
                     <span>Contact Us</span> 
                  </a>
                </li>-->
                            </ul>
        </section>
     <!--/.sidebar -->
  </aside>