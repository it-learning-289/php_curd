<?php

// use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('api');
$log->pushHandler(new StreamHandler('./log/test.log'));

// add records to the log
$log->info('This is an informational message.');
$log->warning('This is a warning message.');
$log->error('This is an error message.');