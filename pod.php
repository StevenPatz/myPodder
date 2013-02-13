<?php
require("../SimplePie/simplepie_1.3.1.mini.php");
//require_once('../SimplePie/autoloader.php');
// @TODO Just a single feed for now, but soon it will be
// a full html page with a form to select the feed to 
// parse
if (PHP_SAPI === 'cli') {
	$nlbr = "\n";
   } else {
	$nlbr = "<br/>";
}

$testFeed = "http://www.loc.gov/podcasts/exquisitecorpse/exquisitecorpse.xml";
$feed = new SimplePie();
 
// Set which feed to process.
$feed->set_feed_url($testFeed);
 
// Run SimplePie.
$feed->init();
 
// This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
$feed->handle_content_type();
print $feed->get_description();
print $nlbr;
foreach ($feed->get_items() as $item) {
	$enclosures = $item->get_enclosures();
	foreach ($enclosures as $enclosure) {
		print $enclosure->get_link();
		print $nlbr;
	}
}

?>
