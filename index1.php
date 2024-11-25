<?php include_once("include/header.php");?>
<?php
    global $vgdb;
?>
<?php include_once("include/side_menu.php");?>
   
            <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
           <!--  <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            <?php
                            /*$getcontacts = $vgdb->get_results("SELECT * FROM contactdetail ORDER BY f_name ASC");
                            if(!empty($getcontacts)){
                                foreach($getcontacts as $contact){
                                    $proPic = $vgdb->get_var("SELECT meta_value FROM contact_meta WHERE u_id=$contact->id AND meta_key='profile_pic'");
                                    echo '
                                    <tr>
                                        <td>
                                        <img src="'.$proPic.'" class="img-circle" width="60px" height="60px"/>
                                        </td>
                                        <td>'.$contact->f_name.' '.$contact->l_name.'</td>
                                        <td>'.$contact->email.'</td>
                                        <td>'.$contact->cell_number.'</td>
                                    </tr>
                                    ';
                                }
                            }
                            else{
                                echo '<tr>
                                        <td colspan="4"></td>
                                    </tr>';
                            }*/
                            ?>
                            
                        </tbody>
                    </table>
                </div>
            </div> -->
            <!-- /.row -->
         
        </div>
        <!-- /#page-wrapper -->

 
<?=include_once("include/footer.php");?>