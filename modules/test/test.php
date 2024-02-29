<?php
$re = '/cars\/(\d.*)/';
$str = 'api/cars/36';

preg_match($re, $str, $matches, PREG_OFFSET_CAPTURE, 0);

// Print the entire match result
var_dump($matches);
