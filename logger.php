<?php

require_once 'vendor/autoload.php'; // Gọi autoloader của Composer

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CustomLogger extends Logger
{
    public function __construct($name, $logPath, $logLevel = Logger::DEBUG)
    {
        parent::__construct($name);
        $this->pushHandler(new StreamHandler($logPath, $logLevel));
    }

    public function logInfo($message)
    {
        $this->info($message);
    }

    public function logWarning($message)
    {
        $this->warning($message);
    }

    public function logError($message)
    {
        $this->error($message);
    }
}

// Sử dụng CustomLogger
$log = new CustomLogger('custom_name', 'your_custom.log', Logger::INFO);

// Ghi log với các mức độ khác nhau
$log->logInfo('This is an informational message');
$log->logWarning('This is a warning message');
$log->logError('This is an error message');
