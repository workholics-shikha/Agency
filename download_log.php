<?php include_once("include/header.php");
    

    $adminId = $_SESSION['adminId'];
    $permissions = $prbsl->get_var("SELECT permissions FROM userdetail WHERE id='$adminId'");
    $userPermissions = array();
    if(!empty($permissions))
    {
    $userPermissions = unserialize($permissions);
    }
 
    if(!array_key_exists("download",$userPermissions))
    {
        echo '<script>window.location.href="'.admin_url().'index.php";</script>';
    }    
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        if($prbsl->delete('reprot_download_log',array('id'=>$id))){
            echo "<script>alert('successfully deleted')</script>";
            echo "<script>window.location.href='download_log.php';</script>";
        }
    }
   $downloadsql= "SELECT RDL.* ,`UD`.`name` FROM reprot_download_log RDL INNER JOIN userdetail UD ON RDL.user = UD.id WHERE RDL.type='filedownload' ORDER BY RDL.`id` DESC";
    $result=$prbsl->get_results($downloadsql);
   // debug($result);
   // die;
?>

   
             <div class="content-wrapper">
            <div class="row">
                 <div class="col-md-12">
                 <section class="content-header">
                    <h1 class="page-header">Download Report</h1>
                </section>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
              <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Report Data 
                            <!-- <a class="pull-right" href="entryform.php">Add Report</i>
</a>   -->        </div>
                        <!-- /.panel-heading -->
                         <div class="box-body">

            <div class="table-responsive">

        <table class="table table-bordered">
                                 <thead>
                                    <tr >
                                        <th>No</th>
                                        <th> User</th>
                                        <th>Form Date</th>
                                        <th>Eng Date</th>
                                        <th>Download Date</th>
                                        <th>Ip Address</th>
                                        
                                        
                                        
                                        
                                     <th>Action</th> 
                                    </tr>
                                </thead>   
                                <tbody>
                                <?php
                                    $i=1;
                                    
                                    if(!empty($result)){
                                    foreach ($result as $aboutdata) {?>

                                    <tr>
                                        <td><?=$i?></td>
                                        <td><?=$aboutdata->name?></td>
                                        <td><?=$aboutdata->startdate?></td>
                                        <td><?=$aboutdata->enddate?></td>
                                        <td><?=$aboutdata->datetime?></td>
                                        <td><?=$aboutdata->ip_address?></td>
                                       
                                        
                                      <td><!--<a href="entryform.php?id=<?=$aboutdata->id?>" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> --><a href="?id=<?=$aboutdata->id?>" class="btn btn-danger"><i class="fa fa-remove" aria-hidden="true"></i> </a>
                                        </td> 
                                    </tr>

                                <?php  $i++;} 
                                    }else{
                                        ?>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <?php
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr >
                                        <th>No</th>
                                        <th> User</th>
                                        <th>Form Date</th>
                                        <th>Eng Date</th>
                                        <th>Download Date</th>
                                        <th>Ip Address</th>
                                       
                                        <!-- <th>Action</th> -->
                                    </tr>
                                </tfoot>  
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
            </section>
            <!-- /.row -->
         
        </div>
        <!-- /#page-wrapper -->

 
<?php include_once("include/footer.php");?>