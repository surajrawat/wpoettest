<?php 
require_once '../config/database.php';

$device_id = isset($_POST['id'])?$_POST['id'] : '';
$_SESSION['user_device_id'] = $device_id;

$brand_result = $db->query("SELECT * FROM brand WHERE device_id ='$device_id' LIMIT 3");
$rows = mysqli_num_rows($brand_result);
$message = "";

while ($data = mysqli_fetch_assoc($brand_result)){

	$message .=   '<li><a class="menu-item device_id"><input type="hidden" value="'.$data['id'].'"><img src="uploads/brand_image/'.$data['image'].'" class="table_img"><p>'.$data['name'].'</p></a></li>';

}

echo($message);

?>




