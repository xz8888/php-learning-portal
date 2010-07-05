<?php
require 'common.php';
force_sign_in();
?>
<html>
    <head>
        <title>My News</title>
        <link rel="stylesheet" type="text/css" href="styles.css" />
    </head>
    <body>

<?php echo_top_nav(TRUE); ?>

        <h1>My News</h1>
        <p>These are the same news articles that would appear on the News tab of the user's Home page.</p>
        <ul>
        
<?php
// defines $ekp_base, $auth_key
require 'config.php';

$ch = curl_init($ekp_base . 'api/userNews?userId=' . $_SESSION['user_name'] . '&format=atom');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_USERPWD, $admin_user_name . ':' . $admin_password);
$returned = curl_exec($ch);
curl_close($ch);

$feed = simplexml_load_string($returned);

foreach ($feed->entry as $entry) {
	$entry->registerXPathNamespace('atom', 'http://www.w3.org/2005/Atom');
	$links = $entry->xpath('atom:link[@rel=\'self\']');
	echo '<li>';
	//echo $links[0]['href'], '<br />';
    echo '<a href="article.php?article_xml=', urlencode($links[0]['href']), '">', $entry->title, '</a>';
    echo '<br />';
	echo $entry->summary;
    echo '</li>';
}
?>

        </ul>
    </body>
</html>
