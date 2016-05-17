<?php

// echo time() . "\n";
// date_default_timezone_set('UTC');
// echo time() . "\n";
date_default_timezone_set('Australia/Brisbane');
// echo time() . "\n";


$datetime = new DateTime('2010-12-30 23:21:46');

echo $datetime->format(DateTime::ISO8601) . PHP_EOL;

echo $datetime->format('c') . PHP_EOL;


echo DateTime::ISO8601 . PHP_EOL;
