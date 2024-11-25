<?php include_once("include/header.php");?>
<?php
    global $vgdb;
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        if($vgdb->delete("userdetail",array('id'=>$id))){
            $vgdb->delete("user_meta",array('u_id'=>$id));
            echo "<script>alert('successfully deleted')</script>";
            echo "<script>window.location.href='user.php';</script>";
        }
    }
?>
<?php include_once("include/side_menu.php");?>
   
            <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Users</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            user Data 
                            <?php if(!checkPermission('view_users') || checkPermission('manage_users')){?>
                            <a class="pull-right" href="userdetail.php">Add user</i>
                            <?php }?>
</a>          </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <div class="dataTable_wrapper">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                 <thead>
                                    <tr >
                                        <th>#</th>
                                        <th>Username</th>
                                        <!-- <th>Service</th>
                                        <th>Web Site</th> -->
                                        <th>Password</th>
                                        <?php if(checkPermission('manage_users')){?>
                                        <th>Action</th>
                                        <?php }?>
                                    </tr>
                                </thead>   
                                <tbody>
                                <?php
                                    $i=1;
                                    $sql="SELECT * FROM userdetail ORDER BY `id` DESC";
                                    $result=$vgdb->get_results($sql);
                                    if(!empty($result)>0){
                                    foreach ($result as $aboutdata) {/*<td><?=$aboutdata->service?></td>
                                        <td><?=$aboutdata->url?></td>*/
                                ?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td><?=$aboutdata->name?></td>
                                        
                                        <td><?=$aboutdata->password?></td>
                                        <?php if(checkPermission('manage_users')){?>
                                        <td>
                                        <a href="user_form.php?id=<?=$aboutdata->id?>" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> | 
                                            <a href="user.php?id=<?=$aboutdata->id?>" class="btn btn-danger"><i class="fa fa-remove" aria-hidden="true"></i></a>
                                        </td>
                                        <?php }?>
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
         
        </div>
        <!-- /#page-wrapper -->

 
<?=include_once("include/footer.php");?>