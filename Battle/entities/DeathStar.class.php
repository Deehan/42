<?php
//Planet sized battleship
class DeathStar extends Ship{ 
	function __construct(Application $app, array $var, $player){
		parent::__construct($app, $var, $player);
		$this->maneuver=3;
		$this->hpmax=49;
		$this->spmax=0;
		$this->hp=15;
		$this->sp=0;
		$this->size=array('width'=>7,'height'=>7);
		$this->image='../images/deathstar.png';
		$this->sprite='../images/deathstar.png';
		$this->speed=3;
		$this->power=7;
		for($i=1;$i<25;$i++)
			$this->weapons[]=new HeavyLaser($app);
		$this->weapons[]=new SuperLaser($app);
	}
}