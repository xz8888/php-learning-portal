<?php
require 'common.php';

$article_xml_url = $_GET['article_xml'];
$entry = simplexml_load_file($article_xml_url);
?>

<html>
    <head>
        <title><?php echo $entry->title; ?></title>
        <link rel="stylesheet" type="text/css" href="styles.css" />
    </head>
    <body>

<?php echo_top_nav(FALSE); ?>

        <h1><?php echo $entry->title; ?></h1>
        
        <!-- TODO convert the date to a friendlier format instead of showing XML date format directly. -->
        <p><strong>Date:</strong> <?php echo formatted_date_time($entry->published); ?></p> 
        
        <?php echo $entry->content; ?>
    </body>
</html>
