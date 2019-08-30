<?php 

include('../includes/auth.php');

$sid = $_REQUEST['sid'];
$sku = $_REQUEST['sku'];
$skuFunc = new SKUFunc();

if(strpos($skuFunc->checkSKUImage($sid), "No Image Found") !== false){
	
	mkdir('../SKUImages/'.$sku.'',0777);
	$target_dir = "../SKUImages/$sku/";
	$path = $_FILES['image']['name'];
	$ext = pathinfo($path, PATHINFO_EXTENSION);
	$temp = explode(".", $_FILES["file"]["name"]);
	$newfilename = $sku.'.'.$sid.".". end($temp);


	if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$newfilename)) {
   		$status = 1;
	}

	if($status == 1){
	$ins = $skuFunc->uploadImageDetails($sid, $newfilename);
}
} else {
	$target_dir = "../SKUImages/$sku/";
	$path = $_FILES['image']['name'];
	$ext = pathinfo($path, PATHINFO_EXTENSION);
	$temp = explode(".", $_FILES["file"]["name"]);
	$newfilename = $sku.'.'.$sid.".". end($temp);
	$orig = $skuFunc->checkSKUImage($sid);
	if(unlink($target_dir.$orig)){
		if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$newfilename)) {
   		$status = 1;
		}
		if($status == 1){
			$upd = $skuFunc->updateImageDetails($sid, $newfilename);
		}
	}
}

?>