<?php
// defines $ekp_base, $auth_key
require 'config.php';

function force_sign_in() {
	session_start();
	
	if (!isset($_SESSION['user_name'])) {
		$location = 'sign_in.php?target=' . urlencode($_SERVER['REQUEST_URI']);
		header('Location: ' . $location);
	}
}

function echo_top_nav($send_to_home_on_sign_out) {
?>
<table width="100%">
	<tr>
		<td>
			<ul class="nav">
				<li><a href="public_news.php">Public News</a></li>
				<li><a href="my_news.php">My News</a></li>
				<li><a href="enrollments.php">My Enrollments</a></li>
				<li><a href="records.php">My Records</a></li>
				<li><a href="catalog.php">Catalogs</a></li>
			</ul>
		</td>
		<td align="right">
<?php
// defines $ekp_base, $auth_key
require 'config.php';

if (!isset($_SESSION)) {
	session_start();
}

$scheme = isset($_SERVER['HTTPS']) ? 'https' : 'http';
$target = $scheme . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$home = $scheme . '://' . $_SERVER['HTTP_HOST'] . '/phpportal/public_news.php';

if (isset($_SESSION['user_name'])) {
	$href = 'sign_out.php?target=' . urlencode($send_to_home_on_sign_out ? $home : $target);
	echo 'Signed in as ' . $_SESSION['user_name'] . '&nbsp;&nbsp;&nbsp;<a href="' . $href . '">Sign Out</a>';
} else {
	$href = 'sign_in.php?target=' . urlencode($target);
	echo 'You aren\'t signed in | <a href="' . $href . '">Sign In</a>';
}
?>
		</td>
	</tr>
</table>
<?php
}

function learning_type_display_name($xml_value) {
	switch ((string) $xml_value) {
		case 'onlineModule':
			return 'Online';
		case 'learningProgram':
			return 'Program';
		default:
			return 'Classroom';
	}
}

function formatted_date_time($date_time) {
	return strftime('%b %d, %Y %I:%M %p', strtotime($date_time));
}
?>