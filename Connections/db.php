<?php
ini_set('display_errors',0);
ini_set('allow_url_fopen', 1);
session_start();
$hostname_db = "localhost";
$database_db = "talkandtrips";
$username_db = "talkandtrips";
$password_db = "tytrs232root";

$db = mysql_pconnect($hostname_db, $username_db, $password_db) or trigger_error(mysql_error(),E_USER_ERROR); 

mysql_select_db($database_db, $db);
$array_idiomas = array('esp', 'eng');
if (!isset($_SESSION['sess_idioma'])||empty($_SESSION['sess_idioma']))
{
	$_SESSION['sess_idioma'] = "esp";
}
	
if (isset($_REQUEST['idioma']) && (in_array($_REQUEST['idioma'], $array_idiomas)))
{
	$_SESSION['sess_idioma'] = $_REQUEST['idioma'];
}

?>