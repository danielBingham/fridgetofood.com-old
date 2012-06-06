<?php
class Application_Service_Javascript_Replacer {
	private $_filepath;
	private $_contents;
	
	public function __construct($file) {
		$this->_filepath = '/srv/www/fridgetofood.test/js/' . $file;
		if(!file_exists($this->_filepath)) {
			throw new Exception('File ' . $this->_filepath . ' does not exist in Javascript_Replacer.');
		}
		$this->_contents = file_get_contents($this->_filepath);
	}
	
	/**
	 * Replace $token with $value.
	 */ 
	public function replace($token, $value) {
		str_replace($token, $value, $this->_contents);	
	}
	
	public function close() {
		$fileHandle = fopen($this->_filepath, 'w');
		if(empty($fileHandle)) {
			throw new Exception('File to open the file ' . $this->_filepath . ' in Javascript_Replacer.');
		}
		
		fprintf($fileHandle, $this->_contents);
		fclose($fileHandle);
	}
	
	
}

?>