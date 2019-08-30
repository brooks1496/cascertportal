<?php
include('dbconfig.php');
// using ldap bind
$ldaprdn  = $_POST['username'];     // ldap rdn or dn
$ldaprdn  = "cassellie\\".$ldaprdn;
$ldappass = $_POST['password'];  

$username = $_POST['username'];
//print $ldaprdn;

if($ldaprdn == 'cassellie\\'){
    header('location:login.php?resp=1');
} else {



// connect to ldap server
$ldapconn = ldap_connect("ca-sbs-01.cassellie.local")
    or die("Could not connect to LDAP server.");

if ($ldapconn) {

    // binding to ldap server
    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

    // verify binding
    if ($ldapbind) 
	{
    session_start();
	$_SESSION['logged_in'] = "$username";
    // Store Session Data
	
	$_SESSION['login_user']= $ldaprdn;
    

}
}
?>