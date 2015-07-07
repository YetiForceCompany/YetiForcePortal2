<?php

class Base_Model_Module {

	protected $defaultView = 'List';

	public function getDefaultView() {
		return $this->defaultView;
	}

	public static function getInstance($module) {
		$handlerModule = Core_Loader::getModuleClassName($module, 'Models', 'Module');
		$instance = new $handlerModule();
		return $instance;
	}

}
