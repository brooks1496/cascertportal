<?php 

include('../includes/auth.php');

$skuFunc = new SKUFunc();

$ins = $skuFunc->updateSKUCerts($_REQUEST['skuID'], $_REQUEST['certID'], $_REQUEST['certified'], $_REQUEST['certNum'], $_REQUEST['expiry']);


?>