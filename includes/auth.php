<?php 

include('C:/xampp/htdocs/Lifecycle/cert/includes/dbconfig.php');
include('C:/xampp/htdocs/Lifecycle/cert/scripts/scripts.html');
include('C:/xampp/htdocs/Lifecycle/cert/functions/functions.php');
if(session_status() == PHP_SESSION_ACTIVE){

} else {
	session_start();
}
$SQL = new SQLClass();
?>