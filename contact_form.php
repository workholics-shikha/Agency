<?php include_once("include/header.php");

 
?>

<div class="content-wrapper">
    <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">Contact</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
    <!-- /.row -->
     <section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php
            	if(isset($_REQUEST['action']) && $_REQUEST['action']=='update'){
	    	$id=$_GET['id'];
     $f_name = addslashes($_POST['f_name']);
        $l_name = addslashes($_POST['l_name']);
        $company_name = addslashes($_POST['company_name']);
        $address = addslashes($_POST['address']);
        $url = addslashes($_POST['url']);
        $phone_number = addslashes($_POST['phone_number']);
        $cell_number = addslashes($_POST['cell_number']);
         $email = addslashes($_POST['email']);
      $updated = $prbsl->update("contactdetail",array('f_name'=>$f_name,'l_name'=>$l_name,'company_name'=>$company_name,'address'=>$address,'url'=>$url,'phone_number'=>$phone_number,'cell_number'=>$cell_number,'email'=>$email
          ),array('id'=>$id));
          
      if($updated){
			 $msg = 'Updated successfully';
  } 
  else{
    $error=true;
    $msg = 'Some error occured when updating';
  }    
	}
      
    $aboutdata=$prbsl->get_row("SELECT * FROM contactdetail where `id`= '".$_GET['id']."'");      
          
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    
                    
                      <?php
            if(!$error && $msg !=''){
              echo '<div class="alert alert-success">'.$msg.'</div>';
            }
            else if($error && $msg !=''){
              echo '<div class="alert alert-danger">'.$msg.'</div>';
            }
            ?>
                    Contact 

                    <a class="pull-right" href="contact.php">Back contact</i></a>                    
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <form action="" method="post" enctype="multipart/form-data">
                          
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
                                  <label>First Name</label>
                                  <input type="text" class="form-control" value="<?php if(isset($aboutdata['f_name'])){ echo $aboutdata['f_name'];}else if(isset($_POST['f_name'])){ echo $_POST['f_name']; } ?>" name="f_name" required>
                              </div>
                              
                              
                              <div class="form-group">
                                  <label>Last Name</label>
                                  <input type="text" class="form-control" value="<?php if(isset($aboutdata['l_name'])){ echo $aboutdata['l_name'];}else if(isset($_POST['l_name'])){ echo $_POST['l_name']; } ?>" name="l_name" required>
                              </div>

                              <div class="form-group">
                                  <label>Company</label>
                                  <input type="text" class="form-control" value="<?php if(isset($aboutdata['company_name'])){ echo $aboutdata['company_name'];}else if(isset($_POST['company_name'])){ echo $_POST['company_name']; } ?>" name="company_name" required>
                              </div>

                              <div class="form-group">
                                  <label>Address</label>
                                  <input type="text" class="form-control" value="<?php if(isset($aboutdata['address'])){ echo $aboutdata['address'];}else if(isset($_POST['address'])){ echo $_POST['address']; } ?>" name="address" required>
                              </div>

                              <div class="form-group">
                                  <label>Web Site</label>
                                  <input type="text" class="form-control" value="<?php if(isset($aboutdata['url'])){ echo $aboutdata['url'];}else if(isset($_POST['url'])){ echo $_POST['url']; } ?>" name="url" required>
                              </div>

                              <div class="form-group">
                                  <label>Phone Number</label>
                                  <input type="text" class="form-control" value="<?php if(isset($aboutdata['phone_number'])){ echo $aboutdata['phone_number'];}else if(isset($_POST['phone_number'])){ echo $_POST['phone_number']; } ?>" name="phone_number" required>
                              </div>
                              <div class="form-group">
                                  <label>Cell Number</label>
                                  <input type="text" class="form-control" value="<?php if(isset($aboutdata['cell_number'])){ echo $aboutdata['cell_number'];}else if(isset($_POST['cell_number'])){ echo $_POST['cell_number']; } ?>" name="cell_number" required>
                              </div>
                              <div class="form-group">
                                  <label>Email</label>
                                  <input type="text" class="form-control" value="<?php if(isset($aboutdata['email'])){ echo $aboutdata['email'];}else if(isset($_POST['email'])){ echo $_POST['email']; } ?>" name="email" required>
                              </div>
                            </div>
                            
                            <div class="col-lg-12 text-center"> 
                            <hr>
                                <!-- <input type="submit" value="Submit" name="submit" class="btn btn-primary">
 -->
 <input type="hidden" value="update" name="action">
                               <?php
                             if (isset($_GET['id'])){  
                                ?>
 
                            <input type="submit" name="updateForm" class="btn btn btn-primary"  value="update">
                                <?php
                             }
                             else
                              {?>
                              <input type="submit" name="submit" class="btn btn-primary"  value="Save">
                                <?php }
                            ?> 

                                
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

 
<?=include_once("include/footer.php");?>