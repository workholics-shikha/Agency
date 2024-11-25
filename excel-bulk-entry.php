<?php include_once("include/header.php");?>
<?php include_once("include/confige.php");?>
<?php
$error=false;
$emsg = '';
?>
<link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="css/jquery-ui.min.css">
<link rel="stylesheet" href="css/bootstrap-select.min.css">
<!--<link rel="stylesheet" href="/resources/demos/style.css">-->
<script src="js/jquery-ui.min.js"></script>
<script src="js/bootstrap-datetimepicker.js"></script>
<script src="js/bootstrap-select.min.js"></script>

<script>
jQuery(document).ready(function($){
    $("#datepicker").datepicker();
    $("#fromDate").datepicker();
    $("#toDate").datepicker();
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
});
</script>
<?php include_once("include/side_menu.php");?>
<style type="text/css">
    .btn.dropdown-toggle.btn-default{background-color: #fff;border-color: #ccc;color: #333;}
    .btn.dropdown-toggle.btn-default:hover{background-color: #e6e6e6;border-color: #adadad;color: #333;}
</style>
<div id="page-wrapper">
    <div class="row">
            <div class="col-lg-12">
                <?php
				if(isset($_REQUEST['action']) && $_REQUEST['action']=='entry'){
					$t_ids    = $_REQUEST['t_id'];
					$language = $_REQUEST['language'];
					$a_id    = $_REQUEST['a_id'];
                    $movietime = date("H:i:s" ,strtotime($_REQUEST['movietime']));					
					
                    foreach($t_ids as $t_id){
                        $a1 = mysql_fetch_array(mysql_query("select * from `theater` where `id`='".$t_id."'"));
                        $theatername = $a1['name'];
                        $region = $a1['region'];
                        $district = $a1['district'];
                        $seating = $a1['seating'];
                        $thcode = $a1['thcode'];
                        $a2 = mysql_fetch_array(mysql_query("select * from `ad` where `id`='".$a_id."'"));				
                        $title = $a2['title'];
                        $duration = $a2['duration'];
                        $rono = $a2['rono'];
                        $fromTime = strtotime($_POST['fromDate']);
                        $toTime = strtotime($_POST['toDate']);
                        $fromDate = date("Y-m-d",$fromTime);
                        $toDate = date("Y-m-d",$toTime);
                        $totalDays = floor(($toTime-$fromTime) / (60 * 60 * 24));
                        for($j=0;$j<=$totalDays;$j++){
                            $starttime  = $_REQUEST['starttime'];
                            $endtime =date("H:i:s" ,strtotime($starttime)+$duration);
                            $airdate = date("Y-m-d",strtotime("$fromDate + $j days"));
                            $starttime = $_REQUEST['starttime'];
                            $movietime = $_REQUEST['movietime'];
                            $show = $_REQUEST['show']+1;
                            for ($i = 1; $i < $show ; $i++) {
                                $sql =  mysql_query("INSERT INTO `demo_main_table`(`id`, `theater_name`, `region`, `district`, `seating`, `thcode`, `airdate`, `starttime`, `endtime`, `showtype`, `show`, `showing`, `duration`, `caption`, `user`, `status`,`rono`,`language`,`movietime`) VALUES (null,'".$theatername."','".$region."','".$district."','".$seating."','".$thcode."','".$airdate."','".date("H:i:s",strtotime($starttime))."','".$endtime."','".$_REQUEST['showtype']."','".$i."','".$_REQUEST['showing']."','".$duration."','".$_REQUEST['title']."','".$_SESSION['email']."','1','".$rono."','".$language."','".$movietime."')"); 
                                $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $endtime);
                                sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                                $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
                                $starttime = date("H:i:s",strtotime($movietime)+$time_seconds);
                                $endtime = date("H:i:s",strtotime($starttime)+$duration);
                            }
                        }
                        if($sql==true){
                          echo '<p class="alert alert-success">Data Successfuly  Added</p>';
                        }
                        else{
                          echo'<p class="alert alert-danger">"Try Again"</p>';
                        }
                    }                    
                }  
                ?>
                <h1 class="page-header">Add Entry</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add Entry                 
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
                                        <input type="text" class="form-control" id="fromDate" name="fromDate" value="" required>
                                      </div>
                                      <div class="form-group">
                                        <label>To Date : </label>
                                        <input type="text" class="form-control" id="toDate" name="toDate" value="" required>
                                      </div>
                                  </div>
                                </div>
                               <div class="form-group">
                                  <label>Ads Name ( Ro No. )</label>
                                  <select class="form-control selectpicker" name="a_id" required id="a_id" data-live-search="true">
                                    <?php $sql2 = mysql_query("select * from `ad` WHERE status='1'   order by `id` ASC");
                                    while($rows = mysql_fetch_array($sql2)){
                                        echo '<option value="'.$rows['id'].'" >'.$rows["clientname"]." ".$rows['title']." ( ".$rows['rono']." )".'</option>';
                                     }?>
                                </select>                 
                              </div>
                              <div class="form-group">
                                  <label>Theater Name</label>
                                  <select class="form-control selectpicker" id="t_id" name="t_id[]" required multiple data-live-search="true">
                                  <!--<option value="">Select Theater Name</option>-->
                                      <?php 
                                      $sql1 = mysql_query("select * from `theater` order by `district` ASC");
                                        while($row = mysql_fetch_array($sql1)){
                                            echo '<option value="'.$row['id'].'" >'.$row['district']." ".$row['name']." ( ".$row['thcode']." )".'</option>'; 
									   }?>
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
                                  <select class="form-control" name="show" required>
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
                              <input type="submit" name="save" class="btn btn-primary"  value="Save">
                                <input type="reset" value="Reset" name="reset" class="btn btn-default">
                               <input type="hidden" value="entry" name="action">
							   
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
       $('.selectpicker').selectpicker({
          //style: 'btn-default',
          //size: 4
        });

   });
 </script>
<?php include_once("include/footer.php");?>