<?php include_once("include/header.php");?>
<?php include_once("include/confige.php");?>
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
<?php include_once("include/side_menu.php");?>   
<div id="page-wrapper">
    <div class="row">
            <div class="col-lg-12">
                <?php
				if(isset($_REQUEST['action']) && $_REQUEST['action']=='log'){
					$periodfrom = date("Y-m-d", strtotime($_REQUEST['periodfrom']));
					$periodto = date("Y-m-d", strtotime($_REQUEST['periodto']));
					$date = date("Y-m-d", strtotime($_REQUEST['date']));
					$sql = mysql_query("INSERT INTO `ad`(`id`, `clientname`, `family`, `rono`, `title`, `periodfrom`, `periodto`, `invoiceno`, `date`, `agencyname`, `duration`,`langauge`,`spot`, `status`) VALUES (null,'".$_REQUEST['clientname']."','".$_REQUEST['family']."','".$_REQUEST['rono']."','".$_REQUEST['title']."','".$periodfrom."','".$periodto."','".$_REQUEST['invoiceno']."','".$date."','".$_REQUEST['agencyname']."','".$_REQUEST['duration']."','".$_REQUEST['langauge']."','".$_REQUEST['spot']."','".$_REQUEST['status']."')");
					if($sql==true){
	                echo '<p class="alert alert-danger">"Theater Added"</p>';
                    }else{echo'<p class="alert alert-danger">"Try Again"</p>';}
				   }
                ?>
                <h1 class="page-header">Add ABC</h1>
                
            </div>
            <!-- /.col-lg-12 -->
        </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <?php 
              if(!checkPermission('manage_users')){
                _die('You cannot access this page','Permission Denied');
              }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add ABC                 
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <form method="post" enctype="multipart/form-data">
                        	
                            <div class="col-lg-10">
                              <div class="form-group">
                                  <label>Client Name</label>
                                  <input type="text" class="form-control" placeholder="" name="clientname" required>
                              </div>
							  <div class="form-group">
                                  <label>Family Planning</label>
                                  <input type="text" class="form-control" placeholder="" name="family" required>
                              </div>
							  
                              <div class="form-group">
                                  <label>RO No</label>
                                  <input type="text" class="form-control" name="rono" required>
                              </div>
							  <div class="form-group">
                                  <label>Title</label>
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
                                  <input type="text" class="form-control" name="spot" required>
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
                               <input type="hidden" value="log" name="action">
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
   });
 </script>
<?php include_once("include/footer.php");?>