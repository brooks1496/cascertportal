<?php 

include('includes/header.php');

?>
<link rel="stylesheet" type="text/css" href="css/home.css">

<div class="container-fluid">

<?php 
$a = 6;

for($i=0; $a > $i; $i++){
	echo '<div class="row">';
	echo '<div class="col-md-2"><h1>'.$i.'</h1></div>
	<div class="col-md-3"><canvas id="'.$i.'"></canvas></div>
	<div class="col-md-3"></div>
	<div class="col-md-3"></div>';
	echo '</div>';
	echo '<div class="row break"></div>';
}

$result = $SQL->SQLQuery('SELECT * from [InventoryControl].[dbo].[ShippingPO]');



?>
