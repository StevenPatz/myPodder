<?php
display_form();
require("../SimplePie/simplepie_1.3.1.mini.php");
//$database = call_database();
//$d = display_feeds($database);

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
  foreach ($feed->get_items() as $num => $item) {
	print $nlbr . "START DOWNLOAD " . $num;
	
	$enclosures = $item->get_enclosures();
	foreach ($enclosures as $enclosure) {
	  $url = $enclosure->get_link();
	  $mp3 = file_get_contents($url);
	  $file_name = basename($url);
	    if (!$mp3)
	    die("there was no file");

	  $saveto = "/media/musicB/podcasts/" . $file_name;
	  file_put_contents($saveto, $mp3); 
	  if (!file_exists($saveto))
	    die("File was not saved");

	  
	} 

	print $nlbr . "END DOWNLOAD " . $num . $nlbr;
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
//include($_SERVER["DOCUMENT_ROOT"] . "/PFBC/Form.php");
include("../PFBC/Form.php");
//$form = new PFBC\Form("GettingStarted");
//$form->addElement(new PFBC\Element\Textbox("My Textbox:", "MyTextbox"));
//$form->addElement(new PFBC\Element\Select("My Select:", "MySelect", array(
//   "Option #1",
//   "Option #2",
//   "Option #3"
//)));
//$form->addElement(new PFBC\Element\Button);
//$form->render();
}


?>
