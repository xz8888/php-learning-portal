<?php
require 'config.php';
session_start();

$target = $_REQUEST['target'];

unset($_SESSION['user_name']);
$location = $ekp_base . 'servlet/ekp?TX=LOGOFF&callback=' . urlencode($target);
header('Location: ' . $location);
?>
