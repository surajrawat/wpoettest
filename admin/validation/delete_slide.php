<?php 
require_once '../../config/database.php';

$status = $message = "";

$id = ( isset($_POST['id']) ? $_POST['id'] : '' );

$query = $db->query("SELECT * FROM slides WHERE id = '$id'");
$img = mysqli_fetch_assoc($query);

$image_url = $_SERVER['DOCUMENT_ROOT']."/wpoet/uploads/slideimage/".$img['image'];
unlink($image_url);

$result = $db->query("DELETE FROM slides WHERE id = '$id' ");

if ($result) {
	$status = "success";
    $message = "Slide deleted successfully.";
}else{
 	$status = "fail";
    $message = "Please try again later : Error - > D1".$db->error;
}

$obj = new stdClass();  // creation of object
$obj->status = $status;
$obj->message = $message;
echo json_encode($obj);	

?>
