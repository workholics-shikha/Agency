<?php include_once("include/header.php");?>

<?php
$error=false;
$emsg = '';

?>

   
 <div class="content-wrapper">
    <div class="row">
            <div class="col-md-12">
                <?php
				if(isset($_POST['submit']))
{
	$timezone = new DateTimeZone('Asia/Calcutta');
    $date =  date('Y-m-d');
    $time =  date("h:i:s");
 // $sql = $prbsl->insert("INSERT INTO `theater`(`id`,`company`,`name`, `region`, `district`, `seating`, `thcode`, `date`,`time`, `status`) VALUES (null,'".$_POST['company']."','".$_POST['name']."','".$_POST['region']."','".$_POST['district']."','".$_POST['seating']."','".$_POST['thcode']."','".$date."','".$time."','".$_POST['status']."')");
  
  
  		
					$company=$_POST['company'];
					$name=$_POST['name'];
					$region=$_POST['region'];
					$district=$_POST['district'];
					$seating=$_POST['seating'];
					$thcode=$_POST['thcode'];
					$status=$_POST['status'];
				
					$sql = $prbsl->insert("theater",
      array(
        /*'service'=>$service,
        'url'=>$url,*/
        'company'=>$company,
        'name'=>$name,
        'region'=>$region,
        'district'=>$district,
        'seating'=>$seating,
        'thcode'=>$thcode,
        'status'=>$status,
        
        'date '=>$date,
        'time'=>$time,
        /*'note'=>$note*/
      )
    );

                    if($sql==true){
	                echo '<p class="alert alert-danger">"Theater Added"</p>';
                    }else{echo'<p class="alert alert-danger">"Try Again"</p>';}
 }                 
                ?>
                <section class="content-header">
                <h1 class="page-header">Add Theater</h1>
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
                    Add Theater                 
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <form method="post" enctype="multipart/form-data">
                        	
                            <div class="col-lg-10">
                             <?php if($error){  ?>
                            	<div class="alert alert-warning">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Success!</strong> <?=$error_message?>
                               </div>
                            <?php } ?>
                            <?php if(isset($success_message)){  ?>
                            	<div class="alert alert-success">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Success!</strong> <?=$success_message?>
                               </div>
                            <?php } ?> 
                              <div class="form-group">
                                  <label>Company Name</label>
                                  <input type="text" class="form-control" placeholder="" name="company" required>
                              </div>
						   
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
							  <div class="form-group">
                                  <label>Status</label>
                                  <select class="form-control" name="status" required>
								  <option value="1">Active</option>
								  <option value="0">Deactive</option>
								  </select>
								  
                              </div>
                         </div>
                            <div class="col-lg-12 text-center"> 
                            <hr>
                            
                              <input type="submit" name="submit" class="btn btn-primary"  value="Save">
                                <input type="reset" value="Reset" name="reset" class="btn btn-default">
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