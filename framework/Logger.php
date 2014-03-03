<?php

include_once 'Enum.php';
include_once 'LoggerConsole.php';
include_once 'ChromePhp.php';

class LoggerMode extends Enum{
	const CONSOLE = "console";
	const CHROME = "chrome";
}

abstract class Logger{
	public static function getLogger(LoggerMode $loggerMode){
		$instance = null;

		$instance = $loggerMode;

		switch ($loggerMode) {
			case LoggerMode::CONSOLE:
				$instance = new LoggerConsole();
				break;
			case LoggerMode::CHROME:
				$instance = ChromePhp::getInstance();
				break;
		}

		return $instance;
	}

	public abstract function log($obj);
	public abstract function info($str);
	public abstract function warn($str);
	public abstract function error($str);

	public abstract function groupCollapsed($str);
	public abstract function groupEnd();
}
?>