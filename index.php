<?php
include_once './framework/Logger.php';

//$logger = Logger::getLogger(LoggerMode::CHROME());
$logger = Logger::getLogger(LoggerMode::CONSOLE());
$logger->groupCollapsed("group1");
$logger->groupCollapsed("group2");
$logger->info($_SERVER);
$logger->groupEnd();
$logger->log("log");
$logger->info("info");
$logger->error("error");
$logger->warn("warn");
$logger->groupEnd();
?>