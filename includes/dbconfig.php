<?php 

$odbc_name = "Inventory";
$user_name = "web_access";
$password = "Sys314169$";
if($_SERVER['SERVER_NAME'] == 'pl.cassellie.co.uk'){
$GLOBALS['db'] = 'Lifecycle';
} else {
	$GLOBALS['db'] = 'LifecycleTest';
}


/**************************************************************************
** Connect to database:
*/
$con = odbc_connect($odbc_name,$user_name,$password) 
    or die('Could not connect to the server!');

?> 