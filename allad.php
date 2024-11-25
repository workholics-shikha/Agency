<?php include_once("include/header.php");


    $adminId = $_SESSION['adminId'];
    $permissions = $prbsl->get_var("SELECT permissions FROM userdetail WHERE id='$adminId'");
    $userPermissions = array();
    if(!empty($permissions))
    {
    $userPermissions = unserialize($permissions);
    }
 
    if(!array_key_exists("ads",$userPermissions))
    {
        echo '<script>window.location.href="'.admin_url().'index.php";</script>';
    }

?>

   
            <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12">
				<?php
				     if(isset($_GET['id'])){
						$id = $_GET['id'];
						$delete = $prbsl->delete("ad",array('id'=>$id)); 
					   if($delete==true){
	                echo '<p class="alert alert-danger">"Ad Deleted"</p>';
                    }else{echo'<p class="alert alert-danger">"Try Again"</p>';}
					   }
                    
                  
                ?>
                <section class="content-header">
                    <h1 class="page-header">Ads</h1>
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
                            Ads Data 
                            
                            <a class="pull-right" href="ad.php">Add Ad</i>
                         
</a>          </div>
                        <!-- /.panel-heading -->
                        <div class="box-body">

            <div class="table-responsive">

        <table class="table table-bordered">
                                    <tr>
                                        <th>#</th>
                                        <!-- <th>Title</th> -->
                                        <th>Client Name</th>
										<th>Ro No</th>
										<th>Period From</th>
                                        <th>Period to</th>
										<th>Action</th>
								    </tr>
                                </thead>   
                                <tbody>
                                <?php
                                     $i=1;
                                    $sql="SELECT * FROM ad ORDER BY `id` DESC";
                                    $result=$prbsl->get_results($sql);
                                    if(!empty($result)>0){
                                    foreach ($result as $row) {
										
                                ?>
                                    <tr>
                                        <td><?php echo $i?></td>
                                       <td><?php echo $row->clientname;?></td>
									   <td><?php echo $row->rono;?></td>
										<td><?php echo $row->periodfrom;?></td>
										<td><?php echo $row->periodto;?></td>
										<td>
                                        <a href="ad_form.php?id=<?php echo $row->id;?>" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> | 
                                            <a href="allad.php?id=<?php echo $row->id;?>" class="btn btn-danger"><i class="fa fa-remove" aria-hidden="true"></i></a>
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

 
<?=include_once("include/footer.php");?>