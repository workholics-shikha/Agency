<?php include_once("include/header.php");
  
?>
<?php
$error=false;
$emsg = '';
if(isset($_POST['submit']))
{
  //$service = addslashes($_POST['service']);
  //$url = addslashes($_POST['url']);
  $name = addslashes($_POST['name']).'@agencycare.com';
  $password = addslashes($_POST['password']);
  $email = addslashes($_POST['email']);
 
  $checkusername = $prbsl->get_var("SELECT name FROM userdetail WHERE email='$email'");
  
  if($checkusername !=''){
    $emsg = 'Username or Email already exists';
  }
  else{
    $inserted = $prbsl->insert("userdetail",
      array(
        /*'service'=>$service,
        'url'=>$url,*/
        'password'=>$password,
        'email'=>$email,
        'name'=>$name,
        /*'note'=>$note*/
      )
    );
    if($inserted){
          //$permissions = serialize($_POST['permission']);
          //updateUserMeta($prbsl->insert_id,'permissions',$permissions);
          echo "<script>alert('successfully ')</script>";
          echo "<script>window.location.href='".admin_url()."/user.php';</script>";
        }
  }
}
?>

   
<div class="content-wrapper">
    <div class="row">
            <div class="col-md-12">
                <?php
                if($emsg !=''){
                  echo '<p class="alert alert-danger">'.$emsg.'</p>';
                }
                ?>
                <h1 class="page-header">Add User</h1>
                
            </div>
            <!-- /.col-lg-12 -->
        </div>
    <!-- /.row -->
    <section class="content">
    <div class="row">
        <div class="col-md-12">
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add User                 
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <form method="post" enctype="multipart/form-data">
                        	
                            <div class="col-lg-10">
                             <?php if($error){  ?>
                            	<div class="alert alert-warning">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Success!</strong> <?=$error_message?>
                               </div>
                            <?php } ?>
                            <?php if(isset($success_message)){  ?>
                            	<div class="alert alert-success">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Success!</strong> <?=$success_message?>
                               </div>
                            <?php } ?> 
                             
                              <div class="form-group">
                                  <label>Username</label>
                                  <input type="text" class="form-control" placeholder="" name="name" required> 
                              </div>
                              <div class="form-group">
                                  <label>Password</label>
                                  <input type="password" class="form-control" name="password" required>
                              </div>
                              <div class="form-group">
                                  <label>Email</label>
                                  <input type="text" class="form-control" name="email">
                              </div>
                              <!--<div class="form-group form-inline">
                                  <label><input type="checkbox" name="permission[]" value="manage_contact"> Manage Contact</label> &nbsp; &nbsp;
                                  <label><input type="checkbox" name="permission[]" value="manage_users" class="_mu"> Manage Users</label> &nbsp; &nbsp;
                                  <label><input type="checkbox" name="permission[]" value="manage_groups" class="_vf"> Manage Folders</label> &nbsp; &nbsp;
                                  <label><input type="checkbox" name="permission[]" value="view_folders" class="_mf"> View Folders</label> &nbsp; &nbsp;
                                  <label><input type="checkbox" name="permission[]" value="view_users" class="_vu"> View Users</label> &nbsp; &nbsp;
                              </div>-->
                              <div class="form-group">
                                <?php
                                  $select = $prbsl->get_results("SELECT g_name FROM c_groups WHERE status='1'");
                                  if(!empty($select)){
                                    ?>
                                    <select name="permission[]" class="_mfg form-control" style="display: none;" multiple="multiple">
                                      <?php 
                                      foreach($select as $ss){
                                        
                                      ?>
                                      <option value="<?php echo $ss->g_name;?>"><?php echo $ss->g_name;?></option>
                                      <?php }?>
                                    </select>
                                    <?php
                                  }
                                  ?>
                              </div>
                         </div>
                            <div class="col-lg-12 text-center"> 
                            <hr>
                              <input type="submit" name="submit" class="btn btn-primary"  value="Save">
                                <input type="reset" value="Reset" name="reset" class="btn btn-default">
                            </div>
                        </form>
                    </div> 
                </div>
                <!-- /.panel-body -->
                
               
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    </section>
    <!-- /.row -->
 
</div>
        <!-- /#page-wrapper -->
<style type="text/css">select._mfg{display: none;}</style>
 <script type="text/javascript">
   jQuery(document).ready(function($){
    $('._mf').on('change',function(){
      if($(this).is(':checked')){
        $('._mfg').show();
      }
      else{
        $('._mfg').hide();
        $('._mfg option:selected').removeAttr("selected");
      }
      $('._vf').prop('checked', false);
    });
    $('._vf').on('change',function(){
      if($(this).is(':checked')){
        $('._mfg').show();
      }
      else{
        $('._mfg').hide();
        $('._mfg option:selected').removeAttr("selected");
      }
      $('._mf').prop('checked', false);
    });
    $('._vu').on('change',function(){
      $('._mu').prop('checked', false);
    });
    $('._mu').on('change',function(){
      $('._vu').prop('checked', false);
    });
   });
 </script>
<?php include_once("include/footer.php");?>