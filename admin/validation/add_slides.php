<?php 
require_once '../../config/database.php';

function sanitize($dirty){
    global $db;
    return trim(mysqli_real_escape_string($db, $dirty));
}


$error = $year = array();
$status = $message = "";

$tab_id = ( isset($_POST['tab_id']) ? $_POST['tab_id'] : '' );
$heading = ( isset($_POST['heading']) ? $_POST['heading'] : '' );
$subheading = ( isset($_POST['subheading']) ? $_POST['subheading'] : '' );

$slide_image =  (isset($_FILES['slide_image']['name']) ? $_FILES['slide_image']['name'] : '' );
$tmpLoc =  ( isset($_FILES['slide_image']['tmp_name']) ? $_FILES['slide_image']['tmp_name'] : '' );

if (empty($tab_id)) {
	$error['tab_id'] = 'Select Tab';
}

if (empty($heading)) {
	$error['heading'] = 'Enter slide heading';
}

if (empty($subheading)) {
	$error['subheading'] = 'Enter slide subheading';
}else{
	if ( strlen($subheading) > 250 ) {
		$error['subheading'] = 'Subheading length must be max 250 characters';		
	}
}


if (empty($slide_image)) {
	$error['slide_image'] = 'Upload slide image';		
}else{
	$slide_imagearray = explode('.', $slide_image);
	$fileName =( isset($slide_imagearray[0]) ? $slide_imagearray[0] : '' );
	$fileExt = ( isset($slide_imagearray[1]) ? $slide_imagearray[1] : '' );
	$allowed = array('png','jpeg','jpg');
	if (!in_array($fileExt, $allowed)) {
		$error['slide_image'] = 'The file extension must be a png, jpeg, jpg';
	}
}


if (!empty($error)) {
	$status = "fail";
    $message = "Please check your fields properly then submit the form.";
}else{

	$t = microtime(true);
    $micro = sprintf("%06d",($t - floor($t)) * 1000000);
    $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
    $date = $d->format('YmdHisu');
	$slide_image = $date.$slide_image;

	$uploadPath =  '../../uploads/slideimage/'.$slide_image;

	$tab_id = sanitize($tab_id); 
	$heading = sanitize($heading); 
	$subheading = sanitize($subheading); 
	$slide_image = sanitize($slide_image); 

	$applicationQuery = $db->query("INSERT INTO slides (tab_id, heading, subheading, image)values('$tab_id','$heading','$subheading', '$slide_image')");

	if ($applicationQuery) {
		move_uploaded_file($tmpLoc, $uploadPath);
		$status = "success";
	    $message = "Slide inserted successfully.";
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