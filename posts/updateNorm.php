<?php 

include('../includes/auth.php');

$result = $SQL->SQLQuery("UPDATE intranet.dbo.Certification_LKNorms SET Required = ".$_REQUEST['required']." WHERE FK_NormID = ".$_REQUEST['normID']." AND FK_ProductID = ".$_REQUEST['skuID']);

?>