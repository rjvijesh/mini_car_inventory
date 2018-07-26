<?php 
require_once 'database.php';
$dbgetdetails1 = new Database();
$dbgetdetails2 = new Database();
$allMasterModelDetails = $dbgetdetails1->getModelDetails();
//to get count of same model same manufaturer
$countAvailableModelManufacturer = $finalCount = $ignoreIds = array();
foreach($allMasterModelDetails as $key => $value){
	$countAvailableModelManufacturer[$value['name']][$value['manufacturer_id']][] = $value['id'];
}
foreach($countAvailableModelManufacturer as $items => $itemsVal){
	foreach($itemsVal as $items1 => $itemsVal1){
		if(count($itemsVal1) > 1){
			$ignoreIds[]= $itemsVal1[1];
		}
		$finalCount[$items][$items1] = count($itemsVal1);
	}
}
$allMasterManufacturerDetails = $dbgetdetails2->getAllManufactureDetails();
?>
<html>
<?php require_once('header.php');?>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.6/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">


<body>
<div class="MT20">
<table id="modelDetails" class="table table-striped table-bordered" style="width:100%">
	<thead>
		<tr>
			<th>Serial No.</th>
			<th>Manufacturer Name</th>
			<th>Model Name</th>
			<th>Count</th>
			<th style="display:none">Color</th>
			<th style="display:none">Year</th>
			<th style="display:none">Image</th>
			<th style="display:none">Model ID</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		if(isset($allMasterModelDetails) && !empty($allMasterModelDetails)){
			$i=1;
			foreach($allMasterModelDetails as $key => $value){
				if(!in_array($value['id'], $ignoreIds)){
		?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $value['name']; ?></td>
			<td><?php echo (isset($allMasterManufacturerDetails[$value['manufacturer_id']]) && !empty($allMasterManufacturerDetails[$value['manufacturer_id']])) ? $allMasterManufacturerDetails[$value['manufacturer_id']] : ''; ?></td>
			<td><?php echo $finalCount[$value['name']][$value['manufacturer_id']]; ?></td>
			<td style="display:none"><?php echo $value['color_code']; ?></td>
			<td style="display:none"><?php echo $value['year']; ?></td>
			<td style="display:none"><?php echo $value['files'];?></td>
			<td style="display:none"><?php echo $value['id'];?></td>
		</tr>
		<?php	
				}
			$i++;
			}
		}
		?>
		
	</tbody>
</table>
</div>
<script>
$(document).ready(function() {
    $('#modelDetails').DataTable();
	var modelTable=  $('#modelDetails').DataTable();   
    $('#modelDetails').on('click', 'tr', function () {
		$("#model_manufacturer_name").val(modelTable.row(this).data()[1]);
		$("#model_name").val(modelTable.row(this).data()[2]);
		$("#model_color").val(modelTable.row(this).data()[4]);
		$("#model_manufacturer_year").val(modelTable.row(this).data()[5]);
		$("#imgNames").html('');
		if(modelTable.row(this).data()[6] != ''){
			var images = JSON.parse(modelTable.row(this).data()[6]);
		}else{
			var images =['default_image.jpg'];
		}
		$.each(images, function(i, val) {
			$("<img />").attr("src", "upload/"+val).attr("width", "120px").attr("height", "120px").addClass('MR10').appendTo("#imgNames");
		});	
		$("#model_id_sold").attr('model_id', modelTable.row(this).data()[7]);
		$('#DescModal').modal("show");
	});
	$('#header li a').removeClass('active');
	$('.view_inventory').addClass('active');
});


$('body').on('click', '#model_id_sold', function(){
		var model_id = $('#model_id_sold').attr('model_id');
		if(model_id == ''){
			alert("Model id not found");
			return false;
		}else{
			$.ajax( {
				url: siteUrl+'car_inventory/model.php?action=updatestatus',
				data: 'id='+model_id+'&flag=delete',
				dataType: 'json',
				type: 'post',
				success: function( resp ){
					if(resp.flag == 1){
						alert(resp.message);
						window.location.reload();
					}else{
						alert(resp.message);
						return false;
					}
				},
				error: function(){
					alert();
				},
			});	
		}
		return false;
	});

</script>



<div class="modal fade" id="DescModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                 <h3 class="modal-title">Model Details</h3>
			</div>
            <div class="modal-body">
            
				<div class="row dataTable MT10">
					<div class="col-md-4">
						<label class="control-label">Model Name</label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" maxlength="50" id="model_name" name="modelName">
					</div>
				</div>
				
				<div class="row dataTable MT10">
					<div class="col-md-4">
						<label class="control-label">Manufacturer Name</label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" maxlength="30" id="model_manufacturer_name" name="modelManufacturerName">
					</div>
				</div>
				
				<div class="row dataTable MT10">
					<div class="col-md-4">
						<label class="control-label">Model Color</label>
					</div>
					<div class="col-md-8">
						<input type="color" class="form-control" id="model_color" name="modelColor">
					</div>
				</div>
				
				<div class="row dataTable MT10">
					<div class="col-md-4">
						<label class="control-label">Manufacturer year</label>
					</div>
					<div class="col-md-8">
						<input type="text" class="form-control" maxlength="30" id="model_manufacturer_year" name="modelManufacturerYear">
					</div>
				</div>
				
				<div class="row dataTable MT20" >
					<div class="col-md-4">
						<label class="control-label">Model Image</label>
					</div>
					<div class="col-md-8" id="imgNames">
						
					</div>
				</div>
				<div class="row dataTable MT20" >
					<div class="col-md-4">
						<a class="control-label" id="model_id_sold" model_id="">SOLD</a>
					</div>
				</div>
				
                <br>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</body>
</html>
