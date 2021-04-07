<?php 
require_once '../config/database.php';
require_once '../config/helper.php';

function sanitize($dirty){
    global $db;
    return trim(mysqli_real_escape_string($db, $dirty));
}


$error = $year = array();
$status = $message = "";

$device_id = ( isset($_POST['device_id']) ? $_POST['device_id'] : '' );
$brand_id = ( isset($_POST['brand_id']) ? $_POST['brand_id'] : '' );
$model_id = ( isset($_POST['model_id']) ? $_POST['model_id'] : '' );
$service = ( isset($_POST['service']) ? $_POST['service'] : '' );

if (empty($service)) {
	$error['service'] = 'Please select services';
}

if (!empty($error)) {
	$status = "fail";
    $message = "Please select services you want to get.";
	
}else{


	$service_data = "";  
	foreach($service as $value){  
		
	      $service_data .= $value.",";  
	}

	$device_id = sanitize($device_id); 
	$brand_id = sanitize($brand_id); 
	$model_id = sanitize($model_id); 
	$service_data = sanitize($service_data); 

	$insertApplication = "INSERT INTO orders (device_id, brand_id, model_id, services)values('$device_id', '$brand_id', '$model_id', '$service_data')";
	$applicationQuery = $db->query($insertApplication);
	$last_id = $db->insert_id;
	
	if ($applicationQuery) {
		$status = "success";
	    $message = "Booking uploaded successfully.";
	    mysqli_close($db);

    }else{
     	$status = "fail";
        $message = "Please try again later : Error - > D1".$db->error;
    }
}

$obj = new stdClass();  // creation of object
$obj->status = $status;
$obj->message = $message;
$obj->error = $error;

if (!empty($last_id)) {
	$obj->last_id = $last_id;
}



echo json_encode($obj);	

?>