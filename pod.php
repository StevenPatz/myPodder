<?php
display_form();
require("../SimplePie/simplepie_1.3.1.mini.php");
$database = call_database();
$d = display_feeds($database);

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
//print $feed->get_description();
print $nlbr;
foreach ($feed->get_items() as $num => $item) {
	$enclosures = $item->get_enclosures();
	foreach ($enclosures as $enclosure) {
		?><a href="<?php print $enclosure->get_link();?>"><?php print $num;?></a><?php
		print $nlbr;
	}
}
function call_database() {

  try
  {
    //open the database
    $db = new PDO('sqlite:podder.sqlite');
    return $db;
  }
  catch(PDOException $e)
  {
    print 'Exception : '.$e->getMessage();
  }
  
 } 
function add_feeds() {

//$db->exec("INSERT INTO feeds (id,url,guid,transfered) VALUES ($id,$url,$guid,$transfered);");



}


function display_feeds($db) {

    $result = $db->query('SELECT * FROM feeds');
    foreach($result as $row)
    {
      print $row['id'];
      print $row['url'];
      print $row['guid'];
      print $row['transfered'];
    }
    

    // close the database connection
   $db = NULL;
  }

function display_form() {
session_start();
include("../PFBC/Form.php");
$form = new PFBC\Form("Feeds");
$form->addElement(new PFBC\Element\Select("Select a Feed:", "FeedSelect", array(
   "Feed 1",
   "Feed 2",
   "Feed 3"
)));
$form->addElement(new PFBC\Element\Button);
$form->render();
}


?>
