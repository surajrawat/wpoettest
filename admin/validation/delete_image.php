<?php 
require_once '../../config/database.php';

$status = $message = "";

$id = ( isset($_POST['id']) ? $_POST['id'] : '' );


$query = $db->query("SELECT * FROM tab WHERE id = '$id'");
$img = mysqli_fetch_assoc($query);

$image_url = $_SERVER['DOCUMENT_ROOT']."/wpoet/uploads/tabiconimage/".$img['icon_image'];
unlink($image_url);
$result = $db->query("UPDATE tab SET `icon_image` = '' WHERE id = '$id' ");
if ($result) {
	$status = "success";
    $message = "Image deleted successfully.";
}else{
 	$status = "fail";
    $message = "Please try again later : Error - > D1".$db->error;
}


$obj = new stdClass();  // creation of object
$obj->status = $status;
$obj->message = $message;
echo json_encode($obj);	

?>
