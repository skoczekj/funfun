<?php
namespace Root\Www;

require_once(__DIR__ . '/../vendor/autoload.php');

$shortOpts = "hu:l::";
$longOpts = ["help", "url", "limit"];

$outputHandler = new OutputHandler();
$inputHandler = new InputHandler(getopt($shortOpts), $outputHandler);
$inputArguments = $inputHandler->getInputArguments();

$service = new Service($outputHandler, $inputArguments);
$service->crawl();

exit;
