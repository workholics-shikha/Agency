<?php       
session_start();
include('include/function.php');
if(!isset($_SESSION['adminId'])){
    //header("Location:".admin_url()."login.php");
	header("Location:".admin_url()."login.php");
}

$userrole =  $_SESSION['cur_user'];
$curFileName = currentFileName();
$adminId = $_SESSION['adminId'];
global $prbsl;
//$curFileName="";

$permissions = $prbsl->get_var("SELECT permissions FROM userdetail WHERE id='$adminId'");
$userPermissions = array();
if(!empty($permissions))
{
  $userPermissions = unserialize($permissions);
}


?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Agency</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=admin_url()?>css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=admin_url()?>css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=admin_url()?>css/ionicons.min.css">
  <!--<link rel="stylesheet" href="<?=admin_url()?>css/jquery-ui.min.css">
   Theme style -->
  <link rel="stylesheet" href="<?=admin_url()?>css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?=admin_url()?>css/style.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?=admin_url()?>css/_all-skins.min.css">
  <link rel="stylesheet" href="<?=admin_url()?>css/blue.css">
  <link rel="stylesheet" href="<?=admin_url()?>css/bootstrap-datetimepicker.min.css">

  
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <script src="<?=admin_url()?>js/jquery.min.js"></script> 
  <script src="https://cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
  

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="<?=admin_url()?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini" ><b>Agency</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg" ><b> Agency</b></span>
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
              <span class="hidden-xs">Agency Admin</span>
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
                
               <!-- <li class="<?=($curFileName == 'users.php')?'active':''?>">
                  <a href="<?=admin_url()?>users-list.php">
                  <i class="fa fa-users"></i>
                     <span>Users</span> 
                  </a>
                </li>-->
         <?php 
             if(array_key_exists("users",$userPermissions))
             {
         ?>     <li class="<?=($curFileName == 'user.php')?'active':''?>">
				        	<a href="<?=admin_url()?>user.php">
                    <i class="fa fa-user"></i>
                      <span>Users</span> 
                    </a>
                </li>
          <?php } ?>      
    <?php 
        if(array_key_exists("ads",$userPermissions))
        {
    ?>         
				  <li class="<?=($curFileName == 'allad.php')?'active':''?>">
					<a href="<?=admin_url()?>allad.php">
                  <i class="fa fa-picture-o"></i>
                     <span>Ads</span> 
                  </a>
                </li>
    <?php } ?>    
    <?php 
        if(array_key_exists("theater",$userPermissions))
        {
    ?>           
				<li class="<?=($curFileName == 'alltheater.php')?'active':''?>">
					<a href="<?=admin_url()?>alltheater.php">
                  <i class="fa fa-home"></i>
                     <span>Theater</span> 
                  </a>
                </li>
     <?php } ?>           
                
     <?php 
        if(array_key_exists("report",$userPermissions))
        {
    ?>             
				<li class="<?=($curFileName == 'view_report.php')?'active':''?>">
					<a href="<?=admin_url()?>view_report.php">
                  <i class="fa fa-home"></i>
                     <span>Report</span> 
                  </a>
                </li>
    <?php } ?>  
    <?php 
        if(array_key_exists("bulk_entry",$userPermissions))
        {
    ?>              
		<li class="<?=($curFileName == 'bulk-entry.php')?'active':''?>">
					<a href="<?=admin_url()?>bulk-entry.php">
                  <i class="fa fa-smile-o"></i>
                     <span>Bulk Entry</span> 
                  </a>
                </li>
     <?php } ?>    
     <?php 
        if(array_key_exists("contact",$userPermissions))
        {
    ?>         
                <li class="<?=($curFileName == 'contact.php')?'active':''?>">
					<a href="<?=admin_url()?>contact.php">
                  <i class="fa fa-phone"></i>
                     <span>Contact</span> 
                  </a>
                </li>
      <?php } ?>    
      <?php 
        if(array_key_exists("export_data",$userPermissions))
        {
    ?>         
		        	<li class="<?=($curFileName == 'export.php')?'active':''?>">
                <a href="<?=admin_url()?>export.php">
                  <i class="fa fa-picture-o"></i>
                     <span>Export Data
                     </span> 
                  </a>
                </li>
				<?php } ?>
        <?php 
        if(array_key_exists("group",$userPermissions))
        {
    ?>    
				<li class="<?=($curFileName == 'groups.php')?'active':''?>">
					<a href="<?=admin_url()?>groups.php">
                  <i class="fa fa-smile-o"></i>
                     <span>Group</span> 
                  </a>
                </li>
       <?php } ?>         
       <?php 
            if(array_key_exists("download",$userPermissions))
            {
        ?>            
                		<li class="<?=($curFileName == 'download_log.php')?'active':''?>">
					<a href="<?=admin_url()?>download_log.php">
                  <i class="fa fa-download"></i>
                     <span>Download</span> 
                  </a>
                </li>
        <?php } ?>        
                
               
				<li>
					<a href="login.php?action=logout">
                  <i class="fa fa-sign-out"></i>
                     <span>Sign Out</span> 
                  </a>
                </li>
			
                            </ul>
        </section>
     <!--/.sidebar -->
  </aside>