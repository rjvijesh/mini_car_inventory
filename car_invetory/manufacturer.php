<?php 
require_once 'database.php';
class Manufacturer{
	public function add($name=''){
		$status = array('resp'=>'error', 'flag'=>2, 'message'=>'data insertion failed');
		if(isset($name) && !empty($name)){
			//data to be inserted in manufaturer master table
			$manufaturerDetails = array();
			$manufaturerDetails['name'] = $name;
			$manufaturerDetails['status'] = 1;
			$manufaturerDetails['created_on'] = date('Y:m:d h:i:s');
			$dbinsert = new Database();
			if($dbinsert->addManufacturer($manufaturerDetails)){
				$status = array('resp'=>'success', 'flag'=>1, 'message'=>'data inserted successfully');
			}
		}else{
			$status = array('resp'=>'error', 'flag'=>2, 'message'=>'manufacturer name not found');
		}
		echo json_encode($status);
		exit;
	}
}
if(isset($_GET['action']) && $_GET['action'] == 'add' && isset($_POST)){
	$mn = new Manufacturer();
	if(isset($_POST['mname']) && !empty($_POST['mname'])){
		$mn->add($_POST['mname']);
	}
}
?>