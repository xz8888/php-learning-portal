<?php
require 'common.php';

$default_catalog_xml_url = $ekp_base . 'api/catalog?id=*ROOT*';
$catalog_xml_url = isset($_GET['catalog_xml']) ? $_GET['catalog_xml'] : $default_catalog_xml_url;

session_start();

if (isset($_SESSION['user_name'])) {
	// User is signed in, so send an authenticated request to fetch catalogs based on the user's permissions
	$ch = curl_init($catalog_xml_url . '&userId=' . urlencode($_SESSION['user_name']));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_USERPWD, $admin_user_name . ':' . $admin_password);
	$returned = curl_exec($ch);
	curl_close($ch);
	
	$catalog = simplexml_load_string($returned);
} else {
	// User is not signed in, so send an unauthenticated request to fetch information for public catalogs
	$catalog = simplexml_load_file($catalog_xml_url);
}
?>

<html>
    <head>
        <title><?php echo $catalog->title; ?></title>
        <link rel="stylesheet" type="text/css" href="styles.css" />
    </head>
    <body>

<?php echo_top_nav(FALSE); ?>
    
<?php
// breadcrumb trail
function show_breadcrumb($catalog) {
    if ($catalog->{'parent'}) {
    	show_breadcrumb($catalog->{'parent'});
    	echo '<a href="?catalog_xml=', urlencode($catalog->{'parent'}->link[0]), '">', $catalog->{'parent'}->title, '</a> &gt; ';
    }	
}

if ($catalog->{'parent'}) {
	echo '<br />';
}

show_breadcrumb($catalog);
?>

        <h1><?php echo $catalog->title; ?></h1>
        <h2>Subcatalogs</h2>
        <ul>
        
<?php
foreach ($catalog->child as $child) {
	// This used to work before the XML link format was fixed
	// $href = $child->link[0];
	
	// New way
	$xml_links = $child->xpath('link[@rel=\'self\']');
	$href = $xml_links[0]['href'];
	
	echo '<li><a href="?catalog_xml=', urlencode($href), '">', $child->title, '</a></li>';
}
?>

        </ul>
        <h2>Courses</h2>
        <ul>
        
<?php
foreach ($catalog->module as $module) {
	$xml_links = $module->xpath('link[@rel=\'self\']');
	$href = 'module.php?module_xml=' . urlencode($xml_links[0]['href']);
	echo '<li><a href="' . $href . '">' . $module->title . '</a> (' . learning_type_display_name($module->type) . ')';
	echo '<br />' . $module->description . '</li>';
}
?>

        </ul>
    </body>
</html>
