<?php include_once("include/header.php");?>
  
           <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12">
				<?php
				     if(isset($_GET['id'])){
						$id = $_GET['id'];
						$delete=$prbsl->delete('maintable',array('id'=>$id));   
					   if($delete==true){
	                echo '<p class="alert alert-danger">"Report Deleted"</p>';
                    }else{echo'<p class="alert alert-danger">"Try Again"</p>';}
					   }
                ?>
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
                            
</a>          </div>
                        <!-- /.panel-heading -->
                 <div class="box-body">

            <div class="table-responsive">

        <table class="table table-bordered">
                                 <thead>
                                    <tr >
                                        <th>#</th>
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
									$sql="SELECT * FROM `maintable` ORDER BY `id` DESC";
                                    $result=$prbsl->get_results($sql);
                                   
                                    foreach ($result as $row) {
                                ?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td><?php echo $row->theater_name;?></td>
										<td><?php echo $row->region;?></td>
										<td><?php echo $row->district;?></td>
										<td><?php echo $row->seating;?></td>
										<td><?php echo $row->thcode;?></td>
										<td>
                                            <a href="mainreport.php?id=<?php echo $row->id;?>" class="btn btn-danger"><i class="fa fa-remove" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
									<?php $i++; }?>
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