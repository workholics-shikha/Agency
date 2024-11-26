<footer class="main-footer">
  <!--<div class="pull-right hidden-xs"> <b>Desiredsoft Pvt.Ltd</b> 2.3.3 </div>-->
  <strong>Copyright &copy; 2019 <a href="<?= site_url() ?>">Agency</a>.</strong> All Rights Reserved</footer>
</div>
<!-- ./wrapper --> 
<!-- <script src="<?=admin_url()?>js/jquery.min.js"></script>   -->
<script src="<?=admin_url()?>js/jquery.validate.min.js"></script>
<script src="<?=admin_url()?>js/custom.js"></script>
<script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
 <!-- <script src="<?=admin_url()?>js/bootstrap.min.js"></script>   -->
 
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
 
<script src="<?=admin_url()?>js/app.min.js"></script> 
<style>
	.error {
    padding: 15px;
    border: 1px solid transparent;
    border-radius: 4px;
    width: 100%;
    font-size: 13px;
    text-transform: none;
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
    margin-bottom: 0;
}
</style>
<script>
$(document).ready(function(){
	$(".UnSubscribe").click(function(){
		var status = $(this).attr('status');
            var id = $(this).attr('id');
		$.ajax({
                url: "subscribes_status.php", 
                type: "POST",
                data: {action:"NewsUnSubscribe",status:status,id:id},
				success:function(res){
					 location.reload();
					
					}
            });
		});
});
</script>
<script>
// In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.select2_row_no').select2();

    $( ".datepicker" ).datepicker();
});
</script>
<div class="control-sidebar-bg"></div>
</body>
</html>