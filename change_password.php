<?php
require_once("include/header.php");
global $prbsl;

$success = '';
$error = '';
if(isset($_POST['change'])){

$id=$_SESSION['adminId'];
$password=$_POST['password'];

	 $new_password=$_POST['new_password'];
	
	  $cnfrm_password=$_POST['cnfrm_password'];
	
	 $row1 = $prbsl->get_row("SELECT * FROM admin_user WHERE id=$id");		

		$old_pwd=$row1['password'];
	  if($password!==$old_pwd){
		 
		  $passError="wrong password!please enter correct password";
  }
 
 else if(strlen($new_password)<6){
	 $error=true;
$npassError="New Password must have 6 characters";	 
	  
  }
   else if($new_password!==$cnfrm_password){
	
$error="password and confirm password not match";	 
	  
  }
    else 	{
        $data=array("password"=>$new_password);
        $updated = $prbsl->update("admin_user",$data,array("id"=>$id));
	
	
	if($updated){
		$success = 'your password changed successfully';
	
		
		}
	else {
		
	
		$error="your new password and confirm password not match";
	}
	
}
  }
	
?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>Change Password
<!--<a href="<?=admin_url()?>services.php" class="btn btn-primary"><i class="fa fa-backward"></i> Back</a>-->
</h1>
</section>
<!-- Main content -->
<section class="content">
<div class="row">
  <div class="col-md-12">
      
    <?php 
    if($success !=''){
    echo '<div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Success!</strong> '.$success.'</div>';
      }
      if($error !=''){
      echo '<div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong> '.$error.'</div>';
        }
        ?>
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">
           Change Password
            </h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <form method="post" id="package_form" action="">
             
              <div class="panel panel-default">
                <div class="panel-body">
                  <!-- <div class="col-md-2" style="background-color:#000000;">
                    <img  src="<?=site_url()?>uploads/services/<?=$servicesData["service_icon"]?>" width='100px' height='140spx'>
                    <input type='hidden' name='hidicon_simage' value="<?=$servicesData["service_icon"]?>">
                  </div> -->
                  <div class="col-md-10">
                        <div class="form-group">
                     
                      <input type="text" name="password" class="form-control" placeholder="Old password" required autocomplete="off">
                    </div>  
                    <span class="text-danger"><?php if(isset($passError) && $passError!="") { echo $passError; } ?></span>
                     <strong>&nbsp;</strong>
                    <div class="form-group">
                     
                      <input type="text" name="new_password" class="form-control" placeholder="New password" autocomplete="off" required>
                    </div>
                    	<span class="text-danger"><?php if(isset($npassError) && $npassError!="") { echo $npassError; } ?></span>
                    	 <strong>&nbsp;</strong>
                    <div class="form-group">
                     
                      <input type="text" name="cnfrm_password" class="form-control" placeholder="confirm password" autocomplete="off" required>
                    </div>
						<span class="text-danger"><?php if(isset($cpassError) && $cpassError!="") { echo $cpassError; } ?></span>
						 <strong>&nbsp;</strong>

				
				
					
					
				
					
                  
                  </div>
					
				   
                  </div>
                
				   <div class="clearfix"></div>
                 
                 
                  <div class="panel-footer">
                    
                  <button type="submit" name="change" class="btn btn-primary" >Change Password</button>
                   
                   
                 
                  
                    
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <?php
  require_once("include/footer.php");
  ?>
  <script src="<?=admin_url()?>ckeditor/ckeditor.js"></script>
  <script type="text/javascript">
  jQuery(document).ready(function($){
  $('.serviceData').on('click','.addData',function(e){
  e.preventDefault();
  var current = $(this);
  output = '<div class="data-wrapper col-md-12"><div class="col-md-12 package-boreder"><strong>&nbsp;</strong><div class=" form-group input-group "><input type="text" name="service_content[]" class="form-control" placeholder="content"><span class="input-group-btn"><a href="#" class="addData btn btn-info"><i class="fa fa-plus"></i></a></span></div></div></div>';
  current.find('i').removeClass('fa-plus').addClass('fa-minus');
  current.addClass('removeData').removeClass('addData');
  current.addClass('btn-danger').removeClass('btn-info');
  $('.serviceData').append(output);
  });
  $('.serviceData').on('click','.removeData',function(e){
  e.preventDefault();
  var current = $(this);
  current.parents('.data-wrapper').remove();
  });
  
  $('.costing').on('click','.costingaddData',function(e){
  e.preventDefault();
  var current = $(this);
  output = '<div class="col-md-4"><div class="col-md-12 package-boreder"><strong>&nbsp;</strong><div class=" form-group input-group "><input type="text" name="pax[]" class="form-control" placeholder="No of Pax" ><span class="input-group-btn"><a href="#" class="costingaddData btn btn-info"><i class="fa fa-plus"></i></a></span></div><div class="form-group"><input type="text" class="form-control" name="threestart[]" placeholder="3* Hotel" ></div><div class="form-group"><input type="text" class="form-control" name="fourstart[]" placeholder="4* Hotel" ></div><div class="form-group"><input type="text" class="form-control" name="fivestart[]" placeholder="5* Hotel" ></div></div></div>';
  current.find('i').removeClass('fa-plus').addClass('fa-minus');
  current.addClass('costingremoveData').removeClass('costingaddData');
  current.addClass('btn-danger').removeClass('btn-info');
  $('.costing').append(output);
  });
  $('.costing').on('click','.costingremoveData',function(e){
  e.preventDefault();
  var current = $(this);
  current.parents('.col-md-4').remove();
  });
  
  $('.hotel').on('click','.hoteladdData',function(e){
  e.preventDefault();
  var current = $(this);
  output = '<div class="col-md-4"><div class="col-md-12 package-boreder"><strong>&nbsp;</strong><div class=" form-group input-group "><input type="text" name="destination[]" class="form-control" placeholder="Destination" ><span class="input-group-btn"><a href="#" class="hoteladdData btn btn-info"><i class="fa fa-plus"></i></a></span></div><div class="form-group"><input type="text" class="form-control" name="threestart_one[]" placeholder="3* Hotel" ></div><div class="form-group"><input type="text" class="form-control" name="fourstart_two[]" placeholder="4* Hotel"></div><div class="form-group"><input type="text" class="form-control" name="fivestart_three[]" placeholder="5* Hotel" ></div><div class="form-group"><input type="text" class="form-control" name="mplan[]" placeholder="Meal Plan" ></div></div></div>';
  current.find('i').removeClass('fa-plus').addClass('fa-minus');
  current.addClass('hotelremoveData').removeClass('costingaddData');
  current.addClass('btn-danger').removeClass('btn-info');
  $('.hotel').append(output);
  });
  $('.hotel').on('click','.hotelremoveData',function(e){
  e.preventDefault();
  var current = $(this);
  current.parents('.col-md-4').remove();
  });
  
  //$(".ckeditor").ckeditor();
  CKEDITOR.replace( 'ckeditor' );
  CKEDITOR.replace( 'ckeditor2' );
  CKEDITOR.replace( 'ckeditor3' );
  CKEDITOR.replace( 'ckeditor4' );
  });
  </script>
  <style>
  .package-boreder{
  border: 1px solid green;
  margin-top: 5px;
  }
  </style>