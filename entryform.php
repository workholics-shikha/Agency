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
    $("#datepicker").datepicker();
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
<?php 
    if(isset($_GET['id'])){

        $sqlentry="SELECT * FROM maintable where `id`='".$_GET['id']."'";
        $entrydata=$prbsl->get_row($sqlentry);

        
    }

?>  
<?php //print_r($entrydata); debug($userId); ?>

<div class="content-wrapper">
    <div class="row">
            <div class="col-md-12">
                <?php
				if(isset($_REQUEST['action']) && $_REQUEST['action']=='entry'){
					$airdate = date("Y-m-d", strtotime($_REQUEST['airdate']));
					$starttime  = $_REQUEST['starttime'];

				    //$endtime    = $_REQUEST['endtime'];
          //$endtime=date("");
					$t_id    = $_REQUEST['t_id'];
					$language = $_REQUEST['language'];
					$a_id    = $_POST['a_id'];
                    $movietime = date("H:i:s" ,strtotime($_REQUEST['movietime']));					
					$a1 = $prbsl->get_row("select * from `theater` where `id`='".$t_id."' ");
					$theatername = $a1['name'];
					$region = $a1['region'];
					$district = $a1['district'];
					$seating = $a1['seating'];
					$thcode = $a1['thcode'];
					
						$a2 = $prbsl->get_row("select * from `ad` where `id`='".$a_id."'");
					$title = $a2['title'];
					$duration = $a2['duration'];

          $rono = $a2['rono'];
					$endtime =date("H:i:s" ,strtotime($starttime)+$duration);
          
          if(isset($_GET['id'])){
               $show11=$_POST['show1'];
              	  $showtype=$_POST['showtype'];
                           $showing=$_POST['showing'];
                              $title=$_POST['title'];
                           $email=$_SESSION['email'];
                            $starttimee=date("H:i:s",strtotime($starttime));
                            	$a_id    = $_POST['a_id'];
                            	$id=$_GET['id'];
            
            //$sqlupdate=mysql_query("UPDATE  `maintable` SET  `theater_name`='".$theatername."', `region`='".$region."', `district`='".$district."', `seating`='".$seating."', `thcode`='".$thcode."', `airdate`='".$airdate."', `starttime`='".date("H:i:s" ,strtotime($_REQUEST['starttime']))."', `endtime`='".$endtime."', `showtype`='".$_REQUEST['showtype']."', `show`='".$_REQUEST['show']."', `showing`='".$_REQUEST['showing']."', `duration`='".$duration."', `caption`='".$_REQUEST['title']."', `user`='".$userId."',`rono`='".$rono."',`language`='".$language."',`movietime`='".$movietime."' where id='".$_GET['id']."'");
            //$prbsl->insert("reprot_download_log",$array);
            
            

 
   $sql = $prbsl->update('maintable',array('theater_name'=>$theatername,'region'=>$region,'district'=>$district,'seating'=>$seating,'thcode'=>$thcode,'airdate'=>$airdate,'starttime'=>$starttimee,'endtime'=>$endtime,'showtype'=>$showtype,'showing'=>$showing,'duration'=>$duration,'caption'=>$title,'user'=>$email,'status'=>1,'rono'=>$rono,'language'=>$language,'movietime'=>$movietime,'show1'=>$show11,'a_id'=>$a_id),array('id'=>$id));
        
            if($sql==true){
              echo '<p class="alert alert-danger">Data Successfuly  Updated</p>';

              echo '<script> var i=setTimeout(function(){ window.location.href="entryform.php?id='.$_GET['id'].'"},1000,clearTimeout(i)) </script>';
            }else{
              echo'<p class="alert alert-danger">"Try Again"</p>';
            }
            
            
          }else{
			  
			     $starttime = $_REQUEST['starttime'];
				  //$movietime = $_REQUEST['movietime'];
				  //$show = $_REQUEST['show']+1;
				  $show1 = $_POST['show1']+1;
				 for ($i = 1; $i < $show1 ; $i++) {
 					  
					 //$sql =  mysql_query("INSERT INTO `maintable`(`id`, `theater_name`, `region`, `district`, `seating`, `thcode`, `airdate`, `starttime`, `endtime`, `showtype`, `show`, `showing`, `duration`, `caption`, `user`, `status`,`rono`,`language`,`movietime`) VALUES (null,'".$theatername."','".$region."','".$district."','".$seating."','".$thcode."','".$airdate."','".date("H:i:s",strtotime($starttime))."','".$endtime."','".$_REQUEST['showtype']."','".$i."','".$_REQUEST['showing']."','".$duration."','".$_REQUEST['title']."','".$_SESSION['email']."','1','".$rono."','".$language."','".$movietime."')"); 
					 
					  $showtype=$_POST['showtype'];
                           $showing=$_POST['showing'];
                              $title=$_POST['title'];
                           $email=$_SESSION['email'];
                            $starttimee=date("H:i:s",strtotime($starttime));
                            	$a_id    = $_POST['a_id'];
                            
                            $sql=$prbsl->insert('maintable',array('theater_name'=>$theatername,'region'=>$region,'district'=>$district,'seating'=>$seating,'thcode'=>$thcode,'airdate'=>$airdate,'starttime'=>$starttimee,'endtime'=>$endtime,'showtype'=>$showtype,'showing'=>$showing,'duration'=>$duration,'caption'=>$title,'user'=>$email,'status'=>1,'rono'=>$rono,'language'=>$language,'movietime'=>$movietime,'show1'=>$i,'a_id'=>$a_id));
					$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $endtime);
					sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                    $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
					 $starttime = date("H:i:s",strtotime($movietime)+$time_seconds);//echo'<br>';
					 // $endtime = date("H:i:s",strtotime($starttime)+$duration);//echo'<br>';
				  }
					 					
  			
			if($sql==true){
              echo '<p class="alert alert-danger">Data Successfuly  Added</p>';
            }else{
              echo'<p class="alert alert-danger">"Try Again"</p>';
            }
  				  
          }
        }  
                ?>
                <h1 class="page-header"><?php if(isset($_GET['id'])){ echo "Edit"; }else{ echo "Add"; } ?>  Entry</h1>
                
            </div>
            <!-- /.col-lg-12 -->
        </div>
    <!-- /.row -->
    <section class="content">
    <div class="row">
        <div class="col-md-12">
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php if(isset($_GET['id'])){ echo "Edit"; }else{ echo "Add"; } ?> Entry                 
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                   <!--  <div class="row">
                       <form method="post" enctype="multipart/form-data">
                        <div class="col-md-12" style="">
                          <div class="col-md-2"></div>
                          <div class='col-md-2' >
                          <label>Import File</label>
                          </div>
                          <div class='col-md-4'>
                            <input type="file" name="file" class="form-control" required>
                          </div>
                          <div class="col-md-3">
                            <input type="submit" value="Submit" name="submit" class="btn btn-primary">
                          </div>
                        </div> 
                      </form>
                    </div> -->
                    <div class="row">
                     
                        <form method="post" enctype="multipart/form-data">
                        	
                            <div class="col-lg-10">
                               <div class="form-group">
                                  <label>Ads Name ( Ro No. )</label>
                                  <select class="form-control" name="a_id" required id="a_id">
                                  
                                  <?php 
                                   echo $idd=$entrydata['a_id'];
                                  $sql32 = "select * from `ad` where id=$idd ";
                      $row3 = $prbsl->get_row($sql32);
                      
                          
                  ?>
                   <option value="<?php echo $row3['id'];?>" ><?php echo $row3['clientname']." ".$row3['title']." ( ".$row3['rono']." )";?></option>
                  
                  <?php $sql2 = "select * from `ad` where status='1' order by `id` ASC";
                      $rowss = $prbsl->get_results($sql2);
                      foreach($rowss as $rows){
                          
                  ?>
				  
                  <option value="<?php echo $rows->id;?>" ><?php echo $rows->clientname." ".$rows->title." ( ".$rows->rono." )";?></option>
                    <?php }?>
                  </select>                 
                              </div>
                              <div class="form-group">
                                  <label>Theater Name</label>
                                  <select class="form-control" id="t_id" name="t_id" required>
                                  <option value="">Select Theater Name</option>
								  <?php $sql1 = "select * from `theater` order by `id` DESC";
								        $rowss1 = $prbsl->get_results($sql1);
                      foreach($rowss1 as $row){
								  ?>
								  <option value="<?php echo $row->id;?>" <?php if(isset($row->id) && $row->id==$entrydata['id']){echo'selected';}?><?php if(isset($entrydata['theater_name']) && $entrydata['theater_name']==$row->name){ echo "selected"; } ?>><?php echo $row->company." ".$row->district." ".$row->name." ( ".$row->thcode." )";?></option>
									  <?php }?>
								  </select>
                              </div>
							  <div class="form-group">
                                  <label>Language</label>
                                  <select class="form-control" id="language" name="language" required>
                                  <option value="">Select Language</option>
                						<option value="Hindi" <?php if(isset($_REQUEST['language']) && $_REQUEST['language']=='Hindi'){echo'selected';}?> <?php if($entrydata['language']=='Hindi'){echo'selected';}?>>Hindi</option>
                								  <option value="English" <?php if(isset($_REQUEST['language']) && $_REQUEST['language']=='English'){echo'selected';}?> <?php if($entrydata['language']=='English'){echo'selected';}?>>English</option>
                								  <option value="Punjabi" <?php if(isset($_REQUEST['language']) && $_REQUEST['language']=='Punjabi'){echo'selected';}?> <?php if($entrydata['language']=='Punjabi'){echo'selected';}?>>Punjabi</option>
                								  <option value="Bengali" <?php if(isset($_REQUEST['language']) && $_REQUEST['language']=='Bengali'){echo'selected';}?> <?php if($entrydata['language']=='Bengali'){echo'selected';}?>>Bengali</option>
                								  <option value="Gujrati" <?php if(isset($_REQUEST['language']) && $_REQUEST['language']=='Gujrati'){echo'selected';}?> <?php if($entrydata['language']=='Gujrati'){echo'selected';}?>>Gujrati</option>
                                  <option value="Marathi" <?php if(isset($_REQUEST['language']) && $_REQUEST['language']=='Marathi'){echo'selected';}?> <?php if($entrydata['language']=='Marathi'){echo'selected';}?>>Marathi</option>
                                  <option value="Telgu" <?php if(isset($_REQUEST['language']) && $_REQUEST['language']=='Telgu'){echo'selected';}?> <?php if($entrydata['language']=='Telgu'){echo'selected';}?>>Telgu</option>
                                  <option value="Tamil" <?php if(isset($_REQUEST['language']) && $_REQUEST['language']=='Tamil'){echo'selected';}?> <?php if($entrydata['language']=='Tamil'){echo'selected';}?>>Tamil</option>
                                  <option value="Assamese" <?php if(isset($_REQUEST['language']) && $_REQUEST['language']=='Assamese'){echo'selected';}?> <?php if($entrydata['language']=='Assamese'){echo'selected';}?>>Assamese</option>
                                  <option value="Kannada" <?php if(isset($_REQUEST['language']) && $_REQUEST['language']=='Kannada'){echo'selected';}?> <?php if($entrydata['language']=='Kannada'){echo'selected';}?>>Kannada</option>
                                  <option value="Malyalam" <?php if(isset($_REQUEST['language']) && $_REQUEST['language']=='Malyalam'){echo'selected';}?> <?php if($entrydata['language']=='Malyalam'){echo'selected';}?>>Malyalam</option>
                                  </select>
                              </div>
							 
							                <div class="form-group">
                                  <label>Caption</label>
                                  <input type="text" class="form-control" value=" <?php if(isset($entrydata['caption'])){ echo $entrydata['caption']; } ?>  <?php if(isset($_REQUEST['caption'])){echo $_REQUEST['caption'];}?>" name="title" required>
                              </div>
                              <div class="form-group">
                                  <label>Airdate</label>
                                  <input type="text" class="form-control" id="datepicker" name="airdate" value=" <?php echo $entrydata['airdate'];?>" required>
                              </div>

							               <div class="form-group">
							  
                                  <label>Start Time (15:20:30)<?=date("H:i:s")?></label>
                                  <input type="text" class="form-control"   name="starttime" value=" <?php echo $entrydata['starttime'];?>" placeholder="H:M:S">
                              </div>
							 <!--  <div class="form-group">
                                  <label>End Time</label>
                                  <input type="text"  class="form-control" id="timepicker1" name="endtime" value=" <?php if(isset($entrydata['endtime'])){ echo $entrydata['endtime']; } ?>" placeholder="H:M:S">
                              </div> -->
							  <div class="form-group">
                                  <label>Showtype</label>
                                  <select class="form-control" name="showtype" required>
                                  <option value="">Select Showtype </option>
								  <option value="PST_1"  <?php if(isset($_REQUEST['showtype']) && $_REQUEST['showtype']=='PST_1'){echo'selected';}?>  <?php if(isset($entrydata['showtype']) && $entrydata['showtype']=="PST_1"){ echo "selected"; } ?> >PST_1</option>
								  <option value="PST_2" <?php if(isset($_REQUEST['showtype']) && $_REQUEST['showtype']=='PST_2'){echo'selected';}?> <?php if(isset($entrydata['showtype']) && $entrydata['showtype']=="PST_2"){ echo "selected"; } ?> >PST_2</option>
								  <option value="NPST_1" <?php if(isset($_REQUEST['showtype']) && $_REQUEST['showtype']=='NPST_1'){echo'selected';}?> <?php if(isset($entrydata['showtype']) && $entrydata['showtype']=="NPST_1"){ echo "selected"; } ?> >NPST_1</option>
								  <option value="NPST_2" <?php if(isset($_REQUEST['showtype']) && $_REQUEST['showtype']=='NPST_2'){echo'selected';}?> <?php if(isset($entrydata['showtype']) && $entrydata['showtype']=="NPST_2"){ echo "selected"; } ?> >NPST_2</option>
								  
								  </select>
                              </div>
							  <div class="form-group">
                                  <label>Show (select number of show of the day)</label>
                                  <select class="form-control" name="show1" required>
                                  <option value="">Select Show </option>
								  <option value="1"  <?php if(isset($_REQUEST['show']) && $_REQUEST['show']=='1'){echo'selected';}?> <?php if(isset($entrydata['show1']) && $entrydata['show1']=="1"){ echo "selected"; } ?>>1</option>
								  <option value="2" <?php if(isset($_REQUEST['show']) && $_REQUEST['show']=='2'){echo'selected';}?> <?php if(isset($entrydata['show1']) && $entrydata['show1']=="2"){ echo "selected"; } ?>>2</option>
								  <option value="3" <?php if(isset($_REQUEST['show']) && $_REQUEST['show']=='3'){echo'selected';}?> <?php if(isset($entrydata['show1']) && $entrydata['show1']=="3"){ echo "selected"; } ?>>3</option>
								  <option value="4" <?php if(isset($_REQUEST['show']) && $_REQUEST['show']=='4'){echo'selected';}?> <?php if(isset($entrydata['show1']) && $entrydata['show1']=="4"){ echo "selected"; } ?>>4</option>
								  <option value="5" <?php if(isset($_REQUEST['show']) && $_REQUEST['show']=='5'){echo'selected';}?> <?php if(isset($entrydata['show1']) && $entrydata['show1']=="5"){ echo "selected"; } ?>>5</option>
								  </select>
                              </div>
							  <div class="form-group">
                                  <label>Showing</label>
                                  <select class="form-control" name="showing" required>
                                  <option value="">Select Showing </option>
								  <option value="1" <?php if(isset($_REQUEST['showing']) && $_REQUEST['showing']=='1'){echo'selected';}?> <?php if(isset($entrydata['showing']) && $entrydata['showing']=="1"){ echo "selected"; } ?>>1</option>
								  <option value="2" <?php if(isset($_REQUEST['showing']) && $_REQUEST['showing']=='2'){echo'selected';}?> <?php if(isset($entrydata['showing']) && $entrydata['showing']=="2"){ echo "selected"; } ?>>2</option>
								  <option value="3" <?php if(isset($_REQUEST['showing']) && $_REQUEST['showing']=='3'){echo'selected';}?> <?php if(isset($entrydata['showing']) && $entrydata['showing']=="3"){ echo "selected"; } ?>>3</option>
								  <option value="4" <?php if(isset($_REQUEST['showing']) && $_REQUEST['showing']=='4'){echo'selected';}?> <?php if(isset($entrydata['showing']) && $entrydata['showing']=="4"){ echo "selected"; } ?>>4</option>
								  <option value="5" <?php if(isset($_REQUEST['showing']) && $_REQUEST['showing']=='5'){echo'selected';}?> <?php if(isset($entrydata['showing']) && $entrydata['showing']=="5"){ echo "selected"; } ?>>5</option>
								  </select>
                              </div>
                            <div class="form-group">
							<label>Movie Time (hh:mm:ss)<?=date("H:i:s")?></label>
                                  <input type="text" class="form-control"   name="movietime" value="<?php echo $entrydata['movietime'];?>" placeholder="H:M:S">
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