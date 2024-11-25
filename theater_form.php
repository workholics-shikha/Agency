<?php include_once("include/header.php");?>

  
<div class="content-wrapper">
    <div class="row">

            <div class="col-md-12">
                <h1 class="page-header">Edit Theater</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
    <!-- /.row -->
     <section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php
			
if(isset($_POST['action']) && $_POST['action']=='update'){
	$timezone = new DateTimeZone('Asia/Calcutta');
    $date =  date('Y-m-d');
    $time =  date("h:i:sa");
    $id=$_GET['id'];
	//$update =  mysql_query("UPDATE `theater` SET `company`='".$_REQUEST['company']."',`name`='".$_REQUEST['name']."',`region`='".$_REQUEST['region']."',`district`='".$_REQUEST['district']."',`seating`='".$_REQUEST['seating']."',`thcode`='".$_REQUEST['thcode']."',`date`='".$date."',`time`='".$time."',`status`='".$_REQUEST['name']."' WHERE `id`='".$_REQUEST['id']."'"); 
	
		$company=$_POST['company'];
				 $name=$_POST['name'];
				 $region=$_POST['region'];
						$district=$_POST['district'];
			$seating=$_POST['seating'];
						$thcode=$_POST['thcode'];
			$date=$_POST['date'];
			 $time=$_POST['time'];
						$status=$_POST['status'];
	
	 $updated = $prbsl->update('theater',array('company'=>$company,
        'name'=>$name,'region'=>$region,'district'=>$district,'seating'=>$seating,'thcode'=>$thcode,'date'=>$date,'time'=>$time,'status'=>$status),array('id'=>$id));

	//$updated = $prbsl->update("theater",$data,array('id'=>$id));
   if($updated==true){
				echo '<div class="alert alert-success">"Updated"</div>';
			}else{
				echo '<div class="alert alert-success">"Try Again"</div>';
			}
   }
			
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Theater 
                    <a class="pull-right" href="alltheater.php">Back</i></a>                    
                </div>
				<?php 
				$gqt = "select * from `theater` where `id`='".$_REQUEST['id']."' order by `id` Desc";
				$quwer  = $prbsl->get_row($gqt);
				?>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <form action="" method="post" enctype="multipart/form-data">
                          
                            <div class="col-lg-10">
						 <div class="form-group">
                                  <label>Company Name</label>
                                  <input type="text" class="form-control" value="<?php echo $quwer['company']?>" name="company" required>
                              </div>
						   
                               <div class="form-group">
                                  <label>Theatre Name</label>
                                  <input type="text" class="form-control" value="<?php echo $quwer['name']?>" name="name" required>
                              </div>
                              <div class="form-group">
                                  <label>Region</label>
                                  <input type="text" class="form-control" name="region" value="<?php echo $quwer['region']?>" required>
                              </div>
							  <div class="form-group">
                                  <label>District</label>
                                  <input type="text" class="form-control" value="<?php echo $quwer['district']?>" name="district" required>
                              </div>
							  <div class="form-group">
                                  <label>Seating</label>
                                  <input type="text" class="form-control" value="<?php echo $quwer['seating']?>" name="seating" required>
                              </div>
							  <div class="form-group">
                                  <label>ThCode</label>
                                  <input type="text" class="form-control" value="<?php echo $quwer['thcode']?>" name="thcode" required>
                              </div>
							  <div class="form-group">
                                  <label>Status</label>
                                  <select class="form-control" name="status" required>
								  <option <?php if($quwer['status']==1){echo'selected';}?> value="1">Active</option>
								  <option <?php if($quwer['status']==0){echo'selected';}?> value="0">Deactive</option>
								  </select>
								  
                              </div>
                            </div>
                            <div class="col-lg-12 text-center"> 
                            <hr>
                            <input type="hidden" value="update" name="action">
                              <input type="submit" name="updateForm" class="btn btn btn-primary"  value="update">
                              <!--<input type="reset" value="Reset" name="reset" class="btn btn-default">-->
                               
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
    <!-- /.row -->
 </section>
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