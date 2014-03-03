<?php

include_once 'Logger.php';

class LoggerConsole extends Logger{
	const INFO = "info";
	const WARN = "warn";
	const ERROR = "error";
	const LOG = "";
	const GROUP_START = "GROUP_START";
	const GROUP_END = "GROUP_END";
	const GROUP_TAG = "---------";

	private $groupFlag = false;
	private $outputBuffer = array();
	private $tabCount = 0;

	public function log($str){
		$this->_log(self::LOG, $str);
	}
	
	public function info($str){
		$this->_log(self::INFO, $str);
	}

	public function warn($str){
		$this->_log(self::WARN, $str);
	}

	public function error($str){
		$this->_log(self::ERROR, $str);
	}

	private function getTab($count){
		$tab = "";
		for($i = 0; $i < $count; $i++){ $tab .= "\t"; }
		return $tab;
	}

	/**
	*	書き込む行を追加
	*/
	private function addRow($str){
		$this->outputBuffer[] = $str;
	}

	private function addMessage($buffer, $count, $modeStr, $first){
		$tab = $this->getTab($count);

		if(is_array($buffer)){
			if($first){
				$first = false;
				$this->addRow($this->getTab($count).$modeStr."array[");
			}

			$tab = $this->getTab(++$count);
			foreach ($buffer as $key => $value) {
				$msg = "";

				if(is_array($value)){
					$this->addRow($tab.$key.":"."array[");
					$this->addMessage($value, $count, "", $first);
				}else{
					$this->addRow($tab.$key.":"."\"$value\"");
				}
			}

			$this->addRow($this->getTab(--$count).']');
		}else{
			$this->addRow($tab.$modeStr.$buffer);
		}
	}

	public function _log($mode, $msg){
		if($mode === self::GROUP_START){
			$this->groupFlag = true;
			$this->addRow($this->getTab($this->tabCount).self::GROUP_TAG.$msg.self::GROUP_TAG);
		}else if($mode === self::GROUP_END){
			$this->tabCount--;
			$this->addRow($this->getTab($this->tabCount).self::GROUP_TAG."end".self::GROUP_TAG);
		}else {
			if($mode !== self::LOG)
				$modeStr = sprintf("%-7s: ","\"$mode\"");
			else
			 	$modeStr = sprintf("%-7s: "," ");
			$this->addMessage($msg, $this->tabCount, $modeStr, true);
		}
		
		if($mode === self::GROUP_START){
			$this->tabCount++;
		}else if($mode === self::GROUP_END){
			if($this->tabCount == 0){
				$this->groupFlag = false;
			}
		}

		if(!$this->groupFlag){
			foreach ($this->outputBuffer as $buf) {
				print($buf."\n");
			}

			$this->outputBuffer = [];
		}
	}

	public function groupCollapsed($str){
		$this->_log(self::GROUP_START, $str);
	}

	public function groupEnd(){
		$this->_log(self::GROUP_END, "");
	}
}

?>