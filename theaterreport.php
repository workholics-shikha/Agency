<?php include_once("include/header.php");?>
<?php include_once("include/confige.php")?>

<?php include_once("include/side_menu.php");?>
   
            <div id="page-wrapper">
			<div class="col-lg-12">
            <?php 
              if(!checkPermission('manage_users')){
                _die('You cannot access this page','Permission Denied');
              }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Report Form                
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <form method="post" enctype="multipart/form-data">
                        	
                            <div class="col-lg-10">
                              <div class="form-group">
                                  <label>Theatre Name</label>
                                  <input type="text" class="form-control" placeholder="" name="name" required>
                              </div>
                              <div class="form-group">
                                  <label>Region</label>
                                  <input type="text" class="form-control" name="region" required>
                              </div>
							  <div class="form-group">
                                  <label>District</label>
                                  <input type="text" class="form-control" name="district" required>
                              </div>
							  <div class="form-group">
                                  <label>Seating</label>
                                  <input type="text" class="form-control" name="seating" required>
                              </div>
							  <div class="form-group">
                                  <label>ThCode</label>
                                  <input type="text" class="form-control" name="thcode" required>
                              </div>							  
                         </div>
                            <div class="col-lg-12 text-center"> 
                            <hr>
                              <input type="submit" name="submit" class="btn btn-primary"  value="Save">
                                <input type="reset" value="Reset" name="reset" class="btn btn-default">
                               <input type="hidden" value="reportform" name="action">
							</div>
                        </form>
                    </div> 
                </div>
                <!-- /.panel-body -->
                
               
            </div>
            <!-- /.panel -->
        </div>
            <div class="row">
                <div class="col-lg-12">
				<?php
				     if(isset($_GET['id'])){
						$id = $_GET['id'];
						$delete = mysql_query("DELETE FROM `theater` WHERE `id`='".$id."'");   
					   if($delete==true){
	                echo '<p class="alert alert-danger">"Theater Deleted"</p>';
                    }else{echo'<p class="alert alert-danger">"Try Again"</p>';}
					   }
					   ?>
                    <h1 class="page-header">Theaters Report</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
			
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Theaters Report 
                            <?php /*if(!checkPermission('view_users') || checkPermission('manage_users')){?>
                            <a class="pull-right" href="theater.php">Theaters Report</i>
                            <?php }*/?>
</a>          </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <div class="dataTable_wrapper">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
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
                                    $i=0;
									$sql=mysql_query("SELECT * FROM theater ORDER BY `id` DESC");
                                    while($row = mysql_fetch_array($sql)){
										$i++;
                                ?>
                                    <tr>
                                        <td><? echo $i?></td>
                                        <td><? echo $row['name']?></td>
										<td><? echo $row['region']?></td>
										<td><? echo $row['district']?></td>
										<td><? echo $row['seating']?></td>
										<td><? echo $row['thcode']?></td>
										<td>
                                        <a href="theater_form.php?id=<? echo $row['id'];?>" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> | 
                                            <a href="alltheater.php?id=<? echo $row['id'];?>" class="btn btn-danger"><i class="fa fa-remove" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>

									<?php } ?>
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