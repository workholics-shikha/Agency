<?php include_once("include/header.php");?>
<?php

if(isset($_GET['id'])){
        $id = $_GET['id'];
    $array=array('id'=>$id);
    $sql="SELECT * FROM `contactdetail` WHERE id='$id'";
        $aboutdata=$prbsl->get_row($sql);
    }

    $error=false;
    if(isset($_POST['submit']))
    {
        $f_name = addslashes($_POST['f_name']);
        $l_name = addslashes($_POST['l_name']);
        $company_name = addslashes($_POST['company_name']);
        $address = addslashes($_POST['address']);
        $url = addslashes($_POST['url']);
        $phone_number = addslashes($_POST['phone_number']);
        $cell_number = addslashes($_POST['cell_number']);
         $email = addslashes($_POST['email']);
       $inserted = $prbsl->insert("contactdetail",
          array(
            'f_name'=>$f_name,
            'l_name'=>$l_name,
            'company_name'=>$company_name,
            'address'=>$address,
            'url'=>$url,
            'phone_number'=>$phone_number,
            'cell_number'=>$cell_number,
            'email'=>$email
          )
        ); 
    if($inserted){
            echo "<script>alert('successfully ')</script>";
            echo "<script>window.location.href='contact.php';</script>";
        }
  }
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
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php if(isset($_GET['id'])){
                            echo "Edit";
                        }else{
                            echo "Add";
                        }
                    ?>
                    Contact 

                    <a class="pull-right" href="contact.php">Back Contact</i></a>                    
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
                                  <label>First Name</label>
                                  <input type="text" class="form-control" name="f_name" required>
                              </div>
                              <div class="form-group">
                                  <label>Last Name</label>
                                  <input type="text" class="form-control" name="l_name" required>
                              </div>
                              <div class="form-group">
                                  <label>Company</label>
                                  <input type="text" class="form-control" name="company_name" required>
                              </div>
                              <div class="form-group">
                                  <label>Address</label>
                                  <input type="text" class="form-control" name="address" required>
                              </div>
                              
                              <div class="form-group">
                                  <label>Web Site</label>
                                  <input type="text" class="form-control" name="url" required>
                              </div>
                              <div class="form-group">
                                  <label>Phone Number</label>
                                  <input type="text" class="form-control" name="phone_number" required>
                              </div>
                              <div class="form-group">
                                  <label>Cell Number</label>
                                  <input type="text" class="form-control"  name="cell_number">
                              </div>
                              <div class="form-group">
                                  <label>Email</label>
                                  <input type="text" class="form-control" name="email" required>
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
    </section>
    <!-- /.row -->
 
</div>
        <!-- /#page-wrapper -->

 
<?=include_once("include/footer.php");?>