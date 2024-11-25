<?php include_once("include/header.php");

$adminId = $_SESSION['adminId'];
$permissions = $prbsl->get_var("SELECT permissions FROM userdetail WHERE id='$adminId'");
$userPermissions = array();
if(!empty($permissions))
{
  $userPermissions = unserialize($permissions);
}

if(!array_key_exists("theater",$userPermissions))
{
    echo '<script>window.location.href="'.admin_url().'index.php";</script>';
}

?>


   
             <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12">
				<?php
                $error=false;
                $msg='';
				    if(isset($_GET['status'])){
                        $uid = $_GET['uid'];
                        $status = $_GET['status'];

                        $updatequery="UPDATE `theater` SET status='".$status."' WHERE id='$uid'";
                        if(mysql_query($updatequery)){
                            $msg="Row Successfuly Updated";
                            echo "<script>var i=setTimeout(function(){window.location.href='alltheater.php'}, 2000)</script>";
                        }else{
                            $error=true;
                            $msg="Please check Data";
                            echo "<script>var i=setTimeout(function(){window.location.href='alltheater.php'}, 2000)</script>";
                        }

                    }

                    if(isset($_GET['id'])){
						$id = $_GET['id'];
						$delete = $prbsl->delete("theater",array('id'=>$id));
						
						
					   if($delete==true){
	                echo '<p class="alert alert-danger">"Theater Deleted"</p>';
                    }else{echo'<p class="alert alert-danger">"Try Again"</p>';}
					   }
                    
                  
                ?>
                <section class="content-header">
                    <h1 class="page-header">Theaters</h1>
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
                            Theaters Data 
                            <a class="pull-right" href="theater.php">Add Theaters</i> </a>          
                        </div>
                        <!-- /.panel-heading -->
                       <div class="box-body">
                        <?php
                          if(!$error && $msg !=''){
                            echo '<div class="alert alert-success">'.$msg.'</div>';
                          }
                          if($error && $msg !=''){
                            echo '<div class="alert alert-danger">'.$msg.'</div>';
                          }
                        ?>
                           

            <div class="table-responsive">

        <table class="table table-bordered">
                                    <tr >
                                        <th>#</th>
								        <th>Company</th>
                                        <th>Theatre Name</th>
										<th>Region</th>
										<th>District</th>
										<th>Seating</th>
										<th>ThCode</th>
                                        <th>Action</th>                                        
                                    </tr>
                                </thead>   
                                <tbody>
                                <?php
                                    $i=1;
									$sql="SELECT * FROM theater ORDER BY `id` DESC";
                                   
										 $result=$prbsl->get_results($sql);
                                    if(!empty($result)>0){
                                    foreach ($result as $row) {
                                ?>
                                    <tr>
                                        <td><?php echo $i?></td>
                                        <td><?php echo $row->company;?></td>
								        <td><?php echo $row->name;?></td>
										<td><?php echo $row->region;?></td>
										<td><?php echo $row->district;?></td>
										<td><?php echo $row->seating;?></td>
										<td><?php echo $row->thcode;?></td>
										<td>
                                        
                                        <a href="theater_form.php?id=<?php echo $row->id;?>" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> | 
                                            <a href="alltheater.php?id=<?php echo $row->id;?>" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>

									<?php $i++; } }?>
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
            </section>
            <!-- /.row -->
         
        </div>
        <!-- /#page-wrapper -->

 
<?=include_once("include/footer.php");?>