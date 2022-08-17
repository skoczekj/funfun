<?php
echo "Hello World!";

$a = "I'm a str";
var_dump($a);

// phpinfo();

//basic page to test if crawler does anything
ob_start();
include "home.html";
$html = ob_get_clean();
echo $html;
