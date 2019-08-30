<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php 

include('dbconfig.php');
include('scripts/scripts.html');
include('functions/functions.php');

if(session_status() == PHP_SESSION_ACTIVE){

} else {
	session_start();
}

$SQL = new SQLClass();
?>
<link rel="stylesheet" href="css/header.css">
<html>
<head>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#logo').on('click', function(){
				window.location.href = 'skulist.php';
			})
		})
	</script>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  		<img id="logo" src="site images/cassellie.png">
  		

  		<form class="form-inline" action="search.php" method="get">
    		<input class="form-control mr-sm-2 src" name='srcInput' id="srcInput" type="text" placeholder="Search SKU...">
    		<button class="btn btn-success" id="srcBtn" type="submit">Search</button>
  		</form>
	</nav>
</head>
