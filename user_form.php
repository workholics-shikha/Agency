<?php include_once("include/header.php");?>
<?php
  
if(isset($_POST['updateForm']))

{
 $id= $_GET['id'];
 
  $email = $_POST['email'];
  //$url = addslashes($_POST['url']);
  $password = addslashes($_POST['password']);
  //$note = addslashes($_POST['note']);
  $update = $prbsl->update("userdetail",array(
     'password'=>$password,'email'=>$email,
     
    ),array('id'=>$id));
  if ($update) 
  {
   // $permissions = serialize($_POST['permission']);
    //updateUserMeta($id,'permissions',$permissions);
    //echo "Record updated successfully";
    //header('Location: user.php');
    $msg = 'Updated successfully';
  } 
  else{
    $error=true;
    $msg = 'Some error occured when updating';
  }
}
    $id = $_GET['id'];
    $array=array('id'=>$id);
    $aboutdata=$prbsl->get_row("SELECT * FROM `userdetail` WHERE id=$id");
    //$permission = unserialize(getUserMeta($id,'permissions'));
    //if($permission == null){
      //$permission = array();
  //  }
?>

   
<div class="content-wrapper">
    <div class="row">

            <div class="col-md-12">
                <h1 class="page-header">Edit User</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
    <!-- /.row -->
    <section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php
            if(!$error && $msg !=''){
              echo '<div class="alert alert-success">'.$msg.'</div>';
            }
            else if($error && $msg !=''){
              echo '<div class="alert alert-danger">'.$msg.'</div>';
            }
            ?>
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit User 
                    <a class="pull-right" href="user.php">Back</i></a>                    
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <form action="" method="post" enctype="multipart/form-data">
                          
                            <div class="col-lg-10">
                              <!-- <div class="form-group">
                                  <label>Service</label>
                                  <input type="text" class="form-control" value="<?=$aboutdata->service;?>" name="service" required>
                              </div>
                              <div class="form-group">
                                  <label>Web Site</label>
                                  <input type="text" class="form-control" value="<?=$aboutdata['url']?>" name="url" required>
                              </div> -->
                              <div class="form-group">
                                  <label>Username</label>
                                  <input type="text" class="form-control" value="<?=$aboutdata['name'];?>" readonly placeholder="@mywebsite.com">
                              </div>
                              <div class="form-group">
                                  <label>Password</label>
                                  <input type="password" class="form-control" value="<?=$aboutdata['password']?>" name="password" required>
                              </div>
                             <div class="form-group">
                                  <label>Email</label>
                                  <input type="text" class="form-control" value="<?=$aboutdata['email']?>" name="email" readonly=" " required>
                              </div>
                                <!--<div class="form-group">
                                  <label>Notes</label>
                                  <textarea type="text" class="form-control" value="" id="note" name="note" required><?=$aboutdata['note']?></textarea>
                              </div>  
                              <div class="form-group form-inline">
                                  <label><input type="checkbox" name="permission[]" value="manage_contact" <?=(in_array('manage_contact',$permission))?'checked="checked"':''?>> 
                                    Manage Contact
                                  </label> &nbsp; &nbsp;
                                  <label><input type="checkbox" name="permission[]" value="manage_users" <?=(in_array('manage_users',$permission))?'checked="checked"':''?> class="_mu"> 
                                    Manage Users
                                  </label> &nbsp; &nbsp;
                                  <label><input type="checkbox" name="permission[]" value="manage_groups" <?=(in_array('manage_groups',$permission))?'checked="checked"':''?> class="_mf"> 
                                    Manage Folders
                                  </label> &nbsp; &nbsp;
                                  <label><input type="checkbox" name="permission[]" value="view_folders" <?=(in_array('view_folders',$permission))?'checked="checked"':''?> class="_vf"> 
                                    View Folders
                                  </label> &nbsp; &nbsp;
                                  <label><input type="checkbox" name="permission[]" value="view_users" <?=(in_array('view_users',$permission))?'checked="checked"':''?> class="_vu"> View Users</label> &nbsp; &nbsp;
                              </div>
                              <div class="form-group">
                                <?php
                                  $select = $prbsl->get_results("SELECT g_name FROM c_groups WHERE status=1");
                                  if(!empty($select)){
                                    $display = 'none';
                                    if(in_array('manage_groups',$permission) || in_array('view_folders',$permission)){
                                      $display = 'block';
                                    }
                                    ?>
                                    <select name="permission[]" class="_mfg form-control" style="display: <?=$display?>;" multiple="multiple">
                                      <?php 
                                      foreach($select as $ss){
                                        $checked = '';
                                        if(in_array($ss->g_name,$permission)){
                                          $checked = 'selected="selected"';
                                        }
                                        echo '<option value="'.$ss->g_name.'" '.$checked.'>'.$ss->g_name.'</option>';
                                      }
                                      ?>
                                    </select>
                                    <?php
                                  }
                                  ?>
                              </div>-->
                            </div>
                            <div class="col-lg-12 text-center"> 
                            <hr>
                              <input type="submit" name="updateForm" class="btn btn btn-primary"  value="update">
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