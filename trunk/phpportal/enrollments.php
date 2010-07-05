<?php
require 'common.php';
force_sign_in();
?>
<html>
    <head>
        <title>My Enrollments</title>
        <link rel="stylesheet" type="text/css" href="styles.css" />
    </head>
    <body>

<?php echo_top_nav(TRUE); ?>

        <h1>My Enrollments</h1>
        <ul>
        
<?php
$ch = curl_init($ekp_base . 'api/enrollments?userId=' . urlencode($_SESSION['user_name']));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_USERPWD, $admin_user_name . ':' . $admin_password);
$returned = curl_exec($ch);
curl_close($ch);

$trainingHistory = simplexml_load_string($returned);

foreach ($trainingHistory->trainingRecord as $record) {
	$launch_link = $record->xpath('link[@rel=\'launch\']');
	$kc_link = $record->xpath('link[@rel=\'kc\']');
	$module_xml_links = $record->learningModule->xpath('link[@rel=\'self\']');
	$module_href = 'module.php?module_xml=' . urlencode($module_xml_links[0]['href']);
	
	echo '<li>';
	echo '<strong><a href="' . $module_href . '">' . $record->learningModule->title . '</a></strong> (<a href="';
	echo $launch_link[0]['href'];
	echo '" target="_blank">Launch</a>, <a href="';
	echo $kc_link[0]['href'];
	echo '" target="_blank">Knowledge Center</a>)';
	
	if ($record->startDate) {
		echo '<br />Start: ' . formatted_date_time($record->startDate);
	}
	
	if ($record->endDate) {
		echo '<br />End: ' . formatted_date_time($record->endDate);
	}
	
	$status = (string) $record->overallStatus;
	
	if ($status === 'incomplete') {
		$display_status = 'In Process';
	} else if ($status === 'completed') {
		$display_status = 'Completed';
	} else if ($status === 'cancelled') {
		$display_status = 'Cancelled';
	} else {
		$display_status = 'Needs Action';
	}
	
	echo '<br />Type: ' . learning_type_display_name($record->learningModule->type);
	echo '<br />Status: ' . $display_status;
    echo '</li>';
}
?>

        </ul>
    </body>
</html>
