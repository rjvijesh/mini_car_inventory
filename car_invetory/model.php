<?php 
require_once 'database.php';
session_start();
class Model extends Database{
	public function add($formModelData=array()){
		$status = array('resp'=>'error', 'flag'=>2, 'message'=>'data insertion failed');
		if(isset($formModelData) && !empty($formModelData)){
			//data to be inserted in car model master table
			$modelDetails = array();
			$modelDetails['name'] = $formModelData['name'];
			$modelDetails['manufacturer_id'] = $formModelData['manufacturer_id'];
			$modelDetails['color_code'] = $formModelData['color'];
			$modelDetails['year'] = $formModelData['year'];
			$modelDetails['files']='';
			if(isset($_SESSION['attachment_files']) && !empty($_SESSION['attachment_files'])){
				$fileDetailsArr = $_SESSION['attachment_files'];
				foreach($fileDetailsArr as $key => $value){
					$fileArr[] = $value;
				}
				$modelDetails['files'] = json_encode($fileArr);
			}
			if(empty($modelDetails['files'])){
				$status = array('resp'=>'error', 'flag'=>2, 'message'=>'kindly upload images');
				echo json_encode($status);
				exit;		
			}
			$modelDetails['status'] = 1;
			$modelDetails['created_on'] = date('Y:m:d h:i:s');
			$dbinsert = new Database();
			if($dbinsert->addModel($modelDetails)){
				$status = array('resp'=>'success', 'flag'=>1, 'message'=>'data inserted successfully');
			}
		}else{
			$status = array('resp'=>'error', 'flag'=>2, 'message'=>'manufacturer name not found');
		}
		echo json_encode($status);
		exit;
	}
	
	public function uploadfiles(){
		if(isset($_FILES) && !empty($_FILES)) {
			$attachment_files = isset($_SESSION['attachment_files']) ? $_SESSION['attachment_files'] : '';
			
			if(empty($attachment_files) || !is_array($attachment_files)){
				$attachment_files = [];
			}
			//remove space, dot and other special characters from a file name
			if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])){
				$fileDetails = pathinfo($_FILES['file']['name']);
				$fileDetails['filename'] = preg_replace('/[^A-Za-z0-9]/', '_', $fileDetails['filename']);
				$_FILES['file']['name'] = $fileDetails['filename'].'.'.$fileDetails['extension'];	
			}
			
			$tmp = explode('.', $_FILES['file']['name']);
			$ext = end($tmp);
			$ext = strtolower($ext);
			$file_name = md5 ( $_FILES['file']['name'] . time () ) . '.' . $ext;
			$path = 'upload/';
			move_uploaded_file($_FILES['file']['tmp_name'], $path.$file_name);
			$attachment_files[] = $file_name;
			$_SESSION['attachment_files']= $attachment_files;
			echo $file_name;
		}
	}
	
	public function removefiles(){
		$filename = $_POST['filename'];
		$attachment_files = isset($_SESSION['attachment_files']) ? $_SESSION['attachment_files'] : array();
		if(isset($attachment_files)){
			//find the file to be removed in a array and unset
            $key = array_search($filename, $attachment_files); // $key = 2;
			if(!empty($key) && isset($attachment_files[$key])){
				unset($attachment_files[$key]);
				//find the file from the actual directory and unlink the file
				$path ='upload/';
				$file_path = $path.$filename;
				unlink($file_path);
			}
			//set the new array and overwrite to session value
			$_SESSION['attachment_files'] = $attachment_files;
			   
			 //read from final session value  
			$attachment_files = $_SESSION['attachment_files'];
			print_r($attachment_files);
		}
	}
	
	public function updatestatus($id='', $flag=''){
		$status = array('resp'=>'error', 'flag'=>2, 'message'=>'data update failed');
		if(isset($id) && !empty($id) && isset($flag) && !empty($flag)){
			$modelUpdateDetails=array();
			$modelUpdateDetails['id'] = $id;
			$modelUpdateDetails['flag'] = $flag;
			$dbupdate = new Database();
			if($dbupdate->updateModel($modelUpdateDetails)){
				$status = array('resp'=>'success', 'flag'=>1, 'message'=>'data updated successfully');
			}	
		}else{
			$status = array('resp'=>'error', 'flag'=>2, 'message'=>'data updation failed');
		}
		echo json_encode($status);
		exit;
	}
}

$model = new Model();
if(isset($_GET['action']) && $_GET['action'] == 'add' && isset($_POST)){
	if(isset($_POST['model']) && !empty($_POST['model'])){
		$model->add($_POST['model']);
	}
}
if(isset($_GET['action']) && $_GET['action'] == 'uploadfiles' && isset($_POST)){
	$model->uploadfiles();
}
if(isset($_GET['action']) && $_GET['action'] == 'removefiles'){
	$model->removefiles();
}
if(isset($_GET['action']) && $_GET['action'] == 'updatestatus'){
	if(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['flag']) && !empty($_POST['flag'])){
		$model->updatestatus($_POST['id'], $_POST['flag']);
	}
}
?>