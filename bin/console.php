<?php
namespace Root\Www;

use DiDom\Document;
require_once(__DIR__ . '/../vendor/autoload.php');

$shortOpts = "hu:l::";
$longOpts = ["help", "url", "limit"];

$opts = getopt($shortOpts);

$outputHandler = new OutputHandler();
$service = new Service($outputHandler);
$inputHandler = new InputHandler($opts, $outputHandler, $service);
$inputHandler->crawl();



// crawl($url, $limit);

// lineBreak();

exit;
