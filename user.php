<?php include_once("include/header.php");?>
<?php
    global $prbsl;
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        if($prbsl->delete("userdetail",array('id'=>$id))){
            $prbsl->delete("user_meta",array('u_id'=>$id));
            echo "<script>alert('successfully deleted')</script>";
            echo "<script>window.location.href='user.php';</script>";
        }
    }

    $adminId = $_SESSION['adminId'];
    $permissions = $prbsl->get_var("SELECT permissions FROM userdetail WHERE id='$adminId'");
    $userPermissions = array();
    if(!empty($permissions))
    {
    $userPermissions = unserialize($permissions);
    }
 
    if(!array_key_exists("users",$userPermissions))
    {
        header("Location:".admin_url()."index.php");
    }
?>

   
            <div class="content-wrapper">
            
               <section class="content-header">
                    <h1 class="content-header">Users</h1>
                </section>
                <!-- /.col-lg-12 -->
            
            <!-- /.row -->
             <section class="content">
            <div class="row">
                <div class="col-md-12">
                    
                  <div class="box">    

            <div class="box-header with-border">

              <h3 class="box-title">
                 <a class="pull-right" href="userdetail.php">Add user</i></a>   
              </h3>
            
            </div>
               
                        <!-- /.panel-heading -->
                         <div class="box-body">

            <div class="table-responsive">

        <table class="table table-bordered">
                                 <thead>
                                    <tr >
                                        <th>#</th>
                                        <th>Username</th>
                                        <!-- <th>Service</th>
                                        <th>Web Site</th> -->
                                        <th>Password</th>
                                        <th>Role</th>
                                        
                                        <th>Action</th>
                                        
                                    </tr>
                                </thead>   
                                <tbody>
                                <?php
                                    $i=1;
                                    $sql="SELECT * FROM userdetail ORDER BY `id` DESC";
                                    $result=$prbsl->get_results($sql);
                                    if(!empty($result)>0){
                                    foreach ($result as $aboutdata) {/*<td><?=$aboutdata->service?></td>
                                        <td><?=$aboutdata->url?></td>*/
                                ?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td><?=$aboutdata->name?></td>
                                        
                                        <td><?=$aboutdata->password?></td>
                                        <td><?=$aboutdata->role?></td>
                                        
                                        <td>
                                        <a href="user_form.php?id=<?=$aboutdata->id?>" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> | 
                                            <a href="user.php?id=<?=$aboutdata->id?>" class="btn btn-danger"><i class="fa fa-remove" aria-hidden="true"></i></a>
                                        </td>
                                        
                                    </tr>

                                <?php  $i++;} } ?>
                                </tbody>
                                </table>
                            </div> 
                            <!-- /.table-responsive -->
                            
                        </div>
                        <!-- /.panel-body -->
                   
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
          </section>
        </div>
        <!-- /#page-wrapper -->

 
<?php include_once("include/footer.php");?>