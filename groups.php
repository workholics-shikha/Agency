<?php include_once("include/header.php");

if(isset($_GET['grp']) && $_GET['grp']!=''){
	require_once "single_grp.php";
}
else{
    
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        if($prbsl->delete('c_groups',array('id'=>$id))){
            echo "<script>alert('successfully deleted')</script>";
            echo "<script>window.location.href='groups.php';</script>";
        }
    }   
	?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="content-header">
            <h1 class="page-header">Groups</h1>
            </section>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    
    <section class="content">
    <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default">
                        <div class="panel-heading">
                            Group Data 
                            
                                </div>   
    <div class="box-body">

            <div class="table-responsive">

        <table class="table table-bordered">
    			<thead>
    				<tr>
    					<th>Group Name</th>
    					<th>Added On</th>
    					<th>Total Contacts</th>
    						<th>Action</th>
    				</tr>
    			</thead>
    			<tbody>
    				<?php
    				$getGroups = $prbsl->get_results("SELECT * FROM c_groups ORDER BY g_name");
    				if(!empty($getGroups)){
    					foreach($getGroups as $grp){
    					    
    					    $gslug=$grp->g_name;
    					$data = $prbsl->get_row("SELECT * FROM c_groups WHERE g_slug='$gslug'");
$gid = $data['id'];
$gflds = unserialize($data['g_fields']);
$splitField = count($gflds);
    					?>
    					    <tr>
<td><?php echo $grp->g_name;?></td>
<td><?php echo $grp->added_date;?></td>
<td><?php echo $splitField;?></td>
<td><!--<a href="entryform.php?id=<?=$aboutdata->id?>" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> --><a href="?id=<?=$grp->id;?>" class="btn btn-danger"><i class="fa fa-remove" aria-hidden="true"></i> </a>
                                        </td> 
    </tr>					
    					    
    				<?php	}
    				}
    				else{
    					echo '<tr>
    						<td colspan="3">No Groups Found</td>
    					</tr>';
    				}
    				?>
    			</tbody>
    			
    		</table>
    	</div>
    </div>
    </div>
    </div>
     </div>
    </section>
</div>
<?php
}
 include_once("include/footer.php");?>