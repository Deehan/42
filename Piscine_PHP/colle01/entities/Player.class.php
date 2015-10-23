<?php
class Player extends Basic_ent
{
	private $_color;
	private $_name;
	private $_ships=array();

	public function __construct(Application $app, $name, $color=null)
	{
		parent::__construct($app);
		$this->_name = $name;
		$this->_ships = array();
		$this->_color = empty($color) ? '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT) : $color;
	}

	public function __get($name)
	{
		switch($name)
		{
			case 'color':
			case 'name':
				$name = '_'.$name;
				return $this->$name;
			break;
			default:
				return NULL;
		}
	}

	public function initiate($name){
		if (count($this->_ships) < 5)
		{
			if (rand(1,2) == 1)
				$this->_ships[]=new BattleCruiser($this->app, array('name'=>$name), 1);
			else
				$this->_ships[]=new DeathStar($this->app, array('name'=>$name), 1);
		}
	}

	public function getships(){
		return $this->_ships;
	}

	public function __set($name, $value)
	{
		switch($name)
		{
			case 'color':
			case 'name':
				$name = '_'.$name;
				$this->$name = $value;
			break;
			default:
		}
	}
}