<?php
require 'config.php';
session_start();

$target = $_REQUEST['target'];

if (isset($_SESSION['user_name'])) {
	header('Location: ' . $target);
} else {
	$nonce = dechex(mt_rand()) . dechex(mt_rand()) . dechex(mt_rand())
			. dechex(mt_rand());
	$_SESSION['nonce'] = $nonce;
	$_SESSION['target'] = $target;
	$location = $ekp_base . 'servlet/ekp/authenticate?nonce=' . urlencode($nonce)
			. '&callback=' . urlencode($auth_callback);
	header('Location: ' . $location);
}
?>
