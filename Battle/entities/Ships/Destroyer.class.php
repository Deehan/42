<?php
//Fast and advanced battleship
class Destroyer extends Ship{
	function __construct(Application $app, array $var){
		parent::__construct($app, $var);
		$this->maneuver=0;
		$this->shield=0;
		$this->hp=20;
		$this->size=array('width'=>3,'height'=>2);
		$this->image='../images/destroyer.png';
		$this->speed=10;
		for ($i=1; $i<25; $i++)
			$this->weapons[]=new HeavyLaser();
		$this->weapons[]=new Gauss();
	}
}
?>