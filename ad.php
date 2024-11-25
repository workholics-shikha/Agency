<?php 
include_once("include/header.php");
?>

<?php
$error=false;
$emsg = '';
?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
	$( "#datepicker1" ).datepicker();
	$( "#datepicker2" ).datepicker();
	$( "#datepicker3" ).datepicker();
  } );
  </script>

<div class="content-wrapper">
    
                <section class="content-header">
        <h1>Add AD
         
		</h1>
	</section>
              
                
                
           
            <!-- /.col-lg-12 -->
        
    <!-- /.row -->
    <section class="content">
    <div class="row">
        <div class="col-md-12">
           
                <?php

        $clients =$prbsl->get_results("SELECT * FROM userdetail where role='client' ORDER BY `id` ASC");
               // `title`,'".$_REQUEST['title']."'
				if(isset($_REQUEST['action']) && $_REQUEST['action']=='log'){
					$periodfrom = date("Y-m-d", strtotime($_POST['periodfrom']));
					$periodto = date("Y-m-d", strtotime($_POST['periodto']));
					$date = date("Y-m-d", strtotime($_POST['date']));
         
				
					$client_id=$_POST['client_id'];
          $client = $prbsl->get_row("SELECT * FROM `userdetail` WHERE `role`='client' AND `id`='$client_id'");

          $clientname = $client['name'];
          $family=$_POST['family'];
					$rono=$_POST['rono'];
          $caption=$_POST['title'];
					$invoiceno=$_POST['invoiceno'];
					$agencyname=$_POST['agencyname'];
					$duration=$_POST['duration'];
					$langauge=$_POST['langauge'];
					$spot=$_POST['spot'];
					$status=$_POST['status'];


          
					$sql = $prbsl->insert("ad",
              array(
                /*'service'=>$service,
                'url'=>$url,*/
                'clientname'=>$clientname,
                'family'=>$family,
                'rono'=>$rono,
                'title'=>$caption,
                'invoiceno'=>$invoiceno,
                'agencyname'=>$agencyname,
                'duration'=>$duration,
                'langauge'=>$langauge,
                'spot'=>$spot,
                'status'=>$status,
                'periodfrom'=>$periodfrom,
                'periodto '=>$periodto,
                'date'=>$date,
                /*'note'=>$note*/
              )
    );
					if($sql==true){
	                echo '<p class="alert alert-success">"Ad and RO Detail successfully submitted "</p>';
                    }else{echo'<p class="alert alert-danger">"Try Again"</p>';}
				   }
                ?>

     
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add Ad                 
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <form method="post" enctype="multipart/form-data">
                        	
                            <div class="col-md-10">
                              <div class="form-group">
                                  <label>Client Name</label>
                                  <select class="form-control" name="client_id" required>
                                     <option value="">Select Client</option>
                                     <?php if(!empty($clients)): ?>
                                        <?php foreach($clients as $client): ?>
                                          <option value="<?php echo $client->id; ?>"><?php echo $client->name; ?></option>
                                        <?php endforeach; ?>  
                                     <?php endif; ?>  
                                  </select>
                              </div>
							  <div class="form-group">
                                  <label>Campaign Name</label>
                                  <input type="text" class="form-control" placeholder="" name="family" required>
                              </div>
							  
                              <div class="form-group">
                                  <label>RO No</label>
                                  <input type="text" class="form-control" name="rono" required>
                              </div>
							  <div class="form-group">
                                  <label>Caption</label>
                                  <input type="text" class="form-control" name="title" required>
                              </div>
							  <div class="form-group">
                                  <label>Period From</label>
                                  <input type="text" id="datepicker1" class="form-control" name="periodfrom" required>
                              </div>
							  <div class="form-group">
                                  <label>Period To</label>
                                  <input type="text" id="datepicker2" class="form-control" name="periodto" required>
                              </div>
							  <div class="form-group">
                                  <label>Invoice No</label>
                                  <input type="text" class="form-control" name="invoiceno" required>
                              </div>
							  <div class="form-group">
                                  <label>Date</label>
                                  <input type="text" id="datepicker3" class="form-control" name="date" required>
                              </div>
							  <div class="form-group">
                                  <label>Agency Name</label>
                                  <input type="text" class="form-control" name="agencyname" required>
                              </div>
							  <div class="form-group">
                                  <label>Duration</label>
                                  <input type="text" class="form-control" name="duration" required>
                              </div>
							  <div class="form-group">
                                  <label>Langauge</label>
                                  <input type="text" class="form-control" name="langauge" required>
                              </div> 
							  <div class="form-group">
                                  <label>Spot</label>
                                  <select class="form-control" name="spot" required>
								  <option value="1">Preshow</option>
								  <option value="2">Postshow</option>
								  <option value="3">Interval</option>
								  </select>
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
                            <input type="hidden" value="log" name="action">
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
    </section>
    </div>
    <!-- /.row -->
 

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