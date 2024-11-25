<?php 


/*$servername = "localhost:3306";
$username = "desiantiques_agency";
$password = "desiantiques1001Agency";
$dbname = "wwwdesiantiques_agency";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}else{
	echo "Rammm"; die;
}*/



  session_start();
  
  include("include/function.php");
  global $prbsl;

  /*	$data=$prbsl->get_row("SELECT * FROM `userdetail`");
  	print_r($data); die;*/
/*echo admin_url(); die;*/


  	$login_error='';
	if(isset($_GET['action']) && $_GET['action'] == 'logout'){
		unset($_SESSION['adminId']);
		//header("Location:".admin_url()."login");
		header("Location:".admin_url()."login.php");
	}

 if(isset($_SESSION['email'])){
     unset($_SESSION['email']);
    unset($_SESSION['adminId']);
		header("Location:".admin_url()."login.php");
	
    // header("Location: http://dissdemo.biz/ravi/agency/index.php"); 
  }
 // $error=false;
  if(isset($_POST['login'])){
      
   $email=$_POST['email'];
   $password=$_POST['password'];
   $role = $_POST['role'];
   $user=$prbsl->get_row("SELECT * FROM `userdetail` WHERE `email`='$email' AND `password`='$password' AND `role`='$role'");
	if($user){
		header("Location:".admin_url()."index.php");
		$_SESSION['email']=$user['email'];
		$_SESSION['adminId']=$user['id'];
		$_SESSION['cur_user']=$role;
   }
   $error=true;
   $login_error="Please Check Username And Password";
  }
?>



<!DOCTYPE html>
<html>
	
	<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Agency Admin | Log in</title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.6 -->
		<link rel="stylesheet" href="<?=admin_url()?>/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?=admin_url()?>/css/AdminLTE.min.css">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="hold-transition login-page">
		<?php if($login_error !=''){
			echo '<div style="width:100%;text-align:center;font-size:20px;font-weight:bold;background-color:#FFF;">'.$login_error.'</div>';
		}?>
		<div class="login-box">
			<div class="login-logo">
			    <div>
			    	<!--<img src="http://morphe-forma.com/img/logo/mf-95x85.png" alt="" style="width:120px; ">-->
			    	<h1 style="color:#fff;">Agency Admin</h1>
			    	</div>
				
			
			</div>
			
			
			<!-- /.login-logo -->
			<div class="login-box-body">
			    
			    
			    
				<form method="post">
					<div class="form-group has-feedback">
						<input type="email" class="form-control" name="email" placeholder="Email" autocomplete="off" autofocus required>
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off" required>
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					<select name="role" class="form-control" required>
						<option value="">Select Role</option>
						<option value="admin">Admin</option>
						<option value="client">Client</option>
						<option value="agent">Agent</option>
					</select>
					<div class="row">
						<div class="col-xs-8">
						</div>
						<!-- /.col -->
						<div class="col-xs-4">
						    <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Login</button>
							
						</div>
						<!-- /.col -->
					</div>
				</form>
			</div>
			<!-- /.login-box-body -->
		</div>
		<!-- /.login-box -->
		<!-- jQuery 2.2.0 -->
		<script src="https://www.viraatswadeshihaat.com/agency/js/jquery.min.js"></script>
		<!-- Bootstrap 3.3.6 -->
		<script src="https://www.viraatswadeshihaat.com/agency/js/bootstrap.min.js"></script>
	</body>
	</html>
		