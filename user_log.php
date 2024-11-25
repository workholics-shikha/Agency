<?php include_once("include/header.php");
    global $vgdb;
    /*if(isset($_GET['id'])){
        $id = $_GET['id'];
        if($vgdb->delete('maintable',array('id'=>$id))){
            echo "<script>alert('successfully deleted')</script>";
            echo "<script>window.location.href='view_report.php';</script>";
        }
    }*/
   $downloadsql= "SELECT RDL.* ,`UD`.`name` FROM reprot_download_log RDL INNER JOIN userdetail UD ON RDL.user = UD.id WHERE RDL.type='login' ORDER BY RDL.`id` DESC";
    $result=$vgdb->get_results($downloadsql);
   // debug($result);
   // die;
?>
<?php include_once("include/side_menu.php");?>
   
            <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Report</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Report  User Log 
                            <!-- <a class="pull-right" href="entryform.php">Add Report</i> -->
</a>          </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <div class="dataTable_wrapper">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                 <thead>
                                    <tr >
                                        <th>No</th>
                                        <th>User</th>
                                        <th>Login Date</th>
                                        <th>Ip Address</th>
                                        
                                        
                                        
                                        
                                        <!-- <th>Action</th> -->
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
                                        <td><?=$aboutdata->datetime?></td>
                                        <td><?=$aboutdata->ip_address?></td>
                                       
                                        
                                        <!--  <td><a href="entryform.php?id=<?=$aboutdata->id?>" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="?id=<?=$aboutdata->id?>" class="btn btn-danger"><i class="fa fa-remove" aria-hidden="true"></i> </a>
                                        </td> -->
                                    </tr>

                                <?php  $i++;} 
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr >
                                        <th>No</th>
                                        <th>User</th>
                                        <th>Login Date</th>
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
            <!-- /.row -->
         
        </div>
        <!-- /#page-wrapper -->

 
<?php include_once("include/footer.php");?>