<html>
    <head>
        <title>Public News</title>
        <link rel="stylesheet" type="text/css" href="styles.css" />
    </head>
    <body>

<?php
require 'common.php';
echo_top_nav(FALSE);
?>

        <h1>Public News</h1>
        <p>Essentially, these are the news articles that appear on EKP's login page.</p>
        <ul>
        
<?php
$feed = simplexml_load_file($ekp_base . 'api/publicNews?format=atom');

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
