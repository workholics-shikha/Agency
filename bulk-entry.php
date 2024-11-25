<?php include_once("include/header.php");?>

<?php
$error=false;
$emsg = '';
?>
  <link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="js/bootstrap-datetimepicker.js"></script>
  <script>
  $(function() {
	  $('#datepicker').datepicker({
		autoclose: true,  
        todayHighlight: true
	  });
	  $("#toDate").datepicker({
			autoclose: true,  
			todayHighlight: true
	  });
	  
     $('.timepicker').datetimepicker({
    format:"hh:mm:ss",
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 1,
    minView: 0,
    maxView: 1,
    forceParse: 0
    });	
  } );
  </script>
<style>
 .datepicker .prev,.datepicker .next{
     position: relative;
    color: black;
 }
</style>
<div class="content-wrapper">
    <div class="row">
            <div class="col-md-12">
                <?php
				
        $adminId = $_SESSION['adminId'];
        $permissions = $prbsl->get_var("SELECT permissions FROM userdetail WHERE id='$adminId'");
        $userPermissions = array();
        if(!empty($permissions))
        {
          $userPermissions = unserialize($permissions);
        }
     
        if(!array_key_exists("bulk_entry",$userPermissions))
        {
             echo '<script>window.location.href="'.admin_url().'index.php";</script>';
        }

				if(isset($_REQUEST['action']) && $_REQUEST['action']=='entry'){
					// echo '<pre>'; print_r($_POST); die;
		  $t_id    = $_POST['t_id'];
			
					$language = $_POST['language'];
						
					$a_id    = $_POST['a_id'];
                   $movietime = date("H:i:s" ,strtotime($_POST['movietime']));				
				//	$a1 = $prbsl->get_row("select * from `theater` where `id`=$t_id ");
					$a1 = $prbsl->get_row("select * from `theater` where `id`='".$t_id."' ");
                 
				 $theatername = $a1['name']; 
					 
					$region = $a1['region']; 
					$district = $a1['district'];
				$seating = $a1['seating'];
						$thcode = $a1['thcode'];
					$a2 = $prbsl->get_row("select * from `ad` where `id`='".$a_id."'");
					
				$title = $a2['title'];
					$duration = $a2['duration'];
                    	 $rono   = $a2['rono'];
                    $fromTime  = strtotime($_POST['fromDate']);
                      $toTime  = strtotime($_POST['toDate']);
                     $fromDate = date("Y-m-d",$fromTime);
                    $toDate    = date("Y-m-d",$toTime);
                    $totalDays = floor(($toTime-$fromTime) / (60 * 60 * 24));

                    for($j=0;$j<=$totalDays;$j++){

                         $starttime  = $_POST['starttime'];
                        
                         $endtime    = date("H:i:s" ,strtotime($starttime)+$duration);
                        
                         $airdate    = date("Y-m-d",strtotime("$fromDate + $j days"));
                         
                         $movietime  = date("H:i:s",strtotime($_POST['movietime']));

                        $show1 = $_POST['show1']+1;
                        for($i=1;$i<$show1;$i++) {
                      
                            $showtype   = $_POST['showtype'];
                            
                            $showing    = $_POST['showing'];

                            $title      = $_POST['title'];

                            $email      = $_SESSION['email'];

                            $starttimee = date("H:i:s",strtotime($starttime));
                             
                            $sql=$prbsl->insert('maintable',array('theater_name'=>$theatername,'region'=>$region,'district'=>$district,'seating'=>$seating,'thcode'=>$thcode,'airdate'=>$airdate,'starttime'=>$starttimee,'endtime'=>$endtime,'showtype'=>$showtype,'showing'=>$showing,'duration'=>$duration,'caption'=>$title,'user'=>$email,'status'=>1,'rono'=>$rono,'language'=>$language,'movietime'=>$movietime,'show1'=>$i,'a_id'=>$a_id));
                            
                            $str_time     = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $endtime);
                            sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                            $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                            $starttime    = date("H:i:s",strtotime($movietime)+$time_seconds);
                            $endtime      = date("H:i:s",strtotime($starttime)+$duration);
                        }
                    }					
                    if($sql==true){
                      echo '<p class="alert alert-success">Data Successfuly  Added</p>';
                    }else{
                      echo'<p class="alert alert-danger">"Try Again"</p>';
                    }
                }  
                ?>
                <h1 class="page-header">Add Report </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
    <!-- /.row -->
  <section class="content">
    <div class="row">
        <div class="col-md-12">
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add Report 
                    
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                     
                        <form method="post" enctype="multipart/form-data">
                        	
                            <div class="col-lg-10">
                             <div class="form-group">
                                    <div class="form-inline">
                                      <div class="form-group">
                                        <label>From Date : </label>
										<input  type="text" name="fromDate" placeholder="From Date" class="form-control datepicker" id="datepicker" autocomplete="off" readonly required>
										
                                        
                                      </div>
                                      <div class="form-group">
                                        <label>To Date : </label>
										<input  type="text" name="toDate" placeholder="End Date" class="form-control datepicker" id="toDate" autocomplete="off" readonly required>
										
                                        
                                      </div>
                                  </div>
                                </div>
                               <div class="form-group">
                                  <label>Ads Name ( Ro No. )</label>
                                  <select class="form-control" name="a_id" required id="a_id">
                                  <option value="">Select Ad and Ro No</option>
                  <?php $sql2 = "select * from `ad` WHERE status='1' order by `id` ASC";
                  $rows1=$prbsl->get_results($sql2);
                      foreach($rows1 as $rows){
                  ?>
				  
                  <option value="<?php echo $rows->id;?>" ><?php echo $rows->clientname." ".$rows->title." ( ".$rows->rono." )";?></option>
                    <?php }?>
                  </select>                 
                              </div>
                              <div class="form-group">
                                  <label>Theater Name</label>
                                  <select class="form-control" id="t_id" name="t_id" required>
                                  <option value="">Select Theater Name</option>
								  <?php $sql1 = "select * from `theater` order by `id` desc";
								      
								          
								       $row1=$prbsl->get_results($sql1);
                      foreach($row1 as $row){   
								  ?>
								  <option value="<?php echo $row->id;?>" ><?php echo $row->company." ".$row->district." ".$row->name." ( ".$row->thcode." )";?></option>
									  <?php }?>
								  </select>
                              </div>
							  <div class="form-group">
                                  <label>Language</label>
                                  <select class="form-control" id="language" name="language" required>
                                      <option value="">Select Language</option>
                                      <option value="Hindi">Hindi</option>
                                      <option value="English">English</option>
                                      <option value="Punjabi">Punjabi</option>
                                      <option value="Bengali">Bengali</option>
                                      <option value="Gujrati">Gujrati</option>
                                      <option value="Marathi">Marathi</option>
                                      <option value="Telgu">Telgu</option>
                                      <option value="Tamil">Tamil</option>
                                      <option value="Assamese">Assamese</option>
                                      <option value="Kannada">Kannada</option>
                                      <option value="Malyalam">Malyalam</option>
                                  </select>
                              </div>							 
							 <div class="form-group">
                                  <label>Caption</label>
                                  <input type="text" class="form-control" value="" name="title" required>
                              </div>
                                <div class="form-group">
							  
                                  <label>Start Time (15:20:30)<?=date("H:i:s")?></label>
                                  <input type="text" class="form-control"   name="starttime" value="" placeholder="H:M:S">
                              </div>
							  <div class="form-group">
                                  <label>Showtype</label>
                                  <select class="form-control" name="showtype" required>
                                  <option value="">Select Showtype </option>
								  <option value="PST_1">PST_1</option>
								  <option value="PST_2">PST_2</option>
								  <option value="NPST_1">NPST_1</option>
								  <option value="NPST_2">NPST_2</option>
								  </select>
                              </div>
							  <div class="form-group">
                                  <label>Show (select number of show of the day)</label>
                                  <select class="form-control" name="show1" required>
                                  <option value="">Select Show </option>
								  <option value="1">1</option>
								  <option value="2">2</option>
								  <option value="3">3</option>
								  <option value="4">4</option>
								  <option value="5">5</option>
								  </select>
                              </div>
							  <div class="form-group">
                                  <label>Showing</label>
                                  <select class="form-control" name="showing" required>
                                  <option value="">Select Showing </option>
								  <option value="1">1</option>
								  <option value="2">2</option>
								  <option value="3">3</option>
								  <option value="4">4</option>
								  <option value="5">5</option>
								  </select>
                              </div>
                            <div class="form-group">
							<label>Movie Time (hh:mm:ss)<?=date("H:i:s")?></label>
                                  <input type="text" class="form-control"   name="movietime" value="" placeholder="H:M:S">
                            </div>
                            <div class="col-lg-12 text-center"> 
                            <hr>
                            <input type="hidden" value="entry" name="action">
                              <input type="submit" name="save" class="btn btn-primary"  value="Save">
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
 
</div>
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

    $("#t_id").change(function(){
      var tid =$(this).val();

      $.ajax({
        url:"ajax.php",
        type:"post",
        data: { tid:tid },
        success: function(resource){
          console.log(resource);
        }
      });
    });
   });
 </script>
<?php include_once("include/footer.php");?>