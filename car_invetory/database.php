<?php 
class Database{
	private $user ;
    private $host;
    private $pass ;
    private $db;
    private $conn;

    public function __construct()
    {
        $this->conn = false;
        $this->host = "localhost";
        $this->user = "root";
        $this->pass = "";
        $this->db = "car_inventory";
		$this->connect();
    }
    public function connect()
    {
		$this->conn = mysqli_connect($this->host, $this->user, $this->pass,$this->db);
		if (!$this->conn) {
			echo "Error: Unable to connect to MySQL." . PHP_EOL;
			echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
			echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
			exit;
		}
		
		return $this->conn;
    }
	
	public function addManufacturer($manufacturerData = array()){
		if(isset($manufacturerData) && !empty($manufacturerData)){
			$name = !empty($manufacturerData['name']) ? $manufacturerData['name'] : '';
			$status = !empty($manufacturerData['status']) ? $manufacturerData['status'] : '';
			$created_on = !empty($manufacturerData['created_on']) ? $manufacturerData['created_on'] : '';
			$sql = "INSERT INTO manufacturer_master_details ".
               "(name,status, created_on) "."VALUES ".
               "('$name','$status','$created_on')";
               //mysql_select_db( $this->db);
			if ($this->conn->query($sql) === TRUE){    
				return true;
			} else {   
				return false;
			}
		}else{
			return false;
		}
	}
	
	public function addModel($modelDetails=array()){
		if(isset($modelDetails) && !empty($modelDetails)){
			$name = !empty($modelDetails['name']) ? $modelDetails['name'] : '';
			$manufacturer_id = !empty($modelDetails['manufacturer_id']) ? $modelDetails['manufacturer_id'] : '';
			$color_code = !empty($modelDetails['color_code']) ? $modelDetails['color_code'] : '';
			$year = !empty($modelDetails['year']) ? $modelDetails['year'] : '';
			$files = !empty($modelDetails['files']) ? $modelDetails['files'] : '';
			$status = !empty($modelDetails['status']) ? $modelDetails['status'] : '';
			$created_on = !empty($modelDetails['created_on']) ? $modelDetails['created_on'] : '';
			
			$sql = "INSERT INTO model_master_details ".
               "(name, manufacturer_id, color_code, year, files, status, created_on) "."VALUES ".
               "('$name', '$manufacturer_id', '$color_code', '$year', '$files','$status','$created_on')";
            if ($this->conn->query($sql) === TRUE){    
				return true;
			} else {   
				return false;
			}
		}else{
			return false;
		}
	}
	
	public function getAllManufactureDetails(){
		$allManufacturerDetails=array();
		$sql = "select id,name from manufacturer_master_details where status=1 ";
		$cur = mysqli_query($this->conn,$sql);
		while($data = mysqli_fetch_assoc($cur)) { 
			$allManufacturerDetails[$data['id']] = $data['name'];
		}
		return $allManufacturerDetails;
	}
	
	public function getModelDetails(){
		$allModelDetails=array();
		$sql = "select id,name,manufacturer_id,color_code,year,files from model_master_details where status=1";
		$cur = mysqli_query($this->conn,$sql);
		while($data = mysqli_fetch_assoc($cur)) { 
			$allModelDetails[$data['id']] = $data;
		}
		return $allModelDetails;
	}
	
	public function updateModel($modelDetails=array()){
		if(isset($modelDetails) && !empty($modelDetails)){
			$id = !empty($modelDetails['id']) ? $modelDetails['id'] : '';
			$flag = !empty($modelDetails['flag']) ? $modelDetails['flag'] : '';
			if(!empty($id) && $id > 0){
				if($flag == 'delete'){
					$sql = "update model_master_details SET status=4 where status=1 and id=".$id;
					if ($this->conn->query($sql) === TRUE){    
						return true;
						//echo "csdjcv";die;
					} else {   
						return false;
						//echo("Error description: " . mysqli_error($this->conn));
					}
				}	
			}else {   
				return false;
			}
		}else{
			return false;
		}
	}
}
$db = new Database();
//$db->connect();
?>