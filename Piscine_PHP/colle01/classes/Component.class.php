<?php  
abstract class Component {
	protected $app;

	public function __construct(Application $app) {
		$this->app = $app;
	}

	public function app() {
		return $this->app;
	}

	public abstract function doc();
}