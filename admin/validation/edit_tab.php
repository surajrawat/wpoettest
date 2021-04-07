<?php 
require_once '../../config/database.php';

function sanitize($dirty){
    global $db;
    return trim(mysqli_real_escape_string($db, $dirty));
}


$error = $year = array();
$status = $message = "";

$id = ( isset($_POST['id']) ? $_POST['id'] : '' );
$tab_name = ( isset($_POST['tab_name']) ? $_POST['tab_name'] : '' );



if (empty($tab_name)) {
	$error['tab_name'] = 'Enter tab name.';
}

if (isset($_FILES['tab_image']['name'])) {
	$tab_image =  (isset($_FILES['tab_image']['name']) ? $_FILES['tab_image']['name'] : '' );
	$tmpLoc =  ( isset($_FILES['tab_image']['tmp_name']) ? $_FILES['tab_image']['tmp_name'] : '' );

	if (empty($tab_image)) {
		$error['tab_image'] = 'Upload tab icon image.';		
	}else{
		$tab_imagearray = explode('.', $tab_image);
		$fileName =( isset($tab_imagearray[0]) ? $tab_imagearray[0] : '' );
		$fileExt = ( isset($tab_imagearray[1]) ? $tab_imagearray[1] : '' );
		$allowed = array('png','jpeg','jpg');
		if (!in_array($fileExt, $allowed)) {
			$error['tab_image'] = 'The file extension must be a png, jpeg, jpg';
		}
	}
}

if (!empty($error)) {
	$status = "fail";
    $message = "Please check your fields properly then submit the form.";
	
}else{

	if (isset($_FILES['tab_image']['name'])) {

			$t = microtime(true);
		    $micro = sprintf("%06d",($t - floor($t)) * 1000000);
		    $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
		    $date = $d->format('YmdHisu');
			$tab_image = $date.$tab_image;

			$uploadPath =  '../../uploads/tabiconimage/'.$tab_image;

			move_uploaded_file($tmpLoc, $uploadPath);

			$tab_name = sanitize($tab_name); 

			$result = $db->query("UPDATE tab SET `name`  = '$tab_name' , `icon_image` = '$tab_image' WHERE id = '$id' ");
			if ($result) {
				$status = "success";
			    $message = "Tab Updated.";
			    mysqli_close($db);
			}else{
		     	$status = "fail";
		        $message = "Please try again later : Error - > D1".$db->error;
		    }


	}else{

			$tab_name = sanitize($tab_name); 

			$result = $db->query("UPDATE tab SET `name` = '$tab_name' WHERE id = '$id' ");
			if ($result) {
				$status = "success";
			    $message = "Tab Updated.";
			    mysqli_close($db);
			}else{
		     	$status = "fail";
		        $message = "Please try again later : Error - > D1".$db->error;
		    }


	}


}

$obj = new stdClass();  // creation of object
$obj->status = $status;
$obj->message = $message;
$obj->error = $error;

echo json_encode($obj);	

?>