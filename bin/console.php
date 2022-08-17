<?php
include "output.php";
include "service.php";

lineBreak();

$shortOpts = "hu:l::";
$longOpts = ["help", "url", "limit"];

$opts = getopt($shortOpts);

if (isset($opts["h"])) {
    showHelp();
}

$limit = 100;
if (
    isset($opts["l"]) &&
    $opts["l"] < 100 &&
    $opts["l"] > 0
) {
    $limit = (int)$opts["l"];
}

$url = "";
if (isset($opts["u"])) {
    //TODO SANITIZE INPUT
    $url = $opts["u"];
}

crawl($url, $limit);

lineBreak();

exit;
