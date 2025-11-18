<?php include_once("include/header.php");
    
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        if($prbsl->delete('contactdetail',array('id'=>$id))){
            echo "<script>alert('successfully deleted')</script>";
            echo "<script>window.location.href='contact.php';</script>";
        }
    }
    
    
    $result=$prbsl->get_results("SELECT * FROM contactdetail ORDER BY `id` DESC");
    //debug($result);
?>

   
             <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">Contact</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <section class="content-header">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            contact Data 
                         <a class="pull-right" href="contactdetail.php">Add contact</i>
</a>          </div>
                        <!-- /.panel-heading -->
                        <div class="box-body">

            <div class="table-responsive">

        <table class="table table-bordered">
                                 <thead>
                                    <tr >
                                        <th>No</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Company</th>
                                        <th>Phone Number</th>
                                        <th>E-mail</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>   
                                <tbody>
                                <?php
                                    $i=1;
                                    
                                    if(!empty($result)){
                                    foreach ($result as $aboutdata) {?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td><?=$aboutdata->f_name?></td>
                                        <td><?=$aboutdata->l_name?></td>
                                        <td><?=$aboutdata->company_name?></td>
                                        <td><?=$aboutdata->phone_number?></td>
                                        <td><?=$aboutdata->email?></td>
                                        
                                        <td><a href="contact_form.php?id=<?=$aboutdata->id?>" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> |
                                            <a href="contact.php?id=<?=$aboutdata->id?>" class="btn btn-danger"><i class="fa fa-remove" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>

                                <?php  $i++;} 
                                    }else{
                                        ?>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <?php
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr >
                                        <th>No</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Company</th>
                                        <th>Phone Number</th>
                                        <th>E-mail</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>  
                                </table>
                            </div> 
                            <!-- /.table-responsive -->
                            
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

 
<?php include_once("include/footer.php");?>