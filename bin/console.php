<?php
include "output.php";

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
    $limit = $opts["l"];
}

$url = "";
if (isset($opts["u"])) {
    $url = $opts["u"];
}

showPassedArguments($url, $limit);

exit;
