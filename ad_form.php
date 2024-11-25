<?php include_once("include/header.php");

?>

        
<div class="content-wrapper">
    <div class="row">

            <div class="col-md-12">
                <h1 class="page-header">Edit Ad</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
    <!-- /.row -->
     <section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php
			
			if(isset($_REQUEST['action']) && $_REQUEST['action']=='update'){
			    
			  
$periodfrom = date("Y-m-d", strtotime($_POST['periodfrom']));
	 $periodto = date("Y-m-d", strtotime($_POST['periodto']));
 $date = date("Y-m-d", strtotime($_POST['date']));
		$id=$_GET['id'];

	
	$clientname=$_POST['clientname'];
				 $family=$_POST['family'];
				 $rono=$_POST['rono'];
						$invoiceno=$_POST['invoiceno'];
			$agencyname=$_POST['agencyname'];
						$duration=$_POST['duration'];
			$langauge=$_POST['langauge'];
			 $spot=$_POST['spot'];
						$status=$_POST['status'];

 
   $updated = $prbsl->update('ad',array('clientname'=>$clientname,
        'family'=>$family,'rono'=>$rono,'invoiceno'=>$invoiceno,'agencyname'=>$agencyname,'duration'=>$duration,'langauge'=>$langauge,'spot'=>$spot,'status'=>$status,'periodfrom'=>$periodfrom,'periodto' =>$periodto,'date'=>$date),array('id'=>$id));

   if($updated){
			 $msg = 'Updated successfully';
  } 
  else{
    $error=true;
    $msg = 'Some error occured when updating';
  }
   }
			
            ?>
            
              <?php
            if(!$error && $msg !=''){
              echo '<div class="alert alert-success">'.$msg.'</div>';
            }
            else if($error && $msg !=''){
              echo '<div class="alert alert-danger">'.$msg.'</div>';
            }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Ad 
                    <a class="pull-right" href="allad.php">Back</i></a>                    
                </div>
				<?php 
				$gqt = "select * from `ad` where `id`='".$_GET['id']."' order by `id` Desc";
				
				 $quwer=$prbsl->get_row($gqt);
				?>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <form action="" method="post" enctype="multipart/form-data">
                          
                            <div class="col-lg-10">
                               <div class="form-group">
                                  <label>Client Name</label>
                                  <input type="text" class="form-control" value="<?php echo $quwer['clientname']?>"  name="clientname" required>
                              </div>
							  <div class="form-group">
                                  <label>Campaign Name</label>
                                  <input type="text" class="form-control" value="<?php echo $quwer['family']?>"  name="family" required>
                              </div>
							  
                              <div class="form-group">
                                  <label>RO No</label>
                                  <input type="text" class="form-control" value="<?php echo $quwer['rono']?>" name="rono" required>
                              </div>
							  <!-- <div class="form-group">
                                  <label>Title</label>
                                  <input type="text" class="form-control" value="<?php echo $quwer['title']?>" name="title" required>
                              </div> -->
							  <div class="form-group">
                                  <label>Period From</label>
                                  <input type="text" id="datepicker1" value="<?php echo $quwer['periodfrom']?>" class="form-control" name="periodfrom" required>
                              </div>
							  <div class="form-group">
                                  <label>Period To</label>
                                  <input type="text" id="datepicker2" value="<?php echo $quwer['periodto']?>" class="form-control" name="periodto" required>
                              </div>
							  <div class="form-group">
                                  <label>Invoice No</label>
                                  <input type="text" class="form-control" value="<?php echo $quwer['invoiceno']?>"  name="invoiceno" required>
                              </div>
							  <div class="form-group">
                                  <label>Date</label>
                                  <input type="text" id="datepicker3" value="<?php echo $quwer['date']?>" class="form-control" name="date" required>
                              </div>
							  <div class="form-group">
                                  <label>Agency Name</label>
                                  <input type="text" class="form-control" value="<?php echo $quwer['agencyname']?>" name="agencyname" required>
                              </div>
							  <div class="form-group">
                                  <label>Duration</label>
                                  <input type="text" class="form-control" value="<?php echo $quwer['duration']?>" name="duration" required>
                              </div>
							  <div class="form-group">
                                  <label>Langauge</label>
                                  <input type="text" class="form-control" value="<?php echo $quwer['langauge']?>" name="langauge" required>
                              </div>
							  <div class="form-group">
                                  <label>Spot</label>
                                  <select class="form-control" name="spot" required>
								  <option <?php if($quwer['spot']==1){echo'selected';}?> value="1">Preshow</option>
								  <option <?php if($quwer['spot']==2){echo'selected';}?> value="2">Postshow</option>
								  <option <?php if($quwer['spot']==3){echo'selected';}?> value="3">Interval</option>
								  </select>
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
                              <input type="submit" name="submit" class="btn btn btn-primary"  value="update">
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
    </section>
    <!-- /.row -->
 
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