<?php
require 'config.php';
session_start();

$user_id = $_REQUEST['userId'];
$sig_base_str = $user_id . $auth_key . $_SESSION['nonce'];

if ($_REQUEST['sig'] === md5($sig_base_str)) {
	$_SESSION['user_name'] = $user_id;
	header('Location: ' . $_SESSION['target']);
} else {
	echo '<h1>Begone, hacker!</h1>';
}
?>
