<?php
//Fast and advanced battleship
class Valkyrie extends Ship{
	function __construct(Application $app, array $var){
		parent::__construct($app, $var);
		$this->maneuver=5;
		$this->shield=0;
		$this->hp=3;
		$this->size=array('width'=>1,'height'=>1);
		$this->image='../images/valkyrie.png';
		$this->weapons[]=new LightLaser();
	}
}
?>