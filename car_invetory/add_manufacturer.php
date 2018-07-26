<html>
<?php require_once('header.php');?>
<body>
<div class="MT20 TC">
<h3 class="TC MB20">Add Manufacturer</h3>
<form action="/" method="post" name="manufacturer" id="manufacturer">
<label> Name</label>
<input type="textbox" name="mname" id="mname" />
 <br><br>
<input type="submit" value="Submit">
</form>
</div>
<script>
$( '#manufacturer' ).submit( function(){
	var data = $('#manufacturer').serialize();
	var mname = $('#mname').val();
	if(mname == ''){
		alert("Manufacturer name cannot be blank");
	}else{
		$.ajax( {
			url: siteUrl+'car_inventory/manufacturer.php?action=add',
			data: data,
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
$(document).ready(function() {
	$('#header li a').removeClass('active');
	$('.add_manufacturer').addClass('active');
});
</script>
</body>
</html>