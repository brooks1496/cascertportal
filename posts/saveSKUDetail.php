<?php 

include('../includes/auth.php');

$skuFunc = new skuFunc();

$c = $_REQUEST['type'];

if($c == 'Product Type'){
	$column = 'ProductType';
} 
else if($c == 'Range'){
	$column = 'Range';
} 
else if($c == 'Supplier Contact'){
	$column == 'SupplierContact';
}

$update = $skuFunc->updateSKU($_REQUEST['sid'], $column, $_REQUEST['input']);


if($update){
	echo "success";
} else {
	echo "failed";
}
?>