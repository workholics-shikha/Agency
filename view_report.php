<?php include_once("include/header.php");
   
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        if($prbsl->delete('maintable',array('id'=>$id))){
            echo "<script>alert('successfully deleted')</script>";
            echo "<script>window.location.href='view_report.php';</script>";
        }
    }
    
      
    $result=$prbsl->get_results("SELECT * FROM maintable ORDER BY `id` DESC limit 10000");
    //debug($result);
    $adminId = $_SESSION['adminId'];
    $permissions = $prbsl->get_var("SELECT permissions FROM userdetail WHERE id='$adminId'");
    $userPermissions = array();
    if(!empty($permissions))
    {
      $userPermissions = unserialize($permissions);
    }

    if(!array_key_exists("report",$userPermissions))
    {
        echo '<script>window.location.href="'.admin_url().'index.php";</script>';
    }
?>

   
          <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">Report</h1>
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
                           <!--<form method="post" action="export.php">
                               
                                <input type="submit" name="downloadxls" value="Download XLS" class="btn btn-primary">
                                </form>-->
                              
                           <a class="pull-right" href="bulk-entry.php">Add Report</i> 
</a>          </div>
                        <!-- /.panel-heading -->
                               <div class="box-body">

            <div class="table-responsive">

        <table class="table table-bordered">
                                    <tr >
                                        <th>No</th>
                                        <th>Theater Name</th>
                                        <th>Thcode</th>
                                        <th>Ads Name</th>
                                        <th>Airdate</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Region</th>
                                        <th>District</th>
										<!--<th>Edit</th>-->

                                        
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
                                        <td><?=$aboutdata->theater_name?></td>
                                        <td><?=$aboutdata->thcode?></td>
                                        <td><?=$aboutdata->caption?></td>
                                        <td><?=date("m-d-Y", strtotime($aboutdata->airdate)) ?></td>
                                        <td><?=$aboutdata->starttime?></td>
                                        <td><?=$aboutdata->endtime?></td>
                                        <td><?=$aboutdata->region?></td>
                                        <td><?=$aboutdata->district?></td>
                                       <td> <a href="entryform.php?id=<?=$aboutdata->id;?>" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="?id=<?=$aboutdata->id?>" class="btn btn-danger"><i class="fa fa-remove" aria-hidden="true"></i> </a>
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
                                        <th>Theater Name</th>
                                        <th>Thcode</th>
                                        <th>Ads Name</th>
                                        <th>Airdate</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Region</th>
                                        <th>District</th>
                                      <th>Action</th> 
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