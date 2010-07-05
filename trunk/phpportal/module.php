<?php
require 'common.php';

function echo_module_session_fields($module_session) {
	if ($module_session->start)
		echo '<strong>Start:</strong> ' . formatted_date_time($module_session->start) . '<br />';
	
	if ($module_session->end)
		echo '<strong>End:</strong> ' . formatted_date_time($module_session->end) . '<br />';
	
	if ($module_session->region)
		echo '<strong>Geographic Region:</strong> ' . $module_session->region . '<br />';
	
	foreach ($module_session->instructor as $instructor)
		echo '<strong>Instructor:</strong> ' . $instructor.given . ' ' . $instructor->family . '<br />';
	
	if ($module_session->institute)
		echo '<strong>Institute:</strong> ' . $module_session->institute . '<br />';
	
	if ($module_session->location)
		echo '<strong>Venue:</strong> ' . $module_session->location . '<br />';
	
	if ($module_session->open)
		echo '<strong>Enrollment Open From:</strong> ' . $module_session->open . '<br />';
	
	if ($module_session->deadline)
		echo '<strong>Enrollment Dealine:</strong> ' . $module_session->deadline . '<br />';
	
	if ($module_session->seats)
		echo '<strong>Available Seats:</strong> ' . $module_session->seats . '<br />';
	
	if ($module_session->status)
		echo '<strong>Status:</strong> ' . $module_session->status . '<br />';
}

$module_xml_url = $_REQUEST['module_xml'];
$module = simplexml_load_file($module_xml_url);
?>

<html>
    <head>
        <title><?php echo $module->title; ?></title>
        <link rel="stylesheet" type="text/css" href="styles.css" />
    </head>
    <body>

<?php echo_top_nav(FALSE); ?>

        <h1><?php echo $module->title; ?></h1>
        <p><strong>Type:</strong> <?php echo learning_type_display_name($module->type); ?></p>
        <p><strong>Subject:</strong> <?php echo $module->subject; ?></p>
        <p><strong>Language:</strong> <?php echo $module->language; ?></p>
        <p><strong>Description:</strong> <?php echo $module->description; ?></p>
        <p><strong>Objectives:</strong><ul>
<?php
foreach ($module->objective as $objective) {
	echo '<li>' . $objective . '</li>';
}
?>
		</ul></p>
        <p><strong>More Information:</strong> <?php echo '<a href="' . $module->info . '">' . $module->info . '</a>'; ?></p>
        
        <h2>Sessions</h2>
        <ul>
<?php
foreach ($module->session as $session) {
	echo '<li>';
	
	if ($session->id)
		echo '<strong>' . $session->id . '</strong><br />';
	
	echo '<ul>';
	
	foreach ($session->module as $program_module) {
		$xml_links = $program_module->xpath('link[@rel=\'self\']');
		$href = 'module.php?module_xml=' . urlencode($xml_links[0]['href']);
		echo '<li><a href="' . $href . '">' . $program_module->title . '</a> (';
		echo learning_type_display_name($program_module->type) . ')<br />';
		echo_module_session_fields($program_module);
		echo '</li>';
	}
	
	echo '</ul>';
	
	echo_module_session_fields($session);
	
	$enroll_links = $session->xpath('link[@rel=\'enroll\']');
	echo '<a href="' . $enroll_links[0]['href'] . '">Enroll</a>';
	echo '</li>';
}
?>
        </ul>
    </body>
</html>
