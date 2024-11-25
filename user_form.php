<?php include_once("include/header.php");?>
<?php


if(isset($_POST['updateForm']))
{
 $id= $_GET['id'];
 
  $email = $_POST['email'];
  //$url = addslashes($_POST['url']);
  $password = addslashes($_POST['password']);

  $role = $_POST['role'];

  $permissions = array(); 
  if(isset($_POST['permission']) && !empty($_POST['permission']))
  {
       $permissionData = $_POST['permission'];  
       foreach($permissionData as $permission)
       {
          if(in_array('users',$permissionData))
          {
              $permissions['users'] = (isset($_POST['user_permission']) && !empty($_POST['user_permission']))?$_POST['user_permission']:'';
          }
          if(in_array('ads',$permissionData))
          {
              $permissions['ads'] = (isset($_POST['ads_permission']) && !empty($_POST['ads_permission']))?$_POST['ads_permission']:'';
          } 
          if(in_array('theater',$permissionData))
          {
              $permissions['theater'] = (isset($_POST['theater_permission']) && !empty($_POST['theater_permission']))?$_POST['theater_permission']:'';
          }
          if(in_array('report',$permissionData))
          {
              $permissions['report'] = (isset($_POST['report_permission']) && !empty($_POST['report_permission']))?$_POST['report_permission']:'';
          } 
          if(in_array('bulk_entry',$permissionData))
          {
              $permissions['bulk_entry'] = (isset($_POST['bulk_permission']) && !empty($_POST['bulk_permission']))?$_POST['bulk_permission']:'';
          } 
          if(in_array('contact',$permissionData))
          {
              $permissions['contact'] = (isset($_POST['contact_permission']) && !empty($_POST['contact_permission']))?$_POST['contact_permission']:'';
          }
          if(in_array('export_data',$permissionData))
          {
              $permissions['export_data'] = (isset($_POST['export_permission']) && !empty($_POST['export_permission']))?$_POST['export_permission']:'';
          }
          if(in_array('group',$permissionData))
          {
              $permissions['group'] = (isset($_POST['group_permission']) && !empty($_POST['group_permission']))?$_POST['group_permission']:'';
          }
          if(in_array('download',$permissionData))
          {
              $permissions['download'] = (isset($_POST['download_permission']) && !empty($_POST['download_permission']))?$_POST['download_permission']:'';
          }  
       }
  }
  //$note = addslashes($_POST['note']);
  $update = $prbsl->update("userdetail",array(
     'password'=>$password,'email'=>$email,'role'=>$role,'permissions'=>serialize($permissions)
     
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
    $userPermissions = array();
    if(!empty($aboutdata['permissions']))
    {
      $userPermissions = unserialize($aboutdata['permissions']);
    }
    print_r($userPermissions);

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
                              <div class="form-group">
                                  <label>Select Role</label>
                                  <select name="role" class="form-control" required>
                                        <option value="">Select Role</option> 
                                        <option value="admin" <?php echo ($aboutdata['role'] == "admin")?'selected':''; ?>>Admin</option>
                                        <option value="client" <?php echo ($aboutdata['role'] == "client")?'selected':''; ?>>Client</option>
                                        <option value="agent" <?php echo ($aboutdata['role'] == "agent")?'selected':''; ?>>Agent</option>
                                  </select>
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

                              <div class="form-group form-inline">
                                  <label>Add Permissions</label>
                                  <br>
                                  <label><input type="checkbox" name="permission[]" value="users" <?php echo (key_exists('users',$userPermissions))?'checked':''; ?>> Users</label> &nbsp; &nbsp;
                                  <label><input type="checkbox" name="permission[]" value="ads" <?php echo (key_exists('ads',$userPermissions))?'checked':''; ?>> Ads</label> &nbsp; &nbsp;
                                  <label><input type="checkbox" name="permission[]" value="theater" <?php echo (key_exists('theater',$userPermissions))?'checked':''; ?> > Theater</label> &nbsp; &nbsp;
                                  <label><input type="checkbox" name="permission[]" value="report" <?php echo (key_exists('report',$userPermissions))?'checked':''; ?>> Report</label> &nbsp; &nbsp;
                                  <label><input type="checkbox" name="permission[]" value="bulk_entry" <?php echo (key_exists('bulk_entry',$userPermissions))?'checked':''; ?>> Bulk Entry</label> &nbsp; &nbsp;
                                  <label><input type="checkbox" name="permission[]" value="contact" <?php echo (key_exists('contact',$userPermissions))?'checked':''; ?>> Contact</label> &nbsp; &nbsp;
                                  <label><input type="checkbox" name="permission[]" value="export_data" <?php echo (key_exists('export_data',$userPermissions))?'checked':''; ?>> Export Data</label> &nbsp; &nbsp;
                                  <label><input type="checkbox" name="permission[]" value="group" <?php echo (key_exists('group',$userPermissions))?'checked':''; ?>> Group</label> &nbsp; &nbsp;
                                  <label><input type="checkbox" name="permission[]" value="download" <?php echo (key_exists('download',$userPermissions))?'checked':''; ?>> Download</label> &nbsp; &nbsp;
                              </div>
                              <?php
                                   $usercrdPermissions = array(); 
                                   if(key_exists('users',$userPermissions))
                                   {
                                       $usercrdPermissions = (!empty($userPermissions['users']))?$userPermissions['users']:[];
                                   }
                                   $adsPermissions = array();
                                   if(key_exists('ads',$userPermissions))
                                   {
                                      $adsPermissions = (!empty($userPermissions['ads']))?$userPermissions['ads']:[];
                                   }
                                   $theaterPermissions = array(); 
                                   if(key_exists('theater',$userPermissions))
                                   {
                                     $theaterPermissions =(!empty($userPermissions['theater']))?$userPermissions['theater']:[];
                                   }
                                   $reportPermissions = array(); 
                                   if(key_exists('report',$userPermissions))
                                   {
                                     $reportPermissions = (!empty($userPermissions['report']))?$userPermissions['report']:[];
                                   }

                                   $bulkPermissions = array(); 
                                   if(key_exists('bulk_entry',$userPermissions))
                                   {
                                      $bulkPermissions = (!empty($userPermissions['bulk_entry']))?$userPermissions['bulk_entry']:[];
                                   }
                                   $contactPermissions = array(); 
                                   if(key_exists('contact',$userPermissions))
                                   {
                                       $contactPermissions = (!empty($userPermissions['contact']))?$userPermissions['contact']:[];
                                   }
                                   $exportPermissions = array(); 
                                   if(key_exists('export_data',$userPermissions))
                                   {
                                      $exportPermissions =(!empty($userPermissions['export_data']))?$userPermissions['export_data']:[];
                                   }
                                   $groupPermissions = array(); 
                                   if(key_exists('group',$userPermissions))
                                   {
                                      $groupPermissions = (!empty($userPermissions['group']))?$userPermissions['group']:[];
                                   }
                                   $downloadPermissions = array(); 
                                   if(key_exists('download',$userPermissions))
                                   {
                                      $downloadPermissions = (!empty($userPermissions['download']))?$userPermissions['download']:[];
                                   }
                                   

                               ?>
                              <div class="each_permission">
                                   <div class="col-md-2">
                                       <label>Users</label>
                                       <br>
                                       <label><input type="checkbox" name="user_permission[]" value="edit" <?php echo (in_array('edit',$usercrdPermissions))?'checked':''; ?>> Edit</label> &nbsp; &nbsp;
                                       <label><input type="checkbox" name="user_permission[]" value="delete" <?php echo (in_array('delete',$usercrdPermissions))?'checked':''; ?>> Delete</label> &nbsp; &nbsp;
                                   </div>
                                   <div class="col-md-2">
                                       <label>Ads</label>
                                       <br>
                                       <label><input type="checkbox" name="ads_permission[]" value="edit" <?php echo (in_array('edit',$adsPermissions))?'checked':''; ?>> Edit</label> &nbsp; &nbsp;
                                       <label><input type="checkbox" name="ads_permission[]" value="delete" <?php echo (in_array('delete',$adsPermissions))?'checked':''; ?>> Delete</label> &nbsp; &nbsp;
                                   </div>
                                   <div class="col-md-2">
                                       <label>Theater</label>
                                       <br>
                                       <label><input type="checkbox" name="theater_permission[]" value="edit" <?php echo (in_array('edit',$theaterPermissions))?'checked':''; ?>> Edit</label> &nbsp; &nbsp;
                                       <label><input type="checkbox" name="theater_permission[]" value="delete" <?php echo (in_array('delete',$theaterPermissions))?'checked':''; ?>> Delete</label> &nbsp; &nbsp;
                                   </div>
                                   <div class="col-md-2">
                                       <label>Report</label>
                                       <br>
                                       <label><input type="checkbox" name="report_permission[]" value="edit" <?php echo (in_array('edit',$reportPermissions))?'checked':''; ?>> Edit</label> &nbsp; &nbsp;
                                       <label><input type="checkbox" name="report_permission[]" value="delete" <?php echo (in_array('delete',$reportPermissions))?'checked':''; ?>> Delete</label> &nbsp; &nbsp;
                                   </div>
                                   <div class="col-md-2">
                                       <label>Bulk Entry</label>
                                       <br>
                                       <label><input type="checkbox" name="bulk_permission[]" value="edit" <?php echo (in_array('edit',$bulkPermissions))?'checked':''; ?>> Edit</label> &nbsp; &nbsp;
                                       <label><input type="checkbox" name="bulk_permission[]" value="delete" <?php echo (in_array('delete',$bulkPermissions))?'checked':''; ?>> Delete</label> &nbsp; &nbsp;
                                   </div>
                                   <div class="col-md-2">
                                       <label>Contact</label>
                                       <br>
                                       <label><input type="checkbox" name="contact_permission[]" value="edit" <?php echo (in_array('edit',$contactPermissions))?'checked':''; ?>> Edit</label> &nbsp; &nbsp;
                                       <label><input type="checkbox" name="contact_permission[]" value="delete" <?php echo (in_array('delete',$contactPermissions))?'checked':''; ?>> Delete</label> &nbsp; &nbsp;
                                   </div>
                                   <div class="col-md-2">
                                       <br>
                                       <label>Export Data</label>
                                       <br>
                                       <label><input type="checkbox" name="export_permission[]" value="edit" <?php echo (in_array('edit',$exportPermissions))?'checked':''; ?>> Edit</label> &nbsp; &nbsp;
                                       <label><input type="checkbox" name="export_permission[]" value="delete" <?php echo (in_array('delete',$exportPermissions))?'checked':''; ?>> Delete</label> &nbsp; &nbsp;
                                   </div>
                                   <div class="col-md-2">
                                       <br>
                                       <label>Group</label>
                                       <br>
                                       <label><input type="checkbox" name="group_permission[]" value="edit" <?php echo (in_array('edit',$groupPermissions))?'checked':''; ?>> Edit</label> &nbsp; &nbsp;
                                       <label><input type="checkbox" name="group_permission[]" value="delete" <?php echo (in_array('delete',$groupPermissions))?'checked':''; ?>> Delete</label> &nbsp; &nbsp;
                                   </div>
                                   <div class="col-md-2">
                                       <br>
                                       <label>Download</label>
                                       <br>
                                       <label><input type="checkbox" name="download_permission[]" value="edit" <?php echo (in_array('edit',$downloadPermissions))?'checked':''; ?>> Edit</label> &nbsp; &nbsp;
                                       <label><input type="checkbox" name="download_permission[]" value="delete" <?php echo (in_array('delete',$downloadPermissions))?'checked':''; ?>> Delete</label> &nbsp; &nbsp;
                                   </div>

                              </div>
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