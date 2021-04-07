<?php 
require_once '../config/database.php';
require_once '../config/helper.php';

function sanitize($dirty){
    global $db;
    return trim(mysqli_real_escape_string($db, $dirty));
}


$error = $year = array();
$status = $message = "";

$order_id = ( isset($_POST['order_id']) ? $_POST['order_id'] : '' );
$username = ( isset($_POST['username']) ? $_POST['username'] : '' );
$mobile = ( isset($_POST['mobile']) ? $_POST['mobile'] : '' );
$email = ( isset($_POST['email']) ? $_POST['email'] : '' );
$address = ( isset($_POST['address']) ? $_POST['address'] : '' );

if (empty($username)) {
	$error['username'] = 'Please enter your full name';
}else{
	if( !preg_match('/^[a-zA-Z\s.]{3,255}$/', $username) ) {
      $error['username'] = 'Name should be of max. 255 characters. Only Alphabets, space and dot allowed.';
    }
}

if (empty($mobile)) {
	$error['mobile'] = 'Please enter your mobile no.';
}else{
	if( !preg_match('/^[+0-9*]{6,15}$/', $mobile) ) {
		$error['mobile'] = 'Invalid mobile number.';
	}
}
if (!empty($email)) {
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error['email'] = 'You must enter a valid email address.'; 
	}
}

if (empty($address)) {
	$error['address'] = 'Enter your full address details.';	
}

if (!empty($error)) {
	$status = "fail";
    $message = "Please check your fields properly then submit the form";
	
}else{

	$date = date('d F, Y (l)');
	$time = date("h:i:sa");

	$username = sanitize($username); 
	$mobile = sanitize($mobile); 
	$email = sanitize($email); 
	$address = sanitize($address); 

	$insertApplication = "INSERT INTO pending_orders (order_id, user_name, user_mobile, user_email, user_address, order_date, order_time )values('$order_id', '$username', '$mobile', '$email', '$address', '$date', '$time')";
	$applicationQuery = $db->query($insertApplication);
//	$last_id = $db->insert_id;
	
	if ($applicationQuery) {
		$status = "success";
	    $message = "Booking Successfully.";
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
$obj->order_id = $order_id;


echo json_encode($obj);	

?>