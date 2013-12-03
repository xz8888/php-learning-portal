<?php
require 'config.php';
session_start();

$target = $_REQUEST['target'];

if (isset($_SESSION['user_name'])) {
	header('Location: ' . $target);
} else {
	$nonce = bin2hex(openssl_random_pseudo_bytes(20));
	$_SESSION['nonce'] = $nonce;
	$_SESSION['target'] = $target;
	$location = $ekp_base . 'servlet/ekp/authenticate?nonce=' . urlencode($nonce)
			. '&callback=' . urlencode($auth_callback);
	header('Location: ' . $location);
}
?>
