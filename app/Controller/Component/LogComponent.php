<?php
App::uses('Folder','Utility');
App::uses('File','Utility');

class LogComponent extends Object{
	function initialize(&$controller, $settings = array()) {
	// saving the controller reference for later use
	$this->controller =& $controller;
	}
	//called after Controller::beforeFilter()
	function startup(&$controller) {
	}
	//called after Controller::beforeRender()
	function beforeRender(&$controller) {
	}
	//called after Controller::render()
	function shutdown(&$controller) {
	}
	//called before Controller::redirect()
	function beforeRedirect(&$controller, $url, $status=null, $exit=true) {
	}
	function redirectSomewhere($value) {
	// utilizing a controller method
	}

	function writeLog($fileLog,$log){
		$dir = new Folder(LOGROOT_DIR);
		$file = new File($dir->pwd() . DS . $fileLog);
		$contents = $file->read();
		$count = substr_count($contents, "\n")+1;
		$file->append('#'.(string)$count.': '.$log . "\n");
		$file->close();
	}

	function writeOder($fileLog,$log){
		$dir = new Folder('oder');
		
		$file = new File($dir->pwd() . DS . $fileLog);
		
		$file->append($log . "\n");

		$file->close();
	}
}

?>