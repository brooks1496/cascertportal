<?php

include('../includes/auth.php');

$certs = array_values($_REQUEST['certs']);
$a = 1;

$sku  = $_REQUEST['sku'];
$sid = $_REQUEST['sid'];

$_SESSION['sku'] = array(
	'code'=> $sku,
	'sid' => $sid,
	'certs' => $certs,

);

print_r($_SESSION);

?>

