<?php
//Fast and advanced battleship
class BattleCruiser extends Ship{
	function __construct(Application $app, array $var, $player){
		parent::__construct($app, $var, $player);
		$this->maneuver=2;
		$this->hpmax=20;
		$this->spmax=10;
		$this->hp=20;
		$this->sp=10;
		$this->size=array('width'=>5,'height'=>3);
		$this->image='../images/battlecruiser.png';
		$this->weapons[]=new LightLaser($app);
		$this->weapons[]=new Plasma($app);
		$this->power=7;
		$this->speed=10;
		$this->sprite='../images/battlecruiser.png';
	}
}
?>