<?php 

  session_start();
  include("include/function.php");
  if(isset($_SESSION['email'])){
     header("Location:".admin_url()); 
  }
  $error=false;
  if(isset($_POST['login'])){
   $email=$_POST['email'];
   $password=$_POST['password'];
   $sql="SELECT name FROM `userdetail` WHERE `name`='$email' AND `password`='$password'";
   $result=$vgdb->get_var($sql);
   if($result != ''){
    $query="SELECT id FROM `userdetail` WHERE `name`='$email'";
    $userId=$vgdb->get_var($query);
    
    $array=array('type'=>"login","datetime"=>date("Y-m-d H:i:s"),'ip_address'=>$_SERVER['REMOTE_ADDR'],'user'=>$userId);
           $vgdb->insert("reprot_download_log",$array);
      $_SESSION['email']=$result;
     header("Location:".admin_url());
   }else{
      $checkadmin = $vgdb->get_var("SELECT email FROM `admin_user` WHERE `email`='$email' AND `password`='$password'");
      if($checkadmin !=''){
        $_SESSION['email']=$checkadmin;
        $_SESSION['cur_user']='admin';
        header("Location:".admin_url());
      }
      $error=true;
      $login_error="Please Check Username And Password";
   }
  }
?>
<!DOCTYPE html>

<!-- saved from url=(0046)http://valleyobcare.com/intake/index.php/login -->


<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>Agency</title>


<link href="<?=admin_url()?>/Intake_files/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?=admin_url()?>/Intake_files/uniform.default.css" rel="stylesheet" type="text/css">
 <link href="<?=admin_url()?>/Intake_files/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="<?=admin_url()?>/Intake_files/style.css" rel="stylesheet" type="text/css">

<!-- Documentation extras -->

<link href="<?=admin_url()?>/Intake_files/docs.min.css" rel="stylesheet">

<!--js->




<![if lt IE 9]><script src="http://valleyobcare.com/intake/login/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

<!--[if lte IE 7]>
<link type="text/css" rel="stylesheet" media="all" href="http://valleyobcare.com/intake/login/css/screen_ie.css" />
<![endif]-->
<!--[if lte IE 6]>   <style type="text/css" media="screen">     #element {       filter: alpha(opacity=50);     }   </style>   <![endif]-->



</head><body style="background: rgb(232, 227, 208);">


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="fontsd">
                    <!--<img src="<?=admin_url()?>/Intake_files/logo.png" class="img-responsive" alt="">-->
                </div>


                <div class="login-form-box" style="text-align: center;">
                        <?php
                        if($error){
                          echo '<div class="alert alert-danger">'.$login_error.'</div>';
                        }
                        ?>
                                        <form role="form" method="post">
                        <div class="form-group">

                            <input type="email" name="email" style="height: 60px;" class="form-control form-contro2" placeholder="Email" required="">

                        </div>
                        <div class="form-group">

                            <input type="password" name="password" style="height: 60px;" class="form-control form-contro3" placeholder="Password" required="">

                        </div>
                        <!--<div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox"> Remember Me
                            </div>
                        </div>-->
                       <!--  <div class="form-group">
                            <a href="http://valleyobcare.com/intake/index.php/home/forgot" id="target">Forgot Password </a>
                        </div> -->
                        <div class="form-group">

                            <button type="submit" name="login" class="btn btn-clay greek btn-lg btn-block login-btn">Login</button>

                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>
<script src="<?=admin_url()?>/js/jquery.min.js"></script>
<script>
   /* $( "#target" ).click(function() {
        swal("Please Contact ADMIN!");
    });*/
</script>

</body></html>