<?php 
require_once 'database.php';
session_start();
if(isset($_SESSION["attachment_files"])){
	unset($_SESSION["attachment_files"]);
}
$dbgetmanudetails = new Database();
$allMasterManufacturerDetails = $dbgetmanudetails->getAllManufactureDetails();
?>
<html>
<?php require_once('header.php');?>
<script src="js/dropzone.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/dropzone.css">

<body>
	<div class="MT20 ML20">
		<form action="/" method="post" name="model" id="model">
			<div class="FL MR10">
				<label> Name</label>
				<input type="textbox" name="model[name]" id="model_name" />
			</div>
			<div class="FL">
				<label> Manufacturer</label>
				<select id="model_manufacturer_id" name="model[manufacturer_id]">                      
					<option selected="selected">Select</option>
					<?php
					foreach($allMasterManufacturerDetails as $key => $value){
					?>
					<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
					<?php
					}
					?>
				</select>
			</div>
			<div class="CL"></div>
			<div class="MT10">
				<label> color</label>
				<input type="color" name="model[color]" id="model_color"  value="#ff0000"/>
				 
			</div>
			<div class="MT10">
				<label> Manufacturing Year</label>
				<input type="textbox" name="model[year]" id="model_year" pattern="^\d{4}$" required />
			</div>
			<h4> Add Image</h4>
			<?php 
				echo '<div class="dropzone" name="model[image]" id="model_car_image" style="width:88%; min-height: 200px;min-height: 200px;margin-left: 43px;margin-top: 10px;margin-bottom: 25px;border: 2px solid rgba(212, 194, 194, 0.3);"></div>';
			?>
			
			<br><br>
			<input type="submit" value="Submit">
		</form>
	</div>

	
	<script>
	
	$( '#model' ).submit( function(){
		var data = $('#model').serialize();
		var model_name = $('#model_name').val();
		var model_year = $('#model_year').val();
		var model_manufacturer_id = $('#model_manufacturer_id').val();
		if(model_name == ''){
			alert("Model name cannot be blank");
			return false;
		}else if(model_year == ''){
			alert("Model year cannot be blank");
			return false;
		}else if(model_manufacturer_id == 'Select'){
			alert("kindly select model manufacturer");
			return false;
		}else{
			$.ajax( {
				url: siteUrl+'car_inventory/model.php?action=add',
				data: data,
				dataType: 'json',
				type: 'post',
				success: function( resp ){
					if(resp.flag == 1){
						alert(resp.message);
						window.location.href = siteUrl+"car_inventory/view_inventory.php";
					}else{
						alert(resp.message);
						return false;
					}
				},
				error: function (jqXHR, exception) {
					var msg = '';
					if (jqXHR.status === 0) {
						msg = 'Not connect.\n Verify Network.';
					} else if (jqXHR.status == 404) {
						msg = 'Requested page not found. [404]';
					} else if (jqXHR.status == 500) {
						msg = 'Internal Server Error [500].';
					} else if (exception === 'parsererror') {
						msg = 'Requested JSON parse failed.';
					} else if (exception === 'timeout') {
						msg = 'Time out error.';
					} else if (exception === 'abort') {
						msg = 'Ajax request aborted.';
					} else {
						msg = 'Uncaught Error.\n' + jqXHR.responseText;
					}
					alert(msg);
				},
			});	
		}
		return false;
	});
	
	
	var myDropzone = new Dropzone("div#model_car_image", { 
    url: siteUrl+'car_inventory/model.php?action=uploadfiles',
    addRemoveLinks: true,
	acceptedFiles: 'image/*',
	maxFiles: 2,
	minFiles: 1,
	headers: {
		'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
	},
    success: function(file, serverFileName) {
        file.upload.filename = serverFileName;
        return true;
    },
	
	
    removedfile: function(file, event) {
        var fname = file.upload.filename;
		$.ajax({
			type: "POST",
			url: siteUrl+'car_inventory/model.php?action=removefiles',
			data: {filename: fname},
			success:
				function( response ) {
					//alert(response);
				},
		});
        $(file.previewElement).remove();
        return true;
    }
});
$(document).ready(function() {
	$('#header li a').removeClass('active');
	$('.add_car_model').addClass('active');
	Dropzone.autoDiscover = false;
});

	</script>
</body>
</html>