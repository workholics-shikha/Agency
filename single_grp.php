<?php
global $vgdb;
$gslug = $vgdb->esc_string($_GET['grp']);
$smsg = '';
$emsg = '';
if(isset($_GET['action']) && $_GET['action']=='delete'){
	$acId = $_GET['contact'];
	$delete = $vgdb->delete('contactdetail',array('id'=>$acId));
	if($delete){
		$vgdb->delete('group_relation',array('u_id'=>$acId));
		$smsg = 'Contacts deleted';
	}
	else if($delete == 0){

	}
	else{
		$emsg = 'Some error occured';
	}
}
if(isset($_POST['actionCon'])){
	$uIds = $_POST['chk'];
	if(!empty($uIds)){
		foreach($uIds as $u_id){
			$delete = $vgdb->delete('contactdetail',array('id'=>$u_id));
			if($delete){
				$vgdb->delete('group_relation',array('u_id'=>$u_id));
				$smsg = 'Contacts deleted';
			}
			else if($delete == 0){
			}
			else{
				$emsg = 'Some error occured';
			}
		}
	}
}
$query = "";
$grpBy = '';


$data = $vgdb->get_row("SELECT * FROM c_groups WHERE g_slug='$gslug'");
$gid = $data['id'];
$gflds = unserialize($data['g_fields']);
$splitField = splitField($gflds);
$labels = splitLabel($gflds);
?>
<div id="page-wrapper">
    <div class="row">
    	<?php
    	if($smsg !=''){
    		echo '<p class="alert alert-success">'.$smsg.'</p>';
    	}
    	else if($emsg !=''){
    		echo '<p class="alert alert-danger">'.$emsg.'</p>';
    	}
    
    	?>
        <div class="col-lg-12">
        
            <h1 class="page-header" style="font-size: 24px;padding-bottom: 18px;"><span class="<?=$editClass?>"><?=$data['g_name']?></span>
            
            
	            	<input type="text" class="gName" value="<?=$data['g_name']?>" style="display:none">
	            	
		        <div class="pull-right" style="margin-left: 15px;margin-top: 0px;">
		            
		            	<small>
		            		<a href="#" class="pull-right btn btn-primary adCn"><i class="fa fa-plus"></i> Add Contact</a>
		            	</small>
		            
	            </div>
	            <div class="pull-right">
	            	<form method="post" class="form-inline text-right">
		    			<div class="input-group">
					      <input type="text" class="form-control" name="sc" placeholder="Search for...">
					      <span class="input-group-btn">
					        <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
					      </span>
					    </div><!-- /input-group -->
		    		</form>
	            </div>
            </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
    	<div class="form-actions col-sm-12 col-xs-12">
    		<div class="row">
		    	<div class="pull-left col-sm-6 col-xs-12">
		    	<?php
		    	/*if(checkPermission('manag_contact')){
		    			?>
		    			
						<form class="form-inline" method="post" onsubmit="return confirm('Are you sure you want to delete these contacts');">
							<div class="form-group">
								<select name="action" class="form-control">
									<option value="del">Delete</option>
								</select>
								<input type="submit" name="actionCon" value="Submit" class="btn btn-default">
							</div>
						</form>
				    	<?php
		    	 }*/?>
		    	</div>
		    	<div class="pull-right col-sm-6 col-xs-12">
		    		
		    	</div>
	    	</div>
	    	<div class="clearfix"></div>
    		<!-- <hr /> -->
    	</div>
    	<div class="clearfix"></div>
    	<div class="table-response col-sm-12 col-xs-12">
    		<table class="table table-striped table-bordered ">
    			<thead>
    				<tr>
    				<?php
    					if(in_array('ppc',$splitField)){
    						echo '<th><i class="fa fa-user"></i></th>';
    					}
    					if(in_array('f_name',$splitField) || in_array('l_name',$splitField)){
    						echo '<th>'.$labels['f_name'].' '.$labels['l_name'].'</th>';
    					}
    					if(in_array('email',$splitField)){
    						echo '<th>'.$labels['email'].'</th>';
    					}
    					if(in_array('dob',$splitField)){
    						echo '<th>'.$labels['dob'].'</th>';
    					}
    					if(in_array('company_name',$splitField)){
    						echo '<th>'.$labels['company_name'].'</th>';
    					}
    					if(in_array('address',$splitField)){
    						echo '<th>'.$labels['address'].'</th>';
    					}
    					if(in_array('phone_number',$splitField)){
    						echo '<th>'.$labels['phone_number'].'</th>';
    					}
    					if(in_array('cell_number',$splitField)){
    						echo '<th>'.$labels['cell_number'].'</th>';
    					}
    					if(in_array('url',$splitField)){
    						echo '<th>'.$labels['url'].'</th>';
    					}
    					if(in_array('note',$splitField)){
    						echo '<th>'.$labels['note'].'</th>';
    					}
    					if(checkPermission('manage_contact')){
    						echo '<th>Action</th>';
    					}
    				?>
    				</tr>
    			</thead>
    			<tbody>
    				<?php
    				$inner = "";
    				$query = '';
    				$like = "";
    				if(isset($_POST['sc']) && $_POST['sc'] !=''){
						$sc = $_POST['sc'];
						$like .= " CD.company_name LIKE '%$sc%' OR ";
						$like .= " CD.address LIKE '%$sc%' OR ";
						$like .= " CD.phone_number LIKE '%$sc%' OR ";
						$like .= " CD.cell_number LIKE '%$sc%' OR ";
						$like .= " CD.email LIKE '%$sc%' OR ";
						$like .= " CD.dob LIKE '%$sc%' OR ";
						$like .= " CD.status LIKE '%$sc%' OR ";
						$like .= " CD.f_name LIKE '%$sc%' OR ";
						$like .= " CD.l_name LIKE '%$sc%' OR ";
						$like .= " CD.note LIKE '%$sc%' AND ";
						$grpBy .= " GROUP BY CD.id";
					}
					$inner .= " INNER JOIN contactdetail AS CD ON CD.id=GR.u_id";
					$query = "SELECT * FROM group_relation AS GR $inner WHERE ";
					$query .= " $like ";
					$query .=" GR.g_id=$gid";
					$query .= " {$grpBy}";
    				$getContacts = $vgdb->get_results($query);
    				$totalColoumns = count($splitField);
    				if(!empty($getContacts)){
    					foreach($getContacts as $contact){
    						$uId = $contact->u_id;
    						//$getUser = $vgdb->get_row("SELECT * FROM contactdetail WHERE id=$uId");
    						$profile_pic = $vgdb->get_var("SELECT meta_value FROM contact_meta WHERE u_id=$uId AND meta_key='profile_pic'");
    						$addString = 'class="_snglCnt" cnt="'.$contact->id.'"';
    						if(checkPermission('manage_contact')){
    							$addString .= ' title="Edit"';
    						}
    						else{
    							$addString .= ' title="View"';
    						}
    						echo '<tr >';
    							/*if(checkPermission('manag_contact') || is_admin()){
    								echo '<input type="checkbox" name="chk[]" value=""'.$uId.'/>';
    							}*/
    							if(in_array('ppc',$splitField)){
    								echo '<td><a rel="profile_pic" class="fancybox" href="'.$profile_pic.'"><img src="'.$profile_pic.'" class="img-circle" width="30px" height="30px"/></a></td>';
    							}
    							if(in_array('f_name',$splitField) || in_array('l_name',$splitField)){
    								echo '<td '.$addString.' style="word-wrap: break-word;word-break: break-all;">'.$contact->f_name.' '.$contact->l_name.'</td>';
    							}
    							if(in_array('email',$splitField)){
    								echo '<td '.$addString.' style="word-wrap: break-word;word-break: break-all;">'.$contact->email.'</td>';
    							}
    							if(in_array('dob',$splitField)){
    								echo '<td '.$addString.'>'.$contact->dob.'</td>';
    							}
    							if(in_array('company_name',$splitField)){
    								echo '<td '.$addString.' style="word-wrap: break-word;word-break: break-all;">'.$contact->company_name.'</td>';
    							}
    							if(in_array('address',$splitField)){
    								echo '<td '.$addString.' style="word-wrap: break-word;word-break: break-all;">'.$contact->address.'</td>';
    							}
    							if(in_array('phone_number',$splitField)){
    								echo '<td '.$addString.'>'.$contact->phone_number.'</td>';
    							}
    							if(in_array('cell_number',$splitField)){
    								echo '<td '.$addString.'>'.$contact->cell_number.'</td>';
    							}
    							if(in_array('url',$splitField)){
    								echo '<td style="white-space: nowrap;text-overflow: ellipsis;max-width: 150px;overflow: hidden;"><a href="'.$contact->url.'" target="_blank">'.$contact->url.'</a></td>';
    							}
    							if(in_array('note',$splitField)){
    								echo '<td '.$addString.' style="word-wrap: break-word;word-break: break-all;">'.$contact->note.'</td>';
    							}
    							if(checkPermission('manag_contact') || is_admin() ){
    								/*<a href="'.admin_url().'/groups.php?grp='.$_GET['grp'].'&action=view&contact='.$uId.'" class="">
	    									<i class="fa fa-eye"></i>
	    								</a> | */
	    							//if(!checkPermission('view_folders') || is_admin()){
		    							echo '<td style="word-wrap: break-word;word-break: break-all;">	    								
		    								<a href="'.admin_url().'/groups.php?grp='.$_GET['grp'].'&action=delete&contact='.$uId.'" onclick="return confirm(\'Are you sure you want to delete these contacts\');" class="">
		    									<i class="fa fa-trash"></i>
		    								</a>
		    							</td>';
	    							//}
    							}
    						echo '</tr>
    						';
    					}
    				}
    				else{
    					if(in_array('l_name',$splitField)){
    						$totalColoumns = $totalColoumns-1;
    					}
    					echo '<tr><td colspan="'.$totalColoumns.'">There are no contacts in this group.</td></tr>';
    				}
    				?>
    			</tbody>
    		</table>
    	</div>
    </div>
</div>
<div class="__pp addConPP">
    <div class="__ppd">
        <form method="post" enctype="multipart/form-data">
	        <div class="__ppC">
	            <div class="__ppH">
	                <button type="button" class="_ppcl">&times;</button>
	                <h2>Add Contact</h2>
	            </div> 
	            <div class="__ppB">
	                <p class="alert hidden ajaxmsg"></p>
	                <?php
	                
	                if(in_array('ppc',$splitField)){
	                	?>
						<div class="form-group">
						  <label><?=$labels['ppc']?></label>
						  <input type="file" name="pro_pic" id="pro_pic"/>
						</div>
	                	<?php
	                }
	                if(in_array('f_name',$splitField)){
	                	?>
		                <div class="form-group">
						  <label><?=$labels['f_name']?></label>
						  <input type="text" class="form-control required-field" name="f_name" required>
						</div>
	                	<?php
	                }
	                if(in_array('l_name',$splitField)){
	                	?>
		                <div class="form-group">
						  <label><?=$labels['l_name']?></label>
						  <input type="text" class="form-control required-field" name="l_name" required>
						</div>
	                	<?php
	                }
	                if(in_array('company_name',$splitField)){
	                	?>
		                <div class="form-group">
						  <label><?=$labels['company_name']?></label>
						  <input type="text" class="form-control required-field" name="company_name" required>
						</div>
	                	<?php
	                }
	                if(in_array('address',$splitField)){
	                	?>
		                <div class="form-group">
						  <label><?=$labels['address']?></label>
						  <input type="text" class="form-control required-field" name="address" required>
						</div>
	                	<?php
	                }
	                if(in_array('url',$splitField)){
	                	?>
		                <div class="form-group">
						  <label><?=$labels['url']?></label>
						  <input type="text" class="form-control required-field" name="url" required>
						</div>
	                	<?php
	                }
	                if(in_array('phone_number',$splitField)){
	                	?>
		                <div class="form-group">
						  <label><?=$labels['phone_number']?></label>
						  <input type="text" class="form-control required-field" name="phone_number" required>
						</div>
	                	<?php
	                }
	                if(in_array('cell_number',$splitField)){
	                	?>
		                <div class="form-group">
						  <label><?=$labels['cell_number']?></label>
						  <input type="text" class="form-control required-field" name="cell_number" required>
						</div>
	                	<?php
	                }
	                if(in_array('email',$splitField)){
	                	?>
		               	<div class="form-group">
						  <label><?=$labels['email']?></label>
						  <input type="text" class="form-control required-field" name="email" required>
						</div>
	                	<?php
	                }
	                if(in_array('dob',$splitField)){
	                	?>
		               	<div class="form-group">
						  <label><?=$labels['dob']?></label>
						  <input type="text" class="form-control required-field" id="dob-add" name="dob" required>
						</div>
	                	<?php
	                }
	                if(in_array('note',$splitField)){
	                	?>
		               	<div class="form-group">
						  <label><?=$labels['note']?></label>
						  <input type="text" class="form-control required-field" name="note" required>
						</div>
	                	<?php
	                }
	                ?>
	            </div>
	        </div>
	        <div class="__ppf">
	            <input type="hidden" name="action" value="adCon">
	            <input type="hidden" name="grp" value="<?=$_GET['grp']?>">
	            <button type="submit" class="btn btn-primary submitForm">
	                <span>Add Contact</span>
	            </button>
	        </div>
        </form>
    </div>
</div>
<div class="__pp editCnt">
	<div class="__ppd">
        <form method="post" enctype="multipart/form-data">
	        <div class="__ppC">
	        	<div class="__ppH">
	                <button type="button" class="_ppcl">&times;</button>
	                <?php
	                if(!checkPermission('manage_contact')){
	                	echo '<h2>Contact</h2>';
	                }
	                else{
	                	echo '<h2>Edit Contact</h2>';
	                }
	                ?>
	            </div> 
	            <div class="__ppB">
	                <p class="alert hidden ajaxmsg"></p>
	                <?php
	                
	                if(in_array('ppc',$splitField)){
	                	?>
						<div class="form-group">
							<div class="text-center">
								<img src="" name="pro_pic" width="60px" height="60px" class="img-circle" />
							</div>
							<?php if(checkPermission('manage_contact')){ ?>
						  	<label><?=$labels['ppc']?></label>
						  	<input type="file" name="pro_pic" id="pro_pic"/>
						  	<?php }?>
						</div>
	                	<?php
	                }
	                if(in_array('f_name',$splitField)){
	                	?>
		                <div class="form-group">
						  <label><?=$labels['f_name']?></label>
						  <input type="text" class="form-control required-field" name="f_name" required>
						</div>
	                	<?php
	                }
	                if(in_array('l_name',$splitField)){
	                	?>
		                <div class="form-group">
						  <label><?=$labels['l_name']?></label>
						  <input type="text" class="form-control required-field" name="l_name" required>
						</div>
	                	<?php
	                }
	                if(in_array('company_name',$splitField)){
	                	?>
		                <div class="form-group">
						  <label><?=$labels['company_name']?></label>
						  <input type="text" class="form-control required-field" name="company_name" required>
						</div>
	                	<?php
	                }
	                if(in_array('address',$splitField)){
	                	?>
		                <div class="form-group">
						  <label><?=$labels['address']?></label>
						  <input type="text" class="form-control required-field" name="address" required>
						</div>
	                	<?php
	                }
	                if(in_array('url',$splitField)){
	                	?>
		                <div class="form-group">
						  <label><?=$labels['url']?></label>
						  <input type="text" class="form-control required-field" name="url" required>
						</div>
	                	<?php
	                }
	                if(in_array('phone_number',$splitField)){
	                	?>
		                <div class="form-group">
						  <label><?=$labels['phone_number']?></label>
						  <input type="text" class="form-control required-field" name="phone_number" required>
						</div>
	                	<?php
	                }
	                if(in_array('cell_number',$splitField)){
	                	?>
		                <div class="form-group">
						  <label><?=$labels['cell_number']?></label>
						  <input type="text" class="form-control required-field" name="cell_number" required>
						</div>
	                	<?php
	                }
	                if(in_array('email',$splitField)){
	                	?>
		               	<div class="form-group">
						  <label><?=$labels['email']?></label>
						  <input type="text" class="form-control required-field" name="email" required>
						</div>
	                	<?php
	                }
	                if(in_array('dob',$splitField)){
	                	?>
		               	<div class="form-group">
						  <label><?=$labels['dob']?></label>
						  <input type="text" class="form-control required-field" id="dob-edit" name="dob" required>
						</div>
	                	<?php
	                }
	                if(in_array('note',$splitField)){
	                	?>
		               	<div class="form-group">
						  <label><?=$labels['note']?></label>
						  <input type="text" class="form-control required-field" name="note" required>
						</div>
	                	<?php
	                }
	                ?>
	            </div>
	        </div>
	        <?php
	            if(checkPermission('manage_contact')){
	            	?>
	        <div class="__ppf">
	            <input type="hidden" name="action" value="editCnt">
	            <input type="hidden" name="cnt" value="">
	            
	            	<button type="submit" class="btn btn-primary editForm">
	                	<span>Edit Contact</span>
	            		</button>'
	           
        	</div><?php
        	 }
	            ?>
	    </form>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		var oldVal = '';
		$('.updateGn').on('click',function(e){
			e.preventDefault();
			$(this).hide();
			$('.gName').show();
			oldVal = $(this).text();
			$('.gName').focus();
		});
		$('.gName').on('blur',function(){
			var current = $(this);
			if(current.val() !=''){
				$.ajax({
					type:'POST',
					url:paths.ajax_path,
					data:{action:'updatgName',gslug:"<?=$_GET['grp']?>",gname:current.val()},
					success:function(response){
						$('.updateGn').text(current.val());
						current.hide();
						$('.updateGn').show();
					}
				});				
			}
			else{
				$('.updateGn').text(oldVal);
				current.hide();
				$('.updateGn').show();
			}			
		});
		$('.gName').on('keyup',function(e){
			if(e.which==13 && e.keyCode==13){
				var current = $(this);
				if(current.val() !=''){
					$.ajax({
						type:'POST',
						url:paths.ajax_path,
						data:{action:'updatgName',gslug:"<?=$_GET['grp']?>",gname:current.val()},
						success:function(response){
							$('.updateGn').text(current.val());
							current.hide();
							$('.updateGn').show();
						}
					});				
				}
				else{
					$('.updateGn').text(oldVal);
					current.hide();
					$('.updateGn').show();
				}	
			}
		});
		$('#dob-add').datepicker({format: 'dd/mm/yyyy',autoclose: true});
		$('#dob-edit').datepicker({format: 'dd/mm/yyyy',autoclose: true});
	});
</script>
<style type="text/css">.gName{display:none}._snglCnt{cursor:pointer;}</style>