<?php
class Application {

	protected $_game;
				
	public function run() {
		$getController 	= (!empty($_GET['controller'])) ? trim($_GET['controller']) : 'board';
		$getAction 		= (!empty($_GET['action'])) ? trim($_GET['action']) : 'run';			
		$getController 	= ucfirst($getController);

		if ( !empty($getController) AND is_file(_CTRL_DIR_.$getController.'.class.php') ) {
			include_once(_CTRL_DIR_.$getController.'.class.php');

			$board = new Board($this);
			$board->initgame();
			if(class_exists($getController)) {
				$controller = new $getController($this);
				$controller->$getAction();
			}
		}
	}

	public function setGame(Game &$game)
	{
		$this->_game = $game;
	}

	public function game()
	{
		return $this->_game;
	}
}