<?php 
require_once '../config/database.php';
require_once '../config/helper.php';

function sanitize($dirty){
    global $db;
    return trim(mysqli_real_escape_string($db, $dirty));
}


$error = $year = array();
$status = $message = "";

$name = ( isset($_POST['name']) ? $_POST['name'] : '' );
$mobile = ( isset($_POST['mobile']) ? $_POST['mobile'] : '' );
$message = ( isset($_POST['message']) ? $_POST['message'] : '' );

if (empty($name)) {
	$error['name'] = 'Enter your name';
}else{
	if( !preg_match('/^[a-zA-Z\s.]{3,255}$/', $name) ) {
      $error['name'] = 'Name should be of max. 255 characters. Only Alphabets, space and dot allowed.';
    }
}

if (empty($mobile)) {
	$error['mobile'] = 'Enter your mobile no.';
}else{
	if( !preg_match('/^[+0-9*]{6,15}$/', $mobile) ) {
		$error['mobile'] = 'Invalid mobile number.';
	}
}

if (empty($message)) {
	$error['message'] = 'Enter your message.';	
}

if (!empty($error)) {
	$status = "fail";
    $message = "Please check your fields properly then submit the form";
	
}else{

	$date = date('d F, Y (l)');
	$time = date("h:i:sa");

	$name = sanitize($name); 
	$mobile = sanitize($mobile); 
	$message = sanitize($message); 
	
	$insertApplication = "INSERT INTO contact_us (name, mobile, message, contact_date, contact_time )values('$name', '$mobile', '$message', '$date', '$time' )";
	$applicationQuery = $db->query($insertApplication);
	
	if ($applicationQuery) {
		$status = "success";
	    $message = "We receive your message, Our team will contact you shortly.";
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


echo json_encode($obj);	

?>